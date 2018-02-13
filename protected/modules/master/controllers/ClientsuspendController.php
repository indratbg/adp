<?php

class ClientsuspendController extends AAdminController
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
		$model=new Clientsuspend;

		if(isset($_POST['Clientsuspend']))
		{
			$model->attributes=$_POST['Clientsuspend'];
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
		
		if(isset($_POST['Clientsuspend']))
		{
			$model->attributes=$_POST['Clientsuspend'];
			
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->client_birth_dt))$model->client_birth_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model->client_birth_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->acct_open_dt))$model->acct_open_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model->acct_open_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->next_rollover_dt))$model->next_rollover_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model->next_rollover_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->ac_expiry_dt))$model->ac_expiry_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model->ac_expiry_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->commit_fee_dt))$model->commit_fee_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model->commit_fee_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->roll_fee_dt))$model->roll_fee_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model->roll_fee_dt)->format('Y-m-d');
				
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->init_deposit_efek_date))$model->init_deposit_efek_date=DateTime::createFromFormat('Y-m-d G:i:s' ,$model->init_deposit_efek_date)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model->closed_date))$model->closed_date=DateTime::createFromFormat('Y-m-d G:i:s',$model->closed_date)->format('Y-m-d');
				
				if($model->susp_stat =='Y'){
					$model->susp_stat='N';
				}
				else{
					$model->susp_stat='Y';
				}
				
				
			if($model->validate() && $model->executeSpSuspend(AConstant::INBOX_STAT_UPD,$id) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update '.$model->client_cd);
				$this->redirect(array('index','id'=>$model->client_cd));
            }
		}	$model->status=$model->susp_stat;
			$model->susp_trx='A';
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
		$model=new Clientsuspend('search');
		$model->unsetAttributes();  // clear any default values
		$model->approved_stat='A';
		$model->susp_stat  ='<>C';
		$model->client_type_1 ='<>B';
		
		if(isset($_GET['Clientsuspend']))
			$model->attributes=$_GET['Clientsuspend'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Clientsuspend::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
