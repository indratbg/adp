<?php

/**
 * This is the model class for table "T_MANY_HEADER".
 *
 * The followings are the available columns in table 'T_MANY_HEADER':
 * @property string $update_date
 * @property string $menu_name
 * @property integer $update_seq
 * @property string $status
 * @property string $user_id
 * @property string $ip_address
 * @property string $approved_status
 * @property string $approved_user_id
 * @property string $approved_date
 * @property string $approved_ip_address
 * @property string $reject_reason
 * @property string $cancel_reason
 */
class Vinboxprocessgljournal extends AActiveRecord
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $update_date_date;
	public $update_date_month;
	public $update_date_year;

	public $approved_date_date;
	public $approved_date_month;
	public $approved_date_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $approved_user_id;
	public $approved_ip_address;
	public $error_code = -999;
	public $error_msg  = '';
	
	/*
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	*/
	
	public function primaryKey()
	{
		return 'update_seq';
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    

	public function tableName()
	{
		return 'T_MANY_HEADER';
	}

	public function rules()
	{
		return array(
		
			array('update_date, approved_date', 'application.components.validator.ADatePickerSwitcherValidator'),
			array('update_seq', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('update_date, menu_name, update_seq', 'required','on'=>'insert,update,reject'),
			array('reject_reason','required','on'=>'reject, rejectchecked'),
			array('cancel_reason','required','on'=>'cancel'),
			
			array('update_seq', 'numerical', 'integerOnly'=>true),
			array('menu_name', 'length', 'max'=>50),
			array('user_id, approved_user_id', 'length', 'max'=>10),
			array('approved_status', 'length', 'max'=>1),
			array('ip_address, approved_ip_address', 'length', 'max'=>15),
			array('reject_reason, cancel_reason', 'length', 'max'=>200),
			array('approved_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('status, update_date, menu_name, update_seq, user_id, ip_address, approved_status, approved_user_id, approved_date, approved_ip_address, reject_reason, cancel_reason,update_date_date,update_date_month,update_date_year,approved_date_date,approved_date_month,approved_date_year', 'safe', 'on'=>'search'),
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
			'update_date' => 'Update Date',
			'menu_name' => 'Menu Name',
			'update_seq' => 'Update Seq',
			'user_id' => 'Request By',
			'ip_address' => 'Ip Address',
			'approved_status' => 'Approved Status',
			'approved_user_id' => 'Approved By',
			'approved_date' => 'Approved Date',
			'approved_ip_address' => 'Approved Ip Address',
			'reject_reason' => 'Reject Reason',
			'cancel_reason' => 'Cancel Reason',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->update_date_date))
			$criteria->addCondition("TO_CHAR(t.update_date,'DD') LIKE '%".$this->update_date_date."%'");
		if(!empty($this->update_date_month))
			$criteria->addCondition("TO_CHAR(t.update_date,'MM') LIKE '%".$this->update_date_month."%'");
		if(!empty($this->update_date_year))
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		
			//$criteria->compare('menu_name',$this->menu_name,true);
			$criteria->addCondition("t.menu_name IN (".implode(',',$this->menu_name).")");
		$criteria->compare('update_seq',$this->update_seq);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('approved_status',$this->approved_status,true);
		$criteria->compare('approved_user_id',$this->approved_user_id,true);
		$criteria->compare('status',$this->status,true);

		if(!empty($this->approved_date_date))
			$criteria->addCondition("TO_CHAR(t.approved_date,'DD') LIKE '%".$this->approved_date_date."%'");
		if(!empty($this->approved_date_month))
			$criteria->addCondition("TO_CHAR(t.approved_date,'MM') LIKE '%".$this->approved_date_month."%'");
		if(!empty($this->approved_date_year))
			$criteria->addCondition("TO_CHAR(t.approved_date,'YYYY') LIKE '%".$this->approved_date_year."%'");		$criteria->compare('approved_ip_address',$this->approved_ip_address,true);
		$criteria->compare('reject_reason',$this->reject_reason,true);
		$criteria->compare('cancel_reason',$this->cancel_reason,true);

		$sort = new CSort;
		$sort->defaultOrder='approved_date desc, update_date desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}

	private function logRecord()
	{
		$ip = Yii::app()->request->userHostAddress;
		if($ip=="::1")
			$ip = '127.0.0.1';
		
		$this->approved_ip_address = $ip;
		$this->approved_user_id    = Yii::app()->user->id;
	}
	
	

}