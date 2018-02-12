<?php

/**
 * This is the model class for table "MST_GL_ACCOUNT".
 *
 * The followings are the available columns in table 'MST_GL_ACCOUNT':
 * @property string $gl_acct_cd
 * @property string $acct_name
 * @property string $acct_short
 * @property string $acct_type
 * @property string $kd_broker
 * @property double $open_bal
 * @property string $db_cr_flg
 * @property string $prt_type
 * @property string $anal_flg
 * @property string $acct_stat
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $excess_pay_flg
 * @property string $match_flg
 * @property string $trust_flg
 * @property string $refund_flg
 * @property string $bah_acct_name
 * @property string $bah_acct_short
 * @property string $def_cpc_cd
 * @property string $mkbd_cd
 * @property string $mkbd_group
 * @property string $gl_a
 * @property string $sl_a
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 * @property string $brch_cd
 * 
 */
class Glaccount extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
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
		return 'IPNEXTG.MST_GL_ACCOUNT';
	}
	
	public function getPrimaryKey()
	{
		return array('gl_a' => $this->gl_a,'sl_a' => $this->sl_a);
	}
	
	public function getGlDescrip()
	{
		return $this->gl_a." - ".$this->acct_name;
	}
	
	public function getBankAccount()
	{
		return $this->sl_a." - ".$this->acct_name;
	}
	
	public function executeSp($exec_status,$old_gl_a,$old_sl_a)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		//DANASAKTI
		/*if($this->brch_cd == 'JK' && $this->sl_a !== '000000')
		{
			$this->sl_a = '1'.substr($this->sl_a,1);
			if($exec_status == AConstant::INBOX_STAT_INS)$old_sl_a = $this->sl_a;
		}
		else if($this->brch_cd == 'SL' && $this->sl_a !== '000000')
		{
			$this->sl_a = '2'.substr($this->sl_a,1);
			if($exec_status == AConstant::INBOX_STAT_INS)$old_sl_a = $this->sl_a;
		}*/
		//END DANASAKTI
		
		$this->gl_acct_cd = trim($this->gl_a).$this->sl_a;
		
		try{
			$query  = "CALL SP_MST_GL_ACCOUNT_UPD(
						:P_SEARCH_GL_A,
						:P_SEARCH_SL_A,
						:P_GL_ACCT_CD,
						:P_ACCT_NAME,
						:P_ACCT_SHORT,
						:P_ACCT_TYPE,
						:P_OPEN_BAL,
						:P_DB_CR_FLG,
						:P_PRT_TYPE,
						--:P_ANAL_FLG,
						:P_ACCT_STAT,
						:P_USER_ID,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						--:P_EXCESS_PAY_FLG,
						--:P_MATCH_FLG,
						--:P_TRUST_FLG,
						--:P_REFUND_FLG,
						:P_BAH_ACCT_NAME,
						:P_BAH_ACCT_SHORT,
						:P_DEF_CPC_CD,
						:P_MKBD_CD,
						:P_MKBD_GROUP,
						:P_GL_A,
						:P_SL_A,
						:P_UPD_BY,
						:P_BRCH_CD,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_GL_A",$old_gl_a,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_SL_A",$old_sl_a,PDO::PARAM_STR);
			$command->bindValue(":P_GL_ACCT_CD",$this->gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_NAME",$this->acct_name,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_SHORT",$this->acct_short,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_TYPE",$this->acct_type,PDO::PARAM_STR);
			$command->bindValue(":P_OPEN_BAL",$this->open_bal,PDO::PARAM_STR);
			$command->bindValue(":P_DB_CR_FLG",$this->db_cr_flg,PDO::PARAM_STR);
			$command->bindValue(":P_PRT_TYPE",$this->prt_type,PDO::PARAM_STR);
			//$command->bindValue(":P_ANAL_FLG",$this->anal_flg,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_STAT",$this->acct_stat,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);			
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			//$command->bindValue(":P_EXCESS_PAY_FLG",$this->excess_pay_flg,PDO::PARAM_STR);
			//$command->bindValue(":P_MATCH_FLG",$this->match_flg,PDO::PARAM_STR);
			//$command->bindValue(":P_TRUST_FLG",$this->trust_flg,PDO::PARAM_STR);
			//$command->bindValue(":P_REFUND_FLG",$this->refund_flg,PDO::PARAM_STR);
			$command->bindValue(":P_BAH_ACCT_NAME",$this->bah_acct_name,PDO::PARAM_STR);
			$command->bindValue(":P_BAH_ACCT_SHORT",$this->bah_acct_short,PDO::PARAM_STR);
			$command->bindValue(":P_DEF_CPC_CD",$this->def_cpc_cd,PDO::PARAM_STR);
			$command->bindValue(":P_MKBD_CD",$this->mkbd_cd,PDO::PARAM_STR);
			$command->bindValue(":P_MKBD_GROUP",$this->mkbd_group,PDO::PARAM_STR);
			$command->bindValue(":P_GL_A",$this->gl_a,PDO::PARAM_STR);
			$command->bindValue(":P_SL_A",$this->sl_a,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_BRCH_CD",$this->brch_cd,PDO::PARAM_STR);
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

	public function rules()
	{
		return array(
		
			array('open_bal', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('open_bal', 'numerical'),
			array('gl_acct_cd', 'length', 'max'=>12),
			array('acct_name, bah_acct_name', 'length', 'max'=>50),
			array('acct_short, bah_acct_short', 'length', 'max'=>20),
			array('acct_type, kd_broker, def_cpc_cd', 'length', 'max'=>4),
			array('db_cr_flg, prt_type, anal_flg, acct_stat, excess_pay_flg, match_flg, trust_flg, refund_flg', 'length', 'max'=>1),
			array('user_id', 'length', 'max'=>10),
			array('mkbd_cd, mkbd_group', 'length', 'max'=>3),
			array('cre_dt, upd_dt, brch_cd', 'safe'),
			
			array('gl_a,sl_a,acct_name,prt_type,acct_short','required'),	//brch_cd required hanya untuk DANASAKTI  
			array('sl_a','checkBranch'),
			

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('gl_acct_cd, acct_name, acct_short, acct_type, kd_broker, open_bal, db_cr_flg, prt_type, anal_flg, acct_stat, user_id, cre_dt, upd_dt, excess_pay_flg, match_flg, trust_flg, refund_flg, bah_acct_name, bah_acct_short, def_cpc_cd, mkbd_cd, mkbd_group, gl_a, sl_a,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function checkBranch()
	{
		$check = Sysparam::model()->find("param_id = 'SYSTEM' AND param_cd1 = 'CHECK' and param_cd2 ='ACCTBRCH'")->dflg1;
		
		if($check == 'Y')
		{
			if(!$this->brch_cd)
			{
				$this->addError('brch_cd', 'Branch Code Cannot be Blank');
			}
			
			if($this->brch_cd == 'JK' && $this->sl_a !== '000000')
			{
				if(substr($this->sl_a,0,1) != '1')$this->addError('sl_a', "If branch is 'JK', the first digit of sub account must be '1' ");
			}
			else if($this->brch_cd == 'SL' && $this->sl_a !== '000000')
			{
				if(substr($this->sl_a,0,1) != '2')$this->addError('sl_a', "If branch is 'SL', the first digit of sub account must be '2' ");
			}
		}
	}

/*
	public function checkType()
	{
		if($this->prt_type == 'S' && $this->sl_a !== '000000')$this->addError('sl_a','Jika printing style SUMMARY, sl_a harus "000000"');
		else if($this->prt_type == 'D' && $this->sl_a === '000000')$this->addError('sl_a','Jika printing style DETAIL, sl_a tdak boleh "000000"');
	}
*/
	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'gl_acct_cd' => 'Gl Acct Code',
			'acct_name' => 'Description',
			'acct_short' => 'Group',
			'acct_type' => 'Type',
			'kd_broker' => 'Kd Broker',
			'open_bal' => 'Open Bal',
			'db_cr_flg' => 'Db Cr Flg',
			'prt_type' => 'Level',
			'anal_flg' => 'Anal Flg',
			'acct_stat' => 'Account Status',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'excess_pay_flg' => 'Excess Pay Flg',
			'match_flg' => 'Match Flg',
			'trust_flg' => 'Trust Flg',
			'refund_flg' => 'Refund Flg',
			'bah_acct_name' => 'Bah Acct Name',
			'bah_acct_short' => 'Bah Acct Short',
			'def_cpc_cd' => 'Affiliated',
			'mkbd_cd' => 'Mkbd Line No',
			'mkbd_group' => 'Mkbd Group No',
			'gl_a' => 'Main Account',
			'sl_a' => 'Sub Account',
			'brch_cd' => 'Branch Code'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('UPPER(acct_name)',strtoupper($this->acct_name),true);
		$criteria->compare('acct_short',$this->acct_short,true);
		$criteria->compare('acct_type',$this->acct_type,true);
		$criteria->compare('kd_broker',$this->kd_broker,true);
		$criteria->compare('open_bal',$this->open_bal);
		$criteria->compare('db_cr_flg',$this->db_cr_flg,true);
		$criteria->compare('prt_type',$this->prt_type,true);
		$criteria->compare('anal_flg',$this->anal_flg,true);
		$criteria->compare('acct_stat',$this->acct_stat,true);
		$criteria->compare('user_id',$this->user_id,true);

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
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('excess_pay_flg',$this->excess_pay_flg,true);
		$criteria->compare('match_flg',$this->match_flg,true);
		$criteria->compare('trust_flg',$this->trust_flg,true);
		$criteria->compare('refund_flg',$this->refund_flg,true);
		$criteria->compare('bah_acct_name',$this->bah_acct_name,true);
		$criteria->compare('bah_acct_short',$this->bah_acct_short,true);
		$criteria->compare('def_cpc_cd',$this->def_cpc_cd,true);
		$criteria->compare('mkbd_cd',$this->mkbd_cd,true);
		$criteria->compare('mkbd_group',$this->mkbd_group,true);
		
		//$criteria->compare('TRIM(gl_a)',$this->gl_a, true);
		$criteria->addCondition("UPPER(TRIM(gl_a)) LIKE UPPER('".$this->gl_a."%')");
		if(!strpos($this->sl_a,'%') && strpos($this->sl_a,'%') !== 0)$criteria->compare('sl_a',$this->sl_a);
		else {
			$criteria->addCondition("sl_a LIKE '$this->sl_a'");
		}

		$criteria->compare('approved_stat',$this->approved_stat,true);
		
		$sort = new CSort;
		$sort->defaultOrder = 'GL_A, SL_A, BRCH_CD';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}