<?php

/**
 * This is the model class for table "T_FOLDER".
 *
 * The followings are the available columns in table 'T_FOLDER':
 * @property string $fld_mon
 * @property string $folder_cd
 * @property string $doc_date
 * @property string $doc_num
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $upd_by
 */
class Tfolder extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $doc_date_date;
	public $doc_date_month;
	public $doc_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
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
    
	public function executeSp($exec_status,$old_doc_num,$update_date,$update_seq,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_T_FOLDER_UPD(
						:P_SEARCH_DOC_NUM,			
						:P_FLD_MON,				
						:P_FOLDER_CD,					
						TO_DATE(:P_DOC_DATE,'YYYY-MM-DD'),					
						:P_DOC_NUM,						
						:P_USER_ID,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),		
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPDATE_SEQ,
						:P_RECORD_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_DOC_NUM",$old_doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_FLD_MON",$this->fld_mon,PDO::PARAM_STR);
			$command->bindValue(":P_FOLDER_CD",strtoupper($this->folder_cd),PDO::PARAM_STR);
			$command->bindValue(":P_DOC_DATE",$this->doc_date,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_NUM",$this->doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$update_seq,PDO::PARAM_STR);
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

	public function tableName()
	{
		return 'T_FOLDER';
	}

	public function rules()
	{
		return array(
		
			array('doc_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('fld_mon', 'length', 'max'=>4),
			array('folder_cd', 'length', 'max'=>8),
			array('user_id, upd_by', 'length', 'max'=>10),
			array('doc_date, cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('fld_mon, folder_cd, doc_date, doc_num, user_id, cre_dt, upd_dt, upd_by,doc_date_date,doc_date_month,doc_date_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'fld_mon' => 'Fld Mon',
			'folder_cd' => 'Folder Code',
			'doc_date' => 'Doc Date',
			'doc_num' => 'Doc Num',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('fld_mon',$this->fld_mon,true);
		$criteria->compare('folder_cd',$this->folder_cd,true);

		if(!empty($this->doc_date_date))
			$criteria->addCondition("TO_CHAR(t.doc_date,'DD') LIKE '%".$this->doc_date_date."%'");
		if(!empty($this->doc_date_month))
			$criteria->addCondition("TO_CHAR(t.doc_date,'MM') LIKE '%".$this->doc_date_month."%'");
		if(!empty($this->doc_date_year))
			$criteria->addCondition("TO_CHAR(t.doc_date,'YYYY') LIKE '%".$this->doc_date_year."%'");		$criteria->compare('doc_num',$this->doc_num,true);
		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");
		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('upd_by',$this->upd_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}