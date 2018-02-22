<?php

/**
 * This is the model class for table "T_FUND_TRF".
 *
 * The followings are the available columns in table 'T_FUND_TRF':
 * @property string $trf_date
 * @property string $trf_id
 * @property string $doc_num
 * @property string $fund_bank_cd
 * @property string $client_cd
 * @property string $trf_type
 * @property string $trf_flg
 * @property string $trf_timestamp
 * @property double $trf_amt
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $user_id
 */
class Tfundtrf extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $trf_date_date;
	public $trf_date_month;
	public $trf_date_year;

	public $trf_timestamp_date;
	public $trf_timestamp_month;
	public $trf_timestamp_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

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
		return 'T_FUND_TRF';
	}

	public function rules()
	{
		return array(
		
			array('trf_date, trf_timestamp', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('trf_amt', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('trf_date, trf_id, doc_num', 'required'),
			array('trf_amt', 'numerical'),
			array('trf_id', 'length', 'max'=>8),
			array('doc_num', 'length', 'max'=>17),
			array('fund_bank_cd', 'length', 'max'=>5),
			array('client_cd', 'length', 'max'=>12),
			array('trf_type', 'length', 'max'=>4),
			array('trf_flg', 'length', 'max'=>1),
			array('user_id', 'length', 'max'=>10),
			array('trf_timestamp, cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('trf_date, trf_id, doc_num, fund_bank_cd, client_cd, trf_type, trf_flg, trf_timestamp, trf_amt, cre_dt, upd_dt, user_id,trf_date_date,trf_date_month,trf_date_year,trf_timestamp_date,trf_timestamp_month,trf_timestamp_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'trf_date' => 'Trf Date',
			'trf_id' => 'Trf',
			'doc_num' => 'Doc Num',
			'fund_bank_cd' => 'Fund Bank Code',
			'client_cd' => 'Client Code',
			'trf_type' => 'Trf Type',
			'trf_flg' => 'Trf Flg',
			'trf_timestamp' => 'Trf Timestamp',
			'trf_amt' => 'Trf Amt',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'user_id' => 'User',
		);
	}

public function executeSp($exec_status,$old_trf_date,$old_trf_id,$old_doc_num,$record_seq)
	{ 
		$connection  = Yii::app()->db;
				
		try{
			$query  = "CALL Sp_T_FUND_TRF_UPD_INBOX(TO_DATE(:P_SEARCH_TRF_DATE,'YYYY-MM-DD'),
													:P_SEARCH_TRF_ID,
													:P_SEARCH_DOC_NUM,
													TO_DATE(:P_TRF_DATE,'YYYY-MM-DD'),
													:P_TRF_ID,
													:P_DOC_NUM,
													:P_FUND_BANK_CD,
													:P_CLIENT_CD,
													:P_TRF_TYPE,
													:P_TRF_FLG,
													TO_DATE(:P_TRF_TIMESTAMP,'YYYY-MM-DD HH24:MI:SS'),
													:P_TRF_AMT,
													TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
													TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
													:P_USER_ID,
													:P_UPD_STATUS,
													:p_ip_address,
													:p_cancel_reason,
													to_date(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),
													:p_update_seq,
													:p_record_seq,
													:p_error_code,
													:p_error_msg)";
			
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_TRF_DATE",$old_trf_date,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_TRF_ID",$old_trf_id,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_DOC_NUM",$old_doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_TRF_DATE",$this->trf_date,PDO::PARAM_STR);
			$command->bindValue(":P_TRF_ID",$this->trf_id,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_NUM",$this->doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_FUND_BANK_CD",$this->fund_bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_TRF_TYPE",$this->trf_type,PDO::PARAM_STR);
			$command->bindValue(":P_TRF_FLG",$this->trf_flg,PDO::PARAM_STR);
			$command->bindValue(":P_TRF_TIMESTAMP",$this->trf_timestamp,PDO::PARAM_STR);
			$command->bindValue(":P_TRF_AMT",$this->trf_amt,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);								
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_RECORD_SEQ",$record_seq,PDO::PARAM_STR);	
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

	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->trf_date_date))
			$criteria->addCondition("TO_CHAR(t.trf_date,'DD') LIKE '%".$this->trf_date_date."%'");
		if(!empty($this->trf_date_month))
			$criteria->addCondition("TO_CHAR(t.trf_date,'MM') LIKE '%".$this->trf_date_month."%'");
		if(!empty($this->trf_date_year))
			$criteria->addCondition("TO_CHAR(t.trf_date,'YYYY') LIKE '%".$this->trf_date_year."%'");		$criteria->compare('trf_id',$this->trf_id,true);
		$criteria->compare('doc_num',$this->doc_num,true);
		$criteria->compare('fund_bank_cd',$this->fund_bank_cd,true);
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('trf_type',$this->trf_type,true);
		$criteria->compare('trf_flg',$this->trf_flg,true);

		if(!empty($this->trf_timestamp_date))
			$criteria->addCondition("TO_CHAR(t.trf_timestamp,'DD') LIKE '%".$this->trf_timestamp_date."%'");
		if(!empty($this->trf_timestamp_month))
			$criteria->addCondition("TO_CHAR(t.trf_timestamp,'MM') LIKE '%".$this->trf_timestamp_month."%'");
		if(!empty($this->trf_timestamp_year))
			$criteria->addCondition("TO_CHAR(t.trf_timestamp,'YYYY') LIKE '%".$this->trf_timestamp_year."%'");		$criteria->compare('trf_amt',$this->trf_amt);

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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}