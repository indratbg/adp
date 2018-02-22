<?php
class Postingintselected extends Tinterest
{
    
 public $old_ic_num;
 public $int_on_receivable;
 public $int_on_payable;
 public $amt;
 public $jurnal_sts;
 public $journal_date;
    
public static function model($className=__CLASS__)
{
    return parent::model($className);
}

public function rules()
{
    return array_merge(
    array(
    array('journal_date,old_ic_num, int_on_receivable, int_on_payable, amt, jurnal_sts','safe')
    ),parent::rules()); 
}
public static function GetListInterest($bgn_date,$end_date,$branch_cd)
{
    $sql = "SELECT A.BRANCH_CODE, A.CLIENT_CD, A.CLIENT_NAME, A.OLD_IC_NUM, SUBSTR(TRIM(OLD_IC_NUM), 
            DECODE(LENGTH(TRIM(OLD_IC_NUM)),5,2,3),4) SORTK, A.AMT, D.EFF_DT, D.INT_ON_RECEIVABLE, 
            D.INT_ON_PAYABLE, A.APPROVED_STS, A.APPROVED_STS AS JURNAL_STS
            FROM
              (
                SELECT B.CLIENT_CD, MC.BRANCH_CODE, MC.CLIENT_NAME, MC.OLD_IC_NUM, B.AMT, B.APPROVED_STS
                FROM
                  (
                    SELECT CLIENT_CD, MAX(POST_FLG) APPROVED_STS, SUM(INT_AMT - NVL(POSTED_INT,0)) * -1 AMT
                    FROM T_INTEREST T
                    WHERE T.INT_DT BETWEEN '$bgn_date' AND '$end_date'
                    AND T.POST_FLG <> 'E'
                    GROUP BY T.CLIENT_CD
                  )
                  B, MST_CLIENT MC
                WHERE B.CLIENT_CD           = MC.CLIENT_CD
                AND NVL(MC.AMT_INT_FLG,'Y') = 'Y'
                AND MC.SUSP_STAT            = 'N'
                AND TRIM(MC.BRANCH_CODE) LIKE '$branch_cd'
                AND B.AMT <> 0
              )
              A, (
                SELECT R.CLIENT_CD, R.EFF_DT, R.INT_ON_RECEIVABLE, R.INT_ON_PAYABLE
                FROM
                  (
                    SELECT CLIENT_CD, MAX(EFF_DT) EFF_DT
                    FROM T_INTEREST_RATE
                    WHERE EFF_DT <= '$end_date'
                    GROUP BY CLIENT_CD
                  )
                  S, T_INTEREST_RATE R
                WHERE R.CLIENT_CD = S.CLIENT_CD
                AND R.EFF_DT      = S.EFF_DT
              )
              D
            WHERE A.CLIENT_CD = D.CLIENT_CD
            order by 2";
            
    return $sql;
}


    public function executeSpPostingInt($bgn_client,$end_client,$bgn_branch, $month_end)
    {
        $connection  = Yii::app()->db;
        $transaction = $connection->beginTransaction(); 
        try{
            $query  = "CALL  SP_POSTING_INTEREST(to_date(:p_date,'yyyy-mm-dd'),
                                                  :p_bgn_client,
                                                  :p_end_client,
                                                  to_date(:p_bgn_date,'yyyy-mm-dd'),
                                                  to_date(:p_end_date,'yyyy-mm-dd'),
                                                  :p_brch_cd,
                                                  :p_month_end,
                                                  :p_user_id,
                                                  :P_IP_ADDRESS,
                                                  :P_ERROR_CD,
                                                  :P_ERROR_MSG)";
        
            $command = $connection->createCommand($query);
            $command->bindValue(":p_date",$this->journal_date,PDO::PARAM_STR);
            $command->bindValue(":p_bgn_client",$bgn_client,PDO::PARAM_STR);
            $command->bindValue(":p_end_client",$end_client,PDO::PARAM_STR);
            $command->bindValue(":p_bgn_date",$this->int_dt_from,PDO::PARAM_STR);
            $command->bindValue(":p_end_date",$this->int_dt_to,PDO::PARAM_STR);
            $command->bindValue(":p_brch_cd",$bgn_branch,PDO::PARAM_STR);
            $command->bindValue(":p_month_end",$month_end,PDO::PARAM_STR);
            $command->bindValue(":p_user_id",$this->user_id,PDO::PARAM_STR);
            $command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
            $command->bindParam(":P_ERROR_CD",$this->error_code,PDO::PARAM_INT,10);
            $command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,200);
            $command->execute();
            $transaction->commit();
        }catch(Exception $ex){
            $transaction->rollback();
            if($this->error_code == -999)
                $this->error_msg = $ex->getMessage();
        }
        
        if($this->error_code < 0)
            $this->addError('error_code', 'Error '.$this->error_code.' '.$this->error_msg);
        
        return $this->error_code;
    }
}

?>