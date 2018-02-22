<?php

class UploadstockbalanceController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
	
	public function actionIndex()
	{	
	
		$model =new Tstkksei;
		$modelReport = new Rptstkksei('UPLOAD_STOCK_BALANCE','R_T_STK_KSEI','Upload_stk_balance.rptdesign');
		$url = '';
		$success=false;
	
		if(isset($_POST['Tstkksei']))
		{
			$model->attributes = $_POST['Tstkksei'];
			$model->scenario='upload';
			
			if($model->validate()){
			//buat ambil file yang di upload tanpa $_FILES
			$model->file_upload = CUploadedFile::getInstance($model,'file_upload');
			
			$path = FileUpload::getFilePath(FileUpload::UPLOAD_STOCK_BALANCE,'upload.txt' );
			$model->file_upload->saveAs($path);
			$filename = $model->file_upload;
			
			$ksei_date_char=substr($filename,-12);	
			$ksei_date=substr($ksei_date_char,0,8);
			$bal_dt = $model->date_now;
			
			if(strtotime($ksei_date) != strtotime($bal_dt))
			{
				Yii::app()->user->setFlash('danger', 'Tanggal tidak sama dengan file yang diupload');
			$success=false;
			}
			else
			{
			$success=true;	
			}
			
			//BACKUP STOCK BALACE
			if($success && $model->executeBackup()>0)
			{
				$success=true;
			}
			else 
			{
				$success=false;	
			}
		
			
			if($success)
			{	
			//insert data ke Tstkksei
			$lines = file($path);
			foreach ($lines as $line_num => $line) 
			{
				//if($line_num!=0)
				//{
					$pieces = explode('|',$line);
					
					$model->sub_rek = $pieces[0];
					$model->bal_dt = $ksei_date;
					$model->stk_cd = $pieces[2];
					$model->free = trim($pieces[4]);
					$model->qty = $pieces[1];
					$model->import_dt = new CDbExpression("TO_DATE('".date('Y-m-d H:i:s')."','YYYY-MM-DD HH24:MI:SS')");
				
						if($model->qty != '0')
						{
							$check =Tstkksei::model()->find("bal_dt = '$model->bal_dt' and sub_rek ='$model->sub_rek' and stk_cd='$model->stk_cd' and free = '$model->free' ");
							if($check)continue;
							else {
								if($model->save(FALSE))
								{
									$model = new Tstkksei();
								}//end if model save	
							}
							
						}//end qty <> 0
					//}//end line num !=0
				}//end foreach
			
			
				//setelah di upload dan dibaca, delete file nya
				//unlink(FileUpload::getFilePath(FileUpload::IMPORT_REK_DANA,$filename ));
				Yii::app()->user->setFlash('success', 'Successfully upload '.$filename);
				//$this->redirect(array('/master/import/index'));	
			
			//SHOW REPORT
			$modelReport->bal_dt = $ksei_date;
			//$modelReport->vp_userid = 
			if($modelReport->validate() && $modelReport->executeRpt()>0){
				$url=$modelReport->showReport();
			}
			
			}//end success
			}
			
			//RESET DATE
			/*	$date = date('Y-m-d',strtotime(date('Y-m-d')." -1 day"));
				do{
				$cek = Calendar::model()->find("tgl_libur = to_date('$date','yyyy-mm-dd')");
				if($cek)
				{
						$date = date('Y-m-d',strtotime("$date -1 day"));
						$days = DateTime::createFromFormat('Y-m-d',$date)->format('D');
					if($days=='Mon')
					{
						$date = date('Y-m-d',strtotime("$date -3 day"));
					}
					else if($days=='Sun')
					{
						$date = date('Y-m-d',strtotime("$date -2 day"));
					}
					else if($days=='Sat')
					{
							$date = date('Y-m-d',strtotime("$date -1 day"));
					}
				}
					$days = DateTime::createFromFormat('Y-m-d',$date)->format('D');
					if($days=='Mon')
					{
						$date = date('Y-m-d',strtotime("$date -3 day"));
					}
					else if($days=='Sun')
					{
						$date = date('Y-m-d',strtotime("$date -2 day"));
					}
					else if($days=='Sat')
					{
							$date = date('Y-m-d',strtotime("$date -1 day"));
					}
			
			}
			while($cek);
			*/
			$sql = "select get_doc_date('1',trunc(sysdate)) date_now from dual";
			$exec = DAO::queryRowSql($sql);
			$date = $exec['date_now'];
		
			if(DateTime::createFromFormat('Y-m-d H:i:s',$date))$date = DateTime::createFromFormat('Y-m-d H:i:s',$date)->format('d/m/Y');
			$model->date_now = $date;
			
			
			
			//$model->date_now = DateTime::createFromFormat('Y-m-d',$date)->format('d/m/Y');
			//END RESET DATE
			
			
			
			//}//end foreach
			}//end if isset
			else
			{
				/*
				$date = date('Y-m-d',strtotime(date('Y-m-d')." -1 day"));
		
				do{
				$cek = Calendar::model()->find("tgl_libur = to_date('$date','yyyy-mm-dd')");
				if($cek)
				{
						$date = date('Y-m-d',strtotime("$date -1 day"));
						$days = DateTime::createFromFormat('Y-m-d',$date)->format('D');
					if($days=='Mon')
					{
						$date = date('Y-m-d',strtotime("$date -3 day"));
					}
					else if($days=='Sun')
					{
						$date = date('Y-m-d',strtotime("$date -2 day"));
					}
					else if($days=='Sat')
					{
							$date = date('Y-m-d',strtotime("$date -1 day"));
					}
				}
					$days = DateTime::createFromFormat('Y-m-d',$date)->format('D');
					if($days=='Mon')
					{
						$date = date('Y-m-d',strtotime("$date -3 day"));
					}
					else if($days=='Sun')
					{
						$date = date('Y-m-d',strtotime("$date -2 day"));
					}
					else if($days=='Sat')
					{
							$date = date('Y-m-d',strtotime("$date -1 day"));
					}
			
			}
			while($cek);*/
			$sql = "select get_doc_date('1',trunc(sysdate)) date_now from dual";
			$exec = DAO::queryRowSql($sql);
			$date = $exec['date_now'];
		
			if(DateTime::createFromFormat('Y-m-d H:i:s',$date))$date = DateTime::createFromFormat('Y-m-d H:i:s',$date)->format('d/m/Y');
			$model->date_now = $date;
			
		//	$model->date_now = DateTime::createFromFormat('Y-m-d',$date)->format('d/m/Y');
				
			}
				
		$this->render('index',array('model'=>$model,
									'url'=>$url,
									'modelReport'=>$modelReport
									));
	}

	
}
