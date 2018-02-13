<?php

/**
 * This is the model class for table "MST_BASE_PPH21".
 *
 * The followings are the available columns in table 'MST_BASE_PPH21':
 * @property double $base_pph21
 * @property double $min_val
 * @property double $max_val
 * @property string $npwp_flg
 * @property string $cre_dt
 * @property string $cre_by
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 * @property integer $pph21_rate
 */
class Basepph21 extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

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
		return 'MST_BASE_PPH21';
	}

	public function rules()
	{
		return array(
		
			array('approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('base_pph21, min_val, max_val, pph21_rate', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('pph21_rate', 'numerical', 'integerOnly'=>true),
			array('min_val, max_val', 'numerical'),
			array('cre_by, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('base_pph21, min_val, max_val, npwp_flg, cre_dt, cre_by, upd_dt, upd_by, approved_dt, approved_by, approved_stat, pph21_rate,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'base_pph21' => 'Base Pph21',
			'min_val' => 'Min Val',
			'max_val' => 'Max Val',
			'npwp_flg' => 'Npwp Flg',
			'cre_dt' => 'Cre Date',
			'cre_by' => 'Cre By',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Stat',
			'pph21_rate' => 'Pph21 Rate',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('base_pph21',$this->base_pph21);
		$criteria->compare('min_val',$this->min_val);
		$criteria->compare('max_val',$this->max_val);
		$criteria->compare('npwp_flg',$this->npwp_flg,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('cre_by',$this->cre_by,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('upd_by',$this->upd_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);
		$criteria->compare('pph21_rate',$this->pph21_rate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}