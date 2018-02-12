<?php

class TstkmovementallController extends AAdminController
{
	public $menu_name = array('\'STOCK MOVEMENT ENTRY\'','\'CORPORATE ACTION JOURNAL\'','\'GENERATE IPO SECURITES JOURNAL\'');
	
	public $table_name = 'T_STK_MOVEMENT';
	
	public $sp_approve = 'SP_T_STK_MOVEMENT_APPROVE';
	
	public $layout = '//layouts/admin_column3';
	
	/*private function getMovementType($doc_num, $ref_doc_num)
	{
		switch(substr($doc_num,4,1))
		{
			case 'R':
				return 'RECEIVE';
			case 'W':
				return 'WITHDRAW';
			case 'J':
				switch(substr($ref_doc_num,0,4))
				{
					case 'REPO':	
						return 'REPO';
					default:
						return 'RETURN REPO';
				}	
		}
	}*/
	
	private function setMovementType($jur_type, &$movement_type, &$movement_type_2)
	{
		switch($jur_type)
		{
			case 'RECV':
				$movement_type = 'RECEIVE';
				$movement_type_2 = 'Scripless';
				break;
							
			case 'RECVS':
				$movement_type = 'RECEIVE';
				$mocement_type_2 = 'Scrip';
				break;
				
			case '3336':
				$movement_type = 'RECEIVE';
				$movement_type_2 = 'Convert Scrip';
				break;
				
			case 'WHDR':
				$movement_type = 'WITHDRAW';
				$movement_type_2 = 'Scripless';
				break;
				
			case 'WHDRS':
				$movement_type = 'WITHDRAW';
				$movement_type_2 = 'Scrip';
				break;
				
			case 'REPO':
			case 'REPOY':
				$movement_type = 'REPO';
				break;
				
			case 'REPORTN':
			case 'REPOYRTN':
				$movement_type = 'RETURN REPO';
				break;
				
			case 'REREPOC':
			case 'REREPOS':
			case 'REREPOY':
				$movement_type = 'REVERSE REPO';
				break;
				
			case 'REREPOCRTN':
			case 'REREPOSRTN':
			case 'REREPOYRTN':
				$movement_type = 'RETURN REVERSE REPO';
				break;
				
			case 'EXERT0':
				$movement_type = 'EXERCISE HMETD';
				$movement_type_2 = 'Dipindahkan ke efek jaminan';
				break;
				
			case 'EXERBELI':
				$movement_type = 'EXERCISE HMETD';
				$movement_type_2 = 'Mencatat transaksi beli';
				break;
				
			case 'EXERSERAH':
				$movement_type = 'EXERCISE HMETD';
				$movement_type_2 = 'Menyerahkan HMETD ke LPP';
				break;
				
			case 'EXERRECV1':
			case 'EXERRECV2':
				$movement_type = 'EXERCISE HMETD';
				$movement_type_2 = 'Menerima efek';
				break;
				
			case 'TOFFBUY':
				$movement_type = 'TENDER OFFER BUY';
				$movement_type_2 = 'Buy';
				break;
				
			case 'TOFFBUYDU1':
			case 'TOFFBUYDU2':
				$movement_type = 'TENDER OFFER BUY';
				$movement_type_2 = 'Settle buy';
				break;
				
			case 'TOFFSELL':
				$movement_type = 'TENDER OFFER SELL';
				$movement_type_2 = 'Pindah ke rek tampungan LPP';
				break;
				
			case 'TOFFSELLDU':
				$movement_type = 'TENDER OFFER SELL';
				$movement_type_2 = 'Settle sell';
				break;
				
			case 'BORROW':
				$movement_type = 'BORROWING';
				break;
				
			case 'BORROWRTN':
				$movement_type = 'RETURN BORROWING';
				break;
				
			case 'LEND':
				$movement_type = 'LENDING';
				$movement_type_2 = 'To LKP';
				break;
				
			case 'LENDPE':
				$movement_type = 'LENDING';
				$movement_type_2 = 'To broker';
				break;
				
			case 'LENDRTN':
				$movement_type = 'RETURN LENDING';
				$movement_type_2 = 'To LKP';
				break;
				
			case 'LENDPERTN':
				$movement_type = 'RETURN LENDING';
				$movement_type_2 = 'To broker';
				break;
			case 'SPLITX':
				$movement_type = 'SPLITX';
				$movement_type_2 = 'X DATE';
				break;
			case 'SPLITD':
				$movement_type = 'SPLITD';
				$movement_type_2 = 'DISTRIBUTION';
				break;
			case 'REVERSEX'	:
				$movement_type = 'REVERSE';
				$movement_type_2 = 'X DATE';
				break;
			case 'REVERSED'	:
				$movement_type = 'REVERSE';
				$movement_type_2 = 'DISTRIBUTION';
				break;
			case 'CORPACTC' :
				$movement_type = 'CORPACTC';
				$movement_type_2 = 'Cum Date';
				break;
			case 'CORPACTD' :
				$movement_type = 'CORPACTD';
				$movement_type_2 = 'Distribution Date';
				break;
			case 'HMETDC':
				$movement_type = 'HMETD';
				$movement_type_2 = 'CUM DATE';
				break;
			case 'HMETDD':
				$movement_type = 'HMEDTD';
				$movement_type_2 = 'DISTRIBUTION';
				break;	
			case 'BONUSC':
				$movement_type = 'BONUS';
				$movement_type_2 = 'CUM DATE';
				break;
			case 'BONUSD':
				$movement_type = 'HMETD';
				$movement_type_2 = 'DISTRIBUTION';
				break;	
			case 'STKDIVC':
				$movement_type = 'STOCK DIVIDEN';
				$movement_type_2 = 'CUM DATE';
				break;
			case 'STKDIVD':
				$movement_type = 'STOCK DIVIDEN';
				$movement_type_2 = 'DISTRIBUTION';
				break;
			case 'IPO':
				$movement_type = 'IPO';
				$movement_type_2 = 'IPO';
				break;
			case 'REVERSEN':
				$movement_type = 'REVERSE';
				$movement_type_2 = 'DISTRIBUTION';
				break;
			case 'SPLITN':
				$movement_type = 'SPLIT';
				$movement_type_2 = 'DISTRIBUTION';
				break;
			case 'BONUSN':
				$movement_type = 'BONUS';
				$movement_type_2 = 'DISTRIBUTION';
				break;
			case 'STKDIVN':
				$movement_type = 'STOCK DIVIDEN';
				$movement_type_2 = 'DISTRIBUTION';
				break;
			case 'HMETDN':
				$movement_type = 'HMETD';
				$movement_type_2 = 'DISTRIBUTION';
				break;	
				
			case 'EXERR':
				$movement_type = 'EXERCISE NP';
				$movement_type_2 = 'RECEIVE';
				break;
				
			case 'EXERW':
				$movement_type = 'EXERCISE NP';
				$movement_type_2 = 'WITHDRAW';
				break;
		}
	}
	
