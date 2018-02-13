<?php

class BranchController extends AAdminController
{	
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	public function actionAjxCmbAccNum()
	{
		$resp['status']  = 'error';
		$arrAcctValue  	 = array();
		$arrAcctLabel  	 = array();
		
		if(isset($_POST['Branch']['bank_cd']))
		{
			$bank_cd   	  = $_POST['Branch']['bank_cd']; 
			$listBankAcct = Bankacct::model()->findAll('bank_cd=:bank_cd AND approved_stat = \'A\'',array(':bank_cd'=>$bank_cd));
		
			foreach($listBankAcct as $modelBankAcct){
				$arrAcctValue[]  = $modelBankAcct->bank_acct_cd;	
				$arrAcctLabel[] = $modelBankAcct->BankAcctCdAndBrchCd;
			}
			
			$resp['status'] = 'success';
		}
		
		
		$resp['content'] = array('acct_value'=>$arrAcctValue,'acct_label'=>$arrAcctLabel);
		echo json_encode($resp);
	}

	public function actionCreate()
	{
		$model=new Branch;

		if(isset($_POST['Branch']))
		{
			$model->attributes=$_POST['Branch'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->brch_cd) > 0 ){
            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->brch_cd);
				$this->redirect(array('/master/branch/index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Branch']))
		{
			$model->attributes=$_POST['Branch'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$id) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update '.$model->brch_cd);
				$this->redirect(array('/master/branch/index'));
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
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->brch_cd);
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
			$model = $this->loadModel($id);
			
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_CAN) < 0)
				throw new CHttpException(400,'Error '.$model->error_code.' '.$model->error_msg);

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	*/
	public function actionIndex()
	{
		$model=new Branch('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Branch']))
			$model->attributes=$_GET['Branch'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Branch::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
