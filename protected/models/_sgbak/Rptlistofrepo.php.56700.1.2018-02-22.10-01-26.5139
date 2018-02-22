<?php

class Rptlistofrepo extends ARptForm
{
	public $bgn_date;
	public $end_date;
	public $stk_option;
	public $stk_cd_from;
	public $stk_cd_to;
	public $dummy_date;
	public $broker_option;
	public $broker_cd;
	public $client_option;
	public $bgn_client;
	public $end_client;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('bgn_date, end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('bgn_dt','check_date','on'=>'print'),
			array('client_option,bgn_client, end_client,broker_cd,broker_option,stk_option,stk_cd_from, stk_cd_to','safe')
		);
	}
	public function check_date()
	{
		$cek_date = Sysparam::model()->find(" param_id= 'LIST_OF_REPO' and param_cd1='DATE' ")->ddate1;
		if($this->bgn_date <= $cek_date || $this->end_date <= $cek_date)
		{
			if(DateTime::createFromFormat('Y-m-d H:i:s',$cek_date)) $cek_date = DateTime::createFromFormat('Y-m-d H:i:s',$cek_date)->format('d-M-Y'); 
			$this->addError('bgn_date', 'Date must be greater than '.$cek_date);
		}
	}
	public function attributeLabels()
	{
		return array(
			
			
		);
	}
		

	public function executeRpt($bgn_stk, $end_stk, $bgn_client, $end_client, $bgn_broker, $end_broker)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL   SPR_LIST_OF_REPO( TO_DATE(:P_BGN_DATE,'YYYY-MM-DD'),
												TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
												:P_BGN_STOCK,
												:P_END_STOCK,
												:P_BGN_CLIENT,
												:P_END_CLIENT,
												:P_BGN_BROKER,
												:P_END_BROKER,
												:P_USER_ID,
												TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
												:P_RANDOM_VALUE,
												:P_ERROR_CD,
												:P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE",$this->bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_STOCK",$bgn_stk,PDO::PARAM_STR);
			$command->bindValue(":P_END_STOCK",$end_stk,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$bgn_client,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$end_client,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_BROKER",$bgn_broker,PDO::PARAM_STR);
			$command->bindValue(":P_END_BROKER",$end_broker,PDO::PARAM_STR);
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
