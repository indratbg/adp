<?php

class Rptlistofbondtrx extends ARptForm
{
	public $bgn_date;
	public $end_date;
	public $dummy_date;
	public $option_date;
	public $ticket_no_from;
	public $ticket_no_to;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('bgn_date, end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('option_date,ticket_no_from,ticket_no_to','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			
			
		);
	}
		

	public function executeRpt($option_date)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_LIST_OF_BOND_TRX(to_date(:P_BGN_DATE,'yyyy-mm-dd'),
												to_date(:P_END_DATE,'yyyy-mm-dd'),
												:P_OPTION_DATE,
												:P_USER_ID ,
												to_date(:P_GENERATE_DATE,'yyyy-mm-dd hh24:mi:ss'),
												:P_RANDOM_VALUE,
												:P_ERROR_CD,
												:P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE",$this->bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_OPTION_DATE",$option_date,PDO::PARAM_STR);
			//$command->bindValue(":P_TICKET_NO_FROM",$ticket_from,PDO::PARAM_STR);
			//$command->bindValue(":P_TICKET_NO_TO",$ticket_to,PDO::PARAM_STR);
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
