<?php
class Ipofund2 extends Tipoclient
{
public $tahap;
public $folder_cd;
public $gl_acct_bank;
public $sl_acct_bank;
public $gl_acct_hutang;
public $sl_acct_hutang;
public $remarks;
public $client_cd;
public $branch_cd;
public $rdi_type;

public static function cekParam()
{
	$cekParam = Sysparam::model()->find("param_id='IPO FUND ENTRY' and param_cd1='TRFLGSG'")->dflg1;
		
	return $cekParam;
}

public static function getPenerimaanDana($stk_cd,$option,$client_cd,$branch_cd,$rdi_type, $batch)
{
	
	$sql="SELECT client_Cd,
				  client_name,
				  fixed_qty,
				  pool_qty,
				  alloc_qty,
				  price,
				  amount,
				  fund_ipo,
				  bal_rdi,
				  branch_code
				FROM
				  (SELECT P.client_Cd,
				    client_name,
				    fixed_qty,
				    pool_qty,
				    alloc_qty,
				    E.price,
				    (fixed_qty + Pool_qty) * price AS amount,
				    NVL( f_fund_ipo('$stk_cd',DECODE('$rdi_type','NORDI','$batch', P.client_Cd), 'ALOKASI'),0) fund_ipo,
				    NVL(F_Fund_Bal(P.client_cd, TRUNC(SYSDATE)),0) bal_rdi,
				    branch_code
				  FROM
				    (SELECT A.client_cd,
				      A.client_name, a.branch_code
				    FROM MST_CLIENT A,
				      MST_CLIENT_FLACCT B
				    WHERE A.client_Cd         = B.client_Cd (+)
				    and b.acct_stat(+) ='A'
				    AND ((B.client_Cd IS NULL
				    AND '$rdi_type'                         = 'NORDI' )
				    OR ( B.client_cd  IS NOT NULL
				    AND '$rdi_type'                        <> 'NORDI'))
				    ) M,
				    T_IPO_CLIENT P,
				    T_PEE E
				  WHERE P.client_Cd   = M.client_Cd
				  and nvl(p.batch,'%') like '%$batch'
				  AND P.stk_cd        = '$stk_cd'
				  AND P.approved_stat = 'A'
				  AND P.stk_cd        = E.stk_cd
				  )
				WHERE fund_ipo = 0
				and client_cd like '%$client_cd'
				and TRIM(branch_code) like '%$branch_cd'
				ORDER BY client_cd
			";
			
			/*
			 * AND ((P.fund_bal    > 0
				  AND '$rdi_type'                     = 'CUKUP')
				  OR (P.fund_bal     IS NULL
				  AND '$rdi_type'                     = 'KURANG')
				  OR (P.fund_bal     IS NULL
				  AND '$rdi_type'                     = 'NORDI'))
			 * 
			 */
			
return $sql;
}
public static function getPenjatahan($stk_cd,$option,$client_cd,$branch_cd,$rdi_type, $batch)
{
	$sql="SELECT client_Cd,
		  client_name,
		  fixed_qty,
		  pool_qty,
		  alloc_qty,
		  price,
		  amount,
		  fund_ipo,
		   FUND_IPO_PENERIMAAN
		FROM
		  (SELECT p.client_Cd,
		    client_name,
		    fixed_qty,
		    pool_qty,
		    alloc_qty,
		    E.price,
		    (fixed_qty + alloc_qty) * price AS amount,
		    NVL( f_fund_ipo('$stk_cd',DECODE('$rdi_type','NORDI','UMUM', P.client_Cd), 'PENJATAHAN'),0) fund_ipo,
		    NVL( f_fund_ipo('$stk_cd',DECODE('$rdi_type','NORDI','UMUM', P.client_Cd), 'ALOKASI'),0)  FUND_IPO_PENERIMAAN
		  FROM
		    (SELECT A.client_cd,
		      A.client_name
		    FROM MST_CLIENT A,
		     MST_CLIENT_FLACCT B
		    WHERE A.client_Cd  = B.client_Cd (+)
			and b.acct_stat(+) ='A'
			AND TRIM(A.BRANCH_CODE) LIKE '%$branch_cd'
		    AND ((B.client_Cd IS NULL
		    AND '$rdi_type'        = 'NORDI' )
		    OR ( B.client_cd  IS NOT NULL
		    AND '$rdi_type'        <> 'NORDI'))
		    ) M,
		    T_IPO_CLIENT P,
		    T_PEE E
		  WHERE P.client_Cd   = M.client_Cd
		  and nvl(p.batch,'%') like '%$batch'
		  AND P.stk_cd        = '$stk_cd'
		  AND P.approved_stat = 'A'
		  AND P.stk_cd        = E.stk_cd
		  )
		  WHERE ('$option'   <> 'ALL'
		 
		  AND FUND_IPO_PENERIMAAN <> 0)
		  and client_cd like '%$client_cd'
		  order by client_cd
		";
	return $sql;
}

public static function getRefund($stk_cd, $option,$client_cd,$branch_cd, $rdi_type, $batch)
{
	$sql="SELECT client_Cd,
			  client_name,
			  fixed_qty,
			  pool_qty,
			  alloc_qty,
			  price,
			  fund_ipo,
			  paid_ipo,
			  refund
			FROM
			  (SELECT p.client_Cd,
			    client_name,
			    fixed_qty,
			    pool_qty,
			    alloc_qty,
			    e.price,
			    (fixed_qty + pool_qty) * price AS fund_ipo,
			    (fixed_qty + alloc_qty) * price paid_ipo,
			    (fixed_qty + pool_qty - alloc_qty) * price refund
			  FROM
			    (SELECT a.client_cd,
			      a.client_name
			    FROM MST_CLIENT a,
			      MST_CLIENT_FLACCT b
			    WHERE a.client_cd like '%$client_cd'
			    and trim(a.branch_code) like '%$branch_cd'
			    and a.client_Cd  = b.client_Cd (+)
				and b.acct_stat(+) ='A'
			    AND ((b.client_Cd IS NULL
			    AND '$rdi_type'         = 'NORDI' )
			    OR ( b.client_cd  IS NOT NULL
			    AND '$rdi_type'        <> 'NORDI'))
			    ) M,
			    T_IPO_CLIENT p,
			    T_PEE e
			  WHERE p.stk_cd      = '$stk_cd'
			   and nvl(p.batch,'%') like '%$batch'
			  AND p.approved_stat = 'A'
			  AND p.client_Cd     = M.client_Cd
			  AND p.stk_cd        = e.stk_cd
			  )
			WHERE '$option' <> 'ALL'
			AND refund       > 0
			order by client_cd";
	return $sql;
}
public static function checkData($client_cd, $doc_date,$recordSeq,$trx_type,$trx_amt)
{
	$sql="select * from (SELECT
						 (SELECT TO_DATE(FIELD_VALUE,'YYYY/MM/DD HH24:MI:SS') FROM T_MANY_DETAIL DA 
						        WHERE DA.TABLE_NAME = 'T_FUND_MOVEMENT' 
						        AND DA.UPDATE_DATE = DD.UPDATE_DATE
						        AND DA.UPDATE_SEQ = DD.UPDATE_SEQ
						        AND DA.FIELD_NAME = 'DOC_DATE'
						        AND DA.RECORD_SEQ = DD.RECORD_SEQ) DOC_DATE, 
						(SELECT FIELD_VALUE FROM T_MANY_DETAIL DA 
						        WHERE DA.TABLE_NAME = 'T_FUND_MOVEMENT' 
						        AND DA.UPDATE_DATE = DD.UPDATE_DATE
						        AND DA.UPDATE_SEQ = DD.UPDATE_SEQ
						        AND DA.FIELD_NAME = 'TRX_TYPE'
						        AND DA.RECORD_SEQ = DD.RECORD_SEQ) TRX_TYPE, 
						(SELECT FIELD_VALUE FROM T_MANY_DETAIL DA 
						        WHERE DA.TABLE_NAME = 'T_FUND_MOVEMENT' 
						        AND DA.UPDATE_DATE = DD.UPDATE_DATE
						        AND DA.UPDATE_SEQ = DD.UPDATE_SEQ
						        AND DA.FIELD_NAME = 'CLIENT_CD'
						        AND DA.RECORD_SEQ = DD.RECORD_SEQ) CLIENT_CD,
						(SELECT FIELD_VALUE FROM T_MANY_DETAIL DA 
						        WHERE DA.TABLE_NAME = 'T_FUND_MOVEMENT' 
						        AND DA.UPDATE_DATE = DD.UPDATE_DATE
						        AND DA.UPDATE_SEQ = DD.UPDATE_SEQ
						        AND DA.FIELD_NAME = 'TRX_AMT'
						        AND DA.RECORD_SEQ = DD.RECORD_SEQ) TRX_AMT
						FROM T_MANY_DETAIL DD, T_MANY_HEADER HH WHERE DD.TABLE_NAME = 'T_FUND_MOVEMENT' AND DD.UPDATE_DATE = HH.UPDATE_DATE
                      AND DD.UPDATE_SEQ = HH.UPDATE_SEQ AND  DD.RECORD_SEQ ='$recordSeq'
                     AND DD.FIELD_NAME = 'DOC_DATE' AND HH.APPROVED_STATUS = 'E' ORDER BY HH.UPDATE_SEQ
                     )
                     where client_cd='$client_cd' and doc_date='$doc_date' and trx_type='$trx_type' and trx_amt='$trx_amt' ";
	return $sql;
}
 

