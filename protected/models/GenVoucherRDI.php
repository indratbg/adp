<?php

class GenVoucherRDI extends Tpayrech
{
	public $brch_cd;
	public $brch_all_flg;
	public $bank_rdi;
	public $bank_all_flg;
	public $debit;
	public $credit;
	public $arap_bal;
	public $rdi_bal;
	public $from_rdi_amt;
	public $to_rdi_amt;
	public $rdi_num;
	public $rdi_stat;
	
	public $ap_vch_cnt;
	public $ar_vch_cnt;
	
	public $successCnt;
	public $failCnt;
	public $failMsg;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getVoucherTransferRdiSql($bal_date, $due_date, $brch_cd)
	{
		$sql = "SELECT branch_code AS brch_cd,client_cd,client_name, bank_acct_fmt AS rdi_num, bank_cd, rdi_stat,decode(brch_sort,'LO','LOT',brch_sort) brch_sort, acct_type AS client_type,
  				-1 * fund_bal AS rdi_bal, decode(sign(UPTO_T0), -1, 0,upto_t0) AS debit, decode(sign(UPTO_T0), -1, abs(upto_t0),0) AS credit, 
  				EST_QQ_MASUK AS from_rdi_amt, EST_QQ_KELUAR AS to_rdi_amt
				FROM
				( 
					SELECT m.branch_code, m.client_cd, m.client_name, m.bank_acct_fmt, m.bank_cd, m.rdi_stat,m.brch_sort, m.acct_type, m.fund_bal,
		  			NVL(upto_t0,0) upto_t0, DECODE(SIGN(avail_fund_bal - NVL(ar_t0,0)), -1,F_Limit_Ambil_Rdi(client_type_3,avail_fund_bal),
			   		DECODE(rdi_stat,'A',NVL(ar_t0,0),'I',avail_fund_bal)) est_qq_masuk, DECODE(rdi_stat,'A', NVL(ap_T0,0),0) est_qq_keluar, min_trf
 					FROM
 					( 
 						SELECT client_Cd, SUM(upto_t0)upto_t0, DECODE(SIGN( SUM(upto_t0)), 1,  SUM(upto_t0), 0) AR_t0, DECODE(SIGN( SUM(upto_t0)), -1, ABS( SUM(upto_t0)), 0) AP_t0
						FROM
							(
							 	SELECT a.sl_acct_cd client_cd, DECODE(a.db_Cr_flg,'D',1,-1) * a.curr_val upto_t0
							 	FROM T_ACCOUNT_LEDGER a, MST_CLIENT m, MST_GLA_TRX g
							 	WHERE a.doc_date BETWEEN TO_DATE('$bal_date','YYYY-MM-DD') AND TO_DATE('$due_date','YYYY-MM-DD')  
								AND a.sl_acct_cd = m.client_cd
								AND trim(a.gl_acct_cd) = trim(g.gl_a)
								AND g.jur_type = 'ARAP'
							 	AND a.due_date <= TO_DATE('$due_date','YYYY-MM-DD')  
							 	AND a.approved_sts = 'A'
							 	AND reversal_jur = 'N'
                				AND record_source <> 'RE'
							 	UNION ALL
							 	SELECT sl_acct_cd, sum((deb_obal - cre_obal)) beg_bal
							 	FROM T_DAY_TRS, MST_CLIENT, MST_GLA_TRX g
							 	WHERE trs_dt = TO_DATE('$bal_date','YYYY-MM-DD')
							 	AND T_DAY_TRS.sl_acct_cd = MST_CLIENT.client_Cd
								AND trim(T_DAY_TRS.gl_acct_cd) = trim(g.gl_a)
								AND g.jur_type = 'ARAP'
							 	AND (deb_obal - cre_obal) <> 0
            				    group by sl_acct_cd
							)
							GROUP BY client_cd
					) a RIGHT JOIN
			 		( 
			 			SELECT  m.client_cd,  branch_code, client_name,
			 			DECODE(GREATEST(TO_DATE('$due_date','YYYY-MM-DD'),TO_DATE('03/01/2013','dd/mm/yyyy')),TO_DATE('$due_date','YYYY-MM-DD'),'X',client_type_3) client_type_3,
				 		trim(m.client_type_1||m.client_type_2||m.client_type_3) AS acct_type,
				 		DECODE(trim(m.rem_cd), 'LOT','LO',trim(branch_code)) brch_sort,
				  		f.bank_acct_fmt, f.bank_cd,f.acct_stat AS rdi_stat,
				  		DECODE(f.client_cd, NULL, 0, -1 * NVL( F_Fund_Bal(m.client_cd,TO_DATE('$due_date','YYYY-MM-DD')),0)) fund_bal,
				  		DECODE(f.client_cd, NULL, 0, GREATEST(NVL( F_Fund_Bal(m.client_cd,TO_DATE('$due_date','YYYY-MM-DD')),0) -min_balance,0)) avail_fund_bal
			  			FROM MST_CLIENT m, MST_CLIENT_FLACCT f,
						(
							SELECT TO_NUMBER(prm_desc) min_balance
							FROM MST_PARAMETER
							WHERE prm_cd_1 = 'BRDMIN'
						) d1
						WHERE m.client_cd = f.client_cd
						AND m.susp_stat = 'N'
						AND  ( f.acct_stat = 'A' OR f.acct_stat = 'I' )
			  		) M ON a.client_cd = m.client_cd LEFT JOIN
		 			( 
					select client_cd from
			          (
			              SELECT	    (SELECT field_value
                          FROM T_MANY_DETAIL DA
                          WHERE DA.TABLE_NAME = 'T_PAYRECH'
                          AND DA.UPDATE_DATE  = DD.UPDATE_DATE
                          AND DA.UPDATE_SEQ   = DD.UPDATE_SEQ
                          AND DA.FIELD_NAME   = 'CLIENT_CD'
                          AND DA.RECORD_SEQ   = DD.RECORD_SEQ
                          ) CLIENT_CD,
                          (SELECT to_date(FIELD_VALUE,'yyyy/mm/dd hh24:mi:ss')
                          FROM T_MANY_DETAIL DA
                          WHERE DA.TABLE_NAME = 'T_PAYRECH'
                          AND DA.UPDATE_DATE  = DD.UPDATE_DATE
                          AND DA.UPDATE_SEQ   = DD.UPDATE_SEQ
                          AND DA.FIELD_NAME   = 'PAYREC_DATE'
                          AND DA.RECORD_SEQ   = DD.RECORD_SEQ
                          ) PAYREC_DATE,
                          (SELECT FIELD_VALUE
                          FROM T_MANY_DETAIL DA
                          WHERE DA.TABLE_NAME = 'T_PAYRECH'
                          AND DA.UPDATE_DATE  = DD.UPDATE_DATE
                          AND DA.UPDATE_SEQ   = DD.UPDATE_SEQ
                          AND DA.FIELD_NAME   = 'ACCT_TYPE'
                          AND DA.RECORD_SEQ   = DD.RECORD_SEQ
                          ) ACCT_TYPE,
                          HH.APPROVED_STATUS,
                          HH.MENU_NAME
                        FROM T_MANY_DETAIL DD,
                          T_MANY_HEADER HH
                        WHERE DD.TABLE_NAME    = 'T_PAYRECH'
                        AND DD.UPDATE_DATE     = HH.UPDATE_DATE
                        AND DD.UPDATE_SEQ      = HH.UPDATE_SEQ
                        AND DD.RECORD_SEQ      = 1
                        AND DD.FIELD_NAME      = 'CLIENT_CD'
                        AND HH.APPROVED_STATUS = 'E'
                        )
                    WHERE TRUNC(PAYREC_DATE) = TO_DATE('$due_date','YYYY-MM-DD')
                    AND ACCT_TYPE ='RDI'
					
					) p ON m.client_cd = p.client_cd,
					( 
						SELECT  trim(PRM_CD_2) bank_cd, TO_NUMBER(prm_desc) min_trf
						FROM MST_PARAMETER
						WHERE prm_cd_1 = 'TRFMIN'
					) d2
	  				WHERE p.client_cd IS NULL
	  				AND d2.bank_cd = m.bank_cd
					AND (m.brch_sort = '$brch_cd' OR '$brch_cd' = '%')
	  				AND (upto_t0 <> 0 OR ( avail_fund_bal <> 0 AND rdi_stat = 'I' ))
				)
  				WHERE est_qq_masuk >= min_trf OR est_qq_keluar >= min_trf
  				ORDER BY brch_sort,client_cd";
		
		/*
		  SELECT client_Cd, upto_t0, DECODE(SIGN(upto_t0), 1, upto_t0, 0) AR_t0, DECODE(SIGN(upto_t0), -1, ABS(upto_t0), 0) AP_t0
						FROM
						( 
							SELECT client_Cd, SUM(upto_t0) upto_t0
						  	FROM
						  	(
							 	SELECT a.xn_doc_num, a.tal_id, a.sl_acct_cd client_cd, DECODE(a.db_Cr_flg,'D',1,-1) * a.curr_val upto_t0
							 	FROM T_ACCOUNT_LEDGER a, MST_CLIENT m, MST_GLA_TRX g
							 	WHERE a.doc_date BETWEEN TO_DATE('$bal_date','YYYY-MM-DD') AND TO_DATE('$due_date','YYYY-MM-DD')  
								AND a.sl_acct_cd = m.client_cd
								AND a.gl_acct_cd = RPAD(g.gl_a,12)
								AND g.jur_type = 'ARAP'
							 	AND a.due_date <= TO_DATE('$due_date','YYYY-MM-DD')
							 	AND a.approved_sts = 'A'
							 	AND reversal_jur = 'N'
                				AND record_source <> 'RE'
							 	UNION ALL
							 	SELECT gl_Acct_cd,1,sl_acct_cd, (deb_obal - cre_obal) beg_bal
							 	FROM T_DAY_TRS, MST_CLIENT, MST_GLA_TRX g
							 	WHERE trs_dt = TO_DATE('$bal_date','YYYY-MM-DD')
							 	AND T_DAY_TRS.sl_acct_cd = MST_CLIENT.client_Cd
								AND T_DAY_TRS.gl_acct_cd = RPAD(g.gl_a,12)
								AND g.jur_type = 'ARAP'
							 	AND (deb_obal - cre_obal) <> 0
							)
							GROUP BY client_cd
		 				 )
		 */
		 
		/*
		 SELECT MAX(client_cd) client_cd, MAX(payrec_date) payrec_date, MAX(acct_type) acct_type
						FROM
						(
							SELECT DECODE(field_name,'CLIENT_CD',field_value, NULL) client_cd,
									DECODE(field_name,'PAYREC_DATE',TO_DATE(field_value,'YYYY/MM/DD HH24:MI:SS'), NULL) payrec_date,
									DECODE(field_name,'ACCT_TYPE',field_value, NULL) acct_type,
							a.update_date, a.update_seq, record_seq
							FROM T_MANY_DETAIL a JOIN T_MANY_HEADER b
							ON a.update_seq = b.update_seq
							AND a.update_date = b.update_date
							WHERE approved_status = 'E'
							AND table_name = 'T_PAYRECH'
							AND record_seq = 1
		          			AND field_name IN ('CLIENT_CD','PAYREC_DATE','ACCT_TYPE')
						)
						GROUP BY update_date, update_seq, record_seq
						HAVING TRUNC(MAX(payrec_date)) = TO_DATE('$due_date','YYYY-MM-DD')
						AND MAX(ACCT_TYPE) = 'RDI'
		 */
		
		return $sql;
	}
	
