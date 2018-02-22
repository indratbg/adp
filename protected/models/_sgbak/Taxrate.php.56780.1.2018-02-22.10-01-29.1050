<?php

/**
 * This is the model class for table "MST_TAX_RATE".
 *
 * The followings are the available columns in table 'MST_TAX_RATE':
 * @property string $begin_dt
 * @property string $end_dt
 * @property string $tax_type
 * @property string $client_cd
 * @property string $stk_cd
 * @property string $client_type_1
 * @property string $client_type_2
 * @property double $rate_1
 * @property double $rate_2
 * @property string $cre_dt
 * @property string $user_id
 * @property string $tax_desc
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 * @property integer $seqno
 */
class Taxrate extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $begin_dt_date;
	public $begin_dt_month;
	public $begin_dt_year;

	public $end_dt_date;
	public $end_dt_month;
	public $end_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $rate_type;
	public $rowId;
	
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
		return 'MST_TAX_RATE';
	}

	public function executeSp($exec_status,$old_seqno)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_MST_TAX_RATE_UPD(
						:P_SEARCH_SEQNO,
						:P_SEQNO,
						TO_DATE(:P_BEGIN_DT,'YYYY-MM-DD'),
						TO_DATE(:P_END_DT,'YYYY-MM-DD'),
						:P_TAX_TYPE,
						:P_CLIENT_CD,
						:P_STK_CD,
						:P_CLIENT_TYPE_1,
						:P_CLIENT_TYPE_2,
						:P_RATE_1,
						:P_RATE_2,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						:P_TAX_DESC,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_SEQNO",$old_seqno,PDO::PARAM_STR);
			$command->bindValue(":P_SEQNO",$this->seqno,PDO::PARAM_STR);
			$command->bindValue(":P_BEGIN_DT",$this->begin_dt,PDO::PARAM_STR);
			$command->bindValue(":P_END_DT",$this->end_dt,PDO::PARAM_STR);
			$command->bindValue(":P_TAX_TYPE",$this->tax_type,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE_1",$this->client_type_1,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE_2",$this->client_type_2,PDO::PARAM_STR);
			$command->bindValue(":P_RATE_1",$this->rate_1,PDO::PARAM_STR);
			$command->bindValue(":P_RATE_2",$this->rate_2,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_TAX_DESC",$this->tax_desc,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);

			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
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
		
			array('begin_dt, end_dt, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('rate_1, rate_2', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('begin_dt, end_dt, rate_type, rate_1', 'required'),
			array('client_cd','checkNull'),
			array('rate_1, rate_2', 'numerical'),
			array('tax_type', 'length', 'max'=>25),
			array('client_cd, stk_cd', 'length', 'max'=>12),
			array('client_type_1, client_type_2, approved_stat', 'length', 'max'=>1),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('tax_desc', 'length', 'max'=>50),
			array('cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('begin_dt, end_dt, tax_type, client_cd, stk_cd, client_type_1, client_type_2, rate_1, rate_2, cre_dt, user_id, tax_desc, upd_dt, upd_by, approved_dt, approved_by, approved_stat,begin_dt_date,begin_dt_month,begin_dt_year,end_dt_date,end_dt_month,end_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function checkNull()
	{
		if($this->rate_type == 0)
		{
			if($this->client_type_1 == '')$this->addError('client_type_1','Jika Rate Type UMUM, Client Type 1 harus dipilih');
			if($this->client_type_2 == '')$this->addError('client_type_2','Jika Rate Type UMUM, Client Type 2 harus dipilih');
			if($this->rate_2 == '')$this->addError('rate_2','Jika Rate Type UMUM, Rate w/o NPWP harus diisi');
		}
		else
		{
			if($this->client_cd == '')$this->addError('client_cd', 'Jika Rate Type SPECIAL, Client Code harus dipilih');
			if($this->stk_cd == '')$this->addError('stk_cd', 'Jika Rate Type SPECIAL, Stock Code harus dipilih');
		}
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'begin_dt' => 'Effective From',
			'end_dt' => 'Effective To',
			'tax_type' => 'Tax Type',
			'client_cd' => 'Client Code',
			'stk_cd' => 'Stock',
			'client_type_1' => 'Client Type 1',
			'client_type_2' => 'Client Type 2',
			'rate_1' => 'Rate',
			'rate_2' => 'Rate w/o NPWP',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'tax_desc' => 'Tax Desc',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		
		$criteria->select = "BEGIN_DT,END_DT,TAX_TYPE,CLIENT_CD,STK_CD,L1.cl_desc AS CLIENT_TYPE_1, L2.cl_desc AS CLIENT_TYPE_2,RATE_1,RATE_2,CRE_DT,USER_ID,DECODE(CLIENT_CD,NULL,'UMUM','SPECIAL') RATE_TYPE, SEQNO";
		$criteria->join = "LEFT JOIN LST_TYPE1 L1 ON NVL(t.CLIENT_TYPE_1,'X') = L1.CL_TYPE1 LEFT JOIN LST_TYPE2 L2 ON NVL(t.CLIENT_TYPE_2,'X') = L2.CL_TYPE2";

		if(!empty($this->begin_dt_date))
			$criteria->addCondition("TO_CHAR(t.begin_dt,'DD') LIKE '%".$this->begin_dt_date."%'");
		if(!empty($this->begin_dt_month))
			$criteria->addCondition("TO_CHAR(t.begin_dt,'MM') LIKE '%".$this->begin_dt_month."%'");
		if(!empty($this->begin_dt_year))
			$criteria->addCondition("TO_CHAR(t.begin_dt,'YYYY') LIKE '%".$this->begin_dt_year."%'");
		if(!empty($this->end_dt_date))
			$criteria->addCondition("TO_CHAR(t.end_dt,'DD') LIKE '%".$this->end_dt_date."%'");
		if(!empty($this->end_dt_month))
			$criteria->addCondition("TO_CHAR(t.end_dt,'MM') LIKE '%".$this->end_dt_month."%'");
		if(!empty($this->end_dt_year))
			$criteria->addCondition("TO_CHAR(t.end_dt,'YYYY') LIKE '%".$this->end_dt_year."%'");		$criteria->compare('tax_type',$this->tax_type,true);
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('client_type_1',$this->client_type_1,true);
		$criteria->compare('client_type_2',$this->client_type_2,true);
		$criteria->compare('rate_1',$this->rate_1);
		$criteria->compare('rate_2',$this->rate_2);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('tax_desc',$this->tax_desc,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('upd_by',$this->upd_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);

		$criteria->addCondition("TAX_TYPE = 'DIVTAX'");
				
		$sort = new CSort;
		$sort->defaultOrder = 'BEGIN_DT DESC';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}