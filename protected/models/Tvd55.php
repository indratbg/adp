<?php

/**
 * This is the model class for table "T_VD55".
 *
 * The followings are the available columns in table 'T_VD55':
 * @property string $mkbd_date
 * @property string $mkbd_cd
 * @property string $line_desc
 * @property string $tanggal
 * @property integer $qty1
 * @property integer $qty2
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Tvd55 extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $mkbd_date_date;
	public $mkbd_date_month;
	public $mkbd_date_year;

	public $tanggal_date;
	public $tanggal_month;
	public $tanggal_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	
	public $save_flg ='N';
	public $old_mkbd_cd;
	public $old_mkbd_date;
	public $new_mkbd_date;

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
		return 'T_VD55';
	}

	public function rules()
	{
		return array(
		
			array('mkbd_date,old_mkbd_date tanggal, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('qty1, qty2', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('mkbd_cd,mkbd_date', 'required'),
			array('qty1, qty2', 'numerical', 'integerOnly'=>true),
			array('line_desc', 'length', 'max'=>80),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('tanggal, cre_dt,save_flg, old_mkbd_cd, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('mkbd_date, mkbd_cd, line_desc, tanggal, qty1, qty2, cre_dt, user_id, upd_dt, upd_by, approved_dt, approved_by, approved_stat,mkbd_date_date,mkbd_date_month,mkbd_date_year,tanggal_date,tanggal_month,tanggal_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'mkbd_date' => 'Date',
			'mkbd_cd' => 'Mkbd Code',
			'line_desc' => 'Line Desc',
			'tanggal' => 'Tanggal',
			'qty1' => 'Qty1',
			'qty2' => 'Qty2',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Stat',
		);
	}
public function executeSp($exec_status,$old_mkbd_date,$old_mkbd_cd)
	{
		$connection  = Yii::app()->db;
		
		 $this->user_id = Yii::app()->user->id;
		
		try{
			$query  = "CALL Sp_T_VD55_Upd(
									TO_DATE(:P_SEARCH_MKBD_DATE,'YYYY-MM-DD'),
									:P_SEARCH_MKBD_CD,
									TO_DATE(:P_MKBD_DATE,'YYYY-MM-DD'),
									:P_MKBD_CD,
									:P_LINE_DESC,
									TO_DATE(:P_TANGGAL,'YYYY-MM-DD'),
									:P_QTY1,
									:P_QTY2,
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
			$command->bindValue(":P_SEARCH_MKBD_DATE",$old_mkbd_date,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_MKBD_CD",$old_mkbd_cd,PDO::PARAM_STR);
			$command->bindValue(":P_MKBD_DATE",$this->mkbd_date,PDO::PARAM_STR);
			$command->bindValue(":P_MKBD_CD",$this->mkbd_cd,PDO::PARAM_STR);
			$command->bindValue(":P_LINE_DESC",$this->line_desc,PDO::PARAM_STR);
			$command->bindValue(":P_TANGGAL",$this->tanggal,PDO::PARAM_STR);
			$command->bindValue(":P_QTY1",$this->qty1,PDO::PARAM_STR);
			$command->bindValue(":P_QTY2",$this->qty2,PDO::PARAM_STR);
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

		if(!empty($this->mkbd_date_date))
			$criteria->addCondition("TO_CHAR(t.mkbd_date,'DD') LIKE '%".$this->mkbd_date_date."%'");
		if(!empty($this->mkbd_date_month))
			$criteria->addCondition("TO_CHAR(t.mkbd_date,'MM') LIKE '%".$this->mkbd_date_month."%'");
		if(!empty($this->mkbd_date_year))
			$criteria->addCondition("TO_CHAR(t.mkbd_date,'YYYY') LIKE '%".$this->mkbd_date_year."%'");		$criteria->compare('mkbd_cd',$this->mkbd_cd,true);
		$criteria->compare('line_desc',$this->line_desc,true);

		if(!empty($this->tanggal_date))
			$criteria->addCondition("TO_CHAR(t.tanggal,'DD') LIKE '%".$this->tanggal_date."%'");
		if(!empty($this->tanggal_month))
			$criteria->addCondition("TO_CHAR(t.tanggal,'MM') LIKE '%".$this->tanggal_month."%'");
		if(!empty($this->tanggal_year))
			$criteria->addCondition("TO_CHAR(t.tanggal,'YYYY') LIKE '%".$this->tanggal_year."%'");		$criteria->compare('qty1',$this->qty1);
		$criteria->compare('qty2',$this->qty2);

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