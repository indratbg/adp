<?php

/**
 * This is the model class for table "T_REKS_NAB".
 *
 * The followings are the available columns in table 'T_REKS_NAB':
 * @property string $reks_cd
 * @property string $nab_date
 * @property double $nab_unit
 * @property double $nab
 * @property string $user_id
 * @property string $cre_dt
 * @property string $mkbd_dt
 */
class Treksnab extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $nab_date_date;
	public $nab_date_month;
	public $nab_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;
	public $save_flg = 'N';
	public $cancel_flg = 'N';
	
	public $mkbd_dt_date;
	public $mkbd_dt_month;
	public $mkbd_dt_year;
	public $old_reks_cd;
	public $old_mkbd_dt;
	//AH: #END search (datetime || date)  additional comparison
	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	public $hiddenDate;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    

	public function tableName()
	{
		return 'T_REKS_NAB';
	}
	public function executeSp($exec_status,$old_reks_cd,$old_mkbd_dt)
	{
		$connection  = Yii::app()->db;
	
		
		try{
			$query  = "CALL SP_T_REKS_NAB_UPD(
						:P_SEARCH_REKS_CD,
						TO_DATE(:P_SEARCH_MKBD_DT,'YYYY-MM-DD'),
						:P_REKS_CD,
						TO_DATE(:P_NAB_DATE,'YYYY-MM-DD'),
						:P_NAB_UNIT,
						:P_NAB,
						:P_USER_ID,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_MKBD_DT,'YYYY-MM-DD'),
						:P_UPD_BY,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";		
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_REKS_CD",$old_reks_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_MKBD_DT",$old_mkbd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_REKS_CD",$this->reks_cd,PDO::PARAM_STR);
			$command->bindValue(":P_NAB_DATE",$this->nab_date,PDO::PARAM_STR);
			$command->bindValue(":P_NAB_UNIT",$this->nab_unit,PDO::PARAM_STR);
			$command->bindValue(":P_NAB",$this->nab,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_MKBD_DT",$this->mkbd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
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

	public function rules()
	{
		return array(
		
			array('nab_date, mkbd_dt,old_mkbd_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('nab_unit, nab', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('reks_cd,nab_date,nab_unit,nab,mkbd_dt', 'required'),
			array('nab_unit, nab', 'numerical'),
			array('reks_cd', 'length', 'max'=>25),
			array('user_id', 'length', 'max'=>10),
			array('nab_date, cre_dt, mkbd_dt,save_flg,cancel_flg,old_reks_cd,old_mkbd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('reks_cd, nab_date, nab_unit, nab, user_id, cre_dt, mkbd_dt,nab_date_date,nab_date_month,nab_date_year,cre_dt_date,cre_dt_month,cre_dt_year,mkbd_dt_date,mkbd_dt_month,mkbd_dt_year', 'safe', 'on'=>'search'),
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
			'reks_cd' => 'Reks Code',
			'nab_date' => 'Nab Date',
			'nab_unit' => 'Nab Unit',
			'nab' => 'Nab',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'mkbd_dt' => 'Mkbd Date',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('reks_cd',$this->reks_cd,true);

		if(!empty($this->nab_date_date))
			$criteria->addCondition("TO_CHAR(t.nab_date,'DD') LIKE '%".$this->nab_date_date."%'");
		if(!empty($this->nab_date_month))
			$criteria->addCondition("TO_CHAR(t.nab_date,'MM') LIKE '%".$this->nab_date_month."%'");
		if(!empty($this->nab_date_year))
			$criteria->addCondition("TO_CHAR(t.nab_date,'YYYY') LIKE '%".$this->nab_date_year."%'");		$criteria->compare('nab_unit',$this->nab_unit);
		$criteria->compare('nab',$this->nab);
	
		if(!empty($this->mkbd_dt_date))
			$criteria->addCondition("TO_CHAR(t.mkbd_dt,'DD') LIKE '%".$this->mkbd_dt_date."%'");
		if(!empty($this->mkbd_dt_month))
			$criteria->addCondition("TO_CHAR(t.mkbd_dt,'MM') LIKE '%".$this->mkbd_dt_month."%'");
		if(!empty($this->mkbd_dt_year))
			$criteria->addCondition("TO_CHAR(t.mkbd_dt,'YYYY') LIKE '%".$this->mkbd_dt_year."%'");
		
		$sort = new CSort;
		$sort->defaultOrder = 'nab_date DESC, REKS_CD';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}