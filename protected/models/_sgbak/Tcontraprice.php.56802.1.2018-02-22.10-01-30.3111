<?php

/**
 * This is the model class for table "T_CONTR_APRICE".
 *
 * The followings are the available columns in table 'T_CONTR_APRICE':
 * @property string $contr_dt
 * @property string $trx_type
 * @property double $aprice
 * @property string $from_contr_num
 * @property string $to_contr_num
 * @property string $stk_cd
 * @property string $orig_contr_num
 */
class Tcontraprice extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $contr_dt_date;
	public $contr_dt_month;
	public $contr_dt_year;
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
		return 'T_CONTR_APRICE';
	}
	
	protected function afterFind()
	{
		$this->contr_dt = Yii::app()->format->cleanDate($this->contr_dt);
	}

	public function rules()
	{
		return array(
		
			array('contr_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('aprice', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('aprice', 'numerical'),
			array('trx_type', 'length', 'max'=>1),
			array('stk_cd', 'length', 'max'=>50),
			array('orig_contr_num', 'length', 'max'=>17),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('contr_dt, trx_type, aprice, from_contr_num, to_contr_num, stk_cd, orig_contr_num,contr_dt_date,contr_dt_month,contr_dt_year', 'safe', 'on'=>'search'),
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
			'contr_dt' => 'Contr Date',
			'trx_type' => 'Trx Type',
			'aprice' => 'Aprice',
			'from_contr_num' => 'From Contr Num',
			'to_contr_num' => 'To Contr Num',
			'stk_cd' => 'Stk Code',
			'orig_contr_num' => 'Orig Contr Num',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->contr_dt_date))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'DD') LIKE '%".$this->contr_dt_date."%'");
		if(!empty($this->contr_dt_month))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'MM') LIKE '%".$this->contr_dt_month."%'");
		if(!empty($this->contr_dt_year))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'YYYY') LIKE '%".$this->contr_dt_year."%'");		$criteria->compare('trx_type',$this->trx_type,true);
		$criteria->compare('aprice',$this->aprice);
		$criteria->compare('from_contr_num',$this->from_contr_num,true);
		$criteria->compare('to_contr_num',$this->to_contr_num,true);
		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('orig_contr_num',$this->orig_contr_num,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}