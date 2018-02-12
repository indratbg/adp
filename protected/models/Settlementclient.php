<?php

/**
 * This is the model class for table "MST_SETTLEMENT_CLIENT".
 *
 * The followings are the available columns in table 'MST_SETTLEMENT_CLIENT':
 * @property string $exch_cd
 * @property string $client_cd
 * @property string $eff_dt
 * @property string $market_type
 * @property string $ctr_type
 * @property string $sale_sts
 * @property string $script_sts
 * @property integer $csd_script
 * @property integer $csd_value
 * @property integer $kds_script
 * @property integer $kds_value
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Settlementclient extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $eff_dt_date;
	public $eff_dt_month;
	public $eff_dt_year;

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
	
	/*
	 *  AH: provide all date only field in here , 
	 *    to change format from yyyy-mm-dd 00:00:00 into yyyy-mm-dd
	 */
	protected function afterFind()
	{
		$this->eff_dt = Yii::app()->format->cleanDate($this->eff_dt);
	}
	
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
		return 'MST_SETTLEMENT_CLIENT';
	}
	
	public function getPrimaryKey()
	{
		return array('eff_dt'=>$this->eff_dt,'client_cd'=>$this->client_cd,'market_type'=>$this->market_type,'ctr_type'=>$this->ctr_type,'sale_sts'=>$this->sale_sts);	
	}
	
	

	public function rules()
	{
		return array(
			array('client_cd,ctr_type,market_type,eff_dt,sale_sts,csd_script,kds_value,csd_value','required'),
			
			array('csd_script, csd_value, kds_script, kds_value', 'application.components.validator.ANumberSwitcherValidator'),
			array('eff_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP','skipOnError'=>true),
			
			array('csd_script, csd_value, kds_script, kds_value', 'numerical', 'integerOnly'=>true),
			array('script_sts, approved_stat', 'length', 'max'=>1),
			array('user_id', 'length', 'max'=>8),
			array('approved_by', 'length', 'max'=>10),
			array('cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('exch_cd, client_cd, eff_dt, market_type, ctr_type, sale_sts, script_sts, csd_script, csd_value, kds_script, kds_value, user_id, cre_dt, upd_dt,eff_dt_date,eff_dt_month,eff_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year, approved_dt, approved_by, approved_stat,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}
	
	/*
	 *  AH: this function is for executing procedure
	 *  exec_status  : I/U/C
	 */
	public function executeSp($exec_status,$eff_dt,$client_cd,$market_type,$ctr_type,$sale_sts)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		$this->kds_script=$this->kds_value;
		
		try{
			$query  = "CALL SP_MST_SETTLEMENT_CLIENT_UPD(
						:P_SEARCH_CLIENT_CD, TO_DATE(:P_SEARCH_EFF_DT,'YYYY-MM-DD'),
						:P_SEARCH_MARKET_TYPE,:P_SEARCH_CTR_TYPE,:P_SEARCH_SALE_STS,
						
						:P_EXCH_CD,:P_CLIENT_CD, TO_DATE(:P_EFF_DT,'YYYY-MM-DD'),
						:P_MARKET_TYPE,:P_CTR_TYPE,:P_SALE_STS,
						:P_SCRIPT_STS,:P_CSD_SCRIPT,:P_CSD_VALUE,
						:P_KDS_SCRIPT,:P_KDS_VALUE,
						
						:P_USER_ID,TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),:P_UPD_BY,
						:P_UPD_STATUS,:P_IP_ADDRESS,:P_CANCEL_REASON,
						:P_ERROR_CODE,:P_ERROR_MSG)";
						
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_SEARCH_CLIENT_CD",$client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_EFF_DT",$eff_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_MARKET_TYPE",$market_type,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_CTR_TYPE",$ctr_type,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_SALE_STS",$sale_sts,PDO::PARAM_STR);
			
			$command->bindValue(":P_EXCH_CD",$this->exch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_EFF_DT",$this->eff_dt,PDO::PARAM_STR);
			$command->bindValue(":P_MARKET_TYPE",$this->market_type,PDO::PARAM_STR);
			$command->bindValue(":P_CTR_TYPE",$this->ctr_type,PDO::PARAM_STR);
			$command->bindValue(":P_SALE_STS",$this->sale_sts,PDO::PARAM_STR);
			$command->bindValue(":P_SCRIPT_STS",$this->script_sts,PDO::PARAM_STR);
			$command->bindValue(":P_CSD_SCRIPT",$this->csd_script,PDO::PARAM_STR);
			$command->bindValue(":P_CSD_VALUE",$this->csd_value,PDO::PARAM_STR);
			$command->bindValue(":P_KDS_SCRIPT",$this->kds_script,PDO::PARAM_STR);
			$command->bindValue(":P_KDS_VALUE",$this->kds_value,PDO::PARAM_STR);
			
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,200);

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

	public function relations()
	{
		return array(
			//'client' => array(self::BELONGS_TO, 'Client', array('client_cd'=>'client_cd')),
		);
	}

	public function attributeLabels()
	{
		return array(
			'client_cd' => 'Client',
			'ctr_type' => 'Stock Type',
			'market_type' => 'Market Type',
			'eff_dt' => 'Effective Date',
			'sale_sts' => 'Buy / Sell',
			
			'csd_script' => 'KSEI settlement days',
			'kds_value' => 'KPEI settlement days',
			'csd_value' => 'Client AR/AP settlement days',
			
			'kds_script'=> 'KDS Script',
			'exch_cd' => 'Exch Code',
			'script_sts' => 'Script Sts',
			
			'user_id' => 'Create By',
			'cre_dt' => 'Create Date',
			'upd_dt' => 'Update Date',
			'upd_by' => 'Update By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('exch_cd',$this->exch_cd,true);
		$criteria->addCondition("UPPER(client_cd) LIKE UPPER('".$this->client_cd."%')");

		if(!empty($this->eff_dt_date))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'DD') LIKE '%".$this->eff_dt_date."%'");
		if(!empty($this->eff_dt_month))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'MM') LIKE '%".$this->eff_dt_month."%'");
		if(!empty($this->eff_dt_year))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'YYYY') LIKE '%".$this->eff_dt_year."%'");		$criteria->compare('market_type',$this->market_type,true);
		$criteria->compare('ctr_type',$this->ctr_type,true);
		$criteria->compare('sale_sts',$this->sale_sts,true);
		$criteria->compare('script_sts',$this->script_sts,true);
		$criteria->compare('csd_script',$this->csd_script);
		$criteria->compare('csd_value',$this->csd_value);
		$criteria->compare('kds_script',$this->kds_script);
		$criteria->compare('kds_value',$this->kds_value);
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
		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);
		//$criteria->order = 'eff_dt, client_cd, market_type, ctr_type, sale_sts';
		$sort = new CSort();
		$sort->defaultOrder = 'eff_dt desc, client_cd';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}