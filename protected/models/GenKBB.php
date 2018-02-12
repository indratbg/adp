<?php

class GenKBB extends Tpayrech
{
	public $branch_all_flg;
	public $save_text_flg;
	public $save_excel_flg;
	public $save_csv_flg;
	
	public $doc_num;
	public $trf_id;
	public $trans_date;
	public $trans_amount;
	public $from_acct;
	public $to_acct;
	public $bank_acct_num;
	public $bi_code;
	public $bank_branch_name;
	public $remark_1;
	public $remark_2;
	public $jenis;
	public $receiver_name;
	public $customer_type;
	public $customer_residence;
	
	public $bank_acct_cd;
	public $bank_name;
	public $currency;
	public $descrip;
	public $cnt;
	public $tanggal;
	public $e_mail;
	public $trx_type;
	
	public $bank_acct_cd_csv;
	public $bank_name_csv;
	public $bank_acct_fmt_csv;
	public $acct_name_csv;
	
	public $method;
	
	public $upd_flg;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getKbbApSql($end_date, $branch)
	{
		/*$sql = "SELECT acct_name, TO_DATE('$end_date','YYYY-MM-DD') AS trans_date, curr_amt AS trans_amount, bank_acct_num, 'BCA' bank_cd, '1111111' bi_code,
				'JAKARTA' bank_branch_name,	'AP-'||t.client_cd remark_1, branch_code||' '||t.folder_cd  remark_2, 'BCA' Jenis
				FROM
				(  
					SELECT CLIENT_CD, CURR_AMT, folder_cd
         			FROM T_PAYRECH
		 			WHERE PAYREC_DATE = TO_DATE('$end_date','YYYY-MM-DD')
					AND acct_type = 'RDI'
					AND payrec_type = 'PV'
		 			--AND (approved_sts = :s_status OR :s_status = '%')
		 			AND approved_sts <> 'C'
				) t,
				( 
					SELECT *
		  			FROM
		  			( 
		  				SELECT mst_client.client_cd, REM_CD,  SUBSTR(mst_client_flacct.acct_name,1,35) AS acct_name, mst_client_flacct.bank_acct_num,
				 		DECODE(TRIM(mst_client.rem_cd), 'LOT','LO', DECODE(TRIM(mst_client.olt),'N',trim(branch_code),'LO')) AS brch,
				 		DECODE(TRIM(mst_client.rem_cd), 'LOT','LOT/'||TRIM(branch_code), DECODE(TRIM(mst_client.olt),'N',TRIM(branch_code),'LOT/'||TRIM(branch_code))) AS branch_code
				 		FROM mst_client_flacct, mst_client
				 		WHERE mst_client_flacct.client_cd = mst_client.client_cd
				 		AND mst_client_flacct.acct_stat = 'A'
				 		AND mst_client_flacct.bank_cd = 'BCA02'
					)
					WHERE INSTR('$branch',trim(brch)) > 0
				) m
		 		WHERE t.client_cd = m.client_cd
				ORDER BY remark_2, remark_1";*/	
				
		$sql = "SELECT REPLACE(acct_name,',',' ') acct_name, TO_DATE('$end_date','YYYY-MM-DD') AS trans_date, trim(TO_CHAR(curr_amt,'9999999999999999.99')) AS trans_amount,						
				bank_acct_num, 'BCA' bank_cd, '1111111' bi_code, 'JAKARTA' bank_branch_name, t.client_cd||' '||t.folder_cd remark_1, branch_code||' '||doc_num  remark_2,					
				'BCA' Jenis, customer_type, customer_residence, doc_num, upd_flg, payrec_num	
				FROM
				( 	
					SELECT client_cd, curr_amt, folder_cd, doc_num, upd_flg, payrec_num
					FROM
					(						
		  				SELECT CLIENT_CD, CURR_AMT, folder_cd, p.doc_num, 'Y' upd_flg, payrec_num				
		   				FROM
		   				( 						
		   					SELECT P1.CLIENT_CD, CURR_AMT, folder_cd, m.doc_num, payrec_num	
		    				FROM
		    				( 						
		    					SELECT payrec_num, client_cd, curr_amt, folder_cd		
			 					FROM T_PAYRECH				
			 					WHERE PAYREC_DATE = TO_DATE('$end_date','YYYY-MM-DD')					
								AND acct_type  = 'RDI'					
								AND payrec_type IN ('PV', 'PD')
								AND approved_sts <> 'C'												
							) p1,		
							( 
								SELECT doc_num, doc_ref_num					
			  					FROM t_fund_movement 					
			  					WHERE doc_date = TO_DATE('$end_date','YYYY-MM-DD')					
			  					AND approved_sts = 'A'
							)  m					
							WHERE P1.payrec_num = m.doc_ref_num(+)					
						) p,					
			 			( 					
			 				SELECT doc_num, trf_flg					
			    			FROM T_FUND_TRF					
							WHERE trf_date = TO_DATE('$end_date','YYYY-MM-DD')												
						) f				
						WHERE  p.doc_num = f.doc_num 					
						AND f.trf_flg = 'N'
						UNION
						SELECT MAX(client_cd), TO_NUMBER(MAX(curr_amt)), MAX(folder_cd), NULL doc_num, 'N' upd_flg, MAX(payrec_num)	
						FROM
						(
							SELECT DECODE (field_name, 'CLIENT_CD', field_value, NULL) client_cd,
									DECODE (field_name, 'CURR_AMT', field_value, NULL) curr_amt,
									DECODE (field_name, 'FOLDER_CD', field_value, NULL) folder_cd,
									DECODE (field_name, 'PAYREC_DATE', field_value, NULL) payrec_date,
									DECODE (field_name, 'ACCT_TYPE', field_value, NULL) acct_type,
									DECODE (field_name, 'PAYREC_TYPE', field_value, NULL) payrec_type,
									DECODE (field_name, 'PAYREC_NUM', field_value, NULL) payrec_num,
							a.update_seq, a.record_seq
							FROM T_MANY_DETAIL a JOIN T_MANY_HEADER b
							ON a.update_date = b.update_date
							AND a.update_seq = b.update_seq
							WHERE b.approved_status = 'E'
							AND a.table_name = 'T_PAYRECH'
							AND a.upd_status = 'I'
						)
						GROUP BY update_seq, record_seq
						HAVING TO_DATE(MAX(payrec_date),'YYYY/MM/DD HH24:MI:SS') = TO_DATE('$end_date','YYYY-MM-DD')
						AND MAX(acct_type) = 'RDI'
						AND MAX(payrec_type) IN ('PV','PD')
					) t
					LEFT JOIN
					(
						SELECT d.trx_ref
						FROM T_H2H_REF_DETAIL d JOIN T_H2H_REF_HEADER h
						ON d.trf_id = h.trf_id
						WHERE h.trf_date = TO_DATE('$end_date','YYYY-MM-DD')
						--AND NVL(d.status,'00') = '00'--26 jan 2017
						AND (d.status IS NULL or d.status ='00') ---SUPAYA GAK DIRETRIEVE YANG PROSES WAITING
						
					) h
					ON t.payrec_num = h.trx_ref
					WHERE h.trx_ref IS NULL
				) t,					
				( 
					SELECT *					
		  			FROM
		  			( 
		  				SELECT mst_client.client_cd, REM_CD,  SUBSTR(mst_client_flacct.acct_name,1,35) AS acct_name, mst_client_flacct.bank_acct_num,					
				 		DECODE(trim(mst_client.rem_cd), 'LOT','LOT/'||trim(branch_code), trim(branch_code)) AS branch_code,
				 		DECODE(trim(mst_client.rem_cd), 'LOT','LO', trim(branch_code)) AS brch,
				 		DECODE(client_type_1, 'I','1','C','2') customer_type,			
				 		DECODE(client_type_2, 'L','R','N') customer_residence			
				 		FROM mst_client_flacct, mst_client			
				 		WHERE mst_client_flacct.client_cd = mst_client.client_cd			
				 		AND mst_client_flacct.acct_stat <> 'C'			
				 		AND mst_client_flacct.bank_cd = 'BCA02'
					)			
		   			WHERE INSTR('$branch',brch) > 0
				) m				
		 		WHERE t.client_cd = m.client_cd
				ORDER BY remark_2, remark_1";
			
		return $sql;
	}
	
