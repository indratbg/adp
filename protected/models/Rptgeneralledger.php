<?php

class Rptgeneralledger extends ARptForm
{
    public $month;
    public $year;
    public $bgn_date;
    public $end_date;
    public $report_mode;
    public $cancel_flg;
    public $branch_cd;
    public $branch_option;
    public $from_gla;
    public $to_gla;
    public $from_sla;
    public $to_sla;
    public $dummy_date;
    public $col_name = array(
     //   'seqno'=>'Seqno',
        'tgl_acct_cd'=>'GL Code',
        'tsl_acct_cd'=>'SL Code',
        'acct_name'=>'Acct Name',
        'doc_num'=>'Doc Num',
        'folder_cd'=>'Folder Code',
        'doc_date'=>'Doc Date',
        'ledger_nar'=>'Description',
        'beg_bal'=>'Begin Balance',
        'debit'=>'Debit',
        'credit'=>'Credit',
        'cum_bal'=>'Balance'
    );
    public $col_name_acct = array(
        'doc_date'=>'Doc Date',
        'gl_acct_cd'=>'GL Code',
        'debit'=>'Debit',
        'credit'=>'Credit',
        'cum_bal'=>'Balance'
    );
    public $tempDateCol = array();

    public function rules()
    {
        return array(
            array(
                'bgn_date,end_date',
                'application.components.validator.ADatePickerSwitcherValidatorSP'
            ),
            array(
                'vo_random_value,month,year,report_mode,cancel_flg,branch_cd,branch_option,from_gla,to_gla,from_sla,to_sla',
                'safe'
            )
        );
    }

    public function attributeLabels()
    {
        return array();
    }

    public function executeRpt($bgn_acct, $end_acct, $bgn_sub, $end_sub, $branch_cd, $mode, $reversal_flg)
    {

        $connection = Yii::app()->dbrpt;
        $transaction = $connection->beginTransaction();

        try
        {
            $query = "CALL  SPR_GENERAL_LEDGER(to_date(:dt_bgn_date,'YYYY-MM-DD'),
											    TO_DATE(:dt_end_date,'YYYY-MM-DD'),
											    :as_bgn_acct,
											    :as_end_acct,
											    :as_bgn_sub ,
											    :as_end_sub,
											    :as_bgn_branch,
											    :as_reversal,
											    :P_MODE,
											    :P_USER_ID,
											    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
											    :P_RANDOM_VALUE,
											    :P_ERROR_CD,
											    :P_ERROR_MSG)";

            $command = $connection->createCommand($query);
            $command->bindValue(":dt_bgn_date", $this->bgn_date, PDO::PARAM_STR);
            $command->bindValue(":dt_end_date", $this->end_date, PDO::PARAM_STR);
            $command->bindValue(":as_bgn_acct", $bgn_acct, PDO::PARAM_STR);
            $command->bindValue(":as_end_acct", $end_acct, PDO::PARAM_STR);
            $command->bindValue(":as_bgn_sub", $bgn_sub, PDO::PARAM_STR);
            $command->bindValue(":as_end_sub", $end_sub, PDO::PARAM_STR);
            $command->bindValue(":as_bgn_branch", $branch_cd, PDO::PARAM_STR);
            $command->bindValue(":as_reversal", $reversal_flg, PDO::PARAM_STR);
            $command->bindValue(":P_MODE", $mode, PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID", $this->vp_userid, PDO::PARAM_STR);
            $command->bindValue(":P_GENERATE_DATE", $this->vp_generate_date, PDO::PARAM_STR);
            $command->bindParam(":P_RANDOM_VALUE", $this->vo_random_value, PDO::PARAM_INT, 10);
            $command->bindParam(":P_ERROR_CD", $this->vo_errcd, PDO::PARAM_INT, 10);
            $command->bindParam(":P_ERROR_MSG", $this->vo_errmsg, PDO::PARAM_STR, 100);

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