	public function executeSpTransferRDI()
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_RVPV_AUTO_TRF(
						TO_DATE(:P_DUE_DATE,'YYYY-MM-DD'),
						:P_BRCH_CD,
						:P_FUND_BANK_CD,
						:P_ARAP,
						:P_AP_VCH,
						:P_AR_VCH,
						:P_SUCCESS_CNT,
						:P_FAIL_CNT,
						:P_FAIL_MSG,
						:P_USER_ID,
						:P_IP_ADDRESS,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_DUE_DATE",$this->due_date,PDO::PARAM_STR);
			$command->bindValue(":P_BRCH_CD",$this->brch_all_flg=='Y'?'%':$this->brch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_FUND_BANK_CD",$this->bank_rdi,PDO::PARAM_STR);
			$command->bindValue(":P_ARAP",$this->brch_all_flg=='Y'?'%':$this->brch_cd,PDO::PARAM_STR);
			$command->bindParam(":P_AP_VCH",$this->ap_vch_cnt,PDO::PARAM_STR,10);
			$command->bindParam(":P_AR_VCH",$this->ar_vch_cnt,PDO::PARAM_STR,10);
			$command->bindParam(":P_SUCCESS_CNT",$this->successCnt,PDO::PARAM_STR,10);
			$command->bindParam(":P_FAIL_CNT",$this->failCnt,PDO::PARAM_STR,10);
			$command->bindParam(":P_FAIL_MSG",$this->failMsg,PDO::PARAM_STR,200);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
						
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
		
			array('trx_date, due_date, payrec_date, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('debit, credit, arap_bal, rdi_bal, from_rdi_amt, to_rdi_amt', 'application.components.validator.ANumberSwitcherValidator'),
		
			array('due_date','required','on'=>'header'),
			
			array('brch_cd, brch_all_flg, bank_rdi, bank_all_flg, bank_acct_num, rdi_stat, trx_date, due_date, client_cd, client_name, client_type', 'safe'),
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

	public function attributeLabels()
	{
		return array_merge(
			array(
				'brch_cd' => 'Branch',
				'bank_rdi' => 'Bank Rekening Dana'
			),
			parent::attributeLabels()
		);
	}
}
