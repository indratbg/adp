<?php

/**
 * This is the model class for table "T_BANK_MUTATION".
 *
 * The followings are the available columns in table 'T_BANK_MUTATION':
 * @property string $kodeab
 * @property string $namaab
 * @property string $rdn
 * @property string $sid
 * @property string $sre
 * @property string $namanasabah
 * @property string $tanggalefektif
 * @property string $tanggaltimestamp
 * @property string $instructionfrom
 * @property string $counterpartaccount
 * @property string $typemutasi
 * @property string $transactiontype
 * @property string $currency
 * @property double $beginningbalance
 * @property double $transactionvalue
 * @property double $closingbalance
 * @property string $remark
 * @property string $bankreference
 * @property string $bankid
 * @property integer $importseq
 * @property string $importdate
 */
class Tbankmutation extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $tanggalefektif_date;
	public $tanggalefektif_month;
	public $tanggalefektif_year;

	public $tanggaltimestamp_date;
	public $tanggaltimestamp_month;
	public $tanggaltimestamp_year;
	public $import_type;
	public $file_upload;
	public $importdate_date;
	public $importdate_month;
	public $importdate_year;
	public $save_flg='N';
	public $safe_flg;
	public $p_bank_cd;
	public $importseq;
	public $data;
	public $vo_fail;
	public $vo_eff_dt;
	public $client_cd;
	public $branch_code;
	public $cifs;
	public $from_dt;
	public $to_dt;
	public $type_mutasi;
	public $branch;
	public $client_name;
	public $update_date;
	public $update_seq;
	public $record_seq;
	public $user_id;
	public $ip_address;
	public $typetext;
	public $remark;
	public $frombank;
	public $input_remark;
	public $tgl_time;
	public $bank_rdi;
	public $acct_stat;
	public $client_fail;
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
		return 'T_BANK_MUTATION';
	}

	public function rules()
	{
		return array(
		
			array('tgl_time,tanggalefektif, tanggaltimestamp, importdate', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('beginningbalance, transactionvalue, closingbalance, importseq', 'application.components.validator.ANumberSwitcherValidator'),
			array('from_dt,to_dt','required','on'=>'filter'),
			array('file_upload','file','types'=>'txt','wrongType'=>'File type must be txt','on'=>'upload'),
			array('sid, sre, namanasabah, tanggaltimestamp, counterpartaccount, typemutasi, currency, remark', 'required','on'=>'post'),
		
			array('importseq', 'numerical', 'integerOnly'=>true),
			array('beginningbalance, transactionvalue, closingbalance', 'numerical'),
			array('kodeab', 'length', 'max'=>5),
			array('namaab', 'length', 'max'=>50),
			array('sid, instructionfrom, counterpartaccount', 'length', 'max'=>15),
			array('sre', 'length', 'max'=>14),
			//array('namanasabah', 'length', 'max'=>25),
			array('typemutasi', 'length', 'max'=>1),
			array('currency', 'length', 'max'=>3),
			array('remark', 'length', 'max'=>36),
			array('acct_stat,bank_rdi,namanasabah,safe_flg,tanggaltimestamp,tgl_time,input_remark,frombank,transactiontype,remark,namaab,kodeab,bankreference,rdn,bankid,importdate,save_flg,file_upload,import_type,client_cd,branch_code,cifs,from_dt,to_dt,type_mutasi,branch,client_name,typetext', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('kodeab, namaab, rdn, sid, sre, namanasabah, tanggalefektif, tanggaltimestamp, instructionfrom, counterpartaccount, typemutasi, transactiontype, currency, beginningbalance, transactionvalue, closingbalance, remark, bankreference, bankid, importseq, importdate,tanggalefektif_date,tanggalefektif_month,tanggalefektif_year,tanggaltimestamp_date,tanggaltimestamp_month,tanggaltimestamp_year,importdate_date,importdate_month,importdate_year', 'safe', 'on'=>'search'),
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
			'kodeab' => 'Kodeab',
			'namaab' => 'Namaab',
			'rdn' => 'Rdn',
			'sid' => 'Sid',
			'sre' => 'Sre',
			'namanasabah' => 'Nama Nasabah',
			'tanggalefektif' => 'Tanggal Efektif',
			'tanggaltimestamp' => 'Tanggal Timestamp',
			'instructionfrom' => 'Instruction From',
			'counterpartaccount' => 'Counterpartaccount',
			'typemutasi' => 'Type Mutasi',
			'transactiontype' => 'Transactiontype',
			'currency' => 'Currency',
			'beginningbalance' => 'Beginning Balance',
			'transactionvalue' => 'Transaction Value',
			'closingbalance' => 'Closing Balance',
			'remark' => 'Remark',
			'bankreference' => 'Bank Reference',
			'bankid' => 'Bankid',
			'importseq' => 'Importseq',
			'importdate' => 'Importdate',
			'file_upload' => '',
			'typemutasi'=>'Type Mutasi'
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

 public function executeSp($bank_cd,$importseq,$data)
	{
		
		$connection  = Yii::app()->db;
		$connection->enableParamLogging = false; //WT disable save data to log
		$transaction = $connection->beginTransaction();

		try{
			$query  = "CALL Sp_Fund_Bank_Mvmt_Import(:p_bank_cd,
												:p_importseq,
												:p_data,
												:vo_eff_dt,
												:VO_FAIL,
												:vo_errcd,
												:vo_errmsg)";

			$command = $connection->createCommand($query);
			
			$command->bindParam(":p_bank_cd",$bank_cd,PDO::PARAM_STR,5);
			$command->bindParam(":p_importseq",$importseq,PDO::PARAM_INT,10);
			$command->bindParam(":p_data",$data,PDO::PARAM_STR,500);
			$command->bindParam(":vo_eff_dt",$this->vo_eff_dt,PDO::PARAM_STR,200);
			$command->bindParam(":vo_fail",$this->vo_fail,PDO::PARAM_INT,10);
			$command->bindParam(":vo_errcd",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":vo_errmsg",$this->error_msg,PDO::PARAM_STR,500);
			
			$command->execute();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->error_code == -999)
				 $this->error_msg = $ex->getMessage();
		 }
		  if($this->error_code < 0)
			$this->addError('vo_errmsg', 'Error '.$this->error_code.' '.$this->error_msg);
		return $this->error_code;
	}

	
	public function executeSpInbox($exec_status,$record_seq)
	{ //echo "<script>alert('test')</script>";
		$connection  = Yii::app()->db;
		
		$this->user_id    = Yii::app()->user->id;
		try{
			$query  = "CALL Sp_MUTASI_RDI_UPD(
									:P_CLIENT_CD,
									:P_BRCH_CD,
									:P_FROMBANK,
									:P_RDN,
									:P_NAMANASABAH,
									TO_DATE(:P_TANGGALEFEKTIF,'YYYY-MM-DD'),
									TO_DATE(:P_TANGGALTIMESTAMP,'YYYY-MM-DD HH24:MI:SS'),
									:P_INSTRUCTIONFROM,
									:P_TYPEMUTASI,
									:P_TRANSACTIONTYPE,
									:P_TRANSACTIONVALUE,
									:P_REMARK,
									:P_BANKREFERENCE,
									:P_BANKID,
									:P_USER_ID,
									:P_UPD_STATUS,
									:p_ip_address,
									:p_cancel_reason,
									TO_DATE(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),
									:p_update_seq,
									:p_record_seq,
									:p_error_code,
									:p_error_msg)";
						
			$command = $connection->createCommand($query);
			/*
			$command->bindValue(":P_SEARCH_RDN",$this->rdn,PDO::PARAM_STR);
						$command->bindValue(":P_SEARCH_BANKREFERENCE",$this->bankreference,PDO::PARAM_STR);
						$command->bindValue(":P_SEARCH_TANGGALEFEKTIF",$this->tanggaltimestamp,PDO::PARAM_STR);
						$command->bindValue(":P_SEARCH_BANKID",$this->bankid,PDO::PARAM_STR);
						$command->bindValue(":P_SEARCH_TRANSACTIONTYPE",$this->transactiontype,PDO::PARAM_STR);*/
			
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BRCH_CD",trim($this->branch_code),PDO::PARAM_STR);
			$command->bindValue(":P_FROMBANK",$this->frombank,PDO::PARAM_STR);
			$command->bindValue(":P_RDN",$this->rdn,PDO::PARAM_STR);
			$command->bindValue(":P_NAMANASABAH",$this->namanasabah,PDO::PARAM_STR);
			$command->bindValue(":P_TANGGALEFEKTIF",$this->tanggalefektif,PDO::PARAM_STR);
			$command->bindValue(":P_TANGGALTIMESTAMP",$this->tgl_time,PDO::PARAM_STR);
			$command->bindValue(":P_INSTRUCTIONFROM",$this->instructionfrom,PDO::PARAM_STR);
			$command->bindValue(":P_TYPEMUTASI",trim($this->typemutasi),PDO::PARAM_STR);
			$command->bindValue(":P_TRANSACTIONTYPE",$this->transactiontype,PDO::PARAM_STR);
			$command->bindValue(":P_TRANSACTIONVALUE",$this->transactionvalue,PDO::PARAM_STR);
			$command->bindValue(":P_REMARK",$this->input_remark,PDO::PARAM_STR);
			$command->bindValue(":P_BANKREFERENCE",$this->bankreference,PDO::PARAM_STR);
			$command->bindValue(":P_BANKID",$this->bankid,PDO::PARAM_STR);
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


	public static function getData($from_dt_fund, $to_dt_fund, $from_dt, $to_dt, $type, $branch, $bank_rdi)
	{
		$cek_broker = Vbrokersubrek::model()->find()->broker_cd;
		$broker_cd = substr($cek_broker, 0,2);
		if($broker_cd =='YJ')
		{
		$sql = "SELECT X.*
				FROM
				  (SELECT a.tanggalefektif,
				    a.TANGGALTimestamp,
				    a.currency,
				    a.InstructionFrom,
				    a.RDN,
				    c.branch_code,
				    c.client_cd,
				    c.client_name,
				    a.namanasabah,
				    a.BEGINNINGBALANCE,
				    a.TRANSACTIONVALUE,
				    a.CLOSINGBALANCE ,
				    a.BANKREFERENCE,
				    'N' Jurnal,
				    b.cnt ,
				    a.bankid,
				    a.transactiontype,
				    f.descrip TYPETEXT ,
				    a.remark,
				    f.descrip default_remark,
				    a.typemutasi ,
				    b.acct_stat,
				    DECODE(a.transactiontype,'NINT',f.ip_bank_cd,'NTAX',f.ip_bank_cd,DECODE(a.InstructionFrom,'0000000000','XXX',f.ip_bank_cd)) frombank
				  FROM
				    (SELECT NVL(bank_ref_num,'X') bank_ref_num,
				      fund_bank_acct AS BANK_ACCT_NUM,
				      doc_Date,
				      sl_acct_cd
				    FROM T_FUND_MOVEMENT a
				    WHERE doc_date BETWEEN to_date('$from_dt_fund','yyyy-mm-dd') AND to_date('$to_dt_fund','yyyy-mm-dd')
				    AND source        = 'MUTASI'
				    AND approved_sts <> 'C'
				    ) d,
				    (SELECT a.*
				    FROM T_BANK_MUTATION a,
				      (SELECT REPLACE(REPLACE(bank_acct_cd,'-',''),'.','') pe_bank_acct
				      FROM MST_BANK_ACCT
				      WHERE bank_acct_cd <> 'X'
				      ) b
				    WHERE a.TanggalEfektif BETWEEN to_date('$from_dt','yyyy-mm-dd') AND to_date('$to_dt','yyyy-mm-dd')
				    AND a.InstructionFrom = pe_bank_acct(+)
				    AND pe_bank_acct     IS NULL
				    ) a,
				    (SELECT BANK_ACCT_NUM,
				      MAX(client_cd) AS client_cd,
				      COUNT(1)       AS cnt,
				      acct_stat
				    FROM MST_CLIENT_FLACCT
				    WHERE acct_stat IN ('A')
				    GROUP BY BANK_ACCT_NUM,
				      acct_stat
				    ) b,
				    (SELECT client_cd,
				      client_name,
				      DECODE(trim(rem_cd),'LOT','LO',DECODE(trim(MST_CLIENT.olt),'N',trim(branch_code),'LO')) branch_finan,
				      branch_code
				    FROM MST_CLIENT
				    ) c,
				    (SELECT t.rdi_trx_type,
				      t.descrip,
				      t.grp,
				      f.ip_bank_cd,
				      t.db_cr_flg
				    FROM MST_RDI_TRX_TYPE t,
				      MST_FUND_BANK f
				    WHERE t.fund_bank_cd = f.bank_cd
				    AND t.grp LIKE '%$type'
				    ) f
				  WHERE a.transactiontype LIKE f.rdi_trx_type
				  AND a.typemutasi                       = f.db_Cr_flg
				  AND b.client_cd                        = c.client_cd
				  AND a.BANKREFERENCE                    = d.bank_ref_num(+)
				  AND d.bank_ref_num                    IS NULL
				  AND a.rdn                              = b.BANK_ACCT_NUM
				  AND a.rdn                              = d.BANK_ACCT_NUM(+)
				  AND d.BANK_ACCT_NUM                   IS NULL
				  AND d.doc_date                        IS NULL
				  AND a.transactiontype                  = d.sl_acct_cd(+)
				  AND d.sl_acct_cd                      IS NULL
				  AND ('$branch'                         = 'All'
				  OR INSTR('$branch',trim(branch_finan)) > 0)
				  )X
				WHERE bankid LIKE '%$bank_rdi'
				ORDER BY client_cd,
				  tanggaltimestamp DESC";
	}
	else if($broker_cd=='MU' || $broker_cd =='PF')
	{
	

		$sql = "SELECT a.TANGGALTimestamp,
				  a.currency,
				  a.InstructionFrom,
				  a.RDN,
				  c.branch_code,
				  c.client_cd,
				  c.client_name,
				  a.BEGINNINGBALANCE,
				  a.TRANSACTIONVALUE,
				  a.CLOSINGBALANCE ,
				  a.BANKREFERENCE,
				  'N' Jurnal,
				  b.cnt,
				  a.tanggalefektif,
				  a.bankid,
				  a.transactiontype,
				  DECODE(a.transactiontype, '198','Tax','160','Interest','Setoran') TypeText,
				  DECODE(a.transactiontype, '198','NGA','160','NGA','005','NGA','XXX') frombank,
				  a.remark,
				  'N' default_remark,
				  a.typemutasi,
				  a.namanasabah
				FROM
				  (SELECT NVL(bank_ref_num,'X') bank_ref_num
				  FROM T_FUND_MOVEMENT
				  WHERE doc_date BETWEEN '$from_dt' AND '$to_dt'
				  AND approved_sts <> 'C'
				  ) d,
				  (SELECT TANGGALTimestamp,
				    currency,
				    InstructionFrom,
				    RDN,
				    BEGINNINGBALANCE,
				    TRANSACTIONVALUE,
				    CLOSINGBALANCE ,
				    BANKREFERENCE,
				    tanggalefektif,
				    bankid,
				    transactiontype,
				    DECODE(transactiontype, '198','Tax','160','Interest','Setoran') TypeText,
				    DECODE(transactiontype, '198','NGA','160','NGA','005','NGA','XXX') frombank,
				    remark,typemutasi, namanasabah
				  FROM T_BANK_MUTATION
				  WHERE TanggalEfektif BETWEEN '$from_dt' AND '$to_dt'
				  AND (TYPEMUTASI            = 'C'
				  OR transactiontype         = '198')
				  AND trim(transactiontype) IN ('1', '11','513','625','160','198')
				  ) a,
				  (SELECT BANK_ACCT_NUM,
				    MAX(client_cd) AS client_cd,
				    COUNT(1)       AS cnt
				  FROM MST_CLIENT_FLACCT
				  WHERE acct_stat <> 'C'
				  GROUP BY BANK_ACCT_NUM
				  ) b,
				  MST_CLIENT c
				WHERE (( a.typetext        = 'Setoran'
				AND '$type'        = 'S')
				OR ( a.typetext           <> 'Setoran'
				AND '$type'        = 'I')
				OR '$type'         = '%')
				AND a.InstructionFrom NOT IN
				  (SELECT REPLACE(REPLACE(bank_acct_cd,'-',''),'.','')
				  FROM MST_BANK_ACCT
				  WHERE bank_acct_cd <> 'X'
				  )
				AND a.rdn                 = b.BANK_ACCT_NUM
				AND b.client_cd           = c.client_cd
				AND ( TRIM(c.branch_code) = substr('$branch',1,2)
				OR '$branch'             = 'All')
				AND a.BANKREFERENCE       = d.bank_ref_num(+)
				AND d.bank_ref_num       IS NULL
				ORDER BY  a.TANGGALTimestamp,
					c.branch_code,
				  c.client_cd,
				  a.TRANSACTIONVALUE DESC
				 
				";
	}
	/*else //untuk pf 
	{
		$sql ="SELECT a.TANGGALTimestamp,
				  a.currency,
				  a.InstructionFrom,
				  a.namanasabah,
				  a.RDN,
				  c.branch_code,
				  c.client_cd,
				  c.client_name,
				  a.BEGINNINGBALANCE,
				  a.TRANSACTIONVALUE,
				  a.CLOSINGBALANCE ,
				  a.BANKREFERENCE,
				  'N' Jurnal,
				  b.cnt,
				  a.tanggalefektif,
				  a.bankid,
				  a.transactiontype,
				  a.typetext,
				  DECODE(a.transactiontype, '198','NGA','160','NGA','005','NGA','XXX') frombank,
				  a.remark,
				  'N' default_remark,
				  a.typemutasi
				FROM
				  (SELECT NVL(bank_ref_num,'X') bank_ref_num
				  FROM T_fund_movement
				  WHERE doc_date BETWEEN to_date('$from_dt','yyyy-mm-dd') AND to_date('$to_dt','yyyy-mm-dd')
				  AND approved_sts <> 'C'
				  ) d,
				  (SELECT a.*,
				    DECODE(a.transactiontype, '198','Tax','160','Interest','Setoran') TypeText
				  FROM t_bank_mutation a
				  ) a,
				  (SELECT BANK_ACCT_NUM,
				    MAX(client_cd) AS client_cd,
				    COUNT(1)       AS cnt
				  FROM mst_client_flacct
				  WHERE acct_stat <> 'C'
				  GROUP BY BANK_ACCT_NUM
				  ) b,
				  mst_client c
				WHERE a.TanggalEfektif BETWEEN to_date('$from_dt','yyyy-mm-dd') AND to_date('$to_dt','yyyy-mm-dd')
				AND (a.TYPEMUTASI          = 'C'
				OR a.transactiontype       = '198')
				AND a.transactiontype     <> '@IP@'
				AND a.InstructionFrom NOT IN
				  (SELECT REPLACE(REPLACE(bank_acct_cd,'-',''),'.','')
				  FROM MST_BANK_ACCT
				  WHERE bank_acct_cd <> 'X'
				  )
				AND a.rdn                = b.BANK_ACCT_NUM
				AND b.client_cd          = c.client_cd
				AND a.BANKREFERENCE      = d.bank_ref_num(+)
				AND d.bank_ref_num      IS NULL
				AND (TRIM(C.BRANCH_CODE) = substr('$branch',1,2)
				OR '$branch'             ='All')
				AND(( typetext           = 'Setoran'
				AND '$type'              = 'S')
				OR ( typetext           <> 'Setoran'
				AND '$type'              = 'I')
				OR '$type'               = '%')
				ORDER BY c.branch_code,
				  c.client_cd,
				  a.TRANSACTIONVALUE DESC,
				  a.TANGGALTimestamp
						";
	}			  
	 */ 
  return $sql;
	}

	
	public static function getCekUnapprove($amt,$client_cd, $doc_date, $bankrefence, $bank_mvmt_date)
	{
		$sql="SELECT *
				FROM
				  (SELECT
				    (SELECT to_date(FIELD_VALUE,'yyyy/mm/dd hh24:mi:ss')
				    FROM T_MANY_DETAIL DA
				    WHERE DA.TABLE_NAME = 'T_FUND_MOVEMENT'
				    AND DA.UPDATE_DATE  = DD.UPDATE_DATE
				    AND DA.UPDATE_SEQ   = DD.UPDATE_SEQ
				    AND DA.FIELD_NAME   = 'DOC_DATE'
				    AND DA.RECORD_SEQ   = DD.RECORD_SEQ
				    ) DOC_DATE,
				    (SELECT FIELD_VALUE
				    FROM T_MANY_DETAIL DA
				    WHERE DA.TABLE_NAME = 'T_FUND_MOVEMENT'
				    AND DA.UPDATE_DATE  = DD.UPDATE_DATE
				    AND DA.UPDATE_SEQ   = DD.UPDATE_SEQ
				    AND DA.FIELD_NAME   = 'CLIENT_CD'
				    AND DA.RECORD_SEQ   = DD.RECORD_SEQ
				    ) CLIENT_CD,
				    (SELECT FIELD_VALUE
				    FROM T_MANY_DETAIL DA
				    WHERE DA.TABLE_NAME = 'T_FUND_MOVEMENT'
				    AND DA.UPDATE_DATE  = DD.UPDATE_DATE
				    AND DA.UPDATE_SEQ   = DD.UPDATE_SEQ
				    AND DA.FIELD_NAME   = 'BANK_REF_NUM'
				    AND DA.RECORD_SEQ   = DD.RECORD_SEQ
				    ) BANK_REF_NUM,
				    (SELECT FIELD_VALUE
				    FROM T_MANY_DETAIL DA
				    WHERE DA.TABLE_NAME = 'T_FUND_MOVEMENT'
				    AND DA.UPDATE_DATE  = DD.UPDATE_DATE
				    AND DA.UPDATE_SEQ   = DD.UPDATE_SEQ
				    AND DA.FIELD_NAME   = 'BANK_MVMT_DATE'
				    AND DA.RECORD_SEQ   = DD.RECORD_SEQ
				    ) BANK_MVMT_DATE,
				    (SELECT FIELD_VALUE
				    FROM T_MANY_DETAIL DA
				    WHERE DA.TABLE_NAME = 'T_FUND_MOVEMENT'
				    AND DA.UPDATE_DATE  = DD.UPDATE_DATE
				    AND DA.UPDATE_SEQ   = DD.UPDATE_SEQ
				    AND DA.FIELD_NAME   = 'TRX_AMT'
				    AND DA.RECORD_SEQ   = DD.RECORD_SEQ
				    ) TRX_AMT,
				    HH.APPROVED_STATUS,
				    HH.MENU_NAME
				  FROM T_MANY_DETAIL DD,
				    T_MANY_HEADER HH
				  WHERE DD.TABLE_NAME    = 'T_FUND_MOVEMENT'
				  AND DD.UPDATE_DATE     = HH.UPDATE_DATE
				  AND DD.UPDATE_SEQ      = HH.UPDATE_SEQ
				   AND HH.UPDATE_DATE >TRUNC(SYSDATE)-10
				  AND DD.RECORD_SEQ      = 1
				  AND DD.FIELD_NAME      = 'DOC_DATE'
				  AND HH.APPROVED_STATUS = 'E'
				  )
				WHERE TRX_AMT     ='$amt'
				AND client_cd     = '$client_cd'
				AND doc_date      = to_date('$doc_date','yyyy-mm-dd')
				AND bank_ref_num  = '$bankrefence'
				AND bank_mvmt_date='$bank_mvmt_date'";
				
			return $sql;
	}
	
	
	
	/*
	public function approveMutasiBca()
	{
		$connection  = Yii::app()->db;
		//$transaction = $connection->beginTransaction();	
		$menuName = 'UPLOAD RDN MUTATION';
		try{
			$this->logRecord();
			$query  = "CALL SP_FL_BCA_INTEREST_APPROVE(
						TO_DATE(:p_tanggalefektif,'YYYY-MM-DD'),
						:P_CLIENT_CD,
						:P_TRANSACTIONTYPE,
						:P_MENU_NAME,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPDDATE_SEQ,
						:P_APPROVED_USER_ID,
						:P_APPROVED_IP_ADDRESS,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			$command = $connection->createCommand($query);
			$command->bindValue(":p_tanggalefektif",$this->tanggalefektif,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_TRANSACTIONTYPE",$this->transactiontype,PDO::PARAM_STR);
			$command->bindValue(":P_MENU_NAME",$menuName,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_APPROVED_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_APPROVED_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_STR,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,200);
			$command->execute();
			//$transaction->commit();
		}catch(Exception $ex){
			//$transaction->rollback();
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}
	private function logRecord()
	{
		$ip = Yii::app()->request->userHostAddress;
		if($ip=="::1")
			$ip = '127.0.0.1';
		
		$this->ip_address = $ip;
		$this->user_id    = Yii::app()->user->id;
	}
	 * 
	 */
	public function executeInterest($menuName,$from_dt_fund, $to_dt_fund)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_MUTASI_RDI_BCA_INTEREST( :P_USER_ID,
														:P_IP_ADDRESS,
														:P_MENU_NAME,
														TO_DATE(:P_FROM_DT,'YYYY-MM-DD'),
														TO_DATE(:P_TO_DT,'YYYY-MM-DD'),
														TO_DATE(:P_FROM_DT_FUND,'YYYY-MM-DD'),
													 	TO_DATE(:P_TO_DT_FUND,'YYYY-MM-DD'),
														:P_BRANCH,
														:P_BANK_RDI,
														:p_client_fail,
														:P_ERROR_CD ,
														:P_ERROR_MSG)";
			
						
			$command = $connection->createCommand($query);
		//	$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
		//	$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_MENU_NAME",$menuName,PDO::PARAM_STR);
			$command->bindValue(":P_FROM_DT",$this->from_dt,PDO::PARAM_STR);
			$command->bindValue(":P_TO_DT",$this->to_dt,PDO::PARAM_STR);
			$command->bindValue(":P_FROM_DT_FUND",$from_dt_fund,PDO::PARAM_STR);
			$command->bindValue(":P_TO_DT_FUND",$to_dt_fund,PDO::PARAM_STR);
			//$command->bindValue(":P_TYPE",$this->type_mutasi,PDO::PARAM_STR);			
			$command->bindValue(":P_BRANCH",$this->branch,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_RDI",$this->bank_rdi,PDO::PARAM_STR);
			$command->bindParam(":p_client_fail",$this->client_fail,PDO::PARAM_STR,1000);
			$command->bindParam(":P_ERROR_CD",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			
			//Commit baru akan dijalankan saat semua transaksi INSERT sukses
			
		}catch(Exception $ex){
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->client_fail)Yii::app()->user->setFlash('danger', $this->client_fail);
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}
	
	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('kodeab',$this->kodeab,true);
		$criteria->compare('namaab',$this->namaab,true);
		$criteria->compare('rdn',$this->rdn,true);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('sre',$this->sre,true);
		$criteria->compare('namanasabah',$this->namanasabah,true);

		if(!empty($this->tanggalefektif_date))
			$criteria->addCondition("TO_CHAR(t.tanggalefektif,'DD') LIKE '%".$this->tanggalefektif_date."%'");
		if(!empty($this->tanggalefektif_month))
			$criteria->addCondition("TO_CHAR(t.tanggalefektif,'MM') LIKE '%".$this->tanggalefektif_month."%'");
		if(!empty($this->tanggalefektif_year))
			$criteria->addCondition("TO_CHAR(t.tanggalefektif,'YYYY') LIKE '%".$this->tanggalefektif_year."%'");
		if(!empty($this->tanggaltimestamp_date))
			$criteria->addCondition("TO_CHAR(t.tanggaltimestamp,'DD') LIKE '%".$this->tanggaltimestamp_date."%'");
		if(!empty($this->tanggaltimestamp_month))
			$criteria->addCondition("TO_CHAR(t.tanggaltimestamp,'MM') LIKE '%".$this->tanggaltimestamp_month."%'");
		if(!empty($this->tanggaltimestamp_year))
			$criteria->addCondition("TO_CHAR(t.tanggaltimestamp,'YYYY') LIKE '%".$this->tanggaltimestamp_year."%'");		$criteria->compare('instructionfrom',$this->instructionfrom,true);
		$criteria->compare('counterpartaccount',$this->counterpartaccount,true);
		$criteria->compare('typemutasi',$this->typemutasi,true);
		$criteria->compare('transactiontype',$this->transactiontype,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('beginningbalance',$this->beginningbalance);
		$criteria->compare('transactionvalue',$this->transactionvalue);
		$criteria->compare('closingbalance',$this->closingbalance);
		$criteria->compare('remark',$this->remark,true);
		$criteria->compare('bankreference',$this->bankreference,true);
		$criteria->compare('bankid',$this->bankid,true);
		$criteria->compare('importseq',$this->importseq);

		if(!empty($this->importdate_date))
			$criteria->addCondition("TO_CHAR(t.importdate,'DD') LIKE '%".$this->importdate_date."%'");
		if(!empty($this->importdate_month))
			$criteria->addCondition("TO_CHAR(t.importdate,'MM') LIKE '%".$this->importdate_month."%'");
		if(!empty($this->importdate_year))
			$criteria->addCondition("TO_CHAR(t.importdate,'YYYY') LIKE '%".$this->importdate_year."%'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}