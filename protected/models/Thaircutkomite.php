<?php

/**
 * This is the model class for table "T_HAIRCUT_KOMITE".
 *
 * The followings are the available columns in table 'T_HAIRCUT_KOMITE':
 * @property string $status_dt
 * @property string $stk_cd
 * @property double $haircut
 * @property string $create_dt
 * @property string $eff_dt
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Thaircutkomite extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $status_dt_date;
	public $status_dt_month;
	public $status_dt_year;

	public $create_dt_date;
	public $create_dt_month;
	public $create_dt_year;

	public $eff_dt_date;
	public $eff_dt_month;
	public $eff_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	public $old_eff_dt;
	public $old_stk_cd;
	public $old_status_dt;
	public $file_upload;
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
		return 'T_HAIRCUT_KOMITE';
	}

	public function rules()
	{
		return array(
		
			array('status_dt, create_dt,old_eff_dt, eff_dt,old_status_dt,eff_dt, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('file_upload','file','types'=>'txt','wrongType'=>'File type must be txt','on'=>'upload'),
			array('haircut', 'application.components.validator.ANumberSwitcherValidator'),
			array('eff_dt,stk_cd,status_dt','required','except'=>'upload'),
			array('haircut','checkhaircut'),
			array('haircut', 'numerical'),
			array('upd_by, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('file_upload,create_dt, eff_dt, stk_cd,upd_dt, approved_dt,old_eff_dt,old_stk_cd,old_status_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('status_dt, stk_cd, haircut, create_dt, eff_dt, upd_dt, upd_by, approved_dt, approved_by, approved_stat,status_dt_date,status_dt_month,status_dt_year,create_dt_date,create_dt_month,create_dt_year,eff_dt_date,eff_dt_month,eff_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}
		public function checkhaircut(){
			
			if ($this->haircut >100 || ($this->haircut<0)) {
				$this->addError('haircut','Tidak Boleh Lebih Dari 100');
			}	
		}
	public function getPrimaryKey()
	{
		return array('status_dt'=>$this->status_dt,'stk_cd' => $this->stk_cd,'eff_dt' => $this->eff_dt);
	}
	
	public function relations()
	{
		return array(
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'status_dt' => 'Status Date',
			'stk_cd' => 'Stock Cd',
			'haircut' => 'Haircut',
			'cre_dt' => 'Create Date',
			'eff_dt' => 'Effective Date',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Stat',
		);
	}
	public function executeSp($exec_status,$old_status_dt,$old_stk_cd,$old_eff_dt)
	{
		$connection  = Yii::app()->db;
	
		
		try{
			$query  = "CALL SP_T_HAIRCUT_KOMITE_UPD(
									TO_DATE(:P_SEARCH_STATUS_DT,'YYYY-MM-DD'),
									TO_DATE(:P_SEARCH_EFF_DT,'YYYY-MM-DD'),
									:P_SEARCH_STK_CD,
									TO_DATE(:P_STATUS_DT,'YYYY-MM-DD'),
									:P_STK_CD,
									:P_HAIRCUT,
									TO_DATE(:P_CREATE_DT,'YYYY-MM-DD HH24:MI:SS'),
									TO_DATE(:P_EFF_DT,'YYYY-MM-DD'),
									TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
									:P_UPD_BY,
									:P_USER_ID,
									TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
									:P_UPD_STATUS,
									:p_ip_address,
									:p_cancel_reason,
									:p_error_code,
									:p_error_msg)";		
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_STATUS_DT",$old_status_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_EFF_DT",$old_eff_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_STK_CD",$old_stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_STATUS_DT",$this->status_dt,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_HAIRCUT",$this->haircut,PDO::PARAM_STR);
			$command->bindValue(":P_CREATE_DT",$this->create_dt,PDO::PARAM_STR);
			$command->bindValue(":P_EFF_DT",$this->eff_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
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

		if(!empty($this->status_dt_date))
			$criteria->addCondition("TO_CHAR(t.status_dt,'DD') LIKE '%".$this->status_dt_date."%'");
		if(!empty($this->status_dt_month))
			$criteria->addCondition("TO_CHAR(t.status_dt,'MM') LIKE '%".$this->status_dt_month."%'");
		if(!empty($this->status_dt_year))
			$criteria->addCondition("TO_CHAR(t.status_dt,'YYYY') LIKE '%".$this->status_dt_year."%'");		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('haircut',$this->haircut);

		if(!empty($this->create_dt_date))
			$criteria->addCondition("TO_CHAR(t.create_dt,'DD') LIKE '%".$this->create_dt_date."%'");
		if(!empty($this->create_dt_month))
			$criteria->addCondition("TO_CHAR(t.create_dt,'MM') LIKE '%".$this->create_dt_month."%'");
		if(!empty($this->create_dt_year))
			$criteria->addCondition("TO_CHAR(t.create_dt,'YYYY') LIKE '%".$this->create_dt_year."%'");
		if(!empty($this->eff_dt_date))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'DD') LIKE '%".$this->eff_dt_date."%'");
		if(!empty($this->eff_dt_month))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'MM') LIKE '%".$this->eff_dt_month."%'");
		if(!empty($this->eff_dt_year))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'YYYY') LIKE '%".$this->eff_dt_year."%'");
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

		$sort = new CSort();
		$sort->defaultOrder = 'eff_dt desc,stk_cd';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}