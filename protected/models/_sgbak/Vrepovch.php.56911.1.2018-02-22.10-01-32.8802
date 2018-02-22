<?php

/**
 * This is the model class for table "V_REPO_VCH".
 *
 * The followings are the available columns in table 'V_REPO_VCH':
 * @property string $repo_num
 * @property string $doc_num
 * @property string $doc_ref_num
 * @property integer $tal_id
 * @property double $amt
 * @property string $user_id
 * @property string $cre_dt
 * @property string $doc_dt
 * @property string $payrec_type
 * @property string $folder_cd
 * @property double $payrec_amt
 * @property string $remarks
 */
class Vrepovch extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $doc_dt_date;
	public $doc_dt_month;
	public $doc_dt_year;
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
		return 'V_REPO_VCH';
	}
	
	public function executeSp($exec_status,$old_repo_num,$old_doc_num,$old_doc_ref_num,$update_date,$update_seq,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_T_REPO_VCH_UPD(
						:P_SEARCH_REPO_NUM,
						:P_SEARCH_DOC_NUM,
						:P_SEARCH_DOC_REF_NUM,
						:P_REPO_NUM,
						:P_DOC_NUM,
						:P_DOC_REF_NUM,
						:P_TAL_ID,
						:P_AMT,
						TO_DATE(:P_DOC_DT,'YYYY-MM-DD'),
						:P_USER_ID,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPDATE_SEQ,
						:P_RECORD_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
		
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_REPO_NUM",$old_repo_num,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_DOC_NUM",$old_doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_DOC_REF_NUM",$old_doc_ref_num,PDO::PARAM_STR);
			$command->bindValue(":P_REPO_NUM",$this->repo_num,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_NUM",$this->doc_num,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_REF_NUM",$this->doc_ref_num,PDO::PARAM_STR);
			$command->bindValue(":P_TAL_ID",$this->tal_id,PDO::PARAM_STR);
			$command->bindValue(":P_AMT",$this->amt,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_DT",$this->doc_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);								
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$update_seq,PDO::PARAM_STR);
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

	public function rules()
	{
		return array(
		
			array('doc_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('tal_id, amt, payrec_amt', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('repo_num, doc_num, doc_ref_num, tal_id, amt', 'required'),
			array('tal_id', 'numerical', 'integerOnly'=>true),
			array('amt, payrec_amt', 'numerical'),
			array('repo_num, doc_num, doc_ref_num', 'length', 'max'=>17),
			array('user_id', 'length', 'max'=>10),
			//array('payrec_type', 'length', 'max'=>2),
			array('folder_cd', 'length', 'max'=>8),
			array('remarks', 'length', 'max'=>50),
			array('payrec_type,cre_dt, doc_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('repo_num, doc_num, doc_ref_num, tal_id, amt, user_id, cre_dt, doc_dt, payrec_type, folder_cd, payrec_amt, remarks,cre_dt_date,cre_dt_month,cre_dt_year,doc_dt_date,doc_dt_month,doc_dt_year', 'safe', 'on'=>'search'),
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
			'repo_num' => 'Repo Num',
			'doc_num' => 'Doc Num',
			'doc_ref_num' => 'Doc Ref Num',
			'tal_id' => 'Tal',
			'amt' => 'Amount',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'doc_dt' => 'Doc Date',
			'payrec_type' => 'Payrec Type',
			'folder_cd' => 'Folder Code',
			'payrec_amt' => 'Payrec Amt',
			'remarks' => 'Remarks',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('repo_num',$this->repo_num,true);
		$criteria->compare('doc_num',$this->doc_num,true);
		$criteria->compare('doc_ref_num',$this->doc_ref_num,true);
		$criteria->compare('tal_id',$this->tal_id);
		$criteria->compare('amt',$this->amt);
		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");
		if(!empty($this->doc_dt_date))
			$criteria->addCondition("TO_CHAR(t.doc_dt,'DD') LIKE '%".$this->doc_dt_date."%'");
		if(!empty($this->doc_dt_month))
			$criteria->addCondition("TO_CHAR(t.doc_dt,'MM') LIKE '%".$this->doc_dt_month."%'");
		if(!empty($this->doc_dt_year))
			$criteria->addCondition("TO_CHAR(t.doc_dt,'YYYY') LIKE '%".$this->doc_dt_year."%'");		$criteria->compare('payrec_type',$this->payrec_type,true);
		$criteria->compare('folder_cd',$this->folder_cd,true);
		$criteria->compare('payrec_amt',$this->payrec_amt);
		$criteria->compare('remarks',$this->remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}