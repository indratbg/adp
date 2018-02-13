<?php

Class BlockController extends AAdminController
{
	public function actionUpdate($prm_cd_1,$prm_cd_2)
	{
		$model=$this->loadModel($prm_cd_1,$prm_cd_2);

		if(isset($_POST['Block']))
		{
			$model->attributes=$_POST['Block'];
			if($model->validate() && $model->executeSpBlock($model->prm_cd_1, $model->prm_cd_2) > 0){
				Yii::app()->user->setFlash('success', 'Successfully update '.$model->prm_cd_1.' '.$model->prm_cd_2);
             	$this->redirect(array('/custody/block/index'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionIndex()
	{
		$model=new Block('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Block']))
			$model->attributes=$_GET['Block'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function loadModel($prm_cd_1,$prm_cd_2)
	{
		$model=Block::model()->findByPk(array('prm_cd_1'=>$prm_cd_1,'prm_cd_2'=>$prm_cd_2));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
