<?php
ini_set('memory_limit','512M');
class RptclientactivityController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
public function actionGetclient()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_REQUEST['term']);
      $qSearch = DAO::queryAllSql("
				Select client_cd, client_name FROM MST_CLIENT 
				Where (client_cd like '".$term."%')
      			AND susp_stat = 'N'
      			AND rownum <= 11
      			ORDER BY client_cd
      			"); 
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['client_cd']. ' - '.$search['client_name']
      			, 'labelhtml'=>$search['client_cd']
      			, 'value'=>$search['client_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }
	
	public function actionIndex()
    {
    	$broker_cd = Vbrokersubrek::model()->find()->broker_cd;	
		$rpt_name='';
		if(substr($broker_cd,0,2)=='YJ')
		{
			$rpt_name = 'R_CLIENT_ACTIVITY_YJ.rptdesign';
		}
		if(substr($broker_cd,0,2)=='MU')
		{
			$rpt_name = 'R_CLIENT_ACTIVITY_MU.rptdesign';
		}
		else if(substr($broker_cd,0,2)=='PF')
		{
			$rpt_name = 'R_CLIENT_ACTIVITY_PF.rptdesign';
		}
    	$model = new Rptclientactivity('CLIENT_ACTIVITY','R_CLIENT_ACTIVITY',$rpt_name);
		$sql = "select  stk_cd, stk_cd||' - '||stk_desc stk_desc from mst_counter where approved_stat='A' order by stk_cd";
		$stk_cd = Counter::model()->findAllBySql($sql); 
		$rem_cd = Sales::model()->findAll(array('select'=>"rem_cd, rem_cd||' - '|| rem_name as rem_name ",'condition'=>"approved_stat='A' "));
		$branch_cd = Branch::model()->findAll(array('select'=>"brch_cd, brch_cd ||' - '|| brch_name as brch_name",'condition'=>"approved_stat='A' ",'order'=>'brch_cd' ));
		$model->bgn_date = date('d/m/Y');
		$model->end_date = date('d/m/Y');
		$model->market_type_option=0;
		$url ='';
		$model->report_type=1;
		$model->stk_option=0;
		$model->client_option=0;
		$model->sales_option=0;
		$model->branch_option=0;
		$model->position_option=0;
		$model->group_by=0;
		$model->kpei_due_dt_option=0;
		$model->price=0;
		if(isset($_POST['Rptclientactivity']))
		{
			$model->attributes = $_POST['Rptclientactivity'];
			//var_dump( $model->market_type);die();
			if($model->validate())
			{
				//stock
				if($model->stk_option =='0')
				{
					$bgn_stk_cd = '%';
					$end_stk_cd = '_';
				}
				else 
				{
					$bgn_stk_cd = $model->stk_cd;
					$end_stk_cd = $model->stk_cd;
				}
				//all client
				if($model->client_option == '0')
				{
					$bgn_client_cd = '%';
					$end_client_cd = '_';
					$custody ='N';
					$bgn_client_type_3 = '%';
					$end_client_type_3 = '_';
					$bgn_margin = '%';
					$end_margin = '_';
					$client_type3 ='%';
				}
				//regular
				else if($model->client_option =='1')
				{ 
					$bgn_client_cd = '%';
					$end_client_cd = '_';
					$custody ='N';
					$bgn_client_type_3 = 'R';
					$end_client_type_3 = 'R';
					$bgn_margin = '%';
					$end_margin = '_';
					$client_type3 ='R';
				}
				//custody
				else if($model->client_option =='2')
				{
					$bgn_client_cd = '%';
					$end_client_cd = '_';
					$custody ='Y';
					$bgn_client_type_3 = '%';
					$end_client_type_3 = '_';
					$bgn_margin = '%';
					$end_margin = '_';
					$client_type3 ='%';
				}
				//SPECIFIED
				else if($model->client_option =='3')
				{
					$bgn_client_cd = $model->bgn_client;
					$end_client_cd = $model->end_client;
					$custody ='N';
					$bgn_client_type_3 = '%';
					$end_client_type_3 = '_';
					$bgn_margin = '%';
					$end_margin = '_';
					$client_type3 ='%';
				}
				//MARGIN
				else if($model->client_option =='4')
				{
					$bgn_client_cd = '%';
					$end_client_cd = '_';
					$custody ='N';
					$bgn_margin = 'M';
					$end_margin = 'M';
					$bgn_client_type_3 = 'M';
					$end_client_type_3 = 'M';
					$client_type3 ='M';
				}
				//T PLUS
				else if($model->client_option =='5')
				{
					$bgn_client_cd = '%';
					$end_client_cd = '_';
					$custody ='N';
					$bgn_margin = 'R';
					$end_margin = 'R';
					$bgn_client_type_3 = 'T';
					$end_client_type_3 = 'T';
					$client_type3 ='T';
				}
				
				//sales
				if($model->sales_option =='0')
				{
					$bgn_rem_cd = '%';
					$end_rem_cd = '_';
				}
				else 
				{
					$bgn_rem_cd = $model->rem_cd;
					$end_rem_cd = $model->rem_cd;
				}
				//branch
				if($model->branch_option =='0')
				{
					$bgn_branch = '%';
					$end_branch = '_';	
				}
				else
				{
					$bgn_branch = $model->branch_cd;
					$end_branch = $model->branch_cd;
				}	
				//STA B-BELI, J-JUAL
				if($model->beli_jual=='0')
				{
					$sta = '%';
				}
				else if($model->beli_jual =='1')
				{
					$sta = 'B';
				}
				else 
				{
					$sta = 'J';	
				}
				//STA_TYPE, JIKA REGULAR R, TITIP=I, NEGO=R
				if($model->market_type_option== '0')
				{
					$sta_type = '%';	
					$mrkt_type = '%';
					$bgn_mrkt_type='%';
					$end_mrkt_type='_';
				}
				else 
				{
					//'0'=>'Regular','1'=>'Titip','2'=>'Nego','3'=>'Tutup Sendiri','4'=>'Tunai'
					$sta_type = $model->market_type=='1'?'I':'R';	
					$mrkt_type =  $model->market_type=='2'?'NG':'RG';
					//$bgn_mrkt_type=$model->market_type=='2'?'NG':'RG';
					//$end_mrkt_type=	$model->market_type=='2'?'NG':'RG';
					$sta_type='%';
					$mrkt_type ='%';
					
					if($model->market_type =='0' || $model->market_type =='1')
					{
						$bgn_mrkt_type='RG';
						$end_mrkt_type='RG';
					}
					else if($model->market_type =='2')
					{
						$bgn_mrkt_type='NG';
						$end_mrkt_type='NG';
					}
					else if($model->market_type =='3')
					{
						$bgn_mrkt_type='TS';
						$end_mrkt_type='TS';
					}
					else if($model->market_type =='4')
					{
						$bgn_mrkt_type='TN';
						$end_mrkt_type='TN';
					}
					else 
					{
						$bgn_mrkt_type='%';
						$end_mrkt_type='_';	
						
					}
				} 
				if($model->kpei_due_dt_option==0)
				{
					$bgn_days = 0;
					$end_days = 3;
				}
				else 
				{
					$bgn_days = $model->kpei_due_dt;
					$end_days =  $model->kpei_due_dt;
				}
				//group by
				if($model->group_by =='0')
				{
					$group_by = 'CLIENT';
				}
				else if($model->group_by =='1')
				{
					$group_by = 'SALES';
				}
				else if($model->group_by == '2')
				{
					$group_by = 'OLD_CLIENT';
				}
				else if($model->group_by == '3')
				{
					$group_by = 'STOCK';
				}
				else if($model->group_by == '4')
				{
					$group_by = 'CONTRACT_DATE';
				}
				
				
				
				if($model->executeRpt($bgn_branch, $end_branch, $bgn_stk_cd, $end_stk_cd, $bgn_client_cd, $end_client_cd, $bgn_rem_cd, $end_rem_cd, $custody, $sta, $sta_type, $mrkt_type, $bgn_days, $end_days, $client_type3,$bgn_mrkt_type,$end_mrkt_type, $group_by)>0)
				{
					$url=$model->showReport().'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
		}
		
		if(DateTime::createFromFormat('Y-m-d',$model->bgn_date)) $model->bgn_date = DateTime::createFromFormat('Y-m-d',$model->bgn_date)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$model->end_date)) $model->end_date = DateTime::createFromFormat('Y-m-d',$model->end_date)->format('d/m/Y');
		
		$this->render('index',array('model'=>$model,
									'url'=>$url,
									'rem_cd'=>$rem_cd,
									'branch_cd'=>$branch_cd,
									'rand_value'=>$model->vo_random_value,
									'user_id'=>$model->vp_userid,
									'stk_cd'=>$stk_cd));
	}

	public function actionGetXls($rand_value, $user_id)
	{	
		
    $excelFileName = Yii::app()->basePath.'/../upload/rpt_xls/Client_Activity.xls';
	$objPHPExcel= XPHPExcel::createPHPExcel();	
	
	  $objPHPExcel->getProperties()->setCreator("SSS")
								 ->setLastModifiedBy("SSS")
								 ->setTitle("Client Activity")
								 ->setSubject("Office 2007 XLSX Test Document")
								// ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
								 ->setKeywords("office 2007 openxml php")
								 ->setCategory("Contracting");
	
	$objPHPExcel->setActiveSheetIndex(0);
	//CEK REPORT MODE
	$sql ="select count(*) as cnt from INSISTPRO_RPT.R_Client_activity where rand_value='$rand_value' AND user_id ='$user_id'";
	$exec = DAO::queryRowSql($sql);
	
	//if report mode by regular
	if($exec['cnt']>0)
	{
	
		 	$objPHPExcel->getActiveSheet()->setCellValue("A1", 'Branch')
				 	->setCellValue("B1", 'Client Code')
					->setCellValue("C1", 'Client Name')
					->setCellValue("D1", 'Rem Code')
					->setCellValue("E1", 'Rem Name')
					->setCellValue("F1", 'Contract Date')
					->setCellValue("G1", 'Due Date')
					->setCellValue("H1", 'Contract Number')
					->setCellValue("I1", 'Beli/ Jual')
					->setCellValue("J1", 'Stock')
					->setCellValue("K1", 'LOT')
					->setCellValue("L1", 'Qty')
					->setCellValue("M1", 'Price')
					->setCellValue("N1", 'NET')
					->setCellValue("O1", 'Commision')
					->setCellValue("P1", 'VAT')
					->setCellValue("Q1", 'BEJ Fee')
					->setCellValue("R1", 'PPH')
					->setCellValue("S1", '%')
					->setCellValue("T1", 'Total Fee')
					->setCellValue("U1", 'Total Amount')
					;
			//retrieve data
			$sql = "SELECT BRCH_CD,  CLIENT_CD,  CLIENT_NAME,  REM_CD,  REM_NAME,
					  CONTR_DT,  DUE_DT_FOR_AMT,  CONTR_NUM,  BJ,  STK_CD,
						  LOT_SIZE, QTY, PRICE,  NET,  COMMISSION,  VAT,
						  TRANS_LEVY,  PPH,  BROK_PERC,  BROK,  AMT
						FROM insistpro_rpt.r_client_activity
						WHERE RAND_VALUE='$rand_value' and user_id='$user_id'
						ORDER BY CLIENT_CD, CONTR_DT,STK_CD,BJ";		
			$data = DAO::queryAllSql($sql);
			$x=2;
			foreach($data as $row)
			{
				$objPHPExcel->getActiveSheet()->setCellValue("A$x",$row['brch_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("B$x",$row['client_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("C$x",$row['client_name']);
				$objPHPExcel->getActiveSheet()->setCellValue("D$x",$row['rem_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("E$x",$row['rem_name']);
				$objPHPExcel->getActiveSheet()->setCellValue("F$x",$row['contr_dt']);
				$objPHPExcel->getActiveSheet()->setCellValue("G$x",$row['due_dt_for_amt']);
				$objPHPExcel->getActiveSheet()->setCellValue("H$x",$row['contr_num']);
				$objPHPExcel->getActiveSheet()->setCellValue("I$x",$row['bj']);
				$objPHPExcel->getActiveSheet()->setCellValue("J$x",$row['stk_cd']);
				$objPHPExcel->getActiveSheet()->setCellValue("K$x",$row['lot_size']);
				$objPHPExcel->getActiveSheet()->setCellValue("L$x",$row['qty']);
				$objPHPExcel->getActiveSheet()->setCellValue("M$x",$row['price']);
				$objPHPExcel->getActiveSheet()->setCellValue("N$x",$row['net']);
				$objPHPExcel->getActiveSheet()->setCellValue("O$x",$row['commission']);
				$objPHPExcel->getActiveSheet()->setCellValue("P$x",$row['vat']);
				$objPHPExcel->getActiveSheet()->setCellValue("Q$x",$row['trans_levy']);
				$objPHPExcel->getActiveSheet()->setCellValue("R$x",$row['pph']);
				$objPHPExcel->getActiveSheet()->setCellValue("S$x",$row['brok_perc']);
				$objPHPExcel->getActiveSheet()->setCellValue("T$x",$row['brok']);
				$objPHPExcel->getActiveSheet()->setCellValue("U$x",$row['amt']);
				$x++;
			}
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
						$objWriter->save($excelFileName);
		}

		if(file_exists($excelFileName))
		{
			header('Content-Description: File Transfer');
		    header('Content-Type: application/vnd.ms-excel');
		    header('Content-Disposition: attachment; filename="'.'Client Activity'.'.xls"');
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