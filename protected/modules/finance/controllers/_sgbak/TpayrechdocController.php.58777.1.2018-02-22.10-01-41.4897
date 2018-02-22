<?php

class TpayrechdocController extends AAdminController
{

	public $layout='//layouts/admin_column3';

	public function actionIndex()
	{
		$model 		= new Rptvoucherdoc('VOUCHER_DOCUMENT',array('R_VOUCHER','R_CHEQ'),'Voucher_Document.rptdesign');
		$modelVoucherList = array();
		
		$model->voucher_type = array();	
		
		$retrieved = false;
		$url 		= NULL;	
		
		if(isset($_POST['Rptvoucherdoc']))
		{
			$model->attributes = $_POST['Rptvoucherdoc'];
						
			if($_POST['submit'] == 'list')
			{
				// Retrieve list of printable vouchers	
				if($model->validate())
				{
					$retrieved = true;
					
					$begin_dt = $model->date_from==''?'01/01/1990':$model->date_from;
					$end_dt = $model->date_to==''?date('d/m/Y'):$model->date_to;
					$voucher_type = count($model->voucher_type)==2?'%':$model->voucher_type[0];
					$begin_folder = $model->file_no_from==''?'%':$model->file_no_from;
					$end_folder = $model->file_no_to==''?'_':$model->file_no_to;
					$begin_docnum = $model->journal_number_from==''?'%':$model->journal_number_from;
					$end_docnum = $model->journal_number_to==''?'_':$model->journal_number_to;
					
					if($model->client_criteria == 'A')
					{
						$begin_client = '%';
						$end_client = '_';
					}
					else if($model->client_criteria == 'N')
					{
						$begin_client = $end_client = '';
					}
					else
					{
						$begin_client = $model->client_from==''?'%':$model->client_from;
						$end_client = $model->client_to==''?'_':$model->client_to;		
					}
					
					if($model->voucher_status != 'E')
					{
						$modelVoucherList = Tpayrech::model()->findAllBySql(Rptvoucherdoc::getListofVoucherSql($begin_dt, $end_dt, $voucher_type, $begin_folder, $end_folder, $begin_docnum, $end_docnum, $begin_client, $end_client, $model->voucher_status));			
					}
					else 
					{
						$modelVoucherList = Tpayrech::model()->findAllBySql(Rptvoucherdoc::getTmanyListofVoucherSql($begin_dt, $end_dt, $voucher_type, $begin_folder, $end_folder, $begin_docnum, $end_docnum, $begin_client, $end_client));			
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
					$x = 0;
					
					if(isset($_POST['Tpayrech']))
					{
						foreach($_POST['Tpayrech'] as $row)
						{
							$modelVoucherList[$x] = new Tpayrech('report');
							$modelVoucherList[$x]->attributes = $row;
							
							if($row['print'] == 'Y')
							{
								$doc_num[] = $row['payrec_num'];
							}
							
							$x++;
						}
						
						if(count($doc_num))
						{
							if($model->executeReportGenSp($doc_num,$model->voucher_status) > 0)
							{
								$url = $model->showReport();
								$url .= "&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100";
								//$model->showReport();
							}
						}
					}
				}
			}		
		}
		else 
		{
			$model->date_from = $model->date_to = date('d/m/Y');
			$model->voucher_status = 'A';
			$model->client_criteria = 'A';
			$model->voucher_type[0] = 'R';
			$model->voucher_type[1] = 'P';
		}

		$this->render('index',array(
			'model'=>$model,
			'modelVoucherList'=>$modelVoucherList,
			'url'=>$url,
			'retrieved'=>$retrieved,
		));
	}
}
