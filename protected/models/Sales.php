<?php

/**
 * This is the model class for table "MST_SALES".
 *
 * The followings are the available columns in table 'MST_SALES':
 * @property string $rem_type
 * @property string $rem_cd
 * @property string $rem_name
 * @property string $rem_name_abbr
 * @property string $rem_birth_dt
 * @property string $join_dt
 * @property string $rem_ic_num
 * @property string $def_addr_1
 * @property string $def_addr_2
 * @property string $def_addr_3
 * @property string $post_cd
 * @property string $contact_pers
 * @property string $phone_num
 * @property string $handphone_num
 * @property string $fax_num
 * @property string $regn_cd
 * @property string $lic_num
 * @property string $lic_expry_dt
 * @property string $bank_cd
 * @property string $bank_brch_cd
 * @property string $rem_acct_num
 * @property double $dep_val
 * @property double $exp_lim
 * @property string $rem_susp_stat
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $user_id
 * @property string $ic_type
 * @property string $race
 * @property string $old_ic_num
 * @property string $rem_main_sub
 * @property string $sub_rem_cd
 * @property double $commission_val
 * @property double $basic_salary
 * @property string $email
 * @property string $branch_cd
 * @property string $incentive_flg
 * @property string $incentive_basis
 * @property double $incentive_per
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 * @property string $def_addr
 * @property string $ptkp_type
 * @property string $npwp_number
 * @property string $warn_pph21_rate
 */
