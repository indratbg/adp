<?php

class Rptreconcileporto extends ARptForm
{
	public $report_date;
	public $option;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('report_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('report_date','safe')
		);
	}
	
	public function attributeLabels()
	{
		
	}
		

	public function executeRpt($report_date,$option)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		// var_dump($report_date);var_dump($option);die();
		try{
			$query  = "CALL    SPR_RECONCILE_PORTO_KSEI( TO_DATE(:P_REPORT_DATE,'YYYY-MM-DD'),
												:P_OPTION,
											    :P_USER_ID ,
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";
					
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_REPORT_DATE",$report_date,PDO::PARAM_STR);
			$command->bindValue(":P_OPTION",$option,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,100);

			$command->execute();
			$transaction->commit();
			
			
		}catch(Exception $ex){
			
			if($this->vo_errcd == -999){
				$this->vo_errmsg = $ex->getMessage();
		    }
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}
	
	public function executeRpt_2($report_date,$option)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		// var_dump($report_date);var_dump($option);die();
		try{
			$query  = "CALL    SPR_RECONCILE_PORTO_SYSTEM( TO_DATE(:P_REPORT_DATE,'YYYY-MM-DD'),
												:P_OPTION,
											    :P_USER_ID ,
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";
					
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_REPORT_DATE",$report_date,PDO::PARAM_STR);
			$command->bindValue(":P_OPTION",$option,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,100);

			$command->execute();
			$transaction->commit();
			
			
		}catch(Exception $ex){
			
			if($this->vo_errcd == -999){
				$this->vo_errmsg = $ex->getMessage();
		    }
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}
	

}
