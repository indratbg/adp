<?php

/**
 * This is the model class for table "REP_SOA_SELECTION".
 *
 * The followings are the available columns in table 'REP_SOA_SELECTION':
 * @property string $from_dt
 * @property string $to_dt
 * @property string $purpose
 * @property string $client_from
 * @property string $client_to
 * @property string $branch_from
 * @property string $branch_to
 * @property string $sales_from
 * @property string $sales_to
 * @property string $olt_flg
 * @property string $update_date
 * @property integer $update_seq
 * @property string $user_id
 * @property string $generate_date
 */
class Soa extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $from_dt_date;
	public $from_dt_month;
	public $from_dt_year;

	public $to_dt_date;
	public $to_dt_month;
	public $to_dt_year;

	public $update_date_date;
	public $update_date_month;
	public $update_date_year;

	public $generate_date_date;
	public $generate_date_month;
	public $generate_date_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $client_from_branch;
	public $client_from_name;
	public $client_from_susp;
	public $client_to_branch;
	public $client_to_name;
	public $client_to_susp;
	public $branch_from_name;
	public $branch_to_name;
	public $sales_from_name;
	public $sales_to_name;
	
	public $month;
	public $year;
	
	public $client_search_type;
	public $client_susp;
	
	public $update_date;
	public $update_seq;
	
	public $dummy_date;
	
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
		return 'LAP_SOA_SELECTION';
	}
	
	public function getPrimaryKey()
	{
		return array('update_date'=>$this->update_date,'update_seq'=>$this->update_seq);
	}
	
	public function getIndexValue($type)
	{
		switch($type)
		{
			case 'client':
				$client_from = $this->client_from=='%'?'ALL':$this->client_from;
				$client_to = $this->client_to=='_'?'ALL':$this->client_to;
				
				if($client_from == $client_to)
				{
					return $client_from;
				}
				else 
				{
					return $client_from.' - '.$client_to;
				}
				
				break;
				
			case 'branch':
				$branch_from = trim($this->branch_from)=='%'?'ALL':$this->branch_from;
				$branch_to = trim($this->branch_to)=='_'?'ALL':$this->branch_to;
				
				if($branch_from == $branch_to)
				{
					return $branch_from;
				}
				else 
				{
					return $branch_from.' - '.$branch_to;
				}
				
				break;
				
			case 'sales':
				$sales_from = trim($this->sales_from)=='%'?'ALL':$this->sales_from;
				$sales_to = trim($this->sales_to)=='_'?'ALL':$this->sales_to;
				
				if($sales_from == $sales_to)
				{
					return $sales_from;
				}
				else 
				{
					return $sales_from.' - '.$sales_to;
				}
				
				break;
		}
	}
	
	public function executeSpHeader($exec_status,$menuName)
	{
		$connection  = Yii::app()->dbrpt;
		
		try{
			$query  = "CALL SP_T_MANY_HEADER_INSERT(
						:P_MENU_NAME,
						:P_STATUS,
						:P_USER_ID,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_UPDATE_DATE,
						:P_UPDATE_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
				
			$command = $connection->createCommand($query);
			$command->bindValue(":P_MENU_NAME",$menuName,PDO::PARAM_STR);
			$command->bindValue(":P_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);			
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			
			$command->bindParam(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR,30);
			$command->bindParam(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR,10);
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
	
	public function executeSp($exec_status,$record_seq)
	{
		$connection  = Yii::app()->dbrpt;
		
		try{
			$query  = "CALL SP_SOA_GEN(
						TO_DATE(:P_FROM_DT,'YYYY-MM-DD'),
						TO_DATE(:P_TO_DT,'YYYY-MM-DD'),
						:P_PURPOSE,
						:P_CLIENT_FROM,
						:P_CLIENT_TO,
						:P_BRANCH_FROM,
						:P_BRANCH_TO,
						:P_SALES_FROM,
						:P_SALES_TO,
						:P_OLT_FLG,
						:P_EMAIL_FLG,
						:P_USER_ID,
						TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_STATUS,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPDATE_SEQ,
						:P_RECORD_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_FROM_DT",$this->from_dt,PDO::PARAM_STR);
			$command->bindValue(":P_TO_DT",$this->to_dt,PDO::PARAM_STR);
			$command->bindValue(":P_PURPOSE",$this->purpose,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_FROM",$this->client_from?$this->client_from:'%',PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TO",$this->client_to?$this->client_to:'_',PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH_FROM",$this->branch_from?$this->branch_from:'%',PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH_TO",$this->branch_to?$this->branch_to:'_',PDO::PARAM_STR);
			$command->bindValue(":P_SALES_FROM",$this->sales_from?$this->sales_from:'%',PDO::PARAM_STR);
			$command->bindValue(":P_SALES_TO",$this->sales_to?$this->sales_to:'_',PDO::PARAM_STR);
			$command->bindValue(":P_OLT_FLG",$this->olt_flg,PDO::PARAM_STR);
			$command->bindValue(":P_EMAIL_FLG",$this->email_flg,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->generate_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_RECORD_SEQ",$record_seq,PDO::PARAM_STR);
						
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
		
			array('from_dt, to_dt, update_date, generate_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('update_seq', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('from_dt, to_dt', 'required'),
			
			array('update_seq', 'numerical', 'integerOnly'=>true),
			array('purpose, olt_flg, email_flg', 'length', 'max'=>1),
			array('client_from, client_to', 'length', 'max'=>50),
			array('branch_from, branch_to', 'length', 'max'=>2),
			array('sales_from, sales_to', 'length', 'max'=>3),
			array('user_id', 'length', 'max'=>10),
			array('month, year, client_search_type, from_dt, to_dt, update_date, generate_date, client_from_branch, client_to_branch, client_from_name, client_to_name, branch_from_name, branch_to_name, sales_from_name, sales_to_name', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('from_dt, to_dt, purpose, client_from, client_to, branch_from, branch_to, sales_from, sales_to, olt_flg, update_date, update_seq, user_id, generate_date,from_dt_date,from_dt_month,from_dt_year,to_dt_date,to_dt_month,to_dt_year,update_date_date,update_date_month,update_date_year,generate_date_date,generate_date_month,generate_date_year', 'safe', 'on'=>'search'),
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
			'purpose' => 'Purpose',
			'client_from' => 'Client From',
			'client_to' => 'Client To',
			'branch_from' => 'Branch From',
			'branch_to' => 'Branch To',
			'sales_from' => 'Sales From',
			'sales_to' => 'Sales To',
			'olt_flg' => 'Olt Flg',
			'email_flg' => 'E-Mail Status',
			'update_date' => 'Update Date',
			'update_seq' => 'Update Seq',
			'user_id' => 'Generated By',
			'generate_date' => 'Generate Date',
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
			$criteria->addCondition("TO_CHAR(t.to_dt,'YYYY') LIKE '%".$this->to_dt_year."%'");		$criteria->compare('purpose',$this->purpose,true);
		$criteria->compare('client_from',$this->client_from,true);
		$criteria->compare('client_to',$this->client_to,true);
		$criteria->compare('branch_from',$this->branch_from,true);
		$criteria->compare('branch_to',$this->branch_to,true);
		$criteria->compare('sales_from',$this->sales_from,true);
		$criteria->compare('sales_to',$this->sales_to,true);
		$criteria->compare('olt_flg',$this->olt_flg,true);

		if(!empty($this->update_date_date))
			$criteria->addCondition("TO_CHAR(t.update_date,'DD') LIKE '%".$this->update_date_date."%'");
		if(!empty($this->update_date_month))
			$criteria->addCondition("TO_CHAR(t.update_date,'MM') LIKE '%".$this->update_date_month."%'");
		if(!empty($this->update_date_year))
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		$criteria->compare('update_seq',$this->update_seq);
		$criteria->compare('UPPER(user_id)',strtoupper($this->user_id));

		if(!empty($this->generate_date_date))
			$criteria->addCondition("TO_CHAR(t.generate_date,'DD') LIKE '%".$this->generate_date_date."%'");
		if(!empty($this->generate_date_month))
			$criteria->addCondition("TO_CHAR(t.generate_date,'MM') LIKE '%".$this->generate_date_month."%'");
		if(!empty($this->generate_date_year))
			$criteria->addCondition("TO_CHAR(t.generate_date,'YYYY') LIKE '%".$this->generate_date_year."%'");
		
		$sort = new CSort;
		$sort->defaultOrder = 'generate_date DESC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}