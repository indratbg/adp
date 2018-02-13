<?php

/**
 * This is the model class for table "LAP_MKBD_VD51".
 *
 * The followings are the available columns in table 'LAP_MKBD_VD51':
 * @property string $update_date
 * @property integer $update_seq
 * @property string $mkbd_date
 * @property string $vd
 * @property string $mkbd_cd
 * @property string $description
 * @property integer $c1
 * @property string $user_id
 * @property string $approved_stat
 * @property string $approved_by
 * @property string $approved_dt
 */
class Lapmkbdvd51 extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $update_date_date;
	public $update_date_month;
	public $update_date_year;

	public $mkbd_date_date;
	public $mkbd_date_month;
	public $mkbd_date_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	public $text_vd51;
	public $text_vd52;
	public $text_vd53;
	public $text_vd54;
	public $text_vd55;
	public $text_vd56a;
	public $text_vd56b;
	public $text_vd57;
	public $text_vd58;
	public $text_vd59;
	public $text_vd510a;
	public $text_vd510b;
	public $text_vd510c;
	public $text_vd510d;
	public $text_vd510e;
	public $text_vd510f;
	public $text_vd510g;
	public $text_vd510h;
	public $text_vd510i;
	
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
		return 'V_LAP_MKBD_VD51';
	}

	public function rules()
	{
		return array(
		
			array('update_date, mkbd_date, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('update_seq, c1', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('update_date, update_seq', 'required'),
			array('update_seq, c1', 'numerical', 'integerOnly'=>true),
			array('vd', 'length', 'max'=>6),
			array('mkbd_cd', 'length', 'max'=>8),
			array('description', 'length', 'max'=>200),
			array('user_id, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('mkbd_date, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('update_date, update_seq, mkbd_date, vd, mkbd_cd, description, c1, user_id, approved_stat, approved_by, approved_dt,update_date_date,update_date_month,update_date_year,mkbd_date_date,mkbd_date_month,mkbd_date_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'update_date' => 'Update Date',
			'update_seq' => 'Update Seq',
			'mkbd_date' => 'Mkbd Date',
			'vd' => 'Vd',
			'mkbd_cd' => 'Mkbd Code',
			'description' => 'Description',
			'c1' => 'C1',
			'user_id' => 'User',
			'approved_stat' => 'Approved Stat',
			'approved_by' => 'Approved By',
			'approved_dt' => 'Approved Date',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->update_date_date))
			$criteria->addCondition("TO_CHAR(t.update_date,'DD') LIKE '%".$this->update_date_date."%'");
		if(!empty($this->update_date_month))
			$criteria->addCondition("TO_CHAR(t.update_date,'MM') LIKE '%".$this->update_date_month."%'");
		if(!empty($this->update_date_year))
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		$criteria->compare('update_seq',$this->update_seq);

		if(!empty($this->mkbd_date_date))
			$criteria->addCondition("TO_CHAR(t.mkbd_date,'DD') LIKE '%".$this->mkbd_date_date."%'");
		if(!empty($this->mkbd_date_month))
			$criteria->addCondition("TO_CHAR(t.mkbd_date,'MM') LIKE '%".$this->mkbd_date_month."%'");
		if(!empty($this->mkbd_date_year))
			$criteria->addCondition("TO_CHAR(t.mkbd_date,'YYYY') LIKE '%".$this->mkbd_date_year."%'");		$criteria->compare('vd',$this->vd,true);
		$criteria->compare('mkbd_cd',$this->mkbd_cd,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('c1',$this->c1);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);
		$criteria->compare('approved_by',$this->approved_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}