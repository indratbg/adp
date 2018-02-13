<?php

class Rptsecugeneralledger extends ARptForm
{
	public $end_date;
	public $month;
	public $year;
	public $gl_option;
	public $gl_acct;
	public $client_option;
	public $client_cd;
	public $stk_option;
	public $stk_cd;
	public $reversal_jur;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('reversal_jur,sort_by,stk_option,stk_cd,client_cd,client_option,gl_option,gl_acct,year,month','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'end_date'=>'Periode'		
		);
	}
		

	public function executeRpt($bgn_acct,$end_acct,$bgn_client,$end_client,$bgn_stk,$end_stk,$reversal_jur)
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		
		try{
			$query  = "CALL SPR_SECU_GENERAL_LEDGER(TO_DATE( :P_END_DATE,'YYYY-MM-DD'),
														    :P_BGN_ACCT,
														    :P_END_ACCT,
														    :P_BGN_CLIENT,
														    :P_END_CLIENT,
														    :P_BGN_STK,
														    :P_END_STK,
														    :P_REVERSAL_JUR,
														    :P_USER_ID,
														    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
														    :P_RANDOM_VALUE,
														    :P_ERROR_CD,
														    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_ACCT",$bgn_acct,PDO::PARAM_STR);
			$command->bindValue(":P_END_ACCT",$end_acct,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$bgn_client,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$end_client,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_STK",$bgn_stk,PDO::PARAM_STR);
			$command->bindValue(":P_END_STK",$end_stk,PDO::PARAM_STR);
			$command->bindValue(":P_REVERSAL_JUR",$reversal_jur,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,200);

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

