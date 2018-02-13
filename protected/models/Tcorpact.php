<?php

/**
 * This is the model class for table "T_CORP_ACT".
 *
 * The followings are the available columns in table 'T_CORP_ACT':
 * @property string $stk_cd
 * @property string $ca_type
 * @property string $cum_dt
 * @property string $x_dt
 * @property string $recording_dt
 * @property string $distrib_dt
 * @property double $from_qty
 * @property double $to_qty
 * @property string $cre_dt
 * @property string $user_id
 * @property double $rate
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Tcorpact extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cum_dt_date;
	public $cum_dt_month;
	public $cum_dt_year;

	public $x_dt_date;
	public $x_dt_month;
	public $x_dt_year;
	
	public $recording_dt_date;
	public $recording_dt_month;
	public $recording_dt_year;

	public $distrib_dt_date;
	public $distrib_dt_month;
	public $distrib_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	public $old_x_dt;
	public $old_stk_cd;
	public $old_ca_type;
	public $save_flg = 'N';
	public $cancel_flg = 'N';
	public $price;
	public $type;
	public $fee;
	public $branch;
	public $client_cd;
	public $client;
	public $dropdown_branch;
	public $dropdown_client;
	public $payment_date_tender;
	public $saved;
	public $paid;
	public $jurnal_cumdt;
	public $jurnal_distribdt;
	public $ca_type_filter;
	public $stk_cd_filter;
	public $payrec_num;
	public $today_dt;
	public $distrib_dt_journal;
	public $stk_cd_merge;
    public $x_dt_bofo_flg='Y';
 
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
		return 'T_CORP_ACT';
	}
	
	//DateTime::createFromFormat('Y-m-d G:i:s', $this->x_dt)->format('Y-m-d')
	public function getPrimaryKey()
	{
		return array('stk_cd' => $this->stk_cd,'x_dt' => $this->x_dt);
	}
	
	public static function getListStock($stk_cd,$ca_type,$distrib_dt)
	{
	    $distrib_dt_query="";
	    if($distrib_dt)
        {
            $distrib_dt_query="and distrib_dt>='$distrib_dt'";
        }
        
        $sql = "select * from t_corp_act where (stk_cd='$stk_cd' or '$stk_cd'='%')
                $distrib_dt_query 
                 and (ca_type = '$ca_type' or '$ca_type'='%') and approved_stat='A' 
                 order by distrib_dt desc,stk_cd";    
        	
		
		return $sql;
	}
	
	public function executeSp($exec_status,$old_stk_cd,$old_ca_type,$old_x_dt)
	{
		$connection  = Yii::app()->db;
			
		
		try{
			$query  = "CALL SP_T_CORP_ACT_UPD(
						:P_SEARCH_STK_CD,
						:P_SEARCH_CA_TYPE,												
						TO_DATE(:P_SEARCH_X_DT,'YYYY-MM-DD'), 
						:P_STK_CD,
						:P_CA_TYPE,
						:P_STK_CD_MERGE,
						TO_DATE(:P_CUM_DT,'YYYY-MM-DD'),
						TO_DATE(:P_X_DT,'YYYY-MM-DD'),
						TO_DATE(:P_RECORDING_DT,'YYYY-MM-DD'),
						TO_DATE(:P_DISTRIB_DT,'YYYY-MM-DD'),
						:P_FROM_QTY,
						:P_TO_QTY,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						:P_RATE,
						:P_ROUNDING,
						:P_ROUND_POINT,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_STK_CD",$old_stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_CA_TYPE",$old_ca_type,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_X_DT",$old_x_dt,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CA_TYPE",$this->ca_type,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD_MERGE",$this->stk_cd_merge,PDO::PARAM_STR);
			$command->bindValue(":P_CUM_DT",$this->cum_dt,PDO::PARAM_STR);
			$command->bindValue(":P_X_DT",$this->x_dt,PDO::PARAM_STR);
			$command->bindValue(":P_RECORDING_DT",$this->recording_dt,PDO::PARAM_STR);
			$command->bindValue(":P_DISTRIB_DT",$this->distrib_dt,PDO::PARAM_STR);
			$command->bindValue(":P_FROM_QTY",$this->from_qty,PDO::PARAM_STR);
			$command->bindValue(":P_TO_QTY",$this->to_qty,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_RATE",$this->rate,PDO::PARAM_STR);
			$command->bindValue(":P_ROUNDING",$this->rounding,PDO::PARAM_STR);
			$command->bindValue(":P_ROUND_POINT",$this->round_point,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);

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
		
			array('today_dt,payment_date_tender,cum_dt,old_x_dt, x_dt, recording_dt, distrib_dt, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('from_qty, to_qty, rate', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('round_point,from_qty, to_qty, rate', 'numerical'),
			array('ca_type', 'length', 'max'=>8),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('x_dt_bofo_flg,rounding,stk_cd_merge,client,today_dt,payrec_num,stk_cd_filter,ca_type_filter,saved,paid,payment_date_tender,dropdown_client,dropdown_branch,branch,client_cd,fee,type,price,cum_dt, recording_dt,from_qty, to_qty, distrib_dt,save_flg,cancel_flg, cre_dt, upd_dt, approved_dt,old_x_dt,old_stk_cd,old_ca_type', 'safe'),
			
			array('rounding,stk_cd,ca_type,cum_dt,x_dt,recording_dt,distrib_dt','required', 'except' => 'report,retrieve'),
			array('rate','check_caType'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('stk_cd_merge,stk_cd, ca_type, cum_dt, x_dt, recording_dt, distrib_dt, from_qty, to_qty, cre_dt, user_id, rate, upd_dt, upd_by, approved_dt, approved_by, approved_stat,cum_dt_date,cum_dt_month,cum_dt_year,x_dt_date,x_dt_month,x_dt_year,recording_dt_date,recording_dt_month,recording_dt_year,distrib_dt_date,distrib_dt_month,distrib_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function check_caType()
	{
		if($this->ca_type == 'CASHDIV' && $this->rate == '')
		{
			$this->addError('rate','Jika Corporate Action Type CASH DIVIDEN, rate harus diisi');
		}
		if($this->ca_type =='STKDIV' && $this->rate<=0)
		{
			$this->addError('rate','Jika Corporate Action Type STOCK DIVIDEN, rate tidak boleh 0');
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
			'stk_cd' => 'Stock',
			'ca_type' => 'Corporate Action Type',
			'stk_cd_merge'=>'To Stock',
			'cum_dt' => 'Cum Date',
			'x_dt' => 'X Date',
			'recording_dt' => 'Recording Date',
			'distrib_dt' => 'Distribution/ Payment Date',
			'from_qty' => 'Setiap', 
			'to_qty' => 'Menjadi/ Mendapat',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'rate' => 'Rate',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
			'today_dt'=>'Today Date'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('lower(stk_cd)',strtolower($this->stk_cd),true);
		$criteria->compare('ca_type',$this->ca_type,true);
		
		if(!$this->distrib_dt_date && !$this->distrib_dt_month && !$this->distrib_dt_year)$criteria->addCondition("distrib_dt >= TRUNC(sysdate)");
				
		if(!empty($this->cum_dt_date))
			$criteria->addCondition("TO_CHAR(t.cum_dt,'DD') LIKE '%".$this->cum_dt_date."%'");
		if(!empty($this->cum_dt_month))
			$criteria->addCondition("TO_CHAR(t.cum_dt,'MM') LIKE '%".$this->cum_dt_month."%'");
		if(!empty($this->cum_dt_year))
			$criteria->addCondition("TO_CHAR(t.cum_dt,'YYYY') LIKE '%".$this->cum_dt_year."%'");
		if(!empty($this->x_dt_date))
			$criteria->addCondition("TO_CHAR(t.x_dt,'DD') LIKE '%".$this->x_dt_date."%'");
		if(!empty($this->x_dt_month))
			$criteria->addCondition("TO_CHAR(t.x_dt,'MM') LIKE '%".$this->x_dt_month."%'");
		if(!empty($this->x_dt_year))
			$criteria->addCondition("TO_CHAR(t.x_dt,'YYYY') LIKE '%".$this->x_dt_year."%'");
		if(!empty($this->recording_dt_date))
			$criteria->addCondition("TO_CHAR(t.recording_dt,'DD') LIKE '%".$this->recording_dt_date."%'");
		if(!empty($this->recording_dt_month))
			$criteria->addCondition("TO_CHAR(t.recording_dt,'MM') LIKE '%".$this->recording_dt_month."%'");
		if(!empty($this->recording_dt_year))
			$criteria->addCondition("TO_CHAR(t.recording_dt,'YYYY') LIKE '%".$this->recording_dt_year."%'");
		if(!empty($this->distrib_dt_date))
			$criteria->addCondition("TO_CHAR(t.distrib_dt,'DD') LIKE '%".$this->distrib_dt_date."%'");
		if(!empty($this->distrib_dt_month))
			$criteria->addCondition("TO_CHAR(t.distrib_dt,'MM') LIKE '%".$this->distrib_dt_month."%'");
		if(!empty($this->distrib_dt_year))
			$criteria->addCondition("TO_CHAR(t.distrib_dt,'YYYY') LIKE '%".$this->distrib_dt_year."%'");		$criteria->compare('from_qty',$this->from_qty);
		$criteria->compare('to_qty',$this->to_qty);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('rate',$this->rate);

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
		
		$sort = new CSort;
		$sort->defaultOrder = 'distrib_dt DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}