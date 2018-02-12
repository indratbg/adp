<?php

/**
 * This is the model class for table "T_SUBREK_KSEI".
 *
 * The followings are the available columns in table 'T_SUBREK_KSEI':
 * @property string $status_dt
 * @property string $client_name
 * @property string $subrek
 * @property string $id_num
 * @property string $sid
 */
class Tsubrekksei extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $status_dt_date;
	public $status_dt_month;
	public $status_dt_year;
	public $status_dt_char;
	public $user_id;
	public $ip_address;
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
		return 'T_SUBREK_KSEI';
	}

	public function rules()
	{
		return array(
		
			array('status_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('client_name', 'length', 'max'=>80),
			array('subrek', 'length', 'max'=>14),
			array('id_num', 'length', 'max'=>50),
			array('sid', 'length', 'max'=>15),
			array('status_dt_char,status_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('status_dt, client_name, subrek, id_num, sid,status_dt_date,status_dt_month,status_dt_year', 'safe', 'on'=>'search'),
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
			'status_dt' => 'Status Date',
			'client_name' => 'Client Name',
			'subrek' => 'Subrek',
			'id_num' => 'Id Num',
			'sid' => 'Sid',
		);
	}

public function executeSpLogUpd($status_dt)
	{
	 
		$this->user_id=Yii::app()->user->id;
		$ip = Yii::app()->request->userHostAddress;
		if($ip=="::1")
				$ip = '127.0.0.1';
			$this->ip_address = $ip;	 
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SP_UPLOAD_T_SUBREK_KSEI_LOG(TO_DATE(:P_STATUS_DT,'YYYY-MM-DD'),
															:p_record_seq,
															:P_USER_ID,
															:p_upd_status,
															:P_IP_ADDRESS,
															:p_error_code,
															:p_error_msg)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_STATUS_DT",$status_dt,PDO::PARAM_STR);
			$command->bindValue(":p_record_seq",1,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":p_upd_status",'X',PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindParam(":p_error_code",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":p_error_msg",$this->error_msg,PDO::PARAM_STR,100);

			$command->execute();
			$transaction->commit();
			
			
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->error_code == -999){
				$this->error_msg = $ex->getMessage();
		    }
		}
		
		if($this->error_code < 0)
			$this->addError('vo_errmsg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}
	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->status_dt_date))
			$criteria->addCondition("TO_CHAR(t.status_dt,'DD') LIKE '%".$this->status_dt_date."%'");
		if(!empty($this->status_dt_month))
			$criteria->addCondition("TO_CHAR(t.status_dt,'MM') LIKE '%".$this->status_dt_month."%'");
		if(!empty($this->status_dt_year))
			$criteria->addCondition("TO_CHAR(t.status_dt,'YYYY') LIKE '%".$this->status_dt_year."%'");		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('subrek',$this->subrek,true);
		$criteria->compare('id_num',$this->id_num,true);
		$criteria->compare('sid',$this->sid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}