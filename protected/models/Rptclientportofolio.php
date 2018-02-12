<?php

class Rptclientportofolio extends ARptForm
{

	public $end_date;
	public $limit_flg='N';
	public $client_cd;
	public $branch_cd;
	public $rem_cd;
	public $stk_cd;
	
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('stk_cd,branch_cd,rem_cd,client_cd, limit_flg','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'end_date'=>'Date',
			'limit_flg'=>'With Available limit',
			'branch_cd'=>'Branch',
			'rem_cd'=>'Sales',
			'stk_cd'=>'Stock',
			'client_cd'=>'Client'
		);
	}
		

	public function executeRpt($bgn_client, $end_client,$limit_flg,$bgn_branch, $end_branch, $bgn_rem, $end_rem, $bgn_stock, $end_stock)
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_CLIENT_PORTOFOLIO( TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
												    :P_BGN_CLIENT,
												    :P_END_CLIENT,
												    :P_LIMIT_FLG,
												    :P_BGN_BRANCH,
												    :P_END_BRANCH,
												    :P_BGN_REM,
												    :P_END_REM,
												    :P_BGN_STOCK,
												    :P_END_STOCK,
												    :P_USER_ID,
												    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
												    :P_RANDOM_VALUE,
												    :P_ERROR_CD,
												    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$bgn_client,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$end_client,PDO::PARAM_STR);
			$command->bindValue(":P_LIMIT_FLG",$limit_flg,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_BRANCH",$bgn_branch,PDO::PARAM_STR);
			$command->bindValue(":P_END_BRANCH",$end_branch,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_REM",$bgn_rem,PDO::PARAM_STR);
			$command->bindValue(":P_END_REM",$end_rem,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_STOCK",$bgn_stock,PDO::PARAM_STR);
			$command->bindValue(":P_END_STOCK",$end_stock,PDO::PARAM_STR);
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