	public static function getKbbArSql($end_date, $branch)
	{
		$sql = "SELECT m.BANK_ACCT_num, TRIM(TO_CHAR(curr_amt,'9999999999999999.99')) AS trans_amount, REPLACE(m.acct_name,',',' ') acct_name, 'AR-' || t.client_cd Remark_1,					
				m.branch_code||' '||t.folder_cd Remark_2, TO_DATE('$end_date','YYYY-MM-DD') Trans_date, upd_flg, payrec_num			
				FROM
				(	
					SELECT client_cd, curr_amt, folder_cd, doc_num, upd_flg, payrec_num
					FROM
					(
						SELECT CLIENT_CD, CURR_AMT, folder_cd, p.doc_num, 'Y' upd_flg, payrec_num			
		   				FROM
		   				( 	
							SELECT P1.CLIENT_CD, CURR_AMT, folder_cd, m.doc_num, payrec_num
							FROM	
							(
								SELECT payrec_num, client_cd, curr_amt, folder_cd				
			         			FROM T_PAYRECH					
					 			WHERE PAYREC_DATE = TO_DATE('$end_date','YYYY-MM-DD')			
					 			AND payrec_type IN ( 'RV','RD')			
					 			AND acct_type = 'RDI'					
					 			AND approved_sts <> 'C'	
					 		)
				 			p1,		
							( 
								SELECT doc_num, doc_ref_num					
			  					FROM t_fund_movement 					
			  					WHERE doc_date = TO_DATE('$end_date','YYYY-MM-DD')					
			  					AND approved_sts = 'A'
							)  m					
							WHERE P1.payrec_num = m.doc_ref_num(+)
						) p,					
			 			( 					
			 				SELECT doc_num, trf_flg					
			    			FROM T_FUND_TRF					
							WHERE trf_date = TO_DATE('$end_date','YYYY-MM-DD')												
						) f				
						WHERE p.doc_num = f.doc_num 					
						AND f.trf_flg = 'N' 			
						UNION
						SELECT MAX(client_cd), TO_NUMBER(MAX(curr_amt)), MAX(folder_cd), NULL doc_num, 'N' upd_flg, MAX(payrec_num)	
						FROM
						(
							SELECT DECODE (field_name, 'CLIENT_CD', field_value, NULL) client_cd,
									DECODE (field_name, 'CURR_AMT', field_value, NULL) curr_amt,
									DECODE (field_name, 'FOLDER_CD', field_value, NULL) folder_cd,
									DECODE (field_name, 'PAYREC_DATE', field_value, NULL) payrec_date,
									DECODE (field_name, 'ACCT_TYPE', field_value, NULL) acct_type,
									DECODE (field_name, 'PAYREC_TYPE', field_value, NULL) payrec_type,
									DECODE (field_name, 'PAYREC_NUM', field_value, NULL) payrec_num,
							a.update_seq, a.record_seq
							FROM T_MANY_DETAIL a JOIN T_MANY_HEADER b
							ON a.update_date = b.update_date
							AND a.update_seq = b.update_seq
							WHERE b.approved_status = 'E'
							AND a.table_name = 'T_PAYRECH'
							AND a.upd_status = 'I'
						)
						GROUP BY update_seq, record_seq
						HAVING TO_DATE(MAX(payrec_date),'YYYY/MM/DD HH24:MI:SS') = TO_DATE('$end_date','YYYY-MM-DD')
						AND MAX(acct_type) = 'RDI'
						AND MAX(payrec_type) IN ('RV','RD')		
					) t
					LEFT JOIN
					(
						SELECT d.trx_ref
						FROM T_H2H_REF_DETAIL d JOIN T_H2H_REF_HEADER h
						ON d.trf_id = h.trf_id
						WHERE h.trf_date = TO_DATE('$end_date','YYYY-MM-DD')
						--AND NVL(d.status,'00') = '00'--26 jan 2017
						AND (d.status IS NULL or d.status ='00') ---SUPAYA GAK DIRETRIEVE YANG PROSES WAITING
					) h
					ON t.payrec_num = h.trx_ref
					WHERE h.trx_ref IS NULL
				) t, 				
				( 				
					SELECT client_cd, acct_name,branch_code, BANK_ACCT_NUM,	customer_type, customer_residence	
					FROM
					(	
						SELECT mst_client.client_cd, SUBSTR(mst_client_flacct.acct_name,1,35) AS acct_name,
						DECODE(TRIM(mst_client.rem_cd), 'LOT','LO',trim(branch_code)) AS brch,
				 		DECODE(TRIM(mst_client.rem_cd), 'LOT','LOT/'||TRIM(branch_code), trim(branch_code)) AS branch_code,	
				 		mst_client_flacct.BANK_ACCT_NUM, DECODE(client_type_1, 'I',1,'C',2) customer_type, DECODE(client_type_2, 'L','R','N') customer_residence	
						FROM mst_client, mst_client_flacct 	
						WHERE susp_stat = 'N' 	
						AND mst_client.client_Cd = mst_client_flacct.client_Cd	
						AND mst_client_flacct.acct_stat IN ( 'A','I')	
						AND mst_client_flacct.bank_cd = 'BCA02'	
					) WHERE INSTR('$branch',trim(brch)) > 0		
			  	) m 		
				WHERE t.client_cd = m.client_Cd 					
				ORDER by m.branch_code, remark_1";
			
		return $sql;					
	}
	
