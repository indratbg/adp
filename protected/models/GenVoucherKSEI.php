<?php

class GenVoucherKSEI extends Tpayrech
{
	public $ksei_bal;
	public $arap_bal;
	public $from_ksei_amt;
	public $to_ksei_amt;
	public $subrek;
	public $generate = 'Y';
	
	public $ap_vch_cnt;
	public $ar_vch_cnt;
	public $fail_vch;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getVoucherTransferKseiSql($bal_date, $due_date, $mode, $brch_cd)
	{
		$sql = "SELECT branch_code, client_cd, client_name, acct_type client_type, SUBSTR(subrek,1,5) || '-' || SUBSTR(subrek,6,4) || '-' || SUBSTR(subrek,10,3) || '-' || SUBSTR(subrek,13,2) subrek, rdi_acct, NVL(BAL_KSEI,0) ksei_bal, UPTO_T0 arap_bal, KSEI_OUT from_ksei_amt, KSEI_IN to_ksei_amt, DECODE('$mode','KSEI','N','Y') generate 
				FROM
				( 
					SELECT TRIM(m.branch_code) branch_code, m.client_cd, m.client_name, m.acct_type, NVL(K.BAL_KSEI,0) BAL_KSEI, m.subrek, rdi_acct, NVL(upto_t0,0) upto_t0, 
					DECODE(SIGN(ABS(NVL(BAL_KSEI,0)) - NVL(ar_t0,0)), -1, NVL(BAL_KSEI,0), NVL(ar_t0,0)) KSEI_OUT, NVL(ap_T0,0) KSEI_IN 
 					FROM
 					( 
 						SELECT client_Cd, NVL(upto_t0,0) upto_t0, DECODE(SIGN(upto_t0), 1, upto_t0, 0) AR_t0, DECODE(SIGN(upto_t0), -1, ABS(upto_t0), 0) AP_t0 
   						FROM
   						( 
   							SELECT client_Cd, SUM(upto_t0) upto_t0 
     						FROM
     						( 
       							SELECT a.xn_doc_num, a.tal_id, a.sl_acct_cd client_cd, DECODE(a.db_Cr_flg,'D',1,-1) * a.curr_val upto_t0 
       							FROM t_account_ledger a, mst_client m, 
	   							( 
	   								SELECT gl_A 
	     							FROM MST_GLA_TRX
		 							WHERE jur_type = 'T3'
		 						) v   
       							WHERE a.doc_date BETWEEN TO_DATE('$bal_date','YYYY-MM-DD') AND TO_DATE('$due_date','YYYY-MM-DD') 
	   							AND a.gl_acct_cd = RPAD(v.gl_a,12)
	   							AND a.sl_acct_cd = m.client_cd 
       							AND a.due_date <= TO_DATE('$due_date','YYYY-MM-DD') 
       							AND a.approved_sts = 'A' 
       							AND a.reversal_jur = 'N'
       							AND a.record_source <> 'RE'
       							UNION ALL 
       							SELECT gl_Acct_cd,1,sl_acct_cd, (deb_obal - cre_obal) beg_bal 
       							FROM t_day_trs, mst_client,
	   							( 
	   								SELECT gl_A 
	     							FROM MST_GLA_TRX
		 							WHERE jur_type = 'T3'
								) v   
       							WHERE trs_dt = TO_DATE('$bal_date','YYYY-MM-DD') 
       							AND t_day_trs.sl_acct_cd = mst_client.client_Cd 
	   							AND gl_acct_cd = RPAD(v.gl_a,12)
       							AND (deb_obal - cre_obal) <> 0
							) 
      						GROUP BY client_cd
						)
					) a, 
    				(
						SELECT  m.client_cd, branch_code, client_name, m.client_type_3 AS acct_type, v.subrek001 subrek, f.bank_acct_num rdi_acct --, -1 * NVL( F_Fund_Bal(m.client_cd, TO_DATE('$due_date','YYYY-MM-DD') ),0) AS fund_bal
				     	FROM mst_client m, mst_client_flacct f, v_client_subrek14 v 
				     	WHERE m.client_cd = f.client_cd(+) 
				     	AND m.susp_stat = 'N' 
				     	AND f.client_cd IS NULL
				     	AND m.client_cd = v.client_cd
					 	AND SUBSTR(v.subrek001,6,4) <>'0000'
				    	AND TRIM(m.branch_code) LIKE '$brch_cd'
				  	) M,
				  	( 
						SELECT MAX(client_cd) client_cd, MAX(payrec_date) payrec_date
						FROM
						(
							SELECT DECODE(field_name,'CLIENT_CD',field_value, NULL) client_cd,
							DECODE(field_name,'PAYREC_DATE',TO_DATE(field_value,'YYYY/MM/DD HH24:MI:SS'), NULL) payrec_date,
							a.update_date, a.update_seq, record_seq
							FROM T_MANY_DETAIL a JOIN T_MANY_HEADER b
							ON a.update_seq = b.update_seq
							AND a.update_date = b.update_date
							WHERE menu_name = 'GENERATE VOUCHER TRANSFER KSEI'
							AND approved_status = 'E'
							AND table_name = 'T_PAYRECH'
		          			AND field_name IN ('CLIENT_CD','PAYREC_DATE')
						)
						GROUP BY update_date, update_seq, record_seq
					) p,
   					( 
   						SELECT CLIENT_CD, SUM(DECODE(TRX_TYPE,'R',1,-1) * TRX_AMT) BAL_KSEI
      					FROM T_FUND_KSEI
	  					WHERE DOC_DATE <= TO_DATE('$due_date','YYYY-MM-DD') 
	  					AND APPROVED_STS = 'A'
	  					GROUP BY CLIENT_CD 
					) k
  					WHERE a.client_cd(+) = m.client_cd
  					AND p.client_cd(+) = m.client_cd
	  				AND p.client_cd IS NULL
					AND M.CLIENT_CD = K.CLIENT_CD(+) 
					AND ( (upto_t0 <> 0 AND '$mode' <> 'KSEI') OR ('$mode' = 'KSEI' AND BAL_KSEI <> 0) ) 
				)
				WHERE KSEI_OUT > 0 OR KSEI_IN > 0 OR '$mode' = 'KSEI' 
				ORDER BY client_cd ";
		
		return $sql;
	}
		
