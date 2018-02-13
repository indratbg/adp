<?php

class Interestprocess extends ARptForm
{
	
	public $mode_rpt;
	public $client_cd;
	public $client_nm;
	public $client_type;
	public $brch_cd;
	public $month;
	public $year;
	public $from_due_dt;
	public $to_due_dt;
	
	public $closing_dt;//
	public $dummy_dt;
	public $ip_address;
	
	public $process_option;
	public $client_option;
	public $branch_option;
	public $journal_date;
	public $cl_desc;
	public $amt_int_flg;
	public $client_cnt;
	public $client_type_3;
	public $tempDateCol   = array();
	
	public function rules()
	{
		return array(
			array('journal_date,closing_dt,from_due_dt,to_due_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('from_due_dt,to_due_dt,closing_dt','required'),
			array('client_cd,branch_cd','checkRequired','on'=>'generate'),
			array('mode_rpt,client_option,client_type_3,client_cnt,client_type,client_nm,amt_int_flg,cl_desc,branch_option,process_option,month,year,client_cd,brch_cd','safe')
		);
	}
	public static function cekBranch()
	{
		return Sysparam::model()->find("param_id='INTEREST' AND PARAM_CD1='BYBRANCH' ")->dflg1;
	}
	 public function checkRequired()
	 {
	 	$check_client = Client::model()->find("client_cd='$this->client_cd' ");	
	 	if($this->client_option == '1' && !$this->client_cd)
		{
			$this->addError('client_cd', 'Client cannot be blank');
			if(!$check_client)
			{
				$this->addError('client_cd', 'Not a valid client');
			}
		}
		if($this->branch_option == '1' && !$this->brch_cd && self::cekBranch()=='Y')
		{
			$this->addError('brch_cd', 'Branch cannot be blank');
		}
		if($this->process_option=='1' && !$this->journal_date)
		{
			$this->addError('journal_date', 'Journal Date cannot be blank');
		}
		
		
	 }
	public function executeSpWorksheet($bgn_client, $end_client, $as_deposit, $bgn_branch, $end_branch, $mode_rpt)
	{
		 
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();	
		try{
		
			$query  = "CALL   SPR_INTEREST_WORKSHEET(   to_date(:dt_bgn_dt,'yyyy-mm-dd'),
													    to_date(:dt_end_dt,'yyyy-mm-dd'),
													    :s_bgn_client,
													    :s_end_client,
													    :as_deposit,
													    :s_bgn_branch,
													    :s_end_branch,
													    :P_MODE_RPT,
													    :P_USER_ID,
													    to_date(:P_GENERATE_DATE,'yyyy-mm-dd hh24:mi:ss'),
													    :P_RANDOM_VALUE,
													    :P_ERROR_CD,
													    :P_ERROR_MSG)";
			$command = $connection->createCommand($query);
			$command->bindValue(":dt_bgn_dt",$this->from_due_dt,PDO::PARAM_STR);
			$command->bindValue(":dt_end_dt",$this->to_due_dt,PDO::PARAM_STR);
			$command->bindValue(":s_bgn_client",$bgn_client,PDO::PARAM_STR);
			$command->bindValue(":s_end_client",$end_client,PDO::PARAM_STR);
			$command->bindValue(":as_deposit",$as_deposit,PDO::PARAM_STR);
			$command->bindValue(":s_bgn_branch",$bgn_branch,PDO::PARAM_STR);
			$command->bindValue(":s_end_branch",$end_branch,PDO::PARAM_STR);
			$command->bindValue(":P_MODE_RPT",$mode_rpt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,1000);
			$command->execute();
			 $transaction->commit();
			
		}catch(Exception $ex){
			 $transaction->rollback();
			if($this->vo_errcd = -999){
				$this->vo_errmsg = $ex->getMessage();
			}
		}
		
		if($this->vo_errcd < 0){
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
			
		}
		return $this->vo_errcd;
	}
	
	
	public function executeSpProsesInt($client_cd,$branch_cd, $cancel_posted_int)
	{
		 
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		try{
		
			$query  = "CALL  SP_PROCESS_INTEREST(:p_client_cd,
											to_date(:p_bgn_date,'yyyy-mm-dd'),	
											to_date(:p_end_date,'yyyy-mm-dd'),
											to_date(:p_close_date,'yyyy-mm-dd'),
											:p_brch_cd,	
											:p_cancel_posted_interest,
											:p_user_id,
											:p_ip_address,
											:o_client_cnt,
											:p_vo_errcd,				
											:p_vo_errmsg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":p_client_cd",$client_cd,PDO::PARAM_STR);
			$command->bindValue(":p_bgn_date",$this->from_due_dt,PDO::PARAM_STR);
			$command->bindValue(":p_end_date",$this->to_due_dt,PDO::PARAM_STR);
			$command->bindValue(":p_close_date",$this->closing_dt,PDO::PARAM_STR);
			$command->bindValue(":p_brch_cd",$branch_cd,PDO::PARAM_STR);
			$command->bindValue(":p_cancel_posted_interest",$cancel_posted_int,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindParam(":O_CLIENT_CNT",$this->client_cnt,PDO::PARAM_INT,10);
			$command->bindParam(":p_vo_errcd",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":p_vo_errmsg",$this->vo_errmsg,PDO::PARAM_STR,200);
			$command->execute();
			 $transaction->commit();
			
		}catch(Exception $ex){
			 $transaction->rollback();
			if($this->vo_errcd = -999){
				$this->vo_errmsg = $ex->getMessage();
			}
		}
		
		if($this->vo_errcd < 0){
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
			
		}
		return $this->vo_errcd;
	}

