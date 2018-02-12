<?php

class Rptdailycashflow extends ARptForm
{

    public $end_date;
    public $kategori_flg='A';
    public $tempDateCol = array();
  
    public function rules()
    {
        return array(
            array(
                'end_date',
                'application.components.validator.ADatePickerSwitcherValidatorSP'
            ),
            array(
                'vo_random_value,kategori_flg',
                'safe'
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'kategori_flg'=>'Sembunyikan mutasi yang 0',
            'end_date'=>'Tanggal'
        );
    }

    public function executeRpt()
    {

        $connection = Yii::app()->dbrpt;
        //$connection = Yii::app()->dbrpt_adp;      
        $transaction = $connection->beginTransaction();
       
        try
        {
            $query = "CALL SPR_CASH_FLOW_HARIAN(TO_DATE(:P_REP_DATE,'YYYY-MM-DD'),
                                                :P_USER_ID,
                                                :P_GENERATE_DATE,
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
