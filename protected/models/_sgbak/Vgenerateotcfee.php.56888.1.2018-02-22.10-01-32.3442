<?php

/**
 * This is the model class for table "V_GENERATE_OTC_FEE".
 *
 * The followings are the available columns in table 'V_GENERATE_OTC_FEE':
 * @property string $client_cd
 * @property string $client_name
 * @property double $sum_otc_client
 * @property double $sum_otc_repo_jual
 * @property double $sum_otc_repo_beli
 * @property string $jur
 * @property string $closed
 */
class Vgenerateotcfee extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison	//AH: #END search (datetime || date)  additional comparison
	
	
	public $from_dt;
	public $end_dt;
	public $folder_cd;
	public $jasa_sl_acct_cd;
	public $jasa_gl_acct_cd;
	public $hutang_gl_acct_cd;
	public $hutang_sl_acct_cd;
	public $ymh_gl_acct_cd;
	public $ymh_sl_acct_cd;
	public $desc;
	public $jur_date;
	public $cre_dt;
	public $save_flg='N';
	public $end_date;
	public $otc_fee;
	public $tot_fee_uncheck;
	public $tot_fee;
	public $count_uncheck;
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
		return 'V_GENERATE_OTC_FEE';
	}

	public function rules()
	{
		return array(
			array('end_dt,from_dt jur_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('sum_otc_client, sum_otc_repo_jual, sum_otc_repo_beli', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('sum_otc_client, sum_otc_repo_jual, sum_otc_repo_beli', 'numerical'),
			array('jur_date,desc','required','on'=>'proses'),
			array('client_cd', 'length', 'max'=>12),
			array('client_name', 'length', 'max'=>50),
			array('jur', 'length', 'max'=>1),
			array('closed', 'length', 'max'=>6),
			array('count_uncheck,tot_fee,tot_fee_uncheck,otc_fee,save_flg,desc,from_dt,end_dt,jur_dt,folder_cd,jasa_sl_acct_cd,jasa_gl_acct_cd,hutang_gl_acct_cd,hutang_sl_acct_cd,ymh_sl_acct_cd,ymh_gl_acct_cd','safe'),	
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, client_name, sum_otc_client, sum_otc_repo_jual, sum_otc_repo_beli, jur, closed', 'safe', 'on'=>'search'),
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
			'client_name' => 'Client Name',
			'sum_otc_client' => 'Sum Otc Client',
			'sum_otc_repo_jual' => 'Sum Otc Repo Jual',
			'sum_otc_repo_beli' => 'Sum Otc Repo Beli',
			'jur' => 'Jur',
			'closed' => 'Closed',
		);
	}
public function executeSpHeader($exec_status,$menuName)
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
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('sum_otc_client',$this->sum_otc_client);
		$criteria->compare('sum_otc_repo_jual',$this->sum_otc_repo_jual);
		$criteria->compare('sum_otc_repo_beli',$this->sum_otc_repo_beli);
		$criteria->compare('jur',$this->jur,true);
		$criteria->compare('closed',$this->closed,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}