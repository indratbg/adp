<?php

/**
 * This is the model class for table "R_TRADE_CONF".
 *
 * The followings are the available columns in table 'R_TRADE_CONF':
 * @property integer $rand_value
 * @property string $userid
 * @property string $generate_date
 * @property string $client_name
 * @property string $contact_pers
 * @property string $old_ic_num
 * @property string $def_addr_1
 * @property string $def_addr_2
 * @property string $def_addr_3
 * @property string $post_cd
 * @property string $phone_num
 * @property string $phone2_1
 * @property string $hp_num
 * @property string $fax_num
 * @property string $hand_phone1
 * @property string $e_mail1
 * @property string $print_flg
 * @property string $client_title
 * @property string $branch_code
 * @property string $brch_name
 * @property string $brch_acct_num
 * @property string $bank_name
 * @property string $short_bank_name
 * @property string $brch_phone
 * @property string $brch_fax
 * @property string $brch_addr_1
 * @property string $brch_addr_2
 * @property string $brch_addr_3
 * @property string $dealing_phone
 * @property string $br_post_cd
 * @property string $rem_name
 * @property string $nama_prsh
 * @property string $no_ijin1
 * @property string $client_bank_name
 * @property string $client_bank_acct
 * @property string $client_bank
 * @property string $tc_id
 * @property string $npwp_no
 * @property string $sid
 * @property string $subrek001
 * @property string $bank_rdi_acct
 * @property string $rdi_name
 * @property string $bank_rdi
 * @property string $mrkt_t3
 * @property string $mrkt_t2
 * @property string $mrkt_t1
 * @property string $mrkt_t0
 * @property string $contr_dt
 * @property string $r_i
 * @property string $client_cd
 * @property string $beli_jual
 * @property string $stk_cd
 * @property string $status
 * @property integer $lot_size
 * @property integer $qty
 * @property double $price
 * @property double $brok_perc
 * @property double $whpph23_perc
 * @property string $brch_cd
 * @property string $rem_cd
 * @property double $b_val
 * @property double $j_val
 * @property double $b_comm
 * @property double $j_comm
 * @property double $b_vat
 * @property double $j_vat
 * @property double $b_levy
 * @property double $j_levy
 * @property double $b_pph
 * @property double $j_pph
 * @property double $b_whpph23
 * @property double $j_whpph23
 * @property double $pph_perc
 * @property string $mrkt_type
 * @property string $due_dt_for_amt
 * @property string $kpei_due_dt
 * @property double $sum_b_t3
 * @property double $sum_j_t3
 * @property double $sum_b_t2
 * @property double $sum_j_t2
 * @property double $sum_b_t1
 * @property double $sum_j_t1
 * @property double $sum_b_t0
 * @property double $sum_j_t0
 * @property double $max_3plus
 * @property string $due_t3
 * @property string $due_t2
 * @property string $due_t1
 * @property string $max_rg_t3
 * @property string $max_rg_t2
 * @property string $max_rg_t1
 * @property string $max_rg_t0
 * @property string $max_ng_t3
 * @property string $max_ng_t2
 * @property string $max_ng_t1
 * @property string $max_ng_t0
 * @property double $sum_b_amt
 * @property double $sum_j_amt
 * @property double $sum_b_val
 * @property double $sum_j_val
 * @property double $sum_b_comm
 * @property double $sum_j_comm
 * @property double $sum_b_vat
 * @property double $sum_j_vat
 * @property double $sum_b_levy
 * @property double $sum_j_levy
 * @property double $sum_b_pph
 * @property double $sum_j_pph
 * @property double $sum_b_whpph23
 * @property double $sum_j_whpph23
 */
