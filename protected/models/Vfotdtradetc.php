<?php

/**
 * This is the model class for table "V_FOTD_TRADE_TC".
 *
 * The followings are the available columns in table 'V_FOTD_TRADE_TC':
 * @property string $client_cd
 * @property string $stk_cd
 * @property double $qty
 * @property string $belijual
 * @property string $trade_date
 */
class Vfotdtradetc extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $trade_date_date;
	public $trade_date_month;
	public $trade_date_year;
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
		return 'V_FOTD_TRADE_TC';
	}
	
	protected function afterFind()
	{
		$this->trade_date = Yii::app()->format->cleanDate($this->trade_date);
	}

	public function rules()
	{
		return array(
		
			array('trade_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('qty', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('trade_date', 'required'),
			array('qty', 'numerical'),
			array('client_cd, stk_cd', 'length', 'max'=>12),
			array('belijual', 'length', 'max'=>1),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, stk_cd, qty, belijual, trade_date,trade_date_date,trade_date_month,trade_date_year', 'safe', 'on'=>'search'),
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
			'client_cd' => 'Client Code',
			'stk_cd' => 'Stk Code',
			'qty' => 'Qty',
			'belijual' => 'Belijual',
			'trade_date' => 'Trade Date',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('belijual',$this->belijual,true);

		if(!empty($this->trade_date_date))
			$criteria->addCondition("TO_CHAR(t.trade_date,'DD') LIKE '%".$this->trade_date_date."%'");
		if(!empty($this->trade_date_month))
			$criteria->addCondition("TO_CHAR(t.trade_date,'MM') LIKE '%".$this->trade_date_month."%'");
		if(!empty($this->trade_date_year))
			$criteria->addCondition("TO_CHAR(t.trade_date,'YYYY') LIKE '%".$this->trade_date_year."%'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}