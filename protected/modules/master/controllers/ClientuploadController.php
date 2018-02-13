<?php 

class ClientuploadController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model = new Clientupload;
		$modelTable = '';
		$processedFlg = isset($_GET['processedFlg'])?$_GET['processedFlg']:false;
		
		if(isset($_POST['Clientupload']))
		{
			$model->attributes = $_POST['Clientupload'];
			
			if($model->mode == 1)
			{
				$model->scenario = 'upload';
				
				if($model->validate())
				{
					$model->source_file = CUploadedFile::getInstance($model,'source_file');
					
					/*if(!($extension = $model->source_file->getExtensionName()))$extension = 'xls';
						
					$fileName = 'upload/client_upload/client_'.date('YmdHis').substr((string)microtime(), 2, 6).'.'.$extension;
					$model->source_file->saveAs($fileName);*/
					
					$excelType = $model->source_file->getExtensionName() == 'xlsx' ? 'Excel2007' : 'Excel5';
					XPHPExcel::init();
					$objReader = PHPExcel_IOFactory::createReader($excelType);
					//$objReader->setReadDataOnly(true);
					$objReader->setLoadSheetsOnly('INTERNAL'); 
					$objPHPExcel = $objReader->load($model->source_file->getTempName());
                   
					$objSheet = $objPHPExcel->getActiveSheet();
					$highestRow = $objSheet->getHighestRow();
					$highestColumn = $objSheet->getHighestColumn();
					$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
					$modelTable = new Tclientupload;
					$uploadDate = date('d/m/Y');				
					$excelColumnNameArr = array();
					
					for($col=0;$col<=$highestColumnIndex;$col++)
					{
						$excelColumnNameArr[$col] = strtolower(trim($objSheet->getCellByColumnAndRow($col, 1)->getValue()));
					}
					
					$success = true;
					
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					$err_msg='';
					for($row=2;$row<=$highestRow;$row++)
					{
						$modelTable->isNewRecord = true;
						$modelTable->scenario = 'insert';
						$modelTable->unsetAttributes();
						
						for($col=0;$col<=$highestColumnIndex;$col++)
						{
							$cell = $objSheet->getCellByColumnAndRow($col, $row);
							$value = $cell->getValue();
							
							if(PHPExcel_Shared_Date::isDateTime($cell)) 
							{
								$value = date('d/m/Y', PHPExcel_Shared_Date::ExcelToPHP($value)); 
							}
							if($excelColumnNameArr[$col]== 'subrek' && PHPExcel_Shared_Date::isDateTime($cell) && strlen($value)<14)
                            {
                                $err_msg='Kolom subrek pada excel tidak boleh format date (subrek harus format general)';
                            }
							$modelTable->setAttribute($excelColumnNameArr[$col], $value);
						}
						
						$modelTable->upload_date = $uploadDate;
						$modelTable->xml_flg = 'N';
						
						try{
                           $cek = Tclientupload::model()->find("subrek = '$modelTable->subrek' ");
                           if($cek)
                            {
                                $err_msg='Data '.$modelTable->subrek.' '.$modelTable->client_name.' , sudah pernah diupload sebelumnya';
                                $success = false;
                                break;
                            }
                            if(strlen($modelTable->subrek)<14)
                            {
                                $err_msg='Subrek '.$modelTable->client_name. ' tidak valid ,'.$err_msg;
                                $success = false;
                                break;
                            }
                            
							if(!$modelTable->save())
							{
								// Validation fail
								$success = false;
								break;
							}
                              
                            
						}
						catch(Exception $ex)
						{
							// Insert fail
							
							$success = false;
							$modelTable->addError('source_file',$err_msg?$err_msg:$ex->getMessage());
							break;
						}

					}
					
					if($success)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Upload successful');
						$this->redirect(array('index'));
					}
					else 
					{
						$transaction->rollback();
                        $err_msg?Yii::app()->user->setFlash('danger', $err_msg):'';
					}
				}
			}
			else 
			{
				if($model->batch == '')$model->batch = '%';
			
				if($model->validate() && $model->executeSp() > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully processed');
					$this->redirect(array('/master/clientupload/index','processedFlg'=>true));
				}
				
				if($model->batch == '%')$model->batch = '';
			}
			
		}
		else 
		{
			$model->mode = 1;
		}
		
		$this->render('index',array(
			'model'=>$model,
			'modelTable'=>$modelTable,
			'processedFlg'=>$processedFlg
		));
	}
}
