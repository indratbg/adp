<?php

class RptoutstandingarapvsglController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionGetclient()
	{
		$i = 0;
		$src = array();
		$term = strtoupper($_REQUEST['term']);
		$qSearch = DAO::queryAllSql("
				Select client_cd, client_name FROM MST_CLIENT 
				Where (client_cd like '" . $term . "%')
      			AND rownum <= 11
      			ORDER BY client_cd
      			");

		foreach ($qSearch as $search)
		{
			$src[$i++] = array(
				'label' => $search['client_cd'] . ' - ' . $search['client_name'],
				'labelhtml' => $search['client_cd'],
				'value' => $search['client_cd']
			);
		}

		echo CJSON::encode($src);
		Yii::app()->end();
	}

	public function actionIndex()
	{
		$model = new Rptoutstandingarapvsgl('OUTSTANDING_ARAP_VS_GL', 'R_RECON_OUTSTANDING_ARAP', 'Outstanding_arap_vs_gl.rptdesign');
		$model->end_date = date('d/m/Y');
		$model->client_option = 0;
		$url = '';
		$model->report_type = 1;
		$model->option_outs = '0';
		$cek_bgn_dt = Sysparam::model()->find("param_id='RECON_OUTSTANDING' and param_cd1='BGN_DATE'")->ddate1;
		$url_xls = '';
		//set date outs_aft_date
		$sql = DAO::queryRowSql("SELECT DECODE(MAX_DT,NULL,trunc(SYSDATE,'mm'),TO_DATE('01'||TO_CHAR(ADD_MONTHS(MAX_DT,1),'MMYYYY'),'DDMMYYYY')) START_DATE FROM 
								(
								SELECT MAX(BEGIN_DATE)MAX_DT FROM T_BEGIN_ARAP_OUTSTAND
								) 
								");
		$start_date = $sql['start_date'];
		if(DateTime::createFromFormat('Y-m-d H:i:s',$start_date))$start_date =DateTime::createFromFormat('Y-m-d H:i:s',$start_date)->format('d/m/Y');
		$model->outs_aft_date = $start_date; 
		if (isset($_POST['Rptoutstandingarapvsgl']) && isset($_POST['scenario']))
		{
			$model->attributes = $_POST['Rptoutstandingarapvsgl'];
			$scenario = $_POST['scenario'];

			if ($model->validate())
			{
				//show report
				if ($scenario == 'show')
				{

					if ($model->client_option == '0')
					{
						$bgn_client = '%';
						$end_client = '_';
					}
					else
					{
						if (strlen($model->bgn_client_cd)=='1' && strlen($model->end_client_cd)=='1' )
						{
							$bgn_client = $model->bgn_client_cd . '%';
							$end_client = $model->end_client_cd . '_';
						}
						else
						{
							$bgn_client = $model->bgn_client_cd;
							$end_client = $model->end_client_cd;
						}
					}
					$model->bgn_date = $cek_bgn_dt;
					if (DateTime::createFromFormat('Y-m-d H:i:s', $model->bgn_date))
						$model->bgn_date = DateTime::createFromFormat('Y-m-d H:i:s', $model->bgn_date)->format('Y-m-d');
					$option = $model->report_type == '0' ? 'ALL' : 'DIFF';
					$option_bfr_date = $model->option_outs == '0' ? 'N' : 'Y';
					if ($model->validate() && $model->executeRpt($option, $bgn_client, $end_client, $option_bfr_date) > 0)
					{
						$rpt_link = $model->showReport();
						$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
						$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
					}
				}
				//proses outstanding
				else
				{
					if ($model->validate() && $model->executeProsesOuts() > 0)
					{
						Yii::app()->user->setFlash('success', 'Successfully Process Start Date of Outstanding');
					}
				}

			}
		}

		if (DateTime::createFromFormat('Y-m-d', $model->end_date))
			$model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'url' => $url,
			'rand_value' => $model->vo_random_value,
			'user_id' => $model->vp_userid,
			'url_xls' => $url_xls
		));
	}

	public function actionGetXls($rand_value, $user_id)
	{

		$excelFileName = Yii::app()->basePath . '/../upload/rpt_xls/Outstanding_arap_vs_gl.xls';
		$objPHPExcel = XPHPExcel::createPHPExcel();

		$objPHPExcel->getProperties()->setCreator("SSS")->setLastModifiedBy("SSS")->setTitle("OUTSTANDING AR/AP VS GL")->setSubject("Office 2007 XLSX Test Document")
		//->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
		->setKeywords("office 2007 openxml php")->setCategory("Accounting");

		$objPHPExcel->setActiveSheetIndex(0);
		//CEK REPORT MODE
		$sql = "select count(*) as cnt from INSISTPRO_RPT.R_RECON_OUTSTANDING_ARAP where rand_value='$rand_value' AND user_id ='$user_id'";
		$exec = DAO::queryRowSql($sql);

		if ($exec['cnt'] > 0)
		{

			$objPHPExcel->getActiveSheet()->setCellValue("A1", 'CLIENT CODE')->setCellValue("B1", 'OLD IC NUM')->setCellValue("C1", 'BRANCH')->setCellValue("D1", 'NAME')->setCellValue("E1", 'OUTSTANDING')->setCellValue("F1", 'GL AMOUNT')->setCellValue("G1", 'SELISIH');

			//retrieve data
			$sql = "select client_cd, client_name,branch_code,old_ic_num,gl_acct_cd, OUTS_AMT,tb_amt, selisih 
					from INSISTPRO_RPT.R_RECON_OUTSTANDING_ARAP
					WHERE rand_value='$rand_value'
					AND user_id     ='$user_id'
					ORDER BY client_cd ";
			$data = DAO::queryAllSql($sql);
			$x = 2;
			foreach ($data as $row)
			{
				$objPHPExcel->getActiveSheet()->setCellValue("A$x", $row['client_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("B$x", $row['old_ic_num']);
				$objPHPExcel->getActiveSheet()->setCellValue("C$x", $row['branch_code']);
				$objPHPExcel->getActiveSheet()->setCellValue("D$x", $row['client_name']);
				$objPHPExcel->getActiveSheet()->setCellValue("E$x", $row['outs_amt']);
				$objPHPExcel->getActiveSheet()->setCellValue("F$x", $row['tb_amt']);
				$objPHPExcel->getActiveSheet()->setCellValue("G$x", $row['selisih']);

				$x++;
			}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save($excelFileName);
		}

		if (file_exists($excelFileName))
		{
			header('Content-Description: File Transfer');
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="' . 'Outstanding AR/AP vs GL' . '.xls"');
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
?>