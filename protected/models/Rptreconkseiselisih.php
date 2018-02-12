<?php

class Rptreconkseiselisih extends ARptForm
{
	public $p_date;
	public $p_selisih;
	public $p_option;
	
	public $tempDateCol   = array();  
	
	public function rules()
	{
		return array(
			array('p_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('p_selisih,p_option','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
		'p_date'=>'Tanggal',
		'p_selisih'=>'Selisih',
		'p_option'=>'Show'
		);
	}
		

	public function executeRpt()
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		
		try{
			$query  = "CALL    SPR_RECON_KSEI_SELISIH( TO_DATE(:P_DATE,'YYYY-MM-DD'),
											    :P_SELISIH ,
											    :P_OPTION ,
											    :P_USER_ID ,
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";
					
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_DATE",$this->p_date,PDO::PARAM_STR);
			$command->bindValue(":P_SELISIH",$this->p_selisih,PDO::PARAM_STR);
			$command->bindValue(":P_OPTION",$this->p_option,PDO::PARAM_STR);
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
