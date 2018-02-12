<?php

class Rptoutstandingarapvsgl extends ARptForm
{
	public $bgn_date;
	public $end_date;
	public $dummy_date;
	public $client_option;
	public $bgn_client_cd;
	public $end_client_cd;
	public $report_type;
	public $option_outs;
	public $outs_bfr_date;
	public $outs_aft_date;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('outs_bfr_date,outs_aft_date,bgn_date, end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('option_outs,bgn_client_cd, end_client_cd,report_type,stk_cd,client_option,','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			
			'doc_dt'=>'Date'
		);
	}
		

	public function executeRpt($option,$bgn_client,$end_client, $option_bfr_date )
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		try{
			$query  = "CALL  SPR_RECON_OUTST_ARAP( to_date(:P_BGN_DATE,'YYYY-MM-DD'),
											    TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
											    :P_OPTION,
											    :P_BGN_CLIENT,
											    :P_END_CLIENT,
											  	 :P_before_bgn_date,
											    :P_USER_ID,
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE",$this->bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_OPTION",$option,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_CLIENT",$bgn_client,PDO::PARAM_STR);
			$command->bindValue(":P_END_CLIENT",$end_client,PDO::PARAM_STR);
			$command->bindValue(":P_before_bgn_date",$option_bfr_date,PDO::PARAM_STR);
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
	public function executeProsesOuts()
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SP_BEGIN_ARAP_OUTSTAND()";
					
			$command = $connection->createCommand($query);
			$command->execute();
			$transaction->commit();

		}catch(Exception $ex){
			$transaction->rollback();
			if($this->vo_errcd == -999){
				$this->vo_errmsg = $ex->getMessage();
		    }
		}
		
		return $this->vo_errcd;
	}

}
