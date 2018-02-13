<?php

/**
 * This is the model class for table "MST_BANK_ACCT".
 *
 * The followings are the available columns in table 'MST_BANK_ACCT':
 * @property string $bank_cd
 * @property string $sl_acct_cd
 * @property string $bank_acct_cd
 * @property string $chq_num_mask
 * @property string $bank_acct_type
 * @property string $brch_cd
 * @property string $folder_prefix
 * @property string $gl_acct_cd
 * @property string $curr_cd
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $user_id
 */
class Bankacct extends AActiveRecordSP
{
	public $cancel_flg = 'N';
	public $save_flg = 'N';
	
	public $old_bank_acct_cd;
	public $old_gl_acct_cd;
	public $old_sl_acct_cd;
	public $old_bank_acct_type;
	public $old_brch_cd;
	public $old_folder_prefix;
	public $old_curr_cd;
	public $old_closed_date;
	
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
		return 'IPNEXTG.MST_BANK_ACCT';
	}
	
	public function getBankCdAndName()
	{
		$bank = DAO::queryRowSql("SELECT bank_cd, bank_name FROM MST_BANK_MASTER WHERE bank_cd = '$this->bank_cd'");
		return $this->bank_cd.' / '.$bank['bank_name'];
	}
	
	public function getBankAcctCdAndBrchCd()
	{
		return $this->bank_acct_cd. (!empty($this->brch_cd)?' / '.$this->brch_cd:'');
	} 

	public function executeSp($exec_status,$old_gl_acct_cd,$old_sl_acct_cd,$old_bank_cd,$old_bank_acct_cd,$update_date,$update_seq,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_MST_BANK_ACCT_UPD(
						:P_SEARCH_GL_ACCT_CD,
						:P_SEARCH_SL_ACCT_CD,
						:P_SEARCH_BANK_CD,
						:P_SEARCH_BANK_ACCT_CD,
						:P_BANK_CD,
						:P_SL_ACCT_CD,
						:P_BANK_ACCT_CD,
						:P_CHQ_NUM_MASK,
						:P_BANK_ACCT_TYPE,
						:P_BRCH_CD,
						:P_FOLDER_PREFIX,
						:P_GL_ACCT_CD,
						:P_CURR_CD,
						TO_DATE(:P_CLOSED_DATE,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
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
			$command->bindValue(":P_SEARCH_GL_ACCT_CD",$old_gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_SL_ACCT_CD",$old_sl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_BANK_CD",$old_bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_BANK_ACCT_CD",$old_bank_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_CD",$this->bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SL_ACCT_CD",$this->sl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_ACCT_CD",$this->bank_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CHQ_NUM_MASK",$this->chq_num_mask,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_ACCT_TYPE",$this->bank_acct_type,PDO::PARAM_STR);
			$command->bindValue(":P_BRCH_CD",$this->brch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_FOLDER_PREFIX",$this->folder_prefix,PDO::PARAM_STR);
			$command->bindValue(":P_GL_ACCT_CD",$this->gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CURR_CD",$this->curr_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLOSED_DATE",$this->closed_date,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);								
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$update_seq,PDO::PARAM_STR);
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
			array('closed_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('bank_cd,gl_acct_cd,sl_acct_cd,bank_acct_cd,curr_cd, closed_date', 'required'),
			array('bank_cd, brch_cd, curr_cd', 'length', 'max'=>3),
			array('bank_acct_cd, chq_num_mask', 'length', 'max'=>20),
			array('bank_acct_type, folder_prefix', 'length', 'max'=>2),
			
			array('gl_acct_cd','check'),
			array('bank_cd','checkBank','on'=>'update'),
			array('save_flg, cancel_flg, old_bank_acct_cd, old_gl_acct_cd, old_sl_acct_cd, old_bank_acct_type, old_brch_cd, old_folder_prefix, old_curr_cd, old_closed_date','safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('bank_cd, sl_acct_cd, bank_acct_cd, chq_num_mask, bank_acct_type, brch_cd, folder_prefix, gl_acct_cd, curr_cd', 'safe', 'on'=>'search'),
		);
	}
	
	public function checkBank()
	{
		if($this->bank_cd)
		{
			$check = Bankmaster::model()->find("bank_cd = '$this->bank_cd'");
			if(!$check)$this->addError('bank_cd','Bank Code harus terdaftar');
		}
	}
	
	public function check()
	{
		if($this->gl_acct_cd && $this->sl_acct_cd)
		{
			$check = Glaccount::model()->find("gl_a = '$this->gl_acct_cd' AND sl_a = '$this->sl_acct_cd'");
			if(!$check)$this->addError('gl_acct_cd','Main Acct '.$this->gl_acct_cd.' dan Sub Acct '.$this->sl_acct_cd.' tidak ada di Chart of Account');
		}
		
		if($this->brch_cd && $this->brch_cd != '%')
		{
			$check = Branch::model()->find("brch_cd ='$this->brch_cd'");
			if(!$check)$this->addError('brch_cd','Branch Code harus terdaftar');
		}
	}

	public function relations()
	{
		return array(
			//'bankmaster' => array(self::BELONGS_TO, 'Bankmaster', array('bank_cd'=>'bank_cd')),
		);
	}

	public function attributeLabels()
	{
		return array(
			'bank_cd' => 'Bank Code',
			'sl_acct_cd' => 'Sub Acct Code',
			'bank_acct_cd' => 'Bank Acct Code',
			'chq_num_mask' => 'Chq Num Mask',
			'bank_acct_type' => 'Account Type',
			'brch_cd' => 'Branch Code',
			'folder_prefix' => 'Vch Prefix',
			'gl_acct_cd' => 'Main Acct',
			'curr_cd' => 'Currency',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('bank_cd',$this->bank_cd,true);
		$criteria->compare('sl_acct_cd',$this->sl_acct_cd,true);
		$criteria->compare('bank_acct_cd',$this->bank_acct_cd,true);
		$criteria->compare('chq_num_mask',$this->chq_num_mask,true);
		$criteria->compare('bank_acct_type',$this->bank_acct_type,true);
		$criteria->compare('brch_cd',$this->brch_cd,true);
		$criteria->compare('folder_prefix',$this->folder_prefix,true);
		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('curr_cd',$this->curr_cd,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}