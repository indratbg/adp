<?php

Class GenrepojournalController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	public $menuName = 'REPO JOURNAL';
	
	public function actionAjxGetDetail()
	{
		$data = array();
		
		if(isset($_POST['repo_num']))
		{
			$repo_num = $_POST['repo_num'];
						
			$data = DAO::queryRowSql("
				SELECT repo_val, return_val, repo_type, stk_cd
				FROM T_REPO a 
				JOIN T_REPO_STK b ON a.repo_num = b.repo_num
				JOIN T_STK_MOVEMENT c ON b.doc_num = c.doc_num
				WHERE a.repo_num = '$repo_num'
			");
		}
		
		echo json_encode($data);
	}
	
	public function actionGetBankSla()
    {
    	$i=0;
      	$src=array();
      	$term = strtoupper($_POST['term']);
      	$qSearch = DAO::queryAllSql("
				SELECT sl_a FROM MST_GL_ACCOUNT 
				WHERE TRIM(gl_a) = '".$_POST['bankGla']."' 
				AND sl_a LIKE '".$term."%'
				AND ROWNUM <= 15
				AND APPROVED_STAT = 'A'
				ORDER BY sl_a
      			");
      
      	foreach($qSearch as $search)
      	{
      		$src[$i++] = array('label'=>$search['sl_a']
      			, 'labelhtml'=>$search['sl_a'] //WT: Display di auto completenya
      			, 'value'=>$search['sl_a']);
      	}
      
      	echo CJSON::encode($src);
      	Yii::app()->end();
    }
	
	public function actionIndex()
	{
		$model = new Genrepojournal;
		$modelHeader = '';
		$modelLedger = array();
		$modelFolder = '';
		
		$success = false;
		
		if(isset($_POST['Genrepojournal']))
		{
			$model->attributes = $_POST['Genrepojournal'];
			
			if($model->validate())
			{
				$result = DAO::queryRowSql("SELECT GET_DOCNUM_GL(TO_DATE('$model->repo_date','YYYY-MM-DD'),'GL') doc_num FROM dual");
								
				$modelHeader = new Tjvchh;
				$modelLedger[0] = new Taccountledger;
				
				$modelLedger[0]->xn_doc_num = $modelHeader->jvch_num = $result['doc_num'];
				$modelLedger[0]->doc_date = $modelLedger[0]->due_date = $modelHeader->jvch_date = $model->repo_date;
				$modelLedger[0]->record_source = $modelHeader->jvch_type = 'GL';
				$modelLedger[0]->curr_cd = $modelHeader->curr_cd = 'IDR';
				$modelLedger[0]->folder_cd = $modelHeader->folder_cd = $model->folder_cd;
				$modelLedger[0]->reversal_jur = $modelHeader->reversal_jur = 'N';
				$modelLedger[0]->ledger_nar = $modelHeader->remarks = $model->remarks;
				$modelLedger[0]->tal_id = 1;
				$modelLedger[0]->manual = 'Y';
				
				switch($model->repo_stage) 
				{
					case 1 :
						if($model->repo_type == 'REPO')
						{
							$modelLedger[0]->curr_val = $modelLedger[0]->xn_val = $modelHeader->curr_amt = $model->repo_val;
							$modelLedger[0]->db_cr_flg = 'D';
							$modelLedger[0]->gl_acct_cd = $model->bank_gla;
							$modelLedger[0]->sl_acct_cd = $model->bank_sla;
							
							$result = DAO::queryRowSql($model->getPortoSql($model->repo_num, $model->repo_date));
							
							$modelLedger[1] = clone $modelLedger[0];
							$modelLedger[1]->curr_val = $modelLedger[1]->xn_val = $result['stk_val'];
							$modelLedger[1]->tal_id = 2;
							$modelLedger[1]->db_cr_flg = 'C';
							$modelLedger[1]->gl_acct_cd = $model->porto_gla;
							$modelLedger[1]->sl_acct_cd = $model->porto_sla;
							
							$remaining_qty = $model->repo_val - $result['stk_val'];
							
							if($remaining_qty != 0)
							{
								$modelLedger[2] = clone $modelLedger[0];
								$modelLedger[2]->curr_val = $modelLedger[2]->xn_val = abs($remaining_qty);
								$modelLedger[2]->tal_id = 3;
								$modelLedger[2]->gl_acct_cd = $model->lr_porto_gla;
								$modelLedger[2]->sl_acct_cd = $model->lr_porto_sla;
								
								if($remaining_qty > 0)
								{
									$modelLedger[2]->db_cr_flg = 'C';
								}
								else 
								{
									$modelLedger[2]->db_cr_flg = 'D';
								}
							}
						}
						else 
						{
							$modelLedger[0]->curr_val = $modelLedger[0]->xn_val = $modelHeader->curr_amt = $model->repo_val;
							$modelLedger[0]->db_cr_flg = 'D';
							$modelLedger[0]->gl_acct_cd = $model->porto_gla;
							$modelLedger[0]->sl_acct_cd = $model->porto_sla;

							$modelLedger[1] = clone $modelLedger[0];
							$modelLedger[1]->tal_id = 2;
							$modelLedger[1]->db_cr_flg = 'C';
							$modelLedger[1]->gl_acct_cd = $model->bank_gla;
							$modelLedger[1]->sl_acct_cd = $model->bank_sla;
						}
						
						break;
						
					case 2:
						if($model->repo_type == 'REPO')
						{
							$modelLedger[0]->curr_val = $modelLedger[0]->xn_val = $modelHeader->curr_amt = $model->return_val;
							$modelLedger[0]->db_cr_flg = 'D';
							$modelLedger[0]->gl_acct_cd = $model->porto_gla;
							$modelLedger[0]->sl_acct_cd = $model->porto_sla;

							$modelLedger[1] = clone $modelLedger[0];
							$modelLedger[1]->tal_id = 2;
							$modelLedger[1]->db_cr_flg = 'C';
							$modelLedger[1]->gl_acct_cd = $model->bank_gla;
							$modelLedger[1]->sl_acct_cd = $model->bank_sla;
						}
						else
						{
							$result = DAO::queryRowSql($model->getPortoSql($model->repo_num, $model->repo_date));
							
							$modelLedger[0]->curr_val = $modelLedger[0]->xn_val = $modelHeader->curr_amt = $result['stk_val'];
							$modelLedger[0]->db_cr_flg = 'D';
							$modelLedger[0]->gl_acct_cd = $model->bank_gla;
							$modelLedger[0]->sl_acct_cd = $model->bank_sla;
							
							$modelLedger[1] = clone $modelLedger[0];
							$modelLedger[1]->curr_val = $modelLedger[1]->xn_val = $model->repo_val;
							$modelLedger[1]->tal_id = 2;
							$modelLedger[1]->db_cr_flg = 'C';
							$modelLedger[1]->gl_acct_cd = $model->porto_gla;
							$modelLedger[1]->sl_acct_cd = $model->porto_sla;
							
							$remaining_qty = $result['stk_val'] - $model->repo_val;
														
							if($remaining_qty != 0)
							{
								$modelLedger[2] = clone $modelLedger[0];
								$modelLedger[2]->curr_val = $modelLedger[2]->xn_val = abs($remaining_qty);
								$modelLedger[2]->tal_id = 3;
								$modelLedger[2]->gl_acct_cd = $model->lr_porto_gla;
								$modelLedger[2]->sl_acct_cd = $model->lr_porto_sla;
								
								if($remaining_qty > 0)
								{
									$modelLedger[2]->db_cr_flg = 'C';
								}
								else 
								{
									$modelLedger[2]->db_cr_flg = 'D';
								}
							}
						}
						
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
						$this->redirect(array('/glaccounting/genrepojournal/index'));
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
			$gl_bank = DAO::queryRowSql("SELECT dstr1 FROM MST_SYS_PARAM WHERE param_id = 'REPO JOURNAL' AND param_cd1 = 'GLACCT' AND param_cd2 = 'BANK'");
			$gl_porto = DAO::queryRowSql("SELECT dstr1 FROM MST_SYS_PARAM WHERE param_id = 'REPO JOURNAL' AND param_cd1 = 'GLACCT' AND param_cd2 = 'PORTO'");
			$gl_lr_porto = DAO::queryRowSql("SELECT dstr1, dstr2 FROM MST_SYS_PARAM WHERE param_id = 'REPO JOURNAL' AND param_cd1 = 'GLACCT' AND param_cd2 = 'LRPORTO'");
			
			$model->bank_gla = $gl_bank['dstr1'];
			$model->porto_gla = $gl_porto['dstr1'];
			$model->lr_porto_gla = $gl_lr_porto['dstr1'];
			$model->lr_porto_sla = $gl_lr_porto['dstr2'];
			
			$model->repo_stage = 1;
			$model->repo_date = date('d/m/Y');
		}
		
		$this->render('index',array(
			'model' => $model,
			'modelHeader' => $modelHeader,
			'modelLedger' => $modelLedger,
			'modelFolder' => $modelFolder
		));
	}
}