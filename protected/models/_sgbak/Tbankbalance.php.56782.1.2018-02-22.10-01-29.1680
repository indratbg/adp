<?php

/**
 * This is the model class for table "T_BANK_BALANCE".
 *
 * The followings are the available columns in table 'T_BANK_BALANCE':
 * @property string $rdn
 * @property string $sid
 * @property string $sre
 * @property string $namanasabah
 * @property double $balance
 * @property string $tanggalefektif
 * @property string $tanggaltimestamp
 * @property string $currency
 * @property string $bankid
 * @property string $flg_upd_tfb
 */
class Tbankbalance extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $tanggalefektif_date;
	public $tanggalefektif_month;
	public $tanggalefektif_year;

	public $tanggaltimestamp_date;
	public $tanggaltimestamp_month;
	public $tanggaltimestamp_year;
	public $file_upload;
	public $fail;
	public $reconcile_with;
	//public $begin_date;
	public $end_date;
	public $user_id;
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
		return 'T_BANK_BALANCE';
	}

	public function rules()
	{
		return array(
		
			array(' end_date,tanggalefektif, tanggaltimestamp', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('balance', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('rdn, sid, sre, namanasabah, balance, tanggalefektif, tanggaltimestamp, currency, bankid', 'required','except'=>'upload,reconcile'),
			array('balance', 'numerical'),
			array('file_upload','file','types'=>'txt','wrongType'=>'File type must be *.txt','on'=>'upload'),
			array('rdn, namanasabah', 'length', 'max'=>25),
			array('sid', 'length', 'max'=>15),
			array('sre', 'length', 'max'=>14),
			array('currency', 'length', 'max'=>3),
			array('bankid', 'length', 'max'=>5),
			array('flg_upd_tfb', 'length', 'max'=>1),
			array('reconcile_with,file_upload','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('rdn, sid, sre, namanasabah, balance, tanggalefektif, tanggaltimestamp, currency, bankid, flg_upd_tfb,tanggalefektif_date,tanggalefektif_month,tanggalefektif_year,tanggaltimestamp_date,tanggaltimestamp_month,tanggaltimestamp_year', 'safe', 'on'=>'search'),
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
			'rdn' => 'Rdn',
			'sid' => 'Sid',
			'sre' => 'Sre',
			'namanasabah' => 'Namanasabah',
			'balance' => 'Balance',
			'tanggalefektif' => 'Date',
			'tanggaltimestamp' => 'Tanggaltimestamp',
			'currency' => 'Currency',
			'bankid' => 'Bank code',
			'flg_upd_tfb' => 'Flg Upd Tfb',
			//'begin_date'=>'From Date',
			'end_date'=>'Date'
		);
	}


public function executeSpImport($bank_cd,$data)
	{ 
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		$connection->enableParamLogging = false; //WT disable save data to log
		try{
			$query  = "CALL  SP_FUND_BANK_BAL_IMPORT(:p_bank_cd,
													:p_data,
													:p_userid,
													
													:VO_FAIL,
													:vo_errcd,
													:vo_errmsg)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":p_bank_cd",$bank_cd,PDO::PARAM_STR);
			$command->bindValue(":p_data",$data,PDO::PARAM_STR);
			$command->bindValue(":p_userid",$this->user_id,PDO::PARAM_STR);			
			//$command->bindParam(":vo_eff_dt",$this->begin_date,PDO::PARAM_STR,50);
			$command->bindParam(":VO_FAIL",$this->fail,PDO::PARAM_INT,10);
			$command->bindParam(":vo_errcd",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":vo_errmsg",$this->error_msg,PDO::PARAM_STR,200);

			$command->execute();
			$transaction->commit();
			//Commit baru akan dijalankan saat semua transaksi INSERT sukses
			
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

public function executeSpImportDelete()
	{ 
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		try{
			$query  = "CALL  SP_FUND_BAL_BANK_DELETE(to_date(:p_status_dt,'yyyy-mm-dd'),
													:p_error_cd,
													:p_error_msg)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":p_status_dt",$this->end_date,PDO::PARAM_STR);
			$command->bindParam(":p_error_cd",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":p_error_msg",$this->error_msg,PDO::PARAM_STR,200);

			$command->execute();
			$transaction->commit();
			//Commit baru akan dijalankan saat semua transaksi INSERT sukses
			
		}catch(Exception $ex){
			$transaction->rollback();
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
		$criteria->compare('rdn',$this->rdn,true);
		$criteria->compare('sid',$this->sid,true);
		$criteria->compare('sre',$this->sre,true);
		$criteria->compare('namanasabah',$this->namanasabah,true);
		$criteria->compare('balance',$this->balance);

		if(!empty($this->tanggalefektif_date))
			$criteria->addCondition("TO_CHAR(t.tanggalefektif,'DD') LIKE '%".$this->tanggalefektif_date."%'");
		if(!empty($this->tanggalefektif_month))
			$criteria->addCondition("TO_CHAR(t.tanggalefektif,'MM') LIKE '%".$this->tanggalefektif_month."%'");
		if(!empty($this->tanggalefektif_year))
			$criteria->addCondition("TO_CHAR(t.tanggalefektif,'YYYY') LIKE '%".$this->tanggalefektif_year."%'");
		if(!empty($this->tanggaltimestamp_date))
			$criteria->addCondition("TO_CHAR(t.tanggaltimestamp,'DD') LIKE '%".$this->tanggaltimestamp_date."%'");
		if(!empty($this->tanggaltimestamp_month))
			$criteria->addCondition("TO_CHAR(t.tanggaltimestamp,'MM') LIKE '%".$this->tanggaltimestamp_month."%'");
		if(!empty($this->tanggaltimestamp_year))
			$criteria->addCondition("TO_CHAR(t.tanggaltimestamp,'YYYY') LIKE '%".$this->tanggaltimestamp_year."%'");		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('bankid',$this->bankid,true);
		$criteria->compare('flg_upd_tfb',$this->flg_upd_tfb,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}