<?php

/**
 * This is the model class for table "T_CORP_GUARANTEE".
 *
 * The followings are the available columns in table 'T_CORP_GUARANTEE':
 * @property string $contract_dt
 * @property string $end_contract_dt
 * @property string $guaranteed
 * @property string $afiliasi
 * @property string $rincian
 * @property string $jangka
 * @property double $nilai
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Tcorpguarantee extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $contract_dt_date;
	public $contract_dt_month;
	public $contract_dt_year;

	public $end_contract_dt_date;
	public $end_contract_dt_month;
	public $end_contract_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	public $save_flg = 'N';
	public $cancel_flg = 'N';
	public $old_contract_dt;
	public $old_guaranteed;
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
		return 'T_CORP_GUARANTEE';
	}

	public function rules()
	{
		return array(
		
			array('contract_dt, end_contract_dt, approved_dt,old_contract_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('nilai', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('contract_dt,afiliasi,guaranteed,end_contract_dt', 'required'),
			array('nilai', 'numerical'),
			array('afiliasi', 'length', 'max'=>20),
			array('rincian, jangka', 'length', 'max'=>30),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('cre_dt, ,cancel_flg,save_flg,old_contract_dt,old_guaranteed,upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('contract_dt, end_contract_dt, guaranteed, afiliasi, rincian, jangka, nilai, cre_dt, user_id, upd_dt, upd_by, approved_dt, approved_by, approved_stat,contract_dt_date,contract_dt_month,contract_dt_year,end_contract_dt_date,end_contract_dt_month,end_contract_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'contract_dt' => 'Contract Date',
			'end_contract_dt' => 'End Contract Date',
			'guaranteed' => 'Guaranteed',
			'afiliasi' => 'Afiliasi',
			'rincian' => 'Rincian',
			'jangka' => 'Jangka',
			'nilai' => 'Nilai',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Stat',
		);
	}
	public function executeSp($exec_status,$old_contract_dt,$old_guaranteed)
	{
		$connection  = Yii::app()->db;
	
		
		try{
			$query  = "CALL SP_T_CORP_GUARANTEE_UPD(
						
						TO_DATE(:P_SEARCH_CONTRACT_DT,'YYYY-MM-DD'),
						:P_SEARCH_GUARANTEED,
						TO_DATE(:P_CONTRACT_DT,'YYYY-MM-DD'),
						TO_DATE(:P_END_CONTRACT_DT,'YYYY-MM-DD'),
						:P_GUARANTEED,
						:P_AFILIASI,
						:P_RINCIAN,
						:P_JANGKA,
						:P_NILAI,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_ERROR_CODE,
						:P_ERROR_MSG )";		
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_CONTRACT_DT",$old_contract_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_GUARANTEED",$old_guaranteed,PDO::PARAM_STR);
			$command->bindValue(":P_CONTRACT_DT",$this->contract_dt,PDO::PARAM_STR);
			$command->bindValue(":P_END_CONTRACT_DT",$this->end_contract_dt,PDO::PARAM_STR);
			$command->bindValue(":P_GUARANTEED",$this->guaranteed,PDO::PARAM_STR);
			$command->bindValue(":P_AFILIASI",$this->afiliasi,PDO::PARAM_STR);
			$command->bindValue(":P_RINCIAN",$this->rincian,PDO::PARAM_STR);
			$command->bindValue(":P_JANGKA",$this->jangka,PDO::PARAM_STR);
			$command->bindValue(":P_NILAI",$this->nilai,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
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


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->contract_dt_date))
			$criteria->addCondition("TO_CHAR(t.contract_dt,'DD') LIKE '%".$this->contract_dt_date."%'");
		if(!empty($this->contract_dt_month))
			$criteria->addCondition("TO_CHAR(t.contract_dt,'MM') LIKE '%".$this->contract_dt_month."%'");
		if(!empty($this->contract_dt_year))
			$criteria->addCondition("TO_CHAR(t.contract_dt,'YYYY') LIKE '%".$this->contract_dt_year."%'");
		if(!empty($this->end_contract_dt_date))
			$criteria->addCondition("TO_CHAR(t.end_contract_dt,'DD') LIKE '%".$this->end_contract_dt_date."%'");
		if(!empty($this->end_contract_dt_month))
			$criteria->addCondition("TO_CHAR(t.end_contract_dt,'MM') LIKE '%".$this->end_contract_dt_month."%'");
		if(!empty($this->end_contract_dt_year))
			$criteria->addCondition("TO_CHAR(t.end_contract_dt,'YYYY') LIKE '%".$this->end_contract_dt_year."%'");		$criteria->compare('guaranteed',$this->guaranteed,true);
		$criteria->compare('afiliasi',$this->afiliasi,true);
		$criteria->compare('rincian',$this->rincian,true);
		$criteria->compare('jangka',$this->jangka,true);
		$criteria->compare('nilai',$this->nilai);

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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}