<?php

/**
 * This is the model class for table "T_SECU_BAL".
 *
 * The followings are the available columns in table 'T_SECU_BAL':
 * @property string $bal_dt
 * @property string $client_cd
 * @property string $stk_cd
 * @property string $status
 * @property string $gl_acct_cd
 * @property integer $qty
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 */
class Tsecubal extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $bal_dt_date;
	public $bal_dt_month;
	public $bal_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
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
		return 'T_SECU_BAL';
	}

	public function rules()
	{
		return array(
		
			array('bal_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('qty', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('qty', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>10),
			array('cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('bal_dt, client_cd, stk_cd, status, gl_acct_cd, qty, cre_dt, user_id, upd_dt,bal_dt_date,bal_dt_month,bal_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'bal_dt' => 'Bal Date',
			'client_cd' => 'Client Code',
			'stk_cd' => 'Stk Code',
			'status' => 'Status',
			'gl_acct_cd' => 'Gl Acct Code',
			'qty' => 'Qty',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->bal_dt_date))
			$criteria->addCondition("TO_CHAR(t.bal_dt,'DD') LIKE '%".$this->bal_dt_date."%'");
		if(!empty($this->bal_dt_month))
			$criteria->addCondition("TO_CHAR(t.bal_dt,'MM') LIKE '%".$this->bal_dt_month."%'");
		if(!empty($this->bal_dt_year))
			$criteria->addCondition("TO_CHAR(t.bal_dt,'YYYY') LIKE '%".$this->bal_dt_year."%'");		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('qty',$this->qty);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}