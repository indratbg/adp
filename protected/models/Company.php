<?php

/**
 * This is the model class for table "MST_COMPANY".
 *
 * The followings are the available columns in table 'MST_COMPANY':
 * @property string $kd_broker
 * @property string $nama_prsh
 * @property integer $round
 * @property double $limit_mkbd
 * @property string $jsx_listed
 * @property string $ssx_listed
 * @property double $kom_fee_pct
 * @property double $vat_pct
 * @property double $pph_pct
 * @property double $levy_pct
 * @property string $min_fee_flag
 * @property integer $min_value
 * @property integer $min_charge
 * @property string $brok_nom_asing
 * @property string $brok_nom_lokal
 * @property string $jenis_ijin1
 * @property string $no_ijin1
 * @property string $tgl_ijin1
 * @property string $jenis_ijin2
 * @property string $no_ijin2
 * @property string $tgl_ijin2
 * @property string $jenis_ijin3
 * @property string $no_ijin3
 * @property string $tgl_ijin3
 * @property string $jenis_ijin4
 * @property string $no_ijin4
 * @property string $tgl_ijin4
 * @property string $jenis_ijin5
 * @property string $no_ijin5
 * @property string $tgl_ijin5
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $other_1
 * @property string $other_2
 * @property string $def_addr_1
 * @property string $def_addr_2
 * @property string $def_addr_3
 * @property string $post_cd
 * @property string $contact_pers
 * @property string $phone_num
 * @property string $hp_num
 * @property string $fax_num
 * @property string $e_mail1
 * @property string $con_pers_title
 */
