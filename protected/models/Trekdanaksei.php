<?php

/**
 * This is the model class for table "T_REK_DANA_KSEI".
 *
 * The followings are the available columns in table 'T_REK_DANA_KSEI':
 * @property string $sid
 * @property string $subrek
 * @property string $name
 * @property string $rek_dana
 * @property string $bank_cd
 * @property string $create_dt
 */
class Trekdanaksei extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $create_dt_date;
	public $create_dt_month;
	public $create_dt_year;
	
	public $file_upload;
	public $import_type;
	//AH: #END search (datetime || date)  additional comparison
	public $update_date;
	public $update_seq;
	public $no_rek;
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
		return 'T_REK_DANA_KSEI';
	}

	public function rules()
	{
		return array(
		
			array('create_dt,ksei_date', 'application.components.validator.ADatePickerSwitcherValidator'),
			array('file_upload','file','types'=>'cas','wrongType'=>'File type must be cas','on'=>'upload'),
			array('sid, subrek', 'length', 'max'=>15),
			array('name', 'length', 'max'=>50),
			array('rek_dana', 'length', 'max'=>25),
			array('bank_cd', 'length', 'max'=>5),
			array('create_dt, file_upload, import_type,user_id', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('sid, subrek, name, rek_dana, bank_cd, create_dt,create_dt_date,create_dt_month,create_dt_year', 'safe', 'on'=>'search'),
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
			'sid' => 'Sid',
			'subrek' => 'Subrek',
			'name' => 'Name',
			'rek_dana' => 'Rek Dana',
			'bank_cd' => 'Bank Code',
			'create_dt' => 'Create Date',
			'user_id'=>'User Id',
			'ksei_date'=>'Ksei Date'
		);
	}

 public function executeInsert()
	{
	
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		$p_user_id = Yii::app()->user->id;
		try{
			$query  = "CALL SP_MST_CLIENT_FLACCT_IMP(:P_USER_ID,:P_IP_ADDRESS,:VO_MSSG_ERR,:VO_ERR_CD)";

			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindParam(":VO_ERR_CD",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":VO_MSSG_ERR",$this->error_msg,PDO::PARAM_STR,500);
			
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
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('subrek',$this->subrek,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('rek_dana',$this->rek_dana,true);
		$criteria->compare('bank_cd',$this->bank_cd,true);

		if(!empty($this->create_dt_date))
			$criteria->addCondition("TO_CHAR(t.create_dt,'DD') LIKE '%".($this->create_dt_date)."%'");
		if(!empty($this->create_dt_month))
			$criteria->addCondition("TO_CHAR(t.create_dt,'MM') LIKE '%".($this->create_dt_month)."%'");
		if(!empty($this->create_dt_year))
			$criteria->addCondition("TO_CHAR(t.create_dt,'YYYY') LIKE '%".($this->create_dt_year)."%'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function executeBackup()
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL sp_backup_rekdana_ksei(:VO_MSSG_ERR,:VO_ERR_CD)";

			$command = $connection->createCommand($query);
			
			$command->bindParam(":VO_ERR_CD",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":VO_MSSG_ERR",$this->error_msg,PDO::PARAM_STR,100);
			
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

}

