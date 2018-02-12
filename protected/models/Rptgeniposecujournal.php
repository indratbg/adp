<?php

class Rptgeniposecujournal extends ARptForm
{

	
	public $ip_address;
	public $stk_cd;
	public $stk_cd_temp;
	public $stk_cd_ksei;
	public $remarks;
	public function rules()
	{
		return array(
				array('stk_cd_temp','cek_stk_cd','on'=>'generate'),
				array('remarks,stk_cd,stk_cd_temp,stk_cd_ksei','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
		
			
		);
	}
	public function cek_stk_cd(){
		
		$cek= Counter::model()->find("stk_cd = '$this->stk_cd_ksei' ");
		
		if(!$cek){
			$this->addError('stk_cd_temp', "Stock code tidak ditemukan");
		}
		
	}
	
public function executeSp()
	{
		 
		 $connection  = Yii::app()->db;
		 $transaction = $connection->beginTransaction();
		try{
			$query  = "CALL SP_GEN_IPO_SECU_JOURNAL(:P_STK_CD_TEMP,
													:P_STK_CD_KSEI,
													:P_REMARKS,
													:P_USER_ID,
													:P_IP_ADDRESS,
													:P_ERRCD,
													:P_ERRMSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_STK_CD_TEMP",$this->stk_cd_temp,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD_KSEI",$this->stk_cd_ksei,PDO::PARAM_STR);
			$command->bindValue(":P_REMARKS",$this->remarks,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);			
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindParam(":P_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,1000);

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


	public function executeSpRpt()
	{	 
		 $connection  = Yii::app()->dbrpt;
		 $transaction = $connection->beginTransaction();
		try{
			$query  = "CALL SPR_GEN_IPO_SECU_JUR(:P_STK_CD,
												 :P_STK_CD_KSEI,
												 :P_USER_ID,
												 to_date(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
												 :P_RANDOM_VALUE,
												 :P_ERRCD,
												 :P_ERRMSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_STK_CD",$this->stk_cd_temp,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD_KSEI",$this->stk_cd_ksei,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,1000);
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
