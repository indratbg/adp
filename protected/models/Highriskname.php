<?php

/**
 * This is the model class for table "T_HIGHRISK_NAME".
 *
 * The followings are the available columns in table 'T_HIGHRISK_NAME':
 * @property string $name
 * @property string $kategori
 * @property string $descrip
 * @property string $ref_date
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 * @property string $country
 * @property string $birth
 * @property string $address
 * @property double $seqno
 */
class Highriskname extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $ref_date_date;
	public $ref_date_month;
	public $ref_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $update_date; //update date for t_many_header
	public $update_seq; // update seq for t_many_header
	
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
		return 'T_HIGHRISK_NAME';
	}

	public function rules()
	{
		return array(
		
			array('ref_date, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('seqno', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('name', 'required'),
			array('birth, country', 'length', 'max'=>100),
			array('name, address', 'length', 'max'=>200),
			array('kategori, user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('descrip', 'length', 'max'=>500),
			array('ref_date, cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('name, kategori, descrip, ref_date, cre_dt, user_id, upd_dt, upd_by, approved_dt, approved_by, approved_stat, country, birth, address, seqno,ref_date_date,ref_date_month,ref_date_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'kategori' => 'Kategori',
			'descrip' => 'Description',
			'ref_date' => 'Ref Date',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Stat',
			'country' => 'Country',
			'birth' => 'Birth',
			'address' => 'Address',
			'seqno' => 'Seqno',
		);
	}
	
	protected function afterFind()
	{
		$this->ref_date = Yii::app()->format->cleanDate($this->ref_date);
	}
	
	public function executeSpManyHeader($exec_status,$menuName,&$transaction)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
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
			
			//Commit baru akan dijalankan saat semua transaksi INSERT sukses
			
		}catch(Exception $ex){
			//$transaction->rollback();
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

	public function executeSp($exec_status,$seqno,$record_seq,&$transaction)
	{
		$connection  = Yii::app()->db;
		try{
			$query  = "CALL SP_T_HIGHRISK_NAME_UPD(:P_SEQNO,:P_NAME,:P_KATEGORI, 
						:P_DESCRIP,TO_DATE(:P_REF_DATE,'YYYY-MM-DD'),TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_COUNTRY,:P_BIRTH,:P_ADDRESS,
						:P_USER_ID,TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),:P_UPD_BY,
						:P_UPD_STATUS,:p_ip_address,
						:p_cancel_reason,
						:p_update_date,
						:p_update_seq,
						:p_record_seq,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";

			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_SEQNO",$seqno,PDO::PARAM_STR);
			$command->bindValue(":P_NAME",$this->name,PDO::PARAM_STR);
			$command->bindValue(":P_KATEGORI",$this->kategori,PDO::PARAM_STR);
			$command->bindValue(":P_DESCRIP",$this->descrip,PDO::PARAM_STR);
			$command->bindValue(":P_REF_DATE",$this->ref_date,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_COUNTRY",$this->country,PDO::PARAM_STR);
			$command->bindValue(":P_BIRTH",$this->birth,PDO::PARAM_STR);
			$command->bindValue(":P_ADDRESS",$this->address,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_RECORD_SEQ",$record_seq,PDO::PARAM_STR);
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
		$criteria->addCondition("UPPER(name) LIKE UPPER('%".$this->name."%')");
		$criteria->compare('kategori',$this->kategori,true);
		if(!empty($this->descrip))
			$criteria->addCondition("UPPER(descrip) LIKE UPPER('%".$this->descrip."%')");

		if(!empty($this->ref_date_date))
			$criteria->addCondition("TO_CHAR(t.ref_date,'DD') LIKE '%".$this->ref_date_date."%'");
		if(!empty($this->ref_date_month))
			$criteria->addCondition("TO_CHAR(t.ref_date,'MM') LIKE '%".$this->ref_date_month."%'");
		if(!empty($this->ref_date_year))
			$criteria->addCondition("TO_CHAR(t.ref_date,'YYYY') LIKE '%".$this->ref_date_year."%'");
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
		
		if(!empty($this->country))
			$criteria->addCondition("UPPER(country) LIKE UPPER('%".$this->country."%')");
		if(!empty($this->birth))
			$criteria->addCondition("UPPER(birth) LIKE UPPER('%".$this->birth."%')");
		if(!empty($this->address))
			$criteria->addCondition("UPPER(address) LIKE UPPER('%".$this->address."%')");
		$criteria->compare('seqno',$this->seqno);
		//$criteria->compare('approved_stat',$this->approved_stat,true);
		$criteria->compare('approved_stat','A',true);
		$sort = new CSort();
		$sort->defaultOrder = 'kategori, name';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}