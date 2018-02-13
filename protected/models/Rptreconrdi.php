<?php

class Rptreconrdi extends ARptForm
{
	
	//[AH] just create
  	public $tempDateCol;
	//public $begin_date;
	public $end_date;
	public $pembulatan;
	public $bank_cd;
	public function rules()
	{
		return array(
			//array('tc_date','required'),
			array('end_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array(' end_date, pembulatan, bank_cd','safe'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'begin_date'=>'Begin Date',
			'end_date'=>'End Date',
			
		);
	}
		
	public function executeReportGenSp()
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL Spr_RECON_RDI(	to_date(:P_END_DATE ,'yyyy-mm-dd'),
											:P_PEMBULATAN,
											:P_BANK_CD,
											:P_USER_ID ,
											to_date(:p_generate_date,'yyyy-mm-dd hh24:mi:ss'),
											:vo_random_value,
											:vo_errcd,
											:vo_errmsg)";
					
			$command = $connection->createCommand($query);
			//$command->bindValue(":P_BEGIN_DATE",$this->begin_date,PDO::PARAM_STR);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_PEMBULATAN",$this->pembulatan,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_CD",$this->bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":p_generate_date",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":vo_random_value",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":vo_errcd",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":vo_errmsg",$this->vo_errmsg,PDO::PARAM_STR,200);

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
