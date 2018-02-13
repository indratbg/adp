<?php

/**
 * This is the model class for table "MST_CIF".
 *
 * The followings are the available columns in table 'MST_CIF':
 * @property string $cifs
 * @property string $cif_name
 * @property string $sid
 * @property string $client_type_1
 * @property string $client_type_2
 * @property string $npwp_no
 * @property string $client_title
 * @property string $mother_name
 * @property string $client_birth_dt
 * @property string $client_ic_num
 * @property string $ic_type
 * @property string $ic_expiry_dt
 * @property string $def_addr_1
 * @property string $def_addr_2
 * @property string $def_addr_3
 * @property string $country
 * @property string $post_cd
 * @property string $phone_num
 * @property string $hp_num
 * @property string $fax_num
 * @property string $hand_phone1
 * @property string $phone2_1
 * @property string $e_mail1
 * @property string $inst_type
 * @property string $inst_type_txt
 * @property string $annual_income_cd
 * @property string $annual_income
 * @property string $funds_code
 * @property string $source_of_funds
 * @property string $purpose01
 * @property string $purpose02
 * @property string $purpose03
 * @property string $purpose04
 * @property string $purpose05
 * @property string $purpose06
 * @property string $purpose07
 * @property string $purpose08
 * @property string $purpose09
 * @property string $purpose10
 * @property string $purpose11
 * @property string $purpose90
 * @property string $purpose_lainnya
 * @property string $invesment_period
 * @property string $net_asset_cd
 * @property string $net_asset
 * @property string $net_asset_yr
 * @property string $addl_fund_cd
 * @property string $addl_fund
 * @property string $biz_type
 * @property string $act_first
 * @property string $act_first_dt
 * @property string $act_last
 * @property string $act_last_dt
 * @property string $siup_no
 * @property string $tdp_no
 * @property string $modal_dasar
 * @property string $modal_disetor
 * @property string $industry_cd
 * @property string $industry
 * @property string $cre_dt
 * @property string $cre_user_id
 * @property string $upd_dt
 * @property string $upd_user_id
 * @property string $autho_person_name
 * @property string $autho_person_ic_type
 * @property string $autho_person_ic_num
 * @property string $autho_person_position
 * @property string $profit_cd
 * @property string $profit
 * @property string $tempat_pendirian
 * @property string $skd_no
 * @property string $skd_expiry
 * @property string $tax_id
 * @property string $autho_person_ic_expiry
 * @property string $def_city
 * @property string $npwp_date
 * @property string $direct_sid
 * @property string $asset_owner
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Cif extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $client_birth_dt_date;
	public $client_birth_dt_month;
	public $client_birth_dt_year;

	public $ic_expiry_dt_date;
	public $ic_expiry_dt_month;
	public $ic_expiry_dt_year;

	public $act_first_dt_date;
	public $act_first_dt_month;
	public $act_first_dt_year;

	public $act_last_dt_date;
	public $act_last_dt_month;
	public $act_last_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $skd_expiry_date;
	public $skd_expiry_month;
	public $skd_expiry_year;

	public $autho_person_ic_expiry_date;
	public $autho_person_ic_expiry_month;
	public $autho_person_ic_expiry_year;

	public $npwp_date_date;
	public $npwp_date_month;
	public $npwp_date_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $client_cd;
	public $search_cifs;
	
	public $custodian = FALSE;

	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function afterFind()
	{
		if($this->act_first_dt)$this->act_first_dt=DateTime::createFromFormat('Y-m-d H:i:s',$this->act_first_dt)->format('d/m/Y');
		if($this->act_last_dt)$this->act_last_dt=DateTime::createFromFormat('Y-m-d H:i:s',$this->act_last_dt)->format('d/m/Y');
		if($this->skd_expiry)$this->skd_expiry=DateTime::createFromFormat('Y-m-d H:i:s',$this->skd_expiry)->format('d/m/Y');
		if($this->autho_person_ic_expiry)$this->autho_person_ic_expiry=DateTime::createFromFormat('Y-m-d H:i:s',$this->autho_person_ic_expiry)->format('d/m/Y');
		if($this->npwp_date)$this->npwp_date=DateTime::createFromFormat('Y-m-d H:i:s',$this->npwp_date)->format('d/m/Y');
		if($this->siup_expiry_date)$this->siup_expiry_date=DateTime::createFromFormat('Y-m-d H:i:s',$this->siup_expiry_date)->format('d/m/Y');
		if($this->tdp_expiry_date)$this->tdp_expiry_date=DateTime::createFromFormat('Y-m-d H:i:s',$this->tdp_expiry_date)->format('d/m/Y');
		if($this->pma_expiry_date)$this->pma_expiry_date=DateTime::createFromFormat('Y-m-d H:i:s',$this->pma_expiry_date)->format('d/m/Y');
	}
	
	public function getCifAndCifname()
	{
		return $this->cifs." - ".$this->cif_name;
	}
	
	public function getType1Desc()
	{
		return AConstant::$client_type[$this->client_type_1];
	}
    
	public function tableName()
	{
		return 'MST_CIF';
	}
	
	public function executeSp($exec_status,$old_cif,$update_date,$update_seq,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_MST_CIF_UPD(
						:P_SEARCH_CIFS,
						:P_CIFS,
						:P_CIF_NAME,
						:P_SID,
						:P_CLIENT_TYPE_1,
						:P_CLIENT_TYPE_2,
						:P_NPWP_NO,
						:P_CLIENT_TITLE,
						:P_MOTHER_NAME,
						TO_DATE(:P_CLIENT_BIRTH_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_CLIENT_IC_NUM,
						:P_IC_TYPE,
						TO_DATE(:P_IC_EXPIRY_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_DEF_ADDR_1,
						:P_DEF_ADDR_2,
						:P_DEF_ADDR_3,
						:P_COUNTRY,
						:P_POST_CD,
						:P_PHONE_NUM,
						:P_HP_NUM,
						:P_FAX_NUM,
						:P_HAND_PHONE1,
						:P_PHONE2_1,
						:P_E_MAIL1,
						:P_INST_TYPE,
						:P_INST_TYPE_TXT,
						:P_ANNUAL_INCOME_CD,
						:P_ANNUAL_INCOME,
						:P_FUNDS_CODE,
						:P_SOURCE_OF_FUNDS,
						:P_PURPOSE01,
						:P_PURPOSE02,
						:P_PURPOSE03,
						:P_PURPOSE04,
						:P_PURPOSE05,
						:P_PURPOSE06,
						:P_PURPOSE07,
						:P_PURPOSE08,
						:P_PURPOSE09,
						:P_PURPOSE10,
						:P_PURPOSE11,
						:P_PURPOSE90,
						:P_PURPOSE_LAINNYA,
						:P_INVESMENT_PERIOD,
						:P_NET_ASSET_CD,
						:P_NET_ASSET,
						:P_NET_ASSET_YR,
						:P_ADDL_FUND_CD,
						:P_ADDL_FUND,
						:P_BIZ_TYPE,
						:P_ACT_FIRST,
						TO_DATE(:P_ACT_FIRST_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_ACT_LAST,
						TO_DATE(:P_ACT_LAST_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_SIUP_NO,
						:P_TDP_NO,
						:P_MODAL_DASAR,
						:P_MODAL_DISETOR,
						:P_INDUSTRY_CD,
						:P_INDUSTRY,
						:P_AUTHO_PERSON_NAME,
						:P_AUTHO_PERSON_IC_TYPE,
						:P_AUTHO_PERSON_IC_NUM,
						:P_AUTHO_PERSON_POSITION,
						:P_PROFIT_CD,
						:P_PROFIT,
						:P_TEMPAT_PENDIRIAN,
						:P_SKD_NO,
						:P_SKD_EXPIRY,
						:P_TAX_ID,
						TO_DATE(:P_AUTHO_PERSON_IC_EXPIRY,'YYYY-MM-DD HH24:MI:SS'),
						:P_DEF_CITY,
						TO_DATE(:P_NPWP_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_DIRECT_SID,
						:P_ASSET_OWNER,
--						:P_AUTHO_PERSON_NPWP,
--						:P_AUTHO_PERSON_NPWP_DATE,
--						:P_OLT_USER_ID,
--						:P_NICK_NAME,
						:P_SOURCE_ADDL_FUND_CD,
						:P_SOURCE_ADDL_FUND,
						:P_EXPENSE_AMOUNT_CD,
						TO_DATE(:P_SIUP_EXPIRY_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_SIUP_ISSUED,
						TO_DATE(:P_TDP_EXPIRY_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_TDP_ISSUED,
						:P_PMA_NO,
						TO_DATE(:P_PMA_EXPIRY_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_PMA_ISSUED,
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
			$command->bindValue(":P_SEARCH_CIFS",$old_cif,PDO::PARAM_STR);
			$command->bindValue(":P_CIFS",$this->cifs,PDO::PARAM_STR);
			$command->bindValue(":P_CIF_NAME",$this->cif_name,PDO::PARAM_STR);
			$command->bindValue(":P_SID",$this->sid,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE_1",$this->client_type_1,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE_2",$this->client_type_2,PDO::PARAM_STR);
			$command->bindValue(":P_NPWP_NO",$this->npwp_no,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TITLE",$this->client_title,PDO::PARAM_STR);
			$command->bindValue(":P_MOTHER_NAME",$this->mother_name,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_BIRTH_DT",$this->client_birth_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_IC_NUM",$this->client_ic_num,PDO::PARAM_STR);
			$command->bindValue(":P_IC_TYPE",$this->ic_type,PDO::PARAM_STR);
			$command->bindValue(":P_IC_EXPIRY_DT",$this->ic_expiry_dt,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_1",$this->def_addr_1,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_2",$this->def_addr_2,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_3",$this->def_addr_3,PDO::PARAM_STR);
			$command->bindValue(":P_COUNTRY",$this->country,PDO::PARAM_STR);
			$command->bindValue(":P_POST_CD",$this->post_cd,PDO::PARAM_STR);
			$command->bindValue(":P_PHONE_NUM",$this->phone_num,PDO::PARAM_STR);
			$command->bindValue(":P_HP_NUM",$this->hp_num,PDO::PARAM_STR);
			$command->bindValue(":P_FAX_NUM",$this->fax_num,PDO::PARAM_STR);
			$command->bindValue(":P_HAND_PHONE1",$this->hand_phone1,PDO::PARAM_STR);
			$command->bindValue(":P_PHONE2_1",$this->phone2_1,PDO::PARAM_STR);
			$command->bindValue(":P_E_MAIL1",$this->e_mail1,PDO::PARAM_STR);
			$command->bindValue(":P_INST_TYPE",$this->inst_type,PDO::PARAM_STR);
			$command->bindValue(":P_INST_TYPE_TXT",$this->inst_type_txt,PDO::PARAM_STR);
			$command->bindValue(":P_ANNUAL_INCOME_CD",$this->annual_income_cd,PDO::PARAM_STR);
			$command->bindValue(":P_ANNUAL_INCOME",$this->annual_income,PDO::PARAM_STR);
			$command->bindValue(":P_FUNDS_CODE",$this->funds_code,PDO::PARAM_STR);
			$command->bindValue(":P_SOURCE_OF_FUNDS",$this->source_of_funds,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE01",$this->purpose01,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE02",$this->purpose02,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE03",$this->purpose03,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE04",$this->purpose04,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE05",$this->purpose05,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE06",$this->purpose06,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE07",$this->purpose07,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE08",$this->purpose08,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE09",$this->purpose09,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE10",$this->purpose10,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE11",$this->purpose11,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE90",$this->purpose90,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE_LAINNYA",$this->purpose_lainnya,PDO::PARAM_STR);
			$command->bindValue(":P_INVESMENT_PERIOD",$this->invesment_period,PDO::PARAM_STR);
			$command->bindValue(":P_NET_ASSET_CD",$this->net_asset_cd,PDO::PARAM_STR);
			$command->bindValue(":P_NET_ASSET",$this->net_asset,PDO::PARAM_STR);
			$command->bindValue(":P_NET_ASSET_YR",$this->net_asset_yr,PDO::PARAM_STR);
			$command->bindValue(":P_ADDL_FUND_CD",$this->addl_fund_cd,PDO::PARAM_STR);
			$command->bindValue(":P_ADDL_FUND",$this->addl_fund,PDO::PARAM_STR);
			$command->bindValue(":P_BIZ_TYPE",$this->biz_type,PDO::PARAM_STR);
			$command->bindValue(":P_ACT_FIRST",$this->act_first,PDO::PARAM_STR);
			$command->bindValue(":P_ACT_FIRST_DT",$this->act_first_dt,PDO::PARAM_STR);
			$command->bindValue(":P_ACT_LAST",$this->act_last,PDO::PARAM_STR);
			$command->bindValue(":P_ACT_LAST_DT",$this->act_last_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SIUP_NO",$this->siup_no,PDO::PARAM_STR);
			$command->bindValue(":P_TDP_NO",$this->tdp_no,PDO::PARAM_STR);
			$command->bindValue(":P_MODAL_DASAR",$this->modal_dasar,PDO::PARAM_STR);
			$command->bindValue(":P_MODAL_DISETOR",$this->modal_disetor,PDO::PARAM_STR);
			$command->bindValue(":P_INDUSTRY_CD",$this->industry_cd,PDO::PARAM_STR);
			$command->bindValue(":P_INDUSTRY",$this->industry,PDO::PARAM_STR);
			$command->bindValue(":P_AUTHO_PERSON_NAME",$this->autho_person_name,PDO::PARAM_STR);
			$command->bindValue(":P_AUTHO_PERSON_IC_TYPE",$this->autho_person_ic_type,PDO::PARAM_STR);
			$command->bindValue(":P_AUTHO_PERSON_IC_NUM",$this->autho_person_ic_num,PDO::PARAM_STR);
			$command->bindValue(":P_AUTHO_PERSON_POSITION",$this->autho_person_position,PDO::PARAM_STR);
			$command->bindValue(":P_PROFIT_CD",$this->profit_cd,PDO::PARAM_STR);
			$command->bindValue(":P_PROFIT",$this->profit,PDO::PARAM_STR);
			$command->bindValue(":P_TEMPAT_PENDIRIAN",$this->tempat_pendirian,PDO::PARAM_STR);
			$command->bindValue(":P_SKD_NO",$this->skd_no,PDO::PARAM_STR);
			$command->bindValue(":P_SKD_EXPIRY",$this->skd_expiry,PDO::PARAM_STR);
			$command->bindValue(":P_TAX_ID",$this->tax_id,PDO::PARAM_STR);
			$command->bindValue(":P_AUTHO_PERSON_IC_EXPIRY",$this->autho_person_ic_expiry,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_CITY",$this->def_city,PDO::PARAM_STR);
			$command->bindValue(":P_NPWP_DATE",$this->npwp_date,PDO::PARAM_STR);
			$command->bindValue(":P_DIRECT_SID",$this->direct_sid,PDO::PARAM_STR);
			$command->bindValue(":P_ASSET_OWNER",$this->asset_owner,PDO::PARAM_STR);
//			$command->bindValue(":P_AUTHO_PERSON_NPWP",$this->autho_person_npwp,PDO::PARAM_STR);
//			$command->bindValue(":P_AUTHO_PERSON_NPWP_DATE",$this->autho_person_npwp_date,PDO::PARAM_STR);
//			$command->bindValue(":P_OLT_USER_ID",$this->olt_user_id,PDO::PARAM_STR);
//			$command->bindValue(":P_NICK_NAME",$this->nick_name,PDO::PARAM_STR);
			$command->bindValue(":P_SOURCE_ADDL_FUND_CD",$this->source_addl_fund_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SOURCE_ADDL_FUND",$this->source_addl_fund,PDO::PARAM_STR);
			$command->bindValue(":P_EXPENSE_AMOUNT_CD",$this->expense_amount_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SIUP_EXPIRY_DATE",$this->siup_expiry_date,PDO::PARAM_STR);
			$command->bindValue(":P_SIUP_ISSUED",$this->siup_issued,PDO::PARAM_STR);
			$command->bindValue(":P_TDP_EXPIRY_DATE",$this->tdp_expiry_date,PDO::PARAM_STR);
			$command->bindValue(":P_TDP_ISSUED",$this->tdp_issued,PDO::PARAM_STR);
			$command->bindValue(":P_PMA_NO",$this->pma_no,PDO::PARAM_STR);
			$command->bindValue(":P_PMA_EXPIRY_DATE",$this->pma_expiry_date,PDO::PARAM_STR);
			$command->bindValue(":P_PMA_ISSUED",$this->pma_issued,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);			
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$update_seq,PDO::PARAM_STR);
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

	public function rules()
	{
		return array(
		
			array('client_birth_dt, ic_expiry_dt, act_first_dt, act_last_dt, skd_expiry, autho_person_ic_expiry, npwp_date, approved_dt, siup_expiry_date, tdp_expiry_date, pma_expiry_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('cifs, cif_name, client_birth_dt, tax_id, def_addr_1, funds_code','required'),
			
			array('mother_name, annual_income_cd, ic_type, client_ic_num',$this->client_type_1=='I'?'required':'safe'),
			
			array('tempat_pendirian, country, def_city, inst_type, net_asset_cd', $this->client_type_1=='C'?'required':'safe'),
			array('profit_cd',$this->client_type_1=='C'?'checkCustodian':'safe'),
			array('act_first',$this->client_type_1=='C'?'checkType2':'safe'),
			array('npwp_no',$this->client_type_1=='C'?'checkCountry':'safe'),
			array('addl_fund',$this->client_type_1=='C'?'checkIndustry':'safe'),	
			
			array('phone_num',$this->client_type_1=='I'?'checkPhone':'required'),
			array('purpose01','checkPurpose'),
			//array('net_asset_cd','checkRequired'),
			array('inst_type_txt','checkInst'),
			array('source_of_funds','checkFund'),
				
			array('cif_name, mother_name, def_addr_1, def_addr_2, e_mail1, autho_person_name, autho_person_position', 'length', 'max'=>50),
			array('sid, npwp_no, phone_num, hp_num, fax_num, hand_phone1, phone2_1, direct_sid', 'length', 'max'=>15),
			array('client_type_1, client_type_2, ic_type, autho_person_ic_type, asset_owner, approved_stat', 'length', 'max'=>1),
			array('client_title, post_cd', 'length', 'max'=>6),
			array('client_ic_num, def_addr_3, country, inst_type_txt, source_of_funds, source_addl_fund, purpose_lainnya, act_first, act_last, siup_no, tdp_no, modal_dasar, modal_disetor, industry, autho_person_ic_num, profit, tempat_pendirian, skd_no, siup_issued, tdp_issued, pma_no, pma_issued', 'length', 'max'=>30),
			array('inst_type, annual_income_cd, funds_code, purpose01, purpose02, purpose03, purpose04, purpose05, purpose90, net_asset_cd, biz_type, industry_cd, profit_cd', 'length', 'max'=>2),
			array('annual_income, net_asset, def_city, addl_fund', 'length', 'max'=>40),
			array('invesment_period', 'length', 'max'=>20),
			array('net_asset_yr, tax_id', 'length', 'max'=>4),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('client_birth_dt, ic_expiry_dt, act_first_dt, act_last_dt, cre_dt, upd_dt, skd_expiry, autho_person_ic_expiry, npwp_date, approved_dt, siup_expiry_date, tdp_expiry_date, pma_expiry_date, source_addl_fund_cd, expense_amount_cd, addl_fund_cd', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('cifs, cif_name, sid, client_type_1, client_type_2, npwp_no, client_title, mother_name, client_birth_dt, client_ic_num, ic_type, ic_expiry_dt, def_addr_1, def_addr_2, def_addr_3, country, post_cd, phone_num, hp_num, fax_num, hand_phone1, phone2_1, e_mail1, inst_type, inst_type_txt, annual_income_cd, annual_income, funds_code, source_of_funds, purpose01, purpose02, purpose03, purpose04, purpose05, purpose06, purpose07, purpose08, purpose09, purpose10, purpose11, purpose90, purpose_lainnya, invesment_period, net_asset_cd, net_asset, net_asset_yr, addl_fund_cd, addl_fund, biz_type, act_first, act_first_dt, act_last, act_last_dt, siup_no, tdp_no, modal_dasar, modal_disetor, industry_cd, industry, cre_dt, user_id, upd_dt, autho_person_name, autho_person_ic_type, autho_person_ic_num, autho_person_position, profit_cd, profit, tempat_pendirian, skd_no, skd_expiry, tax_id, autho_person_ic_expiry, def_city, npwp_date, direct_sid, asset_owner, upd_by, approved_dt, approved_by, approved_stat, source_addl_fund_cd, source_addl_fund, expense_amount_cd, siup_expiry_date, siup_issued, tdp_expiry_date, tdp_issued, pma_no, pma_expiry_date, pma_issued,client_birth_dt_date,client_birth_dt_month,client_birth_dt_year,ic_expiry_dt_date,ic_expiry_dt_month,ic_expiry_dt_year,act_first_dt_date,act_first_dt_month,act_first_dt_year,act_last_dt_date,act_last_dt_month,act_last_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,skd_expiry_date,skd_expiry_month,skd_expiry_year,autho_person_ic_expiry_date,autho_person_ic_expiry_month,autho_person_ic_expiry_year,npwp_date_date,npwp_date_month,npwp_date_year,approved_dt_date,approved_dt_month,approved_dt_year,siup_expiry_date_date,siup_expiry_date_month,siup_expiry_date_year,tdp_expiry_date_date,tdp_expiry_date_month,tdp_expiry_date_year,pma_expiry_date_date,pma_expiry_date_month,pma_expiry_date_year', 'safe', 'on'=>'search'),
		);
	}

	public function checkPhone()
	{
		if($this->phone_num == null && $this->hp_num == null)$this->addError('phone_num', 'Phone or Mobile number must be filled');
	}

	public function checkPurpose()
	{
		if($this->purpose01 == '00' && 
			$this->purpose02 == '00' &&
			$this->purpose03 == '00' &&
			$this->purpose04 == '00' &&
			$this->purpose05 == '00' &&
			$this->purpose90 == '00')$this->addError('Purpose of Investment', 'Purpose of Investment must be selected');
	}

	public function checkCustodian()
	{
		if(!$this->custodian)
		{
			if(!$this->profit_cd)$this->addError('profit_cd','Operational Profit must be filled');
			if(!$this->net_asset_yr)$this->addError('net_asset_yr','Year of Operational Profit and Kekayaan Bersih must be filled');
		}
	}

	public function checkType2()
	{
		if($this->client_type_2 == 'L' && !$this->custodian)
		{
			if(!$this->act_first)$this->addError('act_first','If Client Type II is \'LOCAL\',  No Akta Pendirian must be filled');
			if(!$this->siup_no)$this->addError('siup_no','If Client Type II is \'LOCAL\',  No SIUP must be filled');
		}
	}

	public function checkCountry()
	{
		if($this->country == 'INDONESIA' && !$this->npwp_no)$this->addError('npwp_no','If Country is \'INDONESIA\',  No NPWP must be filled');
	}
	
	public function checkIndustry()
	{
		if($this->industry_cd == '90' && !$this->addl_fund)$this->addError('addl_fund','Kegiatan usaha must be specified if \'LAINNYA\' is chosen');
	}
	
	public function checkInst()
	{
		if($this->inst_type == '90' && !$this->inst_type_txt)$this->addError('inst_type_txt','Institution Type must be specified if \'LAINNYA\' is chosen');
	}
	
	public function checkFund()
	{
		if($this->funds_code == '90' && !$this->source_of_funds)$this->addError('source_of_funds','Source of income must be specified if \'LAINNYA\' is chosen');
	}

/*	public function checkRequired()
	{
		if($this->client_type_1 == 'C' && !$this->net_asset_cd)$this->addError('net_asset_cd','Kekayaan Bersih cannot be blank');
	}
*/
	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'cifs' => 'CIF',
			'cif_name' => 'Name',
			'sid' => 'Single ID',
			'client_type_1' => 'Client Type I',
			'client_type_2' => 'Client Type II',
			'npwp_no' => 'NPWP',
			'client_title' => 'Client Title',
			'mother_name' => 'Mother\'s Maiden Name',
			'client_birth_dt' => $this->client_type_1=='I'?'Birth Date':'Tanggal Pendirian',
			'client_ic_num' => 'ID Number',
			'ic_type' => 'Identity Card Type',
			'ic_expiry_dt' => 'ID Expiry Date',
			'def_addr_1' => 'Address',
			'def_addr_2' => 'Def Addr 2',
			'def_addr_3' => 'Def Addr 3',
			'country' => 'Country',
			'post_cd' => 'Post Code',
			'phone_num' => 'Phone Number',
			'hp_num' => 'Mobile Number',
			'fax_num' => 'Fax',
			'hand_phone1' => 'Mobile Number',
			'phone2_1' => 'Phone2 1',
			'e_mail1' => 'E-Mail',
			'inst_type' => 'Company Characteristic',
			'inst_type_txt' => 'Inst Type Txt',
			'annual_income_cd' => 'Annual Income',
			'annual_income' => 'Annual Income',
			'funds_code' => 'Source of Income',
			'source_of_funds' => 'Source Of Funds',
			'expense_amount_cd' => 'Expense',
			'purpose01' => 'Purpose01',
			'purpose02' => 'Purpose02',
			'purpose03' => 'Purpose03',
			'purpose04' => 'Purpose04',
			'purpose05' => 'Purpose05',
			'purpose06' => 'Purpose06',
			'purpose07' => 'Purpose07',
			'purpose08' => 'Purpose08',
			'purpose09' => 'Purpose09',
			'purpose10' => 'Purpose10',
			'purpose11' => 'Purpose11',
			'purpose90' => 'Purpose90',
			'purpose_lainnya' => 'Purpose Lainnya',
			'invesment_period' => 'Invesment Period',
			'net_asset_cd' => 'Kekayaan Bersih',
			'net_asset' => 'Net Asset',
			'net_asset_yr' => 'Year',
			'addl_fund_cd' => 'Additional Income',
			'source_addl_fund_cd' => 'Source of Additional Income',
			'addl_fund' => 'Addl Fund',
			'biz_type' => 'Business Type',
			'act_first' => 'No Akta Pendirian',
			'act_first_dt' => 'Tanggal Akta Pendirian',
			'act_last' => 'No Akta Terakhir',
			'act_last_dt' => 'Tanggal Akta Terakhir',
			'siup_no' => 'SIUP',
			'tdp_no' => 'TDP',
			'pma_no' => 'PMA',
			'siup_expiry_date' => 'Tanggal Kadaluarsa',
			'tdp_expiry_date' => 'Tanggal Kadaluarsa',
			'pma_expiry_date' => 'Tanggal Kadaluarsa',
			'siup_issued'  => 'Diterbitkan di',
			'tdp_issued'  => 'Diterbitkan di',
			'pma_issued'  => 'Diterbitkan di',
			'modal_dasar' => 'Modal Dasar',
			'modal_disetor' => 'Modal Disetor',
			'industry_cd' => 'Kegiatan Usaha',
			'industry' => 'Sebutkan',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User ID',
			'upd_dt' => 'Upd Date',
			'autho_person_name' => 'Autho Person Name',
			'autho_person_ic_type' => 'Autho Person Ic Type',
			'autho_person_ic_num' => 'Autho Person Ic Num',
			'autho_person_position' => 'Autho Person Position',
			'profit_cd' => 'Operational Profit',
			'profit' => 'Profit',
			'tempat_pendirian' => 'Tempat Pendirian',
			'skd_no' => 'SKD',
			'skd_expiry' => 'Tanggal Kadaluarsa',
			'tax_id' => 'Tax',
			'autho_person_ic_expiry' => 'Autho Person Ic Expiry',
			'def_city' => 'City',
			'npwp_date' => 'NPWP Registration Date',
			'direct_sid' => 'Direct Sid',
			'asset_owner' => 'Asset Owner',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('cifs',$this->cifs,true);
		$criteria->compare('cif_name',$this->cif_name,true);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('client_type_1',$this->client_type_1,true);
		$criteria->compare('client_type_2',$this->client_type_2,true);
		$criteria->compare('npwp_no',$this->npwp_no,true);
		$criteria->compare('client_title',$this->client_title,true);
		$criteria->compare('mother_name',$this->mother_name,true);

		if(!empty($this->client_birth_dt_date))
			$criteria->addCondition("TO_CHAR(t.client_birth_dt,'DD') LIKE '%".($this->client_birth_dt_date)."%'");
		if(!empty($this->client_birth_dt_month))
			$criteria->addCondition("TO_CHAR(t.client_birth_dt,'MM') LIKE '%".($this->client_birth_dt_month)."%'");
		if(!empty($this->client_birth_dt_year))
			$criteria->addCondition("TO_CHAR(t.client_birth_dt,'YYYY') LIKE '%".($this->client_birth_dt_year)."%'");		$criteria->compare('client_ic_num',$this->client_ic_num,true);
		$criteria->compare('ic_type',$this->ic_type,true);

		if(!empty($this->ic_expiry_dt_date))
			$criteria->addCondition("TO_CHAR(t.ic_expiry_dt,'DD') LIKE '%".($this->ic_expiry_dt_date)."%'");
		if(!empty($this->ic_expiry_dt_month))
			$criteria->addCondition("TO_CHAR(t.ic_expiry_dt,'MM') LIKE '%".($this->ic_expiry_dt_month)."%'");
		if(!empty($this->ic_expiry_dt_year))
			$criteria->addCondition("TO_CHAR(t.ic_expiry_dt,'YYYY') LIKE '%".($this->ic_expiry_dt_year)."%'");		$criteria->compare('def_addr_1',$this->def_addr_1,true);
		$criteria->compare('def_addr_2',$this->def_addr_2,true);
		$criteria->compare('def_addr_3',$this->def_addr_3,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('post_cd',$this->post_cd,true);
		$criteria->compare('phone_num',$this->phone_num,true);
		$criteria->compare('hp_num',$this->hp_num,true);
		$criteria->compare('fax_num',$this->fax_num,true);
		$criteria->compare('hand_phone1',$this->hand_phone1,true);
		$criteria->compare('phone2_1',$this->phone2_1,true);
		$criteria->compare('e_mail1',$this->e_mail1,true);
		$criteria->compare('inst_type',$this->inst_type,true);
		$criteria->compare('inst_type_txt',$this->inst_type_txt,true);
		$criteria->compare('annual_income_cd',$this->annual_income_cd,true);
		$criteria->compare('annual_income',$this->annual_income,true);
		$criteria->compare('funds_code',$this->funds_code,true);
		$criteria->compare('source_of_funds',$this->source_of_funds,true);
		$criteria->compare('purpose01',$this->purpose01,true);
		$criteria->compare('purpose02',$this->purpose02,true);
		$criteria->compare('purpose03',$this->purpose03,true);
		$criteria->compare('purpose04',$this->purpose04,true);
		$criteria->compare('purpose05',$this->purpose05,true);
		$criteria->compare('purpose06',$this->purpose06,true);
		$criteria->compare('purpose07',$this->purpose07,true);
		$criteria->compare('purpose08',$this->purpose08,true);
		$criteria->compare('purpose09',$this->purpose09,true);
		$criteria->compare('purpose10',$this->purpose10,true);
		$criteria->compare('purpose11',$this->purpose11,true);
		$criteria->compare('purpose90',$this->purpose90,true);
		$criteria->compare('purpose_lainnya',$this->purpose_lainnya,true);
		$criteria->compare('invesment_period',$this->invesment_period,true);
		$criteria->compare('net_asset_cd',$this->net_asset_cd,true);
		$criteria->compare('net_asset',$this->net_asset,true);
		$criteria->compare('net_asset_yr',$this->net_asset_yr,true);
		$criteria->compare('addl_fund_cd',$this->addl_fund_cd,true);
		$criteria->compare('addl_fund',$this->addl_fund,true);
		$criteria->compare('biz_type',$this->biz_type,true);
		$criteria->compare('act_first',$this->act_first,true);

		if(!empty($this->act_first_dt_date))
			$criteria->addCondition("TO_CHAR(t.act_first_dt,'DD') LIKE '%".($this->act_first_dt_date)."%'");
		if(!empty($this->act_first_dt_month))
			$criteria->addCondition("TO_CHAR(t.act_first_dt,'MM') LIKE '%".($this->act_first_dt_month)."%'");
		if(!empty($this->act_first_dt_year))
			$criteria->addCondition("TO_CHAR(t.act_first_dt,'YYYY') LIKE '%".($this->act_first_dt_year)."%'");		$criteria->compare('act_last',$this->act_last,true);

		if(!empty($this->act_last_dt_date))
			$criteria->addCondition("TO_CHAR(t.act_last_dt,'DD') LIKE '%".($this->act_last_dt_date)."%'");
		if(!empty($this->act_last_dt_month))
			$criteria->addCondition("TO_CHAR(t.act_last_dt,'MM') LIKE '%".($this->act_last_dt_month)."%'");
		if(!empty($this->act_last_dt_year))
			$criteria->addCondition("TO_CHAR(t.act_last_dt,'YYYY') LIKE '%".($this->act_last_dt_year)."%'");		$criteria->compare('siup_no',$this->siup_no,true);
		$criteria->compare('tdp_no',$this->tdp_no,true);
		$criteria->compare('modal_dasar',$this->modal_dasar,true);
		$criteria->compare('modal_disetor',$this->modal_disetor,true);
		$criteria->compare('industry_cd',$this->industry_cd,true);
		$criteria->compare('industry',$this->industry,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".($this->cre_dt_date)."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".($this->cre_dt_month)."%'");

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".($this->upd_dt_date)."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".($this->upd_dt_month)."%'");
		$criteria->compare('autho_person_name',$this->autho_person_name,true);
		$criteria->compare('autho_person_ic_type',$this->autho_person_ic_type,true);
		$criteria->compare('autho_person_ic_num',$this->autho_person_ic_num,true);
		$criteria->compare('autho_person_position',$this->autho_person_position,true);
		$criteria->compare('profit_cd',$this->profit_cd,true);
		$criteria->compare('profit',$this->profit,true);
		$criteria->compare('tempat_pendirian',$this->tempat_pendirian,true);
		$criteria->compare('skd_no',$this->skd_no,true);

		if(!empty($this->skd_expiry_date))
			$criteria->addCondition("TO_CHAR(t.skd_expiry,'DD') LIKE '%".($this->skd_expiry_date)."%'");
		if(!empty($this->skd_expiry_month))
			$criteria->addCondition("TO_CHAR(t.skd_expiry,'MM') LIKE '%".($this->skd_expiry_month)."%'");
		if(!empty($this->skd_expiry_year))
			$criteria->addCondition("TO_CHAR(t.skd_expiry,'YYYY') LIKE '%".($this->skd_expiry_year)."%'");		$criteria->compare('tax_id',$this->tax_id,true);

		if(!empty($this->autho_person_ic_expiry_date))
			$criteria->addCondition("TO_CHAR(t.autho_person_ic_expiry,'DD') LIKE '%".($this->autho_person_ic_expiry_date)."%'");
		if(!empty($this->autho_person_ic_expiry_month))
			$criteria->addCondition("TO_CHAR(t.autho_person_ic_expiry,'MM') LIKE '%".($this->autho_person_ic_expiry_month)."%'");
		if(!empty($this->autho_person_ic_expiry_year))
			$criteria->addCondition("TO_CHAR(t.autho_person_ic_expiry,'YYYY') LIKE '%".($this->autho_person_ic_expiry_year)."%'");		$criteria->compare('def_city',$this->def_city,true);

		if(!empty($this->npwp_date_date))
			$criteria->addCondition("TO_CHAR(t.npwp_date,'DD') LIKE '%".($this->npwp_date_date)."%'");
		if(!empty($this->npwp_date_month))
			$criteria->addCondition("TO_CHAR(t.npwp_date,'MM') LIKE '%".($this->npwp_date_month)."%'");
		if(!empty($this->npwp_date_year))
			$criteria->addCondition("TO_CHAR(t.npwp_date,'YYYY') LIKE '%".($this->npwp_date_year)."%'");		$criteria->compare('direct_sid',$this->direct_sid,true);
		$criteria->compare('asset_owner',$this->asset_owner,true);
		$criteria->compare('upd_by',$this->upd_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".($this->approved_dt_date)."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".($this->approved_dt_month)."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".($this->approved_dt_year)."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
/*	
	public function executeSp($exec_status)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL Sp_Mst_Client_autho_Upd(:P_SEARCH_CIFS,:P_CLIENT_CD,:P_CIFS, 
						:P_CIF_NAME,:P_SID,:P_CLIENT_TYPE_1,:P_CLIENT_TYPE_2,
						:P_NPWP_NO,:P_CLIENT_TITLE,:P_MOTHER_NAME,
						TO_DATE(:P_CLIENT_BIRTH_DT,'YYYY-MM-DD'),:P_CLIENT_IC_NUM,
						:P_IC_TYPE,TO_DATE(:P_IC_EXPIRY_DT,'YYYY-MM-DD'),
						:P_DEF_ADDR_1,:P_DEF_ADDR_2,:P_DEF_ADDR_3,:P_COUNTRY,:P_POST_CD
						,:P_PHONE_NUM,:P_HP_NUM,:P_FAX_NUM,:P_HAND_PHONE1,:P_PHONE2_1
						,:P_E_MAIL1,:P_INST_TYPE,:P_INST_TYPE_TXT,:P_ANNUAL_INCOME_CD,:P_ANNUAL_INCOME
						,:P_FUNDS_CODE,:P_SOURCE_OF_FUNDS,:P_PURPOSE01,:P_PURPOSE02,:P_PURPOSE03
						,:P_PURPOSE04,:P_PURPOSE05,:P_PURPOSE06,:P_PURPOSE07,:P_PURPOSE08
						,:P_PURPOSE09,:P_PURPOSE10,:P_PURPOSE11,:P_PURPOSE90,:P_PURPOSE_LAINNYA
						,:P_INVESMENT_PERIOD,:P_NET_ASSET_CD,:P_NET_ASSET,:P_NET_ASSET_YR,:P_ADDL_FUND_CD
						,:P_ADDL_FUND,:P_BIZ_TYPE,:P_ACT_FIRST,TO_DATE(:P_ACT_FIRST_DT,'YYYY-MM-DD'),:P_ACT_LAST
						,TO_DATE(:P_ACT_LAST_DT,'YYYY-MM-DD'),:P_SIUP_NO,:P_TDP_NO,:P_MODAL_DASAR,:P_MODAL_DISETOR
						,:P_INDUSTRY_CD,:P_INDUSTRY,:P_AUTHO_PERSON_NAME,:P_AUTHO_PERSON_IC_TYPE,:P_AUTHO_PERSON_IC_NUM
						,:P_AUTHO_PERSON_POSITION,:P_PROFIT_CD,:P_PROFIT,:P_TEMPAT_PENDIRIAN,:P_SKD_NO
						,TO_DATE(:P_SKD_EXPIRY,'YYYY-MM-DD'),:P_TAX_ID,TO_DATE(:P_AUTHO_PERSON_IC_EXPIRY,'YYYY-MM-DD')
						,:P_DEF_CITY,TO_DATE(:P_NPWP_DATE,'YYYY-MM-DD'),:P_DIRECT_SID,:P_ASSET_OWNER,						
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),:P_CRE_USER_ID,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),:P_UPD_USER_ID,
						:P_UPD_STATUS,:P_IP_ADDRESS,:P_CANCEL_REASON,:P_ERROR_CODE,:P_ERROR_MSG)";

			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_SEARCH_CIFS",$this->search_cifs,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CIFS",$this->cifs,PDO::PARAM_STR);
			$command->bindValue(":P_CIF_NAME",$this->cif_name,PDO::PARAM_STR);
			$command->bindValue(":P_SID",$this->sid,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE_1",$this->client_type_1,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE_2",$this->client_type_2,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TITLE",$this->client_title,PDO::PARAM_STR);
			$command->bindValue(":P_MOTHER_NAME",$this->mother_name,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_BIRTH_DT",$this->client_birth_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_IC_NUM",$this->client_ic_num,PDO::PARAM_STR);
			$command->bindValue(":P_IC_TYPE",$this->ic_type,PDO::PARAM_STR);
			$command->bindValue(":P_IC_EXPIRY_DT",$this->ic_expiry_dt,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_1",$this->def_addr_1,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_2",$this->def_addr_2,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_3",$this->def_addr_3,PDO::PARAM_STR);
			$command->bindValue(":P_COUNTRY",$this->country,PDO::PARAM_STR);
			$command->bindValue(":P_POST_CD",$this->post_cd,PDO::PARAM_STR);
			$command->bindValue(":P_PHONE_NUM",$this->phone_num,PDO::PARAM_STR);
			$command->bindValue(":P_HP_NUM",$this->hp_num,PDO::PARAM_STR);
			$command->bindValue(":P_FAX_NUM",$this->fax_num,PDO::PARAM_STR);
			$command->bindValue(":P_HAND_PHONE1",$this->hand_phone1,PDO::PARAM_STR);
			$command->bindValue(":P_PHONE2_1",$this->phone2_1,PDO::PARAM_STR);
			$command->bindValue(":P_E_MAIL1",$this->e_mail1,PDO::PARAM_STR);
			$command->bindValue(":P_INST_TYPE",$this->inst_type,PDO::PARAM_STR);
			$command->bindValue(":P_INST_TYPE_TXT",$this->inst_type_txt,PDO::PARAM_STR);
			$command->bindValue(":P_ANNUAL_INCOME_CD",$this->annual_income_cd,PDO::PARAM_STR);
			$command->bindValue(":P_ANNUAL_INCOME",$this->annual_income,PDO::PARAM_STR);
			$command->bindValue(":P_FUNDS_CODE",$this->funds_code,PDO::PARAM_STR);
			$command->bindValue(":P_SOURCE_OF_FUNDS",$this->source_of_funds,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE01",$this->purpose01,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE02",$this->purpose02,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE03",$this->purpose03,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE04",$this->purpose04,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE05",$this->purpose05,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE06",$this->purpose06,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE07",$this->purpose07,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE08",$this->purpose08,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE09",$this->purpose09,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE10",$this->purpose10,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE11",$this->purpose11,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE90",$this->purpose90,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE_LAINNYA",$this->purpose_lainnya,PDO::PARAM_STR);
			$command->bindValue(":P_INVESMENT_PERIOD",$this->investment_period,PDO::PARAM_STR);
			$command->bindValue(":P_NET_ASSET_CD",$this->net_asset_cd,PDO::PARAM_STR);
			$command->bindValue(":P_NET_ASSET",$this->net_asset,PDO::PARAM_STR);
			$command->bindValue(":P_NET_ASSET_YR",$this->net_asset_yr,PDO::PARAM_STR);
			$command->bindValue(":P_ADDL_FUND_CD",$this->addl_fund_cd,PDO::PARAM_STR);
			$command->bindValue(":P_ADDL_FUND",$this->addl_fund,PDO::PARAM_STR);
			$command->bindValue(":P_BIZ_TYPE",$this->biz_type,PDO::PARAM_STR);
			$command->bindValue(":P_ACT_FIRST",$this->act_first,PDO::PARAM_STR);
			$command->bindValue(":P_ACT_FIRST_DT",$this->act_first_dt,PDO::PARAM_STR);
			$command->bindValue(":P_ACT_LAST",$this->act_last,PDO::PARAM_STR);
			$command->bindValue(":P_ACT_LAST_DT",$this->act_last_dt,PDO::PARAM_STR);
			$command->bindValue(":P_TDP_NO",$this->tdp_no,PDO::PARAM_STR);
			$command->bindValue(":P_MODAL_DASAR",$this->modal_dasar,PDO::PARAM_STR);
			$command->bindValue(":P_MODAL_DISETOR",$this->modal_disetor,PDO::PARAM_STR);
			$command->bindValue(":P_INDUSTRY_CD",$this->industry_cd,PDO::PARAM_STR);
			$command->bindValue(":P_INDUSTRY",$this->industry,PDO::PARAM_STR);
			$command->bindValue(":P_AUTHO_PERSON_NAME",$this->autho_person_name,PDO::PARAM_STR);
			$command->bindValue(":P_AUTHO_PERSON_IC_TYPE",$this->autho_person_ic_type,PDO::PARAM_STR);
			$command->bindValue(":P_AUTHO_PERSON_IC_NUM",$this->autho_person_ic_num,PDO::PARAM_STR);
			$command->bindValue(":P_AUTHO_PERSON_POSITION",$this->autho_person_position,PDO::PARAM_STR);
			$command->bindValue(":P_PROFIT_CD",$this->profit_cd,PDO::PARAM_STR);
			$command->bindValue(":P_PROFIT",$this->profit,PDO::PARAM_STR);
			$command->bindValue(":P_TEMPAT_PENDIRIAN",$this->tempat_pendirian,PDO::PARAM_STR);
			$command->bindValue(":P_SKD_NO",$this->skd_no,PDO::PARAM_STR);
			$command->bindValue(":P_SKD_EXPIRY",$this->skd_expiry,PDO::PARAM_STR);
			$command->bindValue(":P_TAX_ID",$this->tax_id,PDO::PARAM_STR);
			$command->bindValue(":P_AUTHO_PERSON_IC_EXPIRY",$this->autho_person_ic_expiry,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_CITY",$this->def_city,PDO::PARAM_STR);
			$command->bindValue(":P_NPWP_DATE",$this->npwp_date,PDO::PARAM_STR);
			$command->bindValue(":P_DIRECT_SID",$this->direct_sid,PDO::PARAM_STR);
			$command->bindValue(":P_ASSET_OWNER",$this->asset_owner,PDO::PARAM_STR);
			
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_USER_ID",$this->cre_user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_USER_ID",$this->upd_user_id,PDO::PARAM_STR);
			
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,100);
			
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
}






































