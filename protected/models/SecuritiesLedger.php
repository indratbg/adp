<?php

/**
 * This is the model class for table "MST_SECURITIES_LEDGER".
 *
 * The followings are the available columns in table 'MST_SECURITIES_LEDGER':
 * @property string $sl_code
 * @property string $sl_desc
 * @property string $gl_acct_cd
 * @property string $fl_dbcr
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $ver_bgn_dt
 * @property string $ver_end_dt
 * @property string $user_id
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class SecuritiesLedger extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $ver_bgn_dt_date;
	public $ver_bgn_dt_month;
	public $ver_bgn_dt_year;

	public $ver_end_dt_date;
	public $ver_end_dt_month;
	public $ver_end_dt_year;
	
	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	
	//AH: #END search (datetime || date)  additional comparison
	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	protected function afterFind()
	{
		$this->ver_bgn_dt = Yii::app()->format->cleanDate($this->ver_bgn_dt);
		$this->ver_end_dt = Yii::app()->format->cleanDate($this->ver_end_dt);
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
	public function getPrimaryKey(){
		return array('gl_acct_cd'=>trim($this->gl_acct_cd), 'ver_bgn_dt'=>$this->ver_bgn_dt);
	}

	public function tableName()
	{
		return 'MST_SECURITIES_LEDGER';
	}

	public function rules()
	{
		return array(
		
			array('ver_bgn_dt, ver_end_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('sl_code, fl_dbcr, gl_acct_cd, ver_bgn_dt', 'required'),
			array('sl_code', 'length', 'max'=>12),
			array('sl_desc', 'length', 'max'=>60),
			array('fl_dbcr', 'length', 'max'=>1),
			array('user_id, upd_by', 'length', 'max'=>10),
			array('cre_dt, upd_dt, ver_end_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('sl_code, sl_desc, gl_acct_cd, fl_dbcr, cre_dt, user_id, upd_dt, upd_by, ver_bgn_dt, ver_end_dt, cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,ver_bgn_dt_date,ver_bgn_dt_month,ver_bgn_dt_year,
			ver_end_dt_date,ver_end_dt_month,ver_end_dt_year,approved_dt_date,approved_dt_month,approved_dt_year,approved_by,approved_stat', 'safe', 'on'=>'search'),
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
			'sl_code' => 'MKBD vd57 Line No.',
			'sl_desc' => 'Description',
			'gl_acct_cd' => 'Acct Code',
			'fl_dbcr' => 'Debit / Credit',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User ID',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'ver_bgn_dt' => 'Version From',
			'ver_end_dt' => 'To',
		);
	}
	
	public function executeSp($exec_status, $old_gl_acct_cd, $old_ver_bgn_dt)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_MST_SECURITIES_LEDGER_UPD(
						:P_SEARCH_GL_ACCT_CD,TO_DATE(:P_SEARCH_VER_BGN_DT,'YYYY-MM-DD'),:P_SL_CODE,:P_SL_DESC,:P_GL_ACCT_CD,:P_FL_DBCR,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),:P_UPD_BY,TO_DATE(:P_VER_BGN_DT,'YYYY-MM-DD'),TO_DATE(:P_VER_END_DT,'YYYY-MM-DD'),
						:P_USER_ID, :P_UPD_STATUS,:P_IP_ADDRESS,
						:P_CANCEL_REASON,:P_ERROR_CODE,:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_GL_ACCT_CD",$old_gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_VER_BGN_DT",$old_ver_bgn_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SL_CODE",$this->sl_code,PDO::PARAM_STR);
			$command->bindValue(":P_SL_DESC",$this->sl_desc,PDO::PARAM_STR);
			$command->bindValue(":P_GL_ACCT_CD",$this->gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_FL_DBCR",$this->fl_dbcr,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_VER_BGN_DT",$this->ver_bgn_dt,PDO::PARAM_STR);
			$command->bindValue(":P_VER_END_DT",$this->ver_end_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);

			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

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


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('sl_code',$this->sl_code,true);
		$criteria->compare('sl_desc',$this->sl_desc,true);
		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('fl_dbcr',$this->fl_dbcr,true);

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

		if(!empty($this->ver_bgn_dt_date))
			$criteria->addCondition("TO_CHAR(t.ver_bgn_dt,'DD') LIKE '%".$this->ver_bgn_dt_date."%'");
		if(!empty($this->ver_bgn_dt_month))
			$criteria->addCondition("TO_CHAR(t.ver_bgn_dt,'MM') LIKE '%".$this->ver_bgn_dt_month."%'");
		if(!empty($this->ver_bgn_dt_year))
			$criteria->addCondition("TO_CHAR(t.ver_bgn_dt,'YYYY') LIKE '%".$this->ver_bgn_dt_year."%'");
		if(!empty($this->ver_end_dt_date))
			$criteria->addCondition("TO_CHAR(t.ver_end_dt,'DD') LIKE '%".$this->ver_end_dt_date."%'");
		if(!empty($this->ver_end_dt_month))
			$criteria->addCondition("TO_CHAR(t.ver_end_dt,'MM') LIKE '%".$this->ver_end_dt_month."%'");
		if(!empty($this->ver_end_dt_year))
			$criteria->addCondition("TO_CHAR(t.ver_end_dt,'YYYY') LIKE '%".$this->ver_end_dt_year."%'");
			
		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
			
		$criteria->compare('approved_stat',$this->approved_stat,true);
		//$criteria->addCondition("approved_stat NOT LIKE 'C'");
		
		//$criteria->order = 'ver_bgn_dt, sl_code';
		
		
		$sort = new CSort();
		$sort->defaultOrder = 'sl_code';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}