<?php

class RptbondtrxtaxController extends AAdminController
{

	public $layout = '//layouts/admin_column3';
	public function actionAjxGetTicketList()
	{
		$resp['status'] = 'error';

		$ticket_no = array();

		if (isset($_POST['bgn_date']) && isset($_POST['end_date']) && isset($_POST['date_flg']))
		{
			$bgn_date = $_POST['bgn_date'];
			$end_date = $_POST['end_date'];
			$date_flg = $_POST['date_flg'];

			$model = Tbondtrx::model()->findAll(array(
				'select' => 'DISTINCT trx_id_yymm,trx_date',
				'condition' => " ( (trx_date between TO_DATE('$bgn_date','DD/MM/YYYY') and TO_DATE('$end_date','DD/MM/YYYY') and '$date_flg'='TRX')
							or (value_dt between TO_DATE('$bgn_date','DD/MM/YYYY') and TO_DATE('$end_date','DD/MM/YYYY') and '$date_flg'='VAL') )
							 And approved_sts='A'",
				'order' => 'trx_date'
			));

			foreach ($model as $row)
			{
				$ticket_no[] = $row->trx_id_yymm;
			}
			$resp['status'] = 'success';
		}

		$resp['content'] = array('ticket_no' => $ticket_no);
		echo json_encode($resp);
	}

	public function actionIndex()
	{
		$model = new Rptbondtrxtax('BOND_TRX_TAX', 'R_BOND_TRX_TAX', 'Bond_trx_tax.rptdesign');
		$model->bgn_date = date('01/m/Y');
		$model->end_date = date('t/m/Y');
		$dropdown_ticket = Tbondtrx::model()->findAll(array(
			'select' => 'DISTINCT trx_id_yymm,trx_date',
			'condition' => "trx_date between TO_DATE('$model->bgn_date','DD/MM/YYYY') and  TO_DATE('$model->end_date','DD/MM/YYYY')
							 And approved_sts='A' ",
			'order' => 'trx_date'
		));
		$model->date_flg = '0';
		$model->year = date('Y');
		$model->month = date('m');
		$url = '';
		$url_xls = '';
		if (isset($_POST['Rptbondtrxtax']))
		{
			$model->attributes = $_POST['Rptbondtrxtax'];

			$trx_date_flg = $model->date_flg == '0' ? 'Y' : 'N';
			$value_dt_flg = $model->date_flg == '1' ? 'Y' : 'N';

			$bgn_trx_id = $model->fr_ticket_no ? $model->fr_ticket_no : '%';
			$end_trx_id = $model->to_ticket_no ? $model->to_ticket_no : '_';

			if ($model->validate() && $model->executeRpt($trx_date_flg, $value_dt_flg, $bgn_trx_id, $end_trx_id) > 0)
			{
				if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
					$model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
				if (DateTime::createFromFormat('Y-m-d', $model->end_date))
					$model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');
				$rpt_link = $model->showReport($model->bgn_date, $model->end_date);
				$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
			}
			$dropdown_ticket = Tbondtrx::model()->findAll(array(
				'select' => 'DISTINCT trx_id_yymm,trx_date',
				'condition' => "((trx_date between '$model->bgn_date' and '$model->end_date' and '$trx_date_flg'='Y') 
							or (value_dt between '$model->bgn_date' and '$model->end_date'	and '$value_dt_flg'='Y')) And approved_sts='A' ",
				'order' => 'trx_date'
			));

		}

		$this->render('index', array(
			'model' => $model,
			'dropdown_ticket' => $dropdown_ticket,
			'url' => $url,
			'rand_value' => $model->vo_random_value,
			'user_id' => $model->vp_userid,
		));
	}

	public function actionGetXls($rand_value, $user_id)
	{

		$excelFileName = Yii::app()->basePath . '/../upload/rpt_xls/Bond_Transaction_Tax_Report.xls';
		$objPHPExcel = XPHPExcel::createPHPExcel();

		$objPHPExcel->getProperties()->setCreator("SSS")->setLastModifiedBy("SSS")->setTitle("Bond Transaction")->setSubject("Office 2007 XLSX Test Document")
		//->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
		->setKeywords("office 2007 openxml php")->setCategory("Accounting");

		$objPHPExcel->setActiveSheetIndex(0);
		//CEK REPORT MODE
		$sql = "select count(*) as cnt from INSISTPRO_RPT.R_BOND_TRX_TAX where rand_value='$rand_value' AND user_id ='$user_id'";
		$exec = DAO::queryRowSql($sql);

		//if report mode by regular
		if ($exec['cnt'] > 0)
		{

			$objPHPExcel->getActiveSheet()->setCellValue("A1", 'TRX DATE')->setCellValue("B1", 'TRX ID')->setCellValue("C1", 'TRANSACTION TYPE')->setCellValue("D1", 'VALUE DATE')->setCellValue("E1", 'BOND CODE')->setCellValue("F1", 'LAWAN NAME')->setCellValue("G1", 'NOMINAL')->setCellValue("H1", 'PRICE')->setCellValue("I1", 'CAPITAL GAIN BEFORE TAX')->setCellValue("J1", 'GL 6150')->setCellValue("K1", 'PREPAID ART 4:2')->setCellValue("L1", 'CLIENTS PROFIT')->setCellValue("M1", 'Tax Payable 4:2 - from Profit BROKER')->setCellValue("N1", 'Tax Payable 4:2 - from Profit CLIENTS')->setCellValue("O1", 'COUNTER PARTY')->setCellValue("P1", 'NET AMOUNT');
			//retrieve data
			$sql = "select trx_date ,trx_id ,trans_type,value_dt,short_desc , lawan_name ,nominal,price, capital_gain, acct_6150, prepaid,
					clients, profit_broker, clients_tax_pay, broker_tax_pay, net_amount
					from insistpro_rpt.r_bond_trx_tax where rand_value='$rand_value' and user_id='$user_id'	
					order by  value_dt, trx_id_yymm, trx_date, trx_seq_no ";
			$data = DAO::queryAllSql($sql);
			$x = 2;
			foreach ($data as $row)
			{
				$objPHPExcel->getActiveSheet()->setCellValue("A$x", $row['trx_date']);
				$objPHPExcel->getActiveSheet()->setCellValue("B$x", $row['trx_id']);
				$objPHPExcel->getActiveSheet()->setCellValue("C$x", $row['trans_type']);
				$objPHPExcel->getActiveSheet()->setCellValue("D$x", $row['value_dt']);
				$objPHPExcel->getActiveSheet()->setCellValue("E$x", $row['short_desc']);
				$objPHPExcel->getActiveSheet()->setCellValue("F$x", $row['lawan_name']);
				$objPHPExcel->getActiveSheet()->setCellValue("G$x", $row['nominal']);
				$objPHPExcel->getActiveSheet()->setCellValue("H$x", $row['price']);
				$objPHPExcel->getActiveSheet()->setCellValue("I$x", $row['capital_gain']);
				$objPHPExcel->getActiveSheet()->setCellValue("J$x", $row['acct_6150']);
				$objPHPExcel->getActiveSheet()->setCellValue("K$x", $row['prepaid']);
				$objPHPExcel->getActiveSheet()->setCellValue("L$x", $row['clients']);
				$objPHPExcel->getActiveSheet()->setCellValue("M$x", $row['profit_broker']);
				$objPHPExcel->getActiveSheet()->setCellValue("N$x", $row['clients_tax_pay']);
				$objPHPExcel->getActiveSheet()->setCellValue("O$x", $row['broker_tax_pay']);
				$objPHPExcel->getActiveSheet()->setCellValue("P$x", $row['net_amount']);
				$x++;
			}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save($excelFileName);
		}

		if (file_exists($excelFileName))
		{
			header('Content-Description: File Transfer');
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="' . 'Bond Transaction Tax Report' . '.xls"');
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
