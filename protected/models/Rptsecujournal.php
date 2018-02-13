<?php

class Rptsecujournal extends ARptForm
{

	public $from_date;
	public $to_date;
	public $doc_num;
	public $cre_dt;
	public function rules()
	{
		return array(
			array('from_date, to_date','required'),
			array('doc_num,from_date,to_date','safe')
			);
	}
	
	public function attributeLabels()
	{
		return array(
			'doc_num'=>'Journal Number',
			'from_date'=>'From Date',
			'to_date'=>'To Date'
		);
	}
		
	public function executeRpt()
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_SECU_JOURNAL(  TO_DATE(:P_FROM_DATE,'DD/MM/YYYY'),
											    TO_DATE(:P_TO_DATE,'DD/MM/YYYY'),
											    :P_DOC_NUM,
											    :P_USER_ID,
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											    :P_RANDOM_VALUE,
											    :P_ERROR_MSG,
											    :P_ERROR_CD)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_FROM_DATE",$this->from_date,PDO::PARAM_STR);
			$command->bindValue(":P_TO_DATE",$this->to_date,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_NUM",$this->doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,200);

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
