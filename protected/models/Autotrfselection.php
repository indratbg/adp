<?php
class Autotrfselection extends Tfundmovement
{
public $tahap;
public $folder_cd;
public $gl_acct_bank;
public $sl_acct_bank;
public $gl_acct_hutang;
public $sl_acct_hutang;
public $remarks;
public $client_cd;
public $branch_code;
public $save_flg='N';
public $client_name;
public $auto_trf;
public $trf_id;
public $trf_type;
public $trf_flg_ori;
public $new_trf_flg;
public $upd_mode;
public $curr_amt;
public $payee_acct_num;
public $bank_name;
public $bank_acct_fmt;
public $payee_name;
public $bank_branch;
public $trf_fee;
public $rdi_acct_name;

public $nama;
public $trans_date;
public $trans_amount;
public $remark_1;
public $remark_2;
public $acc_no;
public static function model($className=__CLASS__)
{
	return parent::model($className);
}

public function rules()
{
	return array_merge(
	array(
	
		array('acc_no,remark_1,remark_2,trans_amount,trans_date,nama,rdi_acct_name,trf_fee,bank_branch,payee_name,bank_acct_fmt,bank_name,payee_acct_num,curr_amt,doc_num,trf_flg_ori,trf_type,trf_id,auto_trf,save_flg,branch_code,client_name','safe'),
	
	),parent::rules());	
}


public static function getAutotrf($doc_date,$fund_bank_cd,$branch_grp,$reselect)
{
	$sql="select t.doc_date, t.client_cd, 					
				decode(t.brch,t.branch_code,t.branch_code,t.brch||'/'||t.branch_code)  branch_code,					
				t.client_name, t.trx_amt,					
				to_bank, to_acct, b.bank_name,					
				t.acct_name, t.fee,					
				decode(f.trf_flg,null,'Y','N','Y','Y','N') auto_trf, t.doc_num,					
				t.folder_cd, f.trf_flg as trf_flg_ori 					
				from( select doc_date, brch, trim(branch_code) branch_code,					
						T_FUND_MOVEMENT.client_cd, client_name,trx_amt, 			
						to_bank, to_acct,  doc_num, T_FUND_MOVEMENT.acct_name, 			
						cifs, t_payrech.folder_cd, fee			
						from( select client_cd, client_name,cifs, 			
						 	  		 decode(trim(mst_client.rem_cd), 'LOT','LOT',trim(branch_code)) as brch,					
									 branch_code
						      from mst_client ) mst_client,			
						T_FUND_MOVEMENT,  t_payrech			
						where T_FUND_MOVEMENT.Approved_sts = 'A'			
						and from_client = 'FUND'			
						and to_client = 'LUAR'			
						and doc_date = '$doc_date'			
						and to_bank is not null			
						and to_acct is not null			
						and trx_type = 'W'			
				      and fund_bank_cd = '$fund_bank_cd'					
						and T_FUND_MOVEMENT.client_cd = mst_client.client_cd 			
						and instr('$branch_grp',substr(mst_client.brch,1,2)) >0			
						and T_FUND_MOVEMENT.doc_ref_num2 = t_payrech.payrec_num(+)			
				) t,					
				(					
				select distinct doc_num, trf_flg					
				from t_fund_trf					
				where trf_date = '$doc_date'					
					) f,				
				(SELECT BANK_CD,  bank_name
                      FROM MST_IP_BANK
                      WHERE APPROVED_STAT = 'A') b,					
				mst_client_bank c					
				where t.to_bank = b.bank_cd (+)					
				and t.cifs = c.cifs (+)					
				and t.to_acct = c.bank_acct_num (+)					
				and t.doc_num =f.doc_num(+) 					
				and (( '$reselect' ='N' and  f.doc_num IS null ) or					
						( f.doc_num is not null and '$reselect' ='Y'))
				ORDER BY branch_code,T.CLIENT_CD";
	return $sql;
}
public static function getPrintX($doc_date, $fund_bank_cd, $branch_grp){
	
	$sql="  select m.branch_code, p.client_cd,brch,					
		 	m.acct_name as rdi_acct_name, m.bank_acct_fmt,			
		  	payrec_date,curr_amt,			
		  	remarks, folder_cd,  			
		  	payee_name, 			
		  	payee_acct_num, payee_bank_cd, 			
		  	nvl(v.bank_name,nvl(b.bank_cd,'-')) as bank_name,			
			nvl(bank_brch_name, '-') bank_branch,		
			trf_fee,		
			decode(payee_bank_cd,'BCA',0,length(payee_name)) as name_length,					
       		1 print_flg, P.DOC_NUM					
			from
			(  
				select client_cd, REM_CD,  acct_name, bank_acct_fmt, brch,branch_code	
				from
				( 
					select mst_client.client_cd, REM_CD,  substr(mst_client_flacct.acct_name,1,35) as acct_name, 		
					mst_client_flacct.bank_acct_fmt,
					decode(trim(mst_client.rem_cd), 'LOT','LOT',trim(branch_code)) as brch,					
					trim(branch_code) as branch_code	
					from mst_client_flacct, mst_client	
					where mst_client_flacct.client_cd = mst_client.client_cd	
					and mst_client_flacct.acct_stat <> 'C'	
					aND mst_client_flacct.bank_cd = '$fund_bank_cd'
				)	
				where instr('$branch_grp',substr(brch,1,2)) > 0	
			) m,		
			( 
				select payrec_date,payrec_num as doc_num, T_PAYRECH.client_cd,			
			  	curr_amt, deduct_fee as trf_fee,		
 			  	remarks, folder_cd,  		
			  	q.payee_name, 		
			  	q.payee_acct_num, q.payee_bank_cd	   	
		 		FROM T_PAYRECH, t_cheq q			
		  		WHERE PAYREC_DATE = '$doc_date'			
				and acct_type = 'RDM'			
				and payrec_type in ('PV', 'PD')			
		 		and T_PAYRECH.approved_sts <> 'C'			
 				and T_PAYRECH.payrec_num = q.rvpv_number 			
				union all			
				select doc_date,doc_num, client_cd,			
		       	trx_amt, fee,			
			   	remarks, folder_cd,		
			   	acct_name,		
			   	to_acct, to_bank		
				from t_fund_movement			
				WHERE Doc_DATE = '$doc_date'			
				and source = 'INPUT'			
				and trx_type = 'W'			
				and to_client = 'LUAR'			
				and approved_sts <> 'C'
				
				UNION ALL
				
				SELECT TO_DATE(MAX(payrec_date),'YYYY/MM/DD HH24:MI:SS'), MAX(payrec_num), MAX(client_cd),
						TO_NUMBER(MAX(curr_amt)), TO_NUMBER(MAX(deduct_fee)),
						MAX(remarks), MAX(folder_cd),
						MAX(payee_name),
						MAX(payee_acct_num), MAX(payee_bank_cd)	
				FROM
				(
					SELECT DECODE (field_name, 'PAYREC_DATE', field_value, NULL) payrec_date,
							DECODE (field_name, 'PAYREC_NUM', field_value, NULL) payrec_num,
							DECODE (field_name, 'CLIENT_CD', field_value, NULL) client_cd,
							DECODE (field_name, 'CURR_AMT', field_value, NULL) curr_amt,
							DECODE (field_name, 'DEDUCT_FEE',field_value, NULL) deduct_fee,
							DECODE (field_name, 'REMARKS',field_value, NULL) remarks,
							DECODE (field_name, 'FOLDER_CD', field_value, NULL) folder_cd,
							DECODE (field_name, 'PAYEE_NAME',field_value, NULL) payee_name,
							DECODE (field_name, 'PAYEE_ACCT_NUM',field_value, NULL) payee_acct_num,
							DECODE (field_name, 'PAYEE_BANK_CD', field_value, NULL) payee_bank_cd,
							DECODE (field_name, 'ACCT_TYPE', field_value, NULL) acct_type,
							DECODE (field_name, 'PAYREC_TYPE', field_value, NULL) payrec_type,
					a.update_seq, a.record_seq
					FROM T_MANY_DETAIL a JOIN T_MANY_HEADER b
					ON a.update_date = b.update_date
					AND a.update_seq = b.update_seq
					WHERE b.approved_status = 'E'
					AND a.table_name IN ('T_PAYRECH','T_CHEQ')
					AND a.upd_status = 'I'
				)
				GROUP BY update_seq, record_seq
				HAVING TO_DATE(MAX(payrec_date),'YYYY/MM/DD HH24:MI:SS') = TO_DATE('$doc_date','YYYY-MM-DD')
				AND MAX(acct_type) = 'RDM'
				AND MAX(payrec_type) IN ('PV','PD')
				
			) p,			
		  	v_client_bank v,			
		 	(
		 		SELECT BANK_CD,  bank_name
                      FROM MST_IP_BANK
                      WHERE APPROVED_STAT = 'A'
			) b		
			where p.client_cd = m.client_cd			
			and p.client_cd = v.client_cd(+)			
			and p.payee_acct_num = v.bank_acct_num(+)			
			and p.PAYEE_BANK_CD = b.bank_cd(+)	
			order by brch,p.client_cd";
		
	return $sql;
	
}

public static function getPenarikan($doc_date, $fund_bank_cd, $branch_grp)
{
	$sql="select acct_name nama, '$doc_date' as trans_date,							
		   trf_amt as trans_amount,						
			bank_acct_num as acc_no,					
			decode(trf_id, 'KBB','PAYM-','BY-')||t.client_cd remark_1,					
			branch_code||' '||t.folder_cd  remark_2,					
			doc_num, 'N' save_flg					
		from( 							
			    SELECT CLIENT_CD, TRX_AMT as trf_amt, folder_cd,  						
			   		  m.doc_num, trf_id				
			    from( select doc_num, trf_flg, trf_id						
				    from t_fund_trf					
					where trf_date = '$doc_date'				
					and trf_id in ('KBB')				
					) f,				
				( select doc_num,t_fund_movement.client_cd, doc_ref_num, trx_amt, t_payrech.folder_cd					
				  from t_fund_movement, t_payrech					
				  where  doc_date = '$doc_date'					
				  and t_fund_movement.approved_sts = 'A'					
				  and doc_ref_num is not null					
				  and trx_type = 'R'					
				  and t_payrech.payrec_date = '$doc_date'					
				  and t_fund_movement.doc_ref_num = t_payrech.PAYREC_NUM)  m					
				where f.doc_num = m.doc_num					
				) t,					
				( SELECT *					
				  FROM( select mst_client.client_cd, REM_CD,  mst_client_flacct.acct_name, mst_client_flacct.bank_acct_num,					
						 decode(trim(mst_client.rem_cd), 'LOT','LOT/'||trim(branch_code),trim(branch_code)) as branch_code,
						 decode(trim(mst_client.rem_cd), 'LOT','LO',trim(branch_code)) as brch
						 from mst_client_flacct, mst_client			
						 where mst_client_flacct.client_cd = mst_client.client_cd			
						 and mst_client_flacct.acct_stat <> 'C'			
						 AND mst_client_flacct.bank_cd = '$fund_bank_cd')			
					where instr('$branch_grp',brch) > 0		 		
					) m				
				 where t.client_cd = m.client_cd					
		Order By Branch_Code, T.Client_Cd";
		
	return $sql;
	
}
public function executeSpTrf()
	{ 
		$connection  = Yii::app()->db;
				
		try{
			$query  = "CALL SP_T_Fund_Trf_Upd(TO_DATE(:p_doc_date,'YYYY-MM-DD'), 
											 :p_doc_num,
	   	  		  							 :p_trf_id,
	   	  		  							 :p_trf_type,
	   	  		  							 :p_upd_mode,
				                             :p_trf_flg,
				                             :p_user_id,
				                             :p_error_code,
				                             :p_error_msg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":p_doc_date",$this->doc_date,PDO::PARAM_STR);
			$command->bindValue(":p_doc_num",$this->doc_num,PDO::PARAM_STR);
			$command->bindValue(":p_trf_id",$this->trf_id,PDO::PARAM_STR);
			$command->bindValue(":p_trf_type",$this->trf_type,PDO::PARAM_STR);
			$command->bindValue(":p_upd_mode",$this->upd_mode,PDO::PARAM_STR);
			$command->bindValue(":p_trf_flg",$this->new_trf_flg,PDO::PARAM_STR);
			$command->bindValue(":p_user_id",$this->user_id,PDO::PARAM_STR);		
			$command->bindParam(":p_error_code",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":p_error_msg",$this->error_msg,PDO::PARAM_STR,200);

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