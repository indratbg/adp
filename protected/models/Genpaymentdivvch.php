<?php

class Genpaymentdivvch extends Tpayrech
{
	public $brch_cd;
	public $bank_acct_num;
	public $pembulatan;
	public $save_flg;
	public $rdi_bank_cd;
	public $rowid;
	public $stk_cd;
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function rules()
	{
		return array(
			array(
				'payrec_date',
				'application.components.validator.ADatePickerSwitcherValidatorSP'
			),

			array(
				'curr_amt, pembulatan',
				'application.components.validator.ANumberSwitcherValidator'
			),
			array('pembulatan','cek_pembulatan'),
			array(
				'pembulatan, curr_amt',
				'numerical'
			),
			array('remarks','required'),
			array(
				'folder_cd',
				'length',
				'max' => 8
			),
			array(
				'stk_cd,rdi_bank_cd,save_flg,remarks,client_cd,brch_cd, bank_acct_num, pembulatan, client_name, bank_cd',
				'safe'
			),
		);
	}
	public function cek_pembulatan()
	{
		$result = DAO::queryRowSql("SELECT dflg1 FROM MST_SYS_PARAM WHERE param_id = 'RVPV_AUTO_TRF' AND param_cd1 = 'ROUND' ");	
		$total = $this->curr_amt+$this->pembulatan;
		
		
		if(intval($total) != $total && $result['dflg1'] == 'Y')
		{
			$this->addError('pembulatan','Angka yang anda masukkan tidak bulat ('.number_format($total,2,',','.').')');
		}
	}
	public static function getPaymentList($payrec_date, $branch_cd)
	{
		$sql = "SELECT DISTINCT BRCH_CD,CLIENT_CD,CLIENT_NAME,BANK_CD,BANK_ACCT_NUM,rdi_bank_cd,
				SUM(CURR_AMT) OVER (PARTITION BY BRCH_CD,CLIENT_CD) curr_amt,
				decode(count(stk_cd) over(PARTITION BY BRCH_CD,CLIENT_CD),1,'DIV '|| stk_cd||' - '||client_cd,null) remarks
				FROM
				  (
				  SELECT --b.rowid,
				    C.BRANCH_CODE brch_cd,
				    C.CLIENT_CD,
				    C.CLIENT_NAME,
				    D.BANK_CD,
				    C.BANK_ACCT_NUM,
				    B.GL_ACCT_CD,
				    B.SL_ACCT_CD,   
				    B.CURR_VAL AS curr_amt,
				    f.bank_cd rdi_bank_cd,
				    e.stk_cd
				  FROM T_PAYRECH A,
				    T_ACCOUNT_LEDGER B,
				    MST_CLIENT C,
				    MST_CLIENT_BANK D,
				    T_CASH_DIVIDEN E,
				    MST_CLIENT_FLACCT F
				  WHERE A.PAYREC_NUM  =B.XN_DOC_NUM
				  AND B.XN_DOC_NUM = E.RVPV_NUMBER
				  AND B.SL_ACCT_CD    =C.CLIENT_CD
				  AND B.SL_ACCT_CD    = C.CLIENT_CD
				  
				  AND C.CIFS= D.CIFS
				     AND C.BANK_ACCT_NUM=d.bank_acct_num
          			AND C.BANK_CD=D.BANK_CD
				  AND B.SL_ACCT_CD    =E.CLIENT_CD
				  AND B.SL_ACCT_CD    = F.CLIENT_CD
				  AND C.CLIENT_TYPE_3 = 'R'
				  
				  AND A.PAYREC_DATE   ='$payrec_date'
				  AND E.DISTRIB_DT    ='$payrec_date'
				  AND TRIM(C.BRANCH_CODE) like '$branch_cd'
				  AND A.ACCT_TYPE    ='DIV'
				  AND F.ACCT_STAT    ='A'
				  AND (B.SETT_VAL    < B.CURR_VAL)
				  AND B.SETT_FOR_CURR=0
				  )
				ORDER BY CLIENT_CD
  ";

  //AND B.SL_ACCT_CD    = D.CLIENT_CD
  //AND C.BANK_ACCT_NUM = D.BANK_ACCT_NUM
		return $sql;
	}

	public static function getPrefixFolder($bank_cd)
	{
		$cek_bank = Sysparam::model()->find("PARAM_ID='GEN_PAYMENT_VOC_DIV' and param_cd1='GL_ACCT' AND PARAM_CD2 like '$bank_cd' ");
		$folder_cd = $cek_bank->param_cd3;

		return $folder_cd;
	}

	public function executeSpPaymentDiv()
	{
		$connection = Yii::app()->db;
		//var_dump($this->client_cd);die();
		try
		{
			$query = "CALL SP_GEN_PAYMT_DIV_VOUCHER(TO_DATE(:P_PAYREC_DATE,'YYYY-MM-DD'),
													    :P_CLIENT_CD,
													    :P_REMARKS,
													    :P_PEMBULATAN,
													    :P_FOLDER_CD,
													    :P_BANK_CD,
													    :P_USER_ID,
													    :P_IP_ADDRESS,
													    :P_ERROR_CODE,
													    :P_ERROR_MSG)";

			$command = $connection->createCommand($query);
			$command->bindValue(":P_PAYREC_DATE", $this->payrec_date, PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD", $this->client_cd, PDO::PARAM_STR);
			$command->bindValue(":P_REMARKS", $this->remarks, PDO::PARAM_STR);
			$command->bindValue(":P_PEMBULATAN", $this->pembulatan, PDO::PARAM_STR);
			$command->bindValue(":P_FOLDER_CD", $this->folder_cd, PDO::PARAM_STR);
			$command->bindValue(":P_BANK_CD", $this->rdi_bank_cd, PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID", $this->user_id, PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS", $this->ip_address, PDO::PARAM_STR);
			$command->bindParam(":P_ERROR_CODE", $this->error_code, PDO::PARAM_INT, 10);
			$command->bindParam(":P_ERROR_MSG", $this->error_msg, PDO::PARAM_STR, 1000);
			$command->execute();
		}
		catch(Exception $ex)
		{
			if ($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}

		if ($this->error_code < 0)
			$this->addError('error_msg', 'Error ' . $this->error_code . ' ' . $this->error_msg);

		return $this->error_code;
	}

}
