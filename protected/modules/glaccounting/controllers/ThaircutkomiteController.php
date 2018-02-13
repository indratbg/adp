<?php

class ThaircutkomiteController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionView($status_dt,$stk_cd,$eff_dt)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($status_dt, $stk_cd, $eff_dt),
		));
	}

	public function actionCreate()
	{
		
		
		$model=new Thaircutkomite;

		if(isset($_POST['Thaircutkomite']))
		{
			$model->attributes=$_POST['Thaircutkomite'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->status_dt,$model->stk_cd,$model->eff_dt) > 0){
            	Yii::app()->user->setFlash('success', 'Successfully create Haircut MKBD');
				$this->redirect(array('/glaccounting/Thaircutkomite/index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($status_dt, $stk_cd,$eff_dt)
	{
		$model=$this->loadModel($status_dt, $stk_cd,$eff_dt);

		if(isset($_POST['Thaircutkomite']))
		{
			$model->attributes=$_POST['Thaircutkomite'];
		if(DateTime::createFromFormat('Y-m-d H:i:s',$status_dt))$status_dt=DateTime::createFromFormat('Y-m-d H:i:s',$status_dt)->format('Y-m-d');
		if(DateTime::createFromFormat('Y-m-d H:i:s',$eff_dt))$eff_dt=DateTime::createFromFormat('Y-m-d H:i:s',$eff_dt)->format('Y-m-d');
			
			
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$status_dt, $stk_cd, $eff_dt) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update Haircut MKBD');
				$this->redirect(array('/glaccounting/Thaircutkomite/index'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionAjxPopDelete($status_dt, $stk_cd, $eff_dt)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Ttempheader();
		$model->scenario = 'cancel';
		$model1 = $this->loadModel($status_dt, $stk_cd, $eff_dt);
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate()){
				$model1->cancel_reason  = $model->cancel_reason;
				$model1->user_id = Yii::app()->user->id;
				$model1->ip_address = Yii::app()->request->userHostAddress;
				if($model1->ip_address=="::1")
					$model1->ip_address = '127.0.0.1';
				if(DateTime::createFromFormat('Y-m-d H:i:s',$status_dt))$status_dt=DateTime::createFromFormat('Y-m-d H:i:s',$status_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d H:i:s',$eff_dt))$eff_dt=DateTime::createFromFormat('Y-m-d H:i:s',$eff_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d H:i:s',$model1->status_dt))$model1->status_dt=DateTime::createFromFormat('Y-m-d H:i:s',$model1->status_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d H:i:s',$model1->eff_dt))$model1->eff_dt=DateTime::createFromFormat('Y-m-d H:i:s',$model1->eff_dt)->format('Y-m-d');
				if($model1->executeSp(AConstant::INBOX_STAT_CAN,$status_dt, $stk_cd, $eff_dt) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->stk_cd);
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
		$model=new Thaircutkomite('search');
		$model->unsetAttributes();  // clear any default values
		
		$model->approved_stat = 'A';
		

		if(isset($_GET['Thaircutkomite']))
			$model->attributes=$_GET['Thaircutkomite'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	

	public function loadModel($status_dt, $stk_cd, $eff_dt)
	{
		$model=Thaircutkomite::model()->find("status_dt = to_date('$status_dt','YYYY-MM-DD HH24:MI:SS') and stk_cd ='$stk_cd' and eff_dt = to_date('$eff_dt','YYYY-MM-DD HH24:MI:SS')");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	 
}
