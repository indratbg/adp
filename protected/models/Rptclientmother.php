<?php

class Rptclientmother extends ARptForm
{
	public $client_status;
	public $client_cd;
	public $branch_cd;
	public $branch_status;
	
	public function rules()
	{
		return array(
			array('client_status,client_cd,branch_cd,branch_status','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
		
			
		);
	}
	public function executeRpt($client_cd,$client_status, $branch_cd)
		{
			
			$connection  = Yii::app()->dbrpt;
			$transaction = $connection->beginTransaction();
			try{
				$query = "CALL SPR_CLIENT_MOTHERNAME (
														:P_BRANCH_CODE,
														:P_CLIENT_CD,
														:P_STATUS,
														:VP_USERID,
														:VP_GENERATE_DATE,
														:VO_RANDOM_VALUE,
														:VO_ERRCD,
														:VO_ERRMSG
													)";
				$command = $connection->createCommand($query);
				$command ->bindValue(":P_BRANCH_CODE",$branch_cd,PDO::PARAM_STR);
				$command ->bindValue(":P_CLIENT_CD",$client_cd,PDO::PARAM_STR);
				$command ->bindValue(":P_STATUS",$client_status,PDO::PARAM_STR);
				$command->bindValue(":VP_USERID",$this->vp_userid,PDO::PARAM_STR);
				$command->bindValue(":VP_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
				$command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
				$command->bindParam(":VO_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
				$command->bindParam(":VO_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,200);
				
				$command->execute();
				$transaction->commit();
			
			}
		catch(Exception $ex){
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