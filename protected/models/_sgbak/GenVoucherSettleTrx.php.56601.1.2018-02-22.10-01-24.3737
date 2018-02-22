<?php

class GenVoucherSettleTrx extends Tpayrech
{
    public $brch_cd;
    public $bank_acct_num;
    public $net_buy;
    public $net_sell;
    public $pembulatan;
    public $vch_ref;
    public $generate = 'Y';
    
    public $ap_vch_cnt;
    public $ar_vch_cnt;
    public $fail_vch;
    public $piutang;
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public static function getSettleTrxCustodySql($trx_date, $due_date, $rdi_flg)
    {
        $sql = "SELECT client_cd, client_name, branch_code brch_cd, bank_acct_num, due_dt_for_amt due_date, DECODE(SIGN(net_amt),1, net_amt,0) net_buy, DECODE(SIGN(net_amt),-1, ABS(net_amt),0) net_sell, 'Y' flg, 0 pembulatan,
                F_GET_OUTS_AR_CLIENT(client_cd,TO_DATE('$due_date','YYYY-MM-DD')) piutang
                FROM
                  (
                    SELECT t.client_cd, m.client_name, due_dt_for_amt, branch_code, m.bank_acct_num, SUM(DECODE(SUBSTR(contr_num,5,1),'B',1,-1) * (amt_for_curr - NVL(t.sett_val,0)) ) net_amt
                    FROM t_contracts t, mst_client m, mst_client_flacct r
                    WHERE contr_dt           = TO_DATE('$trx_date','YYYY-MM-DD')
                    AND contr_stat          <> 'C'
                    AND due_dt_for_amt       = TO_DATE('$due_date','YYYY-MM-DD')
                    AND t.client_cd          = m.client_cd
                    AND m.custodian_cd      IS NOT NULL
                    AND NVL(t.sett_val,0)    < amt_for_curr
                    AND NVL(sett_for_curr,0) = 0
                    AND t.client_cd          = r.client_cd(+)
                    AND ((r.client_cd       IS NULL  AND '$rdi_flg'           ='N') OR ('$rdi_flg'            ='Y' and r.acct_stat='A'))
                    GROUP BY t.client_cd, m.client_name, m.branch_code, m.bank_acct_num, due_dt_for_amt
                  )
                  ---18apr2017 tambah jurnal minfee untuk MU
                UNION ALL
                SELECT client_cd, client_name, brch_cd, bank_acct_num, due_date, DECODE(SIGN(net_amt),1, net_amt,0) net_buy, DECODE(SIGN(net_amt),-1, ABS(net_amt),0) net_sell, 'Y' flg, 0 pembulatan,
                F_GET_OUTS_AR_CLIENT(client_cd,TO_DATE('$due_date','YYYY-MM-DD')) piutang
                FROM
                  (
                    SELECT t.sl_acct_cd client_cd, m.client_name, m.branch_code brch_cd, m.bank_acct_num, t.due_date, SUM(DECODE(t.db_cr_flg,'D',1,-1) * curr_val)net_amt
                    FROM T_ACCOUNT_LEDGER t, MST_GLA_TRX v, mst_client m, mst_client_flacct r
                    WHERE SUBSTR(xn_doc_num,8,3) = 'MFE'
                    AND t.sl_acct_cd             =m.client_cd
                    AND m.client_cd              = r.client_cd(+)
                    AND ((r.client_cd       IS NULL  AND '$rdi_flg'           ='N') OR ('$rdi_flg'            ='Y' and r.acct_stat='A'))
                    AND m.custodian_cd          IS NOT  NULL
                    AND doc_date = TO_DATE('$trx_date','YYYY-MM-DD') 
                    AND t.due_date = TO_DATE('$due_date','YYYY-MM-DD')
                    AND v.jur_type           ='CLIE'
                    AND T.RECORD_SOURCE     ='GL'
                    AND T.REVERSAL_JUR       ='N' 
                    AND trim(t.gl_acct_cd)         = v.GL_A
                    AND curr_val > NVL(sett_val,0)
                     AND NVL(sett_for_curr,0) = 0
                    AND t.approved_sts       ='A'
                    GROUP BY t.sl_acct_cd, m.client_name, m.branch_code, m.bank_acct_num, t.due_date
                  )
                ORDER BY 1";
        
        return $sql;
    }
    
