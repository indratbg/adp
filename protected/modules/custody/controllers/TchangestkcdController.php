<?php

class TchangestkcdController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionGetstock()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_POST['term']);
      $qSearch = DAO::queryAllSql("
				Select stk_cd, stk_desc FROM MST_COUNTER 
				Where (stk_cd like '%".$term."%' OR stk_desc like '%".$term."%')
      			AND rownum <= 11
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['stk_cd']
      			, 'labelhtml'=>$search['stk_cd'].' - '.$search['stk_desc'] //WT: Display di auto completenya
      			, 'value'=>$search['stk_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }
	
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new Tchangestkcd;

		if(isset($_POST['Tchangestkcd']))
		{
			$model->attributes=$_POST['Tchangestkcd'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->stk_cd_old) > 0 ){
            	Yii::app()->user->setFlash('success', 'Successfully change '.$model->stk_cd_old);
				$this->redirect(array('/custody/tchangestkcd/index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Tchangestkcd']))
		{
			$model->attributes=$_POST['Tchangestkcd'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$id) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update '.$model->stk_cd_old);
				$this->redirect(array('/custody/tchangestkcd/index'));
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
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->stk_cd_old);
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
	
	/*
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
	 * 
	 */

	public function actionIndexprocess()
	{
		$model=new Tchangestkcd();
		
		if(isset($_GET['isproceed'])){
			$model->user_id = Yii::app()->user->id;
			if($model->executeSpChangeTicker() > 0){
				Yii::app()->user->setFlash('success', 'Successfully process ticker code change!');
			}
		}

		$this->render('indexprocess',array(
			'model'=>$model	
		));
	}
	
	public function actionIndex()
	{
		$model=new Tchangestkcd('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Tchangestkcd']))
			$model->attributes=$_GET['Tchangestkcd'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Tchangestkcd::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
