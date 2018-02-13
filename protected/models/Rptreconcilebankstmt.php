<?php

class Rptreconcilebankstmt extends ARptForm
{

	public $import_type;
	public $to_dt;
	public $period_from;
	public $period_to;
	public $gl_acct_cd;
	public $sl_acct_cd;
	public function rules()
	{
		return array(
		array('period_from,period_to', 'application.components.validator.ADatePickerSwitcherValidator'),
		array('import_type','safe'),
		
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'trx_date'=>'Transaction Due Date'
		);
	}

	public function executeRpt()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		try{
			$query  = "CALL SPR_T_BANK_STMT(	to_date(:period_from,'yyyy-mm-dd'),
												to_date(:period_to,'yyyy-mm-dd'),
												:p_gl_acct,
												:p_sl_acct,
												:s_option,
												 :P_USER_ID,
												 :P_GENERATE_DATE,
												 :P_RANDOM_VALUE,
												 :P_ERRCD,
												 :P_ERRMSG)";
				
			$command = $connection->createCommand($query);
			$command->bindValue(":period_from",$this->period_from,PDO::PARAM_STR);
			$command->bindValue(":period_to",$this->period_to,PDO::PARAM_STR);
			$command->bindValue(":p_gl_acct",$this->gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":p_sl_acct",$this->sl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":s_option",$this->import_type,PDO::PARAM_STR);
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
