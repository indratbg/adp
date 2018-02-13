<?php

/**
 * This is the model class for table "V_BOND_COUPON".
 *
 * The followings are the available columns in table 'V_BOND_COUPON':
 * @property string $bond_cd
 * @property string $maturity_date
 * @property string $period_from
 * @property string $period_to
 * @property double $int_rate
 */
class Vbondcoupon extends AActiveRecord
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $maturity_date_date;
	public $maturity_date_month;
	public $maturity_date_year;

	public $period_from_date;
	public $period_from_month;
	public $period_from_year;

	public $period_to_date;
	public $period_to_month;
	public $period_to_year;
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
    
	protected function afterFind()
	{
		$this->maturity_date = Yii::app()->format->cleanDate($this->maturity_date);
		$this->period_from = Yii::app()->format->cleanDate($this->period_from);
		$this->period_to = Yii::app()->format->cleanDate($this->period_to);
	}

	public function tableName()
	{
		return 'V_BOND_COUPON';
	}

	public function rules()
	{
		return array(
		
			array('maturity_date, period_from, period_to', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('int_rate', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('bond_cd, period_from, period_to', 'required'),
			array('int_rate', 'numerical'),
			array('bond_cd', 'length', 'max'=>20),
			array('maturity_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('bond_cd, maturity_date, period_from, period_to, int_rate,maturity_date_date,maturity_date_month,maturity_date_year,period_from_date,period_from_month,period_from_year,period_to_date,period_to_month,period_to_year', 'safe', 'on'=>'search'),
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
			'bond_cd' => 'Bond Code',
			'maturity_date' => 'Maturity Date',
			'period_from' => 'Period From',
			'period_to' => 'Period To',
			'int_rate' => 'Int Rate',
		);
	}
	

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('bond_cd',$this->bond_cd,true);

		if(!empty($this->maturity_date_date))
			$criteria->addCondition("TO_CHAR(t.maturity_date,'DD') LIKE '%".$this->maturity_date_date."%'");
		if(!empty($this->maturity_date_month))
			$criteria->addCondition("TO_CHAR(t.maturity_date,'MM') LIKE '%".$this->maturity_date_month."%'");
		if(!empty($this->maturity_date_year))
			$criteria->addCondition("TO_CHAR(t.maturity_date,'YYYY') LIKE '%".$this->maturity_date_year."%'");
		if(!empty($this->period_from_date))
			$criteria->addCondition("TO_CHAR(t.period_from,'DD') LIKE '%".$this->period_from_date."%'");
		if(!empty($this->period_from_month))
			$criteria->addCondition("TO_CHAR(t.period_from,'MM') LIKE '%".$this->period_from_month."%'");
		if(!empty($this->period_from_year))
			$criteria->addCondition("TO_CHAR(t.period_from,'YYYY') LIKE '%".$this->period_from_year."%'");
		if(!empty($this->period_to_date))
			$criteria->addCondition("TO_CHAR(t.period_to,'DD') LIKE '%".$this->period_to_date."%'");
		if(!empty($this->period_to_month))
			$criteria->addCondition("TO_CHAR(t.period_to,'MM') LIKE '%".$this->period_to_month."%'");
		if(!empty($this->period_to_year))
			$criteria->addCondition("TO_CHAR(t.period_to,'YYYY') LIKE '%".$this->period_to_year."%'");		$criteria->compare('int_rate',$this->int_rate);

		$sort = new CSort();
		$sort->defaultOrder = 'bond_cd';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}