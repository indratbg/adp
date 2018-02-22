<?php

class Rptunrealizedgainloss extends ARptForm
{
	
	public $bgn_date;
	public $end_date;
	public $avail_flg='N';
	public $branch_cd;
	public $client_cd;
	public $dummy_date;
	public $rem_cd;
	public $stk_cd;
	public $branch_option;
	public $client_option;
	public $rem_option;
	public $stk_option;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('bgn_date,end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('stk_option,rem_option,branch_option,client_option,stk_cd,avail_flg,rem_cd,branch_cd,client_cd','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			
			
		);
	}
		

	public function executeRpt($bgn_client, $end_client,$bgn_stk, $end_stk,$bgn_branch,$end_branch,$bgn_rem, $end_rem)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL   SPR_UNREALIZED_GAIN_LOSS(to_date(:dt_beg_dt,'YYYY-MM-DD'),
													    TO_DATE(:dt_end_dt,'YYYY-MM-DD'),
													    :s_bgn_client,
													    :s_end_client,
													    :s_bgn_stk,
													    :s_end_stk,
													    :s_bgn_branch,
													    :s_end_branch,
													    :s_bgn_rem,
													    :s_end_rem,
													    :as_limit,
													    :P_USER_ID,
													    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
													    :P_RANDOM_VALUE,
													    :P_ERROR_CD,
													    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":dt_beg_dt",$this->bgn_date,PDO::PARAM_STR);
			$command->bindValue(":dt_end_dt",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":s_bgn_client",$bgn_client,PDO::PARAM_STR);
			$command->bindValue(":s_end_client",$end_client,PDO::PARAM_STR);
			$command->bindValue(":s_bgn_stk",$bgn_stk,PDO::PARAM_STR);
			$command->bindValue(":s_end_stk",$end_stk,PDO::PARAM_STR);
			$command->bindValue(":s_bgn_branch",$bgn_branch,PDO::PARAM_STR);
			$command->bindValue(":s_end_branch",$end_branch,PDO::PARAM_STR);
			$command->bindValue(":s_bgn_rem",$bgn_rem,PDO::PARAM_STR);
			$command->bindValue(":s_end_rem",$end_rem,PDO::PARAM_STR);
			$command->bindValue(":as_limit",$this->avail_flg,PDO::PARAM_STR);
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
