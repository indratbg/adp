<?php

/**
 * This is the model class for table "T_STK_KSEI".
 *
 * The followings are the available columns in table 'T_STK_KSEI':
 * @property string $import_dt
 * @property string $bal_dt
 * @property string $sub_rek
 * @property string $stk_cd
 * @property integer $qty
 * @property string $free
 */
class Tstkksei extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $import_dt_date;
	public $import_dt_month;
	public $import_dt_year;

	public $bal_dt_date;
	public $bal_dt_month;
	public $bal_dt_year;
	public $date_now;
	public $file_upload;
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
		return 'T_STK_KSEI';
	}

	public function rules()
	{
		return array(
		
			array('date_now,import_dt, bal_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('qty', 'application.components.validator.ANumberSwitcherValidator'),
			array('file_upload','file','types'=>'txt','wrongType'=>'File type must be txt','on'=>'upload'),
			array('import_dt, bal_dt, sub_rek, stk_cd', 'required','except'=>'upload'),
			array('qty', 'numerical', 'integerOnly'=>true),
			array('sub_rek', 'length', 'max'=>14),
			array('stk_cd, free', 'length', 'max'=>20),
			array('date_now','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('import_dt, bal_dt, sub_rek, stk_cd, qty, free,import_dt_date,import_dt_month,import_dt_year,bal_dt_date,bal_dt_month,bal_dt_year', 'safe', 'on'=>'search'),
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
			'import_dt' => 'Import Date',
			'bal_dt' => 'Bal Date',
			'sub_rek' => 'Sub Rek',
			'stk_cd' => 'Stk Code',
			'qty' => 'Qty',
			'free' => 'Free',
			'date_now'=>'Date'
		);
	}

	public function executeBackup()
	{
		$connection  = Yii::app()->db;
		$connection->enableParamLogging = false; //WT disable save data to log
		$transaction = $connection->beginTransaction();
		try{
			$query  = "CALL SP_BACKUP_STOCK_BALANCE(TO_DATE(:P_BAL_DT,'yyyy-mm-dd'),:VO_MSSG_ERR,:VO_ERR_CD)";

			$command = $connection->createCommand($query);
			$command->bindValue(":P_BAL_DT",$this->date_now,PDO::PARAM_STR);
			$command->bindParam(":VO_ERR_CD",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":VO_MSSG_ERR",$this->error_msg,PDO::PARAM_STR,200);
			
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

		if(!empty($this->import_dt_date))
			$criteria->addCondition("TO_CHAR(t.import_dt,'DD') LIKE '%".$this->import_dt_date."%'");
		if(!empty($this->import_dt_month))
			$criteria->addCondition("TO_CHAR(t.import_dt,'MM') LIKE '%".$this->import_dt_month."%'");
		if(!empty($this->import_dt_year))
			$criteria->addCondition("TO_CHAR(t.import_dt,'YYYY') LIKE '%".$this->import_dt_year."%'");
		if(!empty($this->bal_dt_date))
			$criteria->addCondition("TO_CHAR(t.bal_dt,'DD') LIKE '%".$this->bal_dt_date."%'");
		if(!empty($this->bal_dt_month))
			$criteria->addCondition("TO_CHAR(t.bal_dt,'MM') LIKE '%".$this->bal_dt_month."%'");
		if(!empty($this->bal_dt_year))
			$criteria->addCondition("TO_CHAR(t.bal_dt,'YYYY') LIKE '%".$this->bal_dt_year."%'");		$criteria->compare('sub_rek',$this->sub_rek,true);
		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('free',$this->free,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}