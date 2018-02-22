<?php

class Rptsalesperformance extends ARptForm
{
    public $month;
    public $year;
    public $bgn_date;
    public $end_date;
    public $contract_option;
    public $contract_type;
    public $branch_option;
    public $branch_cd;
    public $rem_option;
    public $rem_cd;
    public $rpt_type;
    public $dummy_date;
    public $tempDateCol = array();
    public $col_name = array(
        'brch_cd'=>'Branch Code',
        'brch_name'=>'Branch Name',
        'contract_type'=>'Contract Type',
        'rem_cd'=>'Sales Code',
        'rem_name'=>'Sales Name',
        'client_cd'=>'Client Code',
        'client_name'=>'Client Name',
        'commission_per'=>'Commission per',
        'val'=>'Transaction',
        'brok'=>'Total Fee',
        'commission'=>'Net Commision',
        'amt_for_curr'=>'Total Transaction'
    );
    public function rules()
    {
        return array(
            array(
                'bgn_date,end_date',
                'application.components.validator.ADatePickerSwitcherValidatorSP'
            ),
            array(
                'bgn_date',
                'checkBeginDate'
            ),
            array(
                'vo_random_value,contract_option,month,year,contract_type,branch_option,branch_cd,rpt_type,rem_option,rem_cd',
                'safe'
            )
        );
    }

    public function attributeLabels()
    {
        return array('end_date'=>'To');
    }

    public function checkBeginDate()
    {
        $cek = Sysparam::model()->find("PARAM_ID='PERFORMANCE REPORT' and param_cd1='CLIENT' AND PARAM_CD2='START' ")->ddate1;
        if (strtotime($this->bgn_date) < strtotime($cek))
        {
            if (DateTime::createFromFormat('Y-m-d H:i:s', $cek))
                $cek = DateTime::createFromFormat('Y-m-d H:i:s', $cek)->format('d-M-Y');
            $this->addError('bgn_date', 'From Date harus lebih besar dari ' . $cek);
        }

    }

    public function executeRpt($bgn_branch, $end_branch, $bgn_ctr_type, $end_ctr_type, $bgn_rem_cd, $end_rem_cd, $rpt_mode)
    {
        $connection = Yii::app()->dbrpt;
        $transaction = $connection->beginTransaction();

        try
        {
            $query = "CALL  SPR_PERFORMANCE_SALES(TO_DATE(:P_BGN_DATE,'YYYY-MM-DD'),
												    TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
												    :P_BGN_BRANCH,
												    :P_END_BRANCH,
												    :P_BGN_CTR_TYPE,
												    :P_END_CTR_TYPE,
												    :P_BGN_REM,
												    :P_END_REM,
												    :P_REPORT_MODE,
												    :P_USER_ID,
												    TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
												    :P_RANDOM_VALUE,
												    :P_ERROR_CD,
												    :P_ERROR_MSG)";

            $command = $connection->createCommand($query);
            $command->bindValue(":P_BGN_DATE", $this->bgn_date, PDO::PARAM_STR);
            $command->bindValue(":P_END_DATE", $this->end_date, PDO::PARAM_STR);
            $command->bindValue(":P_BGN_BRANCH", $bgn_branch, PDO::PARAM_STR);
            $command->bindValue(":P_END_BRANCH", $end_branch, PDO::PARAM_STR);
            $command->bindValue(":P_BGN_CTR_TYPE", $bgn_ctr_type, PDO::PARAM_STR);
            $command->bindValue(":P_END_CTR_TYPE", $end_ctr_type, PDO::PARAM_STR);
            $command->bindValue(":P_BGN_REM", $bgn_rem_cd, PDO::PARAM_STR);
            $command->bindValue(":P_END_REM", $end_rem_cd, PDO::PARAM_STR);
            $command->bindValue(":P_REPORT_MODE", $rpt_mode, PDO::PARAM_STR);
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

}
