<?php

ini_set('memory_limit', '256M');
class RptppnkeluaranstandardController extends AAdminController
{

	public $layout = '//layouts/admin_column3';
	public function actionIndex()
	{
		$model = new Rptppnkeluaranstandard('PPN_KELUARAN_STANDARD', 'R_PPN_KELUARAN', 'PPN_Keluaran_Standard.rptdesign');
		$modelDetail = array();
		$model->year = date('Y');
		$model->bgn_date = date('01/m/Y');
		$model->end_date = date('t/m/Y');
		$model->report_mode = 1;
		$model->month = date('m');
		$model->no_seri = 0;
		$client_cd_arr = array(); //RD 9DES2016
		$valid = true;
		$success = false;
		$seri = array();
		$seri_flg = array();
		$url = '';
		$url_xls = '';
		$no_seri_flg = Sysparam::model()->find("param_id='PPN KELUARAN STANDARD' and param_cd1='NO_SERI' ")->dflg1;
		// var_dump($no_seri_flg);
		// die();
		if (isset($_POST['Rptppnkeluaranstandard']) && isset($_POST['scenario']))
		{
			$model->attributes = $_POST['Rptppnkeluaranstandard'];
			$scenario = $_POST['scenario'];
			$rowCount = $_POST['rowCount'];
			$mode = $model->report_mode == '0' ? 'DETAIL' : 'SUMMARY';
			
			if ($scenario == 'print' && $mode == 'SUMMARY' && $rowCount > 0 )
			{
				//$rowCount = $_POST['rowCount'];
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction(); 
				
				for($x=0;$x<$rowCount;$x++)
				{
					$modelDetail[$x] = new Rppnkeluaran;
					$modelDetail[$x]->attributes = $_POST['Rppnkeluaran'][$x+1];
					$print_flg = $modelDetail[$x]->save_flg;
					$client_cd_arr[] = $modelDetail[$x]->client_cd; //RD 9DES2016
					$seri[] = $modelDetail[$x]->no_series; //RD 9DES2016 
					$seri_flg[]=$modelDetail[$x]->save_flg;
				}
				
				if($model->executeRpt($client_cd_arr,$mode,'Y',$seri,$seri_flg)>0)
				{
					$success=true;
				}
				
				else 
				{
					$success=false;
				}
				
				if($success)
				{
					$transaction->commit();
				}
				
				else
				{
					$transaction->rollback();
				}
			}
			
			if ($scenario == 'print')
			{
				//$rand = $model->rand_val;
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				
				if ($model->validate() && $model->executeRpt($client_cd_arr, $mode,'Y',$seri,$seri_flg) > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
					$transaction->commit();
				}
				
				else
				{
					$transaction->rollback();
				}
			}
			
			else if($scenario =='retrieve' && $mode =='SUMMARY')//retrieve data for MU
			{
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction(); 
				$model->scenario='retrieve';
				if ($model->validate() && $model->executeRpt($client_cd_arr, $mode,'N',$seri,$seri_flg) > 0)
				{
					$sql="select t.* from R_PPN_KELUARAN t where rand_value='$model->vo_random_value' and user_id='$model->vp_userid' and client_cd<>'TXT' ORDER BY CLIENT_TYPE_1, CLIENT_CD, tanggal";
					$modelDetail = Rppnkeluaran::model()->findAllBySql($sql);
					//$model->rand_val = $model->vo_random_value;
					//$modelDetail = Rppnkeluaran::model()->findAll("rand_value='$model->vo_random_value' and user_id='$model->vp_userid' and client_cd<>'TXT' ");
					foreach($modelDetail as $row){
						$row->no_series = 0;
					}
					$transaction->commit();
				}else{
					$transaction->rollback();
				} 	
			}
		}

		if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
			$model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->end_date))
			$model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'url_xls' => $url_xls,
			'url' => $url,
			'no_seri_flg' => $no_seri_flg,
			'rand_value' => $model->vo_random_value,
			'user_id' => $model->vp_userid,
			'modelDetail'=>$modelDetail
		));
	}

	public function actionGetXls($rand_value, $user_id)
	{

		$excelFileName = Yii::app()->basePath . '/../upload/rpt_xls/PPN_Keluaran.xls';
		$objPHPExcel = XPHPExcel::createPHPExcel();

		$objPHPExcel->getProperties()->setCreator("SSS")->setLastModifiedBy("SSS")->setTitle("Tax Invoice")->setSubject("Office 2007 XLSX Test Document")
		//->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
		->setKeywords("office 2007 openxml php")->setCategory("Accounting");

		$objPHPExcel->setActiveSheetIndex(0);

		$sql = "select count(1)cnt from insistpro_rpt.R_PPN_KELUARAN
			 where rand_value='$rand_value' AND user_id ='$user_id' and client_cd <> 'TXT' ";
		$exec = DAO::queryRowSql($sql);
		if (count($exec['cnt']) > 0)
		{
			$objPHPExcel->getActiveSheet()->setCellValue("A1", 'client cd')->setCellValue("B1", 'client name')->setCellValue("C1", 'npwp no')->setCellValue("D1", 'alamat')->setCellValue("E1", 'dpp')->setCellValue("F1", 'ppn')->setCellValue("G1", 'tanggal')->setCellValue("H1", 'amount');
			//retrieve data
			$sql = "select client_cd,client_name,npwp_no,alamat,dpp,ppn,tanggal,amount from insistpro_rpt.R_PPN_KELUARAN
					 where rand_value='$rand_value' AND user_id ='$user_id' and client_cd <> 'TXT'
					 order by client_cd ";
			$data = DAO::queryAllSql($sql);
			$x = 2;
			foreach ($data as $row)
			{
				$objPHPExcel->getActiveSheet()->setCellValue("A$x", $row['client_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("B$x", $row['client_name']);
				$objPHPExcel->getActiveSheet()->setCellValue("C$x", $row['npwp_no']);
				$objPHPExcel->getActiveSheet()->setCellValue("D$x", $row['alamat']);
				$objPHPExcel->getActiveSheet()->setCellValue("E$x", $row['dpp']);
				$objPHPExcel->getActiveSheet()->setCellValue("F$x", $row['ppn']);
				$objPHPExcel->getActiveSheet()->setCellValue("G$x", $row['tanggal']);
				$objPHPExcel->getActiveSheet()->setCellValue("H$x", $row['amount']);
				$x++;
			}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save($excelFileName);

			if (file_exists($excelFileName))
			{
				header('Content-Description: File Transfer');
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment; filename="' . 'PPN Keluaran Standard' . '.xls"');
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
