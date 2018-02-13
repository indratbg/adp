<?php

class RptstocktosettledetailController extends AAdminController
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
      			AND susp_stat = 'N'
      			AND rownum <= 11
      			ORDER BY client_cd
      			");

		foreach ($qSearch as $search)
		{
			$src[$i++] = array(
				'label' => $search['client_cd'],
				'labelhtml' => $search['client_cd'],
				'value' => $search['client_cd']
			);
		}

		echo CJSON::encode($src);
		Yii::app()->end();
	}

	public function actionGetDueDate()
	{
		$resp['status'] = 'error';

		if (isset($_POST['date']))
		{

			$tanggal = $_POST['date'];

			$sql = "select get_due_date(3,to_date('$tanggal','dd/mm/yyyy')) as due_date from dual";
			$data = DAO::queryRowSql($sql);
			$due_date = $data['due_date'];
			if (DateTime::createFromFormat('Y-m-d H:i:s', $due_date))
				$due_date = DateTime::createFromFormat('Y-m-d H:i:s', $due_date)->format('d/m/Y');
			$resp['due_date'] = $due_date;

			$resp['status'] = 'success';

		}
		echo json_encode($resp);
	}

	public function actionIndex()
	{
		$model = new Rptstocktosettledetail('STOCK_TO_SETTLE_DETAIL', 'R_STOCK_TO_SETTLE_DETAIL', 'Stock_to_settle_detail.rptdesign');
		$sql = "select  stk_cd, stk_cd||'-'||stk_desc stk_desc from mst_counter where approved_stat='A' order by stk_cd";
		$stk_cd = Counter::model()->findAllBySql($sql);
		$url = '';
		$url_xls = '';
		$sql = "select get_due_date(3,trunc(sysdate))due_date from dual";
		$exec = DAO::queryRowSql($sql);

		$model->contr_dt_from = date('d/m/Y');
		$model->contr_dt_to = date('d/m/Y');
		$model->due_dt_from = DateTime::createFromFormat('Y-m-d H:i:s', $exec['due_date'])->format('d/m/Y');
		$model->due_dt_to = $model->due_dt_from;
		$model->stk_option = '0';
		$model->client_option = '0';
		$model->stk_type = '0';

		if (isset($_POST['Rptstocktosettledetail']))
		{
			$model->attributes = $_POST['Rptstocktosettledetail'];
			if ($model->validate())
			{
				if ($model->stk_option == '0')
				{
					$bgn_stk = '%';
					$end_stk = '_';
				}
				else
				{
					$bgn_stk = $model->stk_cd_from;
					$end_stk = $model->stk_cd_to;
				}
				if ($model->client_option == '0')
				{
					$bgn_client = '%';
					$end_client = '_';
				}
				else
				{
					$bgn_client = $model->bgn_client;
					$end_client = $model->end_client;
				}
				if ($model->stk_type == '0')
				{
					$stk_type = 'ALL';
				}
				else
				{
					$stk_type = 'CUSTODY';
				}

				$market_type = $model->market_type ? $model->market_type : 'ALL';
				if ($model->executeRpt($bgn_stk, $end_stk, $bgn_client, $end_client, $market_type, $stk_type) > 0)
				{
					$rpt_link = $model->showReport();
					$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
				}

			}
		}

		if (DateTime::createFromFormat('Y-m-d', $model->contr_dt_from))
			$model->contr_dt_from = DateTime::createFromFormat('Y-m-d', $model->contr_dt_from)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->contr_dt_to))
			$model->contr_dt_to = DateTime::createFromFormat('Y-m-d', $model->contr_dt_to)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->due_dt_from))
			$model->due_dt_from = DateTime::createFromFormat('Y-m-d', $model->due_dt_from)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->due_dt_to))
			$model->due_dt_to = DateTime::createFromFormat('Y-m-d', $model->due_dt_to)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'url' => $url,
			'url_xls' => $url_xls,
			'stk_cd' => $stk_cd,
			'rand_value' => $model->vo_random_value,
			'user_id' => $model->vp_userid
		));
	}

	public function actionGetXls($rand_value, $user_id)
	{

		$excelFileName = Yii::app()->basePath . '/../upload/rpt_xls/Stock_to_settle_detail.xls';
		$objPHPExcel = XPHPExcel::createPHPExcel();

		$objPHPExcel->getProperties()->setCreator("SSS")->setLastModifiedBy("SSS")
		->setTitle("Stock to settle detail")->setSubject("Office 2007 XLSX Test Document")
		//->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
		->setKeywords("office 2007 openxml php")->setCategory("Custody");

		$objPHPExcel->setActiveSheetIndex(0);
		//CEK REPORT MODE
		$sql = "SELECT count(1)cnt
					FROM insistpro_rpt.r_stock_to_settle_detail
					where rand_value='$rand_value' and user_id='$user_id'";
		$exec = DAO::queryRowSql($sql);

		//if report mode by regular
		if ($exec['cnt'] > 0)
		{

			$objPHPExcel->getActiveSheet()->setCellValue("A1", 'Client Code')
			->setCellValue("B1", 'Client Name')->setCellValue("C1", 'Market')
			->setCellValue("D1", 'Broker')
			->setCellValue("E1", 'Quantity of Deliver')
			->setCellValue("F1", 'Quantity of Receipt')
			->setCellValue("G1", 'Total')
			->setCellValue("H1", 'Type');
			
			//retrieve data
			$sql = "SELECT client_cd,client_name, market_type,bs_broker_cd,sell,buy,discrepancy,decode(sign(discrepancy),-1,'R','D') typ
					FROM insistpro_rpt.r_stock_to_settle_detail
					where rand_value='$rand_value' and user_id='$user_id'
					ORDER BY stk_cd, client_cd";
			$data = DAO::queryAllSql($sql);
			$x = 2;
			foreach ($data as $row)
			{
				$objPHPExcel->getActiveSheet()->setCellValue("A$x", $row['client_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("B$x", $row['client_name']);
				$objPHPExcel->getActiveSheet()->setCellValue("C$x", $row['market_type']);
				$objPHPExcel->getActiveSheet()->setCellValue("D$x", $row['bs_broker_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("E$x", $row['sell']);
				$objPHPExcel->getActiveSheet()->setCellValue("F$x", $row['buy']);
				$objPHPExcel->getActiveSheet()->setCellValue("G$x", $row['discrepancy']);
				$objPHPExcel->getActiveSheet()->setCellValue("H$x", $row['typ']);
				$x++;
			}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save($excelFileName);
		}
	
		if (file_exists($excelFileName))
		{
			header('Content-Description: File Transfer');
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="' . 'Stock to Settle Detail' . '.xls"');
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