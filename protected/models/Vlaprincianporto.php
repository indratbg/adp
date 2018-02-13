<?php

/**
 * This is the model class for table "V_LAP_RINCIAN_PORTO".
 *
 * The followings are the available columns in table 'V_LAP_RINCIAN_PORTO':
 * @property string $update_date
 * @property integer $update_seq
 * @property string $report_date
 * @property string $rep_type
 * @property string $stk_cd
 * @property integer $port001
 * @property integer $port002
 * @property integer $port004
 * @property integer $client001
 * @property integer $client002
 * @property integer $client004
 * @property integer $subrek_qty
 * @property integer $jumlah_acct
 * @property string $user_id
 * @property string $approved_stat
 * @property string $approved_by
 * @property string $approved_dt
 */
class Vlaprincianporto extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $update_date_date;
	public $update_date_month;
	public $update_date_year;

	public $report_date_date;
	public $report_date_month;
	public $report_date_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	public $text;
	public $text2;
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
		return 'INSISTPRO_RPT.LAP_RINCIAN_PORTO';
	}

	public function rules()
	{
		return array(
		
			array('update_date, report_date, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('update_seq, port001, port002, port004, client001, client002, client004, subrek_qty, jumlah_acct', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('update_date, update_seq', 'required'),
			array('update_seq, port001, port002, port004, client001, client002, client004, subrek_qty, jumlah_acct', 'numerical', 'integerOnly'=>true),
			array('rep_type, approved_stat', 'length', 'max'=>1),
			array('stk_cd', 'length', 'max'=>50),
			array('user_id, approved_by', 'length', 'max'=>10),
			array('report_date, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('update_date, update_seq, report_date, rep_type, stk_cd, port001, port002, port004, client001, client002, client004, subrek_qty, jumlah_acct, user_id, approved_stat, approved_by, approved_dt,update_date_date,update_date_month,update_date_year,report_date_date,report_date_month,report_date_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'report_date' => 'Report Date',
			'rep_type' => 'Rep Type',
			'stk_cd' => 'Stk Code',
			'port001' => 'Port001',
			'port002' => 'Port002',
			'port004' => 'Port004',
			'client001' => 'Client001',
			'client002' => 'Client002',
			'client004' => 'Client004',
			'subrek_qty' => 'Subrek Qty',
			'jumlah_acct' => 'Jumlah Acct',
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

		if(!empty($this->report_date_date))
			$criteria->addCondition("TO_CHAR(t.report_date,'DD') LIKE '%".$this->report_date_date."%'");
		if(!empty($this->report_date_month))
			$criteria->addCondition("TO_CHAR(t.report_date,'MM') LIKE '%".$this->report_date_month."%'");
		if(!empty($this->report_date_year))
			$criteria->addCondition("TO_CHAR(t.report_date,'YYYY') LIKE '%".$this->report_date_year."%'");		$criteria->compare('rep_type',$this->rep_type,true);
		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('port001',$this->port001);
		$criteria->compare('port002',$this->port002);
		$criteria->compare('port004',$this->port004);
		$criteria->compare('client001',$this->client001);
		$criteria->compare('client002',$this->client002);
		$criteria->compare('client004',$this->client004);
		$criteria->compare('subrek_qty',$this->subrek_qty);
		$criteria->compare('jumlah_acct',$this->jumlah_acct);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);
		$criteria->compare('approved_by',$this->approved_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");
		
		$sort = new CSort;
		$sort->defaultOrder = 'stk_cd';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}