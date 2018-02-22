<?php

class Nettingarap extends Tpayrech
{
	public $netting_date;
	public $dividen_flg;
	
	public $successCnt;
	public $failCnt;
	public $failMsg;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function executeSpNettingArap()
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_NETTING_ARAP(
						TO_DATE(:P_DATE,'YYYY-MM-DD'),
						:P_DIVIDEN,
						:P_CLIENT_CD,
						:P_SUCCESS_CNT,
						:P_FAIL_CNT,
						:P_FAIL_MSG,
						:P_USER_ID,
						:P_IP_ADDRESS,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_DATE",$this->netting_date,PDO::PARAM_STR);
			$command->bindValue(":P_DIVIDEN",$this->dividen_flg,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd?$this->client_cd:'%',PDO::PARAM_STR);
			$command->bindParam(":P_SUCCESS_CNT",$this->successCnt,PDO::PARAM_STR,10);
			$command->bindParam(":P_FAIL_CNT",$this->failCnt,PDO::PARAM_STR,10);
			$command->bindParam(":P_FAIL_MSG",$this->failMsg,PDO::PARAM_STR,200);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
						
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			
		}catch(Exception $ex){
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

	public function attributeLabels()
	{
		return array_merge
				(
					parent::attributeLabels(),
					array(
						'netting_date' => 'Date',
						'dividen_flg' => 'Include Dividen'
					)
				);
	}
	
	public function rules()
	{
		return array(
			array('netting_date','checkIfHoliday'),
		
			array('netting_date, trx_date, due_date, payrec_date, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('curr_amt, num_cheq', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('netting_date','required'),

			array('num_cheq', 'numerical', 'integerOnly'=>true),
			array('curr_amt', 'numerical'),
			array('payrec_type', 'length', 'max'=>2),
			array('acct_type', 'length', 'max'=>4),
			array('sl_acct_cd, gl_acct_cd, client_cd', 'length', 'max'=>12),
			array('curr_cd', 'length', 'max'=>3),
			array('payrec_frto, remarks, client_bank_name', 'length', 'max'=>50),
			array('user_id', 'length', 'max'=>10),
			array('approved_sts', 'length', 'max'=>1),
			array('approved_by', 'length', 'max'=>20),
			array('check_num, client_bank_acct', 'length', 'max'=>30),
			array('folder_cd', 'length', 'max'=>8),
			array('dividen_flg, brch_cd, bank_acct_num, net_buy, net_sell, vch_ref, pembulatan, print, file_upload,trx_date, due_date, trf_ksei, int_adjust, type, client_bank_cd, client_name, client_type, client_type_3, branch_code, olt, recov_charge_flg, bank_cd, bank_acct_fmt, active, rdi_pay_flg, payrec_date, cre_dt, upd_dt, approved_dt', 'safe'),
		);		
	}

	public function checkIfHoliday()
	{
		if($this->netting_date)
		{
			$check = "SELECT dflg1 FROM MST_SYS_PARAM WHERE param_id = 'SYSTEM' AND param_cd1 = 'CHECK' AND param_cd2 = 'HOLIDAY'";
			$checkFlg = DAO::queryRowSql($check);
			
			if($checkFlg['dflg1'] == 'Y')
			{
				$sql = "SELECT F_IS_HOLIDAY('$this->netting_date') is_holiday FROM dual";
				$isHoliday = DAO::queryRowSql($sql);
				
				if($isHoliday['is_holiday'] == 1)$this->addError('netting_date','Date must not be holiday');
			}
		}
	}
}
