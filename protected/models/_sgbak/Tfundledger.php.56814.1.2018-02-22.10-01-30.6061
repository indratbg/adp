<?php

/**
 * This is the model class for table "T_FUND_LEDGER".
 *
 * The followings are the available columns in table 'T_FUND_LEDGER':
 * @property string $doc_num
 * @property integer $seqno
 * @property string $trx_type
 * @property string $doc_date
 * @property string $acct_cd
 * @property string $client_cd
 * @property double $debit
 * @property double $credit
 * @property string $cre_dt
 * @property string $user_id
 * @property string $approved_dt
 * @property string $approved_sts
 * @property string $approved_by
 * @property string $cancel_dt
 * @property string $cancel_by
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $manual
 */
class Tfundledger extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $doc_date_date;
	public $doc_date_month;
	public $doc_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;

	public $cancel_dt_date;
	public $cancel_dt_month;
	public $cancel_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
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
		return 'T_FUND_LEDGER';
	}

	public function rules()
	{
		return array(
		
			array('doc_date, approved_dt, cancel_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('seqno, debit, credit', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('acct_cd, client_cd', 'required'),
			array('debit, credit', 'numerical'),
			array('trx_type, approved_sts, manual', 'length', 'max'=>1),
			array('acct_cd', 'length', 'max'=>8),
			array('client_cd', 'length', 'max'=>12),
			array('user_id, approved_by, cancel_by, upd_by', 'length', 'max'=>10),
			array('doc_date, cre_dt, approved_dt, cancel_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('doc_num, seqno, trx_type, doc_date, acct_cd, client_cd, debit, credit, cre_dt, user_id, approved_dt, approved_sts, approved_by, cancel_dt, cancel_by, upd_dt, upd_by, manual,doc_date_date,doc_date_month,doc_date_year,cre_dt_date,cre_dt_month,cre_dt_year,approved_dt_date,approved_dt_month,approved_dt_year,cancel_dt_date,cancel_dt_month,cancel_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'doc_num' => 'Doc Num',
			'seqno' => 'Seqno',
			'trx_type' => 'Trx Type',
			'doc_date' => 'Doc Date',
			'acct_cd' => 'Acct Code',
			'client_cd' => 'Client Code',
			'debit' => 'Debit',
			'credit' => 'Credit',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'approved_dt' => 'Approved Date',
			'approved_sts' => 'Approved Sts',
			'approved_by' => 'Approved By',
			'cancel_dt' => 'Cancel Date',
			'cancel_by' => 'Cancel By',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'manual' => 'Manual',
		);
	}


	public function executeSp($exec_status,$old_doc_num,$old_seqno,$update_date,$update_seq,$record_seq)
	{ 
		$connection  = Yii::app()->db;
				
		try{
			$query  = "CALL Sp_T_FUND_LEDGER_UPD(:P_SEARCH_DOC_NUM,
												:P_SEARCH_SEQNO,
												:P_DOC_NUM,
												:P_SEQNO,
												:P_TRX_TYPE,
												TO_DATE(:P_DOC_DATE,'YYYY-MM-DD'),
												:P_ACCT_CD,
												:P_CLIENT_CD,
												:P_DEBIT,
												:P_CREDIT,
												TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
												:P_USER_ID,
												TO_DATE(:P_CANCEL_DT,'YYYY-MM-DD HH24:MI:SS'),
												:P_CANCEL_BY,
												TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
												:P_UPD_BY,
												:P_MANUAL,
												:P_UPD_STATUS,
												:p_ip_address,
												:p_cancel_reason,
												TO_DATE(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),
												:p_update_seq,
												:p_record_seq,
												:p_error_code,
												:p_error_msg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_DOC_NUM",$old_doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_SEQNO",$old_seqno,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_NUM",$this->doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_SEQNO",$this->seqno,PDO::PARAM_STR);
			$command->bindValue(":P_TRX_TYPE",$this->trx_type,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_DATE",$this->doc_date,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_CD",$this->acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_DEBIT",$this->debit,PDO::PARAM_STR);
			$command->bindValue(":P_CREDIT",$this->credit,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_DT",$this->cancel_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_BY",$this->cancel_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_MANUAL",$this->manual,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);								
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$update_seq,PDO::PARAM_STR);
			$command->bindValue(":p_record_seq",$record_seq,PDO::PARAM_STR);	
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

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('doc_num',$this->doc_num,true);
		$criteria->compare('seqno',$this->seqno);
		$criteria->compare('trx_type',$this->trx_type,true);

		if(!empty($this->doc_date_date))
			$criteria->addCondition("TO_CHAR(t.doc_date,'DD') LIKE '%".$this->doc_date_date."%'");
		if(!empty($this->doc_date_month))
			$criteria->addCondition("TO_CHAR(t.doc_date,'MM') LIKE '%".$this->doc_date_month."%'");
		if(!empty($this->doc_date_year))
			$criteria->addCondition("TO_CHAR(t.doc_date,'YYYY') LIKE '%".$this->doc_date_year."%'");		$criteria->compare('acct_cd',$this->acct_cd,true);
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('debit',$this->debit);
		$criteria->compare('credit',$this->credit);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_sts',$this->approved_sts,true);
		$criteria->compare('approved_by',$this->approved_by,true);

		if(!empty($this->cancel_dt_date))
			$criteria->addCondition("TO_CHAR(t.cancel_dt,'DD') LIKE '%".$this->cancel_dt_date."%'");
		if(!empty($this->cancel_dt_month))
			$criteria->addCondition("TO_CHAR(t.cancel_dt,'MM') LIKE '%".$this->cancel_dt_month."%'");
		if(!empty($this->cancel_dt_year))
			$criteria->addCondition("TO_CHAR(t.cancel_dt,'YYYY') LIKE '%".$this->cancel_dt_year."%'");		$criteria->compare('cancel_by',$this->cancel_by,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('upd_by',$this->upd_by,true);
		$criteria->compare('manual',$this->manual,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}