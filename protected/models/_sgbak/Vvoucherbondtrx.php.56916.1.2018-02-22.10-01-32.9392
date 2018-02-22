<?php

/**
 * This is the model class for table "V_VOUCHER_BOND_TRX".
 *
 * The followings are the available columns in table 'V_VOUCHER_BOND_TRX':
 * @property string $trx_date
 * @property integer $trx_seq_no
 * @property string $value_dt
 * @property string $trx_id
 * @property string $trx_ref
 * @property string $trx_type
 * @property string $lawan
 * @property string $bond_cd
 * @property double $nominal
 * @property double $price
 * @property double $net_amount
 * @property string $flg
 * @property string $folder_cd
 * @property string $lawan_name
 * @property string $sortkey
 * @property string $bank_sl_acct
 * @property string $remarks
 */
class Vvoucherbondtrx extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $trx_date_date;
	public $trx_date_month;
	public $trx_date_year;

	public $value_dt_date;
	public $value_dt_month;
	public $value_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $save_flg = 'N';
	
	public $allid = 'N';
	
	public $update_date; //update date for t_many_header
	public $update_seq; // update seq for t_many_header
	
	public $user_id;
	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function afterFind()
	{
		$this->trx_date = Yii::app()->format->cleanDate($this->trx_date);
		$this->value_dt = Yii::app()->format->cleanDate($this->value_dt);
	}
    

	public function tableName()
	{
		return 'V_VOUCHER_BOND_TRX';
	}

	public function rules()
	{
		return array(
		
			array('trx_date, value_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('trx_seq_no, nominal, price, net_amount', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('trx_date, trx_seq_no, value_dt, trx_id, bond_cd', 'required'),
			array('folder_cd','required','on'=>'generate'),
			array('trx_seq_no', 'numerical', 'integerOnly'=>true),
			array('nominal, price, net_amount', 'numerical'),
			array('trx_id', 'length', 'max'=>5),
			array('trx_ref, lawan_name', 'length', 'max'=>50),
			array('trx_type', 'length', 'max'=>4),
			array('lawan', 'length', 'max'=>10),
			array('bond_cd', 'length', 'max'=>20),
			array('flg', 'length', 'max'=>1),
			array('folder_cd', 'length', 'max'=>8),
			array('sortkey', 'length', 'max'=>3),
			array('bank_sl_acct', 'length', 'max'=>6),
			array('remarks', 'length', 'max'=>50),
			array('allid, save_flg, user_id, remarks', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('save_flg, user_id, trx_date, trx_seq_no, value_dt, trx_id, trx_ref, trx_type, lawan, bond_cd, nominal, price, net_amount, flg, folder_cd, lawan_name, sortkey, bank_sl_acct, remarks,trx_date_date,trx_date_month,trx_date_year,value_dt_date,value_dt_month,value_dt_year', 'safe', 'on'=>'search'),
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
			'trx_date' => 'Trx Date',
			'trx_seq_no' => 'Trx Seq No',
			'value_dt' => 'Value Date',
			'trx_id' => 'Trx ID',
			'trx_ref' => 'Trx Ref',
			'trx_type' => 'Trx Type',
			'lawan' => 'Lawan',
			'bond_cd' => 'Bond Code',
			'nominal' => 'Nominal',
			'price' => 'Price',
			'net_amount' => 'Net Amount',
			'flg' => 'Flg',
			'folder_cd' => 'File No/Vch Ref',
			'lawan_name' => 'Lawan Name',
			'sortkey' => 'Sortkey',
			'bank_sl_acct' => 'Bank Sub Acct',
			'remarks' => 'Remarks',
		);
	}
	
	public function executeSpManyHeader($exec_status,$menuName,&$transaction)
	{
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
			//$transaction->rollback();
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

	public function executeSpVchBondTrx($exec_status, &$transaction)
	{
		$connection  = Yii::app()->db;			
		try{
			$query  = "CALL Sp_Bond_Trx_Vch_Nextg(
						TO_DATE(:P_TRX_DATE,'YYYY-MM-DD'),
						:P_TRX_SEQ_NO,
						:P_REMARKS,
						:P_FOLDER_CD,
						:P_BANK_SUB_ACCT,
						:P_USER_ID,
						:P_UPD_STATUS,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPDATE_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
					
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_TRX_DATE",$this->trx_date,PDO::PARAM_STR);
			$command->bindValue(":P_TRX_SEQ_NO",$this->trx_seq_no,PDO::PARAM_STR);
			$command->bindValue(":P_REMARKS",$this->remarks,PDO::PARAM_STR);
			$command->bindValue(":P_FOLDER_CD",$this->folder_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BANK_SUB_ACCT",$this->bank_sl_acct,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);
			
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


	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->trx_date_date))
			$criteria->addCondition("TO_CHAR(t.trx_date,'DD') LIKE '%".$this->trx_date_date."%'");
		if(!empty($this->trx_date_month))
			$criteria->addCondition("TO_CHAR(t.trx_date,'MM') LIKE '%".$this->trx_date_month."%'");
		if(!empty($this->trx_date_year))
			$criteria->addCondition("TO_CHAR(t.trx_date,'YYYY') LIKE '%".$this->trx_date_year."%'");		$criteria->compare('trx_seq_no',$this->trx_seq_no);

		if(!empty($this->value_dt_date))
			$criteria->addCondition("TO_CHAR(t.value_dt,'DD') LIKE '%".$this->value_dt_date."%'");
		if(!empty($this->value_dt_month))
			$criteria->addCondition("TO_CHAR(t.value_dt,'MM') LIKE '%".$this->value_dt_month."%'");
		if(!empty($this->value_dt_year))
			$criteria->addCondition("TO_CHAR(t.value_dt,'YYYY') LIKE '%".$this->value_dt_year."%'");		$criteria->compare('trx_id',$this->trx_id,true);
		$criteria->compare('trx_ref',$this->trx_ref,true);
		$criteria->compare('trx_type',$this->trx_type,true);
		$criteria->compare('lawan',$this->lawan,true);
		$criteria->compare('bond_cd',$this->bond_cd,true);
		$criteria->compare('nominal',$this->nominal);
		$criteria->compare('price',$this->price);
		$criteria->compare('net_amount',$this->net_amount);
		$criteria->compare('flg',$this->flg,true);
		$criteria->compare('folder_cd',$this->folder_cd,true);
		$criteria->compare('lawan_name',$this->lawan_name,true);
		$criteria->compare('sortkey',$this->sortkey,true);
		$criteria->compare('bank_sl_acct',$this->bank_sl_acct,true);
		$criteria->compare('remarks',$this->remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}