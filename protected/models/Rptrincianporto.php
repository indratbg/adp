<?php

class Rptrincianporto extends ARptForm
{

	public $date_now;
	public $bgn_dt;
	public $ip_address;
	public $cancel_reason;
	public $update_date;
	public $update_seq;
	public $broker;
	public function rules()
	{
		return array(
		array('date_now','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
		'date_now'=>'Date'
			
		);
	}
	
public function executeSpHeader($exec_status,$menuName)
	{
		 
		 $connection  = Yii::app()->db;
		 $transaction = $connection->beginTransaction();
		try{
			$query  = "CALL SP_T_MANY_HEADER_INSERT(:P_MENU_NAME,
													:P_STATUS,
													:P_USER_ID,
													:P_IP_ADDRESS,
													:P_CANCEL_REASON,
													:P_UPDATE_DATE,
													:P_UPDATE_SEQ,
													:P_vo_errcd,
													:P_vo_errmsg)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_MENU_NAME",$menuName,PDO::PARAM_STR);
			$command->bindValue(":P_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);			
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindParam(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR,30);
			$command->bindParam(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR,10);
			$command->bindParam(":P_vo_errcd",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_vo_errmsg",$this->vo_errmsg,PDO::PARAM_STR,1000);

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
public function executeSpIns($status,$record_seq)
	{	 
		 $connection  = Yii::app()->dbrpt;
		 $transaction = $connection->beginTransaction();
		try{
			$query  = "CALL SPR_LAP_RINCIAN_PORTO_Upd(TO_DATE(:P_REPORT_DATE,'YYYY-MM-DD'),
														:P_UPD_STATUS,
														TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
														:P_UPDATE_SEQ,
														:p_record_seq,
														:p_error_code,
														:p_error_msg)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_REPORT_DATE",$this->date_now,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$status,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_RECORD_SEQ",$record_seq,PDO::PARAM_STR);
			$command->bindParam(":p_error_code",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":p_error_msg",$this->vo_errmsg,PDO::PARAM_STR,1000);

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
			$query  = "CALL SP_RINCIAN_PORTO_YJ(TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
													:P_UPDATE_SEQ,
													TO_DATE(:P_END_DT,'YYYY-MM-DD'),
													TO_DATE(:P_BGN_DT,'YYYY-MM-DD'),
													:P_USER_ID,
													:P_ERROR_CD,
													:P_ERROR_MSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_END_DT",$this->date_now,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_DT",$this->bgn_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR,10);
			$command->bindParam(":p_error_cd",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":p_error_msg",$this->vo_errmsg,PDO::PARAM_STR,1000);

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
