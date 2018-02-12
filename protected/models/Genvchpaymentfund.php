<?php

class Genvchpaymentfund extends Tpayrech
{
    public $save_flg;
    public $t0;
    public $branch_code;
    public $doc_date;
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function rules()
    {
        return array_merge(
        array(
            array('doc_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
            //array('t0', 'application.components.validator.ANumberSwitcherValidator'),
            array('t0,save_flg,branch_code','safe'),
        
        ),parent::rules()); 
    }
    public function attributeLabels()
    {
        return array(
        'doc_date'=>'Date',
        'client_cd'=>'Client Code'
        );
    }
    public static function getVoucherKBBFundSql($doc_date, $client_cd, $branch_code)
    {
        $sql = "SELECT TRIM(M.BRANCH_CODE)branch_code,A.CLIENT_CD,M.CLIENT_NAME, ABS(DECODE(SIGN(T0),-1, DECODE(SIGN(FUND_BALANCE),1, DECODE(SIGN(ABS(T0)-FUND_BALANCE),-1,T0,-FUND_BALANCE), 0), T0)) T0
                FROM
                  (
                    SELECT CLIENT_CD, -F_CLIENT_ONHAND_CASH(CLIENT_CD, to_date('$doc_date','dd/mm/yyyy')) T0, -F_GET_DUE_FUNDBAL(CLIENT_CD, to_date('$doc_date','dd/mm/yyyy')) FUND_BALANCE
                    FROM FUND_CLIENT_MASTER
                  )
                  A, MST_CLIENT M, (
                    SELECT CLIENT_CD, BANK_CD,ACCT_STAT
                    FROM MST_CLIENT_FLACCT
                    WHERE ACCT_STAT IN('A','I')
                    AND APPROVED_STAT='A'
                  )
                  F,
                  ( 
                    select client_cd from
                      (
                          SELECT        (SELECT field_value
                          FROM T_MANY_DETAIL DA
                          WHERE DA.TABLE_NAME = 'T_PAYRECH'
                          AND DA.UPDATE_DATE  = DD.UPDATE_DATE
                          AND DA.UPDATE_SEQ   = DD.UPDATE_SEQ
                          AND DA.FIELD_NAME   = 'CLIENT_CD'
                          AND DA.RECORD_SEQ   = DD.RECORD_SEQ
                          ) CLIENT_CD,
                          (SELECT to_date(FIELD_VALUE,'yyyy/mm/dd hh24:mi:ss')
                          FROM T_MANY_DETAIL DA
                          WHERE DA.TABLE_NAME = 'T_PAYRECH'
                          AND DA.UPDATE_DATE  = DD.UPDATE_DATE
                          AND DA.UPDATE_SEQ   = DD.UPDATE_SEQ
                          AND DA.FIELD_NAME   = 'PAYREC_DATE'
                          AND DA.RECORD_SEQ   = DD.RECORD_SEQ
                          ) PAYREC_DATE,
                          (SELECT FIELD_VALUE
                          FROM T_MANY_DETAIL DA
                          WHERE DA.TABLE_NAME = 'T_PAYRECH'
                          AND DA.UPDATE_DATE  = DD.UPDATE_DATE
                          AND DA.UPDATE_SEQ   = DD.UPDATE_SEQ
                          AND DA.FIELD_NAME   = 'ACCT_TYPE'
                          AND DA.RECORD_SEQ   = DD.RECORD_SEQ
                          ) ACCT_TYPE,
                          HH.APPROVED_STATUS,
                          HH.MENU_NAME
                        FROM T_MANY_DETAIL DD,
                          T_MANY_HEADER HH
                        WHERE DD.TABLE_NAME    = 'T_PAYRECH'
                        AND DD.UPDATE_DATE     = HH.UPDATE_DATE
                        AND DD.UPDATE_SEQ      = HH.UPDATE_SEQ
                        AND DD.RECORD_SEQ      = 1
                        AND DD.FIELD_NAME      = 'CLIENT_CD'
                        AND HH.APPROVED_STATUS = 'E'
                        )
                    WHERE TRUNC(PAYREC_DATE) = to_date('$doc_date','dd/mm/yyyy')
                    AND ACCT_TYPE ='ROR'
                    
                    )t
                WHERE A.CLIENT_CD=M.CLIENT_CD
                AND A.CLIENT_CD  =F.CLIENT_CD
                AND M.CLIENT_CD  =F.CLIENT_CD
                and m.client_cd = t.client_cd(+)
                and t.client_cd is null
                AND (TRIM(M.BRANCH_CODE) = '$branch_code' OR '%' ='$branch_code' )
                AND (M.CLIENT_CD           = '$client_cd' OR '%' = '$client_cd')
                AND  decode(sign(T0),-1, decode(sign(Fund_Balance),1, decode(sign(abs(T0)-Fund_Balance),-1,T0,-Fund_Balance), 0), T0) < -1
                order by a.client_cd
                 ";
        
        return $sql;
    }
    
    public function executeSpVchFund($client_cd, $branch_code)
    {
        $connection  = Yii::app()->db;
        try{
            $query  = "CALL SP_GEN_VCH_PAYMENT_FUND(to_date(:P_DOC_DATE,'YYYY-MM-DD'),
                                                    :P_CLIENT_CD,
                                                    :P_BRANCH_CODE,
                                                    :P_USER_ID,
                                                    :P_IP_ADDRESS ,
                                                    :P_ERROR_CODE,
                                                    :P_ERROR_MSG)";
            
            $command = $connection->createCommand($query);
            $command->bindValue(":P_DOC_DATE",$this->doc_date,PDO::PARAM_STR);
            $command->bindValue(":P_CLIENT_CD",$client_cd,PDO::PARAM_STR);
            $command->bindValue(":P_BRANCH_CODE",$branch_code,PDO::PARAM_STR);;
            $command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
            $command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
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
}
