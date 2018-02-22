<?php

class TbankbalanceController extends AAdminController
{
	public $layout = '//layouts/admin_column3';
	
	public function actionAjxValidateFinance() //LO: The purpose of this 'empty' function is to check whether an user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}
		public function actionAjxValidateCs() //LO: The purpose of this 'empty' function is to check whether an user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}
	public function actionIndex()
	{
		$model = new Tbankbalance;
		$modelData = new Tfundbalbank;
		//$btn_import1 = Sysparam::model()->find("PARAM_ID='BANK BALANCE' AND PARAM_CD1='IMPORT' AND PARAM_CD2='FINANCE' ");
		//$btn_import2 = Sysparam::model()->find("PARAM_ID='BANK BALANCE' AND PARAM_CD1='IMPORT' AND PARAM_CD2='CS' ");
		$modelReport = new Rptreconrdi('RECONCILE_RDI','R_RECON_RDI','Reconcile_rdi.rptdesign');
		$model->end_date = date('d/m/Y');
		$model->reconcile_with='0';
		$model->bankid = Fundbank::model()->find(" default_flg='Y' ")->bank_cd;
		$url='';
		$success = FALSE;
		if(isset($_POST['Tbankbalance']))
		{
			$model->attributes = $_POST['Tbankbalance'];
			$scenario = $_POST['scenario'];
			if($scenario =='import1')
			{
				$model->scenario='upload';
				if($model->validate())
				{
					
					if($model->executeSpImportDelete()>0)
					{
						$success=true;
					}
					else 
					{
						$success=FALSE;	
					}
					
					//buat ambil file yang di upload tanpa $_FILES
					$model->file_upload = CUploadedFile::getInstance($model,'file_upload');
					$path = FileUpload::getFilePath(FileUpload::IMPORT_BANK_BALANCE,'upload.txt' );
					$model->file_upload->saveAs($path);
					$filename = $model->file_upload;
					$model->user_id = Yii::app()->user->id;
					$lines = file($path);
					foreach ($lines as $line_num => $line) 
					{
						$piece = explode('	', $line);
						
						if(count($piece) !=4)
						{
							$success=false;
							$model->addError('tanggalefektif', 'Delimiter not valid');
							break;
						}
						else 
						{
							$success=true;
						}
						/*
						$length_nama = strlen(trim($piece[0]));
						$length_num = strlen(trim($piece[1]));
						$selisih = $length_nama-$length_num;
						
						if(strpos(trim($piece[0]), trim($piece[1]) ))
						{
							$nama = substr(trim($piece[0]),0,$selisih);	
							$nama = trim(str_replace('-','', $nama));
						}
						else 
						{*/
							$nama = substr(trim($piece[0]),0,50);
						//}
						
						$nama = str_replace('"','', $nama);
						if(strlen($nama)>50)
						{
							$success=false;
							$model->addError('namanasabah', 'Nama Nasabah terlalu panjang '.$nama);
							break;
						}
					
						$balance = str_replace('"', '', $piece[2]);
						$modelData = new Tfundbalbank;
						$modelData->status_dt = $model->end_date;
						$modelData->nama = $nama;
						if (trim($piece[3])=='BNGA3' && strlen($piece[1])=='13' && substr($piece[1], 0,1)=='0')
						{
							$rdn = substr($piece[1], 1);
						}
						else
						{
							$rdn = $piece[1];
						}
						 
						$modelData->rdi_num = $rdn;
						$modelData->balance = str_replace(',', '', $balance);
						$modelData->user_id = $model->user_id;
						$modelData->cre_dt = date('Y-m-d H:i:s');
						$modelData->bank_timestamp = '';
						$modelData->rdi_bank_cd = trim($piece[3]);
						if($modelData->save(false))
						{
							$modelData = new Tfundbalbank;
						}
					}
					if($success)
					{
						Yii::app()->user->setFlash('success', 'Successfully import '.$filename);
						$this->redirect(array('index'));
					}
						
				}
				
			}
			else if($scenario =='import2')
			{
				$model->scenario='upload';
				if($model->validate())
				{
					//buat ambil file yang di upload tanpa $_FILES
					$model->file_upload = CUploadedFile::getInstance($model,'file_upload');
					$path = FileUpload::getFilePath(FileUpload::IMPORT_BANK_BALANCE,'upload.txt' );
					$model->file_upload->saveAs($path);
					$filename = $model->file_upload;
					$lines = file($path);
					$model->user_id = Yii::app()->user->id;
					foreach ($lines as $line_num => $line) 
					{
						$bank_cd = substr(trim($line),-5);
						$sql = "SELECT COLFMT 
								 FROM T_FUND_BANK_FORMAT
								 where bank_cd = '$bank_cd'
								 and line_type = 'BAL'
								 and coltype = 'DELIM'";
						$cek = DAO::queryRowSql($sql);
						if(!$cek)
						{
							Yii::app()->user->setFlash('danger', 'Failed upload file, delimiter not found');
							break;
						} 		 		 
						
						$data = $line;
						if($model->executeSpImport($bank_cd, $data)>0)
						{
							$success=true;
						}
						else 
						{
							$success=FALSE;
						}
					}
					if($success)
					{
						Yii::app()->user->setFlash('success', 'Successfully import '.$filename);
						$this->redirect(array('index'));
					}
				}
			}
			else if($scenario =='reconcile')
			{
					$model->scenario = 'reconcile';	
				if($model->validate())
				{
					$modelReport->bank_cd = $model->bankid;
					$modelReport->end_date = $model->end_date;
					$modelReport->pembulatan = $model->reconcile_with=='0'?'N':'Y';
					if($modelReport->validate() && $modelReport->executeReportGenSp()>0)
					{	
						$url = $modelReport->showReport().'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					}	
				}
			}
		
		} 
if(DateTime::createFromFormat('Y-m-d',$model->end_date))$model->end_date = DateTime::createFromFormat('Y-m-d',$model->end_date)->format('d/m/Y');		
		$this->render('index',array('model'=>$model,
									'modelReport'=>$modelReport,
									//'btn_import1'=>$btn_import1,
									//'btn_import2'=>$btn_import2,
									'url'=>$url));
	}

}

