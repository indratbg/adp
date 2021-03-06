<?php

/**
 * This is the model class for table "T_PAYRECH".
 *
 * The followings are the available columns in table 'T_PAYRECH':
 * @property string $payrec_num
 * @property string $payrec_type
 * @property string $payrec_date
 * @property string $acct_type
 * @property string $sl_acct_cd
 * @property string $curr_cd
 * @property double $curr_amt
 * @property string $payrec_frto
 * @property string $remarks
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $approved_sts
 * @property string $approved_by
 * @property string $approved_dt
 * @property string $gl_acct_cd
 * @property string $client_cd
 * @property string $check_num
 * @property string $folder_cd
 * @property integer $num_cheq
 * @property string $client_bank_acct
 * @property string $client_bank_name
 */
class Tpayrech extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $payrec_date_date;
	public $payrec_date_month;
	public $payrec_date_year;

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
	
	public $type;
	
	public $payrec_num;
	
	public $client_name;
	public $bank_cd;
	public $acct_name;
	public $bank_acct_fmt;
	public $client_type;
	public $client_type_3;
	public $branch_code;
	public $olt;
	public $recov_charge_flg;
	public $active;
	public $rdi_pay_flg;
	public $client_bank_cd;
	public $int_adjust;
	public $trf_ksei;
	
	public $trx_date;
	public $due_date;
	
	public $update_date;
	public $update_seq;
	public $file_upload;
	
	public $print = 'Y'; // for report
	
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
		return 'T_PAYRECH';
	}
	
	public static function checkPending($client_cd)
	{
		$sql = "SELECT COUNT(*) pending_cnt FROM T_MANY_HEADER h
				JOIN T_MANY_DETAIL d
				ON h.update_date = d.update_date
				AND h.update_seq = d.update_seq
				WHERE h.approved_status = 'E'
				AND 
				(
					(
						h.menu_name = 'VOUCHER ENTRY' 
						AND d.table_name = 'T_PAYRECH'
						AND d.field_name = 'CLIENT_CD'
						AND d.field_value = '$client_cd'
					) 
					OR
					(
						h.menu_name = 'GL JOURNAL ENTRY' 
						AND d.table_name = 'T_ACCOUNT_LEDGER'
						AND d.field_name = 'SL_ACCT_CD'
						AND d.field_value = '$client_cd'
					)
				)
				";
				
		$result = DAO::queryRowSql($sql);
		
		return $result['pending_cnt'];
	}
	
	public function executeSpHeader($exec_status,$menuName)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = 
					"
					DECLARE
						v_update_date	DATE;
					BEGIN
						SP_T_MANY_HEADER_INSERT
						(
							:P_MENU_NAME,
							:P_STATUS,
							:P_USER_ID,
							:P_IP_ADDRESS,
							:P_CANCEL_REASON,
							v_update_date,
							:P_UPDATE_SEQ,
							:P_ERROR_CODE,
							:P_ERROR_MSG
						);
						
						SELECT TO_CHAR(v_update_date,'YYYY-MM-DD HH24:MI:SS') INTO :P_UPDATE_DATE FROM dual;
					END;";
				
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
			
			/*if(DateTime::createFromFormat('Y-m-d H:i:s',$this->update_date) === false) //Reselect the update date if the retrieved date format is not YYYY-MM-DD HH24:MI:SS
			{
				$result = DAO::queryRowSql("SELECT update_date FROM T_MANY_HEADER WHERE update_seq = '$this->update_seq'");
				
				$this->update_date = $result['update_date'];
			}*/
			
		}catch(Exception $ex){
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}	
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}
    

	public function executeSp($exec_status,$old_payrec_num,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_T_PAYRECH_UPD(
						:P_SEARCH_PAYREC_NUM,
						:P_PAYREC_NUM,
						:P_PAYREC_TYPE,
						TO_DATE(:P_PAYREC_DATE,'YYYY-MM-DD'),
						:P_ACCT_TYPE,
						:P_SL_ACCT_CD,
						:P_CURR_CD,
						:P_CURR_AMT,
						:P_PAYREC_FRTO,
						:P_REMARKS,
						:P_GL_ACCT_CD,
						:P_CLIENT_CD,
						:P_CHECK_NUM,
						:P_FOLDER_CD,
						:P_NUM_CHEQ,
						:P_CLIENT_BANK_ACCT,
						:P_CLIENT_BANK_NAME,
						:P_REVERSAL_JUR,		
						:P_USER_ID,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),		
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPDATE_SEQ,
						:P_RECORD_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_PAYREC_NUM",$old_payrec_num,PDO::PARAM_STR);
			$command->bindParam(":P_PAYREC_NUM",$this->payrec_num,PDO::PARAM_STR,100);
			$command->bindValue(":P_PAYREC_TYPE",$this->payrec_type,PDO::PARAM_STR);
			$command->bindValue(":P_PAYREC_DATE",$this->payrec_date,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_TYPE",$this->acct_type,PDO::PARAM_STR);
			$command->bindValue(":P_SL_ACCT_CD",$this->sl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CURR_CD",$this->curr_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CURR_AMT",$this->curr_amt,PDO::PARAM_STR);
			$command->bindValue(":P_PAYREC_FRTO",$this->payrec_frto,PDO::PARAM_STR);
			$command->bindValue(":P_REMARKS",$this->remarks,PDO::PARAM_STR);
			$command->bindValue(":P_GL_ACCT_CD",$this->gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CHECK_NUM",$this->check_num,PDO::PARAM_STR);
			$command->bindValue(":P_FOLDER_CD",$this->folder_cd,PDO::PARAM_STR);
			$command->bindValue(":P_NUM_CHEQ",$this->num_cheq,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_BANK_ACCT",$this->client_bank_acct,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_BANK_NAME",$this->client_bank_name,PDO::PARAM_STR);
			$command->bindValue(":P_REVERSAL_JUR",$this->reversal_jur,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
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
	
	public function rules()
	{
		return array(
			array('payrec_date','checkIfHoliday'),
		
			array('trx_date, due_date, payrec_date, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('curr_amt, num_cheq', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('remarks','required','except'=>'upload,fund'),
			array('file_upload','file','types'=>'txt','wrongType'=>'File type must be txt','on'=>'upload'),
			array('payrec_type','required','on'=>'D'),
			array('payrec_date', 'required','except'=>'upload,fund'),
			array('curr_amt','required','on'=>'D'),
			array('client_cd','required','on'=>'V'),
			
			array('folder_cd','checkParam','except'=>'upload,fund'),
			array('folder_cd','checkFolderCd','except'=>'upload,fund'),
			array('sl_acct_cd','checkRequired','except'=>'upload,fund'),
			array('client_cd','checkExist','on'=>'D, V'),
			
			array('num_cheq', 'numerical', 'integerOnly'=>true),
			array('curr_amt', 'numerical'),
			array('payrec_type', 'length', 'max'=>2),
			array('acct_type', 'length', 'max'=>4),
			array('sl_acct_cd, gl_acct_cd, client_cd', 'length', 'max'=>12),
			array('curr_cd', 'length', 'max'=>3),
			array('payrec_frto, remarks, client_bank_name', 'length', 'max'=>50),
			array('user_id', 'length', 'max'=>10),
			array('approved_sts', 'length', 'max'=>1),
			array('approved_by', 'length', 'max'=>20),
			array('check_num, client_bank_acct', 'length', 'max'=>30),
			array('folder_cd', 'length', 'max'=>8),
			array('print, file_upload,trx_date, due_date, trf_ksei, int_adjust, type, client_bank_cd, client_name, client_type, client_type_3, branch_code, olt, recov_charge_flg, bank_cd, bank_acct_fmt, active, rdi_pay_flg, payrec_date, cre_dt, upd_dt, approved_dt', 'safe'),

			array('payrec_num','required','on'=>'report'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('payrec_num, payrec_type, payrec_date, acct_type, sl_acct_cd, curr_cd, curr_amt, payrec_frto, remarks, user_id, cre_dt, upd_dt, approved_sts, approved_by, approved_dt, gl_acct_cd, client_cd, check_num, folder_cd, num_cheq, client_bank_acct, client_bank_name,payrec_date_date,payrec_date_month,payrec_date_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function checkIfHoliday()
	{
		if($this->payrec_date)
		{
			$check = "SELECT dflg1 FROM MST_SYS_PARAM WHERE param_id = 'SYSTEM' AND param_cd1 = 'CHECK' AND param_cd2 = 'HOLIDAY'";
			$checkFlg = DAO::queryRowSql($check);
			
			if($checkFlg['dflg1'] == 'Y')
			{
				$sql = "SELECT F_IS_HOLIDAY('$this->payrec_date') is_holiday FROM dual";
				$isHoliday = DAO::queryRowSql($sql);
				
				if($isHoliday['is_holiday'] == 1)$this->addError('payrec_date','Date must not be holiday');
			}
		}
	}

	public function checkParam()
	{
		$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'VCH_REF' ")->dflg1;
		
		if($check == 'Y' && !$this->folder_cd)$this->addError('folder_cd', 'File Code cannot be blank'); 
	}

	public function checkFolderCd()
	{
		$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'VCH_REF' ")->dflg1;
		
		$folderChange = true;
		
		if(!$this->isNewRecord)
		{
			$oldFolderCd = Tpayrech::model()->find("payrec_num = '$this->payrec_num'")->folder_cd;
			if($this->folder_cd == $oldFolderCd)
				$folderChange = false;
		}
		
		if($check == 'Y' && $folderChange)
		{ 
			$return = $doc_num = $user_id = $doc_date = '';
			
			$connection  = Yii::app()->db;
			
			$query  = 
					"
					DECLARE
						v_doc_date	DATE;
					BEGIN
						SP_CHECK_FOLDER_CD
						(
							:P_FOLDER_CD,
							TO_DATE(:P_DATE,'YYYY-MM-DD'),
							:P_RTN,
							:P_DOC_NUM,
							:P_USER_ID,
							v_doc_date
						);
						
						SELECT TO_CHAR(v_doc_date,'YYYY-MM-DD HH24:MI:SS') INTO :P_DOC_DATE FROM dual;
					END;";
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_FOLDER_CD",$this->folder_cd,PDO::PARAM_STR);
			$command->bindValue(":P_DATE",$this->payrec_date,PDO::PARAM_STR);
			$command->bindParam(":P_RTN",$return,PDO::PARAM_STR,1);
			$command->bindParam(":P_DOC_NUM",$doc_num,PDO::PARAM_STR,100);
			$command->bindParam(":P_USER_ID",$user_id,PDO::PARAM_STR,10);
			$command->bindParam(":P_DOC_DATE",$doc_date,PDO::PARAM_STR,100);
	
			$command->execute();
			
			if($doc_date)$doc_date = DateTime::createFromFormat('Y-m-d H:i:s',$doc_date)->format('d/m/Y');
			
			if($return == 1)$this->addError('folder_cd',"File Code $this->folder_cd is already used by $user_id $doc_num $doc_date");
		}
	}
	
	public function checkRequired()
	{
		//$check = Parameter::model()->find("prm_cd_1 = 'BNKFLG' AND prm_cd_2 = '$this->gl_acct_cd'");
		if($this->gl_acct_cd != 'NA' && !$this->sl_acct_cd)
		{
			$this->addError('sl_acct_cd', 'Bank Account must be filled');
		}
	}
	
	public function checkExist()
	{
		if($this->client_cd != '')
		{
			$check = DAO::queryRowSql
					("
						SELECT COUNT(*) cnt
						FROM MST_CLIENT
						WHERE client_cd = '$this->client_cd'
						AND susp_stat = 'N'
					");
			
			if($check['cnt'] == 0)$this->addError('client_cd', "Client $this->client_cd doesn't exist");
		}
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'payrec_num' => 'Voucher Number',
			'payrec_type' => 'Voucher Type',
			'payrec_date' => 'Voucher Date',
			'acct_type' => 'Acct Type',
			'sl_acct_cd' => 'Sl Acct Code',
			'curr_cd' => 'Curr Code',
			'curr_amt' => 'Amount',
			'payrec_frto' => 'Payee',
			'remarks' => 'Remarks',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'approved_sts' => 'Approved Sts',
			'approved_by' => 'Approved By',
			'approved_dt' => 'Approved Date',
			'gl_acct_cd' => 'Cash/Bank Account',
			'client_cd' => 'Client Code',
			'check_num' => 'Check Num',
			'folder_cd' => 'File Code',
			'num_cheq' => 'Num Cheq',
			'client_bank_acct' => 'Account',
			'client_bank_name' => 'Bank',
			
			'bank_cd' => 'Rekening Dana',
			'rdi_pay_flg' => 'Pay Via RDI',
			'client_bank_cd' => 'Bank',
			'int_adjust' => 'Interest Adjustment',
			'trf_ksei' => 'Trf From KSEI'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('payrec_num',$this->payrec_num,true);
		$criteria->compare('payrec_type',$this->payrec_type,true);

		if(!empty($this->payrec_date_date))
			$criteria->addCondition("TO_CHAR(t.payrec_date,'DD') LIKE '%".$this->payrec_date_date."%'");
		if(!empty($this->payrec_date_month))
			$criteria->addCondition("TO_CHAR(t.payrec_date,'MM') LIKE '%".$this->payrec_date_month."%'");
		if(!empty($this->payrec_date_year))
			$criteria->addCondition("TO_CHAR(t.payrec_date,'YYYY') LIKE '%".$this->payrec_date_year."%'");	
		
		if(empty($this->payrec_date_date) && empty($this->payrec_date_month) && empty($this->payrec_date_year))
			$criteria->addCondition("t.payrec_date BETWEEN TRUNC(SYSDATE) - 1 AND TRUNC(SYSDATE) + 20");
			
		//$criteria->compare('acct_type',$this->acct_type,true);	
		
		if($this->type != 'KPEI')
		{
			$criteria->addCondition("(t.acct_type IS NULL AND (t.client_cd NOT IN ('KPEI','GS1000') AND LENGTH(t.client_cd) <> 2 OR t.client_cd IS NULL)) OR t.acct_type NOT IN ('KPEI','NEGO','GSJK','GSSL')");
		}
		else
		{
			$criteria->addCondition("t.acct_type IN ('KPEI','NEGO','GSJK','GSSL') OR t.client_cd IN ('KPEI','GS1000') OR LENGTH(t.client_cd) = 2");
		}	
		
		$criteria->compare('sl_acct_cd',$this->sl_acct_cd,true);
		$criteria->compare('curr_cd',$this->curr_cd,true);
		$criteria->compare('curr_amt',$this->curr_amt);
		$criteria->compare('payrec_frto',$this->payrec_frto,true);
		$criteria->compare('remarks',$this->remarks,true);
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
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('approved_sts',$this->approved_sts,true);
		$criteria->compare('approved_by',$this->approved_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		
		if($this->client_cd)$criteria->addCondition("upper(client_cd) LIKE upper('".$this->client_cd."%')");
		
		$criteria->compare('check_num',$this->check_num,true);
		
		if($this->folder_cd == null)$criteria->addCondition("folder_cd NOT LIKE 'MJN%' OR folder_cd IS NULL");
		else 
			$criteria->addCondition("upper(folder_cd) LIKE upper('".$this->folder_cd."%')");
		
		$criteria->compare('num_cheq',$this->num_cheq);	
		$criteria->compare('client_bank_acct',$this->client_bank_acct,true);
		$criteria->compare('client_bank_name',$this->client_bank_name,true);
		$criteria->compare('reversal_jur',$this->reversal_jur,true);
		
		$sort = new CSort;
		
		$sort->defaultOrder="payrec_date DESC";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}