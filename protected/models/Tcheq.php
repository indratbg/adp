<?php

/**
 * This is the model class for table "T_CHEQ".
 *
 * The followings are the available columns in table 'T_CHEQ':
 * @property string $bank_cd
 * @property string $sl_acct_cd
 * @property string $bg_cq_flg
 * @property string $chq_num
 * @property string $chq_dt
 * @property double $chq_amt
 * @property string $rvpv_number
 * @property string $chq_stat
 * @property string $payee_bank_cd
 * @property string $payee_acct_num
 * @property double $deduct_fee
 * @property string $print_flg
 * @property string $pr_trf_flg
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $user_id
 * @property string $upd_user_id
 * @property integer $seqno
 * @property string $payee_name
 */
class Tcheq extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $chq_dt_date;
	public $chq_dt_month;
	public $chq_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
	
	//AH: #END search (datetime || date)  additional comparison
	
	public $cancel_flg = 'N';
	public $save_flg = 'N';
	
	public $rowid;
	
	public $check;
	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    

	public function tableName()
	{
		return 'T_CHEQ';
	}
	
	public function executeSp($exec_status,$old_rvpv_number,$old_chq_seq,$old_chq_num,$update_date,$update_seq,$record_seq)
	{
		$connection  = Yii::app()->db;
				
		try{
			$query  = "CALL SP_T_CHEQ_UPD(
						:P_SEARCH_RVPV_NUMBER,
						:P_SEARCH_CHQ_SEQ,
						:P_SEARCH_CHQ_NUM,
						:P_BANK_CD,
						:P_SL_ACCT_CD,
						:P_BG_CQ_FLG,
						:P_CHQ_NUM,
						TO_DATE(:P_CHQ_DT,'YYYY-MM-DD'),
						:P_CHQ_AMT,
						:P_RVPV_NUMBER,
						:P_CHQ_STAT,
						:P_PAYEE_BANK_CD,
						:P_PAYEE_ACCT_NUM,
						:P_DEDUCT_FEE,
						:P_PRINT_FLG,
						:P_PR_TRF_FLG,						
						:P_UPD_USER_ID,
						:P_SEQNO,
						:P_PAYEE_NAME,
						:P_DESCRIP,
						:P_CHQ_SEQ,	
						:P_USER_ID,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),				
						:P_UPD_STATUS,
						:p_ip_address,
						:p_cancel_reason,
						TO_DATE(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),
						:p_update_seq,
						:p_record_seq,
						:p_error_code,
						:p_error_msg	)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_RVPV_NUMBER",$old_rvpv_number,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_CHQ_SEQ",$old_chq_seq,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_CHQ_NUM",$old_chq_num,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_CD",$this->bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SL_ACCT_CD",$this->sl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BG_CQ_FLG",$this->bg_cq_flg,PDO::PARAM_STR);
			$command->bindValue(":P_CHQ_NUM",$this->chq_num,PDO::PARAM_STR);
			$command->bindValue(":P_CHQ_DT",$this->chq_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CHQ_AMT",$this->chq_amt,PDO::PARAM_STR);
			$command->bindValue(":P_RVPV_NUMBER",$this->rvpv_number,PDO::PARAM_STR);
			$command->bindValue(":P_CHQ_STAT",$this->chq_stat,PDO::PARAM_STR);
			$command->bindValue(":P_PAYEE_BANK_CD",$this->payee_bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_PAYEE_ACCT_NUM",$this->payee_acct_num,PDO::PARAM_STR);
			$command->bindValue(":P_DEDUCT_FEE",$this->deduct_fee,PDO::PARAM_STR);
			$command->bindValue(":P_PRINT_FLG",$this->print_flg,PDO::PARAM_STR);
			$command->bindValue(":P_PR_TRF_FLG",$this->pr_trf_flg,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_USER_ID",$this->upd_user_id,PDO::PARAM_STR);
			$command->bindValue(":P_SEQNO",$this->seqno,PDO::PARAM_STR);
			$command->bindValue(":P_PAYEE_NAME",$this->payee_name,PDO::PARAM_STR);
			$command->bindValue(":P_DESCRIP",$this->descrip,PDO::PARAM_STR);
			$command->bindValue(":P_CHQ_SEQ",$this->chq_seq,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);								
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_RECORD_SEQ",$record_seq,PDO::PARAM_STR);	
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			
			//Commit baru akan dijalankan saat semua transaksi INSERT sukses
			
		}catch(Exception $ex){
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

	public function rules()
	{
		return array(
		
			array('chq_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('chq_amt, deduct_fee, seqno', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('bank_cd, sl_acct_cd, chq_num, chq_amt, bg_cq_flg, deduct_fee', 'required'),
			array('seqno', 'numerical', 'integerOnly'=>true),
			array('chq_amt, deduct_fee', 'numerical'),
			array('bank_cd, payee_bank_cd', 'length', 'max'=>3),
			array('sl_acct_cd', 'length', 'max'=>12),
			array('bg_cq_flg', 'length', 'max'=>2),
			array('chq_num, payee_acct_num', 'length', 'max'=>20),
			array('rvpv_number', 'length', 'max'=>17),
			array('chq_stat, print_flg, pr_trf_flg', 'length', 'max'=>1),
			array('user_id, upd_user_id', 'length', 'max'=>10),
			array('payee_name', 'length', 'max'=>50),
			array('save_flg, cancel_flg, rowid, descrip, chq_dt, cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('bank_cd, sl_acct_cd, bg_cq_flg, chq_num, chq_dt, chq_amt, rvpv_number, chq_stat, payee_bank_cd, payee_acct_num, deduct_fee, print_flg, pr_trf_flg, cre_dt, upd_dt, user_id, upd_user_id, seqno, payee_name,chq_dt_date,chq_dt_month,chq_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'bank_cd' => 'Bank Code',
			'sl_acct_cd' => 'Sl Acct Code',
			'bg_cq_flg' => 'Cheque Type',
			'chq_num' => 'Cheque Number',
			'chq_dt' => 'Chq Date',
			'chq_amt' => 'Chq Amt',
			'rvpv_number' => 'Rvpv Number',
			'chq_stat' => 'Chq Stat',
			'payee_bank_cd' => 'Payee Bank Code',
			'payee_acct_num' => 'Payee Acct Num',
			'deduct_fee' => 'Deduct Fee',
			'print_flg' => 'Print Flg',
			'pr_trf_flg' => 'Pr Trf Flg',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'user_id' => 'User',
			'upd_user_id' => 'Upd User',
			'seqno' => 'Seqno',
			'payee_name' => 'Payee Name',
			'descrip' => 'Description',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('bank_cd',$this->bank_cd,true);
		$criteria->compare('sl_acct_cd',$this->sl_acct_cd,true);
		$criteria->compare('bg_cq_flg',$this->bg_cq_flg,true);
		$criteria->compare('chq_num',$this->chq_num,true);

		if(!empty($this->chq_dt_date))
			$criteria->addCondition("TO_CHAR(t.chq_dt,'DD') LIKE '%".$this->chq_dt_date."%'");
		if(!empty($this->chq_dt_month))
			$criteria->addCondition("TO_CHAR(t.chq_dt,'MM') LIKE '%".$this->chq_dt_month."%'");
		if(!empty($this->chq_dt_year))
			$criteria->addCondition("TO_CHAR(t.chq_dt,'YYYY') LIKE '%".$this->chq_dt_year."%'");		$criteria->compare('chq_amt',$this->chq_amt);
		$criteria->compare('rvpv_number',$this->rvpv_number,true);
		$criteria->compare('chq_stat',$this->chq_stat,true);
		$criteria->compare('payee_bank_cd',$this->payee_bank_cd,true);
		$criteria->compare('payee_acct_num',$this->payee_acct_num,true);
		$criteria->compare('deduct_fee',$this->deduct_fee);
		$criteria->compare('print_flg',$this->print_flg,true);
		$criteria->compare('pr_trf_flg',$this->pr_trf_flg,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");
		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('upd_user_id',$this->upd_user_id,true);
		$criteria->compare('seqno',$this->seqno);
		$criteria->compare('payee_name',$this->payee_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}