class Rtradeconf extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $generate_date_date;
	public $generate_date_month;
	public $generate_date_year;

	public $contr_dt_date;
	public $contr_dt_month;
	public $contr_dt_year;

	public $due_dt_for_amt_date;
	public $due_dt_for_amt_month;
	public $due_dt_for_amt_year;

	public $kpei_due_dt_date;
	public $kpei_due_dt_month;
	public $kpei_due_dt_year;

	public $due_t3_date;
	public $due_t3_month;
	public $due_t3_year;

	public $due_t2_date;
	public $due_t2_month;
	public $due_t2_year;

	public $due_t1_date;
	public $due_t1_month;
	public $due_t1_year;
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
		return 'INSISTPRO_RPT.R_TRADE_CONF';
	}

	public function rules()
	{
		return array(
		
			array('generate_date, contr_dt, due_dt_for_amt, kpei_due_dt, due_t3, due_t2, due_t1', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('rand_value, lot_size, qty, price, brok_perc, whpph23_perc, b_val, j_val, b_comm, j_comm, b_vat, j_vat, b_levy, j_levy, b_pph, j_pph, b_whpph23, j_whpph23, pph_perc, sum_b_t3, sum_j_t3, sum_b_t2, sum_j_t2, sum_b_t1, sum_j_t1, sum_b_t0, sum_j_t0, max_3plus, sum_b_amt, sum_j_amt, sum_b_val, sum_j_val, sum_b_comm, sum_j_comm, sum_b_vat, sum_j_vat, sum_b_levy, sum_j_levy, sum_b_pph, sum_j_pph, sum_b_whpph23, sum_j_whpph23', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('rand_value, lot_size, qty', 'numerical', 'integerOnly'=>true),
			array('price, brok_perc, whpph23_perc, b_val, j_val, b_comm, j_comm, b_vat, j_vat, b_levy, j_levy, b_pph, j_pph, b_whpph23, j_whpph23, pph_perc, sum_b_t3, sum_j_t3, sum_b_t2, sum_j_t2, sum_b_t1, sum_j_t1, sum_b_t0, sum_j_t0, max_3plus, sum_b_amt, sum_j_amt, sum_b_val, sum_j_val, sum_b_comm, sum_j_comm, sum_b_vat, sum_j_vat, sum_b_levy, sum_j_levy, sum_b_pph, sum_j_pph, sum_b_whpph23, sum_j_whpph23', 'numerical'),
			array('userid', 'length', 'max'=>100),
			array('client_name, contact_pers, e_mail1, bank_name, brch_addr_1, brch_addr_2, rem_name, nama_prsh, client_bank_name, rdi_name, stk_cd', 'length', 'max'=>50),
			array('old_ic_num, def_addr_1, def_addr_2, def_addr_3, brch_name, brch_addr_3, client_bank_acct, bank_rdi_acct', 'length', 'max'=>30),
			array('post_cd, client_title, br_post_cd', 'length', 'max'=>6),
			array('phone_num, phone2_1, hp_num, fax_num, hand_phone1, brch_phone, brch_fax, dealing_phone, npwp_no, sid, bank_rdi', 'length', 'max'=>15),
			array('print_flg, r_i, beli_jual, status', 'length', 'max'=>1),
			array('branch_code, brch_cd, rem_cd', 'length', 'max'=>3),
			array('brch_acct_num, no_ijin1', 'length', 'max'=>25),
			array('short_bank_name', 'length', 'max'=>20),
			array('client_bank', 'length', 'max'=>255),
			array('tc_id', 'length', 'max'=>65),
			array('subrek001', 'length', 'max'=>14),
			array('mrkt_t3, mrkt_t2, mrkt_t1, mrkt_t0', 'length', 'max'=>5),
			array('client_cd', 'length', 'max'=>12),
			array('mrkt_type, max_rg_t3, max_rg_t2, max_rg_t1, max_rg_t0, max_ng_t3, max_ng_t2, max_ng_t1, max_ng_t0', 'length', 'max'=>2),
			array('generate_date, contr_dt, due_dt_for_amt, kpei_due_dt, due_t3, due_t2, due_t1', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('rand_value, userid, generate_date, client_name, contact_pers, old_ic_num, def_addr_1, def_addr_2, def_addr_3, post_cd, phone_num, phone2_1, hp_num, fax_num, hand_phone1, e_mail1, print_flg, client_title, branch_code, brch_name, brch_acct_num, bank_name, short_bank_name, brch_phone, brch_fax, brch_addr_1, brch_addr_2, brch_addr_3, dealing_phone, br_post_cd, rem_name, nama_prsh, no_ijin1, client_bank_name, client_bank_acct, client_bank, tc_id, npwp_no, sid, subrek001, bank_rdi_acct, rdi_name, bank_rdi, mrkt_t3, mrkt_t2, mrkt_t1, mrkt_t0, contr_dt, r_i, client_cd, beli_jual, stk_cd, status, lot_size, qty, price, brok_perc, whpph23_perc, brch_cd, rem_cd, b_val, j_val, b_comm, j_comm, b_vat, j_vat, b_levy, j_levy, b_pph, j_pph, b_whpph23, j_whpph23, pph_perc, mrkt_type, due_dt_for_amt, kpei_due_dt, sum_b_t3, sum_j_t3, sum_b_t2, sum_j_t2, sum_b_t1, sum_j_t1, sum_b_t0, sum_j_t0, max_3plus, due_t3, due_t2, due_t1, max_rg_t3, max_rg_t2, max_rg_t1, max_rg_t0, max_ng_t3, max_ng_t2, max_ng_t1, max_ng_t0, sum_b_amt, sum_j_amt, sum_b_val, sum_j_val, sum_b_comm, sum_j_comm, sum_b_vat, sum_j_vat, sum_b_levy, sum_j_levy, sum_b_pph, sum_j_pph, sum_b_whpph23, sum_j_whpph23,generate_date_date,generate_date_month,generate_date_year,contr_dt_date,contr_dt_month,contr_dt_year,due_dt_for_amt_date,due_dt_for_amt_month,due_dt_for_amt_year,kpei_due_dt_date,kpei_due_dt_month,kpei_due_dt_year,due_t3_date,due_t3_month,due_t3_year,due_t2_date,due_t2_month,due_t2_year,due_t1_date,due_t1_month,due_t1_year', 'safe', 'on'=>'search'),
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
			'rand_value' => 'Rand Value',
			'userid' => 'Userid',
			'generate_date' => 'Generate Date',
			'client_name' => 'Client Name',
			'contact_pers' => 'Contact Pers',
			'old_ic_num' => 'Old Ic Num',
			'def_addr_1' => 'Def Addr 1',
			'def_addr_2' => 'Def Addr 2',
			'def_addr_3' => 'Def Addr 3',
			'post_cd' => 'Post Code',
			'phone_num' => 'Phone Num',
			'phone2_1' => 'Phone2 1',
			'hp_num' => 'Hp Num',
			'fax_num' => 'Fax Num',
			'hand_phone1' => 'Hand Phone1',
			'e_mail1' => 'E Mail1',
			'print_flg' => 'Print Flg',
			'client_title' => 'Client Title',
			'branch_code' => 'Branch Code',
			'brch_name' => 'Brch Name',
			'brch_acct_num' => 'Brch Acct Num',
			'bank_name' => 'Bank Name',
			'short_bank_name' => 'Short Bank Name',
			'brch_phone' => 'Brch Phone',
			'brch_fax' => 'Brch Fax',
			'brch_addr_1' => 'Brch Addr 1',
			'brch_addr_2' => 'Brch Addr 2',
			'brch_addr_3' => 'Brch Addr 3',
			'dealing_phone' => 'Dealing Phone',
			'br_post_cd' => 'Br Post Code',
			'rem_name' => 'Rem Name',
			'nama_prsh' => 'Nama Prsh',
			'no_ijin1' => 'No Ijin1',
			'client_bank_name' => 'Client Bank Name',
			'client_bank_acct' => 'Client Bank Acct',
			'client_bank' => 'Client Bank',
			'tc_id' => 'Tc',
			'npwp_no' => 'Npwp No',
			'sid' => 'Sid',
			'subrek001' => 'Subrek001',
			'bank_rdi_acct' => 'Bank Rdi Acct',
			'rdi_name' => 'Rdi Name',
			'bank_rdi' => 'Bank Rdi',
			'mrkt_t3' => 'Mrkt T3',
			'mrkt_t2' => 'Mrkt T2',
			'mrkt_t1' => 'Mrkt T1',
			'mrkt_t0' => 'Mrkt T0',
			'contr_dt' => 'Contr Date',
			'r_i' => 'R I',
			'client_cd' => 'Client Code',
			'beli_jual' => 'Beli Jual',
			'stk_cd' => 'Stk Code',
			'status' => 'Status',
			'lot_size' => 'Lot Size',
			'qty' => 'Qty',
			'price' => 'Price',
			'brok_perc' => 'Brok Perc',
			'whpph23_perc' => 'Whpph23 Perc',
			'brch_cd' => 'Brch Code',
			'rem_cd' => 'Rem Code',
			'b_val' => 'B Val',
			'j_val' => 'J Val',
			'b_comm' => 'B Comm',
			'j_comm' => 'J Comm',
			'b_vat' => 'B Vat',
			'j_vat' => 'J Vat',
			'b_levy' => 'B Levy',
			'j_levy' => 'J Levy',
			'b_pph' => 'B Pph',
			'j_pph' => 'J Pph',
			'b_whpph23' => 'B Whpph23',
			'j_whpph23' => 'J Whpph23',
			'pph_perc' => 'Pph Perc',
			'mrkt_type' => 'Mrkt Type',
			'due_dt_for_amt' => 'Due Date For Amt',
			'kpei_due_dt' => 'Kpei Due Date',
			'sum_b_t3' => 'Sum B T3',
			'sum_j_t3' => 'Sum J T3',
			'sum_b_t2' => 'Sum B T2',
			'sum_j_t2' => 'Sum J T2',
			'sum_b_t1' => 'Sum B T1',
			'sum_j_t1' => 'Sum J T1',
			'sum_b_t0' => 'Sum B T0',
			'sum_j_t0' => 'Sum J T0',
			'max_3plus' => 'Max 3plus',
			'due_t3' => 'Due T3',
			'due_t2' => 'Due T2',
			'due_t1' => 'Due T1',
			'max_rg_t3' => 'Max Rg T3',
			'max_rg_t2' => 'Max Rg T2',
			'max_rg_t1' => 'Max Rg T1',
			'max_rg_t0' => 'Max Rg T0',
			'max_ng_t3' => 'Max Ng T3',
			'max_ng_t2' => 'Max Ng T2',
			'max_ng_t1' => 'Max Ng T1',
			'max_ng_t0' => 'Max Ng T0',
			'sum_b_amt' => 'Sum B Amt',
			'sum_j_amt' => 'Sum J Amt',
			'sum_b_val' => 'Sum B Val',
			'sum_j_val' => 'Sum J Val',
			'sum_b_comm' => 'Sum B Comm',
			'sum_j_comm' => 'Sum J Comm',
			'sum_b_vat' => 'Sum B Vat',
			'sum_j_vat' => 'Sum J Vat',
			'sum_b_levy' => 'Sum B Levy',
			'sum_j_levy' => 'Sum J Levy',
			'sum_b_pph' => 'Sum B Pph',
			'sum_j_pph' => 'Sum J Pph',
			'sum_b_whpph23' => 'Sum B Whpph23',
			'sum_j_whpph23' => 'Sum J Whpph23',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('rand_value',$this->rand_value);
		$criteria->compare('userid',$this->userid,true);

		if(!empty($this->generate_date_date))
			$criteria->addCondition("TO_CHAR(t.generate_date,'DD') LIKE '%".$this->generate_date_date."%'");
		if(!empty($this->generate_date_month))
			$criteria->addCondition("TO_CHAR(t.generate_date,'MM') LIKE '%".$this->generate_date_month."%'");
		if(!empty($this->generate_date_year))
			$criteria->addCondition("TO_CHAR(t.generate_date,'YYYY') LIKE '%".$this->generate_date_year."%'");		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('contact_pers',$this->contact_pers,true);
		$criteria->compare('old_ic_num',$this->old_ic_num,true);
		$criteria->compare('def_addr_1',$this->def_addr_1,true);
		$criteria->compare('def_addr_2',$this->def_addr_2,true);
		$criteria->compare('def_addr_3',$this->def_addr_3,true);
		$criteria->compare('post_cd',$this->post_cd,true);
		$criteria->compare('phone_num',$this->phone_num,true);
		$criteria->compare('phone2_1',$this->phone2_1,true);
		$criteria->compare('hp_num',$this->hp_num,true);
		$criteria->compare('fax_num',$this->fax_num,true);
		$criteria->compare('hand_phone1',$this->hand_phone1,true);
		$criteria->compare('e_mail1',$this->e_mail1,true);
		$criteria->compare('print_flg',$this->print_flg,true);
		$criteria->compare('client_title',$this->client_title,true);
		$criteria->compare('branch_code',$this->branch_code,true);
		$criteria->compare('brch_name',$this->brch_name,true);
		$criteria->compare('brch_acct_num',$this->brch_acct_num,true);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('short_bank_name',$this->short_bank_name,true);
		$criteria->compare('brch_phone',$this->brch_phone,true);
		$criteria->compare('brch_fax',$this->brch_fax,true);
		$criteria->compare('brch_addr_1',$this->brch_addr_1,true);
		$criteria->compare('brch_addr_2',$this->brch_addr_2,true);
		$criteria->compare('brch_addr_3',$this->brch_addr_3,true);
		$criteria->compare('dealing_phone',$this->dealing_phone,true);
		$criteria->compare('br_post_cd',$this->br_post_cd,true);
		$criteria->compare('rem_name',$this->rem_name,true);
		$criteria->compare('nama_prsh',$this->nama_prsh,true);
		$criteria->compare('no_ijin1',$this->no_ijin1,true);
		$criteria->compare('client_bank_name',$this->client_bank_name,true);
		$criteria->compare('client_bank_acct',$this->client_bank_acct,true);
		$criteria->compare('client_bank',$this->client_bank,true);
		$criteria->compare('tc_id',$this->tc_id,true);
		$criteria->compare('npwp_no',$this->npwp_no,true);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('subrek001',$this->subrek001,true);
		$criteria->compare('bank_rdi_acct',$this->bank_rdi_acct,true);
		$criteria->compare('rdi_name',$this->rdi_name,true);
		$criteria->compare('bank_rdi',$this->bank_rdi,true);
		$criteria->compare('mrkt_t3',$this->mrkt_t3,true);
		$criteria->compare('mrkt_t2',$this->mrkt_t2,true);
		$criteria->compare('mrkt_t1',$this->mrkt_t1,true);
		$criteria->compare('mrkt_t0',$this->mrkt_t0,true);

		if(!empty($this->contr_dt_date))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'DD') LIKE '%".$this->contr_dt_date."%'");
		if(!empty($this->contr_dt_month))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'MM') LIKE '%".$this->contr_dt_month."%'");
		if(!empty($this->contr_dt_year))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'YYYY') LIKE '%".$this->contr_dt_year."%'");		$criteria->compare('r_i',$this->r_i,true);
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('beli_jual',$this->beli_jual,true);
		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('lot_size',$this->lot_size);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('price',$this->price);
		$criteria->compare('brok_perc',$this->brok_perc);
		$criteria->compare('whpph23_perc',$this->whpph23_perc);
		$criteria->compare('brch_cd',$this->brch_cd,true);
		$criteria->compare('rem_cd',$this->rem_cd,true);
		$criteria->compare('b_val',$this->b_val);
		$criteria->compare('j_val',$this->j_val);
		$criteria->compare('b_comm',$this->b_comm);
		$criteria->compare('j_comm',$this->j_comm);
		$criteria->compare('b_vat',$this->b_vat);
		$criteria->compare('j_vat',$this->j_vat);
		$criteria->compare('b_levy',$this->b_levy);
		$criteria->compare('j_levy',$this->j_levy);
		$criteria->compare('b_pph',$this->b_pph);
		$criteria->compare('j_pph',$this->j_pph);
		$criteria->compare('b_whpph23',$this->b_whpph23);
		$criteria->compare('j_whpph23',$this->j_whpph23);
		$criteria->compare('pph_perc',$this->pph_perc);
		$criteria->compare('mrkt_type',$this->mrkt_type,true);

		if(!empty($this->due_dt_for_amt_date))
			$criteria->addCondition("TO_CHAR(t.due_dt_for_amt,'DD') LIKE '%".$this->due_dt_for_amt_date."%'");
		if(!empty($this->due_dt_for_amt_month))
			$criteria->addCondition("TO_CHAR(t.due_dt_for_amt,'MM') LIKE '%".$this->due_dt_for_amt_month."%'");
		if(!empty($this->due_dt_for_amt_year))
			$criteria->addCondition("TO_CHAR(t.due_dt_for_amt,'YYYY') LIKE '%".$this->due_dt_for_amt_year."%'");
		if(!empty($this->kpei_due_dt_date))
			$criteria->addCondition("TO_CHAR(t.kpei_due_dt,'DD') LIKE '%".$this->kpei_due_dt_date."%'");
		if(!empty($this->kpei_due_dt_month))
			$criteria->addCondition("TO_CHAR(t.kpei_due_dt,'MM') LIKE '%".$this->kpei_due_dt_month."%'");
		if(!empty($this->kpei_due_dt_year))
			$criteria->addCondition("TO_CHAR(t.kpei_due_dt,'YYYY') LIKE '%".$this->kpei_due_dt_year."%'");		$criteria->compare('sum_b_t3',$this->sum_b_t3);
		$criteria->compare('sum_j_t3',$this->sum_j_t3);
		$criteria->compare('sum_b_t2',$this->sum_b_t2);
		$criteria->compare('sum_j_t2',$this->sum_j_t2);
		$criteria->compare('sum_b_t1',$this->sum_b_t1);
		$criteria->compare('sum_j_t1',$this->sum_j_t1);
		$criteria->compare('sum_b_t0',$this->sum_b_t0);
		$criteria->compare('sum_j_t0',$this->sum_j_t0);
		$criteria->compare('max_3plus',$this->max_3plus);

		if(!empty($this->due_t3_date))
			$criteria->addCondition("TO_CHAR(t.due_t3,'DD') LIKE '%".$this->due_t3_date."%'");
		if(!empty($this->due_t3_month))
			$criteria->addCondition("TO_CHAR(t.due_t3,'MM') LIKE '%".$this->due_t3_month."%'");
		if(!empty($this->due_t3_year))
			$criteria->addCondition("TO_CHAR(t.due_t3,'YYYY') LIKE '%".$this->due_t3_year."%'");
		if(!empty($this->due_t2_date))
			$criteria->addCondition("TO_CHAR(t.due_t2,'DD') LIKE '%".$this->due_t2_date."%'");
		if(!empty($this->due_t2_month))
			$criteria->addCondition("TO_CHAR(t.due_t2,'MM') LIKE '%".$this->due_t2_month."%'");
		if(!empty($this->due_t2_year))
			$criteria->addCondition("TO_CHAR(t.due_t2,'YYYY') LIKE '%".$this->due_t2_year."%'");
		if(!empty($this->due_t1_date))
			$criteria->addCondition("TO_CHAR(t.due_t1,'DD') LIKE '%".$this->due_t1_date."%'");
		if(!empty($this->due_t1_month))
			$criteria->addCondition("TO_CHAR(t.due_t1,'MM') LIKE '%".$this->due_t1_month."%'");
		if(!empty($this->due_t1_year))
			$criteria->addCondition("TO_CHAR(t.due_t1,'YYYY') LIKE '%".$this->due_t1_year."%'");		$criteria->compare('max_rg_t3',$this->max_rg_t3,true);
		$criteria->compare('max_rg_t2',$this->max_rg_t2,true);
		$criteria->compare('max_rg_t1',$this->max_rg_t1,true);
		$criteria->compare('max_rg_t0',$this->max_rg_t0,true);
		$criteria->compare('max_ng_t3',$this->max_ng_t3,true);
		$criteria->compare('max_ng_t2',$this->max_ng_t2,true);
		$criteria->compare('max_ng_t1',$this->max_ng_t1,true);
		$criteria->compare('max_ng_t0',$this->max_ng_t0,true);
		$criteria->compare('sum_b_amt',$this->sum_b_amt);
		$criteria->compare('sum_j_amt',$this->sum_j_amt);
		$criteria->compare('sum_b_val',$this->sum_b_val);
		$criteria->compare('sum_j_val',$this->sum_j_val);
		$criteria->compare('sum_b_comm',$this->sum_b_comm);
		$criteria->compare('sum_j_comm',$this->sum_j_comm);
		$criteria->compare('sum_b_vat',$this->sum_b_vat);
		$criteria->compare('sum_j_vat',$this->sum_j_vat);
		$criteria->compare('sum_b_levy',$this->sum_b_levy);
		$criteria->compare('sum_j_levy',$this->sum_j_levy);
		$criteria->compare('sum_b_pph',$this->sum_b_pph);
		$criteria->compare('sum_j_pph',$this->sum_j_pph);
		$criteria->compare('sum_b_whpph23',$this->sum_b_whpph23);
		$criteria->compare('sum_j_whpph23',$this->sum_j_whpph23);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}