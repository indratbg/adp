<?php

class TaxrateController extends AAdminController
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
		$model=new Taxrate;

		if(isset($_POST['Taxrate']))
		{
			$model->attributes=$_POST['Taxrate'];
			$model->tax_type = 'DIVTAX';
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS, $model->seqno) > 0){
            	Yii::app()->user->setFlash('success', 'Successfully create dividen tax rate');
				$this->redirect(array('index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		if($model->client_cd)$model->rate_type = 1;
		else {
			$model->rate_type = 0;
		} 

		if(isset($_POST['Taxrate']))
		{
			$model->attributes=$_POST['Taxrate'];
			
			if($model->rate_type == 0)$model->client_cd = $model->stk_cd = '';
			else {
				$model->client_type_1 = $model->client_type_2 = '';
				$model->rate_2 = 0;
			}
			
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD, $model->seqno) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update dividen tax rate');
				$this->redirect(array('index'));
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
		
		$model1 = NULL;
		$model  = new Ttempheader();
		$model->scenario = 'cancel';
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate()){
				
				$model1    				= $this->loadModel($id);
				$model1->cancel_reason  = $model->cancel_reason;
				
				if($model1->begin_dt)$model1->begin_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model1->begin_dt)->format('Y-m-d');
				if($model1->end_dt)$model1->end_dt=DateTime::createFromFormat('Y-m-d G:i:s',$model1->end_dt)->format('Y-m-d');
				
				$model1->validate(); 
				if($model1->executeSp(AConstant::INBOX_STAT_CAN,$id) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel Dividen Rate');
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
		$model=new Taxrate('search');
		
		$model->unsetAttributes();  // clear any default values
		/*$query = "SELECT BEGIN_DT, END_DT, 'UMUM' RATE_TYPE, CLIENT_CD, STK_CD, CLIENT_TYPE_1, CLIENT_TYPE_2, RATE_TYPE_1, RATE_TYPE_2
				  FROM MST_TAX_RATE WHERE CLIENT_CD IS NULL
				  UNION
				  SELECT BEGIN_DT, END_DT, 'SPECIAL' RATE_TYPE, CLIENT_CD, STK_CD, CLIENT_TYPE_2, CLIENT_TYPE_2, RATE_TYPE_1, RATE_TYPE_2
				  FROM MST_TAX_RATE WHERE CLIENT_CD IS NOT NULL";*/

		$model->approved_stat = 'A';
		if(isset($_GET['Taxrate']))
			$model->attributes=$_GET['Taxrate'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Taxrate::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
