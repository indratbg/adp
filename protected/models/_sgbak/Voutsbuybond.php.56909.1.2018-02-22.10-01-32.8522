<?php

/**
 * This is the model class for table "V_OUTS_BUY_BOND".
 *
 * The followings are the available columns in table 'V_OUTS_BUY_BOND':
 * @property string $trx_date
 * @property integer $trx_seq_no
 * @property string $trx_id
 * @property string $bond_cd
 * @property string $lawan
 * @property double $total_nominal
 * @property integer $jual
 * @property double $dijual
 * @property double $sisa_nominal
 * @property double $price
 * @property string $value_dt
 * @property string $trx_type
 * @property string $trx_ref
 */
class Voutsbuybond extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $trx_date_date;
	public $trx_date_month;
	public $trx_date_year;

	public $value_dt_date;
	public $value_dt_month;
	public $value_dt_year;
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
		return 'V_OUTS_BUY_BOND';
	}
	
	protected function afterFind()
	{
		$this->trx_date = Yii::app()->format->cleanDate($this->trx_date);
		$this->value_dt = Yii::app()->format->cleanDate($this->value_dt);
	}

	public function rules()
	{
		return array(
		
			array('trx_date, value_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('trx_seq_no, total_nominal, jual, dijual, sisa_nominal, price', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('trx_date, trx_seq_no, trx_id, bond_cd, value_dt, trx_type', 'required'),
			array('trx_seq_no, jual', 'numerical', 'integerOnly'=>true),
			array('total_nominal, dijual, sisa_nominal, price', 'numerical'),
			array('trx_id', 'length', 'max'=>5),
			array('bond_cd', 'length', 'max'=>20),
			array('lawan', 'length', 'max'=>10),
			array('trx_type', 'length', 'max'=>1),
			array('trx_ref', 'length', 'max'=>50),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('trx_date, trx_seq_no, trx_id, bond_cd, lawan, total_nominal, jual, dijual, sisa_nominal, price, value_dt, trx_type, trx_ref,trx_date_date,trx_date_month,trx_date_year,value_dt_date,value_dt_month,value_dt_year', 'safe', 'on'=>'search'),
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
			'trx_date' => 'Trx Date',
			'trx_seq_no' => 'Trx Seq No',
			'trx_id' => 'Trx',
			'bond_cd' => 'Bond Code',
			'lawan' => 'Lawan',
			'total_nominal' => 'Total Nominal',
			'jual' => 'Jual',
			'dijual' => 'Dijual',
			'sisa_nominal' => 'Sisa Nominal',
			'price' => 'Price',
			'value_dt' => 'Value Date',
			'trx_type' => 'Trx Type',
			'trx_ref' => 'Trx Ref',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->trx_date_date))
			$criteria->addCondition("TO_CHAR(t.trx_date,'DD') LIKE '%".$this->trx_date_date."%'");
		if(!empty($this->trx_date_month))
			$criteria->addCondition("TO_CHAR(t.trx_date,'MM') LIKE '%".$this->trx_date_month."%'");
		if(!empty($this->trx_date_year))
			$criteria->addCondition("TO_CHAR(t.trx_date,'YYYY') LIKE '%".$this->trx_date_year."%'");		$criteria->compare('trx_seq_no',$this->trx_seq_no);
		$criteria->compare('trx_id',$this->trx_id,true);
		$criteria->compare('bond_cd',$this->bond_cd,true);
		$criteria->compare('lawan',$this->lawan,true);
		$criteria->compare('total_nominal',$this->total_nominal);
		$criteria->compare('jual',$this->jual);
		$criteria->compare('dijual',$this->dijual);
		$criteria->compare('sisa_nominal',$this->sisa_nominal);
		$criteria->compare('price',$this->price);

		if(!empty($this->value_dt_date))
			$criteria->addCondition("TO_CHAR(t.value_dt,'DD') LIKE '%".$this->value_dt_date."%'");
		if(!empty($this->value_dt_month))
			$criteria->addCondition("TO_CHAR(t.value_dt,'MM') LIKE '%".$this->value_dt_month."%'");
		if(!empty($this->value_dt_year))
			$criteria->addCondition("TO_CHAR(t.value_dt,'YYYY') LIKE '%".$this->value_dt_year."%'");		$criteria->compare('trx_type',$this->trx_type,true);
		$criteria->compare('trx_ref',$this->trx_ref,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}