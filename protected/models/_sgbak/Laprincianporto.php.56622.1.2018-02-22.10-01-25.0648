<?php

/**
 * This is the model class for table "LAP_RINCIAN_PORTO".
 *
 * The followings are the available columns in table 'LAP_RINCIAN_PORTO':
 * @property string $update_date
 * @property integer $update_seq
 * @property string $report_date
 * @property string $rep_type
 * @property string $stk_cd
 * @property double $price
 * @property integer $port001
 * @property integer $port002
 * @property double $port004
 * @property integer $client001
 * @property integer $client002
 * @property integer $client004
 * @property integer $subrek_qty
 * @property integer $jumlah_acct
 * @property string $user_id
 * @property string $approved_stat
 * @property string $approved_by
 * @property string $approved_dt
 * @property string $savetxt_date
 */
class Laprincianporto extends AActiveRecordSP
{
	public $file_upload;
	public $view_type;
	
	//AH: #BEGIN search (datetime || date) additional comparison
	public $update_date_date;
	public $update_date_month;
	public $update_date_year;

	public $report_date_date;
	public $report_date_month;
	public $report_date_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;

	public $savetxt_date_date;
	public $savetxt_date_month;
	public $savetxt_date_year;
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
    
	public function getDbConnection()
	{
		return Yii::app()->dbrpt;
	}

	public function tableName()
	{
		return 'LAP_RINCIAN_PORTO';
	}