	public function executeSpTransferKSEI($exec_status)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_RVPV_TRF_KSEI(
						:P_BRCH_CD,
						:P_CLIENT_CD,
						TO_DATE(:P_DUE_DATE,'YYYY-MM-DD'),
						:P_AP_VCH,
						:P_AR_VCH,
						:P_FAIL_VCH,
						:P_USER_ID,
						:P_UPDATE_SEQ,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BRCH_CD",$this->branch_code,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_DUE_DATE",$this->due_date,PDO::PARAM_STR);
			$command->bindParam(":P_AP_VCH",$this->ap_vch_cnt,PDO::PARAM_STR,100);
			$command->bindParam(":P_AR_VCH",$this->ar_vch_cnt,PDO::PARAM_STR,100);
			$command->bindParam(":P_FAIL_VCH",$this->fail_vch,PDO::PARAM_STR,10);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
						
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			
		}catch(Exception $ex){
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}
	
	public function rules()
	{
		return array(
			array('due_date','checkIfHoliday'),
		
			array('due_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('due_date','required','on'=>'header'),
			
			array('generate, branch_code, client_cd, client_name, client_type, ksei_bal, arap_bal, from_ksei_amt, to_ksei_amt, subrek', 'safe'),
		);		
	}
	
	public function checkIfHoliday()
	{
		if($this->due_date)
		{
			$check = "SELECT dflg1 FROM MST_SYS_PARAM WHERE param_id = 'SYSTEM' AND param_cd1 = 'CHECK' AND param_cd2 = 'HOLIDAY'";
			$checkFlg = DAO::queryRowSql($check);
			
			if($checkFlg['dflg1'] == 'Y')
			{
				$sql = "SELECT F_IS_HOLIDAY('$this->due_date') is_holiday FROM dual";
				$isHoliday = DAO::queryRowSql($sql);
				
				if($isHoliday['is_holiday'] == 1)$this->addError('due_date','Date must not be holiday');
			}
		}
	}
}
