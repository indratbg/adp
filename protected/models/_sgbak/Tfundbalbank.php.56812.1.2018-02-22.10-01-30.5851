<?php

/**
 * This is the model class for table "T_FUND_BAL_BANK".
 *
 * The followings are the available columns in table 'T_FUND_BAL_BANK':
 * @property string $status_dt
 * @property string $nama
 * @property string $rdi_num
 * @property double $balance
 * @property string $user_id
 * @property string $cre_dt
 * @property string $bank_timestamp
 * @property string $rdi_bank_cd
 */
class Tfundbalbank extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $status_dt_date;
	public $status_dt_month;
	public $status_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $bank_timestamp_date;
	public $bank_timestamp_month;
	public $bank_timestamp_year;
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
		return 'T_FUND_BAL_BANK';
	}

	public function rules()
	{
		return array(
		
			array('status_dt, bank_timestamp', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('balance', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('balance', 'numerical'),
			array('nama', 'length', 'max'=>50),
			array('user_id', 'length', 'max'=>10),
			array('rdi_bank_cd', 'length', 'max'=>5),
			array('cre_dt, bank_timestamp', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('status_dt, nama, rdi_num, balance, user_id, cre_dt, bank_timestamp, rdi_bank_cd,status_dt_date,status_dt_month,status_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,bank_timestamp_date,bank_timestamp_month,bank_timestamp_year', 'safe', 'on'=>'search'),
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
			'status_dt' => 'Status Date',
			'nama' => 'Nama',
			'rdi_num' => 'Rdi Num',
			'balance' => 'Balance',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'bank_timestamp' => 'Bank Timestamp',
			'rdi_bank_cd' => 'Rdi Bank Code',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->status_dt_date))
			$criteria->addCondition("TO_CHAR(t.status_dt,'DD') LIKE '%".$this->status_dt_date."%'");
		if(!empty($this->status_dt_month))
			$criteria->addCondition("TO_CHAR(t.status_dt,'MM') LIKE '%".$this->status_dt_month."%'");
		if(!empty($this->status_dt_year))
			$criteria->addCondition("TO_CHAR(t.status_dt,'YYYY') LIKE '%".$this->status_dt_year."%'");		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('rdi_num',$this->rdi_num,true);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");
		if(!empty($this->bank_timestamp_date))
			$criteria->addCondition("TO_CHAR(t.bank_timestamp,'DD') LIKE '%".$this->bank_timestamp_date."%'");
		if(!empty($this->bank_timestamp_month))
			$criteria->addCondition("TO_CHAR(t.bank_timestamp,'MM') LIKE '%".$this->bank_timestamp_month."%'");
		if(!empty($this->bank_timestamp_year))
			$criteria->addCondition("TO_CHAR(t.bank_timestamp,'YYYY') LIKE '%".$this->bank_timestamp_year."%'");		$criteria->compare('rdi_bank_cd',$this->rdi_bank_cd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}