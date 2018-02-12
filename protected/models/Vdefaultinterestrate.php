<?php

/**
 * This is the model class for table "V_DEFAULT_INTEREST_RATE".
 *
 * The followings are the available columns in table 'V_DEFAULT_INTEREST_RATE':
 * @property string $client_cd
 * @property string $client_type
 * @property string $brch_cd
 * @property string $brch_name
 * @property double $int_on_receivable
 * @property double $int_on_payable
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_by
 * @property string $upd_dt
 * @property string $approved_by
 */
class Vdefaultinterestrate extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
    public $cl_type;
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
    public function getPrimaryKey()
    {
        return array('client_cd' => $this->client_cd,'eff_dt' => $this->eff_dt);
    }

	public function tableName()
	{
		return 'V_DEFAULT_INTEREST_RATE';
	}

	public function rules()
	{
		return array(
		      array('eff_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('int_on_receivable, int_on_payable', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('eff_dt,brch_cd,cl_type,client_cd,int_on_receivable, int_on_payable', 'required'),
			array('int_on_receivable, int_on_payable', 'numerical'),
			array('client_cd', 'length', 'max'=>12),
			array('client_type', 'length', 'max'=>100),
			array('brch_cd', 'length', 'max'=>2),
			array('brch_name', 'length', 'max'=>30),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('cl_type,cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, client_type, brch_cd, brch_name, int_on_receivable, int_on_payable, cre_dt, user_id, upd_by, upd_dt, approved_by,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'client_cd' => 'Interest Code',
			'client_type' => 'Client Type',
			'brch_cd' => 'Branch Code',
			'brch_name' => 'Branch Name',
			'eff_dt'=>'Effective Date',
			'int_on_receivable' => 'AR%',
			'int_on_payable' => 'AP%',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_by' => 'Upd By',
			'upd_dt' => 'Upd Date',
			'approved_by' => 'Approved By',
		);
	}


    public function executeSp($exec_status,$old_client_cd,$old_eff_dt,$update_date,$update_seq,$record_seq)
    {
        $connection  = Yii::app()->db;
        
        try{
            $query  = "CALL SP_T_INTEREST_RATE_UPD(
                        :P_SEARCH_CLIENT_CD,
                        TO_DATE(:P_SEARCH_EFF_DT,'YYYY-MM-DD'),
                        :P_CLIENT_CD,
                        TO_DATE(:P_EFF_DT,'YYYY-MM-DD'),
                        :P_INT_ON_RECEIVABLE,
                        :P_INT_ON_PAYABLE,
                        TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
                        TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
                        :P_USER_ID,
                        :P_UPD_BY,
                        :P_UPD_STATUS,
                        :P_IP_ADDRESS,
                        :P_CANCEL_REASON,
                        :P_UPDATE_DATE,
                        :P_UPDATE_SEQ,
                        :P_RECORD_SEQ,
                        :P_ERROR_CODE,
                        :P_ERROR_MSG)";
            
            $command = $connection->createCommand($query);
            $command->bindValue(":P_SEARCH_CLIENT_CD",$old_client_cd,PDO::PARAM_STR);
            $command->bindValue(":P_SEARCH_EFF_DT",$old_eff_dt,PDO::PARAM_STR);
            $command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
            $command->bindValue(":P_EFF_DT",$this->eff_dt,PDO::PARAM_STR);
            $command->bindValue(":P_INT_ON_RECEIVABLE",$this->int_on_receivable,PDO::PARAM_STR);
            $command->bindValue(":P_INT_ON_PAYABLE",$this->int_on_payable,PDO::PARAM_STR);
            $command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
            $command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
            $command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
            $command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
            $command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);           
            $command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
            $command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
            $command->bindParam(":P_UPDATE_DATE",$update_date,PDO::PARAM_STR,30);
            $command->bindParam(":P_UPDATE_SEQ",$update_seq,PDO::PARAM_STR,10);
            $command->bindValue(":P_RECORD_SEQ",$record_seq,PDO::PARAM_STR);
            
            $command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
            $command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

            $command->execute();
            
        }catch(Exception $ex){
            if($this->error_code = -999)
                $this->error_msg = $ex->getMessage();
        }
        
        if($this->error_code < 0)
            $this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
        
        return $this->error_code;
    }
	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('client_type',$this->client_type,true);
		$criteria->compare('lower(brch_cd)',strtolower($this->brch_cd),true);
		$criteria->compare('brch_name',$this->brch_name,true);
		$criteria->compare('int_on_receivable',$this->int_on_receivable);
		$criteria->compare('int_on_payable',$this->int_on_payable);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('upd_by',$this->upd_by,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
        $sort = new CSort;
        $sort->defaultOrder='brch_cd,client_cd';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}