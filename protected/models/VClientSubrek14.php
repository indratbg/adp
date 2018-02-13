<?php

/**
 * This is the model class for table "V_CLIENT_SUBREK14".
 *
 * The followings are the available columns in table 'V_CLIENT_SUBREK14':
 * @property string $client_cd
 * @property string $subrek001
 * @property string $subrek004
 * @property string $subrek14
 */
class VClientSubrek14 extends AActiveRecord
{
	//AH: #BEGIN search (datetime || date) additional comparison	//AH: #END search (datetime || date)  additional comparison
	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function primaryKey()
	{
		return 'client_cd';
	}

	public function tableName()
	{
		return 'V_CLIENT_SUBREK14';
	}

	public function rules()
	{
		return array(
			
			array('client_cd, subrek001', 'required'),
			array('client_cd', 'length', 'max'=>12),
			array('subrek001, subrek004', 'length', 'max'=>14),
			array('subrek14', 'length', 'max'=>31),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, subrek001, subrek004, subrek14', 'safe', 'on'=>'search'),
		);
	}
	
	/*
	 *  AH: this function is for executing procedure
	 *  exec_status  : I/U/C
	 */
	public function executeSp($exec_status)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_GANTI_COY(
						GANTI NIH !!
			
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,:P_IC_TYPE,:P_EMAIL,:P_BRANCH_CD,
						:P_UPD_BY,TO_DATE(:P_APPROVED_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_APPROVED_BY,:P_APPROVED_STS,
						:P_DEF_ADDR,:P_UPD_STATUS,:P_IP_ADDRESS,
						:P_CANCEL_REASON,:P_ERROR_CODE,:P_ERROR_MSG)";
						
			$command = $connection->createCommand($query);
			
					$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SUBREK001",$this->subrek001,PDO::PARAM_STR);
			$command->bindValue(":P_SUBREK004",$this->subrek004,PDO::PARAM_STR);
			$command->bindValue(":P_SUBREK14",$this->subrek14,PDO::PARAM_STR);
			
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_APPROVED_DT",$this->approved_dt,PDO::PARAM_STR);
			$command->bindValue(":P_APPROVED_BY",$this->approved_by,PDO::PARAM_STR);
			$command->bindValue(":P_APPROVED_STS",$this->approved_stat,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,100);

			$command->execute();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->error_code == -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'client_cd' => 'Client Code',
			'subrek001' => 'Subrek001',
			'subrek004' => 'Subrek004',
			'subrek14' => 'Subrek14',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('subrek001',$this->subrek001,true);
		$criteria->compare('subrek004',$this->subrek004,true);
		$criteria->compare('subrek14',$this->subrek14,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}