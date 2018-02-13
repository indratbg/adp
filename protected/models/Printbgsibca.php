<?php
class Printbgsibca extends Tpayrech
{
	public $client_name;
	public $curr_amt;
	public $remarks;
	public $bank_acct_cd;
	public $flg;
	public $chq_num;
	public $payee_bank_cd;
	public $upd_flg;
	public $bg_cq_flg;
	public $system_bank_cd;
	public $sl_acct_cd;
	public $rvpv_number;
	public $chq_old;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function rules()
	{
		return array(
			array('chq_old,folder_cd,client_name,curr_amt,remarks,bank_acct_cd,flg,chq_num,payee_bank_cd,upd_flg,bg_cq_flg,system_bank_cd,sl_acct_cd,rvpv_number','safe')
		);	
	}

	public function attributeLabels()
	{
		return array(
			
			
		);
	}

	public static function getBgSi($p_date,$p_user_id,$p_sl_acct_cd,$p_bg_cq)
	{
		// var_dump($p_bg_cq);
		// die();
		$sql="
			SELECT h.client_cd,
			  ms.client_name,
			  q.chq_amt AS curr_amt,
			  h.remarks,
			  ba.bank_acct_cd,
			  h.sl_acct_cd,
			  h.folder_cd,
			  'N' flg,
			  q.CHQ_NUM,
			  q.payee_bank_cd,
			  'N' UPD_FLG,
			  Q.BG_CQ_FLG,
			  q.bank_cd AS system_bank_cd,
			  q.sl_acct_cd,
			  Q.rvpv_number
			FROM
			  (SELECT remarks, sl_acct_cd, folder_cd, payrec_num, client_cd
			  FROM T_PAYRECH
			  WHERE payrec_date = to_Date('$p_date','dd/mm/yyyy')
			  AND payrec_type  IN ('PV','PD')
			  AND approved_sts <> 'C'
			  AND user_id LIKE '$p_user_id'
			  AND sl_acct_cd LIKE '$p_sl_acct_cd'
			  AND client_cd IS NOT NULL
			  AND trim(gl_acct_Cd) = '1200'
			  ) h,
			  MST_BANK_ACCT ba,
			  MST_BANK_MASTER m,
			  ( SELECT client_cd, client_name FROM MST_CLIENT
			  UNION
			  SELECT 'KPEI',nama_prsh FROM mst_company
			  ) ms,
			  T_CHEQ q
			WHERE h.sl_acct_cd    = ba.sl_acct_cd
			AND ba.bank_cd        = m.bank_cd
			AND m.short_bank_name = 'BCA'
			AND h.payrec_num      = q.rvpv_number
			AND q.bg_cq_flg LIKE '$p_bg_cq'
			AND q.payee_bank_cd IS NOT NULL
			AND h.client_cd      = ms.client_cd
		";
		
		return $sql;
	}

	public function executeSpUpdate($sys_bank_cd,$sl_acct_cd,$chq_num_old,$chq_num_new,$bg_cq_flg,$rvpv_num)
	{
		$connection	= Yii::app()->db;
		// $transaction = $connection->beginTransaction();
		
		try{
			$query	= "CALL SP_UPD_BG_NUMBER(
						:p_system_bank_cd,
						:p_sl_Acct_cd, 
						:p_old_chq_num,
						:p_new_chq_num,
						:P_BG_CQ_FLG,
						:P_RVPV_NUMBER,
						:p_user_id,
						:p_error_code,
						:p_error_msg)";
						
			$command = $connection->createCommand($query);
			$command->bindValue(":p_system_bank_cd",$sys_bank_cd,PDO::PARAM_STR);
			$command->bindValue(":p_sl_Acct_cd",$sl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":p_old_chq_num",$chq_num_old,PDO::PARAM_STR);
			$command->bindValue(":p_new_chq_num",$chq_num_new,PDO::PARAM_STR);
			$command->bindValue(":P_BG_CQ_FLG",$bg_cq_flg,PDO::PARAM_STR);
			$command->bindValue(":P_RVPV_NUMBER",$rvpv_num,PDO::PARAM_STR);
			$command->bindValue(":p_user_id",$this->user_id,PDO::PARAM_STR);		
			$command->bindParam(":p_error_code",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":p_error_msg",$this->error_msg,PDO::PARAM_STR,200);
			
			$command->execute();
			// $transaction->commit();
		}catch(Exception $ex){
			// $transaction->rollback();
			if($this->error_code == -999){
				$this->error_msg = $ex->getMessage();
			}
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;					
			
	}
}
?>