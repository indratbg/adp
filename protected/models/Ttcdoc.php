<?php

/**
 * This is the model class for table "T_TC_DOC".
 *
 * The followings are the available columns in table 'T_TC_DOC':
 * @property string $tc_id
 * @property string $tc_date
 * @property integer $tc_status
 * @property integer $tc_rev
 * @property string $client_cd
 * @property string $client_name
 * @property string $brch_cd
 * @property string $rem_cd
 * @property string $tc_doc
 * @property string $cre_dt
 * @property string $cre_by
 */
class Ttcdoc extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $tc_date_date;
	public $tc_date_month;
	public $tc_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $upload_file;
	public $client_type;
	public $market_type;
	
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
		return 'T_TC_DOC';
	}
	
	public function executeSp($mode,$type)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_GEN_TRADING_REF(
						TO_DATE(:P_TRX_DATE,'YYYY-MM-DD'),
						:P_CLIENT_CD,
						:P_MODE,
						:P_TC_ID,
						:P_USER_ID,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_TRX_DATE",$this->tc_date,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_MODE",$mode,PDO::PARAM_STR);
			$command->bindValue(":P_TC_ID",$type,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",Yii::app()->user->id,PDO::PARAM_STR);

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
		
			array('tc_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('tc_rev', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('tc_date', 'required'),
			array('tc_status, tc_rev', 'numerical', 'integerOnly'=>true),
			array('client_cd', 'length', 'max'=>12),
			array('client_name', 'length', 'max'=>50),
			array('brch_cd', 'length', 'max'=>2),
			array('rem_cd', 'length', 'max'=>3),
		//	array('tc_doc', 'length', 'max'=>4000),
			array('cre_by', 'length', 'max'=>10),
			array('cre_dt,client_type', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('tc_id, tc_date, tc_status, tc_rev, client_cd, client_name, brch_cd, rem_cd, tc_doc, cre_dt, cre_by,tc_date_date,tc_date_month,tc_date_year,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
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
			'tc_id' => 'Tc',
			'tc_date' => 'Trade Confirmation Date',
			'tc_status' => 'Tc Status',
			'tc_rev' => 'Tc Rev',
			'client_cd' => 'Client Code',
			'client_name' => 'Client Name',
			'brch_cd' => 'Brch Code',
			'rem_cd' => 'Rem Code',
			//'tc_doc' => 'Tc Doc',
			'cre_dt' => 'Cre Date',
			'cre_by' => 'Cre By',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('tc_id',$this->tc_id,true);

		if(!empty($this->tc_date_date))
			$criteria->addCondition("TO_CHAR(t.tc_date,'DD') LIKE '%".$this->tc_date_date."%'");
		if(!empty($this->tc_date_month))
			$criteria->addCondition("TO_CHAR(t.tc_date,'MM') LIKE '%".$this->tc_date_month."%'");
		if(!empty($this->tc_date_year))
			$criteria->addCondition("TO_CHAR(t.tc_date,'YYYY') LIKE '%".$this->tc_date_year."%'");		$criteria->compare('tc_status',$this->tc_status);
		$criteria->compare('tc_rev',$this->tc_rev);
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('brch_cd',$this->brch_cd,true);
		$criteria->compare('rem_cd',$this->rem_cd,true);
	//	$criteria->compare('tc_doc',$this->tc_doc,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('cre_by',$this->cre_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}