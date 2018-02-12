<?php

/**
 * This is the model class for table "T_REKS_TRX".
 *
 * The followings are the available columns in table 'T_REKS_TRX':
 * @property string $reks_cd
 * @property string $reks_name
 * @property string $reks_type
 * @property string $afiliasi
 * @property string $trx_date
 * @property string $trx_type
 * @property double $subs
 * @property double $redm
 * @property string $user_id
 * @property string $cre_dt
 * @property string $gl_a1
 * @property string $sl_a1
 * @property string $gl_a2
 * @property string $sl_a2
 * @property string $doc_ref_num
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Trekstrx extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $trx_date_date;
	public $trx_date_month;
	public $trx_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	
	public $update_date;
	public $update_seq;
	
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
		return 'T_REKS_TRX';
	}

	public function rules()
	{
		return array(
		
			array('trx_date, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('subs, redm', 'application.components.validator.ANumberSwitcherValidator'),
			array('reks_cd,reks_name,reks_type,trx_date,trx_type,afiliasi,subs,redm','required'),
			array('redm','cekredm'),
			array('subs','ceksubs'),
			array('subs, redm', 'numerical'),
			array('reks_name', 'length', 'max'=>50),
			array('reks_type, gl_a1, gl_a2', 'length', 'max'=>4),
			array('afiliasi, approved_stat', 'length', 'max'=>1),
			array('trx_type, user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('sl_a1, sl_a2', 'length', 'max'=>6),
			array('doc_ref_num', 'length', 'max'=>17),
			array('cre_dt, upd_dt, approved_dt,doc_ref_num', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('reks_cd, reks_name, reks_type, afiliasi, trx_date, trx_type, subs, redm, user_id, cre_dt, gl_a1, sl_a1, gl_a2, sl_a2, doc_ref_num, upd_dt, upd_by, approved_dt, approved_by, approved_stat,trx_date_date,trx_date_month,trx_date_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}
	
	public function cekredm(){
			
			if($this->trx_type == 'REDM' && $this->redm <=0){
				
				$this->addError('redm','Tidak Boleh kecil/sama dengan 0');
			
			}
			if($this->trx_type == 'REDM' && $this->subs != 0){
				$this->addError('subs','Harus 0');
			}
			
		}
		public function ceksubs(){
			
			if($this->trx_type == 'SUBS' && $this->subs <=0){
				$this->addError('subs','Tidak Boleh kecil/sama dengan 0');
			}
			if($this->trx_type == 'SUBS' && $this->redm != 0){
				$this->addError('redm','Harus 0');
			
			}
		}
		

/*
	public function getPrimaryKey()
	{
		return array('reks_cd' => $this->reks_cd,'trx_date' => $this->trx_date);
	}
	*/

	public function attributeLabels()
	{
		return array(
			'reks_cd' => 'ISIN Code',
			'reks_name' => 'Reksa dana',
			'reks_type' => 'Reksa dana type',
			'afiliasi' => 'Afiliasi',
			'trx_date' => 'Transaction date',
			'trx_type' => 'Transaction type',
			'subs' => 'Subscribe',
			'redm' => 'Redeem',
			'user_id' => 'User',
			'cre_dt' => 'Cre date',
			'gl_a1' => 'Reksa dana Gl Acct',
			'sl_a1' => 'Reksa dana Sub Acct',
			'gl_a2' => 'GL acct',
			'sl_a2' => ' Sub Acct',
			'doc_ref_num' => 'Doc Ref Num',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Stat',
		);
	}
