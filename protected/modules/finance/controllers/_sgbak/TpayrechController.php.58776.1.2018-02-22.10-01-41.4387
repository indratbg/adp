<?php

class TpayrechController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	public $menuName = 'VOUCHER ENTRY';

	public function actionAjxGetClientDetail()
	{
		$model = array();
		
		if(isset($_POST['client']))
		{
			$client = $_POST['client'];
			
			$sql = "SELECT client_name, client_type_1||client_type_2||client_type_3 AS client_type, trim(branch_code) AS branch_code,
					b.cl_desc, DECODE(olt,'Y','OLT','') olt, DECODE(recov_charge_flg,'Y','2490','1422') recov_charge_flg,
					c.bank_cd, c.bank_acct_fmt, DECODE(c.acct_stat,'A','ACTIVE','INACTIVE') active,
					d.cif_name, e.bank_name client_bank, a.bank_acct_num, f.acct_name
					FROM MST_CLIENT a 
					JOIN LST_TYPE3 b ON a.client_type_3 = b.cl_type3
					LEFT JOIN MST_CLIENT_FLACCT c ON a.client_cd = c.client_cd AND c.acct_stat IN('A','I')
					JOIN MST_CIF d ON a.cifs = d.cifs
					LEFT JOIN MST_IP_BANK e ON a.bank_cd = e.bank_cd
					LEFT JOIN MST_CLIENT_BANK f ON a.cifs = f.cifs AND a.bank_acct_num = f.bank_acct_num
					WHERE a.client_cd = '$client'";
			
			$model = DAO::queryRowSql($sql);
		}
		
		echo json_encode($model);
	}
	
	public function actionAjxGetBankAccount()
	{
		$model = array();
		
		if(isset($_POST['glAcctCd']))
		{
			$glAcctCd = $_POST['glAcctCd'];
			$branchCode = $_POST['branchCode'];
			
			$sql = "SELECT trim(sl_a) AS sl_a, acct_name, TRIM(b.BRCH_CD) brch_cd, 
			 		DECODE(trim(b.bank_acct_type),'R','Receipt', 'P','Payment','RP', 'Recv/Pay') RP
			 		FROM mst_gl_account g, mst_bank_acct b
			 		WHERE trim(g.gl_a) = trim('$glAcctCd')
					AND g.sl_a <> '000000'
					AND (g.acct_type = 'BANK' OR g.acct_type = 'KAS')
--					AND (TRIM(b.brch_cd) LIKE '$branchCode' OR ('$branchCode' = '%' AND b.brch_cd IS NULL))
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
	
	public function actionAjxFindBankCd()
	{
		$model = array();
		
		if(isset($_POST['clientCd']))
		{
			$clientCd = $_POST['clientCd'];
			$bankAcctNum = $_POST['bankAcctNum'];
			
			$sql = "SELECT bank_cd, bank_branch, acct_name
					FROM MST_CLIENT_BANK
			 		WHERE cifs = 
			 		(
			 			SELECT cifs FROM MST_CLIENT WHERE client_cd = '$clientCd'
					)
					AND bank_acct_num = '$bankAcctNum'";
			
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
			$brch_cd = $_POST['brch_cd'];
			$rdi_bank = $_POST['rdi_bank'];
			$to_bank = $_POST['to_bank'];
			$glAcctCd = $_POST['glAcctCd'];
			$slAcctCd = $_POST['slAcctCd'];
			$olt = $_POST['olt'];
			$rdi = $_POST['rdi'];
			$clientCd = $_POST['clientCd'];
			
			if($rdi == 'Y')
			{
				$from_bank = $_POST['rdi_bank'];
				$sql = "SELECT IP_BANK_CD FROM MST_FUND_BANK WHERE BANK_CD = '$from_bank'";
				
				$result = DAO::queryRowSql($sql);
				
				if($result)$from_bank = $result['ip_bank_cd'];
			}
			else
			{
				$result = Bankacct::model()->find("TRIM(gl_acct_cd) = '$glAcctCd' AND sl_acct_cd = '$slAcctCd'")->bank_cd;
				$from_bank = Bankmaster::model()->find("bank_cd = '$result'")->short_bank_name;
			}

			
			$sql = "SELECT F_TRANSFER_FEE('$amt','$from_bank','$to_bank','$brch_cd','$olt','$rdi','$clientCd') transfer_fee FROM dual";
			
			$model = DAO::queryRowSql($sql);
		}
		
		echo json_encode($model);
	}
	
	public function actionAjxGetRdiAcctName()
	{
		$model = array();
		
		if(isset($_POST['glAcctCd']))
		{
			$glAcctCd = $_POST['glAcctCd'];
			$slAcctCd = $_POST['slAcctCd'];
			
			$sql = "SELECT acct_name
					FROM MST_GL_ACCOUNT
			 		WHERE TRIM(gl_a) = '$glAcctCd'
					AND sl_a = '$slAcctCd'";
			
			$model = DAO::queryRowSql($sql);
		}
		
		echo json_encode($model);
	}
	
	public function actionAjxCheckCash()
	{
		$result = array();
		
		$valid = true;
		$ratio = '';
		$message = '';
		$block = false;
		
		if(isset($_POST['client']))
		{
			$client = $_POST['client'];
			$amt = $_POST['amt'];	
			
			$valid = $this->checkCash($client, $amt, $ratio, $message, $block);
		}
		
		$result['valid'] = $valid;
		$result['ratio'] = $ratio;
		$result['message'] = $message;
		$result['block'] = $block;
		
		echo json_encode($result);
	}

	public function actionAjxValidateBackDated()
	{
		$resp = '';
		echo json_decode($resp);
	}
	
	public function actionGetClient()
	{
		$i=0;
      	$src=array();
      	$term = strtoupper($_POST['term']);
      	
      	$qSearch = DAO::queryAllSql("
					SELECT client_cd, client_name, TRIM(branch_code) branch_code
					FROM MST_CLIENT
					WHERE client_cd LIKE '".$term."%'
					AND susp_stat = 'N'
	      			AND rownum <= 15
	      			ORDER BY client_cd
      			");
      
	    foreach($qSearch as $search)
	    {
	      	$src[$i++] = array('label'=>$search['client_cd'].' - '.$search['branch_code'].' - '.$search['client_name']
	      			, 'labelhtml'=>$search['client_cd'].' - '.$search['branch_code'].' - '.$search['client_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['client_cd']);
	    }
      
      	echo CJSON::encode($src);
      	Yii::app()->end();
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
	
	public function actionGetBankAcctNum()
	{
		$i=0;
      	$src=array();
      	$term = strtoupper($_POST['term']);
      	$clientCd = $_POST['client_cd'];
      	
      	$qSearch = DAO::queryAllSql("
					SELECT bank_acct_num FROM MST_CLIENT_BANK 
					WHERE cifs = 
					(
						SELECT cifs FROM MST_CLIENT WHERE client_cd = '$clientCd'
					)
					AND bank_acct_num LIKE '".$term."%'
					AND approved_stat = 'A'
	      			AND rownum <= 15
	      			ORDER BY bank_acct_num
      			");
      
	    foreach($qSearch as $search)
	    {
	      	$src[$i++] = array('label'=>$search['bank_acct_num']
	      			, 'labelhtml'=>$search['bank_acct_num'] //WT: Display di auto completenya
	      			, 'value'=>$search['bank_acct_num']);
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
		
		$model->rdi_pay_flg = trim($model->acct_type)=='RDM'?'Y':'N';
		$model->trf_ksei = trim($model->acct_type) == 'KSEI'?'Y':'N';
		$model->int_adjust = 'N';
		
		$bankAcct = Glaccount::model()->find("trim(gl_a) = trim('$model->gl_acct_cd') AND sl_a = '$model->sl_acct_cd'");
		
		if($bankAcct)$model->acct_name = $bankAcct->acct_name;
		
		if($model->client_cd)
		{
			$sql = "SELECT client_name, client_type_1||client_type_2||client_type_3 AS client_type, trim(branch_code) AS branch_code,
						b.cl_desc, DECODE(olt,'Y','OLT','') olt, DECODE(recov_charge_flg,'Y','2490','1422') recov_charge_flg,
						c.bank_cd, c.bank_acct_fmt, DECODE(c.acct_stat,'A','ACTIVE','INACTIVE') active,
						d.cif_name, e.bank_name client_bank, a.bank_acct_num
						FROM MST_CLIENT a 
						JOIN LST_TYPE3 b ON a.client_type_3 = b.cl_type3
						JOIN MST_CLIENT_FLACCT c ON a.client_cd = c.client_cd
						JOIN MST_CIF d ON a.cifs = d.cifs
						JOIN MST_IP_BANK e ON a.bank_cd = e.bank_cd
						WHERE a.client_cd = '$model->client_cd'
						AND c.acct_stat IN('A','I')";
			
			$client = DAO::queryRowSql($sql);
			
			if($client)
			{
				$model->client_type = $client['client_type'];
				$model->branch_code = $client['branch_code'];
				$model->client_name = $client['client_name'];
				$model->olt = $client['olt'];
				$model->client_type_3 = $client['cl_desc'];
				$model->recov_charge_flg = $client['recov_charge_flg'];
				$model->bank_cd = $client['bank_cd'];
				$model->bank_acct_fmt = $client['bank_acct_fmt'];
				$model->active = $client['active'];
			}
		}
		
		foreach($modelDetail as $row)
		{
			if($row->budget_cd == 'INTADJ')
			{
				$model->int_adjust == 'Y';
				break;
			}
		}
		
		$obj->render('/tpayrech/view',array(
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
		$modelDetail = array(); //Non Transaction
		$modelDetailLedger = array();
		$modelFolder = new Tfolder;
		$modelCheq = array();
		$modelCheqLedger = array();
		
		$tempModel = array(); 
				
		$retrieved = 0; // 0=>Not Retrieved, 1=>Transaction Retrieved, 2=>Transaction and Journal Retrieved
		$valid = FALSE;
		$success = FALSE;

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
					$startDt = Sysparam::model()->find("param_id = 'VOUCHER ENTRY' AND param_cd1 = 'TRANS' AND param_cd2 = 'START_DT'")->ddate1;
					if(DateTime::createFromFormat('d/m/Y',$startDt))$startDt=DateTime::createFromFormat('d/m/Y',$startDt)->format('Y-m-d');
                    if(DateTime::createFromFormat('Y-m-d H:i:s',$startDt))$startDt=DateTime::createFromFormat('Y-m-d H:i:s',$startDt)->format('Y-m-d');
                    if(DateTime::createFromFormat('d/m/Y',$model->payrec_date))$model->payrec_date=DateTime::createFromFormat('d/m/Y',$model->payrec_date)->format('Y-m-d');
                    if(DateTime::createFromFormat('Y-m-d H:i:s',$model->payrec_date))$model->payrec_date=DateTime::createFromFormat('Y-m-d H:i:s',$model->payrec_date)->format('Y-m-d');
					/*$persistentConn = Yii::app()->dbPersist;
					//$persistTran = $persistentConn->beginTransaction();
					
					try
					{
						$persistCommand = $persistentConn->createCommand(Tpayrecd::getOutstandingArapSql($startDt, $model->payrec_date, $model->client_cd));
						$result = $persistCommand->query();	
						
						$x = 0;
						foreach($result as $row)
						{
							$modelLedger[$x] = new Tpayrecd;
							$modelLedger[$x]->attributes = $row;
							$x++;
						}
					}
					catch(Exception $ex)
					{
						//$persistTran->rollback();
						$retrieved = 0;
						
						if(strpos($ex->getMessage(), 'ORA-00054')===false)
						{
							$model->addError('client_cd', $ex->getMessage());
						}
						else 
						{
							$model->addError('client_cd', 'This data is currently being edited by another user');
						}							
					}
					*/
					$modelLedger = Tpayrecd::model()->findAllBySql(Tpayrecd::getOutstandingArapSql($startDt, $model->payrec_date, $model->client_cd));
                    
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
					foreach($modelLedger as $row)
					{
						if($row->check == 'Y')
						{
							$oldLedger = Taccountledger::model()->find("xn_doc_num = '$row->gl_ref_num' AND tal_id = '$row->tal_id'");
							
							$oldLedger->sett_for_curr = $oldLedger->sett_for_curr==null?0:$oldLedger->sett_for_curr;
							$oldLedger->sett_val = $oldLedger->sett_val==null?0:$oldLedger->sett_val;
							
							$oldOutsAmt = $oldLedger->curr_val - $oldLedger->sett_for_curr - $oldLedger->sett_val;
							
							if($oldLedger->reversal_jur != 'N' || ( round($oldOutsAmt,2) < round($row->old_outs_amt,2) ) )
							{
								Yii::app()->user->setFlash('error', 'Some of the transactions have been modified, please retrieve the transactions again');
								$valid = false;
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
								$modelDetailLedger[$x]->sl_acct_cd = $row->sl_acct_cd;
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
										if($modelDetailLedger[$x]->gl_acct_cd == $rowDetail->gl_acct_cd)
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
						$bankLedger->db_cr_flg = $balDebit > 0?'C':'D';
						$bankLedger->ledger_nar = $model->remarks;
						$bankLedger->system_generated = 'Y';
						$bankLedger->bank_flg = 'Y';
						
						$modelDetailLedger = array_merge($modelDetailLedger,array($bankLedger));						
					}
				}
			}
			else 
			{
				// SUBMIT
				
				if($model->type == 'V')
				{
					// TRANSACTION
					$retrieved = 2;
					
					$ledgerCount = $_POST['ledgerCount'];
					$detailLedgerCount = $_POST['detailLedgerCount'];
					$cheqLedgerCount = $_POST['cheqLedgerCount'];
					
					for($x=0;$x<$ledgerCount;$x++)
					{
						$modelLedger[$x] = new Tpayrecd;
						$modelLedger[$x]->attributes = $_POST['Tpayrecdledger'][$x+1];
						$modelLedger[$x]->system_generated = 'Y';
						
						if($modelLedger[$x]->check == 'Y')
						{
							$modelLedger[$x]->payrec_date = $model->payrec_date;
							//$modelLedger[$x]->doc_tal_id = $modelLedger[$x]->tal_id;
							
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
							
							if($modelLedger[$x]->record_source == 'CDUE')
							{
								$modelLedger[$x]->doc_ref_num = $modelLedger[$x]->contr_num;
								
								//$modelLedger[$x]->tal_id = 1; 
								//$modelLedger[$x]->doc_tal_id = 1; //09may 2017 
							}
							else 
							{
								$modelLedger[$x]->doc_ref_num = $modelLedger[$x]->gl_ref_num;
							}
	
							$modelLedger[$x]->client_cd = $model->client_cd;
							
							switch($modelLedger[$x]->record_source)
							{
								case 'RD':	
								case 'PD':
								case 'ARAP':
									$modelLedger[$x]->record_source = 'PDRD';
									break;
								case 'RVO':
								case 'PVO':
									$modelLedger[$x]->record_source = 'PVRV';
									break;
								case 'CG':
									//if($modelLedger[$x]->budget_cd == 'BONDTRANS')
									//	$modelLedger[$x]->record_source = 'BOND';
									if($modelLedger[$x]->gl_acct_cd == 'KPEI')
										$modelLedger[$x]->record_source = 'KPEI';
									else if($modelLedger[$x]->gl_acct_cd == 'BROKER')
										$modelLedger[$x]->record_source = 'NEGO';
									
									break;
							}
							
							$modelLedger[$x]->doc_date = $modelLedger[$x]->contr_dt;
							$modelLedger[$x]->sett_for_curr = 0;
							$modelLedger[$x]->sett_val = 0;
							
							$valid = $modelLedger[$x]->validate() && $valid;
						}
					}

					$bank = Bankacct::model()->find("TRIM(gl_acct_cd) = '$model->gl_acct_cd' AND sl_acct_cd = '$model->sl_acct_cd'");

					$y = $temp = count($modelLedger);
					//$insertedTalId = 2;

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
							
								if($client)
								{
									$glAccount = Glaccount::model()->find("TRIM(gl_a) = '$glA' AND sl_a = '$slA'");
									$modelDetailLedger[$x]->acct_type = trim($glAccount->acct_type);
								}
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
							$modelLedger[$y]->client_cd = $model->client_cd;
							$modelLedger[$y]->tal_id = $modelLedger[$y]->doc_tal_id = $modelDetailLedger[$x]->tal_id;
							//$modelLedger[$y]->doc_ref_num = date('my').'ZZ1234567';
							$modelLedger[$y]->ref_folder_cd = $model->folder_cd;
							$modelLedger[$y]->doc_date = $model->payrec_date;
							$modelLedger[$y]->due_date = $model->payrec_date;
							
							$modelLedger[$y]->sett_for_curr = 0;
							$modelLedger[$y]->sett_val = 0;
							
							$modelLedger[$y]->check = 'Y';
							
							$valid = $modelLedger[$y]->validate() && $valid;
							
							$y++;
						}		
						
						$valid = $modelDetailLedger[$x]->validate() && $valid;
					}
					
					$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'CHECK' and param_cd2 ='ACCTBRCH'")->dflg1;
		
					if($check == 'Y')
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
					$x = 1;
					foreach($modelLedger as $row)
					{
						if($row->check == 'Y' && $row->system_generated == 'Y')
						{
							$oldLedger = Taccountledger::model()->find("xn_doc_num = '$row->gl_ref_num' AND tal_id = '$row->tal_id'");
							
							$oldLedger->sett_for_curr = $oldLedger->sett_for_curr==null?0:$oldLedger->sett_for_curr;
							$oldLedger->sett_val = $oldLedger->sett_val==null?0:$oldLedger->sett_val;
							
							$oldOutsAmt = $oldLedger->curr_val - $oldLedger->sett_for_curr - $oldLedger->sett_val;
							
							if($oldLedger->reversal_jur != 'N' || ( round($oldOutsAmt,2) < round($row->old_outs_amt,2) ) )
							{
								Yii::app()->user->setFlash('error', 'Some of the transactions have been modified, please retrieve the transactions again');
								$valid = false;
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
						if($model->rdi_pay_flg == 'Y')$model->acct_type = 'RDM';
						else
							$model->acct_type = $model->client_type;
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
									$row->gl_ref_num = $model->payrec_num;
									$row->doc_ref_num = $model->payrec_num;
								}
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
							$modelDetailLedger[$x]->xn_doc_num = $modelDetailLedger[$x]->rvpv_number = $model->payrec_num;
							$modelDetailLedger[$x]->doc_ref_num = Sysparam::model()->find("param_id = 'SYSTEM' and param_cd1 = 'DOC_REF'")->dflg1=='Y'?$model->payrec_num:'';
							$modelDetailLedger[$x]->xn_val = $modelDetailLedger[$x]->curr_val;
							$modelDetailLedger[$x]->reversal_jur = 'N';
							$modelDetailLedger[$x]->manual = 'Y';
							
							if($model->int_adjust == 'Y')$modelDetailLedger[$x]->budget_cd='INTADJ';
							
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
						foreach($modelLedger as $row)
						{
							if($row->check == 'Y' && $row->system_generated == 'Y')
							{
								if($success && $row->executeSpRvpvSettled(AConstant::INBOX_STAT_INS) > 0)$success = true;
								else {
									$success = false;
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
				else
				{
					// NON TRANSACTION
							
					$detailCount = $_POST['detailCount'];
					$cheqCount = $_POST['cheqCount'];
					//if($model->gl_accd_cd == 'NA')$cheqCount = 0;
					
					for($x=0;$x<$detailCount;$x++)
					{
						$modelDetail[$x] = new Tpayrecd;
						$modelDetail[$x]->attributes = $_POST['Tpayrecd'][$x+1];
						
						$glA = $modelDetail[$x]->gl_acct_cd;
						$slA = $modelDetail[$x]->sl_acct_cd;
						$client = Client::model()->find(array('select'=>'client_cd','condition'=>"client_cd = '$slA'"));
						
						if($x==0)
						{
							//if($modelDetail[$x]->gl_acct_cd == 'N/A')$modelDetail[$x]->gl_acct_cd = 'na';
							if($modelDetail[$x]->db_cr_flg == 'DEBIT')$modelDetail[$x]->db_cr_flg = 'D';
							else
								$modelDetail[$x]->db_cr_flg = 'C';
						}
						
						$modelDetail[$x]->payrec_type = $model->payrec_type;
						$modelDetail[$x]->payrec_date = $model->payrec_date;
						$modelDetail[$x]->client_cd = $model->client_cd;
						$modelDetail[$x]->brch_cd = $model->branch_code;
						//$modelDetail[$x]->doc_ref_num = date('my').'ZZ1234567';
						$modelDetail[$x]->record_source = $client?Sysparam::model()->find("param_id = 'VOUCHER ENTRY' and param_cd1 = 'SOURCE' AND param_cd2 = 'ARAP'")->dstr1:'VCH';
						$modelDetail[$x]->tal_id = $modelDetail[$x]->doc_tal_id = $x+1;
						$modelDetail[$x]->doc_date = $modelDetail[$x]->payrec_date;
						$modelDetail[$x]->due_date = $modelDetail[$x]->payrec_date;
						$modelDetail[$x]->ref_folder_cd = $model->folder_cd;
						
						$valid = $modelDetail[$x]->validate() && $valid;
					}

					$bank = Bankacct::model()->find("sl_acct_cd = '$model->sl_acct_cd' AND TRIM(gl_acct_cd) = '$model->gl_acct_cd'");
					
					for($x=0;$x<$cheqCount;$x++)
					{
						$modelCheq[$x] = new Tcheq;
						$modelCheq[$x]->attributes = $_POST['Tcheq'][$x+1];
						
						if($bank)$modelCheq[$x]->bank_cd = $bank->bank_cd;
						$modelCheq[$x]->sl_acct_cd = $model->sl_acct_cd;
						$modelCheq[$x]->chq_stat = 'A';
						$modelCheq[$x]->payee_bank_cd = $model->client_bank_cd;
						$modelCheq[$x]->payee_acct_num = $model->client_bank_acct;
						$modelCheq[$x]->seqno = $modelCheq[$x]->chq_seq = $x+1;
						$modelCheq[$x]->payee_name = $model->payrec_frto;
						
						$valid = $modelCheq[$x]->validate() && $valid;
					}
					
					$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'CHECK' and param_cd2 ='ACCTBRCH'")->dflg1;
		
					if($check == 'Y')
					{
						$brch_cd = '';
						$x = 0;
						foreach($modelDetail as $row)
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
					
					$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'VCH_REF' ")->dflg1;
					
					if($check == 'Y')
					{
						$glAccount = Glaccount::model()->find("TRIM(gl_a) = '$model->gl_acct_cd'");
						
						if($glAccount && $glAccount->acct_type == 'BANK')
						{
							$payrecFlg = $model->payrec_type=='RD'?'RECEIPT':'PAYMENT';
							
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
					
					if($valid)
					{
						$connection  = Yii::app()->db;
						$transaction = $connection->beginTransaction();
						
						if($model->executeSpHeader(AConstant::INBOX_STAT_INS,$this->menuName) > 0)$success = TRUE;
						
						if($model->gl_acct_cd == 'NA')$model->sl_acct_cd = 'nonbank';
						
						if($model->rdi_pay_flg == 'Y')$model->acct_type = 'RDM';
						else if($model->trf_ksei == 'Y')$model->acct_type = 'KSEI';
						else
							$model->acct_type = $model->client_type;
						
						$model->num_cheq = count($modelCheq)>0?1:0;
						
						/*$check = Parameter::model()->find("prm_cd_1 = 'BNKFLG' AND prm_cd_2 = '$model->gl_acct_cd'");
						if($check)
						{
							if($check->prm_desc2 == 'Y')
							{
								$model->curr_cd = Bankacct::model()->find("TRIM(gl_acct_cd) = '$model->gl_acct_cd' AND sl_acct_cd = '$model->sl_acct_cd'")->curr_cd;
							}
						}*/
						$model->curr_cd = 'IDR';
						
						//T_PAYRECH
						if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$model->payrec_num,1) > 0)$success = true;
						else {
							$success = false;
						}
						
						//T_PAYRECD
						for($x=1;$success && $x<$detailCount;$x++) //Start from the second record
						{
							$modelDetail[$x]->payrec_num = $model->payrec_num;
							$modelDetail[$x]->gl_ref_num = $model->payrec_num;
							$modelDetail[$x]->doc_ref_num = $model->payrec_num;
							if($success && $modelDetail[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelDetail[$x]->payrec_num,$modelDetail[$x]->doc_ref_num,$modelDetail[$x]->tal_id,$model->update_date,$model->update_seq,$x) > 0)$success = true;
							else {
								$success = false;
							}
						}
						
						$seq = 1;
						
						//T_ACCOUNT_LEDGER
						for($x=0;$success && $x<$detailCount;$x++)
						{
							
							$modelLedger[$x] = new Taccountledger;
							
							$modelLedger[$x]->xn_doc_num = $model->payrec_num;
							$modelLedger[$x]->doc_ref_num = Sysparam::model()->find("param_id = 'SYSTEM' and param_cd1 = 'DOC_REF'")->dflg1=='Y'?$model->payrec_num:'';
							$modelLedger[$x]->tal_id = $x==0?555:$x+1;
							
							$glA = trim($modelDetail[$x]->gl_acct_cd);
							$slA = $modelDetail[$x]->sl_acct_cd;
							$client = Client::model()->find(array('select'=>'client_cd','condition'=>"client_cd = '$slA'"));
							if($client)$modelLedger[$x]->acct_type = trim(Glaccount::model()->find("TRIM(gl_a) = '$glA' AND sl_a = '$slA'")->acct_type);
							
							$modelLedger[$x]->gl_acct_cd = $modelDetail[$x]->gl_acct_cd;
							$modelLedger[$x]->sl_acct_cd = $modelDetail[$x]->sl_acct_cd;
							//$modelLedger[$x]->curr_cd = $model->curr_cd;
							$modelLedger[$x]->curr_cd = 'IDR';
							$modelLedger[$x]->brch_cd = $model->branch_code;
							$modelLedger[$x]->curr_val = $modelDetail[$x]->payrec_amt;
							$modelLedger[$x]->xn_val = $modelDetail[$x]->payrec_amt;
							$modelLedger[$x]->db_cr_flg = $modelDetail[$x]->db_cr_flg;
							$modelLedger[$x]->ledger_nar = $modelDetail[$x]->remarks;
							$modelLedger[$x]->doc_date = $modelDetail[$x]->doc_date;
							$modelLedger[$x]->due_date = $modelDetail[$x]->due_date;
							$modelLedger[$x]->netting_date = $model->payrec_date;
							$modelLedger[$x]->netting_flg = 2;
							$modelLedger[$x]->record_source = $model->payrec_type;
							$modelLedger[$x]->sett_val = 0;
							$modelLedger[$x]->sett_for_curr = 0;
							$modelLedger[$x]->sett_status = $x==0?'':'N';
							$modelLedger[$x]->rvpv_number = $model->payrec_num;
							$modelLedger[$x]->arap_due_date = $model->payrec_date;
							$modelLedger[$x]->folder_cd = $model->folder_cd;
							if($model->trf_ksei == 'Y')$modelLedger[$x]->budget_cd = 'KSEIVCH';
							else 
								$modelLedger[$x]->budget_cd = substr($model->payrec_type,0,1).'VCH';
							$modelLedger[$x]->reversal_jur = 'N';
							$modelLedger[$x]->manual = 'Y';
							$modelLedger[$x]->cash_withdraw_amt = $modelDetail[$x]->cash_withdraw_amt;
							$modelLedger[$x]->cash_withdraw_reason = $modelDetail[$x]->cash_withdraw_reason;
							$modelLedger[$x]->user_id = $model->user_id;
							$modelLedger[$x]->cre_dt = $model->cre_dt;
							$modelLedger[$x]->upd_by = $model->upd_by;
							$modelLedger[$x]->upd_dt = $model->upd_dt;
							
							if($model->gl_acct_cd != 'NA' || $x > 0)
							{
								if($success && $modelLedger[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelLedger[$x]->xn_doc_num,$modelLedger[$x]->tal_id,$model->update_date,$model->update_seq,$seq++) > 0)$success = true;
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
						for($x=0;$success && $x<$cheqCount;$x++)
						{
							$modelCheq[$x]->rvpv_number = $model->payrec_num;
							
							if($success && $modelCheq[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelCheq[$x]->rvpv_number,$modelCheq[$x]->chq_seq,$modelCheq[$x]->chq_num,$model->update_date,$model->update_seq,$x+1) > 0)$success = true;
							else {
								$success = false;
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
				}
			}
		}
		else 
		{
			$model->type = 'D';
			$model->payrec_type = 'RD';
			$modelDetail[0] = new Tpayrecd;
			$modelDetail[1] = new Tpayrecd;
		}

		$obj->render('/tpayrech/create',array(
			'model'=>$model,
			'modelDetail'=>$modelDetail,
			'modelLedger'=>$modelLedger,
			'modelDetailLedger'=>$modelDetailLedger,
			'modelFolder'=>$modelFolder,
			'modelCheq'=>$modelCheq,
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
		$modelDetail = array(); //Non Transaction
		$modelDetailLedger = array();
		$modelDetailLedgerNonRev = array();
		$modelFolder = Tfolder::model()->find("doc_num = '$model->payrec_num'");
		$modelCheq = array();
		$modelCheqLedger = array();
		$modelJvchh = new Tjvchh;
		
		$oldModel = new Tpayrech;
		$oldModelDetail = array();
		$oldModelDetailLedger = array();
		$oldModelFolder = new Tfolder;
		$reverseModelLedger = array();
		$reverseModelFolder = new Tfolder;
		
		$oldModelLedger = array();
		
		$model->gl_acct_cd = strtoupper($model->gl_acct_cd);
		
		if(trim($model->acct_type) == 'RDM' || (trim($model->acct_type) == 'RDI' && substr($model->payrec_type,0,1) == 'P'))$model->rdi_pay_flg = 'Y';
		else if(trim($model->acct_type) == 'KSEI')$model->trf_ksei = 'Y';
		else {
			$model->rdi_pay_flg = 'N';
		}

		$model->int_adjust = 'N';
		
		$cancel_reason = '';
		$cancel_reason_cheq = '';
		
		$tempModel = array(); 
		
		$type = substr($model->payrec_num,5,1);
		$model->scenario = $model->type = $type;
		
		$oldPayrecDate = DateTime::createFromFormat('Y-m-d H:i:s',$model->payrec_date)->format('Y-m-d');
		
		$retrieved = $type=='D'?0:2;
		
		$valid = FALSE;
		$success = FALSE;
		$settled = FALSE;
		//$nonArapBackDated = FALSE;
		$pending = FALSE;
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
			
			if($type == 'D')
			{
				// NON TRANSACTION	
				$detailCount = $_POST['detailCount'];
				$cheqCount = $_POST['cheqCount'];
				$x=0;
				
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
				
				$oldModel = $this->loadModel($id);
				$oldModel->payrec_date = DateTime::createFromFormat('Y-m-d G:i:s',$oldModel->payrec_date)->format('Y-m-d');
				$oldModel->gl_acct_cd = trim($oldModel->gl_acct_cd);
				
				if($model->payrec_date != $oldModel->payrec_date || $model->gl_acct_cd != $oldModel->gl_acct_cd || $model->sl_acct_cd != $oldModel->sl_acct_cd || $model->curr_amt != $oldModel->curr_amt)
				{
					$reversal = true;
				}
				
				for($x=0;$x<$detailCount;$x++)
				{
					if($x==0)
					{
						$modelDetail[$x] = new Tpayrecd;
						$modelDetail[$x]->attributes = $_POST['Tpayrecd'][$x+1];
						
						$glA = $modelDetail[$x]->gl_acct_cd;
						$slA = $modelDetail[$x]->sl_acct_cd;
						$client = Client::model()->find(array('select'=>'client_cd','condition'=>"client_cd = '$slA'"));
						
						//if($modelDetail[$x]->gl_acct_cd == 'N/A')$modelDetail[$x]->gl_acct_cd = 'na';
						if($modelDetail[$x]->db_cr_flg == 'DEBIT')$modelDetail[$x]->db_cr_flg = 'D';
						else
							$modelDetail[$x]->db_cr_flg = 'C';
						
						$modelDetail[$x]->payrec_type = $model->payrec_type;
						$modelDetail[$x]->payrec_date = $model->payrec_date;
						$modelDetail[$x]->client_cd = $model->client_cd;
						$modelDetail[$x]->brch_cd = $model->branch_code;
						//$modelDetail[$x]->doc_ref_num = date('my').'ZZ1234567';
						$modelDetail[$x]->record_source = $client?Sysparam::model()->find("param_id = 'VOUCHER ENTRY' and param_cd1 = 'SOURCE' AND param_cd2 = 'ARAP'")->dstr1:'VCH';
						$modelDetail[$x]->tal_id = $modelDetail[$x]->doc_tal_id = $x+1;
						$modelDetail[$x]->doc_date = $modelDetail[$x]->payrec_date;
						$modelDetail[$x]->due_date = $modelDetail[$x]->payrec_date;
						$modelDetail[$x]->ref_folder_cd = $model->folder_cd;
						
						$valid = $modelDetail[$x]->validate() && $valid;
					}
					else 
					{
						if(isset($_POST['Tpayrecd'][$x+1]['save_flg']) && $_POST['Tpayrecd'][$x+1]['save_flg'] == 'Y')
						{
							if(isset($_POST['Tpayrecd'][$x+1]['cancel_flg']))
							{
								// CHECKED EXISTING RECORD
								
								$rowid = $_POST['Tpayrecd'][$x+1]['rowid'];
								$modelDetail[$x] = Tpayrecd::model()->find("rowid='$rowid'");
								
								$glA = $modelDetail[$x]->gl_acct_cd;
								$slA = $modelDetail[$x]->sl_acct_cd;
								$client = Client::model()->find(array('select'=>'client_cd','condition'=>"client_cd = '$slA'"));
								
								if($_POST['Tpayrecd'][$x+1]['cancel_flg'] == 'Y')
								{
									//CANCEL
									$modelDetail[$x]->scenario = 'cancel';
									$modelDetail[$x]->cancel_reason = $_POST['cancel_reason'];
									$modelDetail[$x]->rowid = $rowid;
									$modelDetail[$x]->cancel_flg = 'Y';
									$modelDetail[$x]->save_flg = 'Y';
									
									$reversal = true;
									
									/*if($modelDetail[$x]->payrec_date)$modelDetail[$x]->payrec_date = DateTime::createFromFormat('Y-m-d G:i:s',$modelDetail[$x]->payrec_date)->format('Y-m-d');
									if($modelDetail[$x]->doc_date)$modelDetail[$x]->doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$modelDetail[$x]->doc_date)->format('Y-m-d');
									if($modelDetail[$x]->due_date)$modelDetail[$x]->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$modelDetail[$x]->due_date)->format('Y-m-d');*/
								}
								else 
								{
									//UPDATE
									$modelDetail[$x]->scenario = 'update';
									
									if(
										trim($modelDetail[$x]->gl_acct_cd) != trim($_POST['Tpayrecd'][$x+1]['gl_acct_cd'])
										||$modelDetail[$x]->sl_acct_cd != $_POST['Tpayrecd'][$x+1]['sl_acct_cd']
										||$modelDetail[$x]->payrec_amt != str_replace(',','',$_POST['Tpayrecd'][$x+1]['payrec_amt'])
										||$modelDetail[$x]->db_cr_flg != substr($_POST['Tpayrecd'][$x+1]['db_cr_flg'],0,1)
									)
									{
										$reversal = true;
									}
									
									$modelDetail[$x]->attributes = $_POST['Tpayrecd'][$x+1];
								}
							}
							else 
							{
								//CHECKED NEW RECORD
								
								//INSERT
								$modelDetail[$x] = new Tpayrecd;
								$modelDetail[$x]->attributes = $_POST['Tpayrecd'][$x+1];
								
								$glA = $modelDetail[$x]->gl_acct_cd;
								$slA = $modelDetail[$x]->sl_acct_cd;
								$client = Client::model()->find(array('select'=>'client_cd','condition'=>"client_cd = '$slA'"));
								
								$modelDetail[$x]->scenario = 'insert';
								
								$modelDetail[$x]->payrec_type = $model->payrec_type;
								$modelDetail[$x]->client_cd = $model->client_cd;
								$modelDetail[$x]->brch_cd = $model->branch_code;
								//$modelDetail[$x]->doc_ref_num = date('my').'ZZ1234567';
								
								$reversal = true;
							}

							$modelDetail[$x]->payrec_date = $model->payrec_date;
							$modelDetail[$x]->record_source = $client?Sysparam::model()->find("param_id = 'VOUCHER ENTRY' and param_cd1 = 'SOURCE' AND param_cd2 = 'ARAP'")->dstr1:'VCH';
							$modelDetail[$x]->doc_date = $modelDetail[$x]->payrec_date;
							$modelDetail[$x]->due_date = $modelDetail[$x]->payrec_date;
							$modelDetail[$x]->ref_folder_cd = $model->folder_cd;
							
							$valid = $modelDetail[$x]->validate() && $valid;
						}
						else 
						{
							if(isset($_POST['Tpayrecd'][$x+1]['rowid']))
								$rowid = $_POST['Tpayrecd'][$x+1]['rowid'];
							else 
							{
								$rowid = '';
							}
							
							if($rowid)
							{
								// NOT CHECKED EXISTING RECORD
								
								$modelDetail[$x] = Tpayrecd::model()->find("rowid='$rowid'");
								$modelDetail[$x]->rowid = $rowid;
								
								$modelDetail[$x]->gl_acct_cd = trim($modelDetail[$x]->gl_acct_cd);
								$modelDetail[$x]->payrec_date = $model->payrec_date;
								$modelDetail[$x]->doc_date = $modelDetail[$x]->payrec_date;
								$modelDetail[$x]->due_date = $modelDetail[$x]->payrec_date;
								$modelDetail[$x]->ref_folder_cd = $model->folder_cd;
								$valid = $modelDetail[$x]->validate() && $valid;
							}	
						}
					}
				}

				$bank = Bankacct::model()->find("sl_acct_cd = '$model->sl_acct_cd' AND TRIM(gl_acct_cd) = '$model->gl_acct_cd'");

				for($x=0;$x<$cheqCount;$x++)
				{
					if(isset($_POST['Tcheq'][$x+1]['save_flg']) && $_POST['Tcheq'][$x+1]['save_flg'] == 'Y')
					{
						if(isset($_POST['Tcheq'][$x+1]['cancel_flg']))
						{
							// CHECKED EXISTING RECORD
								
							$rowid = $_POST['Tcheq'][$x+1]['rowid'];
							$modelCheq[$x] = Tcheq::model()->find("rowid='$rowid'");								
							
							if($_POST['Tcheq'][$x+1]['cancel_flg'] == 'Y')
							{
								//CANCEL
								$modelCheq[$x]->scenario = 'cancel';
								$modelCheq[$x]->cancel_reason = $_POST['cancel_reason_cheq'];
								$modelCheq[$x]->rowid = $rowid;
								$modelCheq[$x]->cancel_flg = 'Y';
								$modelCheq[$x]->save_flg = 'Y';
								if($modelCheq[$x]->chq_dt)$modelCheq[$x]->chq_dt = DateTime::createFromFormat('Y-m-d G:i:s',$modelCheq[$x]->chq_dt)->format('Y-m-d');
							}
							else 
							{
								//UPDATE
								$modelCheq[$x]->scenario = 'update';
								$modelCheq[$x]->attributes = $_POST['Tcheq'][$x+1];
							}
							
							if($bank)$modelCheq[$x]->bank_cd = $bank->bank_cd;
							$modelCheq[$x]->sl_acct_cd = $model->sl_acct_cd;
							$modelCheq[$x]->payee_bank_cd = $model->client_bank_cd;
							$modelCheq[$x]->payee_acct_num = $model->client_bank_acct;
							$modelCheq[$x]->payee_name = $model->payrec_frto;
						}
						else 
						{
							//CHECKED NEW RECORD
								
							//INSERT
							$modelCheq[$x] = new Tcheq;
							$modelCheq[$x]->attributes = $_POST['Tcheq'][$x+1];
							
							$modelCheq[$x]->scenario = 'insert';
						
							if($bank)$modelCheq[$x]->bank_cd = $bank->bank_cd;
							$modelCheq[$x]->sl_acct_cd = $model->sl_acct_cd;
							$modelCheq[$x]->chq_stat = 'A';
							$modelCheq[$x]->payee_bank_cd = $model->client_bank_cd;
							$modelCheq[$x]->payee_acct_num = $model->client_bank_acct;
							$modelCheq[$x]->payee_name = $model->payrec_frto;
						}
						
						$valid = $modelCheq[$x]->validate() && $valid;
					}
					else 
					{
						if(isset($_POST['Tcheq'][$x+1]['rowid']))
							$rowid = $_POST['Tcheq'][$x+1]['rowid'];
						else 
						{
							$rowid = '';
						}
						
						if($rowid)
						{
							// NOT CHECKED EXISTING RECORD
							
							$modelCheq[$x] = Tcheq::model()->find("rowid='$rowid'");
							$modelCheq[$x]->rowid = $rowid;
							
							if($modelCheq[$x]->chq_dt)$modelCheq[$x]->chq_dt = DateTime::createFromFormat('Y-m-d G:i:s',$modelCheq[$x]->chq_dt)->format('Y-m-d');
							$valid = $modelCheq[$x]->validate() && $valid;
						}
					}
				}

				$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'CHECK' and param_cd2 ='ACCTBRCH'")->dflg1;
		
				if($check == 'Y')
				{
					$brch_cd = '';
					$x = 0;
					foreach($modelDetail as $row)
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

				$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'VCH_REF' ")->dflg1;
					
				if($check == 'Y')
				{
					$glAccount = Glaccount::model()->find("TRIM(gl_a) = '$model->gl_acct_cd'");
						
					if($glAccount && $glAccount->acct_type == 'BANK')
					{
						$payrecFlg = $model->payrec_type=='RD'?'RECEIPT':'PAYMENT';
						
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
					
					if($model->gl_acct_cd == 'NA')$model->sl_acct_cd = 'nonbank';
					
					if($model->rdi_pay_flg == 'Y')$model->acct_type = 'RDM';
					else if($model->trf_ksei == 'Y')$model->acct_type = 'KSEI';
					else
						$model->acct_type = $model->client_type;
					
					$model->num_cheq = count($modelCheq)>0?1:0;
					
					/*$check = Parameter::model()->find("prm_cd_1 = 'BNKFLG' AND prm_cd_2 = '$model->gl_acct_cd'");
					if($check)
					{
						if($check->prm_desc2 == 'Y')
						{
							//$model->curr_cd = Bankacct::model()->find("TRIM(gl_acct_cd) = '$model->gl_acct_cd' AND sl_acct_cd = '$model->sl_acct_cd'")->curr_cd;
						}
					}*/
					$model->curr_cd = 'IDR';
					
					if($reversal)
					{
						// REVERSAL
						
						//--------------CANCEL + REVERSE-----------------//
						//$oldModel = $this->loadModel($id);
						
						// CANCEL T_PAYRECH
						$oldModel->update_date = $model->update_date;
						$oldModel->update_seq = $model->update_seq;
						if($success && $oldModel->executeSp(AConstant::INBOX_STAT_CAN,$oldModel->payrec_num,2) > 0)$success = true;
						else {
							$success = false;
						}
						
						$oldModelDetail = Tpayrecd::model()->findAll("payrec_num = '$oldModel->payrec_num' AND approved_sts = 'A'");
						
						// CANCEL T_PAYRECD
						$modelDetailSeq = 1;
						foreach($oldModelDetail as $row)
						{
							if($row->payrec_date)$row->payrec_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->payrec_date)->format('Y-m-d');
							if($row->doc_date)$row->doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->doc_date)->format('Y-m-d');
							if($row->due_date)$row->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('Y-m-d');
							
							if($success && $row->executeSp(AConstant::INBOX_STAT_CAN,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$modelDetailSeq++) > 0)$success = true;
							else {
								$success = false;
							}
						}
						
						$reverseModelLedger = Taccountledger::model()->findAll("xn_doc_num = '$oldModel->payrec_num' AND approved_sts = 'A'");
						
						$reversalDate = $oldModel->payrec_date;
						
						if(!$originalReversalDate)
						{
							$arapFlg = false;
							
							foreach($reverseModelLedger as $row)
							{
								$result = DAO::queryRowSql("SELECT client_cd FROM MST_CLIENT WHERE client_cd = '$row->sl_acct_cd'");
								
								if($result)
								{
									$arapFlg = true;
									break;
								}
							}
							
							if(!$arapFlg)
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
						}
						
						//$reversePayrecType = $oldModel->payrec_type=='RD'?'PD':'RD';
						$result = DAO::queryRowSql("SELECT GET_DOCNUM_GL(TO_DATE('$reversalDate','YYYY-MM-DD HH24:MI:SS'),'GL') AS REVERSE_DOC_NUM FROM dual");
						$reverseDocNum = $result['reverse_doc_num'];
						
						//$folderPrefix = substr($model->folder_cd,0,3);
						$result = DAO::queryRowSql("SELECT F_GET_FOLDER_NUM(TO_DATE('$reversalDate','YYYY-MM-DD HH24:MI:SS'),'RJ-') AS REVERSE_FOLDER_CD FROM dual");
						$reverseFolderCd = $result['reverse_folder_cd'];
										
						// INSERT REVERSE T_ACCOUNT_LEDGER
						$ledgerSeq = 1;
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
							
							if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$row->xn_doc_num,$row->tal_id,$model->update_date,$model->update_seq,$ledgerSeq++) > 0)$success = true;
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
						
						$x = 0;
						foreach($modelDetail as $row)
						{
							if($row->cancel_flg != 'Y')
							{
								if($x > 0 )
								{
									// INSERT T_PAYRECD
									$row->payrec_num = $model->payrec_num;
									$row->tal_id = $row->doc_tal_id = $x+1;
									$row->gl_ref_num = $model->payrec_num;
									$row->doc_ref_num = $model->payrec_num;
									if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$modelDetailSeq++) > 0)$success = true;
									else {
										$success = false;
									}
								}	
								
								// INSERT T_ACCOUNT_LEDGER
								
								$modelLedger[$x] = new Taccountledger;
								
								$modelLedger[$x]->xn_doc_num = $model->payrec_num;
								$modelLedger[$x]->doc_ref_num = Sysparam::model()->find("param_id = 'SYSTEM' and param_cd1 = 'DOC_REF'")->dflg1=='Y'?$model->payrec_num:'';
								$modelLedger[$x]->tal_id = $x==0?555:$x+1;
								
								//$modelLedger[$x]->acct_type = $model->client_type;
								$glA = trim($modelDetail[$x]->gl_acct_cd);
								$slA = $modelDetail[$x]->sl_acct_cd;
								$client = Client::model()->find(array('select'=>'client_cd','condition'=>"client_cd = '$slA'"));
								if($client)$modelLedger[$x]->acct_type = trim(Glaccount::model()->find("TRIM(gl_a) = '$glA' AND sl_a = '$slA'")->acct_type);
								
								$modelLedger[$x]->gl_acct_cd = $row->gl_acct_cd;
								$modelLedger[$x]->sl_acct_cd = $row->sl_acct_cd;
								//$modelLedger[$x]->curr_cd = $model->curr_cd;
								$modelLedger[$x]->curr_cd = 'IDR';
								$modelLedger[$x]->brch_cd = $model->branch_code;
								$modelLedger[$x]->curr_val = $row->payrec_amt;
								$modelLedger[$x]->xn_val = $row->payrec_amt;
								$modelLedger[$x]->db_cr_flg = $row->db_cr_flg;
								$modelLedger[$x]->ledger_nar = $row->remarks;
								$modelLedger[$x]->doc_date = $row->doc_date;
								$modelLedger[$x]->due_date = $row->due_date;
								$modelLedger[$x]->netting_date = $model->payrec_date;
								$modelLedger[$x]->netting_flg = 2;
								$modelLedger[$x]->record_source = $model->payrec_type;
								$modelLedger[$x]->sett_val = 0;
								$modelLedger[$x]->sett_for_curr = 0;
								$modelLedger[$x]->sett_status = $x==0?'':'N';
								$modelLedger[$x]->rvpv_number = $model->payrec_num;
								$modelLedger[$x]->arap_due_date = $model->payrec_date;
								$modelLedger[$x]->folder_cd = $model->folder_cd;
								if($model->trf_ksei == 'Y')$modelLedger[$x]->budget_cd = 'KSEIVCH';
								else
									$modelLedger[$x]->budget_cd = substr($model->payrec_type,0,1).'VCH';
								$modelLedger[$x]->reversal_jur = 'N';
								$modelLedger[$x]->manual = 'Y';
								$modelLedger[$x]->user_id = $model->user_id;
								$modelLedger[$x]->cre_dt = $model->cre_dt;
								$modelLedger[$x]->upd_by = $model->upd_by;
								$modelLedger[$x]->upd_dt = $model->upd_dt;
								
								if($model->gl_acct_cd != 'NA' || $x > 0)
								{
									if($success && $modelLedger[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelLedger[$x]->xn_doc_num,$modelLedger[$x]->tal_id,$model->update_date,$model->update_seq,$ledgerSeq++) > 0)$success = true;
									else {
										$success = false;
									}
								}
								
								$x++;
							}
						}

						// INSERT T_FOLDER
						
						if($model->folder_cd)
						{
							$modelFolder = new Tfolder; 
							$modelFolder->fld_mon = DateTime::createFromFormat('Y-m-d',$model->payrec_date)->format('my');
							$modelFolder->folder_cd = $model->folder_cd;
							$modelFolder->doc_date = $model->payrec_date;
							$modelFolder->doc_num = $model->payrec_num;
							$modelFolder->user_id = $model->user_id;
							$modelFolder->cre_dt = $model->cre_dt;
							$modelFolder->upd_by = $model->upd_by;
							$modelFolder->upd_dt = $model->upd_dt;
							
							if($success && $modelFolder->executeSp(AConstant::INBOX_STAT_INS,$modelFolder->doc_num,$model->update_date,$model->update_seq,3) > 0)$success = true;
							else {
								$success = false;
							}
						}
						
						//----------------END INSERT NEW RECORD-----------------//
						
						// UPDATE T_CHEQ
						
						$recordSeq = 1;
						//$cheque = DAO::queryRowSql("SELECT NVL(MAX(chq_seq),0) max_seq FROM T_CHEQ WHERE RVPV_NUMBER = '$model->payrec_num'");
						//$currSeq = $cheque['max_seq'] + 1;
						
						for($x=0; $success && $x<$cheqCount; $x++)
						{
							$oldRvpvNumber = $modelCheq[$x]->rvpv_number;
							$oldChqSeq = $modelCheq[$x]->chq_seq;
								
							$modelCheq[$x]->rvpv_number = $model->payrec_num;
							$modelCheq[$x]->chq_seq = $modelCheq[$x]->seqno = $recordSeq;
							
							if($modelCheq[$x]->save_flg == 'Y')
							{							
								if($modelCheq[$x]->cancel_flg == 'Y')
								{
									//CANCEL
									if($success && $modelCheq[$x]->executeSp(AConstant::INBOX_STAT_CAN,$oldRvpvNumber,$oldChqSeq,$modelCheq[$x]->chq_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}
								else if($modelCheq[$x]->rowid)
								{
									//UPDATE
									if($success && $modelCheq[$x]->executeSp(AConstant::INBOX_STAT_UPD,$oldRvpvNumber,$oldChqSeq,$modelCheq[$x]->chq_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}			
								else 
								{
									//INSERT
									if($success && $modelCheq[$x]->executeSp(AConstant::INBOX_STAT_INS,$oldRvpvNumber,$oldChqSeq,$modelCheq[$x]->chq_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}
							}
							else 
							{
								// UPDATE RVPV_NUMBER OF 'NOT CHECKED' EXISTING RECORD
								
								if($success && $modelCheq[$x]->executeSp(AConstant::INBOX_STAT_UPD,$oldRvpvNumber,$oldChqSeq,$modelCheq[$x]->chq_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
								else {
									$success = false;
								}
							}
							$recordSeq++;
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
							
							$x = 0;
							
							$result = DAO::queryRowSql("SELECT MAX(tal_id) last_tal_id FROM T_PAYRECD WHERE payrec_num = '$model->payrec_num'");
							$lastTalId = $result['last_tal_id'];
							
							foreach($modelDetail as $row)
							{
								
								if($x > 0 )
								{
									// INSERT T_PAYRECD								
									if($row->save_flg == 'Y')
									{							
										if($row->cancel_flg == 'Y')
										{
											//CANCEL										
											if($success && $row->executeSp(AConstant::INBOX_STAT_CAN,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$x) > 0)$success = true;
											else {
												$success = false;
											}
										}
										else if($row->rowid)
										{
											//UPDATE
											if($success && $row->executeSp(AConstant::INBOX_STAT_UPD,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$x) > 0)$success = true;
											else {
												$success = false;
											}
										}			
										else 
										{
											//INSERT
											$row->payrec_num = $row->gl_ref_num = $row->doc_ref_num = $model->payrec_num;
											$row->tal_id = ++$lastTalId;
											if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$x) > 0)$success = true;
											else {
												$success = false;
											}
										}
									}
									else
									{
										// UPDATE FOLDER_CD										
										if($success && $row->executeSp(AConstant::INBOX_STAT_UPD,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$x) > 0)$success = true;
										else {
											$success = false;
										}
									}
								}	
								
								// INSERT T_ACCOUNT_LEDGER
								
								$talIdSearch = $x==0?555:$row->tal_id; 
								
								if(!($modelLedger[$x] = Taccountledger::model()->find("xn_doc_num = '$model->payrec_num' AND tal_id = '$talIdSearch'")))
								{
									$modelLedger[$x] = new Taccountledger;
									
									$modelLedger[$x]->xn_doc_num = $model->payrec_num;
									$modelLedger[$x]->doc_ref_num = Sysparam::model()->find("param_id = 'SYSTEM' and param_cd1 = 'DOC_REF'")->dflg1=='Y'?$model->payrec_num:'';
									$modelLedger[$x]->tal_id = $row->tal_id;
									
									$modelLedger[$x]->curr_cd = 'IDR';
									$modelLedger[$x]->netting_flg = 2;
									$modelLedger[$x]->record_source = $model->payrec_type;
									$modelLedger[$x]->sett_val = 0;
									$modelLedger[$x]->sett_for_curr = 0;
									$modelLedger[$x]->sett_status = $x==0?'':'N';
									$modelLedger[$x]->rvpv_number = $model->payrec_num;
									$modelLedger[$x]->reversal_jur = 'N';
									$modelLedger[$x]->manual = 'Y';
									
									$modelLedger[$x]->user_id = $model->user_id;
									$modelLedger[$x]->cre_dt = $model->cre_dt;
								}
																
								$glA = trim($modelDetail[$x]->gl_acct_cd);
								$slA = $modelDetail[$x]->sl_acct_cd;
								$client = Client::model()->find(array('select'=>'client_cd','condition'=>"client_cd = '$slA'"));
								if($client)$modelLedger[$x]->acct_type = trim(Glaccount::model()->find("TRIM(gl_a) = '$glA' AND sl_a = '$slA'")->acct_type);
								
								$modelLedger[$x]->gl_acct_cd = $row->gl_acct_cd;
								$modelLedger[$x]->sl_acct_cd = $row->sl_acct_cd;
								$modelLedger[$x]->brch_cd = $model->branch_code;
								$modelLedger[$x]->curr_val = $row->payrec_amt;
								$modelLedger[$x]->xn_val = $row->payrec_amt;
								$modelLedger[$x]->db_cr_flg = $row->db_cr_flg;
								$modelLedger[$x]->ledger_nar = $row->remarks;
								$modelLedger[$x]->doc_date = $row->doc_date;
								$modelLedger[$x]->due_date = $row->due_date;
								$modelLedger[$x]->netting_date = $model->payrec_date;
								$modelLedger[$x]->arap_due_date = $model->payrec_date;
								
								$modelLedger[$x]->folder_cd = $model->folder_cd;
								if($model->trf_ksei == 'Y')$modelLedger[$x]->budget_cd = 'KSEIVCH';
								else
									$modelLedger[$x]->budget_cd = substr($model->payrec_type,0,1).'VCH';
								
								$modelLedger[$x]->upd_by = $model->upd_by;
								$modelLedger[$x]->upd_dt = $model->upd_dt;
							
								if($row->save_flg == 'Y')
								{							
									if($row->cancel_flg == 'Y')
									{
										//CANCEL										
										if($success && $modelLedger[$x]->executeSp(AConstant::INBOX_STAT_CAN,$modelLedger[$x]->xn_doc_num,$modelLedger[$x]->tal_id,$model->update_date,$model->update_seq,$x+1) > 0)$success = true;
										else {
											$success = false;
										}
									}
									else if($row->rowid)
									{
										//UPDATE
										if($success && $modelLedger[$x]->executeSp(AConstant::INBOX_STAT_UPD,$modelLedger[$x]->xn_doc_num,$modelLedger[$x]->tal_id,$model->update_date,$model->update_seq,$x+1) > 0)$success = true;
										else {
											$success = false;
										}
									}			
									else 
									{
										//INSERT
										if($success && $modelLedger[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelLedger[$x]->xn_doc_num,$modelLedger[$x]->tal_id,$model->update_date,$model->update_seq,$x+1) > 0)$success = true;
										else {
											$success = false;
										}
									}
								}
								else
								{
									// UPDATE FOLDER_CD										
									if($success && $modelLedger[$x]->executeSp(AConstant::INBOX_STAT_UPD,$modelLedger[$x]->xn_doc_num,$modelLedger[$x]->tal_id,$model->update_date,$model->update_seq,$x+1) > 0)$success = true;
									else {
										$success = false;
									}
								}
								
								$x++;
							}
						}
						else 
						{
							// PURE NON REVERSAL 
							
							$modelDetailLedgerNonRev = Taccountledger::model()->findAll(array('condition'=>"xn_doc_num = '$id' AND approved_sts = 'A'",'order'=>"DECODE(record_source,'ARAP','VCH',record_source), tal_id"));
						
							$x = 1;
							
							foreach($modelDetailLedgerNonRev as $row)
							{
								// UPDATE FOLDER_CD, REMARKS
								$row->folder_cd = $model->folder_cd;
								$row->ledger_nar = $modelDetail[$x-1]->remarks;
								
								if($model->trf_ksei == 'Y')$row->budget_cd = 'KSEIVCH';
								else
									$row->budget_cd = substr($model->payrec_type,0,1).'VCH';
								
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
								
								if($x > 1)
								{
									if($success && $modelDetail[$x-1]->executeSp(AConstant::INBOX_STAT_UPD,$modelDetail[$x-1]->payrec_num,$modelDetail[$x-1]->doc_ref_num,$modelDetail[$x-1]->tal_id,$model->update_date,$model->update_seq,$x) > 0)$success = true;
									else {
										$success = false;
									}
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
				
						for($x=0; $success && $x<$cheqCount; $x++)
						{
							$modelCheq[$x]->rvpv_number = $model->payrec_num;
							
							if($modelCheq[$x]->save_flg == 'Y')
							{
								if($modelCheq[$x]->cancel_flg == 'Y')
								{
									//CANCEL
									if($success && $modelCheq[$x]->executeSp(AConstant::INBOX_STAT_CAN,$modelCheq[$x]->rvpv_number,$modelCheq[$x]->chq_seq,$modelCheq[$x]->chq_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}
								else if($modelCheq[$x]->rowid)
								{
									//UPDATE
									if($success && $modelCheq[$x]->executeSp(AConstant::INBOX_STAT_UPD,$modelCheq[$x]->rvpv_number,$modelCheq[$x]->chq_seq,$modelCheq[$x]->chq_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
									else {
										$success = false;
									}
								}			
								else 
								{
									//INSERT
									$modelCheq[$x]->seqno = $modelCheq[$x]->chq_seq = $currSeq++;
									
									if($success && $modelCheq[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelCheq[$x]->rvpv_number,$modelCheq[$x]->chq_seq,$modelCheq[$x]->chq_num,$model->update_date,$model->update_seq,$recordSeq) > 0)$success = true;
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
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$obj->redirect(array('index'));
					}
					else {
						$transaction->rollback();
					}
				}
			}
			else
			{
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
						foreach($modelLedger as $row)
						{
							if($row->check == 'Y')
							{
								$oldLedger = Taccountledger::model()->find("xn_doc_num = '$row->gl_ref_num' AND tal_id = '$row->tal_id'");
								
								$oldLedger->sett_for_curr = $oldLedger->sett_for_curr==null?0:$oldLedger->sett_for_curr;
								$oldLedger->sett_val = $oldLedger->sett_val==null?0:$oldLedger->sett_val;
								
								$oldOutsAmt = $oldLedger->curr_val - $oldLedger->sett_for_curr - $oldLedger->sett_val;
								
								if($oldLedger->reversal_jur != 'N' || ( round($oldOutsAmt,2) < round($row->old_outs_amt,2) ) )
								{
									Yii::app()->user->setFlash('error', 'Some of the transactions have been modified, please retrieve the transactions again');
									$valid = false;
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
									$modelDetailLedger[$x]->sl_acct_cd = $row->sl_acct_cd;
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
											if($modelDetailLedger[$x]->gl_acct_cd == $rowDetail->gl_acct_cd)
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
							$bankLedger->db_cr_flg = $balDebit > 0?'C':'D';
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
					
					for($x=0;$x<$ledgerCount;$x++)
					{
						$modelLedger[$x] = new Tpayrecd;
						$modelLedger[$x]->attributes = $_POST['Tpayrecdledger'][$x+1];
						$modelLedger[$x]->system_generated = 'Y';
						
						if($modelLedger[$x]->check == 'Y')
						{
							$modelLedger[$x]->payrec_date = $model->payrec_date;
							//$modelLedger[$x]->doc_tal_id = $modelLedger[$x]->tal_id;
							
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
							
							if($modelLedger[$x]->record_source == 'CDUE')
							{
								$modelLedger[$x]->doc_ref_num = $modelLedger[$x]->contr_num;
								//$modelLedger[$x]->tal_id = 1; 
								$modelLedger[$x]->doc_tal_id = 1;
							}
							else 
							{
								$modelLedger[$x]->doc_ref_num = $modelLedger[$x]->gl_ref_num;
							}
	
							$modelLedger[$x]->client_cd = $model->client_cd;
							
							switch($modelLedger[$x]->record_source)
							{
								case 'RD':	
								case 'PD':
								case 'ARAP':
									$modelLedger[$x]->record_source = 'PDRD';
									break;
								case 'RVO':
								case 'PVO':
									$modelLedger[$x]->record_source = 'PVRV';
									break;
								case 'CG':
									//if($modelLedger[$x]->budget_cd == 'BONDTRANS')
									//	$modelLedger[$x]->record_source = 'BOND';
									if($modelLedger[$x]->gl_acct_cd == 'KPEI')
										$modelLedger[$x]->record_source = 'KPEI';
									else if($modelLedger[$x]->gl_acct_cd == 'BROKER')
										$modelLedger[$x]->record_source = 'NEGO';
									
									break;
							}
							
							$modelLedger[$x]->doc_date = $modelLedger[$x]->contr_dt;
							$modelLedger[$x]->sett_for_curr = 0;
							$modelLedger[$x]->sett_val = 0;							
							
							$valid = $modelLedger[$x]->validate() && $valid;
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
								
									if($client)
									{
										$glAccount = Glaccount::model()->find("TRIM(gl_a) = '$glA' AND sl_a = '$slA'");
										$modelDetailLedger[$x]->acct_type = trim($glAccount->acct_type);
									}
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
								$modelLedger[$y]->client_cd = $model->client_cd;
								$modelLedger[$y]->tal_id = $modelLedger[$y]->doc_tal_id = $modelDetailLedger[$x]->tal_id;
								//$modelLedger[$y]->doc_ref_num = date('my').'ZZ1234567';
								$modelLedger[$y]->ref_folder_cd = $model->folder_cd;
								$modelLedger[$y]->doc_date = $model->payrec_date;
								$modelLedger[$y]->due_date = $model->payrec_date;
								
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
										$modelDetailLedger[$x]->gl_acct_cd = trim($modelDetailLedger[$x]->gl_acct_cd);
										
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
								$modelLedger[$y]->client_cd = $model->client_cd;
								$modelLedger[$y]->tal_id= $modelLedger[$y]->doc_tal_id = $row->tal_id;
								//$modelLedger[$y]->doc_ref_num = date('my').'ZZ1234567';
								$modelLedger[$y]->ref_folder_cd = $model->folder_cd;
								$modelLedger[$y]->doc_date = $model->payrec_date;
								$modelLedger[$y]->due_date = $model->payrec_date;
								
								$modelLedger[$y]->sett_for_curr = 0;
								$modelLedger[$y]->sett_val = 0;
								
								$modelLedger[$y]->check = 'Y';
								
								$valid = $modelLedger[$y]->validate() && $valid;
								
								$y++;
							}
						}
					}
						
					$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'CHECK' and param_cd2 ='ACCTBRCH'")->dflg1;
	
					if($check == 'Y')
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
					else {
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
					
					foreach($modelLedger as $row)
					{
						if($row->check == 'Y' && $row->system_generated == 'Y')
						{
							$oldLedger = Taccountledger::model()->find("xn_doc_num = '$row->gl_ref_num' AND tal_id = '$row->tal_id'");
							
							$oldLedger->sett_for_curr = $oldLedger->sett_for_curr==null?0:$oldLedger->sett_for_curr;
							$oldLedger->sett_val = $oldLedger->sett_val==null?0:$oldLedger->sett_val;
							
							$oldOutsAmt = $oldLedger->curr_val - $oldLedger->sett_for_curr - $oldLedger->sett_val;
							
							if($oldLedger->reversal_jur != 'N' || ( round($oldOutsAmt,2) < round($row->old_outs_amt,2) ) )
							{
								Yii::app()->user->setFlash('error', 'Some of the transactions have been modified, please retrieve the transactions again');
								$valid = false;
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
						if($model->rdi_pay_flg == 'Y')$model->acct_type = 'RDM';
						else
							$model->acct_type = $model->client_type;
						
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
						
							$result = DAO::queryRowSql("SELECT GET_DOCNUM_GL(TO_DATE('$oldModel->payrec_date','YYYY-MM-DD HH24:MI:SS'),'GL') AS REVERSE_DOC_NUM FROM dual");
							$reverseDocNum = $result['reverse_doc_num'];
							
							$result = DAO::queryRowSql("SELECT F_GET_FOLDER_NUM(TO_DATE('$oldModel->payrec_date','YYYY-MM-DD HH24:MI:SS'),'RJ-') AS REVERSE_FOLDER_CD FROM dual");
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
								
								if($row->doc_date)$row->doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->doc_date)->format('Y-m-d');
								if($row->due_date)$row->due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->due_date)->format('Y-m-d');
								if($row->netting_date)$row->netting_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->netting_date)->format('Y-m-d');
								if($row->arap_due_date)$row->arap_due_date = DateTime::createFromFormat('Y-m-d G:i:s',$row->arap_due_date)->format('Y-m-d');
														
								if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$row->xn_doc_num,$row->tal_id,$model->update_date,$model->update_seq,$detailLedgerSeq++) > 0)$success = true;
								else {
									$success = false;
								}
							}
							
							// INSERT T_JVCHH 
							
							$modelJvchh = new Tjvchh;
							$modelJvchh->jvch_num = $reverseDocNum;
							$modelJvchh->jvch_type = 'RE';
							$modelJvchh->jvch_date = $oldModel->payrec_date;
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
								$reverseModelFolder->fld_mon = DateTime::createFromFormat('Y-m-d',$oldModel->payrec_date)->format('my');
								$reverseModelFolder->folder_cd = $reverseFolderCd;
								$reverseModelFolder->doc_date = $oldModel->payrec_date;
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
										$row->gl_ref_num = $model->payrec_num;
										$row->doc_ref_num = $model->payrec_num;
									}
									if($success && $row->executeSp(AConstant::INBOX_STAT_INS,$row->payrec_num,$row->doc_ref_num,$row->tal_id,$model->update_date,$model->update_seq,$modelLedgerSeq++) > 0)$success = true;
									else {
										$success = false;
									}
								}
							}
							
							//T_ACCOUNT_LEDGER
							//$tal_id = 2;
							foreach($modelDetailLedger as $row)
							{
								if($row->cancel_flg != 'Y')
								{						
									$row->xn_doc_num = $row->rvpv_number = $model->payrec_num;
									$row->doc_ref_num = Sysparam::model()->find("param_id = 'SYSTEM' and param_cd1 = 'DOC_REF'")->dflg1=='Y'?$model->payrec_num:'';
									$row->xn_val = $row->curr_val;
									$row->reversal_jur = 'N';
									$row->manual = 'Y';
									
									if($model->int_adjust=='Y')$row->budget_cd = 'INTADJ';
									
									if($row->bank_flg == 'Y')
									{
										$row->tal_id = 555;	
									}
									/*else 
									{
										$row->tal_id = $tal_id++;
									}*/
																
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

							//$modelUpdated = array();
							$x = 0;

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
								
								$x = 1;
							
								$detailSeq = $temp;
								
								$modelDetailLedgerNonRev = Taccountledger::model()->findAll(array('condition'=>"xn_doc_num = '$id' AND approved_sts = 'A'",'order'=>"DECODE(record_source,'ARAP','VCH',record_source), tal_id"));
								
								foreach($modelDetailLedgerNonRev as $row)
								{
									// UPDATE FOLDER_CD, REMARKS
									$row->folder_cd = $model->folder_cd;
									$row->ledger_nar = $modelDetailLedger[$x-1]->ledger_nar;
									
									if($model->int_adjust=='Y')$row->budget_cd = 'INTADJ';
									
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
		}
		else
		{
			if($type == 'D')
			{
				$modelDetail = Tpayrecd::model()->findAll(array('select'=>'t.*, rowid','condition'=>"payrec_num = '$model->payrec_num' AND approved_sts = 'A'"));
				$modelLedger = Taccountledger::model()->findAll("xn_doc_num = '$model->payrec_num' AND approved_sts = 'A'");
				$modelCheq	 = Tcheq::model()->findAll(array('select'=>'t.*, rowid','condition'=>"rvpv_number = '$model->payrec_num' AND approved_stat = 'A'"));
				
				foreach($modelDetail as $row)
				{
					$row->old_tal_id = $row->tal_id;
					$row->gl_acct_cd = trim($row->gl_acct_cd);
				}
				
				$modelDetailFirst = new Tpayrecd;
				
				$arapFlg = false;
							
				foreach($modelLedger as $row)
				{
					if($row->sett_val > 0 || $row->sett_for_curr > 0)
					{
						$settled = true;
						break;
					}
					
					/*if(!$arapFlg)
					{
						$result = DAO::queryRowSql("SELECT client_cd FROM MST_CLIENT WHERE client_cd = '$row->sl_acct_cd'");
						
						if($result)$arapFlg = true;
					}*/
					
					if($row->tal_id == 555)
					{
						$modelDetailFirst->gl_acct_cd = $row->gl_acct_cd;
						$modelDetailFirst->sl_acct_cd = $row->sl_acct_cd;
						$modelDetailFirst->payrec_amt = $row->curr_val;
						$modelDetailFirst->db_cr_flg = $row->db_cr_flg=='D'?'DEBIT':'CREDIT';
						$modelDetailFirst->remarks = $row->ledger_nar;
					}
				}
				
				/*if(!$arapFlg)
				{
					if(DateTime::createFromFormat('Y-m-d',$oldPayrecDate)->format('Ymd') < date('Ymd'))$nonArapBackDated = true;
				}*/
				
				$modelDetail = array_merge(array($modelDetailFirst),$modelDetail);
			}	
			else 
			{
				//$modelLedger = Tpayrecd::model()->findAll("payrec_num = '$model->payrec_num'");
				$startDt = Sysparam::model()->find("param_id = 'VOUCHER ENTRY' AND param_cd1 = 'TRANS' AND param_cd2 = 'START_DT'")->ddate1;
				$modelLedger = Tpayrecd::model()->findAllBySql(Tpayrecd::getUpdateOutstandingArapSql($startDt, $model->payrec_date, $model->client_cd, $model->payrec_num));
				$modelDetailLedger = Taccountledger::model()->findAll(array('select'=>'t.*, rowid','condition'=>"xn_doc_num = '$model->payrec_num' AND approved_sts = 'A'",'order'=>"DECODE(record_source,'ARAP','VCH',record_source), tal_id"));
				$modelCheqLedger = Tcheq::model()->findAll(array('select'=>'t.*, rowid','condition'=>"rvpv_number = '$model->payrec_num' AND approved_stat = 'A'"));
				
				foreach($modelLedger as $key=>$row)
				{
					/*if($row->buy_sell_ind == 'B' || $row->buy_sell_ind == 'D')
					{
						$row->buy_sett_amt = 0;
					}
					else
					{
						$row->sell_sett_amt = 0;
					}*/
					
					//$settlePayrecdList = Tpayrecd::model()->findAll("doc_ref_num = '$row->contr_num' AND tal_id = '$row->tal_id' AND payrec_num <> '$id' AND approved_sts = 'A'");
					$settlePayrecdCurr = Tpayrecd::model()->find("payrec_num = '$id' AND doc_ref_num = '$row->contr_num' AND tal_id = '$row->tal_id' AND approved_sts = 'A'");
					
					/*foreach($settlePayrecdList as $row2)
					{
						$row->outs_amt -= $row2->payrec_amt;
					}*/
					
					if($settlePayrecdCurr)
					{
						$row->outs_amt += $settlePayrecdCurr->payrec_amt;
						
						if($row->buy_sell_ind == 'B' || $row->buy_sell_ind == 'D')
						{
							$row->sell_sett_amt = $settlePayrecdCurr->payrec_amt;
						}
						else 
						{
							$row->buy_sett_amt = $settlePayrecdCurr->payrec_amt;
						}
					}
					
					if(($row->buy_sett_amt + $row->sell_sett_amt) > 0)
					{
						$row->check = 'Y';
					}

					if($row->outs_amt == 0)unset($modelLedger[$key]);
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
					
					if($row->budget_cd == 'INTADJ')$model->int_adjust = 'Y';
				}
			}	
		}
		
		if($settled)
		{
			Yii::app()->user->setFlash('error', 'Update not allowed. This voucher has already been settled.');
			$obj->redirect(array('index'));
		}
		/*else if($nonArapBackDated)
		{
			Yii::app()->user->setFlash('error', 'Update not allowed. This voucher is non AR/AP and backdated.');
			$this->redirect(array('index'));
		}*/
		else if($pending)
		{
			Yii::app()->user->setFlash('error', 'Update not allowed. This client still has some pending transactions.');
			$obj->redirect(array('index'));
		}
		else {
			$obj->render('/tpayrech/update',array(
				'model'=>$model,
				'modelDetail'=>$modelDetail,
				'modelLedger'=>$modelLedger,
				'modelDetailLedger'=>$modelDetailLedger,
				'modelDetailLedgerNonRev'=>$modelDetailLedgerNonRev,
				'modelFolder'=>$modelFolder,
				'modelCheq'=>$modelCheq,
				'modelCheqLedger'=>$modelCheqLedger,
				'modelJvchh'=>$modelJvchh,
				'tempModel'=>$tempModel,
				'oldModel'=>$oldModel,
				'oldModelDetail'=>$oldModelDetail,
				'oldModelDetailLedger'=>$oldModelDetailLedger,
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
			
			if(isset($_POST['Tcheq']))
			{
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
			}
			
			Yii::app()->user->setFlash('success', 'Data Successfully Updated');
			$obj->redirect(array('index'));
		}
		else 
		{
			$modelDetail = Taccountledger::model()->findAll(array('select'=>'t.*, rowid',"condition"=>"xn_doc_num = '$id' AND approved_sts = 'A'",'order'=>"DECODE(record_source,'ARAP','VCH',record_source), tal_id"));
			$modelCheq = Tcheq::model()->findAll(array('select'=>'t.*, rowid',"condition"=>"rvpv_number = '$id' AND approved_stat = 'A'"));
			
			$model->rdi_pay_flg = trim($model->acct_type)=='RDM'?'Y':'N';
			$model->trf_ksei = trim($model->acct_type) == 'KSEI'?'Y':'N';
			$model->int_adjust = 'N';
			
			$bankAcct = Glaccount::model()->find("trim(gl_a) = trim('$model->gl_acct_cd') AND sl_a = '$model->sl_acct_cd'");
			
			if($bankAcct)$model->acct_name = $bankAcct->acct_name;
			
			if($model->client_cd)
			{
				$sql = "SELECT client_name, client_type_1||client_type_2||client_type_3 AS client_type, trim(branch_code) AS branch_code,
							b.cl_desc, DECODE(olt,'Y','OLT','') olt, DECODE(recov_charge_flg,'Y','2490','1422') recov_charge_flg,
							c.bank_cd, c.bank_acct_fmt, DECODE(c.acct_stat,'A','ACTIVE','INACTIVE') active,
							d.cif_name, e.bank_name client_bank, a.bank_acct_num
							FROM MST_CLIENT a 
							JOIN LST_TYPE3 b ON a.client_type_3 = b.cl_type3
							JOIN MST_CLIENT_FLACCT c ON a.client_cd = c.client_cd
							JOIN MST_CIF d ON a.cifs = d.cifs
							JOIN MST_IP_BANK e ON a.bank_cd = e.bank_cd
							WHERE a.client_cd = '$model->client_cd'
							AND c.acct_stat IN('A','I')";
				
				$client = DAO::queryRowSql($sql);
				
				if($client)
				{
					$model->client_type = $client['client_type'];
					$model->branch_code = $client['branch_code'];
					$model->client_name = $client['client_name'];
					$model->olt = $client['olt'];
					$model->client_type_3 = $client['cl_desc'];
					$model->recov_charge_flg = $client['recov_charge_flg'];
					$model->bank_cd = $client['bank_cd'];
					$model->bank_acct_fmt = $client['bank_acct_fmt'];
					$model->active = $client['active'];
				}
			}
			
			foreach($modelDetail as $row)
			{
				if($row->budget_cd == 'INTADJ')
				{
					$model->int_adjust == 'Y';
					break;
				}
			}
		}
		
		$obj->render('/tpayrech/update_remark',array(
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
		//$nonArapBackDated = FALSE;
		$reversal = TRUE;
		
		$modelDetailLedger = Taccountledger::model()->findAll(array('select'=>'t.*, rowid','condition'=>"xn_doc_num = '$id' AND approved_sts = 'A'",'order'=>"DECODE(record_source,'ARAP','VCH',record_source), tal_id"));	
		
		$arapFlg = false;
		
		foreach($modelDetailLedger as $row)
		{
			if($row->sett_val > 0 || $row->sett_for_curr > 0)
			{
				$settled = true;
				break;
			}
			
			/*if(!$arapFlg)
			{
				$result = DAO::queryRowSql("SELECT client_cd FROM MST_CLIENT WHERE client_cd = '$row->sl_acct_cd'");
				
				if($result)$arapFlg = true;
			}*/
		}
		
		/*if(!$arapFlg)
		{
			if(DateTime::createFromFormat('Y-m-d',$oldPayrecDate)->format('Ymd') < date('Ymd'))$nonArapBackDated = true;
		}*/
		
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];	
					
			if(!$settled  && $model->validate()){
				
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
					
					if($modelHeader->payrec_type == 'RD' || $modelHeader->payrec_type == 'PD')
					{
						if(!$originalReversalDate)
						{
							$arapFlg = false;
							
							foreach($reverseModelJournal as $row)
							{
								$result = DAO::queryRowSql("SELECT client_cd FROM MST_CLIENT WHERE client_cd = '$row->sl_acct_cd'");
								
								if($result)
								{
									$arapFlg = true;
									break;
								}
							}
							
							if(!$arapFlg)
							{
								$oldJournalDate = DateTime::createFromFormat('Y-m-d',$modelHeader->payrec_date)->format('Ymd');
							
								if($oldJournalDate < date('Ymd'))$reversalDate = date('Y-m-d');
							}
						}
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
				
				if(substr($modelHeader->payrec_type,1,1) == 'V')
				{
					foreach($modelDetail as $row)
					{
						if($row->record_source != 'VCH' && $row->record_source != 'ARAP')
						{
							$row->contr_num = $row->doc_ref_num;
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
			Yii::app()->user->setFlash('error', 'Cancel not allowed. This voucher has already been settled');
			$is_successsave = true;
		}
		/*else if($nonArapBackDated)
		{
			Yii::app()->user->setFlash('error', 'Cancel not allowed. This voucher is non AR/AP and backdated.');
			$is_successsave = true;
		}*/

		$obj->render('/tpayrech/_popcancel',array(
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

		if(isset($_GET['Tpayrech']))
			$model->attributes=$_GET['Tpayrech'];

		$obj->render('/tpayrech/index',array(
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
	
	public function checkCash($client_cd, $amt, &$ratio, &$message, &$block)
	{
		$valid = true;
		
 		$connection  = Yii::app()->db;
		
		$message_type;
		$ratio_txt;
		$error_code = -999;
		$error_msg;
				
		try{
			$query  = "CALL GET_RATIO_FO(
						:P_CLIENT_CD,
						'X',
						:P_AMT,
						0,
						0,
						:P_MESSAGE_TYPE,
						:P_RATIO,
						:P_RATIO_TXT,
						:P_ERROR_CODE,
						:P_ERROR_MSG
						)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_CLIENT_CD",$client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_AMT",$amt,PDO::PARAM_STR);	
					
			$command->bindParam(":P_MESSAGE_TYPE",$message_type,PDO::PARAM_STR,10);
			$command->bindParam(":P_RATIO",$ratio,PDO::PARAM_STR,10);
			$command->bindParam(":P_RATIO_TXT",$ratio_txt,PDO::PARAM_STR,200);
			$command->bindParam(":P_ERROR_CODE",$error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			
		}catch(Exception $ex){
			if($error_code = -999)
				$error_msg = $ex->getMessage();
		}
		
		if($error_code < 0)
		{
			$message = 'Fail to get ratio from FO '.$error_msg;
			$valid = false;
			$block = true;
		}
		else
		{
			if($ratio == -4)
			{
				$valid = false;
				$message = $ratio_txt;
				
				if($message_type == 0)
				{
					$block = false;
				}
				else 
				{
					$block = true;
				}
			}
		}
		
		return $valid;
	}
}
