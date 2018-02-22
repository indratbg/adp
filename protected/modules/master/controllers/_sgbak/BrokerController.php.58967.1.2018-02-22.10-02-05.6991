<?php

class BrokerController extends AAdminController
{

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}


	public function actionCreate()
	{
		$model=new Broker;
		if(isset($_POST['Broker'])){
			$model->attributes=$_POST['Broker'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->broker_cd) > 0 ){
	           	Yii::app()->user->setFlash('success', 'Successfully create '.$model->broker_cd.' '.$model->broker_name);
				$this->redirect(array('/master/broker/index'));
	           }
		}
	
		$this->render('create',array(
			'model'=>$model
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Broker']))
		{
			$model->attributes=$_POST['Broker'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$id) > 0 ){
				Yii::app()->user->setFlash('success', 'Successfully update '.$model->broker_cd.' '.$model->broker_name);
             	$this->redirect(array('/master/broker/index'));
			}
		}

		$this->render('update',array(
			'model'=>$model
		));
	}

	 public function actionAjxPopDelete($id)
	 {
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Ttempheader();
		$model1 = null;
		$model->scenario = 'cancel';
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate()){
				
				$model1    				= $this->loadModel($id);
				$model1->cancel_reason  = $model->cancel_reason;
					
				if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$id) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->broker_cd);
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
	 
	 
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Broker('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Broker']))
			$model->attributes=$_GET['Broker'];
		$this->render('index',array(
			'model'=>$model
		));
		$id=$model->broker_cd;
	}
	

	/**
	 * Manages all models.
	 */

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Broker the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Broker::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Broker $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='broker-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
