<?php

class TclientdepositController extends AAdminController
{
	public $menu_name = 'DEPOSIT CLIENT ENTRY';
	public $table_name = 'T_CLIENT_DEPOSIT';
	public $layout = '//layouts/admin_column3';
	public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		$modelChildDetail = array();
		$modelChildDetailUpd = array();
		
		
		$childRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq and update_date =:update_date AND table_name =:table_name','params'=>array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->table_name)));
		$listTmanyChildDetail = array();
		
		$x;
		
		for($x=0;$x<$childRecordCount->record_cnt;$x++)
		{
			$listTmanyChildDetail[$x] = Tmanydetail::model()->findAll('update_seq =:update_seq and update_date =:update_date AND table_name =:table_name AND record_seq = :record_seq',array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->table_name,':record_seq'=>($x+1)));
		}
		
		if($model->status == AConstant::INBOX_STAT_UPD){
			
			$modelChildDetailCurr = array();
			
			for($x=0;$x<$childRecordCount->record_cnt;$x++)
			{
				if($listTmanyChildDetail[$x][0]->table_rowid)
				{
					//Status = UPDATE OR CANCEL
					$childRowid=$listTmanyChildDetail[$x][0]->table_rowid;
					$modelChildDetailCurr[$x] = Tclientdeposit::model()->find("rowid ='$childRowid'");
					$modelChildDetail[$x] = Tclientdeposit::model()->find("rowid ='$childRowid'");
					if($listTmanyChildDetail[$x][0]->upd_status == 'U')
					{	
						//Status = UPDATE
						Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
					}
				}
				else {
					//Status = INSERT
					$modelChildDetail[$x] = new Tclientdeposit;
					Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
				}
			}
			
			
		foreach($modelChildDetail as $row)
		{
		if(DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_date))$row->trx_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_date)->format('d M Y');
		if(DateTime::createFromFormat('Y/m/d H:i:s',$row->trx_date))$row->trx_date=DateTime::createFromFormat('Y/m/d H:i:s',$row->trx_date)->format('d M Y');
		}
		foreach($modelChildDetailCurr as $row)
		{
		if(DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_date))$row->trx_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_date)->format('d M Y');
		if(DateTime::createFromFormat('Y/m/d H:i:s',$row->trx_date))$row->trx_date=DateTime::createFromFormat('Y/m/d H:i:s',$row->trx_date)->format('d M Y');
		}
			
			
			if($model->approved_status != AConstant::INBOX_APP_STAT_ENTRY):
				$this->render('view',array(
					'model'=>$model,
				//	'modelParentDetail'=>$modelParentDetail,
					'modelChildDetail' => $modelChildDetail,
					'listTmanyChildDetail'=>$listTmanyChildDetail,
				));	
			else:
				
				$this->render('view_compare',array(
					'model'=>$model,
					'modelChildDetailCurr'=>$modelChildDetailCurr,
					'modelChildDetail' =>$modelChildDetail,
					'listTmanyChildDetail'=>$listTmanyChildDetail,
				));
			endif;

		}else{
			if($model->status == AConstant::INBOX_STAT_CAN){
				// $parentRowid = $listTmanyParentDetail[0]->table_rowid;
				// $modelParentDetail = Tclientdeposit::model()->find("rowid ='$parentRowid'");
				// for($x=0;$x<$childRecordCount->record_cnt;$x++)
				// {
					// $childRowid=$listTmanyChildDetail[$x][0]->table_rowid;
					// $modelChildDetail[$x] = Tclientdeposit::model()->find("rowid ='$childRowid'");
				// }
			}else{
					
				for($x=0;$x<$childRecordCount->record_cnt;$x++)
				{
					$modelChildDetail[$x] = new Tclientdeposit;
					Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
				}
			}
			foreach($modelChildDetail as $row){
		if(DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_date))$row->trx_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->trx_date)->format('d M Y');
		if(DateTime::createFromFormat('Y/m/d H:i:s',$row->trx_date))$row->trx_date=DateTime::createFromFormat('Y/m/d H:i:s',$row->trx_date)->format('d M Y');
			}
			
			$this->render('view',array(
				'model'=>$model,
				'modelChildDetail' => $modelChildDetail,
				'listTmanyChildDetail'=>$listTmanyChildDetail,
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
		
		$client_cd = Tmanydetail::model()->find("update_seq='$model->update_seq' and update_date = '$model->update_date' and table_name='T_CLIENT_DEPOSIT' AND FIELD_NAME='CLIENT_CD' ")->field_value;
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->client_cd.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve '.$client_cd);
		
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->reject($model->reject_reason);
		$client_cd = Tmanydetail::model()->find("update_seq='$model->update_seq' and update_date = '$model->update_date' and table_name='T_CLIENT_DEPOSIT' AND FIELD_NAME='CLIENT_CD' ")->field_value;
		
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$client_cd.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully reject '.$client_cd);
	}
	
	private function rejectChecked($model,$arrid)
	{
		$reject_reason = $model->reject_reason;
		$hasil=array();
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->reject($reject_reason);
			$client_cd = Tmanydetail::model()->find("update_seq='$id' and table_name='T_CLIENT_DEPOSIT' AND FIELD_NAME='CLIENT_CD' ")->field_value;
			$hasil[]=$client_cd;
			if($model->error_code < 0){
				Yii::app()->user->setFlash('error', 'Error reject '.$model->update_seq.' '.$model->error_msg);
				return false;
			}
		endforeach;
		
		Yii::app()->user->setFlash('success', 'Successfully reject '.json_encode($hasil));
		return true;
	}
	

	public function actionApproveChecked()
	{
		$result  = 'error';
		
		if(isset($_POST['arrid'])):
			
			$arrid	 = $_POST['arrid'];
			$result  = 'success';
			$hasil=array();
			foreach($arrid as $id)
			{
				$model = $this->loadModel($id);
				$model->approve();
					$client_cd = Tmanydetail::model()->find("update_seq='$id' and table_name='T_CLIENT_DEPOSIT' AND FIELD_NAME='CLIENT_CD' ")->field_value;
					$hasil[]=$client_cd;
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve '.$model->update_seq.' '.$model->error_msg);
			else
				Yii::app()->user->setFlash('success', 'Successfully approve '.json_encode($hasil));
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
