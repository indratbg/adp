<?php

/**
 * This is the model class for table "MST_BANK_BI".
 *
 * The followings are the available columns in table 'MST_BANK_BI':
 * @property string $bi_code
 * @property string $rtgs_code
 * @property string $bank_name
 * @property string $branch_name
 * @property string $city
 * @property string $ip_bank_cd
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Bankbi extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;

	
	public $system_bank_name='';
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
		return 'MST_BANK_BI';
	}


	public function executeSp($exec_status,$bi_code)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_MST_BANKBI_UPD(
						:P_SEARCH_BI_CODE,:P_BI_CODE,:P_RTGS_CODE,:P_BANK_NAME,:P_BRANCH_NAME,:P_CITY,:P_IP_BANK_CD,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),:P_USER_ID,TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,:P_UPD_STATUS,:P_IP_ADDRESS,
						:P_CANCEL_REASON,:P_ERROR_CODE,:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_SEARCH_BI_CODE",$bi_code,PDO::PARAM_STR);
			$command->bindValue(":P_BI_CODE",$this->bi_code,PDO::PARAM_STR);
			$command->bindValue(":P_RTGS_CODE",$this->rtgs_code,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_NAME",$this->bank_name,PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH_NAME",$this->branch_name,PDO::PARAM_STR);
			$command->bindValue(":P_CITY",$this->city,PDO::PARAM_STR);
			$command->bindValue(":P_IP_BANK_CD",$this->ip_bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,100);

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

	public function rules()
	{
		return array(
		
			array('bi_code, bank_name','required'),
			
			array('bi_code','length','max'=>7),
			array('rtgs_code', 'length', 'max'=>8),
			array('bank_name', 'length', 'max'=>255),
			array('branch_name', 'length', 'max'=>255),
			array('city, user_id, upd_by, approved_by', 'length', 'max'=>255),
			array('ip_bank_cd', 'length', 'max'=>3),
			array('approved_stat', 'length', 'max'=>1),
			array('cre_dt, upd_dt, approved_dt,rowid', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('bi_code, rtgs_code, bank_name, branch_name, city, ip_bank_cd, cre_dt, user_id, upd_dt, upd_by, approved_dt, approved_by, approved_stat,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year,row_id', 'safe', 'on'=>'search'),
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
			'bi_code' => 'Clearing Code',
			'rtgs_code' => 'Swift',
			'bank_name' => 'Bank Name',
			'branch_name' => 'Branch Name',
			'city' => 'City',
			'ip_bank_cd' => 'Bank Code',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Stat',
			'system_bank_name'=> 'System Bank Name'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->select = "t.bi_code, t.bank_name, t.ip_bank_cd";
		$criteria->compare('bi_code',$this->bi_code,true);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('ip_bank_cd',$this->ip_bank_cd,true);
		// $sql=Parameter::model()->findAllBySql("select prm_desc from mst_parameter where prm_cd_1='BANKCD' order by prm_cd_1");
		// $prm_desc=is_string($sql);
		$criteria->compare('system_bank_name',$this->system_bank_name,true);
		
		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('upd_by',$this->upd_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat','A',true);
		$sort = new CSort;
		
		$sort->defaultOrder='bi_code';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}