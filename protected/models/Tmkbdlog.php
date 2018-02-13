<?php

/**
 * This is the model class for table "T_MKBD_LOG".
 *
 * The followings are the available columns in table 'T_MKBD_LOG':
 * @property string $update_date
 * @property integer $update_seq
 * @property integer $seq_no
 * @property string $error_msg
 * @property string $cre_dt
 * @property string $user_id
 */
class Tmkbdlog extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $update_date_date;
	public $update_date_month;
	public $update_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;
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
		return 'T_MKBD_LOG';
	}

	public function rules()
	{
		return array(
		
			array('update_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('update_seq, seq_no', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('update_date, update_seq, seq_no', 'required'),
			array('update_seq, seq_no', 'numerical', 'integerOnly'=>true),
			array('error_msg', 'length', 'max'=>180),
			array('user_id', 'length', 'max'=>10),
			array('cre_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('update_date, update_seq, seq_no, error_msg, cre_dt, user_id,update_date_date,update_date_month,update_date_year,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
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
			'update_seq' => 'Update Seq',
			'seq_no' => 'Seq No',
			'error_msg' => 'Error Msg',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
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
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		$criteria->compare('update_seq',$this->update_seq);
		$criteria->compare('seq_no',$this->seq_no);
		$criteria->compare('error_msg',$this->error_msg,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}