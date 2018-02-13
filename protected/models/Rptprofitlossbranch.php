<?php

class Rptprofitlossbranch extends ARptForm
{
    public $doc_date;
    public $year;
    public $half_year;
    public $quarter;
    public $branch_option;
    public $branch_cd;
    public $rpt_pres;
    public $month;
    public $dummy_date;
    public $tempDateCol = array();
    public $col_name = array(
        // 'gl_acct_group'=>'GL Code Group',
        // 'gl_acct_group_name'=>'GL Group Name',
         'branch_cd'=>'Branch Code',
        // 'branch_name'=>'Branch Name',
        // 'gl_acct_cd'=>'GL Account',
        // 'gl_acct_name'=>' GL Name',
        // 'sl_acct_cd'=>'SL Code',
        'sl_acct_name'=>'SL Name',
        'mon01'=>'Januari',
        'mon02'=>'Februari',
        'mon03'=>'Maret',
        'mon04'=>'April',
        'mon05'=>'Mei',
        'mon06'=>'Juni',
        'mon07'=>'Juli',
        'mon08'=>'Agustus',
        'mon09'=>'September',
        'mon10'=>'Oktober',
        'mon11'=>'November',
        'mon12'=>'Desember',
        'line_total'=>'Total'
    );
    public $col_name_exp = array(
        'brch_name'=>'Branch Name',
        'sl_acct_name'=>'SL Name',
        'mon01'=>'Januari',
        'mon02'=>'Februari',
        'mon03'=>'Maret',
        'mon04'=>'April',
        'mon05'=>'Mei',
        'mon06'=>'Juni',
        'mon07'=>'Juli',
        'mon08'=>'Agustus',
        'mon09'=>'September',
        'mon10'=>'Oktober',
        'mon11'=>'November',
        'mon12'=>'Desember',
        'line_total'=>'Total'
    );

    public function rules()
    {
        return array(
            array(
                'doc_date',
                'application.components.validator.ADatePickerSwitcherValidatorSP'
            ),
            array(
                'vo_random_value,month,branch_option,branch_cd,year,half_year,quarter,rpt_pres',
                'safe'
            )
        );
    }

    public function attributeLabels()
    {
        return array('end_date'=>'To');
    }

    public function executeRpt($bgn_date, $end_date, $bgn_branch, $end_branch, $criteria, $bgn_mon, $end_mon, $branch_flg, $fixed_income)
    {
        $connection = Yii::app()->dbrpt;
        $transaction = $connection->beginTransaction();

        try
        {
            $query = "CALL  SPR_PROFIT_LOSS_BRANCH(	TO_DATE(:P_BGN_DATE,'YYYY-MM-DD'),
													    TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
													    :P_BGN_BRANCH,
													    :P_END_BRANCH,
													    :P_CRITERIA,
													    :P_BGN_MON,
													    :P_END_MON,
													    :P_BRANCH_FLG,
													    :P_FIXED_INCOME,
													    :P_USER_ID,
													    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
													    :P_RANDOM_VALUE,
													    :P_ERROR_CD,
													    :P_ERROR_MSG)";

            $command = $connection->createCommand($query);
            $command->bindValue(":P_BGN_DATE", $bgn_date, PDO::PARAM_STR);
            $command->bindValue(":P_END_DATE", $end_date, PDO::PARAM_STR);
            $command->bindValue(":P_BGN_BRANCH", $bgn_branch, PDO::PARAM_STR);
            $command->bindValue(":P_END_BRANCH", $end_branch, PDO::PARAM_STR);
            $command->bindValue(":P_CRITERIA", $criteria, PDO::PARAM_STR);
            $command->bindValue(":P_BGN_MON", $bgn_mon, PDO::PARAM_STR);
            $command->bindValue(":P_END_MON", $end_mon, PDO::PARAM_STR);
            $command->bindValue(":P_BRANCH_FLG", $branch_flg, PDO::PARAM_STR);
            $command->bindValue(":P_FIXED_INCOME", $fixed_income, PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID", $this->vp_userid, PDO::PARAM_STR);
            $command->bindValue(":P_GENERATE_DATE", $this->vp_generate_date, PDO::PARAM_STR);
            $command->bindParam(":P_RANDOM_VALUE", $this->vo_random_value, PDO::PARAM_INT, 10);
            $command->bindParam(":P_ERROR_CD", $this->vo_errcd, PDO::PARAM_INT, 10);
            $command->bindParam(":P_ERROR_MSG", $this->vo_errmsg, PDO::PARAM_STR, 200);
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

    public function executeRptDetailExpense($bgn_date, $end_date, $bgn_mon, $end_mon)
    {
        $connection = Yii::app()->dbrpt;
        $transaction = $connection->beginTransaction();

        try
        {
            $query = "CALL  SPR_PROFIT_LOSS_DETAIL_EXP(:P_BGN_DATE,
                                                        :P_END_DATE,
                                                        :P_BGN_MON,
                                                        :P_END_MON,
                                                        :P_USER_ID,
                                                        :P_GENERATE_DATE,
                                                        :P_RANDOM_VALUE,
                                                        :P_ERROR_CODE,
                                                        :P_ERROR_MSG)";

            $command = $connection->createCommand($query);
            $command->bindValue(":P_BGN_DATE", $bgn_date, PDO::PARAM_STR);
            $command->bindValue(":P_END_DATE", $end_date, PDO::PARAM_STR);
            $command->bindValue(":P_BGN_MON", $bgn_mon, PDO::PARAM_STR);
            $command->bindValue(":P_END_MON", $end_mon, PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID", $this->vp_userid, PDO::PARAM_STR);
            $command->bindValue(":P_GENERATE_DATE", $this->vp_generate_date, PDO::PARAM_STR);
            $command->bindParam(":P_RANDOM_VALUE", $this->vo_random_value, PDO::PARAM_INT, 10);
            $command->bindParam(":P_ERROR_CODE", $this->vo_errcd, PDO::PARAM_INT, 10);
            $command->bindParam(":P_ERROR_MSG", $this->vo_errmsg, PDO::PARAM_STR, 200);
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
