<?php

/**
 * This is the model class for table "V_LAP_RINCIAN_PORTO_INDEX".
 *
 * The followings are the available columns in table 'V_LAP_RINCIAN_PORTO_INDEX':
 * @property string $report_date
 * @property string $update_date
 * @property integer $update_seq
 * @property integer $jumlah_acct
 * @property string $user_id
 * @property string $approved_stat
 * @property string $approved_by
 * @property string $approved_dt
 */
class Vlaprincianportoindex extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $report_date_date;
	public $report_date_month;
	public $report_date_year;

	public $update_date_date;
	public $update_date_month;
	public $update_date_year;

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
		return 'V_LAP_RINCIAN_PORTO_INDEX';
	}

	public function rules()
	{
		return array(
		
			array('report_date, update_date, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('update_seq, jumlah_acct', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('update_date, update_seq', 'required'),
			array('update_seq, jumlah_acct', 'numerical', 'integerOnly'=>true),
			array('user_id, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('report_date, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('report_date, update_date, update_seq, jumlah_acct, user_id, approved_stat, approved_by, approved_dt,report_date_date,report_date_month,report_date_year,update_date_date,update_date_month,update_date_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'report_date' => 'Report Date',
			'update_date' => 'Generate Date',
			'update_seq' => 'Update Seq',
			'jumlah_acct' => 'Jumlah Account di KSEI',
			'user_id' => 'User',
			'approved_stat' => 'Approved Stat',
			'approved_by' => 'Approved By',
			'approved_dt' => 'Approved Date',
			'savetxt_date'=>'Save Txt Date'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->report_date_date))
			$criteria->addCondition("TO_CHAR(t.report_date,'DD') LIKE '%".$this->report_date_date."%'");
		if(!empty($this->report_date_month))
			$criteria->addCondition("TO_CHAR(t.report_date,'MM') LIKE '%".$this->report_date_month."%'");
		if(!empty($this->report_date_year))
			$criteria->addCondition("TO_CHAR(t.report_date,'YYYY') LIKE '%".$this->report_date_year."%'");
		if(!empty($this->update_date_date))
			$criteria->addCondition("TO_CHAR(t.update_date,'DD') LIKE '%".$this->update_date_date."%'");
		if(!empty($this->update_date_month))
			$criteria->addCondition("TO_CHAR(t.update_date,'MM') LIKE '%".$this->update_date_month."%'");
		if(!empty($this->update_date_year))
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		$criteria->compare('update_seq',$this->update_seq);
		$criteria->compare('jumlah_acct',$this->jumlah_acct);
		$criteria->compare('lower(user_id)',strtolower($this->user_id),true);
		$criteria->compare('approved_stat',$this->approved_stat,true);
		$criteria->compare('approved_by',$this->approved_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");
		$sort = new CSort;
		$sort->defaultOrder ='report_date desc,update_date desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}