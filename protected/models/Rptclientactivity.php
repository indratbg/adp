<?php

class Rptclientactivity extends ARptForm
{
	public $bgn_date;
	public $end_date;
	public $stk_option;
	public $stk_cd;
	public $dummy_date;
	public $client_option;
	public $bgn_client;
	public $end_client;
	public $report_type;
	public $sales_option;
	public $rem_cd;
	public $branch_option;
	public $branch_cd;
	public $position_option;
	public $group_option;
	public $group_by;
	public $type_client;
	public $beli_jual;
	public $kpei_due_dt_option;
	public $kpei_due_dt;
	public $market_type_option;
	public $market_type;
	public $price;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('bgn_date, end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('market_type,market_type_option,beli_jual,price,kpei_due_dt_option,kpei_due_dt,type_client,client_option,group_by,group_option,branch_cd,position_option,branch_option,rem_cd,sales_option,report_type,stk_option, stk_cd, dummy_date, bgn_client, end_client','safe')
		);
	}

	public function attributeLabels()
	{
		return array(
		
			
		);
	}
		

	public function executeRpt($bgn_branch, $end_branch, $bgn_stk_cd,$end_stk_cd, $bgn_client_cd, $end_client_cd, $bgn_rem_cd, $end_rem_cd, $custody, $sta, $sta_type, $mrkt_type, $bgn_days, $end_days,
	 $client_type3,$bgn_mrkt_type,$end_mrkt_type,$group_by)
	{
		
		$broker_cd = Vbrokersubrek::model()->find()->broker_cd;
		$broker_cd = substr($broker_cd, 0,2);
		$sp_name='';
		if($broker_cd != 'PF')
		{
			$sp_name = 'SPR_CLIENT_ACTIVITY';
		}
		else 
		{
			$sp_name = 'SPR_CLIENT_ACTIVITY_PF';
		}
				
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  $sp_name(  TO_DATE(:P_BGN_DATE,'YYYY-MM-DD'),
												   TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
												   :P_BGN_BRANCH ,
												   :P_END_BRANCH ,
												   :P_BGN_STOCK ,
												   :P_END_STOCK,
												   :P_BGN_CLIENT ,
												   :P_END_CLIENT,
												   :P_BGN_REM ,
												   :P_END_REM ,
												   :P_CUSTODY,
												   :P_STA ,
												   :P_STA_TYPE,
												   :P_MRKT_TYPE,
												   :P_BGN_MRKT_TYPE,
												   :P_END_MRKT_TYPE,
												   :P_BGN_DAYS,
												   :P_END_DAYS,
												   :P_PRICE,
												   :P_CLIENT_TYPE3,
												   :P_GROUP_BY,
												   :P_USER_ID ,
												   :P_GENERATE_DATE,
												   :P_RANDOM_VALUE,
												   :P_ERROR_CD,
												   :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE",$this->bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_BRANCH",$bgn_branch,PDO::PARAM_STR);
			$command->bindValue(":P_END_BRANCH",$end_branch,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_STOCK",$bgn_stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_END_STOCK",$end_stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$bgn_client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$end_client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_REM",$bgn_rem_cd,PDO::PARAM_STR);
			$command->bindValue(":P_END_REM",$end_rem_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CUSTODY",$custody,PDO::PARAM_STR);
			$command->bindValue(":P_STA",$sta,PDO::PARAM_STR);
			$command->bindValue(":P_STA_TYPE",$sta_type,PDO::PARAM_STR);
			$command->bindValue(":P_MRKT_TYPE",$mrkt_type,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_MRKT_TYPE",$bgn_mrkt_type,PDO::PARAM_STR);
			$command->bindValue(":P_END_MRKT_TYPE",$end_mrkt_type,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_DAYS",$bgn_days,PDO::PARAM_STR);
			$command->bindValue(":P_END_DAYS",$end_days,PDO::PARAM_STR);
			$command->bindValue(":P_PRICE",$this->price,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE3",$client_type3,PDO::PARAM_STR);
			$command->bindValue(":P_GROUP_BY",$group_by,PDO::PARAM_STR);
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
