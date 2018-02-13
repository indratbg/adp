<?php

class Rptmapneracaringkas extends ARptForm
{
	public $p_grp;
	public $tempDateCol   = array();
	public $dummy_date;  
	
	public function rules()
	{
		return array(
			array('p_grp,dummy_date','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
		);
	}
		

	public function excuteRpt()
	{
	 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_MST_MAP_NERACA_RINGKAS(
											:P_GRP,
										    :P_USER_ID,
										    to_date(:P_GENERATE_DATE,'yyyy-mm-dd hh24:mi:ss'),
										    :P_RANDOM_VALUE,
										    :P_ERROR_CD,
										    :P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_GRP",$this->p_grp,PDO::PARAM_STR);
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
