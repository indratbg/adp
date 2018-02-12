<?php

/**
 * This is the model class for table "MST_CLIENT_BANK".
 *
 * The followings are the available columns in table 'MST_CLIENT_BANK':
 * @property string $client_cd
 * @property string $bank_cd
 * @property string $bank_brch_cd
 * @property string $bank_acct_num
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $user_id
 * @property string $acct_name
 * @property string $default_flg
 * @property string $cifs
 * @property string $bank_branch
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Clientbank extends AActiveRecordSP
{
	//public $default = FALSE;	
		
	//AH: because updating primary key
	public $old_bank_acct_num;	
	public $old_bank_cd;
	public $old_bank_branch;
	public $old_bank_phone_num;
	public $old_acct_name;
	public $old_bank_acct_type;
	public $old_bank_acct_currency;
	
	public $cancel_flg = 'N';
	public $save_flg = 'N';
	
	public $rowid;
	
	//AH: #BEGIN search (datetime || date) additional comparison
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
		return 'MST_CLIENT_BANK';
	}

	public function primaryKey()
	{
		return 'bank_cd';
	}
	
	public function executeSp($exec_status,$old_cif,$update_date,$update_seq,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_MST_CLIENT_BANK_UPD(
						:P_SEARCH_CIFS,
						:P_SEARCH_BANK_ACCT_NUM,
						:P_CLIENT_CD,
						:P_BANK_CD,
						:P_BANK_BRCH_CD,
						:P_BANK_ACCT_NUM,	
						:P_ACCT_NAME,
						:P_DEFAULT_FLG,
						:P_CIFS,
						:P_BANK_BRANCH,						
						:P_BANK_ACCT_TYPE,
						:P_BANK_PHONE_NUM,
						:P_BANK_ACCT_CURRENCY,
						:P_CRE_DT,
						:P_USER_ID,
						:P_UPD_DT,
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
			$command->bindValue(":P_SEARCH_CIFS",$old_cif,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_BANK_ACCT_NUM",$this->old_bank_acct_num,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_CD",$this->bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_BRCH_CD",$this->bank_brch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_ACCT_NUM",$this->bank_acct_num,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_NAME",$this->acct_name,PDO::PARAM_STR);
			$command->bindValue(":P_DEFAULT_FLG",$this->default_flg,PDO::PARAM_STR);
			$command->bindValue(":P_CIFS",$this->cifs,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_BRANCH",$this->bank_branch,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_ACCT_TYPE",$this->bank_acct_type,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_PHONE_NUM",$this->bank_phone_num,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_ACCT_CURRENCY",$this->bank_acct_currency,PDO::PARAM_STR);	
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
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
		
			array('approved_dt', 'application.components.validator.ADatePickerSwitcherValidator'),
			
			array('bank_cd, bank_acct_num, acct_name', 'required'),
			array('bank_branch','required','on'=>'insert'),
			
			array('client_cd', 'length', 'max'=>12),
			array('bank_cd, bank_brch_cd', 'length', 'max'=>6),
			array('bank_acct_num', 'length', 'max'=>20),
			array('user_id, cifs', 'length', 'max'=>8),
			array('acct_name', 'length', 'max'=>50),
			array('bank_acct_type', 'length', 'max'=>30),
			array('bank_phone_num', 'length', 'max'=>15),
			array('bank_acct_currency', 'length', 'max'=>3),
			array('default_flg, approved_stat', 'length', 'max'=>1),
			array('bank_branch', 'length', 'max'=>40),
			array('upd_by, approved_by', 'length', 'max'=>10),
			array('save_flg, cancel_flg, old_bank_acct_num, old_bank_cd, old_bank_branch, old_bank_phone_num, old_acct_name, old_bank_acct_type, old_bank_acct_currency, cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, bank_cd, bank_brch_cd, bank_acct_num, cre_dt, upd_dt, user_id, acct_name, default_flg, cifs, bank_branch, upd_by, approved_dt, approved_by, approved_stat,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}
	
	/*
	 *  AH: this function is for executing procedure
	 *  exec_status  : I/U/C
	 */

/*
	public function executeSp($exec_status)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_MST_CLIENT_BANK_UPD(
						:P_SEARCH_CIFS,:P_SEARCH_BANK_ACCT_NUM,:P_CLIENT_CD,
						:P_BANK_CD,:P_BANK_ACCT_NUM,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,:P_ACCT_NAME,:P_DEFAULT_FLG,
						:P_CIFS,:P_BANK_BRANCH,:P_UPD_BY,
						:P_UPD_STATUS,:P_IP_ADDRESS,:P_CANCEL_REASON,
						:P_ERROR_CODE,:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_SEARCH_CIFS",$this->cifs,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_BANK_ACCT_NUM",$this->old_bank_acct_num,PDO::PARAM_STR);
			
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_CD",$this->bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_BRCH_CD",$this->bank_brch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_ACCT_NUM",$this->bank_acct_num,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_NAME",$this->acct_name,PDO::PARAM_STR);
			$command->bindValue(":P_DEFAULT_FLG",$this->default_flg,PDO::PARAM_STR);
			$command->bindValue(":P_CIFS",$this->cifs,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_BRANCH",$this->bank_branch,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_APPROVED_DT",$this->approved_dt,PDO::PARAM_STR);
			$command->bindValue(":P_APPROVED_BY",$this->approved_by,PDO::PARAM_STR);
			$command->bindValue(":P_APPROVED_STS",$this->approved_stat,PDO::PARAM_STR);
			
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,100);

			$command->execute();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->error_code == -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}
*/

	public function relations()
	{
		return array(
			'client' => array(self::BELONGS_TO, 'Client', array('cifs'=>'cifs')),
		);
	}
	
	public function getBank_Name()
	{
		//return Parameter::getParamDesc('BANKCD',$this->bank_cd);
		$bank_name = Ipbank::model()->find("bank_cd='$this->bank_cd' "); 
		return $bank_name?$bank_name->bank_name:'';
	}

	public function attributeLabels()
	{
		return array(
			
			// [AH] Change label
			'bank_cd' => 'Bank',
			'bank_acct_num' => 'Account Number',
			'default_flg'=>'Default',
			'bank_branch' => 'Branch',
			'acct_name' => 'Account Name',
			
			'client_cd' => 'Client Code',
			'bank_brch_cd' => 'Bank Brch Code',
			
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'user_id' => 'User',
			'cifs' => 'Cifs',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		
		$criteria->compare('client_cd',$this->client_cd);
		$criteria->compare('bank_cd',$this->bank_cd);
		$criteria->compare('bank_brch_cd',$this->bank_brch_cd);
		$criteria->compare('bank_acct_num',$this->bank_acct_num,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".($this->cre_dt_date)."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".($this->cre_dt_month)."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".($this->cre_dt_year)."%'");
		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".($this->upd_dt_date)."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".($this->upd_dt_month)."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".($this->upd_dt_year)."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('acct_name',$this->acct_name,true);
		$criteria->compare('default_flg',$this->default_flg,true);
		$criteria->compare('cifs',$this->cifs,true);
		$criteria->compare('bank_branch',$this->bank_branch,true);
		$criteria->compare('upd_by',$this->upd_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".($this->approved_dt_date)."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".($this->approved_dt_month)."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".($this->approved_dt_year)."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}