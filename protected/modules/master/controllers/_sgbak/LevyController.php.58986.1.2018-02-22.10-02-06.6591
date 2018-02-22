<?php

class LevyController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionView($eff_dt,$stk_type,$mrkt_type,$value_from,$value_to)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($eff_dt,$stk_type,$mrkt_type,$value_from,$value_to),
		));
	}

	public function actionCreate()
	{
		$model=new Levy;

		if(isset($_POST['Levy']))
		{
			$model->attributes=$_POST['Levy'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->eff_dt,$model->stk_type,$model->mrkt_type) > 0){
            	Yii::app()->user->setFlash('success', 'Successfully create Levy');
				$this->redirect(array('/master/levy/index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($eff_dt,$stk_type,$mrkt_type,$value_from,$value_to)
	{
		$model=$this->loadModel($eff_dt,$stk_type,$mrkt_type,$value_from,$value_to);

		if(isset($_POST['Levy']))
		{
			$model->attributes=$_POST['Levy'];
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$eff_dt,$stk_type,$mrkt_type) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update Levy');
				$this->redirect(array('/master/levy/index'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionAjxPopDelete($eff_dt,$stk_type,$mrkt_type,$value_from,$value_to)
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
				
				$model1    				= $this->loadModel($eff_dt,$stk_type,$mrkt_type,$value_from,$value_to);
				$model1->cancel_reason  = $model->cancel_reason;
				
				if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$eff_dt,$stk_type,$mrkt_type) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel Levy');
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
		$model=new Levy('search');
		$model->unsetAttributes();  // clear any default values
		$model->approved_stat = "<>C";

		if(isset($_GET['Levy']))
			$model->attributes=$_GET['Levy'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($eff_dt,$stk_type,$mrkt_type,$value_from,$value_to)
	{
		$model=Levy::model()->findByPk(array('eff_dt'=>$eff_dt,'stk_type'=>$stk_type,'mrkt_type'=>$mrkt_type,'value_from'=>$value_from,'value_to'=>$value_to));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
