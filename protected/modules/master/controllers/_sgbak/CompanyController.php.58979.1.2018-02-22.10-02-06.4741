<?php

class CompanyController extends AAdminController
{
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$a  =1;
		$model=new Company; 

		if(isset($_POST['Company']))
		{
			$model->attributes=$_POST['Company'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->kd_broker) > 0 ){
				Yii::app()->user->setFlash('success', 'Successfully create '.$model->kd_broker);
				$this->redirect(array('/master/company/index')); 
            }
		}else{
			$model->round = 2;
			$model->limit_mkbd = 25000000;
			$model->jsx_listed = 'Y';
			$model->ssx_listed = 'Y';
			$model->vat_pct = 10;
			$model->pph_pct = 10;
			$model->levy_pct = 4;
			$model->min_fee_flag = 0;
			$model->jenis_ijin1 = 'NPWP';
		}

		$this->render('create',array(
			'model'=>$model,
			'status'=>'I'
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Company']))
		{
			$model->attributes=$_POST['Company'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$id) > 0){
				Yii::app()->user->setFlash('success', 'Successfully update '.$model->kd_broker);
				$this->redirect(array('/master/company/index'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
			'status'=>'U'
		));
	}

	public function actionAjxPopDelete($id)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Ttempheader();
		$model->scenario = 'cancel';
		$model1 = null;
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate()){
				
				$model1    				= $this->loadModel($id);
				$model1->cancel_reason  = $model->cancel_reason;

				if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$id) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->kd_broker);
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
	

	public function actionIndex()
	{
		$model=new Company('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Company']))
			$model->attributes=$_GET['Company'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Company::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
