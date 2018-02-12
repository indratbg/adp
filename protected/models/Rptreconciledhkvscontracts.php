<?php

class Rptreconciledhkvscontracts extends ARptForm
{
	public $settle_date;
	public $import_type;
	public $type;
	public function rules()
	{
		return array(
		array('trx_date', 'application.components.validator.ADatePickerSwitcherValidator'),
		array('import_type,file_upload','safe'),
		
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
			$query  = "CALL SPR_T_DHK(TO_DATE(:P_SETTLE_DATE,'YYYY-MM-DD'),
										:P_OPTIONS,
										:P_TYPE,
										:P_USER_ID,
										:P_GENERATE_DATE,
										:P_RANDOM_VALUE,
										:P_ERRCD,
										:P_ERRMSG)";
				
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SETTLE_DATE",$this->settle_date,PDO::PARAM_STR);
			$command->bindValue(":P_OPTIONS",$this->import_type,PDO::PARAM_STR);
			$command->bindValue(":P_TYPE",$this->type,PDO::PARAM_STR);
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
