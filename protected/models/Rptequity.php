<?php

class Rptequity extends ARptForm
{
    
    public $as_per_date;
    public $acct_type;
    public $limit;
    public $client_option;
    public $bgn_client;
    public $end_client;
    public $branch_option;
    public $bgn_branch;
    public $end_branch;
    public $rem_option;
    public $bgn_rem;
    public $end_rem;
    public $dummy_date;
    public $tempDateCol   = array();  
    
    public function rules()
    {
        return array(
            array('as_per_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
            array('limit', 'application.components.validator.ANumberSwitcherValidator'),
            array('bgn_client,end_client,bgn_branch,end_branch,bgn_rem,end_rem,acct_type,limit,client_option,branch_option,rem_option','safe')
        );
    }
    
    public function attributeLabels()
    {
        return array(
            
            
        );
    }
        

    public function executeRpt($price_date,$bgn_acct_type, $end_acct_type, $bgn_client, $end_client, $bgn_branch, $end_branch, $bgn_rem, $end_rem)
    {
     
        $connection  = Yii::app()->dbrpt;
        $transaction = $connection->beginTransaction();
        
        try{
            $query  = "CALL  SPR_EQUITY(TO_DATE(:P_AS_PER_DATE,'YYYY-MM-DD'),
                                        TO_DATE(:P_PRICE_DATE,'YYYY-MM-DD'),    
                                        :P_BGN_ACCT_TYPE,
                                        :P_END_ACCT_TYPE,
                                        :P_LIMIT,
                                        :P_BGN_CLIENT,
                                        :P_END_CLIENT,
                                        :P_BGN_BRANCH,
                                        :P_END_BRANCH,
                                        :P_BGN_REM,
                                        :P_END_REM,
                                        :P_USER_ID,
                                        :P_GENERATE_DATE,
                                        :P_RANDOM_VALUE,
                                        :P_ERROR_CD,
                                        :P_ERROR_MSG)";
                    
            $command = $connection->createCommand($query);
            $command->bindValue(":P_AS_PER_DATE",$this->as_per_date,PDO::PARAM_STR);
            $command->bindValue(":P_PRICE_DATE",$price_date,PDO::PARAM_STR);
            $command->bindValue(":P_BGN_ACCT_TYPE",$bgn_acct_type,PDO::PARAM_STR);
            $command->bindValue(":P_END_ACCT_TYPE",$end_acct_type,PDO::PARAM_STR);
            $command->bindValue(":P_LIMIT",$this->limit,PDO::PARAM_STR);
            $command->bindValue(":P_BGN_CLIENT",$bgn_client,PDO::PARAM_STR);
            $command->bindValue(":P_END_CLIENT",$end_client,PDO::PARAM_STR);
            $command->bindValue(":P_BGN_BRANCH",$bgn_branch,PDO::PARAM_STR);
            $command->bindValue(":P_END_BRANCH",$end_branch,PDO::PARAM_STR);
            $command->bindValue(":P_BGN_REM",$bgn_rem,PDO::PARAM_STR);
            $command->bindValue(":P_END_REM",$end_rem,PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
            $command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
            $command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
            $command->bindParam(":P_ERROR_CD",$this->vo_errcd,PDO::PARAM_INT,10);
            $command->bindParam(":P_ERROR_MSG",$this->vo_errmsg,PDO::PARAM_STR,100);
            $command->execute();
            $transaction->commit();
        }catch(Exception $ex){
            $transaction->rollback();
            if($this->vo_errcd == -999){
                $this->vo_errmsg = $ex->getMessage();
            }
        }
        
        if($this->vo_errcd < 0)
            $this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
        
        return $this->vo_errcd;
    }
    

}
