<?php

/**
 * This is the model class for table "T_STK_MOVEMENT".
 *
 * The followings are the available columns in table 'T_STK_MOVEMENT':
 * @property string $doc_num
 * @property string $ref_doc_num
 * @property string $doc_dt
 * @property string $client_cd
 * @property string $stk_cd
 * @property string $s_d_type
 * @property string $odd_lot_doc
 * @property integer $total_lot
 * @property integer $total_share_qty
 * @property string $doc_rem
 * @property string $doc_stat
 * @property integer $withdrawn_share_qty
 * @property string $regd_hldr
 * @property string $withdraw_reason_cd
 * @property string $gl_acct_cd
 * @property string $acct_type
 * @property string $db_cr_flg
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $status
 * @property string $due_dt_for_cert
 * @property string $stk_stat
 * @property string $due_dt_onhand
 * @property integer $seqno
 * @property double $price
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 * @property string $prev_doc_num
 * @property string $upd_by
 */
class Tstkmovement extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $doc_dt_date;
	public $doc_dt_month;
	public $doc_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $due_dt_for_cert_date;
	public $due_dt_for_cert_month;
	public $due_dt_for_cert_year;

	public $due_dt_onhand_date;
	public $due_dt_onhand_month;
	public $due_dt_onhand_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $update_date;
	public $update_seq;
	
	public $client_name;
	
	public $doc_num;
	
	public $from_dt;
	public $to_dt;
	
	public $movement_type;
	public $movement_type_2;
	public $client_type;
	public $repo_ref;
	public $price_dt;
	public $withdraw_doc_num;
	public $withdraw_dt;
	public $eff_dt;
	public $client_to;
	public $stk_equi;
	//public $broker;
	//public $remark;
	public $tender_pay_dt;
	public $total;
	
	public $check; //checkbox
	
	public $description;
	public $qty;
	public $sl_desc_debit;
	public $sl_desc_credit;
	//public $p_mvmt = 'RW';
	
	public $rdi_flg;
	
	public $avg_price;
	public $on_hand;
	
	public $value;
	
	public $belijual;
	public $custody_name;
	
	public $penghentian_pengakuan;
	public $serah_saham;
	
	public $same_client_flg;
	
	public $message_type;
	public $ratio;
	public $ratio_txt;
	public $ratio_reason;
	
	public $manual = 'Y';
	
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
		return 'T_STK_MOVEMENT';
	}
	
	public function getPrimaryKey()
	{
		return array('doc_num'=>$this->doc_num,'db_cr_flg'=>$this->db_cr_flg,'seqno'=>$this->seqno);
	}
	
	public function executeSpHeader($exec_status,$menuName)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "
					DECLARE
						v_update_date	DATE;
					BEGIN
						SP_T_MANY_HEADER_INSERT
						(
							:P_MENU_NAME,
							:P_STATUS,
							:P_USER_ID,
							:P_IP_ADDRESS,
							:P_CANCEL_REASON,
							v_update_date,
							:P_UPDATE_SEQ,
							:P_ERROR_CODE,
							:P_ERROR_MSG
						);
						
						SELECT TO_CHAR(v_update_date,'YYYY-MM-DD HH24:MI:SS') INTO :P_UPDATE_DATE FROM dual;
					END;";
				
			$command = $connection->createCommand($query);
			$command->bindValue(":P_MENU_NAME",$menuName,PDO::PARAM_STR);
			$command->bindValue(":P_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);			
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			
			$command->bindParam(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR,50);
			$command->bindParam(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR,10);
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

	public function executeSp($exec_status,$old_doc_num,$old_db_cr_flg,$old_seqno,$update_date,$update_seq,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_T_STK_MOVEMENT_UPD(
						:P_SEARCH_DOC_NUM,
						:P_SEARCH_DB_CR_FLG,
						:P_SEARCH_SEQNO,
--						:P_MOVEMENT_TYPE,
--						:P_MOVEMENT_TYPE_2,
						:P_DOC_NUM,
						:P_REF_DOC_NUM,
						:P_DOC_DT,
						:P_CLIENT_CD,
						:P_STK_CD,
						:P_S_D_TYPE,
						:P_ODD_LOT_DOC,
						:P_TOTAL_LOT,
						:P_TOTAL_SHARE_QTY,
						:P_DOC_REM,
						:P_DOC_STAT,
						:P_WITHDRAWN_SHARE_QTY,
						:P_REGD_HLDR,
						:P_WITHDRAW_REASON_CD,
						:P_GL_ACCT_CD,
						:P_ACCT_TYPE,
						:P_DB_CR_FLG,
						:P_STATUS,
						:P_DUE_DT_FOR_CERT,
						:P_STK_STAT,
						:P_DUE_DT_ONHAND,
						:P_SEQNO,
						:P_PRICE,
						:P_PREV_DOC_NUM,
						:P_MANUAL,
						:P_JUR_TYPE,
						:P_BROKER,
						:P_REPO_REF,
						:P_RATIO,
						:P_RATIO_REASON,
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
			$command->bindValue(":P_SEARCH_DOC_NUM",$old_doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_DB_CR_FLG",$old_db_cr_flg,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_SEQNO",$old_seqno,PDO::PARAM_STR);
//			$command->bindValue(":P_MOVEMENT_TYPE",$this->movement_type,PDO::PARAM_STR);
//			$command->bindValue(":P_MOVEMENT_TYPE_2",$this->movement_type_2,PDO::PARAM_STR);
			$command->bindParam(":P_DOC_NUM",$this->doc_num,PDO::PARAM_STR,100);
			$command->bindValue(":P_REF_DOC_NUM",$this->ref_doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_DT",$this->doc_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_S_D_TYPE",$this->s_d_type,PDO::PARAM_STR);
			$command->bindValue(":P_ODD_LOT_DOC",$this->odd_lot_doc,PDO::PARAM_STR);
			$command->bindValue(":P_TOTAL_LOT",$this->total_lot,PDO::PARAM_STR);
			$command->bindValue(":P_TOTAL_SHARE_QTY",$this->total_share_qty,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_REM",$this->doc_rem,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_STAT",$this->doc_stat,PDO::PARAM_STR);
			$command->bindValue(":P_WITHDRAWN_SHARE_QTY",$this->withdrawn_share_qty,PDO::PARAM_STR);
			$command->bindValue(":P_REGD_HLDR",$this->regd_hldr,PDO::PARAM_STR);
			$command->bindValue(":P_WITHDRAW_REASON_CD",$this->withdraw_reason_cd,PDO::PARAM_STR);
			$command->bindValue(":P_GL_ACCT_CD",$this->gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_TYPE",$this->acct_type,PDO::PARAM_STR);
			$command->bindValue(":P_DB_CR_FLG",$this->db_cr_flg,PDO::PARAM_STR);
			$command->bindValue(":P_STATUS",$this->status,PDO::PARAM_STR);
			$command->bindValue(":P_DUE_DT_FOR_CERT",$this->due_dt_for_cert,PDO::PARAM_STR);
			$command->bindValue(":P_STK_STAT",$this->stk_stat,PDO::PARAM_STR);
			$command->bindValue(":P_DUE_DT_ONHAND",$this->due_dt_onhand,PDO::PARAM_STR);
			$command->bindValue(":P_SEQNO",$this->seqno,PDO::PARAM_STR);
			$command->bindValue(":P_PRICE",$this->price,PDO::PARAM_STR);
			$command->bindValue(":P_PREV_DOC_NUM",$this->prev_doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_MANUAL",$this->manual,PDO::PARAM_STR);
			$command->bindValue(":P_JUR_TYPE",$this->jur_type,PDO::PARAM_STR);
			$command->bindValue(":P_BROKER",$this->broker?$this->broker:$this->withdraw_reason_cd,PDO::PARAM_STR);
			$command->bindValue(":P_REPO_REF",$this->repo_ref,PDO::PARAM_STR);
			$command->bindValue(":P_RATIO",$this->ratio,PDO::PARAM_STR);
			$command->bindValue(":P_RATIO_REASON",$this->ratio_reason,PDO::PARAM_STR);
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

	public static function checkButtonVisible($doc_num, $ref_doc_num)
	{
		switch(substr($doc_num,4,1))
		{
			case 'R':
				return TRUE;
			case 'W':
				return TRUE;
			case 'J':
				switch($ref_doc_num)
				{
					case 'SETTLED':	
					case 'REPO RETURNED':
						return FALSE;
					default:
						return TRUE;
				}
		}
		
		return FALSE;
	}
	
	public function getIndexSql()
	{
		$sql = "SELECT doc_Dt, client_Cd, stk_Cd, DECODE(SUBSTR(doc_num,5,1),'R','Receipt', 'W','Withdraw','J',DECODE(SUBSTR(ref_doc_num,1,4),'REPO','Repo','Return repo') ) AS movement_type,						
		 		(total_share_qty + withdrawn_share_qty) AS qty,	doc_rem AS description, price						
				FROM T_STK_MOVEMENT							
				WHERE doc_dt BETWEEN :p_begin_date AND :p_end_date							
				AND SUBSTR(doc_num,5,3) IN ('JVA' ,'RSN','WSN')							
				AND (SUBSTR(doc_num,5,1) = :p_mvmt 
					OR s_d_type = 'C' AND :p_mvmt = 'RW' 
					OR SUBSTR(ref_doc_num,1,4) = 'REPO' AND :p_mvmt = 'REPO' 
					OR ref_doc_num is not null AND SUBSTR(ref_doc_num,1,4) <> 'REPO' AND :p_mvmt = 'RETURN' 
					OR SUBSTR(doc_num,5,3) = 'JVA' AND :p_mvmt = 'ALLREPO' 
					OR :p_mvmt ='ALL') 						
				AND seqno = 1							
				AND doc_stat = '2'							
				ORDER BY doc_dt DESC, client_cd, stk_Cd";
		
		return $sql;						
		
	}
	
	public static function getClientDetailSql($client_cd = '%')
	{
		$sql = "  SELECT a.CLIENT_CD, a.BRANCH_CODE, a.OLD_IC_NUM,  a.CLIENT_NAME, a.CUSTODIAN_CD,	b.BANK_ACCT_NUM,			
        			DECODE( CUSTODIAN_CD,null,c.margin_cd,'C') client_type,	d.SID						
   					FROM MST_CLIENT a, MST_CLIENT_FLACCT b, LST_TYPE3 c, MST_CIF d						
   					WHERE SUSP_STAT = 'N' 						
   					AND a.CLIENT_CD = b.CLIENT_CD (+) 						
    				AND b.ACCT_STAT in ('A','I')						
    				AND a.CLIENT_TYPE_3 = c.cl_Type3						
    				AND a.CIFS = d.cifs
    				AND a.CLIENT_CD LIKE '$client_cd'						
					ORDER BY CLIENT_CD ASC ";
		return $sql;
	}
	
	public static function getClientTypeSql($client_cd)
	{
		$sql = "  SELECT a.CLIENT_CD, DECODE( CUSTODIAN_CD,null,c.margin_cd,'C') client_type				
   					FROM MST_CLIENT a, LST_TYPE3 c					
   					WHERE SUSP_STAT = 'N' 						
   					AND a.CLIENT_TYPE_3 = c.cl_Type3						
    				AND a.CLIENT_CD LIKE '$client_cd'						
					ORDER BY CLIENT_CD ASC ";
		return $sql;
	}
	
	public static function getWithdrawDetailSql($client_cd = '%', $stk_cd = '%', $margin = '%', $begin_dt, $end_dt)
	{
		$sql = "SELECT  trim(c.client_cd) client_cd, c.client_name, a.stk_Cd,	NVL(a.on_hand,0) on_hand,									
        		0 jur_qty, client_type, DECODE(ada_rdi,1,'','No RDI') rdi_flg, nvl(d.avg_price,0) avg_price, 0 qty								
				FROM
				( 
					SELECT client_cd, stk_cd, SUM(onh_mvmt) on_hand								
	   				FROM 
	   				(	  							
	  					 SELECT client_cd, stk_cd, gl_acct_cd, 								
		  				 (NVL(DECODE(SUBSTR(doc_num,5,2),'JV',1,'XS',1,'LS',1,'RS',1,'WS',1,'CS',1,0) *							
		  				 DECODE(trim(NVL(gl_acct_cd,'36')),'36',1, '35',0) * DECODE(db_cr_flg,'D',-1,1) *							
		  				 (total_share_qty + withdrawn_share_qty),0)) onh_mvmt							
	      				 FROM T_STK_MOVEMENT 								
		 				 WHERE doc_dt BETWEEN TO_DATE('$begin_dt','YYYY-MM-DD') AND TO_DATE('$end_dt','YYYY-MM-DD')							
					     AND stk_cd LIKE '$stk_cd'							
		      			 AND client_cd LIKE '$client_cd'							
						 AND ((gl_acct_cd IN ( '36','35')) OR (gl_acct_cd IS NULL)  )							
						 AND doc_stat    = '2'							
						 UNION ALL							
						 SELECT client_Cd, stk_cd, gl_Acct_cd, qty							
						 FROM T_SECU_BAL							
						 WHERE bal_dt = TO_DATE('$begin_dt','YYYY-MM-DD')						
						 AND stk_cd LIKE '$stk_cd'							
		   				 AND client_cd LIKE '$client_cd'							
		   				 AND gl_acct_cd IN ('36','35')							
					) 							
					GROUP BY  client_cd, stk_cd
				) a,							
				( 									
					SELECT m.client_cd,  m.client_name, DECODE(m.custodian_cd, NULL, l.margin_cd,'C') AS client_type,									
			         cek_rdi_by_sid(m.client_cd) ada_rdi									
					FROM  MST_CLIENT m, LST_TYPE3 l								
					WHERE m.client_cd LIKE '$client_cd'								
					AND m.client_type_3 = l.cl_type3								
				    AND l.margin_cd LIKE  '$margin'									
					AND m.client_type_1 <>'B'								
				) c,
				(
					SELECT MAX(client_cd) client_cd, MAX(stk_cd) stk_cd, MAX(s_d_type) s_d_type, MAX(jur_type) jur_type
					FROM
					(
						SELECT DECODE(field_name,'CLIENT_CD',field_value, NULL) client_cd,
						DECODE(field_name,'STK_CD',field_value, NULL) stk_cd,
						DECODE(field_name,'S_D_TYPE',field_value, NULL) s_d_type,
						DECODE(field_name,'JUR_TYPE',field_value, NULL) jur_type,
						a.update_date, a.update_seq, record_seq
						FROM T_MANY_DETAIL a JOIN T_MANY_HEADER b
						ON a.update_seq = b.update_seq
						AND a.update_date = b.update_date
						WHERE menu_name = 'STOCK MOVEMENT ENTRY'
	          			AND field_name IN ('CLIENT_CD','STK_CD','S_D_TYPE','JUR_TYPE')
						AND approved_status = 'E'
						AND status IN ('I','U')
						AND record_seq IN (1,3)
					)
					GROUP BY update_date, update_seq, record_seq
					HAVING MAX(s_d_type) = 'C'
					AND MAX(jur_type) NOT IN('RECV','3336')
				) t,								
				T_STKHAND d									
				WHERE  c.client_cd = a.client_cd(+)									
				and a.client_Cd = d.client_Cd(+)									
				and a.stk_Cd = d.stk_Cd(+)
				AND a.client_cd = t.client_cd(+)						
				AND a.stk_cd = t.stk_cd(+)					
				AND t.client_cd IS NULL						
				AND t.stk_cd IS NULL									
				AND NVL(a.on_hand,0) > 0
				ORDER BY client_cd, stk_cd";
		
		return $sql;
	}
	
	public static function getWithdrawScriptDetailSql($client_cd = '%', $stk_cd = '%', $margin = '%', $begin_dt, $end_dt)
	{
		$sql = "SELECT  trim(c.client_cd) client_cd, c.client_name, a.stk_Cd,	NVL(a.on_hand,0) on_hand,									
        		0 jur_qty, client_type, DECODE(ada_rdi,1,'','No RDI') rdi_flg, nvl(d.avg_price,0) avg_price, 0 qty								
				FROM
				( 
					SELECT client_cd, stk_cd, SUM(onh_mvmt) on_hand								
	   				FROM 
	   				(	  							
	  					 SELECT client_cd, stk_cd, gl_acct_cd, 								
		  				 (NVL(DECODE(SUBSTR(doc_num,5,2),'JV',1,'XS',1,'LS',1,'RS',1,'WS',1,'CS',1,0) *							
		  				 DECODE(trim(NVL(gl_acct_cd,'36')),'33',1, '35',0,'36',0) * DECODE(db_cr_flg,'D',-1,1) *							
		  				 (total_share_qty + withdrawn_share_qty),0)) onh_mvmt							
	      				 FROM T_STK_MOVEMENT 								
		 				 WHERE doc_dt BETWEEN TO_DATE('$begin_dt','YYYY-MM-DD') AND TO_DATE('$end_dt','YYYY-MM-DD')							
					     AND stk_cd LIKE '$stk_cd'							
		      			 AND client_cd LIKE '$client_cd'							
						 AND ((gl_acct_cd IN ( '33')) OR (gl_acct_cd IS NULL)  )							
						 AND doc_stat    = '2'							
						 UNION ALL							
						 SELECT client_Cd, stk_cd, gl_Acct_cd, qty							
						 FROM T_SECU_BAL							
						 WHERE bal_dt = TO_DATE('$begin_dt','YYYY-MM-DD')						
						 AND stk_cd LIKE '$stk_cd'							
		   				 AND client_cd LIKE '$client_cd'							
		   				 AND gl_acct_cd IN ('33')							
					) 							
					GROUP BY  client_cd, stk_cd
				) a,							
				( 									
					SELECT m.client_cd,  m.client_name, DECODE(m.custodian_cd, NULL, l.margin_cd,'C') AS client_type,									
			         cek_rdi_by_sid(m.client_cd) ada_rdi									
					FROM  MST_CLIENT m, LST_TYPE3 l								
					WHERE m.client_cd LIKE '$client_cd'								
					AND m.client_type_3 = l.cl_type3								
				    AND l.margin_cd LIKE  '$margin'									
					AND m.client_type_1 <>'B'								
				) c,								
				T_STKHAND d									
				WHERE  c.client_cd = a.client_cd(+)									
				and a.client_Cd = d.client_Cd(+)									
				and a.stk_Cd = d.stk_Cd(+)									
				AND NVL(a.on_hand,0) > 0
				ORDER BY client_cd, stk_cd";
		
		return $sql;
	}
	
	public static function getReverseRepoDetailSql($client_cd, $price_dt, $begin_dt, $end_dt)
	{
		$sql = "SELECT A.STK_CD, A.onh_qty on_hand,  B.price,  A.onh_qty * B.PRICE value, 0 qty--, DECODE(cek_rdi_by_sid(m.client_cd),1,'','No RDI') rdi_flg					
				FROM
				( 						
					SELECT client_cd, stk_cd, SUM(onh_mvmt) onh_qty	
					FROM 
					(	 
						SELECT client_cd, stk_cd, 	
						(NVL(DECODE(SUBSTR(doc_num,5,2),'JV',1,'XS',1,'LS',1,'RS',1,'WS',1,'CS',1,0) *
						DECODE(trim(NVL(gl_acct_cd,'36')),'36',1, '09',1,0) * DECODE(db_cr_flg,'D',-1,1) *
						(total_share_qty + withdrawn_share_qty),0)) onh_mvmt
					    FROM T_STK_MOVEMENT 	
						WHERE doc_dt BETWEEN TO_DATE('$begin_dt','YYYY-MM-DD') AND TO_DATE('$end_dt','YYYY-MM-DD')
						AND ((gl_acct_cd  IN  ('36','09')) OR (gl_acct_cd IS NULL)  )
						AND client_Cd = '$client_cd'
						AND doc_stat    = '2'
						UNION ALL
					   	SELECT client_cd, stk_Cd, 	
				  		DECODE(trim(gl_acct_Cd),'36',1,-1) *qty AS bal_qty		
						FROM T_SECU_BAL	
						WHERE bal_dt = TO_DATE('$begin_dt','YYYY-MM-DD')	
						AND client_Cd = '$client_cd'	
						AND gl_acct_cd IN  ('36','09')
					)	
					GROUP BY client_Cd, stk_Cd	
                   	HAVING SUM(onh_mvmt) > 0 
               	) a,						
				(
					SELECT STK_CD, DECODE(STK_CLOS,0,STK_PREV,STK_CLOS) Price						
					FROM V_STK_CLOS						
					WHERE STK_DATE = TO_DATE('$price_dt','YYYY-MM-DD')						
					UNION						
				  	SELECT bond_cd, price/100 price						
				  	FROM T_BOND_PRICE						
				  	WHERE price_dt= TO_DATE('$price_dt','YYYY-MM-DD')		
				) B						
				WHERE A.STK_CD = B.STK_CD";	
		
		return $sql;
	}
	
	public static function getReturnReverseRepoDetailSql($repo_num)
	{
		$sql = "SELECT t.doc_num, doc_dt, t.client_cd, client_name, stk_cd, total_share_qty AS qty					
    			FROM T_STK_MOVEMENT T, 						
      			( 
      				SELECT doc_num, repo_num					
				    FROM T_REPO_STK					
					WHERE repo_num = '$repo_num'				
					AND mvmt_type = 'REPO'
				) r,
				MST_CLIENT c,
				(
					SELECT MAX(repo_ref) repo_num, MAX(ref_doc_num) ref_doc_num, MAX(s_d_type) s_d_type
					FROM
					(
						SELECT DECODE(field_name,'REPO_REF',field_value, NULL) repo_ref,
						DECODE(field_name,'REF_DOC_NUM',field_value, NULL) ref_doc_num,
						DECODE(field_name,'S_D_TYPE',field_value, NULL) s_d_type,
						a.update_date, a.update_seq, record_seq
						FROM T_MANY_DETAIL a JOIN T_MANY_HEADER b
						ON a.update_seq = b.update_seq
						AND a.update_date = b.update_date
						WHERE menu_name = 'STOCK MOVEMENT ENTRY'
	          			AND field_name IN ('REPO_REF','REF_DOC_NUM','S_D_TYPE')
						AND approved_status = 'E'
						AND status = 'I'
						AND record_seq = 1
					)
					GROUP BY update_date, update_seq, record_seq
					HAVING MAX(s_d_type) IN ('I','J')
				) m				
			    WHERE r.doc_num = t.doc_num
			    AND t.client_cd = c.client_cd 	
			    AND r.doc_num = m.ref_doc_num(+)
				AND m.ref_doc_num IS NULL					
			    AND t.seqno = 1						
			    AND t.doc_stat = '2'						
			    AND t.ref_doc_num IN ('UNSETTLED','REPO CLIENT')
--			    AND t.s_d_type = 'J'";	
		
		return $sql;
	}
	
	public static function getOutstandingBuyDetailSql($client_cd, $stk_cd)
	{
		$sql = "SELECT t.doc_num, doc_dt, t.client_cd, client_name, stk_cd, total_share_qty AS qty, price					
				FROM T_STK_MOVEMENT T JOIN MST_CLIENT C ON t.client_cd = c.client_cd								
			    WHERE jur_type = 'TOFFBUY'	
			    AND t.client_cd LIKE '$client_cd'
			    AND stk_cd LIKE '$stk_cd'					
			    AND t.seqno = 1						
			    AND t.doc_stat = '2'						
			    AND t.ref_doc_num = 'UNSETTLED'";	
		
		return $sql;
	}
	
	public static function getOutstandingSellDetailSql($client_cd, $stk_cd)
	{
		$sql = "SELECT t.doc_num, doc_dt, t.client_cd, client_name, stk_cd, withdrawn_share_qty AS qty, price					
				FROM T_STK_MOVEMENT T JOIN MST_CLIENT C ON t.client_cd = c.client_cd								
			    WHERE jur_type = 'TOFFSELL'	
			    AND t.client_cd LIKE '$client_cd'
			    AND stk_cd LIKE '$stk_cd'					
			    AND t.seqno = 1						
			    AND t.doc_stat = '2'						
			    AND t.ref_doc_num = 'UNSETTLED'";	
		
		return $sql;
	}
	
	public static function getSettleDetailSql($doc_dt, $client_cd, $stk_cd, $custodian_cd)
	{
		$result = DAO::queryRowSql("SELECT dflg1 FROM MST_SYS_PARAM WHERE param_id = 'STK MVMT ENTRY' AND param_cd1 = 'CUSTODY' AND param_cd2 = 'BELIJUAL' AND param_cd3 = 'COMBINE'");
			
		if($result && $result['dflg1'] == 'Y')
		{
			//Combine buy with sell
			
			$trxSelect = "SELECT client_cd, client_name, stk_cd, DECODE(SIGN(SUM( DECODE(belijual, 'B', qty, -1 * qty) )), 1, 'B', 'J') belijual, custodian_cd, ABS(SUM(DECODE(belijual, 'B', qty, -1 * qty))) sumqty";
			$trxGroup = "GROUP BY client_cd, client_name, stk_cd, custodian_cd";
		}	
		else
		{
			//Separate buy from sell
			
			$trxSelect = "SELECT client_cd, client_name, stk_cd, belijual, custodian_cd, SUM(qty) sumqty";
			$trxGroup = "GROUP BY client_cd, client_name, stk_cd, belijual, custodian_cd";
		}
		
		$sql = "SELECT a.client_cd, a.client_name, a.stk_cd, DECODE(a.belijual,'B','BELI','JUAL') belijual, a.sumqty AS qty, b.custody_name, a.custodian_cd						
				FROM
				(
					".$trxSelect."						
					FROM
					(
						SELECT t.client_cd, m.client_name, DECODE(t.stk_cd_old, NULL, t.stk_cd, DECODE(SIGN(t.eff_dt - t.due_dt_for_amt), 1, t.stk_cd, DECODE(SUBSTR(t.contr_num,5,1), 'J', t.stk_cd, t.stk_cd_new))) stk_cd, t.qty, SUBSTR(t.contr_num,5,1) belijual, m.custodian_cd		
						FROM 
						(
							SELECT t.contr_dt, t.due_dt_for_amt, contr_stat, t.client_cd, t.stk_cd, t.qty, t.contr_num, c.stk_cd_old, c.stk_cd_new, c.eff_dt
							FROM T_CONTRACTS t
							LEFT JOIN T_CHANGE_STK_CD c ON t.stk_cd = c.stk_cd_old
						) t, 
						MST_CLIENT m	
						WHERE contr_dt > (TO_DATE('$doc_dt','YYYY-MM-DD') - 20) 		
						AND due_dt_for_amt = TO_DATE('$doc_dt','YYYY-MM-DD')		
						AND contr_stat <> 'C'		
						AND t.client_cd = m.client_cd	
						AND m.custodian_cd IS NOT NULL 	
						AND t.client_cd LIKE '$client_cd'
						AND t.stk_cd LIKE '$stk_cd'	
	            		AND (m.custodian_cd = '$custodian_cd' OR '$custodian_cd' = '%')
					)					
					".$trxGroup."
				) a,		
				( 
					SELECT cbest_cd, custody_name			
			  		FROM MST_BANK_CUSTODY
				) b,			
				(
					SELECT DISTINCT client_Cd, stk_Cd, DECODE(JUR_TYPE,'WHDR','B','J') belijual, broker as  custodian_Cd				
					FROM T_STK_MOVEMENT		
					WHERE doc_dt = TO_DATE('$doc_dt','YYYY-MM-DD')		
					AND doc_stat = 2	
					AND s_d_type = 'U' 
				) c,
				(
					SELECT MAX(client_cd) client_cd, MAX(stk_cd) stk_cd, MAX(s_d_type) s_d_type, DECODE(MAX(JUR_TYPE),'WHDR','B','J') BELIJUAL, MAX(CUSTODIAN_CD)CUSTODIAN_CD
					FROM
					(
						SELECT DECODE(field_name,'CLIENT_CD',field_value, NULL) client_cd,
						DECODE(field_name,'STK_CD',field_value, NULL) stk_cd,
						DECODE(field_name,'S_D_TYPE',field_value, NULL) s_d_type,
						DECODE(field_name,'JUR_TYPE',field_value, NULL) JUR_TYPE,--08FEB2017
            			DECODE(field_name,'BROKER',field_value, NULL) CUSTODIAN_CD,--08FEB2017
						a.update_date, a.update_seq, record_seq
						FROM T_MANY_DETAIL a JOIN T_MANY_HEADER b
						ON a.update_seq = b.update_seq
						AND a.update_date = b.update_date
						WHERE menu_name = 'STOCK MOVEMENT ENTRY'
						AND A.TABLE_NAME='T_STK_MOVEMENT'--08FEB2017
	          			AND field_name IN ('CLIENT_CD','STK_CD','S_D_TYPE','JUR_TYPE','BROKER')
						AND approved_status = 'E'
						AND status = 'I'
						AND record_seq = 1
					)
					GROUP BY update_date, update_seq, record_seq
					HAVING MAX(s_d_type) = 'U'
				) d		
				WHERE a.custodian_cd = b.cbest_cd						
				AND a.client_cd = c.client_cd(+)						
				AND a.stk_cd = c.stk_cd(+)	
				AND a.belijual = c.belijual(+)--08FEB2017
        		AND a.custodian_cd = c.custodian_cd(+)--08FEB2017	
				AND a.client_cd = d.client_cd(+)						
				AND a.stk_cd = d.stk_cd(+)	
				AND a.belijual = d.belijual(+)--08feb2017
        		AND a.custodian_cd = d.custodian_cd(+)--08feb2017				
				AND c.client_cd IS NULL						
				AND c.stk_cd IS NULL
				and c.belijual is null--08feb2017
        		and c.custodian_cd is null--08feb2017
				AND d.client_cd IS NULL						
				AND d.stk_cd IS NULL
				and d.belijual is null--08feb2017
        		and d.custodian_cd is null--08feb2017	
				AND a.sumqty <> 0					
				ORDER BY a.client_cd, a.stk_cd, a.belijual";
		return $sql;
	}
	
	public static function getExercise2DetailSql($client_cd, $stk_cd)
	{
		$sql = "SELECT a.client_cd, client_name, stk_cd, withdrawn_share_qty on_hand, withdrawn_share_qty qty, price avg_price
				FROM T_STK_MOVEMENT a JOIN MST_CLIENT b ON a.client_cd = b.client_cd
				WHERE jur_type = 'EXERT0'
				AND a.client_cd LIKE '$client_cd'
				AND stk_cd = '$stk_cd'
				AND ref_doc_num IS null
				AND seqno = 1
				AND doc_stat = 2";
		return $sql;	
	}
	
	public static function getExercise3DetailSql($client_cd, $stk_cd)
	{
		$sql = "SELECT a.client_cd, client_name, stk_cd, total_share_qty on_hand, total_share_qty qty, price avg_price
				FROM T_STK_MOVEMENT a JOIN MST_CLIENT b ON a.client_cd = b.client_cd
				WHERE jur_type = 'EXERBELI'
				AND a.client_cd LIKE '$client_cd'
				AND stk_cd = '$stk_cd'
				AND seqno = 1
				AND doc_stat = 2";
		return $sql;	
	}
	
	public static function getReturnBorrowSql($client_cd, $stk_cd)
	{
		$sql = "SELECT t.doc_num, doc_dt, t.client_cd, client_name, stk_cd, total_share_qty AS qty	
				FROM T_STK_MOVEMENT T JOIN MST_CLIENT C ON t.client_cd = c.client_cd									
			    WHERE jur_type = 'BORROW'	
			    AND t.client_cd LIKE '$client_cd'
			    AND stk_cd LIKE '$stk_cd'					
			    AND t.seqno = 1						
			    AND t.doc_stat = '2'						
			    AND t.ref_doc_num = 'UNSETTLED'";
			    
		return $sql;
	}
	
	public static function getReturnLendingSql($client_cd, $stk_cd, $lend_type)
	{
		$sql = "SELECT t.doc_num, doc_dt, t.client_cd, client_name, stk_cd, withdrawn_share_qty AS qty		
				FROM T_STK_MOVEMENT T JOIN MST_CLIENT C ON t.client_cd = c.client_cd								
			    WHERE jur_type = '$lend_type'	
			    AND t.client_cd LIKE '$client_cd'
			    AND stk_cd LIKE '$stk_cd'					
			    AND t.seqno = 1						
			    AND t.doc_stat = '2'						
			    AND t.ref_doc_num = 'UNSETTLED'";
			    
		return $sql;
	}
	
	public static function getExerciserDetailSql($client_cd, $stk_cd, $withdraw_dt)
	{
		$sql = "SELECT t.doc_num withdraw_doc_num, doc_dt withdraw_dt, t.client_cd, client_name, SUBSTR(stk_cd,1,4) stk_cd, withdrawn_share_qty AS qty		
				FROM T_STK_MOVEMENT T JOIN MST_CLIENT C ON t.client_cd = c.client_cd								
			    WHERE jur_type = 'EXERW'	
			    AND (doc_dt = TO_DATE('$withdraw_dt','YYYY-MM-DD') OR '$withdraw_dt' IS NULL)
			    AND t.client_cd LIKE '$client_cd'
			    AND (stk_cd LIKE '$stk_cd'||'-R' OR stk_cd LIKE '$stk_cd'||'-W')					
			    AND t.seqno = 1						
			    AND t.doc_stat = '2'						
			    AND t.ref_doc_num IS NULL
			    ORDER BY doc_dt, client_cd";
		
		return $sql;
	}
	
	public function validateStkBal()
	{
		$bal_dt = substr($this->doc_dt,0,8).'01';
		
		if(!DAO::queryRowSql("SELECT bal_dt FROM T_STKBAL WHERE bal_dt = TO_DATE('$bal_dt','YYYY-MM-DD')"))
		{
			$this->addError('error_msg','Month end data not found');
			return false;
		}
		
		return true;
	}

	public function rules()
	{
		return array(
			array('doc_dt','checkIfHoliday','on'=>'header, update'),
		
			array('eff_dt, withdraw_dt, tender_pay_dt, price_dt, doc_dt, due_dt_for_cert, due_dt_onhand, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('total_lot, total_share_qty, withdrawn_share_qty, seqno, price, qty, avg_price, on_hand, value', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('doc_dt, doc_rem','required','on'=>'header, update'),
			array('client_cd, stk_cd','required','except'=>'header'),
			array('repo_ref','checkRequired','on'=>'header'),
			array('client_to','checkRdiTo','on'=>'header'),
			array('client_cd','checkSID','on'=>'header'),
			array('client_cd','checkClientType','on'=>'receive, move, exerciser'),
			//array('rdi_flg','checkRdi','on'=>'receive, withdraw, move, reverse, retreverse'),
			array('rdi_flg','checkRdi','except'=>'header, settle'),
			array('qty','required','on'=>'receive'),
			array('qty','checkOnHand','on'=>'withdraw, move, exercisew'),
			array('qty','checkedNotZero','on'=>'settle'),	
			array('qty','notZero','on'=>'receive'),
			array('qty','checkQty','on'=>'update'),	
			//array('qty','checkRatio','on'=>'withdraw'),
			//array('qty','checkRatioMove','on'=>'move'),
			//array('eff_dt','checkEffDt','on'=>'header'),
			array('price','requiredNonZero','on'=>'header'),
			
			array('total_lot, total_share_qty, withdrawn_share_qty, qty', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('ref_doc_num', 'length', 'max'=>15),
			array('client_cd, gl_acct_cd', 'length', 'max'=>12),
			array('stk_cd, regd_hldr', 'length', 'max'=>50),
			array('s_d_type, odd_lot_doc, doc_stat, status, stk_stat, approved_stat', 'length', 'max'=>1),
			array('doc_rem', 'length', 'max'=>60),
			array('withdraw_reason_cd', 'length', 'max'=>5),
			array('acct_type', 'length', 'max'=>4),
			array('user_id', 'length', 'max'=>8),
			array('approved_by, upd_by', 'length', 'max'=>10),
			array('prev_doc_num', 'length', 'max'=>17),
			array('withdraw_doc_num, ratio, ratio_reason, penghentian_pengakuan, serah_saham, movement_type_2, client_name, custody_name, belijual, check, doc_num, movement_type, client_type, repo_ref, client_to, stk_equi, doc_dt, total, cre_dt, upd_dt, due_dt_for_cert, due_dt_onhand, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('from_dt, to_dt, doc_num, ref_doc_num, doc_dt, client_cd, stk_cd, s_d_type, odd_lot_doc, total_lot, total_share_qty, doc_rem, doc_stat, withdrawn_share_qty, regd_hldr, withdraw_reason_cd, gl_acct_cd, acct_type, db_cr_flg, user_id, cre_dt, upd_dt, status, due_dt_for_cert, stk_stat, due_dt_onhand, seqno, price, approved_dt, approved_by, approved_stat, prev_doc_num, upd_by,doc_dt_date,doc_dt_month,doc_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,due_dt_for_cert_date,due_dt_for_cert_month,due_dt_for_cert_year,due_dt_onhand_date,due_dt_onhand_month,due_dt_onhand_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function checkIfHoliday()
	{
		if($this->doc_dt)
		{
			$check = "SELECT dflg1 FROM MST_SYS_PARAM WHERE param_id = 'SYSTEM' AND param_cd1 = 'CHECK' AND param_cd2 = 'HOLIDAY'";
			$checkFlg = DAO::queryRowSql($check);
			
			if($checkFlg['dflg1'] == 'Y')
			{
				$sql = "SELECT F_IS_HOLIDAY('$this->doc_dt') is_holiday FROM dual";
				$isHoliday = DAO::queryRowSql($sql);
				
				if($isHoliday['is_holiday'] == 1)$this->addError('doc_dt','Date must not be holiday');
			}
		}
	}
	
	public function checkClientType()
	{
		$clientDetail = DAO::queryRowSql(self::getClientTypeSql($this->client_cd));
		$clientToDetail = DAO::queryRowSql(self::getClientTypeSql($this->client_to));
		
		if((($this->scenario == 'receive' || $this->scenario == 'exerciser') && $clientDetail['client_type'] == 'M') || ($this->scenario == 'move' && $clientToDetail['client_type'] == 'M'))
		{
			$sql = "SELECT F_CEK_STK_MARGIN('$this->stk_cd','RECEIVE') is_marginable FROM dual";
			$isMarginable = DAO::queryRowSql($sql);
			
			if($isMarginable['is_marginable'] == 0)$this->addError('stk_cd','Stock is not marginable');
		}
	}

	public function checkRdi()
	{
		if($this->rdi_flg)
		{
			$result = DAO::queryRowSql("SELECT prm_desc FROM MST_PARAMETER WHERE prm_cd_1 = 'BLOCK' AND prm_cd_2 = 'RDN'");
			
			$blockFlg = $result['prm_desc'];
			
			if($blockFlg == 'Y')
			{
				//$user_id = Yii::app()->user->id;
				//$sql = "SELECT DSTR1 FROM MST_SYS_PARAM WHERE UPPER(DSTR1) = UPPER('$user_id')";
				//$result = DAO::queryRowSql($sql);
			
				//if(!$result)
				$this->addError('client_cd','Client tidak punya rekening dana');
			}
		}
	}

	public function checkRdiTo()
	{
		if($this->movement_type == 'MOVE')
		{
			$result = DAO::queryRowSql("SELECT cek_rdi_by_sid(client_cd) rdi_flg FROM MST_CLIENT WHERE client_cd = '$this->client_to'");
			if($result['rdi_flg'] == 0)
			{
				$result = DAO::queryRowSql("SELECT prm_desc FROM MST_PARAMETER WHERE prm_cd_1 = 'BLOCK' AND prm_cd_2 = 'RDN'");
			
				$blockFlg = $result['prm_desc'];
			
				if($blockFlg == 'Y')
				{
					//$user_id = Yii::app()->user->id;
					//$sql = "SELECT DSTR1 FROM MST_SYS_PARAM WHERE UPPER(DSTR1) = UPPER('$user_id')";
					//$result = DAO::queryRowSql($sql);
					
					//if(!$result)
					$this->addError('client_to','Client tidak punya rekening dana');
				}
			}
		}
	}

	public function checkOnHand()
	{
		if($this->qty > $this->on_hand)$this->addError('qty', 'Quantity cannot exceed on hand balance');
		else
		{
			$sql = "SELECT F_GET_STOCK_FO('$this->client_cd','$this->stk_cd') fo_stock FROM dual";
			$foStock = DAO::queryRowSql($sql);
			
			if($this->qty > $foStock['fo_stock'])$this->addError('qty', $this->stk_cd.' Theoritical + today\'s trading: '.$foStock['fo_stock']);
		}
	}
	
	public function checkEffDt()
	{
		if($this->movement_type == 'EXERNP' && $this->movement_type_2 == 1)
		{
			if(!$this->eff_dt)$this->addError('eff_dt','Please input the effective date of Corporate Action for '.$this->stk_cd);
		}
	}
	
	public function requiredNonZero()
	{
	    
		if(($this->movement_type == 'TDOSEL' || $this->movement_type == 'TDOBUY') && $this->movement_type_2 == 0 || $this->movement_type_2==2)
		{
			if(!$this->price || $this->price < 0)$this->addError('price','Price must be greater than zero');
		}	
	}
	
	public function checkRatio()
	{
		if(!$this->same_client_flg)
		{
			$clientDetail = DAO::queryRowSql(self::getClientTypeSql($this->client_cd));
			//$result = DAO::queryRowSql("SELECT prm_desc FROM MST_PARAMETER WHERE prm_cd_1 = 'BLOCK' AND prm_cd_2 = 'AR'");
			
			if($clientDetail['client_type'] == 'M')
			{
				$connection  = Yii::app()->db;
				
				try{
					$query  = "CALL GET_RATIO_FO(
								:P_CLIENT_CD,
								:P_STK_CD,
								0,
								:P_WITHDRAW_QTY,
								0,
								:P_MESSAGE_TYPE,
								:P_RATIO,
								:P_RATIO_TXT,
								:P_ERROR_CODE,
								:P_ERROR_MSG
								)";
					
					$command = $connection->createCommand($query);
					$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
					$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
					$command->bindValue(":P_WITHDRAW_QTY",$this->qty,PDO::PARAM_STR);	
							
					$command->bindParam(":P_MESSAGE_TYPE",$this->message_type,PDO::PARAM_STR,10);
					$command->bindParam(":P_RATIO",$this->ratio,PDO::PARAM_STR,10);
					$command->bindParam(":P_RATIO_TXT",$this->ratio_txt,PDO::PARAM_STR,200);
					$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
					$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);
		
					$command->execute();
					
				}catch(Exception $ex){
					if($this->error_code = -999)
						$this->error_msg = $ex->getMessage();
				}
				
				if($this->error_code < 0)
				{
					$this->addError('qty', 'Fail to get ratio from FO '.$this->error_msg);
				}
				else
				{
					if($this->ratio > 0 || $this->ratio == -1 || $this->ratio < 0)
					{
						if($this->message_type == 0)
						{
							
						}
						else 
						{
							$this->addError('qty', 'Withdraw Failed '.$this->ratio_txt);
						}
					}
				}
			}
		}
	}

	public function checkRatioMove()
	{
		if(!$this->same_client_flg)
		{
			$clientDetail = DAO::queryRowSql(self::getClientTypeSql($this->client_cd));
			//$result = DAO::queryRowSql("SELECT prm_desc FROM MST_PARAMETER WHERE prm_cd_1 = 'BLOCK' AND prm_cd_2 = 'AR'");
			
			if($clientDetail['client_type'] == 'M')
			{
				$porto_disc = DAO::queryRowSql("SELECT F_CALC_PORTFOLIO_DISCT('$this->client_cd','$this->stk_cd','$this->qty') qty FROM dual");
				
				$total_withdraw = $porto_disc['qty'];// + $this->qty;
				
				$connection  = Yii::app()->db;
				
				try{
					$query  = "CALL GET_RATIO_FO(
								:P_CLIENT_CD,
								:P_STK_CD,
								0,
								0,
								:P_WITHDRAW_PORTO_DISCT,
								:P_MESSAGE_TYPE,
								:P_RATIO,
								:P_RATIO_TXT,
								:P_ERROR_CODE,
								:P_ERROR_MSG
								)";
					
					$command = $connection->createCommand($query);
					$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
					$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
					$command->bindValue(":P_WITHDRAW_PORTO_DISCT",$total_withdraw,PDO::PARAM_STR);	
							
					$command->bindParam(":P_MESSAGE_TYPE",$this->message_type,PDO::PARAM_STR,10);
					$command->bindParam(":P_RATIO",$this->ratio,PDO::PARAM_STR,10);
					$command->bindParam(":P_RATIO_TXT",$this->ratio_txt,PDO::PARAM_STR,200);
					$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
					$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);
		
					$command->execute();
					
				}catch(Exception $ex){
					if($this->error_code = -999)
						$this->error_msg = $ex->getMessage();
				}
		
				if($this->error_code < 0)
				{
					$this->addError('qty', 'Fail to get ratio from FO '.$this->error_msg);
				}
				else
				{
					if($this->ratio > 0 || $this->ratio == -1 || $this->ratio < 0)
					{
						if($this->message_type == 0)
						{
							
						}
						else 
						{
							$this->addError('qty', 'Move Failed '.$this->ratio_txt);
						}
					}
				}
			}
		}	
	}
	
	public function checkRequired()
	{
		if($this->movement_type == 'RRPOT' || $this->movement_type == 'RRPO' || $this->movement_type == 'RPOT' || $this->movement_type == 'RPO')
		{
			if(!$this->repo_ref)$this->addError('repo_ref','Nomor perjanjian must be selected');
		}
	}
	
	public function checkedNotZero()
	{
		if($this->check == 'Y')
		{
			if($this->qty <= 0)$this->addError('qty','Quantity must be greater than zero');
		}
	}
	
	public function notZero()
	{
		if($this->qty <= 0)$this->addError('qty','Quantity must be greater than zero');
	}
	
	public function checkQty()
	{
		if($this->jur_type == 'WHDR' || $this->jur_type == 'WHDRS' || $this->jur_type == 'LEND' || $this->jur_type == 'LENDPE' || $this->jur_type == 'TOFFSELL')
		{
			$result1 = DAO::queryRowSql("SELECT NVL(total_share_qty,0) + NVL(withdrawn_share_qty,0) qty FROM T_STK_MOVEMENT WHERE doc_num = '$this->doc_num' AND seqno = 1");
			$result2 = DAO::queryRowSql("SELECT on_hand FROM T_STKHAND WHERE client_cd = '$this->client_cd' AND stk_cd = '$this->stk_cd'");
			
			$old_qty = $result1['qty'];
			$this->on_hand = $old_qty + $result2['on_hand'];
			$this->qty = $this->total_share_qty + $this->withdrawn_share_qty;
				
			//$this->checkOnHand();
			
			if($this->qty > $this->on_hand)$this->addError('qty', 'Quantity cannot exceed on hand balance');
			else
			{
				$sql = "SELECT F_GET_STOCK_FO('$this->client_cd','$this->stk_cd') fo_stock FROM dual";
				$foStock = DAO::queryRowSql($sql);
				
				if($this->qty > ($foStock['fo_stock'] + $old_qty))$this->addError('qty', $this->stk_cd.' Theoritical + today\'s trading: '.$foStock['fo_stock']);
			}
		}
	}

	
	public function checkSID()
	{
		if($this->movement_type == 'MOVE')
		{
			$result = DAO::queryRowSql("SELECT prm_desc FROM MST_PARAMETER WHERE prm_cd_1 = 'BLOCK' AND prm_cd_2 = 'SID'");
			
			$blockFlg = $result['prm_desc'];
			
			if($blockFlg == 'Y')
			{
				$clientFrom = DAO::queryRowSql("SELECT SID FROM MST_CIF WHERE CIFS = (SELECT CIFS FROM MST_CLIENT WHERE CLIENT_CD = '$this->client_cd')");
				$clientTo = DAO::queryRowSql("SELECT SID FROM MST_CIF WHERE CIFS = (SELECT CIFS FROM MST_CLIENT WHERE CLIENT_CD = '$this->client_to')");
				
				if($clientFrom['sid'] != $clientTo['sid'])
				{
					$count = DAO::queryRowSql("SELECT COUNT(*) result FROM T_STKMOV_EXCEPT WHERE client_cd IN ('$this->client_cd','$this->client_to')");
					
					if($count['result'] < 2)
						$this->addError('client_cd','Both Clients must have same SID');
				}
			}
		}
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'doc_num' => 'Journal Number',
			'ref_doc_num' => 'Ref Doc Num',
			'doc_dt' => 'Date',
			'client_cd' => 'Client Code',
			'stk_cd' => 'Stock Code',
			's_d_type' => 'S D Type',
			'odd_lot_doc' => 'Odd Lot Doc',
			'total_lot' => 'Total Lot',
			'total_share_qty' => 'Total Share Qty',
			'doc_rem' => 'Description',
			'doc_stat' => 'Doc Stat',
			'withdrawn_share_qty' => 'Withdrawn Share Qty',
			'regd_hldr' => 'Regd Hldr',
			'withdraw_reason_cd' => 'Broker',
			'gl_acct_cd' => 'Gl Acct Code',
			'acct_type' => 'Acct Type',
			'db_cr_flg' => 'Db Cr Flg',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'status' => 'Status',
			'due_dt_for_cert' => 'Due Date For Cert',
			'stk_stat' => 'Stk Stat',
			'due_dt_onhand' => 'Due Date Onhand',
			'seqno' => 'Seqno',
			'price' => 'Price',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Stat',
			'prev_doc_num' => 'Prev Doc Num',
			'upd_by' => 'Upd By',
			
			'repo_ref' => 'Nomor Perjanjian',
			'price_dt' => 'Price Date',
			'withdraw_dt' => 'Withdraw Date',
			'eff_dt' => 'Effective Date',
			'client_to' => 'To Client',
			'stk_equi' => 'Stock Code (Equitas)',
			'tender_pay_dt' => 'Tender Offer Payment Date',
			'from_dt' => 'From Date',
			'to_dt'	=> 'To Date',
			
			'sl_desc_debit' => 'Debit',
			'sl_desc_credit' => 'Credit',
			
			'movement_type_2'=>'Tahap / Option'
		);
	}


	public function search($cancelMultipleFlg = false)
	{
		$criteria = new CDbCriteria;
		
		/*$criteria->select = "doc_Dt, client_Cd, stk_Cd, DECODE(SUBSTR(doc_num,5,1),'R','Receipt', 'W','Withdraw','J',DECODE(SUBSTR(ref_doc_num,1,4),'REPO','Reverse Repo','Return Reverse Repo') ) AS movement_type,						
		 						(total_share_qty + withdrawn_share_qty) AS qty,	doc_rem, price, doc_num, db_cr_flg, seqno, ref_doc_num";*/
		 
		$criteria->select = "doc_Dt, client_Cd, stk_Cd, 
							(
								SELECT mvmt_desc FROM MST_SECU_ACCT WHERE mvmt_type = t.jur_type AND rownum = 1
							) movement_type, 
							/*CASE 
								WHEN jur_type IN ('RECV','3336') THEN 'RECEIVE'
								WHEN jur_type IN ('WHDR','WHDRS') THEN 'WITHDRAW'
								WHEN jur_type IN ('REPO','REPOY') THEN 'REPO'
								WHEN jur_type IN ('REPORTN','REPOYRTN') THEN 'RETURN REPO'
								WHEN jur_type IN ('REREPOC','REREPOS','REREPOY') THEN 'REVERSE REPO'
								WHEN jur_type IN ('REREPOCRTN','REREPOSRTN','REREPOYRTN') THEN 'RETURN REVERSE REPO'
								WHEN jur_type IN ('EXERT0','EXERBELI','EXERSERAH','EXERRECV1','EXERRECV2') THEN 'EXERCISE HMETD'
								WHEN jur_type IN ('TOFFBUY','TOFFBUYDU1','TOFFBUYDU2') THEN 'TENDER OFFER BUY'
								WHEN jur_type IN ('TOFFSELL','TOFFSELLDU') THEN 'TENDER OFFER SELL'
								WHEN jur_type IN ('BORROW') THEN 'BORROWING'
								WHEN jur_type IN ('BORROWRTN') THEN 'RETURN BORROWING'
								WHEN jur_type IN ('LEND','LENDPE') THEN 'LENDING'
								WHEN jur_type IN ('LENDRTN','LENDPERTN') THEN 'RETURN LENDING'
								ELSE
									NULL
							END	movement_type,	*/					
		 						
		 						(total_share_qty + withdrawn_share_qty) AS qty,	doc_rem, price, doc_num, db_cr_flg, seqno, ref_doc_num";
		
		/*$criteria->join = "LEFT JOIN ( 
								SELECT trim(prm_cd_2) mvmt_code, prm_desc AS movement_type		
								FROM MST_PARAMETER		
								WHERE prm_cd_1 = 'SDTYPE'
							) m
							ON t.s_d_type = m.mvmt_code"; */
		 						
		if(!$this->from_dt && !$this->to_dt)
			$criteria->condition = "doc_dt BETWEEN TRUNC(SYSDATE) - 31 AND TRUNC(SYSDATE)";
		else if(!$this->from_dt)
			$criteria->condition = "doc_dt <= TO_DATE('$this->to_dt','DD/MM/YYYY')";
		else if(!$this->to_dt)
			$criteria->condition = "doc_dt >= TO_DATE('$this->from_dt','DD/MM/YYYY')";
		else
			$criteria->condition = "doc_dt BETWEEN TO_DATE('$this->from_dt','DD/MM/YYYY') AND TO_DATE('$this->to_dt','DD/MM/YYYY')";
			
		switch($this->movement_type)
		{
			case 'R':
				$criteria->addCondition("jur_type IN ('RECV','3336') AND s_d_type = 'C'");
				break;
				
			case 'W':
				$criteria->addCondition("jur_type IN ('WHDR','WHDRS') AND s_d_type = 'C'");
				break;
				
			case 'RW':
				$criteria->addCondition("jur_type IN ('RECV','3336','WHDR','WHDRS') AND s_d_type = 'C'");
				break;
				
			case 'REPO':
				$criteria->addCondition("jur_type IN ('REPO','REPOY','REPORTN','REPOYRTN')");
				break;
				
			case 'REREPO':
				$criteria->addCondition("jur_type IN ('REREPOC','REREPOS','REREPOY','REREPOCRTN','REREPOSRTN','REREPOYRTN')");
				break;
				
			case 'EXERCS':
				$criteria->addCondition("jur_type IN ('EXERT0','EXERBELI','EXERSERAH','EXERRECV1','EXERRECV2')");
				break;
				
			case 'EXERNP':
				$criteria->addCondition("jur_type IN ('EXERR','EXERW')");
				break;
				
			case 'SETTLE':
				$criteria->addCondition("jur_type IN ('RECV','3336','WHDR','WHDRS') AND s_d_type = 'U'");
				break;
				
			case 'TDOBUY':
				$criteria->addCondition("jur_type IN ('TOFFBUY','TOFFBUYDU1','TOFFBUYDU2')");
				break;
				
			case 'TDOSEL':
				$criteria->addCondition("jur_type IN ('TOFFSELL','TOFFSELLDU')");
				break;
				
			case 'BORROW':
				$criteria->addCondition("jur_type IN ('BORROW','BORROWRTN')");
				break;
				
			case 'LEND':
				$criteria->addCondition("jur_type IN ('LEND','LENDPE','LENDRTN','LENDPERTN')");
				break;
				
			case 'HMETD':
				$criteria->addCondition("jur_type IN ('HMETDC','HMETDD')");
				break;
		
			case 'SPLIT':
				$criteria->addCondition("jur_type IN ('SPLITD','SPLITX') OR s_d_type = 'S'");
				break;
				
			case 'REVERSE':
				$criteria->addCondition("jur_type IN ('REVERSED','REVERSEX') OR s_d_type = 'R'");
				break;
				
			case 'BONUS':
				$criteria->addCondition("jur_type IN ('BONUSC','BONUSD')");
				break;
				
			case 'STKDIV':
				$criteria->addCondition("jur_type IN ('STKDIVC','STKDIVD')");
				break;
				
			default:
				break;
		}
		
		
		$criteria->addCondition("seqno = 1 AND doc_stat = '2'");
		
		/*$criteria->addCondition("SUBSTR(doc_num,5,3) IN ('JVA' ,'RSN','WSN')							
				AND (SUBSTR(doc_num,5,1) = '$this->movement_type'
					OR s_d_type = 'C' AND '$this->movement_type' = 'RW' 
					OR SUBSTR(ref_doc_num,1,4) = 'REPO' AND '$this->movement_type' = 'REPO' 
					OR ref_doc_num is not null AND SUBSTR(ref_doc_num,1,4) <> 'REPO' AND '$this->movement_type' = 'RETURN' 
					OR SUBSTR(doc_num,5,3) = 'JVA' AND '$this->movement_type' = 'ALLREPO' 
					OR s_d_type = 'U' AND '$this->movement_type' = 'SETTLE' 
					OR '$this->movement_type' ='ALL') 						
				AND seqno = 1							
				AND doc_stat = '2'	");*/
		
		if(!empty($this->doc_dt_date))
			$criteria->addCondition("TO_CHAR(t.doc_dt,'DD') LIKE '%".$this->doc_dt_date."%'");
		if(!empty($this->doc_dt_month))
			$criteria->addCondition("TO_CHAR(t.doc_dt,'MM') LIKE '%".$this->doc_dt_month."%'");
		if(!empty($this->doc_dt_year))
			$criteria->addCondition("TO_CHAR(t.doc_dt,'YYYY') LIKE '%".$this->doc_dt_year."%'");		
			
		$criteria->compare('UPPER(client_cd)',strtoupper($this->client_cd),true);
		$criteria->compare('doc_num',$this->doc_num,true);
		$criteria->compare('ref_doc_num',$this->ref_doc_num,true);
		$criteria->compare('UPPER(stk_cd)',strtoupper($this->stk_cd));
		$criteria->compare('s_d_type',$this->s_d_type,true);
		$criteria->compare('odd_lot_doc',$this->odd_lot_doc,true);
		$criteria->compare('total_lot',$this->total_lot);
		$criteria->compare('total_share_qty',$this->total_share_qty);
		$criteria->compare('doc_rem',$this->doc_rem,true);
		$criteria->compare('doc_stat',$this->doc_stat,true);
		$criteria->compare('withdrawn_share_qty',$this->withdrawn_share_qty);
		$criteria->compare('regd_hldr',$this->regd_hldr,true);
		$criteria->compare('withdraw_reason_cd',$this->withdraw_reason_cd,true);
		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('acct_type',$this->acct_type,true);
		$criteria->compare('db_cr_flg',$this->db_cr_flg,true);
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
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('status',$this->status,true);

		if(!empty($this->due_dt_for_cert_date))
			$criteria->addCondition("TO_CHAR(t.due_dt_for_cert,'DD') LIKE '%".$this->due_dt_for_cert_date."%'");
		if(!empty($this->due_dt_for_cert_month))
			$criteria->addCondition("TO_CHAR(t.due_dt_for_cert,'MM') LIKE '%".$this->due_dt_for_cert_month."%'");
		if(!empty($this->due_dt_for_cert_year))
			$criteria->addCondition("TO_CHAR(t.due_dt_for_cert,'YYYY') LIKE '%".$this->due_dt_for_cert_year."%'");		$criteria->compare('stk_stat',$this->stk_stat,true);

		if(!empty($this->due_dt_onhand_date))
			$criteria->addCondition("TO_CHAR(t.due_dt_onhand,'DD') LIKE '%".$this->due_dt_onhand_date."%'");
		if(!empty($this->due_dt_onhand_month))
			$criteria->addCondition("TO_CHAR(t.due_dt_onhand,'MM') LIKE '%".$this->due_dt_onhand_month."%'");
		if(!empty($this->due_dt_onhand_year))
			$criteria->addCondition("TO_CHAR(t.due_dt_onhand,'YYYY') LIKE '%".$this->due_dt_onhand_year."%'");		$criteria->compare('seqno',$this->seqno);
		
		$criteria->compare('price',$this->price);
		if($this->qty)$criteria->addCondition("withdrawn_share_qty + total_share_qty = '$this->qty'");

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);
		$criteria->compare('prev_doc_num',$this->prev_doc_num,true);
		$criteria->compare('upd_by',$this->upd_by,true);
		
		$sort = new CSort;
		$sort->defaultOrder = 'doc_dt DESC, client_cd, stk_Cd';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>$cancelMultipleFlg?false:array()
		));
	}
}