	public static function getKbbToRdiSql($end_date, $type, $branch)
	{
		$sql = "SELECT REPLACE(acct_name,',',' ') acct_name, TO_DATE('$end_date','YYYY-MM-DD') AS trans_date, trim(TO_CHAR(curr_amt,'9999999999999999.99')) AS trans_amount,						
				bank_acct_num, 'BCA' bank_cd, '1111111' bi_code, 'JAKARTA' bank_branch_name, t.client_cd||' '||t.folder_cd remark_1, branch_code||' '||doc_num  remark_2,					
				'BCA' Jenis, customer_type, customer_residence, doc_num, payrec_num
				FROM
				( 	
					SELECT CLIENT_CD, CURR_AMT, folder_cd, t.doc_num, t.trf_flg, trf_fee, payrec_num
					FROM
					(					
		  				SELECT CLIENT_CD, CURR_AMT, folder_cd, p.doc_num, f.trf_flg, trf_fee, payrec_num		
		   				FROM
		   				( 						
		   					SELECT P1.CLIENT_CD, CURR_AMT, folder_cd, m.doc_num, trf_fee, payrec_num				
		    				FROM
		    				( 						
		    					SELECT payrec_num, client_cd, DECODE('$type', 'PAYM', curr_amt, deduct_fee) AS curr_amt, folder_cd, NVL(deduct_fee,0) AS trf_fee			
			 					FROM T_PAYRECH, T_CHEQ					
			 					WHERE PAYREC_DATE = TO_DATE('$end_date','YYYY-MM-DD')					
								AND acct_type  ='RDM'		
								AND payrec_type IN ('PV', 'PD')
								AND approved_sts <> 'C'												
	 							AND T_PAYRECH.payrec_num = T_CHEQ.rvpv_number(+)					
								AND (('$type' = 'PAYM') OR ('$type' = 'FEE' AND deduct_fee > 0))
							) p1,		
							( 
								SELECT doc_num, doc_ref_num					
			  					FROM t_fund_movement 					
			  					WHERE  doc_date = TO_DATE('$end_date','YYYY-MM-DD')					
			  					AND approved_sts = 'A'
							)  m					
							WHERE P1.payrec_num = m.doc_ref_num(+)					
							UNION ALL					
							SELECT  client_cd,fee,folder_cd, doc_num, 0, doc_num		
						  	FROM t_fund_movement 					
						  	WHERE  doc_date = TO_DATE('$end_date','YYYY-MM-DD')					
						  	AND source = 'INPUT'					
						  	AND trx_type = 'W'					
						  	AND to_client = 'LUAR'					
						  	AND '$type' = 'FEE'					
						  	AND NVL(fee,0) > 0					
						  	AND approved_sts = 'A' 
						) p,					
			 			( 					
			 				SELECT doc_num, trf_flg					
			    			FROM T_FUND_TRF					
							WHERE trf_date = TO_DATE('$end_date','YYYY-MM-DD')				
							AND ((trf_id = 'KBB' AND '$type' = 'PAYM') OR (trf_id = 'FEE' AND '$type' = 'FEE'))							
						) f				
						WHERE  p.doc_num = f.doc_num (+)					
						AND (f.doc_num IS NULL OR f.trf_flg = 'N')
					) t
					LEFT JOIN
					(
						SELECT d.trx_ref
						FROM T_H2H_REF_DETAIL d JOIN T_H2H_REF_HEADER h
						ON d.trf_id = h.trf_id
						WHERE h.trf_date = TO_DATE('$end_date','YYYY-MM-DD')
						--AND NVL(d.status,'00') = '00'--26 jan 2017
						AND (d.status IS NULL or d.status ='00') ---SUPAYA GAK DIRETRIEVE YANG PROSES WAITING
					) h
					ON t.payrec_num = h.trx_ref
					WHERE h.trx_ref IS NULL
				) t,					
				( 
					SELECT *					
		  			FROM
		  			( 
		  				SELECT mst_client.client_cd, REM_CD,  SUBSTR(mst_client_flacct.acct_name,1,35) AS acct_name, mst_client_flacct.bank_acct_num,					
				 		DECODE(trim(mst_client.rem_cd), 'LOT','LOT/'||trim(branch_code),trim(branch_code)) AS branch_code,
				 		DECODE(trim(mst_client.rem_cd), 'LOT','LO',trim(branch_code)) AS brch,
				 		DECODE(client_type_1, 'I','1','C','2') customer_type,			
				 		DECODE(client_type_2, 'L','R','N') customer_residence			
				 		FROM mst_client_flacct, mst_client			
				 		WHERE mst_client_flacct.client_cd = mst_client.client_cd			
				 		AND mst_client_flacct.acct_stat <> 'C'			
				 		AND mst_client_flacct.bank_cd = 'BCA02'
					)			
		   			WHERE INSTR('$branch',brch) > 0
				) m				
		 		WHERE t.client_cd = m.client_cd
				ORDER BY remark_2, remark_1";
		
		return $sql;
	}
	//17 jun 2017 untuk appsfund
	public static function getKbbToRdiFundSql($end_date, $type, $branch)
    {
        $sql = "SELECT REPLACE(acct_name,',',' ') acct_name, TO_DATE('$end_date','YYYY-MM-DD') AS trans_date, trim(TO_CHAR(curr_amt,'9999999999999999.99')) AS trans_amount,                        
                bank_acct_num, 'BCA' bank_cd, '1111111' bi_code, 'JAKARTA' bank_branch_name, t.client_cd||' '||t.folder_cd remark_1, branch_code||' '||doc_num  remark_2,                   
                'BCA' Jenis, customer_type, customer_residence, doc_num, payrec_num
                FROM
                (   
                    SELECT CLIENT_CD, CURR_AMT, folder_cd, t.doc_num, t.trf_flg, trf_fee, payrec_num
                    FROM
                    (                   
                        SELECT CLIENT_CD, CURR_AMT, folder_cd, p.doc_num, f.trf_flg, trf_fee, payrec_num        
                        FROM
                        (                       
                            SELECT P1.CLIENT_CD, CURR_AMT, folder_cd, m.doc_num, trf_fee, payrec_num                
                            FROM
                            (                       
                                SELECT payrec_num, client_cd, DECODE('$type', 'PAYM', curr_amt, deduct_fee) AS curr_amt, folder_cd, NVL(deduct_fee,0) AS trf_fee            
                                FROM T_PAYRECH, T_CHEQ                  
                                WHERE PAYREC_DATE = TO_DATE('$end_date','YYYY-MM-DD')                   
                                AND acct_type ='ROR'         
                                AND payrec_type IN ('PV', 'PD')
                                AND approved_sts <> 'C'                                             
                                AND T_PAYRECH.payrec_num = T_CHEQ.rvpv_number(+)                    
                                AND (('$type' = 'PAYM') OR ('$type' = 'FEE' AND deduct_fee > 0))
                            ) p1,       
                            ( 
                                SELECT doc_num, doc_ref_num                 
                                FROM t_fund_movement                    
                                WHERE  doc_date = TO_DATE('$end_date','YYYY-MM-DD')                 
                                AND approved_sts = 'A'
                            )  m                    
                            WHERE P1.payrec_num = m.doc_ref_num(+)                  
                            UNION ALL                   
                            SELECT  client_cd,fee,folder_cd, doc_num, 0, doc_num        
                            FROM t_fund_movement                    
                            WHERE  doc_date = TO_DATE('$end_date','YYYY-MM-DD')                 
                            AND source = 'INPUT'                    
                            AND trx_type = 'W'                  
                            AND to_client = 'LUAR'                  
                            AND '$type' = 'FEE'                 
                            AND NVL(fee,0) > 0                  
                            AND approved_sts = 'A' 
                        ) p,                    
                        (                   
                            SELECT doc_num, trf_flg                 
                            FROM T_FUND_TRF                 
                            WHERE trf_date = TO_DATE('$end_date','YYYY-MM-DD')              
                            AND ((trf_id = 'KBB' AND '$type' = 'PAYM') OR (trf_id = 'FEE' AND '$type' = 'FEE'))                         
                        ) f             
                        WHERE  p.doc_num = f.doc_num (+)                    
                        AND (f.doc_num IS NULL OR f.trf_flg = 'N')
                    ) t
                    LEFT JOIN
                    (
                        SELECT d.trx_ref
                        FROM T_H2H_REF_DETAIL d JOIN T_H2H_REF_HEADER h
                        ON d.trf_id = h.trf_id
                        WHERE h.trf_date = TO_DATE('$end_date','YYYY-MM-DD')
                        --AND NVL(d.status,'00') = '00'--26 jan 2017
                        AND (d.status IS NULL or d.status ='00') ---SUPAYA GAK DIRETRIEVE YANG PROSES WAITING
                    ) h
                    ON t.payrec_num = h.trx_ref
                    WHERE h.trx_ref IS NULL
                ) t,                    
                ( 
                    SELECT *                    
                    FROM
                    ( 
                        SELECT mst_client.client_cd, REM_CD,  SUBSTR(mst_client_flacct.acct_name,1,35) AS acct_name, mst_client_flacct.bank_acct_num,                   
                        DECODE(trim(mst_client.rem_cd), 'LOT','LOT/'||trim(branch_code),trim(branch_code)) AS branch_code,
                        DECODE(trim(mst_client.rem_cd), 'LOT','LO',trim(branch_code)) AS brch,
                        DECODE(client_type_1, 'I','1','C','2') customer_type,           
                        DECODE(client_type_2, 'L','R','N') customer_residence           
                        FROM mst_client_flacct, mst_client          
                        WHERE mst_client_flacct.client_cd = mst_client.client_cd            
                        AND mst_client_flacct.acct_stat <> 'C'          
                        AND mst_client_flacct.bank_cd = 'BCA02'
                    )           
                    WHERE INSTR('$branch',brch) > 0
                ) m             
                WHERE t.client_cd = m.client_cd
                ORDER BY remark_2, remark_1";
        
        return $sql;
    }
	public static function getKbbToClientSql($end_date, $type, $branch)
	{
		$sql = "SELECT t.doc_num, from_acct, F_Clean(to_acct) to_acct, trf_amt AS trans_amount, 
				SUBSTR(t.remarks||' '||t.branch_code,1,18) AS remark_1, SUBSTR(t.remarks||' '||t.branch_code,19,18) AS remark_2,							
				BI_Code, DECODE(trim(to_bank),p.ip_bank_rdi,p.ip_bank_rdi,t.bank_short_name) bank_cd,	DECODE(trim(to_bank),p.ip_bank_rdi,'',REPLACE(t.bank_brch_name,'CABANG ','') ) bank_branch_name,							
				REPLACE(t.acct_name,',',' ') Receiver_Name,	TO_DATE('$end_date','YYYY-MM-DD') AS trans_date, RPAD('$type',3) AS Jenis,							
				customer_type, customer_residence, t.client_cd 							
				FROM
				( 							
					SELECT t.client_cd, trx_amt, fee, DECODE(SIGN(fee),-1,trx_amt - ABS(fee),trx_amt) AS trf_amt, from_bank, from_acct, 						
	  				to_acct, to_bank,v.acct_name, mst_bank_bi.bi_code, remarks, doc_num,mst_client.branch_code, brch, /*NVL(v.bank_name,r.bank_short_name)*/ r.bank_short_name,						
	  				NVL(v.bank_brch_name, '-') AS bank_brch_name, customer_type, customer_residence, folder_cd					
					FROM
					(   
						SELECT a.client_Cd, a.to_bank, a.to_acct, a.remarks, a.doc_num, a.trx_amt, a.from_bank, a.from_acct, a.acct_name, a.fee,						
						NVL(t2.folder_Cd,a.doc_num) folder_Cd	
	      				FROM
	      				( 
	      					SELECT client_Cd, to_bank, to_acct, remarks, doc_num, trx_amt, from_bank, from_acct, acct_name, fee						
		  				 	FROM t_fund_movement 	
				         	WHERE doc_date = TO_DATE('$end_date','YYYY-MM-DD')				
							AND trx_type = 'W'
							and source <> 'VCHFUND'
							AND to_client = 'LUAR'
							AND approved_sts = 'A'
							AND trx_amt > 0 
						) a, 
              			( 
              				SELECT doc_num, doc_ref_num2, h.folder_cd							
                 			FROM t_fund_movement,T_PAYRECH h							
                  			WHERE doc_date 	= TO_DATE('$end_date','YYYY-MM-DD')	 						
                    		AND trx_type = 'R'
                    		and source <> 'VCHFUND'							
							AND t_fund_movement.approved_sts = 'A'		
		                    AND doc_ref_num IS NOT NULL							
		                    AND doc_ref_num = h.payrec_num(+)							
							AND doc_ref_num2 IS NOT NULL
						) t2		
		  				WHERE a .doc_num = t2.doc_ref_num2 (+)					
					) t, 					
	   				( 
						SELECT client_cd, 
						DECODE(TRIM(mst_client.rem_cd), 'LOT','LO', trim(branch_code)) AS brch,		
	      				branch_code, DECODE(client_type_1, 'I','1','C','2') customer_type, DECODE(client_type_2, 'L','R','N') customer_residence				
	      				FROM mst_client						
		  				WHERE susp_stat = 'N'					
		  				AND client_type_1 <> 'B'
					) mst_client,					
					( 
						SELECT bank_cd, bank_short_name,bi_code
                      FROM MST_IP_BANK
                      WHERE APPROVED_STAT = 'A'
					) r,					
					mst_bank_bi, v_client_bank  v						
					WHERE t.client_cd =  mst_client.client_cd						
					AND ( INSTR('$branch',trim( mst_client.brch)) > 0 OR '$branch' = '%')						
					--AND to_bank = mst_bank_bi.ip_bank_cd --[IN] 27/07/2017 ip_bank_cd dari mst_bank_bi tidak dipake lagi	
				    AND R.BI_CODE = mst_bank_bi.bi_code(+)--[IN] 27/07/2017
				    AND MST_BANK_BI.APPROVED_STAT(+)='A'
					AND to_bank = r.bank_cd						
					AND t.client_cd =  v.client_cd(+)						
					AND to_bank = v.bank_cd(+)						
					AND t.to_acct = v.bank_acct_num(+)						
				) t,							
				(							
 					SELECT TRF_DATE, DOC_NUM							
  					FROM T_FUND_TRF							
  					WHERE TRF_DATE = TO_DATE('$end_date','YYYY-MM-DD')								
  					AND TRF_FLG = 'N'							
  				) FT,	
  				(
  					SELECT d.trx_ref
					FROM T_H2H_REF_DETAIL d JOIN T_H2H_REF_HEADER h
					ON d.trf_id = h.trf_id
					WHERE h.trf_date = TO_DATE('$end_date','YYYY-MM-DD')
					--AND NVL(d.status,'00') = '00'--26 jan 2017 
					AND (d.status IS NULL or d.status ='00') ---SUPAYA GAK DIRETRIEVE YANG PROSES WAITING
				) h,						
				(							
 					SELECT dstr1  AS ksei_bank_rdi, param_cd3 ip_bank_rdi							
   					FROM mst_sys_param							
   					WHERE param_id = 'W_TRF_FUND'							
   					AND param_cd1 = 'BANKRDI'							
 				) p							
				WHERE (from_bank = p.ip_bank_rdi OR from_bank = p.ksei_bank_rdi)							
				AND t.doc_num = FT.doc_num
				AND t.doc_num = h.trx_ref(+)
				AND h.trx_ref IS NULL					
				AND ((trx_amt <= 500000000 AND '$type' = 'LLG' AND to_bank <> ip_bank_rdi)							
      			OR (trx_amt > 500000000 AND '$type' = 'RTG' AND to_bank <> ip_bank_rdi)							
	  			OR (to_bank = '$type'))";
	
		return $sql;
	}
	//17 jun 2017 untuk appsfund
	public static function getKbbToClientFundSql($end_date, $type, $branch)
    {
        $sql = "SELECT t.doc_num, from_acct, F_Clean(to_acct) to_acct, trf_amt AS trans_amount, 
                SUBSTR(t.remarks||' '||t.branch_code,1,18) AS remark_1, SUBSTR(t.remarks||' '||t.branch_code,19,18) AS remark_2,                            
                BI_Code, DECODE(trim(to_bank),p.ip_bank_rdi,p.ip_bank_rdi,t.bank_short_name) bank_cd,   DECODE(trim(to_bank),p.ip_bank_rdi,'',REPLACE(t.bank_brch_name,'CABANG ','') ) bank_branch_name,                            
                REPLACE(t.acct_name,',',' ') Receiver_Name, TO_DATE('$end_date','YYYY-MM-DD') AS trans_date, RPAD('$type',3) AS Jenis,                          
                customer_type, customer_residence, t.client_cd                          
                FROM
                (                           
                    SELECT t.client_cd, trx_amt, fee, DECODE(SIGN(fee),-1,trx_amt - ABS(fee),trx_amt) AS trf_amt, from_bank, from_acct,                         
                    to_acct, to_bank,v.acct_name, mst_bank_bi.bi_code, remarks, doc_num,mst_client.branch_code, brch, /*NVL(v.bank_name,r.bank_short_name)*/ r.bank_short_name,                     
                    NVL(v.bank_brch_name, '-') AS bank_brch_name, customer_type, customer_residence, folder_cd                  
                    FROM
                    (   
                        SELECT a.client_Cd, a.to_bank, a.to_acct, a.remarks, a.doc_num, a.trx_amt, a.from_bank, a.from_acct, a.acct_name, a.fee,                        
                        NVL(t2.folder_Cd,a.doc_num) folder_Cd   
                        FROM
                        ( 
                            SELECT client_Cd, to_bank, to_acct, remarks, doc_num, trx_amt, from_bank, from_acct, acct_name, fee                     
                            FROM t_fund_movement    
                            WHERE doc_date = TO_DATE('$end_date','YYYY-MM-DD')              
                            AND trx_type = 'W'
                            AND to_client = 'LUAR'
                            AND approved_sts = 'A'
                            AND trx_amt > 0 
                            and source='VCHFUND'
                        ) a, 
                        ( 
                            SELECT doc_num, doc_ref_num2, h.folder_cd                           
                            FROM t_fund_movement,T_PAYRECH h                            
                            WHERE doc_date  = TO_DATE('$end_date','YYYY-MM-DD')                         
                            AND trx_type = 'R'      
                            and source='VCHFUND'                    
                            AND t_fund_movement.approved_sts = 'A'      
                            AND doc_ref_num IS NOT NULL                         
                            AND doc_ref_num = h.payrec_num(+)                           
                            AND doc_ref_num2 IS NOT NULL
                        ) t2        
                        WHERE a .doc_num = t2.doc_ref_num2 (+)                  
                    ) t,                    
                    ( 
                        SELECT client_cd, DECODE(TRIM(mst_client.rem_cd), 'LOT','LO', trim(branch_code)) AS brch,     
                        branch_code, DECODE(client_type_1, 'I','1','C','2') customer_type, DECODE(client_type_2, 'L','R','N') customer_residence                
                        FROM mst_client                     
                        WHERE susp_stat = 'N'                   
                        AND client_type_1 <> 'B'
                    ) mst_client,                   
                    ( 
                      SELECT bank_cd,bank_short_name, bi_code
                      FROM MST_IP_BANK
                      WHERE APPROVED_STAT = 'A'
                    ) r,                    
                    mst_bank_bi, v_client_bank  v                       
                    WHERE t.client_cd =  mst_client.client_cd                       
                    AND ( INSTR('$branch',trim( mst_client.brch)) > 0 OR '$branch' = '%')                       
                    --AND to_bank = mst_bank_bi.ip_bank_cd --[IN] 27/07/2017 ip_bank_cd dari mst_bank_bi tidak dipake lagi  
                    AND R.BI_CODE = mst_bank_bi.bi_code(+)--[IN] 27/07/2017  
                    AND MST_BANK_BI.APPROVED_STAT(+)='A'
                    AND to_bank = r.bank_cd                        
                    AND t.client_cd =  v.client_cd(+)                       
                    AND to_bank = v.bank_cd(+)                      
                    AND t.to_acct = v.bank_acct_num(+)                      
                ) t,                            
                (                           
                    SELECT TRF_DATE, DOC_NUM                            
                    FROM T_FUND_TRF                         
                    WHERE TRF_DATE = TO_DATE('$end_date','YYYY-MM-DD')                              
                    AND TRF_FLG = 'N'                           
                ) FT,   
                (
                    SELECT d.trx_ref
                    FROM T_H2H_REF_DETAIL d JOIN T_H2H_REF_HEADER h
                    ON d.trf_id = h.trf_id
                    WHERE h.trf_date = TO_DATE('$end_date','YYYY-MM-DD')
                    --AND NVL(d.status,'00') = '00'--26 jan 2017 
                    AND (d.status IS NULL or d.status ='00') ---SUPAYA GAK DIRETRIEVE YANG PROSES WAITING
                ) h,                        
                (                           
                    SELECT dstr1  AS ksei_bank_rdi, param_cd3 ip_bank_rdi                           
                    FROM mst_sys_param                          
                    WHERE param_id = 'W_TRF_FUND'                           
                    AND param_cd1 = 'BANKRDI'                           
                ) p                         
                WHERE (from_bank = p.ip_bank_rdi OR from_bank = p.ksei_bank_rdi)                            
                AND t.doc_num = FT.doc_num
                AND t.doc_num = h.trx_ref(+)
                AND h.trx_ref IS NULL                   
                AND ((trx_amt <= 500000000 AND '$type' = 'LLG' AND to_bank <> ip_bank_rdi)                          
                OR (trx_amt > 500000000 AND '$type' = 'RTG' AND to_bank <> ip_bank_rdi)                         
                OR (to_bank = '$type'))";
    
        return $sql;
    }
	public static function getKbbToClientIPOSql($end_date, $type, $branch)
	{
		$sql = "SELECT t.doc_num, from_acct, F_Clean(to_acct) to_acct, trf_amt AS trans_amount, 
				SUBSTR(t.remarks||' '||t.branch_code,1,18) AS remark_1, SUBSTR(t.remarks||' '||t.branch_code,19,18) AS remark_2,							
				BI_Code, DECODE(trim(to_bank),p.ip_bank_rdi,p.ip_bank_rdi,t.bank_short_name) bank_cd,	DECODE(trim(to_bank),p.ip_bank_rdi,'',REPLACE(t.bank_brch_name,'CABANG ','') ) bank_branch_name,							
				REPLACE(t.acct_name,',',' ') Receiver_Name,	TO_DATE('$end_date','YYYY-MM-DD') AS trans_date, RPAD('$type',3) AS Jenis,							
				customer_type, customer_residence, t.client_cd 							
				FROM
				( 							
					SELECT t.client_cd, trx_amt, fee, DECODE(SIGN(fee),-1,trx_amt - ABS(fee),trx_amt) AS trf_amt, from_bank, from_acct, 						
	  				to_acct, to_bank, mst_client.client_name AS acct_name, mst_bank_bi.bi_code, remarks, doc_num,mst_client.branch_code, brch, r.bank_short_name,						
	  				'JAKARTA' AS bank_brch_name, customer_type, customer_residence, folder_cd					
					FROM
					(   
      					SELECT client_Cd, to_bank, to_acct, remarks, doc_num, trx_amt, from_bank, from_acct, acct_name, fee, doc_num AS folder_cd					
	  				 	FROM t_fund_movement 	
			         	WHERE doc_date = TO_DATE('$end_date','YYYY-MM-DD')				
						AND trx_type = 'W'
						AND to_client = 'IPO'
						AND approved_sts = 'A'
						AND trx_amt > 0		
					) t, 					
	   				( 
	   					SELECT client_cd, client_name, DECODE(TRIM(mst_client.rem_cd), 'LOT','LO', trim(branch_code)) AS brch,		
	      				branch_code, DECODE(client_type_1, 'I','1','C','2') customer_type, DECODE(client_type_2, 'L','R','N') customer_residence			
	      				FROM mst_client						
		  				WHERE susp_stat = 'N'					
		  				AND client_type_1 <> 'B'
					) mst_client,					
					( 
						SELECT bank_cd, bank_short_name, bi_code
                      FROM MST_IP_BANK
                      WHERE APPROVED_STAT = 'A'
					) r,					
					mst_bank_bi
					WHERE t.client_cd =  mst_client.client_cd						
					AND ( INSTR('$branch',trim( mst_client.brch)) > 0 OR '$branch' = '%')						
					--AND to_bank = mst_bank_bi.ip_bank_cd --[IN] 27/07/2017 ip_bank_cd dari mst_bank_bi tidak dipake lagi 
                    AND R.BI_CODE = mst_bank_bi.bi_code(+)--[IN] 27/07/2017
					AND MST_BANK_BI.APPROVED_STAT(+)='A'
					AND to_bank = r.bank_cd										
				) t,							
				(							
 					SELECT TRF_DATE, DOC_NUM							
  					FROM T_FUND_TRF							
  					WHERE TRF_DATE = TO_DATE('$end_date','YYYY-MM-DD')								
  					AND TRF_FLG = 'N'							
  				) FT,							
				(							
 					SELECT dstr1  AS ksei_bank_rdi, param_cd3 ip_bank_rdi							
   					FROM mst_sys_param							
   					WHERE param_id = 'W_TRF_FUND'							
   					AND param_cd1 = 'BANKRDI'							
 				) p							
				WHERE (from_bank = p.ip_bank_rdi OR from_bank = p.ksei_bank_rdi)							
				AND t.doc_num = FT.doc_num							
				AND ((trx_amt < 500000000 AND '$type' = 'LLG' AND to_bank <> ip_bank_rdi)							
      			OR (trx_amt >= 500000000 AND '$type' = 'RTG' AND to_bank <> ip_bank_rdi)							
	  			OR (to_bank = '$type'))";
	
		return $sql;
	}
	
