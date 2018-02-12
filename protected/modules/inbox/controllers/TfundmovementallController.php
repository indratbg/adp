<?php

class TfundmovementallController extends AAdminController
{
	public $parent_table_name = 'T_FUND_MOVEMENT';
	public $layout = '//layouts/admin_column3';
	public $menu_name = array('\'FUND MOVEMENT ENTRY\'','\'UPLOAD RDN MUTATION\'','\'IPO FUND ENTRY\'','\'FUND AUTO JOURNAL BCA\'');
	public function actionView($id)
	{ 
		$model			  = $this->loadModel($id);
		$modelParentDetail	  = null;
		$modelParentDetailUpd   = null;
	
		
		if($model->status == AConstant::INBOX_STAT_UPD){
			$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq and update_date =:update_date and table_name=:table_name and upd_status=:upd_status',array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->parent_table_name,'upd_status'=>'U'));
			
			$parentRowid = $listTmanyParentDetail[0]->table_rowid;
			
			
			$listTmanyParentDetail1  = Tmanydetail::model()->findAll('update_seq =:update_seq and update_date =:update_date and table_name=:table_name and upd_status=:upd_status',array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->parent_table_name,'upd_status'=>'I'));
			$modelParentDetailCurr = Tfundmovement::model()->find("rowid ='$parentRowid'"); 
			$modelParentDetail = Tfundmovement::model()->find("rowid ='$parentRowid'");
			
			if(!$listTmanyParentDetail1){
				Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
			}
			else{
				Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail1);
			}
			
			
		
			
			
			
			if($model->approved_status != AConstant::INBOX_APP_STAT_ENTRY):
				
			
				$this->render('view',array(
					'model'=>$model,
					'modelParentDetail'=>$modelParentDetail,
			
				));	
			else:
					
				
				$this->render('view_compare',array(
					'model'=>$model,
					'modelParentDetailCurr'=>$modelParentDetailCurr,
				
					'modelParentDetail'=>$modelParentDetail,
					
				));
			endif;

		}else{
			if($model->status == AConstant::INBOX_STAT_CAN){
				$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq and update_date =:update_date and table_name=:table_name and upd_status=:upd_status',array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->parent_table_name,'upd_status'=>'U'));
				$parentRowid = $listTmanyParentDetail[0]->table_rowid;
				$modelParentDetail = Tfundmovement::model()->find("rowid ='$parentRowid'");
				
			}else{
					
				$modelParentDetail  = new Tfundmovement;
				$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq and update_date =:update_date and table_name=:table_name and upd_status=:upd_status',array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->parent_table_name,'upd_status'=>'I'));
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
		//$model->approve();
		$model->approveTfundmovement();
		
		$sql="select field_value from t_many_detail where table_name='T_FUND_MOVEMENT' AND UPDATE_SEQ='$model->update_seq' AND UPDATE_DATE='$model->update_date' AND FIELD_NAME='CLIENT_CD'";
		$client_cd=DAO::queryRowSql($sql);
		$client=$client_cd['field_value'];
		
		
		
		if($model->error_code < 0)
			//Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
			Yii::app()->user->setFlash('error', 'Approve '.$client.', Error  '.$model->error_code.':'.$model->error_msg);
		else{
			//Yii::app()->user->setFlash('success', 'Successfully approve '.$client);
			Yii::app()->user->setFlash('success', 'Successfully approve '.$client);
			
		/*
			$soc = SocketToFront::getInstance();
					$connectRslt=$soc->connectFO();
					
					if($connectRslt=="OK"){
						 $soc->pushClientCash($client);
						$closeSocketResult = $soc->closeConnection(); 
						if($closeSocketResult!="OK"){
							Yii::app()->user->setFlash('error', 'Error close socket connection ');//,socket url: '.$soc->socketURL());
						}
					}else{
						Yii::app()->user->setFlash('error', 'Push Failed: '.$client);
					}
					*/
		
			
			//Yii::app()->user->setFlash('success', 'Successfully approve '.$hasil); 
		
		}
			//echo $hasil;
		//$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->reject($model->reject_reason);
		
		
			
		$sql="select field_value from t_many_detail where table_name='T_FUND_MOVEMENT' AND UPDATE_SEQ='$model->update_seq' AND UPDATE_DATE='$model->update_date' AND FIELD_NAME='CLIENT_CD'";
		$client_cd=DAO::queryRowSql($sql);
		$client=$client_cd['field_value'];
		
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully reject '.$client);
	}
	
	private function rejectChecked($model,$arrid)
	{ 
		$reject_reason = $model->reject_reason;
		$client = array();
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->reject($reject_reason);
			
			$sql="select field_value from t_many_detail where table_name='T_FUND_MOVEMENT' AND UPDATE_SEQ='$model->update_seq' and update_date='$model->update_date' AND FIELD_NAME='CLIENT_CD'";
					$client_cd=DAO::queryRowSql($sql);
					$client [] =$client_cd['field_value'];
			
			
			
			
			if($model->error_code < 0){
				Yii::app()->user->setFlash('error', 'Error reject '.$model->update_seq.' '.$model->error_msg);
				return false;
			}
		endforeach;
		
		Yii::app()->user->setFlash('success', 'Successfully reject '.json_encode($client));
		return true;
	}
	

	public function actionApproveChecked()
	{
		$result  = 'error';
		
		
		if(isset($_POST['arrid'])):
			
			$arrid	 = $_POST['arrid'];
			$result  = 'success';
			$hasil=array();
			$client_approve =array();
			
			//$soc = new SocketToFront();
		//	 $soc = SocketToFront::getInstance();
			// $connectRslt=$soc->connectFO();
			
			//$x=1;
			foreach($arrid as $id)
			{ 
				$model = $this->loadModel($id);
				//$model->approve();
				$model->approveTfundmovement();
					
		
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
				else{
					
					$sql="select field_value from t_many_detail where table_name='T_FUND_MOVEMENT' AND UPDATE_SEQ='$model->update_seq' and update_date='$model->update_date'  AND FIELD_NAME='CLIENT_CD'";
					$client_cd=DAO::queryRowSql($sql);
					$client=$client_cd['field_value'];
					
					$client_approve[] =$client;
					
				/*
					if($connectRslt=='OK'){
										$soc->pushClientCash($client);
									}*/
				
					}
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve '.$model->update_seq.' '.$model->error_msg);
			else		
				Yii::app()->user->setFlash('success', 'Successfully approve '.json_encode($client_approve));
		/*
			
					if($connectRslt=='OK'){
						$closeSocketResult = $soc->closeConnection(); 
						if($closeSocketResult!="OK"){
							Yii::app()->user->setFlash('error', 'Error close socket connection ');//,socket url: '.$soc->socketURL());
						}
					}else{
						Yii::app()->user->setFlash('error', 'Push Failed: '.json_encode($client_approve));
					}*/
		
		endif;
		
		echo $result;
	}

	public function actionIndex()
	{
		$model = new Vfundmovementinboxall('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = AConstant::INBOX_APP_STAT_ENTRY;
		
		
		if(isset($_GET['Vfundmovementinbox']))
			$model->attributes=$_GET['Vfundmovementinbox'];

		$this->render('index',array(
			'model'=>$model,
			
		));
	}
	
	public function actionIndexProcessed()
	{
		$model = new Tmanyheader('search');
		$model->unsetAttributes();
		$model->menu_name= $this->menu_name;
		$model->approved_status = '<>'.AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['Tmanyheader']))
			$model->attributes=$_GET['Tmanyheader'];

		$this->render('index_processed',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model = Tmanyheader::model()->find("update_seq=:update_seq AND menu_name IN (".implode(',',$this->menu_name).")",array(':update_seq'=>$id));
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
