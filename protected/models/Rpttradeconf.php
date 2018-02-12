<?php

class Rpttradeconf extends ARptForm
{

  	public $tc_date;
	public $client_type;
	public $client_cd;
	public $update_date;
	public $update_seq;
	public $beg_rem;
	public $end_rem;
	public $beg_branch;
	public $end_branch;
	public $bgn_date;
	public $end_date;
	public $beg_client;
	public $end_client;
	public $ip_address;
	public $cancel_reason;
	public $cl_type;
	public $brch_cd;
	public $brch_type;
	public $rem_type;
	public $rem_cd;
	public $to_date;
	public $from_client;
	public $to_client;
	//08aug2016
	public $email_option;
	
	public function rules()
	{
		return array(
			array('email_option,from_client,to_client,to_date,rem_type,rem_cd,cl_type,brch_cd, brch_type,cre_by, tc_date, client_type, client_cd, update_date, update_seq, beg_rem, end_rem, beg_branch, end_branch, bgn_date, end_date, beg_client, end_client, ip_address, cancel_reason','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'cl_type'=>'Client Type'
		);
	}
		
	public function executeSpHeader($exec_status,$menuName)
	{
		 
		 $connection  = Yii::app()->dbrpt;
		// $transaction = $connection->beginTransaction();
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
		//	$transaction->commit();
			//Commit baru akan dijalankan saat semua transaksi INSERT sukses
			
		}catch(Exception $ex){
		//	$transaction->rollback();
			if($this->vo_errcd = -999)
				$this->vo_errmsg = $ex->getMessage();
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}

	public function executeSpInboxUpd($mode,$type)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_TRADE_CONF_UPD(
						TO_DATE(:P_TRX_DATE,'YYYY-MM-DD'),
						:P_CLIENT_CD,
						:P_MODE,
						:P_TC_ID,
						:P_USER_ID,
						
						:P_UPD_STATUS,
						:p_ip_address,
						:p_cancel_reason,
						:p_update_date,
						:p_update_seq,
						
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_TRX_DATE",$this->tc_date,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_MODE",$mode,PDO::PARAM_STR);
			$command->bindValue(":P_TC_ID",$type,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			
			$command->bindValue(":P_UPD_STATUS",'X',PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);

			$command->bindParam(":P_ERROR_CODE",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,1000);

			$command->execute();
		}catch(Exception $ex){
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}

public function executeSpRpt()
	{
		 
		 $connection  = Yii::app()->dbrpt;
	//	 $transaction = $connection->beginTransaction();
		try{
			$query  = "CALL SP_TRADE_CONF(to_date(:vp_update_date,'yyyy-mm-dd hh24:mi:ss'),
											:vp_update_seq,
											  :vp_beg_rem,
											  :vp_end_rem,
											  :vp_beg_branch,
											  :vp_end_branch,
											  to_date(:vp_bgn_date,'yyyy-mm-dd'),
											  to_date(:vp_end_date,'yyyy-mm-dd'),
											  :vp_beg_client,
											  :vp_end_client,
											  :vp_userid,
											  :vo_errcd,
											  :vo_errmsg)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":vp_update_date",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":vp_update_seq",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":vp_beg_rem",$this->beg_rem,PDO::PARAM_STR);
			$command->bindValue(":vp_end_rem",$this->end_rem,PDO::PARAM_STR);
			$command->bindValue(":vp_beg_branch",$this->beg_branch,PDO::PARAM_STR);
			$command->bindValue(":vp_end_branch",$this->end_branch,PDO::PARAM_STR);
			$command->bindValue(":vp_bgn_date",$this->tc_date,PDO::PARAM_STR);
			$command->bindValue(":vp_end_date",$this->tc_date,PDO::PARAM_STR);
			$command->bindValue(":vp_beg_client",$this->beg_client,PDO::PARAM_STR);
			$command->bindValue(":vp_end_client",$this->end_client,PDO::PARAM_STR);
			$command->bindValue(":vp_userid",$this->vp_userid,PDO::PARAM_STR);
			$command->bindParam(":vo_errcd",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":vo_errmsg",$this->vo_errmsg,PDO::PARAM_STR,1000);

			$command->execute();
			//$transaction->commit();
			//Commit baru akan dijalankan saat semua transaksi INSERT sukses
			
		}catch(Exception $ex){
			//$transaction->rollback();
			if($this->vo_errcd = -999)
				$this->vo_errmsg = $ex->getMessage();
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}
}
