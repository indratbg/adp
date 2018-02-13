<?php

Class Block extends Parameter
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function executeSpBlock()
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_BLOCK_UPD(
						:P_PRM_CD_2,
						:P_PRM_DESC,	
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),		
						:P_UPD_BY,
						:P_IP_ADDRESS,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			
            $command->bindValue(":P_PRM_CD_2",$this->prm_cd_2,PDO::PARAM_STR);
            $command->bindValue(":P_PRM_DESC",$this->prm_desc,PDO::PARAM_STR);

            $command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR); 
            $command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR); 
            $command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR); 
             
            $command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10); 
            $command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,100); 
			
			$command->execute();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->error_code == -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}
	
	public function attributeLabels()
	{
		return array(
			'prm_cd_1' => 'Code 1',
			'prm_cd_2' => 'Type',
			'prm_desc' => 'Status',
			'prm_desc2' => 'Description 2',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
		);
	}
	
	public function search()
	{
		$criteria = new CDbCriteria;
		
		$criteria->addCondition("UPPER(prm_cd_1) = 'BLOCK' ");	
		
		$sort = new CSort;
		$sort->defaultOrder = 'prm_cd_1, prm_cd_2';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}
