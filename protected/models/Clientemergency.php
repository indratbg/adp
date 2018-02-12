<?php

/**
 * This is the model class for table "MST_CLIENT_EMERGENCY".
 *
 * The followings are the available columns in table 'MST_CLIENT_EMERGENCY':
 * @property string $cifs
 * @property string $emergency_name
 * @property string $emergency_addr1
 * @property string $emergency_addr2
 * @property string $emergency_addr3
 * @property string $emergency_postcd
 * @property string $emergency_phone
 * @property string $emergency_hp
 * @property string $cre_dt
 * @property string $cre_user_id
 * @property string $upd_dt
 * @property string $upd_user_id
 */
class Clientemergency extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
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
		return 'MST_CLIENT_EMERGENCY';
	}
	
	public function executeSp($exec_status,$old_cif,$update_date,$update_seq,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_MST_CLIENT_EMERGENCY_UPD(
						:P_SEARCH_CIFS,
						:P_CIFS,
						:P_EMERGENCY_NAME,
						:P_EMERGENCY_ADDR1,
						:P_EMERGENCY_ADDR2,
						:P_EMERGENCY_ADDR3,
						:P_EMERGENCY_POSTCD,
						:P_EMERGENCY_PHONE,
						:P_EMERGENCY_HP,
						:P_CRE_DT,
						:P_CRE_USER_ID,
						:P_UPD_DT,
						:P_UPD_USER_ID,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPDATE_SEQ,
						:P_RECORD_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_CIFS",$old_cif,PDO::PARAM_STR);
			$command->bindValue(":P_CIFS",$this->cifs,PDO::PARAM_STR);
			$command->bindValue(":P_EMERGENCY_NAME",$this->emergency_name,PDO::PARAM_STR);
			$command->bindValue(":P_EMERGENCY_ADDR1",$this->emergency_addr1,PDO::PARAM_STR);
			$command->bindValue(":P_EMERGENCY_ADDR2",$this->emergency_addr2,PDO::PARAM_STR);
			$command->bindValue(":P_EMERGENCY_ADDR3",$this->emergency_addr3,PDO::PARAM_STR);
			$command->bindValue(":P_EMERGENCY_POSTCD",$this->emergency_postcd,PDO::PARAM_STR);
			$command->bindValue(":P_EMERGENCY_PHONE",$this->emergency_phone,PDO::PARAM_STR);
			$command->bindValue(":P_EMERGENCY_HP",$this->emergency_hp,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_USER_ID",$this->cre_user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_USER_ID",$this->upd_user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_RECORD_SEQ",$record_seq,PDO::PARAM_STR);
						
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			
		}catch(Exception $ex){
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

	public function rules()
	{
		return array(
			
			array('cifs', 'length', 'max'=>8),
			array('emergency_name, emergency_addr1, emergency_addr2', 'length', 'max'=>50),
			array('emergency_addr3', 'length', 'max'=>30),
			array('emergency_postcd', 'length', 'max'=>6),
			array('emergency_phone, emergency_hp', 'length', 'max'=>15),
			array('cre_user_id, upd_user_id', 'length', 'max'=>10),
			array('cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('cifs, emergency_name, emergency_addr1, emergency_addr2, emergency_addr3, emergency_postcd, emergency_phone, emergency_hp, cre_dt, cre_user_id, upd_dt, upd_user_id,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'cifs' => 'Cifs',
			'emergency_name' => 'Name',
			'emergency_addr1' => 'Address',
			'emergency_addr2' => 'Emergency Addr2',
			'emergency_addr3' => 'Emergency Addr3',
			'emergency_postcd' => 'Post Code',
			'emergency_phone' => 'Phone Number',
			'emergency_hp' => 'Mobile Number',
			'cre_dt' => 'Cre Date',
			'cre_user_id' => 'Cre User',
			'upd_dt' => 'Upd Date',
			'upd_user_id' => 'Upd User',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('cifs',$this->cifs,true);
		$criteria->compare('emergency_name',$this->emergency_name,true);
		$criteria->compare('emergency_addr1',$this->emergency_addr1,true);
		$criteria->compare('emergency_addr2',$this->emergency_addr2,true);
		$criteria->compare('emergency_addr3',$this->emergency_addr3,true);
		$criteria->compare('emergency_postcd',$this->emergency_postcd,true);
		$criteria->compare('emergency_phone',$this->emergency_phone,true);
		$criteria->compare('emergency_hp',$this->emergency_hp,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('cre_user_id',$this->cre_user_id,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('upd_user_id',$this->upd_user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}