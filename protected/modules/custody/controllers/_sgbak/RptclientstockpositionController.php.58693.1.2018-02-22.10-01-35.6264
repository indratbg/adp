<?php

class RptclientstockpositionController extends AAdminController
{

	public $layout = '//layouts/admin_column3';
	public function actionIndex()
	{
		$model = new Rptclientstockposition('CLIENT_STOCK_POSITION', 'R_STOCK_POSITION_INTERNAL', 'Client_stock_position.rptdesign');
		$sql = "select  stk_cd, stk_cd||' - '||stk_desc stk_desc from mst_counter where approved_stat='A' order by stk_cd";
		$stk_cd = Counter::model()->findAllBySql($sql);
		$rem_cd = Sales::model()->findAll(array(
			'select' => "rem_cd, rem_cd||' - '|| rem_name as rem_name ",
			'condition' => "approved_stat='A' "
		));
		$branch_cd = Branch::model()->findAll(array(
			'select' => "brch_cd, brch_cd ||' - '|| brch_name as brch_name",
			'condition' => "approved_stat='A' ",
			'order' => 'brch_cd'
		));
		$model->doc_date = date('d/m/Y');
		$url = '';
		$model->report_type = 1;
		$model->stk_option = 0;
		$model->client_option = 0;
		$model->sales_option = 0;
		$model->branch_option = 0;
		$model->position_option = 0;
		$model->group_option = 0;
		if (isset($_POST['Rptclientstockposition']))
		{
			$model->attributes = $_POST['Rptclientstockposition'];
			
			if ($model->validate())
			{
				//REPORT TYPE
				if($model->report_type=='0')
				{
					$model->rptname='Client_stock_position_summary.rptdesign';
				}
				
				//stock
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
				//all client
				if ($model->client_option == '0')
				{
					$bgn_client = '%';
					$end_client = '_';
					$custody = 'N';
					$bgn_client_type_3 = '%';
					$end_client_type_3 = '_';
					$bgn_margin = '%';
					$end_margin = '_';
				}
				//regular
				else if ($model->client_option == '1')
				{
					$bgn_client = '%';
					$end_client = '_';
					$custody = 'N';
					$bgn_client_type_3 = 'R';
					$end_client_type_3 = 'R';
					$bgn_margin = '%';
					$end_margin = '_';
				}
				//custody
				else if ($model->client_option == '2')
				{
					$bgn_client = '%';
					$end_client = '_';
					$custody = 'Y';
					$bgn_client_type_3 = '%';
					$end_client_type_3 = '_';
					$bgn_margin = '%';
					$end_margin = '_';
				}
				//SPECIFIED
				else if ($model->client_option == '3')
				{
					$bgn_client = $model->bgn_client;
					$end_client = $model->end_client;
					$custody = 'N';
					$bgn_client_type_3 = '%';
					$end_client_type_3 = '_';
					$bgn_margin = '%';
					$end_margin = '_';
				}
				//MARGIN
				else if ($model->client_option == '4')
				{
					$bgn_client = '%';
					$end_client = '_';
					$custody = 'N';
					$bgn_margin = 'M';
					$end_margin = 'M';
					$bgn_client_type_3 = 'M';
					$end_client_type_3 = 'M';
				}
				//T PLUS
				else if ($model->client_option == '5')
				{
					$bgn_client = '%';
					$end_client = '_';
					$custody = 'N';
					$bgn_margin = 'R';
					$end_margin = 'R';
					$bgn_client_type_3 = 'T';
					$end_client_type_3 = 'T';
				}

				//sales
				if ($model->sales_option == '0')
				{
					$bgn_rem = '%';
					$end_rem = '_';
				}
				else
				{
					$bgn_rem = $model->rem_cd;
					$end_rem = $model->rem_cd;
				}
				//branch
				if ($model->branch_option == '0')
				{
					$bgn_branch = '%';
					$end_branch = '_';
				}
				else
				{
					$bgn_branch = $model->branch_cd;
					$end_branch = $model->branch_cd;
				}

				//position
				if ($model->position_option == '0')
				{
					$position = 'ALL';
				}
				//REPO
				else if ($model->position_option == '1')
				{
					$position = 'R';
				}
				//SHORT SELL
				else if ($model->position_option == '2')
				{
					$position = 'SHORT';
				}
				//SCRIP
				else if ($model->position_option == '3')
				{
					$position = 'S';
				}
				if ($model->group_option == '0')
				{
					$model->group_by = 'CLIENT';
				}
				else
				{
					$model->group_by = 'STOCK';
				}

				if ($model->executeRpt($bgn_stk, $end_stk, $bgn_client, $end_client, $bgn_rem, $end_rem, $bgn_branch, $end_branch, $position, $custody, $bgn_client_type_3, $end_client_type_3, $bgn_margin, $end_margin) > 0)
				{
				    
                    $date = DateTime::createFromFormat('Y-m-d', $model->doc_date)->format('d-M-Y');
					$url = $model->showReport($model->group_by,$date) . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
		}

		if (DateTime::createFromFormat('Y-m-d', $model->doc_date))
			$model->doc_date = DateTime::createFromFormat('Y-m-d', $model->doc_date)->format('d/m/Y');

		$this->render('index', array(
			'model' => $model,
			'url' => $url,
			'rem_cd' => $rem_cd,
			'branch_cd' => $branch_cd,
			'rand_value' => $model->vo_random_value,
			'user_id' => $model->vp_userid,
			'stk_cd' => $stk_cd
		));
	}
public function actionGetXls($rand_value, $user_id)
	{	
		
    $excelFileName = Yii::app()->basePath.'/../upload/rpt_xls/Client_Stock_Position.xls';
	$objPHPExcel= XPHPExcel::createPHPExcel();	
	
	  $objPHPExcel->getProperties()->setCreator("SSS")
								 ->setLastModifiedBy("SSS")
								 ->setTitle("Client Stock Position")
								 ->setSubject("Office 2007 XLSX Test Document")
								// ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Custody");
	
	$objPHPExcel->setActiveSheetIndex(0);
	//CEK REPORT MODE
	$sql ="select count(*) as cnt from INSISTPRO_RPT.r_stock_position_internal where rand_value='$rand_value' AND user_id ='$user_id'";
	$exec = DAO::queryRowSql($sql);
	
	//if report mode by regular
	if($exec['cnt']>0)
	{
	
		 	$objPHPExcel->getActiveSheet()->setCellValue("A1", 'Branch')
				 	->setCellValue("B1", 'Client Code')
					->setCellValue("C1", 'Old Code')
					->setCellValue("D1", 'Client Name')
					->setCellValue("E1", 'Rem cd')
					->setCellValue("F1", 'Subrek')
					->setCellValue("G1", 'Stock Code')
					->setCellValue("H1", 'Theoritical Qty')
					->setCellValue("I1", 'On Hand')
					->setCellValue("J1", 'Scrip Qty')
					->setCellValue("K1", 'Outs Buy')
					->setCellValue("L1", 'Outs Sell')
					->setCellValue("M1", 'Dijaminkan')
					->setCellValue("N1", 'Repo Beli')
					->setCellValue("O1", 'Repo Jual');
			//retrieve data
			$sql = "select branch_code,client_cd,old_ic_num,client_name,rem_cd,sub_rek,stk_cd,theo_qty,
					onh_qty,scrip_qty,os_buy, os_sell, jaminan,repo_buy_client,repo_sell_client from insistpro_rpt.r_stock_position_internal
					WHERE rand_value='$rand_value' and user_id='$user_id' and client_cd <>'TXT'
					order by stk_cd, client_cd";		
			$data = DAO::queryAllSql($sql);
			$x=2;
			foreach($data as $row)
			{
				$objPHPExcel->getActiveSheet()->setCellValue("A$x",$row['branch_code']);
				$objPHPExcel->getActiveSheet()->setCellValue("B$x",$row['client_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("C$x",$row['old_ic_num']);
				$objPHPExcel->getActiveSheet()->setCellValue("D$x",$row['client_name']);
				$objPHPExcel->getActiveSheet()->setCellValue("E$x",$row['rem_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("F$x",$row['sub_rek']);
				$objPHPExcel->getActiveSheet()->setCellValue("G$x",$row['stk_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("H$x",$row['theo_qty']);
				$objPHPExcel->getActiveSheet()->setCellValue("I$x",$row['onh_qty']);
				$objPHPExcel->getActiveSheet()->setCellValue("J$x",$row['scrip_qty']);
				$objPHPExcel->getActiveSheet()->setCellValue("K$x",$row['os_buy']);
				$objPHPExcel->getActiveSheet()->setCellValue("L$x",$row['os_sell']);
				$objPHPExcel->getActiveSheet()->setCellValue("M$x",$row['jaminan']);
				$objPHPExcel->getActiveSheet()->setCellValue("N$x",$row['repo_buy_client']);
				$objPHPExcel->getActiveSheet()->setCellValue("O$x",$row['repo_sell_client']);
				
				$x++;
			}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
						$objWriter->save($excelFileName);
		}

		if(file_exists($excelFileName))
		{
			header('Content-Description: File Transfer');
		    header('Content-Type: application/vnd.ms-excel');
		    header('Content-Disposition: attachment; filename="'.'Client Stock Position'.'.xls"');
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