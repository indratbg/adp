<?php

Class GenxmlsettlecustodyController extends AAdminController
{
	const CONVERT_COLUMN_FOR_XML = 1;
	const CONVERT_COLUMN_FOR_VIEW = 2;
	
	public $layout='//layouts/admin_column3';
	
	private $custodyHasSubrek;
	private $broker;
	private $mode;
	
	public function actionAjxGetDueDate()
	{
		$dueDate = '';
		
		if(isset($_POST['trx_date']))
		{
			$trx_date = $_POST['trx_date'];
			$sql = "SELECT TO_CHAR(GET_DUE_DATE(F_GET_SETTDAYS(TO_DATE('$trx_date','DD/MM/YYYY')),TO_DATE('$trx_date','DD/MM/YYYY')),'DD/MM/YYYY') due_date FROM dual";
			
			$result = DAO::queryRowSql($sql);
			$dueDate = $result['due_date'];
		}
		
		echo json_encode($dueDate);
	}
	
	public function actionIndex()
	{
		$model = new GenXmlSettleCustody('header');
		$modelResult = $resultContent = $resultArr = array();
		$retrieved = false;
		$valid = false;
		$success = false;
		$scenario = '';
		$model->cekInsert = 'N';
				
		if(isset($_POST['GenXmlSettleCustody']))
		{
			$model->attributes = $_POST['GenXmlSettleCustody'];
			$scenario = $_POST['submit'];
			
			if($scenario == 'retrieve')
			{
				if($model->cekInsert == 'Y'){
					$model->due_date = $model->trx_date;
				}
			
				if($model->validate() && $model->executeSp() > 0)
				{
					$retrieved = true;
					
					$resultArr = DAO::queryAllSql($model->getTrxSql());

					$x = 0;
					foreach($resultArr as $result)
					{
						$modelResult[$x] = new GenXmlSettleCustody('detail');
						$modelResult[$x]->attributes = $result;
						$x++;
					}
				}
			}
			else if($scenario == 'process')
			{					
				if($valid = $model->validate())
				{
					if($model->transfer_type == 'WT')
					{
						$fileNameArr = $typeArr = array();
						$this->retrieveData($model, $resultArr, $fileNameArr, $typeArr);
						
						$x = 0;
						foreach($resultArr as $result)
						{						
							$resultContent[$x]['type'] = $typeArr[$x];
							$resultContent[$x]['xml'] = $this->getXML($result);
							$resultContent[$x]['fileName'] = $fileNameArr[$x];
							
							$x++;
						}
					}
					else
					{
						$retrieved = true;
						
						$x = 0;
						foreach($_POST['Detail'] as $row)
						{
							$modelResult[$x] = new GenXmlSettleCustody('detail');
							$modelResult[$x]->attributes = $row;
							$valid = $valid && $modelResult[$x]->validate();
							$x++;
						}
						
						if($valid)
						{
							$connection  = Yii::app()->db;
							$transaction = $connection->beginTransaction();
							
							try{
								DAO::executeSql("
									DELETE FROM T_SETTLE_TRX_CUSTODY
									WHERE settle_date = TO_DATE('$model->due_date','DD/MM/YYYY')
									AND contr_dt = TO_DATE('$model->trx_date','DD/MM/YYYY')
									AND instruction_type LIKE '%$model->transfer_type'
								");
								
								$success = true;
							}
							catch(Exception $ex)
							{
								$model->addError('error_msg', $ex->getMessage());
								$success = false;
							}
							
							if($success)
							{
								foreach($modelResult as $row)
								{
									$row->due_date = $model->due_date;
									$row->trx_date = $model->trx_date;
									$row->cre_dt = date('d/m/Y H:i:s');
									$row->user_id = Yii::app()->user->id;
									
									$success = $success && $row->save();
								}
							}
							
							if($success)
							{
								$transaction->commit();
								
								$fileNameArr = $typeArr = array();
								$this->retrieveData($model, $resultArr, $fileNameArr, $typeArr);
																				
								$x = 0;
								foreach($resultArr as $result)
								{						
									$resultContent[$x]['type'] = $typeArr[$x];
									$resultContent[$x]['xml'] = $this->getXML($result);
									$resultContent[$x]['fileName'] = $fileNameArr[$x];
									
									$x++;
								}
							}
							else 
							{
								$transaction->rollback();
							}
						}
					}
				}
			}
			else
			{
				//DOWNLOAD
				
				$content = $_POST['xmlSubmit'];
				$fileDownloadName = $_POST['fileName'];
				
			    header('Content-Description: File Transfer');
			    header('Content-Type: text/txt');
			    header('Content-Disposition: attachment; filename="'.$fileDownloadName.'"');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . strlen($content));
				ob_clean();
				flush();
			    echo $content;
				die();
			}
		}
		else 
		{
			$model->setInitAttributes();
		}

		$this->render('index',array(
			'model'=>$model,
			'modelResult'=>$modelResult,
			'resultContent'=>$resultContent,
			'resultArr'=>$resultArr,
			'retrieved'=>$retrieved,
			'scenario'=>$scenario,
		));
	}

	private function retrieveData($model, &$resultArr, &$fileNameArr, &$typeArr)
	{
		$dateArr = explode('/', $model->due_date);
		$processedDate = $dateArr[2].$dateArr[1].$dateArr[0];

		if($model->transfer_type == '%' || $model->transfer_type == 'VP')
		{
			$resultArr[] = DAO::queryAllSql($model->getTrxXMLSql('RVP'));
			$resultArr[] = DAO::queryAllSql($model->getTrxXMLSql('DVP'));
			
			$fileNameArr = array_merge($fileNameArr, array(
				$processedDate . 'RVP.otc',
				$processedDate . 'DVP.otc',
			));
			
			$typeArr = array_merge($typeArr, array('RVP','DVP'));
		}
		
		if($model->transfer_type == '%' || $model->transfer_type == 'FOP')
		{
			$resultArr[] = DAO::queryAllSql($model->getTrxXMLSql('RFOP'));
			$resultArr[] = DAO::queryAllSql($model->getTrxXMLSql('DFOP'));
			
			$fileNameArr = array_merge($fileNameArr, array(
				$processedDate . 'RFOP.otc',
				$processedDate . 'DFOP.otc',
			));
			
			$typeArr = array_merge($typeArr, array('RFOP','DFOP'));
		}
		
		if($model->transfer_type == 'WT')
		{
			//$result = DAO::queryAllSql($model->getWtXMLSql());//30 may 2017 supaya semua client dalam 1 file
			$resultArr[] = DAO::queryAllSql($model->getWtXMLSql());
            $fileNameArr = array($processedDate . '_WT.wt');
            $typeArr =array('WT');
            
			/* 30 may 2017 supaya semua client dalam 1 file
			foreach($result as $row)
			{
				$resultArr[][0] = $row;
				$fileNameArr[] = $row['external reference'] . '.wt';
				$typeArr[] = substr($row['external reference'],9);
			}*/
			
		}
	}

	private function convertColumnName($columnName)
	{
		switch($this->mode)
		{
			case static::CONVERT_COLUMN_FOR_XML:
				return lcfirst(str_replace(' ','',ucwords($columnName)));
				
			case static::CONVERT_COLUMN_FOR_VIEW:
				return ucwords($columnName);
		}
	}

	private function getXML($queryResult)
	{
		$content = "";
		
		if($queryResult)
		{
			$this->mode = static::CONVERT_COLUMN_FOR_XML;
			$columnName = array_map(array($this,'convertColumnName'),array_keys($queryResult[0]));
			
			$content .= "<Message>\r\n";
			
			foreach ($queryResult as $row) 
			{
				$content .= "\t<Record name=\"data\">\r\n";
				
				$x=0;
				foreach($row as $key=>$value)
				{
					$value = trim($value);
					$content .= "\t\t<Field name=\"{$columnName[$x++]}\">$value</Field>\r\n";
				}
				
				$content .= "\t</Record>\r\n";
			}
			
			$content .= '</Message>';
		}
		
		return $content;
	}
}
