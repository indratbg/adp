<?php

/**
 * This is the model class for table "V_REPO_HARIAN".
 *
 * The followings are the available columns in table 'V_REPO_HARIAN':
 * @property string $report_date
 * @property string $repo_num
 * @property double $repo_type
 * @property string $client_cd
 * @property string $repo_date
 * @property string $extent_dt
 * @property string $due_date
 * @property string $stk_cd
 * @property double $sum_qty
 * @property double $bond_qty
 * @property double $sum_amt
 * @property double $days
 * @property string $repo_ref
 * @property string $lawan
 * @property double $stk_price
 * @property double $bond_price
 * @property double $agunan_prc
 * @property string $user_id
 * @property integer $rand_value
 * @property string $generate_date
 * @property string $nama_prsh
 * @property string $kode_ab
 */
class Vrepoharian extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $report_date_date;
	public $report_date_month;
	public $report_date_year;

	public $repo_date_date;
	public $repo_date_month;
	public $repo_date_year;

	public $extent_dt_date;
	public $extent_dt_month;
	public $extent_dt_year;

	public $due_date_date;
	public $due_date_month;
	public $due_date_year;

	public $generate_date_date;
	public $generate_date_month;
	public $generate_date_year;
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
		return 'V_REPO_HARIAN';
	}

	public function rules()
	{
		return array(
		
			array('report_date, repo_date, extent_dt, due_date, generate_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('repo_type, sum_qty, bond_qty, sum_amt, days, stk_price, bond_price, agunan_prc, rand_value', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('repo_num', 'required'),
			array('rand_value', 'numerical', 'integerOnly'=>true),
			array('repo_type, sum_qty, bond_qty, sum_amt, days, stk_price, bond_price, agunan_prc', 'numerical'),
			array('repo_num', 'length', 'max'=>17),
			array('client_cd', 'length', 'max'=>12),
			array('stk_cd, lawan, nama_prsh', 'length', 'max'=>50),
			array('repo_ref', 'length', 'max'=>30),
			array('user_id', 'length', 'max'=>10),
			array('kode_ab', 'length', 'max'=>2),
			array('report_date, repo_date, extent_dt, due_date, generate_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('report_date, repo_num, repo_type, client_cd, repo_date, extent_dt, due_date, stk_cd, sum_qty, bond_qty, sum_amt, days, repo_ref, lawan, stk_price, bond_price, agunan_prc, user_id, rand_value, generate_date, nama_prsh, kode_ab,report_date_date,report_date_month,report_date_year,repo_date_date,repo_date_month,repo_date_year,extent_dt_date,extent_dt_month,extent_dt_year,due_date_date,due_date_month,due_date_year,generate_date_date,generate_date_month,generate_date_year', 'safe', 'on'=>'search'),
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
			'report_date' => 'Report Date',
			'repo_num' => 'Repo Num',
			'repo_type' => 'Repo Type',
			'client_cd' => 'Client Code',
			'repo_date' => 'Repo Date',
			'extent_dt' => 'Extent Date',
			'due_date' => 'Due Date',
			'stk_cd' => 'Stk Code',
			'sum_qty' => 'Sum Qty',
			'bond_qty' => 'Bond Qty',
			'sum_amt' => 'Sum Amt',
			'days' => 'Days',
			'repo_ref' => 'Repo Ref',
			'lawan' => 'Lawan',
			'stk_price' => 'Stk Price',
			'bond_price' => 'Bond Price',
			'agunan_prc' => 'Agunan Prc',
			'user_id' => 'User',
			'rand_value' => 'Rand Value',
			'generate_date' => 'Generate Date',
			'nama_prsh' => 'Nama Prsh',
			'kode_ab' => 'Kode Ab',
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
			$criteria->addCondition("TO_CHAR(t.report_date,'YYYY') LIKE '%".$this->report_date_year."%'");		$criteria->compare('repo_num',$this->repo_num,true);
		$criteria->compare('repo_type',$this->repo_type);
		$criteria->compare('client_cd',$this->client_cd,true);

		if(!empty($this->repo_date_date))
			$criteria->addCondition("TO_CHAR(t.repo_date,'DD') LIKE '%".$this->repo_date_date."%'");
		if(!empty($this->repo_date_month))
			$criteria->addCondition("TO_CHAR(t.repo_date,'MM') LIKE '%".$this->repo_date_month."%'");
		if(!empty($this->repo_date_year))
			$criteria->addCondition("TO_CHAR(t.repo_date,'YYYY') LIKE '%".$this->repo_date_year."%'");
		if(!empty($this->extent_dt_date))
			$criteria->addCondition("TO_CHAR(t.extent_dt,'DD') LIKE '%".$this->extent_dt_date."%'");
		if(!empty($this->extent_dt_month))
			$criteria->addCondition("TO_CHAR(t.extent_dt,'MM') LIKE '%".$this->extent_dt_month."%'");
		if(!empty($this->extent_dt_year))
			$criteria->addCondition("TO_CHAR(t.extent_dt,'YYYY') LIKE '%".$this->extent_dt_year."%'");
		if(!empty($this->due_date_date))
			$criteria->addCondition("TO_CHAR(t.due_date,'DD') LIKE '%".$this->due_date_date."%'");
		if(!empty($this->due_date_month))
			$criteria->addCondition("TO_CHAR(t.due_date,'MM') LIKE '%".$this->due_date_month."%'");
		if(!empty($this->due_date_year))
			$criteria->addCondition("TO_CHAR(t.due_date,'YYYY') LIKE '%".$this->due_date_year."%'");		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('sum_qty',$this->sum_qty);
		$criteria->compare('bond_qty',$this->bond_qty);
		$criteria->compare('sum_amt',$this->sum_amt);
		$criteria->compare('days',$this->days);
		$criteria->compare('repo_ref',$this->repo_ref,true);
		$criteria->compare('lawan',$this->lawan,true);
		$criteria->compare('stk_price',$this->stk_price);
		$criteria->compare('bond_price',$this->bond_price);
		$criteria->compare('agunan_prc',$this->agunan_prc);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('rand_value',$this->rand_value);

		if(!empty($this->generate_date_date))
			$criteria->addCondition("TO_CHAR(t.generate_date,'DD') LIKE '%".$this->generate_date_date."%'");
		if(!empty($this->generate_date_month))
			$criteria->addCondition("TO_CHAR(t.generate_date,'MM') LIKE '%".$this->generate_date_month."%'");
		if(!empty($this->generate_date_year))
			$criteria->addCondition("TO_CHAR(t.generate_date,'YYYY') LIKE '%".$this->generate_date_year."%'");		$criteria->compare('nama_prsh',$this->nama_prsh,true);
		$criteria->compare('kode_ab',$this->kode_ab,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}