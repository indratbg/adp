<?php

class TbelanjamodalController extends AAdminController
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
				$model[0] = new Tbelanjamodal;
				$model[0]->attributes = $_POST['Tbelanjamodal'][0];
				
				if($model[0]->validate() && $model[0]->executeSp(AConstant::INBOX_STAT_INS,$model[0]->seqno) > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully Create Belanja Modal');
					$this->redirect(array('/glaccounting/Tbelanjamodal/index'));
				}
				
				$model1 = Tbelanjamodal::model()->findAll(array('condition'=>"approved_stat = 'A'",
																'order'=>'tgl_komitmen desc'));
					
				foreach($model1 as $row)
				{
					if($row->tgl_komitmen)$row->tgl_komitmen=DateTime::createFromFormat('Y-m-d G:i:s',$row->tgl_komitmen)->format('d/m/Y');
					if($row->tgl_realisasi)$row->tgl_realisasi=DateTime::createFromFormat('Y-m-d G:i:s',$row->tgl_realisasi)->format('d/m/Y');
				}
				
				if($model[0]->tgl_komitmen)$model[0]->tgl_komitmen=DateTime::createFromFormat('Y-m-d',$model[0]->tgl_komitmen)->format('d/m/Y');
				if($model[0]->tgl_realisasi)$model[0]->tgl_realisasi=DateTime::createFromFormat('Y-m-d',$model[0]->tgl_realisasi)->format('d/m/Y');
				
				$model = array_merge($model,$model1);
				$insert = true;
			}
			else
			{
				$model = Tbelanjamodal::model()->findAll(array('condition'=>"approved_stat = 'A'",
																'order'=>'tgl_komitmen desc'));
					
				foreach($model as $row)
				{
					if($row->tgl_komitmen)$row->tgl_komitmen=DateTime::createFromFormat('Y-m-d G:i:s',$row->tgl_komitmen)->format('d/m/Y');
					if($row->tgl_realisasi)$row->tgl_realisasi=DateTime::createFromFormat('Y-m-d G:i:s',$row->tgl_realisasi)->format('d/m/Y');
				}
	
				$rowSeq = $_POST['rowSeq'];
				$model[$rowSeq-1]->attributes = $_POST['Tbelanjamodal'][$rowSeq];
				$oldSeqno = $_POST['oldPk'];
				
				if($model[$rowSeq-1]->validate() && $model[$rowSeq-1]->executeSp(AConstant::INBOX_STAT_UPD,$oldSeqno) > 0)
				{
					Yii::app()->user->setFlash('success', 'Successfully Update Komitmen Belanja Modal');
					$this->redirect(array('/glaccounting/Tbelanjamodal/index'));
				}	
				
				if($model[$rowSeq-1]->tgl_komitmen)$model[$rowSeq-1]->tgl_komitmen=DateTime::createFromFormat('Y-m-d',$model[$rowSeq-1]->tgl_komitmen)->format('d/m/Y');
				if($model[$rowSeq-1]->tgl_realisasi)$model[$rowSeq-1]->tgl_realisasi=DateTime::createFromFormat('Y-m-d',$model[$rowSeq-1]->tgl_realisasi)->format('d/m/Y');
			}	
		}
		else
		{
			$model = Tbelanjamodal::model()->findAll(array('condition'=>"approved_stat = 'A'",
																'order'=>'tgl_komitmen desc'));
		
			foreach($model as $row)
				{
					if($row->tgl_komitmen)$row->tgl_komitmen=DateTime::createFromFormat('Y-m-d G:i:s',$row->tgl_komitmen)->format('d/m/Y');
					if($row->tgl_realisasi)$row->tgl_realisasi=DateTime::createFromFormat('Y-m-d G:i:s',$row->tgl_realisasi)->format('d/m/Y');
				}
		}
		$oldModel = Tbelanjamodal::model()->findAll(array('condition'=>"approved_stat = 'A'",
																'order'=>'tgl_komitmen desc'));
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
				
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->tgl_komitmen))$model1->tgl_komitmen = DateTime::createFromFormat('Y-m-d G:i:s',$model1->tgl_komitmen)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d G:i:s',$model1->tgl_realisasi))$model1->tgl_realisasi = DateTime::createFromFormat('Y-m-d G:i:s',$model1->tgl_realisasi)->format('Y-m-d');
				
				if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$seqno) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel Komitmen Belanja Modal');
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
		$model=Tbelanjamodal::model()->find("seqno= '$seqno'");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
