<?php

class HighrisknameController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';
	
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new Highriskname;

		if(isset($_POST['Highriskname']))
		{
			$model->attributes=$_POST['Highriskname'];
			$success = false;
			if($model->validate()){
				$transaction;
				$menuName = 'HIGHRISK NAME';
				
				if($model->executeSpManyHeader(AConstant::INBOX_STAT_INS,$menuName,$transaction) > 0){
					$success = true;
				}else{
					$success = false;
					$transaction->rollback();
				}
				
				if($success && $model->executeSp(AConstant::INBOX_STAT_INS,null,1,$transaction) > 0){
					$success = true;
				}else{
					$success = false;
					$transaction->rollback();
				}
			}
			if($success){
				$transaction->commit();
				Yii::app()->user->setFlash('success', 'Successfully create '.$model->name);
				$this->redirect(array('/master/highriskname/index'));
			}
			/*
			if($model->validate()&& $model->executeSP(AConstant::INBOX_STAT_INS,$model->name) > 0){
            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->name);
				//$this->redirect(array('view','name'=>$model->name,'kategori'=>$model->kategori));
				$this->redirect(array('/master/highriskname/index'));
            }*/
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Highriskname']))
		{
			/*
			$model->attributes=$_POST['Highriskname'];
			if($model->validate()&& $model->executeSP(AConstant::INBOX_STAT_UPD,$name) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update '.$model->name);
				//$this->redirect(array('view','name'=>$model->name,'kategori'=>$model->kategori));
				$this->redirect(array('/master/highriskname/index'));
            }
			 *
			 */
			
			$model->attributes=$_POST['Highriskname'];
			$success = false;
			if($model->validate()){
				$transaction;
				$menuName = 'HIGHRISK NAME';
				
				if($model->executeSpManyHeader(AConstant::INBOX_STAT_UPD,$menuName,$transaction) > 0){
					$success = true;
				}else{
					$success = false;
					$transaction->rollback();
				}
				
				if($success && $model->executeSp(AConstant::INBOX_STAT_UPD,$id,1,$transaction) > 0){
					$success = true;
				}else{
					$success = false;
					$transaction->rollback();
				}
			}
			if($success){
				$transaction->commit();
				Yii::app()->user->setFlash('success', 'Successfully update '.$model->name);
				$this->redirect(array('/master/highriskname/index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionAjxPopDelete($id)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		$model1 = null;
		$flag = false;
		
		$model  = new Tmanyheader();
		$model->scenario = 'cancel';
		
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];	
			if($model->validate()){	
				$model1    				= $this->loadModel($id);
				$model1->cancel_reason  = $model->cancel_reason;
				$flag = true;
				/*
				if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$name)>0){ 
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->name);
					$is_successsave = true;
				}
				*/
				$success = false;
				$transaction;
				$menuName = 'HIGHRISK NAME';
				
				if($model1->executeSpManyHeader(AConstant::INBOX_STAT_CAN,$menuName,$transaction) > 0){
					$success = true;
				}else{
					$success = false;
					$transaction->rollback();
				}
				
				if($success && $model1->executeSp(AConstant::INBOX_STAT_CAN,$id,1,$transaction) > 0){
					$success = true;
				}else{
					$success = false;
					$transaction->rollback();
				}
				if($success){
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->name);
					$is_successsave = true;
				}
			}
				
		}

		$this->render('_popcancel',array(
			'model'=>$model,
			'flag'=>$flag,
			'model1'=>$model1,
			'is_successsave'=>$is_successsave		
		));
	}
	
	public function actionUpload(){
			
		$counter = 1;
		$model = new UploadXls;
		$model->unsetAttributes();
		$model->scenario = '';
		$modelh = new Highriskname;
		if(isset($_POST['UploadXls']))
		{
			$model->attributes = $_POST['UploadXls'];
			$modelh->attributes = $_POST['Highriskname'];
			
			
			if($model->scenario == '' && $model->validate())
			{
				$model->scenario = 'save';

				$filepath = FileUpload::getFilePath(FileUpload::UPLOAD_T_HIGHRISK_NAME,'highrisk.xls');

				$upload = CUploadedFile::getInstance($model,'upload_file');
				$upload->saveAs($filepath);
				
				//Yii::import('application.vendors.PHPExcel',true);
				//$objReader = new PHPExcel_Reader_Excel5;
				$objExcel = XPHPExcel::createPHPExcel();
				$objReader = new PHPExcel_Reader_Excel5;
				//$objPHPExcel = $objReader->load(@$_FILES['xls']['tmp_name']);
				$objPHPExcel = $objReader->load($filepath);
	            $objWorksheet = $objPHPExcel->getActiveSheet();
	            $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
	            $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
	            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); //
	           
	           
	            $success = false;
				$transaction;
				$menuName = 'HIGHRISK NAME';
				$modelh->user_id = Yii::app()->user->id;
				$ip = Yii::app()->request->userHostAddress;
				if($ip=="::1")
					$ip = '127.0.0.1';
				$modelh->ip_address = $ip;
				
				if($modelh->executeSpManyHeader(AConstant::INBOX_STAT_INS,$menuName,$transaction) > 0){
					$success = true;
				}else{
					$success = false;
					$transaction->rollback();
				}
				/*
				if($success && $model->executeSp(AConstant::INBOX_STAT_INS,null,1,$transaction) > 0){
					$success = true;
				}else{
					$success = false;
					$transaction->rollback();
				}
				if($success){
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully create '.$model->name);
					$this->redirect(array('/master/highriskname/index'));
				}
				*/
				
				if($success){
		            for($i=2; $i<= $highestRow; $i++){
					 	$modelh->name = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue(); //and so on as per your excel column //save your model
					 	//$modelh->kategori = 'CUSTOMER';
						$modelh->country = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
						$modelh->birth = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
						$modelh->address = $objWorksheet->getCellByColumnAndRow(3, $i)->getValue();
						$modelh->descrip = $objWorksheet->getCellByColumnAndRow(4, $i)->getValue();
						$modelh->ref_date = date('Y-m-d');
						//var_dump($modelh->country);
						//die();
						/*
						if($modelh->validate() && $modelh->executeSP(AConstant::INBOX_STAT_INS,$modelh->name) > 0){
							$counter++;
						}else{
							break;
							//var_dump($modelh->error_msg);
							//die();
						}
						 * 
						 */
						 if($success && $modelh->executeSp(AConstant::INBOX_STAT_INS,null,$counter,$transaction) > 0){
							$success = true;
							$counter++;
						}else{
							$success = false;
							break;
							$transaction->rollback();
						}
					}
				}
				//unlink($filepath);
				if($success){
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully upload highrisk names. '.($counter-1).' data uploaded');
					$this->redirect(array('/master/highriskname/index'));
				}
				
				//var_dump($highestRow);
				//die();
				//if($counter == $highestRow){
				//	Yii::app()->user->setFlash('success', 'Successfully upload '.$model->upload_file);
				//}
				$model->unsetAttributes();
			}
		}
		 $this->render('upload',array(
			'model'=>$model,
			'modelh'=>$modelh	
		));
	}

	public function actionIndex()
	{
		$model=new Highriskname('search');
		$model->unsetAttributes();  // clear any default values
		$model->approved_stat = 'A';

		if(isset($_GET['Highriskname']))
			$model->attributes=$_GET['Highriskname'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function loadModel($id)
	{
		//$model=Highriskname::model()->findByPk(array('name'=>$name,'kategori'=>$kategori));
		//$model=Highriskname::model()->find("name= '$name' AND kategori = '$kategori'");
		$model = Highriskname::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
