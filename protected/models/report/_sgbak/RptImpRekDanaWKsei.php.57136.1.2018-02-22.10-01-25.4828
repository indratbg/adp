<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RptImpRekDanaWKsei extends ARptForm
{
	/**
	 * Declares the validation rules.
	 * The rules state that user_id and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
		
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
	
		);
	}
	

	
	public function executeReportGenSp()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			
			$query  = "CALL SP_R_RECON_RDI_KSEI(
						:VP_USERID,TO_DATE(:VP_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),:VO_RANDOM_VALUE,
						:VO_ERRCD,:VO_ERRMSG)";
					
			$command = $connection->createCommand($query);
			
			$command->bindValue(":VP_USERID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":VP_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			
			$command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,100);

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
