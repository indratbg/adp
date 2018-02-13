<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Laptrxharian extends ARptForm

{ 
	public $type;	
	public $update_date;
	public $update_seq;
	public $approved_sts;
	public $approved_by;
	public $grp;
	public $jual;
	public $beli;
	public $seqno;
	public $descrip;
	public $upd_status;
	public $cancel_reason;
	public $ip_address;
	public $tanggal;
	//public $vo_errcd=-999;
	/**
	 * Declares the validation rules.
	 * The rules state that user_id and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('tanggal,trx_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		array('trx_date,type,tanggal','safe')
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'trx_date'=>'Transaction Date',
			'type'=>'Type'
		);
	}
	
	
	
public function executeSpHeader($exec_status,$menuName)
	{
		 
		 $connection  = Yii::app()->db;
		// $transaction = $connection->beginTransaction();
		try{
			$query  = "CALL SP_T_MANY_HEADER_INSERT(
						:P_MENU_NAME,
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
public function executeReportGenSp()
	{
	
		$connection  = Yii::app()->dbrpt;
		//$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_TRX_HARIAN(	TO_DATE(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),
											:p_update_seq,
											TO_DATE(:P_TRX_DATE,'YYYY-MM-DD'),
											:P_USER_ID,
											:P_APPROVED_BY,
											:P_APPROVED_STS,
											:P_ERROR_CD,
											:P_vo_errmsg)";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_TRX_DATE",$this->trx_date,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_APPROVED_BY",$this->approved_by,PDO::PARAM_STR);
			$command->bindValue(":P_APPROVED_STS",$this->approved_sts,PDO::PARAM_STR);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_vo_errmsg",$this->vo_errmsg,PDO::PARAM_STR,100);

			$command->execute();
		//	$transaction->commit();
			
			
		}catch(Exception $ex){
			//$transaction->rollback();
			if($this->vo_errcd == -999){
				$this->vo_errmsg = $ex->getMessage();
		    }
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}





public function executeSp($record_seq)
	{
	
		$connection  = Yii::app()->dbrpt;
		//$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL Sp_LAP_TRX_HARIAN_Upd(TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
													:P_UPDATE_SEQ,
													TO_DATE(:P_TRX_DT,'YYYY-MM-DD'),
													:P_GRP,
													:P_SEQNO,
													:P_DESCRIP,
													:P_BELI,
													:P_JUAL,
													:P_USER_ID,
													:P_UPD_STATUS,
													:p_ip_address,
													:p_cancel_reason,
													:p_record_seq,
													:p_vo_errcd,
													:p_vo_errmsg)";
					
			$command = $connection->createCommand($query);
			$command->bindParam(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR,200);
			$command->bindParam(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_INT,10);
			$command->bindValue(":P_TRX_DT",$this->trx_date,PDO::PARAM_STR);
			$command->bindValue(":P_GRP",$this->grp,PDO::PARAM_INT);
			$command->bindValue(":P_SEQNO",$this->seqno,PDO::PARAM_INT);
			$command->bindValue(":P_DESCRIP",$this->descrip,PDO::PARAM_STR);
			$command->bindValue(":P_BELI",$this->beli,PDO::PARAM_INT);
			$command->bindValue(":P_JUAL",$this->jual,PDO::PARAM_INT);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$this->upd_status,PDO::PARAM_STR);
			$command->bindValue(":p_ip_address",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":p_cancel_reason",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindParam(":P_RECORD_SEQ",$record_seq,PDO::PARAM_INT,10);
			$command->bindParam(":p_vo_errcd",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":p_vo_errmsg",$this->vo_errmsg,PDO::PARAM_STR,100);

			$command->execute();
			//$transaction->commit();
			
			
		}catch(Exception $ex){
			//$transaction->rollback();
			if($this->vo_errcd == -999){
				$this->vo_errmsg = $ex->getMessage();
		    }
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}

	
}
