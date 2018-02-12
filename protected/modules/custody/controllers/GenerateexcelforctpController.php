<?php

class GenerateexcelforctpController extends AAdminController
{
	public $layout='//layouts/admin_column3';

	public function actionIndex()
	{
		$model = new Generateexcelforctp;
		$modelDetail = array();
		$modelDetailCSV= array();
		$sql = "select cbest_cd, custody_name,sr_custody_Cd				
				from mst_bank_custody				
				where approved_sts = 'A'				
				and sr_custody_cd is not null
				union
				select 'KSEI' cbest_cd, 'CBEST' custody_name, 'YJ001' sr_custody_cd
				from dual				
				order by 3				
						";
		$custody_cd = Bankcustody::model()->findAllBySql($sql);				
		$model->trx_date=date('d/m/Y');
		$model->all='ALL';
		$valid = true;
		$success = false;
		$url='';
		$flg ='N';
		//$this->getCSV(date('Y-m-04'));
		if(isset($_POST['Generateexcelforctp']))
		{
			$model->attributes = $_POST['Generateexcelforctp'];
			$scenario = $_POST['scenario'];
				
			if($scenario =='filter')
			{
				$trx_date = $model->trx_date;
				$trx_id = $model->all?'ALL':$model->trx_id;
				$modelDetail = Generateexcelforctp::model()->findAllBySql(Generateexcelforctp::getData($trx_date, $trx_id));
				foreach($modelDetail as $row)
				{
					if(DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_time))$row->trx_time = DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_time)->format('d/m/y H:i'); 
					if(DateTime::createFromFormat('Y-m-d',$row->trx_date))$row->trx_date = DateTime::createFromFormat('Y-m-d',$row->trx_date)->format('d/m/y');
					if(DateTime::createFromFormat('Y-m-d',$row->value_dt))$row->value_dt = DateTime::createFromFormat('Y-m-d',$row->value_dt)->format('d/m/y');
					if(!isset($row->n_yield))$row->save_flg = 'Y';
				}
				
			}
			else if($scenario =='save_csv')
			{
				$rowCount = $_POST['rowCount'];
				
				for($x=0;$x<$rowCount;$x++)
				{
					$modelDetail[$x] = new Generateexcelforctp;
					$modelDetail[$x]->attributes = $_POST['Generateexcelforctp'][$x+1];
					$modelDetail[$x]->datetime = $modelDetail[$x]->trx_time;
					if(DateTime::createFromFormat('d/m/y H:i',$modelDetail[$x]->datetime))$modelDetail[$x]->datetime = DateTime::createFromFormat('d/m/y H:i',$modelDetail[$x]->datetime)->format('Y-m-d H:i:s');
					if(DateTime::createFromFormat('d/m/y',$modelDetail[$x]->trx_date))$modelDetail[$x]->trx_date = DateTime::createFromFormat('d/m/y',$modelDetail[$x]->trx_date)->format('Y-m-d');
					if(DateTime::createFromFormat('d/m/y',$modelDetail[$x]->value_dt))$modelDetail[$x]->value_dt = DateTime::createFromFormat('d/m/y',$modelDetail[$x]->value_dt)->format('Y-m-d');
				
					if($modelDetail[$x]->save_flg=='Y')
					{
						$valid = $modelDetail[$x]->validate() && $valid;	
					}
						
				}
				
				if($valid)
				{
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction(); 
					
					for($x=0;$x<$rowCount;$x++)
					{
						if($modelDetail[$x]->save_flg=='Y')
						{						
							if($modelDetail[$x]->executeSp('N')>0)
							{
								$success=true;
							}
							else 
							{
								$success=false;
							}
						}
					}
					
					
					if($success)
					{
						$transaction->commit();
						
						$flg = 'Y';
						//SHOW POP UP CSV
						$modelDetailCSV = Generateexcelforctp::model()->findAllBySql(Generateexcelforctp::getCSV($model->trx_date));
						
						
					}
					else {
						$transaction->rollback();
					}
				}
			}
			else if($scenario =='save_file')
			{	
				$this->getCSV($model);
				
			}
				foreach($modelDetail as $row)
				{
					if(DateTime::createFromFormat('Y-m-d',$row->trx_date))$row->trx_date = DateTime::createFromFormat('Y-m-d',$row->trx_date)->format('d/m/y');
					if(DateTime::createFromFormat('Y-m-d',$row->value_dt))$row->value_dt = DateTime::createFromFormat('Y-m-d',$row->value_dt)->format('d/m/y');
				}
			
		}
		
		
		$this->render('index',array('model'=>$model,
									'modelDetail'=>$modelDetail,
									'custody_cd'=>$custody_cd,
									'url'=>$url,'flg'=>$flg,
									//'modelReport'=>$modelReport,
									'modelDetailCSV'=>$modelDetailCSV));
	}

	public function getCSV($model)
	{
		
			$connection  = Yii::app()->db;
			$transaction = $connection->beginTransaction();
			if(DateTime::createFromFormat('d/m/Y',$model->trx_date))$model->trx_date = DateTime::createFromFormat('d/m/Y',$model->trx_date)->format('Y-m-d');		
			
			$fileName = 'ctp_'.date('Ymd').'.csv';
			$csvFileName = 'upload/gen_excel_ctp/'.$fileName;
			$handle = fopen($csvFileName,'wb');
			$doc_date = DateTime::createFromFormat('Y-m-d',$model->trx_date)->format('d/m/Y');	
			$data = DAO::queryAllSql(Generateexcelforctp::getCSV($doc_date));
			
			/*
			
				fputcsv($handle, array(
							'Report Type',
							'Position',
							'Securities Id',
							'Transaction Type',
							'Cp Firm Id',
							'Price',
							'Yield',
							'Volume',
							'Trade Date',
							'Trade Time',
							'Vas',
							'Settlement Date',
							'Trx Parties Code Deliverer',
							'Remarks Deliverer',
							'Reference Deliverer',
							'Custodian Deliverer',
							'Trx Parties Code Receiver',
							'Remarks Receiver',
							'Reference Receiver',
							'Custodian Receiver',
							'Second Leg Price',
							'Second Leg Yield',
							'Second Leg Rate',
							'Reverse Date',
							'Late Type',
							'Late Reason'
						));
										
						*/
			
			foreach($data as $row)
			{
				//fputcsv($handle, str_replace('"', '', $row));
				fwrite($handle, $row['report_type'].",");
				fwrite($handle, $row['position'].",");
				fwrite($handle, $row['securities_id'].",");
				fwrite($handle, $row['transaction_type'].",");
				fwrite($handle, $row['cp_firm_id'].",");
				fwrite($handle, $row['price'].",");
				fwrite($handle, $row['yield'].",");
				fwrite($handle, $row['volume'].",");
				fwrite($handle, $row['trade_date'].",");
				fwrite($handle, $row['trade_time'].",");
				fwrite($handle, $row['vas'].",");
				fwrite($handle, $row['settlement_date'].",");
				fwrite($handle, $row['trx_parties_code_deliverer'].",");
				fwrite($handle, $row['remarks_deliverer'].",");
				fwrite($handle, $row['reference_deliverer'].",");
				fwrite($handle, $row['custodian_deliverer'].",");
				fwrite($handle, $row['trx_parties_code_receiver'].",");
				fwrite($handle, $row['remarks_receiver'].",");
				fwrite($handle, $row['reference_receiver'].",");
				fwrite($handle, $row['custodian_receiver'].",");
				fwrite($handle, $row['second_leg_price'].",");
				fwrite($handle, $row['second_leg_yield'].",");
				fwrite($handle, $row['second_leg_rate'].",");
				fwrite($handle, $row['reverse_date'].",");
				fwrite($handle, $row['late_type'].",");
				fwrite($handle, $row['late_reason']."\r\n");
			}
			fclose($handle);
			
			//update xls=Y
			if($model->executeSp('Y')>0)
			{
				$transaction->commit();
			}
			else {
				$transaction->rollback();
			}
			if(file_exists($csvFileName))
			{
				header('Pragma: public');
				header('Content-Description: File Transfer');
				header('Content-Length: ' . filesize($csvFileName));
				header('Content-Disposition: attachment; filename='.$fileName);
				header('Content-Type: application/csv; charset=UTF-8');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header("Content-Transfer-Encoding: binary");
				ob_clean();
				flush();
				readfile($csvFileName);
				unlink($csvFileName);
				exit;	
			}
			
					
	}
	
}