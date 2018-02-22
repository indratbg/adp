<?php

class TexchrateController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';

	public function actionIndex()
	{	$model= array();
		$oldModel = array();
		$insert = false;

		
		if(isset($_POST['scenario']))
		{
			$scenario = $_POST['scenario'];
			if($scenario == 'create')
			{
				$model[0] = new Texchrate;
				$model[0]->attributes = $_POST['Texchrate'][0];
				//insert
				if($model[0]->validate() && $model[0]->executeSp(AConstant::INBOX_STAT_INS,$model[0]->exch_dt,$model[0]->curr_cd) > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully Create Foreign Currency- Exchange Rate');
					$this->redirect(array('/glaccounting/Texchrate/index'));
				}
				
				$model1 = Texchrate::model()->findAll(array('condition'=>"approved_stat = 'A' AND exch_dt>trunc(sysdate)-30 ",'order'=>'exch_dt desc'));
					
				foreach($model1 as $row)
				{
					if($row->exch_dt)$row->exch_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->exch_dt)->format('d/m/Y');
					
						$row->old_exch_dt = $row->exch_dt;
						$row->old_curr_cd = $row->curr_cd;
				}
				
				if($model[0]->exch_dt)$model[0]->exch_dt=DateTime::createFromFormat('Y-m-d',$model[0]->exch_dt)->format('d/m/Y');
				
				
				$model = array_merge($model,$model1);
				$insert = true;
			}
			else
			{
				$model = Texchrate::model()->findAll(array('condition'=>"approved_stat ='A'  AND exch_dt>trunc(sysdate)-30",'order'=>'exch_dt desc'));
					
				foreach($model as $row)
				{
					if($row->exch_dt)$row->exch_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->exch_dt)->format('d/m/Y');
					
					$row->old_exch_dt = $row->exch_dt;
					$row->old_curr_cd = $row->curr_cd;
				}
	
				$rowSeq = $_POST['rowSeq'];
				$model[$rowSeq-1]->attributes = $_POST['Texchrate'][$rowSeq];
			
				
				
				if($model[$rowSeq-1]->validate() && $model[$rowSeq-1]->executeSp(AConstant::INBOX_STAT_UPD,$model[$rowSeq-1]->old_exch_dt,$model[$rowSeq-1]->old_curr_cd) > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully Update Foreign Currency - Exchange Rate');
					$this->redirect(array('/glaccounting/Texchrate/index'));
				}	
				
				if($model[$rowSeq-1]->exch_dt)$model[$rowSeq-1]->exch_dt=DateTime::createFromFormat('Y-m-d',$model[$rowSeq-1]->exch_dt)->format('d/m/Y');
				
			}	
		}
		else
		{
			$model = Texchrate::model()->findAll(array('condition'=>"approved_stat ='A'  AND exch_dt>trunc(sysdate)-30",'order'=>'exch_dt desc'));
		
			foreach($model as $row)
				{
					if($row->exch_dt)$row->exch_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->exch_dt)->format('d/m/Y');
					
					$row->old_exch_dt = $row->exch_dt;
					$row->old_curr_cd = $row->curr_cd;
					
			}
				if(count($model)==0)
				{
					$model[0] = new Texchrate;
					$insert=true;
				}
		}
		
		//$oldModel = Texchrate::model()->findAll(array('condition'=>"approved_stat ='A'",'order'=>'exch_dt desc'));
		

		$this->render('index',array(
				'model'=>$model,
				//'oldModel'=>$oldModel,
				'insert'=>$insert
		));
	}
	
	
	public function actionAjxPopDelete($exch_dt,$curr_cd)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model1 = NULL;
		$model  = new Ttempheader();
		$model->scenario = 'cancel';
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			
				
				$model1    				= $this->loadModel($exch_dt,$curr_cd);
				$model1->cancel_reason  = $model->cancel_reason;
				if($model1->validate()){
			
					if(DateTime::createFromFormat('d/m/Y',$exch_dt))$exch_dt= DateTime::createFromFormat('d/m/Y',$exch_dt)->format('Y-m-d');;
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->exch_dt))$model1->exch_dt = DateTime::createFromFormat('Y-m-d G:i:s',$model1->exch_dt)->format('Y-m-d');
				
				
				if($model1->executeSp(AConstant::INBOX_STAT_CAN,$exch_dt,$curr_cd) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel Exchange Rate');
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
	
	

	public function loadModel($exch_dt,$curr_cd)
	{
		$model=Texchrate::model()->find("exch_dt = TO_DATE('$exch_dt','dd/mm/yyyy') AND curr_cd ='$curr_cd' ");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
