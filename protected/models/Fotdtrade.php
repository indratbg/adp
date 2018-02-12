<?php

/**
 * This is the model class for table "FOTD_TRADE".
 *
 * The followings are the available columns in table 'FOTD_TRADE':
 * @property string $execid
 * @property string $secondaryorderid
 * @property string $orderid
 * @property string $transacttime
 * @property string $effectivetime
 * @property string $side
 * @property string $clordid
 * @property string $clientid
 * @property string $execbroker
 * @property string $contrabroker
 * @property string $contratrader
 * @property string $account
 * @property string $symbol
 * @property string $symbolsfx
 * @property string $securityid
 * @property integer $price
 * @property integer $cumqty
 * @property string $text
 * @property string $clearingaccount
 * @property string $futsettdate
 * @property string $exectype
 * @property integer $lastpx
 * @property string $nocontrabrokers
 * @property string $exectranstype
 * @property string $ordstatus
 * @property integer $leavesqty
 * @property integer $avgpx
 * @property string $complianceid
 * @property string $userid
 * @property string $branchcode
 * @property string $ore_userid
 * @property string $create_date
 * @property string $trade_date
 * @property integer $lotsize
 */
class Fotdtrade extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $create_date_date;
	public $create_date_month;
	public $create_date_year;

	public $trade_date_date;
	public $trade_date_month;
	public $trade_date_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $client_cd;
	public $stk_cd;
	public $mrkt_type;
	public $due_date;
	public $trx_type;
	public $qty;
	
	public $check_flag;
	
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
		return 'V_FOTD_TRADE';
	}

	public function rules()
	{
		return array(
		
			array('create_date, trade_date, due_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('price, qty, cumqty, lastpx, leavesqty, avgpx, lotsize', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('secondaryorderid, orderid, trade_date', 'required','on'=>'insert,update'),
			array('due_date','required','on'=>'fixed'),
			array('price, cumqty, lastpx, leavesqty, avgpx, lotsize', 'numerical', 'integerOnly'=>true),
			array('execid, effectivetime, clordid, futsettdate, ore_userid', 'length', 'max'=>20),
			array('secondaryorderid, orderid', 'length', 'max'=>38),
			array('transacttime', 'length', 'max'=>30),
			array('side, exectype, nocontrabrokers, exectranstype, ordstatus', 'length', 'max'=>1),
			array('clientid, contrabroker, contratrader, account, symbol, securityid, clearingaccount, userid', 'length', 'max'=>12),
			array('execbroker', 'length', 'max'=>50),
			array('symbolsfx', 'length', 'max'=>3),
			array('text', 'length', 'max'=>255),
			array('complianceid', 'length', 'max'=>15),
			array('branchcode', 'length', 'max'=>2),
			array('create_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('execid, secondaryorderid, orderid, transacttime, effectivetime, side, clordid, clientid, execbroker, contrabroker, contratrader, account, symbol, symbolsfx, securityid, price, cumqty, text, clearingaccount, futsettdate, exectype, lastpx, nocontrabrokers, exectranstype, ordstatus, leavesqty, avgpx, complianceid, userid, branchcode, ore_userid, create_date, trade_date, lotsize,create_date_date,create_date_month,create_date_year,trade_date_date,trade_date_month,trade_date_year', 'safe', 'on'=>'search'),
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
			'execid' => 'Execid',
			'secondaryorderid' => 'Secondaryorderid',
			'orderid' => 'Orderid',
			'transacttime' => 'Transacttime',
			'effectivetime' => 'Effectivetime',
			'side' => 'Side',
			'clordid' => 'Clordid',
			'clientid' => 'Clientid',
			'execbroker' => 'Execbroker',
			'contrabroker' => 'Contrabroker',
			'contratrader' => 'Contratrader',
			'account' => 'Account',
			'symbol' => 'Symbol',
			'symbolsfx' => 'Symbolsfx',
			'securityid' => 'Securityid',
			'price' => 'Price',
			'cumqty' => 'Cumqty',
			'text' => 'Text',
			'clearingaccount' => 'Clearingaccount',
			'futsettdate' => 'Futsettdate',
			'exectype' => 'Exectype',
			'lastpx' => 'Lastpx',
			'nocontrabrokers' => 'Nocontrabrokers',
			'exectranstype' => 'Exectranstype',
			'ordstatus' => 'Ordstatus',
			'leavesqty' => 'Leavesqty',
			'avgpx' => 'Avgpx',
			'complianceid' => 'Complianceid',
			'userid' => 'Userid',
			'branchcode' => 'Branchcode',
			'ore_userid' => 'Ore Userid',
			'create_date' => 'Create Date',
			'trade_date' => 'Trade Date',
			'lotsize' => 'Lotsize',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('execid',$this->execid,true);
		$criteria->compare('secondaryorderid',$this->secondaryorderid,true);
		$criteria->compare('orderid',$this->orderid,true);
		$criteria->compare('transacttime',$this->transacttime,true);
		$criteria->compare('effectivetime',$this->effectivetime,true);
		$criteria->compare('side',$this->side,true);
		$criteria->compare('clordid',$this->clordid,true);
		$criteria->compare('clientid',$this->clientid,true);
		$criteria->compare('execbroker',$this->execbroker,true);
		$criteria->compare('contrabroker',$this->contrabroker,true);
		$criteria->compare('contratrader',$this->contratrader,true);
		$criteria->compare('account',$this->account,true);
		$criteria->compare('symbol',$this->symbol,true);
		$criteria->compare('symbolsfx',$this->symbolsfx,true);
		$criteria->compare('securityid',$this->securityid,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('cumqty',$this->cumqty);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('clearingaccount',$this->clearingaccount,true);
		$criteria->compare('futsettdate',$this->futsettdate,true);
		$criteria->compare('exectype',$this->exectype,true);
		$criteria->compare('lastpx',$this->lastpx);
		$criteria->compare('nocontrabrokers',$this->nocontrabrokers,true);
		$criteria->compare('exectranstype',$this->exectranstype,true);
		$criteria->compare('ordstatus',$this->ordstatus,true);
		$criteria->compare('leavesqty',$this->leavesqty);
		$criteria->compare('avgpx',$this->avgpx);
		$criteria->compare('complianceid',$this->complianceid,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('branchcode',$this->branchcode,true);
		$criteria->compare('ore_userid',$this->ore_userid,true);

		if(!empty($this->create_date_date))
			$criteria->addCondition("TO_CHAR(t.create_date,'DD') LIKE '%".$this->create_date_date."%'");
		if(!empty($this->create_date_month))
			$criteria->addCondition("TO_CHAR(t.create_date,'MM') LIKE '%".$this->create_date_month."%'");
		if(!empty($this->create_date_year))
			$criteria->addCondition("TO_CHAR(t.create_date,'YYYY') LIKE '%".$this->create_date_year."%'");
		if(!empty($this->trade_date_date))
			$criteria->addCondition("TO_CHAR(t.trade_date,'DD') LIKE '%".$this->trade_date_date."%'");
		if(!empty($this->trade_date_month))
			$criteria->addCondition("TO_CHAR(t.trade_date,'MM') LIKE '%".$this->trade_date_month."%'");
		if(!empty($this->trade_date_year))
			$criteria->addCondition("TO_CHAR(t.trade_date,'YYYY') LIKE '%".$this->trade_date_year."%'");		$criteria->compare('lotsize',$this->lotsize);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}