	public function rules()
	{
		return array(
		
			array('update_date, report_date, approved_dt, savetxt_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('update_seq, price, port001, port002, port004, client001, client002, client004, subrek_qty, jumlah_acct', 'application.components.validator.ANumberSwitcherValidator'),
			
			//array('update_date, update_seq', 'required'),
			array('update_seq, port001, port002, client001, client002, client004, subrek_qty, jumlah_acct', 'numerical', 'integerOnly'=>true),
			array('price, port004', 'numerical'),
			array('rep_type, approved_stat', 'length', 'max'=>1),
			array('stk_cd', 'length', 'max'=>50),
			array('user_id, approved_by', 'length', 'max'=>10),
			array('report_date, approved_dt, savetxt_date, file_upload, view_type', 'safe'),
			array('file_upload','file','types'=>'por','wrongType'=>'File type must be POR','on'=>'upload'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('update_date, update_seq, report_date, rep_type, stk_cd, price, port001, port002, port004, client001, client002, client004, subrek_qty, jumlah_acct, user_id, approved_stat, approved_by, approved_dt, savetxt_date,update_date_date,update_date_month,update_date_year,report_date_date,report_date_month,report_date_year,approved_dt_date,approved_dt_month,approved_dt_year,savetxt_date_date,savetxt_date_month,savetxt_date_year', 'safe', 'on'=>'search'),
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
			'update_date' => 'Update Date',
			'update_seq' => 'Update Seq',
			'report_date' => 'Report Date',
			'rep_type' => 'Rep Type',
			'stk_cd' => 'Stk Code',
			'price' => 'Price',
			'port001' => 'Port001',
			'port002' => 'Port002',
			'port004' => 'Port004',
			'client001' => 'Client001',
			'client002' => 'Client002',
			'client004' => 'Client004',
			'subrek_qty' => 'Subrek Qty',
			'jumlah_acct' => 'Jumlah Acct',
			'user_id' => 'User',
			'approved_stat' => 'Approved Stat',
			'approved_by' => 'Approved By',
			'approved_dt' => 'Approved Date',
			'savetxt_date' => 'Savetxt Date',
		);
	}

	public function executeSpDelete($reportdate,&$transaction)
	{
		$connection  = Yii::app()->dbrpt;
		try{
			$query  = "CALL SP_RECONCILE_PORTO_DELETE(
						TO_DATE(:P_REPORT_DATE,'YYYYMMDD'),
						:P_ERROR_CODE,
						:P_ERROR_MSG)";

			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_REPORT_DATE",$reportdate,PDO::PARAM_STR);
			
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,500);
			
			$command->execute();
			//$transaction->commit();
		}catch(Exception $ex){
			//$transaction->rollback();
			if($this->error_code == -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		
		return $this->error_code;
	}
	
	public function executeSp($reportdate,$stkcd,$price,$port001,$port002,$port004,$client001,$client002,$client004,$subrekqty,$reptype,$userid,&$transaction)
	{
		$connection  = Yii::app()->dbrpt;
		try{
			$query  = "CALL SP_RECONCILE_PORTO(
						TO_DATE(:P_REPORT_DATE,'YYYYMMDD'),
						:P_STK_CD,
						:P_PRICE,
						:P_PORT001,
						:P_PORT002,
						:P_PORT004,
						:P_CLIENT001,
						:P_CLIENT002,
						:P_CLIENT004,
						:P_SUBREK_QTY,
						:P_REP_TYPE,
						:P_USER_ID,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";

			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_REPORT_DATE",$reportdate,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$stkcd,PDO::PARAM_STR);
			$command->bindValue(":P_PRICE",$price,PDO::PARAM_STR);
			$command->bindValue(":P_PORT001",$port001,PDO::PARAM_STR);
			$command->bindValue(":P_PORT002",$port002,PDO::PARAM_STR);
			$command->bindValue(":P_PORT004",$port004,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT001",$client001,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT002",$client002,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT004",$client004,PDO::PARAM_STR);
			$command->bindValue(":P_SUBREK_QTY",$subrekqty,PDO::PARAM_STR);
			$command->bindValue(":P_REP_TYPE",$reptype,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$userid,PDO::PARAM_STR);
			
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,500);
			
			$command->execute();
			//$transaction->commit();
		}catch(Exception $ex){
			//$transaction->rollback();
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

		if(!empty($this->update_date_date))
			$criteria->addCondition("TO_CHAR(t.update_date,'DD') LIKE '%".$this->update_date_date."%'");
		if(!empty($this->update_date_month))
			$criteria->addCondition("TO_CHAR(t.update_date,'MM') LIKE '%".$this->update_date_month."%'");
		if(!empty($this->update_date_year))
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		$criteria->compare('update_seq',$this->update_seq);

		if(!empty($this->report_date_date))
			$criteria->addCondition("TO_CHAR(t.report_date,'DD') LIKE '%".$this->report_date_date."%'");
		if(!empty($this->report_date_month))
			$criteria->addCondition("TO_CHAR(t.report_date,'MM') LIKE '%".$this->report_date_month."%'");
		if(!empty($this->report_date_year))
			$criteria->addCondition("TO_CHAR(t.report_date,'YYYY') LIKE '%".$this->report_date_year."%'");		$criteria->compare('rep_type',$this->rep_type,true);
		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('port001',$this->port001);
		$criteria->compare('port002',$this->port002);
		$criteria->compare('port004',$this->port004);
		$criteria->compare('client001',$this->client001);
		$criteria->compare('client002',$this->client002);
		$criteria->compare('client004',$this->client004);
		$criteria->compare('subrek_qty',$this->subrek_qty);
		$criteria->compare('jumlah_acct',$this->jumlah_acct);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);
		$criteria->compare('approved_by',$this->approved_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");
		if(!empty($this->savetxt_date_date))
			$criteria->addCondition("TO_CHAR(t.savetxt_date,'DD') LIKE '%".$this->savetxt_date_date."%'");
		if(!empty($this->savetxt_date_month))
			$criteria->addCondition("TO_CHAR(t.savetxt_date,'MM') LIKE '%".$this->savetxt_date_month."%'");
		if(!empty($this->savetxt_date_year))
			$criteria->addCondition("TO_CHAR(t.savetxt_date,'YYYY') LIKE '%".$this->savetxt_date_year."%'");
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}