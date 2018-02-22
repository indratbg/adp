<?php

/**
 * This is the model class for table "T_H2H_REF_HEADER".
 *
 * The followings are the available columns in table 'T_H2H_REF_HEADER':
 * @property string $trf_id
 * @property string $file_name
 * @property string $trx_type
 * @property integer $kbb_type1
 * @property string $kbb_type2
 * @property string $branch_group
 * @property string $trf_date
 * @property string $save_date
 * @property string $upload_date
 * @property string $response_date
 * @property integer $total_record
 * @property integer $success_cnt
 * @property integer $fail_cnt
 * @property string $description
 */
class Th2hrefheader extends AActiveRecordSP
{
	public $trf_date_from;
	public $trf_date_to;
	public $trf_status;
	public $success_stat;
	
	//AH: #BEGIN search (datetime || date) additional comparison
	public $trf_date_date;
	public $trf_date_month;
	public $trf_date_year;

	public $save_date_date;
	public $save_date_month;
	public $save_date_year;

	public $upload_date_date;
	public $upload_date_month;
	public $upload_date_year;

	public $response_date_date;
	public $response_date_month;
	public $response_date_year;
	//AH: #END search (datetime || date)  additional comparison
	
	//online transfer
	public $trx_ref;
	public $curr_cd;
	public $transfer_type;
	public $from_acct;
	public $to_acct;
	public $trx_amt;
	public $remark1;
	public $remark2;
	public $receiver_bank_cd;
	public $receiver_bank_name;
	public $receiver_name;
	public $receiver_bank_branch_name;
	public $receiver_cust_type;
	public $receiver_cust_residence;
	public $receiver_email_address;
	public $user_id;
	public $total_trf_amt;
	
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
		return 'T_H2H_REF_HEADER';
	}
	
	public function rules()
	{
		return array(
		
			array('save_date, upload_date, response_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('trx_amt,total_record, success_cnt, fail_cnt', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('kbb_type1, total_record, success_cnt, fail_cnt', 'numerical', 'integerOnly'=>true),
			array('trf_id', 'length', 'max'=>8),
			array('file_name, description', 'length', 'max'=>50),
			array('trx_type', 'length', 'max'=>2),
			array('kbb_type2, branch_group', 'length', 'max'=>20),
			array('receiver_bank_name,trx_ref,curr_cd,transfer_type,from_acct,to_acct,trx_amt,remark1,remark2,receiver_bank_cd,receiver_name,
					receiver_bank_branch_name,receiver_cust_type,receiver_cust_residence,receiver_cust_residence,receiver_email_address,
					trf_date, save_date, upload_date, response_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('trf_status, trf_id, file_name, trx_type, kbb_type1, kbb_type2, branch_group, trf_date, save_date, upload_date, response_date, total_record, success_cnt, fail_cnt, description,trf_date_date,trf_date_month,trf_date_year,save_date_date,save_date_month,save_date_year,upload_date_date,upload_date_month,upload_date_year,response_date_date,response_date_month,response_date_year', 'safe', 'on'=>'search'),
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
			'trf_id' => 'Transfer ID',
			'file_name' => 'File Name',
			'trx_type' => 'Transaction Type',
			'kbb_type1' => 'Transfer Type',
			'kbb_type2' => 'Transfer Type 2',
			'branch_group' => 'Branch Group',
			'trf_date' => 'Transfer Date',
			'save_date' => 'Save Date',
			'upload_date' => 'Upload Date',
			'response_date' => 'Response Date',
			'total_record' => 'Total Records',
			'success_cnt' => 'Successful Records',
			'fail_cnt' => 'Failed Records',
			'description' => 'Description',
			'trf_status' => 'Transfer Status',
			'success_stat' => 'Detail Status',
			'trx_ref'=>'Reference Number',
			'from_acct'=>'From Account Number',
			'to_acct'=>'To Account Number',
			'trx_amt'=>'Amount',
			'remark1'=>'Remark 1',
			'remark2'=>'Remark 2',
			'receiver_bank_cd'=>'Receiver bank code',
			'receiver_bank_name'=>'Receiver bank name',
			'receiver_bank_branch_name'=>'Receiver bank branch name',
			'curr_cd'=>'Currency Symbol',
			'receiver_name'=>'Receiver Name',
			'total_trf_amt'=>'Total Transfer'
 		);
	}
	public function executeSp($exec_status,$old_trf_id,$record_seq)
	{ 
		$connection  = Yii::app()->db;
				
		try{
			$query  = "CALL  SP_T_H2H_REF_HEADER(:P_SEARCH_TRF_ID,
												:P_TRF_ID,
												:P_FILE_NAME,
												:P_TRX_TYPE,
												:P_KBB_TYPE1,
												:P_KBB_TYPE2,
												:P_BRANCH_GROUP,
												TO_DATE(:P_TRF_DATE,'YYYY-MM-DD'),
												TO_DATE(:P_SAVE_DATE,'YYYY-MM-DD HH24:MI:SS'),
												TO_DATE(:P_UPLOAD_DATE,'YYYY-MM-DD HH24:MI:SS'),
												:P_RESPONSE_DATE,
												:P_TOTAL_RECORD,
												:P_SUCCESS_CNT,
												:P_FAIL_CNT,
												:P_DESCRIPTION,
												:P_CURR_CD,
												:P_REMARK1,
												:P_REMARK2,
												:P_RECEIVER_EMAIL_ADDRESS,
												:P_RECEIVER_BANK_CD,
												:P_RECEIVER_CUST_TYPE,
												:P_RECEIVER_CUST_RESIDENCE,
												:P_TRANSFER_TYPE,
												:P_RECEIVER_BANK_BRANCH_NAME,
												:P_UPD_STATUS,
												:p_ip_address,
												:p_cancel_reason,
												TO_DATE(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),
												:p_update_seq,
												:p_record_seq,
												:p_error_code,
												:p_error_msg)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_TRF_ID",$old_trf_id,PDO::PARAM_STR);
			$command->bindValue(":P_TRF_ID",$this->trf_id,PDO::PARAM_STR);
			$command->bindValue(":P_FILE_NAME",$this->file_name,PDO::PARAM_STR);
			$command->bindValue(":P_TRX_TYPE",$this->trx_type,PDO::PARAM_STR);
			$command->bindValue(":P_KBB_TYPE1",$this->kbb_type1,PDO::PARAM_STR);
			$command->bindValue(":P_KBB_TYPE2",$this->kbb_type2,PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH_GROUP",$this->branch_group,PDO::PARAM_STR);
			$command->bindValue(":P_TRF_DATE",$this->trf_date,PDO::PARAM_STR);
			$command->bindValue(":P_SAVE_DATE",$this->save_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPLOAD_DATE",$this->upload_date,PDO::PARAM_STR);
			$command->bindValue(":P_RESPONSE_DATE",$this->response_date,PDO::PARAM_STR);
			$command->bindValue(":P_TOTAL_RECORD",$this->total_record,PDO::PARAM_STR);
			$command->bindValue(":P_SUCCESS_CNT",$this->success_cnt,PDO::PARAM_STR);
			$command->bindValue(":P_FAIL_CNT",$this->fail_cnt,PDO::PARAM_STR);
			$command->bindValue(":P_DESCRIPTION",$this->description,PDO::PARAM_STR);
			$command->bindValue(":P_CURR_CD",$this->curr_cd,PDO::PARAM_STR);
			$command->bindValue(":P_REMARK1",$this->remark1,PDO::PARAM_STR);
			$command->bindValue(":P_REMARK2",$this->remark2,PDO::PARAM_STR);
			$command->bindValue(":P_RECEIVER_EMAIL_ADDRESS",$this->receiver_email_address,PDO::PARAM_STR);
			$command->bindValue(":P_RECEIVER_BANK_CD",$this->receiver_bank_cd,PDO::PARAM_STR);
			$command->bindValue(":P_RECEIVER_CUST_TYPE",$this->receiver_cust_type,PDO::PARAM_STR);
			$command->bindValue(":P_RECEIVER_CUST_RESIDENCE",$this->receiver_cust_residence,PDO::PARAM_STR);
			$command->bindValue(":P_TRANSFER_TYPE",$this->transfer_type,PDO::PARAM_STR);
			$command->bindValue(":P_RECEIVER_BANK_BRANCH_NAME",$this->receiver_bank_branch_name,PDO::PARAM_STR);
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

	public function search()
	{
		$criteria = new CDbCriteria;
		
		$criteria->select = "t.trf_id, max(file_name)file_name, DECODE(max(trx_type),'CR','AUTO CREDIT','CO','AUTO COLLECTION','FT','AUTO TRANSFER','ONLINE TRANSFER') trx_type, 
							CASE max(kbb_type1)
								WHEN 1 THEN 'AP'
								WHEN 2 THEN 'AR'
								WHEN 3 THEN 'PE to RDI Penarikan ('||max(kbb_type2)||')'
								WHEN 4 THEN 'RDI to Client ('||max(kbb_type2)||')'
								WHEN 6 THEN 'PE to RDI Penarikan ('||max(kbb_type2)||')'
                                WHEN 7 THEN 'RDI to Client ('||max(kbb_type2)||')'
								WHEN 9 THEN 'Online Transfer'
							END kbb_type1, 
							max(kbb_type2)kbb_type2, max(branch_group)branch_group, TO_CHAR(max(trf_date),'DD Mon YY') trf_date,
							 TO_CHAR(max(save_date),'DD Mon YY HH24:MI:SS') save_date, 
							max(upload_date)upload_date, DECODE(max(response_date),NULL,'WAITING','SENT') trf_status, 
							max(response_date)response_date, max(total_record)total_record, 
				              max(success_cnt)success_cnt, max(fail_cnt)fail_cnt, max(t.description)description,
				              sum(d.trf_amt) total_trf_amt";
		$criteria->join="join t_h2h_ref_detail d on t.trf_id=d.trf_id";		
		$criteria->group="t.trf_date,t.trf_id";			  		
		$criteria->compare('t.trf_id',$this->trf_id);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('trx_type',$this->trx_type,true);
		$criteria->compare('kbb_type1',$this->kbb_type1,true);
		// if(!empty($this->kbb_type1))
		// {
			// $kbb_type1= $this->kbb_type1=='5'?'9':$this->kbb_type1;
			// $criteria->compare('kbb_type1',$kbb_type1,true);
		// }
		
		$criteria->compare('kbb_type2',$this->kbb_type2,true);
		$criteria->compare('branch_group',$this->branch_group,true);
		
		if($this->trf_status == 'S')$criteria->addCondition("response_date IS NOT NULL");
		else if($this->trf_status == 'W')$criteria->addCondition("response_date IS NULL");

		if(empty($this->trf_date_date))
		{
			$criteria->addCondition("trf_date >= get_doc_date(1,trunc(sysdate))");	
		}
		
		if(!empty($this->trf_date_date))
			$criteria->addCondition("TO_CHAR(t.trf_date,'DD') LIKE '%".$this->trf_date_date."%'");
		if(!empty($this->trf_date_month))
			$criteria->addCondition("TO_CHAR(t.trf_date,'MM') LIKE '%".$this->trf_date_month."%'");
		if(!empty($this->trf_date_year))
			$criteria->addCondition("TO_CHAR(t.trf_date,'YYYY') LIKE '%".$this->trf_date_year."%'");
		if(!empty($this->save_date_date))
			$criteria->addCondition("TO_CHAR(t.save_date,'DD') LIKE '%".$this->save_date_date."%'");
		if(!empty($this->save_date_month))
			$criteria->addCondition("TO_CHAR(t.save_date,'MM') LIKE '%".$this->save_date_month."%'");
		if(!empty($this->save_date_year))
			$criteria->addCondition("TO_CHAR(t.save_date,'YYYY') LIKE '%".$this->save_date_year."%'");
		if(!empty($this->upload_date_date))
			$criteria->addCondition("TO_CHAR(t.upload_date,'DD') LIKE '%".$this->upload_date_date."%'");
		if(!empty($this->upload_date_month))
			$criteria->addCondition("TO_CHAR(t.upload_date,'MM') LIKE '%".$this->upload_date_month."%'");
		if(!empty($this->upload_date_year))
			$criteria->addCondition("TO_CHAR(t.upload_date,'YYYY') LIKE '%".$this->upload_date_year."%'");
		if(!empty($this->response_date_date))
			$criteria->addCondition("TO_CHAR(t.response_date,'DD') LIKE '%".$this->response_date_date."%'");
		if(!empty($this->response_date_month))
			$criteria->addCondition("TO_CHAR(t.response_date,'MM') LIKE '%".$this->response_date_month."%'");
		if(!empty($this->response_date_year))
			$criteria->addCondition("TO_CHAR(t.response_date,'YYYY') LIKE '%".$this->response_date_year."%'");		$criteria->compare('total_record',$this->total_record);
		$criteria->compare('success_cnt',$this->success_cnt);
		$criteria->compare('fail_cnt',$this->fail_cnt);
		$criteria->compare('description',$this->description,true);
		
		$sort = new CSort;
		$sort->defaultOrder = "t.TRF_DATE desc, t.TRF_ID DESC ";		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}