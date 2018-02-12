<?php

/**
 * This is the model class for table "IPNEXTG.T_REPO_VCH".
 *
 * The followings are the available columns in table 'IPNEXTG.T_REPO_VCH':
 * @property string $repo_num
 * @property string $doc_num
 * @property string $doc_ref_num
 * @property integer $tal_id
 * @property double $amt
 * @property string $doc_dt
 * @property string $user_id
 * @property string $cre_dt
 */
class Trepovch extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $doc_dt_date;
	public $doc_dt_month;
	public $doc_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $cancel_flg = 'N';
	public $save_flg = 'N';
	
	public $old_doc_num;
	public $old_doc_ref_num;
	public $payrec_type;
	public $folder_cd;
	public $remarks;
		
	public $update_seq;
	public $update_date;
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
		return 'T_REPO_VCH';
	}
	
	public function executeSp($exec_status,$old_repo_num,$old_doc_num,$old_doc_ref_num,$update_date,$update_seq,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_T_REPO_VCH_UPD(
						:P_SEARCH_REPO_NUM,
						:P_SEARCH_DOC_NUM,
						:P_SEARCH_DOC_REF_NUM,
						:P_REPO_NUM,
						:P_DOC_NUM,
						:P_DOC_REF_NUM,
						:P_TAL_ID,
						:P_AMT,
						TO_DATE(:P_DOC_DT,'YYYY-MM-DD'),
						:P_PAYREC_TYPE,
						:P_FOLDER_CD,
						:P_REMARKS,
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
			$command->bindValue(":P_SEARCH_REPO_NUM",$old_repo_num,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_DOC_NUM",$old_doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_DOC_REF_NUM",$old_doc_ref_num,PDO::PARAM_STR);
			$command->bindValue(":P_REPO_NUM",$this->repo_num,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_NUM",$this->doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_REF_NUM",$this->doc_ref_num,PDO::PARAM_STR);
			$command->bindValue(":P_TAL_ID",$this->tal_id,PDO::PARAM_STR);
			$command->bindValue(":P_AMT",$this->amt,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_DT",$this->doc_dt,PDO::PARAM_STR);
			$command->bindValue(":P_PAYREC_TYPE",$this->payrec_type,PDO::PARAM_STR);
			$command->bindValue(":P_FOLDER_CD",$this->folder_cd,PDO::PARAM_STR);
			$command->bindValue(":P_REMARKS",$this->remarks,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
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

	public static function getVchSql($repo_date,$client_cd,$repo_num,$doc_num = '%',$doc_ref_num = '%') 
	{
		$begin_date = date("Y-m-01");
		
		$sql = "SELECT doc_num, doc_dt, payrec_type, folder_cd, SUM(payreC_amt) amt, remarks, doc_ref_num, tal_id, 1 sort
				FROM(
					SELECT  r.DOC_NUM,  r.DOC_DT,  p.payrec_type, p.folder_cd, payrec_amt, p.remarks, p.doc_ref_num, r.tal_id
					FROM( 
						SELECT p1.payrec_num, p1.payrec_date, p1.payrec_type, h.folder_cd,
						DECODE(trim(p1.gl_acct_cd),'2415',DECODE(p1.db_cr_flg,'C',1,-1), 
						DECODE(p1.db_cr_flg,'D',1,-1)) * payrec_amt AS payrec_amt,
				        p1.remarks, p1.doc_ref_num, tal_id
						FROM T_PAYRECD P1, T_PAYRECH H
						WHERE p1.payrec_num = h.payrec_num
						AND p1.approved_sts <> 'C'
						AND p1.approved_sts <> 'E' 
						AND p1.payrec_date >= TO_DATE('$repo_date','YYYY-MM-DD HH24:MI:SS')
					--	AND p1.payrec_date >= TO_DATE('$begin_date','YYYY-MM-DD')
						AND p1.sl_acct_cd = '$client_cd'
						UNION
						--29SEP2017 SELECT xn_doc_num payrec_num, doc_date, 'GL' payrec_type, folder_cd, curr_val payrec_amt, ledger_nar remarks, xn_doc_num doc_ref_num, tal_id
						SELECT xn_doc_num payrec_num, doc_date, 'GL' payrec_type, folder_cd, DECODE(DB_CR_FLG,'D','1','-1')*curr_val payrec_amt, ledger_nar remarks, xn_doc_num doc_ref_num, tal_id
						FROM T_ACCOUNT_LEDGER
						WHERE approved_sts <> 'C'
						AND approved_sts <> 'E' 
						AND record_source = 'GL'
						AND doc_date >= TO_DATE('$repo_date','YYYY-MM-DD HH24:MI:SS')
						AND ((budget_cd = 'INTREPO' AND doc_date >= TO_DATE('$begin_date','YYYY-MM-DD')) 
							OR (NVL(trim(budget_cd),'X') <> 'INTREPO'  ))
						AND sl_acct_cd = '$client_cd'
						AND trim(gl_acct_cd) IN ('2415','1415')
					) P,
				    T_REPO_VCH r
					WHERE r.approved_stat <> 'C'
					AND r.doc_num = p.payrec_num
					AND r.doc_ref_num = p.doc_ref_num 
					AND r.tal_id = p.tal_id
					AND r.repo_num = '$repo_num'
					AND r.doc_num LIKE '$doc_num'
					AND r.doc_ref_num LIKE '$doc_ref_num'
					and r.doc_dt >= to_date('$repo_date','yyyy-mm-dd  HH24:MI:SS')
				)
				GROUP BY doc_num, doc_dt, payrec_type, folder_cd, remarks, doc_ref_num, tal_id
				UNION
				SELECT  '-' doc_num,  MAX(r.DOC_DT) doc_Dt,  'PB' payrec_type, '-' folder_cd,
				SUM(curr_val) curr_val, ' total  accrued interest ' ledger_nar, '-' doc_ref_num, 0 tal_id, 2 sort
				FROM( 
					SELECT  SUBSTR(xn_doc_num,1,4) AS mmyy, xn_doc_num payrec_num, xn_doc_num doc_ref_num, tal_id,
					--29SEP2017 doc_date, 'GL' payrec_type, folder_cd, gl_acct_cd, db_cr_flg, curr_val, ledger_nar
					doc_date, 'GL' payrec_type, folder_cd, gl_acct_cd, db_cr_flg,  DECODE(DB_CR_FLG,'D','1','-1')*curr_val curr_val, ledger_nar
					FROM T_ACCOUNT_LEDGER
					WHERE approved_sts <> 'C'
					AND approved_sts <> 'E' 
					AND record_source = 'GL'
					AND budget_cd = 'INTREPO'
					AND doc_date >= TO_DATE('$repo_date','YYYY-MM-DD HH24:MI:SS')
					AND doc_date < TO_DATE('$begin_date','YYYY-MM-DD')
					AND sl_acct_cd = '$client_cd'
					AND trim(gl_acct_cd) IN ('2415','1415')
				) P,
				T_REPO_VCH r
				WHERE r.approved_stat <> 'C'
				AND r.doc_num = p.payrec_num
				AND r.doc_ref_num = p.doc_ref_num
				AND r.tal_id = p.tal_id
				AND r.repo_num = '$repo_num'
				AND r.doc_num LIKE '$doc_num'
				AND r.doc_ref_num LIKE '$doc_ref_num'
				and r.doc_dt >= to_date('$repo_date','yyyy-mm-dd  HH24:MI:SS')
				GROUP BY mmyy
				ORDER BY doc_dt DESC, sort ASC";
		
		return $sql;
	}

	public function rules()
	{
		return array(
		
			array('doc_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('tal_id, amt', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('repo_num, doc_num, doc_ref_num, tal_id', 'required'),
			array('tal_id', 'numerical', 'integerOnly'=>true),
			array('amt', 'numerical'),
			array('repo_num, doc_num, doc_ref_num', 'length', 'max'=>17),
			array('user_id', 'length', 'max'=>10),
			array('doc_dt, cre_dt, old_doc_num, old_doc_ref_num, payrec_type, folder_cd, remarks, save_flg, cancel_flg', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('repo_num, doc_num, doc_ref_num, tal_id, amt, doc_dt, user_id, cre_dt,doc_dt_date,doc_dt_month,doc_dt_year,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
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
			'doc_num' => 'Doc Num',
			'doc_ref_num' => 'Doc Ref Num',
			'tal_id' => 'Tal',
			'amt' => 'Amt',
			'doc_dt' => 'Doc Date',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('repo_num',$this->repo_num,true);
		$criteria->compare('doc_num',$this->doc_num,true);
		$criteria->compare('doc_ref_num',$this->doc_ref_num,true);
		$criteria->compare('tal_id',$this->tal_id);
		$criteria->compare('amt',$this->amt);

		if(!empty($this->doc_dt_date))
			$criteria->addCondition("TO_CHAR(t.doc_dt,'DD') LIKE '%".$this->doc_dt_date."%'");
		if(!empty($this->doc_dt_month))
			$criteria->addCondition("TO_CHAR(t.doc_dt,'MM') LIKE '%".$this->doc_dt_month."%'");
		if(!empty($this->doc_dt_year))
			$criteria->addCondition("TO_CHAR(t.doc_dt,'YYYY') LIKE '%".$this->doc_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}