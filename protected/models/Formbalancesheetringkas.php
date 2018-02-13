<?php

/**
 * This is the model class for table "FORM_BALANCE_SHEET_RINGKAS".
 *
 * The followings are the available columns in table 'FORM_BALANCE_SHEET_RINGKAS':
 * @property string $ver_bgn_dt
 * @property string $ver_end_dt
 * @property integer $grp_1
 * @property integer $grp_2
 * @property integer $grp_3
 * @property integer $norut
 * @property string $ringkasan_cd
 * @property string $line_desc
 * @property string $catatan
 * @property integer $spasi
 * @property string $line_type
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_stat
 * @property string $approved_dt
 * @property string $approved_by
 */
class Formbalancesheetringkas extends AActiveRecordSP
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

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	
	public $old_ver_bgn_dt;
	public $old_ver_end_dt;
	public $old_grp_1;
	public $old_grp_2;
	public $old_grp_3;
	public $old_norut;
	public $old_ringkasan_cd;
	public $old_line_desc;
	public $old_catatan;
	public $old_spasi;
	public $old_line_type;
	public $report_date;
	public $tanggal;
	
	public $filterCriteria;
	public $save_flg = 'N';
	public $cancel_flg = 'N';

	public $dummy_dt;
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
		return 'FORM_BALANCE_SHEET_RINGKAS';
	}

	public function rules()
	{
		return array(
		
			array('report_date, old_ver_end_dt, old_ver_bgn_dt, ver_bgn_dt, ver_end_dt, approved_dt, tanggal', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('grp_1, grp_2, grp_3, norut, spasi', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('ver_bgn_dt, ver_end_dt, grp_2, grp_3, ringkasan_cd', 'required'),
			array('grp_2, grp_3, spasi', 'numerical', 'integerOnly'=>true),
			array('ringkasan_cd', 'length', 'max'=>15),
			array('line_desc', 'length', 'max'=>80),
			array('catatan', 'length', 'max'=>50),
			array('line_type', 'length', 'max'=>5),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('catatan, old_catatan, line_desc, line_type, spasi, old_line_desc, old_line_type, old_spasi, old_grp_1, old_grp_2, old_grp_3, old_ringkasan_cd, old_norut, save_flg, cancel_flg, cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('ver_bgn_dt, ver_end_dt, grp_1, grp_2, grp_3, norut, ringkasan_cd, line_desc, catatan, spasi, line_type, cre_dt, user_id, upd_dt, upd_by, approved_stat, approved_dt, approved_by,ver_bgn_dt_date,ver_bgn_dt_month,ver_bgn_dt_year,ver_end_dt_date,ver_end_dt_month,ver_end_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'ver_bgn_dt' => 'Ver Bgn Date',
			'ver_end_dt' => 'Ver End Date',
			'grp_1' => 'Grp 1',
			'grp_2' => 'Grp 2',
			'grp_3' => 'Grp 3',
			'norut' => 'Norut',
			'ringkasan_cd' => 'Ringkasan Code',
			'line_desc' => 'Line Desc',
			'catatan' => 'Catatan',
			'spasi' => 'Spasi',
			'line_type' => 'Line Type',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_stat' => 'Approved Stat',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
		);
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
			$criteria->addCondition("TO_CHAR(t.ver_end_dt,'YYYY') LIKE '%".$this->ver_end_dt_year."%'");		$criteria->compare('grp_1',$this->grp_1);
		$criteria->compare('grp_2',$this->grp_2);
		$criteria->compare('grp_3',$this->grp_3);
		$criteria->compare('norut',$this->norut);
		$criteria->compare('ringkasan_cd',$this->ringkasan_cd,true);
		$criteria->compare('line_desc',$this->line_desc,true);
		$criteria->compare('catatan',$this->catatan,true);
		$criteria->compare('spasi',$this->spasi);
		$criteria->compare('line_type',$this->line_type,true);

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
		$criteria->compare('approved_stat',$this->approved_stat,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function executeSp($exec_status,$old_ver_end_dt,$old_ver_bgn_dt,$old_catatan,$old_grp_1,$old_grp_2,$old_grp_3,$old_line_desc,$old_line_type,$old_spasi,$old_ringkasan_cd,$old_norut)
	{
		$connection  = Yii::app()->db;
		
		// var_dump($old_ringkasan_cd);
		// die();
		
		try{
			$query  = "CALL Sp_FORM_BAL_SHEET_RINGKAS_Upd(
						TO_DATE(:P_SEARCH_VER_BGN_DT,'YYYY-MM-DD'),
						TO_DATE(:P_SEARCH_VER_END_DT,'YYYY-MM-DD'),		
						:P_SEARCH_GRP_1,		    
						:P_SEARCH_GRP_2,		    
						:P_SEARCH_GRP_3,		    
						:P_SEARCH_LINE_DESC,		
						:P_SEARCH_CATATAN,		
						:P_SEARCH_SPASI,		    
						:P_SEARCH_LINE_TYPE,		
						:P_SEARCH_RINGKASAN_CD,	
						:P_SEARCH_NORUT,			
						TO_DATE(:P_VER_BGN_DT,'YYYY-MM-DD'),
						TO_DATE(:P_VER_END_DT,'YYYY-MM-DD'),			
						:P_GRP_1,					
						:P_GRP_2,					
						:P_GRP_3,					
						:P_LINE_DESC,				
						:P_CATATAN,			    
						:P_SPASI,		    	    
						:P_LINE_TYPE,				
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
			$command->bindValue(":P_SEARCH_GRP_2",$old_grp_2,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_GRP_3",$old_grp_3,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_LINE_DESC",$old_line_desc,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_CATATAN",$old_catatan,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_SPASI",$old_spasi,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_LINE_TYPE",$old_line_type,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_RINGKASAN_CD",$old_ringkasan_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_NORUT",$old_norut,PDO::PARAM_STR);
			
			$command->bindValue(":P_VER_BGN_DT",$this->ver_bgn_dt,PDO::PARAM_STR);
			$command->bindValue(":P_VER_END_DT",$this->ver_end_dt,PDO::PARAM_STR);
			$command->bindValue(":P_GRP_1",$this->grp_1,PDO::PARAM_STR);
			$command->bindValue(":P_GRP_2",$this->grp_2,PDO::PARAM_STR);
			$command->bindValue(":P_GRP_3",$this->grp_3,PDO::PARAM_STR);
			$command->bindValue(":P_LINE_DESC",$this->line_desc,PDO::PARAM_STR);
			$command->bindValue(":P_CATATAN",$this->catatan,PDO::PARAM_STR);
			$command->bindValue(":P_SPASI",$this->spasi,PDO::PARAM_STR);
			$command->bindValue(":P_LINE_TYPE",$this->line_type,PDO::PARAM_STR);
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
}