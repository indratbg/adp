<?php

/**
 * This is the model class for table "T_CLOSE_PRICE".
 *
 * The followings are the available columns in table 'T_CLOSE_PRICE':
 * @property string $stk_date
 * @property string $stk_cd
 * @property string $stk_name
 * @property double $stk_prev
 * @property double $stk_high
 * @property double $stk_low
 * @property double $stk_clos
 * @property double $stk_volm
 * @property double $stk_amt
 * @property double $stk_indx
 * @property double $stk_pidx
 * @property double $stk_askp
 * @property double $stk_askv
 * @property string $stk_askf
 * @property double $stk_bidp
 * @property double $stk_bidv
 * @property string $stk_bidf
 * @property double $stk_open
 */
class Tcloseprice extends AActiveRecord
{
    //AH: #BEGIN search (datetime || date) additional comparison
    public $stk_date_date;
    public $stk_date_month;
    public $stk_date_year;
    public $cancel_reason;
    
    //AH: #END search (datetime || date)  additional comparison
    
    public function __construct($scenario = 'insert')
    {
        parent::__construct($scenario);
        $this->logRecord=true;
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    

    public function tableName()
    {
        return 'T_CLOSE_PRICE';
    }
    
    public function getPrimaryKey()
    {
        return array('stk_date'=>$this->stk_date,'stk_cd'=>$this->stk_cd);  
    }
    public function rules()
    {
        return array(
        
            array('stk_date', 'application.components.validator.ADatePickerSwitcherValidator'),
        
            array('stk_prev, stk_high, stk_low, stk_clos, stk_volm, stk_amt, stk_indx, stk_pidx, stk_askp, stk_askv, stk_bidp, stk_bidv, stk_open', 'application.components.validator.ANumberSwitcherValidator'),
            
            array('stk_prev, stk_high, stk_low, stk_clos, stk_volm, stk_amt, stk_indx, stk_pidx, stk_askp, stk_askv, stk_bidp, stk_bidv, stk_open', 'numerical'),
            //array('stk_volm','test'),
            array('stk_name', 'length', 'max'=>50),
            array('stk_askf, stk_bidf', 'length', 'max'=>5),
            array('stk_cd, isin_code','safe'),
            
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
    
            array('stk_date, stk_cd, stk_name, stk_prev, stk_high, stk_low, stk_clos, stk_volm, stk_amt, stk_indx, stk_pidx, stk_askp, stk_askv, stk_askf, stk_bidp, stk_bidv, stk_bidf, stk_open,stk_date_date,stk_date_month,stk_date_year', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        return array(
            
        );
    }
/*
    public function test(){
        var_dump('test');
        die();
        if ($this->stk_volm== null || $this->stk_volm==''){
             $this->stk_volm = 0;
            
            }
        return  $this->stk_volm;
        
        
    }*/

    
    public function executeSpClosePriceDelete()
    { 
        $connection  = Yii::app()->db;
        $transaction = $connection->beginTransaction(); 
        
        try{
            $query  = "CALL STK_CLOSE_PRICE_DELETE(TO_DATE(:P_STK_DATE,'YYYY-MM-DD'))";
            $command = $connection->createCommand($query);
            $command->bindValue(":P_STK_DATE",$this->stk_date,PDO::PARAM_STR);
            
            $command->execute();
            $transaction->commit();
        }catch(Exception $ex){
            $transaction->rollback();
            if($this->error_code == -999)
                $this->error_msg = $ex->getMessage();
        }
        
        if($this->error_code < 0)
            $this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
        
        return $this->error_code;
    }
    
    
    public function executeSpClosePriceInsert($stk_bidp_zero)
    {
        $connection  = Yii::app()->db;
        $transaction = $connection->beginTransaction(); 
        $p_user_id = Yii::app()->user->id;
        $this->user_id=$p_user_id;
            $this->ip_address = Yii::app()->request->userHostAddress;
                if($this->ip_address=="::1")
                    $this->ip_address = '127.0.0.1';
        //$this->stk_volm=0;
        try{
            
            $query  = "CALL SP_STK_CLOSE_PRICE_INSERT(
                        TO_DATE(:P_STK_DATE,'YYYY-MM-DD'),
                        :P_STK_CD,
                        :P_STK_NAME,
                        :P_STK_PREV,
                        :P_STK_HIGH,
                        :P_STK_LOW,
                        :P_STK_CLOS,
                        :P_STK_VOLM,
                        :P_STK_AMT,
                        :P_STK_INDX,
                        :P_STK_PIDX,
                        :P_STK_ASKP,
                        :P_STK_ASKV,
                        :P_STK_ASKF,
                        :P_STK_BIDP,
                        :P_STK_BIDV,
                        :P_STK_BIDF,
                        :P_STK_OPEN,
                        :P_BIDP_ZERO, 
                        :P_ISIN_CODE,
                        :p_user_id,
                        :p_ip_address, 
                        :p_error_code, 
                        :p_error_msg)";
            $command = $connection->createCommand($query);
            
            $command->bindValue(":P_STK_DATE",$this->stk_date,PDO::PARAM_STR);
            $command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
            $command->bindValue(":P_STK_NAME",$this->stk_name,PDO::PARAM_STR);
            $command->bindValue(":P_STK_PREV",$this->stk_prev,PDO::PARAM_STR);
            $command->bindValue(":P_STK_HIGH",$this->stk_high,PDO::PARAM_STR);
            $command->bindValue(":P_STK_LOW",$this->stk_low,PDO::PARAM_STR);
            $command->bindValue(":P_STK_CLOS",$this->stk_clos,PDO::PARAM_STR);
            $command->bindValue(":P_STK_VOLM",$this->stk_volm,PDO::PARAM_STR);
            $command->bindValue(":P_STK_AMT",$this->stk_amt,PDO::PARAM_STR);
            $command->bindValue(":P_STK_INDX",$this->stk_indx,PDO::PARAM_STR);
            $command->bindValue(":P_STK_PIDX",$this->stk_pidx,PDO::PARAM_STR);
            $command->bindValue(":P_STK_ASKP",$this->stk_askp,PDO::PARAM_STR);
            $command->bindValue(":P_STK_ASKV",$this->stk_askv,PDO::PARAM_STR);
            $command->bindValue(":P_STK_ASKF",$this->stk_askf,PDO::PARAM_STR);
            $command->bindValue(":P_STK_BIDP",$this->stk_bidp,PDO::PARAM_STR);
            $command->bindValue(":P_STK_BIDV",$this->stk_bidv,PDO::PARAM_STR);
            $command->bindValue(":P_STK_BIDF",$this->stk_bidf,PDO::PARAM_STR);
            $command->bindValue(":P_STK_OPEN",$this->stk_open,PDO::PARAM_STR);
            $command->bindValue(":P_BIDP_ZERO",$stk_bidp_zero,PDO::PARAM_STR);
            $command->bindValue(":P_ISIN_CODE",$this->isin_code,PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
            $command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
            $command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
            $command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,4000);
            $command->execute();
            $transaction->commit();
            
        }catch(Exception $ex){
            $transaction->rollback();
            if($this->error_code == -999)
                $this->error_msg = $ex->getMessage();
        }
        
        if($this->error_code < 0)
            $this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
        
        
        return $this->error_code;
    }


    public function attributeLabels()
    {
        return array(
            'stk_date' => 'Stock Date',
            'stk_cd' => 'Stock Code',
            'stk_name' => 'Stock Name',
            'stk_prev' => 'Stock Prev',
            'stk_high' => 'Stock High',
            'stk_low' => 'Stock Low',
            'stk_clos' => 'Stock Clos',
            'stk_volm' => 'Stock Volm',
            'stk_amt' => 'Stock Amt',
            'stk_indx' => 'Stock Indx',
            'stk_pidx' => 'Stock Pidx',
            'stk_askp' => 'Stock Askp',
            'stk_askv' => 'Stock Askv',
            'stk_askf' => 'Stock Askf',
            'stk_bidp' => 'Stock Bidp',
            'stk_bidv' => 'Stock Bidv',
            'stk_bidf' => 'Stock Bidf',
            'stk_open' => 'Stock Open',
        );
    }

public function executeSp($exec_status,$old_stk_date,$old_stk_cd)
    {
        $connection  = Yii::app()->db;
        $transaction = $connection->beginTransaction();
        
        
        try{
            $query  = "CALL   SP_T_CLOSE_PRICE_UPD (TO_DATE(:P_SEARCH_STK_DATE,'YYYY-MM-DD'),
                                                    :P_SEARCH_STK_CD,
                                                    TO_DATE(:P_STK_DATE,'YYYY-MM-DD'),
                                                    :P_STK_CD,
                                                    :P_STK_NAME,
                                                    :P_STK_PREV,
                                                    :P_STK_HIGH,
                                                    :P_STK_LOW,
                                                    :P_STK_CLOS,
                                                    :P_STK_VOLM,
                                                    :P_STK_AMT,
                                                    :P_STK_INDX,
                                                    :P_STK_PIDX,
                                                    :P_STK_ASKP,
                                                    :P_STK_ASKV,
                                                    :P_STK_ASKF,
                                                    :P_STK_BIDP,
                                                    :P_STK_BIDV,
                                                    :P_STK_BIDF,
                                                    :P_STK_OPEN,
                                                    TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
                                                    :P_USER_ID,
                                                    TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
                                                    :P_UPD_BY,
                                                    :P_ISIN_CODE,
                                                    :P_UPD_STATUS,
                                                   :P_IP_ADDRESS,
                                                   :P_CANCEL_REASON,
                                                   :P_ERROR_CODE,
                                                   :P_ERROR_MSG)";
                    
            $command = $connection->createCommand($query);
            $command->bindValue(":P_SEARCH_STK_DATE",$old_stk_date,PDO::PARAM_STR);
            $command->bindValue(":P_SEARCH_STK_CD",$old_stk_cd,PDO::PARAM_STR);
            $command->bindValue(":P_STK_DATE",$this->stk_date,PDO::PARAM_STR);
            $command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
            $command->bindValue(":P_STK_NAME",$this->stk_name,PDO::PARAM_STR);
            $command->bindValue(":P_STK_PREV",$this->stk_prev,PDO::PARAM_STR);
            $command->bindValue(":P_STK_HIGH",$this->stk_high,PDO::PARAM_STR);
            $command->bindValue(":P_STK_LOW",$this->stk_low,PDO::PARAM_STR);
            $command->bindValue(":P_STK_CLOS",$this->stk_clos,PDO::PARAM_STR);
            $command->bindValue(":P_STK_VOLM",$this->stk_volm,PDO::PARAM_STR);
            $command->bindValue(":P_STK_AMT",$this->stk_amt,PDO::PARAM_STR);
            $command->bindValue(":P_STK_INDX",$this->stk_indx,PDO::PARAM_STR);
            $command->bindValue(":P_STK_PIDX",$this->stk_pidx,PDO::PARAM_STR);
            $command->bindValue(":P_STK_ASKP",$this->stk_askp,PDO::PARAM_STR);
            $command->bindValue(":P_STK_ASKV",$this->stk_askv,PDO::PARAM_STR);
            $command->bindValue(":P_STK_ASKF",$this->stk_askf,PDO::PARAM_STR);
            $command->bindValue(":P_STK_BIDP",$this->stk_bidp,PDO::PARAM_STR);
            $command->bindValue(":P_STK_BIDV",$this->stk_bidv,PDO::PARAM_STR);
            $command->bindValue(":P_STK_BIDF",$this->stk_bidf,PDO::PARAM_STR);
            $command->bindValue(":P_STK_OPEN",$this->stk_open,PDO::PARAM_STR);
            $command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
            $command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
            $command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
            $command->bindValue(":P_ISIN_CODE",$this->isin_code,PDO::PARAM_STR);
            $command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
            $command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
            $command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);            
            $command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
            $command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,100);
            
            $command->execute();
            $transaction->commit();
        }catch(Exception $ex){
            $transaction->rollback();
            if($this->error_code == -999)
                $this->error_msg = $ex->getMessage();
        }
        