	public static function getCimbApSql($end_date, $branch)
	{
		$sql = "SELECT b.bank_acct_broker bank_acct_cd, b.bank_name, 'IDR' currency, sum_amt curr_amt, DECODE(LENGTH(TRIM('$branch')),2,'$branch','')||' saldo AP ke RDI' descrip,							
				TO_CHAR(cnt) cnt, '".str_replace('-','',$end_date)."' tanggal, C.PRM_DESC e_mail, f_clean(b.bank_acct_broker) bank_acct_cd_csv, b.bank_name bank_name_csv					
				FROM
				( 
					SELECT bank_Acct_cd bank_acct_broker, m.bank_name							
					FROM mst_bank_acct a, mst_bank_master m					
					WHERE INSTR('$branch',TRIM(brch_cd)) > 0		
					AND a.bank_Cd = m.bank_cd 
				) b,					
				( 
					SELECT SUM(curr_amt) sum_amt, COUNT(1) cnt						
					FROM
					(
						SELECT MAX(client_cd) client_cd, TO_NUMBER(MAX(curr_amt)) curr_amt, MAX(folder_cd) folder_cd
						FROM
						(
							SELECT DECODE (field_name, 'CLIENT_CD', field_value, NULL) client_cd,
									DECODE (field_name, 'CURR_AMT', field_value, NULL) curr_amt,
									DECODE (field_name, 'PAYREC_DATE', field_value, NULL) payrec_date,
									DECODE (field_name, 'ACCT_TYPE', field_value, NULL) acct_type,
									DECODE (field_name, 'PAYREC_TYPE', field_value, NULL) payrec_type,
									DECODE (field_name, 'FOLDER_CD', field_value, NULL) folder_cd,
							a.update_seq, a.record_seq
							FROM T_MANY_DETAIL a JOIN T_MANY_HEADER b
							ON a.update_date = b.update_date
							AND a.update_seq = b.update_seq
							WHERE b.approved_status = 'E'
							AND a.table_name = 'T_PAYRECH'
							AND a.upd_status = 'I'
						)
						GROUP BY update_seq, record_seq
						HAVING TO_DATE(MAX(payrec_date),'YYYY/MM/DD HH24:MI:SS') = TO_DATE('$end_date','YYYY-MM-DD')
						AND MAX(acct_type) = 'RDI'
						AND MAX(payrec_type) IN ('PV','PD')
					) 
					t_payrech,
					mst_client					
					WHERE t_payrech.client_cd = mst_client.client_Cd					
					AND INSTR('$branch',TRIM(MST_CLIENT.branch_code)) > 0
				)A,					
				MST_PARAMETER C							
				WHERE PRM_CD_1 ='E_MAIL'							
				AND PRM_CD_2 ='FINAN' 							
				UNION ALL							
				SELECT f.bank_acct_fmt, f.acct_name , 'IDR' currency, curr_amt curr_amt, 'AP '||trim(t_payrech.client_cd)||' '||folder_Cd, '','',''	, f.bank_acct_num, f_clean_name(f.acct_name)						
				FROM 
				(
					SELECT MAX(client_cd) client_cd, TO_NUMBER(MAX(curr_amt)) curr_amt, MAX(folder_cd) folder_cd
					FROM
					(
						SELECT DECODE (field_name, 'CLIENT_CD', field_value, NULL) client_cd,
								DECODE (field_name, 'CURR_AMT', field_value, NULL) curr_amt,
								DECODE (field_name, 'PAYREC_DATE', field_value, NULL) payrec_date,
								DECODE (field_name, 'ACCT_TYPE', field_value, NULL) acct_type,
								DECODE (field_name, 'PAYREC_TYPE', field_value, NULL) payrec_type,
								DECODE (field_name, 'FOLDER_CD', field_value, NULL) folder_cd,
						a.update_seq, a.record_seq
						FROM T_MANY_DETAIL a JOIN T_MANY_HEADER b
						ON a.update_date = b.update_date
						AND a.update_seq = b.update_seq
						WHERE b.approved_status = 'E'
						AND a.table_name = 'T_PAYRECH'
						AND a.upd_status = 'I'
					)
					GROUP BY update_seq, record_seq
					HAVING TO_DATE(MAX(payrec_date),'YYYY/MM/DD HH24:MI:SS') = TO_DATE('$end_date','YYYY-MM-DD')
					AND MAX(acct_type) = 'RDI'
					AND MAX(payrec_type) IN ('PV','PD')
				)
				t_payrech,
				mst_client, mst_client_flacct f							
				WHERE t_payrech.client_cd = mst_client.client_Cd							
				AND INSTR('$branch',TRIM(MST_CLIENT.branch_code)) > 0						
				AND t_payrech.client_cd = f.client_Cd";
		
		return $sql;
	}
	
