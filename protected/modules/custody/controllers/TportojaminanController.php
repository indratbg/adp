<?php

class TportojaminanController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionView($from_dt,$client_cd,$stk_cd)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($from_dt,$client_cd,$stk_cd),
		));
	}

	public function actionCreate()
	{
		$model=new Tportojaminan;

		if(isset($_POST['Tportojaminan']))
		{
			$model->attributes=$_POST['Tportojaminan'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS, $model->from_dt, $model->client_cd, $model->stk_cd) > 0){
            	Yii::app()->user->setFlash('success', 'Successfully create Portofolio yang Dijaminkan');
				$this->redirect(array('/custody/tportojaminan/index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($from_dt,$client_cd,$stk_cd)
	{
		$model=$this->loadModel($from_dt,$client_cd,$stk_cd);
		
		$from_dt = DateTime::createFromFormat('Y-m-d G:i:s',$from_dt)->format('Y-m-d');

		if(isset($_POST['Tportojaminan']))
		{
			$model->attributes=$_POST['Tportojaminan'];
						
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD, $from_dt, $client_cd, $stk_cd) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update Portofolio yang Dijaminkan');
				$this->redirect(array('/custody/tportojaminan/index'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionAjxPopDelete($from_dt,$client_cd,$stk_cd)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model1 = NULL;
		$model  = new Ttempheader();
		$model->scenario = 'cancel';
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate()){
				
				$model1    				= $this->loadModel($from_dt,$client_cd,$stk_cd);
				$model1->cancel_reason  = $model->cancel_reason;
				
				if(DateTime::createFromFormat('Y-m-d G:i:s',$from_dt))$from_dt=DateTime::createFromFormat('Y-m-d G:i:s',$from_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->from_dt))$model1->from_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model1->from_dt)->format('Y-m-d');
				
				$model1->validate();
				
				if($model1->executeSp(AConstant::INBOX_STAT_CAN,$from_dt,$client_cd,$stk_cd) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel IPO Stock');
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
		$model=new Tportojaminan('search');
		$model->unsetAttributes();  // clear any default values
		
		$model->approved_stat = 'A';

		if(isset($_GET['Tportojaminan']))
			$model->attributes=$_GET['Tportojaminan'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($from_dt,$client_cd,$stk_cd)
	{
		$model=Tportojaminan::model()->findByPk(array('from_dt'=>$from_dt,'client_cd'=>$client_cd,'stk_cd'=>$stk_cd));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
