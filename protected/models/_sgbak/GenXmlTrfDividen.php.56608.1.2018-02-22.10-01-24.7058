<?php

Class GenXmlTrfDividen extends CFormModel
{
	public $ip_address;
	public $error_code 	  = -999;
	public $error_msg  	  = 'Initial Value';
	
	public $payment_date;
	public $output;
	public $brch_cd;
	public $stk_cd;
	
	public $externalReference;
	public $participantCode;
	public $participantAccount;
	public $beneficiaryAccount;
	public $beneficiaryInstitution;
	public $valueDate;
	public $currencyCode;
	public $cashAmount;
	public $description;
	
	function getDivXMLSql()
	{
		$sql = "SELECT 'DIV_{$this->stk_cd}'||d.sl_acct_cd AS \"external Reference\",
					broker_cd AS \"participant Code\",			
					v.subrek001 AS \"participant Account\",			
					bank_acct_Cd AS \"beneficiary Account\",		
					def_bank_cd AS \"beneficiary Institution\",			
					TO_CHAR(h.payrec_date, 'yyyymmdd') AS \"value Date\",		
					'IDR' AS \"currency Code\",			
					TO_CHAR(d.payrec_amt) AS \"cash Amount\",			
					'DIVIDEN {$this->stk_cd} {$this->brch_cd}'||d.sl_acct_cd AS \"description\"			
				FROM t_payrech h, t_payrecd d, v_client_subrek14 v, 
				( 
					SELECT F_CLEAN(bank_acct_Cd) bank_acct_Cd			
			  		FROM mst_bank_acct 			
			  		WHERE trim(BRCH_CD) = '$this->brch_cd' 
			  	) b,			
				( 
					SELECT bank_cd def_bank_cd	
					FROM mst_fund_bank			
					WHERE default_flg = 'Y'
				) c,
			  	v_broker_subrek			
				WHERE h.payrec_date = TO_DATE('$this->payment_date','DD/MM/YYYY')
				AND h.payrec_type = 'RD'
				AND h.client_cd = '$this->brch_cd'||'$this->stk_cd'||TO_CHAR(TO_DATE('$this->payment_date','DD/MM/YYYY'), 'ddmmyy')		
				AND h.payrec_num = d.payrec_num			
				AND d.sl_acct_cd = v.client_cd";
		
		return $sql;
	}
		
	function rules()
	{
		return array(
			array('payment_date, brch_cd, stk_cd, output','required'),
			
			array('externalReference, participantCode, participantAccount, beneficiaryAccount, beneficiaryInstitution, valueDate, currencyCode, cashAmount, description','safe')
		);
	}
	
	function attributeLabels()
	{
		return array(
			'brch_cd' => 'Branch Code',
			'stk_cd' => 'Stock Code',
		);
	}
}
