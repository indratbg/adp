<?php

class Rptprofitlosscompany extends ARptForm
{
	public $month;
	public $year;	
	public $bgn_date;
	public $end_date;
	public $bgn_branch;
	public $end_branch;
	public $dummy_date;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('bgn_date, end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('month,year,dummy_date, bgn_branch, end_branch','safe')
		);
	}

	public function attributeLabels()
	{
		return array(
			
			
		);
	}
		

	public function executeRpt($bgn_branch, $end_branch)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_PROFIT_LOSS_COMPANY(TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
														:P_BGN_BRANCH,
														:P_END_BRANCH,
														:P_USER_ID,
														:P_GENERATE_DATE,
														:P_RANDOM_VALUE,
														:P_ERROR_CD,
														:P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_END_DATE",$this->bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_BRANCH",$bgn_branch,PDO::PARAM_STR);
			$command->bindValue(":P_END_BRANCH",$end_branch,PDO::PARAM_STR);
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
