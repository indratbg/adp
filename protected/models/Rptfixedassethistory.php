<?php

class Rptfixedassethistory extends ARptForm
{
	public $bgn_date;
	public $end_date;
	public $asset_cd;
	public $option;
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('bgn_date,end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('option,asset_cd','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'bgn_date' => 'From',
			'end_date' => 'To',
			'asset_cd' => 'Asset Code',
		);
	}
		

	public function executeRpt()
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		
		try{
			$query  = "CALL    SPR_FIXED_ASSET_HISTORY( TO_DATE(:P_BGN_DATE,'YYYY-MM-DD'),
												TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
											    :P_ASSET_CD,
											    :P_USER_ID ,
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";
					
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_BGN_DATE",$this->bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_ASSET_CD",$this->asset_cd,PDO::PARAM_STR);
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
