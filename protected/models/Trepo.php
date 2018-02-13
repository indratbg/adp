<?php

/**
 * This is the model class for table "IPNEXTG.T_REPO".
 *
 * The followings are the available columns in table 'IPNEXTG.T_REPO':
 * @property string $repo_num
 * @property string $repo_ref
 * @property string $extent_num
 * @property string $repo_type
 * @property string $repo_date
 * @property string $extent_dt
 * @property string $due_date
 * @property double $repo_val
 * @property double $return_val
 * @property double $fee
 * @property double $fee_per
 * @property string $client_cd
 * @property string $client_type
 * @property double $sett_val
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $user_id
 */
class Trepo extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $repo_date_date;
	public $repo_date_month;
	public $repo_date_year;

	public $extent_dt_date;
	public $extent_dt_month;
	public $extent_dt_year;

	public $due_date_date;
	public $due_date_month;
	public $due_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $update_seq;
	public $update_date;
	
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
		return 'T_REPO';
	}

	public function executeSp($exec_status,$old_repo_num,$record_seq)
	{
		$connection  = Yii::app()->db;
				
		try{
			$query  = "CALL SP_T_REPO_UPD(
						:P_SEARCH_REPO_NUM,
						:P_REPO_NUM,
						:P_REPO_REF,
						:P_EXTENT_NUM,
						:P_REPO_TYPE,
						TO_DATE(:P_REPO_DATE,'YYYY-MM-DD'),
						TO_DATE(:P_EXTENT_DT,'YYYY-MM-DD'),
						TO_DATE(:P_DUE_DATE,'YYYY-MM-DD'),
						:P_REPO_VAL,
						:P_RETURN_VAL,
						:P_FEE,
						:P_FEE_PER,
						:P_CLIENT_CD,
						:P_CLIENT_TYPE,
						:P_SECU_TYPE,
						:P_SETT_VAL,
						:P_PENGHENTIAN_PENGAKUAN,
						:P_SERAH_SAHAM,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						:P_UPD_BY,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPDATE_SEQ,
						:P_RECORD_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_REPO_NUM",$old_repo_num,PDO::PARAM_STR);
			$command->bindValue(":P_REPO_NUM",$this->repo_num,PDO::PARAM_STR);
			$command->bindValue(":P_REPO_REF",$this->repo_ref,PDO::PARAM_STR);
			$command->bindValue(":P_EXTENT_NUM",$this->extent_num,PDO::PARAM_STR);
			$command->bindValue(":P_REPO_TYPE",$this->repo_type,PDO::PARAM_STR);
			$command->bindValue(":P_REPO_DATE",$this->repo_date,PDO::PARAM_STR);
			$command->bindValue(":P_EXTENT_DT",$this->extent_dt,PDO::PARAM_STR);
			$command->bindValue(":P_DUE_DATE",$this->due_date,PDO::PARAM_STR);
			$command->bindValue(":P_REPO_VAL",$this->repo_val,PDO::PARAM_STR);
			$command->bindValue(":P_RETURN_VAL",$this->return_val,PDO::PARAM_STR);
			$command->bindValue(":P_FEE",$this->fee,PDO::PARAM_STR);
			$command->bindValue(":P_FEE_PER",$this->fee_per,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE",$this->client_type,PDO::PARAM_STR);
			$command->bindValue(":P_SECU_TYPE",$this->secu_type,PDO::PARAM_STR);
			$command->bindValue(":P_SETT_VAL",$this->sett_val,PDO::PARAM_STR);
			$command->bindValue(":P_PENGHENTIAN_PENGAKUAN",$this->penghentian_pengakuan,PDO::PARAM_STR);
			$command->bindValue(":P_SERAH_SAHAM",$this->serah_saham,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);								
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_RECORD_SEQ",$record_seq,PDO::PARAM_STR);	
			
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

	public function rules()
	{
		return array(
		
			array('repo_date, extent_dt, due_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('repo_val, return_val, fee, fee_per, sett_val', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('repo_type,client_cd,repo_ref,repo_date,due_date,repo_val,fee_per,return_val,client_type,secu_type','required'),
			array('repo_date','checkMonthAndYear','on'=>'update'),
			array('repo_val, return_val, fee, fee_per, sett_val', 'numerical'),
			array('repo_ref, extent_num', 'length', 'max'=>30),
			array('repo_type, user_id', 'length', 'max'=>10),
			array('client_cd', 'length', 'max'=>12),
			array('client_type', 'length', 'max'=>1),
			array('serah_saham, penghentian_pengakuan, repo_date, extent_dt, due_date, cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('repo_num, repo_ref, extent_num, repo_type, repo_date, extent_dt, due_date, repo_val, return_val, fee, fee_per, client_cd, client_type, sett_val, cre_dt, upd_dt, user_id,repo_date_date,repo_date_month,repo_date_year,extent_dt_date,extent_dt_month,extent_dt_year,due_date_date,due_date_month,due_date_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function checkMonthAndYear()
	{
		$oldDate = Trepo::model()->find(array('select'=>"TO_CHAR(REPO_DATE,'mm') repo_date_month,TO_CHAR(REPO_DATE,'yyyy') repo_date_year",'condition'=>"repo_num = '$this->repo_num'"));
		$currMonth = DateTime::createFromFormat('Y-m-d',$this->repo_date)->format('m');
		$currYear = DateTime::createFromFormat('Y-m-d',$this->repo_date)->format('Y');
		
		if($oldDate->repo_date_month != $currMonth || $oldDate->repo_date_year != $currYear)
			$this->addError('repo_date', 'Bulan atau tahun Tanggal Perjanjian tidak boleh diubah');
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'repo_num' => 'Repo Num',
			'repo_ref' => 'Nomor Perjanjian',
			'extent_num' => 'Nomor Perpanjangan',
			'repo_type' => 'Type',
			'repo_date' => 'Repo Date',
			'extent_dt' => 'Extension Date',
			'due_date' => 'Due Date',
			'repo_val' => 'Value',
			'return_val' => 'Return Value',
			'fee' => 'Fee',
			'fee_per' => 'Bunga %',
			'client_cd' => 'Client Code',
			'client_type' => 'Client Type',
			'secu_type' => 'Securities Type',
			'sett_val' => 'Sett Val',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'user_id' => 'User',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'repo_num,repo_type,client_cd,repo_date,extent_dt,due_date,NVL(extent_num,repo_ref) repo_ref, repo_val, return_val';
		
		$criteria->compare('repo_num',$this->repo_num,true);
		$criteria->compare('repo_ref',$this->repo_ref,true);
		$criteria->compare('extent_num',$this->extent_num,true);
		$criteria->compare('repo_type',$this->repo_type,true);

		if(!empty($this->repo_date_date))
			$criteria->addCondition("TO_CHAR(t.repo_date,'DD') LIKE '%".$this->repo_date_date."%'");
		if(!empty($this->repo_date_month))
			$criteria->addCondition("TO_CHAR(t.repo_date,'MM') LIKE '%".$this->repo_date_month."%'");
		if(!empty($this->repo_date_year))
			$criteria->addCondition("TO_CHAR(t.repo_date,'YYYY') LIKE '%".$this->repo_date_year."%'");
		if(!empty($this->extent_dt_date))
			$criteria->addCondition("TO_CHAR(t.extent_dt,'DD') LIKE '%".$this->extent_dt_date."%'");
		if(!empty($this->extent_dt_month))
			$criteria->addCondition("TO_CHAR(t.extent_dt,'MM') LIKE '%".$this->extent_dt_month."%'");
		if(!empty($this->extent_dt_year))
			$criteria->addCondition("TO_CHAR(t.extent_dt,'YYYY') LIKE '%".$this->extent_dt_year."%'");
		if(!empty($this->due_date_date))
			$criteria->addCondition("TO_CHAR(t.due_date,'DD') LIKE '%".$this->due_date_date."%'");
		if(!empty($this->due_date_month))
			$criteria->addCondition("TO_CHAR(t.due_date,'MM') LIKE '%".$this->due_date_month."%'");
		if(!empty($this->due_date_year))
			$criteria->addCondition("TO_CHAR(t.due_date,'YYYY') LIKE '%".$this->due_date_year."%'");		$criteria->compare('repo_val',$this->repo_val);
		$criteria->compare('return_val',$this->return_val);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('fee_per',$this->fee_per);
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('client_type',$this->client_type,true);
		$criteria->compare('sett_val',$this->sett_val);

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
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

		$sort = new CSort;
		$sort->defaultOrder = 'client_cd';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}