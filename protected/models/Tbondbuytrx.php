<?php

/**
 * This is the model class for table "T_BOND_BUY_TRX".
 *
 * The followings are the available columns in table 'T_BOND_BUY_TRX':
 * @property string $trx_date
 * @property integer $trx_seq_no
 * @property string $buy_dt
 * @property integer $buy_trx_seq
 * @property double $nominal
 * @property string $cre_dt
 * @property string $user_id
 * @property string $approved_sts
 * @property string $update_date
 * @property integer $update_seq
 * @property double $seqno
 */
class Tbondbuytrx extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $trx_date_date;
	public $trx_date_month;
	public $trx_date_year;

	public $buy_dt_date;
	public $buy_dt_month;
	public $buy_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $update_date_date;
	public $update_date_month;
	public $update_date_year;
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
		return 'T_BOND_BUY_TRX';
	}
	
	protected function afterFind()
	{
		$this->trx_date = Yii::app()->format->cleanDate($this->trx_date);
		$this->buy_dt = Yii::app()->format->cleanDate($this->buy_dt);
	}

	public function rules()
	{
		return array(
		
			array('trx_date, buy_dt, update_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('trx_seq_no, buy_trx_seq, nominal, update_seq, seqno', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('trx_date, buy_dt, buy_trx_seq', 'required'),
			array('trx_seq_no, buy_trx_seq, update_seq', 'numerical', 'integerOnly'=>true),
			array('nominal', 'numerical'),
			array('user_id', 'length', 'max'=>10),
			array('approved_sts', 'length', 'max'=>1),
			array('cre_dt, update_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('trx_date, trx_seq_no, buy_dt, buy_trx_seq, nominal, cre_dt, user_id, approved_sts, update_date, update_seq, seqno,trx_date_date,trx_date_month,trx_date_year,buy_dt_date,buy_dt_month,buy_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,update_date_date,update_date_month,update_date_year', 'safe', 'on'=>'search'),
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
			'buy_dt' => 'Buy Date',
			'buy_trx_seq' => 'Buy Trx Seq',
			'nominal' => 'Nominal',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'approved_sts' => 'Approved Sts',
			'update_date' => 'Update Date',
			'update_seq' => 'Update Seq',
			'seqno' => 'Seqno',
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

		if(!empty($this->buy_dt_date))
			$criteria->addCondition("TO_CHAR(t.buy_dt,'DD') LIKE '%".$this->buy_dt_date."%'");
		if(!empty($this->buy_dt_month))
			$criteria->addCondition("TO_CHAR(t.buy_dt,'MM') LIKE '%".$this->buy_dt_month."%'");
		if(!empty($this->buy_dt_year))
			$criteria->addCondition("TO_CHAR(t.buy_dt,'YYYY') LIKE '%".$this->buy_dt_year."%'");		$criteria->compare('buy_trx_seq',$this->buy_trx_seq);
		$criteria->compare('nominal',$this->nominal);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('approved_sts',$this->approved_sts,true);

		if(!empty($this->update_date_date))
			$criteria->addCondition("TO_CHAR(t.update_date,'DD') LIKE '%".$this->update_date_date."%'");
		if(!empty($this->update_date_month))
			$criteria->addCondition("TO_CHAR(t.update_date,'MM') LIKE '%".$this->update_date_month."%'");
		if(!empty($this->update_date_year))
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		$criteria->compare('update_seq',$this->update_seq);
		$criteria->compare('seqno',$this->seqno);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}