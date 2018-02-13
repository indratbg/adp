<?php

class Postingmonthlydepr extends CFormModel
{
	public $doc_date;
	public $user_id;
	public $error_code=-999;
	public $error_msg='Initial value';
	public $ip_address;
	public $folder_cd;
	public $mmyy;
	public function rules()
	{
		return array(
			//array('due_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			//array('doc_date','required'),
			array('folder_cd,doc_date','safe')
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'doc_date'=>'Date',
			
		);
	}

	
public function executeSp()
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		try{
			$query  = "CALL   SP_Posting_Depr_ng (to_date(:p_date,'yyyy-mm-dd'),
		   	  		  						  :p_mmyy,
											  :p_folder,
		   	  		  						  :p_user_id,
											  :p_ip_address,
											  :p_error_code,
											  :p_error_msg)";
		
			$command = $connection->createCommand($query);
			$command->bindValue(":p_date",$this->doc_date,PDO::PARAM_STR);
			$command->bindValue(":p_mmyy",$this->mmyy,PDO::PARAM_STR);
			$command->bindValue(":p_folder",$this->folder_cd,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":p_ip_address",$this->ip_address,PDO::PARAM_STR);
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
