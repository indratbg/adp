<?php

class TdepositController extends AAdminController
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
				$model[0] = new Tdeposit;
				$model[0]->attributes = $_POST['Tdeposit'][0];
				
				if($model[0]->validate() && $model[0]->executeSp(AConstant::INBOX_STAT_INS,$model[0]->seqno) > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully Create Deposito');
					$this->redirect(array('/glaccounting/Tdeposit/index'));
				}
				
				$model1 = Tdeposit::model()->findAll(array(
					'condition'=>"approved_stat = 'A'",
					'order'=>'from_dt, bank_cd'));
					
				foreach($model1 as $row)
				{
					if($row->from_dt)$row->from_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->from_dt)->format('d/m/Y');
					if($row->to_dt)$row->to_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->to_dt)->format('d/m/Y');
				}
				
				if($model[0]->from_dt)$model[0]->from_dt=DateTime::createFromFormat('Y-m-d',$model[0]->from_dt)->format('d/m/Y');
				if($model[0]->to_dt)$model[0]->to_dt=DateTime::createFromFormat('Y-m-d',$model[0]->to_dt)->format('d/m/Y');
				
				$model = array_merge($model,$model1);
				$insert = true;
			}
			else
			{
				$model = Tdeposit::model()->findAll(array(
					'condition'=>"approved_stat = 'A'",
					'order'=>'from_dt, bank_cd'));
					
				foreach($model as $row)
				{
					if($row->from_dt)$row->from_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->from_dt)->format('d/m/Y');
					if($row->to_dt)$row->to_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->to_dt)->format('d/m/Y');
				}
	
				$rowSeq = $_POST['rowSeq'];
				$model[$rowSeq-1]->attributes = $_POST['Tdeposit'][$rowSeq];
				$oldSeqno = $_POST['oldPk'];
				
				if($model[$rowSeq-1]->validate() && $model[$rowSeq-1]->executeSp(AConstant::INBOX_STAT_UPD,$oldSeqno) > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully Update Deposito');
					$this->redirect(array('/glaccounting/Tdeposit/index'));
				}	
				
				if($model[$rowSeq-1]->from_dt)$model[$rowSeq-1]->from_dt=DateTime::createFromFormat('Y-m-d',$model[$rowSeq-1]->from_dt)->format('d/m/Y');
				if($model[$rowSeq-1]->to_dt)$model[$rowSeq-1]->to_dt=DateTime::createFromFormat('Y-m-d',$model[$rowSeq-1]->to_dt)->format('d/m/Y');
			}	
		}
		else
		{
			$model = Tdeposit::model()->findAll(array(
			'condition'=>"approved_stat = 'A'",
			'order'=>'from_dt, bank_cd'));
		
			foreach($model as $row)
			{		
				if($row->from_dt)$row->from_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->from_dt)->format('d/m/Y');
				if($row->to_dt)$row->to_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->to_dt)->format('d/m/Y');
			}
		}
		
		$oldModel = Tdeposit::model()->findAll(array(
				'condition'=>"approved_stat = 'A'",
				'order'=>'from_dt, bank_cd'));

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
				
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->from_dt))$model1->from_dt = DateTime::createFromFormat('Y-m-d G:i:s',$model1->from_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->to_dt))$model1->to_dt = DateTime::createFromFormat('Y-m-d G:i:s',$model1->to_dt)->format('Y-m-d');
				
				if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$seqno) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel Deposito');
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
		$model=Tdeposit::model()->find("seqno = '$seqno'");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
