<?php

/**
 * This is the model class for table "MST_CLIENT_REKEFEK".
 *
 * The followings are the available columns in table 'MST_CLIENT_REKEFEK':
 * @property string $client_cd
 * @property string $cifs
 * @property string $subrek_cd
 * @property string $status
 * @property string $open_date
 * @property string $close_date
 * @property string $cre_dt
 * @property string $cre_user_id
 * @property string $upd_dt
 * @property string $upd_user_id
 */
class Clientrek extends AActiveRecord
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $open_date_date;
	public $open_date_month;
	public $open_date_year;

	public $close_date_date;
	public $close_date_month;
	public $close_date_year;

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
		return 'MST_CLIENT_REKEFEK';
	}

	public function rules()
	{
		return array(
		
			array('open_date, close_date', 'application.components.validator.ADatePickerSwitcherValidator'),
			
			array('client_cd, cifs, subrek_cd', 'required'),
			array('client_cd', 'length', 'max'=>12),
			array('cifs', 'length', 'max'=>8),
			array('subrek_cd', 'length', 'max'=>14),
			array('status', 'length', 'max'=>1),
			array('cre_user_id, upd_user_id', 'length', 'max'=>10),
			array('open_date, close_date, cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, cifs, subrek_cd, status, open_date, close_date, cre_dt, cre_user_id, upd_dt, upd_user_id,open_date_date,open_date_month,open_date_year,close_date_date,close_date_month,close_date_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'cifs' => 'Cifs',
			'subrek_cd' => 'Subrek Code',
			'status' => 'Status',
			'open_date' => 'Open Date',
			'close_date' => 'Close Date',
			'cre_dt' => 'Cre Date',
			'cre_user_id' => 'Cre User',
			'upd_dt' => 'Upd Date',
			'upd_user_id' => 'Upd User',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('cifs',$this->cifs,true);
		$criteria->compare('subrek_cd',$this->subrek_cd,true);
		$criteria->compare('status',$this->status,true);

		if(!empty($this->open_date_date))
			$criteria->addCondition("TO_CHAR(t.open_date,'DD') LIKE '%".($this->open_date_date)."%'");
		if(!empty($this->open_date_month))
			$criteria->addCondition("TO_CHAR(t.open_date,'MM') LIKE '%".($this->open_date_month)."%'");
		if(!empty($this->open_date_year))
			$criteria->addCondition("TO_CHAR(t.open_date,'YYYY') LIKE '%".($this->open_date_year)."%'");
		if(!empty($this->close_date_date))
			$criteria->addCondition("TO_CHAR(t.close_date,'DD') LIKE '%".($this->close_date_date)."%'");
		if(!empty($this->close_date_month))
			$criteria->addCondition("TO_CHAR(t.close_date,'MM') LIKE '%".($this->close_date_month)."%'");
		if(!empty($this->close_date_year))
			$criteria->addCondition("TO_CHAR(t.close_date,'YYYY') LIKE '%".($this->close_date_year)."%'");
		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".($this->cre_dt_date)."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".($this->cre_dt_month)."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".($this->cre_dt_year)."%'");		$criteria->compare('cre_user_id',$this->cre_user_id,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".($this->upd_dt_date)."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".($this->upd_dt_month)."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".($this->upd_dt_year)."%'");		$criteria->compare('upd_user_id',$this->upd_user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}