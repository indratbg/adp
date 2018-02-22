<?php

Class GenVoucherTenderOffer extends CFormModel
{
	public $stk_cd;
	public $stage;
	public $tender_ar_gla;
	public $tender_ar_sla;
	public $bank_gla;
	public $bank_sla;
	public $voucher_date;
	public $remarks;
	public $folder_cd;
	
	public $tempDateCol   = array();  
	
	public function getPenjualanSql()
	{
		$sql = "SELECT tal_id, db_cr_flg, gl_a, sl_a, descrip, DECODE(tal_id, 1, SUM(det_amount) OVER (), det_amount) AS amount		
				FROM
				(			 					
					SELECT 1 tal_id, 'D' db_cr_flg, '$this->tender_ar_gla' gl_a, '$this->tender_ar_sla' sl_a, 'Tender Offer '||'$this->stk_cd' descrip, 0 det_amount FROM dual								
					UNION								
					SELECT row_number() OVER (ORDER BY client_Cd) + 1 tal_id, 'C', gl_a, client_cd, 'Tender Offer '||'$this->stk_cd'||' '||TO_CHAR(withdrawn_share_qty)||' @'||TO_CHAR(price) AS descrip,					
					withdrawn_share_qty * price det_amount								
					FROM T_STK_MOVEMENT, 								
					(								
						SELECT trim(gl_a) gl_a								
						FROM MST_GLA_TRX								
						WHERE jur_type = 'T3'
					) MST_GLA_TRX								
					WHERE stk_Cd = '$this->stk_cd'								
					AND doc_dt > (TRUNC(SYSDATE) - 20)								
					AND doc_stat = '2'								
					AND seqno = 1								
					AND jur_type = 'TOFFSELL'								
				)";
		
		return $sql;
	}
	
	public function getDistributionSql()
	{
		$sql = "SELECT tal_id, db_cr_flg, gl_a, sl_a,  descrip, amount								
				FROM								
				(
					SELECT SUM( withdrawn_share_qty * price) amount								
					FROM T_STK_MOVEMENT 								
					WHERE stk_Cd = '$this->stk_cd'								
					AND doc_dt > (TRUNC(SYSDATE) - 20)								
					AND doc_stat = '2'								
					AND seqno = 1								
					AND jur_type = 'TOFFSELL'								
				),								
				(			 					
					SELECT 555 tal_id, 'D' db_cr_flg, '$this->bank_gla' gl_a, '$this->bank_sla' sl_a,  'Tender Offer '||'$this->stk_cd' descrip, 1 sortk FROM dual								
					UNION 								
					SELECT 2 tal_id, 'C' db_cr_flg, '$this->tender_ar_gla' gl_a, '$this->tender_ar_sla' sl_a,  'Tender Offer '||'$this->stk_cd' descrip, 2 sortk FROM dual								
				)
				WHERE amount IS NOT NULL
				ORDER BY sortk";
		
		return $sql;
	}
	
	public function rules()
	{
		return array(
			array('voucher_date','checkIfHoliday'),
		
			array('voucher_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('tender_ar_sla','checkExist'),
			
			array('bank_gla, bank_sla','required','on'=>AConstant::VOUCHER_TENDER_TYPE_DISTRIBUTION),
			array('voucher_date, stk_cd, stage, remarks, tender_ar_gla, tender_ar_sla','required'),
			array('folder_cd, bank_gla, bank_sla','safe'),
		);
	}
	
	public function checkIfHoliday()
	{
		if($this->voucher_date)
		{
			$check = "SELECT dflg1 FROM MST_SYS_PARAM WHERE param_id = 'SYSTEM' AND param_cd1 = 'CHECK' AND param_cd2 = 'HOLIDAY'";
			$checkFlg = DAO::queryRowSql($check);
			
			if($checkFlg['dflg1'] == 'Y')
			{
				$sql = "SELECT F_IS_HOLIDAY('$this->voucher_date') is_holiday FROM dual";
				$isHoliday = DAO::queryRowSql($sql);
				
				if($isHoliday['is_holiday'] == 1)$this->addError('voucher_date','Date must not be holiday');
			}
		}
	}
	
	public function checkExist()
	{
		if($this->stage == AConstant::VOUCHER_TENDER_TYPE_DISTRIBUTION && $this->bank_sla)
		{
			$checkBank = DAO::queryRowSql
						("
							SELECT COUNT(*) cnt
							FROM MST_GL_ACCOUNT
							WHERE TRIM(gl_a) = TRIM('$this->bank_gla') 
							AND sl_a LIKE '$this->bank_sla'
							AND prt_type <> 'S'
							AND acct_stat = 'A'
							AND approved_stat = 'A'
						");
			
			if($checkBank['cnt'] == 0)$this->addError('bank_sla', "$this->bank_gla $this->bank_sla not found in chart of accounts");
		}
		
		if($this->tender_ar_sla)
		{
			$checkPorto = DAO::queryRowSql
						("
							SELECT COUNT(*) cnt
							FROM MST_GL_ACCOUNT
							WHERE TRIM(gl_a) = TRIM('$this->tender_ar_gla') 
							AND sl_a LIKE '$this->tender_ar_sla'
--							AND prt_type <> 'S'
							AND acct_stat = 'A'
							AND approved_stat = 'A'
						");
			
			if($checkPorto['cnt'] == 0)$this->addError('tender_ar_sla', "$this->tender_ar_gla $this->tender_ar_sla not found in chart of accounts");
		}
	}
	
	public function attributeLabels()
	{
		return array(
			'stk_cd' => 'Stock Code',
			'stage' => 'Tahap',
			'bank_gla' => 'GL Bank',
			'bank_sla' => 'SL Bank',
			'tender_ar_gla' => 'GL Piutang Tender Offer',
			'tender_ar_sla' => 'SL Piutang Tender Offer',
		);
	}
}
