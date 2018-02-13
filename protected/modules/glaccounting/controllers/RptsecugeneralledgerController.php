<?php

class RptsecugeneralledgerController extends AAdminController
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
		$model = new Rptsecugeneralledger('SECU_GENERAL_LEDGER','R_SECU_GENERAL_LEDGER','Securities_General_Ledger.rptdesign');
		$model->end_date=date('d/m/Y');
		$model->month=date('m');
		$model->year = date('Y');
		$url ='';
		$url_xls='';
		$model->reversal_jur='0';
		
		if(isset($_POST['Rptsecugeneralledger']))
		{
			$model->attributes = $_POST['Rptsecugeneralledger'];
			
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
			if($model->reversal_jur=='0')
			{
				$reversal_jur ='Y';
			}
			else 
			{
				$reversal_jur = 'N';
			}
			
			if($model->validate() && $model->executeRpt($bgn_acct, $end_acct, $bgn_client, $end_client, $bgn_stk, $end_stk, $reversal_jur)>0)
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
		
    $excelFileName = Yii::app()->basePath.'/../upload/rpt_xls/General_Ledger.xls';
	$objPHPExcel= XPHPExcel::createPHPExcel();	
	
	  $objPHPExcel->getProperties()->setCreator("SSS")
								 ->setLastModifiedBy("SSS")
								 ->setTitle("GENERAL LEDGER")
								 ->setSubject("Office 2007 XLSX Test Document")
								// ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Accounting");
	
	$objPHPExcel->setActiveSheetIndex(0);
	//CEK REPORT MODE
	$sql ="select count(*) as cnt from R_SECU_GENERAL_LEDGER where rand_value='$rand_value' AND user_id ='$user_id'";
	$exec = DAO::queryRowSql($sql);
	if($exec['cnt']>0)
	{
			$objPHPExcel->getActiveSheet()->setCellValue("A1", 'CLIENT CODE')
					->setCellValue("B1", 'CLIENT NAME')
					->setCellValue("C1", 'STOCK CODE')
					->setCellValue("D1", 'REFERENCE')
					->setCellValue("E1", 'GL ACCT CD')
					->setCellValue("F1", 'SL DESC')
					->setCellValue("G1", 'SL CODE')
					->setCellValue("H1", 'AGREEMENT NO')
					->setCellValue("I1", 'DATE')
					->setCellValue("J1", 'DESCRIPTION')
					->setCellValue("K1", 'DEBIT')
					->setCellValue("L1", 'CREDIT')
					->setCellValue("M1", 'BALANCE')
					;
			//retrieve data
			$sql = "SELECT CLIENT_CD,client_name,STK_CD,REF_DOC_NUM,GL_ACCT_CD,SL_DESC,SL_CODE,AGREEMENT_NO,DOC_DT,DOC_REM,DEBIT,CREDIT,BALANCE FROM R_SECU_GENERAL_LEDGER
					WHERE RAND_VALUE='$rand_value' and user_id='$user_id'
					ORDER BY gl_acct_cd,client_cd,stk_cd,linetype,doc_dt,
					approved_dt,doc_num";		
			$data = DAO::queryAllSql($sql);
			$x=2;
			foreach($data as $row)
			{
				$objPHPExcel->getActiveSheet()->setCellValue("A$x",$row['client_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("B$x",$row['client_name']);
				$objPHPExcel->getActiveSheet()->setCellValue("C$x",$row['stk_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("D$x",$row['ref_doc_num']);
				$objPHPExcel->getActiveSheet()->setCellValue("E$x",$row['gl_acct_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("F$x",$row['sl_desc']);
				$objPHPExcel->getActiveSheet()->setCellValue("G$x",$row['sl_code']);
				$objPHPExcel->getActiveSheet()->setCellValue("H$x",$row['agreement_no']);
				$objPHPExcel->getActiveSheet()->setCellValue("I$x",$row['doc_dt']);
				$objPHPExcel->getActiveSheet()->setCellValue("J$x",$row['doc_rem']);
				$objPHPExcel->getActiveSheet()->setCellValue("K$x",$row['debit']);
				$objPHPExcel->getActiveSheet()->setCellValue("L$x",$row['credit']);
				$objPHPExcel->getActiveSheet()->setCellValue("M$x",$row['balance']);
				$x++;
			}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
						$objWriter->save($excelFileName);
		
		
		if(file_exists($excelFileName))
		{
			header('Content-Description: File Transfer');
		    header('Content-Type: application/vnd.ms-excel');
		    header('Content-Disposition: attachment; filename="'.'General Ledger'.'.xls"');
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
}