        if($this->error_code < 0)
            $this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
        
        
        return $this->error_code;
    }
    public function search()
    {
        $criteria = new CDbCriteria;
        $default_date = AConstant::getDocDate(1, date('Y-m-d'));
        if(empty($this->stk_date))
        {
            $criteria->addCondition("stk_date >= to_date('$default_date','yyyy-mm-dd') and approved_stat='A' ");    
        }else{
            $criteria->addCondition("stk_date = to_date('$this->stk_date','dd/mm/yyyy') and approved_stat='A' ");    
        }
        $criteria->compare('lower(stk_cd)',strtolower($this->stk_cd),true);
        $criteria->compare('stk_name',$this->stk_name,true);
        $criteria->compare('stk_prev',$this->stk_prev);
        $criteria->compare('stk_high',$this->stk_high);
        $criteria->compare('stk_low',$this->stk_low);
        $criteria->compare('stk_clos',$this->stk_clos);
        $criteria->compare('stk_volm',$this->stk_volm);
        $criteria->compare('stk_amt',$this->stk_amt);
        $criteria->compare('stk_indx',$this->stk_indx);
        $criteria->compare('stk_pidx',$this->stk_pidx);
        $criteria->compare('stk_askp',$this->stk_askp);
        $criteria->compare('stk_askv',$this->stk_askv);
        $criteria->compare('stk_askf',$this->stk_askf,true);
        $criteria->compare('stk_bidp',$this->stk_bidp);
        $criteria->compare('stk_bidv',$this->stk_bidv);
        $criteria->compare('stk_bidf',$this->stk_bidf,true);
        $criteria->compare('stk_open',$this->stk_open);
        $criteria->compare('approved_stat',$this->approved_stat);
        $sort = new CSort;
        $sort->defaultOrder='stk_date desc,stk_cd';
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>$sort
        ));
    }
}