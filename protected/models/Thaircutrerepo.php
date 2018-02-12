<?php

/**
 * This is the model class for table "T_HAIRCUT_REREPO".
 *
 * The followings are the available columns in table 'T_HAIRCUT_REREPO':
 * @property string $from_dt
 * @property string $to_dt
 * @property string $stk_cd
 * @property integer $haircut
 * @property string $cre_dt
 * @property string $user_id
 */
class Thaircutrerepo extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $from_dt_date;
	public $from_dt_month;
	public $from_dt_year;

	public $to_dt_date;
	public $to_dt_month;
	public $to_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;
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
		return 'T_HAIRCUT_REREPO';
	}
	
	public function executeSp($exec_status,$old_from_dt,$old_stk_cd)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_T_HAIRCUT_REREPO_UPD(
						TO_DATE(:P_SEARCH_FROM_DT,'YYYY-MM-DD'),
						:P_SEARCH_STK_CD,
						TO_DATE(:P_FROM_DT,'YYYY-MM-DD'),
						TO_DATE(:P_TO_DT,'YYYY-MM-DD'),
						:P_STK_CD,
						:P_HAIRCUT,
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
			$command->bindValue(":P_SEARCH_FROM_DT",$old_from_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_STK_CD",$old_stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_FROM_DT",$this->from_dt,PDO::PARAM_STR);
			$command->bindValue(":P_TO_DT",$this->to_dt,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_HAIRCUT",$this->haircut,PDO::PARAM_STR);
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
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

	public function rules()
	{
		return array(
		
			array('from_dt, to_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('haircut', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('from_dt, to_dt, haircut', 'required'),
			array('haircut', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>10),
			array('stk_cd, cre_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('from_dt, to_dt, stk_cd, haircut, cre_dt, user_id,from_dt_date,from_dt_month,from_dt_year,to_dt_date,to_dt_month,to_dt_year,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
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
			'from_dt' => 'From Date',
			'to_dt' => 'To Date',
			'stk_cd' => 'Stock Code',
			'haircut' => 'Haircut',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->from_dt_date))
			$criteria->addCondition("TO_CHAR(t.from_dt,'DD') LIKE '%".$this->from_dt_date."%'");
		if(!empty($this->from_dt_month))
			$criteria->addCondition("TO_CHAR(t.from_dt,'MM') LIKE '%".$this->from_dt_month."%'");
		if(!empty($this->from_dt_year))
			$criteria->addCondition("TO_CHAR(t.from_dt,'YYYY') LIKE '%".$this->from_dt_year."%'");
		if(!empty($this->to_dt_date))
			$criteria->addCondition("TO_CHAR(t.to_dt,'DD') LIKE '%".$this->to_dt_date."%'");
		if(!empty($this->to_dt_month))
			$criteria->addCondition("TO_CHAR(t.to_dt,'MM') LIKE '%".$this->to_dt_month."%'");
		if(!empty($this->to_dt_year))
			$criteria->addCondition("TO_CHAR(t.to_dt,'YYYY') LIKE '%".$this->to_dt_year."%'");		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('haircut',$this->haircut);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('approved_sts',$this->approved_stat,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}