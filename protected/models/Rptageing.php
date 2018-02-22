<?php

class Rptageing extends ARptForm
{
	
	public $to_date;
	public $client_cd;
	public $branch_cd;
	public $dummy_date;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('to_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('client_cd,branch_cd','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			
			
		);
	}
		

	public function executeRpt($client_cd, $branch_cd)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_AGEING (
						TO_DATE(:vp_due_dt,'YYYY-MM-DD'),      
						:vp_client_cd,	
						:vp_branch_code,	
						:vp_userid,		
						TO_DATE(:vp_generatedate,'YYYY-MM-DD HH24:MI:SS'),
						:vo_random_value,
						:vo_errcd,		
						:vo_errmsg)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":vp_due_dt",$this->to_date,PDO::PARAM_STR);
			$command->bindValue(":vp_client_cd",$client_cd,PDO::PARAM_STR);
			$command->bindValue(":vp_branch_code",$branch_cd,PDO::PARAM_STR);
			
			$command->bindValue(":vp_userid",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":vp_generatedate",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":vo_random_value",$this->vo_random_value,PDO::PARAM_INT,10);
			
			$command->bindParam(":vo_errcd",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":vo_errmsg",$this->vo_errmsg,PDO::PARAM_STR,100);

			$command->execute();
			$transaction->commit();
			
			
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->vo_errcd == -999){
				$this->vo_errmsg = $ex->getMessage();
		    }
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}
	

}
