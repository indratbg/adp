<?php

class RptsecutrialbalancedetailController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	public function actionAjxGetGl_acct()
	{
		$resp['status']='error';
		$sl_code=array();
		$sl_desc=array();
		$sl=array();
		if(isset($_POST['tanggal']))
		{
			$tanggal = $_POST['tanggal'];
			//var_dump($tanggal);die();
			$sql="SELECT trim(MST_SECURITIES_LEDGER.SL_CODE) SL_CODE,			
			         MST_SECURITIES_LEDGER.SL_DESC,			
						trim(MST_SECURITIES_LEDGER.GL_ACCT_CD) GL_ACCT_CD
			    FROM MST_SECURITIES_LEDGER			
			WHERE to_date('$tanggal','dd/mm/yyyy') BETWEEN ver_bgn_dt AND ver_end_dt  
			ORDER BY MST_SECURITIES_LEDGER.SL_CODE ASC";
			$model = SecuritiesLedger::model()->findAllBySql($sql);
	
			$x=0;
			foreach($model as $row)
			{
				$sl[$x]['sl_code'] =$row->gl_acct_cd;
				$sl[$x]['sl_desc'] =$row->sl_code.'  '.$row->sl_desc;
				$x++;
			}
		
		$resp['status']='success';	
		}
		$resp['content']=$sl;
		
		echo json_encode($resp);
	}
	
	
	public function actionIndex()
	{
		$model = new Rptsecutrialbalancedetail('SECU_TRIAL_BALANCE_DETAIL','R_SECU_TRIAL_BALANCE_DETAIL','Securities_Trial_Balance_Detail.rptdesign');
		$model->end_date=date('d/m/Y');
		//$model->end_date=date('30/06/2016');
		$model->month=date('m');
		$model->year = date('Y');
		$url ='';
		$url_xls='';
		$model->sort_by='1';
		
		if(isset($_POST['Rptsecutrialbalancedetail']))
		{
			$model->attributes = $_POST['Rptsecutrialbalancedetail'];
			
			if($model->gl_option=='0')
			{
				$bgn_acct = '%';
				$end_acct = '_';	
			}
			else 
			{
				$bgn_acct = trim($model->gl_acct);
				$end_acct = trim($model->gl_acct);	
			}
			if($model->client_option=='0')
			{
				$bgn_client='%';
				$end_client='_';
			}
			else 
			{
				$bgn_client=$model->client_cd;
				$end_client=$model->client_cd;	
			}
			if($model->stk_option=='0')
			{
				$bgn_stk = '%';
				$end_stk = '_';
			}
			else if($model->stk_option=='1')
			{
				$bgn_stk = $model->stk_cd;
				$end_stk = $model->stk_cd;
			}	
			else
			{
				$bgn_stk = 'R';
				$end_stk ='R';
			}
			//SORT
			if($model->sort_by=='0')
			{
				$sort_by = 'CLIENT';
			}
			else 
			{
				$sort_by = 'STOCK';
			}
						
			if($model->validate() && $model->executeRpt($bgn_acct, $end_acct, $bgn_client, $end_client, $bgn_stk, $end_stk, $sort_by)>0)
			{
				$rpt_link= $model->showReport();
				$url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url_xls = $rpt_link.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
			}
		}

		
		if(DateTime::createFromFormat('Y-m-d',$model->end_date))$model->end_date = DateTime::createFromFormat('Y-m-d',$model->end_date)->format('d/m/Y');
		$this->render('index',array('model'=>$model,
									'url'=>$url,
									'rand_value'=>$model->vo_random_value,
									'user_id'=>$model->vp_userid,
									'url_xls'=>$url_xls));
	}

	public function actionGetXls($rand_value, $user_id)
	{	
			
		
    $excelFileName = Yii::app()->basePath.'/../upload/rpt_xls/Securities_Trial_Balance_Detail.xls';
	$objPHPExcel= XPHPExcel::createPHPExcel();	
	
	  $objPHPExcel->getProperties()->setCreator("SSS")
								 ->setLastModifiedBy("SSS")
								 ->setTitle("SECURITIES TRIAL BALANCE DETAIL")
								 ->setSubject("Office 2007 XLSX Test Document")
								// ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Accounting");
	
	$objPHPExcel->setActiveSheetIndex(0);
	
 	$objPHPExcel->getActiveSheet()->setCellValue("A1", 'DOC DATE')
			->setCellValue("B1", 'GL ACCT')
			->setCellValue("C1", 'CLIENT CD')
			->setCellValue("D1", 'CLIENT NAME')
			->setCellValue("E1", 'SUBREK001')
			->setCellValue("F1", 'OLD CD')
			->setCellValue("G1", 'STK CD')
			->setCellValue("H1", 'QTY')
			->setCellValue("I1", 'DEBIT')
			->setCellValue("J1", 'CREDIT')
			->setCellValue("K1", 'END QTY')
			->setCellValue("L1", 'PRICE')
			->setCellValue("M1", 'RASIO S')
			->setCellValue("N1", 'AMT')
			->setCellValue("O1", 'SL DESC')
			->setCellValue("P1", 'SL CODE')
			;
	//retrieve data
	$sql = "SELECT DOC_DATE,
				GL_ACCT_CD,
				CLIENT_CD,
				CLIENT_NAME,
				SUBREK001,
				OLD_CD,
				STK_CD,
				QTY,
				DEBIT,
				CREDIT,
				END_QTY,
				PRICE,
				RASIO_S,
				AMT,
				SL_DESC,
				SL_CODE 
				FROM insistpro_rpt.R_SECU_TRIAL_BALANCE_DETAIL
			where rand_value='$rand_value' and user_id='$user_id'
			ORDER BY GL_ACCT_CD,STK_CD,CLIENT_CD";		
	$data = DAO::queryAllSql($sql);
	$x=2;
	foreach($data as $row)
	{
		$objPHPExcel->getActiveSheet()->setCellValue("A$x",$row['doc_date']);
		$objPHPExcel->getActiveSheet()->setCellValue("B$x",$row['gl_acct_cd']);
		$objPHPExcel->getActiveSheet()->setCellValue("C$x",$row['client_cd']);
		$objPHPExcel->getActiveSheet()->setCellValue("D$x",$row['client_name']);
		$objPHPExcel->getActiveSheet()->setCellValue("E$x",$row['subrek001']);
		$objPHPExcel->getActiveSheet()->setCellValue("F$x",$row['old_cd']);
		$objPHPExcel->getActiveSheet()->setCellValue("G$x",$row['stk_cd']);
		$objPHPExcel->getActiveSheet()->setCellValue("H$x",$row['qty']);
		$objPHPExcel->getActiveSheet()->setCellValue("I$x",$row['debit']);
		$objPHPExcel->getActiveSheet()->setCellValue("J$x",$row['credit']);
		$objPHPExcel->getActiveSheet()->setCellValue("K$x",$row['end_qty']);
		$objPHPExcel->getActiveSheet()->setCellValue("L$x",$row['price']);
		$objPHPExcel->getActiveSheet()->setCellValue("M$x",$row['rasio_s']);
		$objPHPExcel->getActiveSheet()->setCellValue("N$x",$row['amt']);
		$objPHPExcel->getActiveSheet()->setCellValue("O$x",$row['sl_desc']);
		$objPHPExcel->getActiveSheet()->setCellValue("P$x",$row['sl_code']);
		$x++;
	}
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save($excelFileName);
	
	if(file_exists($excelFileName))
	{
		header('Content-Description: File Transfer');
	    header('Content-Type: application/vnd.ms-excel');
	    header('Content-Disposition: attachment; filename="'.'Securities Trial Balance Detail'.'.xls"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($excelFileName));
		ob_clean();
		flush();
	    readfile($excelFileName);
		unlink($excelFileName);
	} 		
			
		
	}
}
