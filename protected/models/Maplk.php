<?php

/**
 * This is the model class for table "MST_MAP_LK".
 *
 * The followings are the available columns in table 'MST_MAP_LK':
 * @property string $ver_bgn_dt
 * @property string $ver_end_dt
 * @property string $entity_cd
 * @property string $lk_acct
 * @property string $gl_a
 * @property string $sl_a
 * @property integer $col_num
 * @property integer $sign
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 */
class Maplk extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $ver_bgn_dt_date;
	public $ver_bgn_dt_month;
	public $ver_bgn_dt_year;

	public $ver_end_dt_date;
	public $ver_end_dt_month;
	public $ver_end_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
	public $save_flg = 'N';
	public $cancel_flg = 'N';
	public $old_ver_bgn_dt;
	public $old_entity_cd;
	public $old_lk_acct;
	public $old_gl_a;
	public $old_sl_a;
	public $old_col_num;
	
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
		return 'MST_MAP_LK';
	}

	public function rules()
	{
		return array(
		
			array('ver_bgn_dt, ver_end_dt,old_ver_bgn_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('col_num, sign', 'application.components.validator.ANumberSwitcherValidator'),
			array('sign','ceksign'),
			array('gl_a','cekgl'),
			array('sl_a','ceksl'),
			array('ver_end_dt,ver_bgn_dt,entity_cd,lk_acct,gl_a,sl_a,col_num', 'required'),
			array('sign', 'numerical', 'integerOnly'=>true),
			array('user_id, upd_by', 'length', 'max'=>10),
			array('old_ver_bgn_dt,cre_dt, upd_dt,save_flg,cancel_flg,old_entity_cd,old_gl_a,old_sl_a,old_lk_acct,old_col_num', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('ver_bgn_dt, ver_end_dt, entity_cd, lk_acct, gl_a, sl_a, col_num, sign, cre_dt, user_id, upd_dt, upd_by,ver_bgn_dt_date,ver_bgn_dt_month,ver_bgn_dt_year,ver_end_dt_date,ver_end_dt_month,ver_end_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}
	public function ceksign(){
		
	if($this->sign != 1 && $this->sign != -1 && $this->sign != ''){
		$this->addError('sign','Sign must be 1 or -1 or blank');
	}
		
	}

public function cekgl(){
	
	$query1="select substr(broker_cd,1,2) from v_broker_subrek";
	$cek=DAO::queryRowSql($query1);
	
	//echo "<script>alert('CekGL')</script>";
	
	if($this->entity_cd == $cek){
	
	$query="SELECT GL_A FROM MST_GL_ACCOUNT WHERE GL_A = '$this->gl_a'";
	$cek=DAO::queryRowSql($query);
	if(!$cek){
		$this->addError('gl_a', 'Not found in chart of Account');
	}
	}
}
public function ceksl(){
	if($this->sl_a !='#'){
	
	$query="SELECT GL_A FROM MST_GL_ACCOUNT WHERE GL_A = '$this->gl_a'";
	$cek=DAO::queryRowSql($query);
	$query1="SELECT SL_A FROM MST_GL_ACCOUNT WHERE SL_A = '$this->sl_a'";
	$cek1=DAO::queryRowSql($query1);
if($this->lk_acct != $this->gl_a){
	if(!$cek && !$cek1){
		$this->addError('gl_a', 'Not found in chart of Account');
		$this->addError('sl_a', 'Not found in chart of Account');
	}
}

	}
	else{
		$query="SELECT GL_A FROM MST_GL_ACCOUNT WHERE GL_A = '$this->gl_a'";
		$cek=DAO::queryRowSql($query);
		if($this->lk_acct != $this->gl_a){
		if(!$cek){
			$this->addError('gl_a', 'Not found in chart of Account');
		}
	}
	}
	
	}
	public function attributeLabels()
	{
		return array(
			'ver_bgn_dt' => 'Ver Bgn Date',
			'ver_end_dt' => 'Ver End Date',
			'entity_cd' => 'Entity Code',
			'lk_acct' => 'Lk Acct',
			'gl_a' => 'Gl A',
			'sl_a' => 'Sl A',
			'col_num' => 'Col Num',
			'sign' => 'Sign',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
		);
	}

	public function executeSp($exec_status,$old_ver_bgn_dt,$old_entity_cd,$old_lk_acct,$old_gl_a,$old_sl_a,$old_col_num)
	{
		$connection  = Yii::app()->db;
		
		
		try{
			$query  = "CALL Sp_MST_MAP_LK_Upd(
											TO_DATE(:P_SEARCH_VER_BGN_DT,'YYYY-MM-DD'),
											:P_SEARCH_ENTITY_CD,
											:P_SEARCH_LK_ACCT,
											:P_SEARCH_GL_A,
											:P_SEARCH_SL_A,
											:P_SEARCH_COL_NUM,
											TO_DATE(:P_VER_BGN_DT,'YYYY-MM-DD'),
											TO_DATE(:P_VER_END_DT,'YYYY-MM-DD'),
											:P_ENTITY_CD,
											:P_LK_ACCT,
											:P_GL_A,
											:P_SL_A,
											:P_COL_NUM,
											:P_SIGN,
											TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
											:P_USER_ID,
											TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
											:P_UPD_BY,
											:P_UPD_STATUS,
											:p_ip_address,
											:p_cancel_reason,
											:p_error_code,
											:p_error_msg)";
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_VER_BGN_DT",$old_ver_bgn_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_ENTITY_CD",$old_entity_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_LK_ACCT",$old_lk_acct,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_GL_A",$old_gl_a,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_SL_A",$old_sl_a,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_COL_NUM",$old_col_num,PDO::PARAM_STR);
			$command->bindValue(":P_VER_BGN_DT",$this->ver_bgn_dt,PDO::PARAM_STR);
			$command->bindValue(":P_VER_END_DT",$this->ver_end_dt,PDO::PARAM_STR);
			$command->bindValue(":P_ENTITY_CD",$this->entity_cd,PDO::PARAM_STR);
			$command->bindValue(":P_LK_ACCT",$this->lk_acct,PDO::PARAM_STR);
			$command->bindValue(":P_GL_A",$this->gl_a,PDO::PARAM_STR);
			$command->bindValue(":P_SL_A",$this->sl_a,PDO::PARAM_STR);
			$command->bindValue(":P_COL_NUM",$this->col_num,PDO::PARAM_STR);
			$command->bindValue(":P_SIGN",$this->sign,PDO::PARAM_STR);
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
			$criteria->addCondition("TO_CHAR(t.ver_end_dt,'YYYY') LIKE '%".$this->ver_end_dt_year."%'");		$criteria->compare('entity_cd',$this->entity_cd,true);
		$criteria->compare('lk_acct',$this->lk_acct,true);
		$criteria->compare('gl_a',$this->gl_a,true);
		$criteria->compare('sl_a',$this->sl_a,true);
		$criteria->compare('col_num',$this->col_num);
		$criteria->compare('sign',$this->sign);

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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}