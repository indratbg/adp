<?php

/**
 * This is the model class for table "T_CASH_DIVIDEN".
 *
 * The followings are the available columns in table 'T_CASH_DIVIDEN':
 * @property string $ca_type
 * @property string $stk_cd
 * @property string $distrib_dt
 * @property string $client_cd
 * @property integer $qty
 * @property double $rate
 * @property double $gross_amt
 * @property integer $tax_pcn
 * @property double $tax_amt
 * @property double $div_amt
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 * @property string $rvpv_number
 */
class Tcashdividen extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $distrib_dt_date;
	public $distrib_dt_month;
	public $distrib_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	public $type_vch;
	public $vch_number;
	public $record_date;
	public $vch_date;
	public $gl_acct_cd;
	public $sl_acct_cd;
	public $file_no;
	public $remarks;
	public $stock_code;
	public $cum_date1;
	public $update_date;
	public $update_seq;
	public $today_date;
	public $check_cum_date;
	public $check_today_date;
	public $recording_dt;
	public $check;
	public $branch_cd;
	public $brch_cd;
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
		return 'T_CASH_DIVIDEN';
	}

	public function rules()
	{
		return array(
		
			array('today_date,update_date,cum_date1,record_date,vch_date,cum_date,distrib_dt, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('qty, rate, gross_amt, tax_pcn, tax_amt, div_amt', 'application.components.validator.ANumberSwitcherValidator'),
			array('gl_acct_cd,vch_date,remarks','required','on'=>'generate'),
			array('sl_acct_cd','ceksl_a','on'=>'generate'),
			array('gl_acct_cd','cekgl_a','on'=>'generate'),
			array('qty, tax_pcn', 'numerical', 'integerOnly'=>true),
			array('rate, gross_amt, tax_amt, div_amt', 'numerical'),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('rvpv_number', 'length', 'max'=>17),
			
			array('brch_cd,branch_cd,check,recording_dt,check_cum_date,check_today_date,div_amt,update_date,update_seq,cum_date1,stock_code,stk_cd,remarks,file_no,gl_acct_cd, sl_acct_cd,record_date,vch_number,cum_date,type_vch,cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('ca_type, stk_cd, distrib_dt, client_cd, qty, rate, gross_amt, tax_pcn, tax_amt, div_amt, cre_dt, user_id, upd_dt, upd_by, approved_dt, approved_by, approved_stat, rvpv_number,distrib_dt_date,distrib_dt_month,distrib_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}
/*

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
	}*/


	public function attributeLabels()
	{
		return array(
			'ca_type' => 'Ca Type',
			'stk_cd' => 'Stk Code',
			'distrib_dt' => 'Distrib Date',
			'client_cd' => 'Client Code',
			'qty' => 'Qty',
			'rate' => 'Rate',
			'gross_amt' => 'Gross Amt',
			'tax_pcn' => 'Tax Pcn',
			'tax_amt' => 'Tax Amt',
			'div_amt' => 'Div Amt',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Stat',
			'rvpv_number' => 'Rvpv Number',
		);
	}

	public function ceksl_a(){
		//$check = Parameter::model()->find("prm_cd_1 = 'BNKFLG' AND prm_cd_2 = '$this->gl_acct_cd'");
		
		
			//echo "<script>alert('test')</script>";
			
			$sql="select trim(gl_a),trim(sl_a) from mst_gl_account where acct_stat='A' AND prt_type <> 'S' and approved_stat='A' and sl_a=trim('$this->sl_acct_cd')";
			$cek=DAO::queryRowSql($sql);
			
			if(!$cek){
				$this->addError('sl_acct_cd', 'Not found in chart of Account');
			}
		
	}
	public function cekgl_a(){
		//$check = Parameter::model()->find("prm_cd_1 = 'BNKFLG' AND prm_cd_2 = '$this->gl_acct_cd'");
	
	
		//echo "<script>alert('test2')</script>";
			$sql="select gl_a from mst_gl_account where acct_stat='A' and approved_stat='A' AND prt_type <> 'S' and  gl_a='$this->gl_acct_cd'";
			$cek=DAO::queryRowSql($sql);
			
			if(!$cek){
				$this->addError('gl_acct_cd', 'Not found in chart of Account');
			
		}
	}
	public function executeSp($exec_status,$old_ca_type,$old_stk_cd,$old_distrib_dt,$old_client_cd,$update_seq,$update_date,$record_seq)
	{
		$connection  = Yii::app()->db;
				
		try{
			$query  = "CALL Sp_T_CASH_DIVIDEN_Upd(
							:P_SEARCH_CA_TYPE,
							:P_SEARCH_STK_CD,
							TO_DATE(:P_SEARCH_DISTRIB_DT,'YYYY-MM-DD'),
							:P_SEARCH_CLIENT_CD,
							:P_CA_TYPE,
							:P_STK_CD,
							TO_DATE(:P_DISTRIB_DT,'YYYY-MM-DD'),
							:P_CLIENT_CD,
							:P_QTY,
							:P_RATE,
							:P_GROSS_AMT,
							:P_TAX_PCN,
							:P_TAX_AMT,
							:P_DIV_AMT,
							TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
							:P_USER_ID,
							TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
							:P_UPD_BY,
							:P_RVPV_NUMBER,
							TO_DATE(:P_CUM_DATE,'YYYY-MM-DD'),
							:P_CUM_QTY,
							:P_ONH,
							:P_SELISIH_QTY,
							:P_CUMDT_DIV_AMT,
							:P_RVPV_KOREKSI,
							:P_UPD_STATUS,
							:p_ip_address,
							:p_cancel_reason,
							TO_DATE(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),
							:p_update_seq,
							:p_record_seq,
							:p_error_code,
							:p_error_msg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_CA_TYPE",$old_ca_type,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_STK_CD",$old_stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_DISTRIB_DT",$old_distrib_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_CLIENT_CD",$old_client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CA_TYPE",$this->ca_type,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_DISTRIB_DT",$this->distrib_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_QTY",$this->qty,PDO::PARAM_STR);
			$command->bindValue(":P_RATE",$this->rate,PDO::PARAM_STR);
			$command->bindValue(":P_GROSS_AMT",$this->gross_amt,PDO::PARAM_STR);
			$command->bindValue(":P_TAX_PCN",$this->tax_pcn,PDO::PARAM_STR);
			$command->bindValue(":P_TAX_AMT",$this->tax_amt,PDO::PARAM_STR);
			$command->bindValue(":P_DIV_AMT",$this->div_amt,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_APPROVED_DT",$this->approved_dt,PDO::PARAM_STR);
			$command->bindValue(":P_APPROVED_BY",$this->approved_by,PDO::PARAM_STR);
			$command->bindValue(":P_APPROVED_STAT",$this->approved_stat,PDO::PARAM_STR);
			$command->bindValue(":P_RVPV_NUMBER",$this->rvpv_number,PDO::PARAM_STR);
			$command->bindValue(":P_CUM_DATE",$this->cum_date,PDO::PARAM_STR);
			$command->bindValue(":P_CUM_QTY",$this->cum_qty,PDO::PARAM_STR);
			$command->bindValue(":P_ONH",$this->onh,PDO::PARAM_STR);
			$command->bindValue(":P_SELISIH_QTY",$this->selisih_qty,PDO::PARAM_STR);
			$command->bindValue(":P_CUMDT_DIV_AMT",$this->cumdt_div_amt,PDO::PARAM_STR);
			$command->bindValue(":P_RVPV_KOREKSI",$this->rvpv_koreksi,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);								
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$update_seq,PDO::PARAM_STR);
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
		$criteria->compare('ca_type',$this->ca_type,true);
		$criteria->compare('stk_cd',$this->stk_cd,true);

		if(!empty($this->distrib_dt_date))
			$criteria->addCondition("TO_CHAR(t.distrib_dt,'DD') LIKE '%".$this->distrib_dt_date."%'");
		if(!empty($this->distrib_dt_month))
			$criteria->addCondition("TO_CHAR(t.distrib_dt,'MM') LIKE '%".$this->distrib_dt_month."%'");
		if(!empty($this->distrib_dt_year))
			$criteria->addCondition("TO_CHAR(t.distrib_dt,'YYYY') LIKE '%".$this->distrib_dt_year."%'");		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('rate',$this->rate);
		$criteria->compare('gross_amt',$this->gross_amt);
		$criteria->compare('tax_pcn',$this->tax_pcn);
		$criteria->compare('tax_amt',$this->tax_amt);
		$criteria->compare('div_amt',$this->div_amt);

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
		$criteria->compare('approved_stat',$this->approved_stat,true);
		$criteria->compare('rvpv_number',$this->rvpv_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}