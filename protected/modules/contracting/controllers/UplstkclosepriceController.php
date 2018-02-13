<?php

class UplstkclosepriceController extends AAdminController
{
	public $layout='//layouts/admin_column3';

	public function actionIndex()
	{
		// [AH] For table data
		$modelPreviews = null;
		
		$success=false;
		// [AH] For table data header label
		$modelPreviewSingle = new Tcloseprice();
		//$modelPreview=array();
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
				
				//[AR-Ganti]  Logic upload file here	
				//upload ke path insistpro/upload/upload_stk_close_price
				//upload dengan nama file bond_tanggalharini(ddmmyyyy).dbf
				//contoh : bond_01012014.dbf
				
				$date = date('dmY');
				
				$model->upload_file = 'closeprice_'.$date.'.dbf';
				
				//[AR-Ganti] Logic read file dengan nama bond_tanggalharini.dbf
				// baca file yang tadi diupload
				
				$filepath = FileUpload::getFilePath(FileUpload::UPLOAD_STK_CLOSE_PRICE,$model->upload_file);
				$upload = CUploadedFile::getInstance($model,'upload_file');
				$upload->saveAs($filepath);
				
				$table 	  = new XBaseTable($filepath);
				$table->open();
				
				$modelPreview = new Tcloseprice();
				$modelAttributes = $modelPreview->attributes;
				
				$x = 1;
				$prevCode = ''; 
				
				while ($record=$table->nextRecord()) 
				{
				    $dbfColumns = $table->getColumns();
					
					foreach ($dbfColumns as $i=>$c)
					{
						 $dbfUpKey = strtoupper(trim($c->getName()));
						 if($dbfUpKey == 'STK_CODE')
						 {
							$currentCode = $record->getString($c);
							$index = $c;
						 }
					}	
					
					//Membandingkan stk_cd record sekarang dengan yang sebelumnya
					//Bila sama, record tidak ditampilkan
					if($x == 1 || $currentCode != $prevCode)
					{
						$modelPreview  = new Tcloseprice();
						// Looping kolom dari table Tcloseprice
						foreach($modelAttributes as $key => $value)
						{
							$modelUpKey = strtoupper(trim($key));
							
							foreach ($dbfColumns as $i=>$c) 
							{
							   $dbfUpKey = strtoupper(trim($c->getName()));
							   // [AR] special case because table and dbf column not same
							   if($modelUpKey == 'STK_CD' && $dbfUpKey == 'STK_CODE')
							   {
							   	   $modelPreview->$key = $record->getString($c);
								   unset($dbfColumns[$i]);
							   }
							   // [AR] special case because table and dbf column not same
							   else if($modelUpKey == 'STK_AMT' && $dbfUpKey == 'STK_AMNT')
							   {
							   	   $modelPreview->$key = $record->getString($c);
								   unset($dbfColumns[$i]);
							   }
							   //27APR2016
							   else if($modelUpKey == 'ISIN_CODE' && $dbfUpKey == 'STK_NUM')
							   {
							   	   $modelPreview->$key = $record->getString($c);
								   unset($dbfColumns[$i]);
							   }
							   else if($modelUpKey == $dbfUpKey)
							   {
							   	   $modelPreview->$key = $record->getString($c);
								   unset($dbfColumns[$i]);
							   }
							   else if($modelUpKey == 'STK_VOLM'){//14 Apr 2015
							   	if($modelPreview->$key==null || $modelPreview==''){
							   		$modelPreview->$key=0;
								}
							   }
							    else if($modelUpKey == 'STK_ASKV'){//14 Apr 2015
							   	if($modelPreview->$key==null || $modelPreview==''){
							   		$modelPreview->$key=0;
								}
							   }
							   if($c->getType() == 'D')
							   		$modelPreview->$key = date('Y-m-d',strtotime(str_replace(' 00:00:00 +0100', '', $modelPreview->$key)));   	
						    } 
						}
						$modelPreviews[] = $modelPreview;
					}
					$prevCode = $record->getString($index);
					$x++;
				}
				Yii::app()->user->setFlash('success', 'Successfully uploaded ');
				$table->close();
	    	}
	    	else if($model->scenario == 'save')
	    	{
	    		$model->scenario = '';	
				
				$date = date('dmY');
				
				$model->upload_file = 'closeprice_'.$date.'.dbf';
							
				// [AR] etc requirement based on mantist
				/*	
				$query  = "SELECT COUNT(STK_CD) AS cnt "; 
				$query .= "FROM T_CLOSE_PRICE ";
				$query .= "WHERE STK_BIDP = 0";
								
				$stk_bidp_zero   = DAO::queryRowSql($query);
				*/
				// [AR] load file and save data
				$filepath = FileUpload::getFilePath(FileUpload::UPLOAD_STK_CLOSE_PRICE,$model->upload_file);
				$table = new XBaseTable($filepath);
				$table->open();
				
				$table2 = new XBaseTable($filepath);
				$table2->open();
				
				$modelPreview = new Tcloseprice();
				$modelAttributes = $modelPreview->attributes;
				
				$x = 1;
				$stk_bidp_zero = 0;
				$stk_clos_non_zero = 0;
				$prev_code = '';
				/*
				$sql ="SELECT COUNT(STK_CD) as cnt 	FROM T_CLOSE_PRICE WHERE STK_BIDP = 0";
				$result=DAO::queryRowSql($sql);
				$stk_bidp_zero=$result['cnt'];
				*/
				//Menghitung jumlah stk_clos dan stk_bidp yang 0 dari file yang di-upload
				$count=0;
				while($record=$table2->nextRecord())
				{
					$dbfColumns = $table2->getColumns();
					foreach ($dbfColumns as $i=>$c) 
					{
						$dbfUpKey = strtoupper(trim($c->getName()));
						if($dbfUpKey == 'STK_BIDP' && $record->getString($c) == 0)$stk_bidp_zero++;
						if($dbfUpKey == 'STK_CLOS' && $record->getString($c) != 0)$stk_clos_non_zero++;
					}
					$count++;
				}
				$stk_bidp_zero = $stk_bidp_zero/$count;
				//echo "<script type='text/javascript'>alert('$stk_bidp_zero');</script>";
				$table2->close();
				//echo "<script type='text/javascript'>alert('$z');</script>";
				
				if($stk_clos_non_zero > 0)
				{				
					while ($record=$table->nextRecord()) 
					{
						$dbfColumns = $table->getColumns();
					
						foreach ($dbfColumns as $i=>$c)
						{
							 $dbfUpKey = strtoupper(trim($c->getName()));
							 if($dbfUpKey == 'STK_CODE')
							 {
								$currentCode = $record->getString($c);
								$index = $c;
							 }
						}	
						if($x == 1 || $currentCode != $prevCode)
						{
							$modelPreview  = new Tcloseprice();					    
							foreach($modelAttributes as $key => $value)
							{
								$modelUpKey = strtoupper(trim($key));	
								foreach ($dbfColumns as $i=>$c) 
								{
								   $dbfUpKey = strtoupper(trim($c->getName()));
								   
								   // [AR] special case because table and dbf column not same
								   if($modelUpKey == 'STK_CD' && $dbfUpKey == 'STK_CODE')
								   {
								   	   $modelPreview->$key = $record->getString($c);
									   unset($dbfColumns[$i]);
								   }
								   // [AR] special case because table and dbf column not same
								   else if($modelUpKey == 'STK_AMT' && $dbfUpKey == 'STK_AMNT')
								   {
								   	   $modelPreview->$key = $record->getString($c);
									   unset($dbfColumns[$i]);
								   }
								   //27APR2016
								   else if($modelUpKey == 'ISIN_CODE' && $dbfUpKey == 'STK_NUM')
								   {
								   	   $modelPreview->$key = $record->getString($c);
									   unset($dbfColumns[$i]);
								   }
								   else if($modelUpKey == $dbfUpKey)
								   {
								   	   $modelPreview->$key = $record->getString($c);
									   unset($dbfColumns[$i]);
								   }
								   
							    else if($modelUpKey == 'STK_VOLM'){//14 Apr 2015
							   	if($modelPreview->$key==null || $modelPreview==''){
							   		$modelPreview->$key=0;
								}
							   }
							    else if($modelUpKey == 'STK_ASKV'){//14 Apr 2015
							   	if($modelPreview->$key==null || $modelPreview==''){
							   		$modelPreview->$key=0;
								}
							   }
								
							   if($c->getType() == 'D')
							   		$modelPreview->$key = date('Y-m-d',strtotime(str_replace(' 00:00:00 +0100', '', $modelPreview->$key)));
								}   	
					    	} 
							// [AR] remove data in same date by SP
							if($x == 1)$modelPreview->executeSpClosePriceDelete();$success=TRUE;
							
							// [AR-Ganti] jalankan SP yang disuru dimantis  buat insert ke table
							if($modelPreview->executeSpClosePriceInsert($stk_bidp_zero)>0){
								$success=TRUE;
							}
							else{
								$success=FALSE;
							}
						}
						
						$prevCode = $record->getString($index);
						$x++;
					}
				if($success){
					Yii::app()->user->setFlash('success', 'Successfully saved ');
				}
				else{
					Yii::app()->user->setFlash('danger',"Error Saving Data $modelPreview->error_code $modelPreview->error_msg");
				}
					
				}
				else 
				{
					Yii::app()->user->setFlash('error', 'Closing price semua nol, tidak di-save ');
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

	public function actionIndexright()
	{
		// [AH] For table data
		$modelPreviews = null;
		
		$success=false;
		// [AH] For table data header label
		$modelPreviewSingle = new Tcloseprice();
		//$modelPreview=array();
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
				
				//[AR-Ganti]  Logic upload file here	
				//upload ke path insistpro/upload/upload_stk_close_price
				//upload dengan nama file bond_tanggalharini(ddmmyyyy).dbf
				//contoh : bond_01012014.dbf
				
				$date = date('dmY');
				
				$model->upload_file = 'closeprice_'.$date.'.dbf';
				
				//[AR-Ganti] Logic read file dengan nama bond_tanggalharini.dbf
				// baca file yang tadi diupload
				
				$filepath = FileUpload::getFilePath(FileUpload::UPLOAD_STK_CLOSE_PRICE,$model->upload_file);
				$upload = CUploadedFile::getInstance($model,'upload_file');
				$upload->saveAs($filepath);
				
				$table 	  = new XBaseTable($filepath);
				$table->open();
				
				$modelPreview = new Tcloseprice();
				$modelAttributes = $modelPreview->attributes;
				
				$x = 1;
				$prevCode = ''; 
				
				while ($record=$table->nextRecord()) 
				{
				    $dbfColumns = $table->getColumns();
					
					foreach ($dbfColumns as $i=>$c)
					{
						 $dbfUpKey = strtoupper(trim($c->getName()));
						 if($dbfUpKey == 'STK_CODE')
						 {
							$currentCode = $record->getString($c);
							$index = $c;
						 }
					}	
					
					//Membandingkan stk_cd record sekarang dengan yang sebelumnya
					//Bila sama, record tidak ditampilkan
					if($x == 1 || $currentCode != $prevCode)
					{
						$modelPreview  = new Tcloseprice();
						// Looping kolom dari table Tcloseprice
						foreach($modelAttributes as $key => $value)
						{
							$modelUpKey = strtoupper(trim($key));
							
							foreach ($dbfColumns as $i=>$c) 
							{
							   $dbfUpKey = strtoupper(trim($c->getName()));
							   // [AR] special case because table and dbf column not same
							   if($modelUpKey == 'STK_CD' && $dbfUpKey == 'STK_CODE')
							   {
							   	   $modelPreview->$key = $record->getString($c);
								   unset($dbfColumns[$i]);
							   }
							   // [AR] special case because table and dbf column not same
							   else if($modelUpKey == 'STK_AMT' && $dbfUpKey == 'STK_AMNT')
							   {
							   	   $modelPreview->$key = $record->getString($c);
								   unset($dbfColumns[$i]);
							   }
							   //27APR2016
							   else if($modelUpKey == 'ISIN_CODE' && $dbfUpKey == 'STK_NUM')
							   {
							   	   $modelPreview->$key = $record->getString($c);
								   unset($dbfColumns[$i]);
							   }
							   else if($modelUpKey == $dbfUpKey)
							   {
							   	   $modelPreview->$key = $record->getString($c);
								   unset($dbfColumns[$i]);
							   }
							   else if($modelUpKey == 'STK_VOLM'){//14 Apr 2015
							   	if($modelPreview->$key==null || $modelPreview==''){
							   		$modelPreview->$key=0;
								}
							   }
							    else if($modelUpKey == 'STK_ASKV'){//14 Apr 2015
							   	if($modelPreview->$key==null || $modelPreview==''){
							   		$modelPreview->$key=0;
								}
							   }
							   if($c->getType() == 'D')
							   		$modelPreview->$key = date('Y-m-d',strtotime(str_replace(' 00:00:00 +0100', '', $modelPreview->$key)));   	
						    } 
						}
						$modelPreviews[] = $modelPreview;
					}
					$prevCode = $record->getString($index);
					$x++;
				}
				Yii::app()->user->setFlash('success', 'Successfully uploaded ');
				$table->close();
	    	}
	    	else if($model->scenario == 'save')
	    	{
	    		$model->scenario = '';	
				
				$date = date('dmY');
				
				$model->upload_file = 'closeprice_'.$date.'.dbf';
							
				// [AR] etc requirement based on mantist
				/*	
				$query  = "SELECT COUNT(STK_CD) AS cnt "; 
				$query .= "FROM T_CLOSE_PRICE ";
				$query .= "WHERE STK_BIDP = 0";
								
				$stk_bidp_zero   = DAO::queryRowSql($query);
				*/
				// [AR] load file and save data
				$filepath = FileUpload::getFilePath(FileUpload::UPLOAD_STK_CLOSE_PRICE,$model->upload_file);
				$table = new XBaseTable($filepath);
				$table->open();
				
				$table2 = new XBaseTable($filepath);
				$table2->open();
				
				$modelPreview = new Tcloseprice();
				$modelAttributes = $modelPreview->attributes;
				
				$x = 1;
				$stk_bidp_zero = 0;
				$stk_clos_non_zero = 0;
				$prev_code = '';
				/*
				$sql ="SELECT COUNT(STK_CD) as cnt 	FROM T_CLOSE_PRICE WHERE STK_BIDP = 0";
				$result=DAO::queryRowSql($sql);
				$stk_bidp_zero=$result['cnt'];
				*/
				//Menghitung jumlah stk_clos dan stk_bidp yang 0 dari file yang di-upload
				$count=0;
				while($record=$table2->nextRecord())
				{
					$dbfColumns = $table2->getColumns();
					foreach ($dbfColumns as $i=>$c) 
					{
						$dbfUpKey = strtoupper(trim($c->getName()));
						if($dbfUpKey == 'STK_BIDP' && $record->getString($c) == 0)$stk_bidp_zero++;
						if($dbfUpKey == 'STK_CLOS' && $record->getString($c) != 0)$stk_clos_non_zero++;
					}
					$count++;
				}
				$stk_bidp_zero = $stk_bidp_zero/$count;
				//echo "<script type='text/javascript'>alert('$stk_bidp_zero');</script>";
				$table2->close();
				//echo "<script type='text/javascript'>alert('$z');</script>";
				
				if($stk_clos_non_zero > 0)
				{				
					while ($record=$table->nextRecord()) 
					{
						$dbfColumns = $table->getColumns();
					
						foreach ($dbfColumns as $i=>$c)
						{
							 $dbfUpKey = strtoupper(trim($c->getName()));
							 if($dbfUpKey == 'STK_CODE')
							 {
								$currentCode = $record->getString($c);
								$index = $c;
							 }
						}	
						if($x == 1 || $currentCode != $prevCode)
						{
							$modelPreview  = new Tcloseprice();					    
							foreach($modelAttributes as $key => $value)
							{
								$modelUpKey = strtoupper(trim($key));	
								foreach ($dbfColumns as $i=>$c) 
								{
								   $dbfUpKey = strtoupper(trim($c->getName()));
								   
								   // [AR] special case because table and dbf column not same
								   if($modelUpKey == 'STK_CD' && $dbfUpKey == 'STK_CODE')
								   {
								   	   $modelPreview->$key = $record->getString($c);
									   unset($dbfColumns[$i]);
								   }
								   // [AR] special case because table and dbf column not same
								   else if($modelUpKey == 'STK_AMT' && $dbfUpKey == 'STK_AMNT')
								   {
								   	   $modelPreview->$key = $record->getString($c);
									   unset($dbfColumns[$i]);
								   }
								   //27APR2016
								   else if($modelUpKey == 'ISIN_CODE' && $dbfUpKey == 'STK_NUM')
								   {
								   	   $modelPreview->$key = $record->getString($c);
									   unset($dbfColumns[$i]);
								   }
								   else if($modelUpKey == $dbfUpKey)
								   {
								   	   $modelPreview->$key = $record->getString($c);
									   unset($dbfColumns[$i]);
								   }
								   
							    else if($modelUpKey == 'STK_VOLM'){//14 Apr 2015
							   	if($modelPreview->$key==null || $modelPreview==''){
							   		$modelPreview->$key=0;
								}
							   }
							    else if($modelUpKey == 'STK_ASKV'){//14 Apr 2015
							   	if($modelPreview->$key==null || $modelPreview==''){
							   		$modelPreview->$key=0;
								}
							   }
								
							   if($c->getType() == 'D')
							   		$modelPreview->$key = date('Y-m-d',strtotime(str_replace(' 00:00:00 +0100', '', $modelPreview->$key)));
								}   	
					    	} 
							// [AR] remove data in same date by SP
							if($x == 1)$modelPreview->executeSpClosePriceDelete();$success=TRUE;
							
							// [AR-Ganti] jalankan SP yang disuru dimantis  buat insert ke table
							if($modelPreview->executeSpClosePriceInsert($stk_bidp_zero)>0){
								$success=TRUE;
							}
							else{
								$success=FALSE;
							}
						}
						
						$prevCode = $record->getString($index);
						$x++;
					}
				if($success){
					Yii::app()->user->setFlash('success', 'Successfully saved ');
				}
				else{
					Yii::app()->user->setFlash('danger',"Error Saving Data $modelPreview->error_code $modelPreview->error_msg");
				}
					
				}
				else 
				{
					Yii::app()->user->setFlash('error', 'Closing price semua nol, tidak di-save ');
				}
				
				$table->close();
			}
			
		}
		
		$this->render('indexright',array(
			'model'=>$model,
			'modelPreviews'=>$modelPreviews,
			'modelPreviewSingle'=>$modelPreviewSingle,
		));
	}
}
