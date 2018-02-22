<?php

class SecuritiesledgerController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionView($gl_acct_cd, $ver_bgn_dt)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($gl_acct_cd, $ver_bgn_dt),
		));
	}

	public function actionCreate()
	{
		$model=new SecuritiesLedger;

		if(isset($_POST['SecuritiesLedger']))
		{
			$model->attributes=$_POST['SecuritiesLedger'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->gl_acct_cd, $model->ver_bgn_dt) > 0){
            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->gl_acct_cd);
				$this->redirect(array('/custody/securitiesledger/index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($gl_acct_cd, $ver_bgn_dt)
	{
		$model=$this->loadModel($gl_acct_cd, $ver_bgn_dt);

		if(isset($_POST['SecuritiesLedger']))
		{
			$model->attributes=$_POST['SecuritiesLedger'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$gl_acct_cd, $ver_bgn_dt) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update '.$model->gl_acct_cd);
				$this->redirect(array('/custody/securitiesledger/index'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionAjxPopDelete($gl_acct_cd, $ver_bgn_dt)
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
				
				$model1    				= $this->loadModel($gl_acct_cd, $ver_bgn_dt);
				$model1->cancel_reason  = $model->cancel_reason;
				
				if($model1->executeSp(AConstant::INBOX_STAT_CAN,$gl_acct_cd, $ver_bgn_dt) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel securities ledger');
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
	public function actionDelete($gl_acct_cd, $ver_bgn_dt)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = $this->loadModel($gl_acct_cd, $ver_bgn_dt);
			
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_CAN) < 0)
				throw new CHttpException(400,'Error '.$model->error_code.' '.$model->error_msg);

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view','gl_acct_cd'=>$gl_acct_cd,'ver_bgn_dt'=>$ver_bgn_dt));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	*/
	public function actionIndex()
	{
		$model=new SecuritiesLedger('search');
		$model->unsetAttributes();  // clear any default values
		$model->approved_stat = "A";
		if(isset($_GET['SecuritiesLedger']))
			$model->attributes=$_GET['SecuritiesLedger'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($gl_acct_cd, $ver_bgn_dt)
	{
		$model=SecuritiesLedger::model()->find("trim(gl_acct_cd) = trim('$gl_acct_cd') and to_char(ver_bgn_dt,'YYYY-MM-DD') = '$ver_bgn_dt'");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
