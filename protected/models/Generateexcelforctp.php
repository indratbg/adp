<?php
class Generateexcelforctp extends Tbondtrx
{
	
public $all;
public $sdh_upload;	
public $n_yield;
public $lawan_name;
public $custody_cd;
public $trx_time;
public $custody_name;
public $cbest_cd;
public $sr_custody_cd;
public $lawan_custody_cd;
public $datetime;

public $report_type;
public $position;
public $securities_id;
public $transaction_type;
public $cp_firm_id;
public $price;
public $yield;
public $volume;
public $trade_date;
public $trade_time;
public $vas;
public $settlement_date;
public $trx_parties_code_deliverer;
public $remarks_deliverer;
public $reference_deliverer;
public $custodian_deliverer;
public $trx_parties_code_receiver;
public $remarks_receiver;
public $reference_receiver;
public $custodian_receiver;
public $second_leg_price;
public $second_leg_yield;
public $second_leg_rate;
public $reverse_date;
public $late_type;
public $late_reason;
public static function model($className=__CLASS__)
{
	return parent::model($className);
}

public function rules()
{
	return 
	 array(
	 	array('n_yield','required'),
		array('datetime,trx_seq_no,trx_date, value_dt,trx_id,trx_ref,seller,buyer, bond_cd,
		nominal, price,save_flg,lawan_custody_cd,sr_custody_cd,cbest_cd,trx_time,custody_cd,lawan_name,n_yield,all, sdh_upload','safe')
	);
}

public static function getData($trx_date,$trx_id)
{ 
	$sql="SELECT t.TRX_DATE,
		  t.trx_seq_no,
		  t.value_dt,
		  t.TRX_ID,
		  t.TRX_REF,
		  DECODE( t.TRX_TYPE,'B',L.CTP_CD,'S-YJ') seller,
		  DECODE( t.TRX_TYPE,'B','S-YJ',L.CTP_CD) Buyer,
		  t.BOND_CD,
		  t.NOMINAL,
		  t.PRICE,
		  DECODE(c.trx_seq_no, NULL, 'Y','N') AS flg,
		  L.lawan_name,
		  DECODE(t.report_type,'TWO',NULL, DECODE(t.TRX_TYPE,'B',NVL(d_custody, sr_custody_cd), NULL)) lawan_custody_cd,
		  DECODE(t.report_type,'TWO',NULL, DECODE(t.TRX_TYPE,'B',NULL, NVL(R_custody, sr_custody_cd))) sr_custody_cd,
		  NVL(c.yield, p.yield) AS n_yield,
		  DECODE(c.trx_seq_no, NULL,SYSDATE, c.trade_datetime) trx_time,
		  t.report_type,
		  DECODE(c.trx_seq_no, NULL, '','Sudah') sdh_upload
		FROM T_BOND_TRX t,
		  (SELECT lawan,
		    lawan_name,
		    lawan_type,
		    MST_LAWAN_BOND_TRX.ctp_cd,
		    sr_custody_cd,
		    Participant
		  FROM MST_LAWAN_BOND_TRX,
		    MST_BANK_CUSTODY
		  WHERE NVL(custody_cbest_cd,'*') = cbest_cd(+)
		  ) L,
		  T_BOND_TRX_CTP c,
		  ( SELECT bond_cd, yield FROM T_BOND_PRICE WHERE price_Dt = to_date('$trx_date','dd/mm/yyyy')
		  ) p
		WHERE t.trx_date    = to_date('$trx_date','dd/mm/yyyy')
		AND (t.trx_id       = '$trx_id'
		OR '$trx_id'        = 'ALL')
		AND T.approved_sts <> 'C'
		AND T.lawan         = L.lawan
		AND (t.trx_type     = 'S'
		OR L.Participant    = 'N')
		AND t.trx_Date      = c.trx_date(+)
		AND t.trx_seq_no    = c.trx_seq_no(+)
		AND t.trx_Date      = c.trx_date(+)
		AND t.bond_cd       = p.bond_cd(+)
		ORDER BY trx_seq_no
			";
			return $sql;
}
public static function getCSV($trx_date)
{
	$sql = "SELECT REPORT_TYPE,
			  BUY_SELL_IND AS Position,
			  BOND_CD      AS securities_id,
			  TRANS_TYPE transaction_type,
			  FIRM_ID                    AS cp_firm_id,
			  trim(TO_CHAR(PRICE,'999.99999')) AS price,
			  trim(TO_CHAR(YIELD,'999.99999')) yield,
			  NOMINAL AS volume,
			  TO_CHAR(TRUNC(TRADE_DATETIME),'mm/dd/yyyy') trade_date,
			  TO_CHAR(SYSDATE ,'hh24:mi') trade_time,
			  VAS,
			  TO_CHAR(SETTLEMENT_DATE,'mm/dd/yyyy') SETTLEMENT_DATE,
			  D_PARTY_CD AS trx_parties_code_deliverer,
			  D_REMARKS  AS remarks_deliverer,
			  D_REF      AS reference_deliverer,
			  D_CUSTODY custodian_deliverer,
			  R_PARTY_CD AS trx_parties_code_receiver,
			  R_REMARKS  AS remarks_receiver,
			  R_REF      AS reference_receiver,
			  R_CUSTODY custodian_receiver,
			  RETURN_VALUE AS second_leg_price,
			  RETURN_YIELD AS second_leg_yield,
			  REPO_RATE    AS second_leg_rate,
			  RETURN_DATE reverse_date,
			  LATE_TYPE,
			  LATE_REASON
			FROM T_BOND_TRX_CTP
			WHERE trx_Date = to_date('$trx_date','dd/mm/yyyy')
			AND xls        = 'N'
			ORDER BY trx_id_yymm,
			  trx_seq_no";
	return $sql;		  
}

public function executeSp($save_csv)
	{ 
		$connection  = Yii::app()->db;
			
		try{
			$query  = "CALL Sp_Bond_Trx_Ctp(
											TO_DATE(:P_TRX_DATE,'YYYY-MM-DD'),
											:P_TRX_SEQ_NO,
											TO_DATE(:P_TRADE_DATETIME,'YYYY-MM-DD HH24:MI:SS'),
											:P_YIELD,
											:P_LAWAN_CUSTODY_CD,
											:P_SR_CUSTODY_CD,
											:P_USER_ID,
											:P_SAVE_CSV	,
											:p_error_code,
											:p_error_msg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_TRX_DATE",$this->trx_date,PDO::PARAM_STR);
			$command->bindValue(":P_TRX_SEQ_NO",$this->trx_seq_no,PDO::PARAM_STR);
			$command->bindValue(":P_TRADE_DATETIME",$this->datetime,PDO::PARAM_STR);
			$command->bindValue(":P_YIELD",$this->n_yield,PDO::PARAM_STR);
			$command->bindValue(":P_LAWAN_CUSTODY_CD",$this->lawan_custody_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SR_CUSTODY_CD",$this->sr_custody_cd,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_SAVE_CSV",$save_csv,PDO::PARAM_STR);			
			$command->bindParam(":p_error_code",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":p_error_msg",$this->error_msg,PDO::PARAM_STR,500);

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

}

?>