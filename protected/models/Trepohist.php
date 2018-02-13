<?php

/**
 * This is the model class for table "IPNEXTG.T_REPO_HIST".
 *
 * The followings are the available columns in table 'IPNEXTG.T_REPO_HIST':
 * @property string $repo_num
 * @property string $repo_date
 * @property string $repo_type
 * @property string $due_date
 * @property string $repo_ref
 * @property double $repo_val
 * @property double $return_val
 * @property double $interest_rate
 * @property double $interest_tax
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $user_id
 */
class Trepohist extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $repo_date_date;
	public $repo_date_month;
	public $repo_date_year;

	public $due_date_date;
	public $due_date_month;
	public $due_date_year;

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
		return 'IPNEXTG.T_REPO_HIST';
	}
	
	public function executeSp($exec_status,$old_repo_num,$old_repo_date,$update_date,$update_seq,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_T_REPO_HIST_UPD(
						:P_SEARCH_REPO_NUM,
						TO_DATE(:P_SEARCH_REPO_DATE,'YYYY-MM-DD'),
						:P_REPO_NUM,
						TO_DATE(:P_REPO_DATE,'YYYY-MM-DD'),
						:P_REPO_TYPE,
						TO_DATE(:P_DUE_DATE,'YYYY-MM-DD'),
						:P_REPO_REF,
						:P_REPO_VAL,
						:P_RETURN_VAL,
						:P_INTEREST_RATE,
						:P_INTEREST_TAX,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						:P_UPD_BY,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPDATE_SEQ,
						:P_RECORD_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
		
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_REPO_NUM",$old_repo_num,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_REPO_DATE",$old_repo_date,PDO::PARAM_STR);
			$command->bindValue(":P_REPO_NUM",$this->repo_num,PDO::PARAM_STR);
			$command->bindValue(":P_REPO_DATE",$this->repo_date,PDO::PARAM_STR);
			$command->bindValue(":P_REPO_TYPE",$this->repo_type,PDO::PARAM_STR);
			$command->bindValue(":P_DUE_DATE",$this->due_date,PDO::PARAM_STR);
			$command->bindValue(":P_REPO_REF",$this->repo_ref,PDO::PARAM_STR);
			$command->bindValue(":P_REPO_VAL",$this->repo_val,PDO::PARAM_STR);
			$command->bindValue(":P_RETURN_VAL",$this->return_val,PDO::PARAM_STR);
			$command->bindValue(":P_INTEREST_RATE",$this->interest_rate,PDO::PARAM_STR);
			$command->bindValue(":P_INTEREST_TAX",$this->interest_tax,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);								
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$update_seq,PDO::PARAM_STR);
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

	public function rules()
	{
		return array(
		
			array('repo_date, due_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('repo_val, return_val, interest_rate, interest_tax', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('repo_date,due_date,repo_ref,repo_val,return_val,interest_rate,interest_tax','required'),
			array('repo_val, return_val, interest_rate, interest_tax', 'numerical'),
			array('repo_type, user_id', 'length', 'max'=>10),
			array('repo_ref', 'length', 'max'=>30),
			array('due_date, cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('repo_num, repo_date, repo_type, due_date, repo_ref, repo_val, return_val, interest_rate, interest_tax, cre_dt, upd_dt, user_id,repo_date_date,repo_date_month,repo_date_year,due_date_date,due_date_month,due_date_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'repo_num' => 'Repo Num',
			'repo_date' => 'Repo Date',
			'repo_type' => 'Repo Type',
			'due_date' => 'Due Date',
			'repo_ref' => 'Repo Ref',
			'repo_val' => 'Repo Val',
			'return_val' => 'Return Val',
			'interest_rate' => 'Interest Rate',
			'interest_tax' => 'Interest Tax',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'user_id' => 'User',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('repo_num',$this->repo_num,true);

		if(!empty($this->repo_date_date))
			$criteria->addCondition("TO_CHAR(t.repo_date,'DD') LIKE '%".$this->repo_date_date."%'");
		if(!empty($this->repo_date_month))
			$criteria->addCondition("TO_CHAR(t.repo_date,'MM') LIKE '%".$this->repo_date_month."%'");
		if(!empty($this->repo_date_year))
			$criteria->addCondition("TO_CHAR(t.repo_date,'YYYY') LIKE '%".$this->repo_date_year."%'");		$criteria->compare('repo_type',$this->repo_type,true);

		if(!empty($this->due_date_date))
			$criteria->addCondition("TO_CHAR(t.due_date,'DD') LIKE '%".$this->due_date_date."%'");
		if(!empty($this->due_date_month))
			$criteria->addCondition("TO_CHAR(t.due_date,'MM') LIKE '%".$this->due_date_month."%'");
		if(!empty($this->due_date_year))
			$criteria->addCondition("TO_CHAR(t.due_date,'YYYY') LIKE '%".$this->due_date_year."%'");		$criteria->compare('repo_ref',$this->repo_ref,true);
		$criteria->compare('repo_val',$this->repo_val);
		$criteria->compare('return_val',$this->return_val);
		$criteria->compare('interest_rate',$this->interest_rate);
		$criteria->compare('interest_tax',$this->interest_tax);

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