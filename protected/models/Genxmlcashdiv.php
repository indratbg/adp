<?php

Class Genxmlcashdiv extends Tcashdividen
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    function rules()
    {
       return parent::rules();
    }

    public static function getListCashDiv($distrib_dt)
    {
        $sql = "select stk_cd, sum(div_amt) div_amt 
                from t_cash_dividen                 
                where distrib_dt = to_date('$distrib_dt','yyyy-mm-dd')                
                and  approved_stat = 'A'                   
                group by stk_cd
                order by stk_cd";

        return $sql;
    }
    public static function getXMLCashDiv()
    {
        $sql = "select xml from r_xml where menu_name='TRANSFER TOT CASH DIVIDEN' order by seqno";
        return $sql;    
    }
    
    function attributeLabels()
    {
        return array('distrib_dt'=>'Distribution Date');
    }

    public function executeGenXMLCashDiv()
    {
        $connection = Yii::app()->db;
        $transaction = $connection->beginTransaction();
        try
        {
            $query = "CALL  SP_GENXML_TOTCASHDIV(   :P_INSTRUCTION_TYPE,
                                                    TO_DATE(:P_DISTRIB_DT,'YYYY-MM-DD'),
                                                    :P_USER_ID,
                                                    :P_MENU_NAME,
                                                    :P_ERROR_CODE,
                                                    :P_ERROR_MSG)";

            $command = $connection->createCommand($query);
            $command->bindValue(":P_INSTRUCTION_TYPE", 'WT', PDO::PARAM_STR);
            $command->bindValue(":P_DISTRIB_DT", $this->distrib_dt, PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID", $this->user_id, PDO::PARAM_STR);
            $command->bindValue(":P_MENU_NAME",'TRANSFER TOT CASH DIVIDEN', PDO::PARAM_STR);
            $command->bindParam(":P_ERROR_CODE", $this->error_code, PDO::PARAM_INT, 10);
            $command->bindParam(":P_ERROR_MSG", $this->error_msg, PDO::PARAM_STR, 100);
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
            $this->addError('error_code', 'Error ' . $this->error_code . ' ' . $this->error_msg);
        return $this->error_code;
    }
}
