<?php

class SalesController extends AAdminController
{
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new Sales;

		if(isset($_POST['Sales']))
		{
			if(isset($_POST['Sales']['lic_num'])){
				if($_POST['Sales']['lic_num'] != 'N'){
					$model->scenario = 'licensed';
				}
			}
			$model->attributes=$_POST['Sales'];
			if($model->validate() &&  $model->executeSp(AConstant::INBOX_STAT_INS) > 0 ){
				Yii::app()->user->setFlash('success', 'Successfully create '.$model->rem_cd);
				$this->redirect(array('/master/sales/index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Sales']))
		{
			$model->attributes=$_POST['Sales'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update '.$model->rem_cd);
				$this->redirect(array('/master/sales/index'));
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
		
		$model 			 = new Ttempheader();
		$model->scenario = 'cancel';
		$model1 		 = null;
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate())
			{	
				$model1    				= $this->loadModel($id);
				$model1->cancel_reason  = $model->cancel_reason;
				if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->primaryKey);
					$is_successsave = true;
				}
			}
		}

		$this->render('_popcancel',array(
			'model'=>$model,
			'model1'=>$model1,
			'is_successsave'=>$is_successsave		
		));
	}

	public function actionIndex()
	{
		$model=new Vindexsales('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Vindexsales']))
			$model->attributes=$_GET['Vindexsales'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Sales::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
