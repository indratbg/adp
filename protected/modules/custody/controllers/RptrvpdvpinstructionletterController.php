<?php

class RptrvpdvpinstructionletterController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
public function actionGetclient()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_REQUEST['term']);
      $qSearch = DAO::queryAllSql("
				Select client_cd, client_name FROM MST_CLIENT 
				Where (client_cd like '".$term."%')
      			AND rownum <= 11
      			ORDER BY client_cd
      			"); 
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['client_cd']. ' - '.$search['client_name']
      			, 'labelhtml'=>$search['client_cd']
      			, 'value'=>$search['client_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }
	
	
	public function actionIndex()
    {
    	$model = new Rptrvpdvpinstructionletter('RPV_DVP_INSTRUCTION_LETTER','R_RPV_DVP','RPV_DVP_Intruction_Letter.rptdesign');
		$modelDetail = array();
		$modelPrint = array();
		$model->trx_date = date('d/m/Y');
		$model->value_date = date('d/m/Y');
		$url='';
		$sql="select  '/YJ/'||trim(TO_CHAR(TRUNC(SYSDATE),'RM'))||TO_CHAR(TRUNC(SYSDATE),'/yyyy') as suffix from dual";
		$suffix = DAO::queryRowSql($sql);
		$model->suffix_no_surat = $suffix['suffix'];
		$contact = Sysparam::model()->find("PARAM_ID='RVP_DPV' AND PARAM_CD1='BROKER' AND PARAM_CD2='CONTACT'");
		$model->broker_phone_ext=$contact->dstr2;
		$model->contact_person = $contact->dstr1;
		$model->all_id='ALL';
		$valid = true;
		if(isset($_POST['Rptrvpdvpinstructionletter']))
		{
			$model->attributes = $_POST['Rptrvpdvpinstructionletter'];
			$scenario = $_POST['scenario'];
			
			if($scenario =='filter')
			{
				if($model->validate())
				{
					$trx_date = $model->trx_date;
					$value_date = $model->value_date;
					$trx_id = $model->all_id?'ALL':$model->specified_id;
					$modelDetail = Tbondtrx::model()->findAllBySql(Rptrvpdvpinstructionletter::getData($trx_date, $value_date, $trx_id));	
				}
			}
			else
			{
				$model->scenario = 'print';
				$rowCount = $_POST['rowCount'];
				$valid = $valid && $model->validate();
				$flg='N';
				for($x=0;$x<$rowCount;$x++)
				{
					$modelDetail[$x] = new Tbondtrx;
					$modelDetail[$x]->attributes = $_POST['Tbondtrx'][$x+1];
					if($modelDetail[$x]->save_flg =='Y')
					{
						if($modelDetail[$x]->nomor_surat=='')
						{
							$valid=false;	
							$modelDetail[$x]->addError('nomor_surat','Nomor surat tidak boleh kosong');
						}
						$flg='Y';
						$valid = $valid;
					}
				}
				
				if($flg=='Y' && $valid==TRUE)
				{
					
					$trx_seq_no=array();
					$no_surat =array();
					for($x=0;$x<$rowCount;$x++)
					{
						if($modelDetail[$x]->save_flg =='Y')
						{	
							$trx_seq_no[]=$modelDetail[$x]->trx_seq_no;
							$no_surat[] = $modelDetail[$x]->nomor_surat;
						}
					}
					
					//execute sp report
					$suffix_surat=$model->suffix_no_surat;
					if($model->executeRpt($trx_seq_no, $suffix_surat, $no_surat))
					{
						$url = $model->showReport().'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					}
				
				}
			}
			
			
		}
		
		foreach($modelDetail as $row)
		{
			$row->trx_type = $row->trx_type=='B'?'Buy':'Sell';
			if(DateTime::createFromFormat('Y-m-d',$row->trx_date)) $row->trx_date = DateTime::createFromFormat('Y-m-d',$row->trx_date)->format('d/m/y');
			if(DateTime::createFromFormat('Y-m-d',$row->value_dt)) $row->value_dt = DateTime::createFromFormat('Y-m-d',$row->value_dt)->format('d/m/y');	
		}
		
		if(DateTime::createFromFormat('Y-m-d',$model->trx_date)) $model->trx_date = DateTime::createFromFormat('Y-m-d',$model->trx_date)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$model->value_date)) $model->value_date = DateTime::createFromFormat('Y-m-d',$model->value_date)->format('d/m/Y');
	
		
		$this->render('index',array('model'=>$model,
									'modelDetail'=>$modelDetail,
									'modelPrint'=>$modelPrint,
									'url'=>$url,
									));
	}
}
?>