<?php
class Generateotcfee extends Tstkmovement
{

    public $client_cd;
    public $client_name;
    public $sum_otc_client;
    public $sum_otc_repo_jual;
    public $sum_otc_repo_beli;
    public $jur;
    public $closed;
    public $jur_date;
    public $otc_fee;
    public $desc;
    public $from_dt;
    public $end_dt;
    public $folder_cd;
    public $jasa_sl_acct_cd;
    public $jasa_gl_acct_cd;
    public $ymh_gl_acct_cd;
    public $ymh_sl_acct_cd;
    public $cre_dt;
    public $save_flg = 'N';
    public $tot_fee_uncheck;
    public $count_uncheck;
    public $tot_fee;
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array(
                'from_dt,end_dt,jur_date',
                'application.components.validator.ADatePickerSwitcherValidatorSP'
            ),
            array('from_dt,end_dt,otc_fee','required','on'=>'filter'),
              array('jur_date,desc,jasa_sl_acct_cd,jasa_gl_acct_cd,ymh_gl_acct_cd,ymh_sl_acct_cd','required','on'=>'proses'),
              array('folder_cd','checkFolder','on'=>'proses'),
            array(
                'sum_otc_client,sum_otc_repo_jual,tot_fee,tot_fee_uncheck,otc_fee,sum_otc_repo_beli,count_uncheck',
                'application.components.validator.ANumberSwitcherValidator'
            ),
            array(
                'save_flg,client_cd,jasa_sl_acct_cd, jasa_gl_acct_cd, hutang_gl_acct_cd, hutang_sl_acct_cd, ymh_gl_acct_cd, ymh_sl_acct_cd,desc,folder_cd',
                'safe'
            ),
        );
    }
    public  function checkFolder()
    {
        $folder = Sysparam::model()->find("param_id='SYSTEM' and param_cd1='VCH_REF'")->dflg1;
        if($folder == 'Y' && !$this->folder_cd)
        {
            $this->addError('folder_cd', 'File No. tidak boleh kosong');
        }
    }

    public static function GetListData($rand_value,$user_id)
    {
            /*
        $sql = "SELECT client_cd, client_name, SUM(otc_client) sum_otc_client, 0 sum_otc_repo_jual, 0 sum_otc_repo_beli, jur, closed
                FROM
                  (
                    SELECT x.DOC_DT, x.CLIENT_CD, x.STK_CD, x.withdraw_reason_cd, x.client_name, 
                    x.otc_client * DECODE(SIGN(rw_cnt),0,1, DECODE(SIGN(y.net_qty * x.doc_type),0,0,1,1,-1,0) * 
                    DECODE(x.doc_num,y.minr_doc_num,1,y.minw_doc_num,1,0) ) otc_client, DECODE(c.client_cd,NULL,jur,'N') jur ,
                    DECODE(c.client_cd,NULL,'','CLOSED') closed
                    FROM
                      (
                        SELECT a.DOC_DT, a.CLIENT_CD, a.STK_CD, a.doc_num,a.total_share_qty + a.withdrawn_share_qty AS qty,
                        a.withdraw_reason_cd, b.client_name, DECODE(LENGTH(trim(a.client_cd)),2,0,1) * '$otc_fee' otc_client,
                        DECODE(SUBSTR(a.doc_num,5,3),'RSN',1,'WSN',-1,0) AS doc_type, b.acopen_fee_flg jur
                        FROM T_STK_MOVEMENT a, MST_CLIENT b
                        WHERE a.seqno              = 1
                        AND SUBSTR(a.DOC_NUM,5,3) IN ('RSN','WSN','JVB','JVS')
                        AND a.client_cd            = b.client_cd
                        AND a.doc_stat             = '2'
                        AND a.doc_dt BETWEEN to_date('$from_date','YYYY-MM-DD') AND to_date('$end_date','YYYY-MM-DD')
                        AND a.broker IS NOT NULL
                      )
                      x, (
                        SELECT a.DOC_DT, a.CLIENT_CD, a.STK_CD, SUM(DECODE(SUBSTR(doc_num,5,1),'J',0,a.total_share_qty - a.withdrawn_share_qty)) AS net_qty,
                        MIN(DECODE(SUBSTR(doc_num,5,1),'R',doc_num,'_')) minr_doc_num, MIN(DECODE(SUBSTR(doc_num,5,1),'W',doc_num,'_')) minw_doc_num, 
                        SUM(DECODE(SUBSTR(doc_num,5,1),'R',1,0)) * SUM(DECODE(SUBSTR(doc_num,5,1),'W',1,0)) RW_cnt
                        FROM T_STK_MOVEMENT a
                        WHERE a.seqno              = 1
                        AND SUBSTR(a.DOC_NUM,5,3) IN ('RSN','WSN','JVS','JVB')
                        AND a.doc_stat             = '2'
                        AND a.doc_dt BETWEEN to_date('$from_date','YYYY-MM-DD') AND to_date('$end_date','YYYY-mm-DD')
                        AND a.broker IS NOT NULL
                        GROUP BY a.DOC_DT, a.CLIENT_CD, a.STK_CD
                      )
                      y, (
                        SELECT client_cd
                        FROM T_CLIENT_CLOSING
                        WHERE TRUNC(cre_Dt) BETWEEN ( to_date('$end_date','YYYY-MM-DD') - 32) AND to_date('$end_date','YYYY-MM-DD')
                        AND new_stat = 'C'
                      )
                      c
                    WHERE x.doc_dt  = y.doc_dt
                    AND x.client_cd = y.client_cd
                    AND x.stk_cd    = y.stk_cd
                    AND x.client_Cd = c.client_cd(+)
                  )
                GROUP BY client_cd, client_name,jur, closed
                ORDER BY client_cd";
             * 
             */
             $sql = "SELECT client_cd, client_name, sum_otc_client, sum_otc_repo_jual, sum_otc_repo_beli, jur, closed
                 FROM insistpro_rpt.R_GENERATE_OTC_FEE WHERE RAND_VALUE='$rand_value' and user_id='$user_id' order by client_cd ";
        return $sql;
    }

    public function attributeLabels()
    {
        return array(
            'otc_fee'=>'Biaya OTC',
            'folder_cd'=>'File No.',
            'from_dt'=>'From Date',
            'end_dt'=>'To Date',
            'jur_date'=>'Journal Date',
        );
    }

    public function executeSpJurOTC()
    {
        $connection = Yii::app()->db;

        try
        {
            $query = "CALL SP_DAILY_OTC_JUR(TO_DATE(:P_DATE,'YYYY-MM-DD'),
                                                :P_FOLDER_CD,
                                                :P_USER_ID,
                                                :P_IP_ADDRESS,
                                                :P_ERROR_CODE,
                                                :P_ERROR_MSG)";

            $command = $connection->createCommand($query);
            $command->bindValue(":P_DATE", $this->doc_dt, PDO::PARAM_STR);
            $command->bindValue(":P_FOLDER_CD", $this->folder_cd, PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID", $this->user_id, PDO::PARAM_STR);
            $command->bindValue(":P_IP_ADDRESS", $this->ip_address, PDO::PARAM_STR);
            $command->bindParam(":P_ERROR_CODE", $this->error_code, PDO::PARAM_INT, 10);
            $command->bindParam(":P_ERROR_MSG", $this->error_msg, PDO::PARAM_STR, 200);
            $command->execute();

        }
        catch(Exception $ex)
        {
            if ($this->error_code = -999)
                $this->error_msg = $ex->getMessage();
        }

        if ($this->error_code < 0)
            $this->addError('error_msg', 'Error ' . $this->error_code . ' ' . $this->error_msg);

        return $this->error_code;
    }

}
?>