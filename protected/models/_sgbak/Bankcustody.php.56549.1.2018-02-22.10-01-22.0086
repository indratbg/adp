<?php

/**
 * This is the model class for table "MST_BANK_CUSTODY".
 *
 * The followings are the available columns in table 'MST_BANK_CUSTODY':
 * @property string $cbest_cd
 * @property string $custody_name
 * @property string $custody_addr
 * @property string $sr_custody_cd
 * @property string $ctp_cd
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_sts
 * @property string $contact_person
 * @property string $fax_num
 * @property string $phone_num
 * @property string $acct_num
 */
class Bankcustody extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
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
		return 'MST_BANK_CUSTODY';
	}
	
	public function getCustodianCdAndName()
	{
		return $this->cbest_cd." - ".$this->custody_name;
	}
	
	public function getCustodianCdAndSr()
	{
		return $this->sr_custody_cd." - ".$this->cbest_cd;
	}

	public function rules()
	{
		return array(
		
			array('approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('custody_name, contact_person', 'length', 'max'=>50),
			array('custody_addr', 'length', 'max'=>100),
			array('sr_custody_cd', 'length', 'max'=>25),
			array('ctp_cd', 'length', 'max'=>7),
			array('user_id, upd_by, approved_by, fax_num, acct_num', 'length', 'max'=>10),
			array('approved_sts', 'length', 'max'=>1),
			array('phone_num', 'length', 'max'=>15),
			array('cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('cbest_cd, custody_name, custody_addr, sr_custody_cd, ctp_cd, cre_dt, user_id, upd_dt, upd_by, approved_dt, approved_by, approved_sts, contact_person, fax_num, phone_num, acct_num,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'cbest_cd' => 'Cbest Code',
			'custody_name' => 'Custody Name',
			'custody_addr' => 'Custody Addr',
			'sr_custody_cd' => 'Sr Custody Code',
			'ctp_cd' => 'Ctp Code',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_sts' => 'Approved Sts',
			'contact_person' => 'Contact Person',
			'fax_num' => 'Fax Num',
			'phone_num' => 'Phone Num',
			'acct_num' => 'Acct Num',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('cbest_cd',$this->cbest_cd,true);
		$criteria->compare('custody_name',$this->custody_name,true);
		$criteria->compare('custody_addr',$this->custody_addr,true);
		$criteria->compare('sr_custody_cd',$this->sr_custody_cd,true);
		$criteria->compare('ctp_cd',$this->ctp_cd,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('upd_by',$this->upd_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_sts',$this->approved_sts,true);
		$criteria->compare('contact_person',$this->contact_person,true);
		$criteria->compare('fax_num',$this->fax_num,true);
		$criteria->compare('phone_num',$this->phone_num,true);
		$criteria->compare('acct_num',$this->acct_num,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}