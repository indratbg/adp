<?php

class Rptportorealizedgainloss extends ARptForm
{
	public $month;
	public $year;
	public $bgn_date;	
	public $end_date;
	public $branch_option;
	public $branch_cd;
	public $rem_option;
	public $rem_cd;
	public $dummy_date;
	public $limit_flg;
	public $client_option;
	public $client_cd;
	public $stk_cd;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('bgn_date,end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('stk_cd,client_option,client_cd,limit_flg,month,year,branch_option,branch_cd,rem_option,rem_cd','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'end_date'=>'To'		
		);
	}
		

	public function executeRpt($bgn_client, $end_client, $bgn_stk,$end_stk,$bgn_rem_cd, $end_rem_cd, $bgn_branch, $end_branch)
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		
		try{
			$query  = "CALL  SPR_PORTO_REALIZED_GAIN_LOSS(  TO_DATE(:P_BGN_DATE,'YYYY-MM-DD'),
														    TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
														    :P_BGN_CLIENT,
														    :P_END_CLIENT,
														    :P_BGN_STK,
														    :P_END_STK,
														    :P_BGN_REM,
														    :P_END_REM,
														    :P_BGN_BRANCH,
														    :P_END_BRANCH,
														    :P_USER_ID,
														    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
														    :P_RANDOM_VALUE,
														    :P_ERROR_CD,
														    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE",$this->bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$bgn_client,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$end_client,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_STK",$bgn_stk,PDO::PARAM_STR);
			$command->bindValue(":P_END_STK",$end_stk,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_REM",$bgn_rem_cd,PDO::PARAM_STR);
			$command->bindValue(":P_END_REM",$end_rem_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_BRANCH",$bgn_branch,PDO::PARAM_STR);
			$command->bindValue(":P_END_BRANCH",$end_branch,PDO::PARAM_STR);
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
