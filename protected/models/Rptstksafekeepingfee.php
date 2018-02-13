<?php

class Rptstksafekeepingfee extends ARptForm
{
    public $from_dt;
    public $to_dt;
    public $client_cd;
    public $client_option;
    public $rpt_type;
    public $bgn_subrek;
    public $end_subrek;
    public $dummy_date;
    public $tempDateCol;
    public $col_name = array(
        'doc_dt'=>'Date',
        'client_cd'=>'Client Code',
        'stk_cd'=>'Stock Code',
        'qty'=>'Quantity',
        'price'=>'Price',
        'stk_value'=>'Stock Value',
        'fee'=>'Fee',
        'client_name'=>'Client Name',
        'subrek'=>'Subrek'
    );
    public $col_name_summary = array(
        'max(client_cd)'=>'Client Code',
        'max(client_name)'=>'Client Name',
        'max(subrek)'=>'Subrek',
        'sum(stk_value)'=>'Stock Value',
        'round(sum(stk_value)*0.005/100/365,2)'=>'Fee'
    );
    public function rules()
    {
        return array(
            //array('tc_date','required'),
            array(
                'from_dt,to_dt',
                'application.components.validator.ADatePickerSwitcherValidatorSP'
            ),

            array(
                'bgn_subrek,end_subrek,vo_random_value,client_cd,client_option,rpt_type',
                'safe'
            ),
        );
    }

    public function attributeLabels()
    {
        return array(
            'from_dt'=>'Date',
            'to_dt'=>'to',
            'client_cd'=>'Client',
            'rpt_type'=>'Report Type',
            'client_option'=>'Client'
        );
    }

    public function executeSPStock($bgn_client, $end_client,$bgn_subrek,$end_subrek, $rpt_type)
    {

        $connection = Yii::app()->dbrpt;
        $transaction = $connection->beginTransaction();
        try
        {
            $query = "CALL SPR_SAFE_KEEPING_FEE(TO_DATE(:P_REPORT_DATE,'YYYY-MM-DD'),
                                                    :P_REPORT_TYPE,
                                                    :P_BGN_CLIENT,
                                                    :P_END_CLIENT,
                                                    :P_BGN_SUBREK,
                                                    :P_END_SUBREK,
                                                    :P_USER_ID,
                                                    :P_RANDOM_VALUE,
                                                    :P_ERROR_CD,
                                                    :P_ERROR_MSG)";

            $command = $connection->createCommand($query);
            $command->bindValue(":P_REPORT_DATE", $this->from_dt, PDO::PARAM_STR);
            $command->bindValue(":P_REPORT_TYPE", $rpt_type, PDO::PARAM_STR);
            $command->bindValue(":P_BGN_CLIENT", $bgn_client, PDO::PARAM_STR);
            $command->bindValue(":P_END_CLIENT", $end_client, PDO::PARAM_STR);
            $command->bindValue(":P_BGN_SUBREK", $bgn_subrek, PDO::PARAM_STR);
            $command->bindValue(":P_END_SUBREK", $end_subrek, PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID", $this->vp_userid, PDO::PARAM_STR);
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
