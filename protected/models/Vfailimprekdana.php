<?php

/**
 * This is the model class for table "V_FAIL_IMP_REK_DANA".
 *
 * The followings are the available columns in table 'V_FAIL_IMP_REK_DANA':
 * @property string $client_cd
 * @property string $new_bank_cd
 * @property string $new_bank_acct
 * @property string $name
 * @property string $bank_name
 * @property string $new_acct_fmt
 * @property string $bank_cd
 * @property string $bank_acct
 * @property string $bank_acct_fmt
 * @property string $flg
 * @property double $balance
 */
 
 
class Vfailimprekdana extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison	//AH: #END search (datetime || date)  additional comparison
	
	public $cancel_flg = 'N';
	public $save_flg = 'N';
	public $update_date;
	public $update_seq;
	public $record_seq;
	public $acct_stat;
	public $user_id;
	public $bank_acct_num;
	public $acct_name;
	public $bank_short_name;
	public $cre_dt;
	public $upd_dt;
	public $upd_user_id;
	public $upd_by;
	public $from_dt;
	public $to_dt;
	
	
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
		return 'V_IMP_NEW_REK_DANA';
	}

	public function rules()
	{
		return array(
		
			array('balance', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('client_cd, new_bank_cd, new_bank_acct, bank_acct', 'required'),
			array('balance', 'numerical'),
			array('client_cd', 'length', 'max'=>12),
			array('new_bank_cd, bank_cd', 'length', 'max'=>5),
			array('new_bank_acct', 'length', 'max'=>25),
			array('name, bank_name', 'length', 'max'=>50),
			array('new_acct_fmt', 'length', 'max'=>4000),
			array('bank_acct', 'length', 'max'=>25),
			array('bank_acct_fmt', 'length', 'max'=>30),
			array('flg', 'length', 'max'=>1),
			array('save_flg,bank_acct,name','safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, new_bank_cd, new_bank_acct, name, bank_name, new_acct_fmt, bank_cd, bank_acct, bank_acct_fmt, flg, balance', 'safe', 'on'=>'search'),
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
			'client_cd' => 'Client Code',
			'new_bank_cd' => 'New Bank Code',
			'new_bank_acct' => 'New Bank Acct',
			'name' => 'Name',
			'bank_name' => 'Bank Name',
			'new_acct_fmt' => 'New Acct Fmt',
			'bank_cd' => 'Bank Code',
			'bank_acct' => 'Bank Acct',
			'bank_acct_fmt' => 'Bank Acct Fmt',
			'flg' => 'Flg',
			'balance' => 'Balance',
		);
	}
public function executeSpHeader($exec_status,$menuName)
	{
		$connection  = Yii::app()->db;
			$p_user_id = Yii::app()->user->id;
		try{
			$query  = "CALL SP_T_MANY_HEADER_INSERT(
						:P_MENU_NAME,
						:P_STATUS,
						:P_USER_ID,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_UPDATE_DATE,
						:P_UPDATE_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_MENU_NAME",$menuName,PDO::PARAM_STR);
			$command->bindValue(":P_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$p_user_id,PDO::PARAM_STR);			
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			
			$command->bindParam(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR,30);
			$command->bindParam(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR,10);
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

public function executeSp($exec_status,$old_client_cd,$old_bank_acct_num,$record_seq)
	{
		$connection  = Yii::app()->db;
			$p_user_id = Yii::app()->user->id;
		
		try{
			$query  = "CALL Sp_MST_CLIENT_FLACCT_IMP_Upd(
						:P_SEARCH_CLIENT_CD,
						:P_SEARCH_BANK_ACCT_NUM,
						:P_CLIENT_CD,
						:P_BANK_CD,
						:P_BANK_ACCT_NUM,
						:P_ACCT_NAME,
						:P_ACCT_STAT,
						:P_BANK_SHORT_NAME,
						:P_BANK_ACCT_FMT,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_USER_ID,
						:P_UPD_BY,
						TO_DATE(:P_FROM_DT,'YYYY-MM-DD'),
						TO_DATE(:P_TO_DT,'YYYY-MM-DD'),
						:P_UPD_STATUS,
						:p_ip_address,
						:p_cancel_reason,
						TO_DATE(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),
						:p_update_seq,
						:p_record_seq,
						:p_error_code,
						:p_error_msg)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_CLIENT_CD",$old_client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_BANK_ACCT_NUM",$old_bank_acct_num,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_CD",$this->new_bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_ACCT_NUM",$this->new_bank_acct,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_NAME",$this->name,PDO::PARAM_STR);
			$command->bindValue(":P_ACCT_STAT",$this->acct_stat,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_SHORT_NAME",$this->bank_name,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_ACCT_FMT",$this->new_acct_fmt,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$p_user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_USER_ID",$this->upd_user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_FROM_DT",$this->from_dt,PDO::PARAM_STR);
			$command->bindValue(":P_TO_DT",$this->to_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_RECORD_SEQ",$record_seq,PDO::PARAM_STR);	
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
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('new_bank_cd',$this->new_bank_cd,true);
		$criteria->compare('new_bank_acct',$this->new_bank_acct,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('new_acct_fmt',$this->new_acct_fmt,true);
		$criteria->compare('bank_cd',$this->bank_cd,true);
		$criteria->compare('bank_acct',$this->bank_acct,true);
		$criteria->compare('bank_acct_fmt',$this->bank_acct_fmt,true);
		$criteria->compare('flg',$this->flg,true);
		$criteria->compare('balance',$this->balance);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}