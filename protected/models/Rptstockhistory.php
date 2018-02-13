<?php

class Rptstockhistory extends ARptForm
{
	public $bgn_date;
	public $end_date;
	public $dummy_date;
	public $stk_option;
	public $stk_cd;
	public $client_option;
	public $client_cd;
	public $rem_option;
	public $rem_cd;
	public $qty_option;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('bgn_date, end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('qty_option,stk_option,stk_cd,client_option,client_cd,rem_option,rem_cd','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			
			
		);
	}
		

	public function executeRpt($on_hand,$bgn_stk, $end_stk, $bgn_client, $end_client, $bgn_rem, $end_rem)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_STOCK_HISTORY(to_date(:P_BGN_DATE,'yyyy-mm-dd'),
												to_date(:P_END_DATE,'yyyy-mm-dd'),
												:P_ON_HAND,
												:P_BGN_CLIENT,
												:P_END_CLIENT,
												:P_BGN_STOCK,
												:P_END_STOCK,
												:P_BGN_REM,
												:P_END_REM,
												:P_USER_ID ,
												to_date(:P_GENERATE_DATE,'yyyy-mm-dd hh24:mi:ss'),
												:P_RANDOM_VALUE,
												:P_ERROR_CD,
												:P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE",$this->bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_ON_HAND",$on_hand,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$bgn_client,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$end_client,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_STOCK",$bgn_stk,PDO::PARAM_STR);
			$command->bindValue(":P_END_STOCK",$end_stk,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_REM",$bgn_rem,PDO::PARAM_STR);
			$command->bindValue(":P_END_REM",$end_rem,PDO::PARAM_STR);
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