	/*public static function getCimbApCsvSql($end_date, $branch)
	{
		$sql = "SELECT f_clean(b.bank_acct_broker) bank_acct, b.bank_name, 'IDR' currency, TO_CHAR(sum_amt) SUM_amt,							
				DECODE(LENGTH(TRIM('$branch')),2,'$branch','')||' saldo AP ke RDI' head_descrip, TO_CHAR(cnt) cnt, '".str_replace('-','',$end_date)."' tanggal							
				FROM
				( 
					SELECT bank_Acct_cd bank_acct_broker,  m.bank_name							
					FROM mst_bank_acct a, mst_bank_master m					
					WHERE INSTR('$branch',TRIM(brch_cd)) > 0					
					AND a.bank_Cd = m.bank_cd 
				) b,					
				( 
					SELECT sum(curr_amt) sum_amt, COUNT(1) cnt						
					FROM 
					(
						SELECT MAX(client_cd) client_cd, TO_NUMBER(MAX(curr_amt)) curr_amt, MAX(folder_cd) folder_cd
						FROM
						(
							SELECT DECODE (field_name, 'CLIENT_CD', field_value, NULL) client_cd,
									DECODE (field_name, 'CURR_AMT', field_value, NULL) curr_amt,
									DECODE (field_name, 'PAYREC_DATE', field_value, NULL) payrec_date,
									DECODE (field_name, 'ACCT_TYPE', field_value, NULL) acct_type,
									DECODE (field_name, 'PAYREC_TYPE', field_value, NULL) payrec_type,
									DECODE (field_name, 'FOLDER_CD', field_value, NULL) folder_cd,
							a.update_seq, a.record_seq
							FROM T_MANY_DETAIL a JOIN T_MANY_HEADER b
							ON a.update_date = b.update_date
							AND a.update_seq = b.update_seq
							WHERE b.approved_status = 'E'
							AND a.table_name = 'T_PAYRECH'
							AND a.upd_status = 'I'
						)
						GROUP BY update_seq, record_seq
						HAVING TO_DATE(MAX(payrec_date),'YYYY/MM/DD HH24:MI:SS') = TO_DATE('$end_date','YYYY-MM-DD')
						AND MAX(acct_type) = 'RDI'
						AND MAX(payrec_type) IN ('PV','PD')
					)
					t_payrech,
					mst_client					
					WHERE t_payrech.client_cd = mst_client.client_Cd					
					AND INSTR('$branch',TRIM(MST_CLIENT.branch_code)) > 0
				)A,					
				MST_PARAMETER C							
				WHERE PRM_CD_1 = 'E_MAIL'							
				AND PRM_CD_2 ='FINAN' 							
				UNION ALL							
				SELECT f.bank_acct_num, f_clean_name(f.acct_name), 'IDR' currency, TO_CHAR(curr_amt) curr_amt, 'AP '||TRIM(t_payrech.client_cd)||' '||folder_Cd as descrip, '',''							
				FROM 
				(
					SELECT MAX(client_cd) client_cd, TO_NUMBER(MAX(curr_amt)) curr_amt, MAX(folder_cd) folder_cd
					FROM
					(
						SELECT DECODE (field_name, 'CLIENT_CD', field_value, NULL) client_cd,
								DECODE (field_name, 'CURR_AMT', field_value, NULL) curr_amt,
								DECODE (field_name, 'PAYREC_DATE', field_value, NULL) payrec_date,
								DECODE (field_name, 'ACCT_TYPE', field_value, NULL) acct_type,
								DECODE (field_name, 'PAYREC_TYPE', field_value, NULL) payrec_type,
								DECODE (field_name, 'FOLDER_CD', field_value, NULL) folder_cd,
						a.update_seq, a.record_seq
						FROM T_MANY_DETAIL a JOIN T_MANY_HEADER b
						ON a.update_date = b.update_date
						AND a.update_seq = b.update_seq
						WHERE b.approved_status = 'E'
						AND a.table_name = 'T_PAYRECH'
						AND a.upd_status = 'I'
					)
					GROUP BY update_seq, record_seq
					HAVING TO_DATE(MAX(payrec_date),'YYYY/MM/DD HH24:MI:SS') = TO_DATE('$end_date','YYYY-MM-DD')
					AND MAX(acct_type) = 'RDI'
					AND MAX(payrec_type) IN ('PV','PD')
				)
				t_payrech, 
				mst_client, mst_client_flacct f							
				WHERE t_payrech.client_cd = mst_client.client_Cd							
				AND INSTR('$branch',TRIM(MST_CLIENT.branch_code)) > 0					
				AND t_payrech.client_cd = f.client_Cd";
		
		return $sql;
	}*/
	