public function executeSpHeader($exec_status,$menuName)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_T_MANY_HEADER_INSERT(
						:P_MENU_NAME,
						:P_STATUS,
						:P_USER_ID,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_UPDATE_DATE,
						:P_UPDATE_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_MENU_NAME",$menuName,PDO::PARAM_STR);
			$command->bindValue(":P_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);			
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			
			$command->bindParam(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR,30);
			$command->bindParam(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR,10);
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

		public function executeSp($exec_status,$old_doc_ref_num,$record_seq)
	{
		$connection  = Yii::app()->db;
	
		
		try{
			$query  = "CALL SP_T_REKS_TRX_UPD(
						:P_SEARCH_DOC_REF_NUM,
						:P_REKS_CD,
						:P_REKS_NAME,
						:P_REKS_TYPE,
						:P_AFILIASI,
						TO_DATE(:P_TRX_DATE,'YYYY-MM-DD'),
						:P_TRX_TYPE,
						:P_SUBS,
						:P_REDM,
						:P_USER_ID,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_GL_A1,
						:P_SL_A1,
						:P_GL_A2,
						:P_SL_A2,
						:P_DOC_REF_NUM,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,
						
						:P_REVERSAL_JUR,
						:P_UPD_STATUS,
						:p_ip_address,
						:p_cancel_reason,
						TO_DATE(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),
						:p_update_seq,
						:p_record_seq,
						:p_error_code,
						:p_error_msg)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_DOC_REF_NUM",$old_doc_ref_num,PDO::PARAM_STR);	
			$command->bindValue(":P_REKS_CD",$this->reks_cd,PDO::PARAM_STR);
			$command->bindValue(":P_REKS_NAME",$this->reks_name,PDO::PARAM_STR);
			$command->bindValue(":P_REKS_TYPE",$this->reks_type,PDO::PARAM_STR);
			$command->bindValue(":P_AFILIASI",$this->afiliasi,PDO::PARAM_STR);
			$command->bindValue(":P_TRX_DATE",$this->trx_date,PDO::PARAM_STR);
			$command->bindValue(":P_TRX_TYPE",$this->trx_type,PDO::PARAM_STR);
			$command->bindValue(":P_SUBS",$this->subs,PDO::PARAM_STR);
			$command->bindValue(":P_REDM",$this->redm,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_GL_A1",$this->gl_a1,PDO::PARAM_STR);
			$command->bindValue(":P_SL_A1",$this->sl_a1,PDO::PARAM_STR);
			$command->bindValue(":P_GL_A2",$this->gl_a2,PDO::PARAM_STR);
			$command->bindValue(":P_SL_A2",$this->sl_a2,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_REF_NUM",$this->doc_ref_num,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			
			$command->bindValue(":P_REVERSAL_JUR",$this->reversal_jur,PDO::PARAM_STR);
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
		$criteria->compare('lower(reks_cd)',strtolower($this->reks_cd),true);
		$criteria->compare('lower(reks_name)',strtolower($this->reks_name),true);
		$criteria->compare('reks_type',$this->reks_type,true);
		$criteria->compare('afiliasi',$this->afiliasi,true);

		if(!empty($this->trx_date_date))
			$criteria->addCondition("TO_CHAR(t.trx_date,'DD') LIKE '%".$this->trx_date_date."%'");
		if(!empty($this->trx_date_month))
			$criteria->addCondition("TO_CHAR(t.trx_date,'MM') LIKE '%".$this->trx_date_month."%'");
		if(!empty($this->trx_date_year))
			$criteria->addCondition("TO_CHAR(t.trx_date,'YYYY') LIKE '%".$this->trx_date_year."%'");		$criteria->compare('trx_type',$this->trx_type,true);
		$criteria->compare('subs',$this->subs);
		$criteria->compare('redm',$this->redm);
		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('gl_a1',$this->gl_a1,true);
		$criteria->compare('sl_a1',$this->sl_a1,true);
		$criteria->compare('gl_a2',$this->gl_a2,true);
		$criteria->compare('sl_a2',$this->sl_a2,true);
		$criteria->compare('doc_ref_num',$this->doc_ref_num,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('upd_by',$this->upd_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);
	
		
		$sort = new CSort();
		$sort->defaultOrder = 'trx_date desc,reks_name';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}