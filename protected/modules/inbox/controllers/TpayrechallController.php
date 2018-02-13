<?php

class TpayrechallController extends AAdminController
{
	public $menu_name = array("'IPO FUND ENTRY'","'VOUCHER ENTRY'","'KPEI VOUCHER ENTRY'","'UPLOAD VOUCHER NON TRANSAKSI'","'GENERATE VOUCHER BOND TRX'","'GENERATE RECEIPT DIVIDEN VOUCHER'","'GENERATE VOUCHER SETTLE TRX'","'GENERATE VOUCHER TRANSFER RDI','GENERATE VOUCHER TRANSFER KSEI','GENERATE VOUCHER TENDER OFFER','GENERATE VOUCHER DIVIDEN ALL','GENERATE PAYMENT DIVIDEN VOUCHER','GENERATE VOUCHER PAYMENT FUND' ");
	public $parent_table_name = 'T_PAYRECH';
	public $child_table_name = 'T_ACCOUNT_LEDGER';
	
	public $sp_approve = 'SP_T_PAYRECH_APPROVE';
	public $sp_reject = 'SP_T_PAYRECH_REJECT';
	
	public $layout = '//layouts/admin_column3';
	
	public function actionView($update_date, $update_seq)
	{
		$model			  = $this->loadModel($update_seq);
		$modelParentDetail	  = null;
		$modelParentDetailUpd   = null;
		$modelChildDetail = array();
		$modelChildDetailUpd = array();
		
		if($model->status == AConstant::INBOX_STAT_UPD)
		{
			//$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name AND record_seq = 1',array(':update_seq'=>$model->update_seq,':table_name'=>$this->parent_table_name));
			$listTmanyParentDetail  = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->parent_table_name' AND record_seq = 1");
		}
		else
		{
			//$listTmanyParentDetail  = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name',array(':update_seq'=>$model->update_seq,':table_name'=>$this->parent_table_name));
			$listTmanyParentDetail  = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->parent_table_name'");
		}
		
		//$childRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>'update_seq =:update_seq AND table_name =:table_name','params'=>array(':update_seq'=>$model->update_seq,':table_name'=>$this->child_table_name)));
		$childRecordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->child_table_name'"));
		$listTmanyChildDetail = array();
		
		$x;
		
		for($x=0;$x<$childRecordCount->record_cnt;$x++)
		{
			$listTmanyChildDetail[$x] = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name ='$this->child_table_name' AND record_seq = ($x+1)");
		}
		
		if($model->status == AConstant::INBOX_STAT_UPD){	
			
			$modelChildDetailCurr = array();
			
			$reversal = Tmanydetail::model()->find("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->parent_table_name' AND upd_status = 'C'");
			
			if($reversal)
			{
				// REVERSAL
				$listTmanyParentDetailCancel = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name ='$this->parent_table_name' AND upd_status = 'C'");
				$parentRowid = $listTmanyParentDetailCancel[0]->table_rowid;
			
				$modelParentDetailCurr = Tpayrech::model()->find("rowid ='$parentRowid'"); 
				$modelParentDetail = new Tpayrech;
			
				Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
				
				$modelChildDetailCurr = Taccountledger::model()->findAll("xn_doc_num = '$modelParentDetailCurr->payrec_num' AND approved_sts = 'A'");
				
				for($x=0,$y=0;$x<$childRecordCount->record_cnt;$x++)
				{
					$modelChildDetail[$y] = new Taccountledger;
					Tmanydetail::generateModelAttributes2($modelChildDetail[$y], $listTmanyChildDetail[$x]);
					
					if($modelChildDetail[$y]->record_source == 'RE')
					{
						unset($modelChildDetail[$y]);
					}
					else {
						$y++;
					}
				}
			}
			else 
			{
				// NON REVERSAL
				$parentRowid = $listTmanyParentDetail[0]->table_rowid;
			
				$modelParentDetailCurr = Tpayrech::model()->find("rowid ='$parentRowid'"); 
				$modelParentDetail = new Tpayrech;
			
				Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
				
				$modelChildDetailCurr = Taccountledger::model()->findAll("xn_doc_num = '$modelParentDetail->payrec_num' AND approved_sts = 'A'");
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
				$parentRowid = $listTmanyParentDetail[0]->table_rowid;
				$modelParentDetail = Tpayrech::model()->find("rowid ='$parentRowid'");

				$modelChildDetail = Taccountledger::model()->findAll("xn_doc_num = '$modelParentDetail->payrec_num' AND approved_sts = 'A'");

			}else{
				$modelParentDetail  = new Tpayrech;
				Tmanydetail::generateModelAttributes2($modelParentDetail, $listTmanyParentDetail);
								
				for($x=0;$x<$childRecordCount->record_cnt;$x++)
				{
					$modelChildDetail[$x] = new Taccountledger;
					Tmanydetail::generateModelAttributes2($modelChildDetail[$x], $listTmanyChildDetail[$x]);
				}
				
				/*if(substr($modelParentDetail->payrec_type ,1,1) == 'D') //Non Transaction
				{
					$modelChildDetailFirst = new Tpayrecd;
					$modelChildDetailFirst->gl_acct_cd = $modelParentDetail->gl_acct_cd;
					$modelChildDetailFirst->sl_acct_cd = $modelParentDetail->sl_acct_cd;
					$modelChildDetailFirst->payrec_amt = $modelParentDetail->curr_amt;
					$modelChildDetailFirst->remarks = $modelParentDetail->remarks;
					$modelChildDetailFirst->tal_id = 90;
					$modelChildDetailFirst->doc_date = $modelParentDetail->payrec_date;
					$modelChildDetailFirst->db_cr_flg = substr($modelParentDetail->payrec_type,0,1) == 'R'?'D':'C'; 

					$modelChildDetail = array_merge(array($modelChildDetailFirst),$modelChildDetail);
				}	*/			
			}
			
			$this->render('view',array(
				'model'=>$model,
				'modelParentDetail'=> $modelParentDetail,
				'modelChildDetail' => $modelChildDetail,
				'listTmanyChildDetail'=>$listTmanyChildDetail,
			));	
		}
	}