	public function executeSpPostingInt($bgn_client,$end_client,$bgn_branch, $month_end)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		try{
			$query  = "CALL  SP_POSTING_INTEREST(to_date(:p_date,'yyyy-mm-dd'),
					                              :p_bgn_client,
					                              :p_end_client,
					                              to_date(:p_bgn_date,'yyyy-mm-dd'),
					                              to_date(:p_end_date,'yyyy-mm-dd'),
					                              :p_brch_cd,
					                              :p_month_end,
					                              :p_user_id,
					                              :P_IP_ADDRESS,
					                              :P_ERROR_CD,
					                              :P_ERROR_MSG)";
		
			$command = $connection->createCommand($query);
			$command->bindValue(":p_date",$this->journal_date,PDO::PARAM_STR);
			$command->bindValue(":p_bgn_client",$bgn_client,PDO::PARAM_STR);
			$command->bindValue(":p_end_client",$end_client,PDO::PARAM_STR);
			$command->bindValue(":p_bgn_date",$this->from_due_dt,PDO::PARAM_STR);
			$command->bindValue(":p_end_date",$this->to_due_dt,PDO::PARAM_STR);
			$command->bindValue(":p_brch_cd",$bgn_branch,PDO::PARAM_STR);
			$command->bindValue(":p_month_end",$month_end,PDO::PARAM_STR);
			$command->bindValue(":p_user_id",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,200);
			$command->execute();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->vo_errcd == -999)
				$this->vo_errmsg = $ex->getMessage();
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}
	
    public function executeSpLogInterestProcess($process_type,$client_type,$branch)
    {
        $connection  = Yii::app()->db;
        $transaction = $connection->beginTransaction(); 
        try{
            $query  = "CALL  SP_INTEREST_PROSES_UPD(:P_PROCESS_TYPE,
                                                    :P_CLIENT_TYPE,
                                                    :P_BRANCH,
                                                    TO_DATE(:P_DUE_DATE_FROM,'YYYY-MM-DD'),
                                                    TO_DATE(:P_DUE_DATE_TO,'YYYY-MM-DD'),
                                                    TO_DATE(:P_JOURNAL_DATE,'YYYY-MM-DD'),
                                                    :P_UPD_STATUS,
                                                    :P_USER_ID,
                                                    :P_IP_ADDRESS,
                                                    :p_record_seq,
                                                    :p_error_code,
                                                    :p_error_msg)";
        
            $command = $connection->createCommand($query);
            $command->bindValue(":P_PROCESS_TYPE",$process_type,PDO::PARAM_STR);
            $command->bindValue(":P_CLIENT_TYPE",$client_type,PDO::PARAM_STR);
            $command->bindValue(":P_BRANCH",$branch,PDO::PARAM_STR);
            $command->bindValue(":P_DUE_DATE_FROM",$this->from_due_dt,PDO::PARAM_STR);
            $command->bindValue(":P_DUE_DATE_TO",$this->to_due_dt,PDO::PARAM_STR);
            $command->bindValue(":P_JOURNAL_DATE",$this->journal_date,PDO::PARAM_STR);
            $command->bindValue(":P_UPD_STATUS",'I',PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
            $command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
            $command->bindValue(":p_record_seq",'1',PDO::PARAM_STR);
            $command->bindParam(":p_error_code",$this->vo_errcd,PDO::PARAM_INT,10);
            $command->bindParam(":p_error_msg",$this->vo_errmsg,PDO::PARAM_STR,200);
            $command->execute();
            $transaction->commit();
        }catch(Exception $ex){
            $transaction->rollback();
            if($this->vo_errcd == -999)
                $this->vo_errmsg = $ex->getMessage();
        }
        
        if($this->vo_errcd < 0)
            $this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
        
        return $this->vo_errcd;
    }
}
