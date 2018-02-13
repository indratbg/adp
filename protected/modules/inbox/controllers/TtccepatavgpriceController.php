<?php

class TtccepatavgpriceController extends AAdminController
{
	public $menu_name = 'TC CEPAT AVG PRICE';
	public $table_name = 'T_TC_CEPAT';
		
	public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		
		if($model->status == AConstant::INBOX_STAT_UPD){
			$modelDetail 	  = array();
			$rowid;
			
			$recordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq AND table_name =:table_name','params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name)));
			$listTmanyDetail = array();
			
			$x;
			
			for($x=2;$x<=$recordCount->record_cnt;$x++)
			{
				$listTmanyDetail[$x] = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq AND upd_status = :upd_status',
										array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':record_seq'=>($x),':upd_status'=>'I'));
			}		
											
			for($x=2;$x<=$recordCount->record_cnt;$x++)
			{
				$modelDetail[$x] = new Ttccepat;
				Tmanydetail::generateModelAttributes2($modelDetail[$x], $listTmanyDetail[$x]);
			}
			
			
			$listTmanyDetailCancel = Tmanydetail::model()->find('update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq AND upd_status = :upd_status',
										array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':record_seq'=>'1',':upd_status'=>'C'));
			
			//var_dump($listTmanyDetailCancel->table_rowid);
			//die();
			$modelDetailCancel = Ttccepat::model()->find("rowid ='$listTmanyDetailCancel->table_rowid'");
			
			$clientsource = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>'update_seq =:update_seq AND table_name =:table_name AND field_name =:field_name',
							'params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':field_name'=>'FROM_CLIENT_CD'),'distinct'=>'true'));
			$stksource = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>'update_seq =:update_seq AND table_name =:table_name AND field_name =:field_name',
							'params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':field_name'=>'STK_CD'),'distinct'=>'true'));
			$belijualsource = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>'update_seq =:update_seq AND table_name =:table_name AND field_name =:field_name',
							'params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':field_name'=>'TRX_TYPE'),'distinct'=>'true'));
			$modelDetailSource = Vfotdtradetc::model()->find(array('condition'=>'client_cd = :client_cd AND belijual = :belijual AND stk_cd = :stk_cd',
							'params'=>array(':client_cd'=>$clientsource->field_value,'belijual'=>$belijualsource->field_value,'stk_cd'=>$stksource->field_value)));
			
		}else if($model->status == AConstant::INBOX_STAT_INS){
			$modelDetail 	  = array();
			$rowid;
			
			$recordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq AND table_name =:table_name','params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name)));
			$listTmanyDetail = array();
			
			$x;
			
			for($x=2;$x<=$recordCount->record_cnt;$x++)
			{
				$listTmanyDetail[$x] = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq AND upd_status = :upd_status',
										array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':record_seq'=>($x),':upd_status'=>'I'));
			}		
											
			for($x=2;$x<=$recordCount->record_cnt;$x++)
			{
				$modelDetail[$x] = new Ttccepat;
				Tmanydetail::generateModelAttributes2($modelDetail[$x], $listTmanyDetail[$x]);
			}
			
			
			$modelDetailCancel = null;
			$clientsource = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>'update_seq =:update_seq AND table_name =:table_name AND field_name =:field_name',
							'params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':field_name'=>'FROM_CLIENT_CD'),'distinct'=>'true'));
			$stksource = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>'update_seq =:update_seq AND table_name =:table_name AND field_name =:field_name',
							'params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':field_name'=>'STK_CD'),'distinct'=>'true'));
			$belijualsource = Tmanydetail::model()->find(array('select'=>'field_value','condition'=>'update_seq =:update_seq AND table_name =:table_name AND field_name =:field_name',
							'params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':field_name'=>'TRX_TYPE'),'distinct'=>'true'));
			$modelDetailSource = Vfotdtradetc::model()->find(array('condition'=>'client_cd = :client_cd AND belijual = :belijual AND stk_cd = :stk_cd',
							'params'=>array(':client_cd'=>$clientsource->field_value,'belijual'=>$belijualsource->field_value,'stk_cd'=>$stksource->field_value)));
			
		}else{
			$modelDetail = null;
			$modelDetailSource = null;
			$listTmanyDetailCancel = Tmanydetail::model()->find('update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq AND upd_status = :upd_status',
										array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':record_seq'=>'1',':upd_status'=>'C'));
			
			//var_dump($listTmanyDetailCancel->table_rowid);
			//die();
			$modelDetailCancel = Ttccepat::model()->find("rowid ='$listTmanyDetailCancel->table_rowid'");
		}
		
		$this->render('view',array(
			'model'=>$model,
			'modelDetail' => $modelDetail,
			'modelDetailCancel' => $modelDetailCancel,
			'modelDetailSource' => $modelDetailSource
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
		//$recordCnt = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq AND table_name =:table_name','params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name)));
		$model->approveTcCepatAvgPrice();
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve '.$model->update_seq);
		
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
			
			foreach($arrid as $id)
			{
				$model = $this->loadModel($id);
				$model->approveTcCepatAvgPrice();
				
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
