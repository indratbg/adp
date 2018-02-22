<?php

class Gencorpsched extends Tcorpact
{

    public $doc_dt;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array(
                'doc_dt',
                'application.components.validator.ADatePickerSwitcherValidatorSP'
            ),
            array(
                'doc_dt',
                'required'
            ),
            array(
                'ca_type,doc_dt,stk_cd',
                'safe'
            )
        );
    }

    public function attributeLabels()
    {
        return array(
            'doc_dt'=>'Date',
            'stk_cd'=>'Stock Code',
            'ca_type'=>'Corporate Action Type'
        );
    }

    public function executeSpCaJurManual($stk_cd, $ca_type)
    {
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();
        try
        {
            $query = "CALL Sp_Ca_Jur_MANUAL(TO_DATE(:P_DATE,'YYYY-MM-DD'),
                                            :P_STK_CD,
                                            :P_CA_TYPE,
                                            :P_ERROR_CODE,
                                            :P_ERROR_MSG)";

            $command = $connection->createCommand($query);
            $command->bindValue(":P_DATE", $this->doc_dt, PDO::PARAM_STR);
            $command->bindValue(":P_STK_CD", $stk_cd, PDO::PARAM_STR);
            $command->bindValue(":P_CA_TYPE", $ca_type, PDO::PARAM_STR);
            $command->bindParam(":P_ERROR_CODE", $this->error_code, PDO::PARAM_INT, 10);
            $command->bindParam(":P_ERROR_MSG", $this->error_msg, PDO::PARAM_STR, 200);
            $command->execute();
            $transaction->commit();
        }
        catch(Exception $ex)
        {
            $transaction->rollback();
            if ($this->error_code == -999)
            {
                $this->error_msg = $ex->getMessage();
            }
        }

        if ($this->error_code < 0)
            $this->addError('error_msg', 'Error ' . $this->error_code . ' ' . $this->error_msg);

        return $this->error_code;
    }

}
