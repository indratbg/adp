<?php

/**
 * This is the model class for table "T_IPO_FUND".
 *
 * The followings are the available columns in table 'T_IPO_FUND':
 * @property string $stk_cd
 * @property string $client_cd
 * @property string $tahap
 * @property string $doc_num
 * @property string $cre_dt
 * @property string $user_id
 */
class Tipofund extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;
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
		return 'T_IPO_FUND';
	}

	public function rules()
	{
		return array(
			
			array('tahap', 'length', 'max'=>20),
			array('doc_num', 'length', 'max'=>17),
			array('user_id', 'length', 'max'=>10),
			array('cre_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('stk_cd, client_cd, tahap, doc_num, cre_dt, user_id,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
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
			'stk_cd' => 'Stk Code',
			'client_cd' => 'Client Code',
			'tahap' => 'Tahap',
			'doc_num' => 'Doc Num',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
		);
	}

public function executeSp($exec_status,$old_stk_cd,$old_client_cd, $old_tahap,$update_date,$update_seq,$record_seq)
	{
		$connection  = Yii::app()->db;
				
		try{
			$query  = "CALL  SP_T_IPO_FUND_UPD(	:P_SEARCH_STK_CD,
												:P_SEARCH_CLIENT_CD,
												:P_SEARCH_TAHAP,
												:P_STK_CD,
												:P_CLIENT_CD,
												:P_TAHAP,
												:P_DOC_NUM,
												TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
												:P_USER_ID,
												:P_UPD_STATUS,
												:p_ip_address,
												:p_cancel_reason,
												TO_DATE(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),
												:p_update_seq,
												:p_record_seq,
												:p_error_code,
												:p_error_msg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_STK_CD",$old_stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_CLIENT_CD",$old_client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_TAHAP",$old_tahap,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_TAHAP",$this->tahap,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_NUM",$this->doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);								
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$update_seq,PDO::PARAM_STR);
			$command->bindValue(":p_record_seq",$record_seq,PDO::PARAM_STR);	
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
		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('tahap',$this->tahap,true);
		$criteria->compare('doc_num',$this->doc_num,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}