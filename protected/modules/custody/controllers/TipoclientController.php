<?php

class TipoclientController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionView($client_cd,$stk_cd)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($client_cd,$stk_cd),
		));
	}

	public function actionAjxGetBrchCd()
	{
		$resp['status']  = 'error';
		//$arrValue  	 = array();
		//echo "<script>alert('1');</script>";
		if(isset($_POST['client_cd']))
		{
			$client_cd = $_POST['client_cd']; 
			$client = Client::model()->find('client_cd=:client_cd',array(':client_cd'=>$client_cd));
			
			$branch_code = $client->branch_code;
			
			$resp['status'] = 'success';
		}
		
		$resp['content'] = array('branch_code'=>$branch_code);
		echo json_encode($resp);
	}

	public function actionCreate()
	{
		$model=new Tipoclient;

		if(isset($_POST['Tipoclient']))
		{
			$model->attributes=$_POST['Tipoclient'];
			
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->client_cd,$model->stk_cd) > 0)
			{
			   	Yii::app()->user->setFlash('success', 'Successfully create Client IPO Stock');
				$this->redirect(array('/custody/tipoclient/index'));
				//$this->redirect(array('index'));
            }
		}
		
		$criteria_stk = new CDbCriteria;
		$criteria_stk->select = 'stk_cd';
		$criteria_stk->condition = "distrib_dt_to > TRUNC(SYSDATE)-30 AND approved_stat = 'A' ";
		$criteria_stk->order = 'stk_cd';
		
		$criteria_client = new CDbCriteria;
		$criteria_client->select = 'client_cd,branch_code,old_ic_num,client_name';
		$criteria_client->condition = "susp_stat = 'N' AND client_type_1 <> 'B'";
		$criteria_client->order = 'client_cd';

		$this->render('create',array(
			'model'=>$model,
			'criteria_stk'=>$criteria_stk,
			'criteria_client'=>$criteria_client,
		));
	}

	public function actionUpdate($client_cd,$stk_cd)
	{
		$model=$this->loadModel($client_cd,$stk_cd);

		if(isset($_POST['Tipoclient']))
		{
			$model->attributes=$_POST['Tipoclient'];
			
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$client_cd,$stk_cd) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update Client IPO Stock');
				$this->redirect(array('/custody/tipoclient/index'));
            }
		}
		
		$client = Client::model()->find('client_cd=:client_cd',array(':client_cd'=>$client_cd));
		
		$criteria_stk = new CDbCriteria;
		$criteria_stk->select = 'stk_cd';
		$criteria_stk->condition = "distrib_dt_to > TRUNC(SYSDATE)-30 AND approved_stat = 'A' ";
		$criteria_stk->order = 'stk_cd';
		
		$criteria_client = new CDbCriteria;
		$criteria_client->select = 'client_cd,branch_code,old_ic_num,client_name';
		$criteria_client->condition = "approved_stat = 'A' AND susp_stat = 'N' AND client_type_1 <> 'B'";
		$criteria_client->order = 'client_cd';

		$this->render('update',array(
			'model'=>$model,
			'criteria_stk'=>$criteria_stk,
			'criteria_client'=>$criteria_client,
			'client'=>$client,
		));
	}
	
	public function actionAjxPopDelete($client_cd,$stk_cd)
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
				
				$model1    				= $this->loadModel($client_cd,$stk_cd);
				$model1->cancel_reason  = $model->cancel_reason;
				
				$model1->validate();
				
				if($model1->executeSp(AConstant::INBOX_STAT_CAN,$client_cd,$stk_cd) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel Client IPO Stock');
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
	public function actionDelete($client_cd,$stk_cd)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($client_cd,$stk_cd)->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
		$model=new Tipoclient('search');
		$model->unsetAttributes();  // clear any default values
		
		$model->approved_stat = 'A';

		if(isset($_GET['Tipoclient']))
			$model->attributes=$_GET['Tipoclient'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($client_cd,$stk_cd)
	{
		$model=Tipoclient::model()->find("client_cd = '$client_cd' AND stk_cd = '$stk_cd' AND approved_stat = 'A'");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