    public static function getSettleTrxRegularSql($trx_date, $due_date, $brch_cd)
    {
        $sql = " select client_cd, client_name, brch_cd, bank_cd, bank_acct_num, due_date,
                  sum(net_buy)net_buy,sum(net_sell)net_sell, 'Y' flg, 0 pembulatan,
                  F_GET_OUTS_AR_CLIENT(client_cd,TO_DATE('$due_date','YYYY-MM-DD')) piutang         
              from 
              (   
              SELECT  client_cd, client_name, branch_code brch_cd, bank_cd, bank_acct_num,  due_dt_for_amt due_date,        
                        DECODE(SIGN(net_amt),1, net_amt,0) net_buy,
                        DECODE(SIGN(net_amt),-1, ABS(net_amt),0) net_sell
                FROM
                (           
                    SELECT  t.client_cd, m.client_name, due_dt_for_amt, branch_code, m.bank_cd, m.bank_acct_num, SUM(DECODE(SUBSTR(contr_num,5,1),'B',1,-1) * (amt_for_curr -  NVL(t.sett_val,0)) ) net_amt         
                    FROM t_contracts t, mst_client m, mst_client_flacct f           
                    WHERE contr_dt = TO_DATE('$trx_date','YYYY-MM-DD')          
                    AND contr_stat <> 'C'           
                    AND due_dt_for_amt = TO_DATE('$due_date','YYYY-MM-DD')          
                    AND t.client_cd = m.client_cd   
                    AND t.client_cd = f.client_cd   
                    AND TRIM(t.brch_cd) LIKE '$brch_cd' 
                    AND m.custodian_cd is null      
                    AND m.client_type_3 IN ('R','N')    
                    AND NVL(t.sett_val,0) < amt_for_curr            
                    AND NVL(sett_for_curr,0) = 0    
                    AND f.acct_stat = 'A'       
                    GROUP BY  t.client_cd, m.client_name, m.branch_code, m.bank_cd, m.bank_acct_num, due_dt_for_amt
                )
                WHERE DECODE(SIGN(net_amt),1, net_amt,0) = 0
                   ---18apr2017 tambah jurnal minfee untuk MU
                UNION ALL
               SELECT client_cd, client_name, brch_cd, bank_cd, bank_acct_num, due_date, DECODE(SIGN(net_amt),1, net_amt,0) net_buy, DECODE(SIGN(net_amt),-1, ABS(net_amt),0) net_sell
                FROM
                  (
                    SELECT t.sl_acct_cd client_cd, m.client_name, m.branch_code brch_cd, m.bank_cd, m.bank_acct_num, t.due_date, SUM(DECODE(t.db_cr_flg,'D',1,-1) * curr_val)net_amt
                    FROM T_ACCOUNT_LEDGER t, MST_GLA_TRX v, mst_client m, mst_client_flacct r
                    WHERE SUBSTR(xn_doc_num,8,3) = 'MFE'
                    AND t.sl_acct_cd             =m.client_cd
                    AND m.client_cd              = r.client_cd
                    AND r.acct_stat              ='A'
                    AND m.custodian_cd          IS NULL
                    AND m.client_type_3         IN ('R','N')
                    AND doc_date  = TO_DATE('$trx_date','YYYY-MM-DD')  
                    AND t.due_date=TO_DATE('$due_date','YYYY-MM-DD')
                    AND v.jur_type           ='CLIE'
                    AND T.RECORD_SOURCE    ='GL'
                    AND trim(t.gl_acct_cd)         = v.GL_A
                    AND curr_val > NVL(sett_val,0)
                     AND NVL(sett_for_curr,0) = 0
                    AND t.approved_sts       ='A'
                    AND TRIM(m.branch_code) LIKE '$brch_cd'
                    GROUP BY t.sl_acct_cd, m.client_name, m.branch_code, m.bank_cd, m.bank_acct_num, t.due_date
                  ) 
                  )
                  group by client_cd, client_name, brch_cd, bank_cd, bank_acct_num,  due_date
                ORDER BY 1";
        
        return $sql;
    }
    
