<?php

/**
 * This is the model class for table "MST_CLIENT_TYPE".
 *
 * The followings are the available columns in table 'MST_CLIENT_TYPE':
 * @property string $cl_type1
 * @property string $cl_type2
 * @property string $cl_type3
 * @property string $type_desc
 * @property string $dup_contract
 * @property string $avg_contract
 * @property string $nett_allow
 * @property double $rebate_pct
 * @property double $comm_pct
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $os_p_acct_cd
 * @property string $os_s_acct_cd
 * @property string $os_contra_g_acct_cd
 * @property string $os_contra_l_acct_cd
 * @property string $os_setoff_g_acct_cd
 * @property string $os_setoff_l_acct_cd
 * @property double $int_on_payable
 * @property double $int_on_receivable
 * @property string $int_on_pay_chrg_cd
 * @property string $int_on_rec_chrg_cd
 */
class Clienttype extends AActiveRecordSP
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
    
	public function getPrimaryKey()
	{
		return array('cl_type1'=>$this->cl_type1,'cl_type2'=>$this->cl_type2,'cl_type3'=>$this->cl_type3);	
	}

	public function tableName()
	{
		return 'MST_CLIENT_TYPE';
	}

	public function rules()
	{
		return array(
			array('cl_type1, cl_type2, cl_type3','required'),
			array('rebate_pct, comm_pct, int_on_payable, int_on_receivable', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('rebate_pct, comm_pct, int_on_payable, int_on_receivable', 'numerical'),
			array('type_desc', 'length', 'max'=>255),
			array('dup_contract, avg_contract, nett_allow', 'length', 'max'=>1),
			array('user_id', 'length', 'max'=>10),
			array('os_p_acct_cd, os_s_acct_cd, os_contra_g_acct_cd, os_contra_l_acct_cd, os_setoff_g_acct_cd, os_setoff_l_acct_cd', 'length', 'max'=>12),
			array('int_on_pay_chrg_cd, int_on_rec_chrg_cd', 'length', 'max'=>5),
			array('cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('cl_type1, cl_type2, cl_type3, type_desc, dup_contract, avg_contract, nett_allow, rebate_pct, comm_pct, user_id, cre_dt, upd_dt, os_p_acct_cd, os_s_acct_cd, os_contra_g_acct_cd, os_contra_l_acct_cd, os_setoff_g_acct_cd, os_setoff_l_acct_cd, int_on_payable, int_on_receivable, int_on_pay_chrg_cd, int_on_rec_chrg_cd,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'cl_type1' => 'Client type 1',
			'cl_type2' => 'Client type 2',
			'cl_type3' => 'Client type 3',
			'type_desc' => 'Type Desc',
			'dup_contract' => 'Dup Contract',
			'avg_contract' => 'Avg Contract',
			'nett_allow' => 'Nett Allow',
			'rebate_pct' => 'Rebate Pct',
			'comm_pct' => 'Comm Pct',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'os_p_acct_cd' => 'GL Acct Buy Transaction ',
			'os_s_acct_cd' => ' GL Acct Sell Transaction ',
			'os_contra_g_acct_cd' => 'GL Acct Saldo Kredit',
			'os_contra_l_acct_cd' => 'GL Acct Saldo Debit',
			'os_setoff_g_acct_cd' => 'Os Setoff G Acct Code',
			'os_setoff_l_acct_cd' => 'Os Setoff L Acct Code',
			'int_on_payable' => 'Int On Payable',
			'int_on_receivable' => 'Int On Receivable',
			'int_on_pay_chrg_cd' => 'Int On Pay Chrg Code',
			'int_on_rec_chrg_cd' => 'Int On Rec Chrg Code',
		);
	}

	public function executeSp($exec_status,$old_cl_type1,$old_cl_type2,$old_cl_type3)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_MST_CLIENT_TYPE_UPD(
						:P_SEARCH_CL_TYPE1,
						:P_SEARCH_CL_TYPE2,
						:P_SEARCH_CL_TYPE3,
						:P_CL_TYPE1,
						:P_CL_TYPE2,
						:P_CL_TYPE3,
						:P_TYPE_DESC,
						:P_DUP_CONTRACT,
						:P_AVG_CONTRACT,
						:P_NETT_ALLOW,
						:P_REBATE_PCT,
						:P_COMM_PCT,
						:P_USER_ID,
						:P_CRE_DT,
						:P_UPD_DT,
						:P_OS_P_ACCT_CD,
						:P_OS_S_ACCT_CD,
						:P_OS_CONTRA_G_ACCT_CD,
						:P_OS_CONTRA_L_ACCT_CD,
						:P_OS_SETOFF_G_ACCT_CD,
						:P_OS_SETOFF_L_ACCT_CD,
						:P_INT_ON_PAYABLE,
						:P_INT_ON_RECEIVABLE,
						:P_INT_ON_PAY_CHRG_CD,
						:P_INT_ON_REC_CHRG_CD,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_CL_TYPE1",$old_cl_type1,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_CL_TYPE2",$old_cl_type2,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_CL_TYPE3",$old_cl_type3,PDO::PARAM_STR);
			$command->bindValue(":P_CL_TYPE1",$this->cl_type1,PDO::PARAM_STR);
			$command->bindValue(":P_CL_TYPE2",$this->cl_type2,PDO::PARAM_STR);
			$command->bindValue(":P_CL_TYPE3",$this->cl_type3,PDO::PARAM_STR);
			$command->bindValue(":P_TYPE_DESC",$this->type_desc,PDO::PARAM_STR);
			$command->bindValue(":P_DUP_CONTRACT",$this->dup_contract,PDO::PARAM_STR);
			$command->bindValue(":P_AVG_CONTRACT",$this->avg_contract,PDO::PARAM_STR);
			$command->bindValue(":P_NETT_ALLOW",$this->nett_allow,PDO::PARAM_STR);
			$command->bindValue(":P_REBATE_PCT",$this->rebate_pct,PDO::PARAM_STR);
			$command->bindValue(":P_COMM_PCT",$this->comm_pct,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_OS_P_ACCT_CD",$this->os_p_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_OS_S_ACCT_CD",$this->os_s_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_OS_CONTRA_G_ACCT_CD",$this->os_contra_g_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_OS_CONTRA_L_ACCT_CD",$this->os_contra_l_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_OS_SETOFF_G_ACCT_CD",$this->os_setoff_g_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_OS_SETOFF_L_ACCT_CD",$this->os_setoff_l_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_INT_ON_PAYABLE",$this->int_on_payable,PDO::PARAM_STR);
			$command->bindValue(":P_INT_ON_RECEIVABLE",$this->int_on_receivable,PDO::PARAM_STR);
			$command->bindValue(":P_INT_ON_PAY_CHRG_CD",$this->int_on_pay_chrg_cd,PDO::PARAM_STR);
			$command->bindValue(":P_INT_ON_REC_CHRG_CD",$this->int_on_rec_chrg_cd,PDO::PARAM_STR);
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
		$criteria->compare('lower(cl_type1)',strtolower($this->cl_type1),true);
		$criteria->compare('lower(cl_type2)',strtolower($this->cl_type2),true);
		$criteria->compare('lower(cl_type3)',strtolower($this->cl_type3),true);
		$criteria->compare('lower(type_desc)',strtolower($this->type_desc),true);
		$criteria->compare('lower(dup_contract)',strtolower($this->dup_contract),true);
		$criteria->compare('lower(avg_contract)',strtolower($this->avg_contract),true);
		$criteria->compare('lower(nett_allow)',strtolower($this->nett_allow),true);
		$criteria->compare('rebate_pct',$this->rebate_pct);
		$criteria->compare('comm_pct',$this->comm_pct);
		$criteria->compare('lower(user_id)',strtolower($this->user_id),true);

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
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".($this->upd_dt_year)."%'");		$criteria->compare('os_p_acct_cd',$this->os_p_acct_cd,true);
		$criteria->compare('os_s_acct_cd',$this->os_s_acct_cd,true);
		$criteria->compare('os_contra_g_acct_cd',$this->os_contra_g_acct_cd,true);
		$criteria->compare('os_contra_l_acct_cd',$this->os_contra_l_acct_cd,true);
		$criteria->compare('os_setoff_g_acct_cd',$this->os_setoff_g_acct_cd,true);
		$criteria->compare('os_setoff_l_acct_cd',$this->os_setoff_l_acct_cd,true);
		$criteria->compare('int_on_payable',$this->int_on_payable);
		$criteria->compare('int_on_receivable',$this->int_on_receivable);
		$criteria->compare('int_on_pay_chrg_cd',$this->int_on_pay_chrg_cd,true);
		$criteria->compare('int_on_rec_chrg_cd',$this->int_on_rec_chrg_cd,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);

	
		
			$sort = new CSort();
		$sort->defaultOrder = 'cl_type1,cl_type2,cl_type3';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}