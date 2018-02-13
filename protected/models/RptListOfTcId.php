<?php

class RptListOfTcId extends ARptForm
{
	public $tc_date;
	public $client_cd;
	public $client_mode;
	public $tc_status;
	
	//[AH] just create
  	public $tempDateCol;
	
	public function rules()
	{
		return array(
			array('tc_date','required'),
			array('tc_date,client_cd,tc_status,client_mode','safe'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'tc_date' => 'Date',
			'client_mode' => 'Client',
			'tc_status' => 'Document Status'
		);
	}
		
	public function executeReportGenSp($tc_status)
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_TC_ID_LIST(
							TO_DATE(:VP_TC_DATE,'DD/MM/YYYY'),
							:VP_CLIENT_CD,
							:VP_TC_STATUS,
							:VP_USERID,
							TO_DATE(:VP_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
							:VO_RANDOM_VALUE,
							:VO_ERRCD,
							:VO_ERRMSG
					   )";
					
			$command = $connection->createCommand($query);
			
			$command->bindValue(":VP_TC_DATE",$this->tc_date,PDO::PARAM_STR);
			$command->bindValue(":VP_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":VP_TC_STATUS",$tc_status,PDO::PARAM_STR);
			
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
