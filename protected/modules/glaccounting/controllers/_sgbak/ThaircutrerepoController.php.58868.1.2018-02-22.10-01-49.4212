<?php

class ThaircutrerepoController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionIndex()
	{
		$model= array();
		
		$oldModel = array();
		$insert = false;
		$selected = 0;		
		if(isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];
			if($scenario == 'create')
			{
				$model[0] = new Thaircutrerepo;
				$model[0]->attributes = $_POST['Thaircutrerepo'][0];
				
				if($model[0]->validate() && $model[0]->executeSp(AConstant::INBOX_STAT_INS,$model[0]->from_dt,$model[0]->stk_cd) > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully Create Haircut Reverse Repo');
					$this->redirect(array('/glaccounting/Thaircutrerepo/index'));
				}
				
				$model1 = Thaircutrerepo::model()->findAll(array(
					'select'=>'from_dt, to_dt, stk_cd, haircut',
					'condition'=>"approved_stat = 'A'",
					'order'=>'from_dt DESC'));
					
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
			else if($scenario == 'filter')
			{
				
				
				$model = Thaircutrerepo::model()->findAll(array(
					'select'=>'from_dt, to_dt, stk_cd, haircut',
					'condition'=>"approved_stat = 'A'",
					'order'=>'stk_cd asc'));
				
				foreach($model as $row)
				{
					if($row->from_dt)$row->from_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->from_dt)->format('d/m/Y');
					if($row->to_dt)$row->to_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->to_dt)->format('d/m/Y');
				}
			}
			
			else
			{
				$model = Thaircutrerepo::model()->findAll(array(
					'select'=>'from_dt, to_dt, stk_cd, haircut',
					'condition'=>"approved_stat = 'A'",
					'order'=>'from_dt DESC'));
					
				foreach($model as $row)
				{
					if($row->from_dt)$row->from_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->from_dt)->format('d/m/Y');
					if($row->to_dt)$row->to_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->to_dt)->format('d/m/Y');
				}
	
				$rowSeq = $_POST['rowSeq'];
				$model[$rowSeq-1]->attributes = $_POST['Thaircutrerepo'][$rowSeq];
				$oldFromDt = $_POST['oldPk1'];
				$oldStkCd = $_POST['oldPk2'];
				
				if($oldFromDt)$oldFromDt = DateTime::createFromFormat('Y-m-d G:i:s',$oldFromDt)->format('Y-m-d');
				
				if($model[$rowSeq-1]->validate() && $model[$rowSeq-1]->executeSp(AConstant::INBOX_STAT_UPD,$oldFromDt,$oldStkCd) > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully Update Haircut Reverse Repo');
					$this->redirect(array('/glaccounting/Thaircutrerepo/index'));
				}	
				
				if($model[$rowSeq-1]->from_dt)$model[$rowSeq-1]->from_dt=DateTime::createFromFormat('Y-m-d',$model[$rowSeq-1]->from_dt)->format('d/m/Y');
				if($model[$rowSeq-1]->to_dt)$model[$rowSeq-1]->to_dt=DateTime::createFromFormat('Y-m-d',$model[$rowSeq-1]->to_dt)->format('d/m/Y');
			}	
		}
		else
		{
			$model = Thaircutrerepo::model()->findAll(array(
			'select'=>'from_dt, to_dt, stk_cd, haircut',
			'condition'=>"approved_stat = 'A'",
			'order'=>'from_dt DESC'));
		
			foreach($model as $row)
			{		
				if($row->from_dt)$row->from_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->from_dt)->format('d/m/Y');
				if($row->to_dt)$row->to_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->to_dt)->format('d/m/Y');
			}
		}
		
		$oldModel = Thaircutrerepo::model()->findAll(array(
				'select'=>'from_dt, to_dt, stk_cd, haircut',
				'condition'=>"approved_stat = 'A'",
				'order'=>'from_dt DESC'));

		$this->render('index',array(
			'model'=>$model,
			'oldModel'=>$oldModel,
			'insert'=>$insert,
			'selected'=>$selected,
		));
	}

	public function actionAjxPopDelete($from_dt,$stk_cd)
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
				
				$model1    				= $this->loadModel($from_dt,$stk_cd);
				$model1->cancel_reason  = $model->cancel_reason;
				
				if($from_dt)$from_dt = DateTime::createFromFormat('Y-m-d G:i:s',$from_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->from_dt))$model1->from_dt = DateTime::createFromFormat('Y-m-d G:i:s',$model1->from_dt)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->to_dt))$model1->to_dt = DateTime::createFromFormat('Y-m-d G:i:s',$model1->to_dt)->format('Y-m-d');
				
				if($model1->validate() &&  $model1->executeSp(AConstant::INBOX_STAT_CAN,$from_dt,$stk_cd) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel Haircut Reverse Repo');
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

	public function loadModel($from_dt,$stk_cd)
	{
		$model=Thaircutrerepo::model()->find("from_dt = TO_DATE('$from_dt','YYYY-MM-DD HH24:MI:SS') AND stk_cd = '$stk_cd'");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
