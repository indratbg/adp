<?php
class Genjurbiayaotcharian extends Tstkmovement
{

public $folder_cd;
public $otc_fee;
public $tidak_dijurnal;
public $jur_date;
public static function model($className=__CLASS__)
{
    return parent::model($className);
}

public function rules()
{
    return 
    array(
        array('jur_date,doc_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
        array('doc_dt,otc_fee','required','on'=>'retrieve'),
        array('jur_date,folder_cd,doc_dt','required','on'=>'save'),
        array('doc_dt','checkCongen','on'=>'save'),
        array('otc_fee', 'application.components.validator.ANumberSwitcherValidator'),
        array('tidak_dijurnal,folder_cd','safe'),
    
    ); 
}
public function checkCongen()
{
    $sql = "select count(1)cnt from t_contracts where contr_dt=to_date('$this->doc_dt','yyyy-mm-dd') and contr_stat<>'C' ";
    $exec = DAO::queryRowSql($sql);
    if($exec['cnt']==0)
    {
        $this->addError('doc_dt', 'Hanya boleh digenerate setelah proses contract generation');
    }
}
public static function getDataClientOtcHarian($doc_dt,$otc_fee)
{
    $sql="SELECT DOC_DT, CLIENT_CD, STK_CD, doc_num, TOTAL_SHARE_QTY, WITHDRAWN_SHARE_QTY, doc_rem, price, broker, client_name, otc,
            tidak_dijurnal, SUM( otc) over(partition BY client_cd) AS sum_otc
            FROM
              (
                SELECT x.DOC_DT, x.CLIENT_CD, x.STK_CD, x.doc_num, x.TOTAL_SHARE_QTY, x.WITHDRAWN_SHARE_QTY, x.doc_rem, x.price,
                x.broker, x.client_name, x.otc * DECODE(SIGN(rw_cnt), 0, 1, DECODE(SIGN(y.net_qty * x.doc_type), 0, 0, 1, 1, - 1, 0) * DECODE(x.doc_num, y.minr_doc_num, 1, y.minw_doc_num, 1, 0)) otc,
                DECODE(x.acopen_fee_flg, 'Y', 'N', 'Y') AS Tidak_dijurnal
                FROM
                  (
                    SELECT a.DOC_DT, a.CLIENT_CD, a.STK_CD,(DECODE(SUBSTR(a.DOC_NUM, 7, 1), 'J', 0, 'S', 0, a.TOTAL_SHARE_QTY)) TOTAL_SHARE_QTY,
                    (DECODE(SUBSTR(a.DOC_NUM, 7, 1), 'J', a.TOTAL_SHARE_QTY, 'S', a.TOTAL_SHARE_QTY, a.WITHDRAWN_SHARE_QTY )) WITHDRAWN_SHARE_QTY, 
                    DECODE(a.s_d_type, 'V', 'Trx', SUBSTR(a.DOC_NUM, 5, 1)) doc_rem, a.price, a.withdraw_reason_cd , b.client_name, 
                    '$otc_fee' otc, b.acopen_fee_flg, a.doc_num, a.broker, DECODE(SUBSTR(a.doc_num, 5, 3), 'RSN', 1, 'WSN', - 1, 0) AS doc_type
                    FROM t_stk_movement a, mst_client b, T_daily_otc_jur d
                    WHERE a.seqno                = 1
                    AND SUBSTR(a.DOC_NUM, 5, 3) IN('RSN', 'WSN', 'JVB', 'JVS')
                    AND a.client_cd              = b.client_cd
                    AND b.acopen_fee_flg         = 'Y'
                    AND a.doc_stat               = '2'
                    AND a.doc_dt =to_date('$doc_dt','yyyy-mm-dd') 
                    AND a.broker IS NOT NULL
                    AND a.doc_num  = d.doc_num(+)
                    AND d.doc_num IS NULL
                  )
                  x,(
                    SELECT a.DOC_DT, a.CLIENT_CD, a.STK_CD, SUM(DECODE(SUBSTR(doc_num, 5, 1), 'J', 0, a.total_share_qty - a.withdrawn_share_qty)) AS net_qty,
                    MIN(DECODE(SUBSTR(doc_num, 5, 1), 'R', doc_num, '_')) minr_doc_num, MIN(DECODE( SUBSTR(doc_num, 5, 1), 'W', doc_num, '_')) minw_doc_num,
                    SUM(DECODE(SUBSTR(doc_num, 5, 1), 'R', 1, 0)) * SUM(DECODE( SUBSTR(doc_num, 5, 1), 'W', 1, 0)) RW_cnt
                    FROM t_stk_movement a
                    WHERE a.seqno                = 1
                    AND SUBSTR(a.DOC_NUM, 5, 3) IN('RSN', 'WSN', 'JVS', 'JVB')
                    AND a.doc_stat               = '2'
                    AND a.doc_dt =to_date('$doc_dt','yyyy-mm-dd') --BETWEEN :P_BGN_DATE AND :P_END_DATE
                    AND a.broker IS NOT NULL
                    GROUP BY a.DOC_DT, a.CLIENT_CD, a.STK_CD
                  )
                  y
                WHERE x.doc_dt  = y.doc_dt
                AND x.client_cd = y.client_cd
                AND x.stk_cd    = y.stk_cd
              )
              order by 2,3
    ";
    return $sql;
}
public function attributeLabels()
{
    return array('otc_fee'=>'Biaya OTC',
                  'folder_cd'=>'File No.',
                  'doc_dt'=>'Date',
                  'jur_date'=>'Journal Date'  );
}

public function executeSpJurOTC()
    { 
        $connection  = Yii::app()->db;

        try{
            $query  = "CALL SP_DAILY_OTC_JUR(TO_DATE(:P_OTC_DATE,'YYYY-MM-DD'),
                                                TO_DATE(:P_JOURNAL_DATE,'YYYY-MM-DD'),
                                                :P_FOLDER_CD,
                                                :P_USER_ID,
                                                :P_IP_ADDRESS,
                                                :P_ERROR_CODE,
                                                :P_ERROR_MSG)";
            
            $command = $connection->createCommand($query);
            $command->bindValue(":P_OTC_DATE",$this->doc_dt,PDO::PARAM_STR);
            $command->bindValue(":P_JOURNAL_DATE",$this->jur_date,PDO::PARAM_STR);
            $command->bindValue(":P_FOLDER_CD",$this->folder_cd,PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
            $command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);          
            $command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
            $command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,200);
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

?>