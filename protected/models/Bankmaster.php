<?php

/**
 * This is the model class for table "MST_BANK_MASTER".
 *
 * The followings are the available columns in table 'MST_BANK_MASTER':
 * @property double $chrg_val_l
 * @property double $chrg_val_o
 * @property double $chrg_val_h
 * @property double $chrg_val_t
 * @property double $chrg_val_d
 * @property double $chrg_val_r
 * @property string $bank_cd
 * @property string $bank_name
 * @property string $short_bank_name
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $user_id
 * @property integer $bis_max_l
 * @property integer $bis_max_o
 * @property integer $bis_max_h
 * @property integer $bis_max_t
 * @property integer $bis_max_d
 * @property integer $bis_max_r
 * @property string $chrg_type_l
 * @property string $chrg_type_o
 * @property string $chrg_type_h
 * @property string $chrg_type_t
 * @property string $chrg_type_d
 * @property string $chrg_type_r
 * @property string $affil_flg
 * @property string $rtgs_cd
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Bankmaster extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $bank_acct_cd;
	public $gl_acct_cd;
	public $sl_acct_cd;
	public $folder_prefix;
	
	public $update_date;
	public $update_seq;
	public $cancel_reason;
	
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
		return 'IPNEXTG.MST_BANK_MASTER';
	}
	
	public function primaryKey()
	{
		return 'bank_cd';
	}
	
	public function executeSp($exec_status,$old_bank_cd,$record_seq)
	{
		$connection  = Yii::app()->db;
				
		try{
			$query  = "CALL SP_MST_BANK_MASTER_UPD(
						:P_SEARCH_BANK_CD,
						:P_BANK_CD,
						:P_BANK_NAME,
						:P_SHORT_BANK_NAME,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						:P_RTGS_CD,
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
			$command->bindValue(":P_SEARCH_BANK_CD",$old_bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_CD",$this->bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_NAME",$this->bank_name,PDO::PARAM_STR);
			$command->bindValue(":P_SHORT_BANK_NAME",$this->short_bank_name,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_RTGS_CD",$this->rtgs_cd,PDO::PARAM_STR);
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
			
			//Commit baru akan dijalankan saat semua transaksi INSERT sukses
			
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
		
			//array('chrg_val_l, chrg_val_o, chrg_val_h, chrg_val_t, chrg_val_d, chrg_val_r, bis_max_l, bis_max_o, bis_max_h, bis_max_t, bis_max_d, bis_max_r', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('bank_cd,bank_name,short_bank_name,rtgs_cd', 'required'),

			//array('bis_max_l, bis_max_o, bis_max_h, bis_max_t, bis_max_d, bis_max_r', 'numerical', 'integerOnly'=>true),
			//array('chrg_val_l, chrg_val_o, chrg_val_h, chrg_val_t, chrg_val_d, chrg_val_r', 'numerical'),
			array('bank_cd', 'length', 'max'=>3),
			array('bank_name', 'length', 'max'=>50),
			array('short_bank_name', 'length', 'max'=>20),
			array('user_id', 'length', 'max'=>10),
			//array('chrg_type_l, chrg_type_o, chrg_type_h, chrg_type_t, chrg_type_d, chrg_type_r, affil_flg', 'length', 'max'=>1),
			array('rtgs_cd', 'length', 'max'=>10),
			array('cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('bank_cd, bank_name, gl_acct_cd, sl_acct_cd, folder_prefix', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'bankacct' => array(self::HAS_MANY,'Bankacct','bank_cd'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'bank_cd' => 'Bank Code',
			'bank_name' => 'Bank Name',
			'short_bank_name' => 'Short Bank Name',
			'cre_dt' => 'Create Date',
			'upd_dt' => 'Update Date',
			'user_id' => 'Created By',
			'upd_by' => 'Updated By',
			'rtgs_cd' => 'Rtgs Code',
			
			'bank_acct_cd' => 'Account No.',
			'gl_acct_cd' => 'GL Main Acct Code',
			'sl_acct_cd' => 'Sub Acct Code',
			'folder_prefix' => 'Vch Prefix',
			'cancel_reason' => 'Edit Reason',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		
		$criteria->select = 't.bank_cd,t.bank_name,b.bank_acct_cd,b.gl_acct_cd,b.sl_acct_cd,b.folder_prefix';
		$criteria->join = 'LEFT JOIN MST_BANK_ACCT b ON t.bank_cd = b.bank_cd';
		
		$criteria->compare('UPPER(t.bank_cd)',strtoupper($this->bank_cd),true);
		$criteria->compare('UPPER(bank_name)',strtoupper($this->bank_name),true);
		$criteria->compare('short_bank_name',$this->short_bank_name,true);
		
		$criteria->compare('b.gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('b.sl_acct_cd',$this->sl_acct_cd,true);
		$criteria->compare('b.folder_prefix',$this->folder_prefix,true);

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
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".($this->upd_dt_year)."%'");		$criteria->compare('user_id',$this->user_id,true);

		$criteria->compare('rtgs_cd',$this->rtgs_cd,true);

		$criteria->compare('t.approved_stat',$this->approved_stat);
		
		$criteria2 = new CDbCriteria;
		$criteria2->compare('b.approved_stat',$this->approved_stat);
		$criteria2->addCondition('b.approved_stat IS NULL','OR');
		
		$criteria->mergeWith($criteria2, 'AND');
		
		$sort = new CSort;
		
		$sort->defaultOrder='folder_prefix,bank_name,bank_acct_cd';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}