	public function actionView($id)
	{
		$model			  = $this->loadModel($id);
		$modelDetail	  = null;
		$modelDetailUpd   = null;
		
		$recordCount = Tmanydetail::model()->find(array('select'=>'MAX(record_seq) record_cnt','condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_name'"));
		$listTmanyDetail = array();
		
		$x;
		
		$model2 = new Tstkmovement;
		
		/*
		for($x=0;$x<$recordCount->record_cnt;$x++)
		{
			$listTmanyDetail[$x] = Tmanydetail::model()->findAll('update_seq =:update_seq AND table_name =:table_name AND record_seq = :record_seq',array(':update_seq'=>$model->update_seq,':table_name'=>$this->table_name,':record_seq'=>($x+1)));
		}*/
		
		if($model->status == AConstant::INBOX_STAT_UPD){
			$modelDetail = new Tstkmovement;
			$modelDetailUpd = new Tstkmovement;
			
			$listTmanyDetail[0]= Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_name' AND record_seq = 1");
			Tmanydetail::generateModelAttributes2($modelDetail, $listTmanyDetail[0]);
			
			$this->setMovementType($modelDetail->jur_type, $modelDetail->movement_type, $modelDetail->movement_type_2);
	
			if(substr($modelDetail->doc_num,4,3) == 'REV')
			{
				// REVERSAL
				$currModel = Tstkmovement::model()->find("doc_num = '$modelDetail->prev_doc_num' AND db_cr_flg = 'D' AND seqno = 1");
				$modelDetail->doc_dt = $currModel->doc_dt;
				$modelDetail->doc_rem = $currModel->doc_rem;
				
				if(substr($modelDetail->prev_doc_num,4,3) == 'WSN' || $modelDetail->jur_type == 'WHDR')$modelDetail->qty = $modelDetail->withdrawn_share_qty;
				else {
					$modelDetail->qty = $modelDetail->total_share_qty;
				}
				
				$listTmanyDetail[1]= Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_name' AND record_seq = 3");
				Tmanydetail::generateModelAttributes2($modelDetailUpd, $listTmanyDetail[1]);
				
				$this->setMovementType($modelDetailUpd->jur_type, $modelDetailUpd->movement_type, $modelDetailUpd->movement_type_2);
				
				if(substr($modelDetailUpd->doc_num,4,3) == 'WSN' || $modelDetailUpd->jur_type == 'WHDR')$modelDetailUpd->qty = $modelDetailUpd->withdrawn_share_qty;
				else {
					$modelDetailUpd->qty = $modelDetailUpd->total_share_qty;
				}
				
				$temp = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_name' AND record_seq = 4");
				Tmanydetail::generateModelAttributes2($model2, $temp);
				
				$glAcctDebit = $modelDetailUpd->db_cr_flg=='D'?$modelDetailUpd->gl_acct_cd:$model2->gl_acct_cd;
				$glAcctCredit = $modelDetailUpd->db_cr_flg=='C'?$modelDetailUpd->gl_acct_cd:$model2->gl_acct_cd;
			}
			else
			{
				// NON REVERSAL
				$modelDetailUpd = clone $modelDetail;
				
				if(substr($modelDetailUpd->doc_num,4,3) == 'WSN' || $modelDetailUpd->jur_type == 'WHDR')$modelDetailUpd->qty = $modelDetailUpd->withdrawn_share_qty;
				else {
					$modelDetailUpd->qty = $modelDetailUpd->total_share_qty;
				}
				
				$modelDetail = Tstkmovement::model()->find("doc_num = '$modelDetail->doc_num' AND seqno = 1");
				$this->setMovementType($modelDetail->jur_type, $modelDetail->movement_type, $modelDetail->movement_type_2);
				
				if(substr($modelDetail->doc_num,4,3) == 'WSN' || $modelDetail->jur_type == 'WHDR')$modelDetail->qty = $modelDetail->withdrawn_share_qty;
				else {
					$modelDetail->qty = $modelDetail->total_share_qty;
				}
				
				$model2 = Tstkmovement::model()->find("doc_num = '$modelDetail->doc_num' AND seqno = 2");
				
				$glAcctDebit = $modelDetail->db_cr_flg=='D'?$modelDetail->gl_acct_cd:$model2->gl_acct_cd;
				$glAcctCredit = $modelDetail->db_cr_flg=='C'?$modelDetail->gl_acct_cd:$model2->gl_acct_cd;
			}
			
			$sysdate = date('Y-m-d');
			
			$resultDebit = DAO::queryRowSql("SELECT sl_desc FROM MST_SECURITIES_LEDGER WHERE gl_acct_cd = '$glAcctDebit' AND TO_DATE('$sysdate','YYYY-MM-DD') BETWEEN ver_bgn_dt AND ver_end_dt");
			$resultCredit = DAO::queryRowSql("SELECT sl_desc FROM MST_SECURITIES_LEDGER WHERE gl_acct_cd = '$glAcctCredit' AND TO_DATE('$sysdate','YYYY-MM-DD') BETWEEN ver_bgn_dt AND ver_end_dt");
			
			if($resultDebit && $resultCredit)
			{
				$modelDetail->sl_desc_debit = $resultDebit['sl_desc'];
				$modelDetail->sl_desc_credit = $resultCredit['sl_desc'];
				
				$modelDetailUpd->sl_desc_debit = $resultDebit['sl_desc'];
				$modelDetailUpd->sl_desc_credit = $resultCredit['sl_desc'];
			}
			
			if($model->approved_status != AConstant::INBOX_APP_STAT_ENTRY):
				$this->render('view',array(
					'model'=>$model,
					'modelDetail'=>$modelDetailUpd,
				));	
			else:	
				$this->render('view_compare',array(
					'model'=>$model,
					'modelDetail'=>$modelDetail,
					'modelDetailUpd'=>$modelDetailUpd,
				));
			endif;

		}else{
			if($model->status == AConstant::INBOX_STAT_CAN){
				$modelDetail = new Tstkmovement;

				$listTmanyDetail[0]= Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_name' AND record_seq = 1");
				Tmanydetail::generateModelAttributes2($modelDetail, $listTmanyDetail[0]);
				
				$this->setMovementType($modelDetail->jur_type, $modelDetail->movement_type, $modelDetail->movement_type_2);
				$currModel = Tstkmovement::model()->find("doc_num = '$modelDetail->prev_doc_num' AND db_cr_flg = 'D' AND seqno = 1");
				$modelDetail->doc_dt = $currModel->doc_dt;
				$modelDetail->doc_rem = $currModel->doc_rem;
				
				if(substr($modelDetail->prev_doc_num,4,3) == 'WSN' || $modelDetail->jur_type == 'WHDR')$modelDetail->qty = $modelDetail->withdrawn_share_qty;
				else {
					$modelDetail->qty = $modelDetail->total_share_qty;
				}
				
				$temp = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_name' AND record_seq = 2");
				Tmanydetail::generateModelAttributes2($model2, $temp);
				
				$glAcctDebit = $modelDetail->db_cr_flg=='D'?$modelDetail->gl_acct_cd:$model2->gl_acct_cd;
				$glAcctCredit = $modelDetail->db_cr_flg=='C'?$modelDetail->gl_acct_cd:$model2->gl_acct_cd;
				
				$sysdate = date('Y-m-d');
			
				$resultDebit = DAO::queryRowSql("SELECT sl_desc FROM MST_SECURITIES_LEDGER WHERE gl_acct_cd = '$glAcctDebit' AND TO_DATE('$sysdate','YYYY-MM-DD') BETWEEN ver_bgn_dt AND ver_end_dt");
				$resultCredit = DAO::queryRowSql("SELECT sl_desc FROM MST_SECURITIES_LEDGER WHERE gl_acct_cd = '$glAcctCredit' AND TO_DATE('$sysdate','YYYY-MM-DD') BETWEEN ver_bgn_dt AND ver_end_dt");
				
				if($resultDebit && $resultCredit)
				{
					$modelDetail->sl_desc_debit = $resultCredit['sl_desc']; // Swap debit and credit because of reversal
					$modelDetail->sl_desc_credit = $resultDebit['sl_desc']; // Swap debit and credit because of reversal
				}
				
				$this->render('view',array(
					'model'=>$model,
					'modelDetail'=>$modelDetail,
				));	
			}else{
				$modelDetail  = new Tstkmovement;
				
				
				if($recordCount->record_cnt > 2)
				{
					$modelDetailMove = new Tstkmovement;
					
					$listTmanyDetail[0]= Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_name' AND record_seq = 1");
					Tmanydetail::generateModelAttributes2($modelDetail, $listTmanyDetail[0]);
					
					$this->setMovementType($modelDetail->jur_type, $modelDetail->movement_type, $modelDetail->movement_type_2);
					
					if(substr($modelDetail->doc_num,4,3) == 'WSN' || $modelDetail->jur_type == 'WHDR')$modelDetail->qty = $modelDetail->withdrawn_share_qty;
					else {
						$modelDetail->qty = $modelDetail->total_share_qty;
					}
					
					$temp = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_name' AND record_seq = 2");
					Tmanydetail::generateModelAttributes2($model2, $temp);
					
					$glAcctDebit = $modelDetail->db_cr_flg=='D'?$modelDetail->gl_acct_cd:$model2->gl_acct_cd;
					$glAcctCredit = $modelDetail->db_cr_flg=='C'?$modelDetail->gl_acct_cd:$model2->gl_acct_cd;
					
					$sysdate = date('Y-m-d');
			
					$resultDebit = DAO::queryRowSql("SELECT sl_desc FROM MST_SECURITIES_LEDGER WHERE gl_acct_cd = '$glAcctDebit' AND TO_DATE('$sysdate','YYYY-MM-DD') BETWEEN ver_bgn_dt AND ver_end_dt");
					$resultCredit = DAO::queryRowSql("SELECT sl_desc FROM MST_SECURITIES_LEDGER WHERE gl_acct_cd = '$glAcctCredit' AND TO_DATE('$sysdate','YYYY-MM-DD') BETWEEN ver_bgn_dt AND ver_end_dt");
					
					if($resultDebit && $resultCredit)
					{
						$modelDetail->sl_desc_debit = $resultDebit['sl_desc'];
						$modelDetail->sl_desc_credit = $resultCredit['sl_desc']; 
					}
					
					if(1)//$modelDetail->jur_type != 'EXERRECV1' && $modelDetail->jur_type != 'TOFFBUYDU1')
					{
						$listTmanyDetail[1]= Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_name' AND record_seq = 3");
						Tmanydetail::generateModelAttributes2($modelDetailMove, $listTmanyDetail[1]);
						
						$this->setMovementType($modelDetailMove->jur_type, $modelDetailMove->movement_type, $modelDetailMove->movement_type_2);
						
						if(substr($modelDetailMove->doc_num,4,3) == 'WSN' || $modelDetailMove->jur_type == 'WHDR')$modelDetailMove->qty = $modelDetailMove->withdrawn_share_qty;
						else {
							$modelDetailMove->qty = $modelDetailMove->total_share_qty;
						}
						
						$temp = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_name' AND record_seq = 4");
						Tmanydetail::generateModelAttributes2($model2, $temp);
						
						$glAcctDebit = $modelDetailMove->db_cr_flg=='D'?$modelDetailMove->gl_acct_cd:$model2->gl_acct_cd;
						$glAcctCredit = $modelDetailMove->db_cr_flg=='C'?$modelDetailMove->gl_acct_cd:$model2->gl_acct_cd;
						
						$resultDebit = DAO::queryRowSql("SELECT sl_desc FROM MST_SECURITIES_LEDGER WHERE gl_acct_cd = '$glAcctDebit' AND TO_DATE('$sysdate','YYYY-MM-DD') BETWEEN ver_bgn_dt AND ver_end_dt");
						$resultCredit = DAO::queryRowSql("SELECT sl_desc FROM MST_SECURITIES_LEDGER WHERE gl_acct_cd = '$glAcctCredit' AND TO_DATE('$sysdate','YYYY-MM-DD') BETWEEN ver_bgn_dt AND ver_end_dt");
						
						if($resultDebit && $resultCredit)
						{
							$modelDetailMove->sl_desc_debit = $resultDebit['sl_desc'];
							$modelDetailMove->sl_desc_credit = $resultCredit['sl_desc']; 
						}
						
						$this->render('view',array(
							'model'=>$model,
							'modelDetail'=> $modelDetail,
							'modelDetailMove'=> $modelDetailMove,
						));	
					}
					else 
					{
						$this->render('view',array(
							'model'=>$model,
							'modelDetail'=> $modelDetail,
						));	
					}
				}
				else 
				{
					$listTmanyDetail[0]= Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_name' AND record_seq = 1");
					Tmanydetail::generateModelAttributes2($modelDetail, $listTmanyDetail[0]);
					
					$this->setMovementType($modelDetail->jur_type, $modelDetail->movement_type, $modelDetail->movement_type_2);
					
					if(substr($modelDetail->doc_num,4,3) == 'WSN' || $modelDetail->jur_type == 'WHDR')$modelDetail->qty = $modelDetail->withdrawn_share_qty;
					else {
						$modelDetail->qty = $modelDetail->total_share_qty;
					}
					
					$temp = Tmanydetail::model()->findAll("update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = $model->update_seq AND table_name = '$this->table_name' AND record_seq = 2");
					Tmanydetail::generateModelAttributes2($model2, $temp);
					
					$glAcctDebit = $modelDetail->db_cr_flg=='D'?$modelDetail->gl_acct_cd:$model2->gl_acct_cd;
					$glAcctCredit = $modelDetail->db_cr_flg=='C'?$modelDetail->gl_acct_cd:$model2->gl_acct_cd;
					
					$sysdate = date('Y-m-d');
			
					$resultDebit = DAO::queryRowSql("SELECT sl_desc FROM MST_SECURITIES_LEDGER WHERE gl_acct_cd = '$glAcctDebit' AND TO_DATE('$sysdate','YYYY-MM-DD') BETWEEN ver_bgn_dt AND ver_end_dt");
					$resultCredit = DAO::queryRowSql("SELECT sl_desc FROM MST_SECURITIES_LEDGER WHERE gl_acct_cd = '$glAcctCredit' AND TO_DATE('$sysdate','YYYY-MM-DD') BETWEEN ver_bgn_dt AND ver_end_dt");
					
					if($resultDebit && $resultCredit)
					{
						$modelDetail->sl_desc_debit = $resultDebit['sl_desc'];
						$modelDetail->sl_desc_credit = $resultCredit['sl_desc']; 
					}
					
					$this->render('view',array(
						'model'=>$model,
						'modelDetail'=> $modelDetail,
					));	
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
		
		$detail = Tmanydetail::model()->findAll(array('condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND field_name IN ('CLIENT_CD','STK_CD') AND RECORD_SEQ = 1",'order'=>'field_name'));
		
		$client = $detail[0]->field_value;
		$stock = $detail[1]->field_value;
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Approve '.$client.' '.$stock.', Error  '.$model->error_code.':'.$model->error_msg);
		else
		{
			Yii::app()->user->setFlash('success', 'Successfully approve '.$client.' '.$stock);
			
			//$soc = new SocketToFront();
			/*$soc = SocketToFront::getInstance();
			$connectRslt=$soc->connectFO();
			//klo connect socket berhasil baru push
			if($connectRslt=="OK"){
				$soc->pushClientStock($client,$stock);
				$closeSocketResult = $soc->closeConnection(); 
				if($closeSocketResult!="OK"){
					Yii::app()->user->setFlash('error', 'Error close socket connection ');//,socket url: '.$soc->socketURL());
				}
			}else{
				//Yii::app()->user->setFlash('error', ' Push Failed: Error Connect Socket:  '.$connectRslt." ,socket url: ".$soc->socketURL());
				Yii::app()->user->setFlash('error', ' Push Failed: '.$client.' - '.$stock);
			}
			//Yii::app()->user->setFlash('success', 'Successfully approve '.$hasil); 	*/
		}	
		
		//$this->redirect(array('index','id'=>$model->update_seq));
	}
	
	private function reject(&$model)
	{		
		$model->reject($model->reject_reason);
		
		$detail = Tmanydetail::model()->findAll(array('condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND field_name IN ('CLIENT_CD','STK_CD') AND RECORD_SEQ = 1",'order'=>'field_name'));
		
		$client = $detail[0]->field_value;
		$stock = $detail[1]->field_value;
		
		if($model->error_code < 0)
			Yii::app()->user->setFlash('error', 'Reject '.$client.' ',$stock.', Error  '.$model->error_code.':'.$model->error_msg);
		else
			Yii::app()->user->setFlash('success', 'Successfully reject '.$client.' '.$stock);
	}
	
	private function rejectChecked($model,$arrid)
	{
		$reject_reason = $model->reject_reason;
		
		$client = array();
		$stock = array();
		$key = array();
		$x = 0;
		
		foreach($arrid as $id):
			$model = $this->loadModel($id);	
			$model->reject($reject_reason);
			
			$detail = Tmanydetail::model()->findAll(array('condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND field_name IN ('CLIENT_CD','STK_CD') AND RECORD_SEQ = 1",'order'=>'field_name'));
		
			$client[] = $detail[0]->field_value;
			$stock[] = $detail[1]->field_value;
			$key[] = $client[$x].' '.$stock[$x];
			
			if($model->error_code < 0){
				Yii::app()->user->setFlash('error', 'Error reject '.$client[$x].' '.$stock[$x].' '.$model->error_msg);
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
		
		if(isset($_POST['arrid'])):
			
			$arrid	 = $_POST['arrid'];
			$result  = 'success';
			$hasil = array();
			$client = array();
			$stock = array();
			$x = 0;
			
			//$soc = new SocketToFront();
			/*$soc = SocketToFront::getInstance();
			$connectRslt=$soc->connectFO();*/
			
			foreach($arrid as $id)
			{
				$model = $this->loadModel($id);
				$model->approve($this->sp_approve);
				
				$detail = Tmanydetail::model()->findAll(array('condition'=>"update_date = TO_DATE('$model->update_date','YYYY-MM-DD HH24:MI:SS') AND update_seq = '$model->update_seq' AND field_name IN ('CLIENT_CD','STK_CD') AND RECORD_SEQ = 1",'order'=>'field_name'));
		
				$client[] = $detail[0]->field_value;
				$stock[] = $detail[1]->field_value;
				
				if($model->error_code < 0){
					$result  = 'error';
					break;
				}
				else {
					//Yii::app()->user->setFlash('success', 'Successfully approve '.json_encode($client).' - '.json_encode($stock));
					
					//klo connect socket berhasil baru push
					/*if($connectRslt=="OK"){
						$soc->pushClientStock($client[$x],$stock[$x]);
					}*/
				}
				
				$x++;
			}
			
			if($result  == 'error')
				Yii::app()->user->setFlash('error', 'Error approve '.$client[$x].' '.$stock[$x].' '.$model->error_msg);
			else
				Yii::app()->user->setFlash('success', 'Successfully approve '.json_encode($client).' - '.json_encode($stock));
			
			//klo konek socket OK , close socket
			/*if($connectRslt=='OK'){
				$closeSocketResult = $soc->closeConnection(); 
				if($closeSocketResult!="OK"){
					Yii::app()->user->setFlash('error', 'Error close socket connection ');//,socket url: '.$soc->socketURL());
				}
			}else{
				Yii::app()->user->setFlash('error', 'Push Failed: '.json_encode($client));
			}*/
			
		endif;
		
		echo $result;
	}

	public function actionIndex()
	{
		$model = new Vinboxtstkmovementall('search');
		$model->unsetAttributes();
		$model->menu_name = $this->menu_name;
		$model->approved_status = AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['Vinboxtstkmovementall']))
		{
			$model->attributes=$_GET['Vinboxtstkmovementall'];
			$model->stk_cd = $_GET['Vinboxtstkmovementall']['stk_cd'];
			
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	public function actionIndexProcessed()
	{
		$model = new Vinboxtstkmovementall('search');
		$model->unsetAttributes();
		$model->processed_flg = true;
		$model->menu_name = $this->menu_name;
		$model->approved_status = '<>'.AConstant::INBOX_APP_STAT_ENTRY;
		
		if(isset($_GET['Vinboxtstkmovementall']))
			$model->attributes=$_GET['Vinboxtstkmovementall'];

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
