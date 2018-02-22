<?php

class TpeeController extends AAdminController
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
		$model=new Tpee;

		if(isset($_POST['Tpee']))
		{
			$model->attributes=$_POST['Tpee'];
			$model->setAttribute('stk_cd',strtoupper($model->getAttribute('stk_cd')));
			
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->stk_cd) > 0)
			{
			   	Yii::app()->user->setFlash('success', 'Successfully create IPO Stock');
				$this->redirect(array('/custody/tpee/index'));
				//$this->redirect(array('index'));
            }
            
		}
		
		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		
		$check = Tipoclient::model()->find('stk_cd=:stk_cd',array(':stk_cd'=>$model->stk_cd));

		if(isset($_POST['Tpee']))
		{
			$model->attributes=$_POST['Tpee'];
			/*
			if(DateTime::createFromFormat('d/m/Y', $model->getAttribute('eff_dt_fr')))$model->setAttribute('eff_dt_fr',DateTime::createFromFormat('d/m/Y', $model->getAttribute('eff_dt_fr'))->format('d/m/y'));
			if(DateTime::createFromFormat('d/m/Y', $model->getAttribute('eff_dt_to')))$model->setAttribute('eff_dt_to',DateTime::createFromFormat('d/m/Y', $model->getAttribute('eff_dt_to'))->format('d/m/y'));
			if(DateTime::createFromFormat('d/m/Y', $model->getAttribute('offer_dt_fr')))$model->setAttribute('offer_dt_fr',DateTime::createFromFormat('d/m/Y', $model->getAttribute('offer_dt_fr'))->format('d/m/y'));
			if(DateTime::createFromFormat('d/m/Y', $model->getAttribute('offer_dt_to')))$model->setAttribute('offer_dt_to',DateTime::createFromFormat('d/m/Y', $model->getAttribute('offer_dt_to'))->format('d/m/y'));
			if(DateTime::createFromFormat('d/m/Y', $model->getAttribute('distrib_dt_fr')))$model->setAttribute('distrib_dt_fr',DateTime::createFromFormat('d/m/Y', $model->getAttribute('distrib_dt_fr'))->format('d/m/y'));
			//$model->setAttribute('distrib_dt_to',DateTime::createFromFormat('d/m/y', $model->getAttribute('distrib_dt_to'))->format('d/m/Y'));
			if(DateTime::createFromFormat('d/m/Y', $model->getAttribute('paym_dt')))$model->setAttribute('paym_dt',DateTime::createFromFormat('d/m/Y', $model->getAttribute('paym_dt'))->format('d/m/y'));
			if(DateTime::createFromFormat('d/m/Y', $model->getAttribute('tgl_kontrak')))$model->setAttribute('tgl_kontrak',DateTime::createFromFormat('d/m/Y', $model->getAttribute('tgl_kontrak'))->format('d/m/y'));
			if(DateTime::createFromFormat('d/m/Y', $model->getAttribute('allocate_dt')))$model->setAttribute('allocate_dt',DateTime::createFromFormat('d/m/Y', $model->getAttribute('allocate_dt'))->format('d/m/y'));
			*/
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$id) > 0)
			{
			   	Yii::app()->user->setFlash('success', 'Successfully update IPO Stock');
				$this->redirect(array('/custody/tpee/index'));
				//$this->redirect(array('view','id'=>$model->stk_cd));
            }
		}
		else
		{
			if(DateTime::createFromFormat('Y-m-d G:i:s',$model->getAttribute('eff_dt_fr')))$model->setAttribute('eff_dt_fr',DateTime::createFromFormat('Y-m-d G:i:s', $model->getAttribute('eff_dt_fr'))->format('d/m/y'));
			if(DateTime::createFromFormat('Y-m-d G:i:s',$model->getAttribute('eff_dt_to')))$model->setAttribute('eff_dt_to',DateTime::createFromFormat('Y-m-d G:i:s', $model->getAttribute('eff_dt_to'))->format('d/m/y'));
			if(DateTime::createFromFormat('Y-m-d G:i:s',$model->getAttribute('offer_dt_fr')))$model->setAttribute('offer_dt_fr',DateTime::createFromFormat('Y-m-d G:i:s', $model->getAttribute('offer_dt_fr'))->format('d/m/y'));
			if(DateTime::createFromFormat('Y-m-d G:i:s',$model->getAttribute('offer_dt_to')))$model->setAttribute('offer_dt_to',DateTime::createFromFormat('Y-m-d G:i:s', $model->getAttribute('offer_dt_to'))->format('d/m/y'));
			if(DateTime::createFromFormat('Y-m-d G:i:s',$model->getAttribute('distrib_dt_fr')))$model->setAttribute('distrib_dt_fr',DateTime::createFromFormat('Y-m-d G:i:s', $model->getAttribute('distrib_dt_fr'))->format('d/m/y'));
			if(DateTime::createFromFormat('Y-m-d G:i:s',$model->getAttribute('paym_dt')))$model->setAttribute('paym_dt',DateTime::createFromFormat('Y-m-d G:i:s', $model->getAttribute('paym_dt'))->format('d/m/y'));
			if(DateTime::createFromFormat('Y-m-d G:i:s',$model->getAttribute('tgl_kontrak')))$model->setAttribute('tgl_kontrak',DateTime::createFromFormat('Y-m-d G:i:s', $model->getAttribute('tgl_kontrak'))->format('d/m/y'));
			if(DateTime::createFromFormat('Y-m-d G:i:s',$model->getAttribute('allocate_dt')))$model->setAttribute('allocate_dt',DateTime::createFromFormat('Y-m-d G:i:s', $model->getAttribute('allocate_dt'))->format('d/m/y'));
		}		
	
		$this->render('update',array(
			'model'=>$model,
			'check'=>$check,
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
				
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->getAttribute('eff_dt_fr')))$model1->setAttribute('eff_dt_fr',DateTime::createFromFormat('Y-m-d G:i:s', $model1->getAttribute('eff_dt_fr'))->format('d/m/y'));
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->getAttribute('eff_dt_to')))$model1->setAttribute('eff_dt_to',DateTime::createFromFormat('Y-m-d G:i:s', $model1->getAttribute('eff_dt_to'))->format('d/m/y'));
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->getAttribute('offer_dt_fr')))$model1->setAttribute('offer_dt_fr',DateTime::createFromFormat('Y-m-d G:i:s', $model1->getAttribute('offer_dt_fr'))->format('d/m/y'));
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->getAttribute('offer_dt_to')))$model1->setAttribute('offer_dt_to',DateTime::createFromFormat('Y-m-d G:i:s', $model1->getAttribute('offer_dt_to'))->format('d/m/y'));
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->getAttribute('distrib_dt_fr')))$model1->setAttribute('distrib_dt_fr',DateTime::createFromFormat('Y-m-d G:i:s', $model1->getAttribute('distrib_dt_fr'))->format('d/m/y'));
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->getAttribute('paym_dt')))$model1->setAttribute('paym_dt',DateTime::createFromFormat('Y-m-d G:i:s', $model1->getAttribute('paym_dt'))->format('d/m/y'));
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->getAttribute('tgl_kontrak')))$model1->setAttribute('tgl_kontrak',DateTime::createFromFormat('Y-m-d G:i:s', $model1->getAttribute('tgl_kontrak'))->format('d/m/y'));
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->getAttribute('allocate_dt')))$model1->setAttribute('allocate_dt',DateTime::createFromFormat('Y-m-d G:i:s', $model1->getAttribute('allocate_dt'))->format('d/m/y'));
				$cek=Tipoclient::model()->find("stk_cd = '$id'");
				if(!$cek){
					$model1->validate();
				if ($model1->executeSp(AConstant::INBOX_STAT_CAN,$id) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel IPO Stock');
					$is_successsave = true;	
					}
			

				}
				else{
				
				$model1->addError('cancel_reason', 'Error cancel IPO Stock, Stock Code is already in use');
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
		$model=new Tpee('search');
		$model->unsetAttributes();  // clear any default values
		$model->approved_stat='A';
		if(isset($_GET['Tpee']))
			$model->attributes=$_GET['Tpee'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Tpee::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
