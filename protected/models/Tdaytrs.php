<?php

/**
 * This is the model class for table "T_DAY_TRS".
 *
 * The followings are the available columns in table 'T_DAY_TRS':
 * @property string $trs_dt
 * @property string $gl_acct_cd
 * @property string $sl_acct_cd
 * @property double $deb_todt
 * @property double $cre_todt
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $user_id
 * @property double $deb_obal
 * @property double $cre_obal
 * @property double $deb_qq
 * @property double $cre_qq
 */
class Tdaytrs extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $trs_dt_date;
	public $trs_dt_month;
	public $trs_dt_year;

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
		return 'T_DAY_TRS';
	}

	public function rules()
	{
		return array(
		
			array('trs_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('deb_todt, cre_todt, deb_obal, cre_obal, deb_qq, cre_qq', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('deb_todt, cre_todt, deb_obal, cre_obal, deb_qq, cre_qq', 'numerical'),
			array('user_id', 'length', 'max'=>10),
			array('cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('trs_dt, gl_acct_cd, sl_acct_cd, deb_todt, cre_todt, cre_dt, upd_dt, user_id, deb_obal, cre_obal, deb_qq, cre_qq,trs_dt_date,trs_dt_month,trs_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'trs_dt' => 'Trs Date',
			'gl_acct_cd' => 'Gl Acct Code',
			'sl_acct_cd' => 'Sl Acct Code',
			'deb_todt' => 'Deb Todt',
			'cre_todt' => 'Cre Todt',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'user_id' => 'User',
			'deb_obal' => 'Deb Obal',
			'cre_obal' => 'Cre Obal',
			'deb_qq' => 'Deb Qq',
			'cre_qq' => 'Cre Qq',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->trs_dt_date))
			$criteria->addCondition("TO_CHAR(t.trs_dt,'DD') LIKE '%".$this->trs_dt_date."%'");
		if(!empty($this->trs_dt_month))
			$criteria->addCondition("TO_CHAR(t.trs_dt,'MM') LIKE '%".$this->trs_dt_month."%'");
		if(!empty($this->trs_dt_year))
			$criteria->addCondition("TO_CHAR(t.trs_dt,'YYYY') LIKE '%".$this->trs_dt_year."%'");		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('sl_acct_cd',$this->sl_acct_cd,true);
		$criteria->compare('deb_todt',$this->deb_todt);
		$criteria->compare('cre_todt',$this->cre_todt);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");
		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('deb_obal',$this->deb_obal);
		$criteria->compare('cre_obal',$this->cre_obal);
		$criteria->compare('deb_qq',$this->deb_qq);
		$criteria->compare('cre_qq',$this->cre_qq);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}