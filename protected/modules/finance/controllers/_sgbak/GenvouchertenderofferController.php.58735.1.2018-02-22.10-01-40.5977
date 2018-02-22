<?php

Class GenVoucherTenderOfferController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	public $menuName = 'GENERATE VOUCHER TENDER OFFER';
	
	public function actionGetStock()
	{
		$i=0;
      	$src=array();
      	$term = strtoupper($_POST['term']);
      	$qSearch = DAO::queryAllSql("
				SELECT stk_cd FROM MST_COUNTER
				WHERE stk_cd LIKE '".$term."%'
				AND ROWNUM <= 15
				AND APPROVED_STAT = 'A'
				ORDER BY stk_cd
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
	
	public function actionGetGla()
	{
		$i=0;
      	$src=array();
      	$term = strtoupper($_POST['term']);
      	$qSearch = DAO::queryAllSql("
				SELECT TRIM(gl_a) gl_a, acct_name
				FROM MST_GL_ACCOUNT
				WHERE TRIM(gl_a) LIKE '".$term."%'
				AND ROWNUM <= 15
				AND sl_a = '000000' 
				AND acct_stat = 'A' 
				AND approved_stat = 'A'
				ORDER BY gl_a
      			");
      
      	foreach($qSearch as $search)
      	{
      		$src[$i++] = array('label'=>$search['gl_a'].' - '.$search['acct_name']
      			, 'labelhtml'=>$search['gl_a'].' - '.$search['acct_name'] //WT: Display di auto completenya
      			, 'value'=>$search['gl_a']);
      	}
      
      	echo CJSON::encode($src);
      	Yii::app()->end();
	}
		
	public function actionGetSla()
    {
    	$i=0;
      	$src=array();
      	$term = strtoupper($_POST['term']);
      	$qSearch = DAO::queryAllSql("
				SELECT sl_a, acct_name
				FROM MST_GL_ACCOUNT 
				WHERE TRIM(gl_a) = '".$_POST['gla']."' 
				AND sl_a LIKE '".$term."%'
				AND ROWNUM <= 15
				AND APPROVED_STAT = 'A'
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
	
	public function actionIndex()
	{
		$model = new GenVoucherTenderOffer;
		$modelHeader = '';
		$modelDetail = array();
		$modelLedger = array();
		$modelFolder = '';
		
		$valid = true;
		$success = false;
		
		if(isset($_POST['GenVoucherTenderOffer']))
		{
			$model->attributes = $_POST['GenVoucherTenderOffer'];
			$model->scenario = $model->stage;
			
			if($model->validate())
			{
				//$result = DAO::queryRowSql("SELECT GET_DOCNUM_VCH(TO_DATE('$model->voucher_date','YYYY-MM-DD'),'RD') doc_num FROM dual");
								
				$modelHeader = new Tpayrech;
					
				//$modelHeader->payrec_num = $result['doc_num'];
				$modelHeader->payrec_type = 'RD';
				$modelHeader->payrec_date = $model->voucher_date;
				$modelHeader->curr_cd = 'IDR';
				$modelHeader->remarks = $model->remarks;
				$modelHeader->folder_cd = $model->folder_cd;
				$modelHeader->num_cheq = 0;
				$modelHeader->reversal_jur = 'N';
				
				switch($model->stage) 
				{
					case AConstant::VOUCHER_TENDER_TYPE_PENJUALAN :
						$modelHeader->gl_acct_cd = 'NA';
						$modelHeader->sl_acct_cd = 'nonbank';
						$modelHeader->curr_amt = 0;
						
						$result = DAO::queryAllSql($model->getPenjualanSql());
						
						if(count($result) == 1)
						{
							$model->addError('stk_cd', 'No Data Found');
							$valid = false;
							break;
						}
						
						$x = 0;
						
						foreach($result as $row)
						{
							$modelDetail[$x] = new Tpayrecd;
							//$modelDetail[$x]->payrec_num = $modelDetail[$x]->doc_ref_num = $modelDetail[$x]->gl_ref_num = $modelHeader->payrec_num;
							$modelDetail[$x]->payrec_type = 'RD';
							$modelDetail[$x]->payrec_date = $modelDetail[$x]->doc_date = $modelDetail[$x]->due_date = $modelHeader->payrec_date;
							$modelDetail[$x]->payrec_amt = $row['amount'];
							$modelDetail[$x]->db_cr_flg = $row['db_cr_flg'];
							$modelDetail[$x]->gl_acct_cd = $row['gl_a'];
							$modelDetail[$x]->sl_acct_cd = $row['sl_a'];
							$modelDetail[$x]->remarks = $row['descrip'];
							$modelDetail[$x]->tal_id = $modelDetail[$x]->doc_tal_id = $row['tal_id'];
							$modelDetail[$x]->record_source = 'VCH';
							$modelDetail[$x]->ref_folder_cd = $modelHeader->folder_cd;
							
							$modelLedger[$x] = new Taccountledger;
							//$modelLedger[$x]->xn_doc_num = $modelHeader->payrec_num;
							$modelLedger[$x]->doc_date = $modelLedger[$x]->due_date = $modelHeader->payrec_date;
							$modelLedger[$x]->record_source = 'RD';
							$modelLedger[$x]->curr_cd = 'IDR';
							$modelLedger[$x]->folder_cd = $modelHeader->folder_cd;
							$modelLedger[$x]->reversal_jur = 'N';
							$modelLedger[$x]->tal_id = $row['tal_id'];
							$modelLedger[$x]->manual = 'Y';						
							$modelLedger[$x]->curr_val = $modelLedger[$x]->xn_val = $row['amount'];
							$modelLedger[$x]->db_cr_flg = $row['db_cr_flg'];
							$modelLedger[$x]->gl_acct_cd = $row['gl_a'];
							$modelLedger[$x]->sl_acct_cd = $row['sl_a'];
							$modelLedger[$x]->ledger_nar = $row['descrip'];
							
							$x++;
						}

						break;
						
					case AConstant::VOUCHER_TENDER_TYPE_DISTRIBUTION :
						$modelHeader->gl_acct_cd = $model->bank_gla;
						$modelHeader->sl_acct_cd = $model->bank_sla;
						
						$result = DAO::queryAllSql($model->getDistributionSql());
						
						if($result)
						{
							$modelHeader->curr_amt = $result[0]['amount'];
						}
						else
						{
							$model->addError('stk_cd', 'No Data Found');
							$valid = false;
							break;
						}
						
						$x = 0;
						
						foreach($result as $row)
						{
							if($x > 0)
							{
								$modelDetail[$x] = new Tpayrecd;
								//$modelDetail[$x]->payrec_num = $modelDetail[$x]->doc_ref_num = $modelDetail[$x]->gl_ref_num = $modelHeader->payrec_num;
								$modelDetail[$x]->payrec_type = 'RD';
								$modelDetail[$x]->payrec_date = $modelDetail[$x]->doc_date = $modelDetail[$x]->due_date = $modelHeader->payrec_date;
								$modelDetail[$x]->payrec_amt = $row['amount'];
								$modelDetail[$x]->db_cr_flg = $row['db_cr_flg'];
								$modelDetail[$x]->gl_acct_cd = $row['gl_a'];
								$modelDetail[$x]->sl_acct_cd = $row['sl_a'];
								$modelDetail[$x]->remarks = $row['descrip'];
								$modelDetail[$x]->tal_id = $modelDetail[$x]->doc_tal_id = $row['tal_id'];
								$modelDetail[$x]->record_source = 'VCH';
								$modelDetail[$x]->ref_folder_cd = $modelHeader->folder_cd;
							}
							
							$modelLedger[$x] = new Taccountledger;
							//$modelLedger[$x]->xn_doc_num = $modelHeader->payrec_num;
							$modelLedger[$x]->doc_date = $modelLedger[$x]->due_date = $modelHeader->payrec_date;
							$modelLedger[$x]->record_source = 'RD';
							$modelLedger[$x]->curr_cd = 'IDR';
							$modelLedger[$x]->folder_cd = $modelHeader->folder_cd;
							$modelLedger[$x]->reversal_jur = 'N';
							$modelLedger[$x]->tal_id = $row['tal_id'];
							$modelLedger[$x]->manual = 'Y';						
							$modelLedger[$x]->curr_val = $modelLedger[$x]->xn_val = $row['amount'];
							$modelLedger[$x]->db_cr_flg = $row['db_cr_flg'];
							$modelLedger[$x]->gl_acct_cd = $row['gl_a'];
							$modelLedger[$x]->sl_acct_cd = $row['sl_a'];
							$modelLedger[$x]->ledger_nar = $row['descrip'];
							
							$x++;
						}
							
						break;
				}

				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();
				
				if($modelHeader->validate())
				{
					if(
						$modelHeader->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0 &&
						$modelHeader->executeSp(AConstant::INBOX_STAT_INS, $modelHeader->payrec_num, 1) > 0
					)
					{
						$success = TRUE;
					}
	
					if($success)
					{
						$recordSeq = 1;
						
						foreach($modelDetail as $row)
						{
							$row->payrec_num = $row->doc_ref_num = $row->gl_ref_num = $modelHeader->payrec_num;
							$row->user_id = $modelHeader->user_id;
							$row->cre_dt = $modelHeader->cre_dt;
							$row->ip_address = $modelHeader->ip_address;
							
							if($row->executeSp(AConstant::INBOX_STAT_INS, $row->payrec_num, $row->doc_ref_num, $row->tal_id, $modelHeader->update_date, $modelHeader->update_seq, $recordSeq++) <= 0)
							{
								$success = false;
								break;
							}
						}
						
						$recordSeq = 1;
						
						foreach($modelLedger as $row)
						{
							$row->xn_doc_num = $modelHeader->payrec_num;
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
							$modelFolder->fld_mon = DateTime::createFromFormat('Y-m-d',$modelHeader->payrec_date)->format('my');
							$modelFolder->folder_cd = $model->folder_cd;
							$modelFolder->doc_date = $modelHeader->payrec_date;
							$modelFolder->doc_num = $modelHeader->payrec_num;
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
						$this->redirect(array('/finance/genvouchertenderoffer/index'));
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
			$model->stage = AConstant::VOUCHER_TENDER_TYPE_PENJUALAN;
		}
		
		$this->render('index',array(
			'model' => $model,
			'modelHeader' => $modelHeader,
			'modelDetail' => $modelDetail,
			'modelLedger' => $modelLedger,
			'modelFolder' => $modelFolder
		));
	}
}