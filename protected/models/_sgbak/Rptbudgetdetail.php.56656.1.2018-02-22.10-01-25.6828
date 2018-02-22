<?php

class Rptbudgetdetail extends ARptForm
{
	public $p_report_date;
	public $p_type;
	public $p_branch;
	public $p_clt_type;
	public $opt_branch;
	public $opt_clt;
	public $dummy_date;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('p_report_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('p_type,p_branch,opt_branch,p_clt_type,opt_clt','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
		'p_report_date'=>'Date',
		);
	}
		

	public function executeRpt($p_report_date)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		
		try{
			$query  = "CALL    SPR_BUDGET_DETAIL(TO_DATE(:P_REPORT_DATE,'YYYY-MM-DD'),
												:P_ARAP_TYPE,
												:P_BRANCH,
												:P_CLIENT_TYPE,
											    :P_USER_ID,
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";
					
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_REPORT_DATE",$this->p_report_date,PDO::PARAM_STR);
			$command->bindValue(":P_ARAP_TYPE",$this->p_type,PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH",$this->p_branch,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE",$this->p_clt_type,PDO::PARAM_STR);
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
