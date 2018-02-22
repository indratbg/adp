<?php

/**
 * This is the model class for table "T_CONSOL_JRN".
 *
 * The followings are the available columns in table 'T_CONSOL_JRN':
 * @property string $xn_doc_num
 * @property integer $tal_id
 * @property string $entity
 * @property string $sl_acct_cd
 * @property string $gl_acct_cd
 * @property double $curr_val
 * @property string $db_cr_flg
 * @property string $ledger_nar
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $doc_date
 * @property string $approved_sts
 * @property string $approved_by
 * @property string $approved_dt
 * @property string $folder_cd
 */
class Tconsoljrn extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $doc_date_date;
	public $doc_date_month;
	public $doc_date_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	public $rep_date;
	public $save_flg = 'N';
	public $cancel_flg = 'N';
	public $balance;
	public $update_date;
	public $update_seq;
	public $old_xn_doc_num;
	public $old_tal_id;
	public $old_doc_date;
	public $from_date;
	public $to_date;
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
		return 'T_CONSOL_JRN';
	}
	public function getPrimaryKey(){
		return array('xn_doc_num'=>$this->xn_doc_num,'doc_date'=>$this->doc_date);
	}

	public function rules()
	{
		return array(
		
			array('old_doc_date,rep_date,doc_date, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('tal_id, curr_val', 'application.components.validator.ANumberSwitcherValidator'),
			array('xn_doc_num,tal_id,doc_date','required'),
			array('curr_val', 'numerical'),
			array('entity', 'length', 'max'=>5),
			array('sl_acct_cd, gl_acct_cd', 'length', 'max'=>12),
			array('db_cr_flg, approved_sts', 'length', 'max'=>1),
			array('ledger_nar', 'length', 'max'=>50),
			array('user_id', 'length', 'max'=>10),
			array('approved_by', 'length', 'max'=>20),
			array('folder_cd', 'length', 'max'=>8),
			array('from_date,to_date,doc_date,xn_doc_num,cancel_flg,old_xn_doc_num,old_tal_id,old_doc_date,balance,save_flg,rep_date,cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('xn_doc_num, tal_id, entity, sl_acct_cd, gl_acct_cd, curr_val, db_cr_flg, ledger_nar, user_id, cre_dt, upd_dt, doc_date, approved_sts, approved_by, approved_dt, folder_cd,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,doc_date_date,doc_date_month,doc_date_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'xn_doc_num' => 'Journal Number',
			'tal_id' => 'Nomor Urut',
			'entity' => 'Entity',
			'sl_acct_cd' => 'Sl Acct Cd',
			'gl_acct_cd' => 'Gl Main Acct Cd',
			'curr_val' => 'Amount',
			'db_cr_flg' => 'Debit/Credit',
			'ledger_nar' => 'Description',
			'user_id' => 'User Id',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'doc_date' => 'Date',
			'approved_sts' => 'Approved Sts',
			'approved_by' => 'Approved By',
			'approved_dt' => 'Approved Date',
			'folder_cd' => 'Journal Code',
			'rep_date'=>'Date'
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
public function executeSp($exec_status,$doc_date,$xn_doc_num,$tal_id,$record_seq)
	{ 
		$connection  = Yii::app()->db;
				
		try{
			$query  = "CALL  Sp_T_CONSOL_JRN_Upd(TO_DATE(:P_SEARCH_DOC_DATE,'YYYY-MM-DD'),
												:P_SEARCH_XN_DOC_NUM,
												:P_SEARCH_TAL_ID,
												:P_XN_DOC_NUM,
												:P_TAL_ID,
												:P_ENTITY,
												:P_SL_ACCT_CD,
												:P_GL_ACCT_CD,
												:P_CURR_VAL,
												:P_DB_CR_FLG,
												:P_LEDGER_NAR,
												:P_USER_ID,
												TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
												TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
												TO_DATE(:P_DOC_DATE,'YYYY-MM-DD'),
												:P_FOLDER_CD,
												:P_UPD_STATUS,
												:p_ip_address,
												:p_cancel_reason,
												TO_DATE(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),
												:p_update_seq,
												:p_record_seq,
												:p_error_code,
												:p_error_msg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_DOC_DATE",$doc_date,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_XN_DOC_NUM",$xn_doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_TAL_ID",$tal_id,PDO::PARAM_STR);
			$command->bindValue(":P_XN_DOC_NUM",$this->xn_doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_TAL_ID",$tal_id,PDO::PARAM_STR);
			$command->bindValue(":P_TAL_ID",$this->tal_id,PDO::PARAM_STR);
			$command->bindValue(":P_ENTITY",$this->entity,PDO::PARAM_STR);
			$command->bindValue(":P_SL_ACCT_CD",$this->sl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_GL_ACCT_CD",$this->gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CURR_VAL",$this->curr_val,PDO::PARAM_STR);
			$command->bindValue(":P_DB_CR_FLG",$this->db_cr_flg,PDO::PARAM_STR);
			$command->bindValue(":P_LEDGER_NAR",$this->ledger_nar,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_DATE",$this->doc_date,PDO::PARAM_STR);
			$command->bindValue(":P_FOLDER_CD",$this->folder_cd,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);								
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
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
	public function search()
	{
		$criteria = new CDbCriteria;
		
		$criteria->select = 'MIN(LEDGER_NAR) LEDGER_NAR,DOC_DATE,XN_DOC_NUM,MIN(TAL_ID) TAL_ID';
		//$criteria->condition = 'receiver_id = :receiverId';
		$criteria->group = 'XN_DOC_NUM,DOC_DATE';
		$criteria->order = 'DOC_DATE DESC';
		//$criteria->params = array('receiverId' => $userId);
		
		
		
		$criteria->compare('xn_doc_num',$this->xn_doc_num,true);
		$criteria->compare('tal_id',$this->tal_id);
		$criteria->compare('entity',$this->entity,true);
		$criteria->compare('sl_acct_cd',$this->sl_acct_cd,true);
		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('curr_val',$this->curr_val);
		$criteria->compare('db_cr_flg',$this->db_cr_flg,true);
		$criteria->compare('lower(ledger_nar)',strtolower($this->ledger_nar),true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('approved_sts',$this->approved_sts,true);
		if(!empty($this->from_date) && !empty($this->to_date) )
		$criteria->addCondition("doc_date between to_date('$this->from_date','dd/mm/yyyy') and to_date('$this->to_date','dd/mm/yyyy')");
		
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
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");
		if(!empty($this->doc_date_date))
			$criteria->addCondition("TO_CHAR(t.doc_date,'DD') LIKE '%".$this->doc_date_date."%'");
		if(!empty($this->doc_date_month))
			$criteria->addCondition("TO_CHAR(t.doc_date,'MM') LIKE '%".$this->doc_date_month."%'");
		if(!empty($this->doc_date_year))
			$criteria->addCondition("TO_CHAR(t.doc_date,'YYYY') LIKE '%".$this->doc_date_year."%'");		$criteria->compare('approved_sts',$this->approved_sts,true);
		$criteria->compare('approved_by',$this->approved_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('folder_cd',$this->folder_cd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}