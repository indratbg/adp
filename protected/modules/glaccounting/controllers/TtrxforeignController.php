<?php

class TtrxforeignController extends AAdminController
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
				$model[0] = new Ttrxforeign;
				$model[0]->attributes = $_POST['Ttrxforeign'][0];
				
				if($model[0]->validate() && $model[0]->executeSp(AConstant::INBOX_STAT_INS,$model[0]->tgl_trx,$model[0]->norut) > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully Create Transaksi Dalam Mata Uang Asing');
					$this->redirect(array('/glaccounting/Ttrxforeign/index'));
				}
				
				$model1 = Ttrxforeign::model()->findAll(array(
					'condition'=>"approved_stat = 'A'",
					'order'=>'tgl_trx desc'));
					
				foreach($model1 as $row)
				{
					if($row->tgl_trx)$row->tgl_trx=DateTime::createFromFormat('Y-m-d G:i:s',$row->tgl_trx)->format('d/m/Y');
					$row->old_tgl_trx = $row->tgl_trx;
				}
				
				if($model[0]->tgl_trx)$model[0]->tgl_trx=DateTime::createFromFormat('Y-m-d',$model[0]->tgl_trx)->format('d/m/Y');
				
				
				$model = array_merge($model,$model1);
				$insert = true;
			}
			else
			{
				$model = Ttrxforeign::model()->findAll(array(
					'condition'=>"approved_stat = 'A'",
					'order'=>'tgl_trx desc'
				));
					
				foreach($model as $row)
				{
					if($row->tgl_trx)$row->tgl_trx=DateTime::createFromFormat('Y-m-d G:i:s',$row->tgl_trx)->format('d/m/Y');
					$row->old_tgl_trx = $row->tgl_trx;
					$row->old_norut = $row->norut;
				}
	
				$rowSeq = $_POST['rowSeq'];
				$model[$rowSeq-1]->attributes = $_POST['Ttrxforeign'][$rowSeq];
				$old_tgl_trx = $_POST['oldPk'];
				$old_norut = $_POST['oldPk1'];
				
				if($model[$rowSeq-1]->validate() && $model[$rowSeq-1]->executeSp(AConstant::INBOX_STAT_UPD,$model[$rowSeq-1]->old_tgl_trx,$model[$rowSeq-1]->old_norut) > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully Update Transaksi Dalam Mata Uang Asing');
					$this->redirect(array('/glaccounting/Ttrxforeign/index'));
				}	
				
				if($model[$rowSeq-1]->tgl_trx)$model[$rowSeq-1]->tgl_trx=DateTime::createFromFormat('Y-m-d',$model[$rowSeq-1]->tgl_trx)->format('d/m/Y');
				
			}	
		}
		else
		{
			$model = Ttrxforeign::model()->findAll(array(
			'condition'=>"approved_stat = 'A'",
			'order'=>'tgl_trx desc'
			));
		
			foreach($model as $row)
			{		
				if($row->tgl_trx)$row->tgl_trx=DateTime::createFromFormat('Y-m-d G:i:s',$row->tgl_trx)->format('d/m/Y');
				$row->old_tgl_trx = $row->tgl_trx;
				$row->old_norut = $row->norut;
			}
		}
		
		$oldModel = Ttrxforeign::model()->findAll(array(
				'condition'=>"approved_stat = 'A'",
				'order'=>'tgl_trx desc'
				));

		$this->render('index',array(
			'model'=>$model,
			'oldModel'=>$oldModel,
			'insert'=>$insert
		));
	}

	public function actionAjxPopDelete($tgl_trx,$norut)
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
				
				$model1    				= $this->loadModel($tgl_trx,$norut);
				$model1->cancel_reason  = $model->cancel_reason;
				if(DateTime::createFromFormat('d/m/Y',$tgl_trx))$tgl_trx= DateTime::createFromFormat('d/m/Y',$tgl_trx)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->tgl_trx))$model1->tgl_trx= DateTime::createFromFormat('Y-m-d G:i:s',$model1->tgl_trx)->format('Y-m-d');
				
				
				if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$tgl_trx,$norut) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel Transaksi Dalam Mata Uang Asing');
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

	public function loadModel($tgl_trx,$norut)
	{
		$model=Ttrxforeign::model()->find("tgl_trx = to_date('$tgl_trx','dd/mm/yyyy') and norut = '$norut' ");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
