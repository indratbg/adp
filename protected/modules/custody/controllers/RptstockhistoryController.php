<?php

class RptstockhistoryController extends AAdminController
{

	public $layout = '//layouts/admin_column3';
/*
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
*/
	public function actionIndex()
	{
		$model = new Rptstockhistory('STOCK_HISTORY', 'R_STOCK_HISTORY', 'Stock_history.rptdesign');
		$sql = "select  stk_cd, stk_cd||'-'||stk_desc stk_desc from mst_counter where approved_stat='A' order by stk_cd";
		$stk_cd = Counter::model()->findAllBySql($sql);
		$sql = "select  rem_cd, rem_cd||'-'||rem_name rem_name from mst_sales where approved_stat='A' order by rem_cd";
		$rem_cd = Sales::model()->findAllBySql($sql);
		$url = '';
		$model->bgn_date = date('01/m/Y');
		$model->end_date = date('d/m/Y');
		$model->stk_option = 0;
		$model->rem_option = 0;
		$model->qty_option = 0;
		$model->client_option = 0;
		if (isset($_POST['Rptstockhistory']))
		{
			$model->attributes = $_POST['Rptstockhistory'];
			if ($model->validate())
			{

				if ($model->stk_option == '0')
				{
					$bgn_stk = '%';
					$end_stk = '_';
				}
				else
				{
					$bgn_stk = $model->stk_cd;
					$end_stk = $model->stk_cd;
				}
				if ($model->client_option == '0')
				{
					$bgn_client = '%';
					$end_client = '_';
				}
				else
				{
					$bgn_client = $model->client_cd;
					$end_client = $model->client_cd;
				}
				if ($model->rem_option == '0')
				{
					$bgn_rem = '%';
					$end_rem = '_';
				}
				else
				{
					$bgn_rem = $model->rem_cd;
					$end_rem = $model->rem_cd;
				}
				$on_hand = $model->qty_option == '0' ? 'N' : 'Y';

				if ($model->executeRpt($on_hand, $bgn_stk, $end_stk, $bgn_client, $end_client, $bgn_rem, $end_rem) > 0)
				{
					$url = $model->showReport() . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				}

			}
		}

		if (DateTime::createFromFormat('Y-m-d', $model->bgn_date))
			$model->bgn_date = DateTime::createFromFormat('Y-m-d', $model->bgn_date)->format('d/m/Y');
		if (DateTime::createFromFormat('Y-m-d', $model->end_date))
			$model->end_date = DateTime::createFromFormat('Y-m-d', $model->end_date)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'url' => $url,
			'stk_cd' => $stk_cd,
			'rand_value' => $model->vo_random_value,
			'user_id' => $model->vp_userid,
			'rem_cd' => $rem_cd
		));
	}
	public function actionGetXls($rand_value, $user_id)
	{	
		
    $excelFileName = Yii::app()->basePath.'/../upload/rpt_xls/Stock_history.xls';
	$objPHPExcel= XPHPExcel::createPHPExcel();	
	
	  $objPHPExcel->getProperties()->setCreator("SSS")
								 ->setLastModifiedBy("SSS")
								 ->setTitle("Stock History")
								 ->setSubject("Office 2007 XLSX Test Document")
								// ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Contracting");
	
	$objPHPExcel->setActiveSheetIndex(0);
	//CEK REPORT MODE
	$sql ="select count(*) as cnt from INSISTPRO_RPT.R_stock_history where rand_value='$rand_value' AND user_id ='$user_id'";
	$exec = DAO::queryRowSql($sql);
	
	//if report mode by regular
	if($exec['cnt']>0)
	{
	
		 	$objPHPExcel->getActiveSheet()->setCellValue("A1", 'Branch')
				 	->setCellValue("B1", 'Client Code')
					->setCellValue("C1", 'Client Name')
					->setCellValue("D1", 'Subrek')
					->setCellValue("E1", 'Stock Code')
					->setCellValue("F1", 'Stock Description')
					->setCellValue("G1", 'Transaction Date')
					->setCellValue("H1", 'Transaction type')
					->setCellValue("I1", 'Local Qty')
					->setCellValue("J1", 'Foreign Qty')
					->setCellValue("K1", 'Total')
					->setCellValue("L1", 'Due Date')
					->setCellValue("M1", 'Price')
					->setCellValue("N1", 'Description')
					;
			//retrieve data
			$sql = "select BRANCH_CODE, client_cd, CLIENT_NAME,SUBREK, STK_CD,STK_DESC,DOC_DT,TRX_BS,L_STK_QTY, F_STK_QTY, 
					BAL_AMT,due_date, PRICE, TRX_DESC from insistpro_rpt.r_stock_history
					WHERE rand_value='$rand_value' and user_id='$user_id'
					ORDER BY CLIENT_CD,STK_cD,DOC_DT,CRE_DT,DOC_NUM";		
			$data = DAO::queryAllSql($sql);
			$x=2;
			foreach($data as $row)
			{
				$objPHPExcel->getActiveSheet()->setCellValue("A$x",$row['branch_code']);
				$objPHPExcel->getActiveSheet()->setCellValue("B$x",$row['client_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("C$x",$row['client_name']);
				$objPHPExcel->getActiveSheet()->setCellValue("D$x",$row['subrek']);
				$objPHPExcel->getActiveSheet()->setCellValue("E$x",$row['stk_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("F$x",$row['stk_desc']);
				$objPHPExcel->getActiveSheet()->setCellValue("G$x",$row['doc_dt']);
				$objPHPExcel->getActiveSheet()->setCellValue("H$x",$row['trx_bs']);
				$objPHPExcel->getActiveSheet()->setCellValue("I$x",$row['l_stk_qty']);
				$objPHPExcel->getActiveSheet()->setCellValue("J$x",$row['f_stk_qty']);
				$objPHPExcel->getActiveSheet()->setCellValue("K$x",$row['bal_amt']);
				$objPHPExcel->getActiveSheet()->setCellValue("L$x",$row['due_date']);
				$objPHPExcel->getActiveSheet()->setCellValue("M$x",$row['price']);
				$objPHPExcel->getActiveSheet()->setCellValue("N$x",$row['trx_desc']);
				
				$x++;
			}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
						$objWriter->save($excelFileName);
		}

		if(file_exists($excelFileName))
		{
			header('Content-Description: File Transfer');
		    header('Content-Type: application/vnd.ms-excel');
		    header('Content-Disposition: attachment; filename="'.'STock History'.'.xls"');
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