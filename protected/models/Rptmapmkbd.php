<?php

class Rptmapmkbd extends ARptForm
{
	public $source;
	public $ver_date;
	public function rules()
	{
		return array(
		array('source,ver_date','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
		'source'=>'Source'
			
		);
	}
	
public function executeSpReport()
	{	 
		 $connection  = Yii::app()->dbrpt;
		 $transaction = $connection->beginTransaction();
		try{
			$query  = "CALL SPR_MAP_MKBD(TO_DATE(:P_DATE,'YYYY-MM-DD'),
										:P_SOURCE,
									    :P_USER_ID,
									    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
									    :P_RANDOM_VALUE,
									    :P_ERRCD,
									    :P_ERRMSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_DATE",$this->ver_date,PDO::PARAM_STR);
			$command->bindValue(":P_SOURCE",$this->source,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_STR,10);
			$command->bindParam(":P_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,200);

			$command->execute();
			$transaction->commit();
			//Commit baru akan dijalankan saat semua transaksi INSERT sukses
			
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->vo_errcd = -999)
				$this->vo_errmsg = $ex->getMessage();
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}

}
