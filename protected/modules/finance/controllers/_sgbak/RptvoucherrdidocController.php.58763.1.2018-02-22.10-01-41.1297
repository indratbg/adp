<?php

class RptvoucherrdidocController extends AAdminController
{

	public $layout='//layouts/admin_column3';
	
	public function actionGetClient()
	{
		$i = 0;
	    $src=array();
	    $term = strtoupper($_POST['term']);
		
	    $qSearch = DAO::queryAllSql("
					SELECT client_cd, client_name
					FROM MST_CLIENT
					WHERE (client_cd LIKE '".$term."%')
					AND susp_stat = 'N'
	      			AND rownum <= 15
	      			ORDER BY client_cd
	      			");
	      
	    foreach($qSearch as $search)
	    {
	    	$src[$i++] = array('label'=>$search['client_cd']. ' - ' .$search['client_name']
	      			, 'labelhtml'=>$search['client_cd']. ' - ' .$search['client_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['client_cd']);
	    }
	      
	    echo CJSON::encode($src);
	    Yii::app()->end();
	}
	
	public function actionGetBranch()
	{
		$i = 0;
	    $src=array();
	    $term = strtoupper($_POST['term']);
		
	    $qSearch = DAO::queryAllSql("
					SELECT brch_cd, brch_name 
					FROM MST_BRANCH
					WHERE (brch_cd like '".$term."%')
	      			AND rownum <= 15
	      			ORDER BY brch_cd
	      			");
	      
	    foreach($qSearch as $search)
	    {
	    	$src[$i++] = array('label'=>$search['brch_cd'].' - '.$search['brch_name']
	      			, 'labelhtml'=>$search['brch_cd'].' - '.$search['brch_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['brch_cd']);
	    }
	      
	    echo CJSON::encode($src);
	    Yii::app()->end();
	}

	public function actionIndex()
	{
		$model 		= new Rptvoucherrdidoc('RDI_VOUCHER_DOCUMENT','R_FUND_MOVEMENT','Voucher_RDI_Document.rptdesign');
		$modelVoucherList = array();
		
		$model->voucher_type = array();	
		
		$retrieved = false;
		$url 		= NULL;	
		
		if(isset($_POST['Rptvoucherrdidoc']))
		{
			$model->attributes = $_POST['Rptvoucherrdidoc'];
						
			if($_POST['submit'] == 'list')
			{
				// Retrieve list of printable vouchers	
				if($model->validate())
				{
					$retrieved = true;
					
					$begin_dt = $model->date_from==''?'01/01/1990':$model->date_from;
					$end_dt = $model->date_to==''?date('d/m/Y'):$model->date_to;
					$voucher_type = count($model->voucher_type)==2?'%':$model->voucher_type[0];
					$begin_branch = $model->branch_from==''?'%':$model->branch_from;
					$end_branch = $model->branch_to==''?'_':$model->branch_to;
					$begin_client = $model->client_from==''?'%':$model->client_from;
					$end_client = $model->client_to==''?'_':$model->client_to;
					
					if($model->voucher_status != 'E')
					{
						$modelVoucherList = Tfundmovement::model()->findAllBySql(Rptvoucherrdidoc::getListofVoucherSql($begin_dt, $end_dt, $voucher_type, $begin_branch, $end_branch, $begin_client, $end_client, $model->voucher_status));			
					}
					else 
					{
						$modelVoucherList = Tfundmovement::model()->findAllBySql(Rptvoucherrdidoc::getTmanyListofVoucherSql($begin_dt, $end_dt, $voucher_type, $begin_branch, $end_branch, $begin_client, $end_client));			
					}
				}
			}
			else 
			{
				$retrieved = true;
				// Generate / Print selected vouchers
				
				if($model->validate())
				{
					$doc_num = array();
					$update_date = array();
					$update_seq = array();
					$x = 0;
					
					if(isset($_POST['Tfundmovement']))
					{
						foreach($_POST['Tfundmovement'] as $row)
						{
							$modelVoucherList[$x] = new Tfundmovement('report');
							$modelVoucherList[$x]->attributes = $row;
							
							if($row['print'] == 'Y')
							{
								$doc_num[] = $row['doc_num'];
								$update_date[] = $row['update_date'];
								$update_seq[] = $row['update_seq'];
							}
							
							$x++;
						}
						
						if(count($doc_num))
						{
							if($model->executeReportGenSp($doc_num,$update_date,$update_seq,$model->voucher_status) > 0)
							{
								$url = $model->showReport();
								$url .= "&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100";
							}
						}
					}
				}
			}		
		}
		else 
		{
			$model->voucher_status = 'A';
			$model->voucher_type[0] = 'R';
			$model->voucher_type[1] = 'W';
			$model->date_from = $model->date_to = date('d/m/Y');
		}

		$this->render('index',array(
			'model'=>$model,
			'modelVoucherList'=>$modelVoucherList,
			'url'=>$url,
			'retrieved'=>$retrieved,
		));
	}
}
