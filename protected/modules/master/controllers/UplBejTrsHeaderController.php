<?php

class UplBejTrsHeaderController extends AAdminController
{
	public $layout='//layouts/admin_column2';

	public function actionIndex()
	{
		// [AH] For table data
		$modelPreviews = null;
		
		// [AH] For table data header label
		$modelPreviewSingle = new Bejtrsheader();
		
		// [AH] For form
		$model = new UploadDbf();
		$model->unsetAttributes();
		$model->scenario = '';
		
		if(isset($_POST['UploadDbf']))
		{
			$model->attributes = $_POST['UploadDbf'];	
			
			if($model->scenario == '' && $model->validate())
			{
				$model->scenario = 'save';
				
				$date = date('dmY');
				
				$model->upload_file = 'dte_'.$date.'.dbf';
				
				$filepath = FileUpload::getFilePath(FileUpload::BEJ_TRS_HEADER,$model->upload_file);
				$upload = CUploadedFile::getInstance($model,'upload_file');
				$upload->saveAs($filepath);
				
				$table 	  = new XBaseTable($filepath);
				$table->open();
				
				$modelPreview = new Bejtrsheader();
				$modelAttributes = $modelPreview->attributes;
				
				$x = 1;
				$prevCode = ''; 
								
				while ($record=$table->nextRecord()) 
				{
			   		
					$dbfColumns = $table->getColumns();
					foreach ($dbfColumns as $i=>$c)
					{
						 $dbfUpKey = strtoupper(trim($c->getName()));
						 if($dbfUpKey == 'TRX_CODE')
						 {
							$currentCode = $record->getString($c);
							$index = $c;
						 }
					}	
					// Looping kolom dari table Bejtrsheader
					if($x == 1 || $currentCode != $prevCode)
					{
						$modelPreview = new Bejtrsheader();
						foreach($modelAttributes as $key => $value)
						{
							$modelUpKey = strtoupper(trim($key));
							
							foreach ($dbfColumns as $i=>$c) 
							{
							   $dbfUpKey = strtoupper(trim($c->getName()));
							   if($modelUpKey == $dbfUpKey)
							   {
							   	   $modelPreview->$key = $record->getString($c);
								   
								   if($c->getType() == 'D')
							   			$modelPreview->$key = date('Y-m-d',strtotime(str_replace(' 00:00:00 +0100', '', $modelPreview->$key)));  
								   unset($dbfColumns[$i]);
							   }
						    } 
						}
						$modelPreviews[] = $modelPreview;
					}
					$prevCode = $record->getString($index);
					$x++;
				}
				$table->close();
				Yii::app()->user->setFlash('success', 'Successfully uploaded ');
				
		   	}
	    	else if($model->scenario == 'save')
	    	{
	    		
	    		$model->scenario = '';	
				
				$date = date('dmY');
				
				$model->upload_file = 'dte_'.$date.'.dbf';
							
				// [AR] etc requirement based on mantist
						
				// [AR] load file and save data
				$filepath = FileUpload::getFilePath(FileUpload::BEJ_TRS_HEADER,$model->upload_file);
				$table = new XBaseTable($filepath);
				$table->open();
				
				$modelPreview = new Bejtrsheader();
				$modelAttributes = $modelPreview->attributes;
				
				$x = 1;
				$diffDate = FALSE;	
				
				while($record = $table->nextRecord())
				{
					$dbfColumns = $table->getColumns();				
					foreach ($dbfColumns as $i=>$c) 
					{
						$dbfUpKey = strtoupper(trim($c->getName()));
						if($dbfUpKey == 'TRX_DATE' && date('Y-m-d',strtotime(str_replace(' 00:00:00 +0100', '',$record->getString($c)))) != date('Y-m-d'))$diffDate = TRUE;
						
					}
					break;
				}

				$table->close();
				$table->open();
				$x = 1;
				$prevCode = ''; 
				
				//INSERT jika date di file = sysdate				
				if(!$diffDate)
				{
					//$z = Yii::app()->user->id;
					//echo "<script type='text/javascript'>alert('$z');</script>";
					//$query = "DELETE FROM LOTSFO.BEJ_TRS_HEADER";
					//$obj = Bejtrsheader::model()->findAll();
					//if(!empty($obj))Bejtrsheader::model()->deleteAll();
					Bejtrsheader::model()->deleteAll();
					//DAO::executeSql($query);
					
					while ($record=$table->nextRecord()) 
					{
						$dbfColumns = $table->getColumns();
						foreach ($dbfColumns as $i=>$c)
						{
							 $dbfUpKey = strtoupper(trim($c->getName()));
							 if($dbfUpKey == 'TRX_CODE')
							 {
								$currentCode = $record->getString($c);
								$index = $c;
							 }
						}
						
						if($x == 1 || $currentCode != $prevCode)
						{
							$modelPreview 		= new Bejtrsheader();
							foreach($modelAttributes as $key => $value)
							{
								$modelUpKey = strtoupper(trim($key));	
								foreach ($dbfColumns as $i=>$c) 
								{
								    $dbfUpKey = strtoupper(trim($c->getName()));
								  	if($modelUpKey == $dbfUpKey)
								  	{
								   	   $modelPreview->$key = $record->getString($c);
									   
									   if($c->getType() == 'D')
								   	   		$modelPreview->$key = date('Y-m-d',strtotime(str_replace(' 00:00:00 +0100', '', $modelPreview->$key)));  
									   unset($dbfColumns[$i]);
								   	} 	
						    	} 
							}
							$modelPreview->save(FALSE);
						}
						$prevCode = $record->getString($index);
						$x++;
					}
					$modelPreview->executeSpBejTransUpload();
					Yii::app()->user->setFlash('success', 'Successfully saved ');
				}
				else 
				{
					Yii::app()->user->setFlash('error', 'Tanggal di file tidak sama dengan tanggal hari ini, tidak di-save ');
				}
				
				$table->close();
			}
			
		}
		
		$this->render('index',array(
			'model'=>$model,
			'modelPreviews'=>$modelPreviews,
			'modelPreviewSingle'=>$modelPreviewSingle,
		));
	}
}