	public static function getCimbArSql($end_date, $branch)
	{
		$sql = "SELECT b.bank_acct_broker bank_acct_cd, f.bank_acct_fmt, b.broker_acct_name AS acct_name, curr_amt,					
				TO_CHAR(TO_DATE('$end_date','YYYY-MM-DD'),'DD/MM/YYYY')||' AR '||TRIM(t_payrech.client_cd)||' '||folder_Cd AS descrip, 'CIMB' AS trx_type, c.e_mail,
				f.bank_acct_num bank_acct_fmt_csv, F_CLEAN(b.bank_acct_broker) bank_acct_cd_csv, REPLACE( b.broker_acct_name,',','') acct_name_csv				
				FROM 
				(
					SELECT MAX(client_cd) client_cd, TO_NUMBER(MAX(curr_amt)) curr_amt, MAX(folder_cd) folder_cd
					FROM
					(
						SELECT DECODE (field_name, 'CLIENT_CD', field_value, NULL) client_cd,
								DECODE (field_name, 'CURR_AMT', field_value, NULL) curr_amt,
								DECODE (field_name, 'PAYREC_DATE', field_value, NULL) payrec_date,
								DECODE (field_name, 'ACCT_TYPE', field_value, NULL) acct_type,
								DECODE (field_name, 'PAYREC_TYPE', field_value, NULL) payrec_type,
								DECODE (field_name, 'FOLDER_CD', field_value, NULL) folder_cd,
						a.update_seq, a.record_seq
						FROM T_MANY_DETAIL a JOIN T_MANY_HEADER b
						ON a.update_date = b.update_date
						AND a.update_seq = b.update_seq
						WHERE b.approved_status = 'E'
						AND a.table_name = 'T_PAYRECH'
						AND a.upd_status = 'I'
					)
					GROUP BY update_seq, record_seq
					HAVING TO_DATE(MAX(payrec_date),'YYYY/MM/DD HH24:MI:SS') = TO_DATE('$end_date','YYYY-MM-DD')
					AND MAX(acct_type) = 'RDI'
					AND MAX(payrec_type) IN ('RV','RD')
				)
				t_payrech, 
				mst_client, mst_client_flacct f,					
				( 
					SELECT bank_Acct_cd bank_acct_broker, c.nama_prsh AS broker_acct_name					
					FROM mst_bank_acct a, mst_bank_master m, mst_company c			
					WHERE INSTR('$branch',TRIM(brch_cd)) > 0			
					AND a.bank_Cd = m.bank_cd 
				) b,			
				( 
					SELECT TRIM(prm_desc) AS e_mail					
					FROM MST_PARAMETER 					
					WHERE PRM_CD_1 ='E_MAIL'					
					AND PRM_CD_2 ='FINAN'
				) c 					
				WHERE t_payrech.client_cd = mst_client.client_Cd					
				AND INSTR('$branch',TRIM(MST_CLIENT.branch_code)) > 0		
				AND t_payrech.client_cd = f.client_Cd";
		
		return $sql;
	}
	
