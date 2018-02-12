<?php

class Rptagingandsaldorekdana extends ARptForm
{
	
	public $end_date;
	public $arap_bal;
	public $saldo_rek;
	public $branch_cd;
	public $client_cd;
	public $dummy_date;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('branch_cd,saldo_rek,arap_bal,client_cd','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			
			
		);
	}
		

	public function executeRpt($bgn_branch, $end_branch, $bgn_client, $end_client, $fund_bal, $arap)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_AGING_AND_SALDO_REK(   TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
													    :P_BGN_BRANCH,
													    :P_END_BRANCH,
													    :P_BGN_CLIENT,
													    :P_END_CLIENT,
													    :P_FUND_BAL,
													    :P_ARAP,
													    :P_USER_ID,
													    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
													    :P_RANDOM_VALUE,
													    :P_ERROR_CD,
													    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_BRANCH",$bgn_branch,PDO::PARAM_STR);
			$command->bindValue(":P_END_BRANCH",$end_branch,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$bgn_client,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$end_client,PDO::PARAM_STR);
			$command->bindValue(":P_FUND_BAL",$fund_bal,PDO::PARAM_STR);
			$command->bindValue(":P_ARAP",$arap,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,100);

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
