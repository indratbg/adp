<?php

class Rptprofitlossrecap extends ARptForm
{

	public $month;
	public $year;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			//array('from_date,to_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('month,year','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'month'=>'For the month of ',
			'year'=>'Year '
			
		);
	}
		

	public function executeRpt($bgn_date, $end_date)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_PROFIT_LOSS_RECAP( TO_DATE(:P_BGN_DATE,'YYYY-MM-DD'),
											    TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
											    :P_USER_ID,
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE",$bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$end_date,PDO::PARAM_STR);
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
