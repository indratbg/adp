<?php

class ImportController extends AAdminController
{
	public $menu_name = 'IMPORT REKENING DANA';
	public $parent_table_name = 'MST_CLIENT_FLACCT';
	
	
	public function actionView($id)
	{ 
		$model			  = $this->loadModel($id);
		$modelParentDetail	  = null;
		$modelParentDetailUpd   = null;
	
		
		if($model->status == AConstant::INBOX_STAT_UPD){
			$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq and update_date=:update_date and table_name=:table_name and upd_status=:upd_status',array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->parent_table_name,'upd_status'=>'U'));
			
			$parentRowid = $listTmanyParentDetail[0]->table_rowid;
			
			
			$listTmanyParentDetail1  = Tmanydetail::model()->findAll('update_seq =:update_seq and update_date=:update_date and table_name=:table_name and upd_status=:upd_status',array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->parent_table_name,'upd_status'=>'I'));
			
			$listTmanyParentDetail2  = Tmanydetail::model()->findAll('update_seq =:update_seq and update_date=:update_date and table_name=:table_name and upd_status=:upd_status',array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->parent_table_name,'upd_status'=>'U'));
			
			
			$modelParentDetailCurr = Clientflacct::model()->find("rowid ='$parentRowid'"); 
			$modelParentDetail = Clientflacct::model()->find("rowid ='$parentRowid'");
			$modelParentDetailNew = Clientflacct::model()->find("rowid ='$parentRowid'");
			
			
			//	Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);//old
				Tmanydetail::generateModelAttributes2($modelParentDetailCurr, $listTmanyParentDetail1);
			
				Tmanydetail::generateModelAttributes2($modelParentDetailNew, $listTmanyParentDetail2);
		
			
				
			
			
			if($model->approved_status != AConstant::INBOX_APP_STAT_ENTRY):
				
			
				$this->render('view',array(
					'model'=>$model,
					'modelParentDetailCurr'=>$modelParentDetailCurr,
					'modelParentDetailNew'=>$modelParentDetailNew,
				));	
			else:
					
				
				$this->render('view_compare',array(
					'model'=>$model,
					'modelParentDetailCurr'=>$modelParentDetailCurr,
					'modelParentDetailNew'=>$modelParentDetailNew,
					'modelParentDetail'=>$modelParentDetail,
					
				));
			endif;

		}else{
			if($model->status == AConstant::INBOX_STAT_CAN){
				$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq and update_date=:update_date and table_name=:table_name and upd_status=:upd_status',array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->parent_table_name,'upd_status'=>'U'));
				$parentRowid = $listTmanyParentDetail[0]->table_rowid;
				$modelParentDetail = Clientflacct::model()->find("rowid ='$parentRowid'");
				
			}else{
				$modelParentDetail  = new Clientflacct;
				$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq and update_date=:update_date and table_name=:table_name and upd_status=:upd_status',array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->parent_table_name,'upd_status'=>'I'));
				Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
								
				
			}
			
			$this->render('view',array(
				'model'=>$model,
				'modelParentDetail'=> $modelParentDetail,
				
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
		//$recordCnt = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq AND table_name =:table_name','params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->child_table_name)));
		$model->approve();
		$client_cd = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$id' AND table_name = '$this->parent_table_name' AND field_name = 'CLIENT_CD'")->field_value;
		
		

		if($model->error_code < 0)
				Yii::app()->user->setFlash('error', 'Approve '.$client_cd.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app() -> user -> setFlash('success', 'Successfully approve ' . $client_cd);
		
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->reject($model->reject_reason);
		$client_cd = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND table_name = '$this->parent_table_name' AND field_name = 'CLIENT_CD'")->field_value;
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$client_cd.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully reject '.$client_cd);
	}
	
	private function rejectChecked($model,$arrid)
	{ 
		$reject_reason = $model->reject_reason;
		$client_cd = array();
		$x = 0;
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->reject($reject_reason);
			$client_cd[] = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$id' AND table_name = '$this->parent_table_name' AND field_name = 'CLIENT_CD'")->field_value;
			if($model->error_code < 0){
					Yii::app()->user->setFlash('error', 'Error reject '.$client_cd[$x].' '.$model->error_msg);
				return false;
			}
$x++;
		endforeach;
		
		Yii::app()->user->setFlash('success', 'Successfully reject '.json_encode($client_cd));
		return true;
	}
	

	public function actionApproveChecked()
	{
		$result  = 'error';
		
		if(isset($_POST['arrid'])):
			
			$arrid	 = $_POST['arrid'];
			$result  = 'success';
			$client_cd = array();
			$x = 0;
			foreach($arrid as $id)
			{
				$model = $this->loadModel($id);
				$model->approve();
				$client_cd[] = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$id' AND table_name = '$this->parent_table_name' AND field_name = 'CLIENT_CD'")->field_value;
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
					$x++;
			}
			
			if($result  == 'error')
			Yii::app() -> user -> setFlash('error', 'Error approve '. $model -> error_code .$client_cd[$x].' '.$model->error_msg);
			else
				Yii::app() -> user -> setFlash('success', 'Successfully approve ' .json_encode($client_cd));
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
			$model->attributes=$_GET['Vfundmovementinbox'];

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
