<?php

class TwhdrcahsexceptController extends AAdminController
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
		$model=new Twhdrcahsexcept;

		if(isset($_POST['Twhdrcahsexcept']))
		{
			$model->attributes=$_POST['Twhdrcahsexcept'];
			if($model->save()){
            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->client_cd);
				$this->redirect(array('view','id'=>$model->client_cd));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Twhdrcahsexcept']))
		{
			$model->attributes=$_POST['Twhdrcahsexcept'];
				$sql="update T_WHDR_CASH_EXCEPT set CLIENT_CD = '$model->client_cd'  where client_cd = '$id' ";
				$exec = DAO::executeSql($sql);
				
                Yii::app()->user->setFlash('success', 'Successfully update '.$model->client_cd);
				$this->redirect(array('index'));
				
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		//if(Yii::app()->request->isPostRequest)
		//{
			//$this->loadModel($id);

				$sql="delete from T_WHDR_CASH_EXCEPT where client_cd = '$id' ";
				$exec = DAO::executeSql($sql);
 			  Yii::app()->user->setFlash('success', 'Successfully delete '.$id);
				$this->redirect(array('index'));
			// if(!isset($_GET['ajax']))
				// $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
		// }
		// else
			// throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
		$model=new Twhdrcahsexcept('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Twhdrcahsexcept']))
			$model->attributes=$_GET['Twhdrcahsexcept'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Twhdrcahsexcept::model()->find("client_cd = '$id' ");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
