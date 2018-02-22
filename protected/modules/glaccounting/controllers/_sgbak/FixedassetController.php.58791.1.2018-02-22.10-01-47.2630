<?php

class FixedassetController extends AAdminController
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
		$model=new Fixedasset;

		if(isset($_POST['Fixedasset']))
		{
			$model->attributes=$_POST['Fixedasset'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->asset_cd) > 0){
            	Yii::app()->user->setFlash('success', 'Successfully create Fixed Asset');
				$this->redirect(array('/glaccounting/fixedasset/index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Fixedasset']))
		{
			$model->attributes=$_POST['Fixedasset'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$id) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update Fixed Asset');
				$this->redirect(array('/glaccounting/fixedasset/index'));
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
		$model->scenario = 'cancel';
		$model1 = $this->loadModel($id);
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate()){
				$model1->cancel_reason  = $model->cancel_reason;
				$model1->user_id = Yii::app()->user->id;
				$model1->ip_address = Yii::app()->request->userHostAddress;
				if($model1->ip_address=="::1")
					$model1->ip_address = '127.0.0.1';
				
				if($model1->executeSp(AConstant::INBOX_STAT_CAN,$id) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->asset_cd);
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
		$model=new Fixedasset('search');
		$model->unsetAttributes();  // clear any default values
		
		$model->approved_stat = 'A';
		$model->asset_stat = 'ACTIVE';

		if(isset($_GET['Fixedasset']))
			$model->attributes=$_GET['Fixedasset'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	public function actionAssetno(){
		$resp['status']='error';
		if(isset($_POST['asset_no'])){
			$assetno = $_POST['asset_no'];
			
		$query="select f_asset_num('$assetno') as asset from dual";
			$assetnum = DAO::queryRowSql($query);
			
		
				$resp['num'] = $assetnum['asset'];
				
				$resp['status']='success';
		
		}
		
		
		echo json_encode($resp);
		
		
	}

	public function loadModel($id)
	{
		$model=Fixedasset::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