	/*public static function getCimbArCsvSql($end_date, $branch)
	{
		$sql = "SELECT f.bank_acct_num, F_CLEAN(b.bank_acct_broker) bank_acct_broker, REPLACE( b.broker_acct_name,',','') acct_name,					
				TO_CHAR(curr_amt) curr_amt, TO_CHAR(TO_DATE('$end_date','YYYY-MM-DD'),'DD/MM/YYYY')||' AR '||TRIM(t_payrech.client_cd)||' '||folder_Cd AS descrip,					
				'CIMB' AS trx_type					
				FROM 
				(
					SELECT MAX(client_cd) client_cd, TO_NUMBER(MAX(curr_amt)) curr_amt, MAX(folder_cd) folder_cd
					FROM
					(
						SELECT DECODE (field_name, 'CLIENT_CD', field_value, NULL) client_cd,
								DECODE (field_name, 'CURR_AMT', field_value, NULL) curr_amt,
								DECODE (field_name, 'PAYREC_DATE', field_value, NULL) payrec_date,
								DECODE (field_name, 'ACCT_TYPE', field_value, NULL) acct_type,
								DECODE (field_name, 'PAYREC_TYPE', field_value, NULL) payrec_type,
								DECODE (field_name, 'FOLDER_CD', field_value, NULL) folder_cd,
						a.update_seq, a.record_seq
						FROM T_MANY_DETAIL a JOIN T_MANY_HEADER b
						ON a.update_date = b.update_date
						AND a.update_seq = b.update_seq
						WHERE b.approved_status = 'E'
						AND a.table_name = 'T_PAYRECH'
						AND a.upd_status = 'I'
					)
					GROUP BY update_seq, record_seq
					HAVING TO_DATE(MAX(payrec_date),'YYYY/MM/DD HH24:MI:SS') = TO_DATE('$end_date','YYYY-MM-DD')
					AND MAX(acct_type) = 'RDI'
					AND MAX(payrec_type) IN ('RV','RD')
				)
				t_payrech, 
				mst_client, mst_client_flacct f,					
				( 
					SELECT bank_Acct_cd bank_acct_broker, m.bank_name, c.nama_prsh AS broker_acct_name					
					FROM mst_bank_acct a, mst_bank_master m, mst_company c			
					WHERE INSTR('$branch',TRIM(brch_cd)) > 0			
					AND a.bank_Cd = m.bank_cd 
				) b,			
				( 
					SELECT trim(prm_desc) AS e_mail					
					FROM MST_PARAMETER 					
					WHERE PRM_CD_1 ='E_MAIL'					
					AND PRM_CD_2 ='FINAN'
				) c 					
				WHERE t_payrech.client_cd = mst_client.client_Cd					
				AND INSTR('$branch',TRIM(MST_CLIENT.branch_code)) > 0
				AND t_payrech.client_cd = f.client_Cd";
		
		return $sql;
	}*/
	
