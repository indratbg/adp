<?php

/**
 * This is the model class for table "tdpemployee".
 *
 * The followings are the available columns in table 'tdpemployee':
 * @property string $employee_cd
 * @property string $company_cd
 * @property string $branch_cd
 * @property string $employee_name
 * @property string $employee_type
 * @property string $email
 * @property string $join_dt
 * @property string $create_by
 * @property string $create_dttm
 * @property string $update_by
 * @property string $update_dttm
 */
class Employee extends AActiveRecord
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $join_dt_date;
	public $join_dt_month;
	public $join_dt_year;

	public $create_dttm_date;
	public $create_dttm_month;
	public $create_dttm_year;
	public $create_dttm_time;

	public $update_dttm_date;
	public $update_dttm_month;
	public $update_dttm_year;
	public $update_dttm_time;
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
		return 'tdpemployee';
	}

	public function rules()
	{
		return array(
		
			array('join_dt', 'application.components.validator.ADatePickerSwitcherValidator'),
			
			array('employee_cd, company_cd, branch_cd, employee_name, employee_type, join_dt', 'required'),
			array('employee_cd, employee_type', 'length', 'max'=>50),
			array('company_cd, branch_cd', 'length', 'max'=>20),
			array('employee_name', 'length', 'max'=>255),
			array('email', 'length', 'max'=>200),
			array('create_by, update_by', 'length', 'max'=>150),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('employee_cd, company_cd, branch_cd, employee_name, employee_type, email, join_dt, create_by, create_dttm, update_by, update_dttm,join_dt_date,join_dt_month,join_dt_year,create_dttm_date,create_dttm_month,create_dttm_year,create_dttm_time,update_dttm_date,update_dttm_month,update_dttm_year,update_dttm_time', 'safe', 'on'=>'search'),
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
			'employee_cd' => 'Employee Code',
			'company_cd' => 'Company Code',
			'branch_cd' => 'Branch Code',
			'employee_name' => 'Employee Name',
			'employee_type' => 'Employee Type',
			'email' => 'Email',
			'join_dt' => 'Join Date',
			'create_by' => 'Create By',
			'create_dttm' => 'Create Datetime',
			'update_by' => 'Update By',
			'update_dttm' => 'Update Datetime',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('employee_cd',$this->employee_cd,true);
		$criteria->compare('company_cd',$this->company_cd,true);
		$criteria->compare('branch_cd',$this->branch_cd,true);
		$criteria->compare('employee_name',$this->employee_name,true);
		$criteria->compare('employee_type',$this->employee_type,true);
		$criteria->compare('email',$this->email,true);

		if(!empty($this->join_dt_date))
			$criteria->addCondition("DATE_FORMAT(t.join_dt,'%d') LIKE '%".($this->join_dt_date)."%'");
		if(!empty($this->join_dt_month))
			$criteria->addCondition("DATE_FORMAT(t.join_dt,'%m') LIKE '%".($this->join_dt_month)."%'");
		if(!empty($this->join_dt_year))
			$criteria->addCondition("DATE_FORMAT(t.join_dt,'%Y') LIKE '%".($this->join_dt_year)."%'");
		$criteria->compare('create_by',$this->create_by,true);

		if(!empty($this->create_dttm_date))
			$criteria->addCondition("DATE_FORMAT(t.create_dttm,'%d') LIKE '%".($this->create_dttm_date)."%'");
		if(!empty($this->create_dttm_month))
			$criteria->addCondition("DATE_FORMAT(t.create_dttm,'%m') LIKE '%".($this->create_dttm_month)."%'");
		if(!empty($this->create_dttm_year))
			$criteria->addCondition("DATE_FORMAT(t.create_dttm,'%Y') LIKE '%".($this->create_dttm_year)."%'");
		if(!empty($this->create_dttm_time))
			$criteria->addCondition("DATE_FORMAT(t.create_dttm,'%H:%i') LIKE '%".($this->create_dttm_time)."%'");
		$criteria->compare('update_by',$this->update_by,true);

		if(!empty($this->update_dttm_date))
			$criteria->addCondition("DATE_FORMAT(t.update_dttm,'%d') LIKE '%".($this->update_dttm_date)."%'");
		if(!empty($this->update_dttm_month))
			$criteria->addCondition("DATE_FORMAT(t.update_dttm,'%m') LIKE '%".($this->update_dttm_month)."%'");
		if(!empty($this->update_dttm_year))
			$criteria->addCondition("DATE_FORMAT(t.update_dttm,'%Y') LIKE '%".($this->update_dttm_year)."%'");
		if(!empty($this->update_dttm_time))
			$criteria->addCondition("DATE_FORMAT(t.update_dttm,'%H:%i') LIKE '%".($this->update_dttm_time)."%'");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}