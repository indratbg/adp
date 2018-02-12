<?php

class Rptoutsarapclient extends ARptForm
{
	public $as_at_date;
	public $from_date;
	public $to_date;
	public $bgn_client;
	public $end_client;
	public $client_option;
	public $sort_by;
	public $branch_cd;
	public $option;
	public $dummy_date;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('from_date,to_date,as_at_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('bgn_client, end_client,client_cd,client_option,sort_by,branch_cd,option','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			
			
		);
	}
		

	public function executeRpt($from_date, $to_date,$bgn_client, $end_client,$branch_cd, $sort_by,$option)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		$sp_name = $option=='0'?'SPR_OUTS_ARAP_CLIENT':'SPR_OUTS_ARAP_SETTLEMENT';
		
		try{
			$query  = "CALL   $sp_name (TO_DATE( :P_AS_AT,'YYYY-MM-DD'),
										TO_DATE( :P_FROM_DATE,'YYYY-MM-DD'),
									    TO_DATE(:P_TO_DATE,'YYYY-MM-DD'),
									    :P_BGN_CLIENT,
									    :P_END_CLIENT,
									    :P_BRANCH_CD,
									    :P_SORT_BY,
									    :P_USER_ID,
									    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
									    :P_RANDOM_VALUE,
									    :P_ERROR_CD,
									    :P_ERROR_MSG)";
					
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_AS_AT",$this->as_at_date,PDO::PARAM_STR);
			$command->bindValue(":P_FROM_DATE",$from_date,PDO::PARAM_STR);
			$command->bindValue(":P_TO_DATE",$to_date,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$bgn_client,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$end_client,PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH_CD",$branch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SORT_BY",$sort_by,PDO::PARAM_STR);
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
