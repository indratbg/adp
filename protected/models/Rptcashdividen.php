<?php

class Rptcashdividen extends ARptForm
{
    public $distrib_dt;
    public $recording_dt;
    public $stk_cd;
    public $pembagi;
    public $pengali;
    public $price;
    public $end_branch;
    public $bgn_branch;
    public $bgn_client;
    public $end_client;
    public $rate;
    public $bgn_dt;
    public $cum_dt;
    public $rvpv_number;

    //[AH] just create
    public $tempDateCol;

    public function rules()
    {
        return array(
            //array('tc_date','required'),
            array(
                'cum_dt,distrib_dt,recording_dt,bgn_dt',
                'application.components.validator.ADatePickerSwitcherValidatorSP'
            ),
            array(
                'pembagi,pengali,rate,price',
                'application.components.validator.ANumberSwitcherValidator'
            ),
            array(
                'rvpv_number,cum_dt,distrib_dt,recording_dt,stk_cd,pembagi,pengali,price,end_branch,bgn_branch,bgn_client,end_client,rate,end_date',
                'safe'
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'distrib_dt'=>'Payment Date',
            'Recording_dt'=>'Recording Date',
            'stk_cd'=>'Stk Cd',
            'pembagi'=>'Pembagi',
            'pengali'=>'Pengali',
            'price'=>'Price',
            'end_branch'=>'End Branch',
            'bgn_branch'=>'Begin Branch',
            'bgn_client'=>'Begin Client',
            'end_client'=>'End Client',
            'rate'=>'Rate',
            'bgn_dt'=>'Begin Date'
        );
    }

    public static function retrieveData($stk_cd, $distrib_dt, $recording_dt, $cek_pape)
    {
        $recording_dt_query = "";
        $payrech_date_query = "";
        $distrib_dt_query = "";
        if ($distrib_dt)
        {
            $distrib_dt_query = " AND distrib_dt  >= to_date('$distrib_dt','dd/mm/yyyy') ";
            $payrech_date_query = " and payrec_date >= to_date('$distrib_dt','dd/mm/yyyy') ";
        }
        else if ($recording_dt)
        {
            $recording_dt_query = "AND recording_dt =to_date('$recording_dt','dd/mm/yyyy' ";
        }

        $sql = "SELECT a.STK_CD, a.CA_TYPE, a.CUM_DT, a.X_DT, a.RECORDING_DT, a.DISTRIB_DT, a.RATE, b.FROM_QTY, b.TO_QTY,b.price, 
                    c.saved, d.paid, d.payrec_num
                FROM
                  (
                    SELECT STK_CD, CA_TYPE, CUM_DT, X_DT, RECORDING_DT, DISTRIB_DT, FROM_QTY, TO_QTY, RATE
                    FROM T_CORP_ACT
                    WHERE ca_type    = 'CASHDIV'
                    AND (stk_cd      = '$stk_cd' OR '$stk_cd'     ='%')
                    $distrib_dt_query
                    $recording_dt_query
                    AND APPROVED_STAT= 'A'
                  )
                  a, (
                    SELECT STK_CD, CA_TYPE, CUM_DT, X_DT, RECORDING_DT, DISTRIB_DT, FROM_QTY, TO_QTY, RATE AS price
                    FROM T_CORP_ACT
                    WHERE ca_type   = 'STKDIV'
                    AND (stk_cd      = '$stk_cd' OR '$stk_cd'     ='%')
                    $distrib_dt_query
                    $recording_dt_query
                    AND APPROVED_STAT= 'A'
                  )
                  b, (
                    SELECT DISTINCT stk_cd, 'Y' SAVed, distrib_dt
                    FROM ipnextg.T_CASH_DIVIDEN
                    WHERE approved_stat = 'A'
                    $distrib_dt_query
                  )
                  c, (
                    SELECT SUBSTR(client_cd,1,4) stk_cd, payrec_date, 'Y' paid, payrec_num
                    FROM T_PAYRECH
                    WHERE acct_type      = 'DIV'
                    AND approved_sts   = 'A'
                    $payrech_date_query
                  )
                  d
                WHERE a.stk_cd                                    = b.stk_cd(+)
                AND a.cum_dt                                      = b.cum_dt(+)
                AND a.stk_cd                                      = c.stk_cd(+)
                AND a.distrib_dt                                  = c.distrib_dt(+)
                AND a.stk_cd                                      = d.stk_Cd(+)
                AND DECODE('$cek_pape','N',a.distrib_dt,a.CUM_DT) = d.payrec_date(+)
                ORDER BY a.cum_dt DESC, a.stk_cd";

        return $sql;
    }

    public function executeReportGenSp()
    {

        $connection = Yii::app()->dbrpt;
        $transaction = $connection->beginTransaction();

        try
        {
            $query = "CALL SPR_T_CASH_DIVIDEN(	TO_DATE(:P_CUM_DT,'YYYY-MM-DD'),
													TO_DATE(:P_DISTRIB_DT,'YYYY-MM-DD'),
													TO_DATE(:P_RECORDING_DT,'YYYY-MM-DD'),
													:P_STK_CD,
													:P_PEMBAGI,
													:P_PENGALI,
													:P_PRICE,
													:P_END_BRANCH,
													:P_BGN_BRANCH,
													:P_BGN_CLIENT,
													:P_END_CLIENT,
													:P_RATE,
													TO_DATE(:P_END_DT,'YYYY-MM-DD'),
													:P_USER_ID,
													:RVPV_NUMBER,
													TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
													:vo_random_value,
													:vo_errcd,
													:vo_errmsg)";

            $command = $connection->createCommand($query);
            $command->bindValue(":P_CUM_DT", $this->cum_dt, PDO::PARAM_STR);
            $command->bindValue(":P_DISTRIB_DT", $this->distrib_dt, PDO::PARAM_STR);
            $command->bindValue(":P_RECORDING_DT", $this->recording_dt, PDO::PARAM_STR);
            $command->bindValue(":P_STK_CD", $this->stk_cd, PDO::PARAM_STR);
            $command->bindValue(":P_PEMBAGI", $this->pembagi, PDO::PARAM_STR);
            $command->bindValue(":P_PENGALI", $this->pengali, PDO::PARAM_STR);
            $command->bindValue(":P_PRICE", $this->price, PDO::PARAM_STR);
            $command->bindValue(":P_END_BRANCH", $this->end_branch, PDO::PARAM_STR);
            $command->bindValue(":P_BGN_BRANCH", $this->bgn_branch, PDO::PARAM_STR);
            $command->bindValue(":P_BGN_CLIENT", $this->bgn_client, PDO::PARAM_STR);
            $command->bindValue(":P_END_CLIENT", $this->end_client, PDO::PARAM_STR);
            $command->bindValue(":P_RATE", $this->rate, PDO::PARAM_STR);
            $command->bindValue(":P_END_DT", $this->bgn_dt, PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID", $this->vp_userid, PDO::PARAM_STR);
            $command->bindValue(":RVPV_NUMBER", $this->rvpv_number, PDO::PARAM_STR);
            $command->bindValue(":P_GENERATE_DATE", $this->vp_generate_date, PDO::PARAM_STR);
            $command->bindParam(":VO_RANDOM_VALUE", $this->vo_random_value, PDO::PARAM_INT, 10);
            $command->bindParam(":VO_ERRCD", $this->vo_errcd, PDO::PARAM_INT, 10);
            $command->bindParam(":VO_ERRMSG", $this->vo_errmsg, PDO::PARAM_STR, 100);

            $command->execute();
            $transaction->commit();

        }
        catch(Exception $ex)
        {
            $transaction->rollback();
            if ($this->vo_errcd == -999)
            {
                $this->vo_errmsg = $ex->getMessage();
            }
        }

        if ($this->vo_errcd < 0)
            $this->addError('vo_errmsg', 'Error ' . $this->vo_errcd . ' ' . $this->vo_errmsg);

        return $this->vo_errcd;
    }

    public function executeSp()
    {

        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();
        try
        {
            $query = "CALL SP_INSERT_T_CASH_DIVIDEN( :P_USER_ID,
														:P_RAND_VALUE,	
													  :vo_errcd,
													  :vo_errmsg)";

            $command = $connection->createCommand($query);
            $command->bindValue(":P_USER_ID", $this->vp_userid, PDO::PARAM_STR);
            $command->bindValue(":P_RAND_VALUE", $this->vo_random_value, PDO::PARAM_INT, 10);
            $command->bindParam(":VO_ERRCD", $this->vo_errcd, PDO::PARAM_INT, 10);
            $command->bindParam(":VO_ERRMSG", $this->vo_errmsg, PDO::PARAM_STR, 100);
            $command->execute();
            $transaction->commit();
        }
        catch(Exception $ex)
        {
            $transaction->rollback();
            if ($this->vo_errcd == -999)
            {
                $this->vo_errmsg = $ex->getMessage();
            }
        }

        if ($this->vo_errcd < 0)
            $this->addError('vo_errmsg', 'Error ' . $this->vo_errcd . ' ' . $this->vo_errmsg);

        return $this->vo_errcd;
    }

}
