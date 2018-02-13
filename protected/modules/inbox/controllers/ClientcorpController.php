<?php

class ClientcorpController extends AAdminController
{
	public $menu_name = 'INSTITUTIONAL CLIENT PROFILE ENTRY';
	public $table_client = 'MST_CLIENT';
	public $table_cif = 'MST_CIF';
	public $table_client_inst = 'MST_CLIENT_INST';
	public $table_client_bank = 'MST_CLIENT_BANK';
	public $table_client_autho = 'MST_CLIENT_AUTHO';
	
	public $sp_approve = 'SP_MST_CLIENT_APPROVE';
	
	public $layout = '//layouts/admin_column3';
	
	private function findSubrek($val)
	{
		return($val->field_name == 'SUBREK001' || $val->field_name == 'SUBREK004');
	}
	
	public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		
		$listTmanyClientDetail  = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_client'");
		$listTmanyCifDetail  = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_cif'");
		$listTmanyClientInstDetail  = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_client_inst'");
		
		$clientBankRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_client_bank'"));
		$listTmanyClientBankDetail = array();
		
		$clientAuthoRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_client_autho'"));
		$listTmanyClientAuthoDetail = array();
		
		$x;
		
		for($x=0;$x<$clientBankRecordCount->record_cnt;$x++)
		{
			$listTmanyClientBankDetail[$x] = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_client_bank' AND record_seq = ($x+1)");
		}
		
		for($x=0;$x<$clientAuthoRecordCount->record_cnt;$x++)
		{
			$listTmanyClientAuthoDetail[$x] = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_client_autho' AND record_seq = ($x+1)");
		}
		