	public static function insertH2HRef($trfHeader, $trfDetail)
	{
		$trf_id = $trfHeader['trf_id'];
		$file_name = $trfHeader['file_name'];
		$trx_type = $trfHeader['trx_type'];
		$kbb_type1 = $trfHeader['kbb_type1'];
		$kbb_type2 = $trfHeader['kbb_type2'];
		$branch_group = $trfHeader['branch_group'];
		$trf_date = $trfHeader['trf_date'];
		$save_date = $trfHeader['save_date'];
		$total_record = $trfHeader['total_record'];
		
		$sql = "INSERT INTO T_H2H_REF_HEADER(trf_id, file_name, trx_type, kbb_type1, kbb_type2, branch_group, trf_date, save_date, total_record)
				VALUES ('$trf_id','$file_name','$trx_type','$kbb_type1','$kbb_type2','$branch_group',TO_DATE('$trf_date','DD/MM/YYYY'),TO_DATE('$save_date','DD/MM/YYYY HH24:MI:SS'),$total_record)";	
		
		try
		{
			DAO::executeSql($sql);
			
			foreach($trfDetail as $row)
			{
				$x = 0;
				$fieldNames = $fieldValues = '';
				
				foreach($row as $key=>$value)
				{
					if($x > 0)
					{
						$fieldNames .= ',';
						$fieldValues .= ',';
					}
					$fieldNames .= $key; 
					$fieldValues .= "'$value'";
					
					$x++;
				}

				$sql = "INSERT INTO T_H2H_REF_DETAIL(" . $fieldNames . ") VALUES (" .$fieldValues . ")";
				
				DAO::executeSql($sql);
			}
		}
		catch(Exception $ex)
		{
			if(strpos($ex->getMessage(),'ORA-00001') !== false)
			{
				$errMsg = 'Duplicated transfer ID. These records may have already been saved. Please retrieve the records again to make sure.';
			}
			else 
			{
				$errMsg = $ex->getMessage();
			}
			
			return $errMsg;
		}
		
		return 1;
	}
		
	public function executeSpFundTrf($trf_id, $trf_type, $upd_mode, $trf_flg)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_T_FUND_TRF_UPD(
						TO_DATE(:P_DOC_DATE,'YYYY-MM-DD'),
						:P_DOC_NUM,
						:P_TRF_ID,
						:P_TRF_TYPE,
						:P_UPD_MODE,
						:P_TRF_FLG,
						:P_USER_ID,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_DOC_DATE",$this->due_date,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_NUM",$this->doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_TRF_ID",$trf_id,PDO::PARAM_STR);
			$command->bindValue(":P_TRF_TYPE",$trf_type,PDO::PARAM_STR);
			$command->bindParam(":P_UPD_MODE",$upd_mode,PDO::PARAM_STR,100);
			$command->bindParam(":P_TRF_FLG",$trf_flg,PDO::PARAM_STR,100);
			$command->bindValue(":P_USER_ID",Yii::app()->user->id,PDO::PARAM_STR);
						
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
	
	public function rules()
	{
		return array(
			array('due_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('due_date, payrec_type','required','on'=>'header'),
			
			array('method, due_date, payrec_type, bank_cd, branch_code, branch_all_flg, save_excel_flg, save_text_flg, save_csv_flg', 'safe'),
		);		
	}
	
	public function attributeLabels()
	{
		return array_merge
		(
			parent::attributeLabels(),
			array
			(
				'due_date' => 'Transfer Date',
				'payrec_type' => 'Type',
				'branch_code' => 'Branch',
			)
		);
	}
}
