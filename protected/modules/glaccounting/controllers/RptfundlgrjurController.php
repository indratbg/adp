<?php
class RptfundlgrjurController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
		$model= new Rptfundlgrjur('LIST_OF_FUND_LGR_JUR','R_FUND_LEDGER','Fund_ledger_jur.rptdesign');
		
		//$model->trans_date =date('d/m/Y');
		$url 	= "";
		$option=array('PE','CLIENT','UMUM','ALL','CLIENT_CD');
		
		if(isset($_POST['Rptfundlgrjur'])){
			
			
			$model->attributes=$_POST['Rptfundlgrjur'];
			
			$model->val_jur_num=(trim($model->jur_num)!="")?strtoupper(trim($model->jur_num)):"%";
			$model->val_folder_cd=(trim($model->folder_cd)!="")?strtoupper(trim($model->folder_cd)):"%";
		
			
			$model->val_client_cd=($model->selected_opt!=4)?$option[$model->selected_opt]:$model->client_cd;
		
			if($model->validate() && $model->executeReportGenSp()>0  ){
				$url = $model->showReport().'&__showtitle=false&__format=pdf';
				
			}
	
		}else{
			$model->selected_opt=0;
			$model->month = date('n');
			$model->year = date('Y');
			$model->from_dt=date('01/m/Y');
			$model->to_dt=date('t/m/Y');
		}
		
		$this->render('index',array(
			'model'=>$model,
			'url'=>$url
		));
	}
	
	public function actionGetClient()
	{
		
		 $i=0;
	      $src=array();
	      $term = strtoupper($_REQUEST['term']);
	      $qSearch = DAO::queryAllSql("
					Select client_cd, client_name FROM MST_CLIENT 
					Where (client_cd like '".$term."%')
	      			AND susp_stat = 'N' AND client_type_1 <> 'B' AND custodian_cd IS NULL
	      			AND rownum <= 11
	      			ORDER BY client_cd
	      			");
	      
	      foreach($qSearch as $search)
	      {
	      	$src[$i++] = array('label'=>$search['client_cd'].' - '.$search['client_name']
	      			, 'labelhtml'=>$search['client_cd'].' - '.$search['client_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['client_cd']);
	      }
	      
	      echo CJSON::encode($src);
	      Yii::app()->end();
	}
}
?>