public function executeSpGen($user)
	{ 
		$connection  = Yii::app()->db;
				
		try{
			$query  = "CALL SP_GEN_FUND_IPO(:P_STK_CD,
											:P_TAHAP,
											:P_FOLDER_CD,
											:P_GL_ACCT_CD_BANK,
											:P_SL_ACCT_CD_BANK,
											:P_GL_ACCT_CD_HUTANG,
											:P_SL_ACCT_CD_HUTANG,
											:P_REMARKS,
											:P_CLIENT_CD,
											:P_BRANCH_CD,
											:P_USER,
											:P_USER_ID,
											:P_IP_ADDRESS,
											:P_ERROR_CODE,
											:P_ERROR_MSG) ";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_TAHAP",$this->tahap,PDO::PARAM_STR);
			$command->bindValue(":P_FOLDER_CD",$this->folder_cd,PDO::PARAM_STR);
			$command->bindValue(":P_GL_ACCT_CD_BANK",$this->gl_acct_bank,PDO::PARAM_STR);
			$command->bindValue(":P_SL_ACCT_CD_BANK",$this->sl_acct_bank,PDO::PARAM_STR);
			$command->bindValue(":P_GL_ACCT_CD_HUTANG",$this->gl_acct_hutang,PDO::PARAM_STR);
			$command->bindValue(":P_SL_ACCT_CD_HUTANG",$this->sl_acct_hutang,PDO::PARAM_STR);
			$command->bindValue(":P_REMARKS",$this->remarks,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH_CD",$this->branch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_USER",$user,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);		
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

}

?>