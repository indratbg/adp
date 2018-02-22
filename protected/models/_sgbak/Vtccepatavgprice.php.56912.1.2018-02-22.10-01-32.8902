<?php

/**
 * This is the model class for table "V_TC_CEPAT_AVG_PRICE".
 *
 * The followings are the available columns in table 'V_TC_CEPAT_AVG_PRICE':
 * @property string $client_cd
 * @property string $stk_cd
 * @property integer $qty
 * @property string $belijual
 * @property string $contr_num
 * @property string $contr_num_cepat
 * @property double $brok_perc
 * @property string $due_dt
 */
class Vtccepatavgprice extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $due_dt_date;
	public $due_dt_month;
	public $due_dt_year;
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
		return 'V_TC_CEPAT_AVG_PRICE';
	}

	public function rules()
	{
		return array(
		
			array('due_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('qty, brok_perc', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('qty', 'numerical', 'integerOnly'=>true),
			array('brok_perc', 'numerical'),
			array('client_cd, contr_num_cepat', 'length', 'max'=>12),
			array('stk_cd', 'length', 'max'=>50),
			array('belijual', 'length', 'max'=>1),
			array('contr_num', 'length', 'max'=>13),
			array('due_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, stk_cd, qty, belijual, contr_num, contr_num_cepat, brok_perc, due_dt,due_dt_date,due_dt_month,due_dt_year', 'safe', 'on'=>'search'),
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
			'stk_cd' => 'Stk Code',
			'qty' => 'Qty',
			'belijual' => 'Belijual',
			'contr_num' => 'Contr Num',
			'contr_num_cepat' => 'Contr Num Cepat',
			'brok_perc' => 'Brok Perc',
			'due_dt' => 'Due Date',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('belijual',$this->belijual,true);
		$criteria->compare('contr_num',$this->contr_num,true);
		$criteria->compare('contr_num_cepat',$this->contr_num_cepat,true);
		$criteria->compare('brok_perc',$this->brok_perc);

		if(!empty($this->due_dt_date))
			$criteria->addCondition("TO_CHAR(t.due_dt,'DD') LIKE '%".$this->due_dt_date."%'");
		if(!empty($this->due_dt_month))
			$criteria->addCondition("TO_CHAR(t.due_dt,'MM') LIKE '%".$this->due_dt_month."%'");
		if(!empty($this->due_dt_year))
			$criteria->addCondition("TO_CHAR(t.due_dt,'YYYY') LIKE '%".$this->due_dt_year."%'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}