<?php

/**
 * This is the model class for table "T_EXCH_RATE".
 *
 * The followings are the available columns in table 'T_EXCH_RATE':
 * @property string $exch_dt
 * @property string $curr_cd
 * @property double $rate
 * @property string $cre_dt
 * @property string $user_id
 */
class Texchrate extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $exch_dt_date;
	public $exch_dt_month;
	public $exch_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;
	public $save_flg = 'N';
	public $cancel_flg = 'N';
	public $old_exch_dt;
	public $old_curr_cd;
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
		return 'T_EXCH_RATE';
	}

	public function rules()
	{
		return array(
		
			array('exch_dt,old_exch_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('rate', 'application.components.validator.ANumberSwitcherValidator'),
			array('exch_dt,curr_cd','required'),
			array('rate', 'numerical'),
			array('user_id', 'length', 'max'=>10),
			array('cre_dt,old_curr_cd,old_exch_dt,save_flg, cancel_flg, curr_cd', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('exch_dt, curr_cd, rate, cre_dt, user_id,exch_dt_date,exch_dt_month,exch_dt_year,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
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
			'exch_dt' => 'Exch Date',
			'curr_cd' => 'Curr Code',
			'rate' => 'Rate',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
		);
	}

	public function executeSp($exec_status,$old_exch_dt,$old_curr_cd)
	{
		$connection  = Yii::app()->db;
	
		
		try{
			$query  = "CALL SP_T_EXCH_RATE_UPD(
						
							TO_DATE(:P_SEARCH_EXCH_DT,'YYYY-MM-DD'),
							:P_SEARCH_CURR_CD,
							TO_DATE(:P_EXCH_DT,'YYYY-MM-DD'),
							:P_CURR_CD,
							:P_RATE,
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
			$command->bindValue(":P_SEARCH_EXCH_DT",$old_exch_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_CURR_CD",$old_curr_cd,PDO::PARAM_STR);						
			$command->bindValue(":P_EXCH_DT",$this->exch_dt,PDO::PARAM_STR);			
			$command->bindValue(":P_CURR_CD",$this->curr_cd,PDO::PARAM_STR);
			$command->bindValue(":P_RATE",$this->rate,PDO::PARAM_STR);
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

		if(!empty($this->exch_dt_date))
			$criteria->addCondition("TO_CHAR(t.exch_dt,'DD') LIKE '%".$this->exch_dt_date."%'");
		if(!empty($this->exch_dt_month))
			$criteria->addCondition("TO_CHAR(t.exch_dt,'MM') LIKE '%".$this->exch_dt_month."%'");
		if(!empty($this->exch_dt_year))
			$criteria->addCondition("TO_CHAR(t.exch_dt,'YYYY') LIKE '%".$this->exch_dt_year."%'");		$criteria->compare('curr_cd',$this->curr_cd,true);
		$criteria->compare('rate',$this->rate);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);


		$sort = new CSort();
		$sort->defaultOrder = 'exch_dt';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
		));
	}
}