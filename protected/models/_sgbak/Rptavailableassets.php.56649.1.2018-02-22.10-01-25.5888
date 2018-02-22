<?php

class Rptavailableassets extends ARptForm
{

    public $end_date;
    public $client_cd;
    public $tempDateCol = array();
    public $col_name = array(
        'acct_name'=>'ACCOUNT NAME',
        'beg_bal'=>'BEGINNING BALANCE',
        'debit'=>'DEBIT',
        'credit'=>'CREDIT',
        'avail_asset'=>'AVAILABLE_FUND'
    );
    public function rules()
    {
        return array(
            array(
                'end_date',
                'application.components.validator.ADatePickerSwitcherValidatorSP'
            ),
            array(
                'vo_random_value,client_cd',
                'safe'
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'client_cd'=>'Client Code',
            'end_date'=>'Date'
        );
    }

    public function executeRpt()
    {

        $connection = Yii::app()->dbrpt;
        $transaction = $connection->beginTransaction();

        try
        {
            $query = "CALL  SPR_AVAILABLE_ASSETS(TO_DATE(:P_REP_DATE,'YYYY-MM-DD'),
                                            :P_USER_ID,
                                            to_date(:P_GENERATE_DATE,'yyyy-mm-dd hh24:mi:ss'),
                                            :P_RAND_VALUE,
                                            :P_ERROR_CODE,
                                            :P_ERROR_MSG)";

            $command = $connection->createCommand($query);
            $command->bindValue(":P_REP_DATE", $this->end_date, PDO::PARAM_STR);
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
