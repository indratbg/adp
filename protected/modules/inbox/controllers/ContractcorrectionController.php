<?php
ini_set('memory_limit', '128M');
class ContractcorrectionController extends AAdminController
{
	public $menu_name = 'CONTRACT CORRECTION';
	public $table_name = 'T_CONTRACTS';
	
	public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		$modelDetail 	  = array();
		$rowid;
		
		$recordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt',
		'condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq =:update_seq AND table_name =:table_name",'params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name)));
		$listTmanyDetail = array();
		
		$x;
		
		for($x=2;$x<=$recordCount->record_cnt;$x++)
		{
			$listTmanyDetail[$x] = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq AND upd_status = :upd_status",
									array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':record_seq'=>($x),':upd_status'=>'I'));
		}		
										
		for($x=2;$x<=$recordCount->record_cnt;$x++)
		{
			$modelDetail[$x] = new Tcontracts;
			Tmanydetail::generateModelAttributes2($modelDetail[$x], $listTmanyDetail[$x]);
		}
		
		$listTmanyDetailCancel = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq AND upd_status = :upd_status",
									array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':record_seq'=>'1',':upd_status'=>'C'));
		
		$modelDetailCancel = Tcontracts::model()->find("rowid ='$listTmanyDetailCancel->table_rowid'");
		
		$this->render('view',array(
			'model'=>$model,
			'modelDetail' => $modelDetail,
			'modelDetailCancel' => $modelDetailCancel
		));	
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
		$model->approveContractCorrection();
		/*
		$qrowid = Tmanydetail::model()->find(array('select'=>'table_rowid','condition'=>"update_seq = '$model->update_seq' and update_date = to_date('$model->update_date','YYYY-MM-DD HH24:MI:SS') and table_rowid is not null and upd_status = 'C'"));
		$rowid = $qrowid->table_rowid;
		$qclient = Tcontracts::model()->find(array('select'=>'client_cd','condition'=>"rowid = '$rowid'"));
		$client = $qclient->client_cd;
		*/
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve contract correction');
		
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
			//$arrclient = '';
			//$cnt = 1;
			
			foreach($arrid as $id)
			{
				$model = $this->loadModel($id);
				$model->approveContractCorrection();
				/*
				$qrowid = Tmanydetail::model()->find(array('select'=>'table_rowid','condition'=>"update_seq = '$model->update_seq' and update_date = to_date('$model->update_date','YYYY-MM-DD HH24:MI:SS') and table_rowid is not null and upd_status = 'C'"));
				$rowid = $qrowid->table_rowid;
				$qclient = Tcontracts::model()->find(array('select'=>'client_cd','condition'=>"rowid = '$rowid'"));
				$client = $qclient->client_cd;
				
				if($cnt == 1){
					$arrclient = $client;
				}else{
					$arrclient = $arrclient.', '.$client;
				}
				
				$cnt++;
				*/
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve '.$model->update_seq.' '.$model->error_msg);
			else
				Yii::app()->user->setFlash('success', 'Successfully approve contract correction');
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
