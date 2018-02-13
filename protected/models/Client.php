
<?php

/**
 * This is the model class for table "MST_CLIENT".
 *
 * The followings are the available columns in table 'MST_CLIENT':
 * @property string $client_cd
 * @property integer $cif_number
 * @property string $client_name
 * @property string $client_name_abbr
 * @property string $client_type_1
 * @property string $client_type_2
 * @property string $client_type_3
 * @property string $client_title
 * @property string $client_birth_dt
 * @property string $religion
 * @property string $acct_open_dt
 * @property string $client_race
 * @property string $client_ic_num
 * @property string $chq_payee_name
 * @property string $sett_off_cd
 * @property string $stk_exch
 * @property string $ic_type
 * @property string $curr_cd
 * @property string $def_curr_cd
 * @property string $rem_cd
 * @property string $bank_cd
 * @property string $bank_brch_cd
 * @property string $def_contra_flg
 * @property string $cust_client_flg
 * @property double $cr_lim
 * @property string $susp_stat
 * @property string $def_addr_1
 * @property string $def_addr_2
 * @property string $def_addr_3
 * @property string $post_cd
 * @property string $contact_pers
 * @property string $phone_num
 * @property string $hp_num
 * @property string $fax_num
 * @property string $e_mail1
 * @property string $hand_phone1
 * @property string $phone2_1
 * @property string $regn_cd
 * @property string $desp_pref
 * @property string $stop_pay
 * @property string $old_ic_num
 * @property string $print_flg
 * @property string $rem_own_trade
 * @property string $avg_flg
 * @property string $client_name_ext
 * @property string $branch_code
 * @property string $pph_appl_flg
 * @property string $levy_appl_flg
 * @property double $int_on_payable
 * @property double $int_on_receivable
 * @property double $int_on_adv_recd
 * @property integer $grace_period
 * @property integer $int_rec_days
 * @property integer $int_pay_days
 * @property string $tax_on_interest
 * @property string $agreement_no
 * @property string $npwp_no
 * @property double $rebate
 * @property string $rebate_basis
 * @property double $commission_per
 * @property string $acopen_fee_flg
 * @property string $next_rollover_dt
 * @property string $ac_expiry_dt
 * @property string $commit_fee_dt
 * @property string $roll_fee_dt
 * @property string $recov_charge_flg
 * @property string $upd_dt
 * @property string $cre_dt
 * @property string $user_id
 * @property double $rebate_tottrade
 * @property string $amt_int_flg
 * @property string $internet_client
 * @property string $contra_days
 * @property string $vat_appl_flg
 * @property string $int_accumulated
 * @property string $bank_acct_num
 * @property string $custodian_cd
 * @property string $olt
 * @property string $sid
 * @property string $biz_type
 * @property string $cifs
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 * @property string $closed_date
 */
