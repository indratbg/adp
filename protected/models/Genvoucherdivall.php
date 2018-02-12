<?php

class Genvoucherdivall extends CFormModel
{
	
	public $branch_cd;
	public $folder_cd;
	public $distrib_dt;
	public $user_id;
	public $ip_address;
	public $error_code=-999;
	public $error_msg='';
	public $tempDateCol   = array();  
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function rules()
	{	
	 return 
	 array(
	 	array('distrib_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
	 	array('branch_cd,folder_cd','safe') 
	);	
	}

	
	public function attributeLabels()
	{
		return array(
			'distrib_dt'=>'Payment Date',
			'folder_cd'=>'Start File no.'
			
		);
	}

	public static function getFolderPrefix()
	{
		$sql="SELECT A.GL_ACCT_CD,
			  A.SL_ACCT_CD,
			  A.FOLDER_PREFIX
			FROM MST_BANK_ACCT A,
			  (SELECT DSTR1 GL_ACCT_CD,
			    DSTR2 SL_ACCT_CD
			  FROM MST_SYS_PARAM
			  WHERE PARAM_ID='VOUCHER_DIVIDEN'
			  AND PARAM_CD1 ='GL_ACCT'
			  AND PARAM_CD2 ='BANK'
			  ) B
			WHERE TRIM(A.GL_ACCT_CD) = B.GL_ACCT_CD
			AND A.SL_ACCT_CD         =B.SL_ACCT_CD";
		$exec = DAO::queryRowSql($sql);
		$folder_prefix = $exec['folder_prefix'].'R';
		return $folder_prefix;
	}
public function executeSp()
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		try{
			$query  = "CALL  SP_GEN_VOUCHER_DIV(TO_DATE(:P_DISTRIB_DT,'YYYY-MM-DD'),
											    :P_BRANCH_CD,
											    :P_FOLDER_CD,
											    :P_USER_ID,
											    :P_IP_ADDRESS,
											    :P_ERROR_CODE,
											    :P_ERROR_MSG)";
		
			$command = $connection->createCommand($query);
			$command->bindValue(":P_DISTRIB_DT",$this->distrib_dt,PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH_CD",$this->branch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_FOLDER_CD",$this->folder_cd,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,200);

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
