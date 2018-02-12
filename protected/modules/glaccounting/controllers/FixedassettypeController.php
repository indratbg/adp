<?php

class FixedassettypeController extends AAdminController
{	
	public function actionView($prm_cd_1,$prm_cd_2)
	{
		$model = $this->loadModel($prm_cd_1,$prm_cd_2);
		
		$model->gl_acct_db = substr($model->prm_desc2,0,4);
		$model->sl_acct_db = substr($model->prm_desc2,4,6);
		$model->gl_acct_cr = substr($model->prm_desc2,10,4);
		$model->sl_acct_cr = substr($model->prm_desc2,14,6);
		
		$this->render('view',array(
			'model'=>$model,
		));
	}

	public function actionCreate()
	{
		$model=new Fixedassettype;

		if(isset($_POST['Fixedassettype'])){
			$model->attributes=$_POST['Fixedassettype'];
			
			$menuName = 'FIXED ASSET TYPE ENTRY';
			$transaction;
			
			if($model->validate() && $model->executeSpManyHeader(AConstant::INBOX_STAT_INS,$menuName,$transaction) > 0 && $model->executeSp(AConstant::INBOX_STAT_INS, $model->prm_cd_2, 1, $transaction) > 0){
            	Yii::app()->user->setFlash('success', 'Successfully create fixed asset type');
				$this->redirect(array('/glaccounting/fixedassettype/index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($prm_cd_1,$prm_cd_2)
	{
		$model=$this->loadModel($prm_cd_1,$prm_cd_2);
		
		$model->gl_acct_db = substr($model->prm_desc2,0,4);
		$model->sl_acct_db = substr($model->prm_desc2,4,6);
		$model->gl_acct_cr = substr($model->prm_desc2,10,4);
		$model->sl_acct_cr = substr($model->prm_desc2,14,6);

		if(isset($_POST['Fixedassettype']))
		{
			$model->attributes=$_POST['Fixedassettype'];
			
			$menuName = 'FIXED ASSET TYPE ENTRY';
			$transaction;
			
			if($model->validate() && $model->executeSpManyHeader(AConstant::INBOX_STAT_UPD,$menuName,$transaction) > 0 && $model->executeSp(AConstant::INBOX_STAT_UPD, $prm_cd_2, 1, $transaction) > 0){
				Yii::app()->user->setFlash('success', 'Successfully update fixed asset type');
             	$this->redirect(array('/glaccounting/fixedassettype/index'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionAjxPopDelete($prm_cd_1,$prm_cd_2)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Tmanyheader();
		$model->scenario = 'cancel';
		$model1 = $this->loadModel($prm_cd_1,$prm_cd_2);
		
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];	
					
			if($model->validate()){
				$model1->cancel_reason  = $model->cancel_reason;
				$model1->user_id = Yii::app()->user->id;
				$model1->ip_address = Yii::app()->request->userHostAddress;
				if($model1->ip_address=="::1")
					$model1->ip_address = '127.0.0.1';
				
				$success = false;
				$transaction;
				$menuName = 'FIXED ASSET TYPE ENTRY';
				if($model1->executeSpManyHeader(AConstant::INBOX_STAT_CAN,$menuName,$transaction) > 0)$success = true;
				
				if($success && $model1->executeSp(AConstant::INBOX_STAT_CAN,$prm_cd_2,1,$transaction) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->prm_cd_2);
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

	public function actionDelete($prm_cd_1,$prm_cd_2)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($prm_cd_1,$prm_cd_2)->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
		$model=new Fixedassettype('search');
		$model->unsetAttributes();  // clear any default values
		$model->prm_cd_1 = 'FASSET';
		$model->approved_stat = 'A';

		if(isset($_GET['Fixedassettype']))
			$model->attributes=$_GET['Fixedassettype'];
			

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($prm_cd_1,$prm_cd_2)
	{
		$model=Fixedassettype::model()->findByPk(array('prm_cd_1'=>$prm_cd_1,'prm_cd_2'=>$prm_cd_2));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
