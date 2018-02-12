<?php

/**
 * This is the model class for table "T_BAL_FOREIGN_CURRENCY".
 *
 * The followings are the available columns in table 'T_BAL_FOREIGN_CURRENCY':
 * @property string $bal_dt
 * @property string $gl_acct_cd
 * @property string $sl_acct_cd
 * @property string $curr_cd
 * @property double $bal_amount
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_sts
 */
class Tbalforeigncurrency extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $bal_dt_date;
	public $bal_dt_month;
	public $bal_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	public $folder_cd;
	public $rowid;
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
		return 'T_BAL_FOREIGN_CURRENCY';
	}

	public function rules()
	{
		return array(
		
			array('bal_dt, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('bal_amount', 'application.components.validator.ANumberSwitcherValidator'),
			array('gl_acct_cd,sl_acct_cd,bal_dt,bal_amount','required','on'=>'insert'),
			array('bal_amount', 'numerical'),
			array('curr_cd', 'length', 'max'=>3),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_sts', 'length', 'max'=>1),
			array('rowid,gl_acct_cd,sl_acct_cd,folder_cd,cre_dt, upd_dt, approved_dt', 'safe'),
			array('folder_cd','cekFolder','on'=>'generate'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('bal_dt, gl_acct_cd, sl_acct_cd, curr_cd, bal_amount, cre_dt, user_id, upd_dt, upd_by, approved_dt, approved_by, approved_sts,bal_dt_date,bal_dt_month,bal_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}
	public function cekFolder()
	{
		$cek =  Sysparam::model()->find(" param_id='SYSTEM' AND PARAM_CD1='VCH_REF'")->dflg1;
		if($cek=='Y' && $this->folder_cd =='')
		{
			$this->addError('folder_cd', 'File No. tidak boleh kosong');
		}
		
	}
	public static function getGenKursJournal($date)
	{
		$sql ="SELECT b.bal_dt,
				  b.gl_acct_cd,
				  b.sl_acct_cd,
				  b.bal_amount,
				  '' folder_cd
				FROM
				  (SELECT gl_acct_cd,
				    sl_acct_cd,
				    MAX(bal_dt) max_dt
				  FROM T_BAL_FOREIGN_CURREncy
				  WHERE bal_dt <= to_date('$date','dd/mm/yyyy')
				  GROUP BY gl_acct_cd,
				    sl_acct_cd
				  ) a,
				  T_BAL_FOREIGN_CURREncy b
				WHERE b.gl_acct_cd = a.gl_acct_Cd
				AND b.sl_acct_cd   = a.sl_acct_Cd
				AND b.bal_dt       = a.max_dt
				AND b.bal_amount   > 0
				and b.approved_sts='A'
				order by b.bal_dt ";
				
		return $sql;		
	}

	public function attributeLabels()
	{
		return array(
			'bal_dt' => 'Journal Date',
			'gl_acct_cd' => 'Gl Acct Code',
			'sl_acct_cd' => 'Sl Acct Code',
			'curr_cd' => 'Curr Code',
			'bal_amount' => 'Bal Amount',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_sts' => 'Approved Sts',
		);
	}


public function executeGenKursJournal($journal_date)
	{ 
		$connection  = Yii::app()->db;
			
		try{
			$query  = "CALL  SP_SELISIH_KURS_NEXTG( to_date(:p_date,'YYYY-MM-DD'),
												    :p_Gl_acct_Cd,
												    :P_Sl_acct_Cd,
												    :P_FOLDER_CD,
												    :P_USER_ID,
												    :P_IP_ADDRESS,
												    :p_error_code,
												    :p_error_msg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":p_date",$journal_date,PDO::PARAM_STR);
			$command->bindValue(":p_Gl_acct_Cd",$this->gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_Sl_acct_Cd",$this->sl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_FOLDER_CD",$this->folder_cd,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindParam(":p_error_code",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":p_error_msg",$this->error_msg,PDO::PARAM_STR,200);

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

		if(!empty($this->bal_dt_date))
			$criteria->addCondition("TO_CHAR(t.bal_dt,'DD') LIKE '%".$this->bal_dt_date."%'");
		if(!empty($this->bal_dt_month))
			$criteria->addCondition("TO_CHAR(t.bal_dt,'MM') LIKE '%".$this->bal_dt_month."%'");
		if(!empty($this->bal_dt_year))
			$criteria->addCondition("TO_CHAR(t.bal_dt,'YYYY') LIKE '%".$this->bal_dt_year."%'");		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('sl_acct_cd',$this->sl_acct_cd,true);
		$criteria->compare('curr_cd',$this->curr_cd,true);
		$criteria->compare('bal_amount',$this->bal_amount);

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
		$criteria->compare('approved_sts',$this->approved_sts,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}