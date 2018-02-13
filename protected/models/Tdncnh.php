<?php

/**
 * This is the model class for table "T_DNCNH".
 *
 * The followings are the available columns in table 'T_DNCNH':
 * @property string $dncn_num
 * @property string $dncn_date
 * @property string $db_cr_flg
 * @property string $acct_type
 * @property string $sl_acct_cd
 * @property string $gl_acct_cd
 * @property string $curr_cd
 * @property double $curr_val
 * @property string $ledger_nar
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $chrg_cd
 * @property string $approved_sts
 * @property string $approved_by
 * @property string $approved_dt
 * @property string $chrg_flg
 * @property string $folder_cd
 * @property string $reversal_jur
 */
class Tdncnh extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $dncn_date_date;
	public $dncn_date_month;
	public $dncn_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	public $client_cd;
	//AH: #END search (datetime || date)  additional comparison
	
	public $update_date;
	public $update_seq;
	
	public $from_date;
	public $to_date;
	public $budget_cd;
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
		return 'T_DNCNH';
	}

	public function rules()
	{
		return array(
		
			array('dncn_date, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('curr_val', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('curr_val', 'numerical'),
			//array('db_cr_flg, approved_sts, chrg_flg', 'length', 'max'=>1),
			array('db_cr_flg, chrg_flg', 'length', 'max'=>1),
			array('acct_type', 'length', 'max'=>4),
			array('sl_acct_cd, gl_acct_cd', 'length', 'max'=>12),
			array('curr_cd', 'length', 'max'=>3),
			array('ledger_nar', 'length', 'max'=>50),
			array('user_id', 'length', 'max'=>10),
			array('chrg_cd', 'length', 'max'=>5),
			array('approved_by', 'length', 'max'=>20),
			array('folder_cd','checkFolderCd','on'=>'insert,update'),
			array('reversal_jur', 'length', 'max'=>17),
			array('dncn_date, cre_dt, upd_dt, approved_dt, from_date, to_date, budget_cd', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('budget_cd,dncn_num, dncn_date, db_cr_flg, acct_type, sl_acct_cd, gl_acct_cd, curr_cd, curr_val, ledger_nar, user_id, cre_dt, upd_dt, chrg_cd, approved_sts, approved_by, approved_dt, chrg_flg, folder_cd, reversal_jur,dncn_date_date,dncn_date_month,dncn_date_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}
	
	public function checkFolderCd()
	{
		
		$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'VCH_REF' ")->dflg1;
		
		$folderChange = true;
		
		if(!$this->isNewRecord)
		{
			$oldFolderCd = Tdncnh::model()->find("dncn_num = '$this->dncn_num'")->folder_cd;
			if($this->folder_cd == $oldFolderCd)
				$folderChange = false;
		}
		
		
		if($check == 'Y' && $folderChange)
		{ 
			$return;
			$doc_num;
			$user_id;
			$doc_date;
			
			$connection  = Yii::app()->db;
			//$transaction = $connection->beginTransaction();	
			
			$query  = "CALL SP_CHECK_FOLDER_CD(
						:P_FOLDER_CD,
						TO_DATE(:P_DATE,'YYYY-MM-DD'),
						:P_RTN,
						:P_DOC_NUM,
						:P_USER_ID,
						:P_DOC_DATE)";
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_FOLDER_CD",$this->folder_cd,PDO::PARAM_STR);
			$command->bindValue(":P_DATE",$this->dncn_date,PDO::PARAM_STR);
			$command->bindParam(":P_RTN",$return,PDO::PARAM_STR,1);
			$command->bindParam(":P_DOC_NUM",$doc_num,PDO::PARAM_STR,100);
			$command->bindParam(":P_USER_ID",$user_id,PDO::PARAM_STR,10);
			$command->bindParam(":P_DOC_DATE",$doc_date,PDO::PARAM_STR,100);
	
			$command->execute();
			
			if($doc_date)$doc_date = DateTime::createFromFormat('Y-m-d G:i:s',$doc_date)->format('d/m/Y');
			
			if($return == 1){
				$this->addError('folder_cd',"File Code ".$this->folder_cd." is already used by $user_id $doc_num $doc_date");
			}
		}
	}

	public function attributeLabels()
	{
		return array(
			'dncn_num' => 'Journal Number',
			'dncn_date' => 'Date',
			'db_cr_flg' => 'Debit / Credit',
			'acct_type' => 'Acct Type',
			'sl_acct_cd' => 'Client',
			'gl_acct_cd' => 'Gl Acct Code',
			'curr_cd' => 'Curr Code',
			'curr_val' => 'Curr Val',
			'ledger_nar' => 'Remarks',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'chrg_cd' => 'Chrg Code',
			'approved_sts' => 'Approved Sts',
			'approved_by' => 'Approved By',
			'approved_dt' => 'Approved Date',
			'chrg_flg' => 'Chrg Flg',
			'folder_cd' => 'File No.',
			'reversal_jur' => 'Reversal Jur',
			'from_date'=>'From Date',
			'to_date'=>'To Date',
			'budget_cd'=>'Budget Cd'
		);
	}
/*
	public function executeSpHeader($exec_status,$menuName)
	{ //echo "<script>alert('test')</script>";
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
	*/
	public function executeSp($exec_status,$old_dncn_num,$record_seq)
	{ 
		$connection  = Yii::app()->db;
				
		try{
			$query  = "CALL  Sp_T_DNCNH_Upd(:P_SEARCH_DNCN_NUM,		
											:P_DNCN_NUM,		
											TO_DATE(:P_DNCN_DATE,'YYYY-MM-DD'),		
											:P_DB_CR_FLG,		
											:P_ACCT_TYPE,		
											:P_SL_ACCT_CD,	
											:P_GL_ACCT_CD,	
											:P_CURR_CD,		
											:P_CURR_VAL,		
											:P_LEDGER_NAR,	
											:P_USER_ID,		
											TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
											TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),				
											:P_CHRG_CD,		
											:P_CHRG_FLG,		
											:P_FOLDER_CD,		
											:P_REVERSAL_JUR,	
											:P_UPD_BY,		
											:P_UPD_STATUS,				
											:p_ip_address,				
											:p_cancel_reason,				
											TO_DATE(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),			
											:p_update_seq,				
											:p_record_seq,				
											:p_error_code,				
											:p_error_msg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_DNCN_NUM",$old_dncn_num,PDO::PARAM_STR);
			$command->bindValue(":P_DNCN_NUM",$this->dncn_num,PDO::PARAM_STR);
			$command->bindValue(":P_DNCN_DATE",$this->dncn_date,PDO::PARAM_STR);
			$command->bindValue(":P_DB_CR_FLG",$this->db_cr_flg,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_TYPE",$this->acct_type,PDO::PARAM_STR);
			$command->bindValue(":P_SL_ACCT_CD",$this->sl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_GL_ACCT_CD",$this->gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CURR_CD",$this->curr_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CURR_VAL",$this->curr_val,PDO::PARAM_STR);
			$command->bindValue(":P_LEDGER_NAR",$this->ledger_nar,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CHRG_CD",$this->chrg_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CHRG_FLG",$this->chrg_flg,PDO::PARAM_STR);
			$command->bindValue(":P_FOLDER_CD",$this->folder_cd,PDO::PARAM_STR);
			$command->bindValue(":P_REVERSAL_JUR",$this->reversal_jur,PDO::PARAM_STR);
			//$command->bindValue(":P_approved_sts",$this->approved_sts,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
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
		$criteria->compare('dncn_num',$this->dncn_num,true);
		
		if(!empty($this->from_date) && !empty($this->to_date) )
			$criteria->addCondition("dncn_date between to_date('$this->from_date','dd/mm/yyyy') and to_date('$this->to_date','dd/mm/yyyy')");
		
		if(!empty($this->dncn_date_date))
			$criteria->addCondition("TO_CHAR(t.dncn_date,'DD') LIKE '%".$this->dncn_date_date."%'");
		if(!empty($this->dncn_date_month))
			$criteria->addCondition("TO_CHAR(t.dncn_date,'MM') LIKE '%".$this->dncn_date_month."%'");
		if(!empty($this->dncn_date_year))
			$criteria->addCondition("TO_CHAR(t.dncn_date,'YYYY') LIKE '%".$this->dncn_date_year."%'");		$criteria->compare('db_cr_flg',$this->db_cr_flg,true);
		$criteria->compare('acct_type',$this->acct_type,true);
		$criteria->compare('sl_acct_cd',$this->sl_acct_cd,true);
		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('curr_cd',$this->curr_cd,true);
		$criteria->compare('curr_val',$this->curr_val);
		$criteria->compare('ledger_nar',$this->ledger_nar,true);
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
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('chrg_cd',$this->chrg_cd,true);
		$criteria->compare('approved_sts',$this->approved_sts,true);
		$criteria->compare('approved_by',$this->approved_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('chrg_flg',$this->chrg_flg,true);
		$criteria->compare('folder_cd',$this->folder_cd,true);
		$criteria->compare('reversal_jur',$this->reversal_jur,true);
		$sort=new CSort;
		$sort->defaultOrder='dncn_date desc';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}