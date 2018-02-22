<?php

/**
 * This is the model class for table "V_INDEX_SALES".
 *
 * The followings are the available columns in table 'V_INDEX_SALES':
 * @property string $rem_cd
 * @property string $rem_name
 * @property string $rem_type
 * @property string $rem_susp_stat
 * @property string $lic_num
 * @property string $branch_cd
 * @property string $brch_name
 * @property string $join_dt
 */
class Vindexsales extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $join_dt_date;
	public $join_dt_month;
	public $join_dt_year;
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
		return 'V_INDEX_SALES';
	}

	public function rules()
	{
		return array(
		
			array('join_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('rem_cd, rem_name, rem_type, lic_num, join_dt', 'required'),
			array('rem_cd, branch_cd', 'length', 'max'=>3),
			array('rem_name', 'length', 'max'=>50),
			array('rem_type, rem_susp_stat', 'length', 'max'=>1),
			array('lic_num', 'length', 'max'=>20),
			array('brch_name', 'length', 'max'=>30),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('rem_cd, rem_name, rem_type, rem_susp_stat, lic_num, branch_cd, brch_name, join_dt,join_dt_date,join_dt_month,join_dt_year', 'safe', 'on'=>'search'),
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
			'rem_cd' => 'Code',
			'rem_name' => 'Name',
			'rem_type' => 'Type',
			'rem_susp_stat' => 'Status',
			'lic_num' => 'License',
			'branch_cd' => 'Branch',
			'brch_name' => 'Branch',
			'join_dt' => 'Join Date',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition("UPPER(rem_cd) LIKE UPPER('".$this->rem_cd."%')");
		if(!empty($this->rem_name))
			$criteria->addCondition("UPPER(rem_name) LIKE UPPER('%".$this->rem_name."%')");
		$criteria->compare('rem_type',$this->rem_type,true);
		$criteria->compare('rem_susp_stat',$this->rem_susp_stat,true);
		$criteria->compare('lic_num',$this->lic_num,true);
		$criteria->compare('branch_cd',$this->branch_cd,true);
		$criteria->compare('brch_name',$this->brch_name,true);

		if(!empty($this->join_dt_date))
			$criteria->addCondition("TO_CHAR(t.join_dt,'DD') LIKE '%".$this->join_dt_date."%'");
		if(!empty($this->join_dt_month))
			$criteria->addCondition("TO_CHAR(t.join_dt,'MM') LIKE '%".$this->join_dt_month."%'");
		if(!empty($this->join_dt_year))
			$criteria->addCondition("TO_CHAR(t.join_dt,'YYYY') LIKE '%".$this->join_dt_year."%'");
		$sort = new CSort();
		$sort->defaultOrder = 'rem_cd';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}