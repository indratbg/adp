<?php

class Rptclientactsummary extends ARptForm
{
	public $rpt_type;
	public $bgn_date;
	public $end_date;
	public $opt_clt;
	public $clt;
	public $opt_branch;
	public $branch;
	public $opt_rem;
	public $rem;
	public $opt_sts;
	public $dummy_date;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('bgn_date,end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('rpt_type,bgn_date,end_date,opt_clt,opt_sts,opt_branch,opt_rem,clt,branch,rem','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
		);
	}
		
	// public function executeRptSum($bgn_clt,$end_clt,$bgn_branch,$end_branch)
	public function executeRptSum($bgn_clt,$end_clt,$bgn_branch,$end_branch,$bgn_rem,$end_rem)
	{
	 	// var_dump($this->bgn_date);
		// die();
		
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_CLIENT_ACT_SUMMARY( 
											TO_DATE(:P_BGN_DATE,'YYYY-MM-DD'),      
											TO_DATE(:P_END_DATE,'YYYY-MM-DD'),     
											:P_BGN_CLIENT,    
											:P_END_CLIENT,   
											:P_BGN_REM,       
											:P_END_REM,       
											:P_BGN_BRANCH,    
											:P_END_BRANCH,    
											:P_STA,           
											:P_USER_ID,       
											TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'), 
											:P_RANDOM_VALUE,
											:P_ERROR_CD, 
											:P_ERROR_MSG
			)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE",$this->bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$bgn_clt,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$end_clt,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_REM",$bgn_rem,PDO::PARAM_STR);
			$command->bindValue(":P_END_REM",$end_rem,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_BRANCH",$bgn_branch,PDO::PARAM_STR);
			$command->bindValue(":P_END_BRANCH",$end_branch,PDO::PARAM_STR);
			$command->bindValue(":P_STA",$this->opt_sts,PDO::PARAM_STR);				
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

	public function executeRptRingkas()
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_CLIENT_ACT_RINGKAS( TO_DATE(:P_BGN_DATE,'YYYY-MM-DD HH24:MI:SS'),      
												TO_DATE(:P_END_DATE,'YYYY-MM-DD HH24:MI:SS'),     
												:P_USER_ID,         
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),   
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE",$this->bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
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