    public function executeSpSettleCustody($exec_status, $client_type)
    {
        $connection  = Yii::app()->db;
        
        try{
            $query  = "CALL SP_RVPV_TRX_CUSTODY(
                        :P_CLIENT_CD,
                        :P_BRCH_CD,
                        TO_DATE(:P_TRX_DATE,'YYYY-MM-DD'),
                        TO_DATE(:P_DUE_DATE,'YYYY-MM-DD'),
                        :P_PEMBULATAN,
                        :P_CLIENT_TYPE,
                        :P_VCH_REF,
                        :P_AP_VCH,
                        :P_AR_VCH,
                        :P_FAIL_VCH,
                        :P_USER_ID,
                        :P_UPDATE_SEQ,
                        TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
                        :P_ERROR_CODE,
                        :P_ERROR_MSG)";
            
            $command = $connection->createCommand($query);
            $command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
            $command->bindParam(":P_BRCH_CD",$this->brch_cd,PDO::PARAM_STR,100);
            $command->bindValue(":P_TRX_DATE",$this->trx_date,PDO::PARAM_STR);
            $command->bindValue(":P_DUE_DATE",$this->due_date,PDO::PARAM_STR);
            $command->bindValue(":P_PEMBULATAN",$this->pembulatan,PDO::PARAM_STR);
            $command->bindValue(":P_CLIENT_TYPE",$client_type,PDO::PARAM_STR);
            $command->bindValue(":P_VCH_REF",$this->vch_ref,PDO::PARAM_STR);
            $command->bindParam(":P_AP_VCH",$this->ap_vch_cnt,PDO::PARAM_STR,100);
            $command->bindParam(":P_AR_VCH",$this->ar_vch_cnt,PDO::PARAM_STR,100);
            $command->bindParam(":P_FAIL_VCH",$this->fail_vch,PDO::PARAM_STR,10);
            $command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
            $command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
            $command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
                        
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
            array('trx_date, due_date, payrec_date, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
        
            array('piutang,curr_amt, num_cheq, pembulatan, net_buy, net_sell', 'application.components.validator.ANumberSwitcherValidator'),
        
            array('due_date, trx_date','required','on'=>'header'),
            
            array('vch_ref','checkRequired','on'=>'regular'),
            array('vch_ref','checkFolderCd','on'=>'regular'),
            array('pembulatan','checkBulat','on'=>'regular, custody'),
            
            array('num_cheq', 'numerical', 'integerOnly'=>true),
            array('pembulatan, curr_amt', 'numerical'),
            array('payrec_type', 'length', 'max'=>2),
            array('acct_type', 'length', 'max'=>4),
            array('sl_acct_cd, gl_acct_cd, client_cd', 'length', 'max'=>12),
            array('curr_cd', 'length', 'max'=>3),
            array('payrec_frto, remarks, client_bank_name', 'length', 'max'=>50),
            array('user_id', 'length', 'max'=>10),
            array('approved_sts', 'length', 'max'=>1),
            array('approved_by', 'length', 'max'=>20),
            array('check_num, client_bank_acct', 'length', 'max'=>30),
            array('folder_cd', 'length', 'max'=>8),
            array('generate, brch_cd, bank_acct_num, net_buy, net_sell, vch_ref, pembulatan, print, file_upload,trx_date, due_date, trf_ksei, int_adjust, type, client_bank_cd, client_name, client_type, client_type_3, branch_code, olt, recov_charge_flg, bank_cd, bank_acct_fmt, active, rdi_pay_flg, payrec_date, cre_dt, upd_dt, approved_dt', 'safe'),
        );      
    }

    public function checkBulat()
    {
        $result = DAO::queryRowSql("SELECT dflg1 FROM MST_SYS_PARAM WHERE param_id = 'RVPV_AUTO_TRF' AND param_cd1 = 'ROUND' ");
        
        if($result && $result['dflg1'] == 'Y')
        {
            $total = $this->net_buy + $this->net_sell + $this->pembulatan;
            
            if($total != round($total))$this->addError('pembulatan', 'Hasil pembulatan harus bulat');
        }
    }
    
    public function checkRequired()
    {
        $check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'VCH_REF' ")->dflg1;
        
        if($check == 'Y' && !$this->vch_ref && $this->client_type=='R' && $this->piutang != 0)$this->addError('vch_ref', 'Vch Ref cannot be blank'); 
    }
}
