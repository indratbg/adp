<?php

class TcorpguaranteeController extends AAdminController
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
				$model[0] = new Tcorpguarantee;
				$model[0]->attributes = $_POST['Tcorpguarantee'][0];
				//insert
				if($model[0]->validate() && $model[0]->executeSp(AConstant::INBOX_STAT_INS,$model[0]->contract_dt,$model[0]->guaranteed) > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully Create Corporate Guarantee');
					$this->redirect(array('/glaccounting/Tcorpguarantee/index'));
				}
				
				$model1 = Tcorpguarantee::model()->findAll(array('condition'=>"approved_stat = 'A'",'order'=>'contract_dt desc'));
					
				foreach($model1 as $row)
				{
					if($row->contract_dt)$row->contract_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->contract_dt)->format('d/m/Y');
					if($row->end_contract_dt)$row->end_contract_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->end_contract_dt)->format('d/m/Y');
					$row->old_contract_dt = $row->contract_dt;
					$row->old_guaranteed = $row->guaranteed;
				}
				
				if($model[0]->contract_dt)$model[0]->contract_dt=DateTime::createFromFormat('Y-m-d',$model[0]->contract_dt)->format('d/m/Y');
				if($model[0]->end_contract_dt)$model[0]->end_contract_dt=DateTime::createFromFormat('Y-m-d',$model[0]->end_contract_dt)->format('d/m/Y');
				
				$model = array_merge($model,$model1);
				$insert = true;
			}
			else
			{
				$model = Tcorpguarantee::model()->findAll(array('condition'=>"approved_stat = 'A'",'order'=>'contract_dt desc'));
					
				foreach($model as $row)
				{
					if($row->contract_dt)$row->contract_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->contract_dt)->format('d/m/Y');
					if($row->end_contract_dt)$row->end_contract_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->end_contract_dt)->format('d/m/Y');
					$row->old_contract_dt = $row->contract_dt;
					$row->old_guaranteed = $row->guaranteed;
				}
	
				$rowSeq = $_POST['rowSeq'];
				$model[$rowSeq-1]->attributes = $_POST['Tcorpguarantee'][$rowSeq];
			
				
				
				if($model[$rowSeq-1]->validate() && $model[$rowSeq-1]->executeSp(AConstant::INBOX_STAT_UPD,$model[$rowSeq-1]->old_contract_dt,$model[$rowSeq-1]->old_guaranteed) > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully Update Corporate Guarantee');
					$this->redirect(array('/glaccounting/Tcorpguarantee/index'));
				}	
				
				if($model[$rowSeq-1]->contract_dt)$model[$rowSeq-1]->contract_dt=DateTime::createFromFormat('Y-m-d',$model[$rowSeq-1]->contract_dt)->format('d/m/Y');
				if($model[$rowSeq-1]->end_contract_dt)$model[$rowSeq-1]->end_contract_dt=DateTime::createFromFormat('Y-m-d',$model[$rowSeq-1]->end_contract_dt)->format('d/m/Y');
			}	
		}
		else
		{
			$model = Tcorpguarantee::model()->findAll(array('condition'=>"approved_stat = 'A'",'order'=>'contract_dt desc'));
		
			foreach($model as $row)
				{
					if($row->contract_dt)$row->contract_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->contract_dt)->format('d/m/Y');
					if($row->end_contract_dt)$row->end_contract_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->end_contract_dt)->format('d/m/Y');
					$row->old_contract_dt = $row->contract_dt;
					$row->old_guaranteed = $row->guaranteed;
			}
		}
		
	//	$oldModel = Tcorpguarantee::model()->findAll(array('condition'=>"approved_stat = 'A'",'order'=>'contract_dt desc'));

		$this->render('index',array(
			'model'=>$model,
		//	'oldModel'=>$oldModel,
			'insert'=>$insert
		));
	}

	public function actionAjxPopDelete($contract_dt,$guaranteed)
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
				
				$model1    				= $this->loadModel($contract_dt,$guaranteed);
				$model1->cancel_reason  = $model->cancel_reason;
				
			if(DateTime::createFromFormat('d/m/Y',$contract_dt))$contract_dt= DateTime::createFromFormat('d/m/Y',$contract_dt)->format('Y-m-d');;
				
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->contract_dt))$model1->contract_dt = DateTime::createFromFormat('Y-m-d G:i:s',$model1->contract_dt)->format('Y-m-d');
			if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->end_contract_dt))$model1->end_contract_dt = DateTime::createFromFormat('Y-m-d G:i:s',$model1->end_contract_dt)->format('Y-m-d');
				
				if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$contract_dt,$guaranteed) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel Corporate Guarantee');
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

	public function loadModel($contract_dt,$guaranteed)
	{
		$model=Tcorpguarantee::model()->find("contract_dt = TO_DATE('$contract_dt','dd/mm/yyyy') AND guaranteed ='$guaranteed' ");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
