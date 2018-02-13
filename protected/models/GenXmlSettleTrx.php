<?php

Class GenXmlSettleTrx extends CFormModel
{
    public $ip_address;
    public $error_code    = -999;
    public $error_msg     = 'Initial Value';
    
    public $trx_date;
    public $due_date;
    public $trx_type;
    public $transfer_type;
    public $output;
    
    public $begin_date;
    public $end_date;
    public $min1_date;
    public $t1_date;
    public $t2_date;
    
    public $externalReference;
    public $participantCode;
    public $sourceAccount;
    public $targetAccount;
    public $currencyCode;
    public $securityCodeType;
    public $securityCode;
    public $instrumentQuantity;
    public $settlementDate;
    public $description;
    
    public $instructionType;
    public $participantAccount;
    public $counterpartCode;
    public $numberOfSecurities;
    public $tradeDate;
    public $settlementAmount;
    public $purpose;
    public $tradingReference;
    public $settlementReason;
    
    function setInitAttributes()
    {
        $this->due_date = date('d/m/Y');
        $sql = "SELECT TO_CHAR(GET_DOC_DATE(F_GET_SETTDAYS(TO_DATE('$this->due_date','DD/MM/YYYY')),TO_DATE('$this->due_date','DD/MM/YYYY')),'DD/MM/YYYY') trx_date FROM dual";
        
        $result = DAO::queryRowSql($sql);
        $this->trx_date = $result['trx_date'];
        
        $this->trx_type = 'A';
        
        /*$sql = "SELECT dstr1
                FROM MST_SYS_PARAM
                WHERE param_id = 'W_GEN_XML_TRX'
                AND param_cd1 = 'MODE'
                AND param_cd2 = 'JUN16'";
                
        $result = DAO::queryRowSql($sql);
        $this->transfer_type = $result['dstr1'];*/
        
        $this->transfer_type = 'N';
        
        $this->output = 'XML';
    }
    
    function setDate()
    {
        $sql = "SELECT '01'||TO_CHAR(GET_DOC_DATE(1,TO_DATE('$this->due_date','DD/MM/YYYY')),'/MM/YYYY') bgn_date,
                    '$this->due_date' end_date,
                    TO_CHAR(GET_DOC_DATE(1,TO_DATE('$this->due_date','DD/MM/YYYY')),'DD/MM/YYYY') min1_date,
                    TO_CHAR(GET_DUE_DATE(1,TO_DATE('$this->due_date','DD/MM/YYYY')),'DD/MM/YYYY') t1_date,
                    TO_CHAR(GET_DUE_DATE(2,TO_DATE('$this->due_date','DD/MM/YYYY')),'DD/MM/YYYY') t2_date
                FROM dual";
            
        $result = DAO::queryRowSql($sql);
        $this->begin_date = $result['bgn_date'];
        $this->end_date = $result['end_date'];
        $this->min1_date = $result['min1_date'];
        $this->t1_date = $result['t1_date'];
        $this->t2_date = $result['t2_date'];
    }
    
    function getTrxShareSql($trx_type, $rute, $client_type, $ri)
    {
        $sql = "SELECT TO_CHAR( TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd')||'_'||t.extref \"external Reference\",
                  broker_cd AS \"participant Code\",
                  sourceAccount AS \"source Account\",
                  targetAccount AS \"target Account\",
                  '' AS \"currency Code\",
                  'LOCAL' \"security Code Type\",
                  t.STK_CD                      AS \"security Code\",
                  ABS(t.sumqty)                 AS \"instrument Quantity\",
                  TO_CHAR( TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') AS \"settlement Date\",
                  DECODE( '$trx_type','B','BUY ','SELL ') ||' TRX ' ||TO_CHAR( TO_DATE('$this->trx_date','DD/MM/YYYY'),'yyyymmdd') ||' ' || client_name AS \"description\"
                FROM
                  (SELECT DECODE(SUBSTR( '$rute',1,5),'MAIN1',broker_001,'MAIN4',broker_004,sourceAccount ) sourceAccount,
                    DECODE(SUBSTR( '$rute',6,5),'MAIN1',broker_001,'MAIN4',broker_004,targetAccount ) targetAccount,
                    stk_cd,
                    ABS(sumqty) sumqty,
                    client_name,
                    DECODE( '$rute','SUBR4PAIR1',sourceAccount ||'_' ||stk_cd,'PAIR1SUBR4',targetAccount ||'_' ||stk_cd,stk_cd) extref,
                    DECODE( '$rute','SUBR4PAIR1',sourceAccount ||'_' ||stk_cd,'PAIR1SUBR4',targetAccount ||'_' ||stk_cd,RPAD(stk_cd,7)) sortk
                  FROM
                    (SELECT sourceAccount,
                      targetAccount,
                      MAX(client_name) client_name,
                      stk_cd,
                      SUM(qty) sumqty
                    FROM
                      (SELECT DECODE(SUBSTR( '$rute',1,5),'SUBR1',subrek001,'SUBR4',subrek004,'PAIR1',pair001, 'MAIN1',DECODE(SUBSTR( '$rute',6,5),'MAIN4', subrek001,broker_001),'MAIN4',broker_004) AS sourceAccount,
                        DECODE(SUBSTR( '$rute',6,5),'SUBR1',subrek001,'SUBR4',subrek004,'PAIR1',pair001, 'MAIN1',DECODE(SUBSTR( '$rute',1,5),'MAIN4',subrek001,broker_001),'MAIN4', broker_004)       AS targetAccount,
                        client_cd,
                        stk_cd,
                        client_name,
                        qty
                      FROM
                        (SELECT NVL(subrek001, broker_001) AS subrek001,
                          NVL(subrek004,broker_004)        AS subrek004,
                          NVL(pair001, broker_001)         AS pair001,
                          broker_001,
                          broker_004,
                          T_CONTRACTS.client_cd,
                          NVL(c.stk_cd_new,T_CONTRACTS.stk_cd) stk_cd,
                          MST_CLIENT.client_name,
                          ( DECODE(SUBSTR(contr_num,5,1), '$trx_type',1,-1) * qty) qty
                        FROM T_CONTRACTS,
                            (SELECT STK_CD FROM T_STK_T1T2 WHERE APPROVED_STAT = 'A') T_STK_T1T2,
                          v_client_subrek14,
                          v_broker_subrek,
                          (SELECT MST_CLIENT.client_cd,
                            DECODE(custodian_cd,NULL,MST_CIF.cif_name,nama_prsh) AS client_name,
                            custodian_cd,
                            client_type_3
                          FROM MST_CLIENT,
                            MST_CIF,
                            MST_COMPANY
                          WHERE MST_CLIENT.cifs        IS NOT NULL
                          AND MST_CLIENT.cifs           =MST_CIF.cifs
                          AND MST_CLIENT.client_type_1 <> 'B'
                          ) MST_CLIENT,
                          ( SELECT stk_cd_old, stk_cd_new FROM T_CHANGE_STK_CD WHERE eff_dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                          ) c
                        WHERE contr_num BETWEEN TO_CHAR( TO_DATE('$this->trx_date','DD/MM/YYYY'),'mmyy') ||'%'
                        AND TO_CHAR( TO_DATE('$this->trx_date','DD/MM/YYYY'),'mmyy') ||'_'
                        AND CONTR_STAT           <> 'C'
                        AND SUBSTR(contr_num,6,1) = '$ri'
                        AND mrkt_type            <> 'NG'
                        AND mrkt_type            <> 'TS'
                        AND CONTR_DT              = TO_DATE('$this->trx_date','DD/MM/YYYY')
                        AND DUE_DT_FOR_CERT       = TO_DATE('$this->due_date','DD/MM/YYYY')
                        AND T_CONTRACTS.client_cd = MST_CLIENT.client_cd
                        AND T_CONTRACTS.client_cd = v_client_subrek14.client_cd(+)
						AND T_CONTRACTS.stk_cd = T_STK_T1T2.stk_cd(+)
						AND T_STK_T1T2.stk_cd IS NULL
                      --  AND NOT EXISTS (SELECT * FROM T_STK_T1T2 WHERE T_CONTRACTS.stk_cd = T_STK_T1T2.stk_cd AND T_STK_T1T2.APPROVED_STAT = 'A')
                        AND T_CONTRACTS.stk_cd    = c.stk_cd_old(+)
                        AND INSTR( '$rute','4')    > 0
                        AND (('$client_type' = 'R' AND custodian_cd IS NULL) OR ('$client_type' = '%' AND custodian_cd IS NULL) OR ('$client_type' = 'C' AND custodian_cd IS NOT NULL) OR ('$client_type' = 'A'))
                        )
                      )
                    GROUP BY sourceAccount,
                      targetAccount,
                      stk_cd
                    ) ,
                    v_broker_subrek
                  WHERE sumqty       > 0
                  AND sourceaccount <> targetaccount
                  ) T,
                  v_broker_subrek
                ORDER BY t.sortk";
        
        return $sql;
    }
    
    function getTrxOtcSql($trx_type, $rute, $client_type, $ri, $mode)
    {
        $sql = "SELECT TO_CHAR( TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') ||'_' ||t.extref \"external Reference\",
                  instructionType AS \"instruction Type\",
                  broker_cd AS \"participant Code\",
                  participantAccount \"participant Account\",
                  broker_cd AS \"counterpart Code\",
                  'LOCAL' \"security Code Type\",
                  t.STK_CD                      AS \"security Code\",
                  ABS(t.sumqty)                 AS \"number Of Securities\",
                  TO_CHAR( TO_DATE('$this->trx_date','DD/MM/YYYY'),'yyyymmdd') AS \"trade Date\",
                  'IDR'                         AS \"currency Code\",
                  NULL \"settlement Amount\",
                  TO_CHAR( TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') AS \"settlement Date\",
                  'EXCHG'                       AS \"purpose\",
                  tc_id                         AS \"trading Reference\",
                  NULL                          AS \"settlement Reason\",
                  DECODE( '$trx_type','B','BUY ','SELL ') ||' TRX ' ||TO_CHAR( TO_DATE('$this->trx_date','DD/MM/YYYY'),'yyyymmdd') ||' ' || client_cd AS \"description\"
                FROM
                  (SELECT DECODE(SUBSTR( s_route,6,5),'MAIN1',sourceAccount,targetAccount ) ParticipantAccount,
                    stk_cd,
                    x.client_cd,
                    ABS(sumqty) sumqty,
                    client_name,
                    stk_cd ||'_' ||x.client_cd||DECODE(mrkt_type,'TS','_TS',NULL) extref,
                    RPAD(stk_cd,7) ||'_' ||x.client_cd sortk,
                    d.tc_id,
                    DECODE( SUBSTR( s_route,1,5),'MAIN1','RFOP','DFOP') instructiontype,
                    seqno,
                    s_route
                  FROM
                    (SELECT sourceAccount,
                      targetAccount,
                      MAX(client_name) client_name,
                      client_cd,
                      stk_cd,
                      SUM(net_qty) sumqty,
                      seqno,
                      s_route,
                      mrkt_type
                    FROM
                      (SELECT DECODE(SUBSTR( s_route,1,5),'SUBR1',subrek001,'PAIR1',DECODE(trim(mrkt_type),'TS',broker_001,pair001), 'MAIN1',broker_001) AS sourceAccount,
                        DECODE(SUBSTR( s_route,6,5),'SUBR1',subrek001,'PAIR1',DECODE(trim(mrkt_type),'TS',broker_001,pair001) , 'MAIN1',broker_001)      AS targetAccount,
                        mrkt_type,
                        client_cd,
                        stk_cd,
                        client_name,
                        net_qty,
                        seqno,
                        s_route
                      FROM
                        (SELECT NVL(subrek001, broker_001) AS subrek001,
                          NVL(subrek004,broker_004)        AS subrek004,
                          NVL(pair001, broker_001)         AS pair001,
                          broker_001,
                          broker_004,
                          T_CONTRACTS.client_cd,
                          NVL(stk_cd_new, T_CONTRACTS.stk_cd) stk_cd,
                          DECODE(trim(mrkt_type),'TS','TS','RG') mrkt_type,
                          MST_CLIENT.client_name,
                          ( DECODE(SUBSTR(contr_num,5,1), '$trx_type',1,-1) * qty) net_qty,
                          seqno,
                          s_route
                        FROM T_CONTRACTS,
                        	(SELECT STK_CD FROM T_STK_T1T2 WHERE APPROVED_STAT = 'A') T_STK_T1T2,
                          v_client_subrek14,
                          v_broker_subrek,
                          (SELECT MST_CLIENT.client_cd,
                            DECODE(custodian_cd,NULL,MST_CIF.cif_name,nama_prsh) AS client_name,
                            custodian_cd,
                            client_type_3
                          FROM MST_CLIENT,
                            MST_CIF,
                            MST_COMPANY
                          WHERE MST_CLIENT.cifs IS NOT NULL
                          AND MST_CLIENT.cifs = MST_CIF.cifs
                          AND MST_CLIENT.client_type_1 <> 'B'
                          ) MST_CLIENT,
                          (SELECT 1 seqno,
                            DECODE( '$trx_type','B', 'PAIR1MAIN1','SUBR1MAIN1') AS s_route
                          FROM dual
                          WHERE '$ri' = 'R'
                          UNION
                          SELECT 2 seqno,
                            DECODE( '$trx_type','B', 'MAIN1SUBR1', 'MAIN1PAIR1') AS s_route
                          FROM dual
                          WHERE '$ri' = 'R'
                          UNION
                          SELECT 1 seqno,
                            DECODE( '$trx_type','B', 'MAIN1SUBR1', 'SUBR1MAIN1') AS s_route
                          FROM dual
                          WHERE '$ri' = 'I'
                          ) route,
                          ( SELECT stk_cd_old, stk_cd_new FROM T_CHANGE_STK_CD WHERE eff_dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                          ) T_CHANGE_STK_CD
                        WHERE contr_num BETWEEN TO_CHAR( TO_DATE('$this->trx_date','DD/MM/YYYY'),'mmyy') ||'%'
                        AND TO_CHAR( TO_DATE('$this->trx_date','DD/MM/YYYY'),'mmyy') ||'_'
                        AND CONTR_STAT                   <> 'C'
                        AND SUBSTR(contr_num,6,1)         = '$ri'
                        AND mrkt_type                    <> 'NG'
                        AND CONTR_DT                      = TO_DATE('$this->trx_date','DD/MM/YYYY')
                        AND DUE_DT_FOR_CERT               = TO_DATE('$this->due_date','DD/MM/YYYY')
                        AND T_CONTRACTS.client_cd         = MST_CLIENT.client_cd
                        AND T_CONTRACTS.client_cd         = v_client_subrek14.client_cd(+)
						AND T_CONTRACTS.stk_cd = T_STK_T1T2.stk_cd(+)
						AND T_STK_T1T2.stk_cd IS NULL
                      --  AND NOT EXISTS (SELECT * FROM T_STK_T1T2 WHERE T_CONTRACTS.stk_cd = T_STK_T1T2.stk_cd AND T_STK_T1T2.APPROVED_STAT = 'A')
                        AND T_CONTRACTS.stk_Cd            = T_CHANGE_STK_CD.stk_cd_old(+)
                        AND ((v_client_subrek14.pair001 <> v_client_subrek14.subrek001 AND '$mode' = 'SUB2SUB') OR ('$mode' = 'VIAMAIN') OR mrkt_type = 'TS')
                        AND (('$client_type' = '%' AND custodian_cd IS NULL) OR ('$client_type' = 'C' AND custodian_cd IS NOT NULL) OR '$client_type' = 'A')
                        )
                      )
                    WHERE ( sourceaccount <> targetaccount
                    OR mrkt_type           = 'TS')
                    GROUP BY sourceAccount,
                      targetAccount,
                      client_Cd,
                      stk_cd,
                      mrkt_type,
                      seqno,
                      s_route
                    ) x ,
                    (SELECT tc_id,
                      client_cd
                    FROM T_TC_DOC
                    WHERE tc_date = TO_DATE('$this->trx_date','DD/MM/YYYY')
                    AND tc_status = 0
                    ) d,
                    v_broker_subrek
                  WHERE sumqty > 0
                    -- AND sourceaccount <> targetaccount
                  AND x.client_cd = d.client_cd(+)
                  ) T,
                  v_broker_subrek
                ORDER BY instructiontype,
                  t.sortk";
        
        return $sql;
    }
    
    function getTrx004Sql($trx_type, $rute, $client_type, $ri, $mode)
    {
        $sql = "SELECT TO_CHAR(TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd')
                  ||'_'
                  ||t.stk_cd
                  ||DECODE('$client_type','C','','_'
                  ||m.client_cd ) \"external Reference\",
                  m.broker_cd                                                                                                                           AS \"participant Code\",
                  DECODE('$trx_type','J',DECODE( '$rute','PAIR1SUBR4', m.pair001,m.broker_001), DECODE( '$rute','SUBR4PAIR1',m.subrek004,m.broker_004)) AS \"source Account\",
                  DECODE('$trx_type','J',DECODE( '$rute','PAIR1SUBR4',m.subrek004,m.broker_004), DECODE( '$rute','SUBR4PAIR1',m.pair001,m.broker_001))  AS \"target Account\",
                  ''                                                                                                                                    AS \"currency Code\",
                  'LOCAL' \"security Code Type\",
                  t.STK_CD                                                    AS \"security Code\",
                  ABS(t.sumqty)                                               AS \"instrument Quantity\",
                  TO_CHAR(TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') AS \"settlement Date\",
                  DECODE('$trx_type','B','BUY ','SELL ')
                  ||'TRX '
                  ||TO_CHAR(TO_DATE('$this->trx_date','DD/MM/YYYY'),'yyyymmdd')
                  ||' '
                  ||m.client_name AS \"description\"
                FROM
                  (SELECT client_cd,
                    stk_cd,
                    'RG' AS mrkt_type,
                    DECODE('$trx_type','B', out_004,in_004) sumqty
                  FROM
                    (SELECT client_cd,
                      stk_cd,
                      onh_amt,
                      DECODE(SIGN(t3_trf004),-1,ABS(t3_trf004),0) t3_buy,
                      DECODE(SIGN(t3_trf004),-1,0,t3_trf004) t3_sell,
                      sisa_3,
                      t2_sell,
                      t2_trf004,
                      sisa_2,
                      t1_sell,
                      t1_trf004,
                      tot_004,
                      qty004,
                      DECODE( SIGN(tot_004), 1, DECODE(SIGN(tot_004 - qty004),-1,0,tot_004 - qty004 ), 0) IN_004,
                      DECODE( SIGN(tot_004), 1, DECODE(SIGN(tot_004 - qty004),-1,qty004 -tot_004,0 ), ABS(tot_004) + qty004) out_004
                    FROM
                      (SELECT client_cd,
                        stk_cd,
                        SUM(onh_amt) onh_amt,
                        SUM(t3_trf004) t3_trf004,
                        SUM(sisa_3) sisa_3,
                        SUM(t2_sell) t2_sell,
                        SUM(DECODE(SUBSTR( '$rute',1,4),'MAIN',0,t2_trf004)) t2_trf004,
                        SUM(DECODE(SUBSTR( '$rute',1,4),'MAIN',0,sisa_2)) sisa_2,
                        SUM(t1_sell) t1_sell,
                        SUM(DECODE(SUBSTR( '$rute',1,4),'MAIN',0,t1_trf004)) t1_trf004,
                        SUM(DECODE(SUBSTR( '$rute',1,4),'MAIN',-1 *sisa_3,tot_004)) tot_004,
                        SUM(qty004) qty004
                      FROM
                        (SELECT client_cd,
                          stk_cd,
                          onh_amt,
                          t3_trf004,
                          sisa_3,
                          t2_sell,
                          t2_trf004,
                          sisa_2,
                          t1_sell,
                          t1_trf004,
                          t3_trf004+ t2_trf004 + t1_trf004 AS tot_004,
                          0 qty004
                        FROM
                          (SELECT s2.client_cd,
                            s2.stk_cd,
                            onh_amt,
                            t3_trf004,
                            sisa_3,
                            t2_sell,
                            s2.t2_trf004,
                            sisa_2,
                            NVL(t1_sell,0) t1_sell,
                            DECODE(sisa_2,0,0,DECODE( SIGN( sisa_2 - NVL(t1_sell,0)), -1, sisa_2,NVL(t1_sell,0)) ) t1_trf004
                          FROM
                            (SELECT s3.client_cd,
                              s3.stk_cd,
                              onh_amt,
                              t3_trf004,
                              sisa_3,
                              NVL(t2_sell,0) t2_sell,
                              DECODE( SIGN( NVL(sisa_3,0) - NVL(t2_sell,0)), -1, NVL(sisa_3,0),NVL(t2_sell,0)) t2_trf004,
                              NVL(sisa_3,0)               - DECODE( SIGN( NVL(sisa_3,0) - NVL(t2_sell,0)), -1, NVL(sisa_3,0),NVL(t2_sell,0)) AS sisa_2
                            FROM
                              (SELECT NVL(onh.client_cd, t3.client_cd) client_cd,
                                NVL(onh.stk_cd, t3.stk_cd) stk_cd,
                                NVL(onh_amt,0) onh_amt,
                                NVL(t3_net,0) t3_trf004,
                                DECODE( SIGN(NVL(onh_amt,0) - NVL(t3_net,0)), -1, 0, NVL(onh_amt,0) - NVL(t3_net,0)) AS sisa_3
                              FROM
                                (SELECT client_cd,
                                  stk_cd,
                                  SUM(onh) onh_amt
                                FROM
                                  (SELECT client_cd,
                                    T_STK_MOVEMENT.stk_cd,
                                    (NVL(DECODE(SUBSTR(doc_num,5,2),'JV',1,'RS',1,'WS',1,'CS',1,0) * DECODE(trim(NVL(gl_acct_cd,'36')),'36',1, 0) * DECODE(db_cr_flg,'D',-1,1) * (total_share_qty + withdrawn_share_qty),0)) onh
                                  FROM T_STK_MOVEMENT,
                                    T_STK_T1T2
                                  WHERE '$mode'       = '004'
                                  AND '$client_type' <> 'C'
                                  AND doc_dt BETWEEN TO_DATE('$this->begin_date','DD/MM/YYYY') AND TO_DATE('$this->min1_date','DD/MM/YYYY')
                                  AND T_STK_MOVEMENT.stk_Cd = T_STK_T1T2.stk_Cd
                                  AND T_STK_T1T2.APPROVED_STAT = 'A'
                                  AND gl_acct_cd           IN ('36')
                                  AND gl_acct_cd           IS NOT NULL
                                  AND doc_stat              = '2'
                                  --AND client_Cd = vl_client_cd
                                  UNION ALL
                                  SELECT client_cd,
                                    T_STK_MOVEMENT.stk_cd,
                                    (NVL(DECODE(SUBSTR(doc_num,5,2),'JV',1,'RS',1,'WS',1,'CS',1,0) * DECODE(trim(NVL(gl_acct_cd,'36')),'36',1, 0) * DECODE(db_cr_flg,'D',-1,1) * (total_share_qty + withdrawn_share_qty),0)) onh
                                  FROM T_STK_MOVEMENT,
                                    T_STK_T1T2
                                  WHERE '$mode'             = '004'
                                  AND '$client_type'       <> 'C'
                                  AND doc_dt                = TO_DATE('$this->due_date','DD/MM/YYYY')
                                  AND T_STK_MOVEMENT.stk_Cd = T_STK_T1T2.stk_Cd
                                  AND T_STK_T1T2.APPROVED_STAT = 'A'
                                  AND gl_acct_cd           IN ('36')
                                  AND gl_acct_cd           IS NOT NULL
                                  AND doc_stat              = '2'
                                    --AND 1 = 2
                                  AND Jur_type IN ('RECVT','WHDRT')
                                  UNION ALL
                                  SELECT client_Cd,
                                    T_SECU_BAL.stk_Cd,
                                    qty onh
                                  FROM T_SECU_BAL,
                                    T_STK_T1T2
                                  WHERE '$mode'         = '004'
                                  AND '$client_type'   <> 'C'
                                  AND bal_dt            = TO_DATE('$this->begin_date','DD/MM/YYYY')
                                  AND T_SECU_BAL.stk_Cd = T_STK_T1T2.stk_Cd
                                  AND T_STK_T1T2.APPROVED_STAT = 'A'
                                  AND gl_acct_cd       IN ('36')
                                  --AND client_Cd = vl_client_cd
                                  UNION ALL
                                  SELECT DECODE('$client_type','C',broker_client_cd,T_STKHAND.client_cd) client_cd,
                                    T_STKHAND.stk_cd,
                                    0
                                  FROM T_STKHAND,
                                    v_CLIENT_subrek14 v,
                                    v_broker_subrek,
                                    T_STK_T1T2
                                  WHERE T_STKHAND.client_Cd      = v.client_Cd(+)
                                  AND T_STKHAND.stk_Cd           = T_STK_T1T2.stk_Cd
                                  AND T_STK_T1T2.APPROVED_STAT = 'A'
                                  AND (( '$client_type'          = 'C'
                                  AND NVL(subrek001,broker_001)  = broker_001)
                                  OR ( '$client_type'           <> 'C'
                                  AND NVL(subrek001,broker_001) <> broker_001))
                                  AND ((bal_qty                 <> 0
                                  OR on_hand                    <> 0
                                  OR os_buy                     <> 0
                                  OR os_sell                    <> 0 )
                                  OR '$client_type'              = 'C')
                                  --AND client_Cd = vl_client_cd
                                  UNION ALL
                                  SELECT client_cd,
                                    v_porto_jaminan.stk_cd,
                                    -1 * qty
                                  FROM v_porto_jaminan,
                                    T_STK_T1T2
                                  WHERE '$mode'              = '004'
                                  AND v_porto_jaminan.stk_Cd = T_STK_T1T2.stk_Cd
                                  AND T_STK_T1T2.APPROVED_STAT = 'A'
                                  --WHERE client_Cd = vl_client_cd
                                  UNION ALL
                                  SELECT client_Cd,
                                    T_CORP_ACT_FO.stk_cd,
                                    (qty_receive -qty_withdraw ) AS qty_recv_withd
                                  FROM T_CORP_ACT_FO,
                                    T_STK_T1T2
                                  WHERE '$mode'            = '004'
                                  AND to_dt                = TO_DATE('$this->due_date','DD/MM/YYYY')
                                  AND T_CORP_ACT_FO.stk_Cd = T_STK_T1T2.stk_Cd
                                  AND T_STK_T1T2.APPROVED_STAT = 'A'
                                  )
                                GROUP BY client_Cd,
                                  stk_Cd
                                ) onh,
                                (SELECT DECODE('$client_type','C',broker_client_cd,T_CONTRACTS.client_cd) client_cd,
                                  NVL(stk_cd_new,T_CONTRACTS.stk_cd) stk_cd,
                                  SUM( DECODE(SUBSTR(contr_num,5,1),'B',-1,1) * qty) t3_net
                                FROM T_CONTRACTS,
                                  v_CLIENT_subrek14 v,
                                  v_broker_subrek,
                                  T_STK_T1T2,
                                  (SELECT stk_cd_old,
                                    stk_cd_new
                                  FROM T_CHANGE_STK_CD
                                  WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                  )
                                WHERE contr_dt                 = TO_DATE('$this->trx_date','DD/MM/YYYY')
                                AND kpei_due_dt                = TO_DATE('$this->due_date','DD/MM/YYYY')
                                AND T_CONTRACTS.client_Cd      = v.client_Cd(+)
                                AND (( '$client_type'          = 'C'
                                AND NVL(subrek001,broker_001)  = broker_001)
                                OR ( '$client_type'           <> 'C'
                                AND NVL(subrek001,broker_001) <> broker_001))
                                  --AND client_Cd = vl_client_cd
                                AND contr_stat           <> 'C'
                                AND SUBSTR(contr_num,6,1) = '$ri'
                                AND mrkt_type            <> 'NG'
                                AND mrkt_type            <> 'TS'
                                AND T_CONTRACTS.stk_cd    = stk_cd_old(+)
                                AND T_CONTRACTS.stk_Cd    = T_STK_T1T2.stk_Cd
                                AND T_STK_T1T2.APPROVED_STAT = 'A'
                                GROUP BY T_CONTRACTS.client_cd,
                                  broker_client_cd,
                                  T_CONTRACTS.stk_cd,
                                  stk_cd_new
                                ) t3
                              WHERE onh.client_cd = t3.client_cd (+)
                              AND onh.stk_cd      = t3.stk_cd(+)
                              ) s3,
                              (SELECT client_cd,
                                stk_cd,
                                DECODE(SIGN(net_qty),-1, ABS(net_qty),0) AS t2_sell
                              FROM
                                (SELECT client_cd,
                                  NVL(stk_cd_new,T_CONTRACTS.stk_cd) stk_cd,
                                  SUM( DECODE(SUBSTR(contr_num,5,1),'B',1,-1) * qty) net_qty
                                FROM T_CONTRACTS,
                                  T_STK_T1T2,
                                  (SELECT stk_cd_old,
                                    stk_cd_new
                                  FROM T_CHANGE_STK_CD
                                  WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                  )
                                WHERE '$mode'       = '004'
                                AND contr_dt        > TO_DATE('$this->trx_date','DD/MM/YYYY')
                                AND '$client_type' <> 'C'
                                  --AND client_Cd = vl_client_cd
                                AND kpei_due_dt           = TO_DATE('$this->t1_date','DD/MM/YYYY')
                                AND contr_stat           <> 'C'
                                AND SUBSTR(contr_num,6,1) = '$ri'
                                AND mrkt_type            <> 'NG'
                                AND mrkt_type            <> 'TS'
                                AND T_CONTRACTS.stk_cd    = stk_cd_old(+)
                                AND T_CONTRACTS.stk_Cd    = T_STK_T1T2.stk_Cd
                                AND T_STK_T1T2.APPROVED_STAT = 'A'
                                AND client_cd
                                  ||T_CONTRACTS.stk_cd NOT IN
                                  ( SELECT trim(client_cd)||trim(v_porto_jaminan.stk_cd) FROM v_porto_jaminan, T_STK_T1T2 WHERE v_porto_jaminan.stk_cd = T_STK_T1T2.stk_cd AND T_STK_T1T2.APPROVED_STAT = 'A'
                                  )
                                GROUP BY client_cd,
                                  T_CONTRACTS.stk_cd,
                                  stk_cd_new
                                )
                              ) t2
                            WHERE s3.client_cd = t2.client_cd(+)
                            AND s3.stk_cd      = t2.stk_cd(+)
                            ) s2,
                            (SELECT client_cd,
                              stk_cd,
                              DECODE(SIGN(net_qty),-1, ABS(net_qty),0) AS t1_sell
                            FROM
                              (SELECT client_cd,
                                NVL(stk_cd_new,T_CONTRACTS.stk_cd) stk_cd,
                                SUM( DECODE(SUBSTR(contr_num,5,1),'B',1,-1) * qty) net_qty
                              FROM T_CONTRACTS,
                                T_STK_T1T2,
                                (SELECT stk_cd_old,
                                  stk_cd_new
                                FROM T_CHANGE_STK_CD
                                WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                )
                              WHERE '$mode'       = '004'
                              AND contr_dt        > TO_DATE('$this->trx_date','DD/MM/YYYY')
                              AND '$client_type' <> 'C'
                                --AND client_Cd = vl_client_cd
                              AND kpei_due_dt           = TO_DATE('$this->t2_date','DD/MM/YYYY')
                              AND contr_stat           <> 'C'
                              AND SUBSTR(contr_num,6,1) = '$ri'
                              AND mrkt_type            <> 'NG'
                              AND mrkt_type            <> 'TS'
                              AND T_CONTRACTS.stk_cd    = stk_cd_old(+)
                              AND T_CONTRACTS.stk_Cd    = T_STK_T1T2.stk_Cd
                              AND T_STK_T1T2.APPROVED_STAT = 'A'
                              AND client_cd
                                ||T_CONTRACTS.stk_cd NOT IN
                                ( SELECT trim(client_cd)||trim(v_porto_jaminan.stk_cd) FROM v_porto_jaminan, T_STK_T1T2 WHERE v_porto_jaminan.stk_cd = T_STK_T1T2.stk_cd AND T_STK_T1T2.APPROVED_STAT = 'A'
                                )
                              GROUP BY client_cd,
                                T_CONTRACTS.stk_cd,
                                stk_cd_new
                              )
                            WHERE net_qty < 0
                            ) t1
                          WHERE s2.client_cd = t1.client_cd(+)
                          AND s2.stk_cd      = t1.stk_cd (+)
                          )
                        WHERE t3_trf004 <> 0
                        OR t2_trf004     > 0
                        OR t1_trf004     > 0
                        UNION ALL
                        SELECT client_cd,
                          stk_cd,
                          0 onh_amt,
                          0 t3_trf004,
                          0 sisa_3,
                          0 t2_sell,
                          0 t2_trf004,
                          0 sisa_2,
                          0 t1_sell,
                          0 t1_trf004,
                          0 AS tot_004,
                          SUM(qty004) qty004
                        FROM
                          (SELECT client_cd,
                            a.stk_cd,
                            qty004 * DECODE(from_qty,NULL,1,to_qty/from_qty) qty004
                          FROM
                            (SELECT client_cd,
                              NVL(stk_cd_new,T_STK_MOVEMENT.stk_cd) stk_cd,
                              NVL( DECODE(db_cr_flg,'D',1,-1) * (total_share_qty + withdrawn_share_qty),0) qty004
                            FROM T_STK_MOVEMENT,
                              T_STK_T1T2,
                              (SELECT stk_cd_old,
                                stk_cd_new
                              FROM T_CHANGE_STK_CD
                              WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                              )
                            WHERE '$mode'   = '004'
                            AND doc_dt      = TO_DATE('$this->min1_date','DD/MM/YYYY')
                            AND gl_acct_cd IN ('13')
                            AND gl_acct_cd IS NOT NULL
                              --AND client_Cd = vl_client_cd
                            AND doc_stat                                = '2'
                            AND db_cr_flg                               = 'D'
                            AND s_d_type                                = '4'
                            AND T_STK_MOVEMENT.stk_cd                   = stk_cd_old(+)
                            AND T_STK_MOVEMENT.stk_Cd                   = T_STK_T1T2.stk_Cd
                            AND T_STK_T1T2.APPROVED_STAT = 'A'
                            AND TO_DATE('$this->due_date','DD/MM/YYYY') > '15jun12'
                            ) a,
                            (SELECT T_CORP_ACT.stk_cd,
                              x_dt,
                              to_qty,
                              from_Qty
                            FROM T_CORP_ACT,
                            T_STK_T1T2
                            WHERE distrib_dt = TO_DATE('$this->due_date','DD/MM/YYYY')
                            AND T_CORP_ACT.stk_cd = T_STK_T1T2.stk_cd
                            AND T_STK_T1T2.APPROVED_STAT = 'A'
                            AND ca_Type     IN ('REVERSE','SPLIT')
                            ) b
                          WHERE a.stk_cd = b.stk_Cd(+)
                          )
                        GROUP BY client_Cd,
                          stk_Cd
                        )
                      GROUP BY client_Cd,
                        stk_Cd
                      )
                    )
                  WHERE (in_004    <> 0
                  OR out_004       <> 0)
                  AND (('$trx_type' = 'B'
                  AND out_004      <> 0)
                  OR ('$trx_type'   = 'J'
                  AND in_004       <> 0))
                  ) t,
                  (SELECT client_cd,
                    client_name,
                    subrek001,
                    subrek004,
                    pair001,
                    broker_001,
                    broker_004,
                    broker_cd
                  FROM
                    (SELECT m.client_cd,
                      DECODE('$client_type','C',nama_prsh,client_name) client_name,
                      NVL(v.subrek001, broker_001) AS subrek001,
                      NVL(v.subrek004,broker_004)  AS subrek004,
                      NVL(v.pair001, broker_001)   AS pair001,
                      broker_001,
                      broker_004,
                      broker_cd
                    FROM v_client_subrek14 v,
                      MST_CLIENT m,
                      v_broker_subrek b,
                      MST_COMPANY c
                    WHERE m.client_cd              = v.client_cd(+)
                    AND (( '$client_type'          = 'C'
                    AND NVL(subrek001,broker_001)  = broker_001)
                    OR ( '$client_type'           <> 'C'
                    AND NVL(subrek001,broker_001) <> broker_001))
                    )
                  ) m
                WHERE T.client_cd = m.client_cd
                AND ( mrkt_type   = 'RG'
                AND '$ri'         ='R' )
                AND ( '$rute'     = 'PAIR1SUBR4'
                OR '$rute'        = 'SUBR4PAIR1'
                OR '$rute'        = 'MAIN1MAIN4'
                OR '$rute'        = 'MAIN4MAIN1')
                ORDER BY t.stk_CD,
                  t.client_Cd";
        
                  
        // For testing, using INSISTPRO.C_STKHAND and C_STK_MOVEMENT                
        /*$sql = "SELECT TO_CHAR(TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') ||'_' ||t.stk_cd ||DECODE('$client_type','C','','_' ||m.client_cd ) \"external Reference\",
                  m.broker_cd                                                                                                                           AS \"participant Code\",
                  DECODE('$trx_type','J',DECODE( '$rute','PAIR1SUBR4', m.pair001,m.broker_001), DECODE( '$rute','SUBR4PAIR1',m.subrek004,m.broker_004)) AS \"source Account\",
                  DECODE('$trx_type','J',DECODE( '$rute','PAIR1SUBR4',m.subrek004,m.broker_004), DECODE( '$rute','SUBR4PAIR1',m.pair001,m.broker_001))  AS \"target Account\",
                  ''                                                                                                                                    AS \"currency Code\",
                  'LOCAL' \"security Code Type\",
                  t.STK_CD AS \"security Code\",
                  ABS(t.sumqty)                 AS \"instrument Quantity\",
                  TO_CHAR(TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') AS \"settlement Date\",
                  DECODE('$trx_type','B','BUY ','SELL ') ||'TRX ' ||TO_CHAR(TO_DATE('$this->trx_date','DD/MM/YYYY'),'yyyymmdd') ||' ' ||m.client_name AS \"description\"
                FROM
                  (SELECT client_cd,
                    stk_cd,
                    'RG' AS mrkt_type,
                    DECODE('$trx_type','B', out_004,in_004) sumqty
                  FROM
                    (SELECT client_cd,
                      stk_cd,
                      onh_amt,
                      DECODE(SIGN(t3_trf004),-1,ABS(t3_trf004),0) t3_buy,
                      DECODE(SIGN(t3_trf004),-1,0,t3_trf004) t3_sell,
                      sisa_3,
                      t2_sell,
                      t2_trf004,
                      sisa_2,
                      t1_sell,
                      t1_trf004,
                      tot_004,
                      qty004,
                      DECODE( SIGN(tot_004), 1, DECODE(SIGN(tot_004 - qty004),-1,0,tot_004 - qty004 ), 0) IN_004,
                      DECODE( SIGN(tot_004), 1, DECODE(SIGN(tot_004 - qty004),-1,qty004 -tot_004,0 ), ABS(tot_004) + qty004) out_004
                    FROM
                      (SELECT client_cd,
                        stk_cd,
                        SUM(onh_amt) onh_amt,
                        SUM(t3_trf004) t3_trf004,
                        SUM(sisa_3) sisa_3,
                        SUM(t2_sell) t2_sell,
                        SUM(DECODE(SUBSTR( '$rute',1,4),'MAIN',0,t2_trf004)) t2_trf004,
                        SUM(DECODE(SUBSTR( '$rute',1,4),'MAIN',0,sisa_2)) sisa_2,
                        SUM(t1_sell) t1_sell,
                        SUM(DECODE(SUBSTR( '$rute',1,4),'MAIN',0,t1_trf004)) t1_trf004,
                        SUM(DECODE(SUBSTR( '$rute',1,4),'MAIN',-1 *sisa_3,tot_004)) tot_004,
                        SUM(qty004) qty004
                      FROM
                        (SELECT client_cd,
                          stk_cd,
                          onh_amt,
                          t3_trf004,
                          sisa_3,
                          t2_sell,
                          t2_trf004,
                          sisa_2,
                          t1_sell,
                          t1_trf004,
                          t3_trf004+ t2_trf004 + t1_trf004 AS tot_004,
                          0 qty004
                        FROM
                          (SELECT s2.client_cd,
                            s2.stk_cd,
                            onh_amt,
                            t3_trf004,
                            sisa_3,
                            t2_sell,
                            s2.t2_trf004,
                            sisa_2,
                            NVL(t1_sell,0) t1_sell,
                            DECODE(sisa_2,0,0,DECODE( SIGN( sisa_2 - NVL(t1_sell,0)), -1, sisa_2,NVL(t1_sell,0)) ) t1_trf004
                          FROM
                            (SELECT s3.client_cd,
                              s3.stk_cd,
                              onh_amt,
                              t3_trf004,
                              sisa_3,
                              NVL(t2_sell,0) t2_sell,
                              DECODE( SIGN( NVL(sisa_3,0) - NVL(t2_sell,0)), -1, NVL(sisa_3,0),NVL(t2_sell,0)) t2_trf004,
                              NVL(sisa_3,0)               - DECODE( SIGN( NVL(sisa_3,0) - NVL(t2_sell,0)), -1, NVL(sisa_3,0),NVL(t2_sell,0)) AS sisa_2
                            FROM
                              (SELECT NVL(onh.client_cd, t3.client_cd) client_cd,
                                NVL(onh.stk_cd, t3.stk_cd) stk_cd,
                                NVL(onh_amt,0) onh_amt,
                                NVL(t3_net,0) t3_trf004,
                                DECODE( SIGN(NVL(onh_amt,0) - NVL(t3_net,0)), -1, 0, NVL(onh_amt,0) - NVL(t3_net,0)) AS sisa_3
                              FROM
                                (SELECT client_cd,
                                  stk_cd,
                                  SUM(onh) onh_amt
                                FROM
                                  (SELECT client_cd,
                                    stk_cd,
                                    (NVL(DECODE(SUBSTR(doc_num,5,2),'JV',1,'RS',1,'WS',1,'CS',1,0) * DECODE(trim(NVL(gl_acct_cd,'36')),'36',1, 0) * DECODE(db_cr_flg,'D',-1,1) * (total_share_qty + withdrawn_share_qty),0)) onh
                                  FROM INSISTPRO.C_STK_MOVEMENT
                                  WHERE '$mode' = '004'
                                  AND doc_dt BETWEEN TO_DATE('$this->begin_date','DD/MM/YYYY') AND TO_DATE('$this->min1_date','DD/MM/YYYY')
                                  AND '$client_type' <> 'C'
                                  AND gl_acct_cd     IN ('36')
                                  AND gl_acct_cd     IS NOT NULL
                                  AND doc_stat        = '2'
                                  --AND client_Cd = vl_client_cd
                                  UNION ALL
                                  SELECT client_cd,
                                    stk_cd,
                                    (NVL(DECODE(SUBSTR(doc_num,5,2),'JV',1,'RS',1,'WS',1,'CS',1,0) * DECODE(trim(NVL(gl_acct_cd,'36')),'36',1, 0) * DECODE(db_cr_flg,'D',-1,1) * (total_share_qty + withdrawn_share_qty),0)) onh
                                  FROM INSISTPRO.C_STK_MOVEMENT
                                  WHERE '$mode'   = '004'
                                  AND doc_dt      = TO_DATE('$this->due_date','DD/MM/YYYY')
                                  AND gl_acct_cd IN ('36')
                                  AND gl_acct_cd IS NOT NULL
                                  AND doc_stat    = '2'
                                    --AND 1 = 2
                                  AND Jur_type IN ('RECVT','WHDRT')
                                  UNION ALL
                                  SELECT client_Cd,
                                    stk_Cd,
                                    qty onh
                                  FROM T_SECU_BAL
                                  WHERE '$mode'   = '004'
                                  AND bal_dt      = TO_DATE('$this->begin_date','DD/MM/YYYY')
                                  AND gl_acct_cd IN ('36')
                                    --AND client_Cd = vl_client_cd
                                  AND '$client_type' <> 'C'
                                  UNION ALL
                                  SELECT DECODE('$client_type','C',broker_client_cd,INSISTPRO.C_STKHAND.client_cd) client_cd,
                                    stk_cd,
                                    0
                                  FROM INSISTPRO.C_STKHAND,
                                    v_CLIENT_subrek14 v,
                                    v_broker_subrek
                                  WHERE INSISTPRO.C_STKHAND.client_Cd      = v.client_Cd(+)
                                  AND (( '$client_type'          = 'C'
                                  AND NVL(subrek001,broker_001)  = broker_001)
                                  OR ( '$client_type'           <> 'C'
                                  AND NVL(subrek001,broker_001) <> broker_001))
                                  AND ((bal_qty                 <> 0
                                  OR on_hand                    <> 0
                                  OR os_buy                     <> 0
                                  OR os_sell                    <> 0 )
                                  OR '$client_type'              = 'C')
                                  --AND client_Cd = vl_client_cd
                                  UNION ALL
                                  SELECT client_cd, stk_cd, -1 * qty FROM v_porto_jaminan WHERE '$mode' = '004'
                                  --WHERE client_Cd = vl_client_cd
                                  UNION ALL
                                  SELECT client_Cd,
                                    stk_cd,
                                    (qty_receive -qty_withdraw ) AS qty_recv_withd
                                  FROM T_CORP_ACT_FO
                                  WHERE '$mode' = '004'
                                  AND to_dt     = TO_DATE('$this->due_date','DD/MM/YYYY')
                                  )
                                GROUP BY client_Cd,
                                  stk_Cd
                                ) onh,
                                (SELECT DECODE('$client_type','C',broker_client_cd,T_CONTRACTS.client_cd) client_cd,
                                  NVL(stk_cd_new,stk_cd) stk_cd,
                                  SUM( DECODE(SUBSTR(contr_num,5,1),'B',-1,1) * qty) t3_net
                                FROM T_CONTRACTS,
                                  v_CLIENT_subrek14 v,
                                  v_broker_subrek,
                                  (SELECT stk_cd_old,
                                    stk_cd_new
                                  FROM T_CHANGE_STK_CD
                                  WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                  )
                                WHERE contr_dt                 = TO_DATE('$this->trx_date','DD/MM/YYYY')
                                AND kpei_due_dt                = TO_DATE('$this->due_date','DD/MM/YYYY')
                                AND T_CONTRACTS.client_Cd      = v.client_Cd(+)
                                AND (( '$client_type'          = 'C'
                                AND NVL(subrek001,broker_001)  = broker_001)
                                OR ( '$client_type'           <> 'C'
                                AND NVL(subrek001,broker_001) <> broker_001))
                                  --AND client_Cd = vl_client_cd
                                AND contr_stat           <> 'C'
                                AND SUBSTR(contr_num,6,1) = '$ri'
                                AND mrkt_type            <> 'NG'
                                AND mrkt_type            <> 'TS'
                                AND stk_cd                = stk_cd_old(+)
                                GROUP BY T_CONTRACTS.client_cd,
                                  broker_client_cd,
                                  stk_cd,
                                  stk_cd_new
                                ) t3
                              WHERE onh.client_cd = t3.client_cd (+)
                              AND onh.stk_cd      = t3.stk_cd(+)
                              ) s3,
                              (SELECT client_cd,
                                stk_cd,
                                DECODE(SIGN(net_qty),-1, ABS(net_qty),0) AS t2_sell
                              FROM
                                (SELECT client_cd,
                                  NVL(stk_cd_new,stk_cd) stk_cd,
                                  SUM( DECODE(SUBSTR(contr_num,5,1),'B',1,-1) * qty) net_qty
                                FROM T_CONTRACTS,
                                  (SELECT stk_cd_old,
                                    stk_cd_new
                                  FROM T_CHANGE_STK_CD
                                  WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                  )
                                WHERE '$mode'       = '004'
                                AND contr_dt        > TO_DATE('$this->trx_date','DD/MM/YYYY')
                                AND '$client_type' <> 'C'
                                  --AND client_Cd = vl_client_cd
                                AND kpei_due_dt           = TO_DATE('$this->t1_date','DD/MM/YYYY')
                                AND contr_stat           <> 'C'
                                AND SUBSTR(contr_num,6,1) = '$ri'
                                AND mrkt_type            <> 'NG'
                                AND mrkt_type            <> 'TS'
                                AND stk_cd                = stk_cd_old(+)
                                AND client_cd
                                  ||stk_cd NOT IN
                                  ( SELECT trim(client_cd)||trim(stk_cd) FROM v_porto_jaminan
                                  )
                                GROUP BY client_cd,
                                  stk_cd,
                                  stk_cd_new
                                )
                              ) t2
                            WHERE s3.client_cd = t2.client_cd(+)
                            AND s3.stk_cd      = t2.stk_cd(+)
                            ) s2,
                            (SELECT client_cd,
                              stk_cd,
                              DECODE(SIGN(net_qty),-1, ABS(net_qty),0) AS t1_sell
                            FROM
                              (SELECT client_cd,
                                NVL(stk_cd_new,stk_cd) stk_cd,
                                SUM( DECODE(SUBSTR(contr_num,5,1),'B',1,-1) * qty) net_qty
                              FROM T_CONTRACTS,
                                (SELECT stk_cd_old,
                                  stk_cd_new
                                FROM T_CHANGE_STK_CD
                                WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                )
                              WHERE '$mode'       = '004'
                              AND contr_dt        > TO_DATE('$this->trx_date','DD/MM/YYYY')
                              AND '$client_type' <> 'C'
                                --AND client_Cd = vl_client_cd
                              AND kpei_due_dt           = TO_DATE('$this->t2_date','DD/MM/YYYY')
                              AND contr_stat           <> 'C'
                              AND SUBSTR(contr_num,6,1) = '$ri'
                              AND mrkt_type            <> 'NG'
                              AND mrkt_type            <> 'TS'
                              AND stk_cd                = stk_cd_old(+)
                              AND client_cd
                                ||stk_cd NOT IN
                                ( SELECT trim(client_cd)||trim(stk_cd) FROM v_porto_jaminan
                                )
                              GROUP BY client_cd,
                                stk_cd,
                                stk_cd_new
                              )
                            WHERE net_qty < 0
                            ) t1
                          WHERE s2.client_cd = t1.client_cd(+)
                          AND s2.stk_cd      = t1.stk_cd (+)
                          )
                        WHERE t3_trf004 <> 0
                        OR t2_trf004     > 0
                        OR t1_trf004     > 0
                        UNION ALL
                        SELECT client_cd,
                          stk_cd,
                          0 onh_amt,
                          0 t3_trf004,
                          0 sisa_3,
                          0 t2_sell,
                          0 t2_trf004,
                          0 sisa_2,
                          0 t1_sell,
                          0 t1_trf004,
                          0 AS tot_004,
                          SUM(qty004) qty004
                        FROM
                          (SELECT client_cd,
                            a.stk_cd,
                            qty004 * DECODE(from_qty,NULL,1,to_qty/from_qty) qty004
                          FROM
                            (SELECT client_cd,
                              NVL(stk_cd_new,stk_cd) stk_cd,
                              NVL( DECODE(db_cr_flg,'D',1,-1) * (total_share_qty + withdrawn_share_qty),0) qty004
                            FROM INSISTPRO.C_STK_MOVEMENT,
                              (SELECT stk_cd_old,
                                stk_cd_new
                              FROM T_CHANGE_STK_CD
                              WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                              )
                            WHERE '$mode'   = '004'
                            AND doc_dt      = TO_DATE('$this->min1_date','DD/MM/YYYY')
                            AND gl_acct_cd IN ('13')
                            AND gl_acct_cd IS NOT NULL
                              --AND client_Cd = vl_client_cd
                            AND doc_stat  = '2'
                            AND db_cr_flg = 'D'
                            AND s_d_type  = '4'
                            AND stk_cd    = stk_cd_old(+)
                            AND TO_DATE('$this->due_date','DD/MM/YYYY') > '15jun12'
                            ) a,
                            (SELECT stk_cd,
                              x_dt,
                              to_qty,
                              from_Qty
                            FROM T_CORP_ACT
                            WHERE distrib_dt = TO_DATE('$this->due_date','DD/MM/YYYY')
                            AND ca_Type     IN ('REVERSE','SPLIT')
                            ) b
                          WHERE a.stk_cd = b.stk_Cd(+)
                          )
                        GROUP BY client_Cd,
                          stk_Cd
                        )
                      GROUP BY client_Cd,
                        stk_Cd
                      )
                    )
                  WHERE (in_004    <> 0
                  OR out_004       <> 0)
                  AND (('$trx_type' = 'B'
                  AND out_004      <> 0)
                  OR ('$trx_type'   = 'J'
                  AND in_004       <> 0))
                  ) t,
                  (SELECT client_cd,
                    client_name,
                    subrek001,
                    subrek004,
                    pair001,
                    broker_001,
                    broker_004,
                    broker_cd
                  FROM
                    (SELECT m.client_cd,
                      DECODE('$client_type','C',nama_prsh,client_name) client_name,
                      NVL(v.subrek001, broker_001) AS subrek001,
                      NVL(v.subrek004,broker_004)  AS subrek004,
                      NVL(v.pair001, broker_001)   AS pair001,
                      broker_001,
                      broker_004,
                      broker_cd
                    FROM v_client_subrek14 v,
                      MST_CLIENT m,
                      v_broker_subrek b,
                      MST_COMPANY c
                    WHERE m.client_cd              = v.client_cd(+)
                    AND (( '$client_type'          = 'C'
                    AND NVL(subrek001,broker_001)  = broker_001)
                    OR ( '$client_type'           <> 'C'
                    AND NVL(subrek001,broker_001) <> broker_001))
                    )
                  ) m
                WHERE T.client_cd = m.client_cd
                AND ( mrkt_type   = 'RG'
                AND '$ri'         ='R' )
                AND ( '$rute'     = 'PAIR1SUBR4'
                OR '$rute'        = 'SUBR4PAIR1'
                OR '$rute'        = 'MAIN1MAIN4'
                OR '$rute'        = 'MAIN4MAIN1')
                ORDER BY t.stk_CD,
                  t.client_Cd";*/
        
        return $sql;
    }
    
    function getTrx004OtcSql($trx_type, $rute, $client_type, $ri, $mode)
    {
        $sql = "SELECT TO_CHAR( TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd')
                  ||'_'
                  ||stk_cd
                  ||'_'
                  ||client_cd \"external Reference\",
                  instructiontype                                                   AS \"instruction type\",
                  broker_cd                                                         AS \"participant Code\",
                  DECODE(SUBSTR( s_route,6,5),'MAIN1',sourceAccount,targetAccount ) AS \"participant Account\",
                  broker_cd                                                         AS \"counterpart Code\",
                  'LOCAL' \"security Code Type\",
                  STK_CD                                                        AS \"security Code\",
                  ABS(sumqty)                                                   AS \"number of Securities\",
                  TO_CHAR( TO_DATE('$this->trx_date','DD/MM/YYYY') ,'yyyymmdd') AS \"trade date\",
                  'IDR'                                                         AS \"currency Code\",
                  NULL \"settlement Amount\",
                  TO_CHAR( TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') AS \"settlement date\",
                  'EXCHG'                                                      AS \"purpose\",
                  tc_id                                                        AS \"trading Reference\",
                  NULL                                                         AS \"settlement Reason\",
                  DECODE( '$trx_type','B','BUY ','SELL ')
                  ||mrkt_type
                  ||' TRX '
                  ||TO_CHAR( TO_DATE('$this->trx_date','DD/MM/YYYY') ,'yyyymmdd')
                  ||' '
                  || client_cd AS \"description\"
                FROM
                  (SELECT client_Cd,
                    stk_cd,
                    mrkt_type,
                    sumqty,
                    client_name,
                    s_route,
                    tc_id ,
                    broker_cd,
                    DECODE( SUBSTR( s_route,1,5),'MAIN1','RFOP','DFOP') instructiontype,
                    DECODE(SUBSTR( s_route,1,5),'SUBR1',subrek001,'PAIR1',DECODE(trim(mrkt_type),'TS',broker_001,pair001), 'MAIN1',broker_001)  AS sourceAccount,
                    DECODE(SUBSTR( s_route,6,5),'SUBR1',subrek001,'PAIR1',DECODE(trim(mrkt_type),'TS',broker_001,pair001) , 'MAIN1',broker_001) AS targetAccount
                  FROM
                    (SELECT t.client_Cd,
                      t.stk_cd,
                      t.mrkt_type,
                      t.sumqty,
                      client_name,
                      subrek001,
                      subrek004,
                      pair001,
                      m.broker_001,
                      tc_id ,
                      broker_cd
                    FROM
                      (SELECT d.client_cd,
                        stk_cd,
                        'RG' AS mrkt_type,
                        DECODE('$trx_type','B', out_004,in_004) sumqty
                      FROM
                        (SELECT client_cd,
                          stk_cd,
                          onh_amt,
                          DECODE(SIGN(t3_trf004),-1,ABS(t3_trf004),0) t3_buy,
                          DECODE(SIGN(t3_trf004),-1,0,t3_trf004) t3_sell,
                          sisa_3,
                          t2_sell,
                          t2_trf004,
                          sisa_2,
                          t1_sell,
                          t1_trf004,
                          tot_004,
                          qty004,
                          DECODE( SIGN(tot_004), 1, DECODE(SIGN(tot_004 - qty004),-1,0,tot_004 - qty004 ), 0) IN_004,
                          --DECODE( SIGN(tot_004), 1, DECODE(SIGN(tot_004 - qty004),-1,qty004 -tot_004,0 ), 0,0,ABS(tot_004)  + qty004) out_004
                          DECODE( SIGN(tot_004), 1, DECODE(SIGN(tot_004 - qty004),-1,qty004 -tot_004,0 ), ABS(tot_004) + qty004) out_004
                        FROM
                          (SELECT client_cd,
                            stk_cd,
                            SUM(onh_amt) onh_amt,
                            SUM(t3_trf004) t3_trf004,
                            SUM(sisa_3) sisa_3,
                            SUM(t2_sell) t2_sell,
                            SUM(t2_trf004) t2_trf004,
                            SUM(sisa_2) sisa_2,
                            SUM(t1_sell) t1_sell,
                            SUM(t1_trf004) t1_trf004,
                            SUM(tot_004) tot_004,
                            SUM(qty004) qty004
                          FROM
                            (SELECT client_cd,
                              stk_cd,
                              onh_amt,
                              t3_trf004,
                              sisa_3,
                              t2_sell,
                              t2_trf004,
                              sisa_2,
                              t1_sell,
                              t1_trf004,
                              t3_trf004+ t2_trf004 + t1_trf004 AS tot_004,
                              0 qty004
                            FROM
                              (SELECT s2.client_cd,
                                s2.stk_cd,
                                onh_amt,
                                t3_trf004,
                                sisa_3,
                                t2_sell,
                                s2.t2_trf004,
                                sisa_2,
                                NVL(t1_sell,0) t1_sell,
                                DECODE(sisa_2,0,0,DECODE( SIGN( sisa_2 - NVL(t1_sell,0)), -1, sisa_2,NVL(t1_sell,0)) ) t1_trf004
                              FROM
                                (SELECT s3.client_cd,
                                  s3.stk_cd,
                                  onh_amt,
                                  t3_trf004,
                                  sisa_3,
                                  NVL(t2_sell,0) t2_sell,
                                  DECODE( SIGN( NVL(sisa_3,0) - NVL(t2_sell,0)), -1, NVL(sisa_3,0),NVL(t2_sell,0)) t2_trf004,
                                  NVL(sisa_3,0)               - DECODE( SIGN( NVL(sisa_3,0) - NVL(t2_sell,0)), -1, NVL(sisa_3,0),NVL(t2_sell,0)) AS sisa_2
                                FROM
                                  (SELECT NVL(onh.client_cd, t3.client_cd) client_cd,
                                    NVL(onh.stk_cd, t3.stk_cd) stk_cd,
                                    NVL(onh_amt,0) onh_amt,
                                    NVL(t3_net,0) t3_trf004,
                                    DECODE( SIGN(NVL(onh_amt,0) - NVL(t3_net,0)), -1, 0, NVL(onh_amt,0) - NVL(t3_net,0)) AS sisa_3
                                  FROM
                                    (SELECT client_cd,
                                      stk_cd,
                                      SUM(onh) onh_amt
                                    FROM
                                      (SELECT client_cd,
                                        T_STK_MOVEMENT.stk_cd,
                                        (NVL(DECODE(SUBSTR(doc_num,5,2),'JV',1,'RS',1,'WS',1,'CS',1,0) * DECODE(trim(NVL(gl_acct_cd,'36')),'36',1, 0) * DECODE(db_cr_flg,'D',-1,1) * (total_share_qty + withdrawn_share_qty),0)) onh
                                      FROM T_STK_MOVEMENT,
                                        T_STK_T1T2
                                      WHERE '$mode'             = '004'
                                      AND T_STK_MOVEMENT.stk_cd = T_STK_T1T2.stk_cd
                                      AND T_STK_T1T2.APPROVED_STAT = 'A'
                                      AND doc_dt BETWEEN TO_DATE('$this->begin_date','DD/MM/YYYY') AND TO_DATE('$this->min1_date','DD/MM/YYYY')
                                      AND gl_acct_cd IN ('36')
                                      AND gl_acct_cd IS NOT NULL
                                      AND doc_stat    = '2'
                                      --AND client_Cd = :p_client_cd
                                      UNION ALL
                                      SELECT client_cd,
                                        T_STK_MOVEMENT.stk_cd,
                                        (NVL(DECODE(SUBSTR(doc_num,5,2),'JV',1,'RS',1,'WS',1,'CS',1,0) * DECODE(trim(NVL(gl_acct_cd,'36')),'36',1, 0) * DECODE(db_cr_flg,'D',-1,1) * (total_share_qty + withdrawn_share_qty),0)) onh
                                      FROM T_STK_MOVEMENT,
                                        T_STK_T1T2
                                      WHERE '$mode'             = '004'
                                      AND T_STK_MOVEMENT.stk_cd = T_STK_T1T2.stk_cd
                                      AND T_STK_T1T2.APPROVED_STAT = 'A'
                                      AND doc_dt                = TO_DATE('$this->due_date','DD/MM/YYYY')
                                      AND gl_acct_cd           IN ('36')
                                      AND gl_acct_cd           IS NOT NULL
                                      AND doc_stat              = '2'
                                        -- AND 1 = 2
                                      AND Jur_type IN ('RECVT','WHDRT')
                                      UNION ALL
                                      SELECT client_Cd,
                                        T_SECU_BAL.stk_Cd,
                                        qty onh
                                      FROM T_SECU_BAL,
                                        T_STK_T1T2
                                      WHERE '$mode'         = '004'
                                      AND T_SECU_BAL.stk_cd = T_STK_T1T2.stk_cd
                                      AND T_STK_T1T2.APPROVED_STAT = 'A'
                                      AND bal_dt            = TO_DATE('$this->begin_date','DD/MM/YYYY')
                                      AND gl_acct_cd       IN ('36')
                                      --AND client_Cd = :p_client_cd
                                      UNION ALL
                                      SELECT client_cd,
                                        T_STKHAND.stk_cd,
                                        0
                                      FROM T_STKHAND,
                                        T_STK_T1T2
                                      WHERE (bal_qty      <> 0
                                      OR on_hand          <> 0
                                      OR os_buy           <> 0
                                      OR os_sell          <> 0)
                                      AND T_STKHAND.stk_cd = T_STK_T1T2.stk_cd
                                      AND T_STK_T1T2.APPROVED_STAT = 'A'
                                      --AND client_Cd = :p_client_cd
                                      UNION ALL
                                      SELECT client_cd,
                                        v_porto_jaminan.stk_cd,
                                        -1 * qty
                                      FROM v_porto_jaminan,
                                        T_STK_T1T2
                                      WHERE '$mode'              = '004'
                                      AND v_porto_jaminan.stk_cd = T_STK_T1T2.stk_cd
                                      AND T_STK_T1T2.APPROVED_STAT = 'A'
                                      --WHERE client_Cd = :p_client_cd
                                      UNION ALL
                                      SELECT client_Cd,
                                        T_CORP_ACT_FO.stk_cd,
                                        (qty_receive -qty_withdraw ) AS qty_recv_withd
                                      FROM T_CORP_ACT_FO,
                                        T_STK_T1T2
                                      WHERE '$mode'            = '004'
                                      AND T_CORP_ACT_FO.stk_cd = T_STK_T1T2.stk_cd
                                      AND T_STK_T1T2.APPROVED_STAT = 'A'
                                      AND to_dt                = TO_DATE('$this->due_date','DD/MM/YYYY')
                                      AND ca_Type             IN ('REVERSE','SPLIT')
                                      )
                                    GROUP BY client_Cd,
                                      stk_Cd
                                    ) onh,
                                    (SELECT client_cd,
                                      NVL(stk_cd_new,T_CONTRACTS.stk_cd) stk_cd,
                                      SUM( DECODE(SUBSTR(contr_num,5,1),'B',-1,1) * qty) t3_net
                                    FROM T_CONTRACTS,
                                      T_STK_T1T2,
                                      (SELECT stk_cd_old,
                                        stk_cd_new
                                      FROM T_CHANGE_STK_CD
                                      WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                      )
                                    WHERE contr_dt         = TO_DATE('$this->trx_date','DD/MM/YYYY')
                                    AND T_CONTRACTS.stk_cd = T_STK_T1T2.stk_cd
                                    AND T_STK_T1T2.APPROVED_STAT = 'A'
                                    AND kpei_due_dt        = TO_DATE('$this->due_date','DD/MM/YYYY')
                                      --AND client_Cd = :p_client_cd
                                    AND contr_stat           <> 'C'
                                    AND SUBSTR(contr_num,6,1) = '$ri'
                                    AND mrkt_type            <> 'NG'
                                    AND mrkt_type            <> 'TS'
                                    AND T_CONTRACTS.stk_cd    = stk_cd_old(+)
                                    GROUP BY client_cd,
                                      T_CONTRACTS.stk_cd,
                                      stk_cd_new
                                    ) t3
                                  WHERE onh.client_cd = t3.client_cd (+)
                                  AND onh.stk_cd      = t3.stk_cd(+)
                                  ) s3,
                                  (SELECT client_cd,
                                    stk_cd,
                                    DECODE(SIGN(net_qty),-1, ABS(net_qty),0) AS t2_sell
                                  FROM
                                    (SELECT client_cd,
                                      NVL(stk_cd_new,T_CONTRACTS.stk_cd) stk_cd,
                                      SUM( DECODE(SUBSTR(contr_num,5,1),'B',1,-1) * qty) net_qty
                                    FROM T_CONTRACTS,
                                      T_STK_T1T2,
                                      (SELECT stk_cd_old,
                                        stk_cd_new
                                      FROM T_CHANGE_STK_CD
                                      WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                      )
                                    WHERE '$mode'          = '004'
                                    AND T_CONTRACTS.stk_cd = T_STK_T1T2.stk_cd
                                    AND T_STK_T1T2.APPROVED_STAT = 'A'
                                    AND contr_dt           > TO_DATE('$this->trx_date','DD/MM/YYYY')
                                    AND '$ri'              = 'R'
                                      --AND client_Cd = :p_client_cd
                                    AND kpei_due_dt        = TO_DATE('$this->t1_date','DD/MM/YYYY')
                                    AND contr_stat        <> 'C'
                                    AND mrkt_type         <> 'NG'
                                    AND mrkt_type         <> 'TS'
                                    AND T_CONTRACTS.stk_cd = stk_cd_old(+)
                                    AND client_cd
                                      ||T_CONTRACTS.stk_cd NOT IN
                                      ( SELECT trim(client_cd)||trim(stk_cd) FROM v_porto_jaminan
                                      )
                                    GROUP BY client_cd,
                                      T_CONTRACTS.stk_cd,
                                      stk_cd_new
                                    )
                                  ) t2
                                WHERE s3.client_cd = t2.client_cd(+)
                                AND s3.stk_cd      = t2.stk_cd(+)
                                ) s2,
                                (SELECT client_cd,
                                  stk_cd,
                                  DECODE(SIGN(net_qty),-1, ABS(net_qty),0) AS t1_sell
                                FROM
                                  (SELECT client_cd,
                                    NVL(stk_cd_new,T_CONTRACTS.stk_cd) stk_cd,
                                    SUM( DECODE(SUBSTR(contr_num,5,1),'B',1,-1) * qty) net_qty
                                  FROM T_CONTRACTS,
                                    T_STK_T1T2,
                                    (SELECT stk_cd_old,
                                      stk_cd_new
                                    FROM T_CHANGE_STK_CD
                                    WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                    )
                                  WHERE '$mode'          = '004'
                                  AND T_CONTRACTS.stk_cd = T_STK_T1T2.stk_cd
                                  AND T_STK_T1T2.APPROVED_STAT = 'A'
                                  AND contr_dt           > TO_DATE('$this->trx_date','DD/MM/YYYY')
                                  AND '$ri'              = 'R'
                                    --AND client_Cd = :p_client_cd
                                  AND kpei_due_dt        = TO_DATE('$this->t2_date','DD/MM/YYYY')
                                  AND contr_stat        <> 'C'
                                  AND mrkt_type         <> 'NG'
                                  AND mrkt_type         <> 'TS'
                                  AND T_CONTRACTS.stk_cd = stk_cd_old(+)
                                  AND client_cd
                                    ||T_CONTRACTS.stk_cd NOT IN
                                    ( SELECT trim(client_cd)||trim(stk_cd) FROM v_porto_jaminan
                                    )
                                  GROUP BY client_cd,
                                    T_CONTRACTS.stk_cd,
                                    stk_cd_new
                                  )
                                WHERE net_qty < 0
                                ) t1
                              WHERE s2.client_cd = t1.client_cd(+)
                              AND s2.stk_cd      = t1.stk_cd (+)
                              )
                            WHERE t3_trf004 <> 0
                            OR t2_trf004     > 0
                            OR t1_trf004     > 0
                            UNION ALL
                            SELECT client_cd,
                              stk_cd,
                              0 onh_amt,
                              0 t3_trf004,
                              0 sisa_3,
                              0 t2_sell,
                              0 t2_trf004,
                              0 sisa_2,
                              0 t1_sell,
                              0 t1_trf004,
                              0 AS tot_004,
                              SUM(qty004) qty004
                            FROM
                              (SELECT client_cd,
                                a.stk_cd,
                                qty004 * DECODE(from_qty,NULL,1,to_qty/from_qty) qty004
                              FROM
                                (SELECT client_cd,
                                  NVL(stk_cd_new,T_STK_MOVEMENT.stk_cd) stk_cd,
                                  NVL( DECODE(db_cr_flg,'D',1,-1) * (total_share_qty + withdrawn_share_qty),0) qty004
                                FROM T_STK_MOVEMENT,
                                  T_STK_T1T2,
                                  (SELECT stk_cd_old,
                                    stk_cd_new
                                  FROM T_CHANGE_STK_CD
                                  WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                  )
                                WHERE '$mode'             = '004'
                                AND T_STK_MOVEMENT.stk_cd = T_STK_T1T2.stk_cd
                                AND T_STK_T1T2.APPROVED_STAT = 'A'
                                AND doc_dt                = TO_DATE('$this->min1_date','DD/MM/YYYY')
                                AND '$ri'                 = 'R'
                                AND gl_acct_cd           IN ('13')
                                AND gl_acct_cd           IS NOT NULL
                                  --AND client_Cd = :p_client_cd
                                AND doc_stat                                = '2'
                                AND db_cr_flg                               = 'D'
                                AND s_d_type                                = '4'
                                AND T_STK_MOVEMENT.stk_cd                   = stk_cd_old(+)
                                AND TO_DATE('$this->due_date','DD/MM/YYYY') > '15jun12'
                                ) a,
                                (SELECT T_CORP_ACT.stk_cd,
                                  x_dt,
                                  to_qty,
                                  from_Qty
                                FROM T_CORP_ACT,
                                  T_STK_T1T2
                                WHERE distrib_dt      = TO_DATE('$this->due_date','DD/MM/YYYY')
                                AND T_CORP_ACT.stk_cd = T_STK_T1T2.stk_cd
                                AND T_STK_T1T2.APPROVED_STAT = 'A'
                                AND ca_Type          IN ('REVERSE','SPLIT')
                                ) b
                              WHERE a.stk_cd = b.stk_Cd(+)
                              )
                            GROUP BY client_Cd,
                              stk_Cd
                            )
                          GROUP BY client_Cd,
                            stk_Cd
                          )
                        ) d,
                        v_client_subrek14 v
                      WHERE d.client_Cd = v.client_cd
                      AND subrek001    <> pair001
                      AND (in_004      <> 0
                      OR out_004       <> 0)
                      AND (('$trx_type' = 'B'
                      AND out_004      <> 0)
                      OR ('$trx_type'   = 'J'
                      AND in_004       <> 0))
                      UNION ALL
                      SELECT client_cd,
                        stk_cd,
                        'TS' AS mrkt_type,
                        SUM(qty)
                      FROM
                        (SELECT T_CONTRACTS.client_cd,
                          NVL(stk_cd_new,T_CONTRACTS.stk_cd) stk_cd,
                          DECODE(SUBSTR(contr_num,5,1),'$trx_type',qty,0) AS qty
                        FROM T_CONTRACTS,
                          T_STK_T1T2,
                          mst_client,
                          v_client_subrek14,
                          v_broker_subrek,
                          (SELECT stk_cd_old,
                            stk_cd_new
                          FROM T_CHANGE_STK_CD
                          WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                          )
                        WHERE contr_dt            = TO_DATE('$this->trx_date','DD/MM/YYYY')
                        AND T_CONTRACTS.stk_cd    = T_STK_T1T2.stk_cd
                        AND T_STK_T1T2.APPROVED_STAT = 'A'
                        AND '$ri'                 = 'R'
                        AND T_CONTRACTS.client_Cd = mst_client.client_cd
                        AND custodian_cd         IS NULL
                          --AND T_CONTRACTS.client_Cd = vl_client_cd
                        AND kpei_due_dt           = TO_DATE('$this->due_date','DD/MM/YYYY')
                        AND contr_stat           <> 'C'
                        AND SUBSTR(contr_num,6,1) = '$ri'
                        AND ( mrkt_type           = 'TS'
                        OR ( sell_broker_cd       = buy_broker_cd
                        AND trim(sell_broker_cd) IS NOT NULL ))
                        AND T_CONTRACTS.stk_cd    = stk_cd_old(+)
                        AND T_CONTRACTS.client_cd
                          ||T_CONTRACTS.stk_cd NOT IN
                          ( SELECT trim(client_cd)||trim(stk_cd) FROM v_porto_jaminan
                          )
                        AND ('$rute'              = 'SUBR1MAIN1'
                        OR '$rute'                = 'MAIN1SUBR1'
                        OR '$rute'                = 'PAIR1MAIN1')
                        AND T_CONTRACTS.client_cd = v_client_subrek14.client_cd
                        AND subrek001            <> broker_001
                        )
                      GROUP BY client_cd,
                        stk_cd
                      HAVING SUM(qty) > 0
                      ) t,
                      (SELECT client_cd,
                        client_name,
                        subrek001,
                        subrek004,
                        pair001,
                        broker_001,
                        tc_id
                      FROM
                        (SELECT m.client_cd,
                          client_name,
                          NVL(v.subrek001, broker_001) AS subrek001,
                          NVL(v.subrek004,broker_004)  AS subrek004,
                          NVL(v.pair001, broker_001)   AS pair001,
                          broker_001,
                          NVL(d.tc_id,'-') tc_id,
                          broker_cd
                        FROM v_client_subrek14 v,
                          MST_CLIENT m,
                          v_broker_subrek b,
                          (SELECT T_TC_DOC.client_cd,
                            tc_id
                          FROM T_TC_DOC,
                            (SELECT client_Cd,
                              MIN(tc_date) min_tc_date
                            FROM T_TC_DOC
                            WHERE tc_date >= TO_DATE('$this->trx_date','DD/MM/YYYY')
                            AND tc_status  = 0
                            GROUP BY client_cd
                            ) min_tc
                          WHERE T_TC_DOC.tc_date = min_tc_date
                          AND T_TC_DOC.client_cd = min_tc.client_Cd
                          AND T_TC_DOC.tc_status = 0
                          ) d
                        WHERE m.client_cd = v.client_cd
                        AND m.client_Cd   = d.client_cd(+)
                        )
                      ) m,
                      v_broker_subrek b
                    WHERE T.client_cd = m.client_cd
                    ) x,
                    (SELECT 1 seqno,
                      DECODE( '$trx_type','B', 'PAIR1MAIN1','SUBR1MAIN1') AS s_route
                    FROM dual
                    WHERE '$ri' = 'R'
                    UNION
                    SELECT 2 seqno,
                      DECODE( '$trx_type','B', 'MAIN1SUBR1', 'MAIN1PAIR1') AS s_route
                    FROM dual
                    WHERE '$ri' = 'R'
                    UNION
                    SELECT 1 seqno,
                      DECODE( '$trx_type','B', 'MAIN1SUBR1', 'SUBR1MAIN1') AS s_route
                    FROM dual
                    WHERE '$ri' = 'I'
                    ) route
                  )
                ORDER BY instructiontype,
                  stk_cd,
                  client_cd";
        
        
        // For testing, using INSISTPRO.C_STKHAND and C_STK_MOVEMENT          
        /*$sql = "SELECT TO_CHAR( TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') ||'_' ||stk_cd ||'_' ||client_cd \"external Reference\",
                  instructiontype AS \"instruction type\",
                  broker_cd                                                         AS \"participant Code\",
                  DECODE(SUBSTR( s_route,6,5),'MAIN1',sourceAccount,targetAccount ) AS \"participant Account\",
                  broker_cd                                                         AS \"counterpart Code\",
                  'LOCAL' \"security Code Type\",
                  STK_CD                          AS \"security Code\",
                  ABS(sumqty)                     AS \"number Of Securities\",
                  TO_CHAR( TO_DATE('$this->trx_date','DD/MM/YYYY') ,'yyyymmdd') AS \"trade Date\",
                  'IDR'                           AS \"currency Code\",
                  NULL \"settlement Amount\",
                  TO_CHAR( TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') AS \"settlement Date\",
                  'EXCHG'                        AS \"purpose\",
                  tc_id                          AS \"trading Reference\",
                  NULL                           AS \"settlement Reason\",
                  DECODE( '$trx_type','B','BUY ','SELL ') ||mrkt_type ||' TRX ' ||TO_CHAR( TO_DATE('$this->trx_date','DD/MM/YYYY') ,'yyyymmdd') ||' ' || client_cd AS \"description\"
                FROM
                  (SELECT client_Cd,
                    stk_cd,
                    mrkt_type,
                    sumqty,
                    client_name,
                    s_route,
                    tc_id ,
                    broker_cd,
                    DECODE( SUBSTR( s_route,1,5),'MAIN1','RFOP','DFOP') instructiontype,
                    DECODE(SUBSTR( s_route,1,5),'SUBR1',subrek001,'PAIR1',DECODE(trim(mrkt_type),'TS',broker_001,pair001), 'MAIN1',broker_001)  AS sourceAccount,
                    DECODE(SUBSTR( s_route,6,5),'SUBR1',subrek001,'PAIR1',DECODE(trim(mrkt_type),'TS',broker_001,pair001) , 'MAIN1',broker_001) AS targetAccount
                  FROM
                    (SELECT t.client_Cd,
                      t.stk_cd,
                      t.mrkt_type,
                      t.sumqty,
                      client_name,
                      subrek001,
                      subrek004,
                      pair001,
                      m.broker_001,
                      tc_id ,
                      broker_cd
                    FROM
                      (SELECT d.client_cd,
                        stk_cd,
                        'RG' AS mrkt_type,
                        DECODE('$trx_type','B', out_004,in_004) sumqty
                      FROM
                        (SELECT client_cd,
                          stk_cd,
                          onh_amt,
                          DECODE(SIGN(t3_trf004),-1,ABS(t3_trf004),0) t3_buy,
                          DECODE(SIGN(t3_trf004),-1,0,t3_trf004) t3_sell,
                          sisa_3,
                          t2_sell,
                          t2_trf004,
                          sisa_2,
                          t1_sell,
                          t1_trf004,
                          tot_004,
                          qty004,
                          DECODE( SIGN(tot_004), 1, DECODE(SIGN(tot_004 - qty004),-1,0,tot_004 - qty004 ), 0) IN_004,
                          --DECODE( SIGN(tot_004), 1, DECODE(SIGN(tot_004 - qty004),-1,qty004 -tot_004,0 ), 0,0,ABS(tot_004)  + qty004) out_004
                          DECODE( SIGN(tot_004), 1, DECODE(SIGN(tot_004 - qty004),-1,qty004 -tot_004,0 ), ABS(tot_004) + qty004) out_004
                        FROM
                          (SELECT client_cd,
                            stk_cd,
                            SUM(onh_amt) onh_amt,
                            SUM(t3_trf004) t3_trf004,
                            SUM(sisa_3) sisa_3,
                            SUM(t2_sell) t2_sell,
                            SUM(t2_trf004) t2_trf004,
                            SUM(sisa_2) sisa_2,
                            SUM(t1_sell) t1_sell,
                            SUM(t1_trf004) t1_trf004,
                            SUM(tot_004) tot_004,
                            SUM(qty004) qty004
                          FROM
                            (SELECT client_cd,
                              stk_cd,
                              onh_amt,
                              t3_trf004,
                              sisa_3,
                              t2_sell,
                              t2_trf004,
                              sisa_2,
                              t1_sell,
                              t1_trf004,
                              t3_trf004+ t2_trf004 + t1_trf004 AS tot_004,
                              0 qty004
                            FROM
                              (SELECT s2.client_cd,
                                s2.stk_cd,
                                onh_amt,
                                t3_trf004,
                                sisa_3,
                                t2_sell,
                                s2.t2_trf004,
                                sisa_2,
                                NVL(t1_sell,0) t1_sell,
                                DECODE(sisa_2,0,0,DECODE( SIGN( sisa_2 - NVL(t1_sell,0)), -1, sisa_2,NVL(t1_sell,0)) ) t1_trf004
                              FROM
                                (SELECT s3.client_cd,
                                  s3.stk_cd,
                                  onh_amt,
                                  t3_trf004,
                                  sisa_3,
                                  NVL(t2_sell,0) t2_sell,
                                  DECODE( SIGN( NVL(sisa_3,0) - NVL(t2_sell,0)), -1, NVL(sisa_3,0),NVL(t2_sell,0)) t2_trf004,
                                  NVL(sisa_3,0)               - DECODE( SIGN( NVL(sisa_3,0) - NVL(t2_sell,0)), -1, NVL(sisa_3,0),NVL(t2_sell,0)) AS sisa_2
                                FROM
                                  (SELECT NVL(onh.client_cd, t3.client_cd) client_cd,
                                    NVL(onh.stk_cd, t3.stk_cd) stk_cd,
                                    NVL(onh_amt,0) onh_amt,
                                    NVL(t3_net,0) t3_trf004,
                                    DECODE( SIGN(NVL(onh_amt,0) - NVL(t3_net,0)), -1, 0, NVL(onh_amt,0) - NVL(t3_net,0)) AS sisa_3
                                  FROM
                                    (SELECT client_cd,
                                      stk_cd,
                                      SUM(onh) onh_amt
                                    FROM
                                      (SELECT client_cd,
                                        stk_cd,
                                        (NVL(DECODE(SUBSTR(doc_num,5,2),'JV',1,'RS',1,'WS',1,'CS',1,0) * DECODE(trim(NVL(gl_acct_cd,'36')),'36',1, 0) * DECODE(db_cr_flg,'D',-1,1) * (total_share_qty + withdrawn_share_qty),0)) onh
                                      FROM INSISTPRO.C_STK_MOVEMENT
                                      WHERE '$mode' = '004'
                                      AND doc_dt BETWEEN TO_DATE('$this->begin_date','DD/MM/YYYY') AND TO_DATE('$this->min1_date','DD/MM/YYYY')
                                      AND gl_acct_cd IN ('36')
                                      AND gl_acct_cd IS NOT NULL
                                      AND doc_stat    = '2'
                                      --AND client_Cd = :p_client_cd
                                      UNION ALL
                                      SELECT client_cd,
                                        stk_cd,
                                        (NVL(DECODE(SUBSTR(doc_num,5,2),'JV',1,'RS',1,'WS',1,'CS',1,0) * DECODE(trim(NVL(gl_acct_cd,'36')),'36',1, 0) * DECODE(db_cr_flg,'D',-1,1) * (total_share_qty + withdrawn_share_qty),0)) onh
                                      FROM INSISTPRO.C_STK_MOVEMENT
                                      WHERE '$mode'   = '004'
                                      AND doc_dt      = TO_DATE('$this->due_date','DD/MM/YYYY')
                                      AND gl_acct_cd IN ('36')
                                      AND gl_acct_cd IS NOT NULL
                                      AND doc_stat    = '2'
                                        -- AND 1 = 2
                                      AND Jur_type IN ('RECVT','WHDRT')
                                      UNION ALL
                                      SELECT client_Cd,
                                        stk_Cd,
                                        qty onh
                                      FROM T_SECU_BAL
                                      WHERE '$mode'   = '004'
                                      AND bal_dt      = TO_DATE('$this->begin_date','DD/MM/YYYY')
                                      AND gl_acct_cd IN ('36')
                                      --AND client_Cd = :p_client_cd
                                      UNION ALL
                                      SELECT client_cd,
                                        stk_cd,
                                        0
                                      FROM INSISTPRO.C_STKHAND
                                      WHERE (bal_qty <> 0
                                      OR on_hand     <> 0
                                      OR os_buy      <> 0
                                      OR os_sell     <> 0)
                                      --AND client_Cd = :p_client_cd
                                      UNION ALL
                                      SELECT client_cd, stk_cd, -1 * qty FROM v_porto_jaminan WHERE '$mode' = '004'
                                      --WHERE client_Cd = :p_client_cd
                                      UNION ALL
                                      SELECT client_Cd,
                                        stk_cd,
                                        (qty_receive -qty_withdraw ) AS qty_recv_withd
                                      FROM T_CORP_ACT_FO
                                      WHERE '$mode' = '004'
                                      AND to_dt     = TO_DATE('$this->due_date','DD/MM/YYYY')
                                      AND ca_Type  IN ('REVERSE','SPLIT')
                                      )
                                    GROUP BY client_Cd,
                                      stk_Cd
                                    ) onh,
                                    (SELECT client_cd,
                                      NVL(stk_cd_new,stk_cd) stk_cd,
                                      SUM( DECODE(SUBSTR(contr_num,5,1),'B',-1,1) * qty) t3_net
                                    FROM T_CONTRACTS,
                                      (SELECT stk_cd_old,
                                        stk_cd_new
                                      FROM T_CHANGE_STK_CD
                                      WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                      )
                                    WHERE contr_dt  = TO_DATE('$this->trx_date','DD/MM/YYYY')
                                    AND kpei_due_dt = TO_DATE('$this->due_date','DD/MM/YYYY')
                                      --AND client_Cd = :p_client_cd
                                    AND contr_stat           <> 'C'
                                    AND SUBSTR(contr_num,6,1) = '$ri'
                                    AND mrkt_type            <> 'NG'
                                    AND mrkt_type            <> 'TS'
                                    AND stk_cd                = stk_cd_old(+)
                                    GROUP BY client_cd,
                                      stk_cd,
                                      stk_cd_new
                                    ) t3
                                  WHERE onh.client_cd = t3.client_cd (+)
                                  AND onh.stk_cd      = t3.stk_cd(+)
                                  ) s3,
                                  (SELECT client_cd,
                                    stk_cd,
                                    DECODE(SIGN(net_qty),-1, ABS(net_qty),0) AS t2_sell
                                  FROM
                                    (SELECT client_cd,
                                      NVL(stk_cd_new,stk_cd) stk_cd,
                                      SUM( DECODE(SUBSTR(contr_num,5,1),'B',1,-1) * qty) net_qty
                                    FROM T_CONTRACTS,
                                      (SELECT stk_cd_old,
                                        stk_cd_new
                                      FROM T_CHANGE_STK_CD
                                      WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                      )
                                    WHERE '$mode' = '004'
                                    AND contr_dt  > TO_DATE('$this->trx_date','DD/MM/YYYY')
                                    AND '$ri'     = 'R'
                                      --AND client_Cd = :p_client_cd
                                    AND kpei_due_dt = TO_DATE('$this->t1_date','DD/MM/YYYY')
                                    AND contr_stat <> 'C'
                                    AND mrkt_type  <> 'NG'
                                    AND mrkt_type  <> 'TS'
                                    AND stk_cd      = stk_cd_old(+)
                                    AND client_cd
                                      ||stk_cd NOT IN
                                      ( SELECT trim(client_cd)||trim(stk_cd) FROM v_porto_jaminan
                                      )
                                    GROUP BY client_cd,
                                      stk_cd,
                                      stk_cd_new
                                    )
                                  ) t2
                                WHERE s3.client_cd = t2.client_cd(+)
                                AND s3.stk_cd      = t2.stk_cd(+)
                                ) s2,
                                (SELECT client_cd,
                                  stk_cd,
                                  DECODE(SIGN(net_qty),-1, ABS(net_qty),0) AS t1_sell
                                FROM
                                  (SELECT client_cd,
                                    NVL(stk_cd_new,stk_cd) stk_cd,
                                    SUM( DECODE(SUBSTR(contr_num,5,1),'B',1,-1) * qty) net_qty
                                  FROM T_CONTRACTS,
                                    (SELECT stk_cd_old,
                                      stk_cd_new
                                    FROM T_CHANGE_STK_CD
                                    WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                    )
                                  WHERE '$mode' = '004'
                                  AND contr_dt  > TO_DATE('$this->trx_date','DD/MM/YYYY')
                                  AND '$ri'     = 'R'
                                    --AND client_Cd = :p_client_cd
                                  AND kpei_due_dt = TO_DATE('$this->t2_date','DD/MM/YYYY')
                                  AND contr_stat <> 'C'
                                  AND mrkt_type  <> 'NG'
                                  AND mrkt_type  <> 'TS'
                                  AND stk_cd      = stk_cd_old(+)
                                  AND client_cd
                                    ||stk_cd NOT IN
                                    ( SELECT trim(client_cd)||trim(stk_cd) FROM v_porto_jaminan
                                    )
                                  GROUP BY client_cd,
                                    stk_cd,
                                    stk_cd_new
                                  )
                                WHERE net_qty < 0
                                ) t1
                              WHERE s2.client_cd = t1.client_cd(+)
                              AND s2.stk_cd      = t1.stk_cd (+)
                              )
                            WHERE t3_trf004 <> 0
                            OR t2_trf004     > 0
                            OR t1_trf004     > 0
                            UNION ALL
                            SELECT client_cd,
                              stk_cd,
                              0 onh_amt,
                              0 t3_trf004,
                              0 sisa_3,
                              0 t2_sell,
                              0 t2_trf004,
                              0 sisa_2,
                              0 t1_sell,
                              0 t1_trf004,
                              0 AS tot_004,
                              SUM(qty004) qty004
                            FROM
                              (SELECT client_cd,
                                a.stk_cd,
                                qty004 * DECODE(from_qty,NULL,1,to_qty/from_qty) qty004
                              FROM
                                (SELECT client_cd,
                                  NVL(stk_cd_new,stk_cd) stk_cd,
                                  NVL( DECODE(db_cr_flg,'D',1,-1) * (total_share_qty + withdrawn_share_qty),0) qty004
                                FROM INSISTPRO.C_STK_MOVEMENT,
                                  (SELECT stk_cd_old,
                                    stk_cd_new
                                  FROM T_CHANGE_STK_CD
                                  WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                  )
                                WHERE '$mode'   = '004'
                                AND doc_dt      = TO_DATE('$this->min1_date','DD/MM/YYYY')
                                AND '$ri'       = 'R'
                                AND gl_acct_cd IN ('13')
                                AND gl_acct_cd IS NOT NULL
                                  --AND client_Cd = :p_client_cd
                                AND doc_stat  = '2'
                                AND db_cr_flg = 'D'
                                AND s_d_type  = '4'
                                AND stk_cd    = stk_cd_old(+)
                                AND TO_DATE('$this->due_date','DD/MM/YYYY') > '15jun12'
                                ) a,
                                (SELECT stk_cd,
                                  x_dt,
                                  to_qty,
                                  from_Qty
                                FROM T_CORP_ACT
                                WHERE distrib_dt = TO_DATE('$this->due_date','DD/MM/YYYY')
                                AND ca_Type     IN ('REVERSE','SPLIT')
                                ) b
                              WHERE a.stk_cd = b.stk_Cd(+)
                              )
                            GROUP BY client_Cd,
                              stk_Cd
                            )
                          GROUP BY client_Cd,
                            stk_Cd
                          )
                        ) d,
                        v_client_subrek14 v
                      WHERE d.client_Cd = v.client_cd
                      AND subrek001    <> pair001
                      AND (in_004      <> 0
                      OR out_004       <> 0)
                      AND (('$trx_type' = 'B'
                      AND out_004      <> 0)
                      OR ('$trx_type'   = 'J'
                      AND in_004       <> 0))
                      UNION ALL
                      SELECT client_cd,
                        stk_cd,
                        'TS' AS mrkt_type,
                        SUM(qty)
                      FROM
                        (SELECT T_CONTRACTS.client_cd,
                          NVL(stk_cd_new,stk_cd) stk_cd,
                          DECODE(SUBSTR(contr_num,5,1),'$trx_type',qty,0) AS qty
                        FROM T_CONTRACTS,
                          mst_client,
                          v_client_subrek14,
                          v_broker_subrek,
                          (SELECT stk_cd_old,
                            stk_cd_new
                          FROM T_CHANGE_STK_CD
                          WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                          )
                        WHERE contr_dt            = TO_DATE('$this->trx_date','DD/MM/YYYY')
                        AND '$ri'                 = 'R'
                        AND T_CONTRACTS.client_Cd = mst_client.client_cd
                        AND custodian_cd         IS NULL
                          --AND T_CONTRACTS.client_Cd = vl_client_cd
                        AND kpei_due_dt           = TO_DATE('$this->due_date','DD/MM/YYYY')
                        AND contr_stat           <> 'C'
                        AND SUBSTR(contr_num,6,1) = '$ri'
                        AND ( mrkt_type           = 'TS'
                        OR ( sell_broker_cd       = buy_broker_cd
                        AND trim(sell_broker_cd) IS NOT NULL ))
                        AND stk_cd                = stk_cd_old(+)
                        AND T_CONTRACTS.client_cd
                          ||T_CONTRACTS.stk_cd NOT IN
                          ( SELECT trim(client_cd)||trim(stk_cd) FROM v_porto_jaminan
                          )
                        AND ('$rute'              = 'SUBR1MAIN1'
                        OR '$rute'                = 'MAIN1SUBR1'
                        OR '$rute'                = 'PAIR1MAIN1')
                        AND T_CONTRACTS.client_cd = v_client_subrek14.client_cd
                        AND subrek001            <> broker_001
                        )
                      GROUP BY client_cd,
                        stk_cd
                      HAVING SUM(qty) > 0
                      ) t,
                      (SELECT client_cd,
                        client_name,
                        subrek001,
                        subrek004,
                        pair001,
                        broker_001,
                        tc_id
                      FROM
                        (SELECT m.client_cd,
                          client_name,
                          NVL(v.subrek001, broker_001) AS subrek001,
                          NVL(v.subrek004,broker_004)  AS subrek004,
                          NVL(v.pair001, broker_001)   AS pair001,
                          broker_001,
                          NVL(d.tc_id,'-') tc_id,
                          broker_cd
                        FROM v_client_subrek14 v,
                          MST_CLIENT m,
                          v_broker_subrek b,
                          (SELECT T_TC_DOC.client_cd,
                            tc_id
                          FROM T_TC_DOC,
                            (SELECT client_Cd,
                              MIN(tc_date) min_tc_date
                            FROM T_TC_DOC
                            WHERE tc_date >= TO_DATE('$this->trx_date','DD/MM/YYYY')
                            AND tc_status  = 0
                            GROUP BY client_cd
                            ) min_tc
                          WHERE T_TC_DOC.tc_date = min_tc_date
                          AND T_TC_DOC.client_cd = min_tc.client_Cd
                          AND T_TC_DOC.tc_status = 0
                          ) d
                        WHERE m.client_cd = v.client_cd
                        AND m.client_Cd   = d.client_cd(+)
                        )
                      ) m,
                      v_broker_subrek b
                    WHERE T.client_cd = m.client_cd
                    ) x,
                    (SELECT 1 seqno,
                      DECODE( '$trx_type','B', 'PAIR1MAIN1','SUBR1MAIN1') AS s_route
                    FROM dual
                    WHERE '$ri' = 'R'
                    UNION
                    SELECT 2 seqno,
                      DECODE( '$trx_type','B', 'MAIN1SUBR1', 'MAIN1PAIR1') AS s_route
                    FROM dual
                    WHERE '$ri' = 'R'
                    UNION
                    SELECT 1 seqno,
                      DECODE( '$trx_type','B', 'MAIN1SUBR1', 'SUBR1MAIN1') AS s_route
                    FROM dual
                    WHERE '$ri' = 'I'
                    ) route
                  )
                ORDER BY instructiontype,
                  stk_cd,
                  client_cd";*/
        
        return $sql;
    }
    
    function getTrxTunaiSql($trx_type, $rute, $client_type, $ri)
    {
        $sql = "SELECT TO_CHAR( TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') ||'_' ||t.extref \"external Reference\",
                  broker_cd AS \"participant Code\",
                  sourceAccount AS \"source Account\",
                  targetAccount AS \"target Account\",
                  '' AS \"currency Code\",
                  'LOCAL' \"security Code Type\",
                  t.STK_CD                      AS \"security Code\",
                  ABS(t.sumqty)                 AS \"instrument Quantity\",
                  TO_CHAR( TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') AS \"settlement Date\",
                  DECODE( '$trx_type','B','BUY ','SELL ') ||' TRX ' ||TO_CHAR( TO_DATE('$this->trx_date','DD/MM/YYYY'),'yyyymmdd') ||' ' || client_name AS \"description\"
                FROM
                  (SELECT DECODE(SUBSTR( '$rute',1,5),'MAIN1',broker_001,'MAIN4',broker_004,sourceAccount ) sourceAccount,
                    DECODE(SUBSTR( '$rute',6,5),'MAIN1',broker_001,'MAIN4',broker_004,targetAccount ) targetAccount,
                    stk_cd,
                    ABS(sumqty) sumqty,
                    client_name,
                    DECODE( '$rute','SUBR4PAIR1',sourceAccount
                    ||'_'
                    ||stk_cd,'PAIR1SUBR4',targetAccount
                    ||'_'
                    ||stk_cd,stk_cd) extref,
                    DECODE( '$rute','SUBR4PAIR1',sourceAccount
                    ||'_'
                    ||stk_cd,'PAIR1SUBR4',targetAccount
                    ||'_'
                    ||stk_cd,RPAD(stk_cd,7)) sortk
                  FROM
                    (SELECT sourceAccount,
                      targetAccount,
                      MAX(client_name) client_name,
                      stk_cd,
                      SUM(qty) sumqty
                    FROM
                      (SELECT DECODE(SUBSTR( '$rute',1,5),'SUBR1',subrek001,'SUBR4',subrek004,'PAIR1',pair001, 'MAIN1',DECODE(SUBSTR( '$rute',6,5),'MAIN4', subrek001,broker_001),'MAIN4',broker_004) AS sourceAccount,
                        DECODE(SUBSTR( '$rute',6,5),'SUBR1',subrek001,'SUBR4',subrek004,'PAIR1',pair001, 'MAIN1',DECODE(SUBSTR( '$rute',1,5),'MAIN4',subrek001,broker_001),'MAIN4', broker_004)       AS targetAccount,
                        client_cd,
                        stk_cd,
                        client_name,
                        qty
                      FROM
                        (SELECT NVL(subrek001, broker_001) AS subrek001,
                          NVL(subrek004,broker_004)        AS subrek004,
                          NVL(pair001, broker_001)         AS pair001,
                          broker_001,
                          broker_004,
                          TRADE.client_cd,
                          stk_cd,
                          MST_CLIENT.client_name,
                          ( DECODE(BuySell, '$trx_type',1,-1) * qty ) qty
                        FROM
                          (SELECT client_cd,
                            stk_Cd,
                            buysell,
                            SUM(cumqty * lotsize) AS qty
                          FROM
                            (SELECT clearingaccount AS client_cd,
                              symbol                AS stk_cd,
                              cumqty,
                              DECODE(side,1,'B','J') BuySell,
                              lotsize
                            FROM V_FOTD_TRADE
                            WHERE trade_date = TO_DATE('$this->trx_date','DD/MM/YYYY')
                            AND symbolsfx    = '0TN'
-- AS:15nov2017             AND execbroker  <> contrabroker
                            --                                UNION ALL
--                            SELECT clearingaccount AS client_cd,
--                              symbol                AS stk_cd,
--                              cumqty,
--                              DECODE(side,1,'B','J') BuySell,
--                              lotsize
--                            FROM V_FOTD_TRADE f,
--                            ( select client_Cd, decode(sale_sts,'P',1,2) BJ, csd_value as sett_days
--                              from mst_settlement_client
--                              where eff_dt = TO_DATE('$this->trx_date','DD/MM/YYYY') 
--                              and market_type = 'NG'
--                              and csd_value = 0) s
--                            WHERE trade_date = TO_DATE('$this->trx_date','DD/MM/YYYY')
--                            AND symbolsfx    = '0NG'
--                            AND execbroker  <> contrabroker
--                            and clearingaccount = client_cd
--                            and side = BJ
                            )
                          GROUP BY client_cd,
                            stk_Cd,
                            buysell
                          ) TRADE,
                          v_client_subrek14,
                          v_broker_subrek,
                          (SELECT MST_CLIENT.client_cd,
                            DECODE(custodian_cd,NULL,MST_CIF.cif_name,nama_prsh) AS client_name,
                            custodian_cd,
                            client_type_3
                          FROM MST_CLIENT,
                            MST_CIF,
                            MST_COMPANY
                          WHERE MST_CLIENT.cifs        IS NOT NULL
                          AND MST_CLIENT.cifs           =MST_CIF.cifs
                          AND MST_CLIENT.client_type_1 <> 'B'
                          ) MST_CLIENT
                        WHERE TRADE.client_cd  = MST_CLIENT.client_cd
                        AND TRADE.client_cd    = v_client_subrek14.client_cd(+)
                        AND INSTR( '$rute','4') > 0
                        AND ( ( '$client_type'  = 'R'
                        AND custodian_cd      IS NULL)
                        OR ( '$client_type'     = '%'
                        AND custodian_cd      IS NULL)
                        OR ( '$client_type'     = 'C'
                        AND custodian_cd      IS NOT NULL)
                        OR ( '$client_type'     = 'A'))
                        )
                      )
                    GROUP BY sourceAccount,
                      targetAccount,
                      stk_cd
                    ) ,
                    v_broker_subrek
                  WHERE sumqty       > 0
                  AND sourceaccount <> targetaccount
                  ) T,
                  v_broker_subrek
                ORDER BY t.sortk";
        
        return $sql;
    }
    
    function getTrxOtcTunaiSql($trx_type, $rute, $client_type, $ri, $mode)
    {
        $sql = "SELECT TO_CHAR( TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') ||'_' ||t.extref \"external Reference\",
                  instructiontype AS \"instruction Type\",
                  broker_cd AS \"participant Code\",
                  participantAccount AS \"participant Account\",
                  broker_cd AS \"counterpart Code\",
                  'LOCAL' \"security Code Type\",
                  t.STK_CD                      AS \"security Code\",
                  ABS(t.sumqty)                 AS \"number Of Securities\",
                  TO_CHAR( TO_DATE('$this->trx_date','DD/MM/YYYY'),'yyyymmdd') AS \"trade Date\",
                  'IDR'                         AS \"currency Code\",
                  NULL \"settlement Amount\",
                  TO_CHAR( TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') AS \"settlement Date\",
                  'EXCHG'                       AS \"purpose\",
                  tc_id                         AS \"trading Reference\",
                  NULL                          AS \"settlement Reason\",
                  DECODE( '$trx_type','B','BUY ','SELL ') ||' TRX ' ||TO_CHAR( TO_DATE('$this->trx_date','DD/MM/YYYY'),'yyyymmdd') ||' ' || client_cd AS \"description\"
                FROM
                  (SELECT DECODE(SUBSTR( s_route,6,5),'MAIN1',sourceAccount,targetAccount ) ParticipantAccount,
                    stk_cd,
                    x.client_cd,
                    ABS(sumqty) sumqty,
                    client_name,
                    stk_cd
                    ||'_'
                    ||x.client_cd extref,
                    RPAD(stk_cd,7)
                    ||'_'
                    ||x.client_cd sortk,
                    d.tc_id,
                    DECODE( SUBSTR( s_route,1,5),'MAIN1','RFOP','DFOP') instructiontype,
                    seqno,
                    s_route
                  FROM
                    (SELECT sourceAccount,
                      targetAccount,
                      MAX(client_name) client_name,
                      client_cd,
                      stk_cd,
                      SUM(net_qty) sumqty,
                      seqno,
                      s_route
                    FROM
                      (SELECT DECODE(SUBSTR( s_route,1,5),'SUBR1',subrek001,'PAIR1',DECODE(trim(mrkt_type),'TS',broker_001,pair001), 'MAIN1',broker_001) AS sourceAccount,
                        DECODE(SUBSTR( s_route,6,5),'SUBR1',subrek001,'PAIR1',DECODE(trim(mrkt_type),'TS',broker_001,pair001) , 'MAIN1',broker_001)      AS targetAccount,
                        mrkt_type,
                        client_cd,
                        stk_cd,
                        client_name,
                        net_qty,
                        seqno,
                        s_route
                      FROM
                        (SELECT NVL(subrek001, broker_001) AS subrek001,
                          NVL(subrek004,broker_004)        AS subrek004,
                          NVL(pair001, broker_001)         AS pair001,
                          broker_001,
                          broker_004,
                          TRADE.client_cd,
                          stk_cd,
                          DECODE(trim(mrkt_type),'TS','TS','RG') mrkt_type,
                          MST_CLIENT.client_name,
                          ( DECODE(buysell, '$trx_type',1,-1) * qty) net_qty,
                          seqno,
                          s_route
                        FROM
                          (SELECT client_cd,
                            stk_Cd,
                            buysell,
                            mrkt_type,
                            SUM(cumqty * lotsize) AS qty
                          FROM
                            (SELECT clearingaccount AS client_cd,
                              symbol                AS stk_cd,
                              cumqty,
                              DECODE(side,1,'B','J') BuySell,
                              lotsize,
                              DECODE(execbroker, contrabroker,'TS','RG') mrkt_type
                            FROM V_FOTD_TRADE
                            WHERE trade_date = TO_DATE('$this->trx_date','DD/MM/YYYY')
                            AND symbolsfx    = '0TN'
                            AND '$ri'         = 'R'
                            )
                          GROUP BY client_cd,
                            stk_Cd,
                            buysell,
                            mrkt_type
                          ) TRADE,
                          v_client_subrek14,
                          v_broker_subrek,
                          (SELECT MST_CLIENT.client_cd,
                            DECODE(custodian_cd,NULL,MST_CIF.cif_name,nama_prsh) AS client_name,
                            custodian_cd,
                            client_type_3
                          FROM MST_CLIENT,
                            MST_CIF,
                            MST_COMPANY
                          WHERE MST_CLIENT.cifs        IS NOT NULL
                          AND MST_CLIENT.cifs           =MST_CIF.cifs
                          AND MST_CLIENT.client_type_1 <> 'B'
                          ) MST_CLIENT,
                          (SELECT 1 seqno,
                            DECODE( '$trx_type','B', 'PAIR1MAIN1','SUBR1MAIN1') AS s_route
                          FROM dual
                          WHERE '$ri' = 'R'
                          UNION
                          SELECT 2 seqno,
                            DECODE( '$trx_type','B', 'MAIN1SUBR1', 'MAIN1PAIR1') AS s_route
                          FROM dual
                          WHERE '$ri' = 'R'
                          UNION
                          SELECT 1 seqno,
                            DECODE( '$trx_type','B', 'MAIN1SUBR1', 'SUBR1MAIN1') AS s_route
                          FROM dual
                          WHERE '$ri' = 'I'
                          ) route
                        WHERE TRADE.client_cd = MST_CLIENT.client_cd
                        AND TRADE.client_cd = v_client_subrek14.client_cd(+)
                        AND ((v_client_subrek14.pair001 <> v_client_subrek14.subrek001 AND '$mode' = 'SUB2SUB') OR ('$mode' = 'VIAMAIN') OR mrkt_type = 'TS')
                        AND (('$client_type' = '%' AND custodian_cd IS NULL) OR ('$client_type' = 'C' AND custodian_cd IS NOT NULL) OR '$client_type' = 'A')
                        )
                      )
                    WHERE ( sourceaccount <> targetaccount
                    OR mrkt_type           = 'TS')
                    GROUP BY sourceAccount,
                      targetAccount,
                      client_Cd,
                      stk_cd,
                      mrkt_type,
                      seqno,
                      s_route
                    ) x ,
                    (SELECT tc_id,
                      client_cd
                    FROM T_TC_DOC
                    WHERE tc_date = TO_DATE('$this->trx_date','DD/MM/YYYY')
                    AND tc_status = 0
                    ) d,
                    v_broker_subrek
                  WHERE sumqty > 0
                    -- AND sourceaccount <> targetaccount
                  AND x.client_cd = d.client_cd(+)
                  ) T,
                  v_broker_subrek
                ORDER BY instructiontype,
                  t.sortk";
        
        return $sql;
    }
    
    function getTrxSharePFSql($trx_type, $rute, $client_type, $ri, $otcFlg)
    {
        $selectSql = $otcFlg ? 
                    "m.tc_id AS \"trading Reference\", TO_CHAR(TO_DATE('$this->trx_date','DD/MM/YYYY'),'yyyymmdd') AS \"trade Date\",":
                    "";
        
        $sql = "SELECT TO_CHAR(TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') ||'_' ||t.stk_cd ||'_' ||m.client_cd \"external Reference\",
                  b.broker_cd                                                                                                                                                                  AS \"participant Code\",
                  DECODE('$trx_type','J',DECODE('$rute','SUBR1MAIN1',m.subrek001,DECODE(m.pair001,m.subrek001,m.pair001,b.broker_001)), DECODE('$rute','MAIN1SUBR1',b.broker_001,m.subrek004)) AS \"source Account\",
                  DECODE('$trx_type','J',DECODE('$rute','SUBR1MAIN1',b.broker_001,m.subrek004), DECODE('$rute','MAIN1SUBR1',m.subrek001,DECODE(m.pair001,m.subrek001,m.pair001,b.broker_001))) AS \"target Account\",
                  ''                                                                                                                                                                           AS \"currency Code\",
                  'LOCAL' \"security Code Type\",
                  t.STK_CD                      AS \"security Code\",
                  ABS(t.sumqty)                 AS \"instrument Quantity\",
                  TO_CHAR(TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') AS \"settlement Date\",
                  $selectSql
                  DECODE('$trx_type','B','BUY ','SELL ') ||'$client_type' || ' TRX ' ||TO_CHAR(TO_DATE('$this->trx_date','DD/MM/YYYY'),'yyyymmdd') ||' ' ||t.client_cd AS \"description\"
                FROM
                  (SELECT client_cd,
                    stk_cd,
                    'RG' AS mrkt_type,
                    DECODE('$trx_type','B', out_004,in_004) sumqty
                  FROM
                    (SELECT client_cd,
                      stk_cd,
                      onh_amt,
                      DECODE(SIGN(t3_trf004),-1,ABS(t3_trf004),0) t3_buy,
                      DECODE(SIGN(t3_trf004),-1,0,t3_trf004) t3_sell,
                      sisa_3,
                      t2_sell,
                      t2_trf004,
                      sisa_2,
                      t1_sell,
                      t1_trf004,
                      tot_004,
                      qty004,
                      DECODE( SIGN(tot_004), 1, DECODE(SIGN(tot_004 - qty004),-1,0,tot_004 - qty004 ), 0) IN_004,
                      DECODE( SIGN(tot_004), 1, DECODE(SIGN(tot_004 - qty004),-1,qty004 -tot_004,0 ), ABS(tot_004) + qty004) out_004
                    FROM
                      (SELECT client_cd,
                        stk_cd,
                        SUM(onh_amt) onh_amt,
                        SUM(t3_trf004) t3_trf004,
                        SUM(sisa_3) sisa_3,
                        SUM(t2_sell) t2_sell,
                        SUM(t2_trf004) t2_trf004,
                        SUM(sisa_2) sisa_2,
                        SUM(t1_sell) t1_sell,
                        SUM(t1_trf004) t1_trf004,
                        SUM(tot_004) tot_004,
                        SUM(qty004) qty004
                      FROM
                        (SELECT client_cd,
                          stk_cd,
                          onh_amt,
                          t3_trf004,
                          sisa_3,
                          t2_sell,
                          t2_trf004,
                          sisa_2,
                          t1_sell,
                          t1_trf004,
                          t3_trf004+ t2_trf004 + t1_trf004 AS tot_004,
                          0 qty004
                        FROM
                          (SELECT s2.client_cd,
                            s2.stk_cd,
                            onh_amt,
                            t3_trf004,
                            sisa_3,
                            t2_sell,
                            s2.t2_trf004,
                            sisa_2,
                            NVL(t1_sell,0) t1_sell,
                            DECODE(sisa_2,0,0,DECODE( SIGN( sisa_2 - NVL(t1_sell,0)), -1, sisa_2,NVL(t1_sell,0)) ) t1_trf004
                          FROM
                            (SELECT s3.client_cd,
                              s3.stk_cd,
                              onh_amt,
                              t3_trf004,
                              sisa_3,
                              NVL(t2_sell,0) t2_sell,
                              DECODE( SIGN( NVL(sisa_3,0) - NVL(t2_sell,0)), -1, NVL(sisa_3,0),NVL(t2_sell,0)) t2_trf004,
                              NVL(sisa_3,0)               - DECODE( SIGN( NVL(sisa_3,0) - NVL(t2_sell,0)), -1, NVL(sisa_3,0),NVL(t2_sell,0)) AS sisa_2
                            FROM
                              (SELECT NVL(onh.client_cd, t3.client_cd) client_cd,
                                NVL(onh.stk_cd, t3.stk_cd) stk_cd,
                                NVL(onh_amt,0) onh_amt,
                                NVL(t3_net,0) t3_trf004,
                                NVL(onh_amt,0) - NVL(t3_net,0) AS sisa_3
                              FROM
                                (SELECT client_cd,
                                  stk_cd,
                                  SUM(onh) onh_amt
                                FROM
                                  (
                                  SELECT client_cd,
                                    NVL(stk_Cd_new,stk_cd) stk_cd,
                                    onh
                                  FROM
                                    (
                                  SELECT client_cd,
                                    stk_cd,
                                    (NVL(DECODE(SUBSTR(doc_num,5,2),'JV',1,'RS',1,'WS',1,'CS',1,0) * DECODE(trim(NVL(gl_acct_cd,'36')),'36',1, 0) * DECODE(db_cr_flg,'D',-1,1) * (total_share_qty + withdrawn_share_qty),0)) onh
                                  FROM T_STK_MOVEMENT
                                  WHERE doc_dt BETWEEN TO_DATE('$this->begin_date','DD/MM/YYYY') AND TO_DATE('$this->end_date','DD/MM/YYYY')
                                  AND gl_acct_cd IN ('36')
                                  AND gl_acct_cd IS NOT NULL
                                  AND doc_stat    = '2'
                                  AND client_Cd  <> 'X'
                                  UNION ALL
                                  /*
                                  SELECT client_cd,
                                    stk_cd,
                                    (NVL(DECODE(SUBSTR(doc_num,5,2),'JV',1,'RS',1,'WS',1,'CS',1,0) * DECODE(trim(NVL(gl_acct_cd,'36')),'36',1, 0) * DECODE(db_cr_flg,'D',-1,1) * (total_share_qty + withdrawn_share_qty),0)) onh
                                  FROM T_STK_MOVEMENT
                                  WHERE doc_dt    = TO_DATE('$this->due_date','DD/MM/YYYY')
                                  AND gl_acct_cd IN ('36')
                                  AND gl_acct_cd IS NOT NULL
                                  AND doc_stat    = '2'
                                  AND 1           = 2
                                  AND Jur_type   IN ('RECVT','WHDRT')
                                  UNION ALL
                                  */
                                  SELECT client_Cd,
                                    stk_Cd,
                                    qty onh
                                  FROM T_SECU_BAL
                                  WHERE bal_dt    = TO_DATE('$this->begin_date','DD/MM/YYYY')
                                  AND gl_acct_cd IN ('36')
                                  AND client_Cd  <> 'X'
                                  UNION ALL
                                  SELECT client_cd,
                                    stk_cd,
                                    0
                                  FROM T_STKHAND
                                  WHERE bal_qty <> 0
                                  OR on_hand    <> 0
                                  AND client_Cd <> 'X'
                                  UNION ALL
                                  SELECT client_cd, stk_cd, -1 * qty FROM v_porto_jaminan WHERE client_Cd <> 'X'
                                  UNION ALL
                                  SELECT client_Cd,
                                    stk_cd,
                                    (qty_receive -qty_withdraw ) AS qty_recv_withd
                                  FROM T_CORP_ACT_FO
                                  WHERE to_dt  = TO_DATE('$this->due_date','DD/MM/YYYY')
                                  AND ca_Type IN ('REVERSE','SPLIT')
                                  ) s,
                                  ( 
                                    SELECT stk_cd_new,stk_cd_old FROM T_CHANGE_STK_CD WHERE eff_dt<= TO_DATE('$this->due_date','DD/MM/YYYY')
                                  ) c
                                  WHERE s.stk_cd=c.stk_cd_old(+)
                                  )
                                GROUP BY client_Cd,
                                  stk_Cd
                                ) onh,
                                (SELECT client_cd,
                                  NVL(stk_cd_new,stk_cd) stk_cd,
                                  SUM( DECODE(SUBSTR(contr_num,5,1),'B',-1,1) * qty) t3_net
                                FROM T_CONTRACTS,
                                  (SELECT stk_cd_old,
                                    stk_cd_new
                                  FROM T_CHANGE_STK_CD
                                  WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                  )
                                WHERE contr_dt            = TO_DATE('$this->trx_date','DD/MM/YYYY')
                                AND kpei_due_dt           = TO_DATE('$this->due_date','DD/MM/YYYY')
                                AND contr_stat           <> 'C'
                                AND SUBSTR(contr_num,6,1) = '$ri'
                                AND mrkt_type            <> 'NG'
                                AND mrkt_type            <> 'TS'
                                AND stk_cd                = stk_cd_old(+)
                                GROUP BY client_cd,
                                  stk_cd,
                                  stk_cd_new
                                ) t3
                              WHERE onh.client_cd = t3.client_cd (+)
                              AND onh.stk_cd      = t3.stk_cd(+)
                              ) s3,
                              (SELECT client_cd,
                                stk_cd,
                                DECODE(SIGN(net_qty),-1, ABS(net_qty),0) AS t2_sell
                              FROM
                                (SELECT client_cd,
                                  NVL(stk_cd_new,stk_cd) stk_cd,
                                  SUM( DECODE(SUBSTR(contr_num,5,1),'B',1,-1) * qty) net_qty
                                FROM T_CONTRACTS,
                                  (SELECT stk_cd_old,
                                    stk_cd_new
                                  FROM T_CHANGE_STK_CD
                                  WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                  )
                                WHERE contr_dt            > (TO_DATE('$this->t1_date','DD/MM/YYYY')- 20)
                                AND kpei_due_dt           = TO_DATE('$this->t1_date','DD/MM/YYYY')
                                AND contr_stat           <> 'C'
                                AND SUBSTR(contr_num,6,1) = '$ri'
                                AND mrkt_type            <> 'NG'
                                AND mrkt_type            <> 'TS'
                                AND stk_cd                = stk_cd_old(+)
                                AND client_cd ||stk_cd NOT IN
                                  ( SELECT trim(client_cd)||trim(stk_cd) FROM v_porto_jaminan
                                  )
                                GROUP BY client_cd,
                                  stk_cd,
                                  stk_cd_new
                                )
                              ) t2
                            WHERE s3.client_cd = t2.client_cd(+)
                            AND s3.stk_cd      = t2.stk_cd(+)
                            ) s2,
                            (SELECT client_cd,
                              stk_cd,
                              DECODE(SIGN(net_qty),-1, ABS(net_qty),0) AS t1_sell
                            FROM
                              (SELECT client_cd,
                                NVL(stk_cd_new,stk_cd) stk_cd,
                                SUM( DECODE(SUBSTR(contr_num,5,1),'B',1,-1) * qty) net_qty
                              FROM T_CONTRACTS,
                                (SELECT stk_cd_old,
                                  stk_cd_new
                                FROM T_CHANGE_STK_CD
                                WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                                )
                              WHERE contr_dt            > (TO_DATE('$this->t2_date','DD/MM/YYYY')- 20)
                              AND kpei_due_dt           = TO_DATE('$this->t2_date','DD/MM/YYYY')
                              AND contr_stat           <> 'C'
                              AND SUBSTR(contr_num,6,1) = '$ri'
                              AND mrkt_type            <> 'NG'
                              AND mrkt_type            <> 'TS'
                              AND stk_cd                = stk_cd_old(+)
                              AND client_cd ||stk_cd NOT IN
                                ( SELECT trim(client_cd)||trim(stk_cd) FROM v_porto_jaminan
                                )
                              GROUP BY client_cd,
                                stk_cd,
                                stk_cd_new
                              )
                            WHERE net_qty < 0
                            ) t1
                          WHERE s2.client_cd = t1.client_cd(+)
                          AND s2.stk_cd      = t1.stk_cd(+)
                          )
                        WHERE t3_trf004 <> 0
                        OR t2_trf004     > 0
                        OR t1_trf004     > 0
                        UNION ALL
                        SELECT client_cd,
                          stk_cd,
                          0 onh_amt,
                          0 t3_trf004,
                          0 sisa_3,
                          0 t2_sell,
                          0 t2_trf004,
                          0 sisa_2,
                          0 t1_sell,
                          0 t1_trf004,
                          0 AS tot_004,
                          SUM(qty004) qty004
                        FROM
                          (SELECT client_cd,
                            a.stk_cd,
                            qty004 * DECODE(from_qty,NULL,1,to_qty/from_qty) qty004
                          FROM
                            (SELECT client_cd,
                              NVL(stk_cd_new,stk_cd) stk_cd,
                              NVL( DECODE(db_cr_flg,'D',1,-1) * (total_share_qty + withdrawn_share_qty),0) qty004
                            FROM T_STK_MOVEMENT,
                              (SELECT stk_cd_old,
                                stk_cd_new
                              FROM T_CHANGE_STK_CD
                              WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                              )
                            WHERE doc_dt    = TO_DATE('$this->end_date','DD/MM/YYYY')
                            AND gl_acct_cd IN ('13')
                            AND gl_acct_cd IS NOT NULL
                            AND doc_stat    = '2'
                            AND db_cr_flg   = 'D'
                            AND s_d_type    = '4'
                            AND stk_cd      = stk_cd_old(+)
                            AND TO_DATE('$this->due_date','DD/MM/YYYY')   > '15jun12'
                            ) a,
                            (SELECT stk_cd,
                              x_dt,
                              to_qty,
                              from_Qty
                            FROM T_CORP_ACT
                            WHERE distrib_dt = TO_DATE('$this->due_date','DD/MM/YYYY')
                            AND ca_Type     IN ('REVERSE','SPLIT')
                            ) b
                            WHERE a.stk_cd = b.stk_Cd(+)
                          )
                        GROUP BY client_Cd,
                          stk_Cd
                        )
                      GROUP BY client_Cd,
                        stk_Cd
                      )
                    )
                  WHERE (in_004    <> 0
                  OR out_004       <> 0)
                  AND (('$trx_type' = 'B'
                  AND out_004      <> 0)
                  OR ('$trx_type'   = 'J'
                  AND in_004       <> 0))
                  UNION ALL
                  SELECT client_cd,
                    stk_cd,
                    'TS' AS mrkt_type,
                    SUM(qty)
                  FROM
                    (SELECT T_CONTRACTS.client_cd,
                      NVL(stk_cd_new,stk_cd) stk_cd,
                      DECODE(SUBSTR(contr_num,5,1),'$trx_type',qty,0) AS qty
                    FROM T_CONTRACTS,
                      v_client_subrek14,
                      v_broker_subrek,
                      (SELECT stk_cd_old,
                        stk_cd_new
                      FROM T_CHANGE_STK_CD
                      WHERE eff_Dt <= TO_DATE('$this->due_date','DD/MM/YYYY')
                      )
                    WHERE contr_dt            = TO_DATE('$this->trx_date','DD/MM/YYYY')
                    AND kpei_due_dt           = TO_DATE('$this->due_date','DD/MM/YYYY')
                    AND contr_stat           <> 'C'
                    AND SUBSTR(contr_num,6,1) = '$ri'
                    AND mrkt_type             = 'NG'
                    AND sell_broker_cd        = buy_broker_cd
                    AND sell_broker_cd       IS NOT NULL
                    AND buy_broker_cd        IS NOT NULL
                    AND stk_cd                = stk_cd_old(+)
                    AND T_CONTRACTS.client_cd ||T_CONTRACTS.stk_cd NOT IN
                      ( SELECT trim(client_cd)||trim(stk_cd) FROM v_porto_jaminan
                      )
                    AND ('$rute'              = 'SUBR1MAIN1'
                    OR '$rute'                = 'MAIN1SUBR1')
                    AND T_CONTRACTS.client_cd = v_client_subrek14.client_cd
                    AND subrek001            <> broker_001
                    )
                  GROUP BY client_cd,
                    stk_cd
                  HAVING SUM(qty) > 0
                  ) t,
                  (SELECT client_cd,
                    client_name,
                    subrek001,
                    subrek004,
                    pair001,
                    broker_001,
                    tc_id
                  FROM
                    (SELECT m.client_cd,
                      client_name,
                      NVL(v.subrek001, broker_001) AS subrek001,
                      NVL(v.subrek004,broker_004)  AS subrek004,
                      NVL(v.pair001, broker_001)   AS pair001,
                      broker_001,
                      NVL(d.tc_id,'-') tc_id
                    FROM v_client_subrek14 v,
                      MST_CLIENT m,
                      v_broker_subrek b,
                      (SELECT T_TC_DOC.client_cd,
                        tc_id
                      FROM T_TC_DOC,
                        (SELECT client_Cd,
                          MIN(tc_date) min_tc_date
                        FROM T_TC_DOC
                        WHERE tc_date >= TO_DATE('$this->trx_date','DD/MM/YYYY')
                        AND tc_status  = 0
                        GROUP BY client_cd
                        ) min_tc
                      WHERE T_TC_DOC.tc_date = min_tc_date
                      AND T_TC_DOC.client_cd = min_tc.client_Cd
                      AND T_TC_DOC.tc_status = 0
                      ) d
                    WHERE m.client_cd = v.client_cd(+)
                    AND m.client_Cd   = d.client_cd(+)
                    )
                  ) m,
                  v_broker_subrek b
                WHERE T.client_cd = m.client_cd
                AND 
                (
                    (('$rute' = 'PAIR1SUBR4' OR '$rute' = 'SUBR4PAIR1') AND (subrek001 = pair001 AND mrkt_type = 'RG' AND '$ri' ='R' )) 
                    OR 
                    (('$rute' = 'SUBR1MAIN1' OR '$rute' = 'MAIN1SUBR1') AND (subrek001 <> pair001 OR mrkt_type = 'TS' OR '$ri' ='I' ))
                )";
        
        return $sql;
    }
    
    function getTrxCashSql($trx_type)
    {
        $sql = "SELECT TO_CHAR(TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') ||'_' ||subrek004 ||'_' ||DECODE('$trx_type','B','BAYAR','TERIMA') \"external Reference\",
                  broker_cd                                     AS \"participant Code\",
                  DECODE('$trx_type','J',subrek004,broker_001)  AS \"source Account\",
                  DECODE('$trx_type','J', broker_001,subrek004) AS \"target Account\",
                  'IDR'                                         AS \"currency Code\",
                  '' \"security Code Type\",
                  ''                                       AS \"security Code\",
                  DECODE('$trx_type','J',net_sell,net_buy) AS \"instrument Quantity\",
                  TO_CHAR(TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd')      AS \"settlement Date\",
                  DECODE('$trx_type','B','BUY ','SELL ') ||' TRX ' ||TO_CHAR(TO_DATE('$this->trx_date','DD/MM/YYYY'),'yyyymmdd') ||' ' ||client_name AS \"description\"
                FROM
                  (SELECT t.subrek004,
                    y.client_name,
                    DECODE(SIGN(net_val),1,net_val,0) net_buy,
                    DECODE(SIGN(net_val),-1,ABS(net_val),0) net_sell,
                    broker_cd,
                    broker_001
                  FROM
                    (SELECT subrek004,
                      SUM(DECODE(belijual,'B',1,-1) * val) net_val
                    FROM
                      (SELECT NVL(subrek004, broker_004) subrek004,
                        SUBSTR(contr_num,5,1) belijual,
                        stk_cd,
                        val
                      FROM t_contracts,
                        V_client_subrek14 v,
                        v_broker_subrek
                      WHERE contr_dt            = TO_DATE('$this->trx_date','DD/MM/YYYY')
                      AND contr_stat           <> 'C'
                      AND due_dt_for_amt        = TO_DATE('$this->due_date','DD/MM/YYYY')
                      AND mrkt_type            <> 'NG'
                      AND mrkt_type            <> 'TS'
                      AND SUBSTR(contr_num,6,1) = 'R'
                      AND t_contracts.client_cd = v.client_cd(+)
                      )
                    GROUP BY subrek004
                    ) t,
                    ( SELECT DISTINCT subrek004,
                      cif_name AS client_name
                    FROM v_client_subrek14,
                      mst_client_rekefek r,
                      mst_cif
                    WHERE subrek004 = r.subrek_cd
                    AND r.cifs      = mst_cif.cifs
                    ) Y,
                    v_broker_subrek
                  WHERE t.subrek004 = y.subrek004
                  )
                WHERE (('$trx_type' = 'B' AND net_buy > 0) OR ('$trx_type' = 'J' AND net_sell > 0))
                ORDER BY 3,4";
        
        return $sql;
    }
    
    function getTrxCashPFSql($trx_type, $client_type)
    {
        $sql = "SELECT TO_CHAR(TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') ||'_' ||t.sid \"external Reference\",
                  b.broker_cd AS \"participant Code\",
                  DECODE('$trx_type','J',t.subrek004,b.broker_001) \"source Account\",
                  DECODE('$trx_type','J',b.broker_001,t.subrek004) \"target Account\",
                  'IDR' \"currency Code\",
                  '' \"security Code Type\",
                  '' \"security Code\",
                  ABS(t.net_amt) \"instrument Quantity\",
                  TO_CHAR(TO_DATE('$this->due_date','DD/MM/YYYY'),'yyyymmdd') \"settlement Date\",
                  DECODE('$trx_type','B','BUY ','SELL ') ||'$client_type' ||' TRX ' ||TO_CHAR(TO_DATE('$this->trx_date','DD/MM/YYYY'),'yyyymmdd') ||' ' ||t.client_name \"description\"
                FROM
                  (SELECT f.cif_name AS client_name,
                    f.sid,
                    a.net_amt,
                    a.subrek004
                  FROM
                    (SELECT subrek004,
                      SUM(DECODE(SUBSTR(contr_num,5,1),'B',1,-1) * net) net_amt
                    FROM t_contracts t,
                      v_client_subrek14 v
                    WHERE t.contr_num BETWEEN TO_CHAR(TO_DATE('$this->trx_date','DD/MM/YYYY') ,'mmyy')
                      ||'%'
                    AND TO_CHAR(TO_DATE('$this->trx_date','DD/MM/YYYY') ,'mmyy')
                      ||'_'
                    AND t.CONTR_STAT           <> 'C'
                    AND SUBSTR(t.contr_num,6,1) = 'R'
                    AND t.mrkt_type            <> 'NG'
                    AND t.CONTR_DT              = TO_DATE('$this->trx_date','DD/MM/YYYY')
                    AND t.DUE_DT_FOR_CERT       = TO_DATE('$this->due_date','DD/MM/YYYY')
                    AND t.client_cd             = v.client_cd
                    GROUP BY subrek004
                    ) a,
                    mst_client_rekefek r,
                    mst_cif f
                  WHERE a.subrek004 = r.SUBREK_cd
                  AND f.cifs = r.cifs
                  AND ((net_amt > 0 AND '$trx_type' = 'B') OR (net_amt < 0 AND '$trx_type' = 'J'))
                  ) T,
                  v_broker_subrek b";
        
        return $sql;
    }
        
    function rules()
    {
        return array(
            array('trx_date, due_date, trx_type, transfer_type, output','required'),
            
            array('externalReference, participantCode, sourceAccount, targetAccount, currencyCode, securityCodeType, securityCode, instrumentQuantity, settlementDate, description, instructionType, participantAccount, counterpartCode, numberOfSecurities, tradeDate, settlementAmount, purpose, tradingReference, settlementReason','safe')
        );
    }
    
    function attributeLabels()
    {
        return array(
            'trx_date' => 'Transaction Date',
            'due_date' => 'Due Date',
            'trx_type' => 'Transaction Type',
            'transfer_type' => 'Transfer',
        );
    }
}
