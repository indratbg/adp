<?php

/**
 * This is the model class for table "T_IPO_CLIENT".
 *
 * The followings are the available columns in table 'T_IPO_CLIENT':
 * @property string $client_cd
 * @property string $stk_cd
 * @property integer $fixed_qty
 * @property integer $pool_qty
 * @property integer $alloc_qty
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Tipoclientimport extends AActiveRecordSP
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
	//AH: #END search (datetime || date)  additional comparison
	
	public $data_type;
	public $source_file;
	public $batch;
	
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
		return 'T_IPO_CLIENT';
	}
	
	public function executeSp($client,$qty)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_T_IPO_CLIENT_UPL(
						:P_SEARCH_CLIENT_CD,
						:P_SEARCH_STK_CD,
						:P_CLIENT_CD,
						:P_STK_CD,
						:P_DATA_TYPE,
						:P_QTY,
						:P_BATCH,
						:P_IPO_PERC,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_CLIENT_CD",$client,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$client,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_DATA_TYPE",$this->data_type,PDO::PARAM_STR);
			$command->bindValue(":P_QTY",$qty,PDO::PARAM_STR);
			$command->bindValue(":P_BATCH",$this->batch,PDO::PARAM_STR);
			$command->bindValue(":P_IPO_PERC",$this->ipo_perc,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
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
			$this->addError('error_msg', $client.' Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

	public function rules()
	{
		return array(
		
			array('approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('fixed_qty, pool_qty, alloc_qty', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('stk_cd,data_type,ipo_perc','required'),
			array('source_file','file','allowEmpty'=>false,'types'=>'txt','wrongType'=>'File type must be "txt"'),
			
			array('fixed_qty, pool_qty, alloc_qty', 'numerical', 'integerOnly'=>true),
			array('batch', 'length', 'max'=>10),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, stk_cd, fixed_qty, pool_qty, alloc_qty, cre_dt, user_id, upd_dt, upd_by, approved_dt, approved_by, approved_stat,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'client_cd' => 'Client Code',
			'stk_cd' => 'Stk Code',
			'fixed_qty' => 'Fixed Qty',
			'pool_qty' => 'Pool Qty',
			'alloc_qty' => 'Alloc Qty',
			'ipo_perc' => 'IPO Fee (%)',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('fixed_qty',$this->fixed_qty);
		$criteria->compare('pool_qty',$this->pool_qty);
		$criteria->compare('alloc_qty',$this->alloc_qty);

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