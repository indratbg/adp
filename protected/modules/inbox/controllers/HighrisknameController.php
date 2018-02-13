<?php

class HighrisknameController extends AAdminController
{
	public $menu_name = 'HIGHRISK NAME';
	public $table_name = 'T_HIGHRISK_NAME';
	
	public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		$modelDetail	  = array();
		$modelDetailUpd   = null;
		//$listtmanydetail  = Tmanydetail::model()->findAll('update_seq =:update_seq',array(':update_seq'=>$model->update_seq));
		
		$getNrec = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt, table_rowid',
		'condition'=>'update_seq =:update_seq and update_date = TO_DATE(:update_date,\'YYYY-MM-DD HH24:MI:SS\')',
		'group'=>'table_rowid',
		'params'=>array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date)));
		
		if($model->status == AConstant::INBOX_STAT_UPD){
			//$modelDetail     = Highriskname::model()->find("rowid ='$model->table_rowid'");	// left
			//$modelDetailUpd  = Highriskname::model()->find("rowid ='$model->table_rowid'");	// right [updated version]
			//Tmanydetail::generateModelAttributes2($modelDetailUpd, $listtmanydetail);
			
			$modelDetail[0]  = Highriskname::model()->find("rowid ='$getNrec->table_rowid'");
			
			$listTmanydetail = Tmanydetail::model()->findAll('update_seq =:update_seq AND update_date = TO_DATE(:update_date,\'YYYY-MM-DD HH24:MI:SS\') AND table_name =:table_name AND record_seq = :record_seq',
			array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->table_name,':record_seq'=>1));
			$modelDetailUpd = new Highriskname;
			Tmanydetail::generateModelAttributes2($modelDetailUpd, $listTmanydetail);
			//var_dump($getNrec->table_rowid);
			//die();
			
			if($model->approved_status != AConstant::INBOX_APP_STAT_ENTRY):
				$this->render('view',array(
					'model'=>$model,
					'modelDetail'=>$modelDetail,
				));	
			else:
				$this->render('view_compare',array(
					'model'=>$model,
					'modelDetail'=>$modelDetail[0],
					'modelDetailUpd'=>$modelDetailUpd
				));
			
			endif;	
		}else{
			if($model->status == AConstant::INBOX_STAT_CAN){
				$modelDetail[0]  = Highriskname::model()->find("rowid ='$getNrec->table_rowid'");	
			}else{
				for ($x = 1; $x <= $getNrec->record_cnt; $x++){
					$listTmanydetail = Tmanydetail::model()->findAll('update_seq =:update_seq AND update_date = TO_DATE(:update_date,\'YYYY-MM-DD HH24:MI:SS\') AND table_name =:table_name AND record_seq = :record_seq',
					array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->table_name,':record_seq'=>$x));
					$modelDetail[$x-1] = new Highriskname;
					Tmanydetail::generateModelAttributes2($modelDetail[$x-1], $listTmanydetail);
				}
			}
			
			$this->render('view',array(
				'model'=>$model,
				'modelDetail'=>$modelDetail
			));	
		}
	}

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
		$model->approve();
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve '.$id);
		
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->reject($model->reject_reason);
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully reject '.$model->update_seq);
	}
	
	private function rejectChecked($model,$arrid)
	{
		$reject_reason = $model->reject_reason;
		
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->reject($reject_reason);
			
			if($model->error_code < 0){
				Yii::app()->user->setFlash('error', 'Error reject '.$model->update_seq.' '.$model->error_msg);
				return false;
			}
		endforeach;
		
		Yii::app()->user->setFlash('success', 'Successfully reject '.json_encode($arrid));
		return true;
	}
	

	public function actionApproveChecked()
	{
		$result  = 'error';
		
		if(isset($_POST['arrid'])):
			
			$arrid	 = $_POST['arrid'];
			$result  = 'success';
			
			foreach($arrid as $id){
				$model = $this->loadModel($id);		
				$model->approve();
				
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve '.$model->update_seq.' '.$model->error_msg);
			else
				Yii::app()->user->setFlash('success', 'Successfully approve '.json_encode($arrid));
		endif;
		
		echo $result;
	}

	public function actionIndex()
	{
		$model = new Tmanyheader('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['Tmanyheader']))
			$model->attributes=$_GET['Tmanyheader'];

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
