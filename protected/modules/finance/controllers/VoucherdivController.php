<?php

class VoucherdivController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	public function actionCek_Voucher(){
		$resp['status']='error';
		$cek_pape = Sysparam::model()->find("param_id='VOUCHER_DIVIDEN' AND PARAM_CD1='PAPE' ")->dflg1;
		$cek_branch = Sysparam::model()->find("param_id='VOUCHER_DIVIDEN' AND PARAM_CD1='BRANCH' and param_cd2='ALL'")->dflg1;
		
		if(isset($_POST['stk_cd']) && isset($_POST['today_date']))
		{	$stk_cd = $_POST['stk_cd'];
			$today_date = $_POST['today_date'];
			$cum_date = $_POST['cum_date'];
			$date = DateTime::createFromFormat('d/m/Y',$today_date)->format('dmy');
			$cek =Tpayrech::model()->find("acct_type = 'DIV' and payrec_date = decode('$cek_pape','Y',to_date('$cum_date','dd/mm/yyyy'),to_date('$today_date','dd/mm/yyyy')) and  			
									client_cd =decode('$cek_branch','Y','$stk_cd','$stk_cd'||'$date')			
									and approved_sts ='A'");
		//(substr(client_cd,1,4) = '$stk_cd' or substr(client_cd,3,4) = '$stk_cd' )										
			if($cek)
			{
				$resp['status']='success';
			}							
		}
		echo json_encode($resp);
	}
		
		
	public function actionCek_cum_date(){
		$resp['status']='error';
		if(isset($_POST['stock_code']))
		{
			$stock_cd = $_POST['stock_code'];
			
			$stk_cd = Tcorpact::model()->find(array('condition'=>"stk_cd='$stock_cd' and ca_type = 'CASHDIV' and APPROVED_STAT='A'  ",'order'=>'distrib_dt desc'));
			
			$cum_dt = $stk_cd->cum_dt;
			$recording_dt = $stk_cd->recording_dt;
			$distrib_dt = $stk_cd->distrib_dt;
			
			if(DateTime::createFromFormat('Y-m-d H:i:s',$cum_dt))$cum_dt= DateTime::createFromFormat('Y-m-d H:i:s',$cum_dt)->format('d/m/Y');
			if(DateTime::createFromFormat('Y-m-d H:i:s',$recording_dt))$recording_dt= DateTime::createFromFormat('Y-m-d H:i:s',$recording_dt)->format('d/m/Y');
			if(DateTime::createFromFormat('Y-m-d H:i:s',$distrib_dt))$distrib_dt= DateTime::createFromFormat('Y-m-d H:i:s',$distrib_dt)->format('d/m/Y');
				
			$resp['cum_dt'] = $cum_dt;
			$resp['recording_dt'] = $recording_dt;
			$resp['distrib_dt'] = $distrib_dt;
			$resp['status']='success';
		}
		echo json_encode($resp);
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
	public function actionIndex()
	{
		//$account_code = Sysparam::model()->find("param_id='VOUCHER_DIVIDEN' AND PARAM_CD1='GL_ACCT' AND PARAM_CD2='BANK'");
		//$account_code_hutang = Sysparam::model()->find("param_id='VOUCHER_DIVIDEN' AND PARAM_CD1='GL_ACCT' AND PARAM_CD2='HUTANG'");
		$gl_acct = Sysparam::model()->find("param_id='VOUCHER_DIVIDEN' AND PARAM_CD1='GL_ACCT' AND PARAM_CD2='PORTO'");
		$stk_cd = Tcorpact::model()->findAllBySql("select STK_CD from t_corp_act where ca_type='CASHDIV' AND cum_dt > trunc(sysdate) - 40 AND APPROVED_STAT='A' ORDER BY STK_CD");
		$cek_pape = Sysparam::model()->find("param_id='VOUCHER_DIVIDEN' AND PARAM_CD1='PAPE' ")->dflg1;
		$cek_branch = Sysparam::model()->find("param_id='VOUCHER_DIVIDEN' AND PARAM_CD1='BRANCH' and param_cd2='ALL'")->dflg1;
		$default_branch = Sysparam::model()->find("param_id='VOUCHER_DIVIDEN' and param_cd1='GL_ACCT' AND PARAM_CD2='BANK'")->param_cd3;
		$company = Company::model()->find()->other_1;
		$company_cd =trim($company);
		$model = new Tcashdividen;
		$model->type_vch = 'RD';
		$modelheader = new Tcashdividen;
	//	$modelheader->gl_acct_cd= $account_code->dstr1;
	//	$modelheader->sl_acct_cd= $account_code->dstr2;
		/*
		if($cek_pape=='Y')
		{
			$modelheader->gl_acct_cd= $account_code_hutang->dstr1;
			$modelheader->sl_acct_cd= $account_code_hutang->dstr2;
		}
		 * 
		 */
		$modeldetail = array();
		$modeldetail[0] = new Tpayrecd;
		$modelpayrech = new Tpayrech;
		$modelledger =array();
		$modelFolder = new Tfolder;
		$modelCashDIv = array();
		
		if(isset($_POST['scenario'])){
			$scenario = $_POST['scenario'];
				
			if($scenario == 'filter')
			{
				$modelheader->scenario = 'generate';
				$model->attributes = $_POST['Tcashdividen'];
				if($model->type_vch =='RD')
				{
								
					if(DateTime::createFromFormat('d/m/Y',$model->cum_date1))$model->cum_date1 = DateTime::createFromFormat('d/m/Y',$model->cum_date1)->format('Y-m-d');
					if(DateTime::createFromFormat('d/m/Y',$model->today_date))$model->today_date = DateTime::createFromFormat('d/m/Y',$model->today_date)->format('Y-m-d');
					if(DateTime::createFromFormat('d/m/Y',$model->recording_dt))$model->recording_dt = DateTime::createFromFormat('d/m/Y',$model->recording_dt)->format('Y-m-d');
					//JIKA DICENTANG CUM DATE
					if($model->check == 0 || ($model->check==1 && $cek_pape=='N'))
					{ //echo "<script>alert('test')</script>";
						$sql1 = "SELECT STK_CD,CUM_DATE,distrib_dt FROM T_CASH_DIVIDEN a, mst_client b 
								WHERE STK_CD = '$model->stock_code' AND CUM_DATE= to_date('$model->cum_date1','yyyy-mm-dd')
								AND distrib_dt =  to_date('$model->today_date','yyyy-mm-dd')
								and a.client_cd=b.client_cd and trim(b.branch_code) like decode('$cek_branch','Y','%','$model->brch_cd')";
						$modelheader = Tcashdividen::model()->findBySql($sql1);
					}
						//JIKA DICENTANG TODAY/PAYMENT DATE
					else if($model->check == 1 && $cek_pape=='Y')
					{	//echo "<script>alert('test')</script>";
						$sql1 = "SELECT STK_CD,CUM_DATE,distrib_dt,selisih_qty FROM T_CASH_DIVIDEN a, mst_client b
								WHERE STK_CD = '$model->stock_code' AND CUM_DATE= to_date('$model->cum_date1','yyyy-mm-dd')
								and selisih_qty <> 0
								AND distrib_dt =  to_date('$model->today_date','yyyy-mm-dd')
								and a.client_cd=b.client_cd and trim(b.branch_code) like decode('$cek_branch','Y','%','$model->brch_cd') ";
						$modelheader = Tcashdividen::model()->findBySql($sql1);
					}
					else{
						//$model->addError('check_cum_date','No data voucher');
						$modelheader=null;
					}
					
					if($modelheader)
					{
						//SET ACCOUNT BANK
						$account_code = Sysparam::model()->find("param_id='VOUCHER_DIVIDEN' AND PARAM_CD1='GL_ACCT' AND PARAM_CD2='BANK' AND
										PARAM_CD3 LIKE '%$model->brch_cd' ");
							
						if($cek_pape=='Y')
						{
							$modelheader->vch_date = $model->cum_date1;
							//$modelheader->vch_date = date('d/m/Y');
						}	
						else
						{
							$modelheader->vch_date = $model->today_date;
						}
						
						$rate = Tcashdividen::model()->find("stk_cd='$model->stock_code' and cum_date= to_date('$model->cum_date1','yyyy-mm-dd')")->rate;
						$modelheader->scenario = 'generate';
						$modelheader->gl_acct_cd= $account_code->dstr1;
						$modelheader->sl_acct_cd= $account_code->dstr2;
						/*
						if($cek_pape=='Y')
						{
							$modelheader->gl_acct_cd= $account_code_hutang->dstr1;
							$modelheader->sl_acct_cd= $account_code_hutang->dstr2;
						}
						 * 
						 */
						$modelheader->stk_cd = $model->stock_code;
						$modelheader->cum_date =  $model->cum_date1;
						$modelheader->remarks = 'DIV '.$model->stock_code.' @'.$rate;
						$modelheader->branch_cd = $model->brch_cd;
						/*
						$account = "select trim(gl_a) gl_a from v_gl_acct_type where acct_type='T3'";
						$gl_a = DAO::queryRowSql($account);
						$gl_a = $gl_a['gl_a'];
						*/
						if($model->check ==0 || ($model->check==1 && $cek_pape=='N'))
						{ 
							$detail = "SELECT DECODE(A.CLIENT_CD,'$company_cd','$gl_acct->dstr1',trim(F_GL_ACCT_T3_JAN2016(a.CLIENT_CD,'C'))) GL_ACCT_CD, 
										decode(a.CLIENT_CD,'$company_cd','$gl_acct->dstr2',a.client_cd) SL_ACCT_CD, DIV_AMT PAYREC_AMT,
									'C' DB_CR_FLG, 'DIV '|| stk_cd ||' ' ||trim(to_char(qty,'9,999,999,999,999,999')) ||' @'||RATE REMARKS, selisih_qty FROM T_CASH_DIVIDEN a, mst_client b
									where stk_cd = '$model->stock_code' and cum_date = to_date('$model->cum_date1','yyyy-mm-dd') 
									and distrib_dt = to_date('$model->today_date','yyyy-mm-dd') 
									and a.client_cd=b.client_cd and trim(b.branch_code) like decode('$cek_branch','Y','%','$model->brch_cd')
									 order by a.client_cd ";
						}
						else if($model->check == 1 && $cek_pape=='Y')
						{
						$detail = "SELECT  DECODE(A.CLIENT_CD,'$company_cd','$gl_acct->dstr1',trim(F_GL_ACCT_T3_JAN2016(a.CLIENT_CD,'C'))) GL_ACCT_CD, 
										decode(a.CLIENT_CD,'$company_cd','$gl_acct->dstr2',a.client_cd) SL_ACCT_CD, DIV_AMT PAYREC_AMT,
									'C' DB_CR_FLG, 'DIV '|| stk_cd ||' ' ||trim(to_char(qty,'9,999,999,999,999,999')) ||' @'||RATE REMARKS, selisih_qty FROM T_CASH_DIVIDEN a, mst_client b 
									where stk_cd = '$model->stock_code' and cum_date = to_date('$model->cum_date1','yyyy-mm-dd')
									and distrib_dt = to_date('$model->today_date','yyyy-mm-dd') 
									and a.client_cd=b.client_cd and trim(b.branch_code) like decode('$cek_branch','Y','%','$model->brch_cd') 
									and selisih_qty <> 0 order by a.client_cd ";
						}
						
						else{
							$modeldetail=null;
						}
						
						$modeldetail = Tpayrecd::model()->findAllBySql($detail);
						$newdetail= new Tpayrecd;
						$newdetail->db_cr_flg ='DEBIT';
						$newdetail->payrec_amt =$modelheader->div_amt;
						$newdetail->gl_acct_cd =  $modelheader->gl_acct_cd;
						$newdetail->sl_acct_cd = $modelheader->sl_acct_cd; 
						$modeldetail=array_merge(array($newdetail),$modeldetail);
						foreach($modeldetail as $row)
						{
								$row->db_cr_flg ='C';
						}
						
						
					}//end IF MODEL HEADER
		
					else
					{
						Yii::app()->user->setFlash('danger','No data found');
						$modelheader = new Tcashdividen;
							
					}
				}
				else
				{
						Yii::app()->user->setFlash('danger','Voucher Type Not Found');
						$modelheader = new Tcashdividen;
				}
			
			}//END IF SCENARIO FILTER
			else//save
			{
						
				$detailCount = $_POST['detailCount'];
				$valid = true;
				$success = false;
				$modelheader = new Tcashdividen;
				$modelheader->scenario='generate';
				$modelheader->attributes = $_POST['Tcashdividen'];	
				
				$valid = $modelheader->validate() && $valid;	
				
					
				for($x=0;$x<$detailCount ;$x++)
				{
					$modeldetail[$x] = new Tpayrecd;
					$modeldetail[$x]->attributes=$_POST['Tpayrecd'][$x+1];
					if($modeldetail[$x]->db_cr_flg == 'DEBIT') $modeldetail[$x]->db_cr_flg = 'D';
					if($modeldetail[$x]->db_cr_flg == 'CREDIT') $modeldetail[$x]->db_cr_flg = 'C';
			
					$valid = $modeldetail[$x]->validate() && $valid;
				}
					
				$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'CHECK' and param_cd2 ='ACCTBRCH'")->dflg1;
		
				if($check == 'Y')
				{
					$brch_cd = '';
					$x = 0;
					foreach($modeldetail as $row)
					{
							$sql = "SELECT check_acct_branch('$row->gl_acct_cd','$row->sl_acct_cd') brch_cd FROM dual";
							$branch_cmp = DAO::queryRowSql($sql);
							$brch_cd_cmp = trim($branch_cmp['brch_cd']);

							if($x==0)$brch_cd=$brch_cd_cmp;
							
							if($brch_cd != $brch_cd_cmp)
							{
								$valid = false;
								$row->addError('gl_acct_cd','All journal must have GL Account and SL Account of the same branch');
								break;
							}
							
						$x++;
					}	
				}
				
			
				
				if($valid)
				{
					
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					$menuName = 'GENERATE RECEIPT DIVIDEN VOUCHER';
					$modelpayrech = new Tpayrech;	
					$modelledger=array();
					
					
					//$modelheader->attributes = $_POST['Tcashdividen'];			
					
					
					if(DateTime::createFromFormat('d/m/Y',$modelheader->vch_date))$modelheader->vch_date = DateTime::createFromFormat('d/m/Y',$modelheader->vch_date)->format('Y-m-d');
					if(DateTime::createFromFormat('Y-m-d H:i:s',$modelheader->distrib_dt))$modelheader->distrib_dt = DateTime::createFromFormat('Y-m-d H:i:s',$modelheader->distrib_dt)->format('Y-m-d');		
					if(DateTime::createFromFormat('d/m/Y',$modelheader->cum_date))$modelheader->cum_date = DateTime::createFromFormat('d/m/Y',$modelheader->cum_date)->format('Y-m-d');
					
					if($modelheader->executeSpHeader(AConstant::INBOX_STAT_INS, $menuName)>0)
					{
						$success=true;
					}
					else
					{
						$success=false;
					}
						//execute header of jurnal
						$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'VCH_REF' ")->dflg1;
						if($check == 'N')
						{
						$modelpayrech->folder_cd = '';
						}
						else
						{
						$modelpayrech->folder_cd = $modelheader->file_no;	
						} 
					
					
						$branch_all= Sysparam::model()->find("param_id='VOUCHER_DIVIDEN' and param_cd1='GL_ACCT' AND PARAM_CD2='BANK'")->param_cd3;
						$brch_cd = $cek_branch=='Y'?$branch_all:$modelheader->branch_cd;
						//UNTUK PF
						$date_client = '';
						if($cek_branch =='N')
						{
						$date_client = DateTime::createFromFormat('Y-m-d',$modelheader->vch_date)->format('dmy');
						}
						
						
						$modelpayrech->acct_type = 'DIV';	
						$modelpayrech->payrec_type = 'RD';
						$modelpayrech->payrec_date = $modelheader->vch_date;
						$modelpayrech->client_cd = $brch_cd.$modelheader->stk_cd.$date_client;
						$modelpayrech->sl_acct_cd = $modelheader->sl_acct_cd;
						$modelpayrech->gl_acct_cd = $modelheader->gl_acct_cd;
						$modelpayrech->curr_cd='IDR';
						$modelpayrech->curr_amt = $modelheader->div_amt;
						$modelpayrech->remarks=$modelheader->remarks;
						$modelpayrech->user_id = $modelheader->user_id;
						$modelpayrech->update_date = $modelheader->update_date;
						$modelpayrech->update_seq = $modelheader->update_seq;
						$modelpayrech->num_cheq = 0;
						
						$modelpayrech->reversal_jur='N';
						if($success && $modelpayrech->validate(null,false) && $modelpayrech->executeSp(AConstant::INBOX_STAT_INS, $modelpayrech->payrec_num, 1))
						{
							$success=true;
						}
						else{
							$success=false;
						}
					
					
						//UPDATE T_CASH_DIVIDEN
						$x=1;
						$modelCashDIv=Tcashdividen::model()->findAll("stk_cd='$modelheader->stk_cd' and cum_date='$modelheader->cum_date'");
					
						foreach($modelCashDIv as $row)
						{
							
							if(DateTime::createFromFormat('Y-m-d H:i:s',$row->cum_date))$row->cum_date = DateTime::createFromFormat('Y-m-d H:i:s',$row->cum_date)->format('Y-m-d');
							if(DateTime::createFromFormat('Y-m-d H:i:s',$row->distrib_dt))$row->distrib_dt = DateTime::createFromFormat('Y-m-d H:i:s',$row->distrib_dt)->format('Y-m-d');	
							
							$row->rvpv_number=$modelpayrech->payrec_num;
							if($success && $row->executeSp(AConstant::INBOX_STAT_UPD,$row->ca_type,$row->stk_cd,$row->distrib_dt,$row->client_cd,$modelheader->update_seq,$modelheader->update_date,$x)>0)
							{
								$success=true;
							}
							else
							{
								$success=false;
							}
							$x++;
						}
					
					
					
						//T_PAYRECD
						for($x=1 ; $success && $x < $detailCount ; $x++)
						{
							$sl_acct_cd = $modeldetail[$x]->sl_acct_cd;
							$client = Client::model()->find("client_cd= '$sl_acct_cd'");	
							if($client)
							{
								$modeldetail[$x]->client_cd = $modeldetail[$x]->sl_acct_cd;
							}
							$modeldetail[$x]->payrec_num= $modelpayrech->payrec_num;
							$modeldetail[$x]->payrec_type ='RD';
							$modeldetail[$x]->gl_ref_num = $modelpayrech->payrec_num;
							$modeldetail[$x]->payrec_date = $modelpayrech->payrec_date;
							$modeldetail[$x]->tal_id= $x==0?555:$x+1;
							$modeldetail[$x]->doc_tal_id= $x==0?555:$x+1;
							$modeldetail[$x]->doc_date = $modelheader->vch_date;
							$modeldetail[$x]->sett_for_curr = 0;
							$modeldetail[$x]->user_id = $modelheader->user_id;
							$modeldetail[$x]->ref_folder_cd= $modelpayrech->folder_cd;
							$modeldetail[$x]->gl_ref_num = $modelpayrech->payrec_num;
							$modeldetail[$x]->sett_for_curr = 0;
							$modeldetail[$x]->sett_val = 0;
							$sl_acct_cd = $modeldetail[$x]->sl_acct_cd;
							$gl_acct_cd = $modeldetail[$x]->gl_acct_cd;
							$branch_cd = Glaccount::model()->find("trim(sl_a)=trim('$sl_acct_cd') and trim(gl_a)= trim('$gl_acct_cd')")->brch_cd;
							
							$modeldetail[$x]->brch_cd = $branch_cd;
							$modeldetail[$x]->due_date = $modelheader->distrib_dt;
							$modeldetail[$x]->doc_ref_num = $modelpayrech->payrec_num;
							$modeldetail[$x]->record_source = $client?Sysparam::model()->find("param_id = 'VOUCHER ENTRY' and param_cd1 = 'SOURCE' AND param_cd2 = 'ARAP'")->dstr1:'VCH';
							if($success && $modeldetail[$x]->executeSp(AConstant::INBOX_STAT_INS,$modeldetail[$x]->payrec_num,$modeldetail[$x]->doc_ref_num,$modeldetail[$x]->tal_id,$modelheader->update_date,$modelheader->update_seq,$x+1)){
							$success=true;	
							}
							else{
								$success=false;
							}
						}

						//T_ACCOUNT_LEDGER
						for($x=0;$success && $x< $detailCount ;$x++)
						{
							$modelledger[$x] = new Taccountledger;
							$sl_acct_cd = $modeldetail[$x]->sl_acct_cd;
							$client = Client::model()->find("client_cd= '$sl_acct_cd'");
							$modelledger[$x]->xn_doc_num = $modelpayrech->payrec_num;
							$modelledger[$x]->doc_ref_num =  Sysparam::model()->find("param_id = 'SYSTEM' and param_cd1 = 'DOC_REF'")->dflg1=='Y'?$modelpayrech->payrec_num:'';
							$modelledger[$x]->tal_id = $x==0?5555:$x+1;
							$modelledger[$x]->sl_acct_cd = $modeldetail[$x]->sl_acct_cd;
							$modelledger[$x]->gl_acct_cd = $modeldetail[$x]->gl_acct_cd;
							$modelledger[$x]->curr_cd = 'IDR';
							$modelledger[$x]->curr_val = $modeldetail[$x]->payrec_amt;
							$modelledger[$x]->xn_val = $modeldetail[$x]->payrec_amt;
							$modelledger[$x]->db_cr_flg = $modeldetail[$x]->db_cr_flg;
							$modelledger[$x]->ledger_nar = $modeldetail[$x]->remarks;
							$modelledger[$x]->user_id = $modelheader->user_id;
							$modelledger[$x]->due_date = $cek_pape=='Y'?$modelheader->distrib_dt:$modelpayrech->payrec_date;
							$modelledger[$x]->doc_date = $cek_pape=='Y'?$modelheader->cum_date:$modelpayrech->payrec_date;
							$modelledger[$x]->arap_due_date = $modelpayrech->payrec_date;
							$modelledger[$x]->record_source ='RD';
							$modelledger[$x]->budget_cd = 'DIVIDEN';
							$modelledger[$x]->sett_for_curr = 0;
							$modelledger[$x]->sett_status = $x==0?'':'N'; 
							$modelledger[$x]->netting_date = $modelpayrech->payrec_date;
							$modelledger[$x]->rvpv_number =$modelpayrech->payrec_num;
							$modelledger[$x]->folder_cd = $modelpayrech->folder_cd;
							$modelledger[$x]->reversal_jur = 'N';
							$modelledger[$x]->manual = 'Y';
							$modelledger[$x]->cre_dt = $modelheader->cre_dt;
							$modelledger[$x]->sett_val = 0;
							$sl_acct_cd = $modelledger[$x]->sl_acct_cd;
							$gl_acct_cd = $modelledger[$x]->gl_acct_cd;
							$type1  = Glaccount::model()->find("trim(gl_a) = trim('$gl_acct_cd') and sl_a =  '$sl_acct_cd' and prt_type<>'S' and approved_stat='A' ");
							if($type1){
								$acct_type = $type1->acct_type;	
							}
							
							$modelledger[$x]->acct_type = $acct_type=='BANK'?'':$acct_type;
							$modelledger[$x]->brch_cd = $type1->brch_cd;
					
							if($success && $modelledger[$x]->executeSp(AConstant::INBOX_STAT_INS,$modelledger[$x]->xn_doc_num,$modelledger[$x]->tal_id,$modelheader->update_date,$modelheader->update_seq,$x+1) > 0){
								$success = true;
							}
							else{
								$success=false;
							}
						}
						//T_FOLDER
						if($check =='Y')
						{ 
							$modelFolder->fld_mon = DateTime::createFromFormat('Y-m-d',$modelpayrech->payrec_date)->format('my');
							$modelFolder->folder_cd = $modelpayrech->folder_cd;
							$modelFolder->doc_date = $modelpayrech->payrec_date;
							$modelFolder->doc_num = $modelpayrech->payrec_num;
							$modelFolder->user_id = $modelpayrech->user_id;
							$modelFolder->cre_dt = $modelpayrech->cre_dt;
							$modelFolder->upd_by = $modelpayrech->upd_by;
							$modelFolder->upd_dt = $modelpayrech->upd_dt;
						
						
							if($success && $modelFolder->executeSp(AConstant::INBOX_STAT_INS,$modelFolder->doc_num,$modelheader->update_date,$modelheader->update_seq,1) > 0)$success = true;
							else {
								$success = false;
							}
						}

					if($success)
					{
						$transaction->commit();							
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/finance/Voucherdiv/index'));
					}
					else 
					{
						$transaction->rollback();
					}
						
				}
				
					
					
				}
				
				
			}


	
		if(DateTime::createFromFormat('Y-m-d',$modelheader->cum_date))$modelheader->cum_date = DateTime::createFromFormat('Y-m-d',$modelheader->cum_date)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$modelheader->cum_date1))$modelheader->cum_date1 = DateTime::createFromFormat('Y-m-d',$modelheader->cum_date1)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$modelheader->vch_date))$modelheader->vch_date = DateTime::createFromFormat('Y-m-d',$modelheader->vch_date)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$model->cum_date1))$model->cum_date1 = DateTime::createFromFormat('Y-m-d',$model->cum_date1)->format('d/m/Y');	
	


		$this->render('index',array(
			'model'=>$model,
			'modelheader'=>$modelheader,
			'modeldetail'=>$modeldetail,
			'modelpayrech'=>$modelpayrech,
			'modelledger'=>$modelledger,
			'stk_cd'=>$stk_cd,
			'modelCashDIv'=>$modelCashDIv,
			'cek_pape'=>$cek_pape,
			'cek_branch'=>$cek_branch,
			'default_branch'=>$default_branch
		));
	}


}
