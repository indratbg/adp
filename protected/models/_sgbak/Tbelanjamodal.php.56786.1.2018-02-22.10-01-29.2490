<?php

/**
 * This is the model class for table "T_BELANJA_MODAL".
 *
 * The followings are the available columns in table 'T_BELANJA_MODAL':
 * @property string $tgl_komitmen
 * @property string $rincian
 * @property string $tgl_realisasi
 * @property double $nilai
 * @property double $sudah_real
 * @property double $belum_real
 * @property string $cre_dt
 * @property string $user_id
 */
class Tbelanjamodal extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $tgl_komitmen_date;
	public $tgl_komitmen_month;
	public $tgl_komitmen_year;

	public $tgl_realisasi_date;
	public $tgl_realisasi_month;
	public $tgl_realisasi_year;

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
    

	public function tableName()
	{
		return 'T_BELANJA_MODAL';
	}

	public function rules()
	{
		return array(
		
			array('tgl_komitmen, tgl_realisasi', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('nilai, sudah_real, belum_real', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('tgl_komitmen', 'required'),
			array('nilai, sudah_real, belum_real', 'numerical'),
			array('rincian', 'length', 'max'=>51),
			array('user_id', 'length', 'max'=>10),
			array('tgl_realisasi, cre_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('tgl_komitmen, rincian, tgl_realisasi, nilai, sudah_real, belum_real, cre_dt, user_id,tgl_komitmen_date,tgl_komitmen_month,tgl_komitmen_year,tgl_realisasi_date,tgl_realisasi_month,tgl_realisasi_year,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
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
			'tgl_komitmen' => 'Tanggal Komitmen',
			'rincian' => 'Rincian',
			'tgl_realisasi' => 'Tanggal Realisasi',
			'nilai' => 'Nilai',
			'sudah_real' => 'Sudah Real',
			'belum_real' => 'Belum Real',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
		);
	}
	public function executeSp($exec_status,$old_seqno)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_T_BELANJA_MODAL_UPD(
							:P_SEARCH_SEQNO,
							TO_DATE(:P_TGL_KOMITMEN,'YYYY-MM-DD'),	
							:P_RINCIAN,
							TO_DATE(:P_TGL_REALISASI,'YYYY-MM-DD'),
							:P_NILAI,
							:P_SUDAH_REAL,
							:P_BELUM_REAL,
							TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
							:P_USER_ID,
							:P_SEQNO,
							TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
							:P_UPD_BY,
							:P_UPD_STATUS,
							:p_ip_address,
							:p_cancel_reason,
							:p_error_code,
							:p_error_msg)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_SEQNO",$old_seqno,PDO::PARAM_STR);
			$command->bindValue(":P_TGL_KOMITMEN",$this->tgl_komitmen,PDO::PARAM_STR);
			$command->bindValue(":P_RINCIAN",$this->rincian,PDO::PARAM_STR);
			$command->bindValue(":P_TGL_REALISASI",$this->tgl_realisasi,PDO::PARAM_STR);
			$command->bindValue(":P_NILAI",$this->nilai,PDO::PARAM_STR);
			$command->bindValue(":P_SUDAH_REAL",$this->sudah_real,PDO::PARAM_STR);
			$command->bindValue(":P_BELUM_REAL",$this->belum_real,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_SEQNO",$this->seqno,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			$transaction->commit();
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

		if(!empty($this->tgl_komitmen_date))
			$criteria->addCondition("TO_CHAR(t.tgl_komitmen,'DD') LIKE '%".$this->tgl_komitmen_date."%'");
		if(!empty($this->tgl_komitmen_month))
			$criteria->addCondition("TO_CHAR(t.tgl_komitmen,'MM') LIKE '%".$this->tgl_komitmen_month."%'");
		if(!empty($this->tgl_komitmen_year))
			$criteria->addCondition("TO_CHAR(t.tgl_komitmen,'YYYY') LIKE '%".$this->tgl_komitmen_year."%'");		$criteria->compare('rincian',$this->rincian,true);

		if(!empty($this->tgl_realisasi_date))
			$criteria->addCondition("TO_CHAR(t.tgl_realisasi,'DD') LIKE '%".$this->tgl_realisasi_date."%'");
		if(!empty($this->tgl_realisasi_month))
			$criteria->addCondition("TO_CHAR(t.tgl_realisasi,'MM') LIKE '%".$this->tgl_realisasi_month."%'");
		if(!empty($this->tgl_realisasi_year))
			$criteria->addCondition("TO_CHAR(t.tgl_realisasi,'YYYY') LIKE '%".$this->tgl_realisasi_year."%'");		$criteria->compare('nilai',$this->nilai);
		$criteria->compare('sudah_real',$this->sudah_real);
		$criteria->compare('belum_real',$this->belum_real);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}