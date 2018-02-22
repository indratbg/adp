<?php

/**
 * This is the model class for table "T_FUND_KSEI".
 *
 * The followings are the available columns in table 'T_FUND_KSEI':
 * @property string $doc_num
 * @property string $doc_date
 * @property string $trx_type
 * @property string $client_cd
 * @property string $brch_cd
 * @property string $source
 * @property string $doc_ref_num
 * @property integer $tal_id_ref
 * @property string $gl_acct_cd
 * @property string $sl_acct_cd
 * @property string $bank_ref_num
 * @property string $bank_mvmt_date
 * @property string $acct_name
 * @property string $remarks
 * @property string $from_client
 * @property string $from_acct
 * @property string $from_bank
 * @property string $to_client
 * @property string $to_acct
 * @property string $to_bank
 * @property double $trx_amt
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_sts
 */
class Tfundksei extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $doc_date_date;
	public $doc_date_month;
	public $doc_date_year;

	public $bank_mvmt_date_date;
	public $bank_mvmt_date_month;
	public $bank_mvmt_date_year;

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
		return 'T_FUND_KSEI';
	}

	public function rules()
	{
		return array(
		
			array('doc_date, bank_mvmt_date, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('tal_id_ref, trx_amt', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('client_cd', 'required'),
			array('tal_id_ref', 'numerical', 'integerOnly'=>true),
			array('trx_amt', 'numerical'),
			array('trx_type, approved_sts', 'length', 'max'=>1),
			array('client_cd, gl_acct_cd, sl_acct_cd, from_client, to_client', 'length', 'max'=>12),
			array('brch_cd', 'length', 'max'=>2),
			array('source, user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('doc_ref_num', 'length', 'max'=>17),
			array('bank_ref_num', 'length', 'max'=>20),
			array('acct_name, remarks', 'length', 'max'=>50),
			array('from_acct, to_acct', 'length', 'max'=>25),
			array('from_bank, to_bank', 'length', 'max'=>30),
			array('doc_date, bank_mvmt_date, cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('doc_num, doc_date, trx_type, client_cd, brch_cd, source, doc_ref_num, tal_id_ref, gl_acct_cd, sl_acct_cd, bank_ref_num, bank_mvmt_date, acct_name, remarks, from_client, from_acct, from_bank, to_client, to_acct, to_bank, trx_amt, cre_dt, user_id, upd_dt, upd_by, approved_dt, approved_by, approved_sts,doc_date_date,doc_date_month,doc_date_year,bank_mvmt_date_date,bank_mvmt_date_month,bank_mvmt_date_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'doc_num' => 'Doc Num',
			'doc_date' => 'Doc Date',
			'trx_type' => 'Trx Type',
			'client_cd' => 'Client Code',
			'brch_cd' => 'Brch Code',
			'source' => 'Source',
			'doc_ref_num' => 'Doc Ref Num',
			'tal_id_ref' => 'Tal Id Ref',
			'gl_acct_cd' => 'Gl Acct Code',
			'sl_acct_cd' => 'Sl Acct Code',
			'bank_ref_num' => 'Bank Ref Num',
			'bank_mvmt_date' => 'Bank Mvmt Date',
			'acct_name' => 'Acct Name',
			'remarks' => 'Remarks',
			'from_client' => 'From Client',
			'from_acct' => 'From Acct',
			'from_bank' => 'From Bank',
			'to_client' => 'To Client',
			'to_acct' => 'To Acct',
			'to_bank' => 'To Bank',
			'trx_amt' => 'Trx Amt',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_sts' => 'Approved Sts',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('doc_num',$this->doc_num,true);

		if(!empty($this->doc_date_date))
			$criteria->addCondition("TO_CHAR(t.doc_date,'DD') LIKE '%".$this->doc_date_date."%'");
		if(!empty($this->doc_date_month))
			$criteria->addCondition("TO_CHAR(t.doc_date,'MM') LIKE '%".$this->doc_date_month."%'");
		if(!empty($this->doc_date_year))
			$criteria->addCondition("TO_CHAR(t.doc_date,'YYYY') LIKE '%".$this->doc_date_year."%'");		$criteria->compare('trx_type',$this->trx_type,true);
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('brch_cd',$this->brch_cd,true);
		$criteria->compare('source',$this->source,true);
		$criteria->compare('doc_ref_num',$this->doc_ref_num,true);
		$criteria->compare('tal_id_ref',$this->tal_id_ref);
		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('sl_acct_cd',$this->sl_acct_cd,true);
		$criteria->compare('bank_ref_num',$this->bank_ref_num,true);

		if(!empty($this->bank_mvmt_date_date))
			$criteria->addCondition("TO_CHAR(t.bank_mvmt_date,'DD') LIKE '%".$this->bank_mvmt_date_date."%'");
		if(!empty($this->bank_mvmt_date_month))
			$criteria->addCondition("TO_CHAR(t.bank_mvmt_date,'MM') LIKE '%".$this->bank_mvmt_date_month."%'");
		if(!empty($this->bank_mvmt_date_year))
			$criteria->addCondition("TO_CHAR(t.bank_mvmt_date,'YYYY') LIKE '%".$this->bank_mvmt_date_year."%'");		$criteria->compare('acct_name',$this->acct_name,true);
		$criteria->compare('remarks',$this->remarks,true);
		$criteria->compare('from_client',$this->from_client,true);
		$criteria->compare('from_acct',$this->from_acct,true);
		$criteria->compare('from_bank',$this->from_bank,true);
		$criteria->compare('to_client',$this->to_client,true);
		$criteria->compare('to_acct',$this->to_acct,true);
		$criteria->compare('to_bank',$this->to_bank,true);
		$criteria->compare('trx_amt',$this->trx_amt);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

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
		$criteria->compare('approved_sts',$this->approved_sts,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}