<?php

/**
 * This is the model class for table "T_EXCEPTION_SPLITTING".
 *
 * The followings are the available columns in table 'T_EXCEPTION_SPLITTING':
 * @property string $client_cd
 * @property string $available_dt
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 */
class Texceptionsplitting extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $available_dt_date;
	public $available_dt_month;
	public $available_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
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
		return 'T_EXCEPTION_SPLITTING';
	}
	
	public function getPrimaryKey(){
		return array('client_cd'=>$this->client_cd, 'available_dt'=>$this->available_dt);
	}

	public function rules()
	{
		return array(
		
			array('available_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('client_cd, available_dt','required'),
			array('user_id, upd_by', 'length', 'max'=>10),
			array('cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, available_dt, cre_dt, user_id, upd_dt, upd_by,available_dt_date,available_dt_month,available_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'available_dt' => 'Available Date',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition("UPPER(client_cd) LIKE UPPER('".$this->client_cd."%')");

		if(!empty($this->available_dt_date))
			$criteria->addCondition("TO_CHAR(t.available_dt,'DD') LIKE '%".$this->available_dt_date."%'");
		if(!empty($this->available_dt_month))
			$criteria->addCondition("TO_CHAR(t.available_dt,'MM') LIKE '%".$this->available_dt_month."%'");
		if(!empty($this->available_dt_year))
			$criteria->addCondition("TO_CHAR(t.available_dt,'YYYY') LIKE '%".$this->available_dt_year."%'");
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

		$sort = new CSort;
		
		$sort->defaultOrder='available_dt desc, client_cd';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}