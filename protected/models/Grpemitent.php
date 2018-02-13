<?php

/**
 * This is the model class for table "MST_GRP_EMITENT".
 *
 * The followings are the available columns in table 'MST_GRP_EMITENT':
 * @property string $grp_emi
 * @property string $grp_type
 * @property string $stk_cd
 * @property string $eff_dt
 * @property string $cre_dt
 * @property string $user_id
 * @property integer $seqno
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Grpemitent extends AActiveRecordSP
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
		return 'MST_GRP_EMITENT';
	}

	public function rules()
	{
		return array(
		
			array('eff_dt, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('seqno', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('grp_emi', 'length', 'max'=>25),
			array('grp_type, approved_stat', 'length', 'max'=>1),
			array('stk_cd', 'length', 'max'=>50),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('eff_dt, cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('grp_emi, grp_type, stk_cd, eff_dt, cre_dt, user_id, seqno, upd_dt, upd_by, approved_dt, approved_by, approved_stat,eff_dt_date,eff_dt_month,eff_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'grp_emi' => 'Grp Emi',
			'grp_type' => 'Grp Type',
			'stk_cd' => 'Stk Code',
			'eff_dt' => 'Eff Date',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'seqno' => 'Seqno',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Stat',
		);
	}
public function executeSp($exec_status,$old_seqno)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_MST_GRP_EMITENT_UPD(
						:P_SEARCH_SEQNO,
						:P_GRP_EMI,
						:P_GRP_TYPE,
						:P_STK_CD,
						TO_DATE(:P_EFF_DT,'YYYY-MM-DD'),
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
			$command->bindValue(":P_GRP_EMI",$this->grp_emi,PDO::PARAM_STR);
			$command->bindValue(":P_GRP_TYPE",$this->grp_type,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_EFF_DT",$this->eff_dt,PDO::PARAM_STR);
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
		$criteria->compare('grp_emi',$this->grp_emi,true);
		$criteria->compare('grp_type',$this->grp_type,true);
		$criteria->compare('stk_cd',$this->stk_cd,true);

		if(!empty($this->eff_dt_date))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'DD') LIKE '%".$this->eff_dt_date."%'");
		if(!empty($this->eff_dt_month))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'MM') LIKE '%".$this->eff_dt_month."%'");
		if(!empty($this->eff_dt_year))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'YYYY') LIKE '%".$this->eff_dt_year."%'");
		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('seqno',$this->seqno);

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