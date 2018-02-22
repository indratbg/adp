<?php

Class HmetdownportoController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	public $menuName = 'HMETD OWN PORTO JOURNAL';
	
	public function actionAjxGetDetail()
	{
		$data = array();
		
		if(isset($_POST['stk_cd']))
		{
			$stk_cd = $_POST['stk_cd'];
			
			$result = DAO::queryRowSql("SELECT TRIM(other_1) AS other_1 FROM MST_COMPANY");
			
			$data = DAO::queryRowSql("
				SELECT t.stk_cd AS hmetd_stk, TO_CHAR(t.distrib_dt,'DD/MM/YYYY') distrib_dt, TO_CHAR(expired_dt,'DD/MM/YYYY') expired_dt, price AS hmetd_price, total_share_qty
				FROM
				(  
					SELECT stk_cd, Get_Doc_Date(1,pp_from_dt) AS distrib_dt, pp_to_dt AS expired_dt
					FROM MST_COUNTER m
				   	WHERE ctr_type = 'RT'
				   	AND pp_from_dt IS NOT NULL
				   	AND approved_stat = 'A'
				)  m,
				T_CORP_ACT t,
				T_STK_MOVEMENT s
				WHERE m.stk_cd = t.stk_Cd
				AND m.distrib_dt = t.distrib_dt
				AND m.stk_cd = s.stk_cd
				AND m.distrib_dt = s.doc_dt
				AND m.stk_cd = '$stk_cd-R'
				AND s.client_cd = '".$result['other_1']."'
				AND s.s_d_type = 'H'
				AND s.doc_stat = '2'
				AND s.seqno = 1
				AND t.approved_stat = 'A'
			");
		}
		
		echo json_encode($data);
	}
	
	public function actionGetStock()
    {
    	$i=0;
      	$src=array();
      	$term = strtoupper($_POST['term']);
      	$qSearch = DAO::queryAllSql("
				SELECT STK_CD FROM MST_COUNTER 
				WHERE STK_CD LIKE '".$term."%'
				AND ROWNUM <= 15
				AND APPROVED_STAT = 'A'
				ORDER BY STK_CD
      			");
      
      	foreach($qSearch as $search)
      	{
      		$src[$i++] = array('label'=>$search['stk_cd']
      			, 'labelhtml'=>$search['stk_cd'] //WT: Display di auto completenya
      			, 'value'=>$search['stk_cd']);
      	}
      
      	echo CJSON::encode($src);
      	Yii::app()->end();
    }
	
	public function actionIndex()
	{
		$model = new HmetdOwnPorto;
		$modelHeader = '';
		$modelLedger = array();
		$modelFolder = '';
		
		$success = false;
		
		if(isset($_POST['HmetdOwnPorto']))
		{
			$model->attributes = $_POST['HmetdOwnPorto'];
			$model->scenario = $model->journal_type;
			
			if($model->validate())
			{
				$gl_porto = DAO::queryRowSql("SELECT dstr1 FROM MST_SYS_PARAM WHERE param_id = 'HMETD SENDIRI' AND param_cd1 = 'GLACCT' AND param_cd2 = 'PORTO'");
				$gl_lr_porto = DAO::queryRowSql("SELECT dstr1, dstr2 FROM MST_SYS_PARAM WHERE param_id = 'HMETD SENDIRI' AND param_cd1 = 'GLACCT' AND param_cd2 = 'LRPORTO'");
				$gl_emitent = DAO::queryRowSql("SELECT dstr1, dstr2 FROM MST_SYS_PARAM WHERE param_id = 'HMETD SENDIRI' AND param_cd1 = 'GLACCT' AND param_cd2 = 'EMITENT'");
				
				$modelHeader = new Tjvchh;
				$modelLedger[0] = new Taccountledger;
				
				$modelLedger[0]->record_source = $modelHeader->jvch_type = 'GL';
				$modelLedger[0]->curr_cd = $modelHeader->curr_cd = 'IDR';
				$modelLedger[0]->folder_cd = $modelHeader->folder_cd = $model->folder_cd;
				$modelLedger[0]->reversal_jur = $modelHeader->reversal_jur = 'N';
				$modelLedger[0]->tal_id = 1;
				$modelLedger[0]->manual = 'Y';
				
				switch($model->journal_type) 
				{
					case AConstant::HMETD_TYPE_DISTRIBUTION:
						$result = DAO::queryRowSql("SELECT GET_DOCNUM_GL(TO_DATE('$model->distribution_dt','YYYY-MM-DD'),'GL') doc_num FROM dual");
						
						$modelLedger[0]->xn_doc_num = $modelHeader->jvch_num = $result['doc_num'];
						$modelLedger[0]->doc_date = $modelLedger[0]->due_date = $modelHeader->jvch_date = $model->distribution_dt;
						$modelLedger[0]->curr_val = $modelLedger[0]->xn_val = $modelHeader->curr_amt = $model->hmetd_qty * $model->hmetd_price;
						$modelLedger[0]->ledger_nar = $modelHeader->remarks = 'Distribution HMETD '.$model->hmetd_stk;
						$modelLedger[0]->db_cr_flg = 'D';
						$modelLedger[0]->gl_acct_cd = $gl_porto['dstr1'];
						$modelLedger[0]->sl_acct_cd = $model->hmetd_stk;
						
						$modelLedger[1] = clone $modelLedger[0];
						$modelLedger[1]->tal_id = 2;
						$modelLedger[1]->db_cr_flg = 'C';
						$modelLedger[1]->gl_acct_cd = $gl_lr_porto['dstr1'];
						$modelLedger[1]->sl_acct_cd = $gl_lr_porto['dstr2'];
						
						break;
						
					case AConstant::HMETD_TYPE_TEBUS:
						$result = DAO::queryRowSql("SELECT GET_DOCNUM_GL(TO_DATE('$model->exercise_dt','YYYY-MM-DD'),'GL') doc_num FROM dual");
						
						$modelLedger[0]->xn_doc_num = $modelHeader->jvch_num = $result['doc_num'];
						$modelLedger[0]->doc_date = $modelLedger[0]->due_date = $modelHeader->jvch_date = $model->exercise_dt;
						$modelLedger[0]->curr_val = $modelLedger[0]->xn_val = $modelHeader->curr_amt = $model->exercise_qty * $model->close_price;
						$modelLedger[0]->ledger_nar = $modelHeader->remarks = 'Tebus HMETD '.$model->hmetd_stk;
						$modelLedger[0]->db_cr_flg = 'D';
						$modelLedger[0]->gl_acct_cd = $gl_porto['dstr1'];
						$modelLedger[0]->sl_acct_cd = $model->stk_cd;
						
						$modelLedger[1] = clone $modelLedger[0];
						$modelLedger[1]->tal_id = 2;
						$modelLedger[1]->curr_val = $modelLedger[1]->xn_val = $model->exercise_qty * $model->exercise_price;
						$modelLedger[1]->db_cr_flg = 'C';
						$modelLedger[1]->gl_acct_cd = $gl_emitent['dstr1'];
						$modelLedger[1]->sl_acct_cd = $gl_emitent['dstr2'];
						
						$modelLedger[2] = clone $modelLedger[0];
						$modelLedger[2]->tal_id = 3;
						$modelLedger[2]->curr_val = $modelLedger[2]->xn_val = $model->exercise_qty * $model->hmetd_price;
						$modelLedger[2]->db_cr_flg = 'C';
						$modelLedger[2]->gl_acct_cd = $gl_porto['dstr1'];
						$modelLedger[2]->sl_acct_cd = $model->hmetd_stk;
						
						$remaining_amt = $modelLedger[0]->curr_val - $modelLedger[1]->curr_val - $modelLedger[2]->curr_val;
						
						if($remaining_amt != 0)
						{
							$modelLedger[3] = clone $modelLedger[0];
							$modelLedger[3]->tal_id = 4;
							$modelLedger[3]->curr_val = $modelLedger[3]->xn_val = abs($remaining_amt);
							$modelLedger[3]->gl_acct_cd = $gl_lr_porto['dstr1'];
							$modelLedger[3]->sl_acct_cd = $gl_lr_porto['dstr2'];
							
							if($remaining_amt > 0)
							{
								$modelLedger[3]->db_cr_flg = 'C';
							}
							else if($remaining_amt < 0)
							{
								$modelLedger[3]->db_cr_flg = 'D';
							}
						}
						
						break;
											
					case AConstant::HMETD_TYPE_EXPIRED:
						$remaining_qty = $model->hmetd_qty - $model->exercise_qty;
						$result = DAO::queryRowSql("SELECT GET_DOCNUM_GL(TO_DATE('$model->expired_dt','YYYY-MM-DD'),'GL') doc_num FROM dual");
						
						$modelLedger[0]->xn_doc_num = $modelHeader->jvch_num = $result['doc_num'];
						$modelLedger[0]->doc_date = $modelLedger[0]->due_date = $modelHeader->jvch_date = $model->expired_dt;
						$modelLedger[0]->curr_val = $modelLedger[0]->xn_val = $modelHeader->curr_amt = $remaining_qty * $model->hmetd_price;
						$modelLedger[0]->ledger_nar = $modelHeader->remarks = 'Expired HMETD '.$model->hmetd_stk;
						$modelLedger[0]->db_cr_flg = 'D';
						$modelLedger[0]->gl_acct_cd = $gl_lr_porto['dstr1'];
						$modelLedger[0]->sl_acct_cd = $gl_lr_porto['dstr2'];
						
						$modelLedger[1] = clone $modelLedger[0];
						$modelLedger[1]->tal_id = 2;
						$modelLedger[1]->db_cr_flg = 'C';
						$modelLedger[1]->gl_acct_cd = $gl_porto['dstr1'];
						$modelLedger[1]->sl_acct_cd = $model->hmetd_stk;
						
						break;
				}

				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				
				if($modelHeader->validate())
				{
					if(
						$modelHeader->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0 &&
						$modelHeader->executeSp(AConstant::INBOX_STAT_INS, $modelHeader->jvch_num, 1) > 0
					)
					{
						$success = TRUE;
					}
	
					if($success)
					{
						$recordSeq = 1;
						
						foreach($modelLedger as $row)
						{
							$row->user_id = $modelHeader->user_id;
							$row->cre_dt = $modelHeader->cre_dt;
							$row->ip_address = $modelHeader->ip_address;
							
							if($row->executeSp(AConstant::INBOX_STAT_INS, $row->xn_doc_num, $row->tal_id, $modelHeader->update_date, $modelHeader->update_seq, $recordSeq++) <= 0)
							{
								$success = false;
								break;
							}
						}
						
						if($success && $model->folder_cd)
						{
							$modelFolder = new Tfolder;
							$modelFolder->fld_mon = DateTime::createFromFormat('Y-m-d',$modelHeader->jvch_date)->format('my');
							$modelFolder->folder_cd = $model->folder_cd;
							$modelFolder->doc_date = $modelHeader->jvch_date;
							$modelFolder->doc_num = $modelHeader->jvch_num;
							$modelFolder->user_id = $modelHeader->user_id;
							$modelFolder->cre_dt = $modelHeader->cre_dt;
							$modelFolder->ip_address = $modelHeader->ip_address;
							
							if($modelFolder->executeSp(AConstant::INBOX_STAT_INS, $modelFolder->doc_num, $modelHeader->update_date, $modelHeader->update_seq, 1) <= 0)
							{
								$success = false;
							}
						}
					}
					
					if($success)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/glaccounting/hmetdownporto/index'));
					}
					else
					{
						$transaction->rollback();
					}
				}
			}
		}
		else
		{
			$model->journal_type = AConstant::HMETD_TYPE_DISTRIBUTION;
		}
		
		$this->render('index',array(
			'model' => $model,
			'modelHeader' => $modelHeader,
			'modelLedger' => $modelLedger,
			'modelFolder' => $modelFolder
		));
	}
}