<?php

class BankacctController extends AAdminController
{
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new Bankacct;

		if(isset($_POST['Bankacct']))
		{
			$model->attributes=$_POST['Bankacct'];
			if($model->save()){
            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->bank_cd);
				$this->redirect(array('view','id'=>$model->bank_cd));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Bankacct']))
		{
			$model->attributes=$_POST['Bankacct'];
			if($model->save()){
                Yii::app()->user->setFlash('success', 'Successfully update '.$model->bank_cd);
				$this->redirect(array('view','id'=>$model->bank_cd));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
		$model=new Bankacct('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Bankacct']))
			$model->attributes=$_GET['Bankacct'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Bankacct::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
