<?php

/**
 * This is the model class for table "T_CLIENT_CLOSING".
 *
 * The followings are the available columns in table 'T_CLIENT_CLOSING':
 * @property string $client_cd
 * @property string $client_name
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $user_id
 * @property string $new_stat
 * @property string $from_stat
 * @property string $approved_stat
 */
class TClientclosing extends AActiveRecordSP
{
	
	public static $new_stat  = array('C'=>'Closed');
	public static $from_stat = array('N'=>'Normal','C'=>'Close'); 
	public $shw_btn_conf = 0;
		
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
	
	//AH: #END search (datetime || date)  additional comparison
	
	// [AH]: #BEGIN parameter to be return after validate
	public $client_type_concat;
	public $client_type_3;
	public $acct_open_dt;
	public $subrek14;
	public $bank_acct_num;
	
	public $stk_qty;
	public $bal_arap;
	public $outstanding_arap;
	public $fund_bal;
	public $ksei_bal;
	public $deposit_bal;
	public $margin;
	public $margin_pasangan;
	public $regular;
	public $subrek004;
	//public $closed_ref;
	public $daily_bal;
	
	public $iscloserdi;
	
	public $update_date; //update date for t_many_header
	public $update_seq; // update seq for t_many_header
	
	
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
		return 'T_CLIENT_CLOSING';
	}
	
	
	public function primaryKey()
	{
		return 'client_cd';	
	}

	public function rules()
	{
		return array(
			array('client_cd', 'required','on'=>'validate'),
			array('client_cd, new_stat','required','on'=>'conftochg'),
			
			array('client_cd', 'length', 'max'=>12),
			//array('closed_ref', 'length', 'max'=>17),
			array('client_name', 'length', 'max'=>50),
			array('user_id', 'length', 'max'=>10),
			array('new_stat, from_stat', 'length', 'max'=>1),
			array('cre_dt, upd_dt, iscloserdi, approved_stat', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('iscloserdi, client_cd, client_name, cre_dt, upd_dt, user_id, new_stat, from_stat,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
		);
	}
	
	public function executeSpValidate()
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_T_CLIENT_CLOSING_VALIDATION(
						:P_SEARCH_CLIENT_CD,:P_CLIENT_TYPE_3,			
						:P_STK_QTY,:P_BAL_ARAP,:P_OUTSTANDING_ARAP,
						:P_FUND_BAL,:P_KSEI_BAL,:P_DEPOSIT_BAL,:P_MARGIN,:P_MARGIN_PASANGAN,
						:P_REGULAR,:P_SUBREK004,:P_DAILY_BAL,:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
					
			$command->bindValue(":P_SEARCH_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE_3",$this->client->client_type_3,PDO::PARAM_STR);
						
			$command->bindParam(":P_STK_QTY",$this->stk_qty,PDO::PARAM_INT,10);
			$command->bindParam(":P_BAL_ARAP",$this->bal_arap,PDO::PARAM_STR,100);
			$command->bindParam(":P_OUTSTANDING_ARAP",$this->outstanding_arap,PDO::PARAM_STR,100);
			$command->bindParam(":P_FUND_BAL",$this->fund_bal,PDO::PARAM_STR,100);
			$command->bindParam(":P_KSEI_BAL",$this->ksei_bal,PDO::PARAM_STR,100);
			$command->bindParam(":P_DEPOSIT_BAL",$this->deposit_bal,PDO::PARAM_STR,100);
			$command->bindParam(":P_MARGIN",$this->margin,PDO::PARAM_STR,100);
			$command->bindParam(":P_MARGIN_PASANGAN",$this->margin_pasangan,PDO::PARAM_STR,100);
			$command->bindParam(":P_REGULAR",$this->regular,PDO::PARAM_STR,100);
			$command->bindParam(":P_SUBREK004",$this->subrek004,PDO::PARAM_STR,100);
			$command->bindParam(":P_DAILY_BAL",$this->daily_bal,PDO::PARAM_STR,100);
			
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,100);
			
			$command->execute();
			$transaction->commit();
			
			$this->setBtnConfToChange();
			
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->error_code == -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

	private function setBtnConfToChange()
	{
		if($this->error_code < 0){
			$this->shw_btn_conf = 0;
		}else{		
			if( empty($this->stk_qty) && empty($this->bal_arap) && empty($this->outstanding_arap) && empty($this->fund_bal) && empty($this->ksei_bal) &&
			    empty($this->deposit_bal) && empty($this->regular) && empty($this->margin_pasangan) && empty($this->subrek004) ){
				$this->shw_btn_conf = 1;
			}else{
				$this->shw_btn_conf = 0;
				$this->addError('error_msg', ' Client ini tidak valid untuk di close');
			}
		}
	}
	
	/*
	 *  AH: this function is for executing procedure
	 */
	 
	public function executeSpManyHeader($exec_status,$menuName,&$transaction)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
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
			//$transaction->rollback();
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}
	
	public function executeSp($exec_status,$record_seq,&$transaction)
	{
		//[AH]: prevent from injection
		/*if($this->executeSpValidate() <= 0)
			return $this->error_code;
		else if($this->isCanCloseAccount()){
			$this->addError('error_msg', 'Error not possible to close account men');
			return -20;
		}*/
		
			
		$connection  = Yii::app()->db;	
		
		try{
			
			$query  = "CALL SP_T_CLIENT_CLOSING_UPD(
						:P_SEARCH_CLIENT_CD,:P_CLIENT_CD,
						:P_CLIENT_NAME,
						
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						:P_NEW_STAT,:P_FROM_STAT,
						
						:P_UPD_BY,:P_UPD_STATUS,:P_IP_ADDRESS,:P_CANCEL_REASON,
						:P_UPDATE_DATE,
						:P_UPDATE_SEQ,:P_RECORD_SEQ,
						
						:P_ERROR_CODE,:P_ERROR_MSG)";
						
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_SEARCH_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_NAME",$this->client_name,PDO::PARAM_STR);
			
			$command->bindValue(":P_NEW_STAT",$this->new_stat,PDO::PARAM_STR);
			$command->bindValue(":P_FROM_STAT",$this->client->susp_stat,PDO::PARAM_STR);
			
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_RECORD_SEQ",$record_seq,PDO::PARAM_STR);
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,100);
			
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,500);

			$command->execute();
			//$transaction->commit();
		}catch(Exception $ex){
			//$transaction->rollback();
			if($this->error_code == -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

	public function relations()
	{
		return array(
			'client' => array(self::BELONGS_TO, 'Client', array('client_cd'=>'client_cd')),
			'clientsubrek14' => array(self::BELONGS_TO, 'VClientSubrek14', array('client_cd'=>'client_cd')),
		);
	}

	public function attributeLabels()
	{
		return array(
			'client_cd' => 'Client Code',
			'client_name' => 'Client Name',
			'cre_dt' => 'Create Date',
			'upd_dt' => 'Update Date',
			'user_id' => 'User',
			'new_stat' => 'New Status',
			'from_stat' => 'From Stat',
			'iscloserdi' => 'Close Rekening Dana',
			//'closed_ref' => 'Voucher Reference'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('client_name',$this->client_name,true);
		
		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".addslashes($this->cre_dt_date)."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".addslashes($this->cre_dt_month)."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".addslashes($this->cre_dt_year)."%'");
		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".addslashes($this->upd_dt_date)."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".addslashes($this->upd_dt_month)."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".addslashes($this->upd_dt_year)."%'");		
		
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('new_stat',$this->new_stat,true);
		$criteria->compare('from_stat',$this->from_stat,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);
		$sort = new CSort();
		$sort->defaultOrder = 'trunc(cre_dt) desc, client_cd';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}