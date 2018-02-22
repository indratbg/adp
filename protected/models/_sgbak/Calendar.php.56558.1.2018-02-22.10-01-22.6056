<?php

/**
 * This is the model class for table "MST_CALENDAR".
 *
 * The followings are the available columns in table 'MST_CALENDAR':
 * @property string $tgl_libur
 * @property string $ket_libur
 * @property string $flag_libur
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Calendar extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $tgl_libur_date;
	public $tgl_libur_month;
	public $tgl_libur_year;

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
		return 'MST_CALENDAR';
	}

	public function rules()
	{
		return array(
		
			array('tgl_libur, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('ket_libur', 'length', 'max'=>40),
			array('flag_libur, approved_stat', 'length', 'max'=>1),
			array('user_id', 'length', 'max'=>8),
			array('upd_by, approved_by', 'length', 'max'=>10),
			array('cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('tgl_libur, ket_libur, flag_libur, user_id, cre_dt, upd_dt, upd_by, approved_dt, approved_by, approved_stat,tgl_libur_date,tgl_libur_month,tgl_libur_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'tgl_libur' => 'Tgl Libur',
			'ket_libur' => 'Ket Libur',
			'flag_libur' => 'Flag Libur',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Stat',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->tgl_libur_date))
			$criteria->addCondition("TO_CHAR(t.tgl_libur,'DD') LIKE '%".$this->tgl_libur_date."%'");
		if(!empty($this->tgl_libur_month))
			$criteria->addCondition("TO_CHAR(t.tgl_libur,'MM') LIKE '%".$this->tgl_libur_month."%'");
		if(!empty($this->tgl_libur_year))
			$criteria->addCondition("TO_CHAR(t.tgl_libur,'YYYY') LIKE '%".$this->tgl_libur_year."%'");		$criteria->compare('ket_libur',$this->ket_libur,true);
		$criteria->compare('flag_libur',$this->flag_libur,true);
		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");
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
		$criteria->compare('approved_stat',$this->approved_stat,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}