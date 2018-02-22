<?php

/**
 * This is the model class for table "T_CHANGE_STK_CD".
 *
 * The followings are the available columns in table 'T_CHANGE_STK_CD':
 * @property string $stk_cd_old
 * @property string $stk_cd_new
 * @property string $eff_dt
 * @property string $run_dt
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Tchangestkcd extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $eff_dt_date;
	public $eff_dt_month;
	public $eff_dt_year;

	public $run_dt_date;
	public $run_dt_month;
	public $run_dt_year;

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
		return 'T_CHANGE_STK_CD';
	}

	public function rules()
	{
		return array(
		
			array('eff_dt, run_dt, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('stk_cd_old','required'),
			array('stk_cd_new', 'length', 'max'=>25),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('eff_dt, run_dt, cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('stk_cd_old, stk_cd_new, eff_dt, run_dt, cre_dt, user_id, upd_dt, upd_by, approved_dt, approved_by, approved_stat,eff_dt_date,eff_dt_month,eff_dt_year,run_dt_date,run_dt_month,run_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'stk_cd_old' => 'Old Stock Code',
			'stk_cd_new' => 'New Stock Code',
			'eff_dt' => 'Effective Date',
			'run_dt' => 'Run Date',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
		);
	}

	public function executeSp($exec_status,$stk_cd_old)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_T_CHANGE_STK_CD_UPD(
						:P_SEARCH_STK_CD_OLD,:P_STK_CD_OLD,:P_STK_CD_NEW,TO_DATE(:P_EFF_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_RUN_DT,'YYYY-MM-DD HH24:MI:SS'),TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),:P_UPD_BY,:P_UPD_STATUS,:P_IP_ADDRESS,
						:P_CANCEL_REASON,:P_ERROR_CODE,:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_SEARCH_STK_CD_OLD",$stk_cd_old,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD_OLD",$this->stk_cd_old,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD_NEW",$this->stk_cd_new,PDO::PARAM_STR);
			$command->bindValue(":P_EFF_DT",$this->eff_dt,PDO::PARAM_STR);
			$command->bindValue(":P_RUN_DT",$this->run_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
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

	public function executeSpChangeTicker()
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_T_CHANGE_STK_CD_UPD(
						:P_USER_ID,:P_ERROR_CODE,:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			
			//$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			//$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,200);

			$command->execute();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
			//if($this->error_code == -999)
				//$this->error_msg = $ex->getMessage();
		}
		
		//if($this->error_code < 0)
			//$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		$this->error_code = 1;
		return $this->error_code;
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition("UPPER(stk_cd_old) LIKE UPPER('".$this->stk_cd_old."%')");
		if(!empty($this->stk_cd_new))
			$criteria->addCondition("UPPER(stk_cd_new) LIKE UPPER('%".$this->stk_cd_new."%')");

		if(!empty($this->eff_dt_date))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'DD') LIKE '%".$this->eff_dt_date."%'");
		if(!empty($this->eff_dt_month))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'MM') LIKE '%".$this->eff_dt_month."%'");
		if(!empty($this->eff_dt_year))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'YYYY') LIKE '%".$this->eff_dt_year."%'");
		if(!empty($this->run_dt_date))
			$criteria->addCondition("TO_CHAR(t.run_dt,'DD') LIKE '%".$this->run_dt_date."%'");
		if(!empty($this->run_dt_month))
			$criteria->addCondition("TO_CHAR(t.run_dt,'MM') LIKE '%".$this->run_dt_month."%'");
		if(!empty($this->run_dt_year))
			$criteria->addCondition("TO_CHAR(t.run_dt,'YYYY') LIKE '%".$this->run_dt_year."%'");
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
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat','A',true);

		$sort = new CSort;
		
		$sort->defaultOrder='eff_dt desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}