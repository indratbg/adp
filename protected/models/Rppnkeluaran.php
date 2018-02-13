<?php

/**
 * This is the model class for table "R_PPN_KELUARAN".
 *
 * The followings are the available columns in table 'R_PPN_KELUARAN':
 * @property string $client_cd
 * @property string $client_type_1
 * @property string $client_name
 * @property string $npwp_no
 * @property string $alamat
 * @property double $dpp
 * @property double $ppn
 * @property string $tanggal
 * @property string $user_id
 * @property integer $rand_value
 * @property string $generate_date
 * @property string $bgn_date
 * @property string $end_date
 * @property string $rpt_type
 * @property double $amount
 */
class Rppnkeluaran extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $tanggal_date;
	public $tanggal_month;
	public $tanggal_year;

	public $generate_date_date;
	public $generate_date_month;
	public $generate_date_year;

	public $bgn_date_date;
	public $bgn_date_month;
	public $bgn_date_year;

	public $end_date_date;
	public $end_date_month;
	public $end_date_year;
	public $save_flg='N';
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
    
	public function getDbConnection()
	{
		return Yii::app()->dbrpt;
	}

	public function tableName()
	{
		return 'R_PPN_KELUARAN';
	}

	public function rules()
	{
		return array(
		
			array('tanggal, generate_date, bgn_date, end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('dpp, ppn, rand_value, amount', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('client_cd', 'required'),
			array('rand_value', 'numerical', 'integerOnly'=>true),
			array('dpp, ppn, amount', 'numerical'),
			array('client_cd', 'length', 'max'=>12),
			array('client_type_1', 'length', 'max'=>1),
			array('client_name', 'length', 'max'=>50),
			array('npwp_no', 'length', 'max'=>30),
			array('alamat', 'length', 'max'=>229),
			array('user_id', 'length', 'max'=>10),
			array('rpt_type', 'length', 'max'=>20),
			array('save_flg, no_series, tanggal, generate_date, bgn_date, end_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, client_type_1, client_name, npwp_no, alamat, dpp, ppn, tanggal, user_id, rand_value, generate_date, bgn_date, end_date, rpt_type, amount,tanggal_date,tanggal_month,tanggal_year,generate_date_date,generate_date_month,generate_date_year,bgn_date_date,bgn_date_month,bgn_date_year,end_date_date,end_date_month,end_date_year', 'safe', 'on'=>'search'),
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
			'client_type_1' => 'Client Type 1',
			'client_name' => 'Client Name',
			'npwp_no' => 'Npwp No',
			'alamat' => 'Alamat',
			'dpp' => 'Dpp',
			'ppn' => 'Ppn',
			'tanggal' => 'Tanggal',
			'user_id' => 'User',
			'rand_value' => 'Rand Value',
			'generate_date' => 'Generate Date',
			'bgn_date' => 'Bgn Date',
			'end_date' => 'End Date',
			'rpt_type' => 'Rpt Type',
			'amount' => 'Amount',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('client_type_1',$this->client_type_1,true);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('npwp_no',$this->npwp_no,true);
		$criteria->compare('alamat',$this->alamat,true);
		$criteria->compare('dpp',$this->dpp);
		$criteria->compare('ppn',$this->ppn);

		if(!empty($this->tanggal_date))
			$criteria->addCondition("TO_CHAR(t.tanggal,'DD') LIKE '%".$this->tanggal_date."%'");
		if(!empty($this->tanggal_month))
			$criteria->addCondition("TO_CHAR(t.tanggal,'MM') LIKE '%".$this->tanggal_month."%'");
		if(!empty($this->tanggal_year))
			$criteria->addCondition("TO_CHAR(t.tanggal,'YYYY') LIKE '%".$this->tanggal_year."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('rand_value',$this->rand_value);

		if(!empty($this->generate_date_date))
			$criteria->addCondition("TO_CHAR(t.generate_date,'DD') LIKE '%".$this->generate_date_date."%'");
		if(!empty($this->generate_date_month))
			$criteria->addCondition("TO_CHAR(t.generate_date,'MM') LIKE '%".$this->generate_date_month."%'");
		if(!empty($this->generate_date_year))
			$criteria->addCondition("TO_CHAR(t.generate_date,'YYYY') LIKE '%".$this->generate_date_year."%'");
		if(!empty($this->bgn_date_date))
			$criteria->addCondition("TO_CHAR(t.bgn_date,'DD') LIKE '%".$this->bgn_date_date."%'");
		if(!empty($this->bgn_date_month))
			$criteria->addCondition("TO_CHAR(t.bgn_date,'MM') LIKE '%".$this->bgn_date_month."%'");
		if(!empty($this->bgn_date_year))
			$criteria->addCondition("TO_CHAR(t.bgn_date,'YYYY') LIKE '%".$this->bgn_date_year."%'");
		if(!empty($this->end_date_date))
			$criteria->addCondition("TO_CHAR(t.end_date,'DD') LIKE '%".$this->end_date_date."%'");
		if(!empty($this->end_date_month))
			$criteria->addCondition("TO_CHAR(t.end_date,'MM') LIKE '%".$this->end_date_month."%'");
		if(!empty($this->end_date_year))
			$criteria->addCondition("TO_CHAR(t.end_date,'YYYY') LIKE '%".$this->end_date_year."%'");		$criteria->compare('rpt_type',$this->rpt_type,true);
		$criteria->compare('amount',$this->amount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}