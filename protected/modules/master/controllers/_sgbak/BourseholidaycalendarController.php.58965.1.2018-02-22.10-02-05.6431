<?php

class BourseholidaycalendarController extends AAdminController
{
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model 	   	   = new Bourseholidaycalendar;
		$listLiburTemp = DAO::queryAllSql("SELECT TO_CHAR(tgl_libur,'DD-MM-YYYY') AS tgl_libur FROM MST_CALENDAR WHERE tgl_libur > TO_DATE('".Yii::app()->datetime->getDateNow()."','YYYY-MM-DD') ");
		$listLiburArr  = NULL;
		
		foreach($listLiburTemp as $item)
			$listLiburArr[] = $item['tgl_libur']; 
		
		$listLiburJson  = json_encode($listLiburArr);
		
		 
		if(isset($_POST['Bourseholidaycalendar']))
		{
			$model->attributes  = $_POST['Bourseholidaycalendar'];
			$model->flag_libur  = 1;
			
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS) > 0 )
			{
				Yii::app()->user->setFlash('success', 'Successfully create '.Yii::app()->format->formatDate($model->tgl_libur));
				$this->redirect(array('/master/bourseholidaycalendar/index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
			'listLiburJson'=>$listLiburJson
		));
	}

	public function actionUpdate($id)
	{
		$model		   = $this->loadModel($id);
		$listLiburTemp = DAO::queryAllSql("SELECT TO_CHAR(tgl_libur,'DD-MM-YYYY') AS tgl_libur FROM MST_CALENDAR WHERE tgl_libur > TO_DATE('".Yii::app()->datetime->getDateNow()."','YYYY-MM-DD') ");
		$listLiburArr  = NULL;
		
		foreach($listLiburTemp as $item)
			$listLiburArr[] = $item['tgl_libur']; 
		
		$listLiburJson  = json_encode($listLiburArr);
		
		if(isset($_POST['Bourseholidaycalendar']))
		{
			$model->attributes  = $_POST['Bourseholidaycalendar'];
			$model->flag_libur  = 1;
			
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update '.Yii::app()->format->formatDate($model->tgl_libur));
				$this->redirect(array('/master/bourseholidaycalendar/index'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
			'listLiburJson'=>$listLiburJson
		));
	}

	public function actionDelete($id)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;	
			
		$model  = new Ttempheader();
		$model->scenario = 'cancel';
	
		$model1 = null;
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate()){
				$model1    				= $this->loadModel($id);
				$model1->cancel_reason  = $model->cancel_reason;
				
				$old_tgl_libur  = $model1->tgl_libur;
				$arr_tgl_libur  = explode('-',$model1->tgl_libur);
				$int_year 		= intval($arr_tgl_libur[0]) - 50;
				$str_tgl_libur  = $int_year.'-'.$arr_tgl_libur[1].'-'.$arr_tgl_libur[2];
				$model1->tgl_libur = $str_tgl_libur; 
				
				if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_UPD,$old_tgl_libur) > 0)
				{
		            Yii::app()->user->setFlash('success', 'Successfully cancel '.Yii::app()->format->formatDate($model1->tgl_libur));
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
		$model=new Bourseholidaycalendar('search');
		$model->unsetAttributes();  // clear any default values
		//$model->tgl_libur_year = date('Y');
		if(isset($_GET['Bourseholidaycalendar']))
			$model->attributes=$_GET['Bourseholidaycalendar'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition("TO_CHAR(tgl_libur,'YYYY-MM-DD') = '".$id."'");
		$model	  = Bourseholidaycalendar::model()->find($criteria);
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
