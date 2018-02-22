<?php

/**
 * This is the model class for table "V_GL_JOURNAL_INBOX".
 *
 * The followings are the available columns in table 'V_GL_JOURNAL_INBOX':
 * @property string $user_id
 * @property string $update_date
 * @property string $status
 * @property string $ip_address
 * @property string $jvch_date
 * @property string $folder_cd
 * @property string $jvch_num
 * @property string $curr_amt
 * @property integer $update_seq
 * @property string $approved_status
 * @property string $menu_name
 * @property string $approved_date
 */
class Vgljournalinbox extends AActiveRecordSP
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
		return 'V_GL_JOURNAL_INBOX';
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
			array('jvch_date, folder_cd, jvch_num, curr_amt', 'length', 'max'=>200),
			array('menu_name', 'length', 'max'=>50),
			array('approved_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('user_id, update_date, status, ip_address, jvch_date, folder_cd, jvch_num, curr_amt, update_seq, approved_status, menu_name, approved_date,update_date_date,update_date_month,update_date_year,approved_date_date,approved_date_month,approved_date_year', 'safe', 'on'=>'search'),
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
			'jvch_date' => 'Date',
			'folder_cd' => 'File No.',
			'jvch_num' => 'Journal Number',
			'curr_amt' => 'Amount',
			'update_seq' => 'Update Seq',
			'approved_status' => 'Approved Status',
			'menu_name' => 'Menu Name',
			'approved_date' => 'Approved Date',
		);
	}

	public static function checkButtonVisible($update_seq)
	{
		$cek = Tmanyheader::model()->find("update_seq='$update_seq' and status='I'");
		
		if($cek)
		{
			$cek2 = Tmanyheader::model()->find("update_seq='$update_seq' and status='I'")->menu_name;
		
		if($cek2 != 'GENERATE MARKET INFO FEE JOURNAL' && $cek2 != 'GENERATE REPO INTEREST JOURNAL')
		{
			return true;
		}
		}
		return FALSE;
	}
	
	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('lower(user_id)',strtolower($this->user_id),true);

		if(!empty($this->update_date_date))
			$criteria->addCondition("TO_CHAR(t.update_date,'DD') LIKE '%".$this->update_date_date."%'");
		if(!empty($this->update_date_month))
			$criteria->addCondition("TO_CHAR(t.update_date,'MM') LIKE '%".$this->update_date_month."%'");
		if(!empty($this->update_date_year))
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		
			$criteria->compare('status',$this->status,true);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('jvch_date',$this->jvch_date,true);
		$criteria->compare('lower(folder_cd)',strtolower($this->folder_cd),true);
		$criteria->compare('jvch_num',$this->jvch_num,true);
		$criteria->compare('curr_amt',$this->curr_amt,true);
		$criteria->compare('update_seq',$this->update_seq);
		$criteria->compare('approved_status',$this->approved_status,true);
		//$criteria->compare('menu_name',$this->menu_name,true);
		$criteria->addCondition("menu_name IN (".implode(',',$this->menu_name).")");
		if(!empty($this->approved_date_date))
			$criteria->addCondition("TO_CHAR(t.approved_date,'DD') LIKE '%".$this->approved_date_date."%'");
		if(!empty($this->approved_date_month))
			$criteria->addCondition("TO_CHAR(t.approved_date,'MM') LIKE '%".$this->approved_date_month."%'");
		if(!empty($this->approved_date_year))
			$criteria->addCondition("TO_CHAR(t.approved_date,'YYYY') LIKE '%".$this->approved_date_year."%'");
			$sort=new CSort();
		$sort->defaultOrder='jvch_date';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}