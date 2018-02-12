<?php

class Rptlapkeuanganconsol extends ARptForm
{

	
	public $ip_address;
	public $end_period_dt;
	public $gl_account;
	public $gl_account_cd;
	public $gl_sub_account;
	public $gl_sub_account_cd;
	public $dummy;
	public $lk_acct;
	public $lk_acct_cd;
	public $company;
	public $company_cd;
	public $report_type;
	public $type;
	public $text;
	public $cancel_reason;
	public $update_date;
	public $update_seq;
	public function rules()
	{
		return array(
				//array('end_period_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
				array('type,report_type,company,company_cd,lk_acct,lk_acct_cd,gl_sub_account_cd,gl_sub_account,gl_account_cd,gl_account,end_period_dt','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'end_period_dt'=>'End Period'
			
		);
	}
	
	
	
	
public function executeSpHeader($exec_status,$menuName)
	{
		 
		 $connection  = Yii::app()->dbrpt;
		//$transaction = $connection->beginTransaction();
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
	
public function executeSp($exec_status,$record_seq)
	{
		 
		 $connection  = Yii::app()->dbrpt;
		// $transaction = $connection->beginTransaction();
		try{
			$query  = "CALL  SPR_LAP_LK_KONSOL_Upd(	to_date(:P_REPORT_DATE,'yyyy-mm-dd'),
													:P_UPD_STATUS,
													to_date(:P_UPDATE_DATE,'yyyy-mm-dd HH24:MI:SS'),
													:P_UPDATE_SEQ,
													:p_record_seq,
													:p_error_code,
													:p_error_msg)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_REPORT_DATE",$this->end_period_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);	
			$command->bindValue(":p_record_seq",$record_seq,PDO::PARAM_STR);		
			$command->bindParam(":p_error_code",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":p_error_msg",$this->vo_errmsg,PDO::PARAM_STR,1000);

			$command->execute();
		//	$transaction->commit();
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
		// $transaction = $connection->beginTransaction();
		try{
			$query  = "CALL  Spr_Lk_Konsol_NG(to_date(:p_update_date,'yyyy-mm-dd HH24:MI:SS'),
											:p_update_seq,
											to_date(:P_end_DATE,'yyyy-mm-dd'),
										   	:P_USER_ID,
										   	:P_ERROR_CODE,
										   	:P_ERROR_MSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":p_update_date",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":p_update_seq",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_end_DATE",$this->end_period_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
		//	$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_CODE",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,1000);
			$command->execute();
			//$transaction->commit();
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
	public function executeSpRptDetail($bgn_date)
	{
		
		 $connection  = Yii::app()->dbrpt;
		 //$transaction = $connection->beginTransaction();
		try{
			$query  = "CALL  SPR_LK_KONSOL_DETAIL(to_date(:P_END_DATE,'yyyy-mm-dd'),
													to_date(:P_BGN_DATE,'yyyy-mm-dd'),
													:P_LK_ACCT_CD,
													:P_GL_A,
													:P_SL_A,
													:P_ENTITY_CD,
													:P_USER_ID,
													:P_GENERATE_DATE,
													:P_RANDOM_VALUE,
													:P_ERRCD,
													:P_ERRMSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_END_DATE",$this->end_period_dt,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_DATE",$bgn_date,PDO::PARAM_STR);
			$command->bindValue(":P_LK_ACCT_CD",$this->lk_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_GL_A",$this->gl_account_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SL_A",$this->gl_sub_account_cd,PDO::PARAM_STR);
			$command->bindValue(":P_ENTITY_CD",$this->company_cd,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,1000);
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
