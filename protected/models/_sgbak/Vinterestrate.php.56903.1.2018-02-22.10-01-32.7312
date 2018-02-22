<?php

/**
 * This is the model class for table "V_INTEREST_RATE".
 *
 * The followings are the available columns in table 'V_INTEREST_RATE':
 * @property string $branch_code
 * @property string $client_cd
 * @property string $client_name
 * @property string $old_ic_num
 * @property double $ar
 * @property double $ap
 * @property string $eff_dt
 * @property string $cl_desc
 * @property string $obs
 * @property string $interest_type
 */
class Vinterestrate extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $eff_dt_date;
	public $eff_dt_month;
	public $eff_dt_year;
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
		return 'V_LATEST_INTEREST_RATE';
	}

	public function getPrimaryKey()
	{
		return array('client_cd' => $this->client_cd,'eff_dt' => $this->eff_dt);
	}

	public function rules()
	{
		return array(
		
			array('eff_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('ar, ap', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('ar, ap', 'numerical'),
			array('branch_code, obs', 'length', 'max'=>3),
			array('client_cd', 'length', 'max'=>12),
			array('client_name', 'length', 'max'=>50),
			array('old_ic_num', 'length', 'max'=>30),
			array('cl_desc', 'length', 'max'=>100),
			array('interest_type', 'length', 'max'=>7),
			array('eff_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('branch_code, client_cd, client_name, old_ic_num, ar, ap, eff_dt, cl_desc, obs, interest_type,eff_dt_date,eff_dt_month,eff_dt_year', 'safe', 'on'=>'search'),
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
			'branch_code' => 'Branch Code',
			'client_cd' => 'Client Code',
			'client_name' => 'Client Name',
			'old_ic_num' => 'Old Ic Num',
			'ar' => 'AR%',
			'ap' => 'AP%',
			'eff_dt' => 'Effective Date',
			'cl_desc' => 'Client type',
			'obs' => 'Obs',
			'interest_type' => 'Interest Type',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('branch_code',$this->branch_code,true);
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('old_ic_num',$this->old_ic_num,true);
		$criteria->compare('ar',$this->ar);
		$criteria->compare('ap',$this->ap);

		if(!empty($this->eff_dt_date))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'DD') LIKE '%".$this->eff_dt_date."%'");
		if(!empty($this->eff_dt_month))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'MM') LIKE '%".$this->eff_dt_month."%'");
		if(!empty($this->eff_dt_year))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'YYYY') LIKE '%".$this->eff_dt_year."%'");		$criteria->compare('cl_desc',$this->cl_desc,true);
		$criteria->compare('obs',$this->obs,true);
		$criteria->compare('interest_type',$this->interest_type,true);
		
		$criteria2 = new CDbCriteria;
		$criteria2->addCondition("t.eff_dt = (SELECT MAX(a.eff_dt) FROM t_interest_rate a WHERE a.client_cd = t.client_cd AND a.approved_stat = 'A')");
		$criteria2->addCondition("t.eff_dt IS NULL","OR");
		
		$criteria->mergeWith($criteria2, 'AND');
		$sort = new CSort;
		$sort->defaultOrder = 'branch_code, client_cd';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}