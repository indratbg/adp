<?php

/**
 * This is the model class for table "T_PUSH_CLIENT".
 *
 * The followings are the available columns in table 'T_PUSH_CLIENT':
 * @property string $client_cd
 * @property string $push_date
 */
class Tpushclient extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $push_date_date;
	public $push_date_month;
	public $push_date_year;
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
		return 'T_PUSH_CLIENT';
	}

	public function rules()
	{
		return array(
		
			array('push_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('client_cd', 'length', 'max'=>12),
			array('push_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, push_date,push_date_date,push_date_month,push_date_year', 'safe', 'on'=>'search'),
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
			'push_date' => 'Client Date',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('client_cd',$this->client_cd,true);

		if(!empty($this->push_date_date))
			$criteria->addCondition("TO_CHAR(t.push_date,'DD') LIKE '%".$this->push_date_date."%'");
		if(!empty($this->push_date_month))
			$criteria->addCondition("TO_CHAR(t.push_date,'MM') LIKE '%".$this->push_date_month."%'");
		if(!empty($this->push_date_year))
			$criteria->addCondition("TO_CHAR(t.push_date,'YYYY') LIKE '%".$this->push_date_year."%'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}