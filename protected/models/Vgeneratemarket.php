<?php

/**
 * This is the model class for table "V_GENERATE_MARKET".
 *
 * The followings are the available columns in table 'V_GENERATE_MARKET':
 * @property string $client_cd
 * @property double $info_fee
 * @property string $client_name
 * @property string $branch_code
 * @property string $flg
 * @property string $keterangan
 */
class Vgeneratemarket extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison	//AH: #END search (datetime || date)  additional comparison
	public $save_flg ='N';
	public $end_date;
	public $jur_date;
	public $folder_cd;
	public $accessflag;
	public $client_type;
	public $user_stat;
	public $fee_flg;
	public $cre_dt;
	public $upd_dt;
	public $upd_by;
	public $upd_status;
	public $update_date;
	public $update_seq;
	public $flg;
	public $period_end_date;
	public $olt_user_id;
	public $user_id;
	public $total_fee;
	
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
		return 'V_GENERATE_MARKET';
	}

	public function rules()
	{
		return array(
			array('end_date, jur_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('info_fee', 'application.components.validator.ANumberSwitcherValidator'),
			
			//array('client_cd', 'required'),
			array('info_fee', 'numerical'),
			array('client_cd', 'length', 'max'=>12),
			array('client_name', 'length', 'max'=>50),
			array('branch_code', 'length', 'max'=>3),
			array('flg', 'length', 'max'=>1),
			array('keterangan', 'length', 'max'=>6),
			array('accessflag,fee_flg,user_stat,client_type,olt_user_id,user_id,save_flg,total_fee,flg,info_fee,client_name,branch_code,end_date,jur_date,folder_cd','safe'),	
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, info_fee, client_name, branch_code, flg, keterangan', 'safe', 'on'=>'search'),
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
			'info_fee' => 'Info Fee',
			'client_name' => 'Client Name',
			'branch_code' => 'Branch Code',
			'flg' => 'Flg',
			'keterangan' => 'Keterangan',
			'end_date'=>'Period End Date',
			'folder_cd'=>'File No.',
			'jur_date'=>'Journal Date',
			'save_flg'=>'SAve Flg'
		);
	}


public function executeSpHeader($exec_status,$menuName)
	{ //echo "<script>alert('test')</script>";
		$connection  = Yii::app()->db;
		
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
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);			
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

public function executeSp($exec_status,$period_end_date,$olt_user_id,$client_cd,$record_seq)
	{ 
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_T_OLT_LOGIN_UPD(
										TO_DATE(:P_SEARCH_PERIOD_END_DATE,'YYYY-MM-DD'),
										:P_SEARCH_OLT_USER_ID,
										:P_SEARCH_CLIENT_CD,
										TO_DATE(:P_PERIOD_END_DATE,'YYYY-MM-DD'),
										:P_OLT_USER_ID,
										:P_ACCESSFLAG,
										:P_CLIENT_TYPE,
										:P_USER_STAT,
										:P_CLIENT_CD,
										:P_FEE_FLG,
										:P_INFO_FEE,
										TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
										:P_USER_ID,
										TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
										:P_UPD_BY,
										:P_UPD_STATUS,
										:p_ip_address,
										:p_cancel_reason,
										TO_DATE(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),
										:p_update_seq,
										:p_record_seq,
										:p_error_code,
										:p_error_msg)";
							
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_PERIOD_END_DATE",$period_end_date,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_OLT_USER_ID",$olt_user_id,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_CLIENT_CD",$client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_PERIOD_END_DATE",$this->period_end_date,PDO::PARAM_STR);
			$command->bindValue(":P_OLT_USER_ID",$this->olt_user_id,PDO::PARAM_STR);
			$command->bindValue(":P_ACCESSFLAG",$this->accessflag,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE",$this->client_type,PDO::PARAM_STR);
			$command->bindValue(":P_USER_STAT",$this->user_stat,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_FEE_FLG",$this->fee_flg,PDO::PARAM_STR);
			$command->bindValue(":P_INFO_FEE",$this->info_fee,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_ip_address",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_cancel_reason",$this->cancel_reason,PDO::PARAM_STR);
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

public function executeSpJournal()
	{ 
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_GENERATE_MARKET_INFO_FEE(to_date(:p_end_date,'yyyy-mm-dd'),
														to_date(:P_JOURNAL_DATE,'yyyy-mm-dd'),
														:P_USER_ID,
														:P_FOLDER_CD,
														:P_IP_ADDRESS,
														to_date(:P_UPDATE_DATE,'yyyy-mm-dd hh24:mi:ss'),
														:P_UPDATE_SEQ,
														:P_ERROR_CODE,
														:P_ERROR_MSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_JOURNAL_DATE",$this->jur_date,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_FOLDER_CD",$this->folder_cd,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_update_date",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_update_seq",$this->update_seq,PDO::PARAM_STR);
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
/*

public function executeSp()
	{ 
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL Sp_Olt_Fee_Upd (TO_DATE(:P_END_DATE,'YYYY-MM-DD'),
											:P_CLIENT_CD,
											:P_INFO_FEE,
											:P_USER_ID,
											:P_ERROR_CODE,
											:P_ERROR_MSG) ";
			$command = $connection->createCommand($query);
			$command->bindValue(":P_END_DATE",$this->end_date,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_INFO_FEE",$this->info_fee,PDO::PARAM_INT);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
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
*/



	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('info_fee',$this->info_fee);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('branch_code',$this->branch_code,true);
		$criteria->compare('flg',$this->flg,true);
		$criteria->compare('keterangan',$this->keterangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}