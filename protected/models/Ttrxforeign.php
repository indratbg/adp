<?php

/**
 * This is the model class for table "T_TRX_FOREIGN".
 *
 * The followings are the available columns in table 'T_TRX_FOREIGN':
 * @property string $tgl_trx
 * @property integer $norut
 * @property string $jenis_trx
 * @property string $currency_type
 * @property double $nilai_rph
 * @property double $untung_unreal
 * @property double $rugi_unreal
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 * @property double $seqno
 */
class Ttrxforeign extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $tgl_trx_date;
	public $tgl_trx_month;
	public $tgl_trx_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	public $old_tgl_trx;
	public $old_norut;
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
		return 'T_TRX_FOREIGN';
	}

	public function rules()
	{
		return array(
		
			array('tgl_trx, approved_dt,old_tgl_trx', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('norut, nilai_rph, untung_unreal, rugi_unreal, seqno', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('tgl_trx, norut', 'required'),
			array('norut', 'numerical', 'integerOnly'=>true),
			array('nilai_rph, untung_unreal, rugi_unreal', 'numerical'),
			array('jenis_trx', 'length', 'max'=>30),
			array('currency_type', 'length', 'max'=>5),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('cre_dt, upd_dt, approved_dt,$old_tgl_trx, $old_norut', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('tgl_trx, norut, jenis_trx, currency_type, nilai_rph, untung_unreal, rugi_unreal, cre_dt, user_id, upd_dt, upd_by, approved_dt, approved_by, approved_stat, seqno,tgl_trx_date,tgl_trx_month,tgl_trx_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'tgl_trx' => 'Tgl Trx',
			'norut' => 'Norut',
			'jenis_trx' => 'Jenis Trx',
			'currency_type' => 'Currency Type',
			'nilai_rph' => 'Nilai Rph',
			'untung_unreal' => 'Untung Unreal',
			'rugi_unreal' => 'Rugi Unreal',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Stat',
			'seqno' => 'Seqno',
		);
	}
		public function executeSp($exec_status,$old_tgl_trx, $old_norut)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_T_TRX_FOREIGN_UPD(
								TO_DATE(:P_SEARCH_TGL_TRX,'YYYY-MM-DD'),
								:P_SEARCH_NORUT,
								TO_DATE(:P_TGL_TRX,'YYYY-MM-DD'),
								:P_NORUT,
								:P_JENIS_TRX,
								:P_CURRENCY_TYPE,
								:P_NILAI_RPH,
								:P_UNTUNG_UNREAL,
								:P_RUGI_UNREAL,
								TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
								:P_USER_ID,
								TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
								:P_UPD_BY,
								:P_SEQNO,
								:P_UPD_STATUS,
								:p_ip_address,
								:p_cancel_reason,
								:p_error_code,
								:p_error_msg)";
			
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_TGL_TRX",$old_tgl_trx,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_NORUT",$old_norut,PDO::PARAM_STR);
			$command->bindValue(":P_TGL_TRX",$this->tgl_trx,PDO::PARAM_STR);
			$command->bindValue(":P_NORUT",$this->norut,PDO::PARAM_STR);
			$command->bindValue(":P_JENIS_TRX",$this->jenis_trx,PDO::PARAM_STR);
			$command->bindValue(":P_CURRENCY_TYPE",$this->currency_type,PDO::PARAM_STR);
			$command->bindValue(":P_NILAI_RPH",$this->nilai_rph,PDO::PARAM_STR);
			$command->bindValue(":P_UNTUNG_UNREAL",$this->untung_unreal,PDO::PARAM_STR);
			$command->bindValue(":P_RUGI_UNREAL",$this->rugi_unreal,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_SEQNO",$this->seqno,PDO::PARAM_STR);
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

		if(!empty($this->tgl_trx_date))
			$criteria->addCondition("TO_CHAR(t.tgl_trx,'DD') LIKE '%".$this->tgl_trx_date."%'");
		if(!empty($this->tgl_trx_month))
			$criteria->addCondition("TO_CHAR(t.tgl_trx,'MM') LIKE '%".$this->tgl_trx_month."%'");
		if(!empty($this->tgl_trx_year))
			$criteria->addCondition("TO_CHAR(t.tgl_trx,'YYYY') LIKE '%".$this->tgl_trx_year."%'");		$criteria->compare('norut',$this->norut);
		$criteria->compare('jenis_trx',$this->jenis_trx,true);
		$criteria->compare('currency_type',$this->currency_type,true);
		$criteria->compare('nilai_rph',$this->nilai_rph);
		$criteria->compare('untung_unreal',$this->untung_unreal);
		$criteria->compare('rugi_unreal',$this->rugi_unreal);

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
		$criteria->compare('approved_stat',$this->approved_stat,true);
		$criteria->compare('seqno',$this->seqno);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}