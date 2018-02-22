<?php

class GljournalledgerController extends AAdminController
{
	public $menu_name = array('\'REPO JOURNAL\',\'HMETD OWN PORTO JOURNAL\'','\'GL JOURNAL ENTRY\'','\'UPLOAD MULTI JOURNAL\'','\'GENERATE OTC FEE JOURNAL\'','\'GENERATE MARKET INFO FEE JOURNAL\'','\'GENERATE REPO INTEREST JOURNAL\'');	
	//public $menu_name = 'GL JOURNAL ENTRY';
	public $parent_table_name = 'T_JVCHH';
	public $child_table_name = 'T_ACCOUNT_LEDGER';
	public $layout = '//layouts/admin_column3';
	
	public function actionGetSlAcct()
	{
		$i=0;
      	$src=array();
      	$term = strtoupper($_REQUEST['term']);
      	$glAcctCd = $_REQUEST['gl_acct_cd'];
      	
      	$qSearch = DAO::queryAllSql("
					SELECT sl_a, acct_name FROM MST_GL_ACCOUNT 
					WHERE TRIM(gl_a) = '$glAcctCd' 
					AND sl_a LIKE '".$term."%'
					AND prt_type <> 'S'
					AND acct_stat = 'A'
					AND approved_stat = 'A'
	      			AND rownum <= 15
	      			ORDER BY sl_a
      			");
      
	    foreach($qSearch as $search)
	    {
	      	$src[$i++] = array('label'=>$search['sl_a'].' - '.$search['acct_name']
	      			, 'labelhtml'=>$search['sl_a'].' - '.$search['acct_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['sl_a']);
	    }
      
      	echo CJSON::encode($src);
      	Yii::app()->end();
	}
	public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		$modelParentDetail	  = null;
		$modelParentDetailUpd   = null;
		$modelChildDetail = array();
		$modelChildDetailUpd = array();
		
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
			
			
			$modelParentDetailCurr = Tjvchh::model()->find("rowid ='$parentRowid'"); 
			$modelParentDetail = Tjvchh::model()->find("rowid ='$parentRowid'");
			$doc_num_lama = Tjvchh::model()->find("rowid = '$parentRowid' ")->jvch_num;
			$listTmanyParentDetail =Tmanydetail::model()->findAll('update_seq =:update_seq and update_date=:update_date AND table_name =:table_name and record_seq=\'1\'',array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->parent_table_name));
			Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
			
			$modelChildDetailCurr = Taccountledger::model()->findAll("xn_doc_num = '$doc_num_lama' and approved_sts='A' ");
			
			$cek = Tmanydetail::model()->find("update_seq = '$model->update_seq' and update_date='$model->update_date' and table_name='$this->parent_table_name' and upd_status = 'C'");
			
			if($cek){
			$childRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt',
				'condition'=>"update_seq =:update_seq and update_date=:update_date AND table_name =:table_name and field_name =:field_name AND SUBSTR(NVL(FIELD_VALUE,'XX'),1,2)  <> 'RJ'",
				'params'=>array(':update_seq'=>$model->update_seq,':update_date'=>$model->update_date,':table_name'=>$this->child_table_name,':field_name'=>'FOLDER_CD')));
			
			for($x=0;$x<$childRecordCount->record_cnt;$x++)
			{
			
				//Status = INSERT
				$modelChildDetail[$x] = new Taccountledger;
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
							$modelChildDetailCurr[$x] = Taccountledger::model()->find("rowid ='$childRowid'");
							$modelChildDetail[$x] = Taccountledger::model()->find("rowid ='$childRowid'");
							if($listTmanyChildDetail[$x][0]->upd_status == 'U')
							{	
								//Status = UPDATE
								Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
							}
						}
						else {
							//Status = INSERT
							$modelChildDetail[$x] = new Taccountledger;
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
				$modelParentDetail = Tjvchh::model()->find("rowid ='$parentRowid->table_rowid'");
				$doc_num_lama =  Tjvchh::model()->find("rowid ='$parentRowid->table_rowid'")->jvch_num;
				$modelChildDetail = Taccountledger::model()->findAll("xn_doc_num = '$doc_num_lama' and approved_sts='A'");
				
				
			}else{
				$modelParentDetail  = new Tjvchh;
				Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
								
				for($x=0;$x<$childRecordCount->record_cnt;$x++)
				{
					$modelChildDetail[$x] = new Taccountledger;
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

	public function actionUpdate($id)
	{
		$cek_folder = Sysparam::model()->find("param_id='SYSTEM' AND PARAM_CD1='VCH_REF'")->dflg1;
		$sign=Sysparam::model()->find("param_id='SYSTEM' and param_cd1='DOC_REF'");
		$cek_branch = Sysparam::model()->find("param_id='SYSTEM' and param_cd1='CHECK' AND PARAM_CD2='ACCTBRCH'")->dflg1;
		$valid = true;
		$modelDetail = array();
		$modelHeader = $this->loadModel($id);
		//ambil t_folder	
		$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq and update_date=:update_date AND table_name =:table_name',array(':update_seq'=>$modelHeader->update_seq,':update_date'=>$modelHeader->update_date,':table_name'=>$this->parent_table_name));
		$model = new Tjvchh;
		Tmanydetail::generateModelAttributes2($model, $listTmanyParentDetail);
		$listTmanyFolder  = Tmanydetail::model()->findAll('update_seq =:update_seq and update_date=:update_date AND table_name =:table_name',array(':update_seq'=>$modelHeader->update_seq,':update_date'=>$modelHeader->update_date,':table_name'=>'T_FOLDER'));
		
		//ambil t_folder
		$modelFolder = new Tfolder;
		Tmanydetail::generateModelAttributes2($modelFolder, $listTmanyFolder);
		
		//ambil t_account_ledger
		$childRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq and update_date=:update_date AND table_name =:table_name','params'=>array(':update_seq'=>$modelHeader->update_seq,':update_date'=>$modelHeader->update_date,':table_name'=>$this->child_table_name)));
		for($x=0;$x<$childRecordCount->record_cnt;$x++)
		{
			$listTmanyChildDetail[$x] = Tmanydetail::model()->findAll('update_seq =:update_seq and update_date=:update_date AND table_name =:table_name AND record_seq = :record_seq',array(':update_seq'=>$modelHeader->update_seq,':update_date'=>$modelHeader->update_date,':table_name'=>$this->child_table_name,':record_seq'=>($x+1)));
		}
		for($x=0;$x<$childRecordCount->record_cnt;$x++)
		{
			$modelDetail[$x] = new Taccountledger;
			Tmanydetail::generateModelAttributes2($modelDetail[$x], $listTmanyChildDetail[$x]);
		}	
	
		$model->scenario='insert';
		
		if(isset($_POST['Tjvchh']))
		{
			$connection  = Yii::app()->db;
			$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
			$user_id =Yii::app()->user->id;
				$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			$ip_address = $ip;
			//reject data lama
			$modelHeader->rejectUpdEntry($modelHeader->cancel_reason);	
		
				
			$model->attributes=$_POST['Tjvchh'];
			$valid = $model->validate();
			
			$rowCount = $_POST['rowCount'];
			
			//get all data t_account_ledger
			for($x=0;$x<$rowCount;$x++)
			{
				if(isset($_POST['Taccountledger'][$x+1]['save_flg']) && $_POST['Taccountledger'][$x+1]['save_flg'] == 'Y')
				{
					$modelDetail[$x] = new Taccountledger;
					$modelDetail[$x]->attributes=$_POST['Taccountledger'][$x+1];
					
			if(DateTime::createFromFormat('Y/m/d H:i:s',$modelDetail[$x]->netting_date))$modelDetail[$x]->netting_date = DateTime::createFromFormat('Y/m/d H:i:s',$modelDetail[$x]->netting_date)->format('Y-m-d');
			if(DateTime::createFromFormat('Y/m/d H:i:s',$modelDetail[$x]->arap_due_date))$modelDetail[$x]->arap_due_date = DateTime::createFromFormat('Y/m/d H:i:s',$modelDetail[$x]->arap_due_date)->format('Y-m-d');
					if($cek_branch == 'Y')
					{
						$sl_acct_cd =trim($modelDetail[0]->sl_acct_cd);
						$gl=trim($modelDetail[$x]->gl_acct_cd);
						$sl=trim($modelDetail[$x]->sl_acct_cd);
						
						$query="SELECT brch_cd from mst_gl_account where sl_a= '$sl_acct_cd'";
						$getquery=DAO::queryRowSql($query);
						$branch=$getquery['brch_cd'];
					
						if($branch)
						{
							$sqlbranch="SELECT brch_cd FROM MST_GL_ACCOUNT WHERE BRCH_CD= '$branch' and gl_a='$gl' and sl_a='$sl'";
							$cekAcct=DAO::queryRowSql($sqlbranch);
							if(!$cekAcct)
							{
								$modelDetail[$x]->addError('gl_acct_cd','Harus dari branch yang sama');
								$valid=false;
							}
						}
					}
					$valid = $modelDetail[$x]->validate() && $valid;
				}	
			}
			
			if($valid)
			{
				
			
				$menuName = $modelHeader->menu_name;
					
				
				$tanggal=$model->jvch_date;
				$sql="SELECT GET_DOCNUM_GL(to_date('$tanggal','yyyy-mm-dd'),'GL') as jvch_num from dual";
				$num=DAO::queryRowSql($sql);
				$jvch_num=$num['jvch_num'];
				$model->jvch_num= $jvch_num;
				$model->jvch_type='GL';
				$model->curr_cd='IDR';
				$model->reversal_jur='N';
				
				if($model->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0)$success = true;
				
				if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$model->jvch_num,1) > 0)$success = true;
				else {
					$success = false;
				}
				if($cek_folder =='Y')
				{
					//insert t_forder
					$modelFolder->fld_mon = DateTime::createFromFormat('Y-m-d',$model->jvch_date)->format('my');
					$modelFolder->folder_cd = $model->folder_cd;
					$modelFolder->doc_date = $model->jvch_date;
					$modelFolder->doc_num = $jvch_num;
					$modelFolder->user_id= $model->user_id;
					if($success && $modelFolder->validate() && $modelFolder->executeSp(AConstant::INBOX_STAT_INS, $modelFolder->doc_num, $model->update_date, $model->update_seq, 1) > 0)$success = true;
					else {
						$success = false;
					}
				}
				$recordSeq = 1;
				
				
				//insert t_account_ledger
				for($x=0; $success && $x<$rowCount ;$x++)
				{ 
					if($modelDetail[$x]->save_flg == 'Y')
					{
				
					$client=trim($modelDetail[$x]->sl_acct_cd);
					$gl_a=trim($modelDetail[$x]->gl_acct_cd);
					$sql_client="SELECT acct_type FROM MST_CLIENT c,mst_gl_account m WHERE client_cd = sl_a and sl_a='$client' and trim(gl_a)='$gl_a'";
					$client_cd=DAO::queryRowSql($sql_client);
					$acct_type = $client_cd['acct_type'];
					if($acct_type){
						$modelDetail[$x]->acct_type = $acct_type;
					}
							$modelDetail[$x]->tal_id=$recordSeq;
							$modelDetail[$x]->xn_doc_num=$model->jvch_num;
							$modelDetail[$x]->folder_cd=$model->folder_cd;
							$modelDetail[$x]->doc_date=$model->jvch_date;
							$modelDetail[$x]->due_date=$modelDetail[$x]->doc_date;
							$modelDetail[$x]->reversal_jur='N';
							$modelDetail[$x]->curr_cd='IDR';
							$modelDetail[$x]->budget_cd='GL';
							$modelDetail[$x]->manual='Y';
							$modelDetail[$x]->record_source='GL';
							$modelDetail[$x]->xn_val = $modelDetail[$x]->curr_val;
							$modelDetail[$x]->user_id = $model->user_id;
							$modelDetail[$x]->cre_dt = $model->cre_dt;;
							if($sign == 'Y')
							{
							$modelDetail[$x]->doc_ref_num = $modelDetail[$x]->xn_doc_num;
							}
					 		
						if($success && $modelDetail[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelDetail[$x]->xn_doc_num,$modelDetail[$x]->tal_id,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
						else {
							$success = false;
						}
						$recordSeq++;
					}	
				}
				
				if($success)
				{	
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Saved');
					$this->redirect(array('/inbox/Gljournalledger/index'));
				}
				else 
				{
					$transaction->rollback();
				}
			}
			
			
		}

		
		if(DateTime::createFromFormat('Y/m/d H:i:s',$model->jvch_date))$model->jvch_date = DateTime::createFromFormat('Y/m/d H:i:s',$model->jvch_date)->format('d/m/Y'); 
		if(DateTime::createFromFormat('Y-m-d',$model->jvch_date))$model->jvch_date = DateTime::createFromFormat('Y-m-d',$model->jvch_date)->format('d/m/Y');
		foreach($modelDetail as $row)
		{
			$row->save_flg='Y';
			$row->gl_acct_cd = trim($row->gl_acct_cd);
		}
		
		
		
		$this->render('update',array('model'=>$model,
									'modelDetail'=>$modelDetail,
									//'modelDetailOlt'=>$modelDetailOlt,
									'modelHeader'=>$modelHeader,
									'modelFolder'=>$modelFolder,
									'update_seq'=>$id,
									'cek_folder'=>$cek_folder));
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
		$model->approveGlJournal();
		$folder_cd = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$id' AND table_name = '$this->parent_table_name' AND field_name = 'FOLDER_CD'")->field_value;
	
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$folder_cd.', Error  '.$model->error_code.':'.$model->error_msg);
		else{
			Yii::app()->user->setFlash('success', 'Successfully approve '.$folder_cd);
	
	/*
		$client = Tmanydetail::model()->findAll("UPDATE_SEQ='$id'  AND FIELD_NAME='SL_ACCT_CD' AND TABLE_NAME='T_ACCOUNT_LEDGER'");
			
			
			
			
					//$soc = new SocketToFront();
					$soc = SocketToFront::getInstance();
					$connectRslt=$soc->connectFO();
					$clientsToPushed=array();
					
					foreach($client as $row){
						
						$push = Client::model()->find("client_cd = '$row->field_value' ");
						
						if($push)
						{
							$clientsToPushed[] =$push->client_cd;	
							if($connectRslt=="OK"){
								$soc->pushClientCash($push->client_cd);
							}	
						}
						
					}
					
					//$soc->closeConnection();
					//klo konek socket OK , close socket
					if($connectRslt=='OK'){
						$closeSocketResult = $soc->closeConnection(); 
						if($closeSocketResult!="OK"){
							//Yii::app()->user->setFlash('error', 'Error close socket connection ,socket url: '.$soc->socketURL());
							Yii::app()->user->setFlash('error', 'Error close socket connection ');//,socket url: '.$soc->socketURL());
						}
					}else{
						//Yii::app()->user->setFlash('error', 'Push Failed: Error Connect Socket:  '.$connectRslt." ,socket url: ".$soc->socketURL());
						Yii::app()->user->setFlash('error', 'Push Failed '.$folder_cd.' clients: '.json_encode($clientsToPushed));
					}
					*/
	
		
		}
		
		
		//$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->reject($model->reject_reason);
		$folder_cd = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND table_name = '$this->parent_table_name' AND field_name = 'FOLDER_CD'")->field_value;
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$folder_cd.', Error  '.$model->error_code.':'.$model->error_msg);
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
			$folder_cd[]= Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND table_name = '$this->parent_table_name' AND field_name = 'FOLDER_CD'")->field_value;
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
				$model->approveGlJournal();
				
				
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
		else {
				$folder_cd[] = Tmanydetail::model()->find("update_seq = '$id' and update_date ='$model->update_date' AND table_name = 'T_JVCHH' AND field_name = 'FOLDER_CD'")->field_value;
				
				
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
				Yii::app()->user->setFlash('success', 'Successfully approve '.json_encode($folder_cd));
			
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
		$model = new Vgljournalinbox('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['Vgljournalinbox']))
			$model->attributes=$_GET['Vgljournalinbox'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionIndexProcessed()
	{
		$model = new Vinboxprocessgljournal('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = '<>'.AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['Vinboxprocessgljournal']))
			$model->attributes=$_GET['Vinboxprocessgljournal'];

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
