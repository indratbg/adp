<?php

class Monthendstock extends CFormModel
{
	public $bal_date;
	public $end_date;
	public $start_date;
	public $user_id;
	public $error_code=-999;
	public $error_msg='Initial value';
	public $ip_address;
	public function rules()
	{
		return array(
			//array('due_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('bal_date','required'),
			array('bal_date','safe')
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'bal_date'=>'First Date of the Month',
			
		);
	}

	
public function executeSp()
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		try{
			$query  = "CALL   SP_BEGIN_BAL_STK(TO_DATE(:P_BAL_DATE,'YYYY-MM-DD'),
												   TO_DATE(:P_START_DATE,'YYYY-MM-DD'),
												   TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
												   :P_USER_ID,
												   :P_IP_ADDRESS,
												   :P_ERROR_CODE,
												   :P_ERROR_MSG)";
		
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BAL_DATE",$this->bal_date,PDO::PARAM_STR);
			$command->bindValue(":P_START_DATE",$this->start_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
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
	
	
}
