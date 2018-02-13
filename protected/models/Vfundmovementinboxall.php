<?php

/**
 * This is the model class for table "V_FUND_MOVEMENT_INBOX".
 *
 * The followings are the available columns in table 'V_FUND_MOVEMENT_INBOX':
 * @property string $user_id
 * @property string $update_date
 * @property string $status
 * @property string $ip_address
 * @property string $doc_date
 * @property string $client_cd
 * @property string $trx_type
 * @property string $trx_amt
 * @property integer $update_seq
 * @property string $approved_status
 * @property string $menu_name
 * @property string $approved_date
 */
class Vfundmovementinboxall extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $update_date_date;
	public $update_date_month;
	public $update_date_year;

	public $approved_date_date;
	public $approved_date_month;
	public $approved_date_year;
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
		return 'V_FUND_MOVEMENT_INBOX';
	}
	
	
	public function rules()
	{
		return array(
		
			array('update_date, approved_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('update_seq', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('update_date, update_seq, menu_name', 'required'),
			array('update_seq', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>10),
			array('status, approved_status', 'length', 'max'=>1),
			array('ip_address', 'length', 'max'=>15),
			array('doc_date, client_cd, trx_type, trx_amt', 'length', 'max'=>200),
			array('menu_name', 'length', 'max'=>50),
			array('approved_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('user_id, update_date, status, ip_address, doc_date, client_cd, trx_type, trx_amt, update_seq, approved_status, menu_name, approved_date,update_date_date,update_date_month,update_date_year,approved_date_date,approved_date_month,approved_date_year', 'safe', 'on'=>'search'),
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
			'user_id' => 'Request By',
			'update_date' => 'Update Date',
			'status' => 'Status',
			'ip_address' => 'Ip Address',
			'doc_date' => 'Journal Date',
			'client_cd' => 'Client Code',
			'trx_type' => 'Movement Type',
			'trx_amt' => 'Amount',
			'update_seq' => 'Update Seq',
			'approved_status' => 'Approved Status',
			'menu_name' => 'Menu Name',
			'approved_date' => 'Approved Date',
			'fee'=>'FEE'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->update_date_date))
			$criteria->addCondition("TO_CHAR(t.update_date,'DD') LIKE '%".$this->update_date_date."%'");
		if(!empty($this->update_date_month))
			$criteria->addCondition("TO_CHAR(t.update_date,'MM') LIKE '%".$this->update_date_month."%'");
		if(!empty($this->update_date_year))
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		$criteria->compare('status',$this->status,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('doc_date',$this->doc_date,true);
		$criteria->compare('lower(client_cd)',strtolower($this->client_cd),true);
		$criteria->compare('trx_type',$this->trx_type,true);
		$criteria->compare('trx_amt',$this->trx_amt,true);
		$criteria->compare('update_seq',$this->update_seq);
		$criteria->compare('approved_status',$this->approved_status,true);
		//$criteria->compare('menu_name',$this->menu_name,true);
		$criteria->compare('fee',$this->fee,true);
		//$criteria->addCondition("menu_name in ('UPLOAD RDN MUTATION','FUND MOVEMENT ENTRY','IPO FUND ENTRY')");
		$criteria->addCondition("t.menu_name IN (".implode(',',$this->menu_name).")");
		if(!empty($this->approved_date_date))
			$criteria->addCondition("TO_CHAR(t.approved_date,'DD') LIKE '%".$this->approved_date_date."%'");
		if(!empty($this->approved_date_month))
			$criteria->addCondition("TO_CHAR(t.approved_date,'MM') LIKE '%".$this->approved_date_month."%'");
		if(!empty($this->approved_date_year))
			$criteria->addCondition("TO_CHAR(t.approved_date,'YYYY') LIKE '%".$this->approved_date_year."%'");
		
		$sort=new CSort();
		$page = new CPagination;
		$page->pageSize=100;
		$sort->defaultOrder='update_date desc';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>$page,
		));
	}
}