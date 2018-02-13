<?php

/**
 * This is the model class for table "T_PORTO_JAMINAN".
 *
 * The followings are the available columns in table 'T_PORTO_JAMINAN':
 * @property string $from_dt
 * @property string $client_cd
 * @property string $stk_cd
 * @property integer $qty
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Tportojaminan extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $from_dt_date;
	public $from_dt_month;
	public $from_dt_year;

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
		return 'T_PORTO_JAMINAN';
	}

	public function getPrimaryKey()
	{
		return array('from_dt'=>$this->from_dt,'client_cd'=>$this->client_cd,'stk_cd'=>$this->stk_cd);
	}

	public function executeSp($exec_status,$old_from_dt,$old_client_cd,$old_stk_cd)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_T_PORTO_JAMINAN_UPD(
						TO_DATE(:P_SEARCH_FROM_DT,'YYYY-MM-DD'),
						:P_SEARCH_CLIENT_CD,
						:P_SEARCH_STK_CD,
						TO_DATE(:P_FROM_DT,'YYYY-MM-DD'),
						:P_CLIENT_CD,
						:P_STK_CD,
						:P_QTY,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_FROM_DT",$old_from_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_CLIENT_CD",$old_client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_STK_CD",$old_stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_FROM_DT",$this->from_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_QTY",$this->qty,PDO::PARAM_STR);
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

	public function rules()
	{
		return array(
		
			array('from_dt, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('qty', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('from_dt, client_cd, stk_cd, qty', 'required'),
			array('qty', 'numerical', 'integerOnly'=>true),
			array('client_cd, stk_cd', 'length', 'max'=>12),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('from_dt, client_cd, stk_cd, qty, cre_dt, user_id, upd_dt, upd_by, approved_dt, approved_by, approved_stat,from_dt_date,from_dt_month,from_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'from_dt' => 'Date',
			'client_cd' => 'Client Code',
			'stk_cd' => 'Stock',
			'qty' => 'Total Quantity',
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

		if(!empty($this->from_dt_date))
			$criteria->addCondition("TO_CHAR(t.from_dt,'DD') LIKE '%".$this->from_dt_date."%'");
		if(!empty($this->from_dt_month))
			$criteria->addCondition("TO_CHAR(t.from_dt,'MM') LIKE '%".$this->from_dt_month."%'");
		if(!empty($this->from_dt_year))
			$criteria->addCondition("TO_CHAR(t.from_dt,'YYYY') LIKE '%".$this->from_dt_year."%'");		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('qty',$this->qty);

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
		
		$sort = new CSort;
		$sort->defaultOrder = 'FROM_DT DESC, STK_CD';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}