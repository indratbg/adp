<?php

class GrpemitentController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

	public function actionIndex()
	{
		$model= array();
		$oldModel = array();
		$insert = false;
				
		if(isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];
			if($scenario == 'create')
			{
				$model[0] = new Grpemitent;
				$model[0]->attributes = $_POST['Grpemitent'][0];
				
				if($model[0]->validate() && $model[0]->executeSp(AConstant::INBOX_STAT_INS,$model[0]->seqno) > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully Create Grup Emitent');
					$this->redirect(array('/glaccounting/Grpemitent/index'));
				}
				
				$model1 = Grpemitent::model()->findAll(array(
					'condition'=>"approved_stat = 'A'",
					'order'=>'eff_dt,grp_emi'));
					
				foreach($model1 as $row)
				{
					if($row->eff_dt)$row->eff_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->eff_dt)->format('d/m/Y');
					
				}
				
				if($model[0]->eff_dt)$model[0]->eff_dt=DateTime::createFromFormat('Y-m-d',$model[0]->eff_dt)->format('d/m/Y');
				
				
				$model = array_merge($model,$model1);
				$insert = true;
			}
			else
			{
				$model = Grpemitent::model()->findAll(array(
					'condition'=>"approved_stat = 'A'",
					'order'=>'eff_dt,grp_emi'));
					
				foreach($model as $row)
				{
					if($row->eff_dt)$row->eff_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->eff_dt)->format('d/m/Y');
					
				}
	
				$rowSeq = $_POST['rowSeq'];
				$model[$rowSeq-1]->attributes = $_POST['Grpemitent'][$rowSeq];
				$oldSeqno = $_POST['oldPk'];
				
				if($model[$rowSeq-1]->validate() && $model[$rowSeq-1]->executeSp(AConstant::INBOX_STAT_UPD,$oldSeqno) > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully Update Grup Emitent');
					$this->redirect(array('/glaccounting/Grpemitent/index'));
				}	
				
				if($model[$rowSeq-1]->eff_dt)$model[$rowSeq-1]->eff_dt=DateTime::createFromFormat('Y-m-d',$model[$rowSeq-1]->eff_dt)->format('d/m/Y');
				
			}	
		}
		else
		{
			$model = Grpemitent::model()->findAll(array(
			'condition'=>"approved_stat = 'A'",
			'order'=>'eff_dt,grp_emi'));
		
			foreach($model as $row)
			{		
				if($row->eff_dt)$row->eff_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->eff_dt)->format('d/m/Y');
				
			}
		}
		
		$oldModel = Grpemitent::model()->findAll(array(
				'condition'=>"approved_stat = 'A'",
				'order'=>'eff_dt,grp_emi'));

		$this->render('index',array(
			'model'=>$model,
			'oldModel'=>$oldModel,
			'insert'=>$insert
		));
	}

	public function actionAjxPopDelete($seqno)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Ttempheader();
		$model->scenario = 'cancel';
		$model1 = NULL;
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate()){
				
				$model1    				= $this->loadModel($seqno);
				$model1->cancel_reason  = $model->cancel_reason;
				
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->eff_dt))$model1->eff_dt = DateTime::createFromFormat('Y-m-d G:i:s',$model1->eff_dt)->format('Y-m-d');
				
				
				if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$seqno) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel Grup Emitent');
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

	public function loadModel($seqno)
	{
		$model=Grpemitent::model()->find("seqno = '$seqno'");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
