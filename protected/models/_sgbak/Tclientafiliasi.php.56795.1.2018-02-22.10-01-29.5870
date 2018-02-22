<?php

/**
 * This is the model class for table "T_CLIENT_AFILIASI".
 *
 * The followings are the available columns in table 'T_CLIENT_AFILIASI':
 * @property string $from_dt
 * @property string $to_dt
 * @property string $client_cd
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_by
 * @property string $upd_dt
 * @property string $approved_by
 * @property string $approved_dt
 * @property string $approved_sts
 */
class Tclientafiliasi extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $from_dt_date;
	public $from_dt_month;
	public $from_dt_year;

	public $to_dt_date;
	public $to_dt_month;
	public $to_dt_year;

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
		return 'T_CLIENT_AFILIASI';
	}

	public function rules()
	{
		return array(
		
			array('from_dt, to_dt, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('from_dt, client_cd', 'required'),
			array('client_cd', 'length', 'max'=>12),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_sts', 'length', 'max'=>1),
			array('to_dt, cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('from_dt, to_dt, client_cd, user_id, cre_dt, upd_by, upd_dt, approved_by, approved_dt, approved_sts,from_dt_date,from_dt_month,from_dt_year,to_dt_date,to_dt_month,to_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'from_dt' => 'From Date',
			'to_dt' => 'To Date',
			'client_cd' => 'Client Code',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_by' => 'Upd By',
			'upd_dt' => 'Upd Date',
			'approved_by' => 'Approved By',
			'approved_dt' => 'Approved Date',
			'approved_sts' => 'Approved Sts',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->from_dt_date))
			$criteria->addCondition("TO_CHAR(t.from_dt,'DD') LIKE '%".$this->from_dt_date."%'");
		if(!empty($this->from_dt_month))
			$criteria->addCondition("TO_CHAR(t.from_dt,'MM') LIKE '%".$this->from_dt_month."%'");
		if(!empty($this->from_dt_year))
			$criteria->addCondition("TO_CHAR(t.from_dt,'YYYY') LIKE '%".$this->from_dt_year."%'");
		if(!empty($this->to_dt_date))
			$criteria->addCondition("TO_CHAR(t.to_dt,'DD') LIKE '%".$this->to_dt_date."%'");
		if(!empty($this->to_dt_month))
			$criteria->addCondition("TO_CHAR(t.to_dt,'MM') LIKE '%".$this->to_dt_month."%'");
		if(!empty($this->to_dt_year))
			$criteria->addCondition("TO_CHAR(t.to_dt,'YYYY') LIKE '%".$this->to_dt_year."%'");		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('upd_by',$this->upd_by,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_sts',$this->approved_sts,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}