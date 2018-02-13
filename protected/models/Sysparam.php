<?php

/**
 * This is the model class for table "MST_SYS_PARAM".
 *
 * The followings are the available columns in table 'MST_SYS_PARAM':
 * @property string $param_id
 * @property string $param_cd1
 * @property string $param_cd2
 * @property string $param_cd3
 * @property string $dstr1
 * @property string $dstr2
 * @property double $dnum1
 * @property double $dnum2
 * @property string $ddate1
 * @property string $ddate2
 * @property string $dflg1
 * @property string $dflg2
 */
class Sysparam extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $ddate1_date;
	public $ddate1_month;
	public $ddate1_year;

	public $ddate2_date;
	public $ddate2_month;
	public $ddate2_year;
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
		return 'MST_SYS_PARAM';
	}

	public function rules()
	{
		return array(
		
			array('ddate1, ddate2', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('dnum1, dnum2', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('param_id', 'required'),
			array('dnum1, dnum2', 'numerical'),
			array('param_id, dstr1, dstr2', 'length', 'max'=>30),
			array('param_cd1, param_cd2, param_cd3', 'length', 'max'=>8),
			array('dflg1, dflg2', 'length', 'max'=>1),
			array('ddate1, ddate2', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('param_id, param_cd1, param_cd2, param_cd3, dstr1, dstr2, dnum1, dnum2, ddate1, ddate2, dflg1, dflg2,ddate1_date,ddate1_month,ddate1_year,ddate2_date,ddate2_month,ddate2_year', 'safe', 'on'=>'search'),
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
			'param_id' => 'Param',
			'param_cd1' => 'Param Code1',
			'param_cd2' => 'Param Code2',
			'param_cd3' => 'Param Code3',
			'dstr1' => 'Dstr1',
			'dstr2' => 'Dstr2',
			'dnum1' => 'Dnum1',
			'dnum2' => 'Dnum2',
			'ddate1' => 'Ddate1',
			'ddate2' => 'Ddate2',
			'dflg1' => 'Dflg1',
			'dflg2' => 'Dflg2',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('param_id',$this->param_id,true);
		$criteria->compare('param_cd1',$this->param_cd1,true);
		$criteria->compare('param_cd2',$this->param_cd2,true);
		$criteria->compare('param_cd3',$this->param_cd3,true);
		$criteria->compare('dstr1',$this->dstr1,true);
		$criteria->compare('dstr2',$this->dstr2,true);
		$criteria->compare('dnum1',$this->dnum1);
		$criteria->compare('dnum2',$this->dnum2);

		if(!empty($this->ddate1_date))
			$criteria->addCondition("TO_CHAR(t.ddate1,'DD') LIKE '%".$this->ddate1_date."%'");
		if(!empty($this->ddate1_month))
			$criteria->addCondition("TO_CHAR(t.ddate1,'MM') LIKE '%".$this->ddate1_month."%'");
		if(!empty($this->ddate1_year))
			$criteria->addCondition("TO_CHAR(t.ddate1,'YYYY') LIKE '%".$this->ddate1_year."%'");
		if(!empty($this->ddate2_date))
			$criteria->addCondition("TO_CHAR(t.ddate2,'DD') LIKE '%".$this->ddate2_date."%'");
		if(!empty($this->ddate2_month))
			$criteria->addCondition("TO_CHAR(t.ddate2,'MM') LIKE '%".$this->ddate2_month."%'");
		if(!empty($this->ddate2_year))
			$criteria->addCondition("TO_CHAR(t.ddate2,'YYYY') LIKE '%".$this->ddate2_year."%'");		$criteria->compare('dflg1',$this->dflg1,true);
		$criteria->compare('dflg2',$this->dflg2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}