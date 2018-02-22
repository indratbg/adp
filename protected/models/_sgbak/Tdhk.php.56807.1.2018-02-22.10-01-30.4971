<?php

/**
 * This is the model class for table "T_DHK".
 *
 * The followings are the available columns in table 'T_DHK':
 * @property string $settle_date
 * @property string $subrek004
 * @property string $sid
 * @property string $subrek001
 * @property string $stk_cd
 * @property integer $net_buy
 * @property integer $net_sell
 * @property string $cre_dt
 * @property string $user_id
 */
class Tdhk extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $settle_date_date;
	public $settle_date_month;
	public $settle_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;
	public $file_upload;
	public $import_type;
	public $trx_date;
	public $type;
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
		return 'T_DHK';
	}

	public function rules()
	{
		return array(
		
			array('trx_date,settle_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('net_buy, net_sell', 'application.components.validator.ANumberSwitcherValidator'),
			array('file_upload','file','types'=>'txt','wrongType'=>'File type must be *.txt','on'=>'upload'),
			array('net_buy, net_sell', 'numerical', 'integerOnly'=>true),
			array('subrek004', 'length', 'max'=>14),
			array('sid', 'length', 'max'=>15),
			array('subrek001', 'length', 'max'=>17),
			array('stk_cd', 'length', 'max'=>25),
			array('user_id', 'length', 'max'=>10),
			array('type,import_type,settle_date, cre_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('settle_date, subrek004, sid, subrek001, stk_cd, net_buy, net_sell, cre_dt, user_id,settle_date_date,settle_date_month,settle_date_year,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
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
			'settle_date' => 'Settle Date',
			'subrek004' => 'Subrek004',
			'sid' => 'Sid',
			'subrek001' => 'Subrek001',
			'stk_cd' => 'Stk Code',
			'net_buy' => 'Net Buy',
			'net_sell' => 'Net Sell',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'trx_date'=>'Transaction Due Date'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->settle_date_date))
			$criteria->addCondition("TO_CHAR(t.settle_date,'DD') LIKE '%".$this->settle_date_date."%'");
		if(!empty($this->settle_date_month))
			$criteria->addCondition("TO_CHAR(t.settle_date,'MM') LIKE '%".$this->settle_date_month."%'");
		if(!empty($this->settle_date_year))
			$criteria->addCondition("TO_CHAR(t.settle_date,'YYYY') LIKE '%".$this->settle_date_year."%'");		$criteria->compare('subrek004',$this->subrek004,true);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('subrek001',$this->subrek001,true);
		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('net_buy',$this->net_buy);
		$criteria->compare('net_sell',$this->net_sell);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}