class Sales extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $rem_birth_dt_date;
	public $rem_birth_dt_month;
	public $rem_birth_dt_year;

	public $join_dt_date;
	public $join_dt_month;
	public $join_dt_year;

	public $lic_expry_dt_date;
	public $lic_expry_dt_month;
	public $lic_expry_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public static $lic_num 	= array(''=>'-Choose License-','WPPE'=>'WPPE','N'=>'No'); 
	public static $rem_type = array('1'=>'Trainee','2'=>'Sales Person','3'=>'Remisier','4'=>'Kepala Cabang');
	
	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getCodeAndName()
	{
		return $this->rem_cd.' - '.$this->rem_name;	
	}
	    

	public function tableName()
	{
		return 'MST_SALES';
	}
	
	/*
	 * AH: provide char data to trim value according
	 *     especially those which shape combo box
	 * 	   and also those who type date and shows in user input
	 */
	protected function afterFind()
	{
		$this->branch_cd 	= trim($this->branch_cd);
		$this->join_dt  	= Yii::app()->format->cleanDate($this->join_dt);
		$this->lic_expry_dt = Yii::app()->format->cleanDate($this->lic_expry_dt);
	}
	
	/*
	 *  AH: this function is for executing procedure
	 *  exec_status  : I/U/C
	 */
	public function executeSp($exec_status)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_MST_SALES_UPD(
						:P_SEARCH_REM_CD,:P_REM_TYPE,:P_REM_CD,
						:P_REM_NAME,:P_REM_NAME_ABBR,
						TO_DATE(:P_REM_BIRTH_DT,'YYYY-MM-DD HH24:MI:SS'),TO_DATE(:P_JOIN_DT,'YYYY-MM-DD'),
						:P_REM_IC_NUM,:P_DEF_ADDR_1,:P_DEF_ADDR_2,:P_DEF_ADDR_3,
						:P_POST_CD,:P_CONTACT_PERS,:P_PHONE_NUM,:P_HANDPHONE_NUM,
						:P_FAX_NUM,:P_REGN_CD,:P_LIC_NUM,TO_DATE(:P_LIC_EXPRY_DT,'YYYY-MM-DD'),:P_REM_SUSP_STAT,
						
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,:P_IC_TYPE,:P_EMAIL,:P_BRANCH_CD,:P_NPWP_NUMBER,:P_PTKP_TYPE,:P_WARN_PPH21,:P_UPD_BY,
						:P_DEF_ADDR,:P_UPD_STATUS,:P_IP_ADDRESS,
						:P_CANCEL_REASON,:P_ERROR_CODE,:P_ERROR_MSG)";
						
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_SEARCH_REM_CD",$this->rem_cd,PDO::PARAM_STR);
			$command->bindValue(":P_REM_TYPE",$this->rem_type,PDO::PARAM_STR);
			$command->bindValue(":P_REM_CD",$this->rem_cd,PDO::PARAM_STR);
			$command->bindValue(":P_REM_NAME",$this->rem_name,PDO::PARAM_STR);
			$command->bindValue(":P_REM_NAME_ABBR",$this->rem_name_abbr,PDO::PARAM_STR);
			$command->bindValue(":P_REM_BIRTH_DT",$this->rem_birth_dt,PDO::PARAM_STR);
			$command->bindValue(":P_JOIN_DT",$this->join_dt,PDO::PARAM_STR);
			$command->bindValue(":P_REM_IC_NUM",$this->rem_ic_num,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_1",$this->def_addr_1,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_2",$this->def_addr_2,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_3",$this->def_addr_3,PDO::PARAM_STR);
			$command->bindValue(":P_POST_CD",$this->post_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CONTACT_PERS",$this->contact_pers,PDO::PARAM_STR);
			$command->bindValue(":P_PHONE_NUM",$this->phone_num,PDO::PARAM_STR);
			$command->bindValue(":P_HANDPHONE_NUM",$this->handphone_num,PDO::PARAM_STR);
			$command->bindValue(":P_FAX_NUM",$this->fax_num,PDO::PARAM_STR);
			$command->bindValue(":P_REGN_CD",$this->regn_cd,PDO::PARAM_STR);
			$command->bindValue(":P_LIC_NUM",$this->lic_num,PDO::PARAM_STR);
			$command->bindValue(":P_LIC_EXPRY_DT",$this->lic_expry_dt,PDO::PARAM_STR);
			$command->bindValue(":P_REM_SUSP_STAT",$this->rem_susp_stat,PDO::PARAM_STR);
			$command->bindValue(":P_IC_TYPE",$this->ic_type,PDO::PARAM_STR);
			$command->bindValue(":P_EMAIL",$this->email,PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH_CD",$this->branch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_NPWP_NUMBER",$this->npwp_number,PDO::PARAM_STR);
			$command->bindValue(":P_PTKP_TYPE",$this->ptkp_type,PDO::PARAM_STR);
			$command->bindValue(":P_WARN_PPH21",$this->warn_pph21_rate,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR",$this->def_addr,PDO::PARAM_STR);
			
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
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

	public function rules() // RD 13 Oktober 2017 add npwp_number, ptkp_type, warn_pph21_rate
	{
		return array(
			array('rem_birth_dt, join_dt, lic_expry_dt, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSp'),
			array('dep_val, exp_lim, commission_val, basic_salary, incentive_per', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('rem_cd, rem_type, rem_name, rem_name_abbr, join_dt, lic_num, branch_cd,def_addr_1', 'required'),
			array('lic_expry_dt', 'required','on'=>'licensed'),			
			array('dep_val, exp_lim, commission_val, basic_salary, incentive_per', 'numerical'),
			array('rem_type, rem_susp_stat, ic_type, race, rem_main_sub, incentive_flg, incentive_basis, approved_stat', 'length', 'max'=>1),
			array('rem_cd','length','max'=>3),
			array('rem_name, email', 'length', 'max'=>50),
			array('rem_name_abbr, lic_num, npwp_number', 'length', 'max'=>20),
			array('rem_ic_num, def_addr_1, def_addr_2, def_addr_3, old_ic_num', 'length', 'max'=>30),
			array('post_cd', 'length', 'max'=>6),
			array('contact_pers', 'length', 'max'=>40),
			array('phone_num, handphone_num, fax_num, rem_acct_num', 'length', 'max'=>15),
			array('regn_cd, bank_cd, sub_rem_cd, branch_cd', 'length', 'max'=>3),
			array('bank_brch_cd', 'length', 'max'=>2),
			array('user_id', 'length', 'max'=>8),
			array('upd_by, approved_by', 'length', 'max'=>10),
			array('def_addr', 'length', 'max'=>150),
			array('rem_birth_dt, cre_dt, upd_dt, approved_dt, ptkp_type, warn_pph21_rate', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('rem_type, rem_cd, rem_name, rem_name_abbr, rem_birth_dt, join_dt, rem_ic_num, def_addr_1, def_addr_2, def_addr_3, post_cd, contact_pers, phone_num, handphone_num, fax_num, regn_cd, lic_num, lic_expry_dt, bank_cd, bank_brch_cd, rem_acct_num, dep_val, exp_lim, rem_susp_stat, cre_dt, upd_dt, user_id, ic_type, race, old_ic_num, rem_main_sub, sub_rem_cd, commission_val, basic_salary, email, branch_cd, incentive_flg, incentive_basis, incentive_per, upd_by, approved_dt, approved_by, approved_stat, def_addr,rem_birth_dt_date,rem_birth_dt_month,rem_birth_dt_year,join_dt_date,join_dt_month,join_dt_year,lic_expry_dt_date,lic_expry_dt_month,lic_expry_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year,npwp_number,ptkp_type', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			//'branch' => array(self::BELONGS_TO, 'Branch', array('branch_cd'=>'brch_cd')),
		);
	}

	public function attributeLabels()
	{
		return array(
			'rem_type' => 'Type',
			'rem_cd' => 'Code',
			'rem_name' => 'Name',
			'rem_name_abbr' => 'Abbr.',
			'ic_type' => 'Identity Type',
			'rem_ic_num' => 'Identity Number',
			'lic_num' => 'License',
			'lic_expry_dt' => 'License Expiry Date',
			
			'rem_birth_dt' => 'Rem Birth Date',
			'join_dt' => 'Join Date',
			'def_addr_1' => 'Address',
			'def_addr_2' => ' ',
			'def_addr_3' => ' ',
			'post_cd' => 'Post Code',
			'contact_pers' => 'Contact Pers',
			'phone_num' => 'Phone Number',
			'handphone_num' => 'Handphone Number',
			'fax_num' => 'Fax Number',
			'regn_cd' => 'Regn Code',
			
			
			'bank_cd' => 'Bank Code',
			'bank_brch_cd' => 'Bank Brch Code',
			'rem_acct_num' => 'Rem Acct Num',
			'dep_val' => 'Dep Val',
			'exp_lim' => 'Exp Lim',
			'rem_susp_stat' => 'Status',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'user_id' => 'User',
			
			'race' => 'Race',
			'old_ic_num' => 'Old Ic Num',
			'rem_main_sub' => 'Rem Main Sub',
			'sub_rem_cd' => 'Sub Rem Code',
			'commission_val' => 'Commission Val',
			'basic_salary' => 'Basic Salary',
			'email' => 'E-mail',
			'branch_cd' => 'Branch',
			'incentive_flg' => 'Incentive Flg',
			'incentive_basis' => 'Incentive Basis',
			'incentive_per' => 'Incentive Per',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
			'def_addr' => 'Def Addr',
			'npwp_number' => 'Nomer NPWP', //RD 6 Oktober 2017
			'ptkp_type' => 'PTKP', //RD 12 Oktober 2017
			'warn_pph21_rate' => 'Rate PPH21 Warning', //RD 13 Oktober 2017 
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		
		$criteria->addCondition("UPPER(rem_cd) LIKE UPPER('".$this->rem_cd."%')");
		if(!empty($this->rem_name))
			$criteria->addCondition("UPPER(rem_name) LIKE UPPER('%".$this->rem_name."%')");
		
		$criteria->compare('rem_type',$this->rem_type,true);
		$criteria->compare('rem_name_abbr',$this->rem_name_abbr,true);

		if(!empty($this->rem_birth_dt_date))
			$criteria->addCondition("TO_CHAR(t.rem_birth_dt,'DD') LIKE '%".$this->rem_birth_dt_date."%'");
		if(!empty($this->rem_birth_dt_month))
			$criteria->addCondition("TO_CHAR(t.rem_birth_dt,'MM') LIKE '%".$this->rem_birth_dt_month."%'");
		if(!empty($this->rem_birth_dt_year))
			$criteria->addCondition("TO_CHAR(t.rem_birth_dt,'YYYY') LIKE '%".$this->rem_birth_dt_year."%'");
		
		if(!empty($this->join_dt_date))
			$criteria->addCondition("TO_CHAR(t.join_dt,'DD') LIKE '%".$this->join_dt_date."%'");
		if(!empty($this->join_dt_month))
			$criteria->addCondition("TO_CHAR(t.join_dt,'MM') LIKE '%".$this->join_dt_month."%'");
		if(!empty($this->join_dt_year))
			$criteria->addCondition("TO_CHAR(t.join_dt,'YYYY') LIKE '%".$this->join_dt_year."%'");		
		
		$criteria->compare('rem_ic_num',$this->rem_ic_num,true);
		$criteria->compare('def_addr_1',$this->def_addr_1,true);
		$criteria->compare('def_addr_2',$this->def_addr_2,true);
		$criteria->compare('def_addr_3',$this->def_addr_3,true);
		$criteria->compare('post_cd',$this->post_cd,true);
		$criteria->compare('contact_pers',$this->contact_pers,true);
		$criteria->compare('phone_num',$this->phone_num,true);
		$criteria->compare('handphone_num',$this->handphone_num,true);
		$criteria->compare('fax_num',$this->fax_num,true);
		$criteria->compare('regn_cd',$this->regn_cd,true);
		$criteria->compare('lic_num',$this->lic_num,true);

		if(!empty($this->lic_expry_dt_date))
			$criteria->addCondition("TO_CHAR(t.lic_expry_dt,'DD') LIKE '%".($this->lic_expry_dt_date)."%'");
		if(!empty($this->lic_expry_dt_month))
			$criteria->addCondition("TO_CHAR(t.lic_expry_dt,'MM') LIKE '%".($this->lic_expry_dt_month)."%'");
		if(!empty($this->lic_expry_dt_year))
			$criteria->addCondition("TO_CHAR(t.lic_expry_dt,'YYYY') LIKE '%".($this->lic_expry_dt_year)."%'");		$criteria->compare('bank_cd',$this->bank_cd,true);
		$criteria->compare('bank_brch_cd',$this->bank_brch_cd,true);
		$criteria->compare('rem_acct_num',$this->rem_acct_num,true);
		$criteria->compare('dep_val',$this->dep_val);
		$criteria->compare('exp_lim',$this->exp_lim);
		$criteria->compare('rem_susp_stat',$this->rem_susp_stat,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".($this->cre_dt_date)."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".($this->cre_dt_month)."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".($this->cre_dt_year)."%'");
		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".($this->upd_dt_date)."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".($this->upd_dt_month)."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".($this->upd_dt_year)."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('ic_type',$this->ic_type,true);
		$criteria->compare('race',$this->race,true);
		$criteria->compare('old_ic_num',$this->old_ic_num,true);
		$criteria->compare('rem_main_sub',$this->rem_main_sub,true);
		$criteria->compare('sub_rem_cd',$this->sub_rem_cd,true);
		$criteria->compare('commission_val',$this->commission_val);
		$criteria->compare('basic_salary',$this->basic_salary);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('branch_cd',$this->branch_cd,true);
		$criteria->compare('incentive_flg',$this->incentive_flg,true);
		$criteria->compare('incentive_basis',$this->incentive_basis,true);
		$criteria->compare('incentive_per',$this->incentive_per);
		$criteria->compare('upd_by',$this->upd_by,true);
		$criteria->compare('ptkp_type',$this->ptkp_type,true); //RD 12 Oktober 2017
		$criteria->compare('npwp_number',$this->npwp_number,true); //RD 6 Oktober 2017
		$criteria->compare('warn_pph21_rate',$this->warn_pph21_rate,true); //RD 13 Oktober 2017

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".($this->approved_dt_date)."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".($this->approved_dt_month)."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".($this->approved_dt_year)."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);
		$criteria->compare('def_addr',$this->def_addr,true);
		$sort = new CSort();
		$sort->defaultOrder = 'rem_cd';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}