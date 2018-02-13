<?php

/**
 * This is the model class for table "T_BANK_STMT".
 *
 * The followings are the available columns in table 'T_BANK_STMT':
 * @property string $period_from
 * @property string $trx_date
 * @property integer $seqno
 * @property string $description
 * @property double $amount
 * @property string $db_cr_flg
 * @property double $balance
 * @property string $gl_acct_cd
 * @property string $sl_acct_cd
 * @property string $bank_acct_num
 */
class Tbankstmt extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $period_from_date;
	public $period_from_month;
	public $period_from_year;

	public $trx_date_date;
	public $trx_date_month;
	public $trx_date_year;
	public $file_upload;
	public $import_type;
	
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
		return 'T_BANK_STMT';
	}

	public function rules()
	{
		return array(
		
			array('trx_date,period_from,period_to', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('seqno, amount, balance', 'application.components.validator.ANumberSwitcherValidator'),
			array('file_upload','file','types'=>'csv','wrongType'=>'File type must be *.csv','on'=>'upload'),
			array('period_from, gl_acct_cd, sl_acct_cd', 'required','on'=>'upload'),
			array('seqno', 'numerical', 'integerOnly'=>true),
			array('amount, balance', 'numerical'),
			array('description', 'length', 'max'=>100),
			array('db_cr_flg', 'length', 'max'=>2),
			array('gl_acct_cd, sl_acct_cd', 'length', 'max'=>12),
			array('bank_acct_num', 'length', 'max'=>30),
			array('period_from,import_type','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('period_from, trx_date, seqno, description, amount, db_cr_flg, balance, gl_acct_cd, sl_acct_cd, bank_acct_num,period_from_date,period_from_month,period_from_year,trx_date_date,trx_date_month,trx_date_year', 'safe', 'on'=>'search'),
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
			'period_from' => 'Period',
			'trx_date' => 'Trx Date',
			'seqno' => 'Seqno',
			'description' => 'Description',
			'amount' => 'Amount',
			'db_cr_flg' => 'Db Cr Flg',
			'balance' => 'Balance',
			'gl_acct_cd' => 'Gl Acct Code',
			'sl_acct_cd' => 'Sl Acct Code',
			'bank_acct_num' => 'Bank Acct Num',
			'period_from'=>'Period From',
			'period_to'=>'To'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->select ='period_from,bank_acct_num, gl_acct_cd, sl_acct_cd';
		
		if(!empty($this->period_from_date))
			$criteria->addCondition("TO_CHAR(t.period_from,'DD') LIKE '%".$this->period_from_date."%'");
		if(!empty($this->period_from_month))
			$criteria->addCondition("TO_CHAR(t.period_from,'MM') LIKE '%".$this->period_from_month."%'");
		if(!empty($this->period_from_year))
			$criteria->addCondition("TO_CHAR(t.period_from,'YYYY') LIKE '%".$this->period_from_year."%'");
		if(!empty($this->trx_date_date))
			$criteria->addCondition("TO_CHAR(t.trx_date,'DD') LIKE '%".$this->trx_date_date."%'");
		if(!empty($this->trx_date_month))
			$criteria->addCondition("TO_CHAR(t.trx_date,'MM') LIKE '%".$this->trx_date_month."%'");
		if(!empty($this->trx_date_year))
			$criteria->addCondition("TO_CHAR(t.trx_date,'YYYY') LIKE '%".$this->trx_date_year."%'");		$criteria->compare('seqno',$this->seqno);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('db_cr_flg',$this->db_cr_flg,true);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('sl_acct_cd',$this->sl_acct_cd,true);
		$criteria->compare('bank_acct_num',$this->bank_acct_num,true);
		$sort = new CSort;
		$sort->defaultOrder='period_from desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}