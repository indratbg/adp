<?php

/**
 * This is the model class for table "T_DEPOSIT".
 *
 * The followings are the available columns in table 'T_DEPOSIT':
 * @property string $bank_cd
 * @property string $bank_type
 * @property string $bank_branch
 * @property string $from_dt
 * @property string $to_dt
 * @property double $amount
 * @property integer $jaminan_lps
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $ref_num
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Tdeposit extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $from_dt_date;
	public $from_dt_month;
	public $from_dt_year;

	public $to_dt_date;
	public $to_dt_month;
	public $to_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
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
		return 'T_DEPOSIT';
	}
	
	public function executeSp($exec_status,$old_seqno)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_T_DEPOSIT_UPD(
						:P_SEARCH_SEQNO,
						:P_BANK_CD,
						:P_BANK_TYPE,
						:P_BANK_BRANCH,
						TO_DATE(:P_FROM_DT,'YYYY-MM-DD'),
						TO_DATE(:P_TO_DT,'YYYY-MM-DD'),
						:P_AMOUNT,
						:P_JAMINAN_LPS,
						:P_USER_ID,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,
						:P_REF_NUM,
						:P_SEQNO,
						:P_UPD_STATUS,
						:p_ip_address,
						:p_cancel_reason,
						:p_error_code,
						:p_error_msg)";
			
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_SEQNO",$old_seqno,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_CD",$this->bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_TYPE",$this->bank_type,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_BRANCH",$this->bank_branch,PDO::PARAM_STR);
			$command->bindValue(":P_FROM_DT",$this->from_dt,PDO::PARAM_STR);
			$command->bindValue(":P_TO_DT",$this->to_dt,PDO::PARAM_STR);
			$command->bindValue(":P_AMOUNT",$this->amount,PDO::PARAM_STR);
			$command->bindValue(":P_JAMINAN_LPS",$this->jaminan_lps,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_REF_NUM",$this->ref_num,PDO::PARAM_STR);
			$command->bindValue(":P_SEQNO",$this->seqno,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
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
		
			array('from_dt, to_dt, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('amount, jaminan_lps', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('ref_num, bank_cd, bank_type, bank_branch, from_dt, to_dt, amount', 'required'),
			array('jaminan_lps', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('bank_cd', 'length', 'max'=>3),
			array('bank_type, approved_stat', 'length', 'max'=>1),
			array('bank_branch', 'length', 'max'=>30),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('ref_num', 'length', 'max'=>25),
			array('to_dt, cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('bank_cd, bank_type, bank_branch, from_dt, to_dt, amount, jaminan_lps, user_id, cre_dt, upd_dt, upd_by, ref_num, approved_dt, approved_by, approved_stat,from_dt_date,from_dt_month,from_dt_year,to_dt_date,to_dt_month,to_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'bank_type' => 'Bank Type',
			'bank_branch' => 'Bank Branch',
			'from_dt' => 'From Date',
			'to_dt' => 'To Date',
			'amount' => 'Amount',
			'jaminan_lps' => 'Jaminan Lps',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'ref_num' => 'Ref No.',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('bank_cd',$this->bank_cd,true);
		$criteria->compare('bank_type',$this->bank_type,true);
		$criteria->compare('bank_branch',$this->bank_branch,true);

		if(!empty($this->from_dt_date))
			$criteria->addCondition("TO_CHAR(t.from_dt,'DD') LIKE '%".$this->from_dt_date."%'");
		if(!empty($this->from_dt_month))
			$criteria->addCondition("TO_CHAR(t.from_dt,'MM') LIKE '%".$this->from_dt_month."%'");
		if(!empty($this->from_dt_year))
			$criteria->addCondition("TO_CHAR(t.from_dt,'YYYY') LIKE '%".$this->from_dt_year."%'");
		if(!empty($this->to_dt_date))
			$criteria->addCondition("TO_CHAR(t.to_dt,'DD') LIKE '%".$this->to_dt_date."%'");
		if(!empty($this->to_dt_month))
			$criteria->addCondition("TO_CHAR(t.to_dt,'MM') LIKE '%".$this->to_dt_month."%'");
		if(!empty($this->to_dt_year))
			$criteria->addCondition("TO_CHAR(t.to_dt,'YYYY') LIKE '%".$this->to_dt_year."%'");		$criteria->compare('amount',$this->amount);
		$criteria->compare('jaminan_lps',$this->jaminan_lps);
		$criteria->compare('user_id',$this->user_id,true);

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
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('upd_by',$this->upd_by,true);
		$criteria->compare('ref_num',$this->ref_num,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}