		if($model->status == AConstant::INBOX_STAT_UPD){
			$modelClientDetail  = new Client;
			$modelCifDetail  = new Cif;
			$modelClientInstDetail  = new Clientinst;
			$modelClientAuthoDetail = array();
			$modelClientBankDetail = array();
			
			Tmanydetail::generateModelAttributes2($modelClientDetail, $listTmanyClientDetail);
			Tmanydetail::generateModelAttributes2($modelCifDetail, $listTmanyCifDetail);
			Tmanydetail::generateModelAttributes2($modelClientInstDetail, $listTmanyClientInstDetail);
			
			$subrek = array_filter($listTmanyClientDetail,array(__CLASS__,"findSubrek"));
			
			foreach($subrek as $row)
			{
				if($row->field_name == 'SUBREK001')
				{
					$modelClientDetail->subrek001_1 = substr($row->field_value,5,4);
					$modelClientDetail->subrek001_2 = substr($row->field_value,12,2);
				}
				else {
					$modelClientDetail->subrek004_1 = substr($row->field_value,5,4);
					$modelClientDetail->subrek004_2 = substr($row->field_value,12,2);
				}
			}
			
			$clientRowid = $listTmanyClientDetail[0]->table_rowid;
			$cifRowid = $listTmanyCifDetail[0]->table_rowid;
			$clientInstRowid = $listTmanyClientInstDetail[0]->table_rowid;
			
			$modelClientDetailCurr = Client::model()->find("rowid = '$clientRowid'");
			$modelCifDetailCurr = Cif::model()->find("rowid = '$cifRowid'");
			$modelClientInstDetailCurr = Clientinst::model()->find("rowid = '$clientInstRowid'");
			
			$row = VClientSubrek14::model()->find("client_cd = '$modelClientDetailCurr->client_cd'");
			
			if($row)
			{
				$subrek1 = $row->subrek001;
				$modelClientDetailCurr->subrek001_1 = substr($subrek1,5,4);
				$modelClientDetailCurr->subrek001_2 = substr($subrek1,12,2);
				
				
				$subrek4 = $row->subrek004;
				$modelClientDetailCurr->subrek004_1 = substr($subrek4,5,4);
				$modelClientDetailCurr->subrek004_2 = substr($subrek4,12,2);
			}
			
			$modelClientBankDetailCurr = array();
			
			for($x=0;$x<$clientBankRecordCount->record_cnt;$x++)
			{
				if($listTmanyClientBankDetail[$x][0]->table_rowid)
				{
					//Status = UPDATE OR CANCEL
					$childRowid=$listTmanyClientBankDetail[$x][0]->table_rowid;
					
					$temp = Clientbank::model()->findAll(array('select'=>"t.*, rowid",'condition'=>"rowid ='$childRowid'")); //Use 'findAll' instead of 'find' to select rowid
					$modelClientBankDetail[$x] = $temp[0];
					
					if($listTmanyClientBankDetail[$x][0]->upd_status == AConstant::INBOX_STAT_UPD)
					{	
						//Status = UPDATE
						Tmanydetail::generateModelAttributes2($modelClientBankDetail[$x], $listTmanyClientBankDetail[$x]);
					}
					else {
						//Status = CANCEL
						$modelClientBankDetail[$x]->default_flg = 'N';
					}
				}
				else {
					//Status = INSERT
					$modelClientBankDetail[$x] = new Clientbank;
					Tmanydetail::generateModelAttributes2($modelClientBankDetail[$x], $listTmanyClientBankDetail[$x]);
				}
			}

			$modelClientBankDetailCurr = Clientbank::model()->findAll(array('select'=>"t.*, rowid",'condition'=>"cifs = '$modelCifDetailCurr->cifs' AND approved_stat = 'A'"));
			
			foreach ($modelClientBankDetailCurr as $row) {
				$row->default_flg = 'X'; //Indicates that default flag should not be showed on current record
			}
			
			$modelClientAuthoDetailCurr = array();
					
			for($x=0;$x<$clientAuthoRecordCount->record_cnt;$x++)
			{
				if($listTmanyClientAuthoDetail[$x][0]->table_rowid)
				{
					//Status = UPDATE OR CANCEL
					$childRowid=$listTmanyClientAuthoDetail[$x][0]->table_rowid;
					
					$temp = Clientautho::model()->findAll(array('select'=>"t.*, rowid",'condition'=>"rowid ='$childRowid'")); //Use 'findAll' instead of 'find' to select rowid
					$modelClientAuthoDetail[$x] = $temp[0];
					
					if($listTmanyClientAuthoDetail[$x][0]->upd_status == AConstant::INBOX_STAT_UPD)
					{	
						//Status = UPDATE
						Tmanydetail::generateModelAttributes2($modelClientAuthoDetail[$x], $listTmanyClientAuthoDetail[$x]);
					}
				}
				else {
					//Status = INSERT
					$modelClientAuthoDetail[$x] = new Clientautho;
					Tmanydetail::generateModelAttributes2($modelClientAuthoDetail[$x], $listTmanyClientAuthoDetail[$x]);
				}
			}

			$modelClientAuthoDetailCurr = Clientautho::model()->findAll(array('select'=>"t.*, rowid",'condition'=>"cifs = '$modelCifDetailCurr->cifs' AND approved_stat = 'A'"));
			
			$modelClientDetail->cust_client_flg=$modelClientDetail->cust_client_flg=='A'?'Y':'N';
			$modelClientDetail->desp_pref=$modelClientDetail->desp_pref=='Y'?'Y':'N';
			
			$modelClientDetailCurr->cust_client_flg=$modelClientDetailCurr->cust_client_flg=='A'?'Y':'N';			
			$modelClientDetailCurr->desp_pref=$modelClientDetailCurr->desp_pref=='Y'?'Y':'N';
			
			
			if($model->approved_status != AConstant::INBOX_APP_STAT_ENTRY):
				$this->render('view',array(
					'model'=>$model,
					'modelClientDetail'=> $modelClientDetail,
					'modelCifDetail'=> $modelCifDetail,
					'modelClientInstDetail'=> $modelClientInstDetail,
					'modelClientAuthoDetail'=> $modelClientAuthoDetail,
					'modelClientBankDetail' => $modelClientBankDetail,
					'listTmanyClientAuthoDetail'=>$listTmanyClientAuthoDetail,
					'listTmanyClientBankDetail'=>$listTmanyClientBankDetail,
				));	
			else:		
				$this->render('view_compare',array(
					'model'=>$model,
					'modelClientDetail'=> $modelClientDetail,
					'modelCifDetail'=> $modelCifDetail,
					'modelClientInstDetail'=> $modelClientInstDetail,
					'modelClientAuthoDetail'=> $modelClientAuthoDetail,
					'modelClientBankDetail' => $modelClientBankDetail,
					'modelClientDetailCurr'=> $modelClientDetailCurr,
					'modelCifDetailCurr'=> $modelCifDetailCurr,
					'modelClientInstDetailCurr'=> $modelClientInstDetailCurr,
					'modelClientAuthoDetailCurr'=> $modelClientAuthoDetailCurr,
					'modelClientBankDetailCurr' => $modelClientBankDetailCurr,
					'listTmanyClientAuthoDetail'=>$listTmanyClientAuthoDetail,
					'listTmanyClientBankDetail'=>$listTmanyClientBankDetail,
				));
			endif;

		}else{
			if($model->status == AConstant::INBOX_STAT_CAN){
				$clientRowid = $listTmanyClientDetail[0]->table_rowid;
				$modelClientDetail = Client::model()->find("rowid ='$clientRowid'");
				for($x=0;$x<$clientBankRecordCount->record_cnt;$x++)
				{
					$childRowid=$listTmanyClientBankDetail[$x][0]->table_rowid;
					$modelClientBankDetail[$x] = Clientbank::model()->find("rowid ='$childRowid'");
				}
				
				$modelClientDetail->cust_client_flg=$modelClientDetail->cust_client_flg=='A'?'Y':'N';
				$modelClientDetail->desp_pref=$modelClientDetail->desp_pref=='Y'?'Y':'N';
				
				$this->render('view',array(
					'model'=>$model,
					'modelClientDetail'=> $modelClientDetail,
					'modelCifDetail'=> $modelCifDetail,
					'modelClientInstDetail'=> $modelClientInstDetail,
					'modelClientBankDetail' => $modelClientBankDetail,
					'listTmanyClientBankDetail'=>$listTmanyClientBankDetail,
				));	
			}else{
				$modelClientDetail  = new Client;
				$modelCifDetail  = new Cif;
				$modelClientInstDetail  = new Clientinst;
				$modelClientBankDetail = array();
				$modelClientAuthoDetail = array();
				
				Tmanydetail::generateModelAttributes2($modelClientDetail, $listTmanyClientDetail);
				Tmanydetail::generateModelAttributes2($modelCifDetail, $listTmanyCifDetail);
				Tmanydetail::generateModelAttributes2($modelClientInstDetail, $listTmanyClientInstDetail);
				
				$subrek = array_filter($listTmanyClientDetail,array(__CLASS__,"findSubrek"));
				
				foreach($subrek as $row)
				{
					if($row->field_name == 'SUBREK001')
					{
						$modelClientDetail->subrek001_1 = substr($row->field_value,5,4);
						$modelClientDetail->subrek001_2 = substr($row->field_value,12,2);
					}
					else {
						$modelClientDetail->subrek004_1 = substr($row->field_value,5,4);
						$modelClientDetail->subrek004_2 = substr($row->field_value,12,2);
					}
				}
							
				if($listTmanyCifDetail[0]->upd_status == AConstant::INBOX_STAT_INS)
				{
					//NEW CIF
					for($x=0;$x<$clientBankRecordCount->record_cnt;$x++)
					{
						$modelClientBankDetail[$x] = new Clientbank;
						Tmanydetail::generateModelAttributes2($modelClientBankDetail[$x], $listTmanyClientBankDetail[$x]);
					}
					
					for($x=0;$x<$clientAuthoRecordCount->record_cnt;$x++)
					{
						$modelClientAuthoDetail[$x] = new Clientautho;
						Tmanydetail::generateModelAttributes2($modelClientAuthoDetail[$x], $listTmanyClientAuthoDetail[$x]);
					}
					
					$modelClientDetail->cust_client_flg=$modelClientDetail->cust_client_flg=='A'?'Y':'N';
					$modelClientDetail->desp_pref=$modelClientDetail->desp_pref=='Y'?'Y':'N';
					
					$this->render('view',array(
						'model'=>$model,
						'modelClientDetail'=> $modelClientDetail,
						'modelCifDetail'=> $modelCifDetail,
						'modelClientInstDetail'=> $modelClientInstDetail,
						'modelClientAuthoDetail'=> $modelClientAuthoDetail,
						'modelClientBankDetail' => $modelClientBankDetail,
						'listTmanyClientAuthoDetail'=>$listTmanyClientAuthoDetail,
						'listTmanyClientBankDetail'=>$listTmanyClientBankDetail,
					));	
				}
				else {
					//EXISTING CIF
					$cifRowid = $listTmanyCifDetail[0]->table_rowid;
					$clientInstRowid = $listTmanyClientInstDetail[0]->table_rowid;
					
					$modelCifDetailCurr = Cif::model()->find("rowid = '$cifRowid'");
					$modelClientInstDetailCurr = Clientinst::model()->find("rowid = '$clientInstRowid'");
							
					$modelClientBankDetailCurr = array();
					
					for($x=0;$x<$clientBankRecordCount->record_cnt;$x++)
					{
						if($listTmanyClientBankDetail[$x][0]->table_rowid)
						{
							//Status = UPDATE OR CANCEL
							$childRowid=$listTmanyClientBankDetail[$x][0]->table_rowid;
							
							$temp = Clientbank::model()->findAll(array('select'=>"t.*, rowid",'condition'=>"rowid ='$childRowid'")); //Use 'findAll' instead of 'find' to select rowid
							$modelClientBankDetail[$x] = $temp[0];
							
							if($listTmanyClientBankDetail[$x][0]->upd_status == AConstant::INBOX_STAT_UPD)
							{	
								//Status = UPDATE
								Tmanydetail::generateModelAttributes2($modelClientBankDetail[$x], $listTmanyClientBankDetail[$x]);
							}
							else {
								//Status = CANCEL
								$modelClientBankDetail[$x]->default_flg = 'N';
							}
						}
						else {
							//Status = INSERT
							$modelClientBankDetail[$x] = new Clientbank;
							Tmanydetail::generateModelAttributes2($modelClientBankDetail[$x], $listTmanyClientBankDetail[$x]);
						}
					}
					
					$modelClientBankDetailCurr = Clientbank::model()->findAll(array('select'=>"t.*, rowid",'condition'=>"cifs = '$modelCifDetailCurr->cifs' AND approved_stat = 'A'"));
					
					foreach ($modelClientBankDetailCurr as $row) {
						$row->default_flg = 'X'; //Indicates that default flag should not be showed on current record
					}
					
					$modelClientAuthoDetailCurr = array();
					
					for($x=0;$x<$clientAuthoRecordCount->record_cnt;$x++)
					{
						if($listTmanyClientAuthoDetail[$x][0]->table_rowid)
						{
							//Status = UPDATE OR CANCEL
							$childRowid=$listTmanyClientAuthoDetail[$x][0]->table_rowid;
							
							$temp = Clientautho::model()->findAll(array('select'=>"t.*, rowid",'condition'=>"rowid ='$childRowid'")); //Use 'findAll' instead of 'find' to select rowid
							$modelClientAuthoDetail[$x] = $temp[0];
							
							if($listTmanyClientAuthoDetail[$x][0]->upd_status == AConstant::INBOX_STAT_UPD)
							{	
								//Status = UPDATE
								Tmanydetail::generateModelAttributes2($modelClientAuthoDetail[$x], $listTmanyClientAuthoDetail[$x]);
							}
						}
						else {
							//Status = INSERT
							$modelClientAuthoDetail[$x] = new Clientautho;
							Tmanydetail::generateModelAttributes2($modelClientAuthoDetail[$x], $listTmanyClientAuthoDetail[$x]);
						}
					}

					$modelClientAuthoDetailCurr = Clientautho::model()->findAll(array('select'=>"t.*, rowid",'condition'=>"cifs = '$modelCifDetailCurr->cifs' AND approved_stat = 'A'"));
					
					$modelClientDetail->cust_client_flg=$modelClientDetail->cust_client_flg=='A'?'Y':'N';
					$modelClientDetail->desp_pref=$modelClientDetail->desp_pref=='Y'?'Y':'N';
					
					if($model->approved_status != AConstant::INBOX_APP_STAT_ENTRY):
						$this->render('view',array(
							'model'=>$model,
							'modelClientDetail'=> $modelClientDetail,
							'modelCifDetail'=> $modelCifDetail,
							'modelClientInstDetail'=> $modelClientInstDetail,
							'modelClientAuthoDetail'=> $modelClientAuthoDetail,
							'modelClientBankDetail' => $modelClientBankDetail,
							'listTmanyClientAuthoDetail'=>$listTmanyClientAuthoDetail,
							'listTmanyClientBankDetail'=>$listTmanyClientBankDetail,
						));	
					else:	
						$this->render('view_compare',array(
							'model'=>$model,
							'modelClientDetail'=> $modelClientDetail,
							'modelCifDetail'=> $modelCifDetail,
							'modelClientInstDetail'=> $modelClientInstDetail,
							'modelClientAuthoDetail'=> $modelClientAuthoDetail,
							'modelClientBankDetail' => $modelClientBankDetail,
							'modelCifDetailCurr'=> $modelCifDetailCurr,
							'modelClientInstDetailCurr'=> $modelClientInstDetailCurr,
							'modelClientAuthoDetailCurr'=> $modelClientAuthoDetailCurr,
							'modelClientBankDetailCurr' => $modelClientBankDetailCurr,
							'listTmanyClientAuthoDetail'=>$listTmanyClientAuthoDetail,
							'listTmanyClientBankDetail'=>$listTmanyClientBankDetail,
						));	
					endif;
				}	
			}				
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
		$model->approve($this->sp_approve);
		
		$client_cd = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND table_name = 'MST_CLIENT' AND field_name = 'CLIENT_CD'")->field_value;
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$client_cd.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve '.$client_cd);
		
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->reject($model->reject_reason);	
		$client_cd = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND table_name = 'MST_CLIENT' AND field_name = 'CLIENT_CD'")->field_value;
		
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
			$client_cd[] = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND table_name = 'MST_CLIENT' AND field_name = 'CLIENT_CD'")->field_value;
			
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
				$model->approve($this->sp_approve);
				$client_cd[] = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND table_name = 'MST_CLIENT' AND field_name = 'CLIENT_CD'")->field_value;
				
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
				$x++;
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve '.$client_cd[$x].' '.$model->error_msg);
			else
				Yii::app()->user->setFlash('success', 'Successfully approve '.json_encode($client_cd));
		endif;
		
		echo $result;
	}

	public function actionIndex()
	{
		$model = new Vinboxclientprofile('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['Vinboxclientprofile']))
			$model->attributes=$_GET['Vinboxclientprofile'];

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