class Company extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $tgl_ijin1_date;
	public $tgl_ijin1_month;
	public $tgl_ijin1_year;

	public $tgl_ijin2_date;
	public $tgl_ijin2_month;
	public $tgl_ijin2_year;

	public $tgl_ijin3_date;
	public $tgl_ijin3_month;
	public $tgl_ijin3_year;

	public $tgl_ijin4_date;
	public $tgl_ijin4_month;
	public $tgl_ijin4_year;

	public $tgl_ijin5_date;
	public $tgl_ijin5_month;
	public $tgl_ijin5_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
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
		return 'MST_COMPANY';
	}
	
		
	/*
	 *  AH: provide all date only field in here , 
	 *    to change format from yyyy-mm-dd 00:00:00 into yyyy-mm-dd
	 */
	protected function afterFind()
	{
		$this->tgl_ijin1 = Yii::app()->format->cleanDate($this->tgl_ijin1);
		$this->tgl_ijin2 = Yii::app()->format->cleanDate($this->tgl_ijin2);
		$this->tgl_ijin3 = Yii::app()->format->cleanDate($this->tgl_ijin3);
		$this->tgl_ijin4 = Yii::app()->format->cleanDate($this->tgl_ijin4);
		$this->tgl_ijin5 = Yii::app()->format->cleanDate($this->tgl_ijin5);
	}
	
	/*
	 *  AH: this function is for executing procedure
	 *  exec_status  : I/U/C
	 */
	public function executeSp($exec_status,$kd_broker)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{	
			$query  = "CALL SP_MST_COMPANY_UPD(
						:P_SEARCH_KD_BROKER,:P_KD_BROKER,:P_NAMA_PRSH,
						:P_ROUND,:P_LIMIT_MKBD,:P_JSX_LISTED,
						:P_SSX_LISTED,:P_KOM_FEE_PCT,:P_VAT_PCT,
						:P_PPH_PCT,:P_LEVY_PCT,:P_MIN_FEE_FLAG,
						:P_MIN_VALUE,:P_MIN_CHARGE,:P_BROK_NOM_ASING,
						:P_BROK_NOM_LOKAL,
						:P_JENIS_IJIN1,:P_NO_IJIN1,
						TO_DATE(:P_TGL_IJIN1,'YYYY-MM-DD'),
						:P_JENIS_IJIN2,:P_NO_IJIN2,
						TO_DATE(:P_TGL_IJIN2,'YYYY-MM-DD'),
						:P_JENIS_IJIN3,:P_NO_IJIN3,
						TO_DATE(:P_TGL_IJIN3,'YYYY-MM-DD'),
						:P_JENIS_IJIN4,:P_NO_IJIN4,
						TO_DATE(:P_TGL_IJIN4,'YYYY-MM-DD'),
						:P_JENIS_IJIN5,:P_NO_IJIN5,
						TO_DATE(:P_TGL_IJIN5,'YYYY-MM-DD'),
						:P_USER_ID,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_OTHER_1,:P_OTHER_2,
						:P_DEF_ADDR_1,:P_DEF_ADDR_2,:P_DEF_ADDR_3,
						:P_POST_CD,:P_CONTACT_PERS,:P_PHONE_NUM,
						:P_HP_NUM,:P_FAX_NUM,:P_E_MAIL1,
						:P_CON_PERS_TITLE,:P_UPD_BY,:P_UPD_STATUS,
						:P_IP_ADDRESS,:P_CANCEL_REASON,
						:P_ERROR_CODE,:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_SEARCH_KD_BROKER",$kd_broker,PDO::PARAM_STR);
			$command->bindValue(":P_KD_BROKER",$this->kd_broker,PDO::PARAM_STR);
			$command->bindValue(":P_NAMA_PRSH",$this->nama_prsh,PDO::PARAM_STR);
			$command->bindValue(":P_ROUND",$this->round,PDO::PARAM_STR);
			$command->bindValue(":P_LIMIT_MKBD",$this->limit_mkbd,PDO::PARAM_STR);
			$command->bindValue(":P_JSX_LISTED",$this->jsx_listed,PDO::PARAM_STR);
			$command->bindValue(":P_SSX_LISTED",$this->ssx_listed,PDO::PARAM_STR);
			$command->bindValue(":P_KOM_FEE_PCT",$this->kom_fee_pct,PDO::PARAM_STR);
			$command->bindValue(":P_VAT_PCT",$this->vat_pct,PDO::PARAM_STR);
			$command->bindValue(":P_PPH_PCT",$this->pph_pct,PDO::PARAM_STR);
			$command->bindValue(":P_LEVY_PCT",$this->levy_pct,PDO::PARAM_STR);
			$command->bindValue(":P_MIN_FEE_FLAG",$this->min_fee_flag,PDO::PARAM_STR);
			$command->bindValue(":P_MIN_VALUE",$this->min_value,PDO::PARAM_STR);
			$command->bindValue(":P_MIN_CHARGE",$this->min_charge,PDO::PARAM_STR);
			$command->bindValue(":P_BROK_NOM_ASING",$this->brok_nom_asing,PDO::PARAM_STR);
			$command->bindValue(":P_BROK_NOM_LOKAL",$this->brok_nom_lokal,PDO::PARAM_STR);
			
			$command->bindValue(":P_JENIS_IJIN1",$this->jenis_ijin1,PDO::PARAM_STR);
			$command->bindValue(":P_NO_IJIN1",$this->no_ijin1,PDO::PARAM_STR);
			$command->bindValue(":P_TGL_IJIN1",$this->tgl_ijin1,PDO::PARAM_STR);
			
			$command->bindValue(":P_JENIS_IJIN2",$this->jenis_ijin2,PDO::PARAM_STR);
			$command->bindValue(":P_NO_IJIN2",$this->no_ijin2,PDO::PARAM_STR);
			$command->bindValue(":P_TGL_IJIN2",$this->tgl_ijin2,PDO::PARAM_STR);
			
			$command->bindValue(":P_JENIS_IJIN3",$this->jenis_ijin3,PDO::PARAM_STR);
			$command->bindValue(":P_NO_IJIN3",$this->no_ijin3,PDO::PARAM_STR);
			$command->bindValue(":P_TGL_IJIN3",$this->tgl_ijin3,PDO::PARAM_STR);
			
			$command->bindValue(":P_JENIS_IJIN4",$this->jenis_ijin4,PDO::PARAM_STR);
			$command->bindValue(":P_NO_IJIN4",$this->no_ijin4,PDO::PARAM_STR);
			$command->bindValue(":P_TGL_IJIN4",$this->tgl_ijin4,PDO::PARAM_STR);
			
			$command->bindValue(":P_JENIS_IJIN5",$this->jenis_ijin5,PDO::PARAM_STR);
			$command->bindValue(":P_NO_IJIN5",$this->no_ijin5,PDO::PARAM_STR);
			$command->bindValue(":P_TGL_IJIN5",$this->tgl_ijin5,PDO::PARAM_STR);
						
			$command->bindValue(":P_OTHER_1",$this->other_1,PDO::PARAM_STR);
			$command->bindValue(":P_OTHER_2",$this->other_2,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_1",$this->def_addr_1,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_2",$this->def_addr_2,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR_3",$this->def_addr_3,PDO::PARAM_STR);
			$command->bindValue(":P_POST_CD",$this->post_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CONTACT_PERS",$this->contact_pers,PDO::PARAM_STR);
			$command->bindValue(":P_PHONE_NUM",$this->phone_num,PDO::PARAM_STR);
			$command->bindValue(":P_HP_NUM",$this->hp_num,PDO::PARAM_STR);
			$command->bindValue(":P_FAX_NUM",$this->fax_num,PDO::PARAM_STR);
			$command->bindValue(":P_E_MAIL1",$this->e_mail1,PDO::PARAM_STR);
			$command->bindValue(":P_CON_PERS_TITLE",$this->con_pers_title,PDO::PARAM_STR);

			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_ADDR",$this->def_addr_1.$this->def_addr_2.$this->def_addr_3,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);

			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,100);

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

	public function rules()
	{
		return array(
		
			array('tgl_ijin1, tgl_ijin2, tgl_ijin3, tgl_ijin4, tgl_ijin5', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('limit_mkbd, kom_fee_pct, vat_pct, pph_pct, levy_pct, min_value, min_charge', 'application.components.validator.ANumberSwitcherValidator'),
			array('nama_prsh, kd_broker, other_1, round, limit_mkbd,vat_pct, pph_pct, levy_pct, min_fee_flag, def_addr_1, contact_pers, no_ijin1','required'),
			array('round, min_value, min_charge', 'numerical', 'integerOnly'=>true),
			array('limit_mkbd, kom_fee_pct, vat_pct, pph_pct, levy_pct', 'numerical'),
			array('kd_broker','length','max'=>2),
			array('nama_prsh, e_mail1', 'length', 'max'=>50),
			array('jsx_listed, ssx_listed, min_fee_flag', 'length', 'max'=>1),
			array('brok_nom_asing, brok_nom_lokal', 'length', 'max'=>12),
			array('jenis_ijin1, jenis_ijin2, jenis_ijin3, jenis_ijin4, jenis_ijin5, other_1, other_2', 'length', 'max'=>10),
			array('no_ijin1, no_ijin2, no_ijin3, no_ijin4, no_ijin5', 'length', 'max'=>25),
			array('user_id', 'length', 'max'=>8),
			array('def_addr_1, def_addr_2, def_addr_3', 'length', 'max'=>30),
			array('post_cd', 'length', 'max'=>6),
			array('contact_pers', 'length', 'max'=>40),
			array('phone_num, hp_num, fax_num, con_pers_title', 'length', 'max'=>15),
			array('tgl_ijin1, tgl_ijin2, tgl_ijin3, tgl_ijin4, tgl_ijin5, cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			
			array('kd_broker, nama_prsh, round, limit_mkbd, jsx_listed, ssx_listed, kom_fee_pct, vat_pct, pph_pct, levy_pct, min_fee_flag, min_value, min_charge, brok_nom_asing, brok_nom_lokal, jenis_ijin1, no_ijin1, tgl_ijin1, jenis_ijin2, no_ijin2, tgl_ijin2, jenis_ijin3, no_ijin3, tgl_ijin3, jenis_ijin4, no_ijin4, tgl_ijin4, jenis_ijin5, no_ijin5, tgl_ijin5, user_id, cre_dt, upd_dt, other_1, def_addr_1, def_addr_2, def_addr_3, post_cd, contact_pers, phone_num, hp_num, fax_num, e_mail1, con_pers_title,tgl_ijin1_date,tgl_ijin1_month,tgl_ijin1_year,tgl_ijin2_date,tgl_ijin2_month,tgl_ijin2_year,tgl_ijin3_date,tgl_ijin3_month,tgl_ijin3_year,tgl_ijin4_date,tgl_ijin4_month,tgl_ijin4_year,tgl_ijin5_date,tgl_ijin5_month,tgl_ijin5_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'kd_broker' => 'Broker Code',
			'other_1' => 'Client Code',
			
			'nama_prsh' => 'Company Name',
			'round' => 'Round',
			'limit_mkbd' => 'MKBD Limit',
			'jsx_listed' => 'JSX',
			'ssx_listed' => 'SSX',
			
			'kom_fee_pct' => 'Commision',
			'vat_pct' => 'VAT',
			'pph_pct' => 'PPH',
			'levy_pct' => 'LEVY',
			'min_fee_flag' => 'Min Fee Flag',
			'min_value' => 'Min Value',
			'min_charge' => 'Min Charge',
			'brok_nom_asing' => 'Brok Nom Asing',
			'brok_nom_lokal' => 'Brok Nom Lokal',
			'jenis_ijin1' => 'Jenis Ijin1',
			'no_ijin1' => 'No Ijin1',
			'tgl_ijin1' => 'Tgl Ijin1',
			'jenis_ijin2' => 'Jenis Ijin2',
			'no_ijin2' => 'No Ijin2',
			'tgl_ijin2' => 'Tgl Ijin2',
			'jenis_ijin3' => 'Jenis Ijin3',
			'no_ijin3' => 'No Ijin3',
			'tgl_ijin3' => 'Tgl Ijin3',
			'jenis_ijin4' => 'Jenis Ijin4',
			'no_ijin4' => 'No Ijin4',
			'tgl_ijin4' => 'Tgl Ijin4',
			'jenis_ijin5' => 'Jenis Ijin5',
			'no_ijin5' => 'No Ijin5',
			'tgl_ijin5' => 'Tgl Ijin5',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			
			'other_2' => 'Client Admin',
			'def_addr_1' => 'Address',
			'def_addr_2' => 'Address 2',
			'def_addr_3' => 'Address 3',
			'post_cd' => 'Post Code',
			'contact_pers' => 'Contact Person',
			'phone_num' => 'Phone Number',
			'hp_num' => 'Hp Number',
			'fax_num' => 'Fax Number',
			'e_mail1' => 'E-Mail',
			'con_pers_title' => 'Contact Person Title',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition("UPPER(kd_broker) LIKE UPPER('".$this->kd_broker."%')");
		$criteria->compare('nama_prsh',$this->nama_prsh,true);
		$criteria->compare('round',$this->round);
		$criteria->compare('limit_mkbd',$this->limit_mkbd);
		$criteria->compare('jsx_listed',$this->jsx_listed,true);
		$criteria->compare('ssx_listed',$this->ssx_listed,true);
		$criteria->compare('kom_fee_pct',$this->kom_fee_pct);
		$criteria->compare('vat_pct',$this->vat_pct);
		$criteria->compare('pph_pct',$this->pph_pct);
		$criteria->compare('levy_pct',$this->levy_pct);
		$criteria->compare('min_fee_flag',$this->min_fee_flag,true);
		$criteria->compare('min_value',$this->min_value);
		$criteria->compare('min_charge',$this->min_charge);
		$criteria->compare('brok_nom_asing',$this->brok_nom_asing,true);
		$criteria->compare('brok_nom_lokal',$this->brok_nom_lokal,true);
		$criteria->compare('jenis_ijin1',$this->jenis_ijin1,true);
		$criteria->compare('no_ijin1',$this->no_ijin1,true);

		if(!empty($this->tgl_ijin1_date))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin1,'DD') LIKE '%".($this->tgl_ijin1_date)."%'");
		if(!empty($this->tgl_ijin1_month))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin1,'MM') LIKE '%".($this->tgl_ijin1_month)."%'");
		if(!empty($this->tgl_ijin1_year))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin1,'YYYY') LIKE '%".($this->tgl_ijin1_year)."%'");		$criteria->compare('jenis_ijin2',$this->jenis_ijin2,true);
		$criteria->compare('no_ijin2',$this->no_ijin2,true);

		if(!empty($this->tgl_ijin2_date))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin2,'DD') LIKE '%".($this->tgl_ijin2_date)."%'");
		if(!empty($this->tgl_ijin2_month))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin2,'MM') LIKE '%".($this->tgl_ijin2_month)."%'");
		if(!empty($this->tgl_ijin2_year))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin2,'YYYY') LIKE '%".($this->tgl_ijin2_year)."%'");		$criteria->compare('jenis_ijin3',$this->jenis_ijin3,true);
		$criteria->compare('no_ijin3',$this->no_ijin3,true);

		if(!empty($this->tgl_ijin3_date))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin3,'DD') LIKE '%".($this->tgl_ijin3_date)."%'");
		if(!empty($this->tgl_ijin3_month))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin3,'MM') LIKE '%".($this->tgl_ijin3_month)."%'");
		if(!empty($this->tgl_ijin3_year))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin3,'YYYY') LIKE '%".($this->tgl_ijin3_year)."%'");		$criteria->compare('jenis_ijin4',$this->jenis_ijin4,true);
		$criteria->compare('no_ijin4',$this->no_ijin4,true);

		if(!empty($this->tgl_ijin4_date))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin4,'DD') LIKE '%".($this->tgl_ijin4_date)."%'");
		if(!empty($this->tgl_ijin4_month))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin4,'MM') LIKE '%".($this->tgl_ijin4_month)."%'");
		if(!empty($this->tgl_ijin4_year))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin4,'YYYY') LIKE '%".($this->tgl_ijin4_year)."%'");		$criteria->compare('jenis_ijin5',$this->jenis_ijin5,true);
		$criteria->compare('no_ijin5',$this->no_ijin5,true);

		if(!empty($this->tgl_ijin5_date))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin5,'DD') LIKE '%".($this->tgl_ijin5_date)."%'");
		if(!empty($this->tgl_ijin5_month))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin5,'MM') LIKE '%".($this->tgl_ijin5_month)."%'");
		if(!empty($this->tgl_ijin5_year))
			$criteria->addCondition("TO_CHAR(t.tgl_ijin5,'YYYY') LIKE '%".($this->tgl_ijin5_year)."%'");		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".($this->cre_dt_date)."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".($this->cre_dt_month)."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".($this->cre_dt_year)."%'");
		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".($this->upd_dt_date)."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".($this->upd_dt_month)."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".($this->upd_dt_year)."%'");		$criteria->compare('other_1',$this->other_1,true);
		$criteria->compare('other_2',$this->other_2,true);
		$criteria->compare('def_addr_1',$this->def_addr_1,true);
		$criteria->compare('def_addr_2',$this->def_addr_2,true);
		$criteria->compare('def_addr_3',$this->def_addr_3,true);
		$criteria->compare('post_cd',$this->post_cd,true);
		$criteria->compare('contact_pers',$this->contact_pers,true);
		$criteria->compare('phone_num',$this->phone_num,true);
		$criteria->compare('hp_num',$this->hp_num,true);
		$criteria->compare('fax_num',$this->fax_num,true);
		$criteria->compare('e_mail1',$this->e_mail1,true);
		$criteria->compare('con_pers_title',$this->con_pers_title,true);
		$criteria->addCondition("approved_stat = 'A'");

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}