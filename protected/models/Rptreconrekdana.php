<?php

class Rptreconrekdana extends ARptForm
{
	public $bal_dt;
	public $report_type;
	public $bank_cd_1;
	public $bank_cd_2;
	public function rules()
	{
		return array(
		array('bank_cd_2,bank_cd_1,report_type,bal_dt','safe')
		
		);
	}
	
	public function attributeLabels()
	{	return array(
				'bal_dt'=>'Date',
				'report_type'=>'Reconcile with');
	}

	public function executeRpt($recon_option, $bank_cd)
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		try{
			$query  = "CALL  SPR_RECON_REK_DANA(TO_DATE(:P_DATE,'YYYY-MM-DD'),
											    :P_RECON_OPTION,
											    :P_BANK_CD,
											    :P_USER_ID,
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											    :P_RANDOM_VALUE,
											    :P_ERRCD,
											    :P_ERRMSG)";
				
			$command = $connection->createCommand($query);
			$command->bindValue(":P_DATE",$this->bal_dt,PDO::PARAM_STR);
			$command->bindValue(":P_RECON_OPTION",$recon_option,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_CD",$bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,100);
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
