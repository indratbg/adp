<?php

/**
 * This is the model class for table "T_RECONCILE_PORTO".
 *
 * The followings are the available columns in table 'T_RECONCILE_PORTO':
 * @property string $report_date
 * @property string $stk_cd
 * @property double $price
 * @property integer $port001
 * @property integer $port002
 * @property double $port004
 * @property integer $client001
 * @property integer $client002
 * @property integer $client004
 * @property integer $subrek_qty
 * @property string $rep_type
 * @property string $cre_dt
 * @property string $user_id
 * @property integer $port_warkat
 * @property integer $client_warkat
 * @property integer $port_cust
 * @property integer $client_cust
 */
class Treconcileporto extends AActiveRecordSP
{
	public $file_upload;
	public $view_type;
	//AH: #BEGIN search (datetime || date) additional comparison
	public $report_date_date;
	public $report_date_month;
	public $report_date_year;

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
    
	public function getDbConnection()
	{
		return Yii::app()->dbrpt;
	}

	public function tableName()
	{
		return 'T_RECONCILE_PORTO';
	}

	public function rules()
	{
		return array(
		
			array('report_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('price, port001, port002, port004, client001, client002, client004, subrek_qty, port_warkat, client_warkat, port_cust, client_cust', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('port001, port002, client001, client002, client004, subrek_qty, port_warkat, client_warkat, port_cust, client_cust', 'numerical', 'integerOnly'=>true),
			array('price, port004', 'numerical'),
			array('stk_cd', 'length', 'max'=>50),
			array('rep_type', 'length', 'max'=>1),
			array('user_id', 'length', 'max'=>10),
			array('report_date, cre_dt, view_type, file_upload', 'safe'),
			array('file_upload','file','types'=>'por','wrongType'=>'File type must be POR','on'=>'upload'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('report_date, stk_cd, price, port001, port002, port004, client001, client002, client004, subrek_qty, rep_type, cre_dt, user_id, port_warkat, client_warkat, port_cust, client_cust,report_date_date,report_date_month,report_date_year,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
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
			'report_date' => 'Report Date',
			'stk_cd' => 'Stk Code',
			'price' => 'Price',
			'port001' => 'Port001',
			'port002' => 'Port002',
			'port004' => 'Port004',
			'client001' => 'Client001',
			'client002' => 'Client002',
			'client004' => 'Client004',
			'subrek_qty' => 'Subrek Qty',
			'rep_type' => 'Rep Type',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'port_warkat' => 'Port Warkat',
			'client_warkat' => 'Client Warkat',
			'port_cust' => 'Port Cust',
			'client_cust' => 'Client Cust',
		);
	}
	
	public function executeSpDelete($reportdate)
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
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
	
	public function executeSp()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
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
						:P_PORT_WARKAT,
						:P_CLIENT_WARKAT,
						:P_PORT_CUST,
						:P_CLIENT_CUST,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";

			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_REPORT_DATE",$this->report_date,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_PRICE",$this->price,PDO::PARAM_STR);
			$command->bindValue(":P_PORT001",$this->port001,PDO::PARAM_STR);
			$command->bindValue(":P_PORT002",$this->port002,PDO::PARAM_STR);
			$command->bindValue(":P_PORT004",$this->port004,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT001",$this->client001,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT002",$this->client002,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT004",$this->client004,PDO::PARAM_STR);
			$command->bindValue(":P_SUBREK_QTY",$this->subrek_qty,PDO::PARAM_STR);
			$command->bindValue(":P_REP_TYPE",$this->rep_type,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_PORT_WARKAT",$this->port_warkat,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_WARKAT",$this->client_warkat,PDO::PARAM_STR);
			$command->bindValue(":P_PORT_CUST",$this->port_cust,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CUST",$this->client_cust,PDO::PARAM_STR);
			
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,500);
			
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

		if(!empty($this->report_date_date))
			$criteria->addCondition("TO_CHAR(t.report_date,'DD') LIKE '%".$this->report_date_date."%'");
		if(!empty($this->report_date_month))
			$criteria->addCondition("TO_CHAR(t.report_date,'MM') LIKE '%".$this->report_date_month."%'");
		if(!empty($this->report_date_year))
			$criteria->addCondition("TO_CHAR(t.report_date,'YYYY') LIKE '%".$this->report_date_year."%'");		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('port001',$this->port001);
		$criteria->compare('port002',$this->port002);
		$criteria->compare('port004',$this->port004);
		$criteria->compare('client001',$this->client001);
		$criteria->compare('client002',$this->client002);
		$criteria->compare('client004',$this->client004);
		$criteria->compare('subrek_qty',$this->subrek_qty);
		$criteria->compare('rep_type',$this->rep_type,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('port_warkat',$this->port_warkat);
		$criteria->compare('client_warkat',$this->client_warkat);
		$criteria->compare('port_cust',$this->port_cust);
		$criteria->compare('client_cust',$this->client_cust);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}