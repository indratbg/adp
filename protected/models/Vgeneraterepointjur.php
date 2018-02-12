<?php

/**
 * This is the model class for table "V_GENERATE_REPO_INT_JUR".
 *
 * The followings are the available columns in table 'V_GENERATE_REPO_INT_JUR':
 * @property string $repo_num
 * @property string $repo_type
 * @property string $repo_ref
 * @property string $client_cd
 * @property string $repo_date
 * @property string $due_date
 * @property double $repo_val
 * @property double $interest_rate
 * @property double $days
 * @property double $int_amt
 * @property double $int_aft_tax
 * @property double $int_tax_amt
 * @property string $jur_flg
 * @property string $folder_cd
 */
class Vgeneraterepointjur extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $repo_date_date;
	public $repo_date_month;
	public $repo_date_year;

	public $due_date_date;
	public $due_date_month;
	public $due_date_year;
	public $jur_date;
	public $jurnal_type;
	public $end_date;
	public $save_flg = 'N';
	public $sign_jur;
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
		return 'V_GENERATE_REPO_INT_JUR';
	}

	public function rules()
	{
		return array(
		
			array('jur_date,repo_date, due_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('repo_val, interest_rate, days, int_amt, int_aft_tax, int_tax_amt', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('repo_num, repo_date', 'required'),
			array('repo_val, interest_rate, days, int_amt, int_aft_tax, int_tax_amt', 'numerical'),
			array('repo_num', 'length', 'max'=>17),
			array('repo_type', 'length', 'max'=>10),
			array('repo_ref', 'length', 'max'=>30),
			array('client_cd', 'length', 'max'=>12),
			array('jur_flg', 'length', 'max'=>1),
			array('sign_jur,save_flg,jur_date,jurnal_type,due_date, folder_cd', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('repo_num, repo_type, repo_ref, client_cd, repo_date, due_date, repo_val, interest_rate, days, int_amt, int_aft_tax, int_tax_amt, jur_flg, folder_cd,repo_date_date,repo_date_month,repo_date_year,due_date_date,due_date_month,due_date_year', 'safe', 'on'=>'search'),
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
			'repo_num' => 'Repo Num',
			'repo_type' => 'Repo Type',
			'repo_ref' => 'Repo Ref',
			'client_cd' => 'Client Code',
			'repo_date' => 'Repo Date',
			'due_date' => 'Due Date',
			'repo_val' => 'Repo Val',
			'interest_rate' => 'Interest Rate',
			'days' => 'Days',
			'int_amt' => 'Int Amt',
			'int_aft_tax' => 'Int Aft Tax',
			'int_tax_amt' => 'Int Tax Amt',
			'jur_flg' => 'Jur Flg',
			'folder_cd' => 'Folder Code',
			'jur_date'=>'Journal Date'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('repo_num',$this->repo_num,true);
		$criteria->compare('repo_type',$this->repo_type,true);
		$criteria->compare('repo_ref',$this->repo_ref,true);
		$criteria->compare('client_cd',$this->client_cd,true);

		if(!empty($this->repo_date_date))
			$criteria->addCondition("TO_CHAR(t.repo_date,'DD') LIKE '%".$this->repo_date_date."%'");
		if(!empty($this->repo_date_month))
			$criteria->addCondition("TO_CHAR(t.repo_date,'MM') LIKE '%".$this->repo_date_month."%'");
		if(!empty($this->repo_date_year))
			$criteria->addCondition("TO_CHAR(t.repo_date,'YYYY') LIKE '%".$this->repo_date_year."%'");
		if(!empty($this->due_date_date))
			$criteria->addCondition("TO_CHAR(t.due_date,'DD') LIKE '%".$this->due_date_date."%'");
		if(!empty($this->due_date_month))
			$criteria->addCondition("TO_CHAR(t.due_date,'MM') LIKE '%".$this->due_date_month."%'");
		if(!empty($this->due_date_year))
			$criteria->addCondition("TO_CHAR(t.due_date,'YYYY') LIKE '%".$this->due_date_year."%'");		$criteria->compare('repo_val',$this->repo_val);
		$criteria->compare('interest_rate',$this->interest_rate);
		$criteria->compare('days',$this->days);
		$criteria->compare('int_amt',$this->int_amt);
		$criteria->compare('int_aft_tax',$this->int_aft_tax);
		$criteria->compare('int_tax_amt',$this->int_tax_amt);
		$criteria->compare('jur_flg',$this->jur_flg,true);
		$criteria->compare('folder_cd',$this->folder_cd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}