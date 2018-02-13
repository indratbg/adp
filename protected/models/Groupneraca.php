<?php

/**
 * This is the model class for table "MST_MAP_NERACA_RINGKAS".
 *
 * The followings are the available columns in table 'MST_MAP_NERACA_RINGKAS':
 * @property string $ver_bgn_dt
 * @property string $ver_end_dt
 * @property integer $grp_1
 * @property integer $norut
 * @property string $gl_acct_cd
 * @property string $ringkasan_cd
 * @property string $line_desc
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 */
class Groupneraca extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $filterCriteria;
	public $acct_name;
	public $save_flg = 'N';
	public $cancel_flg = 'N';
	
	public $gl_acct_cd;
	
	public $old_ver_end_dt;
	public $old_ver_bgn_dt;
	public $old_grp_1;
	public $old_gl_acct_cd;
	public $old_ringkasan_cd;
	public $old_norut;
	public $tanggal;
	public $line_desc;
	
	public $dummy_dt;
	
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
		return 'MST_MAP_NERACA_RINGKAS';
	}

	public function executeSp($exec_status,$old_ver_end_dt,$old_ver_bgn_dt,$old_grp_1,$old_gl_acct_cd,$old_ringkasan_cd,$old_norut)
	{
		$connection  = Yii::app()->db;
		
		// var_dump($old_ringkasan_cd);
		// die();
		
		try{
			$query  = "CALL SP_MST_MAP_NERACA_RINGKAS_UPD(
						TO_DATE(:P_SEARCH_VER_BGN_DT,'YYYY-MM-DD'),
						TO_DATE(:P_SEARCH_VER_END_DT,'YYYY-MM-DD'),
						:P_SEARCH_GRP_1,
						:P_SEARCH_GL_ACCT_CD,
						:P_SEARCH_RINGKASAN_CD,
						:P_SEARCH_NORUT,
						TO_DATE(:P_VER_BGN_DT,'YYYY-MM-DD'),
						TO_DATE(:P_VER_END_DT,'YYYY-MM-DD'),
						:P_GRP_1,
						:P_GL_ACCT_CD,
						:P_RINGKASAN_CD,
						:P_NORUT,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						:P_UPD_BY,
						:P_APPROVED_STAT,
						:p_ip_address,  
						:p_cancel_reason,
						:p_error_code,
						:p_error_msg)";
			
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_VER_BGN_DT",$old_ver_bgn_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_VER_END_DT",$old_ver_end_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_GRP_1",$old_grp_1,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_GL_ACCT_CD",$old_gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_RINGKASAN_CD",$old_ringkasan_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_NORUT",$old_norut,PDO::PARAM_STR);
			$command->bindValue(":P_VER_BGN_DT",$this->ver_bgn_dt,PDO::PARAM_STR);
			$command->bindValue(":P_VER_END_DT",$this->ver_end_dt,PDO::PARAM_STR);
			$command->bindValue(":P_GRP_1",$this->grp_1,PDO::PARAM_STR);
			$command->bindValue(":P_GL_ACCT_CD",$this->gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_RINGKASAN_CD",$this->ringkasan_cd,PDO::PARAM_STR);
			$command->bindValue(":P_NORUT",$this->norut,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_APPROVED_STAT",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":p_ip_address",$this->ip_address,PDO::PARAM_STR);  
			$command->bindValue(":p_cancel_reason",$this->cancel_reason,PDO::PARAM_STR);
			
			$command->bindParam(":p_error_code",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":p_error_msg",$this->error_msg,PDO::PARAM_STR,1000);			

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
		
			array('grp_1, norut', 'application.components.validator.ANumberSwitcherValidator'),
			array('old_ver_end_dt, old_ver_bgn_dt, ver_bgn_dt,tanggal,ver_end_dt,cre_dt,upd_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('ver_bgn_dt,ver_end_dt','required'),
			array('user_id', 'length', 'max'=>10),
			array('line_desc, ringkasan_cd, gl_acct_cd, old_grp_1, old_gl_acct_cd, old_ringkasan_cd, old_norut, acct_name, save_flg, cancel_flg, cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('ver_bgn_dt, ver_end_dt, grp_1, norut, gl_acct_cd, ringkasan_cd, cre_dt, upd_dt, user_id, cre_dt_date, cre_dt_month, cre_dt_year, upd_dt_date, upd_dt_month, upd_dt_year', 'safe', 'on'=>'search'),
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
			'ver_bgn_dt' => 'Version Begin Date',
			'ver_end_dt' => 'Version End Date',
			'grp_1' => 'Grp 1',
			'norut' => 'Nomor Urut',
			'gl_acct_cd' => 'GL Account',
			'ringkasan_cd' => 'Ringkasan',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'user_id' => 'User',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('ver_bgn_dt',$this->ver_bgn_dt,true);
		$criteria->compare('ver_end_dt',$this->ver_end_dt,true);
		$criteria->compare('grp_1',$this->grp_1,true);
		$criteria->compare('norut',$this->norut,true);
		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('ringkasan_cd',$this->ringkasan_cd,true);
		
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
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}