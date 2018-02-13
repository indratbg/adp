<?php
class RpttrialbalanceController extends AAdminController
{

	public $layout = '//layouts/admin_column3';
	/*
		public function actionGetsla()
		{
			$i=0;
			  $src=array();
			  $term = strtoupper($_REQUEST['term']);
			  $glAcctCd = $_REQUEST['gl_acct_cd'];
							  $qSearch = DAO::queryAllSql("
						SELECT DISTINCT sl_a, acct_name FROM MST_GL_ACCOUNT 
						WHERE TRIM(gl_a) like '$glAcctCd' 
						AND sl_a LIKE '".$term."%'
						AND prt_type <> 'S'
						AND acct_stat = 'A'
						AND approved_stat = 'A'
						  AND rownum <= 200
						  ORDER BY sl_a
					  ");
						foreach($qSearch as $search)
			{
				  $src[$i++] = array('label'=>$search['sl_a'].' - '.$search['acct_name']
						  , 'labelhtml'=>$search['sl_a'].' - '.$search['acct_name'] //WT: Display di auto completenya
						  , 'value'=>$search['sl_a']);
			}
						  echo CJSON::encode($src);
			  Yii::app()->end();
		}*/
	
	public function actionIndex()
	{
		$model = new Rpttrialbalance('TRIAL_BALANCE','R_TRIAL_BALANCE','Trial_Balance.rptdesign');
		$gl_a = Glaccount::model()->findAll(array('select'=>"trim(gl_a) gl_a,gl_a||' - '||acct_name acct_name",'condition'=>"approved_stat='A' 
				 and sl_a='000000' AND acct_stat = 'A'",'order'=>'gl_a')); 		
		$model->year = date('Y');
		$model->bgn_date = date('01/m/Y');
		$model->end_date = date('t/m/Y');
		$model->report_mode=0;
		$model->cancel_flg='1';
		$model->branch_option=0;
		$model->month = date('m');
		$url='';
		$url_xls='';
		if(isset($_POST['Rpttrialbalance']))
		{
			$model->attributes = $_POST['Rpttrialbalance'];
			
			if($model->from_gla=='')
			{
				$bgn_acct = '%';
				$end_acct='_';
			}
			else
			{
				$bgn_acct = $model->from_gla;
				$end_acct=$model->to_gla;
			}	
			if($model->from_sla=='')
			{
				$bgn_sub = '%';
				$end_sub = '_';	
			}
			else
			{
				$bgn_sub = $model->from_sla;
				$end_sub = $model->to_sla;
			}	
			
			$branch_cd = $model->branch_option=='0'?'%':$model->branch_cd;
			
			$rpt_mode =$model->report_mode==0?'DETAIL':'SUMMARY'; 
			
			if($model->validate() && $model->executeRpt($bgn_acct, $end_acct, $bgn_sub, $end_sub, $branch_cd, $rpt_mode)>0)
			{
				$rpt_link =$model->showReport(); 
				$url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url_xls = $rpt_link.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				//$this->getXls($model->vo_random_value, $model->vp_userid);
			}
			
			
		}
		if(DateTime::createFromFormat('Y-m-d',$model->bgn_date))$model->bgn_date =DateTime::createFromFormat('Y-m-d',$model->bgn_date)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$model->end_date))$model->end_date =DateTime::createFromFormat('Y-m-d',$model->end_date)->format('d/m/Y'); 
		
		$this->render('index',array('model'=>$model,
									'gl_a'=>$gl_a,
									'rand_value'=>$model->vo_random_value,
									'user_id'=>$model->vp_userid,
									'url'=>$url,
									'url_xls'=>$url_xls));
	}

	public function actionGetXls($rand_value, $user_id)
	{	
			
		
    $excelFileName = Yii::app()->basePath.'/../upload/rpt_xls/Trial_Balance.xls';
	$objPHPExcel= XPHPExcel::createPHPExcel();	
	
	  $objPHPExcel->getProperties()->setCreator("SSS")
								 ->setLastModifiedBy("SSS")
								 ->setTitle("TRIAL BALANCE")
								 ->setSubject("Office 2007 XLSX Test Document")
								// ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Accounting");
	
	$objPHPExcel->setActiveSheetIndex(0);
	
 	$objPHPExcel->getActiveSheet()->setCellValue("A1", 'GL ACCT')
			->setCellValue("B1", 'SL ACCT')
			->setCellValue("C1", 'MAIN ACCT NAME')
			->setCellValue("D1", 'ACCT NAME')
			->setCellValue("E1", 'BEGINNING BALANCE')
			->setCellValue("F1", 'DEBIT')
			->setCellValue("G1", 'CREDIT')
			->setCellValue("H1", 'END BALANCE')
			;
	//retrieve data
	$sql = "SELECT GL_ACCT,sl_acct,main_acct_name,acct_name,BEG_BAL,DEBIT,CREDIT,end_bal FROM insistpro_rpt.r_trial_balance
			where rand_value='$rand_value' and user_id='$user_id' and trim(gl_acct) <>'TXT'
			ORDER BY GL_ACCT,SL_ACCT";		
	$data = DAO::queryAllSql($sql);
	$x=2;
	foreach($data as $row)
	{
		$objPHPExcel->getActiveSheet()->setCellValue("A$x",$row['gl_acct']);
		$objPHPExcel->getActiveSheet()->setCellValue("B$x",$row['sl_acct']);
		$objPHPExcel->getActiveSheet()->setCellValue("C$x",$row['main_acct_name']);
		$objPHPExcel->getActiveSheet()->setCellValue("D$x",$row['acct_name']);
		$objPHPExcel->getActiveSheet()->setCellValue("E$x",$row['beg_bal']);
		$objPHPExcel->getActiveSheet()->setCellValue("F$x",$row['debit']);
		$objPHPExcel->getActiveSheet()->setCellValue("G$x",$row['credit']);
		$objPHPExcel->getActiveSheet()->setCellValue("H$x",$row['end_bal']);
		$x++;
	}
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save($excelFileName);
	
	if(file_exists($excelFileName))
	{
		header('Content-Description: File Transfer');
	    header('Content-Type: application/vnd.ms-excel');
	    header('Content-Disposition: attachment; filename="'.'Trial Balance'.'.xls"');
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
