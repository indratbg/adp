<?php

/**
 * This is the model class for table "MST_CLIENT_INDI".
 *
 * The followings are the available columns in table 'MST_CLIENT_INDI':
 * @property string $cifs
 * @property string $sex_code
 * @property string $birth_place
 * @property string $religion
 * @property string $nationality
 * @property string $marital_status
 * @property string $id_addr
 * @property string $id_rtrw
 * @property string $id_klurahn
 * @property string $id_kcamatn
 * @property string $id_kota
 * @property string $educ_code
 * @property string $education
 * @property string $residence_status
 * @property string $residence
 * @property string $occup_code
 * @property string $occupation
 * @property string $job_position
 * @property string $empr_name
 * @property string $empr_biz_type
 * @property string $empr_addr_1
 * @property string $empr_addr_2
 * @property string $empr_addr_3
 * @property string $empr_post_cd
 * @property string $empr_phone
 * @property string $empr_fax
 * @property string $empr_email
 * @property string $spouse_name
 * @property string $spouse_occup
 * @property string $spouse_empr_name
 * @property string $spouse_empr_addr1
 * @property string $spouse_empr_addr2
 * @property string $spouse_empr_addr3
 * @property string $spouse_empr_post_cd
 * @property string $emergency_name
 * @property string $emergency_addr1
 * @property string $emergency_addr2
 * @property string $emergency_addr3
 * @property string $emergency_postcd
 * @property string $emergency_phone
 * @property string $emergency_hp
 * @property string $cre_dt
 * @property string $cre_user_id
 * @property string $upd_dt
 * @property string $upd_user_id
 * @property string $heir
 * @property string $heir_relation
 * @property string $id_post_cd
 * @property string $kitas_num
 * @property string $kitas_expiry_dt
 * @property string $lama_kerja
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Clientindi extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $kitas_expiry_dt_date;
	public $kitas_expiry_dt_month;
	public $kitas_expiry_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	//AH: #END search (datetime || date)  additional comparison

	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    

	public function tableName()
	{
		return 'MST_CLIENT_INDI';
	}
	
	public function executeSp($exec_status,$old_cif,$update_date,$update_seq,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_MST_CLIENT_INDI_UPD(
						:P_SEARCH_CIFS,
						:P_CIFS,
						:P_SEX_CODE,
						:P_BIRTH_PLACE,
						:P_RELIGION,
						:P_NATIONALITY,
						:P_MARITAL_STATUS,
						:P_ID_ADDR,
						:P_ID_RTRW,
						:P_ID_KLURAHN,
						:P_ID_KCAMATN,
						:P_ID_KOTA,
						:P_EDUC_CODE,
						:P_EDUCATION,
						:P_RESIDENCE_STATUS,
						:P_RESIDENCE,
						:P_OCCUP_CODE,
						:P_OCCUPATION,
						:P_JOB_POSITION,
						:P_EMPR_NAME,
						:P_EMPR_BIZ_TYPE,
						:P_EMPR_ADDR_1,
						:P_EMPR_ADDR_2,
						:P_EMPR_ADDR_3,
						:P_EMPR_POST_CD,
						:P_EMPR_PHONE,
						:P_EMPR_FAX,
						:P_EMPR_EMAIL,
						:P_SPOUSE_NAME,
						:P_SPOUSE_OCCUP,
						:P_SPOUSE_EMPR_NAME,
						:P_SPOUSE_EMPR_ADDR1,
						:P_SPOUSE_EMPR_ADDR2,
						:P_SPOUSE_EMPR_ADDR3,
						:P_SPOUSE_EMPR_POST_CD,
						:P_EMERGENCY_NAME,
						:P_EMERGENCY_ADDR1,
						:P_EMERGENCY_ADDR2,
						:P_EMERGENCY_ADDR3,
						:P_EMERGENCY_POSTCD,
						:P_EMERGENCY_PHONE,
						:P_EMERGENCY_HP,
						:P_HEIR,
						:P_HEIR_RELATION,
						:P_ID_POST_CD,
						:P_KITAS_NUM,
						TO_DATE(:P_KITAS_EXPIRY_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_LAMA_KERJA,
						:P_RESIDENCE_SINCE,
						:P_SPOUSE_RELATIONSHIP,
						:P_SPOUSE_IC_TYPE,
						:P_SPOUSE_IC_NUM,
						:P_SPOUSE_IC_EXPIRY,
						:P_SPOUSE_EMPR_CITY,
						:P_SPOUSE_EMPR_COUNTRY,
						:P_SPOUSE_EMPR_PROVINCE,
						:P_SPOUSE_EMPR_BIZ,
						:P_SPOUSE_JOB_POSITION,
						:P_SPOUSE_EMPR_PHONE,
						:P_SPOUSE_EMPR_FAX,
						:P_SPOUSE_EMPR_EMAIL,
						:P_SPOUSE_LAMA_KERJA,
						:P_EMPR_CITY,
						:P_EMPR_COUNTRY,
						:P_SPOUSE_INCOME_CD,
						:P_SPOUSE_SOURCE_CD,
						:P_SPOUSE_SOURCE_OTHER,
						:P_SPOUSE_ADDL_AMOUNT,
						:P_SPOUSE_ADDL_INCOME,
						:P_SPOUSE_ADDL_OTHER,
						:P_SPOUSE_EXPENSE,
						:P_FAM_FINANCIAL_COMPANY,
						:P_FAM_FINANCIAL_COMPANY_NAME,
						:P_FAM_SUSPENDED_SHARE,
						:P_FAM_SUSPENDED_SHARE_NAME,
						:P_OTHER_BROKER_ACC,
						:P_OTHER_BROKER_ACC_NAME,
						:P_OWN_PUBLIC_SHARE,
						:P_OWN_PUBLIC_SHARE_NAME,
						:P_JML_TANGGUNGAN,
						:P_ID_NEGARA,
						:P_SPOUSE_OCCUP_OTHER,
						:P_NICK_NAME,
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
			$command->bindValue(":P_SEX_CODE",$this->sex_code,PDO::PARAM_STR);
			$command->bindValue(":P_BIRTH_PLACE",$this->birth_place,PDO::PARAM_STR);
			$command->bindValue(":P_RELIGION",$this->religion,PDO::PARAM_STR);
			$command->bindValue(":P_NATIONALITY",$this->nationality,PDO::PARAM_STR);
			$command->bindValue(":P_MARITAL_STATUS",$this->marital_status,PDO::PARAM_STR);
			$command->bindValue(":P_ID_ADDR",$this->id_addr,PDO::PARAM_STR);
			$command->bindValue(":P_ID_RTRW",$this->id_rtrw,PDO::PARAM_STR);
			$command->bindValue(":P_ID_KLURAHN",$this->id_klurahn,PDO::PARAM_STR);
			$command->bindValue(":P_ID_KCAMATN",$this->id_kcamatn,PDO::PARAM_STR);
			$command->bindValue(":P_ID_KOTA",$this->id_kota,PDO::PARAM_STR);
			$command->bindValue(":P_EDUC_CODE",$this->educ_code,PDO::PARAM_STR);
			$command->bindValue(":P_EDUCATION",$this->education,PDO::PARAM_STR);
			$command->bindValue(":P_RESIDENCE_STATUS",$this->residence_status,PDO::PARAM_STR);
			$command->bindValue(":P_RESIDENCE",$this->residence,PDO::PARAM_STR);
			$command->bindValue(":P_OCCUP_CODE",$this->occup_code,PDO::PARAM_STR);
			$command->bindValue(":P_OCCUPATION",$this->occupation,PDO::PARAM_STR);
			$command->bindValue(":P_JOB_POSITION",$this->job_position,PDO::PARAM_STR);
			$command->bindValue(":P_EMPR_NAME",$this->empr_name,PDO::PARAM_STR);
			$command->bindValue(":P_EMPR_BIZ_TYPE",$this->empr_biz_type,PDO::PARAM_STR);
			$command->bindValue(":P_EMPR_ADDR_1",$this->empr_addr_1,PDO::PARAM_STR);
			$command->bindValue(":P_EMPR_ADDR_2",$this->empr_addr_2,PDO::PARAM_STR);
			$command->bindValue(":P_EMPR_ADDR_3",$this->empr_addr_3,PDO::PARAM_STR);
			$command->bindValue(":P_EMPR_POST_CD",$this->empr_post_cd,PDO::PARAM_STR);
			$command->bindValue(":P_EMPR_PHONE",$this->empr_phone,PDO::PARAM_STR);
			$command->bindValue(":P_EMPR_FAX",$this->empr_fax,PDO::PARAM_STR);
			$command->bindValue(":P_EMPR_EMAIL",$this->empr_email,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_NAME",$this->spouse_name,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_OCCUP",$this->spouse_occup,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_EMPR_NAME",$this->spouse_empr_name,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_EMPR_ADDR1",$this->spouse_empr_addr1,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_EMPR_ADDR2",$this->spouse_empr_addr2,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_EMPR_ADDR3",$this->spouse_empr_addr3,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_EMPR_POST_CD",$this->spouse_empr_post_cd,PDO::PARAM_STR);
			$command->bindValue(":P_EMERGENCY_NAME",$this->emergency_name,PDO::PARAM_STR);
			$command->bindValue(":P_EMERGENCY_ADDR1",$this->emergency_addr1,PDO::PARAM_STR);
			$command->bindValue(":P_EMERGENCY_ADDR2",$this->emergency_addr2,PDO::PARAM_STR);
			$command->bindValue(":P_EMERGENCY_ADDR3",$this->emergency_addr3,PDO::PARAM_STR);
			$command->bindValue(":P_EMERGENCY_POSTCD",$this->emergency_postcd,PDO::PARAM_STR);
			$command->bindValue(":P_EMERGENCY_PHONE",$this->emergency_phone,PDO::PARAM_STR);
			$command->bindValue(":P_EMERGENCY_HP",$this->emergency_hp,PDO::PARAM_STR);
			$command->bindValue(":P_HEIR",$this->heir,PDO::PARAM_STR);
			$command->bindValue(":P_HEIR_RELATION",$this->heir_relation,PDO::PARAM_STR);
			$command->bindValue(":P_ID_POST_CD",$this->id_post_cd,PDO::PARAM_STR);
			$command->bindValue(":P_KITAS_NUM",$this->kitas_num,PDO::PARAM_STR);
			$command->bindValue(":P_KITAS_EXPIRY_DT",$this->kitas_expiry_dt,PDO::PARAM_STR);
			$command->bindValue(":P_LAMA_KERJA",$this->lama_kerja,PDO::PARAM_STR);
			$command->bindValue(":P_RESIDENCE_SINCE",$this->residence_since,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_RELATIONSHIP",$this->spouse_relationship,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_IC_TYPE",$this->spouse_ic_type,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_IC_NUM",$this->spouse_ic_num,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_IC_EXPIRY",$this->spouse_ic_expiry,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_EMPR_CITY",$this->spouse_empr_city,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_EMPR_COUNTRY",$this->spouse_empr_country,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_EMPR_PROVINCE",$this->spouse_empr_province,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_EMPR_BIZ",$this->spouse_empr_biz,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_JOB_POSITION",$this->spouse_job_position,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_EMPR_PHONE",$this->spouse_empr_phone,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_EMPR_FAX",$this->spouse_empr_fax,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_EMPR_EMAIL",$this->spouse_empr_email,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_LAMA_KERJA",$this->spouse_lama_kerja,PDO::PARAM_STR);
			$command->bindValue(":P_EMPR_CITY",$this->empr_city,PDO::PARAM_STR);
			$command->bindValue(":P_EMPR_COUNTRY",$this->empr_country,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_INCOME_CD",$this->spouse_income_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_SOURCE_CD",$this->spouse_source_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_SOURCE_OTHER",$this->spouse_source_other,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_ADDL_AMOUNT",$this->spouse_addl_amount,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_ADDL_INCOME",$this->spouse_addl_income,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_ADDL_OTHER",$this->spouse_addl_other,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_EXPENSE",$this->spouse_expense,PDO::PARAM_STR);
			$command->bindValue(":P_FAM_FINANCIAL_COMPANY",$this->fam_financial_company,PDO::PARAM_STR);
			$command->bindValue(":P_FAM_FINANCIAL_COMPANY_NAME",$this->fam_financial_company_name,PDO::PARAM_STR);
			$command->bindValue(":P_FAM_SUSPENDED_SHARE",$this->fam_suspended_share,PDO::PARAM_STR);
			$command->bindValue(":P_FAM_SUSPENDED_SHARE_NAME",$this->fam_suspended_share_name,PDO::PARAM_STR);
			$command->bindValue(":P_OTHER_BROKER_ACC",$this->other_broker_acc,PDO::PARAM_STR);
			$command->bindValue(":P_OTHER_BROKER_ACC_NAME",$this->other_broker_acc_name,PDO::PARAM_STR);
			$command->bindValue(":P_OWN_PUBLIC_SHARE",$this->own_public_share,PDO::PARAM_STR);
			$command->bindValue(":P_OWN_PUBLIC_SHARE_NAME",$this->own_public_share_name,PDO::PARAM_STR);
			$command->bindValue(":P_JML_TANGGUNGAN",$this->jml_tanggungan,PDO::PARAM_STR);
			$command->bindValue(":P_ID_NEGARA",$this->id_negara,PDO::PARAM_STR);
			$command->bindValue(":P_SPOUSE_OCCUP_OTHER",$this->spouse_occup_other,PDO::PARAM_STR);
			$command->bindValue(":P_NICK_NAME",$this->nick_name,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			//$command->bindValue(":P_CRE_USER_ID",$this->cre_user_id,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			//$command->bindValue(":P_UPD_USER_ID",$this->upd_user_id,PDO::PARAM_STR);
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
		
			array('kitas_expiry_dt, approved_dt, spouse_ic_expiry', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('jml_tanggungan', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('sex_code, birth_place, marital_status, nationality, id_addr, educ_code, occup_code', 'required'),
			array('spouse_name','checkMaritalSts'),
			array('occup_code','checkBizType'),
			array('jml_tanggungan', 'numerical', 'integerOnly'=>true),
			array('sex_code, religion, marital_status, approved_stat, spouse_relationship, spouse_ic_type, fam_financial_company, fam_suspended_share, other_broker_acc, own_public_share', 'length', 'max'=>1),
			array('birth_place, nationality', 'length', 'max'=>25),
			array('id_addr, id_klurahn, id_kcamatn, empr_name, empr_addr_1, empr_addr_2, empr_email, spouse_name, spouse_empr_name, spouse_empr_addr1, spouse_empr_addr2, emergency_name, emergency_addr1, emergency_addr2, spouse_empr_email', 'length', 'max'=>50),
			array('id_rtrw, kitas_num, residence_since, spouse_lama_kerja, nick_name', 'length', 'max'=>20),
			array('id_kota, spouse_empr_city, spouse_empr_country, spouse_empr_province, empr_city, empr_country', 'length', 'max'=>40),
			array('educ_code, residence_status, occup_code', 'length', 'max'=>2),
			array('education, residence, occupation, job_position, empr_biz_type, empr_addr_3, spouse_occup, spouse_empr_addr3, emergency_addr3, heir, heir_relation, spouse_ic_num, spouse_empr_biz, spouse_job_position, spouse_source_other, spouse_addl_other, fam_financial_company_name, fam_suspended_share_name, other_broker_acc_name, own_public_share_name, id_negara, spouse_occup_other', 'length', 'max'=>30),
			array('empr_post_cd, spouse_empr_post_cd, emergency_postcd, id_post_cd', 'length', 'max'=>6),
			array('empr_phone, empr_fax, emergency_phone, emergency_hp, lama_kerja, spouse_empr_phone, spouse_empr_fax', 'length', 'max'=>15),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('cre_dt, upd_dt, kitas_expiry_dt, approved_dt, spouse_ic_expiry, spouse_income_cd, spouse_source_cd, spouse_addl_amount, spouse_addl_income, spouse_expense', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('cifs, sex_code, birth_place, nick_name, religion, nationality, marital_status, id_addr, id_rtrw, id_klurahn, id_kcamatn, id_kota, educ_code, education, residence_status, residence, occup_code, occupation, job_position, empr_name, empr_biz_type, empr_addr_1, empr_addr_2, empr_addr_3, empr_post_cd, empr_phone, empr_fax, empr_email, spouse_name, spouse_occup, spouse_empr_name, spouse_empr_addr1, spouse_empr_addr2, spouse_empr_addr3, spouse_empr_post_cd, emergency_name, emergency_addr1, emergency_addr2, emergency_addr3, emergency_postcd, emergency_phone, emergency_hp, cre_dt, upd_dt, heir, heir_relation, id_post_cd, kitas_num, kitas_expiry_dt, lama_kerja, approved_dt, approved_by, approved_stat, residence_since, spouse_relationship, spouse_ic_type, spouse_ic_num, spouse_ic_expiry, spouse_empr_city, spouse_empr_country, spouse_empr_province, spouse_empr_biz, spouse_job_position, spouse_empr_phone, spouse_empr_fax, spouse_empr_email, spouse_lama_kerja, empr_city, empr_country, spouse_income_cd, spouse_source_cd, spouse_source_other, spouse_addl_amount, spouse_addl_income, spouse_addl_other, spouse_expense, fam_financial_company, fam_financial_company_name, fam_suspended_share, fam_suspended_share_name, other_broker_acc, other_broker_acc_name, own_public_share, own_public_share_name, jml_tanggungan, id_negara, spouse_occup_other,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,kitas_expiry_dt_date,kitas_expiry_dt_month,kitas_expiry_dt_year,approved_dt_date,approved_dt_month,approved_dt_year,spouse_ic_expiry_date,spouse_ic_expiry_month,spouse_ic_expiry_year', 'safe', 'on'=>'search'),
		);
	}

	public function checkMaritalSts()
	{
		if($this->marital_status == 'M' || $this->marital_status == 2)
		{
			if($this->spouse_name == null)$this->addError('spouse_name',"Spouse name must be filled if marital status is 'KAWIN'");
			if($this->spouse_relationship == null)$this->addError('spouse_relationship',"Spouse relationship must be chosen if marital status is 'KAWIN'");
		}
	}

	public function checkBizType()
	{
		if($this->occup_code == 10 && $this->empr_biz_type == null)$this->addError('empr_biz_type',"Business type must be filled if occupation is 'WIRASWASTA'");
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
		
			//AR: Tab_Client_Occupation Client_Occupation_Data
			'empr_name' => 'Company Name',
			'empr_biz_type' => 'Business',
			'job_position' => 'Job Position',
			
			'empr_addr_1' => 'Address',
			'empr_addr_2' => 'Empr Addr 2',
			'empr_addr_3' => 'Empr Addr 3',
			'empr_post_cd' => 'Post Code',
			'empr_phone' => 'Phone Number',
			'empr_fax' => 'Fax',
			'empr_email' => 'E-mail',
			'empr_city' => 'City',
			'empr_country' => 'Country',
			
			//AR: Tab_Client_Occupation Client_Spouse_Data
			'spouse_name' => 'Name',
			'spouse_occup' => 'Occupation',
			'spouse_relationship' => 'Relationship',
			'spouse_ic_type' => 'ID Type',
			'spouse_ic_num' => 'ID Number',
			'spouse_ic_expiry' => 'ID Expiry Date',
			'spouse_empr_name' => 'Company Name',
			'spouse_empr_addr1' => 'Company Address',
			'spouse_empr_addr2' => 'Addr2',
			'spouse_empr_addr3' => 'Addr3',
			'spouse_empr_post_cd' => 'Post Code',
			'spouse_job_position' => 'Job Position',
			'spouse_empr_biz' => 'Business',
			'spouse_lama_kerja' => 'Lama Kerja',
			'spouse_empr_city' => 'City',
			'spouse_empr_province' => 'Province',
			'spouse_empr_country' => 'Country',
			'spouse_empr_phone' => 'Phone Number',
			'spouse_empr_fax' => 'Fax',
			'spouse_empr_email' => 'E-mail',
			'spouse_income_cd' => 'Annual Income',
			'spouse_source_cd' => 'Source of Income',
			'spouse_addl_amount' => 'Additional Income',
			'spouse_addl_income' => 'Source of Additional Income',
			'spouse_expense' => 'Expense',
			
			'cifs' => 'Cifs',
			'sex_code' => 'Sex Code',
			'birth_place' => 'Birth Place',
			'religion' => 'Religion',
			'nationality' => 'Nationality',
			'marital_status' => 'Marital Status',
			'id_addr' => 'Alamat',
			'id_rtrw' => 'RT/RW',
			'id_klurahn' => 'Kelurahan',
			'id_kcamatn' => 'Kecamatan',
			'id_kota' => 'Kota',
			'id_negara' => 'Negara',
			'educ_code' => 'Education',
			'education' => 'Education',
			'residence_status' => 'Residence Status',
			'residence' => 'Residence',
			'occup_code' => 'Occupation',
			'occupation' => 'Occupation',
			
			'emergency_name' => 'Name',
			'emergency_addr1' => 'Address',
			'emergency_addr2' => 'Emergency Addr2',
			'emergency_addr3' => 'Emergency Addr3',
			'emergency_postcd' => 'Post Code',
			'emergency_phone' => 'Phone Number',
			'emergency_hp' => 'Mobile Number',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'heir' => 'Ahli Waris',
			'heir_relation' => 'Hubungan',
			'id_post_cd' => 'Kode Pos',
			'kitas_num' => 'KITAS/SKD',
			'kitas_expiry_dt' => 'KITAS Expiry Date',
			'lama_kerja' => 'Lama Kerja',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
			
			'jml_tanggungan' => 'Jumlah Tanggungan',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('cifs',$this->cifs,true);
		$criteria->compare('sex_code',$this->sex_code,true);
		$criteria->compare('birth_place',$this->birth_place,true);
		$criteria->compare('religion',$this->religion,true);
		$criteria->compare('nationality',$this->nationality,true);
		$criteria->compare('marital_status',$this->marital_status,true);
		$criteria->compare('id_addr',$this->id_addr,true);
		$criteria->compare('id_rtrw',$this->id_rtrw,true);
		$criteria->compare('id_klurahn',$this->id_klurahn,true);
		$criteria->compare('id_kcamatn',$this->id_kcamatn,true);
		$criteria->compare('id_kota',$this->id_kota,true);
		$criteria->compare('educ_code',$this->educ_code,true);
		$criteria->compare('education',$this->education,true);
		$criteria->compare('residence_status',$this->residence_status,true);
		$criteria->compare('residence',$this->residence,true);
		$criteria->compare('occup_code',$this->occup_code,true);
		$criteria->compare('occupation',$this->occupation,true);
		$criteria->compare('job_position',$this->job_position,true);
		$criteria->compare('empr_name',$this->empr_name,true);
		$criteria->compare('empr_biz_type',$this->empr_biz_type,true);
		$criteria->compare('empr_addr_1',$this->empr_addr_1,true);
		$criteria->compare('empr_addr_2',$this->empr_addr_2,true);
		$criteria->compare('empr_addr_3',$this->empr_addr_3,true);
		$criteria->compare('empr_post_cd',$this->empr_post_cd,true);
		$criteria->compare('empr_phone',$this->empr_phone,true);
		$criteria->compare('empr_fax',$this->empr_fax,true);
		$criteria->compare('empr_email',$this->empr_email,true);
		$criteria->compare('spouse_name',$this->spouse_name,true);
		$criteria->compare('spouse_occup',$this->spouse_occup,true);
		$criteria->compare('spouse_empr_name',$this->spouse_empr_name,true);
		$criteria->compare('spouse_empr_addr1',$this->spouse_empr_addr1,true);
		$criteria->compare('spouse_empr_addr2',$this->spouse_empr_addr2,true);
		$criteria->compare('spouse_empr_addr3',$this->spouse_empr_addr3,true);
		$criteria->compare('spouse_empr_post_cd',$this->spouse_empr_post_cd,true);
		$criteria->compare('emergency_name',$this->emergency_name,true);
		$criteria->compare('emergency_addr1',$this->emergency_addr1,true);
		$criteria->compare('emergency_addr2',$this->emergency_addr2,true);
		$criteria->compare('emergency_addr3',$this->emergency_addr3,true);
		$criteria->compare('emergency_postcd',$this->emergency_postcd,true);
		$criteria->compare('emergency_phone',$this->emergency_phone,true);
		$criteria->compare('emergency_hp',$this->emergency_hp,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".($this->cre_dt_date)."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".($this->cre_dt_month)."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".($this->cre_dt_year)."%'");		$criteria->compare('cre_user_id',$this->cre_user_id,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".($this->upd_dt_date)."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".($this->upd_dt_month)."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".($this->upd_dt_year)."%'");		$criteria->compare('upd_user_id',$this->upd_user_id,true);
		$criteria->compare('heir',$this->heir,true);
		$criteria->compare('heir_relation',$this->heir_relation,true);
		$criteria->compare('id_post_cd',$this->id_post_cd,true);
		$criteria->compare('kitas_num',$this->kitas_num,true);

		if(!empty($this->kitas_expiry_dt_date))
			$criteria->addCondition("TO_CHAR(t.kitas_expiry_dt,'DD') LIKE '%".($this->kitas_expiry_dt_date)."%'");
		if(!empty($this->kitas_expiry_dt_month))
			$criteria->addCondition("TO_CHAR(t.kitas_expiry_dt,'MM') LIKE '%".($this->kitas_expiry_dt_month)."%'");
		if(!empty($this->kitas_expiry_dt_year))
			$criteria->addCondition("TO_CHAR(t.kitas_expiry_dt,'YYYY') LIKE '%".($this->kitas_expiry_dt_year)."%'");		$criteria->compare('lama_kerja',$this->lama_kerja,true);

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
}