	public function actionAjxCheckAP()
	{
		$seq = $_POST['seq'];
		
		if(is_array($seq))
		{
			// Approve Checked
			
			$totalRecord = count($seq);
			$status = $_POST['status'];
			$client_cd = $_POST['clientCd'];
			$payrec_type = $_POST['payrecType'];
			$amount = $_POST['amount'];
			$update_seq = $payrec_amt = $cum_bal = $basic_limit = $fo_balance = $fo_stockvaldisc = array();
			$error_code = $error_msg = '';
			// AS : 22 Nov 2016
			// Added IF below so the validation runs whenever only 1 item is being approved, otherwise it does not run
			$error_code = 1;
			$error_msg = '';
			$isnotify = 'N';
			if($totalRecord == 1){
				$isnotify = 'Y';
				for($x=0;$x<$totalRecord;$x++)
				{
					if($status[$x] == 'Insert' && $client_cd[$x] && $payrec_type[$x] == "P")
					{
						$getUpdateDate = DAO::queryRowSql("
							select to_char(update_date, 'YYYY-MM-DD HH24:MI:SS') as update_date from T_MANY_HEADER
							where update_seq = $seq[0] and approved_status = 'E'
						");

						if(isset($getUpdateDate)){
							$upddt = $getUpdateDate['update_date'];
							$isclient = DAO::queryRowSql("
								select 0 as cnt from 
								dual
							");
							
							if($isclient['cnt'] > 0){
							
								$result = DAO::queryRowSql("SELECT F_CLIENT_SOA_BAL('{$client_cd[$x]}') cum_bal FROM dual");
								$update_seq[] = $seq[$x];
								$payrec_amt[] = $amount[$x];
								$cum_bal[] = $result['cum_bal'];
								
								$connection  = Yii::app()->db;
								
								try{
									$query   = "CALL SP_GET_FO_BALANCE(
												:P_CLIENT_CD,
												:P_BASIC_LIMIT,
												:P_FO_BALANCE,
												:P_FO_STOCKVALDISC,
											    :P_ERROR_CODE,
											    :P_ERROR_MSG)";
											
									$command = $connection->createCommand($query);
									$command->bindValue(":P_CLIENT_CD",$client_cd[$x],PDO::PARAM_STR);
									$command->bindParam(":P_BASIC_LIMIT",$basic_limit[],PDO::PARAM_STR,50);
									$command->bindParam(":P_FO_BALANCE",$fo_balance[],PDO::PARAM_STR,50);
									$command->bindParam(":P_FO_STOCKVALDISC",$fo_stockvaldisc[],PDO::PARAM_STR,50);
									$command->bindParam(":P_ERROR_CODE",$error_code,PDO::PARAM_STR,10);
									$command->bindParam(":P_ERROR_MSG",$error_msg,PDO::PARAM_STR,2000);
									
									$command->execute();
									
								}catch(Exception $ex){
									$error_code = -999;
									$error_msg = $ex->getMessage();
								}
								
								if($error_code < 0)
								{
									$error_msg = $client_cd[$x].' '.$error_msg;
									break;
								}
							}else{
								$isnotify = 'N';
							}
						}else{
							$error_code = -999;
							$error_msg = 'Update date not found!';
						}
					}
				}
			}
			
			/*
			$payrec_amt = 0;
			$cum_bal = 0;
			$basic_limit = 0;
			$fo_balance = 0;
			$fo_stockvaldisc = 0;*/
			
			
			$result = $error_code > 0 ?
						array('error_code'=>$error_code,'error_msg'=>$error_msg,'update_seq'=>$update_seq,
							'amount'=>$payrec_amt,'cum_bal'=>$cum_bal,'basic_limit'=>$basic_limit,'fo_balance'=>$fo_balance,
							'fo_stockvaldisc'=>$fo_stockvaldisc,'isnotify'=>$isnotify) :
						array('error_code'=>$error_code,'error_msg'=>$error_msg);
			
			echo json_encode($result);
		}
		else 
		{
			// Approve single data
			
			$update_seq = $_POST['seq'];
			/*
			$result = DAO::queryRowSql("SELECT update_date FROM T_MANY_HEADER WHERE update_seq = $update_seq");
			$update_date = $result['update_date'];
			
			$result = DAO::queryRowSql("SELECT field_value 
										FROM T_MANY_DETAIL
										WHERE update_date = TO_DATE('$update_date','YYYY-MM-DD HH24:MI:SS')
										AND update_seq = $update_seq
										AND table_name = 'T_PAYRECH'
										AND record_seq = 1
										AND field_name = 'CURR_AMT'");									
			$amount = $result['field_value'];*/
			$isnotify = 'Y';
			$error_code = 1;
			$error_msg = '';
			$cum_bal = $basic_limit = $fo_balance = $fo_stockvaldisc = 0;
			$client_cd = $_POST['clientCd'];
			
			$getUpdateDate = DAO::queryRowSql("
					select to_char(update_date, 'YYYY-MM-DD HH24:MI:SS') as update_date from T_MANY_HEADER
					where update_seq = $update_seq and approved_status = 'E'
				");

			if(isset($getUpdateDate)){
				$upddt = $getUpdateDate['update_date'];
				$isclient = DAO::queryRowSql("
					select 0 as cnt from 
					dual
				");
					
				if($isclient['cnt'] > 0){
	
					$result = DAO::queryRowSql("SELECT F_CLIENT_SOA_BAL('$client_cd') cum_bal FROM dual");
					$cum_bal = $result['cum_bal'];
					
					$connection  = Yii::app()->db;
					
					$basic_limit = $fo_balance = $fo_stockvaldisc = $error_code = $error_msg = '';
					
					try{
						$query   = "CALL SP_GET_FO_BALANCE(
									:P_CLIENT_CD,
									:P_BASIC_LIMIT,
									:P_FO_BALANCE,
									:P_FO_STOCKVALDISC,
								    :P_ERROR_CODE,
								    :P_ERROR_MSG)";
								
						$command = $connection->createCommand($query);
						$command->bindValue(":P_CLIENT_CD",$client_cd,PDO::PARAM_STR);
						$command->bindParam(":P_BASIC_LIMIT",$basic_limit,PDO::PARAM_STR,50);
						$command->bindParam(":P_FO_BALANCE",$fo_balance,PDO::PARAM_STR,50);
						$command->bindParam(":P_FO_STOCKVALDISC",$fo_stockvaldisc,PDO::PARAM_STR,50);
						$command->bindParam(":P_ERROR_CODE",$error_code,PDO::PARAM_STR,10);
						$command->bindParam(":P_ERROR_MSG",$error_msg,PDO::PARAM_STR,2000);
						
						$command->execute();
						
					}catch(Exception $ex){
						$error_code = -999;
						$error_msg = $ex->getMessage();
					}
				}else{
					$isnotify = 'N';
				}
			}
			
			$result = $error_code > 0 ?
						array('error_code'=>$error_code,'error_msg'=>$error_msg,'cum_bal'=>$cum_bal,'basic_limit'=>$basic_limit,
							'fo_balance'=>$fo_balance,'fo_stockvaldisc'=>$fo_stockvaldisc,'isnotify'=>$isnotify) :
						array('error_code'=>$error_code,'error_msg'=>$error_msg);
			
			echo json_encode($result);
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
		$model->approve($this->sp_approve);
		
		$detail = Tmanydetail::model()->findAll(array('condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND TABLE_NAME = 'T_PAYRECH' AND field_name IN ('PAYREC_NUM','CLIENT_CD','FOLDER_CD') AND RECORD_SEQ = 1",'order'=>'field_name'));
		
		$client_cd = $detail[0]->field_value?'&nbsp;&nbsp;'.$detail[0]->field_value:'';
		$folder_cd = $detail[1]->field_value?'&nbsp;&nbsp;'.$detail[1]->field_value:'';
		$payrec_num = $detail[2]->field_value;
				
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '/*.$payrec_num*/.$folder_cd.$client_cd.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully approve '/*.$payrec_num*/.$folder_cd.$client_cd);
		
		$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->reject($model->reject_reason,$this->sp_reject);
		
		$detail = Tmanydetail::model()->findAll(array('condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND TABLE_NAME = 'T_PAYRECH' AND field_name IN ('PAYREC_NUM','CLIENT_CD','FOLDER_CD') AND RECORD_SEQ = 1",'order'=>'field_name'));
		
		$client_cd = $detail[0]->field_value?'&nbsp;&nbsp;'.$detail[0]->field_value:'';
		$folder_cd = $detail[1]->field_value?'&nbsp;&nbsp;'.$detail[1]->field_value:'';
		$payrec_num = $detail[2]->field_value;
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Reject '/*.$payrec_num*/.$folder_cd.$client_cd.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully reject '/*.$payrec_num*/.$folder_cd.$client_cd);
	}
	
	private function rejectChecked($model,$arrid)
	{
		$reject_reason = $model->reject_reason;
		
		$client_cd = array();
		$folder_cd = array();
		$payrec_num = array();
		$key = array();
		
		$x = 0;
		
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->reject($reject_reason,$this->sp_reject);
			
			$detail = Tmanydetail::model()->findAll(array('condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND TABLE_NAME = 'T_PAYRECH' AND field_name IN ('PAYREC_NUM','CLIENT_CD','FOLDER_CD') AND RECORD_SEQ = 1",'order'=>'field_name'));
		
			$client_cd[] = $detail[0]->field_value?'&nbsp;&nbsp;'.$detail[0]->field_value:'';
			$folder_cd[] = $detail[1]->field_value?'&nbsp;&nbsp;'.$detail[1]->field_value:'';
			$payrec_num[] = $detail[2]->field_value;
			
			$key[] = /*$payrec_num[$x].*/$folder_cd[$x].$client_cd[$x];
			
			if($model->error_code < 0){
				Yii::app()->user->setFlash('error', 'Error reject '/*.$payrec_num[$x]*/.$folder_cd[$x].$client_cd[$x].' '.$model->error_msg);
				return false;
			}
			
			$x++;
		endforeach;
		
		Yii::app()->user->setFlash('success', 'Successfully reject '.json_encode($key));
		return true;
	}
	public function actionApproveChecked()
	{
		
		$result  = 'error';
		
		if(isset($_REQUEST['arrid'])):
			
			$arrid	 = $_REQUEST['arrid'];
			$result  = 'success';
			
			$model = new Tmanyheader;
			if($model->approveVoucherAll($arrid)>0)
			{
				Yii::app()->user->setFlash('success', $model->error_msg);
				$this->redirect(array('index'));
			}
			else 
			{
				Yii::app()->user->setFlash('error', 'Error approve  '.$model->error_code.':'.$model->error_msg);
				$this->redirect(array('index'));
			}
			
		 endif;
			
		echo $result;
	}
	public function actionApproveallkbb()
	{
			$result['status']  = 'error';
			$model = new Tmanyheader;
			if($model->approveVoucherAllRDI()>0)
			{
				Yii::app()->user->setFlash('success', $model->error_msg);
				$result['status']  = 'success';
			}
			else 
			{
				Yii::app()->user->setFlash('error', 'Error approve  '.$model->error_code.':'.$model->error_msg);
			}
			
		echo json_encode($result);
	}



	public function actionApproveCheckedBackup24feb2017()
	{
		$result  = 'error';
		
		if(isset($_POST['arrid'])) { //Approve multiple records at once
			$this->layout='//layouts/mainload';
			
			$arrId = $_POST['arrid'];
			$result  = 'success';
			
			$client_cd = $folder_cd = '';
			$key = array();
			if(isset($_POST['arrkey'])) {
				$key = $_POST['arrkey'];
			}
			
			$totalAll = count($arrId);
			if(isset($_POST['total_all'])) {
				$totalAll = $_POST['total_all'];
			}
			
			$processed = $arrId;
			$cntProcessPerBath = min(1, count($arrId));
			
			for($i=0;$i<$cntProcessPerBath; $i++) {
				$model = $this->loadModel($arrId[$i]);
				$model->approve($this->sp_approve);
				
				$sql = "SELECT field_value 
						FROM T_MANY_DETAIL
						WHERE update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS')
						AND update_seq = '$model->update_seq' 
						AND TABLE_NAME = 'T_PAYRECH' 
						AND field_name IN ('CLIENT_CD','FOLDER_CD') 
						AND record_seq = 1
						ORDER BY field_name";
				$detail = DAO::queryAllSql($sql);
		
				$client_cd = $detail[0]['field_value']?' - '.$detail[0]['field_value']:'';
				$folder_cd = $detail[1]['field_value']?' - '.$detail[1]['field_value']:'';
				
				$key[] = $folder_cd.$client_cd;
				
				if($model->error_code < 0){
					$result  = 'error';
					break;
				} else {
					unset($processed[$i]);
				}
			}

			if($result  == 'error') {
				Yii::app()->user->setFlash('error', 'Error approve '.$folder_cd.$client_cd.' '.$model->error_msg);
				$this->redirect(array('index'));
			}
			else {
				if(count($processed) > 0) {
					Yii::app()->getClientScript()->registerCoreScript('jquery');
					$this->render('reloadapprove',array(
						'processed'=>$processed,
						'totalAll'=>$totalAll,
						'key'=>$key
					));
				} else {
					Yii::app()->user->setFlash('success', 'Successfully approve '.json_encode($key));
					$this->redirect(array('index'));
				}
			}
		} else if(isset($_GET['arrid'])){ //Approve 1 record
			
			$arrid	 = $_GET['arrid'];
			$result  = 'success';
			
			$client_cd = $folder_cd = '';
			//$client_cd = array();
			//$folder_cd = array();
			//$payrec_num = array();
			$key = array();
			
			$x = 0;
			
			foreach($arrid as $id)
			{
				$model = $this->loadModel($id);
				$model->approve($this->sp_approve);
				
				//$detail = Tmanydetail::model()->findAll(array('condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND TABLE_NAME = 'T_PAYRECH' AND field_name IN ('PAYREC_NUM','CLIENT_CD','FOLDER_CD') AND RECORD_SEQ = 1",'order'=>'field_name'));
				$sql = "SELECT field_value 
						FROM T_MANY_DETAIL
						WHERE update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS')
						AND update_seq = '$model->update_seq' 
						AND TABLE_NAME = 'T_PAYRECH' 
						AND field_name IN ('CLIENT_CD','FOLDER_CD') 
						AND record_seq = 1
						ORDER BY field_name";
				$detail = DAO::queryAllSql($sql);
		
				$client_cd = $detail[0]['field_value']?'&nbsp;&nbsp;'.$detail[0]['field_value']:'';
				$folder_cd = $detail[1]['field_value']?'&nbsp;&nbsp;'.$detail[1]['field_value']:'';
				//$payrec_num[] = $detail[2]->field_value;
				
				$key[] = /*$payrec_num[$x].*/$folder_cd.$client_cd;
				
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}

				$x++;
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve '/*.$payrec_num[$x]*/.$folder_cd.$client_cd.' '.$model->error_msg);
			else
				Yii::app()->user->setFlash('success', 'Successfully approve '.json_encode($key));
			$this->redirect(array('index'));
		} else {
			$this->redirect(array('index'));
		}
	}
	

	public function actionApproveCheckedxxxxxx()
	{
		$result  = 'error';
		
		if(isset($_GET['arrid'])):
			
			$arrid	 = $_GET['arrid'];
			$result  = 'success';
			
			$client_cd = $folder_cd = '';
			//$client_cd = array();
			//$folder_cd = array();
			//$payrec_num = array();
			$key = array();
			
			$x = 0;
			
			foreach($arrid as $id)
			{
				$model = $this->loadModel($id);
				$model->approve($this->sp_approve);
				
				//$detail = Tmanydetail::model()->findAll(array('condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND TABLE_NAME = 'T_PAYRECH' AND field_name IN ('PAYREC_NUM','CLIENT_CD','FOLDER_CD') AND RECORD_SEQ = 1",'order'=>'field_name'));
				$sql = "SELECT field_value 
						FROM T_MANY_DETAIL
						WHERE update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS')
						AND update_seq = '$model->update_seq' 
						AND TABLE_NAME = 'T_PAYRECH' 
						AND field_name IN ('CLIENT_CD','FOLDER_CD') 
						AND record_seq = 1
						ORDER BY field_name";
				$detail = DAO::queryAllSql($sql);
		
				$client_cd = $detail[0]['field_value']?'&nbsp;&nbsp;'.$detail[0]['field_value']:'';
				$folder_cd = $detail[1]['field_value']?'&nbsp;&nbsp;'.$detail[1]['field_value']:'';
				//$payrec_num[] = $detail[2]->field_value;
				
				$key[] = /*$payrec_num[$x].*/$folder_cd.$client_cd;
				
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}

				$x++;
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve '/*.$payrec_num[$x]*/.$folder_cd.$client_cd.' '.$model->error_msg);
			else
				Yii::app()->user->setFlash('success', 'Successfully approve '.json_encode($key));
		endif;
		
		$this->redirect(array('index'));
	}

	public function actionIndex()
	{
		$model = new VinboxpayrecAll('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['VinboxpayrecAll']))
			$model->attributes=$_GET['VinboxpayrecAll'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionIndexProcessed()
	{
		$model = new VinboxpayrecAll('search');
		$model->unsetAttributes();
		$model->processed_flg = true;
		$model->menu_name = $this->menu_name;
		$model->approved_status = '<>'.AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['VinboxpayrecAll']))
			$model->attributes=$_GET['VinboxpayrecAll'];

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
