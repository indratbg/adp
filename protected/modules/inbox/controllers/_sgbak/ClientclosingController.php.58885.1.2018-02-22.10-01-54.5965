<?php

class ClientclosingController extends AAdminController
{
	public $menu_name = 'CLIENT CLOSING';
	public $table_name = 'T_CLIENT_CLOSING';
	
	public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		
		$glCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq =:update_seq AND table_name =:table_name",
		'params'=>array(':update_seq'=>$model->update_seq,':table_name'=>'MST_GL_ACCOUNT')));
		$flacctCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq =:update_seq AND table_name =:table_name",
		'params'=>array(':update_seq'=>$model->update_seq,':table_name'=>'MST_CLIENT_FLACCT')));
		$listGlAccount = array();
		$modelGlAccount = array();
		$modelGlAccountUpd = array();
		$modelClient = null;
		$modelClientUpd = null;
		$modelClientFlacct = null;
		$modelClientFlacctUpd = null;
		$subrek001 = null;
				
		for($x=1;$x<=$glCount->record_cnt;$x++)
		{
			$listGlAccount[$x] = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq AND upd_status = :upd_status",
								array(':update_seq'=>$model->update_seq,':table_name'=>'MST_GL_ACCOUNT',':record_seq'=>($x),':upd_status'=>'U'));
			$modelGlAccount[$x] = Glaccount::model()->find("rowid = '".$listGlAccount[$x]->table_rowid."'");
			
			$modelGlAccountUpd[$x] = Glaccount::model()->find("rowid = '".$listGlAccount[$x]->table_rowid."'");
			$modelGlAccountUpd[$x]->acct_stat = 'C';
		}

		for($x=1;$x<=$flacctCount->record_cnt;$x++)
		{
			$listClientFlacct[$x] = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq AND upd_status = :upd_status",
								array(':update_seq'=>$model->update_seq,':table_name'=>'MST_CLIENT_FLACCT',':record_seq'=>($x),':upd_status'=>'U'));
			$modelClientFlacct[$x] = Clientflacct::model()->find("rowid = '".$listClientFlacct[$x]->table_rowid."'");
			
			$modelClientFlacctUpd[$x] = Clientflacct::model()->find("rowid = '".$listClientFlacct[$x]->table_rowid."'");
			$modelClientFlacctUpd[$x]->acct_stat = 'C';
		}
		
		
		$listTclientclosing = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq AND upd_status = :upd_status",
							array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':record_seq'=>1,':upd_status'=>'I'));
		$modelTclientclosing = new TClientclosing;
		Tmanydetail::generateModelAttributes2($modelTclientclosing, $listTclientclosing);
		
		$listClient = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq AND upd_status = :upd_status AND field_name = :field_name",
					array(':update_seq'=>$model->update_seq,':table_name'=>'MST_CLIENT',':record_seq'=>1,':upd_status'=>'U',':field_name'=>'CLIENT_CD'));
		
		if($listClient){
			$listClosed = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq =:update_seq AND table_name =:table_name AND record_seq = 
			:record_seq AND upd_status = :upd_status AND field_name IN ('CLOSED_DATE') ORDER BY field_name",
					array(':update_seq'=>$model->update_seq,':table_name'=>'MST_CLIENT',':record_seq'=>1,':upd_status'=>'U'));
			$clientcdval = $listClient->field_value;
			$listSubrek = VClientSubrek14::model()->find('client_cd = :client_cd',array(':client_cd'=>$clientcdval));
			if($listSubrek)
				$subrek001 = $listSubrek->subrek001;
			else{
				$subrek001 = '-';
			}
			$modelClient = Client::model()->find("rowid = '$listClient->table_rowid'");
			
			$modelClientUpd = Client::model()->find("rowid = '$listClient->table_rowid'");
			$modelClientUpd->susp_stat = 'C';
			$modelClientUpd->closed_date = $listClosed[0]->field_value;
			//$modelClientUpd->closed_ref = $listClosed[1]->field_value;
		}
		
		//var_dump($subrek001);
		//die();
		
		if($model->approved_status <> 'E'){
			$this->render('view',array(
				'model'=>$model,
				'modelTclientclosing' => $modelTclientclosing,
				'modelClient' => $modelClient,
				'modelClientFlacct' => $modelClientFlacct,
				'modelClientUpd' => $modelClientUpd,
				'modelClientFlacctUpd' => $modelClientFlacctUpd,
				'modelGlAccount' => $modelGlAccount,
				'modelGlAccountUpd' => $modelGlAccountUpd,
				'subrek001' => $subrek001
			));	
		}else{
			$this->render('view_compare',array(
				'model'=>$model,
				'modelTclientclosing' => $modelTclientclosing,
				'modelClient' => $modelClient,
				'modelClientFlacct' => $modelClientFlacct,
				'modelClientUpd' => $modelClientUpd,
				'modelClientFlacctUpd' => $modelClientFlacctUpd,
				'modelGlAccount' => $modelGlAccount,
				'modelGlAccountUpd' => $modelGlAccountUpd,
				'subrek001' => $subrek001
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
		$model->approveClientClosing();
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve '.$model->error_code.'. Mohon lakukan penutupan sub rekening di KSEI.');
		
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
				$model->approveClientClosing();
				
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve '.$model->update_seq.' '.$model->error_msg);
			else
				Yii::app()->user->setFlash('success', 'Successfully approve '.json_encode($arrid).'. Mohon lakukan penutupan sub rekening di KSEI.');
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
