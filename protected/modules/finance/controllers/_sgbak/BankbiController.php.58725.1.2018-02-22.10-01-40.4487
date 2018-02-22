<?php

class BankbiController extends AAdminController
{
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
		{
			$model=new Bankbi;
			if(isset($_POST['Bankbi'])){
				$model->attributes=$_POST['Bankbi'];
				if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->bi_code) > 0 ){
	            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->bi_code.' '.$model->bank_name);
					$this->redirect(array('/finance/bankbi/index'));
	            }
			}
	
			$this->render('create',array(
				'model'=>$model,
			));
		}
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if(isset($_POST['Bankbi']))
		{
			$model->attributes=$_POST['Bankbi'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$id) > 0 ){
				Yii::app()->user->setFlash('success', 'Successfully update '.$model->bi_code.' '.$model->bank_name);
             	$this->redirect(array('/finance/bankbi/index'));
			    //$this->redirect(array('view','prm_cd_1'=>$model->prm_cd_1,'prm_cd_2'=>$model->prm_cd_2));
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
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->bi_code);
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

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
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
		$model=new Bankbi('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bankbi']))
			$model->attributes=$_GET['Bankbi'];

		$this->render('index',array(
			'model'=>$model,
		));
		$id=$model->bi_code;
	}


	/**
	 * Manages all models.
	 */

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Bankbi the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Bankbi::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Bankbi $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bankbi-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
