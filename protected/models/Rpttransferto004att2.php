<?php
class Rpttransferto004att2 extends ARptForm
{
    public $trx_date;
    public $due_date;
    public $price_date;
    public $tempDateCol = array();
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array( array(
                'trx_date,due_date,price_date',
                'application.components.validator.ADatePickerSwitcherValidatorSP'
            ));
    }

    public function attributeLabels()
    {
        return array(
            'trx_date'=>'Trx Date',
            'due_date'=>'Due Date',
            'price_date'=>'Price Date'
        );
    }

    public static function getPriceDate()
    {
        $sql = "select max(stk_date)stk_date from t_close_price where approved_stat='A' ";
        $exec = DAO::queryRowSql($sql);
        if (DateTime::createFromFormat('Y-m-d H:i:s', $exec['stk_date']))
            $exec['stk_date'] = DateTime::createFromFormat('Y-m-d H:i:s', $exec['stk_date'])->format('d/m/Y');
        return $exec['stk_date'];
    }

    public function executeSpRpt()
    {
        $connection = Yii::app()->dbrpt;
        $transaction = $connection->beginTransaction();

        try
        {
            $query = "CALL SPR_TRANSFER_TO_004_AT_002(  TO_DATE(:P_TRX_DATE,'YYYY-MM-DD'),
                                                        TO_DATE(:P_DUE_DATE,'YYYY-MM-DD'),
                                                        TO_DATE(:P_PRICE_DATE,'YYYY-MM-DD'),
                                                        :P_USER_ID,
                                                        :P_GENERATE_DATE,
                                                        :P_RANDOM_VALUE,
                                                        :P_ERROR_CD,
                                                        :P_vo_errmsg)";

            $command = $connection->createCommand($query);
            $command->bindValue(":P_TRX_DATE", $this->trx_date, PDO::PARAM_STR);
            $command->bindValue(":P_DUE_DATE", $this->due_date, PDO::PARAM_STR);
            $command->bindValue(":P_PRICE_DATE", $this->price_date, PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID", $this->vp_userid, PDO::PARAM_STR);
            $command->bindValue(":P_GENERATE_DATE", $this->vp_generate_date, PDO::PARAM_STR);
            $command->bindParam(":P_RANDOM_VALUE", $this->vo_random_value, PDO::PARAM_INT, 10);
            $command->bindParam(":P_ERROR_CD", $this->vo_errcd, PDO::PARAM_INT, 10);
            $command->bindParam(":P_vo_errmsg", $this->vo_errmsg, PDO::PARAM_STR, 100);
            $command->execute();
            $transaction->commit();
            //Commit baru akan dijalankan saat semua transaksi INSERT sukses
        }
        catch(Exception $ex)
        {
            if ($this->vo_errcd = -999)
            {
                $transaction->rollback();
                $this->vo_errmsg = $ex->getMessage();
            }

        }

        if ($this->vo_errcd < 0)
            $this->addError('vo_errmsg', 'Error ' . $this->vo_errcd . ' ' . $this->vo_errmsg);

        return $this->vo_errcd;
    }
 public function executeSpTransferto004()
    {
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();

        try
        {
            $query = "CALL SP_TRF_STK_T2(  TO_DATE(:P_TRX_DATE,'YYYY-MM-DD'),
                                            TO_DATE(:P_DUE_DATE,'YYYY-MM-DD'),
                                            :P_USER_ID,
                                            :P_ERROR_CODE,
                                            :P_ERROR_MSG)";

            $command = $connection->createCommand($query);
            $command->bindValue(":P_TRX_DATE", $this->trx_date, PDO::PARAM_STR);
            $command->bindValue(":P_DUE_DATE", $this->due_date, PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID", $this->vp_userid, PDO::PARAM_STR);
            $command->bindParam(":P_ERROR_CODE", $this->vo_errcd, PDO::PARAM_INT, 10);
            $command->bindParam(":P_ERROR_MSG", $this->vo_errmsg, PDO::PARAM_STR, 100);
            $command->execute();
            $transaction->commit();
            //Commit baru akan dijalankan saat semua transaksi INSERT sukses
        }
        catch(Exception $ex)
        {
            if ($this->vo_errcd = -999)
            {
                $transaction->rollback();
                $this->vo_errmsg = $ex->getMessage();
            }

        }

        if ($this->vo_errcd < 0)
            $this->addError('vo_errmsg', 'Error ' . $this->vo_errcd . ' ' . $this->vo_errmsg);

        return $this->vo_errcd;
    }

}
?>