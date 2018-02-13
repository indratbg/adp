<?php

/**
 * This is the model class for table "MST_BRANCH".
 *
 * The followings are the available columns in table 'MST_BRANCH':
 * @property string $brch_cd
 * @property string $def_addr_1
 * @property string $def_addr_2
 * @property string $def_addr_3
 * @property string $post_cd
 * @property string $regn_cd
 * @property string $phone_num
 * @property string $fax_num
 * @property string $telex_num
 * @property string $contact_pers
 * @property string $e_mail1
 * @property string $hand_phone1
 * @property string $phone2_1
 * @property string $bank_cd
 * @property string $bank_brch_cd
 * @property string $brch_acct_num
 * @property string $brch_name
 * @property string $acct_prefix
 * @property string $cre_dt
 * @property string $user_id
 * @property string $branch_status
 * @property string $approved_stat
 */
class Branch extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;
	public $dataval;
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
    
	public function getCodeAndName()
	{
		return $this->brch_cd.' - '.$this->brch_name;
	}
	

	public function tableName()
	{
		return 'MST_BRANCH';
	}
	
	public static function getBranchName($value)
	{
		if($value !== NULL):	
			$value = trim($value);	
			$temp  = self::model()->find('brch_cd=:brch_cd',array(':brch_cd'=>$value));
			
			if($temp === null)
				return $value;
			return $temp->brch_name;
		endif;
		return $value;		
	}
	
	/*
	 * AH: provide char data to trim value according
	 *     especially those which shape combo box
	 */
	protected function afterFind()
	{
		$this->brch_cd = trim($this->brch_cd);
	}
	
	/*
	 *  AH: this function is for executing procedure
	 *  exec_status  : I/U/C
	 */
	public function executeSp($exec_status,$brch_cd)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_MST_BRANCH_UPD(
						:P_SEARCH_BRCH_CD,:P_BRCH_CD,:P_DEF_ADDR_1,:P_DEF_ADDR_2,:P_DEF_ADDR_3,:P_POST_CD,:P_REGN_CD,
						:P_PHONE_NUM,:P_FAX_NUM,:P_TELEX_NUM,:P_CONTACT_PERS,:P_E_MAIL1,:P_HAND_PHONE1,
						:P_PHONE2_1,:P_BANK_CD,:P_BANK_BRCH_CD,:P_BRCH_ACCT_NUM,:P_BRCH_NAME,:P_ACCT_PREFIX,:P_BRANCH_STATUS,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),:P_USER_ID,TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,:P_DEF_ADDR,:P_UPD_STATUS,:P_IP_ADDRESS,
						:P_CANCEL_REASON,:P_ERROR_CODE,:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_SEARCH_BRCH_CD",$brch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BRCH_CD",$this->brch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_1",$this->def_addr_1,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_2",$this->def_addr_2,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_3",$this->def_addr_3,PDO::PARAM_STR);
			$command->bindValue(":P_POST_CD",$this->post_cd,PDO::PARAM_STR);
			$command->bindValue(":P_REGN_CD",$this->regn_cd,PDO::PARAM_STR);
			$command->bindValue(":P_PHONE_NUM",$this->phone_num,PDO::PARAM_STR);
			$command->bindValue(":P_FAX_NUM",$this->fax_num,PDO::PARAM_STR);
			$command->bindValue(":P_TELEX_NUM",$this->telex_num,PDO::PARAM_STR);
			$command->bindValue(":P_CONTACT_PERS",$this->contact_pers,PDO::PARAM_STR);
			$command->bindValue(":P_E_MAIL1",$this->e_mail1,PDO::PARAM_STR);
			$command->bindValue(":P_HAND_PHONE1",$this->hand_phone1,PDO::PARAM_STR);
			$command->bindValue(":P_PHONE2_1",$this->phone2_1,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_CD",$this->bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_BRCH_CD",$this->bank_brch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BRCH_ACCT_NUM",$this->brch_acct_num,PDO::PARAM_STR);
			$command->bindValue(":P_BRCH_NAME",$this->brch_name,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_PREFIX",$this->acct_prefix,PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH_STATUS",$this->branch_status,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR",$this->def_addr,PDO::PARAM_STR);
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
	
	
	

	public function rules()
	{
		return array(
		
			array('brch_cd, brch_name, def_addr_1','required'),
			
			
			array('brch_cd, brch_name, def_addr_1, def_addr_2, e_mail1', 'length', 'max'=>50),
			array('brch_cd','length','is'=>2),
			array('bank_brch_cd','default','value'=>1),
			array('def_addr_3, brch_name', 'length', 'max'=>30),
			array('post_cd', 'length', 'max'=>6),
			array('regn_cd, bank_cd, bank_brch_cd', 'length', 'max'=>3),
			array('phone_num, fax_num, telex_num, hand_phone1, phone2_1', 'length', 'max'=>15),
			array('contact_pers', 'length', 'max'=>40),
			array('brch_acct_num', 'length', 'max'=>25),
			array('acct_prefix', 'length', 'max'=>2),
			array('approved_stat', 'length', 'max'=>1),
			array('user_id', 'length', 'max'=>8),
			array('cre_dt, branch_status, bank_cd, brch_acct_num', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			
			array('branch_status, brch_cd, def_addr_1, def_addr_2, def_addr_3, post_cd, regn_cd, phone_num, fax_num, telex_num, contact_pers, e_mail1, hand_phone1, phone2_1, bank_cd, bank_brch_cd, brch_acct_num, brch_name, acct_prefix, cre_dt, user_id,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			//'bankmaster' => array(self::BELONGS_TO, 'Bankmaster', array('bank_cd'=>'bank_cd')),
		);
	}

	public function attributeLabels()
	{
		return array(
			'brch_cd' => 'Branch Code',
			'def_addr_1' => 'Address',
			'def_addr_2' => ' ',
			'def_addr_3' => ' ',
			'post_cd' => 'Post Code',
			'regn_cd' => 'Regn Code',
			'phone_num' => 'Phone',
			'fax_num' => 'Fax',
			
			'contact_pers' => 'Contact Person',
			'e_mail1' => 'E-mail',
			'hand_phone1' => 'Handphone',
			'phone2_1' => ' ',
			'bank_cd' => 'Bank Code For Account Receiveable',
			'bank_brch_cd' => 'Bank Branch Code (AR) ',
			'brch_acct_num' => 'Account Number',
			'brch_name' => 'Branch Name',
			'acct_prefix' => 'Expense Account Prefix',
			'cre_dt' => 'Create Date',
			'user_id' => 'User',
			
			'telex_num' => 'Telex Num',
			'branch_status'=>'Branch Status'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition("UPPER(brch_cd) LIKE UPPER('".$this->brch_cd."%')");
		$criteria->compare('def_addr_1',$this->def_addr_1,true);
		$criteria->compare('def_addr_2',$this->def_addr_2,true);
		$criteria->compare('def_addr_3',$this->def_addr_3,true);
		$criteria->compare('post_cd',$this->post_cd,true);
		$criteria->compare('regn_cd',$this->regn_cd,true);
		$criteria->compare('phone_num',$this->phone_num,true);
		$criteria->compare('fax_num',$this->fax_num,true);
		$criteria->compare('telex_num',$this->telex_num,true);
		$criteria->compare('contact_pers',$this->contact_pers,true);
		$criteria->compare('e_mail1',$this->e_mail1,true);
		$criteria->compare('hand_phone1',$this->hand_phone1,true);
		$criteria->compare('phone2_1',$this->phone2_1,true);
		$criteria->compare('bank_cd',$this->bank_cd,true);
		$criteria->compare('bank_brch_cd',$this->bank_brch_cd,true);
		$criteria->compare('brch_acct_num',$this->brch_acct_num,true);
		$criteria->compare('brch_name',$this->brch_name,true);
		$criteria->compare('acct_prefix',$this->acct_prefix,true);
		$criteria->compare('branch_status',$this->branch_status,true);
		$criteria->compare('approved_stat','A',true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".($this->cre_dt_date)."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".($this->cre_dt_month)."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".($this->cre_dt_year)."%'");		$criteria->compare('user_id',$this->user_id,true);

		$sort = new CSort;
		
		$sort->defaultOrder='brch_cd';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}