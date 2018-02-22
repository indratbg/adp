<?php

/**
 * This is the model class for table "MST_IP_BANK".
 *
 * The followings are the available columns in table 'MST_IP_BANK':
 * @property string $bank_cd
 * @property string $bi_code
 * @property string $bank_short_name
 * @property string $bank_name
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_stat
 */
class Ipbank extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	
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
		return 'MST_IP_BANK';
	}

	public function rules()
	{
		return array(
		
			array('approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('bank_cd', 'required'),
			array('bi_code', 'length', 'max'=>7),
			array('bank_short_name', 'length', 'max'=>50),
			array('bank_name', 'length', 'max'=>50),
			array('user_id, upd_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('bank_stat','length','max'=>1),
			array('cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('bank_cd, bi_code, bank_short_name, bank_name, cre_dt, user_id, upd_dt, upd_by, approved_dt, approved_stat,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year,bank_stat', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}
    public function getDropDownName()
    {
        return $this->bank_cd.' - '.$this->bank_name;
    }
	public function attributeLabels()
	{
		return array(
			'bank_cd' => 'Bank Code',
			'bi_code' => 'BI Code',
			'bank_short_name' => 'Bank Short Name',
			'bank_name' => 'Bank Name',
			'cre_dt' => 'Created Date',
			'user_id' => 'User',
			'upd_dt' => 'Update Date',
			'upd_by' => 'Update By',
			'approved_dt' => 'Approved Date',
			'approved_stat' => 'Approved Stat',
			'bank_stat'=>'Bank Status'
		);
	}


    public function executeSp($exec_status,$old_bank_cd)
    {
        $connection  = Yii::app()->db;
        $transaction = $connection->beginTransaction(); 
        
        try{
            $query  = "CALL  SP_MST_IP_BANK_UPD(:P_SEARCH_BANK_CD,
                                            :P_BANK_CD,
                                            :P_BI_CODE,
                                            :P_BANK_SHORT_NAME,
                                            :P_BANK_NAME,
                                            :P_BANK_STAT,
                                            TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
                                            :P_USER_ID,
                                            TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
                                            :P_UPD_BY,
                                            :P_UPD_STATUS,
                                            :P_IP_ADDRESS,
                                            :P_CANCEL_REASON,
                                            :P_ERROR_CODE,
                                            :P_ERROR_MSG)";
            
            $command = $connection->createCommand($query);
            $command->bindValue(":P_SEARCH_BANK_CD",$old_bank_cd,PDO::PARAM_STR);
            $command->bindValue(":P_BANK_CD",$this->bank_cd,PDO::PARAM_STR);
            $command->bindValue(":P_BI_CODE",$this->bi_code,PDO::PARAM_STR);
            $command->bindValue(":P_BANK_SHORT_NAME",$this->bank_short_name,PDO::PARAM_STR);
            $command->bindValue(":P_BANK_NAME",$this->bank_name,PDO::PARAM_STR);
            $command->bindValue(":P_BANK_STAT",$this->bank_stat,PDO::PARAM_STR);
            $command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
            $command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
            $command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
            $command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
            $command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
            $command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
            $command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
            $command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

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
		$criteria->compare('bank_cd',strtoupper($this->bank_cd),true);
		$criteria->compare('bi_code',$this->bi_code,true);
		$criteria->compare('bank_short_name',strtoupper($this->bank_short_name),true);
		$criteria->compare('bank_name',strtoupper($this->bank_name),true);
        $criteria->compare('approved_stat',$this->approved_stat,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('upd_by',$this->upd_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_stat',$this->approved_stat,true);
        
        $sort = new CSort;
        $sort->defaultOrder = 'bank_cd';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}