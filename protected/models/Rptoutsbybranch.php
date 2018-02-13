<?php

class Rptoutsbybranch extends ARptForm
{
    public $end_date;
    public $branch_cd;
    public $rem_cd;

    public $dummy_date;
    public $tempDateCol = array();
    public $col_name = array(
        'client_cd'=>'CLIENT_CD',
        'client_name'=>'CLIENT_NAME',
        'rem_cd'=>'REM_CD',
        'rem_name'=>'REM_NAME',
        'branch_cd'=>'BRANCH_CD',
        'branch_name'=>'BRANCH_NAME',
        'outs_amt'=>'OUTS_AMT'
    );
    public function rules()
    {
        return array(
            array(
                'end_date',
                'application.components.validator.ADatePickerSwitcherValidatorSP'
            ),
            array(
                'vo_random_value,branch_cd,rem_cd',
                'safe'
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'branch_cd'=>'Branch',
            'rem_cd'=>'Sales',
            'end_date'=>'Date'
        );
    }

    public function executeRpt($bgn_branch, $end_branch, $bgn_rem, $end_rem)
    {

        $connection = Yii::app()->dbrpt;
        $transaction = $connection->beginTransaction();

        try
        {
            $query = "CALL SPR_OUTS_BY_BRANCH(TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
                                            :P_BGN_BRANCH,
                                            :P_END_BRANCH,
                                            :P_BGN_REM_CD,
                                            :P_END_REM_CD,
                                            :P_USER_ID,
                                            :P_GENERATE_DATE,
                                            :P_RAND_VALUE,
                                            :P_ERROR_CODE,
                                            :P_ERROR_MSG)";

            $command = $connection->createCommand($query);
            $command->bindValue(":P_END_DATE", $this->end_date, PDO::PARAM_STR);
            $command->bindValue(":P_BGN_BRANCH", $bgn_branch, PDO::PARAM_STR);
            $command->bindValue(":P_END_BRANCH", $end_branch, PDO::PARAM_STR);
            $command->bindValue(":P_BGN_REM_CD", $bgn_rem, PDO::PARAM_STR);
            $command->bindValue(":P_END_REM_CD", $end_rem, PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID", $this->vp_userid, PDO::PARAM_STR);
            $command->bindValue(":P_GENERATE_DATE", $this->vp_generate_date, PDO::PARAM_STR);
            $command->bindParam(":P_RAND_VALUE", $this->vo_random_value, PDO::PARAM_INT, 10);
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
