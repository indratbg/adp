<?php

class TpayrechkpeiController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	public $menuName = 'KPEI VOUCHER ENTRY';

	public function actionAjxGetBankAccount()
	{
		$model = array();
		
		if(isset($_POST['glAcctCd']))
		{
			$glAcctCd = $_POST['glAcctCd'];
			//$branchCode = $_POST['branchCode'];
			
			$sql = "SELECT trim(sl_a) AS sl_a, acct_name, b.BRCH_CD, 
			 		DECODE(trim(b.bank_acct_type),'R','Receipt', 'P','Payment','RP', 'Recv/Pay') RP
			 		FROM mst_gl_account g, mst_bank_acct b
			 		WHERE g.gl_a = RPAD('$glAcctCd',12)
					AND g.sl_a <> '000000'
					AND (g.acct_type = 'BANK' OR g.acct_type = 'KAS')
					AND g.gl_a = b.gl_acct_cd (+) 
					AND g.sl_a = b.sl_acct_cd (+) 
					AND g.approved_stat = 'A'
					ORDER BY sl_a";
			
			$model = DAO::queryAllSql($sql);
		}
		
		echo json_encode($model);
	}
	
	public function actionAjxGetFolderPrefix()
	{
		$model = array();
		
		if(isset($_POST['slAcctCd']))
		{
			$glAcctCd = $_POST['glAcctCd'];
			$slAcctCd = $_POST['slAcctCd'];
			
			$sql = "SELECT folder_prefix
					FROM MST_BANK_ACCT
			 		WHERE gl_acct_cd = RPAD('$glAcctCd',12)
					AND sl_acct_cd = '$slAcctCd'";
			
			$model = DAO::queryRowSql($sql);
		}
		
		echo json_encode($model);
	}

	public function actionAjxGetTransferFee()
	{
		$model = array();
		
		if(isset($_POST['amt']))
		{
			$amt = $_POST['amt'];
			$to_bank = $_POST['to_bank'];
			$glAcctCd = $_POST['glAcctCd'];
			$slAcctCd = $_POST['slAcctCd'];
			$olt = $_POST['olt'];
			$rdi = $_POST['rdi'];
			$result = Bankacct::model()->find("TRIM(gl_acct_cd) = '$glAcctCd' AND sl_acct_cd = '$slAcctCd'")->bank_cd;
			$from_bank = Bankmaster::model()->find("bank_cd = '$result'")->short_bank_name;
			
			$sql = "SELECT F_TRANSFER_FEE('$amt','$from_bank','$to_bank',null,'$olt','$rdi','$slAcctCd') transfer_fee FROM dual";
			
			$model = DAO::queryRowSql($sql);
		}
		
		echo json_encode($model);
	}
	
	public function actionAjxGetDueTrxDate()
	{
		$model = array();
		
		if(isset($_POST['dueDate']))
		{
			$dueDate = $_POST['dueDate'];
			$sql = "SELECT GET_DOC_DATE(F_GET_SETTDAYS(TO_DATE('$dueDate','DD/MM/YYYY')),TO_DATE('$dueDate','DD/MM/YYYY')) doc_date FROM dual";
			
			$result = DAO::queryRowSql($sql);
			
			$model = DateTime::createFromFormat('Y-m-d H:i:s',$result['doc_date'])->format('d/m/Y');
		}
		else if(isset($_POST['trxDate']))
		{
			$docDate = $_POST['trxDate'];
            
			$sql = "SELECT GET_DUE_DATE(F_GET_SETTDAYS(TO_DATE('$docDate','DD/MM/YYYY')),TO_DATE('$docDate','DD/MM/YYYY')) due_date FROM dual";
			
			$result = DAO::queryRowSql($sql);
			
			$model = DateTime::createFromFormat('Y-m-d H:i:s',$result['due_date'])->format('d/m/Y');
		}
		
		echo json_encode($model);
	}

	public function actionAjxValidateBackDated()
	{
		$resp = '';
		echo json_decode($resp);
	}
	
	public function actionGetSlAcct()
	{
		$i=0;
      	$src=array();
      	$term = strtoupper($_POST['term']);
      	$glAcctCd = $_POST['gl_acct_cd'];
      	
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

	public function actionView($id, $obj = null)
	{
		if($obj === null)$obj = $this;
		
		$model = $this->loadModel($id);
		$modelDetail = Taccountledger::model()->findAll(array("condition"=>"xn_doc_num = '$id' AND approved_sts = 'A'",'order'=>"DECODE(record_source,'ARAP','VCH',record_source), tal_id"));
		$modelCheq = Tcheq::model()->findAll("rvpv_number = '$id' AND approved_stat = 'A'");
		
		if(!$model->acct_type)
		{	
			if($model->client_cd = 'KPEI')
			{
				$model->acct_type = 'KPEI';
			}
			else if($model->client_cd = 'GS1000')
			{
				$model->acct_type = 'GS1000';
			}
			else
			{
				$model->acct_type = 'NEGO';
			}
		}

		$model->type = $model->acct_type;
				
		$obj->render('/tpayrechkpei/view',array(
			'model'=>$model,
			'modelDetail'=>$modelDetail,
			'modelCheq'=>$modelCheq,
		));
	}

	public function actionCreate($obj = null)
	{
		if($obj === null)$obj = $this;
		
		$model=new Tpayrech;
		$modelLedger = array(); 
		//$modelLedgerSave = array(); // Actual model that saves the record to the database
		$modelDetailLedger = array();
		$modelFolder = new Tfolder;
		$modelCheqLedger = array();
		
		$tempModel = array(); 

		$retrieved = 0; // 0=>Not Retrieved, 1=>Transaction Retrieved, 2=>Transaction and Journal Retrieved
		$valid = FALSE;
		$success = FALSE;
		
		$sameBrokerFlg = TRUE;

		if(isset($_POST['Tpayrech']))
		{
			$model=new Tpayrech($_POST['Tpayrech']['type']);			
			$model->attributes=$_POST['Tpayrech'];
			$model->reversal_jur = 'N';
			
			$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'VCH_REF' ")->dflg1;
		
			if($check == 'N')$model->folder_cd = ''; 
			
			$valid = $model->validate();
			
			$authorizedBackDated = $_POST['authorizedBackDated'];
			
			if(!$authorizedBackDated)
			{
				$currMonth = date('Ym');
				$docMonth = DateTime::createFromFormat('Y-m-d',$model->payrec_date)->format('Ym');
				
				if($docMonth < $currMonth)
				{
					$model->addError('doc_dt','You are not authorized to select last month date');
					$valid = FALSE;
				}
			}
			
			if($_POST['submit'] == 'retrieve')
			{
				if($valid)
				{					
					$retrieved = 1;
					
					/*$glAcctKpeiDebit= $glAcctKpeiCredit = $glAcctBrokerDebit= $glAcctBrokerCredit = '';
					
					if($model->type == 'KPEI')
					{
						$result = DAO::queryAllSql("SELECT * FROM V_GL_ACCT_TYPE WHERE ACCT_TYPE = 'KPEI' ORDER BY DB_CR_FLG");
						$glAcctKpeiDebit = trim($result[1]['gl_a']);
						$glAcctKpeiCredit = trim($result[0]['gl_a']);
						
						$modelLedger = Tpayrecd::model()->findAllBySql(Tpayrecd::getOutstandingArapKpeiSql($model->trx_date, $model->due_date, $model->trx_date, $model->due_date, $glAcctKpeiDebit, $glAcctKpeiCredit, $glAcctBrokerDebit, $glAcctBrokerCredit));
					}
					else if($model->type == 'NEGO')
					{
						$result = DAO::queryAllSql("SELECT * FROM V_GL_ACCT_TYPE WHERE ACCT_TYPE = 'BROK' ORDER BY DB_CR_FLG");
						$glAcctBrokerDebit = trim($result[1]['gl_a']);
						$glAcctBrokerCredit = trim($result[0]['gl_a']);
						
						$modelLedger = Tpayrecd::model()->findAllBySql(Tpayrecd::getOutstandingArapKpeiSql($model->trx_date, $model->due_date, $model->trx_date, $model->due_date, $glAcctKpeiDebit, $glAcctKpeiCredit, $glAcctBrokerDebit, $glAcctBrokerCredit));
					}
					else if($model->type == 'GS1000 JK')
					{
						$modelLedger = Tpayrecd::model()->findAllBySql(Tpayrecd::getOutstandingArapJkSql($model->trx_date, $model->due_date, $model->trx_date, $model->due_date));
					}
					else if($model->type == 'GS1000 SL')
					{
						$modelLedger = Tpayrecd::model()->findAllBySql(Tpayrecd::getOutstandingArapSlSql($model->trx_date, $model->due_date, $model->trx_date, $model->due_date));
					}*/
					
					$glAcctKpei1= $glAcctKpei2 = $glAcctBroker1= $glAcctBroker2 = '';
					
					if($model->type == 'KPEI')
					{
						$result = DAO::queryAllSql("SELECT gl_a FROM MST_GLA_TRX WHERE JUR_TYPE = 'KPEI'");
						$glAcctKpei1 = $result[0]['gl_a'];
						$glAcctKpei2 = $result[1]['gl_a'];
						
						$modelLedger = Tpayrecd::model()->findAllBySql(Tpayrecd::getOutstandingArapKpeiSql($model->trx_date, $model->due_date, $model->trx_date, $model->due_date, $glAcctKpei1, $glAcctKpei2, $glAcctBroker1, $glAcctBroker2));
					}
					else if($model->type == 'NEGO')
					{
						$result = DAO::queryAllSql("SELECT gl_a FROM MST_GLA_TRX WHERE JUR_TYPE = 'BROK'");
						$glAcctBroker1 = $result[0]['gl_a'];
						$glAcctBroker2 = $result[1]['gl_a'];
						
						$modelLedger = Tpayrecd::model()->findAllBySql(Tpayrecd::getOutstandingArapKpeiSql($model->trx_date, $model->due_date, $model->trx_date, $model->due_date, $glAcctKpei1, $glAcctKpei2, $glAcctBroker1, $glAcctBroker2));
					}
					else if($model->type == 'GS1000 JK')
					{
						$result = DAO::queryAllSql("SELECT gl_a FROM MST_GLA_TRX WHERE JUR_TYPE = 'BROK'");
						$glAcctBroker1 = $result[0]['gl_a'];
						$glAcctBroker2 = $result[1]['gl_a'];
						
						$modelLedger = Tpayrecd::model()->findAllBySql(Tpayrecd::getOutstandingArapJkSql($model->trx_date, $model->due_date, $model->trx_date, $model->due_date, $glAcctBroker1, $glAcctBroker2));
					}
					else if($model->type == 'GS1000 SL')
					{
						$result = DAO::queryAllSql("SELECT gl_a FROM MST_GLA_TRX WHERE JUR_TYPE = 'BROK'");
						$glAcctBroker1 = $result[0]['gl_a'];
						$glAcctBroker2 = $result[1]['gl_a'];
						
						$modelLedger = Tpayrecd::model()->findAllBySql(Tpayrecd::getOutstandingArapSlSql($model->trx_date, $model->due_date, $model->trx_date, $model->due_date, $glAcctBroker1, $glAcctBroker2));
					}
				}
			}
			else if($_POST['submit'] == 'retrieve2')
			{
				$ledgerCount = $_POST['ledgerCount'];
				
				$checkCount= 0;
				
				for($x=0;$x<$ledgerCount;$x++)
				{
					$modelLedger[$x] = new Tpayrecd('retrieve');
					$modelLedger[$x]->attributes = $_POST['Tpayrecdledger'][$x+1];
					//$modelLedger[$x]->sl_acct_cd = $model->client_cd;
					
					if($modelLedger[$x]->check == 'Y')$checkCount++;
				}
				
				$retrieved = 1;
				
				if($checkCount == 0)
				{
					Yii::app()->user->setFlash('error', 'There has to be at least one checked transaction');
				}
				else 
				{
					/*if($model->type == 'NEGO')
					{
						// Validate that settled transactions are from the same broker
						$x = 0;
						
						$broker = '';
						
						foreach($modelLedger as $row)
						{
							if($row->check == 'Y')
							{
								if($x == 0)
								{
									$broker = $row->sl_acct_cd;
								}
								else
								{
									$broker_cmp = $row->sl_acct_cd;
									
									if($broker != $broker_cmp)
									{
										//$valid = false;
										//Yii::app()->user->setFlash('error', 'Settled transactions must be from the same broker');
										
										$sameBrokerFlg = FALSE;
									}
								}
								
								$x++;
							}
						}
					}*/
					
					if($valid)
					{
						if($model->type == 'NEGO')
						{
							foreach($modelLedger as $row)
							{
								if($row->check == 'Y')
								{
									$oldLedger = Taccountledger::model()->find("xn_doc_num = '$row->contr_num' AND tal_id = '$row->tal_id'");
									
									$oldLedger->sett_for_curr = $oldLedger->sett_for_curr==null?0:$oldLedger->sett_for_curr;
									$oldLedger->sett_val = $oldLedger->sett_val==null?0:$oldLedger->sett_val;
									
									$oldOutsAmt = $oldLedger->curr_val - $oldLedger->sett_for_curr - $oldLedger->sett_val;
									
									if($oldLedger->reversal_jur != 'N' || ( round($oldOutsAmt,2) < round($row->old_outs_amt,2) ) )
									{
										Yii::app()->user->setFlash('error', '-1 - Some of the transactions have been modified, please retrieve the transactions again');
										$valid = false;
									}
								}
							}
						}
						else if($model->type == 'KPEI')
						{
							foreach($modelLedger as $row)
							{
								if($row->check == 'Y')
								{
									$oldLedger = Taccountledger::model()->findAll("
												doc_date = TO_DATE('$row->trx_date','DD/MM/YYYY') 
												AND due_date = TO_DATE('$row->due_date','DD/MM/YYYY') 
												AND trim(gl_acct_cd) = trim('$row->gl_acct_cd') 
												AND sl_acct_cd = '$row->sl_acct_cd' 
												AND record_source IN ('CG','GL') 
												AND reversal_jur = 'N' 
												AND approved_sts = 'A'");
									
									$currValTotal = $settForCurrTotal = $settValTotal = 0;
									
									foreach($oldLedger as $row2)
									{
										if(!$row2->sett_for_curr)$row2->sett_for_curr=0;
										if(!$row2->sett_val)$row2->sett_val=0;
										
										$currValTotal += $row2->curr_val;
										$settForCurrTotal += $row2->sett_for_curr;
										$settValTotal += $row2->sett_val;
									}
									
									$oldOutsAmt = $currValTotal - $settForCurrTotal - $settValTotal;									

									if(( round($oldOutsAmt,2) < round($row->old_outs_amt,2) ) )
									{
										Yii::app()->user->setFlash('error', '-2 - Some of the transactions have been modified, please retrieve the transactions again');
										$valid = false;
									}
								}
							}
						}
					}
					
					if($valid)
					{
						$retrieved = 2;
						
						$group = array();					
						$detailLedgerCount = 0;
						$x = 0;
						
						foreach($modelLedger as $row)
						{
							if($row->check == 'Y')
							{
								$modelDetailLedger[$x] = new Taccountledger;
								$modelDetailLedger[$x]->gl_acct_cd = $row->gl_acct_cd;
								
								if($model->type == 'GS1000 JK')
								{
									if(trim($modelDetailLedger[$x]->gl_acct_cd) == '3021' || trim($modelDetailLedger[$x]->gl_acct_cd) == '1041' || trim($modelDetailLedger[$x]->gl_acct_cd) == '3360'){
										$modelDetailLedger[$x]->sl_acct_cd = $row->sl_acct_cd;
									}else{
										$modelDetailLedger[$x]->sl_acct_cd = '1'.substr($row->sl_acct_cd,1);
									}
								}
								else 
								{
									$modelDetailLedger[$x]->sl_acct_cd = $row->sl_acct_cd;
								}
								
								$modelDetailLedger[$x]->curr_val = str_replace(',','',$row->buy_sett_amt) + str_replace(',','',$row->sell_sett_amt);
								$modelDetailLedger[$x]->db_cr_flg = $row->buy_sell_ind=='B'||$row->buy_sell_ind=='D'?'C':'D';
								$modelDetailLedger[$x]->ledger_nar = $row->remarks;
								$modelDetailLedger[$x]->system_generated = 'Y';
								$modelDetailLedger[$x]->bank_flg = 'N';
								
								
								// GROUPING
								if($x > 0)
								{
									$y = 1;
									foreach($modelDetailLedger as $rowDetail)
									{
										if($modelDetailLedger[$x]->gl_acct_cd == $rowDetail->gl_acct_cd && $modelDetailLedger[$x]->sl_acct_cd == $rowDetail->sl_acct_cd)
										{
											//Needs to be grouped
											
											if($modelDetailLedger[$x]->db_cr_flg == $rowDetail->db_cr_flg)
											{
												$rowDetail->curr_val += $modelDetailLedger[$x]->curr_val;
											}
											else 
											{
												if($rowDetail->curr_val > $modelDetailLedger[$x]->curr_val)
												{
													$rowDetail->curr_val -= $modelDetailLedger[$x]->curr_val;
												}
												else {
													$rowDetail->curr_val = $modelDetailLedger[$x]->curr_val - $rowDetail->curr_val;
													$rowDetail->db_cr_flg = $rowDetail->db_cr_flg=='D'?'C':'D';
												}
											}
											
											$rowDetail->ledger_nar = $model->remarks;
											unset($modelDetailLedger[$x]);
											break;
										}
										
										$y++;
										
										if($y == count($modelDetailLedger)) //To Prevent Comparing With Itself
										{
											$x++;
											break;
										}
									}
								}
								else
									$x++;
							}
						}

						//SORT => 1. Debit  2. Credit  3. Bank
						
						$currTotal = count($modelDetailLedger);
						
						for($x=0;$x<$currTotal;$currTotal--)
						{
							for($y=$x+1;$y<$currTotal;$y++)
							{
								if($modelDetailLedger[$y-1]->db_cr_flg != $modelDetailLedger[$y]->db_cr_flg && $modelDetailLedger[$y-1]->db_cr_flg == 'C')
								{
									// SWAP
									
									$tempObj = clone $modelDetailLedger[$y-1];
									$modelDetailLedger[$y-1] = clone $modelDetailLedger[$y];
									$modelDetailLedger[$y] = clone $tempObj;
								}
							}
						}

						$bankLedger = new Taccountledger;
						
						$balDebit = str_replace(',','',$_POST['balDebit']);
						$balCredit = str_replace(',','',$_POST['balCredit']);
						
						$bankLedger->gl_acct_cd = $model->gl_acct_cd;
						$bankLedger->sl_acct_cd = $model->sl_acct_cd;
						$bankLedger->curr_val = $balDebit + $balCredit;
						$bankLedger->db_cr_flg = $balCredit > 0?'C':'D';
						$bankLedger->ledger_nar = $model->remarks;
						$bankLedger->system_generated = 'Y';
						$bankLedger->bank_flg = 'Y';
						
						$modelDetailLedger = array_merge($modelDetailLedger,array($bankLedger));			
						//20dec2016 jika KPEI dan gl code 1042/3022 untuk PF, SL_ACCT_CD diset 100000
				
						foreach($modelDetailLedger as $row)
						{
							if ($model->type =='KPEI')
							{
								if((trim($row->gl_acct_cd) =='1042' || trim($row->gl_acct_cd) =='3022') && $row->sl_acct_cd =='200000')
								{
									$row->sl_acct_cd='100000';
									$row->ledger_nar = $row->ledger_nar .' SL';
								}
							}
							
							else if($model->type =='GS1000 JK')
							{
								if((trim($row->gl_acct_cd) =='1041' || trim($row->gl_acct_cd) =='3021') && strlen(trim($row->sl_acct_cd)) =='2')
								{
									$row->sl_acct_cd='1SOLO';
									$row->gl_acct_cd='3360';
								}
							}
							else if($model->type =='GS1000 SL')
							{
								if((trim($row->gl_acct_cd) =='1041' || trim($row->gl_acct_cd) =='3021') && strlen(trim($row->sl_acct_cd)) =='2')
								{
									$row->sl_acct_cd='2PUSAT';
									$row->gl_acct_cd='3360';
								}
							}
						
						}	

					//end 20dec								
					}
				}
			}
			else 
			{
				// SUBMIT
				$retrieved = 2;
				
				$ledgerCount = $_POST['ledgerCount'];
				$detailLedgerCount = $_POST['detailLedgerCount'];
				$cheqLedgerCount = $_POST['cheqLedgerCount'];
				
				$talId = 1;
				
				for($x=0;$x<$ledgerCount;$x++)
				{
					$modelLedger[$x] = new Tpayrecd;
					$modelLedger[$x]->attributes = $_POST['Tpayrecdledger'][$x+1];
					$modelLedger[$x]->system_generated = 'Y';
					
					if($modelLedger[$x]->check == 'Y')
					{
						$modelLedger[$x]->payrec_date = $model->payrec_date;
							
						if($modelLedger[$x]->buy_sell_ind == 'J' || $modelLedger[$x]->buy_sell_ind == 'C')
						{
							$modelLedger[$x]->db_cr_flg = 'D';
							$modelLedger[$x]->payrec_amt = $modelLedger[$x]->buy_sett_amt;	
						}
						else
						{
							$modelLedger[$x]->db_cr_flg = 'C';
							$modelLedger[$x]->payrec_amt = $modelLedger[$x]->sell_sett_amt;
						}
						
						$modelLedger[$x]->doc_date = $modelLedger[$x]->trx_date;
						$modelLedger[$x]->sett_for_curr = 0;
						$modelLedger[$x]->sett_val = 0;
						
						if($model->type == 'KPEI')
						{
							$modelLedger[$x]->client_cd = 'KPEI';
							$modelLedger[$x]->doc_ref_num = date('my').'KPEI'.date('dmy');
							$modelLedger[$x]->tal_id = $modelLedger[$x]->doc_tal_id = $talId++;
							$modelLedger[$x]->record_source = 'KPEI';
							//21DEC2016
							if((trim($modelLedger[$x]->gl_acct_cd) == '1042' || trim($modelLedger[$x]->gl_acct_cd) == '3022') && $modelLedger[$x]->sl_acct_cd =='200000' )
							{
								$modelLedger[$x]->remarks = $modelLedger[$x]->remarks.' SL'; 
							}
							//END 21DEC2016
						}
						else if($model->type == 'NEGO')
						{
							$modelLedger[$x]->client_cd = $modelLedger[$x]->sl_acct_cd;
							$modelLedger[$x]->doc_ref_num = $modelLedger[$x]->contr_num;
							$modelLedger[$x]->record_source = 'NEGO';
							$modelLedger[$x]->doc_tal_id = $modelLedger[$x]->tal_id;
						}
						else 
						{
							//23DEC2016 MENYAMAKAN GL ACCOUNT ANTARA TAL DENGAN T_PAYRECD JIKA PILIH GS1000 JK YAITU DI DEPANNYA ANGKA 1
							
							if($model->type =='GS1000 JK' && strlen($modelLedger[$x]->sl_acct_cd)> 2)
							{
								$modelLedger[$x]->sl_acct_cd = '1'.substr($modelLedger[$x]->sl_acct_cd, 1);
							}
							//END 23DEC016												
							$record_source = $model->type == 'GS1000 JK' ? 'GSJK' : 'GSSL';
							
							$result = DAO::queryRowSql("SELECT jur_type FROM MST_GLA_TRX WHERE gl_a = '".trim($modelLedger[$x]->gl_acct_cd)."'");
						
							if(!$result || ($result['jur_type'] != 'BROK' && $result['jur_type'] != 'BROKD' && $result['jur_type'] != 'BROKC') )
							{
								// KPEI
								
								$modelLedger[$x]->doc_ref_num = date('my').$record_source.date('dmy');
							}
							else 
							{
								// NEGO
								
								$modelLedger[$x]->doc_ref_num = $modelLedger[$x]->contr_num;
							}
								
								
							$modelLedger[$x]->client_cd = 'GS1000';							
							$modelLedger[$x]->tal_id = $modelLedger[$x]->doc_tal_id = $talId++;
							$modelLedger[$x]->record_source = $record_source;
						}
						
						$valid = $modelLedger[$x]->validate() && $valid;
					}
				}

				if($model->type == 'NEGO')
				{
					$x = 0;
					
					$broker = '';
					
					foreach($modelLedger as $row)
					{
						if($row->check == 'Y')
						{
							if($x == 0)
							{
								$broker = $row->sl_acct_cd;
							}
							else
							{
								$broker_cmp = $row->sl_acct_cd;
								
								if($broker != $broker_cmp)
								{
									$sameBrokerFlg = FALSE;
									break;
								}
							}
							
							$x++;
						}
					}
				}

				$bank = Bankacct::model()->find("TRIM(gl_acct_cd) = '$model->gl_acct_cd' AND sl_acct_cd = '$model->sl_acct_cd'");
				
				$y = $temp = count($modelLedger);
				$insertedTalId = 2;

				for($x=$tal_id=0;$x<$detailLedgerCount;$x++)
				{
					$modelDetailLedger[$x] = new Taccountledger;
					$modelDetailLedger[$x]->attributes = $_POST['Taccountledger'][$x+1];
					
					//if($bank)$modelDetailLedger[$x]->curr_cd = $bank->curr_cd; 
					$modelDetailLedger[$x]->curr_cd = 'IDR';
					$modelDetailLedger[$x]->db_cr_flg = $modelDetailLedger[$x]->db_cr_flg=='DEBIT'||$modelDetailLedger[$x]->db_cr_flg=='D'?'D':'C';
					$modelDetailLedger[$x]->folder_cd = $model->folder_cd;
					$modelDetailLedger[$x]->doc_date = $model->payrec_date;
					$modelDetailLedger[$x]->due_date = $model->payrec_date;
					$modelDetailLedger[$x]->sett_val = 0;
					$modelDetailLedger[$x]->sett_for_curr = 0;
					$modelDetailLedger[$x]->arap_due_date = $model->payrec_date;
					
					$glA = trim($modelDetailLedger[$x]->gl_acct_cd);
					$slA = $modelDetailLedger[$x]->sl_acct_cd;
					$client = Client::model()->find(array('select'=>'client_cd','condition'=>"client_cd = '$slA'"));
					
					if($modelDetailLedger[$x]->system_generated == 'Y')
					{
						if($modelDetailLedger[$x]->bank_flg == 'N')
						{
							$modelDetailLedger[$x]->tal_id = $tal_id+1;
							$tal_id++;	
						
							/*if($client)
							{
								$glAccount = Glaccount::model()->find("TRIM(gl_a) = '$glA' AND sl_a = '$slA'");
								$modelDetailLedger[$x]->acct_type = $glAccount->acct_type;
							}*/
						}
						else 
						{
							$modelDetailLedger[$x]->tal_id = 555;
						}
					}
					else 
					{
						//USER INSERTED ROW
			
						$modelDetailLedger[$x]->tal_id = $tal_id+1; 
						$tal_id++;	
						
						$modelLedger[$y] = new Tpayrecd;
							
						$modelLedger[$y]->system_generated = 'N';
							
						$modelLedger[$y]->gl_acct_cd = $modelDetailLedger[$x]->gl_acct_cd;
						$modelLedger[$y]->sl_acct_cd = $modelDetailLedger[$x]->sl_acct_cd;
						$modelLedger[$y]->payrec_amt = $modelDetailLedger[$x]->curr_val;
						$modelLedger[$y]->db_cr_flg = $modelDetailLedger[$x]->db_cr_flg;
						$modelLedger[$y]->remarks = $modelDetailLedger[$x]->ledger_nar;	
													
						$modelLedger[$y]->payrec_date = $model->payrec_date;										
						$modelLedger[$y]->record_source = $client?Sysparam::model()->find("param_id = 'VOUCHER ENTRY' and param_cd1 = 'SOURCE' AND param_cd2 = 'ARAP'")->dstr1:'VCH';
						//$modelLedger[$y]->doc_ref_num = date('my').'ZZ1234567';
						$modelLedger[$y]->ref_folder_cd = $model->folder_cd;
						$modelLedger[$y]->due_date = $model->payrec_date;
						
						if($model->type == 'KPEI')
						{
							$modelLedger[$y]->client_cd = 'KPEI';
							//$modelLedger[$y]->tal_id = $talId++; //Continue from above
						}
						else if($model->type == 'NEGO')
						{
							$modelLedger[$y]->client_cd = $modelDetailLedger[0]->sl_acct_cd;
							//$modelLedger[$y]->tal_id = ++$insertedTalId; //Use new counter
						}
						else
						{
							$modelLedger[$y]->client_cd = 'GS1000';
						}
						
						$modelLedger[$y]->tal_id = $modelLedger[$y]->doc_tal_id = $modelDetailLedger[$x]->tal_id;
						
						$modelLedger[$y]->sett_for_curr = 0;
						$modelLedger[$y]->sett_val = 0;
						
						$modelLedger[$y]->check = 'Y';
						
						$valid = $modelLedger[$y]->validate() && $valid;
						
						$y++;
					}		
					
					$valid = $modelDetailLedger[$x]->validate() && $valid;
				}
				
				$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'CHECK' and param_cd2 ='ACCTBRCH'")->dflg1;
	
				if($check == 'Y' && $model->type != 'KPEI')
				{
					$brch_cd = '';
					$x = 0;
					foreach($modelDetailLedger as $row)
					{
						if($row->gl_acct_cd != 'NA' && $row->gl_acct_cd != '')
						{
							if($x==0)
							{
								$sql = "SELECT check_acct_branch('$row->gl_acct_cd','$row->sl_acct_cd') brch_cd FROM dual";
								$branch = DAO::queryRowSql($sql);
								$brch_cd = $branch['brch_cd'];
	
							}
							else 
							{
								$sql = "SELECT check_acct_branch('$row->gl_acct_cd','$row->sl_acct_cd') brch_cd FROM dual";
								$branch_cmp = DAO::queryRowSql($sql);
								$brch_cd_cmp = $branch_cmp['brch_cd'];
	
								if($brch_cd != $brch_cd_cmp)
								{
									$valid = false;
									$row->addError('gl_acct_cd','All journal entries must have GL Account and SL Account of the same branch');
									break;
								}
								
							}
							$x++;
						}
					}	
				}

				$payrec_type = $payrec_amt = '';

				foreach($modelDetailLedger as $row)
				{
					if($row->bank_flg == 'Y')
					{
						$payrec_amt = $row->curr_val;
						
						if($row->db_cr_flg == 'DEBIT' || $row->db_cr_flg == 'D')$payrec_type = 'RV';
						else {
							$payrec_type = 'PV';
						}
						break;
					}
				}
				
				foreach($modelLedger as $row)
				{
					$row->payrec_type = $payrec_type;
				}
				
				foreach($modelDetailLedger as $row)
				{
					if($row->system_generated == 'Y')$row->record_source = $payrec_type;
					else {
						$row->record_source = $payrec_type.'O';
					}
					
					$row->budget_cd = $payrec_type.'CH';
				}
				
				for($x=0;$x<$cheqLedgerCount;$x++)
				{
					$modelCheqLedger[$x] = new Tcheq;
					$modelCheqLedger[$x]->attributes = $_POST['Tcheqledger'][$x+1];
					
					if($bank)$modelCheqLedger[$x]->bank_cd = $bank->bank_cd;
					$modelCheqLedger[$x]->sl_acct_cd = $model->sl_acct_cd;
					$modelCheqLedger[$x]->chq_stat = 'A';
					$modelCheqLedger[$x]->payee_bank_cd = $model->client_bank_cd;
					$modelCheqLedger[$x]->payee_acct_num = $model->client_bank_acct;
					$modelCheqLedger[$x]->seqno = $modelCheqLedger[$x]->chq_seq = $x+1;
					$modelCheqLedger[$x]->payee_name = $model->payrec_frto;
					
					$valid = $modelCheqLedger[$x]->validate() && $valid;
				}
				
				/*
				// Map $modelDetailLedger to $modelLedgerSave
				$x = 0;
				foreach ($modelDetailLedger as $row) 
				{
					if($row->bank_flg == 'N')
					{
						$modelLedgerSave[$x] = new Tpayrecd;
						$modelLedgerSave[$x]->payrec_type = $payrec_type;
						$modelLedgerSave[$x]->payrec_date = $model->payrec_date;
						$modelLedgerSave[$x]->client_cd = 'KPEI';
						$modelLedgerSave[$x]->gl_acct_cd = $row->gl_acct_cd;
						$modelLedgerSave[$x]->sl_acct_cd = $row->sl_acct_cd;
						$modelLedgerSave[$x]->db_cr_flg = $row->db_cr_flg;
						$modelLedgerSave[$x]->payrec_amt = $row->curr_val;
						$modelLedgerSave[$x]->doc_ref_num = date('my').'KPEI'.date('dmy');
						$modelLedgerSave[$x]->tal_id = $row->tal_id;
						$modelLedgerSave[$x]->record_source = 'KPEI';
						$modelLedgerSave[$x]->doc_date = $model->payrec_date;
						
						$x++;
					}
				}
				*/
				
				$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'VCH_REF' ")->dflg1;
					
				if($check == 'Y')
				{
					$glAccount = Glaccount::model()->find("TRIM(gl_a) = '$model->gl_acct_cd'");
						
					if($glAccount && $glAccount->acct_type == 'BANK')
					{	
						$payrecFlg = $payrec_type=='RV'?'RECEIPT':'PAYMENT';
						
						$folderChar = Sysparam::model()->find("param_id = 'VOUCHER ENTRY' AND param_cd1 = '$payrecFlg' AND param_cd2 = 'FOLDERCD' AND param_cd3 = 'CHAR3'");
						
						if($folderChar)
						{
							if(substr($model->folder_cd,2,1) != $folderChar->dstr1)
							{
								$model->addError('folder_cd', "If voucher type is '$payrecFlg' file code must contain '".$folderChar->dstr1."'");
								$valid = false;
							}
						}
					}
				}
				
				if($model->type == 'NEGO')
				{
					foreach($modelLedger as $row)
					{
						if($row->check == 'Y' && $row->system_generated == 'Y')
						{
							$oldLedger = Taccountledger::model()->find("xn_doc_num = '$row->contr_num' AND tal_id = '$row->tal_id'");
							
							$oldLedger->sett_for_curr = $oldLedger->sett_for_curr==null?0:$oldLedger->sett_for_curr;
							$oldLedger->sett_val = $oldLedger->sett_val==null?0:$oldLedger->sett_val;
							
							$oldOutsAmt = $oldLedger->curr_val - $oldLedger->sett_for_curr - $oldLedger->sett_val;
							
							if($oldLedger->reversal_jur != 'N' || ( round($oldOutsAmt,2) < round($row->old_outs_amt,2) ) )
							{
								Yii::app()->user->setFlash('error', '-3 - Some of the transactions have been modified, please retrieve the transactions again');
								$valid = false;
							}
						}
					}
				}
				else if($model->type == 'KPEI')
				{
					foreach($modelLedger as $row)
					{
						if($row->check == 'Y' && $row->system_generated == 'Y')
						{
							$oldLedger = Taccountledger::model()->findAll("
										doc_date = TO_DATE('$row->doc_date','YYYY-MM-DD') 
										AND due_date = TO_DATE('$row->due_date','YYYY-MM-DD') 
										AND trim(gl_acct_cd) = trim('$row->gl_acct_cd') 
										AND sl_acct_cd = '$row->sl_acct_cd' 
										AND record_source = 'CG' 
										AND reversal_jur = 'N' 
										AND approved_sts = 'A'");
							
							$currValTotal = $settForCurrTotal = $settValTotal = 0;
							
							foreach($oldLedger as $row2)
							{
								if(!$row2->sett_for_curr)$row2->sett_for_curr=0;
								if(!$row2->sett_val)$row2->sett_val=0;
								
								$currValTotal += $row2->curr_val;
								$settForCurrTotal += $row2->sett_for_curr;
								$settValTotal += $row2->sett_val;
							}
							
							$oldOutsAmt = $currValTotal - $settForCurrTotal - $settValTotal;									

							if(( round($oldOutsAmt,2) < round($row->old_outs_amt,2) ) )
							{
								Yii::app()->user->setFlash('error', '-4 - Some of the transactions have been modified, please retrieve the transactions again'.round($oldOutsAmt,2).' '.round($row->old_outs_amt,2));
								$valid = false;
							}
						}
					}
				}
				
				if($valid)
				{
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					
					if($model->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0)$success = TRUE;
					
					$model->payrec_type = $payrec_type;
					$model->curr_amt = $payrec_amt;
					if($model->gl_acct_cd == 'NA')$model->sl_acct_cd = 'nonbank';
					
					if($model->type == 'KPEI')
					{
						$model->acct_type = 'KPEI';
						$model->client_cd = 'KPEI';
					}						
					else if($model->type == 'NEGO')
					{
						$model->acct_type = 'NEGO';
						$model->client_cd = $sameBrokerFlg?$modelDetailLedger[0]->sl_acct_cd:'';
					}
					else
					{
						$model->acct_type = $model->type == 'GS1000 JK'?'GSJK':'GSSL';
						$model->client_cd = 'GS1000';
					}
					
					$model->num_cheq = count($modelCheqLedger)>0?1:0;
					
					//if($bank)$model->curr_cd = $bank->curr_cd;
					$model->curr_cd = 'IDR';
					
					//T_PAYRECH
					if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$model->payrec_num,1) > 0)$success = true;
					else {
						$success = false;
					}
					
					$x=1;
					//T_PAYRECD
					foreach($modelLedger as $row)
					{
						if($row->check == 'Y')
						{
							$row->payrec_num = $model->payrec_num;
							
							if($row->system_generated == 'N')
							{
								$row->doc_ref_num = $row->gl_ref_num = $model->payrec_num;
							}
							else 
							{
								$row->gl_ref_num = $model->payrec_num;
							}
							
							if(!$sameBrokerFlg)$row->client_cd = '';
							
							if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$x) > 0)$success = true;
							else {
								$success = false;
							}
							$x++;
						}
					}
					
					//T_ACCOUNT_LEDGER
					$ledgerSeq = 1;
					for($x=0;$success && $x<$detailLedgerCount;$x++)
					{						
						$modelDetailLedger[$x]->xn_doc_num = $model->payrec_num;
						$modelDetailLedger[$x]->doc_ref_num = Sysparam::model()->find("param_id = 'SYSTEM' and param_cd1 = 'DOC_REF'")->dflg1=='Y'?$model->payrec_num:'';
						$modelDetailLedger[$x]->xn_val = $modelDetailLedger[$x]->curr_val;
						$modelDetailLedger[$x]->reversal_jur = 'N';
						$modelDetailLedger[$x]->manual = 'Y';
						
						if($model->gl_acct_cd != 'NA' || $modelDetailLedger[$x]->bank_flg != 'Y')
						{							
							if($success && $modelDetailLedger[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelDetailLedger[$x]->xn_doc_num,$modelDetailLedger[$x]->tal_id,$model->update_date,$model->update_seq,$ledgerSeq++) > 0)$success = true;
							else {
								$success = false;
							}
						}
					}
	
					//T_FOLDER
					if($model->folder_cd)
					{
						$modelFolder->fld_mon = DateTime::createFromFormat('Y-m-d',$model->payrec_date)->format('my');
						$modelFolder->folder_cd = $model->folder_cd;
						$modelFolder->doc_date = $model->payrec_date;
						$modelFolder->doc_num = $model->payrec_num;
						$modelFolder->user_id = $model->user_id;
						$modelFolder->cre_dt = $model->cre_dt;
						$modelFolder->upd_by = $model->upd_by;
						$modelFolder->upd_dt = $model->upd_dt;
						
						if($success && $modelFolder->executeSp(AConstant::INBOX_STAT_INS,$modelFolder->doc_num,$model->update_date,$model->update_seq,1) > 0)$success = true;
						else {
							$success = false;
						}
					}
					
					//T_CHEQ
					for($x=0;$success && $x<$cheqLedgerCount;$x++)
					{
						$modelCheqLedger[$x]->rvpv_number = $model->payrec_num;
						
						if($success && $modelCheqLedger[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelCheqLedger[$x]->rvpv_number,$modelCheqLedger[$x]->chq_seq,$modelCheqLedger[$x]->chq_num,$model->update_date,$model->update_seq,$x+1) > 0)$success = true;
						else {
							$success = false;
						}
					}
					
					//Update T_CONTRACTS and T_ACCOUNT_LEDGER before approval
					if($model->type != 'GS1000 JK' && $model->type != 'GS1000 SL')
					{
						foreach($modelLedger as $row)
						{
							if($row->check == 'Y' && $row->system_generated == 'Y')
							{
								if($model->type == 'NEGO' && !$sameBrokerFlg)
								{
									$row->client_cd = $row->sl_acct_cd;
								}
								//21DEC2016
								$kode_ab = Vbrokersubrek::model()->find()->broker_cd;
								$kode_ab =substr($kode_ab,0,2);
								if($model->type =='KPEI' && $kode_ab =='PF')
								{
									$row->client_cd=$row->sl_acct_cd;
								}
							
								//END 21DEC2016
								if($success && $row->executeSpRvpvSettled(AConstant::INBOX_STAT_INS) > 0)$success = true;
								else {
									$success = false;
								}
							}
						}
					}
									
					if($success)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$obj->redirect(array('index'));
					}
					else {
						$transaction->rollback();
					}
				}

				$currCount = count($modelLedger);
					
				for(;$temp < $currCount;$temp++)
				{
					$tempModel[] = clone($modelLedger[$temp]);// To contain the error message
					
					unset($modelLedger[$temp]);
				}
			}
		}

		$obj->render('/tpayrechkpei/create',array(
			'model'=>$model,
			'modelLedger'=>$modelLedger,
			//'modelLedgerSave'=>$modelLedgerSave,
			'modelDetailLedger'=>$modelDetailLedger,
			'modelFolder'=>$modelFolder,
			'modelCheqLedger'=>$modelCheqLedger,
			'tempModel'=>$tempModel,
			'retrieved'=>$retrieved
		));
	}

	public function actionUpdate($id, $obj = null, $originalReversalDate = false)
	{
		if($obj === null)$obj = $this;
		
		$model=$this->loadModel($id);
		
		$this->checkCancelled($model, array('index'));
		
		$modelLedger = array();
		$modelDetailLedger = array();
		$modelFolder = Tfolder::model()->find("doc_num = '$model->payrec_num'");
		$modelCheqLedger = array();		
		$modelJvchh = new Tjvchh;
		
		$oldModel = new Tpayrech;
		$oldModelDetail = array();
		$oldModelFolder = new Tfolder;
		$reverseModelLedger = array();
		$reverseModelFolder = new Tfolder;
		
		$sameBrokerFlg = TRUE;
		
		$oldModelLedger = array();
		
		$model->gl_acct_cd = strtoupper($model->gl_acct_cd);
			
		$cancel_reason = '';
		$cancel_reason_cheq = '';
		
		$tempModel = array(); 
		
		if(!$model->acct_type)
		{
			if($model->client_cd = 'KPEI')
			{
				$model->acct_type = 'KPEI';
			}
			else if($model->client_cd = 'GS1000')
			{
				$result = DAO::queryRowSql("SELECT record_source FROM T_PAYRECD WHERE payrec_num = '$model->payrec_num' AND record_source NOT IN ('VCH','ARAP') AND rownum = 1");
				$model->acct_type = $result['record_source'];
			}
			else
			{
				$model->acct_type = 'NEGO';
			}
		}

		$model->scenario = $model->type = $type = $model->acct_type;
		
		if($model->acct_type == 'GSSL')$model->type = 'GS1000 SL';
		else if($model->acct_type == 'GSJK')$model->type = 'GS1000 JK';
		
		$oldPayrecDate = DateTime::createFromFormat('Y-m-d H:i:s',$model->payrec_date)->format('Y-m-d');
		
		$retrieved = 2;
		
		$valid = FALSE;
		$success = FALSE;
		$settled = FALSE;
		$reversal = FALSE;
		$reversal_exception = FALSE;
		$reretrieve_flg = FALSE;

		if(isset($_POST['Tpayrech']))
		{
			$model->attributes=$_POST['Tpayrech'];
			$valid = $model->validate();		
			
			$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'VCH_REF' ")->dflg1;
		
			if($check == 'N')$model->folder_cd = ''; 
			
			$authorizedBackDated = $_POST['authorizedBackDated'];
			
			if(!$authorizedBackDated)
			{
				$currMonth = date('Ym');
				$docMonth = DateTime::createFromFormat('Y-m-d',$model->payrec_date)->format('Ym');
				
				if($docMonth < $currMonth)
				{
					$model->addError('doc_dt','You are not authorized to select last month date');
					$valid = FALSE;
				}
			}

			// TRANSACTION
			if($_POST['submit'] == 'retrieve2')
			{
				$ledgerCount = $_POST['ledgerCount'];
				$reretrieve_flg = true;
				$checkCount= 0;
				
				for($x=0;$x<$ledgerCount;$x++)
				{
					$modelLedger[$x] = new Tpayrecd('retrieve');
					$modelLedger[$x]->attributes = $_POST['Tpayrecdledger'][$x+1];
					
					if($modelLedger[$x]->check == 'Y')$checkCount++;
				}
				
				$retrieved = 1;
				
				if($checkCount == 0)
				{
					Yii::app()->user->setFlash('error', 'There has to be at least one checked transaction');
				}
				else 
				{
					/*if($model->type == 'NEGO')
					{
						// Validate that settled transactions are from the same broker
						$x = 0;
						
						$broker = '';
						
						foreach($modelLedger as $row)
						{
							if($row->check == 'Y')
							{
								if($x == 0)
								{
									$broker = $row->sl_acct_cd;
								}
								else
								{
									$broker_cmp = $row->sl_acct_cd;
									
									if($broker != $broker_cmp)
									{
										//$valid = false;
										//Yii::app()->user->setFlash('error', 'Settled transactions must be from the same broker');
										
										$sameBrokerFlg = FALSE;
									}
								}
								
								$x++;
							}
						}
					}*/
					
					if($valid)
					{
						if($model->type == 'NEGO')
						{
							foreach($modelLedger as $row)
							{
								if($row->check == 'Y')
								{
									$oldLedger = Taccountledger::model()->find("xn_doc_num = '$row->contr_num' AND tal_id = '$row->tal_id'");
									
									$oldLedger->sett_for_curr = $oldLedger->sett_for_curr==null?0:$oldLedger->sett_for_curr;
									$oldLedger->sett_val = $oldLedger->sett_val==null?0:$oldLedger->sett_val;
									
									$oldOutsAmt = $oldLedger->curr_val - $oldLedger->sett_for_curr - $oldLedger->sett_val;
									
									if($oldLedger->reversal_jur != 'N' || ( round($oldOutsAmt,2) < round($row->old_outs_amt,2) ) )
									{
										Yii::app()->user->setFlash('error', '-5 - Some of the transactions have been modified, please retrieve the transactions again');
										$valid = false;
									}
								}
							}
						}
					}
					
					if($valid)
					{
						$retrieved = 2;
						
						$group = array();					
						$detailLedgerCount = 0;
						$x = 0;
						
						foreach($modelLedger as $row)
						{
							if($row->check == 'Y')
							{
								$modelDetailLedger[$x] = new Taccountledger;
								$modelDetailLedger[$x]->gl_acct_cd = $row->gl_acct_cd;
								
								if($model->type == 'GS1000 JK')
								{
									if(trim($modelDetailLedger[$x]->gl_acct_cd) == '3021' || trim($modelDetailLedger[$x]->gl_acct_cd) == '1041' || trim($modelDetailLedger[$x]->gl_acct_cd) == '3360'){
										$modelDetailLedger[$x]->sl_acct_cd = $row->sl_acct_cd;
									}else{
										$modelDetailLedger[$x]->sl_acct_cd = '1'.substr($row->sl_acct_cd,1);
									}
								}
								else 
								{
									$modelDetailLedger[$x]->sl_acct_cd = $row->sl_acct_cd;	
								}
								
								$modelDetailLedger[$x]->curr_val = str_replace(',','',$row->buy_sett_amt) + str_replace(',','',$row->sell_sett_amt);
								$modelDetailLedger[$x]->db_cr_flg = $row->buy_sell_ind=='B'||$row->buy_sell_ind=='D'?'C':'D';
								$modelDetailLedger[$x]->ledger_nar = $row->remarks;
								$modelDetailLedger[$x]->system_generated = 'Y';
								$modelDetailLedger[$x]->bank_flg = 'N';
								
								
								// GROUPING
								if($x > 0)
								{
									$y = 1;
									foreach($modelDetailLedger as $rowDetail)
									{
										if($modelDetailLedger[$x]->gl_acct_cd == $rowDetail->gl_acct_cd && $modelDetailLedger[$x]->sl_acct_cd == $rowDetail->sl_acct_cd)
										{
											//Needs to be grouped
											
											if($modelDetailLedger[$x]->db_cr_flg == $rowDetail->db_cr_flg)
											{
												$rowDetail->curr_val += $modelDetailLedger[$x]->curr_val;
											}
											else 
											{
												if($rowDetail->curr_val > $modelDetailLedger[$x]->curr_val)
												{
													$rowDetail->curr_val -= $modelDetailLedger[$x]->curr_val;
												}
												else {
													$rowDetail->curr_val = $modelDetailLedger[$x]->curr_val - $rowDetail->curr_val;
													$rowDetail->db_cr_flg = $rowDetail->db_cr_flg=='D'?'C':'D';
												}
											}
											
											$rowDetail->ledger_nar = $model->remarks;
											unset($modelDetailLedger[$x]);
											break;
										}
										
										$y++;
										
										if($y == count($modelDetailLedger)) //To Prevent Comparing With Itself
										{
											$x++;
											break;
										}
									}
								}
								else
									$x++;
							}
						}

						//SORT => 1. Debit  2. Credit  3. Bank
						
						$currTotal = count($modelDetailLedger);
						
						for($x=0;$x<$currTotal;$currTotal--)
						{
							for($y=$x+1;$y<$currTotal;$y++)
							{
								if($modelDetailLedger[$y-1]->db_cr_flg != $modelDetailLedger[$y]->db_cr_flg && $modelDetailLedger[$y-1]->db_cr_flg == 'C')
								{
									// SWAP
									
									$tempObj = clone $modelDetailLedger[$y-1];
									$modelDetailLedger[$y-1] = clone $modelDetailLedger[$y];
									$modelDetailLedger[$y] = clone $tempObj;
								}
							}
						}

						$bankLedger = new Taccountledger;
						
						$balDebit = str_replace(',','',$_POST['balDebit']);
						$balCredit = str_replace(',','',$_POST['balCredit']);
						
						$bankLedger->gl_acct_cd = $model->gl_acct_cd;
						$bankLedger->sl_acct_cd = $model->sl_acct_cd;
						$bankLedger->curr_val = $balDebit + $balCredit;
						$bankLedger->db_cr_flg = $balCredit > 0?'C':'D';
						$bankLedger->ledger_nar = $model->remarks;
						$bankLedger->system_generated = 'Y';
						$bankLedger->bank_flg = 'Y';
						
						$modelDetailLedger = array_merge($modelDetailLedger,array($bankLedger));
						
						$modelCheqLedger = Tcheq::model()->findAll(array('select'=>'t.*, rowid','condition'=>"rvpv_number = '$model->payrec_num' AND approved_stat = 'A'"));						
					}
				}
			}
			else 
			{
				// SUBMIT
				$retrieved = 2;
				
				$ledgerCount = $_POST['ledgerCount'];
				$detailLedgerCount = $_POST['detailLedgerCount'];
				$cheqLedgerCount = $_POST['cheqLedgerCount'];
				
				$reretrieve_flg = $_POST['reretrieve_flg'];
				
				$oldModel = $this->loadModel($id);
				$oldModel->payrec_date = DateTime::createFromFormat('Y-m-d G:i:s',$oldModel->payrec_date)->format('Y-m-d');
				$oldModel->gl_acct_cd = trim($oldModel->gl_acct_cd);
				
				$talId = 1;
				
				for($x=0;$x<$ledgerCount;$x++)
				{
					$modelLedger[$x] = new Tpayrecd;
					$modelLedger[$x]->attributes = $_POST['Tpayrecdledger'][$x+1];
					$modelLedger[$x]->system_generated = 'Y';
					
					if($modelLedger[$x]->check == 'Y')
					{
						$modelLedger[$x]->payrec_date = $model->payrec_date;
						
						if($modelLedger[$x]->buy_sell_ind == 'J' || $modelLedger[$x]->buy_sell_ind == 'C')
						{
							$modelLedger[$x]->db_cr_flg = 'D';
							$modelLedger[$x]->payrec_amt = $modelLedger[$x]->buy_sett_amt;	
						}
						else
						{
							$modelLedger[$x]->db_cr_flg = 'C';
							$modelLedger[$x]->payrec_amt = $modelLedger[$x]->sell_sett_amt;
						}
						
						$modelLedger[$x]->doc_date = $modelLedger[$x]->trx_date;
						$modelLedger[$x]->sett_for_curr = 0;
						$modelLedger[$x]->sett_val = 0;
						
						if($model->type == 'KPEI')
						{
							$modelLedger[$x]->client_cd = 'KPEI';
							$modelLedger[$x]->doc_ref_num = date('my').'KPEI'.date('dmy');
							$modelLedger[$x]->tal_id = $modelLedger[$x]->doc_tal_id = $talId++;
							$modelLedger[$x]->record_source = 'KPEI';
						}
						else if($model->type == 'NEGO')
						{
							$modelLedger[$x]->client_cd = $modelLedger[$x]->sl_acct_cd;
							$modelLedger[$x]->doc_ref_num = $modelLedger[$x]->contr_num;
							$modelLedger[$x]->record_source = 'NEGO';
							$modelLedger[$x]->doc_tal_id = $modelLedger[$x]->tal_id;
						}
						else 
						{
							$record_source = $model->acct_type;
							
							$result = DAO::queryRowSql("SELECT jur_type FROM MST_GLA_TRX WHERE gl_a = '".trim($modelLedger[$x]->gl_acct_cd)."'");
							
							if(!$result || $result['jur_type'] != 'BROK' )
							{
								// KPEI
								
								$modelLedger[$x]->doc_ref_num = date('my').$record_source.date('dmy');
							}
							else 
							{
								// NEGO
								
								$modelLedger[$x]->doc_ref_num = $modelLedger[$x]->contr_num;
							}
							
							$modelLedger[$x]->client_cd = 'GS1000';							
							$modelLedger[$x]->tal_id = $modelLedger[$x]->doc_tal_id = $talId++;
							$modelLedger[$x]->record_source = $record_source;
						}
						
						$valid = $modelLedger[$x]->validate() && $valid;
					}
				}

				if($model->type == 'NEGO')
				{
					$x = 0;
					
					$broker = '';
					
					foreach($modelLedger as $row)
					{
						if($row->check == 'Y')
						{
							if($x == 0)
							{
								$broker = $row->sl_acct_cd;
							}
							else
							{
								$broker_cmp = $row->sl_acct_cd;
								
								if($broker != $broker_cmp)
								{
									$sameBrokerFlg = FALSE;
									break;
								}
							}
							
							$x++;
						}
					}
				}

				$bank = Bankacct::model()->find("TRIM(gl_acct_cd) = '$model->gl_acct_cd' AND sl_acct_cd = '$model->sl_acct_cd'");

				$y = $temp = count($modelLedger);
				//$insertedTalId = 2;
				
				if($reretrieve_flg)
				{
					$reversal = true;
					
					for($x=$tal_id=0;$x<$detailLedgerCount;$x++)
					{
						$modelDetailLedger[$x] = new Taccountledger;
						$modelDetailLedger[$x]->attributes = $_POST['Taccountledger'][$x+1];
						
						//if($bank)$modelDetailLedger[$x]->curr_cd = $bank->curr_cd; 
						$modelDetailLedger[$x]->curr_cd = 'IDR';
						$modelDetailLedger[$x]->db_cr_flg = $modelDetailLedger[$x]->db_cr_flg=='DEBIT'||$modelDetailLedger[$x]->db_cr_flg=='D'?'D':'C';
						$modelDetailLedger[$x]->folder_cd = $model->folder_cd;
						$modelDetailLedger[$x]->doc_date = $model->payrec_date;
						$modelDetailLedger[$x]->due_date = $model->payrec_date;
						$modelDetailLedger[$x]->netting_date = $model->payrec_date;
						$modelDetailLedger[$x]->sett_val = 0;
						$modelDetailLedger[$x]->sett_for_curr = 0;
						$modelDetailLedger[$x]->arap_due_date = $model->payrec_date;
						
						$glA = trim($modelDetailLedger[$x]->gl_acct_cd);
						$slA = $modelDetailLedger[$x]->sl_acct_cd;
						$client = Client::model()->find(array('select'=>'client_cd','condition'=>"client_cd = '$slA'"));
						
						if($modelDetailLedger[$x]->system_generated == 'Y')
						{
							if($modelDetailLedger[$x]->bank_flg == 'N')
							{
								$modelDetailLedger[$x]->tal_id = $tal_id+1;
								$tal_id++;	
							
								/*if($client)
								{
									$glAccount = Glaccount::model()->find("TRIM(gl_a) = '$glA' AND sl_a = '$slA'");
									$modelDetailLedger[$x]->acct_type = $glAccount->acct_type;
								}*/
							}
							else 
							{
								$modelDetailLedger[$x]->tal_id = 555;
							}
						}
						else 
						{
							//USER INSERTED ROW
				
							$modelDetailLedger[$x]->tal_id = $tal_id+1; 
							$tal_id++;	
							
							$modelLedger[$y] = new Tpayrecd;
							
							$modelLedger[$y]->system_generated = 'N';
								
							$modelLedger[$y]->gl_acct_cd = $modelDetailLedger[$x]->gl_acct_cd;
							$modelLedger[$y]->sl_acct_cd = $modelDetailLedger[$x]->sl_acct_cd;
							$modelLedger[$y]->payrec_amt = $modelDetailLedger[$x]->curr_val;
							$modelLedger[$y]->db_cr_flg = $modelDetailLedger[$x]->db_cr_flg;
							$modelLedger[$y]->remarks = $modelDetailLedger[$x]->ledger_nar;	
														
							$modelLedger[$y]->payrec_date = $model->payrec_date;										
							$modelLedger[$y]->record_source = $client?Sysparam::model()->find("param_id = 'VOUCHER ENTRY' and param_cd1 = 'SOURCE' AND param_cd2 = 'ARAP'")->dstr1:'VCH';
							//$modelLedger[$y]->doc_ref_num = date('my').'ZZ1234567';
							$modelLedger[$y]->ref_folder_cd = $model->folder_cd;
							$modelLedger[$y]->due_date = $model->payrec_date;
							
							if($model->type == 'KPEI')
							{
								$modelLedger[$y]->client_cd = 'KPEI';
								//$modelLedger[$y]->tal_id = $talId++; //Continue from above
							}
							else if($model->type == 'NEGO')
							{
								$modelLedger[$y]->client_cd = $modelDetailLedger[0]->sl_acct_cd;
								//$modelLedger[$y]->tal_id = ++$insertedTalId; //Use new counter
							}
							else
							{
								$modelLedger[$y]->client_cd = 'GS1000';
							}
							
							$modelLedger[$y]->tal_id = $modelLedger[$y]->doc_tal_id = $modelDetailLedger[$x]->tal_id;
								
							$modelLedger[$y]->sett_for_curr = 0;
							$modelLedger[$y]->sett_val = 0;
							
							$modelLedger[$y]->check = 'Y';
							
							$valid = $modelLedger[$y]->validate() && $valid;
							
							$y++;
						}		
						
						$valid = $modelDetailLedger[$x]->validate() && $valid;
					}
				}
				else 
				{
					//NO RE-RETRIEVE
					
					if(isset($_POST['cancel_reason']))
					{
						if(!$_POST['cancel_reason'])
						{
							$valid = false;
							Yii::app()->user->setFlash('error', 'Cancel Reason Must be Filled');
						}
						else
						{
							$cancel_reason = $_POST['cancel_reason'];
							$model->cancel_reason = $_POST['cancel_reason'];
						}
					}
					
					if(isset($_POST['cancel_reason_cheq']))
					{
						if(!$_POST['cancel_reason_cheq'])
						{
							$valid = false;
							Yii::app()->user->setFlash('error', 'Cheque Cancel Reason Must be Filled');
						}
						else
						{
							$cancel_reason_cheq = $_POST['cancel_reason_cheq'];
							if(!$model->cancel_reason)$model->cancel_reason = $_POST['cancel_reason_cheq'];
						}
					}
					
					if($model->payrec_date != $oldModel->payrec_date || $model->gl_acct_cd != $oldModel->gl_acct_cd || $model->sl_acct_cd != $oldModel->sl_acct_cd)
					{
						$reversal = true;
					}
					
					$result = DAO::queryRowSql("SELECT MAX(tal_id) last_tal_id FROM T_ACCOUNT_LEDGER WHERE xn_doc_num = '$model->payrec_num' AND tal_id <> 555");
					$lastTalId = $result['last_tal_id'];
					
					for($x=0;$x<$detailLedgerCount;$x++)
					{
						if(isset($_POST['Taccountledger'][$x+1]['save_flg']) && $_POST['Taccountledger'][$x+1]['save_flg'] == 'Y')
						{
							if(isset($_POST['Taccountledger'][$x+1]['cancel_flg']))
							{
								// CHECKED EXISTING RECORD
								
								$rowid = $_POST['Taccountledger'][$x+1]['rowid'];
								$modelDetailLedger[$x] = Taccountledger::model()->find("rowid='$rowid'");
								
								
								if($_POST['Taccountledger'][$x+1]['cancel_flg'] == 'Y')
								{
									//CANCEL
									$modelDetailLedger[$x]->scenario = 'cancel';
									$modelDetailLedger[$x]->cancel_reason = $_POST['cancel_reason'];
									$modelDetailLedger[$x]->rowid = $rowid;
									$modelDetailLedger[$x]->system_generated = 'N';
									$modelDetailLedger[$x]->bank_flg = 'N';
									$modelDetailLedger[$x]->cancel_flg = 'Y';
									$modelDetailLedger[$x]->save_flg = 'Y';
									
									$reversal = true;
								}
								else 
								{
									//UPDATE
									$modelDetailLedger[$x]->scenario = 'update';
									
									if(
										trim($modelDetailLedger[$x]->gl_acct_cd) != trim($_POST['Taccountledger'][$x+1]['gl_acct_cd'])
										||$modelDetailLedger[$x]->sl_acct_cd != $_POST['Taccountledger'][$x+1]['sl_acct_cd']
										||$modelDetailLedger[$x]->curr_val != str_replace(',','',$_POST['Taccountledger'][$x+1]['curr_val'])
										||$modelDetailLedger[$x]->db_cr_flg != substr($_POST['Taccountledger'][$x+1]['db_cr_flg'],0,1)
									)
									{
										$reversal = true;
									}
									
									$modelDetailLedger[$x]->attributes = $_POST['Taccountledger'][$x+1];
									$modelDetailLedger[$x]->db_cr_flg = $modelDetailLedger[$x]->db_cr_flg=='DEBIT'||$modelDetailLedger[$x]->db_cr_flg=='D'?'D':'C';
								}
							}
							else 
							{
								//CHECKED NEW RECORD
								//INSERT
								$modelDetailLedger[$x] = new Taccountledger;
								$modelDetailLedger[$x]->attributes = $_POST['Taccountledger'][$x+1];
								
								$modelDetailLedger[$x]->scenario = 'insert';
								
								$modelDetailLedger[$x]->sett_val = 0;
								$modelDetailLedger[$x]->sett_for_curr = 0;
								
								$modelDetailLedger[$x]->tal_id = ++$lastTalId;
								
								$reversal = true;
							}
							
							//if($bank)$modelDetailLedger[$x]->curr_cd = $bank->curr_cd; 
							$modelDetailLedger[$x]->curr_cd = 'IDR';
							$modelDetailLedger[$x]->folder_cd = $model->folder_cd;
							$modelDetailLedger[$x]->doc_date = $model->payrec_date;
							$modelDetailLedger[$x]->due_date = $model->payrec_date;
							$modelDetailLedger[$x]->netting_date = $model->payrec_date;
							$modelDetailLedger[$x]->arap_due_date = $model->payrec_date;
							
							$valid = $modelDetailLedger[$x]->validate() && $valid;
						}
						else 
						{
							if(isset($_POST['Taccountledger'][$x+1]['rowid']))
								$rowid = $_POST['Taccountledger'][$x+1]['rowid'];
							else 
							{
								$rowid = '';
							}
							
							if($rowid)
							{
								// NOT CHECKED EXISTING RECORD
								
								$modelDetailLedger[$x] = Taccountledger::model()->find("rowid='$rowid'");
								$modelDetailLedger[$x]->rowid = $rowid;
								$modelDetailLedger[$x]->scenario = 'none';
								$modelDetailLedger[$x]->system_generated = $_POST['Taccountledger'][$x+1]['system_generated'];
								$modelDetailLedger[$x]->bank_flg = $_POST['Taccountledger'][$x+1]['bank_flg'];
								
								if($modelDetailLedger[$x]->bank_flg == 'Y') //Exception for bank record because its value can be changed without ticking the checkbox
								{
									$modelDetailLedger[$x]->scenario = 'update';
									$modelDetailLedger[$x]->attributes = $_POST['Taccountledger'][$x+1];
									$modelDetailLedger[$x]->db_cr_flg = $modelDetailLedger[$x]->db_cr_flg=='DEBIT'||$modelDetailLedger[$x]->db_cr_flg=='D'?'D':'C';
								}
								
								//if($bank)$modelDetailLedger[$x]->curr_cd = $bank->curr_cd; 
								$modelDetailLedger[$x]->curr_cd = 'IDR';
								$modelDetailLedger[$x]->gl_acct_cd = trim($modelDetailLedger[$x]->gl_acct_cd);
								$modelDetailLedger[$x]->folder_cd = $model->folder_cd;
								$modelDetailLedger[$x]->doc_date = $model->payrec_date;
								$modelDetailLedger[$x]->due_date = $model->payrec_date;
								$modelDetailLedger[$x]->netting_date = $model->payrec_date;
								$modelDetailLedger[$x]->arap_due_date = $model->payrec_date;
								
								$valid = $modelDetailLedger[$x]->validate() && $valid;
							}	
						}
					}

					//ASSIGN USER INSERTED ROW TO TPAYRECD
					foreach($modelDetailLedger as $row)
					{
						if($row->system_generated == 'N' && $row->cancel_flg == 'N')
						{
							$glA = $row->gl_acct_cd;
							$slA = $row->sl_acct_cd;
							$client = Client::model()->find(array('select'=>'client_cd','condition'=>"client_cd = '$slA'"));
							
							$modelLedger[$y] = new Tpayrecd;
						
							$modelLedger[$y]->system_generated = 'N';
								
							$modelLedger[$y]->gl_acct_cd = $row->gl_acct_cd;
							$modelLedger[$y]->sl_acct_cd = $row->sl_acct_cd;
							$modelLedger[$y]->payrec_amt = $row->curr_val;
							$modelLedger[$y]->db_cr_flg = $row->db_cr_flg;
							$modelLedger[$y]->remarks = $row->ledger_nar;	
														
							$modelLedger[$y]->payrec_date = $model->payrec_date;										
							$modelLedger[$y]->record_source = $client?Sysparam::model()->find("param_id = 'VOUCHER ENTRY' and param_cd1 = 'SOURCE' AND param_cd2 = 'ARAP'")->dstr1:'VCH';
							//$modelLedger[$y]->doc_ref_num = date('my').'ZZ1234567';
							$modelLedger[$y]->ref_folder_cd = $model->folder_cd;
							$modelLedger[$y]->due_date = $model->payrec_date;
							
							if($model->type == 'KPEI')
							{
								$modelLedger[$y]->client_cd = 'KPEI';
								//$modelLedger[$y]->tal_id = $talId++; //Continue from above
							}
							else if($model->type == 'NEGO')
							{
								$modelLedger[$y]->client_cd = $modelDetailLedger[0]->sl_acct_cd;
								//$modelLedger[$y]->tal_id = ++$insertedTalId; //Use new counter
							}
							else
							{
								$modelLedger[$y]->client_cd = 'GS1000';
							}
							
							$modelLedger[$y]->tal_id = $modelLedger[$y]->doc_tal_id = $row->tal_id;
							
							$modelLedger[$y]->sett_for_curr = 0;
							$modelLedger[$y]->sett_val = 0;
							
							$modelLedger[$y]->check = 'Y';
							
							$valid = $modelLedger[$y]->validate() && $valid;
							
							$y++;
						}
					}
				}
					
				$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'CHECK' and param_cd2 ='ACCTBRCH'")->dflg1;

				if($check == 'Y' && $model->type != 'KPEI')
				{
					$brch_cd = '';
					$x = 0;
					foreach($modelDetailLedger as $row)
					{
						if($row->gl_acct_cd != 'NA' && $row->gl_acct_cd != '')
						{
							if($x==0)
							{
								$sql = "SELECT check_acct_branch('$row->gl_acct_cd','$row->sl_acct_cd') brch_cd FROM dual";
								$branch = DAO::queryRowSql($sql);
								$brch_cd = $branch['brch_cd'];
	
							}
							else 
							{
								if($row->cancel_flg == 'N')
								{	
									$sql = "SELECT check_acct_branch('$row->gl_acct_cd','$row->sl_acct_cd') brch_cd FROM dual";
									$branch_cmp = DAO::queryRowSql($sql);
									$brch_cd_cmp = $branch_cmp['brch_cd'];
	
									if($brch_cd != $brch_cd_cmp)
									{
										$valid = false;
										$row->addError('gl_acct_cd','All journal entries must have GL Account and SL Account of the same branch');
										break;
									}
								}
							}
							$x++;
						}
					}	
				}
				
				$payrec_type = $payrec_amt = '';
				
				if($model->gl_acct_cd != 'NA')
				{
					foreach($modelDetailLedger as $row)
					{
						if($row->bank_flg == 'Y')
						{
							$payrec_amt = $row->curr_val;
							
							if($row->db_cr_flg == 'DEBIT' || $row->db_cr_flg == 'D')$payrec_type = 'RV';
							else {
								$payrec_type = 'PV';
							}
							break;
						}
					}
				}
				else 
				{
					$payrec_type = 'RV';
					$payrec_amt = 0;
				}
				
				foreach($modelLedger as $row)
				{
					$row->payrec_type = $payrec_type;
				}
				
				foreach($modelDetailLedger as $row)
				{
					if($row->system_generated == 'Y')$row->record_source = $payrec_type;
					else {
						$row->record_source = $payrec_type.'O';
					}
					
					$row->budget_cd = $payrec_type.'CH';
				}
				
				for($x=0;$x<$cheqLedgerCount;$x++)
				{
					if(isset($_POST['Tcheqledger'][$x+1]['save_flg']) && $_POST['Tcheqledger'][$x+1]['save_flg'] == 'Y')
					{
						if(isset($_POST['Tcheqledger'][$x+1]['cancel_flg']))
						{
							// CHECKED EXISTING RECORD
								
							$rowid = $_POST['Tcheqledger'][$x+1]['rowid'];
							$modelCheqLedger[$x] = Tcheq::model()->find("rowid='$rowid'");								
							
							if($_POST['Tcheqledger'][$x+1]['cancel_flg'] == 'Y')
							{
								//CANCEL
								$modelCheqLedger[$x]->scenario = 'cancel';
								$modelCheqLedger[$x]->cancel_reason = $_POST['cancel_reason_cheq'];
								$modelCheqLedger[$x]->rowid = $rowid;
								$modelCheqLedger[$x]->cancel_flg = 'Y';
								$modelCheqLedger[$x]->save_flg = 'Y';
								if($modelCheqLedger[$x]->chq_dt)$modelCheqLedger[$x]->chq_dt = DateTime::createFromFormat('Y-m-d G:i:s',$modelCheqLedger[$x]->chq_dt)->format('Y-m-d');
							}
							else 
							{
								//UPDATE
								$modelCheqLedger[$x]->scenario = 'update';
								$modelCheqLedger[$x]->attributes = $_POST['Tcheqledger'][$x+1];
							}
							
							if($bank)$modelCheqLedger[$x]->bank_cd = $bank->bank_cd;
							$modelCheqLedger[$x]->sl_acct_cd = $model->sl_acct_cd;
							$modelCheqLedger[$x]->payee_bank_cd = $model->client_bank_cd;
							$modelCheqLedger[$x]->payee_acct_num = $model->client_bank_acct;
							$modelCheqLedger[$x]->payee_name = $model->payrec_frto;
						}
						else 
						{
							//CHECKED NEW RECORD
								
							//INSERT
							$modelCheqLedger[$x] = new Tcheq;
							$modelCheqLedger[$x]->attributes = $_POST['Tcheqledger'][$x+1];
							
							$modelCheqLedger[$x]->scenario = 'insert';
						
							if($bank)$modelCheqLedger[$x]->bank_cd = $bank->bank_cd;
							$modelCheqLedger[$x]->sl_acct_cd = $model->sl_acct_cd;
							$modelCheqLedger[$x]->chq_stat = 'A';
							$modelCheqLedger[$x]->payee_bank_cd = $model->client_bank_cd;
							$modelCheqLedger[$x]->payee_acct_num = $model->client_bank_acct;
							$modelCheqLedger[$x]->payee_name = $model->payrec_frto;
						}
						
						$valid = $modelCheqLedger[$x]->validate() && $valid;
					}
					else 
					{
						if(isset($_POST['Tcheqledger'][$x+1]['rowid']))
							$rowid = $_POST['Tcheqledger'][$x+1]['rowid'];
						else 
						{
							$rowid = '';
						}
						
						if($rowid)
						{
							// NOT CHECKED EXISTING RECORD
							
							$modelCheqLedger[$x] = Tcheq::model()->find("rowid='$rowid'");
							$modelCheqLedger[$x]->rowid = $rowid;
							
							if($modelCheqLedger[$x]->chq_dt)$modelCheqLedger[$x]->chq_dt = DateTime::createFromFormat('Y-m-d G:i:s',$modelCheqLedger[$x]->chq_dt)->format('Y-m-d');
							$valid = $modelCheqLedger[$x]->validate() && $valid;
						}
					}
				}

				$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'VCH_REF' ")->dflg1;
				
				if($check == 'Y')
				{
					$glAccount = Glaccount::model()->find("TRIM(gl_a) = '$model->gl_acct_cd'");
					
					if($glAccount && $glAccount->acct_type == 'BANK')
					{
						$payrecFlg = $payrec_type=='RV'?'RECEIPT':'PAYMENT';
						
						$folderChar = Sysparam::model()->find("param_id = 'VOUCHER ENTRY' AND param_cd1 = '$payrecFlg' AND param_cd2 = 'FOLDERCD' AND param_cd3 = 'CHAR3'");
						
						if($folderChar)
						{
							if(substr($model->folder_cd,2,1) != $folderChar->dstr1)
							{
								$model->addError('folder_cd', "If voucher type is '$payrecFlg' file code must contain '".$folderChar->dstr1."'");
								$valid = false;
							}
						}
					}
				}
				
				if($model->type == 'NEGO')
				{
					foreach($modelLedger as $row)
					{
						if($row->check == 'Y' && $row->system_generated == 'Y')
						{
							$oldLedger = Taccountledger::model()->find("xn_doc_num = '$row->contr_num' AND tal_id = '$row->tal_id'");
							
							$oldLedger->sett_for_curr = $oldLedger->sett_for_curr==null?0:$oldLedger->sett_for_curr;
							$oldLedger->sett_val = $oldLedger->sett_val==null?0:$oldLedger->sett_val;
							
							$oldOutsAmt = $oldLedger->curr_val - $oldLedger->sett_for_curr - $oldLedger->sett_val;
							
							if($oldLedger->reversal_jur != 'N' || ( round($oldOutsAmt,2) < round($row->old_outs_amt,2) ) )
							{
								Yii::app()->user->setFlash('error', '-6 - Some of the transactions have been modified, please retrieve the transactions again');
								$valid = false;
							}
						}
					}
				}

				/*-------------BEGIN CONDITIONAL REVERSAL TOGGLE----------------*/
			
				// Uncomment the following code to apply conditional reversal
				
				/*if(str_replace('-','',$oldPayrecDate) >= date('Ymd'))
				{
					if($reversal)
					{
						$reversal = false;
						$reversal_exception = true;
					}
				}*/
				
				
				// Comment the following code to apply conditional reversal
				
				$reversal = true;
				
				/*-------------END CONDITIONAL REVERSAL TOGGLE----------------*/

				if($valid)
				{
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					
					if($model->executeSpHeader(AConstant::INBOX_STAT_UPD,$this->menuName) > 0)$success = TRUE;
					
					$model->payrec_type = $payrec_type;
					$model->curr_amt = $payrec_amt;
					if($model->gl_acct_cd == 'NA')$model->sl_acct_cd = 'nonbank';
					
					if($model->type == 'KPEI')
					{
						$model->acct_type = 'KPEI';
						$model->client_cd = 'KPEI';
					}						
					else if($model->type == 'NEGO')
					{
						$model->acct_type = 'NEGO';
						$model->client_cd = $sameBrokerFlg?$modelDetailLedger[0]->sl_acct_cd:'';
					}
					else
					{
						$model->client_cd = 'GS1000';
					}
					
					$model->num_cheq = count($modelCheqLedger)>0?1:0;
					
					//if($bank)$model->curr_cd = $bank->curr_cd;
					$model->curr_cd = 'IDR';
					
					if($reversal)
					{
						// REVERSAL
					
						//--------------CANCEL + REVERSE-----------------//
						
						// CANCEL T_PAYRECH
						$oldModel->update_date = $model->update_date;
						$oldModel->update_seq = $model->update_seq;
						if($success && $oldModel->executeSp(AConstant::INBOX_STAT_CAN,$oldModel->payrec_num,2) > 0)$success = true;
						else {
							$success = false;
						}
						
						$oldModelLedger = Tpayrecd::model()->findAll("payrec_num = '$oldModel->payrec_num' AND approved_sts = 'A'");
						
						// CANCEL T_PAYRECD
						$modelLedgerSeq = 1;
						foreach($oldModelLedger as $row)
						{
							if($row->payrec_date)$row->payrec_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->payrec_date)->format('Y-m-d');
							if($row->doc_date)$row->doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->doc_date)->format('Y-m-d');
							if($row->due_date)$row->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('Y-m-d');
							
							if($success && $row->executeSp(AConstant::INBOX_STAT_CAN,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$modelLedgerSeq++) > 0)$success = true;
							else {
								$success = false;
							}
						}

						$reverseModelLedger = Taccountledger::model()->findAll("xn_doc_num = '$oldModel->payrec_num' AND approved_sts = 'A'");
						
						$reversalDate = $oldModel->payrec_date;
						
						if(!$originalReversalDate)
						{
							$oldJournalDate = DateTime::createFromFormat('Y-m-d',$oldModel->payrec_date)->format('Ymd');
							$newJournalDate = DateTime::createFromFormat('Y-m-d',$model->payrec_date)->format('Ymd');
							if($oldJournalDate < date('Ymd'))$reversalDate = date('Y-m-d');
							if($newJournalDate == date('Ymd')){
								$reversalDate = $model->payrec_date;
							}else if($newJournalDate < date('Ymd')){
								$model->addError('payrec_date','Voucher Date harus diubah menjadi tanggal hari ini!');
								$success = false;
							}else{
								$model->addError('payrec_date','Voucher Date tidak boleh melewati tanggal hari ini!');
								$success = false;
							}
						}
					
						$result = DAO::queryRowSql("SELECT GET_DOCNUM_GL(TO_DATE('$reversalDate','YYYY-MM-DD HH24:MI:SS'),'GL') AS REVERSE_DOC_NUM FROM dual");
						$reverseDocNum = $result['reverse_doc_num'];
						
						$result = DAO::queryRowSql("SELECT F_GET_FOLDER_NUM(TO_DATE('$reversalDate','YYYY-MM-DD HH24:MI:SS'),'RJ-') AS REVERSE_FOLDER_CD FROM dual");
						$reverseFolderCd = $result['reverse_folder_cd'];
						
						// INSERT REVERSE T_ACCOUNT_LEDGER
						$detailLedgerSeq = 1;
						foreach($reverseModelLedger as $row)
						{
							$row->xn_doc_num = $reverseDocNum;
							$row->db_cr_flg = $row->db_cr_flg=='D'?'C':'D';
							$row->record_source = 'RE';
							$row->sett_val = $row->curr_val;
							$row->folder_cd = $model->folder_cd?$reverseFolderCd:'';
							$row->cre_dt = date('Y-m-d H:i:s');
							
							/*if($row->doc_date)$row->doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->doc_date)->format('Y-m-d');
							if($row->due_date)$row->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('Y-m-d');
							if($row->netting_date)$row->netting_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->netting_date)->format('Y-m-d');
							if($row->arap_due_date)$row->arap_due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->arap_due_date)->format('Y-m-d');*/
							
							$row->doc_date = $row->due_date = $row->netting_date = $row->arap_due_date = $reversalDate;
													
							if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$row->xn_doc_num,$row->tal_id,$model->update_date,$model->update_seq,$detailLedgerSeq++) > 0)$success = true;
							else {
								$success = false;
							}
						}
						
						// INSERT T_JVCHH 
							
						$modelJvchh = new Tjvchh;
						$modelJvchh->jvch_num = $reverseDocNum;
						$modelJvchh->jvch_type = 'RE';
						$modelJvchh->jvch_date = $reversalDate;
						//$modelJvchh->curr_cd = $oldModel->curr_cd;
						$modelJvchh->curr_cd = 'IDR';
						$modelJvchh->curr_amt = $oldModel->curr_amt;
						$modelJvchh->remarks = $oldModel->remarks;
						$modelJvchh->folder_cd = $model->folder_cd?$reverseFolderCd:'';
						$modelJvchh->user_id = Yii::app()->user->id;
						$modelJvchh->cre_dt = date('Y-m-d H:i:s');
						$modelJvchh->update_date = $model->update_date;
						$modelJvchh->update_seq = $model->update_seq;
						
						if($success && $modelJvchh->executeSp(AConstant::INBOX_STAT_INS, $modelJvchh->jvch_num, 1) > 0 )$success = true;
						else {
							$success = false;
						}
						
						// CANCEL T_FOLDER
						
						$oldModelFolder = Tfolder::model()->find("doc_num = '$oldModel->payrec_num'");
						
						if($oldModelFolder)
						{
							if($oldModelFolder->doc_date)$oldModelFolder->doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$oldModelFolder->doc_date)->format('Y-m-d');
							
							if($success && $oldModelFolder->executeSp(AConstant::INBOX_STAT_CAN,$oldModel->payrec_num,$model->update_date,$model->update_seq,1) > 0)$success = true;
							else {
								$success = false;
							}
						
						
						// INSERT REVERSE T_FOLDER
						
							$reverseModelFolder = new Tfolder;
							$reverseModelFolder->fld_mon = DateTime::createFromFormat('Y-m-d',$reversalDate)->format('my');
							$reverseModelFolder->folder_cd = $reverseFolderCd;
							$reverseModelFolder->doc_date = $reversalDate;
							$reverseModelFolder->doc_num = $reverseDocNum;
							$reverseModelFolder->cre_dt = date('Y-m-d H:i:s');
							$reverseModelFolder->user_id = $model->user_id;
							
							if($success && $reverseModelFolder->executeSp(AConstant::INBOX_STAT_INS,$reverseModelFolder->doc_num,$model->update_date,$model->update_seq,2) > 0)$success = true;
							else {
								$success = false;
							}
						}
						
						//--------------END CANCEL + REVERSE-----------------//
						
						
						
						//----------------INSERT NEW RECORD-----------------//
						
						// INSERT T_PAYRECH
						$model->payrec_num = '';
						if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$model->payrec_num,1) > 0)$success = true; //Record Seq = 1, to be shown on 'inbox unprocessed'
						else {
							$success = false;
						}
						
						//T_PAYRECD
						foreach($modelLedger as $row)
						{
							if($row->check == 'Y')
							{
								$row->payrec_num = $model->payrec_num;
								
								if($row->system_generated == 'N')
								{
									$row->doc_ref_num = $row->gl_ref_num = $model->payrec_num;
								}
								else 
								{
									$row->gl_ref_num = $model->payrec_num;
								}
								
								if(!$sameBrokerFlg)$row->client_cd = '';
								
								if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$modelLedgerSeq++) > 0)$success = true;
								else {
									$success = false;
								}
							}
						}
						
						//T_ACCOUNT_LEDGER
						$tal_id = 2;
						foreach($modelDetailLedger as $row)
						{
							if($row->cancel_flg != 'Y')
							{						
								$row->xn_doc_num = $model->payrec_num;
								$row->doc_ref_num = Sysparam::model()->find("param_id = 'SYSTEM' and param_cd1 = 'DOC_REF'")->dflg1=='Y'?$model->payrec_num:'';
								$row->xn_val = $row->curr_val;
								$row->reversal_jur = 'N';
								$row->manual = 'Y';
								
								if($model->int_adjust=='Y')$row->budget_cd = 'INTADJ';
								
								if($row->bank_flg == 'Y')
								{
									$row->tal_id = 555;	
								}
								else 
								{
									$row->tal_id = $tal_id++;
								}
															
								if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$row->xn_doc_num,$row->tal_id,$model->update_date,$model->update_seq,$detailLedgerSeq++) > 0)$success = true;
								else {
									$success = false;
								}
							}
						}
						
						//T_FOLDER
						if($model->folder_cd)
						{
							$modelFolder->fld_mon = DateTime::createFromFormat('Y-m-d',$model->payrec_date)->format('my');
							$modelFolder->folder_cd = $model->folder_cd;
							$modelFolder->doc_date = $model->payrec_date;
							$modelFolder->doc_num = $model->payrec_num;
							$modelFolder->user_id = $model->user_id;
							$modelFolder->cre_dt = $model->cre_dt;
							
							if($success && $modelFolder->executeSp(AConstant::INBOX_STAT_INS,$modelFolder->doc_num,$model->update_date,$model->update_seq,3) > 0)$success = true;
							else {
								$success = false;
							}
						}
						
						//----------------END INSERT NEW RECORD-----------------//
						
						//UPDATE T_CHEQ
						
						$recordSeq = 1;
						
						for($x=0; $success && $x<$cheqLedgerCount; $x++)
						{
							$oldRvpvNumber = $modelCheqLedger[$x]->rvpv_number;
							$oldChqSeq = $modelCheqLedger[$x]->chq_seq;
								
							$modelCheqLedger[$x]->rvpv_number = $model->payrec_num;
							$modelCheqLedger[$x]->chq_seq = $modelCheqLedger[$x]->seqno = $recordSeq;
							
							if($modelCheqLedger[$x]->save_flg == 'Y')
							{							
								if($modelCheqLedger[$x]->cancel_flg == 'Y')
								{
									//CANCEL
									if($success && $modelCheqLedger[$x]->executeSp(AConstant::INBOX_STAT_CAN,$oldRvpvNumber,$oldChqSeq,$modelCheqLedger[$x]->chq_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}
								else if($modelCheqLedger[$x]->rowid)
								{
									//UPDATE
									if($success && $modelCheqLedger[$x]->executeSp(AConstant::INBOX_STAT_UPD,$oldRvpvNumber,$oldChqSeq,$modelCheqLedger[$x]->chq_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}			
								else 
								{
									//INSERT
									if($success && $modelCheqLedger[$x]->executeSp(AConstant::INBOX_STAT_INS,$oldRvpvNumber,$oldChqSeq,$modelCheqLedger[$x]->chq_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}
							}
							else 
							{
								// UPDATE RVPV_NUMBER OF 'NOT CHECKED' EXISTING RECORD
								
								if($success && $modelCheqLedger[$x]->executeSp(AConstant::INBOX_STAT_UPD,$oldRvpvNumber,$oldChqSeq,$modelCheqLedger[$x]->chq_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
								else {
									$success = false;
								}
							}
							$recordSeq++;
						}

						$x = 0;
						
						if($model->type == 'NEGO')
						{
							foreach($oldModelLedger as $row)
							{
								if($row->record_source != 'VCH' && $row->record_source != 'ARAP')
								{
									$updated = false;
									
									foreach($modelLedger as $rowUpd)
									{
										if($rowUpd->check == 'Y' && $rowUpd->system_generated == 'Y')
										{
											if($rowUpd->doc_ref_num == $row->doc_ref_num && $rowUpd->tal_id == $row->tal_id)
											{
												$updated = true;
												//$modelUpdated[$x] = new Tpayrecd;
												//$modelUpdated[$x]->attributes = $rowUpd->attributes;
												//$modelUpdated[$x]->payrec_amt -= $row->payrec_amt;
												
												$rowUpd->inserted = false;
												
												if($rowUpd->payrec_amt != $row->payrec_amt)
												{
													$rowUpd->payrec_amt_diff = $rowUpd->payrec_amt - $row->payrec_amt;
													$rowUpd->updated = true;
												}
												break;
											}
										}
									}
									
									if(!$updated)
									{
										// CANCELLED
										$row->contr_num = $row->doc_ref_num;
										
										if($model->type == 'NEGO' && !$sameBrokerFlg)
										{
											$row->client_cd = $row->sl_acct_cd;
										}
										
										if($success && $row->executeSpRvpvSettled(AConstant::INBOX_STAT_CAN) > 0)$success = true;
										else {
											$success = false;
										}	
									}
								}
							}
							
							foreach($modelLedger as $row)
							{
								if($row->check == 'Y' && $row->system_generated == 'Y')
								{
									if($model->type == 'NEGO' && !$sameBrokerFlg)
									{
										$row->client_cd = $row->sl_acct_cd;
									}
									
									if($row->inserted)
									{
										// INSERTED
										if($success && $row->executeSpRvpvSettled(AConstant::INBOX_STAT_INS) > 0)$success = true;
										else {
											$success = false;
										}
									}
									else if($row->updated)
									{
										// UPDATED
										
										$temp_amt = $row->payrec_amt;
										$row->payrec_amt = abs($row->payrec_amt_diff);
										
										if($success && $row->executeSpRvpvSettled($row->payrec_amt_diff>0?AConstant::INBOX_STAT_INS:AConstant::INBOX_STAT_CAN) > 0)$success = true;
										else {
											$success = false;
										}
										
										$row->payrec_amt = $temp_amt;
									}
								}
							}
						}
						else if($model->type == 'KPEI')
						{
							foreach($oldModelLedger as $row)
							{
								if($row->record_source != 'VCH' && $row->record_source != 'ARAP')
								{
									$updated = false;
									
									foreach($modelLedger as $rowUpd)
									{
										if($rowUpd->check == 'Y' && $rowUpd->system_generated == 'Y')
										{
											if($rowUpd->doc_date == $row->doc_date 
												&& $rowUpd->due_date == $row->due_date
												&& trim($rowUpd->gl_acct_cd) == trim($row->gl_acct_cd)
												&& $rowUpd->sl_acct_cd == $row->sl_acct_cd
												&& $rowUpd->db_cr_flg == $row->db_cr_flg
												&& $rowUpd->remarks == $row->remarks
											)
											{
												$updated = true;
												
												$rowUpd->inserted = false;
											
												break;
											}
										}
									}
									
									if(!$updated)
									{
										// CANCELLED
										$row->contr_num = $row->doc_ref_num;
										if($success && $row->executeSpRvpvSettled(AConstant::INBOX_STAT_CAN) > 0)$success = true;
										else {
											$success = false;
										}	
									}
								}
							}
						}
					}
					else
					{
						// NON REVERSAL	
						
						if($success && $model->executeSp(AConstant::INBOX_STAT_UPD,$model->payrec_num,1) > 0)$success = true;
						else {
							$success = false;
						}
						
						if($reversal_exception)
						{
							// SHOULD ACTUALLY CAUSE REVERSAL
							
							$oldModelLedger = Tpayrecd::model()->findAll("payrec_num = '$model->payrec_num' AND approved_sts = 'A'");
								
							$modelLedgerSeq = $modelDetailLedgerSeq = 1;
							
							if($model->type == 'NEGO')
							{
								foreach($oldModelLedger as $row)
								{
									if($row->record_source != 'VCH' && $row->record_source != 'ARAP')
									{
										$updated = false;
										
										foreach($modelLedger as $rowUpd)
										{
											if($rowUpd->check == 'Y' && $rowUpd->system_generated == 'Y')
											{
												if($rowUpd->doc_ref_num == $row->doc_ref_num && $rowUpd->tal_id == $row->tal_id)
												{
													$updated = true;
													
													$rowUpd->inserted = false;
													$rowUpd->updated = true;
	
													break;
												}
											}
										}
										
										if(!$updated)
										{
											// CANCELLED
											if($row->payrec_date)$row->payrec_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->payrec_date)->format('Y-m-d');
											if($row->doc_date)$row->doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->doc_date)->format('Y-m-d');
											if($row->due_date)$row->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('Y-m-d');
											
											if($success && $row->executeSp(AConstant::INBOX_STAT_CAN,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$modelLedgerSeq++) > 0)$success = true;
											else {
												$success = false;
											}
										}
									}
								}
	
								foreach($modelLedger as $row)
								{
									if($row->check == 'Y' && $row->system_generated == 'Y')
									{
										$row->payrec_num = $model->payrec_num;
										
										if($row->inserted)
										{
											// INSERTED
											$result = DAO::queryRowSql("SELECT COUNT(*) cnt FROM T_PAYRECD WHERE payrec_num = '$row->payrec_num' AND doc_ref_num = '$row->doc_ref_num' AND tal_id = '$row->tal_id' AND approved_sts = 'C'");
											
											$cnt = $result['cnt'];
											
											if($success && $row->executeSp($cnt == 0 ? AConstant::INBOX_STAT_INS : AConstant::INBOX_STAT_UPD,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$modelLedgerSeq++) > 0)$success = true;
											else {
												$success = false;
											}
										}
										else if($row->updated)
										{
											// UPDATED
											if($success && $row->executeSp(AConstant::INBOX_STAT_UPD,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$modelLedgerSeq++) > 0)$success = true;
											else {
												$success = false;
											}
										}
									}
								}
							}
							else if($model->type == 'KPEI')
							{
								foreach($oldModelLedger as $row)
								{
									if($row->record_source != 'VCH' && $row->record_source != 'ARAP')
									{
										$updated = false;
										
										if($row->payrec_date)$row->payrec_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->payrec_date)->format('Y-m-d');
										if($row->doc_date)$row->doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->doc_date)->format('Y-m-d');
										if($row->due_date)$row->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('Y-m-d');
										
										foreach($modelLedger as $rowUpd)
										{
											if($rowUpd->check == 'Y' && $rowUpd->system_generated == 'Y')
											{
												if($rowUpd->doc_date == $row->doc_date 
													&& $rowUpd->due_date == $row->due_date
													&& trim($rowUpd->gl_acct_cd) == trim($row->gl_acct_cd)
													&& $rowUpd->sl_acct_cd == $row->sl_acct_cd
													&& $rowUpd->db_cr_flg == $row->db_cr_flg
													&& $rowUpd->remarks == $row->remarks
												)
												{
													$updated = true;
													
													$rowUpd->inserted = false;
												
													break;
												}
											}
										}
										
										if(!$updated)
										{
											// CANCELLED
											
											if($success && $row->executeSp(AConstant::INBOX_STAT_CAN,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$modelLedgerSeq++) > 0)$success = true;
											else {
												$success = false;
											}
										}
									}
								}
							}
							
							//$oldModelDetailLedger = Taccountledger::model()->findAll("xn_doc_num = '$model->payrec_num' AND approved_sts = 'A'");
							
							if($reretrieve_flg)
							{
								// RE-RETRIEVE
								
								$z = $x = $talIdSkipCnt = $lastTalId = $lastPayrecdTalId = 0;
								$oldCancelFlg = $oldPayrecdCancelFlg = true;
								$oldInsertedPayrecd = Tpayrecd::model()->findAll("payrec_num = '$model->payrec_num' AND doc_ref_num = '$model->payrec_num' AND approved_sts = 'A'");
								
								foreach($modelDetailLedger as $row)
								{
									$row->xn_doc_num = $model->payrec_num;
									$row->doc_ref_num = Sysparam::model()->find("param_id = 'SYSTEM' and param_cd1 = 'DOC_REF'")->dflg1=='Y'?$model->payrec_num:'';
									$row->xn_val = $row->curr_val;
									$row->reversal_jur = 'N';
									$row->manual = 'Y';
									
									if($model->int_adjust=='Y')$row->budget_cd = 'INTADJ';
									
									$approved_sts = 'X';
									
									if($row->bank_flg == 'N')
									{
										$row->tal_id += $talIdSkipCnt;
										
										do
										{
											$result = DAO::queryRowSql("SELECT approved_sts FROM T_ACCOUNT_LEDGER WHERE xn_doc_num = '$model->payrec_num' AND tal_id = $row->tal_id");
											
											if($result)
											{
												$approved_sts = $result['approved_sts'];
												
												if($approved_sts == 'C')
												{
													$talIdSkipCnt++;
													$row->tal_id++;
												}
											}
											else
											{
												$approved_sts = 'X';
											}
											
										}while($approved_sts == 'C');
										
										if($approved_sts == 'A')
										{
											// UPDATE
											
											if($success && $row->executeSp(AConstant::INBOX_STAT_UPD,$row->xn_doc_num,$row->tal_id,$model->update_date,$model->update_seq,$modelDetailLedgerSeq++) > 0)$success = true;
											else {
												$success = false;
											}
										}
										else
										{
											// INSERT
											
											$oldCancelFlg = false;
											
											if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$row->xn_doc_num,$row->tal_id,$model->update_date,$model->update_seq,$modelDetailLedgerSeq++) > 0)$success = true;
											else {
												$success = false;
											}
										}
										
										$lastTalId = $row->tal_id;

										if($row->system_generated == 'N')
										{
											// INSERT / UPDATE USER INSERTED T_PAYRECD
											
											foreach($modelLedger as $payrecdRow)
											{
												if($payrecdRow->system_generated == 'N' /*&& $payrecdRow->tal_id == $row->tal_id*/)
												{
													$payrecdRow->payrec_num = $payrecdRow->gl_ref_num = $payrecdRow->doc_ref_num = $model->payrec_num;
													$payrecdRow->tal_id = $payrecdRow->doc_tal_id = $row->tal_id;
													
													if(isset($oldInsertedPayrecd[$x]))
													{
														// UPDATE
														
														if($success && $payrecdRow->executeSp(AConstant::INBOX_STAT_UPD,$oldInsertedPayrecd[$x]->payrec_num,$oldInsertedPayrecd[$x]->doc_ref_num,$oldInsertedPayrecd[$x]->tal_id,$model->update_date,$model->update_seq,$modelLedgerSeq++) > 0)$success = true;
														else {
															$success = false;
														}
													}
													else 
													{
														// INSERT
														
														$oldPayrecdCancelFlg = false;
														
														if($success && $payrecdRow->executeSp(AConstant::INBOX_STAT_INS,$payrecdRow->payrec_num,$payrecdRow->doc_ref_num,$payrecdRow->tal_id,$model->update_date,$model->update_seq,$modelLedgerSeq++) > 0)$success = true;
														else {
															$success = false;
														}
													}
													
													$lastPayrecdTalId = $payrecdRow->tal_id;
													
													break;
												}
											}

											$x++;
										}
									}
									else 
									{
										// UPDATE BANK RECORD IF EXIST
										
										if($success && $row->executeSp(AConstant::INBOX_STAT_UPD,$row->xn_doc_num,$row->tal_id,$model->update_date,$model->update_seq,$modelDetailLedgerSeq++) > 0)$success = true;
										else {
											$success = false;
										}
									}
									$z++;
								}

								if($oldCancelFlg)
								{
									// CANCEL T_ACCOUNT_LEDGER
									
									$oldModelDetailLedger = Taccountledger::model()->findAll("xn_doc_num = '$model->payrec_num' AND tal_id > '$lastTalId' AND tal_id <> 555 AND approved_sts = 'A'");
									
									foreach($oldModelDetailLedger as $row)
									{
										if($row->doc_date)$row->doc_date = DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_date)->format('Y-m-d');
										if($row->due_date)$row->due_date = DateTime::createFromFormat('Y-m-d H:i:s',$row->due_date)->format('Y-m-d');
										if($row->netting_date)$row->netting_date = DateTime::createFromFormat('Y-m-d H:i:s',$row->netting_date)->format('Y-m-d');
										if($row->arap_due_date)$row->arap_due_date = DateTime::createFromFormat('Y-m-d H:i:s',$row->arap_due_date)->format('Y-m-d');
										
										if($success && $row->executeSp(AConstant::INBOX_STAT_CAN,$row->xn_doc_num,$row->tal_id,$model->update_date,$model->update_seq,$modelDetailLedgerSeq++) > 0)$success = true;
										else {
											$success = false;
										}
									}
								}
								
								if($oldPayrecdCancelFlg)
								{
									// CANCEL T_PAYRECD
									
									$oldModelDetail = Tpayrecd::model()->findAll("payrec_num = '$model->payrec_num' AND doc_ref_num = '$model->payrec_num' AND tal_id > '$lastPayrecdTalId' AND approved_sts = 'A'");
									
									foreach($oldModelDetail as $row)
									{
										if($row->payrec_date)$row->payrec_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->payrec_date)->format('Y-m-d');
										if($row->doc_date)$row->doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->doc_date)->format('Y-m-d');
										if($row->due_date)$row->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('Y-m-d');
										
										if($success && $row->executeSp(AConstant::INBOX_STAT_CAN,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$modelLedgerSeq++) > 0)$success = true;
										else {
											$success = false;
										}
									}
								}
								
								if($model->type == 'NEGO')
								{
									foreach($oldModelLedger as $row)
									{
										if($row->record_source != 'VCH' && $row->record_source != 'ARAP')
										{
											$updated = false;
											
											foreach($modelLedger as $rowUpd)
											{
												if($rowUpd->check == 'Y' && $rowUpd->system_generated == 'Y')
												{
													if($rowUpd->doc_ref_num == $row->doc_ref_num && $rowUpd->tal_id == $row->tal_id)
													{
														$updated = true;													
														$rowUpd->inserted = false;
														
														if($rowUpd->payrec_amt != $row->payrec_amt)
														{
															$rowUpd->payrec_amt_diff = $rowUpd->payrec_amt - $row->payrec_amt;
															$rowUpd->updated = true;
														}
														break;
													}
												}
											}
											
											if(!$updated)
											{
												// CANCELLED
												$row->contr_num = $row->doc_ref_num;
												if($success && $row->executeSpRvpvSettled(AConstant::INBOX_STAT_CAN) > 0)$success = true;
												else {
													$success = false;
												}	
											}
										}
									}
									
									foreach($modelLedger as $row)
									{
										if($row->check == 'Y' && $row->system_generated == 'Y')
										{
											if($row->inserted)
											{
												// INSERTED
												if($success && $row->executeSpRvpvSettled(AConstant::INBOX_STAT_INS) > 0)$success = true;
												else {
													$success = false;
												}
											}
											else if($row->updated)
											{
												// UPDATED
												
												$temp_amt = $row->payrec_amt;
												$row->payrec_amt = abs($row->payrec_amt_diff);
												
												if($success && $row->executeSpRvpvSettled($row->payrec_amt_diff>0?AConstant::INBOX_STAT_INS:AConstant::INBOX_STAT_CAN) > 0)$success = true;
												else {
													$success = false;
												}
												
												$row->payrec_amt = $temp_amt;
											}
										}
									}
								}
								else if($model->type == 'KPEI')
								{
									foreach($oldModelLedger as $row)
									{
										if($row->record_source != 'VCH' && $row->record_source != 'ARAP')
										{
											$updated = false;
											
											foreach($modelLedger as $rowUpd)
											{
												if($rowUpd->check == 'Y' && $rowUpd->system_generated == 'Y')
												{
													if($rowUpd->doc_date == $row->doc_date 
														&& $rowUpd->due_date == $row->due_date
														&& trim($rowUpd->gl_acct_cd) == trim($row->gl_acct_cd)
														&& $rowUpd->sl_acct_cd == $row->sl_acct_cd
														&& $rowUpd->db_cr_flg == $row->db_cr_flg
														&& $rowUpd->remarks == $row->remarks
													)
													{
														$updated = true;
														
														$rowUpd->inserted = false;
													
														break;
													}
												}
											}
											
											if(!$updated)
											{
												// CANCELLED
												$row->contr_num = $row->doc_ref_num;
												if($success && $row->executeSpRvpvSettled(AConstant::INBOX_STAT_CAN) > 0)$success = true;
												else {
													$success = false;
												}	
											}
										}
									}
								}
							}
							else 
							{
								// NO RE-RETRIEVE
								
								$x = 0;
								
								foreach($modelDetailLedger as $row)
								{
									if($model->int_adjust=='Y')$row->budget_cd = 'INTADJ';
									
									if($row->save_flg == 'Y')
									{
										$row->xn_val = $row->curr_val;
																	
										if($row->cancel_flg == 'Y')
										{												
											//CANCEL	
											$payrecd = Tpayrecd::model()->find("payrec_num = '$model->payrec_num' AND doc_ref_num = '$model->payrec_num' AND tal_id = $row->tal_id");
											
											if($payrecd->payrec_date)$payrecd->payrec_date = DateTime::createFromFormat('Y-m-d H:i:s',$payrecd->payrec_date)->format('Y-m-d');
											if($payrecd->doc_date)$payrecd->doc_date = DateTime::createFromFormat('Y-m-d H:i:s',$payrecd->doc_date)->format('Y-m-d');
											if($payrecd->due_date)$payrecd->due_date = DateTime::createFromFormat('Y-m-d H:i:s',$payrecd->due_date)->format('Y-m-d');
											
											$modelDetail[] = $payrecd;
											
											if($success && $payrecd->executeSp(AConstant::INBOX_STAT_CAN,$payrecd->payrec_num,$payrecd->doc_ref_num,$payrecd->tal_id,$model->update_date,$model->update_seq,$modelLedgerSeq++) > 0)$success = true;
											else {
												$success = false;
											}
								
											if($success && $row->executeSp(AConstant::INBOX_STAT_CAN,$row->xn_doc_num,$row->tal_id,$model->update_date,$model->update_seq,$modelDetailLedgerSeq++) > 0)$success = true;
											else {
												$success = false;
											}
										}
										else if($row->rowid)
										{
											//UPDATE
											if($row->system_generated == 'N')
											{
												//$payrecd = Tpayrecd::model()->find("payrec_num = '$model->payrec_num' AND doc_ref_num = '$model->payrec_num' AND tal_id = $row->tal_id");
												
												foreach($modelLedger as $payrecdRow)
												{
													if($payrecdRow->system_generated == 'N' && $payrecdRow->tal_id == $row->tal_id)
													{
														$payrecdRow->payrec_num = $payrecdRow->gl_ref_num = $payrecdRow->doc_ref_num = $model->payrec_num;
																												
														if($success && $payrecdRow->executeSp(AConstant::INBOX_STAT_UPD,$payrecdRow->payrec_num,$payrecdRow->doc_ref_num,$payrecdRow->tal_id,$model->update_date,$model->update_seq,$modelLedgerSeq++) > 0)$success = true;
														else {
															$success = false;
														}
														break;
													}
												}
											}
											
											if($success && $row->executeSp(AConstant::INBOX_STAT_UPD,$row->xn_doc_num,$row->tal_id,$model->update_date,$model->update_seq,$modelDetailLedgerSeq++) > 0)$success = true;
											else {
												$success = false;
											}
										}			
										else 
										{
											//INSERT
											
											foreach($modelLedger as $payrecdRow)
											{
												if($payrecdRow->system_generated == 'N' && $payrecdRow->tal_id == $row->tal_id)
												{
													$payrecdRow->payrec_num = $payrecdRow->gl_ref_num = $payrecdRow->doc_ref_num = $model->payrec_num;
													
													if($success && $payrecdRow->executeSp(AConstant::INBOX_STAT_INS,$payrecdRow->payrec_num,$payrecdRow->doc_ref_num,$payrecdRow->tal_id,$model->update_date,$model->update_seq,$modelLedgerSeq++) > 0)$success = true;
													else {
														$success = false;
													}
													break;
												}
											}

											$row->xn_doc_num = $model->payrec_num;
											$row->doc_ref_num = Sysparam::model()->find("param_id = 'SYSTEM' and param_cd1 = 'DOC_REF'")->dflg1=='Y'?$model->payrec_num:'';
								
											$row->reversal_jur = 'N';
											$row->manual = 'Y';
								
											if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$row->xn_doc_num,$row->tal_id,$model->update_date,$model->update_seq,$modelDetailLedgerSeq++) > 0)$success = true;
											else {
												$success = false;
											}
										}
									}
									else
									{
										// UPDATE FOLDER_CD		
										if($row->system_generated == 'N')
										{
											//$payrecd = Tpayrecd::model()->find("payrec_num = '$model->payrec_num' AND doc_ref_num = '$model->payrec_num' AND tal_id = $row->tal_id");
											
											foreach($modelLedger as $payrecdRow)
											{
												if($payrecdRow->system_generated == 'N' && $payrecdRow->tal_id == $row->tal_id)
												{
													$payrecdRow->payrec_num = $payrecdRow->gl_ref_num = $payrecdRow->doc_ref_num = $model->payrec_num;
																											
													if($success && $payrecdRow->executeSp(AConstant::INBOX_STAT_UPD,$payrecdRow->payrec_num,$payrecdRow->doc_ref_num,$payrecdRow->tal_id,$model->update_date,$model->update_seq,$modelLedgerSeq++) > 0)$success = true;
													else {
														$success = false;
													}
													break;
												}
											}
										}
																		
										if($success && $row->executeSp(AConstant::INBOX_STAT_UPD,$row->xn_doc_num,$row->tal_id,$model->update_date,$model->update_seq,$modelDetailLedgerSeq++) > 0)$success = true;
										else {
											$success = false;
										}
									}
									
									$x++;
								}
							}
						}
						else 
						{
							// PURE NON REVERSAL
						
							$modelDetailLedgerNonRev = Taccountledger::model()->findAll(array('condition'=>"xn_doc_num = '$id' AND approved_sts = 'A'",'order'=>"DECODE(record_source,'ARAP','VCH',record_source), tal_id"));
							
							$x = 1;
							
							$detailSeq = $temp;
							
							foreach($modelDetailLedgerNonRev as $row)
							{
								// UPDATE FOLDER_CD, REMARKS
								$row->folder_cd = $model->folder_cd;
								$row->ledger_nar = $modelDetailLedger[$x-1]->ledger_nar;
								
								if($row->doc_date)$row->doc_date = DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_date)->format('Y-m-d');
								if($row->due_date)$row->due_date = DateTime::createFromFormat('Y-m-d H:i:s',$row->due_date)->format('Y-m-d');
								if($row->netting_date)$row->netting_date = DateTime::createFromFormat('Y-m-d H:i:s',$row->netting_date)->format('Y-m-d');
								if($row->arap_due_date)$row->arap_due_date = DateTime::createFromFormat('Y-m-d H:i:s',$row->arap_due_date)->format('Y-m-d');
								
								$row->upd_dt = date('Y-m-d H:i:s');
								$row->upd_by = Yii::app()->user->id;
								
								if($success && $row->executeSp(AConstant::INBOX_STAT_UPD,$row->xn_doc_num,$row->tal_id,$model->update_date,$model->update_seq,$x) > 0)$success = true;
								else {
									$success = false;
								}
								
								if($modelDetailLedger[$x-1]->system_generated == 'N')
								{
									// UPDATE T_PAYRECD.REMARKS
									
									$modelLedger[$detailSeq]->payrec_num = $modelLedger[$detailSeq]->doc_ref_num = $modelLedger[$detailSeq]->gl_ref_num = $model->payrec_num;
									
									if($success && $modelLedger[$detailSeq]->executeSp(AConstant::INBOX_STAT_UPD,$modelLedger[$detailSeq]->payrec_num,$modelLedger[$detailSeq]->doc_ref_num,$modelLedger[$detailSeq]->tal_id,$model->update_date,$model->update_seq,$x) > 0)$success = true;
									else {
										$success = false;
									}
									
									$detailSeq++;
								}
								
								$x++;
							}
						}
						
						if($model->folder_cd)
						{
							$modelFolder->fld_mon = DateTime::createFromFormat('Y-m-d',$model->payrec_date)->format('my');
							$modelFolder->folder_cd = $model->folder_cd;
							$modelFolder->doc_date = $model->payrec_date;
							$modelFolder->upd_dt = $model->upd_dt;
							$modelFolder->upd_by = $model->upd_by;
							
							if($success && $modelFolder->executeSp(AConstant::INBOX_STAT_UPD,$model->payrec_num,$model->update_date,$model->update_seq,1) > 0)$success = true;
							else {
								$success = false;
							}
						}
						
						$recordSeq = 1;
						$cheque = DAO::queryRowSql("SELECT NVL(MAX(chq_seq),0) max_seq FROM T_CHEQ WHERE RVPV_NUMBER = '$model->payrec_num'");
						$currSeq = $cheque['max_seq'] + 1;
				
						for($x=0; $success && $x<$cheqLedgerCount; $x++)
						{
							$modelCheqLedger[$x]->rvpv_number = $model->payrec_num;
							
							if($modelCheqLedger[$x]->save_flg == 'Y')
							{
								if($modelCheqLedger[$x]->cancel_flg == 'Y')
								{
									//CANCEL
									if($success && $modelCheqLedger[$x]->executeSp(AConstant::INBOX_STAT_CAN,$modelCheqLedger[$x]->rvpv_number,$modelCheqLedger[$x]->chq_seq,$modelCheqLedger[$x]->chq_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}
								else if($modelCheqLedger[$x]->rowid)
								{
									//UPDATE
									if($success && $modelCheqLedger[$x]->executeSp(AConstant::INBOX_STAT_UPD,$modelCheqLedger[$x]->rvpv_number,$modelCheqLedger[$x]->chq_seq,$modelCheqLedger[$x]->chq_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}			
								else 
								{
									//INSERT
									$modelCheqLedger[$x]->seqno = $modelCheqLedger[$x]->chq_seq = $currSeq++;
									
									if($success && $modelCheqLedger[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelCheqLedger[$x]->rvpv_number,$modelCheqLedger[$x]->chq_seq,$modelCheqLedger[$x]->chq_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}
								$recordSeq++;
							}
						}
					}
					
					if($success)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Updated');
						$obj->redirect(array('index'));
					}
					else {
						$transaction->rollback();
					}
				}

				$currCount = count($modelLedger);
				
				for(;$temp < $currCount;$temp++)
				{
					$tempModel[] = clone($modelLedger[$temp]);// To contain the error message
					
					unset($modelLedger[$temp]);
				}
			}		
		}
		else
		{
			$modelLedger = Tpayrecd::model()->findAll("payrec_num = '$model->payrec_num' AND approved_sts = 'A'");
			$modelDetailLedger = Taccountledger::model()->findAll(array('select'=>'t.*, rowid','condition'=>"xn_doc_num = '$model->payrec_num' AND approved_sts = 'A'",'order'=>"DECODE(record_source,'ARAP','VCH',record_source), tal_id"));
			$modelCheqLedger = Tcheq::model()->findAll(array('select'=>'t.*, rowid','condition'=>"rvpv_number = '$model->payrec_num' AND approved_stat = 'A'"));

			
			foreach($modelLedger as $key=>$row)
			{
				if($row->record_source != 'VCH' && $row->record_source != 'ARAP')
				{
					$row->trx_date = $row->doc_date;
					$row->buy_sell_ind = $row->db_cr_flg=='D'?'C':'D';
					$row->check = 'Y';
					
					if($row->buy_sell_ind == 'D')
					{
						$row->buy_sett_amt = 0;
						$row->sell_sett_amt = $row->payrec_amt;
						$row->protect_cd = 1;
					}
					else
					{
						$row->buy_sett_amt = $row->payrec_amt;
						$row->sell_sett_amt = 0;
						$row->protect_cd = 2;
					}
					
					if($model->type != 'NEGO')
					{
						//KPEI, GSJK, GSSL
						
						$row->outs_amt = $row->payrec_amt;	
						$row->old_outs_amt = 0;
					}
					else
					{
						$row->contr_num = $row->doc_ref_num;
						
						$settledLedger= Taccountledger::model()->find("xn_doc_num = '$row->doc_ref_num' AND tal_id = $row->tal_id");
						
						if(!$settledLedger->sett_for_curr)$settledLedger->sett_for_curr = 0;
						
						$row->outs_amt = $settledLedger->curr_val - $settledLedger->sett_for_curr - $settledLedger->sett_val + $row->payrec_amt;	
						$row->old_outs_amt	= $settledLedger->curr_val - $settledLedger->sett_for_curr - $settledLedger->sett_val;			
					}
				}
				else 
				{
					unset($modelLedger[$key]);	
				}
			}
			
			foreach($modelDetailLedger as $row)
			{
				if($row->sett_val > 0 || $row->sett_for_curr > 0)
				{
					$settled = true;
					break;
				}
				$row->gl_acct_cd = trim($row->gl_acct_cd);
				
				if($row->record_source == 'PV' || $row->record_source == 'RV')
				{
					$row->system_generated = 'Y';
					
					if($row->tal_id == 555)$row->bank_flg = 'Y';
					else 
					{
						$row->bank_flg = 'N';
					}
				}
				else 
				{
					$row->bank_flg = 'N';
					$row->system_generated = 'N';
				}
			}
		}
		
		if($settled)
		{
			Yii::app()->user->setFlash('error', 'This voucher has already been settled');
			$obj->redirect(array('index'));
		}
		else {
			$obj->render('/tpayrechkpei/update',array(
				'model'=>$model,
				'modelLedger'=>$modelLedger,
				'modelDetailLedger'=>$modelDetailLedger,
				'modelFolder'=>$modelFolder,
				'modelCheqLedger'=>$modelCheqLedger,
				'modelJvchh'=>$modelJvchh,
				'tempModel'=>$tempModel,
				'oldModel'=>$oldModel,
				'oldModelDetail'=>$oldModelDetail,
				'oldModelFolder'=>$oldModelFolder,
				'oldModelLedger'=>$oldModelLedger,
				'reverseModelLedger'=>$reverseModelLedger,
				'reverseModelFolder'=>$reverseModelFolder,
				'retrieved'=>$retrieved,
				'reretrieve_flg'=>$reretrieve_flg,
				'cancel_reason'=>$cancel_reason,
				'cancel_reason_cheq'=>$cancel_reason_cheq,
			));
		}		
	}

	public function actionUpdateRemark($id, $obj = null)
	{
		if($obj === null)$obj = $this;
		
		$model = $this->loadModel($id);
		$modelDetail = array();
		$modelCheq = array();
		
		if(isset($_POST['Tpayrech']))
		{
			$model->remarks = $_POST['Tpayrech']['remarks'];
			$model->upd_by = Yii::app()->user->id;
			$model->upd_dt = date('Y-m-d H:i:s');
			
			$model->save(false);
			
			$x = 0;
			
			foreach($_POST['Taccountledger'] as $row)
			{
				$rowid = $row['rowid'];
				
				$modelDetail[$x] = Taccountledger::model()->find("rowid = '$rowid'");
				$modelDetail[$x]->ledger_nar = $row['ledger_nar'];
				$modelDetail[$x]->upd_by = Yii::app()->user->id;
				$modelDetail[$x]->upd_dt = date('Y-m-d H:i:s');
				
				$modelDetail[$x]->save(false);
				
				$payrecd = Tpayrecd::model()->find("payrec_num = '$id' AND doc_ref_num = '$id' AND tal_id = ".$modelDetail[$x]->tal_id);
				
				if($payrecd)
				{
					$payrecd->remarks = $modelDetail[$x]->ledger_nar;
					$payrecd->upd_by = Yii::app()->user->id;
					$payrecd->upd_dt = date('Y-m-d H:i:s');
					
					$payrecd->save(false);
				}
				
				$x++;
			}
			
			foreach($_POST['Tcheq'] as $row)
			{
				$rowid = $row['rowid'];
				$date = date('Y-m-d H:i:s');
				
				//$modelCheq[$x] = Tcheq::model()->find("rowid = '$rowid'");
				//$modelCheq[$x]->descrip = $row['descrip'];
				//$modelCheq[$x]->upd_by = Yii::app()->user->id;
				//$modelCheq[$x]->upd_dt = date('Y-m-d H:i:s');
				
				//$modelCheq[$x]->save(false); This method can't be used because the table T_CHEQ doesn't have a primary key
				
				$sql = "UPDATE T_CHEQ SET descrip = '".$row['descrip']."', upd_by = '".Yii::app()->user->id."', upd_dt = TO_DATE('$date','YYYY-MM-DD HH24:MI:SS') ";
				$sql .= "WHERE rowid = '$rowid'";
				
				DAO::executeSql($sql);
			}
			
			Yii::app()->user->setFlash('success', 'Data Successfully Updated');
			$obj->redirect(array('index'));
		}
		else 
		{
			$modelDetail = Taccountledger::model()->findAll(array('select'=>'t.*, rowid',"condition"=>"xn_doc_num = '$id' AND approved_sts = 'A'",'order'=>"DECODE(record_source,'ARAP','VCH',record_source), tal_id"));
			$modelCheq = Tcheq::model()->findAll(array('select'=>'t.*, rowid',"condition"=>"rvpv_number = '$id' AND approved_stat = 'A'"));
			
			if(!$model->acct_type)
			{
				if($model->client_cd = 'KPEI')
				{
					$model->acct_type = 'KPEI';
				}
				else if($model->client_cd = 'GS1000')
				{
					$result = DAO::queryRowSql("SELECT record_source FROM T_PAYRECD WHERE payrec_num = '$model->payrec_num' AND record_source NOT IN ('VCH','ARAP') AND rownum = 1");
					$model->acct_type = $result['record_source'];
				}
				else
				{
					$model->acct_type = 'NEGO';
				}
			}
	
			$model->type = $model->acct_type;
		}
		
		$obj->render('/tpayrechkpei/update_remark',array(
			'model'=>$model,
			'modelDetail'=>$modelDetail,
			'modelCheq'=>$modelCheq
		));
	}

	public function actionAjxPopDelete($id, $obj = null, $originalReversalDate = false)
	{
		if($obj === null)$obj = $this;
		
		$obj->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Tmanyheader();
		$model->scenario = 'cancel';
		
		$modelHeader = new Tpayrech;
		$modelDetail = new Tpayrecd;
		$reverseModelJournal = array();
		$modelFolder = new Tfolder;
		$reverseModelFolder = new Tfolder;
		$modelCheq = array();
		$modelJvchh = new Tjvchh;
		
		$settled = FALSE;
		$reversal = TRUE;
		
		$modelDetailLedger = Taccountledger::model()->findAll(array('select'=>'t.*, rowid','condition'=>"xn_doc_num = '$id' AND approved_sts = 'A'",'order'=>"DECODE(record_source,'ARAP','VCH',record_source), tal_id"));	
		
		foreach($modelDetailLedger as $row)
		{
			if($row->sett_val > 0 || $row->sett_for_curr > 0)
			{
				$settled = true;
				break;
			}
		}
		
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];	
					
			if(!$settled && $model->validate()){
				
				$success = FALSE;
				
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction(); 
				
				$modelHeader = $this->loadModel($id);
				$this->checkCancelled($modelHeader, Yii::app()->request->requestUri);
				
				$modelHeader->cancel_reason = $model->cancel_reason;
				$modelHeader->validate();
				if($modelHeader->executeSpHeader(AConstant::INBOX_STAT_CAN,$this->menuName) > 0)$success = TRUE;
				
				// CANCEL T_PAYRECH
				if($modelHeader->payrec_date)$modelHeader->payrec_date = DateTime::createFromFormat('Y-m-d G:i:s',$modelHeader->payrec_date)->format('Y-m-d');
				if($success && $modelHeader->executeSp(AConstant::INBOX_STAT_CAN,$modelHeader->payrec_num,1) > 0)$success = true;
				else {
					$success = false;
				}
				
				$modelDetail = Tpayrecd::model()->findAll("payrec_num = '$modelHeader->payrec_num' AND approved_sts = 'A'");
				
				$x = 1;
				// CANCEL T_PAYRECD
				foreach($modelDetail as $row)
				{
					if($row->payrec_date)$row->payrec_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->payrec_date)->format('Y-m-d');
					if($row->doc_date)$row->doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->doc_date)->format('Y-m-d');
					if($row->due_date)$row->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('Y-m-d');
					
					if($success && $row->executeSp(AConstant::INBOX_STAT_CAN,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$modelHeader->update_date,$modelHeader->update_seq,$x++) > 0)$success = true;
					else {
						$success = false;
					}
				}
				
				/*-------------BEGIN CONDITIONAL REVERSAL TOGGLE----------------*/
				
				// Uncomment the following code to apply conditional reversal
				
				/*if(str_replace('-','',$modelHeader->payrec_date) >= date('Ymd'))
				{
					$reversal = FALSE;					
				}*/
				
				/*-------------END CONDITIONAL REVERSAL TOGGLE----------------*/
				
				if($reversal)
				{
					$reverseModelJournal = Taccountledger::model()->findAll("xn_doc_num = '$modelHeader->payrec_num' AND approved_sts = 'A'");
					
					$reversalDate = $modelHeader->payrec_date;
					
					if(!$originalReversalDate)
					{
						$oldJournalDate = DateTime::createFromFormat('Y-m-d',$modelHeader->payrec_date)->format('Ymd');
					
						if($oldJournalDate < date('Ymd'))$reversalDate = date('Y-m-d');

					}
					
					$result = DAO::queryRowSql("SELECT GET_DOCNUM_GL(TO_DATE('$reversalDate','YYYY-MM-DD HH24:MI:SS'),'GL') AS REVERSE_DOC_NUM FROM dual");
					$reverseDocNum = $result['reverse_doc_num'];
					
					$result = DAO::queryRowSql("SELECT F_GET_FOLDER_NUM(TO_DATE('$reversalDate','YYYY-MM-DD HH24:MI:SS'),'RJ-') AS REVERSE_FOLDER_CD FROM dual");
					$reverseFolderCd = $result['reverse_folder_cd'];
					
					// INSERT REVERSE T_ACCOUNT_LEDGER
					$x = 1;
					foreach($reverseModelJournal as $row)
					{
						$row->xn_doc_num = $reverseDocNum;
						$row->db_cr_flg = $row->db_cr_flg=='D'?'C':'D';
						$row->record_source = 'RE';
						$row->sett_val = $row->curr_val;
						$row->folder_cd = $modelHeader->folder_cd?$reverseFolderCd:'';
						$row->cre_dt = date('Y-m-d H:i:s');
						
						/*if($row->doc_date)$row->doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->doc_date)->format('Y-m-d');
						if($row->due_date)$row->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('Y-m-d');
						if($row->netting_date)$row->netting_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->netting_date)->format('Y-m-d');
						if($row->arap_due_date)$row->arap_due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->arap_due_date)->format('Y-m-d');*/
						
						$row->doc_date = $row->due_date = $row->netting_date = $row->arap_due_date = $reversalDate;
												
						if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$row->xn_doc_num,$row->tal_id,$modelHeader->update_date,$modelHeader->update_seq,$x++) > 0)$success = true;
						else {
							$success = false;
						}
					}
					
					// INSERT T_JVCHH 
								
					$modelJvchh = new Tjvchh;
					$modelJvchh->jvch_num = $reverseDocNum;
					$modelJvchh->jvch_type = 'RE';
					$modelJvchh->jvch_date = $reversalDate;
					//$modelJvchh->curr_cd = $modelHeader->curr_cd;
					$modelJvchh->curr_cd = 'IDR';
					$modelJvchh->curr_amt = $modelHeader->curr_amt;
					$modelJvchh->remarks = $modelHeader->remarks;
					$modelJvchh->folder_cd = $modelHeader->folder_cd?$reverseFolderCd:'';
					$modelJvchh->user_id = Yii::app()->user->id;
					$modelJvchh->cre_dt = date('Y-m-d H:i:s');
					$modelJvchh->update_date = $modelHeader->update_date;
					$modelJvchh->update_seq = $modelHeader->update_seq;
					
					if($success && $modelJvchh->executeSp(AConstant::INBOX_STAT_INS, $modelJvchh->jvch_num, 1) > 0 )$success = true;
					else {
						$success = false;
					}
				}
				else 
				{
					// NON REVERSAL
					
					$x = 1;
					foreach($modelDetailLedger as $row)
					{
						if($row->doc_date)$row->doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->doc_date)->format('Y-m-d');
						if($row->due_date)$row->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('Y-m-d');
						if($row->netting_date)$row->netting_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->netting_date)->format('Y-m-d');
						if($row->arap_due_date)$row->arap_due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->arap_due_date)->format('Y-m-d');
						
						if($success && $row->executeSp(AConstant::INBOX_STAT_CAN,$row->xn_doc_num,$row->tal_id,$modelHeader->update_date,$modelHeader->update_seq,$x++) > 0)$success = true;
						else {
							$success = false;
						}
					}
				}
				
				// CANCEL T_FOLDER
							
				$modelFolder = Tfolder::model()->find("doc_num = '$modelHeader->payrec_num'");
				
				if($modelFolder)
				{
					if($modelFolder->doc_date)$modelFolder->doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$modelFolder->doc_date)->format('Y-m-d');
					
					if($success && $modelFolder->executeSp(AConstant::INBOX_STAT_CAN,$modelFolder->doc_num,$modelHeader->update_date,$modelHeader->update_seq,1) > 0)$success = true;
					else {
						$success = false;
					}
				
					if($reversal)
					{
						// INSERT REVERSE T_FOLDER
					
						$reverseModelFolder = new Tfolder;
						$reverseModelFolder->fld_mon = DateTime::createFromFormat('Y-m-d',$reversalDate)->format('my');
						$reverseModelFolder->folder_cd = $reverseFolderCd;
						$reverseModelFolder->doc_date = $reversalDate;
						$reverseModelFolder->doc_num = $reverseDocNum;
						$reverseModelFolder->cre_dt = date('Y-m-d H:i:s');
						$reverseModelFolder->user_id = $modelHeader->user_id;
						
						if($success && $reverseModelFolder->executeSp(AConstant::INBOX_STAT_INS,$reverseModelFolder->doc_num,$modelHeader->update_date,$modelHeader->update_seq,2) > 0)$success = true;
						else {
							$success = false;
						}	
					}
				}

				$modelCheq = Tcheq::model()->findAll("rvpv_number = '$modelHeader->payrec_num' AND approved_stat = 'A'");

				// CANCEL T_CHEQ
				
				foreach($modelCheq as $row)
				{
					if($row->chq_dt)$row->chq_dt = DateTime::createFromFormat('Y-m-d G:i:s',$row->chq_dt)->format('Y-m-d');	
					$row->chq_stat = 'C';	
						
					if($success && $row->executeSp(AConstant::INBOX_STAT_CAN,$row->rvpv_number,$row->chq_seq,$row->chq_num,$modelHeader->update_date,$modelHeader->update_seq,$x++) > 0)$success = true;
					else {
						$success = false;
					}
				}
				
				if($modelHeader->client_cd != 'GS1000')
				{
					foreach($modelDetail as $row)
					{
						if($row->record_source != 'VCH' && $row->record_source != 'ARAP')
						{
							$row->contr_num = $row->doc_ref_num;
							
							if($modelHeader->acct_type == 'NEGO' && $row->client_cd == '')
							{
								$row->client_cd = $row->sl_acct_cd;
							}
							
							if($success && $row->executeSpRvpvSettled(AConstant::INBOX_STAT_CAN) > 0)$success = true;
							else {
								$success = false;
							}
						}	
					}
				}
				
				if($success)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Data Successfully Cancelled');
					$is_successsave = true;	
				}
				else {
					$transaction->rollback();
				}	
			}
		}

		if($settled)
		{
			Yii::app()->user->setFlash('error', 'This voucher has already been settled');
			$is_successsave = true;
		}

		$obj->render('/tpayrechkpei/_popcancel',array(
			'model'=>$model,
			'modelHeader'=>$modelHeader,
			'modelDetail'=>$modelDetail,
			'reverseModelJournal'=>$reverseModelJournal,
			'modelFolder'=>$modelFolder,
			'reverseModelFolder'=>$reverseModelFolder ,
			'modelCheq'=>$modelCheq,
			'modelJvchh'=>$modelJvchh,
			'is_successsave'=>$is_successsave		
		));

	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex($obj = null)
	{
		if($obj === null)$obj = $this;
		
		$model=new Tpayrech('search');
		$model->unsetAttributes();  // clear any default values
		
		//$model->reversal_jur = 'N';
		$model->approved_sts = 'A';
		$model->type = 'KPEI';

		if(isset($_GET['Tpayrech']))
			$model->attributes=$_GET['Tpayrech'];

		$obj->render('/tpayrechkpei/index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Tpayrech::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
