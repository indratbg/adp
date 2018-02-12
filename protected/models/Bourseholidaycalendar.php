<?php

/**
 * This is the model class for table "MST_CALENDAR".
 *
 * The followings are the available columns in table 'MST_CALENDAR':
 * @property string $tgl_libur
 * @property string $ket_libur
 * @property string $flag_libur
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_dt
 */
class Bourseholidaycalendar extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $tgl_libur_date;
	public $tgl_libur_month;
	public $tgl_libur_year;

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
    

	public function tableName()
	{
		return 'MST_CALENDAR';
	}
	
	
	/*
	 * AH: provide char data to trim value according
	 *     especially those which shape combo box
	 * 	   and also those who type date and shows in user input
	 */
	protected function afterFind()
	{
		$this->tgl_libur = Yii::app()->format->cleanDate($this->tgl_libur);
	}
	
	
	/*
	 *  AH: this function is for executing procedure
	 *  exec_status  : I/U/C
	 */
	public function executeSp($exec_status,$p_src_tgl_libur = NULL)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_MST_CALENDAR_UPD(
						TO_DATE(:P_SEARCH_TGL_LIBUR,'YYYY-MM-DD'),TO_DATE(:P_TGL_LIBUR,'YYYY-MM-DD'),:P_KET_LIBUR,:P_FLAG_LIBUR,
						:P_USER_ID,TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),:P_UPD_BY,
						:P_UPD_STATUS,:P_IP_ADDRESS,:P_CANCEL_REASON,
						:P_ERROR_CODE,:P_ERROR_MSG)";
						
			$command = $connection->createCommand($query);
			
			$src_tgl_libur = ($p_src_tgl_libur != NULL) ?$p_src_tgl_libur:$this->tgl_libur;
			
			
			$command->bindValue(":P_SEARCH_TGL_LIBUR",$src_tgl_libur,PDO::PARAM_STR);
			$command->bindValue(":P_TGL_LIBUR",$this->tgl_libur,PDO::PARAM_STR);
			$command->bindValue(":P_KET_LIBUR",$this->ket_libur,PDO::PARAM_STR);
			$command->bindValue(":P_FLAG_LIBUR",$this->flag_libur,PDO::PARAM_STR);

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
			array('tgl_libur, ket_libur, flag_libur','required'),
			array('ket_libur', 'length', 'max'=>40),
			array('flag_libur', 'length', 'max'=>1),
			array('user_id', 'length', 'max'=>8),

			array('tgl_libur', 'application.components.validator.ADatePickerSwitcherValidatorSP','skipOnError'=>true),
				
			array('tgl_libur, ket_libur, flag_libur, user_id, cre_dt, upd_dt,tgl_libur_date,tgl_libur_month,tgl_libur_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'tgl_libur' => 'Tanggal',
			'ket_libur' => 'Keterangan',
			'flag_libur' => 'Flag Libur',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->tgl_libur_date))
			$criteria->addCondition("TO_CHAR(t.tgl_libur,'DD') LIKE '%".$this->tgl_libur_date."%'");
		if(!empty($this->tgl_libur_month))
			$criteria->addCondition("TO_CHAR(t.tgl_libur,'MM') LIKE '%".$this->tgl_libur_month."%'");
		if(!empty($this->tgl_libur_year))
			$criteria->addCondition("TO_CHAR(t.tgl_libur,'YYYY') LIKE '%".$this->tgl_libur_year."%'");
		else {
			$criteria->addCondition("TO_CHAR(t.tgl_libur,'YYYY') >= ".date('Y'));
		}	
			
		if(!empty($this->ket_libur))
			$criteria->addCondition("UPPER(ket_libur) LIKE UPPER('%".$this->ket_libur."%')");
		$criteria->compare('flag_libur',$this->flag_libur,true);
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
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");
		
		$criteria->addCondition("approved_stat = 'A'");
		
		$sort = array(
			'defaultOrder'=>'tgl_libur DESC',
		);
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}