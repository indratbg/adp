<?php

class GeneratemkbdreportController extends AAdminController
{
	public $menu_name = 'MKBD REPORT';

	public $layout = '//layouts/admin_column3';
	

	public function actionAjxPopReject($id)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model = $this->loadModel($id);
		$model->scenario = 'reject';
	
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];			
			if($model->validate()):
				$this->reject($model);
				$is_successsave = true;
			endif;
		}

		$this->render('/template/_popreject',array(
			'model'=>$model,
			'is_successsave'=>$is_successsave
		));
	}

	public function actionAjxPopRejectChecked()
	{
		$this->layout 	= '//layouts/main_popup';
		
		if(!isset($_GET['arrid']))
			throw new CHttpException(404,'The requested page does not exist.');
		
		$is_successsave = false;
		$model = new Tmanyheader();
		$model->scenario = 'rejectchecked';
		
		$arrid = $_GET['arrid'];
			
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];
			if($model->validate() && $this->rejectChecked($model,$arrid))
				$is_successsave = true;
		}	
	

		$this->render('/template/_popreject',array(
			'model'=>$model,
			'is_successsave'=>$is_successsave
		));	
	} 
	
	public function actionApprove($id)
	{
		$model = $this->loadModel($id);
		$model->approveLapmkbdreport();
		
		$mkbd_date =Tmanydetail::model()->find("update_seq='$model->update_seq' and update_date='$model->update_date' and table_name='LAP_MKBD_VD51' and field_name='MKBD_DATE' and record_seq=1 ");
		$date='';
		if($mkbd_date){
			$date = $mkbd_date->field_value;
			if(DateTime::createFromFormat('Y/m/d H:i:s',$date))$date=DateTime::createFromFormat('Y/m/d H:i:s',$date)->format('d M Y');
		}
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve, MKBD Date '.$date.' Error  '.$model->error_code.':'.$model->error_msg);
		else{
			Yii::app()->user->setFlash('success', 'Successfully approve '.$date);
		
		}
			
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->rejectLapmkbd($model->reject_reason);
		$mkbd_date =Tmanydetail::model()->find("update_seq='$model->update_seq' and update_date='$model->update_date' and table_name='LAP_MKBD_VD51' and field_name='MKBD_DATE' and record_seq=1 ");
		$date='';
		if($mkbd_date){
			$date = $mkbd_date->field_value;
			if(DateTime::createFromFormat('Y/m/d H:i:s',$date))$date=DateTime::createFromFormat('Y/m/d H:i:s',$date)->format('d M Y');
		}
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Reject MKBD Date '.$date.' , Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully reject MKBD Date at '.$date);
	}
	
	private function rejectChecked($model,$arrid)
	{ 
		$reject_reason = $model->reject_reason;
		$hasil=array();
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->rejectLapmkbd($model->reject_reason);
			
			if($model->error_code < 0)
			{
				Yii::app()->user->setFlash('error', 'Error reject '.$model->update_seq.' '.$model->error_msg);
				return false;
			}
			else{
			$mkbd_date =Tmanydetail::model()->find("update_seq='$model->update_seq' and update_date='$model->update_date' and table_name='LAP_MKBD_VD51' and field_name='MKBD_DATE' and record_seq=1 ");
				$hasil[]='';
				if($mkbd_date)
				{
					$date = $mkbd_date->field_value;
					if(DateTime::createFromFormat('Y/m/d H:i:s',$date))$date=DateTime::createFromFormat('Y/m/d H:i:s',$date)->format('d M Y');
					$hasil[] =$date;
				}
		
			}
		endforeach;
		Yii::app()->user->setFlash('success', 'Successfully reject MKBD Date  '.json_encode($hasil));
		return true;
	}
	

	public function actionApproveChecked()
	{
		$result  = 'error';
		
		if(isset($_POST['arrid'])):
			
			$arrid	 = $_POST['arrid'];
			$result  = 'success';
			$hasil=array();
			
			//$x=1;
			foreach($arrid as $id)
			{ 
				$model = $this->loadModel($id);
				$model->approveLapmkbdreport();
		
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
				else
				{
					$mkbd_date =Tmanydetail::model()->find("update_seq='$model->update_seq' and update_date='$model->update_date' and table_name='LAP_MKBD_VD51' and field_name='MKBD_DATE' and record_seq=1 ");
					$hasil[]='';
					if($mkbd_date)
					{
						$date = $mkbd_date->field_value;
						if(DateTime::createFromFormat('Y/m/d H:i:s',$date))$date=DateTime::createFromFormat('Y/m/d H:i:s',$date)->format('d M Y');
						$hasil[] = $date;
					}
		
				}
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve '.$model->update_seq.' '.$model->error_msg);
			else
				
				Yii::app()->user->setFlash('success', 'Successfully approve transaction at '.json_encode($hasil));
		endif;
		
		echo $result;
	}

	public function actionIndex()
	{
		$model = new Vinboxlapmkbd('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = AConstant::INBOX_APP_STAT_ENTRY;
		
		
		if(isset($_GET['Vinboxlapmkbd']))
			$model->attributes=$_GET['Vinboxlapmkbd'];

		$this->render('index',array(
			'model'=>$model,
			
		));
	}
	
	public function actionIndexProcessed()
	{
		$model = new Tmanyheader('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = '<>'.AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['Tmanyheader']))
			$model->attributes=$_GET['Tmanyheader'];

		$this->render('index_processed',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model = Tmanyheader::model()->find('update_seq=:update_seq AND menu_name=:menu_name',array(':update_seq'=>$id,':menu_name'=>$this->menu_name));
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