class Client extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $client_birth_dt_date;
	public $client_birth_dt_month;
	public $client_birth_dt_year;

	public $acct_open_dt_date;
	public $acct_open_dt_month;
	public $acct_open_dt_year;

	public $next_rollover_dt_date;
	public $next_rollover_dt_month;
	public $next_rollover_dt_year;

	public $ac_expiry_dt_date;
	public $ac_expiry_dt_month;
	public $ac_expiry_dt_year;

	public $commit_fee_dt_date;
	public $commit_fee_dt_month;
	public $commit_fee_dt_year;

	public $roll_fee_dt_date;
	public $roll_fee_dt_month;
	public $roll_fee_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	
	//AH: Additional attribute ,  than it will be concatenate (if insert) or break (if select) into CLIENT_CD
	public $client_code_opt;
	public $acct_open;
	public $searched_cif;
	public $cif_opt;
	
	public $subrek001;
	public $subrek001_1;
	public $subrek001_2;
	public $subrek004;
	public $subrek004_1;
	public $subrek004_2;
	
	public $old_branch_code;
	public $old_rem_cd;
	public $branch_change_flg;
	public $rem_change_flg;
	
	public $copy_client;
	
	public $rdn;
	
	public $update_seq;
	public $update_date;
	
	public static $cif_option = array('1'=>'New','2'=>'Existing');
	const CIF_OPTION_NEW 		= 1;
	const CIF_OPTION_EXISTING 	= 2;
	
	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	public function afterFind()
	{
		if(DateTime::createFromFormat('Y-m-d G:i:s',$this->next_rollover_dt))$this->next_rollover_dt = DateTime::createFromFormat('Y-m-d G:i:s',$this->next_rollover_dt)->format('Y-m-d');
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
	public function getCodeAndName()
	{
		return $this->client_cd." - ".$this->client_name;
	}
	
	public function getCodeAndNameAndBranch()
	{
		return $this->client_cd." - ".$this->client_name." - ".$this->branch_code; 	
		
	}
	
	public function getCodeAndNameAndType()
	{
		return $this->client_cd." - ".$this->client_name." - ".$this->client_type_1;
	}
	
	public function getConcatForSettlementClientCmb()
	{
		return $this->client_cd." - ".$this->branch_code.((!empty($this->old_ic_num))?" - ".$this->old_ic_num:"")." - ".$this->client_name;	
	}
	
	public function tableName()
	{
		return 'MST_CLIENT';
	}

	public function rules()
	{
		return array(
			array('client_birth_dt, acct_open_dt, next_rollover_dt, ac_expiry_dt, commit_fee_dt, roll_fee_dt, approved_dt, init_deposit_efek_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('cr_lim, int_on_payable, int_on_receivable, int_on_adv_recd, grace_period, int_rec_days, int_pay_days, rebate, commission_per, rebate_tottrade, commission_per_sell, commission_per_buy, transaction_limit, init_deposit_amount, init_deposit_efek_price', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('client_name, acct_open_dt, contact_pers, client_type_2, client_type_3, branch_code, rem_cd, commission_per, print_flg, def_addr_1', 'required'),
			array('subrek001_1','checkCustodian'),
			array('stop_pay','checkEmail'),
			array('client_type_3','checkRegular'),
			array('client_name','validateFirstFour','on'=>'update'),
			
			array('cif_number, grace_period, int_rec_days, int_pay_days', 'numerical', 'integerOnly'=>true),
			array('cr_lim, int_on_payable, int_on_receivable, int_on_adv_recd, rebate, commission_per, rebate_tottrade, commission_per_sell, commission_per_buy, transaction_limit, init_deposit_amount, init_deposit_efek_price', 'numerical'),
			array('client_name, e_mail1, reference_name', 'length', 'max'=>50),
			array('client_name_abbr, agreement_no, npwp_no, bank_acct_num, init_deposit_efek', 'length', 'max'=>20),
			array('client_type_1, client_type_2, client_type_3, religion, client_race, ic_type, def_contra_flg, cust_client_flg, susp_stat, desp_pref, stop_pay, print_flg, rem_own_trade, avg_flg, pph_appl_flg, levy_appl_flg, tax_on_interest, acopen_fee_flg, recov_charge_flg, amt_int_flg, internet_client, vat_appl_flg, int_accumulated, olt, approved_stat, trade_conf_send_to, trade_conf_send_freq, recommended_by_cd, id_copy_flg, npwp_copy_flg, koran_copy_flg, copy_other_flg', 'length', 'max'=>1),
			array('phone_num, hp_num, fax_num, hand_phone1, phone2_1, sid', 'length', 'max'=>15),
			array('client_title','length','max'=>6),
			array('client_ic_num, def_addr_1, def_addr_2, def_addr_3, old_ic_num, client_name_ext, recommended_by_other, copy_other', 'length', 'max'=>30),
			array('chq_payee_name', 'length', 'max'=>100),
			array('sett_off_cd, stk_exch, curr_cd, def_curr_cd, rem_cd, bank_cd, bank_brch_cd, regn_cd, branch_code', 'length', 'max'=>3),
			array('post_cd', 'length', 'max'=>6),
			array('contact_pers, def_city', 'length', 'max'=>40),
			array('rebate_basis, contra_days, biz_type', 'length', 'max'=>2),
			array('user_id, custodian_cd, cifs', 'length', 'max'=>8),
			array('upd_by, approved_by', 'length', 'max'=>10),
			array('subrek001_1, subrek004_1','length','is'=>4),
			array('subrek001_2, subrek004_2','length','is'=>2),
			array('copy_client, branch_change_flg, rem_change_flg, closed_date, client_cd, subrek001_1, subrek001_2, subrek004_1, subrek004_2, cif_opt, client_code_opt, client_birth_dt, next_rollover_dt, ac_expiry_dt, commit_fee_dt, roll_fee_dt, upd_dt, cre_dt, approved_dt, init_deposit_efek_date, client_class', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('closed_date, client_cd, cif_number, client_name, client_name_abbr, client_type_2, client_type_3, client_title, client_birth_dt, religion, acct_open_dt, client_race, client_ic_num, chq_payee_name, sett_off_cd, stk_exch, ic_type, curr_cd, def_curr_cd, rem_cd, bank_cd, bank_brch_cd, def_contra_flg, cust_client_flg, cr_lim, susp_stat, def_addr_1, def_addr_2, def_addr_3, post_cd, contact_pers, phone_num, hp_num, fax_num, e_mail1, hand_phone1, phone2_1, regn_cd, desp_pref, stop_pay, old_ic_num, print_flg, rem_own_trade, avg_flg, client_name_ext, branch_code, pph_appl_flg, levy_appl_flg, int_on_payable, int_on_receivable, int_on_adv_recd, grace_period, int_rec_days, int_pay_days, tax_on_interest, agreement_no, npwp_no, rebate, rebate_basis, commission_per, acopen_fee_flg, next_rollover_dt, ac_expiry_dt, commit_fee_dt, roll_fee_dt, recov_charge_flg, upd_dt, cre_dt, user_id, rebate_tottrade, amt_int_flg, internet_client, contra_days, vat_appl_flg, int_accumulated, bank_acct_num, custodian_cd, olt, sid, biz_type, cifs, upd_by, approved_dt, approved_by, approved_stat, reference_name, trade_conf_send_to, trade_conf_send_freq, def_city, commission_per_sell, commission_per_buy, recommended_by_cd, recommended_by_other, transaction_limit, init_deposit_amount, init_deposit_efek, init_deposit_efek_price, init_deposit_efek_date, id_copy_flg, npwp_copy_flg, koran_copy_flg, copy_other_flg, copy_other,client_birth_dt_date,client_birth_dt_month,client_birth_dt_year,acct_open_dt_date,acct_open_dt_month,acct_open_dt_year,next_rollover_dt_date,next_rollover_dt_month,next_rollover_dt_year,ac_expiry_dt_date,ac_expiry_dt_month,ac_expiry_dt_year,commit_fee_dt_date,commit_fee_dt_month,commit_fee_dt_year,roll_fee_dt_date,roll_fee_dt_month,roll_fee_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,approved_dt_date,approved_dt_month,approved_dt_year,init_deposit_efek_date_date,init_deposit_efek_date_month,init_deposit_efek_date_year', 'safe', 'on'=>'search'),
		);
	}

	public function checkCustodian()
	{
		if(!$this->custodian_cd)
		{
			if(1/*$this->isNewRecord || $this->acct_open_dt != date('Y-m-d')*/)
			{
				if(!$this->subrek001_1)$this->addError('subrek001_1','Subrek 001 no 1 must be filled');
				if(!$this->subrek001_2)$this->addError('subrek001_2','Subrek 001 no 2 must be filled');
				if(!$this->subrek004_1)$this->addError('subrek004_1','Subrek 004 no 1 must be filled');
				if(!$this->subrek004_2)$this->addError('subrek004_2','Subrek 004 no 2 must be filled');
			}
		}
	}

	public function checkEmail()
	{
		if($this->stop_pay == 1 && $this->e_mail1 == null)$this->addError('e_mail1','E-mail must be filled');
	}

	public function checkRegular()
	{
		if($this->client_type_3 == 'M' || $this->client_type_3 == 'L')
		{
			if(!Client::model()->find("client_cd IN (SELECT client_cd FROM MST_CIF WHERE cifs = '$this->cifs') AND client_type_3 IN (SELECT CL_TYPE3 FROM LST_TYPE3 WHERE MARGIN_CD = 'R') AND susp_stat = 'N'"))
				$this->addError('client_type_3', 'If client type 3 = MARGIN or SHORT SELL, client must have at least one active account with REGULAR type');
		}
	}
	
	public function validateFirstFour()
	{
		$old_client = Client::model()->find("client_cd = '$this->client_cd'");
		
		if($old_client)
		{
			$oldNoSpace = trim(str_replace(' ','',$old_client->client_name));
			$oldNoSpecChar = preg_replace('/[^A-Za-z]/', '', $oldNoSpace);
			
			$noSpace = trim(str_replace(' ','',$this->client_name));
			$noSpecChar = preg_replace('/[^A-Za-z]/', '', $noSpace);
			
			if(strlen($oldNoSpecChar) >= 4)$firstPart = 4;
			else 
			{
				$firstPart = strlen($oldNoSpecChar);
			}
			
			if(strtoupper(substr($oldNoSpecChar,0,$firstPart)) != strtoupper(substr($noSpecChar,0,$firstPart)))
			{
				$this->addError('client_name','Part of name that is used as Client Code cannot be changed');
			}
		}
	}
	
	public function genDefaultValue()
	{
		$this->cif_number = '9';	
	}
	
	 /* 
     *  AH: this function is for executing procedure 
     *  exec_status  : I/U/C 
     */ 
    public $valid_code = -999;
	public $valid_msg = '';
	
	/*
    public function executeSp($exec_status,$modelClientindi) 
    {
    	$this->genDefaultValue();
		 
        $connection  = Yii::app()->db; 
        $transaction = $connection->beginTransaction();     
      
        try{
        	
            $query  = "CALL SP_MST_CLIENT_VALIDATION(
            			:P_CLIENT_CD,:P_MARITAL_STATUS,:P_SPOUSE_NAME,:P_OCCUP_CODE,:P_BIZ_TYPE,
            			:P_UPD_STATUS,:P_VALID_CODE,:P_VALID_MSG,:P_ERROR_CODE,:P_ERROR_MSG)"; 
                         
            $command = $connection->createCommand($query); 
            
            $command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_MARITAL_STATUS",$modelClientindi->marital_status,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_NAME",$modelClientindi->spouse_name,PDO::PARAM_STR);
			$command->bindValue(":P_OCCUP_CODE",$modelClientindi->occup_code,PDO::PARAM_STR);
			$command->bindValue(":P_BIZ_TYPE",$this->biz_type,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
            $command->bindParam(":P_VALID_CODE",$this->valid_code,PDO::PARAM_INT,10); 
            $command->bindParam(":P_VALID_MSG",$this->valid_msg,PDO::PARAM_STR,100);
            $command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10); 
            $command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,100);
             
			 
            $command->bindValue(":P_APPROVED_DT",$this->approved_dt,PDO::PARAM_STR); 
            $command->bindValue(":P_APPROVED_BY",$this->approved_by,PDO::PARAM_STR); 
            $command->bindValue(":P_APPROVED_STS",$this->approved_stat,PDO::PARAM_STR); 
			
            $command->bindValue(":P_CIF_NUMBER",$this->cif_number,PDO::PARAM_STR);
            $command->bindValue(":P_CLIENT_NAME",$this->client_name,PDO::PARAM_STR);
            $command->bindValue(":P_CLIENT_NAME_ABBR",$this->client_name_abbr,PDO::PARAM_STR);
            $command->bindValue(":P_CLIENT_TYPE_1",$this->client_type_1,PDO::PARAM_STR);
            $command->bindValue(":P_CLIENT_TYPE_2",$this->client_type_2,PDO::PARAM_STR);
            $command->bindValue(":P_CLIENT_TYPE_3",$this->client_type_3,PDO::PARAM_STR);
            $command->bindValue(":P_CLIENT_TITLE",$this->client_title,PDO::PARAM_STR);
            $command->bindValue(":P_CLIENT_BIRTH_DT",$this->client_birth_dt,PDO::PARAM_STR);
            $command->bindValue(":P_RELIGION",$this->religion,PDO::PARAM_STR);
            $command->bindValue(":P_ACCT_OPEN_DT",$this->acct_open_dt,PDO::PARAM_STR);
            $command->bindValue(":P_CLIENT_RACE",$this->client_race,PDO::PARAM_STR);
            $command->bindValue(":P_CLIENT_IC_NUM",$this->client_ic_num,PDO::PARAM_STR);
            $command->bindValue(":P_CHQ_PAYEE_NAME",$this->chq_payee_name,PDO::PARAM_STR);
            $command->bindValue(":P_SETT_OFF_CD",$this->sett_off_cd,PDO::PARAM_STR);
            $command->bindValue(":P_STK_EXCH",$this->stk_exch,PDO::PARAM_STR);
            $command->bindValue(":P_IC_TYPE",$this->ic_type,PDO::PARAM_STR);
            $command->bindValue(":P_CURR_CD",$this->curr_cd,PDO::PARAM_STR);
            $command->bindValue(":P_DEF_CURR_CD",$this->def_curr_cd,PDO::PARAM_STR);
            $command->bindValue(":P_REM_CD",$this->rem_cd,PDO::PARAM_STR);
            $command->bindValue(":P_BANK_CD",$this->bank_cd,PDO::PARAM_STR);
            $command->bindValue(":P_BANK_BRCH_CD",$this->bank_brch_cd,PDO::PARAM_STR);
            $command->bindValue(":P_DEF_CONTRA_FLG",$this->def_contra_flg,PDO::PARAM_STR);
            $command->bindValue(":P_CUST_CLIENT_FLG",$this->cust_client_flg,PDO::PARAM_STR);
            $command->bindValue(":P_CR_LIM",$this->cr_lim,PDO::PARAM_STR);
            $command->bindValue(":P_SUSP_STAT",$this->susp_stat,PDO::PARAM_STR);
            $command->bindValue(":P_DEF_ADDR_1",$this->def_addr_1,PDO::PARAM_STR);
            $command->bindValue(":P_DEF_ADDR_2",$this->def_addr_2,PDO::PARAM_STR);
            $command->bindValue(":P_DEF_ADDR_3",$this->def_addr_3,PDO::PARAM_STR);
            $command->bindValue(":P_POST_CD",$this->post_cd,PDO::PARAM_STR);
            $command->bindValue(":P_CONTACT_PERS",$this->contact_pers,PDO::PARAM_STR);
            $command->bindValue(":P_PHONE_NUM",$this->phone_num,PDO::PARAM_STR);
            $command->bindValue(":P_HP_NUM",$this->hp_num,PDO::PARAM_STR);
            $command->bindValue(":P_FAX_NUM",$this->fax_num,PDO::PARAM_STR);
            $command->bindValue(":P_E_MAIL1",$this->e_mail1,PDO::PARAM_STR);
            $command->bindValue(":P_HAND_PHONE1",$this->hand_phone1,PDO::PARAM_STR);
            $command->bindValue(":P_PHONE2_1",$this->phone2_1,PDO::PARAM_STR);
            $command->bindValue(":P_REGN_CD",$this->regn_cd,PDO::PARAM_STR);
            $command->bindValue(":P_DESP_PREF",$this->desp_pref,PDO::PARAM_STR);
            $command->bindValue(":P_STOP_PAY",$this->stop_pay,PDO::PARAM_STR);
            $command->bindValue(":P_OLD_IC_NUM",$this->old_ic_num,PDO::PARAM_STR);
            $command->bindValue(":P_PRINT_FLG",$this->print_flg,PDO::PARAM_STR);
            $command->bindValue(":P_REM_OWN_TRADE",$this->rem_own_trade,PDO::PARAM_STR);
            $command->bindValue(":P_AVG_FLG",$this->avg_flg,PDO::PARAM_STR);
            $command->bindValue(":P_CLIENT_NAME_EXT",$this->client_name_ext,PDO::PARAM_STR);
            $command->bindValue(":P_BRANCH_CODE",$this->branch_code,PDO::PARAM_STR);
            $command->bindValue(":P_PPH_APPL_FLG",$this->pph_appl_flg,PDO::PARAM_STR);
            $command->bindValue(":P_LEVY_APPL_FLG",$this->levy_appl_flg,PDO::PARAM_STR);
            $command->bindValue(":P_INT_ON_PAYABLE",$this->int_on_payable,PDO::PARAM_STR);
            $command->bindValue(":P_INT_ON_RECEIVABLE",$this->int_on_receivable,PDO::PARAM_STR);
            $command->bindValue(":P_INT_ON_ADV_RECD",$this->int_on_adv_recd,PDO::PARAM_STR);
            $command->bindValue(":P_GRACE_PERIOD",$this->grace_period,PDO::PARAM_STR);
            $command->bindValue(":P_INT_REC_DAYS",$this->int_rec_days,PDO::PARAM_STR);
            $command->bindValue(":P_INT_PAY_DAYS",$this->int_pay_days,PDO::PARAM_STR);
            $command->bindValue(":P_TAX_ON_INTEREST",$this->tax_on_interest,PDO::PARAM_STR);
            $command->bindValue(":P_AGREEMENT_NO",$this->agreement_no,PDO::PARAM_STR);
            $command->bindValue(":P_NPWP_NO",$this->npwp_no,PDO::PARAM_STR);
            $command->bindValue(":P_REBATE",$this->rebate,PDO::PARAM_STR);
            $command->bindValue(":P_REBATE_BASIS",$this->rebate_basis,PDO::PARAM_STR);
            $command->bindValue(":P_COMMISSION_PER",$this->commission_per,PDO::PARAM_STR);
            $command->bindValue(":P_ACOPEN_FEE_FLG",$this->acopen_fee_flg,PDO::PARAM_STR);
            $command->bindValue(":P_NEXT_ROLLOVER_DT",$this->next_rollover_dt,PDO::PARAM_STR);
            $command->bindValue(":P_AC_EXPIRY_DT",$this->ac_expiry_dt,PDO::PARAM_STR);
            $command->bindValue(":P_COMMIT_FEE_DT",$this->commit_fee_dt,PDO::PARAM_STR);
            $command->bindValue(":P_ROLL_FEE_DT",$this->roll_fee_dt,PDO::PARAM_STR);
            $command->bindValue(":P_RECOV_CHARGE_FLG",$this->recov_charge_flg,PDO::PARAM_STR);
            $command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
            $command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
            $command->bindValue(":P_REBATE_TOTTRADE",$this->rebate_tottrade,PDO::PARAM_STR);
            $command->bindValue(":P_AMT_INT_FLG",$this->amt_int_flg,PDO::PARAM_STR);
            $command->bindValue(":P_INTERNET_CLIENT",$this->internet_client,PDO::PARAM_STR);
            $command->bindValue(":P_CONTRA_DAYS",$this->contra_days,PDO::PARAM_STR);
            $command->bindValue(":P_VAT_APPL_FLG",$this->vat_appl_flg,PDO::PARAM_STR);
            $command->bindValue(":P_INT_ACCUMULATED",$this->int_accumulated,PDO::PARAM_STR);
            $command->bindValue(":P_BANK_ACCT_NUM",$this->bank_acct_num,PDO::PARAM_STR);
            $command->bindValue(":P_CUSTODIAN_CD",$this->custodian_cd,PDO::PARAM_STR);
            $command->bindValue(":P_OLT",$this->olt,PDO::PARAM_STR);
            $command->bindValue(":P_SID",$this->sid,PDO::PARAM_STR);
            $command->bindValue(":P_BIZ_TYPE",$this->biz_type,PDO::PARAM_STR);
            $command->bindValue(":P_CIFS",$this->cifs,PDO::PARAM_STR);
            $command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
            $command->bindValue(":P_APPROVED_DT",$this->approved_dt,PDO::PARAM_STR);
            $command->bindValue(":P_APPROVED_BY",$this->approved_by,PDO::PARAM_STR);
            $command->bindValue(":P_APPROVED_STS",$this->approved_stat,PDO::PARAM_STR);
             
            $command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR); 
            $command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR); 
            $command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR); 
            $command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR); 
            $command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR); 
            $command->bindValue(":P_APPROVED_DT",$this->approved_dt,PDO::PARAM_STR); 
            $command->bindValue(":P_APPROVED_BY",$this->approved_by,PDO::PARAM_STR); 
            $command->bindValue(":P_APPROVED_STS",$this->approved_stat,PDO::PARAM_STR); 
            $command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR); 
            $command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR); 
            
            $command->execute(); 
            $transaction->commit(); 
        }catch(Exception $ex){ 
            $transaction->rollback(); 
            if($this->error_code == -999) 
                $this->error_msg = $ex->getMessage(); 
        } 
         
        if($this->error_code < 0) 
            $this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
         
        return $this->error_code; 
    }
   */
   
   public function executeSp($exec_status,$old_client_cd,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_MST_CLIENT_UPD(
						:P_SEARCH_CLIENT_CD,
						:P_CLIENT_CD,
						:P_CIF_NUMBER,
						:P_CLIENT_NAME,
						:P_CLIENT_NAME_ABBR,
						:P_CLIENT_TYPE_1,
						:P_CLIENT_TYPE_2,
						:P_CLIENT_TYPE_3,
						:P_SUBREK001,
						:P_SUBREK004,
						:P_BRANCH_CHANGE_FLG,
						:P_REM_CHANGE_FLG,
						:P_COPY_FLG,
						:P_CLIENT_TITLE,
						TO_DATE(:P_CLIENT_BIRTH_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_RELIGION,
						TO_DATE(:P_ACCT_OPEN_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_CLIENT_RACE,
						:P_CLIENT_IC_NUM,
						:P_CHQ_PAYEE_NAME,
						:P_SETT_OFF_CD,
						:P_STK_EXCH,
						:P_IC_TYPE,
						:P_CURR_CD,
						:P_DEF_CURR_CD,
						:P_REM_CD,
						:P_BANK_CD,
						:P_BANK_BRCH_CD,
						:P_DEF_CONTRA_FLG,
						:P_CUST_CLIENT_FLG,
						:P_CR_LIM,
						:P_SUSP_STAT,
						:P_DEF_ADDR_1,
						:P_DEF_ADDR_2,
						:P_DEF_ADDR_3,
						:P_POST_CD,
						:P_CONTACT_PERS,
						:P_PHONE_NUM,
						:P_HP_NUM,
						:P_FAX_NUM,
						:P_E_MAIL1,
						:P_HAND_PHONE1,
						:P_PHONE2_1,
						:P_REGN_CD,
						:P_DESP_PREF,
						:P_STOP_PAY,
						:P_OLD_IC_NUM,
						:P_PRINT_FLG,
						:P_REM_OWN_TRADE,
						:P_AVG_FLG,
						:P_CLIENT_NAME_EXT,
						:P_BRANCH_CODE,
						:P_PPH_APPL_FLG,
						:P_LEVY_APPL_FLG,
						:P_INT_ON_PAYABLE,
						:P_INT_ON_RECEIVABLE,
						:P_INT_ON_ADV_RECD,
						:P_GRACE_PERIOD,
						:P_INT_REC_DAYS,
						:P_INT_PAY_DAYS,
						:P_TAX_ON_INTEREST,
						:P_AGREEMENT_NO,
						:P_NPWP_NO,
						:P_REBATE,
						:P_REBATE_BASIS,
						:P_COMMISSION_PER,
						:P_ACOPEN_FEE_FLG,
						TO_DATE(:P_NEXT_ROLLOVER_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_AC_EXPIRY_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_COMMIT_FEE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_ROLL_FEE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_RECOV_CHARGE_FLG,
						:P_REBATE_TOTTRADE,
						:P_AMT_INT_FLG,
						:P_INTERNET_CLIENT,
						:P_CONTRA_DAYS,
						:P_VAT_APPL_FLG,
						:P_INT_ACCUMULATED,
						:P_BANK_ACCT_NUM,
						:P_CUSTODIAN_CD,
						:P_OLT,
						:P_SID,
						:P_BIZ_TYPE,
						:P_CIFS,
						:P_REFERENCE_NAME,
						:P_TRADE_CONF_SEND_TO,
						:P_TRADE_CONF_SEND_FREQ,
						:P_DEF_CITY,
						:P_COMMISSION_PER_SELL,
						:P_COMMISSION_PER_BUY,
						:P_RECOMMENDED_BY_CD,
						:P_RECOMMENDED_BY_OTHER,
						:P_TRANSACTION_LIMIT,
						:P_INIT_DEPOSIT_AMOUNT,
						:P_INIT_DEPOSIT_EFEK,
						:P_INIT_DEPOSIT_EFEK_PRICE,
						:P_INIT_DEPOSIT_EFEK_DATE,
						:P_ID_COPY_FLG,
						:P_NPWP_COPY_FLG,
						:P_KORAN_COPY_FLG,
						:P_COPY_OTHER_FLG,
						:P_COPY_OTHER,
						:P_CLIENT_CLASS,
						:P_SUSP_TRX,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPDATE_SEQ,
						:P_RECORD_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_CLIENT_CD",$old_client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CIF_NUMBER",$this->cif_number,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_NAME",$this->client_name,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_NAME_ABBR",$this->client_name_abbr,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE_1",$this->client_type_1,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE_2",$this->client_type_2,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE_3",$this->client_type_3,PDO::PARAM_STR);
			$command->bindValue(":P_SUBREK001",$this->subrek001,PDO::PARAM_STR);
			$command->bindValue(":P_SUBREK004",$this->subrek004,PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH_CHANGE_FLG",$this->branch_change_flg,PDO::PARAM_STR);
			$command->bindValue(":P_REM_CHANGE_FLG",$this->rem_change_flg,PDO::PARAM_STR);
			$command->bindValue(":P_COPY_FLG",$this->copy_client?1:0,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TITLE",null,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_BIRTH_DT",$this->client_birth_dt,PDO::PARAM_STR);
			$command->bindValue(":P_RELIGION",$this->religion,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_OPEN_DT",$this->acct_open_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_RACE",$this->client_race,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_IC_NUM",$this->client_ic_num,PDO::PARAM_STR);
			$command->bindValue(":P_CHQ_PAYEE_NAME",$this->chq_payee_name,PDO::PARAM_STR);
			$command->bindValue(":P_SETT_OFF_CD",$this->sett_off_cd,PDO::PARAM_STR);
			$command->bindValue(":P_STK_EXCH",$this->stk_exch,PDO::PARAM_STR);
			$command->bindValue(":P_IC_TYPE",$this->ic_type,PDO::PARAM_STR);
			$command->bindValue(":P_CURR_CD",$this->curr_cd,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_CURR_CD",$this->def_curr_cd,PDO::PARAM_STR);
			$command->bindValue(":P_REM_CD",$this->rem_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_CD",$this->bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_BRCH_CD",$this->bank_brch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_CONTRA_FLG",$this->def_contra_flg,PDO::PARAM_STR);
			$command->bindValue(":P_CUST_CLIENT_FLG",$this->cust_client_flg,PDO::PARAM_STR);
			$command->bindValue(":P_CR_LIM",$this->cr_lim,PDO::PARAM_STR);
			$command->bindValue(":P_SUSP_STAT",$this->susp_stat,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_1",$this->def_addr_1,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_2",$this->def_addr_2,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_3",$this->def_addr_3,PDO::PARAM_STR);
			$command->bindValue(":P_POST_CD",$this->post_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CONTACT_PERS",$this->contact_pers,PDO::PARAM_STR);
			$command->bindValue(":P_PHONE_NUM",$this->phone_num,PDO::PARAM_STR);
			$command->bindValue(":P_HP_NUM",$this->hp_num,PDO::PARAM_STR);
			$command->bindValue(":P_FAX_NUM",$this->fax_num,PDO::PARAM_STR);
			$command->bindValue(":P_E_MAIL1",$this->e_mail1,PDO::PARAM_STR);
			$command->bindValue(":P_HAND_PHONE1",$this->hand_phone1,PDO::PARAM_STR);
			$command->bindValue(":P_PHONE2_1",$this->phone2_1,PDO::PARAM_STR);
			$command->bindValue(":P_REGN_CD",$this->regn_cd,PDO::PARAM_STR);
			$command->bindValue(":P_DESP_PREF",$this->desp_pref,PDO::PARAM_STR);
			$command->bindValue(":P_STOP_PAY",$this->stop_pay,PDO::PARAM_STR);
			$command->bindValue(":P_OLD_IC_NUM",$this->old_ic_num,PDO::PARAM_STR);
			$command->bindValue(":P_PRINT_FLG",$this->print_flg,PDO::PARAM_STR);
			$command->bindValue(":P_REM_OWN_TRADE",$this->rem_own_trade,PDO::PARAM_STR);
			$command->bindValue(":P_AVG_FLG",$this->avg_flg,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_NAME_EXT",$this->client_name_ext,PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH_CODE",$this->branch_code,PDO::PARAM_STR);
			$command->bindValue(":P_PPH_APPL_FLG",$this->pph_appl_flg,PDO::PARAM_STR);
			$command->bindValue(":P_LEVY_APPL_FLG",$this->levy_appl_flg,PDO::PARAM_STR);
			$command->bindValue(":P_INT_ON_PAYABLE",$this->int_on_payable,PDO::PARAM_STR);
			$command->bindValue(":P_INT_ON_RECEIVABLE",$this->int_on_receivable,PDO::PARAM_STR);
			$command->bindValue(":P_INT_ON_ADV_RECD",$this->int_on_adv_recd,PDO::PARAM_STR);
			$command->bindValue(":P_GRACE_PERIOD",$this->grace_period,PDO::PARAM_STR);
			$command->bindValue(":P_INT_REC_DAYS",$this->int_rec_days,PDO::PARAM_STR);
			$command->bindValue(":P_INT_PAY_DAYS",$this->int_pay_days,PDO::PARAM_STR);
			$command->bindValue(":P_TAX_ON_INTEREST",$this->tax_on_interest,PDO::PARAM_STR);
			$command->bindValue(":P_AGREEMENT_NO",$this->agreement_no,PDO::PARAM_STR);
			$command->bindValue(":P_NPWP_NO",$this->npwp_no,PDO::PARAM_STR);
			$command->bindValue(":P_REBATE",$this->rebate,PDO::PARAM_STR);
			$command->bindValue(":P_REBATE_BASIS",$this->rebate_basis,PDO::PARAM_STR);
			$command->bindValue(":P_COMMISSION_PER",$this->commission_per,PDO::PARAM_STR);
			$command->bindValue(":P_ACOPEN_FEE_FLG",$this->acopen_fee_flg,PDO::PARAM_STR);
			$command->bindValue(":P_NEXT_ROLLOVER_DT",$this->next_rollover_dt,PDO::PARAM_STR);
			$command->bindValue(":P_AC_EXPIRY_DT",$this->ac_expiry_dt,PDO::PARAM_STR);
			$command->bindValue(":P_COMMIT_FEE_DT",$this->commit_fee_dt,PDO::PARAM_STR);
			$command->bindValue(":P_ROLL_FEE_DT",$this->roll_fee_dt,PDO::PARAM_STR);
			$command->bindValue(":P_RECOV_CHARGE_FLG",$this->recov_charge_flg,PDO::PARAM_STR);		
			$command->bindValue(":P_REBATE_TOTTRADE",$this->rebate_tottrade,PDO::PARAM_STR);
			$command->bindValue(":P_AMT_INT_FLG",$this->amt_int_flg,PDO::PARAM_STR);
			$command->bindValue(":P_INTERNET_CLIENT",$this->internet_client,PDO::PARAM_STR);
			$command->bindValue(":P_CONTRA_DAYS",$this->contra_days,PDO::PARAM_STR);
			$command->bindValue(":P_VAT_APPL_FLG",$this->vat_appl_flg,PDO::PARAM_STR);
			$command->bindValue(":P_INT_ACCUMULATED",$this->int_accumulated,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_ACCT_NUM",$this->bank_acct_num,PDO::PARAM_STR);
			$command->bindValue(":P_CUSTODIAN_CD",$this->custodian_cd,PDO::PARAM_STR);
			$command->bindValue(":P_OLT",$this->olt,PDO::PARAM_STR);
			$command->bindValue(":P_SID",$this->sid,PDO::PARAM_STR);
			$command->bindValue(":P_BIZ_TYPE",$this->biz_type,PDO::PARAM_STR);
			$command->bindValue(":P_CIFS",$this->cifs,PDO::PARAM_STR);
			$command->bindValue(":P_REFERENCE_NAME",$this->reference_name,PDO::PARAM_STR);
			$command->bindValue(":P_TRADE_CONF_SEND_TO",$this->trade_conf_send_to,PDO::PARAM_STR);
			$command->bindValue(":P_TRADE_CONF_SEND_FREQ",$this->trade_conf_send_freq,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_CITY",$this->def_city,PDO::PARAM_STR);
			$command->bindValue(":P_COMMISSION_PER_SELL",$this->commission_per_sell,PDO::PARAM_STR);
			$command->bindValue(":P_COMMISSION_PER_BUY",$this->commission_per_buy,PDO::PARAM_STR);
			$command->bindValue(":P_RECOMMENDED_BY_CD",$this->recommended_by_cd,PDO::PARAM_STR);
			$command->bindValue(":P_RECOMMENDED_BY_OTHER",$this->recommended_by_other,PDO::PARAM_STR);
			$command->bindValue(":P_TRANSACTION_LIMIT",$this->transaction_limit,PDO::PARAM_STR);
			$command->bindValue(":P_INIT_DEPOSIT_AMOUNT",$this->init_deposit_amount,PDO::PARAM_STR);
			$command->bindValue(":P_INIT_DEPOSIT_EFEK",$this->init_deposit_efek,PDO::PARAM_STR);
			$command->bindValue(":P_INIT_DEPOSIT_EFEK_PRICE",$this->init_deposit_efek_price,PDO::PARAM_STR);
			$command->bindValue(":P_INIT_DEPOSIT_EFEK_DATE",$this->init_deposit_efek_date,PDO::PARAM_STR);
			$command->bindValue(":P_ID_COPY_FLG",$this->id_copy_flg,PDO::PARAM_STR);
			$command->bindValue(":P_NPWP_COPY_FLG",$this->npwp_copy_flg,PDO::PARAM_STR);
			$command->bindValue(":P_KORAN_COPY_FLG",$this->koran_copy_flg,PDO::PARAM_STR);
			$command->bindValue(":P_COPY_OTHER_FLG",$this->copy_other_flg,PDO::PARAM_STR);
			$command->bindValue(":P_COPY_OTHER",$this->copy_other,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CLASS",$this->client_class,PDO::PARAM_STR);
			$command->bindValue(":P_SUSP_TRX",$this->susp_trx,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);			
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_RECORD_SEQ",$record_seq,PDO::PARAM_STR);
			
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

	public function executeSpInterest($exec_status,$old_client_cd,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_INTEREST_TYPE_UPD(
						:P_SEARCH_CLIENT_CD,
						:P_AMT_INT_FLG,
						:P_INT_ACCUMULATED,
						:P_TAX_ON_INTEREST,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						:P_UPD_BY,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_UPDATE_DATE,
						:P_UPDATE_SEQ,
						:P_RECORD_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_CLIENT_CD",$old_client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_AMT_INT_FLG",$this->amt_int_flg,PDO::PARAM_STR);
			$command->bindValue(":P_INT_ACCUMULATED",$this->int_accumulated,PDO::PARAM_STR);
			$command->bindValue(":P_TAX_ON_INTEREST",$this->tax_on_interest,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);			
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindParam(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR,30);
			$command->bindParam(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR,10);
			$command->bindValue(":P_RECORD_SEQ",$record_seq,PDO::PARAM_STR);
			
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

	public function relations()
	{
		return array(
			'lsttype1' => array(self::BELONGS_TO, 'Lsttype1', array('client_type_1'=>'cl_type1')),
		);
	}

	public function attributeLabels()
	{
		return array(
			'searched_cif' => 'CIF',
		
			'client_type_1' => 'Client Type I',
			'client_type_2' => 'Client Type II',
			'client_type_3' => 'Client Type III',
			
			'contact_pers' => 'Contact Person',
			'print_flg' => 'Trade Confirmation Send Via',
			'rebate_basis' => 'Type',
		
			'acct_open_dt' => 'Account Opening',
			'acct_open'=>'Account Opening Date',
		
			//AR: Tab_Client_Individual Client_Individual_Data
			'phone_num' => 'Phone Number 1',
			'phone2_1' => 'Phone Number 2',
			
			'hp_num' => 'Handphone Number 1',
			'hand_phone1' => 'Handphone Number2',
			
			'client_cd' => 'Client Code',
			'cif_number' => 'Cif Number',
			'client_name' => 'Name',
			'client_name_abbr' => 'Client Name Abbr',
			'client_title' => 'Client Title',
			'client_birth_dt' => 'Client Birth Date',
			'religion' => 'Religion',
			
			'client_race' => 'Client Race',
			'client_ic_num' => 'ID Number',
			'chq_payee_name' => 'Chq Payee Name',
			'sett_off_cd' => 'Sett Off Code',
			'stk_exch' => 'Stk Exch',
			'ic_type' => 'ID Type',
			'curr_cd' => 'Curr Code',
			'def_curr_cd' => 'Def Curr Code',
			'rem_cd' => 'Sales/Remisier',
			'bank_cd' => 'Bank Code',
			'bank_brch_cd' => 'Bank Brch Code',
			'def_contra_flg' => 'Def Contra Flg',
			'cust_client_flg' => 'Cust Client Flg',
			'cr_lim' => 'Basic Limit',
			'susp_stat' => 'Status',
			'def_addr_1' => 'Address',
			'def_addr_2' => 'Def Addr 2',
			'def_addr_3' => 'Def Addr 3',
			'post_cd' => 'Post Code',
			'def_city' => 'City',
			
			
			'fax_num' => 'Fax Num',
			'e_mail1' => 'E-Mail',
			
			
			'regn_cd' => 'Regn Code',
			'desp_pref' => 'Desp Pref',
			'stop_pay' => 'E-mail Default',
			'old_ic_num' => 'Old Ic Num',
			
			'rem_own_trade' => 'Rem Own Trade',
			'avg_flg' => 'Avg Flg',
			'client_name_ext' => 'Client Name Ext',
			'branch_code' => 'Branch Code',
			'pph_appl_flg' => 'Pph Appl Flg',
			'levy_appl_flg' => 'Levy Appl Flg',
			'int_on_payable' => 'Int On Payable',
			'int_on_receivable' => 'Int On Receivable',
			'int_on_adv_recd' => 'Int On Adv Recd',
			'grace_period' => 'Grace Period',
			'int_rec_days' => 'Int Rec Days',
			'int_pay_days' => 'Int Pay Days',
			'tax_on_interest' => 'Tax On Interest',
			'agreement_no' => 'Sub Rek Regular',
			'npwp_no' => 'Npwp No',
			'rebate' => 'Rebate',
			
			'commission_per' => 'Commission %',
			'acopen_fee_flg' => 'Acopen Fee Flg',
			'next_rollover_dt' => 'Next Rollover Date',
			'ac_expiry_dt' => 'Ac Expiry Date',
			'commit_fee_dt' => 'Commit Fee Date',
			'roll_fee_dt' => 'Roll Fee Date',
			'recov_charge_flg' => 'Recov Charge Flg',
			'upd_dt' => 'Upd Date',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'rebate_tottrade' => 'Rebate Tottrade',
			'amt_int_flg' => 'Amt Int Flg',
			'internet_client' => 'Internet Client',
			'contra_days' => 'Contra Days',
			'vat_appl_flg' => 'Vat Appl Flg',
			'int_accumulated' => 'Int Accumulated',
			'bank_acct_num' => 'Bank Acct Num',
			'custodian_cd' => 'Bank Custodian',
			'olt' => 'OLT',
			'sid' => 'SID',
			'biz_type' => 'Biz Type',
			'cifs' => 'CIF',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
			
			'subrek001_1' => 'Sub Rekening Efek',
			'closed_date' => 'Closed Date',
			
			'client_class' => 'Classification',
			'old_ic_num' => 'Old Client Code',
			'recommended_by_cd' => 'Recommended By',
			
			'trade_conf_send_to' => 'Trade Confirmation Dikirim Ke',
			'trade_conf_send_freq' => 'Trade Confirmation Dikirim Setiap',
			
			'copy_client' => 'Copy Data from Client',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->select = "t.client_cd, client_name, branch_code, rem_cd, client_type_3, a.subrek001, SID";
		$criteria->join = "LEFT JOIN V_CLIENT_SUBREK14 a ON t.client_cd = a.client_cd";
		
		$criteria->compare('UPPER(t.client_cd)',strtoupper($this->client_cd),true);
		$criteria->compare('cif_number',$this->cif_number);
		$criteria->compare('UPPER(client_name)',strtoupper($this->client_name),true);
		$criteria->compare('client_name_abbr',$this->client_name_abbr,true);
		//$criteria->compare('client_type_1',$this->client_type_1,true);
		$criteria->addCondition("client_type_1 IN ($this->client_type_1)");
		$criteria->compare('client_type_2',$this->client_type_2,true);
		$criteria->compare('client_type_3',$this->client_type_3,true);
		$criteria->compare('client_title',$this->client_title,true);

		if(!empty($this->client_birth_dt_date))
			$criteria->addCondition("TO_CHAR(t.client_birth_dt,'DD') LIKE '%".($this->client_birth_dt_date)."%'");
		if(!empty($this->client_birth_dt_month))
			$criteria->addCondition("TO_CHAR(t.client_birth_dt,'MM') LIKE '%".($this->client_birth_dt_month)."%'");
		if(!empty($this->client_birth_dt_year))
			$criteria->addCondition("TO_CHAR(t.client_birth_dt,'YYYY') LIKE '%".($this->client_birth_dt_year)."%'");		$criteria->compare('religion',$this->religion,true);

		if(!empty($this->acct_open_dt_date))
			$criteria->addCondition("TO_CHAR(t.acct_open_dt,'DD') LIKE '%".($this->acct_open_dt_date)."%'");
		if(!empty($this->acct_open_dt_month))
			$criteria->addCondition("TO_CHAR(t.acct_open_dt,'MM') LIKE '%".($this->acct_open_dt_month)."%'");
		if(!empty($this->acct_open_dt_year))
			$criteria->addCondition("TO_CHAR(t.acct_open_dt,'YYYY') LIKE '%".($this->acct_open_dt_year)."%'");		$criteria->compare('client_race',$this->client_race,true);
		$criteria->compare('client_ic_num',$this->client_ic_num,true);
		$criteria->compare('chq_payee_name',$this->chq_payee_name,true);
		$criteria->compare('sett_off_cd',$this->sett_off_cd,true);
		$criteria->compare('stk_exch',$this->stk_exch,true);
		$criteria->compare('ic_type',$this->ic_type,true);
		$criteria->compare('curr_cd',$this->curr_cd,true);
		$criteria->compare('def_curr_cd',$this->def_curr_cd,true);
		$criteria->compare('rem_cd',$this->rem_cd,true);
		$criteria->compare('bank_cd',$this->bank_cd,true);
		$criteria->compare('bank_brch_cd',$this->bank_brch_cd,true);
		$criteria->compare('def_contra_flg',$this->def_contra_flg,true);
		$criteria->compare('cust_client_flg',$this->cust_client_flg,true);
		$criteria->compare('cr_lim',$this->cr_lim);
		$criteria->compare('susp_stat',$this->susp_stat);
		$criteria->compare('def_addr_1',$this->def_addr_1,true);
		$criteria->compare('def_addr_2',$this->def_addr_2,true);
		$criteria->compare('def_addr_3',$this->def_addr_3,true);
		$criteria->compare('post_cd',$this->post_cd,true);
		$criteria->compare('contact_pers',$this->contact_pers,true);
		$criteria->compare('phone_num',$this->phone_num,true);
		$criteria->compare('hp_num',$this->hp_num,true);
		$criteria->compare('fax_num',$this->fax_num,true);
		$criteria->compare('e_mail1',$this->e_mail1,true);
		$criteria->compare('hand_phone1',$this->hand_phone1,true);
		$criteria->compare('phone2_1',$this->phone2_1,true);
		$criteria->compare('regn_cd',$this->regn_cd,true);
		$criteria->compare('desp_pref',$this->desp_pref,true);
		$criteria->compare('stop_pay',$this->stop_pay,true);
		$criteria->compare('old_ic_num',$this->old_ic_num,true);
		$criteria->compare('print_flg',$this->print_flg,true);
		$criteria->compare('rem_own_trade',$this->rem_own_trade,true);
		$criteria->compare('avg_flg',$this->avg_flg,true);
		$criteria->compare('client_name_ext',$this->client_name_ext,true);
		$criteria->compare('branch_code',$this->branch_code,true);
		$criteria->compare('pph_appl_flg',$this->pph_appl_flg,true);
		$criteria->compare('levy_appl_flg',$this->levy_appl_flg,true);
		$criteria->compare('int_on_payable',$this->int_on_payable);
		$criteria->compare('int_on_receivable',$this->int_on_receivable);
		$criteria->compare('int_on_adv_recd',$this->int_on_adv_recd);
		$criteria->compare('grace_period',$this->grace_period);
		$criteria->compare('int_rec_days',$this->int_rec_days);
		$criteria->compare('int_pay_days',$this->int_pay_days);
		$criteria->compare('tax_on_interest',$this->tax_on_interest,true);
		$criteria->compare('agreement_no',$this->agreement_no,true);
		$criteria->compare('npwp_no',$this->npwp_no,true);
		$criteria->compare('rebate',$this->rebate);
		$criteria->compare('rebate_basis',$this->rebate_basis,true);
		$criteria->compare('commission_per',$this->commission_per);
		$criteria->compare('acopen_fee_flg',$this->acopen_fee_flg,true);

		if(!empty($this->next_rollover_dt_date))
			$criteria->addCondition("TO_CHAR(t.next_rollover_dt,'DD') LIKE '%".($this->next_rollover_dt_date)."%'");
		if(!empty($this->next_rollover_dt_month))
			$criteria->addCondition("TO_CHAR(t.next_rollover_dt,'MM') LIKE '%".($this->next_rollover_dt_month)."%'");
		if(!empty($this->next_rollover_dt_year))
			$criteria->addCondition("TO_CHAR(t.next_rollover_dt,'YYYY') LIKE '%".($this->next_rollover_dt_year)."%'");
		if(!empty($this->ac_expiry_dt_date))
			$criteria->addCondition("TO_CHAR(t.ac_expiry_dt,'DD') LIKE '%".($this->ac_expiry_dt_date)."%'");
		if(!empty($this->ac_expiry_dt_month))
			$criteria->addCondition("TO_CHAR(t.ac_expiry_dt,'MM') LIKE '%".($this->ac_expiry_dt_month)."%'");
		if(!empty($this->ac_expiry_dt_year))
			$criteria->addCondition("TO_CHAR(t.ac_expiry_dt,'YYYY') LIKE '%".($this->ac_expiry_dt_year)."%'");
		if(!empty($this->commit_fee_dt_date))
			$criteria->addCondition("TO_CHAR(t.commit_fee_dt,'DD') LIKE '%".($this->commit_fee_dt_date)."%'");
		if(!empty($this->commit_fee_dt_month))
			$criteria->addCondition("TO_CHAR(t.commit_fee_dt,'MM') LIKE '%".($this->commit_fee_dt_month)."%'");
		if(!empty($this->commit_fee_dt_year))
			$criteria->addCondition("TO_CHAR(t.commit_fee_dt,'YYYY') LIKE '%".($this->commit_fee_dt_year)."%'");
		if(!empty($this->roll_fee_dt_date))
			$criteria->addCondition("TO_CHAR(t.roll_fee_dt,'DD') LIKE '%".($this->roll_fee_dt_date)."%'");
		if(!empty($this->roll_fee_dt_month))
			$criteria->addCondition("TO_CHAR(t.roll_fee_dt,'MM') LIKE '%".($this->roll_fee_dt_month)."%'");
		if(!empty($this->roll_fee_dt_year))
			$criteria->addCondition("TO_CHAR(t.roll_fee_dt,'YYYY') LIKE '%".($this->roll_fee_dt_year)."%'");		$criteria->compare('recov_charge_flg',$this->recov_charge_flg,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".($this->upd_dt_date)."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".($this->upd_dt_month)."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".($this->upd_dt_year)."%'");
		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".($this->cre_dt_date)."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".($this->cre_dt_month)."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".($this->cre_dt_year)."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('rebate_tottrade',$this->rebate_tottrade);
		$criteria->compare('amt_int_flg',$this->amt_int_flg,true);
		$criteria->compare('internet_client',$this->internet_client,true);
		$criteria->compare('contra_days',$this->contra_days,true);
		$criteria->compare('vat_appl_flg',$this->vat_appl_flg,true);
		$criteria->compare('int_accumulated',$this->int_accumulated,true);
		$criteria->compare('bank_acct_num',$this->bank_acct_num,true);
		$criteria->compare('custodian_cd',$this->custodian_cd,true);
		$criteria->compare('olt',$this->olt,true);
		$criteria->compare('UPPER(sid)',strtoupper($this->sid),true);
		$criteria->compare('biz_type',$this->biz_type,true);
		$criteria->compare('UPPER(cifs)',strtoupper($this->cifs),true);
		$criteria->compare('upd_by',$this->upd_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".($this->approved_dt_date)."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".($this->approved_dt_month)."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".($this->approved_dt_year)."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);
		
		$sort = new CSort;
		$sort->defaultOrder = 'client_cd';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}