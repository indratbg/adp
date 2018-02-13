<?php

/**
 * This is the model class for table "V_LAP_MKBD_VD51".
 *
 * The followings are the available columns in table 'V_LAP_MKBD_VD51':
 * @property string $mkbd_date
 * @property string $update_date
 * @property integer $update_seq
 * @property string $user_id
 * @property string $approved_stat
 * @property string $approved_by
 * @property string $approved_dt
 * @property string $cre_dt
 * @property string $price_date
 * @property string $savetxt_date
 * @property string $save_txt_by
 */
class Vlapmkbdvd51 extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $mkbd_date_date;
	public $mkbd_date_month;
	public $mkbd_date_year;

	public $update_date_date;
	public $update_date_month;
	public $update_date_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $price_date_date;
	public $price_date_month;
	public $price_date_year;

	public $savetxt_date_date;
	public $savetxt_date_month;
	public $savetxt_date_year;
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
		
			array('mkbd_date, update_date, approved_dt, price_date, savetxt_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('update_seq', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('update_date, update_seq', 'required'),
			array('update_seq', 'numerical', 'integerOnly'=>true),
			array('user_id, approved_by, save_txt_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('mkbd_date, approved_dt, cre_dt, price_date, savetxt_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('mkbd_date, update_date, update_seq, user_id, approved_stat, approved_by, approved_dt, cre_dt, price_date, savetxt_date, save_txt_by,mkbd_date_date,mkbd_date_month,mkbd_date_year,update_date_date,update_date_month,update_date_year,approved_dt_date,approved_dt_month,approved_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,price_date_date,price_date_month,price_date_year,savetxt_date_date,savetxt_date_month,savetxt_date_year', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}
	public function getPrimaryKey()
	{
		return array('update_date'=>$this->update_date,'update_seq'=>$this->update_seq);
	}
	public function attributeLabels()
	{
		return array(
			'mkbd_date' => 'MKBD Date',
			'update_date' => 'Generate Date',
			'update_seq' => 'Update Seq',
			'user_id' => 'Generate By',
			'approved_stat' => 'Approved Status',
			'approved_by' => 'Approved By',
			'approved_dt' => 'Approved Date',
			'cre_dt' => 'Cre Date',
			'price_date' => 'Price Date',
			'savetxt_date' => 'Save Txt Date',
			'save_txt_by' => 'Save Txt By',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->mkbd_date_date))
			$criteria->addCondition("TO_CHAR(t.mkbd_date,'DD') LIKE '%".$this->mkbd_date_date."%'");
		if(!empty($this->mkbd_date_month))
			$criteria->addCondition("TO_CHAR(t.mkbd_date,'MM') LIKE '%".$this->mkbd_date_month."%'");
		if(!empty($this->mkbd_date_year))
			$criteria->addCondition("TO_CHAR(t.mkbd_date,'YYYY') LIKE '%".$this->mkbd_date_year."%'");
		if(!empty($this->update_date_date))
			$criteria->addCondition("TO_CHAR(t.update_date,'DD') LIKE '%".$this->update_date_date."%'");
		if(!empty($this->update_date_month))
			$criteria->addCondition("TO_CHAR(t.update_date,'MM') LIKE '%".$this->update_date_month."%'");
		if(!empty($this->update_date_year))
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		$criteria->compare('update_seq',$this->update_seq);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);
		$criteria->compare('approved_by',$this->approved_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");
		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");
		if(!empty($this->price_date_date))
			$criteria->addCondition("TO_CHAR(t.price_date,'DD') LIKE '%".$this->price_date_date."%'");
		if(!empty($this->price_date_month))
			$criteria->addCondition("TO_CHAR(t.price_date,'MM') LIKE '%".$this->price_date_month."%'");
		if(!empty($this->price_date_year))
			$criteria->addCondition("TO_CHAR(t.price_date,'YYYY') LIKE '%".$this->price_date_year."%'");
		if(!empty($this->savetxt_date_date))
			$criteria->addCondition("TO_CHAR(t.savetxt_date,'DD') LIKE '%".$this->savetxt_date_date."%'");
		if(!empty($this->savetxt_date_month))
			$criteria->addCondition("TO_CHAR(t.savetxt_date,'MM') LIKE '%".$this->savetxt_date_month."%'");
		if(!empty($this->savetxt_date_year))
			$criteria->addCondition("TO_CHAR(t.savetxt_date,'YYYY') LIKE '%".$this->savetxt_date_year."%'");		$criteria->compare('save_txt_by',$this->save_txt_by,true);

		$sort = new CSort;
		$sort->defaultOrder = 'update_date desc, mkbd_date desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}