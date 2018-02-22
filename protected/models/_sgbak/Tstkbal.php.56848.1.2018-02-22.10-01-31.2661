<?php

/**
 * This is the model class for table "T_STKBAL".
 *
 * The followings are the available columns in table 'T_STKBAL':
 * @property string $bal_dt
 * @property string $client_cd
 * @property string $stk_cd
 * @property string $l_f
 * @property integer $beg_bal_qty
 * @property integer $beg_on_hand
 * @property integer $os_buy
 * @property integer $os_sell
 * @property integer $on_lent
 * @property integer $on_borrow
 * @property integer $repo_beli
 * @property integer $repo_jual
 * @property integer $on_bae
 * @property integer $on_custody
 * @property integer $repo_client
 * @property integer $repoj_client_in
 * @property double $avg_price
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property integer $os_corp_act
 * @property integer $os_bonus
 */
class Tstkbal extends AActiveRecordSP
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
		return 'T_STKBAL';
	}

	public function rules()
	{
		return array(
		
			array('bal_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('beg_bal_qty, beg_on_hand, os_buy, os_sell, on_lent, on_borrow, repo_beli, repo_jual, on_bae, on_custody, repo_client, repoj_client_in, avg_price, os_corp_act, os_bonus', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('bal_dt, client_cd, stk_cd, l_f', 'required'),
			array('beg_bal_qty, beg_on_hand, os_buy, os_sell, on_lent, on_borrow, repo_beli, repo_jual, on_bae, on_custody, repo_client, repoj_client_in, os_corp_act, os_bonus', 'numerical', 'integerOnly'=>true),
			array('avg_price', 'numerical'),
			array('client_cd', 'length', 'max'=>12),
			array('stk_cd', 'length', 'max'=>50),
			array('l_f', 'length', 'max'=>1),
			array('user_id, upd_by', 'length', 'max'=>10),
			array('cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('bal_dt, client_cd, stk_cd, l_f, beg_bal_qty, beg_on_hand, os_buy, os_sell, on_lent, on_borrow, repo_beli, repo_jual, on_bae, on_custody, repo_client, repoj_client_in, avg_price, cre_dt, user_id, upd_dt, upd_by, os_corp_act, os_bonus,bal_dt_date,bal_dt_month,bal_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'l_f' => 'L F',
			'beg_bal_qty' => 'Beg Bal Qty',
			'beg_on_hand' => 'Beg On Hand',
			'os_buy' => 'Os Buy',
			'os_sell' => 'Os Sell',
			'on_lent' => 'On Lent',
			'on_borrow' => 'On Borrow',
			'repo_beli' => 'Repo Beli',
			'repo_jual' => 'Repo Jual',
			'on_bae' => 'On Bae',
			'on_custody' => 'On Custody',
			'repo_client' => 'Repo Client',
			'repoj_client_in' => 'Repoj Client In',
			'avg_price' => 'Avg Price',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'os_corp_act' => 'Os Corp Act',
			'os_bonus' => 'Os Bonus',
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
		$criteria->compare('l_f',$this->l_f,true);
		$criteria->compare('beg_bal_qty',$this->beg_bal_qty);
		$criteria->compare('beg_on_hand',$this->beg_on_hand);
		$criteria->compare('os_buy',$this->os_buy);
		$criteria->compare('os_sell',$this->os_sell);
		$criteria->compare('on_lent',$this->on_lent);
		$criteria->compare('on_borrow',$this->on_borrow);
		$criteria->compare('repo_beli',$this->repo_beli);
		$criteria->compare('repo_jual',$this->repo_jual);
		$criteria->compare('on_bae',$this->on_bae);
		$criteria->compare('on_custody',$this->on_custody);
		$criteria->compare('repo_client',$this->repo_client);
		$criteria->compare('repoj_client_in',$this->repoj_client_in);
		$criteria->compare('avg_price',$this->avg_price);

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
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('upd_by',$this->upd_by,true);
		$criteria->compare('os_corp_act',$this->os_corp_act);
		$criteria->compare('os_bonus',$this->os_bonus);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}