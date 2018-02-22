<?php

class FixedassetmovementController extends AAdminController
{
	public $menu_name = 'FASSET MOVEMENT ENTRY';
	public $parent_table_name = 'T_FASSET_MOVEMENT';
	public $child_table_name = 'MST_FIXED_ASSET';
	
	public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		$modelParentDetail	  = null;
		$modelParentDetailUpd   = null;
		$modelChildDetail = array();
		$modelChildDetailUpd = array();
		// var_dump($model->update_seq);die();
		//$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name',array(':update_seq'=>$model->update_seq,':table_name'=>$this->parent_table_name));
		
		$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_date=:update_date and update_seq =:update_seq AND table_name =:table_name',array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->parent_table_name));
	//	$childRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq AND table_name =:table_name','params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->child_table_name)));
		$childRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq and update_date =:update_date AND table_name =:table_name','params'=>array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->child_table_name)));
		$listTmanyChildDetail = array();
		
		$x;
		
		for($x=0;$x<$childRecordCount->record_cnt;$x++)
		{
			$listTmanyChildDetail[$x] = Tmanydetail::model()->findAll('update_seq =:update_seq and update_date =:update_date AND table_name =:table_name AND record_seq = :record_seq',array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->child_table_name,':record_seq'=>($x+1)));
		}
		
		if($model->status == AConstant::INBOX_STAT_UPD){
			
			$parentRowid = Tmanydetail::model()->find("update_seq = '$model->update_seq' and update_date='$model->update_date' and table_name='$this->parent_table_name' and table_rowid is not null ")->table_rowid;
			
			
			$modelParentDetailCurr = Fixedassetmovement::model()->find("rowid ='$parentRowid'"); 
			$modelParentDetail = Fixedassetmovement::model()->find("rowid ='$parentRowid'");
			$asset_cd = Fixedassetmovement::model()->find("rowid = '$parentRowid' ")->asset_cd;
			$listTmanyParentDetail =Tmanydetail::model()->findAll('update_seq =:update_seq and update_date=:update_date AND table_name =:table_name and record_seq=\'1\'',array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->parent_table_name));
			Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
			
			$modelChildDetailCurr = Fixedasset::model()->findAll("asset_cd = '$asset_cd' and approved_stat='A' ");
			
			$cek = Tmanydetail::model()->find("update_seq = '$model->update_seq' and update_date='$model->update_date' and table_name='$this->parent_table_name' and upd_status = 'C'");
			
			if($cek){
			$childRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt',
				'condition'=>"update_seq =:update_seq and update_date=:update_date AND table_name =:table_name and field_name =:field_name AND SUBSTR(NVL(FIELD_VALUE,'XX'),1,2)  <> 'RJ'",
				'params'=>array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->child_table_name,':field_name'=>'FOLDER_CD')));
			
			for($x=0;$x<$childRecordCount->record_cnt;$x++)
			{
			
				//Status = INSERT
				$modelChildDetail[$x] = new Fixedasset;
				Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
				
			}
			}
			else{
					for($x=0;$x<$childRecordCount->record_cnt;$x++)
					{
						if($listTmanyChildDetail[$x][0]->table_rowid)
						{
							//Status = UPDATE OR CANCEL
							$childRowid=$listTmanyChildDetail[$x][0]->table_rowid;
							$modelChildDetailCurr[$x] = Fixedasset::model()->find("rowid ='$childRowid'");
							$modelChildDetail[$x] = Fixedasset::model()->find("rowid ='$childRowid'");
							if($listTmanyChildDetail[$x][0]->upd_status == 'U')
							{	
								//Status = UPDATE
								Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
							}
						}
						else {
							//Status = INSERT
							$modelChildDetail[$x] = new Fixedasset;
							Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
						}
					}
			}
			
			
			if($model->approved_status != AConstant::INBOX_APP_STAT_ENTRY):
				$this->render('view',array(
					'model'=>$model,
					'modelParentDetail'=>$modelParentDetail,
					'modelChildDetail' => $modelChildDetail,
					'listTmanyChildDetail'=>$listTmanyChildDetail,
				));	
			else:
				
				$this->render('view_compare',array(
					'model'=>$model,
					'modelParentDetailCurr'=>$modelParentDetailCurr,
					'modelChildDetailCurr'=>$modelChildDetailCurr,
					'modelParentDetail'=>$modelParentDetail,
					'modelChildDetail' =>$modelChildDetail,
					'listTmanyChildDetail'=>$listTmanyChildDetail,
				));
			endif;

		}else{
			if($model->status == AConstant::INBOX_STAT_CAN){
				
				$parentRowid = Tmanydetail::model()->find("update_seq = '$model->update_seq' and update_date='$model->update_date' and table_name = '$this->parent_table_name' and table_rowid is not null");
				$modelParentDetail = Fixedassetmovement::model()->find("rowid ='$parentRowid->table_rowid'");
				$asset_cd_lama =  Fixedassetmovement::model()->find("rowid ='$parentRowid->table_rowid'")->asset_cd;
				$modelChildDetail = Fixedasset::model()->findAll("asset_cd = '$asset_cd_lama' and approved_stat='A'");
				
				
			}else{
				$modelParentDetail  = new Fixedassetmovement;
				Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
								
				for($x=0;$x<$childRecordCount->record_cnt;$x++)
				{
					$modelChildDetail[$x] = new Fixedasset;
					Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
				}
			}
			
			$this->render('view',array(
				'model'=>$model,
				'modelParentDetail'=> $modelParentDetail,
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
	
		//$recordCnt = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq AND table_name =:table_name','params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->child_table_name)));
		$model->approve();
	
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$model->update_seq.', Error  '.$model->error_code.':'.$model->error_msg);
		else{
			Yii::app()->user->setFlash('success', 'Successfully approve '.$model->update_seq);
			
		}
		
		
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->reject($model->reject_reason);
		$folder_cd = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND table_name = '$this->parent_table_name' OR table_name = '$this->child_table_name' AND field_name = 'FASSET MOVEMENT ENTRY'")->field_value;
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully reject '.$folder_cd);
	}
	
	private function rejectChecked($model,$arrid)
	{
		$reject_reason = $model->reject_reason;
		$folder_cd=array();
		$x=0;
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->reject($reject_reason);
			$folder_cd[]= Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND table_name = '$this->parent_table_name' AND field_name = 'FASSET MOVEMENT ENTRY'")->field_value;
			if($model->error_code < 0){
				Yii::app()->user->setFlash('error', 'Error reject '.$folder_cd[$x].' '.$model->error_msg);
				return false;
			}
		$x++;
		endforeach;
		
		Yii::app()->user->setFlash('success', 'Successfully reject '.json_encode($folder_cd));
		return true;
	}
	

	public function actionApproveChecked()
	{
		
		$result  = 'error';
		
		if(isset($_POST['arrid'])):
			
			$arrid	 = $_POST['arrid'];
			$result  = 'success';
			$folder_cd=array();
			$x = 0;
			//$soc = new SocketToFront();
			// $soc = SocketToFront::getInstance();
			// $connectRslt=$soc->connectFO();
			
			foreach($arrid as $id)
			{
				$model = $this->loadModel($id);
				$model->approve();
				
				
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
		else {
				// $folder_cd[] = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND table_name = '$this->parent_table_name' AND field_name = 'FASSET MOVEMENT ENTRY'")->field_value;
				
				
				/*
					$client = Tmanydetail::model()->findAll("UPDATE_SEQ='$id'  AND FIELD_NAME='SL_ACCT_CD' AND TABLE_NAME='T_ACCOUNT_LEDGER'");
								
							
								if($connectRslt=='OK'){
												foreach($client as $row){
													$push = Client::model()->find("client_cd = '$row->field_value' ");
											
													if($push){
														$soc->pushClientCash($push->client_cd);
													}
											
												}
											}*/
				
			
				
				}

				$x++;
			}

			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve  '.$model->error_code.':'.$model->error_msg);
			else
				Yii::app()->user->setFlash('success', 'Successfully approve ');
			
	/*
	
				
					//$soc->closeConnection(); 
					//klo konek socket OK , close socket
					if($connectRslt=='OK'){
						$closeSocketResult = $soc->closeConnection(); 
						if($closeSocketResult!="OK"){
							Yii::app()->user->setFlash('error', 'Error close socket connection ,socket url: '.$soc->socketURL());
						}
					}else{
						//Yii::app()->user->setFlash('error', 'Push Failed: Error Connect Socket:  '.$connectRslt." ,socket url: ".$soc->socketURL());
						Yii::app()->user->setFlash('error', 'Push Failed '.json_encode($folder_cd));
					}
		*/
	
			
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
		$model = Tmanyheader::model()->find("update_seq=:update_seq AND menu_name=:menu_name",array(':update_seq'=>$id,':menu_name'=>$this->menu_name));
		
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
