<?php

/**
 * This is the model class for table "V_REPO_JOURNAL_REF_VCH".
 *
 * The followings are the available columns in table 'V_REPO_JOURNAL_REF_VCH':
 * @property string $payrec_num
 * @property string $payrec_date
 * @property double $payrec_amt
 * @property string $folder_cd
 * @property string $remarks
 * @property string $gl_acct_cd
 * @property string $sl_acct_cd
 */
class Vjournalrefvch extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $payrec_date_date;
	public $payrec_date_month;
	public $payrec_date_year;
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
		return 'V_REPO_JOURNAL_REF_VCH';
	}

	public function rules()
	{
		return array(
		
			array('payrec_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('payrec_amt', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('payrec_amt', 'numerical'),
			array('payrec_num', 'length', 'max'=>17),
			array('folder_cd', 'length', 'max'=>8),
			array('remarks', 'length', 'max'=>50),
			array('gl_acct_cd, sl_acct_cd', 'length', 'max'=>12),
			array('payrec_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('payrec_num, payrec_date, payrec_amt, folder_cd, remarks, gl_acct_cd, sl_acct_cd,payrec_date_date,payrec_date_month,payrec_date_year', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}
    public static function getJournalRefVch($repo_date,$gl_acct_cd, $client_cd )
    {
        $sql=" SELECT a.payrec_num, payrec_date,payrec_amt,folder_cd,remarks,gl_acct_cd,sl_acct_cd, payrec_type, a.doc_ref_num, a.tal_id
              FROM
                (
                  SELECT d.payrec_num, d.payrec_date, DECODE(trim(d.gl_acct_cd),'2415',DECODE(d.db_cr_flg,'C',1,-1), DECODE(d.db_cr_flg,'D',1,-1)) * d.payrec_amt AS payrec_amt, d.payrec_type, h.folder_cd, d.doc_ref_num, d.tal_id, d.remarks,trim(d.gl_acct_cd) AS gl_acct_cd, d.sl_acct_cd
                  FROM t_payrecd d, t_payrech h
                  WHERE d.approved_sts <> 'C'
                  AND h.payrec_num      = d.payrec_num
                  AND (NOT h.folder_cd LIKE 'MJ%')
                  and d.payrec_date>=to_date('$repo_date','yyyy-mm-dd  HH24:MI:SS')
                  and h.payrec_date>=to_date('$repo_date','yyyy-mm-dd  HH24:MI:SS')
                  and d.sl_acct_cd ='$client_cd'
                  and trim(d.gl_acct_cd)='$gl_acct_cd'
                  UNION ALL
                  SELECT xn_doc_num, doc_date, DECODE(trim(gl_acct_cd),'2415',DECODE(db_cr_flg,'C',1,-1), DECODE(db_cr_flg,'D',1,-1)) * curr_val, db_cr_flg||' ',folder_cd, xn_doc_num, tal_id, ledger_nar,trim(gl_acct_cd) AS gl_acct_cd, sl_acct_cd
                  FROM t_account_ledger
                  WHERE approved_sts <> 'C'
                  AND record_source   = 'GL'
                  AND reversal_jur    = 'N'
                  AND (NOT folder_cd LIKE 'MJ%')
                  and doc_date>=to_date('$repo_date','yyyy-mm-dd  HH24:MI:SS')
                  and trim(gl_acct_cd)='$gl_acct_cd'
                )
                a, (
                  SELECT doc_num, doc_ref_num, tal_id
                  FROM T_repo_vch
                  WHERE approved_stat = 'A'
                  and doc_dt >=to_date('$repo_date','yyyy-mm-dd  HH24:MI:SS')
                )
                r
              WHERE a.payrec_num = r.doc_num (+)
              AND a.doc_ref_num  = r.doc_ref_num (+)
              AND a.tal_id       = r.tal_id (+)
              AND r.doc_num     IS NULL
              AND r.doc_ref_num IS NULL
              AND r.tal_id      IS NULL
              AND a.gl_acct_cd  IN
                (
                  SELECT trim(gl_a) FROM V_GL_ACCT_TYPE
                )
              order by a.payrec_num";
      return $sql;
    }
	public function attributeLabels()
	{
		return array(
			'payrec_num' => 'Payrec Num',
			'payrec_date' => 'Payrec Date',
			'payrec_amt' => 'Payrec Amt',
			'folder_cd' => 'Folder Code',
			'remarks' => 'Remarks',
			'gl_acct_cd' => 'Gl Acct Code',
			'sl_acct_cd' => 'Sl Acct Code',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('payrec_num',$this->payrec_num,true);

		if(!empty($this->payrec_date_date))
			$criteria->addCondition("TO_CHAR(t.payrec_date,'DD') LIKE '%".$this->payrec_date_date."%'");
		if(!empty($this->payrec_date_month))
			$criteria->addCondition("TO_CHAR(t.payrec_date,'MM') LIKE '%".$this->payrec_date_month."%'");
		if(!empty($this->payrec_date_year))
			$criteria->addCondition("TO_CHAR(t.payrec_date,'YYYY') LIKE '%".$this->payrec_date_year."%'");		$criteria->compare('payrec_amt',$this->payrec_amt);
		$criteria->compare('folder_cd',$this->folder_cd,true);
		$criteria->compare('remarks',$this->remarks,true);
		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('sl_acct_cd',$this->sl_acct_cd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}