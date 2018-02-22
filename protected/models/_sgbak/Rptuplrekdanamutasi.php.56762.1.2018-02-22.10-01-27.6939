<?php

class Rptuplrekdanamutasi extends ARptForm
{
	
public $tanggaltimestamp;
public $frombank;
public $instructionfrom;
public $rdn;
public $branch;	
public $client_cd;
public $client_name;	
public $beginningbalance;
public $transactionvalue;
public $closingbalance;
public $journal;

	//[AH] just create
  	public $tempDateCol;
	
	public function rules()
	{
		return array(
				
			
		);
	}
	
	public function attributeLabels()
	{
		return array(
			
		);
	}
		
	public function executeRpt()
	{
	
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		try{		
				$query  = "CALL SPR_UPL_REK_DANA_MUTASI(TO_DATE(:P_TANGGALTIMESTAMP,'YYYY-MM-DD HH24:MI:SS'),		
														:P_FROMBANK,
														:P_INSTRUCTIONFROM,
														:P_RDN,
														:P_BRANCH,
														:P_CLIENT_CD,
														:P_CLIENT_NAME,
														:P_BEGINNINGBALANCE,
														:P_TRANSACTIONVALUE,
														:P_CLOSINGBALANCE,
														:P_JOURNAL,
														:P_RAND_VALUE,
														TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),		
														:P_USER_ID,
														:P_ERROR_CD,
														:P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_TANGGALTIMESTAMP",$this->tanggaltimestamp,PDO::PARAM_STR);
			$command->bindValue(":P_FROMBANK",$this->frombank,PDO::PARAM_STR);
			$command->bindValue(":P_INSTRUCTIONFROM",$this->instructionfrom,PDO::PARAM_STR);
			$command->bindValue(":P_RDN",$this->rdn,PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH",$this->branch,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_NAME",$this->client_name,PDO::PARAM_STR);
			$command->bindValue(":P_BEGINNINGBALANCE",$this->beginningbalance,PDO::PARAM_STR);
			$command->bindValue(":P_TRANSACTIONVALUE",$this->transactionvalue,PDO::PARAM_STR);
			$command->bindValue(":P_CLOSINGBALANCE",$this->closingbalance,PDO::PARAM_STR);
			$command->bindValue(":P_JOURNAL",$this->journal,PDO::PARAM_STR);
			$command->bindParam(":P_RAND_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
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
