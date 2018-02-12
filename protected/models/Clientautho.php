<?php

/**
 * This is the model class for table "MST_CLIENT_AUTHO".
 *
 * The followings are the available columns in table 'MST_CLIENT_AUTHO':
 * @property string $cifs
 * @property integer $seqno
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $position
 * @property string $npwp_no
 * @property string $npwp_date
 * @property string $ktp_no
 * @property string $ktp_expiry
 * @property string $passport_no
 * @property string $passport_expiry
 * @property string $kitas_no
 * @property string $kitas_expiry
 * @property string $cre_dt
 * @property string $cre_user_id
 * @property string $upd_dt
 * @property string $upd_user_id
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Clientautho extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $npwp_date_date;
	public $npwp_date_month;
	public $npwp_date_year;

	public $ktp_expiry_date;
	public $ktp_expiry_month;
	public $ktp_expiry_year;

	public $passport_expiry_date;
	public $passport_expiry_month;
	public $passport_expiry_year;

	public $kitas_expiry_date;
	public $kitas_expiry_month;
	public $kitas_expiry_year;

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
	
	public $old_seqno;
	public $old_ktp_expiry;
	public $old_passport_expiry;
	public $old_kitas_expiry;
	public $old_npwp_date;
	public $old_birth_dt;
	
	public $cancel_flg = 'N';
	public $save_flg = 'N';
	
	public $rowid;
	
	public $search_cifs;
	public $search_seqno;
	
	public $custodian = FALSE;
	
	/*
	protected function afterFind()
	{
		$this->ktp_expiry = Yii::app()->format->cleanDate($this->ktp_expiry);
		$this->npwp_date = Yii::app()->format->cleanDate($this->npwp_date);
		$this->passport_expiry = Yii::app()->format->cleanDate($this->passport_expiry);
		$this->kitas_expiry = Yii::app()->format->cleanDate($this->kitas_expiry);
	}*/
	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	public function getPrimaryKey()
	{
		return array('cifs'=>$this->cifs,'seqno'=>$this->seqno);
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    

	public function tableName()
	{
		return 'MST_CLIENT_AUTHO';
	}
	
	public function executeSp($exec_status,$old_cif,$update_date,$update_seq,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_MST_CLIENT_AUTHO_UPD(
						:P_SEARCH_CIFS,
						:P_SEARCH_SEQNO,
						:P_CIFS,
						:P_SEQNO,
						:P_FIRST_NAME,
						:P_MIDDLE_NAME,
						:P_LAST_NAME,
						:P_POSITION,
						:P_NPWP_NO,
						:P_NPWP_DATE,
						:P_KTP_NO,
						:P_KTP_EXPIRY,
						:P_PASSPORT_NO,
						:P_PASSPORT_EXPIRY,
						:P_KITAS_NO,
						:P_KITAS_EXPIRY,
						:P_BIRTH_DT,
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
			$command->bindValue(":P_SEARCH_SEQNO",$this->old_seqno,PDO::PARAM_STR);
			$command->bindValue(":P_CIFS",$this->cifs,PDO::PARAM_STR);
			$command->bindValue(":P_SEQNO",$this->seqno,PDO::PARAM_STR);
			$command->bindValue(":P_FIRST_NAME",$this->first_name,PDO::PARAM_STR);
			$command->bindValue(":P_MIDDLE_NAME",$this->middle_name,PDO::PARAM_STR);
			$command->bindValue(":P_LAST_NAME",$this->last_name,PDO::PARAM_STR);
			$command->bindValue(":P_POSITION",$this->position,PDO::PARAM_STR);
			$command->bindValue(":P_NPWP_NO",$this->npwp_no,PDO::PARAM_STR);
			$command->bindValue(":P_NPWP_DATE",$this->npwp_date,PDO::PARAM_STR);
			$command->bindValue(":P_KTP_NO",$this->ktp_no,PDO::PARAM_STR);
			$command->bindValue(":P_KTP_EXPIRY",$this->ktp_expiry,PDO::PARAM_STR);
			$command->bindValue(":P_PASSPORT_NO",$this->passport_no,PDO::PARAM_STR);
			$command->bindValue(":P_PASSPORT_EXPIRY",$this->passport_expiry,PDO::PARAM_STR);
			$command->bindValue(":P_KITAS_NO",$this->kitas_no,PDO::PARAM_STR);
			$command->bindValue(":P_KITAS_EXPIRY",$this->kitas_expiry,PDO::PARAM_STR);
			$command->bindValue(":P_BIRTH_DT",$this->birth_dt,PDO::PARAM_STR);
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
		
			array('npwp_date, ktp_expiry, passport_expiry, kitas_expiry, birth_dt, old_npwp_date, old_ktp_expiry, old_passport_expiry, old_kitas_expiry, old_birth_dt, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('seqno', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('seqno, first_name, position', 'required'),
			
			array('ktp_no','checkRequired'),
			array('ktp_expiry','checkNum'),
			
			array('seqno', 'numerical', 'integerOnly'=>true),
			array('cifs', 'length', 'max'=>8),
			array('first_name, middle_name, last_name, position', 'length', 'max'=>40),
			array('npwp_no, passport_no', 'length', 'max'=>20),
			array('ktp_no, kitas_no', 'length', 'max'=>30),
			array('cre_user_id, upd_user_id, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('save_flg, cancel_flg, old_seqno, old_ktp_expiry, old_passport_expiry, old_kitas_expiry, old_npwp_date, old_birth_dt, npwp_date, ktp_expiry, passport_expiry, kitas_expiry, birth_dt, cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('cifs, seqno, first_name, middle_name, last_name, position, npwp_no, npwp_date, ktp_no, ktp_expiry, passport_no, passport_expiry, kitas_no, kitas_expiry, cre_dt, cre_user_id, upd_user_id, approved_dt, approved_by, approved_stat,npwp_date_date,npwp_date_month,npwp_date_year,ktp_expiry_date,ktp_expiry_month,ktp_expiry_year,passport_expiry_date,passport_expiry_month,passport_expiry_year,kitas_expiry_date,kitas_expiry_month,kitas_expiry_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function checkRequired()
	{
		if($this->ktp_no == null && $this->passport_no == null && $this->npwp_no == null && $this->kitas_no == null && !$this->custodian)$this->addError('ktp_no', 'At least one of the following must be filled for each authorized person: KTP, PASSPORT, KITAS/SKD, NPWP');
	}

	public function checkNum()
	{
		if($this->ktp_no && !$this->ktp_expiry)$this->addError('ktp_expiry','KTP Expiry Date must be filled if KTP Number is filled');
		if($this->passport_no && !$this->passport_expiry)$this->addError('passport_expiry','Passport Expiry Date must be filled if Passport Number is filled');
		if($this->kitas_no && !$this->kitas_expiry)$this->addError('kitas_expiry','KITAS/SKD Expiry Date must be filled if KITAS/SKD Number is filled');
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'name'=>'Name',
			'cifs' => 'Cifs',
			'seqno' => 'No Urut',
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'last_name' => 'Last Name',
			'position' => 'Job Position',
			'npwp_no' => 'NPWP No',
			'npwp_date' => 'NPWP Date',
			'ktp_no' => 'KTP No',
			'ktp_expiry' => 'KTP Expiry Date',
			'passport_no' => 'Passport No',
			'passport_expiry' => 'Passport Expiry Date',
			'kitas_no' => 'KITAS No',
			'kitas_expiry' => 'KITAS Expiry Date',
			'birth_dt'	=> 'Birth Date',
			'cre_dt' => 'Cre Date',
			'cre_user_id' => 'Cre User',
			'upd_dt' => 'Upd Date',
			'upd_user_id' => 'Upd User',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('cifs',$this->cifs,true);
		$criteria->compare('seqno',$this->seqno);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('npwp_no',$this->npwp_no,true);

		if(!empty($this->npwp_date_date))
			$criteria->addCondition("TO_CHAR(t.npwp_date,'DD') LIKE '%".($this->npwp_date_date)."%'");
		if(!empty($this->npwp_date_month))
			$criteria->addCondition("TO_CHAR(t.npwp_date,'MM') LIKE '%".($this->npwp_date_month)."%'");
		if(!empty($this->npwp_date_year))
			$criteria->addCondition("TO_CHAR(t.npwp_date,'YYYY') LIKE '%".($this->npwp_date_year)."%'");		$criteria->compare('ktp_no',$this->ktp_no,true);

		if(!empty($this->ktp_expiry_date))
			$criteria->addCondition("TO_CHAR(t.ktp_expiry,'DD') LIKE '%".($this->ktp_expiry_date)."%'");
		if(!empty($this->ktp_expiry_month))
			$criteria->addCondition("TO_CHAR(t.ktp_expiry,'MM') LIKE '%".($this->ktp_expiry_month)."%'");
		if(!empty($this->ktp_expiry_year))
			$criteria->addCondition("TO_CHAR(t.ktp_expiry,'YYYY') LIKE '%".($this->ktp_expiry_year)."%'");		$criteria->compare('passport_no',$this->passport_no,true);

		if(!empty($this->passport_expiry_date))
			$criteria->addCondition("TO_CHAR(t.passport_expiry,'DD') LIKE '%".($this->passport_expiry_date)."%'");
		if(!empty($this->passport_expiry_month))
			$criteria->addCondition("TO_CHAR(t.passport_expiry,'MM') LIKE '%".($this->passport_expiry_month)."%'");
		if(!empty($this->passport_expiry_year))
			$criteria->addCondition("TO_CHAR(t.passport_expiry,'YYYY') LIKE '%".($this->passport_expiry_year)."%'");		$criteria->compare('kitas_no',$this->kitas_no,true);

		if(!empty($this->kitas_expiry_date))
			$criteria->addCondition("TO_CHAR(t.kitas_expiry,'DD') LIKE '%".($this->kitas_expiry_date)."%'");
		if(!empty($this->kitas_expiry_month))
			$criteria->addCondition("TO_CHAR(t.kitas_expiry,'MM') LIKE '%".($this->kitas_expiry_month)."%'");
		if(!empty($this->kitas_expiry_year))
			$criteria->addCondition("TO_CHAR(t.kitas_expiry,'YYYY') LIKE '%".($this->kitas_expiry_year)."%'");
		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".($this->cre_dt_date)."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".($this->cre_dt_month)."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".($this->cre_dt_year)."%'");		$criteria->compare('cre_user_id',$this->cre_user_id,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".($this->upd_dt_date)."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".($this->upd_dt_month)."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".($this->upd_dt_year)."%'");		$criteria->compare('upd_user_id',$this->upd_user_id,true);
		
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
/*	
	public function executeSp($exec_status)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL Sp_Mst_Client_autho_Upd(:P_SEARCH_CIFS,:P_SEARCH_SEQNO,:P_CIFS, 
						:P_SEQNO,:P_FIRST_NAME,:P_MIDDLE_NAME,:P_LAST_NAME,
						:P_POSITION,:P_NPWP_NO,TO_DATE(:P_NPWP_DATE,'YYYY-MM-DD'),:P_KTP_NO,
						TO_DATE(:P_KTP_EXPIRY,'YYYY-MM-DD'),:P_PASSPORT_NO,
						TO_DATE(:P_PASSPORT_EXPIRY,'YYYY-MM-DD'),:P_KITAS_NO,
						TO_DATE(:P_KITAS_EXPIRY,'YYYY-MM-DD'),
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),:P_CRE_USER_ID,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),:P_UPD_USER_ID,
						:P_UPD_STATUS,:P_IP_ADDRESS,:P_CANCEL_REASON,:P_ERROR_CODE,:P_ERROR_MSG)";

			$command = $connection->createCommand($query);
			
			//$this->bank_acct_fmt = $this->bank_acct_num;
			//$this->bank_acct_num = str_replace('.','',$this->bank_acct_num);
			
			$command->bindValue(":P_SEARCH_CIFS",$this->search_cifs,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_SEQNO",$this->search_seqno,PDO::PARAM_STR);
			$command->bindValue(":P_CIFS",$this->cifs,PDO::PARAM_STR);
			$command->bindValue(":P_SEQNO",$this->seqno,PDO::PARAM_STR);
			$command->bindValue(":P_FIRST_NAME",$this->first_name,PDO::PARAM_STR);
			$command->bindValue(":P_MIDDLE_NAME",$this->middle_name,PDO::PARAM_STR);
			$command->bindValue(":P_LAST_NAME",$this->last_name,PDO::PARAM_STR);
			$command->bindValue(":P_POSITION",$this->position,PDO::PARAM_STR);
			$command->bindValue(":P_NPWP_NO",$this->npwp_no,PDO::PARAM_STR);
			$command->bindValue(":P_NPWP_DATE",$this->npwp_date,PDO::PARAM_STR);
			$command->bindValue(":P_KTP_NO",$this->ktp_no,PDO::PARAM_STR);
			$command->bindValue(":P_KTP_EXPIRY",$this->ktp_expiry,PDO::PARAM_STR);
			$command->bindValue(":P_PASSPORT_NO",$this->passport_no,PDO::PARAM_STR);
			$command->bindValue(":P_PASSPORT_EXPIRY",$this->passport_expiry,PDO::PARAM_STR);
			$command->bindValue(":P_KITAS_NO",$this->kitas_no,PDO::PARAM_STR);
			$command->bindValue(":P_KITAS_EXPIRY",$this->kitas_expiry,PDO::PARAM_STR);
			
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_USER_ID",$this->cre_user_id,PDO::PARAM_STR);		
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_USER_ID",$this->upd_user_id,PDO::PARAM_STR);
			
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
}