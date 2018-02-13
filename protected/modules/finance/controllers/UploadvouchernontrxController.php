<?php

class UploadvouchernontrxController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
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
					WHERE client_cd = '$clientCd' 
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
	
	
	public function actionAjxGetClientDetail()
	{
		$model = array();
		
		if(isset($_POST['client']))
		{
			$client = $_POST['client'];
			
			$sql = "SELECT client_name, client_type_1||client_type_2||client_type_3 AS client_type, trim(branch_code) AS branch_code,
					b.cl_desc, DECODE(olt,'Y','OLT','') olt, DECODE(recov_charge_flg,'Y','2490','1422') recov_charge_flg,
					c.bank_cd, c.bank_acct_fmt, DECODE(c.acct_stat,'A','ACTIVE','INACTIVE') active,
					d.cif_name, e.bank_name client_bank, a.bank_acct_num
					FROM MST_CLIENT a 
					JOIN LST_TYPE3 b ON a.client_type_3 = b.cl_type3
					JOIN MST_CLIENT_FLACCT c ON a.client_cd = c.client_cd
					JOIN MST_CIF d ON a.cifs = d.cifs
					JOIN MST_IP_BANK e ON a.bank_cd = e.bank_cd
					WHERE a.client_cd = '$client'
					AND c.acct_stat IN('A','I')";
			
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
			
		/*	$sql = "SELECT trim(sl_a) AS sl_a, acct_name, b.BRCH_CD, 
			 		DECODE(trim(b.bank_acct_type),'R','Receipt', 'P','Payment','RP', 'Recv/Pay') RP
			 		FROM mst_gl_account g, mst_bank_acct b
			 		WHERE g.gl_a = RPAD('$glAcctCd',12)
					AND g.sl_a <> '000000'
					AND (g.acct_type = 'BANK' OR g.acct_type = 'KAS')
					AND TRIM(b.brch_cd) LIKE '$branchCode'
					AND g.sl_a = b.sl_acct_cd (+) 
					ORDER BY sl_a";
			*/		
			$sql1=" SELECT trim(sl_a) AS sl_a,
					  acct_name, b.BRCH_CD, 
					decode(trim(b.bank_acct_type),'R','Receipt', 'P','Payment','RP', 'Recv/Pay') RP
					  FROM mst_gl_account g, mst_bank_acct b
					  WHERE g.gl_a = RPAD('$glAcctCd',12)
					    AND g.sl_a <> '000000'
					    AND (g.acct_type = 'BANK' OR g.acct_type = 'KAS')
						AND g.gl_a = b.gl_acct_cd (+) 
					   AND g.sl_a = b.sl_acct_cd (+) 
					  ORDER BY sl_a"	;
			$model = DAO::queryAllSql($sql1);
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
			
			$sql = "SELECT bank_cd
					FROM MST_CLIENT_BANK
			 		WHERE client_cd = '$clientCd'
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
			
			if($rdi == 'Y')
			{
				$from_bank = $_POST['rdi_bank'];
				$sql = "SELECT IP_BANK_CD FROM MST_FUND_BANK WHERE BANK_CD = '$from_bank'";
				
				$result = DAO::queryRowSql($sql);
				
				if($result)$from_bank = $result['ip_bank_cd'];
			}
			else
			{
				$from_bank = Bankacct::model()->find("TRIM(gl_acct_cd) = '$glAcctCd' AND sl_acct_cd = '$slAcctCd'")->bank_cd;
			}

			
			$sql = "SELECT F_TRANSFER_FEE('$amt','$from_bank','$to_bank','$brch_cd','$olt','$rdi','$slAcctCd') transfer_fee FROM dual";
			
			$model = DAO::queryRowSql($sql);
		}
		
		echo json_encode($model);
	}
	public function actionIndex()
	{	
		$modelupload = new Tpayrech();
		$modelFolder = new Tfolder;
		$model = new Tpayrech;
		$model->payrec_type = 'RD';
		$modeldetail=array();
		$modeldetail[0] = new Taccountledger;
		$modelcheq=array();
		
		$success=false;
		
		$import_type;
		$filename = '';
		$valid = TRUE;
		$success = false;
		$cancel_reason = '';
	
			
		if(isset($_POST['scenario']))
		{ 
			if($_POST['scenario'] =='import'){
					
			$modelupload->attributes = $_POST['Tpayrech'];
			$modelupload->scenario='upload';
			if($modelupload->validate()){
			
		
			//buat ambil file yang di upload tanpa $_FILES
			$modelupload->file_upload = CUploadedFile::getInstance($modelupload,'file_upload');
			
			$path = FileUpload::getFilePath(FileUpload::T_PAYRECH,'Upload.txt' );
			$modelupload->file_upload->saveAs($path);
			$filename = $modelupload->file_upload;
				
			//insert data 
			$lines = file($path);
			$x=1;
			foreach ($lines as $line_num => $line) 
			{	$modeldetail[$x] = new Taccountledger;
				$modeldetail[0] = new Taccountledger;
					$pieces = explode("\t",$line);
					if(count($pieces)<5)
					{
						Yii::app()->user->setFlash('danger', 'Failed upload file');
						$this->redirect(array('index'));
						break;
					}
					$modeldetail[$x]->gl_acct_cd= $pieces[0];
					$modeldetail[$x]->sl_acct_cd= $pieces[1];
					$modeldetail[$x]->ledger_nar= $pieces[2];
					$modeldetail[$x]->db_cr_flg = $pieces[3];
					$modeldetail[$x]->curr_val= $pieces[4];
				$x++;	
				}
			
				//setelah di upload dan dibaca, delete file nya
			//unlink(FileUpload::getFilePath(FileUpload::IMPORT_REK_DANA,$filename ));
			Yii::app()->user->setFlash('success', 'Successfully upload '.$filename);
			//$this->redirect(array('index'));
			
			}
			}
				//save
				else{
					
					$rowCount = $_POST['rowCount'];
					$cheqCount =$_POST['cheqCount'];
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					$menuName = 'UPLOAD VOUCHER NON TRANSAKSI';
					
					
					$model= new Tpayrech;
					$modelpayrecd = array();
					
					$model->attributes = $_POST['Tpayrech'];
					 if(DateTime::createFromFormat('d/m/Y',$model->payrec_date))$model->payrec_date=DateTime::createFromFormat('d/m/Y',$model->payrec_date)->format('Y-m-d');
					$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'VCH_REF' ")->dflg1;
		
					$model->curr_amt = str_replace( ',', '', $model->curr_amt);
					if($check == 'N')$model->folder_cd = ''; 
						//validate t payrech
					$valid = $model->validate() && $valid;
					
					
					//validate t account ledger
				for($x=0;$x<$rowCount;$x++)
				{
					
						$modeldetail[$x] = new Taccountledger;
						$modeldetail[$x]->attributes=$_POST['Taccountledger'][$x+1];
						//if($modeldetail[$x]->gl_acct_cd == 'N/A')$modeldetail[$x]->gl_acct_cd = 'na';
						if($modeldetail[$x]->db_cr_flg == 'DEBIT')$modeldetail[$x]->db_cr_flg = 'D';
						if($modeldetail[$x]->db_cr_flg == 'CREDIT')$modeldetail[$x]->db_cr_flg = 'C';
						//validate account code
						$gl_a = trim($modeldetail[$x]->gl_acct_cd);
						$sl_a = trim($modeldetail[$x]->sl_acct_cd);
						$cek = Glaccount::model()->find("trim(gl_a) = '$gl_a' and sl_a = '$sl_a' and prt_type <>'S' and acct_stat='A' and approved_stat='A' ");
											
						$valid = $modeldetail[$x]->validate() && $valid;
						
						if(!$cek)
						{	$valid=false;
							$modeldetail[$x]->addError('gl_acct_cd','Account code not found in chart of account');
						}
					
				}
				
				$bank = Bankacct::model()->find("sl_acct_cd = '$model->sl_acct_cd' AND TRIM(gl_acct_cd) = '$model->gl_acct_cd'");
				
					//validate t cheq
					for($x=0;$x<$cheqCount;$x++)
				{
					
						$modelcheq[$x] = new Tcheq;
						$modelcheq[$x]->attributes=$_POST['Tcheq'][$x+1];

						if($bank)$modelcheq[$x]->bank_cd = $bank->bank_cd;
						$modelcheq[$x]->sl_acct_cd = $model->sl_acct_cd;
						$modelcheq[$x]->chq_stat = 'A';
						$modelcheq[$x]->payee_bank_cd = $model->client_bank_cd;
						$modelcheq[$x]->payee_acct_num = $model->client_bank_acct;
						$modelcheq[$x]->seqno = $x+1;
						$modelcheq[$x]->chq_seq = $x+1;
						$modelcheq[$x]->payee_name = $model->payrec_frto;
						$valid = $modelcheq[$x]->validate() && $valid;
					
				}
					
				
					
					$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'CHECK' and param_cd2 ='ACCTBRCH'")->dflg1;
		
					if($check == 'Y')
					{
						$brch_cd = '';
						$x = 0;
						foreach($modeldetail as $row)
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
									$row->addError('gl_acct_cd','All journal must have GL Account and SL Account of the same branch');
									break;
								}
							}	
							
							$x++;
						}	
					}
			
					$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'CHEQ' AND param_cd2 = 'RV'")->dflg1;
					
					if($check == 'N' ){
						if($model->payrec_type == 'RD' && $cheqCount > 0){
						Yii::app()->user->setFlash('danger', 'Cheque is only used for payment ');
						$success=FALSE;
						$valid=false;
						}
						
					}
					$date=date('Y-m-d',strtotime(' -1 month'));
					
					
					if($model->payrec_date != "" || $model->payrec_date != null){
					
					$x_date=DateTime::createFromFormat('Y-m-d',$model->payrec_date)->format('Y-m-d');
					
					if($x_date < $date){
						$model->addError('payrec_date', 'Cannot set date last month');
						$success=FALSE;
						$valid=FALSE;
					}
					}
					
					
					
					
					
					if($_POST['balance'] !=0){
						$debit=$_POST['debit'];
						$credit=$_POST['credit'];
						Yii::app()->user->setFlash('danger', 'Amount not balance, your debit : ' .$debit .' and credit : '.$credit );
						$success=FALSE;
						$valid=false;
					}
					
					$payrec_type = $payrec_amt = '';
					$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'VCH_REF' ")->dflg1;
					if($model->gl_acct_cd==''){
						$model->addError('gl_acct_cd', "Gl Acct not found in chart of account");
					}
					else{
					$cekFolder=Glaccount::model()->find("trim(gl_a) = trim('$model->gl_acct_cd') and sl_a =  '$model->sl_acct_cd' AND prt_type <> 'S' AND acct_stat = 'A' AND approved_stat = 'A'");	
					}
					
					
					
					
					if($cekFolder){
						$acct_type= $cekFolder->acct_type;
						if($acct_type == 'BANK'){
							if($check == 'Y')
						{
						$payrecFlg = 'RD';
						
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
						
					}
					
					
					
					
					
				if($valid){	
				
					
						
					$sql="select get_docnum_vch(to_date('$model->payrec_date','yyyy-mm-dd'),'$model->payrec_type') as payrec_num from dual";
					$payrec=DAO::executeSql($sql);
					$payrec_num=$payrec['payrech_num'];
					$model->payrec_num= $payrec_num;
					$model->reversal_jur='N';
					
					if($model->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0)$success = true;
					
					
						//if($model->rdi_pay_flg == 'Y')$model->acct_type = 'RDM';
						//else if($model->trf_ksei == 'Y')$model->acct_type = 'KSEI';
						//else
							//$model->acct_type = $model->client_type;
						
						$model->num_cheq = count($modelcheq)>0?1:0;
						/*
						$check = Parameter::model()->find("prm_cd_1 = 'BNKFLG' AND prm_cd_2 = '$model->gl_acct_cd'");
						if($check)
						{
							if($check->prm_desc2 == 'Y')
							{
								$model->curr_cd = Bankacct::model()->find("TRIM(gl_acct_cd) = '$model->gl_acct_cd' AND sl_acct_cd = '$model->sl_acct_cd'")->curr_cd;
							}
						}
						
						 * 
						 */
					$model->curr_cd='IDR';
					//$model->remarks = str_replace("'", "''", $model->remarks);
					
					if($success && $model->executeSp(AConstant::INBOX_STAT_INS, $model->payrec_num, 1)>0){$success=TRUE;}
					else{
						$success=FALSE;
					}
					
					
					for($x=0;$success && $x<$rowCount;$x++){
						//T ACCOUNT LEDGER
						
						
						$glA = $modeldetail[$x]->gl_acct_cd;
						$slA = $modeldetail[$x]->sl_acct_cd;
						$client = Client::model()->find(array('select'=>'client_cd','condition'=>"client_cd = '$slA'"));
						
						$modeldetail[$x]->xn_doc_num = $model->payrec_num;
						$modeldetail[$x]->tal_id= $x==0?555:$x+1;
						$modeldetail[$x]->reversal_jur ='N';
						$modeldetail[$x]->manual='Y';
						if($model->trf_ksei == 'Y')$modeldetail[$x]->budget_cd = 'KSEIVCH';
							else 
								$modeldetail[$x]->budget_cd = substr($model->payrec_type,0,1).'VCH';
						$modeldetail[$x]->doc_ref_num = Sysparam::model()->find("param_id = 'SYSTEM' and param_cd1 = 'DOC_REF'")->dflg1=='Y'?$model->payrec_num:'';
						$modeldetail[$x]->acct_type =$model->client_type;
						$modeldetail[$x]->curr_cd= 'IDR';
						$modeldetail[$x]->brch_cd =$model->branch_code;;
						$modeldetail[$x]->netting_date = $model->payrec_date;
						//$modeldetail[$x]->netting_flg = '';
						$modeldetail[$x]->doc_date = $model->payrec_date;
						$modeldetail[$x]->due_date = $model->payrec_date;
						$modeldetail[$x]->xn_val = $modeldetail[$x]->curr_val;
						$modeldetail[$x]->record_source = $model->payrec_type;
						$modeldetail[$x]->sett_val =0;
						$modeldetail[$x]->sett_for_curr = 0;
						$modeldetail[$x]->sett_status = $x==0?'':'N';
						$modeldetail[$x]->rvpv_number =$model->payrec_num;
						$modeldetail[$x]->arap_due_date = $model->payrec_date;
						$modeldetail[$x]->user_id = $model->user_id;
						$modeldetail[$x]->update_date = $model->update_date;
						$modeldetail[$x]->update_seq = $model->update_seq;
						$modeldetail[$x]->folder_cd= $model->folder_cd;
						$modeldetail[$x]->ledger_nar =  $modeldetail[$x]->ledger_nar;
						if($model->trf_ksei == 'Y')$modeldetail[$x]->budget_cd = 'KSEIVCH';
							else 
								$modeldetail[$x]->budget_cd = substr($model->payrec_type,0,1).'VCH';
						
					
					
						if($success && $modeldetail[$x]->executeSp(AConstant::INBOX_STAT_INS,$modeldetail[$x]->xn_doc_num,$modeldetail[$x]->tal_id,$model->update_date,$model->update_seq,$x+1) > 0)$success = true;
							else {
								$success = false;
							}
							
							if($x > 0){
					//T PAYRECD
						$modelpayrecd[$x]= new Tpayrecd;	
						$modelpayrecd[$x]->payrec_num =  $model->payrec_num;
						$modelpayrecd[$x]->gl_ref_num =  $model->payrec_num;
						$modelpayrecd[$x]->payrec_type = $model->payrec_type;
						$modelpayrecd[$x]->gl_ref_num=$model->payrec_num;
						$modelpayrecd[$x]->payrec_date = $model->payrec_date;
						$modelpayrecd[$x]->client_cd = $model->client_cd;
						$modelpayrecd[$x]->brch_cd = $model->branch_code;
						$modelpayrecd[$x]->gl_acct_cd = $modeldetail[$x]->gl_acct_cd;
						$modelpayrecd[$x]->sl_acct_cd = $modeldetail[$x]->sl_acct_cd;
						$modelpayrecd[$x]->db_cr_flg = $modeldetail[$x]->db_cr_flg;
						$modelpayrecd[$x]->payrec_amt = $modeldetail[$x]->curr_val;
						$modelpayrecd[$x]->user_id=$model->user_id;
						$modelpayrecd[$x]->doc_ref_num =  $model->payrec_num;
						$modelpayrecd[$x]->tal_id =$x+1;
						$modelpayrecd[$x]->remarks=$modeldetail[$x]->ledger_nar;
						$modelpayrecd[$x]->record_source = $client?Sysparam::model()->find("param_id = 'VOUCHER ENTRY' and param_cd1 = 'SOURCE' AND param_cd2 = 'ARAP'")->dstr1:'VCH';
						$modelpayrecd[$x]->doc_date = $model->payrec_date;
						$modelpayrecd[$x]->due_date = $model->payrec_date;
						$modelpayrecd[$x]->ref_folder_cd= $model->folder_cd;
						$modelpayrecd[$x]->gl_ref_num = $model->payrec_num;
						$modelpayrecd[$x]->sett_for_curr = 0;
						$modelpayrecd[$x]->sett_val=0;
						$modelpayrecd[$x]->brch_cd = $model->branch_code;
						$modelpayrecd[$x]->doc_tal_id =$modeldetail[$x]->tal_id;
						$modelpayrecd[$x]->cre_dt = $model->cre_dt;
						
						if($success && $modelpayrecd[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelpayrecd[$x]->payrec_num,$modelpayrecd[$x]->doc_ref_num,$modelpayrecd[$x]->tal_id,$model->update_date,$model->update_seq,$x+1)){
							$success=TRUE;
						}
						else{
							$success=FALSE;
						}
						}
						
					}
					
					
					
					if($model->payrec_type =='PD'){
					//T CHEQ
					for($y=0;$success && $y<$cheqCount;$y++){
					
						$modelcheq[$y]->rvpv_number=$model->payrec_num;
						$modelcheq[$y]->seqno = $modelcheq[$y]->chq_seq = $y+1;
						
					if($success && $modelcheq[$y]->executeSp(AConstant::INBOX_STAT_INS,$modelcheq[$y]->rvpv_number,$modelcheq[$y]->chq_seq,$modelcheq[$y]->chq_num,$model->update_date,$model->update_seq,$y+1)){
						$success=true;
					}
					else{
						$success=false;
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
					
					
					if($success)
					{
						$transaction->commit();							
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/finance/Uploadvouchernontrx/index'));
					}
					else {
						$transaction->rollback();
					}
				}//end valid

 if(DateTime::createFromFormat('Y-m-d',$model->payrec_date))$model->payrec_date=DateTime::createFromFormat('Y-m-d',$model->payrec_date)->format('d/m/Y');

				}//end save
			}//end scenario
			
			

		$this->render('index',array(
			'modelupload'=>$modelupload,
			'model'=>$model,
			'modeldetail'=>$modeldetail,
			'modelcheq'=>$modelcheq
		));
	}

	
}
