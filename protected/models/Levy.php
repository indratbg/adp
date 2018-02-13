<?php

/**
 * This is the model class for table "MST_LEVY".
 *
 * The followings are the available columns in table 'MST_LEVY':
 * @property string $eff_dt
 * @property string $stk_type
 * @property string $mrkt_type
 * @property double $value_from
 * @property double $value_to
 * @property double $levy_pct
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $user_id
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Levy extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $eff_dt_date;
	public $eff_dt_month;
	public $eff_dt_year;

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
	
	/*
	 * AH: provide char data to trim value according
	 *     especially those which shape combo box
	 * 	   and also those who type date and shows in user input
	 */
	protected function afterFind()
	{
		$this->eff_dt = Yii::app()->format->cleanDate($this->eff_dt);
	}
	
	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function getPrimaryKey()
	{
		return array('eff_dt'=>$this->eff_dt,'stk_type'=>$this->stk_type,'mrkt_type'=>$this->mrkt_type,'value_from'=>$this->value_from,'value_to'=>$this->value_to);	
	}

	public function tableName()
	{
		return 'MST_LEVY';
	}

	public function rules()
	{
		return array(
			array('eff_dt, stk_type, mrkt_type, value_from, value_to,levy_pct','required'),
			array('eff_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('value_from, value_to, levy_pct', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('levy_pct', 'numerical'),
			array('user_id', 'length', 'max'=>8),
			array('cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('eff_dt, stk_type, mrkt_type, value_from, value_to, levy_pct, cre_dt, upd_dt, user_id,eff_dt_date,eff_dt_month,
					eff_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year,approved_by,approved_stat', 'safe', 'on'=>'search'),
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
			'eff_dt' => 'Effective Date',
			'stk_type' => 'Stock Type',
			'mrkt_type' => 'Market Type',
			'value_from' => 'Value From',
			'value_to' => 'Value To',
			'levy_pct' => 'Levy (%)',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'user_id' => 'User',
		);
	}

	public function executeSp($exec_status,$eff_dt,$stk_type,$mrkt_type)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_MST_LEVY_UPD(
						TO_DATE(:P_SEARCH_EFF_DT,'YYYY-MM-DD'),
						:P_SEARCH_STK_TYPE,
						:P_SEARCH_MRKT_TYPE,
						TO_DATE(:P_EFF_DT,'YYYY-MM-DD'),
						:P_STK_TYPE,:P_MRKT_TYPE,
						:P_VALUE_FROM,
						:P_VALUE_TO,
						:P_LEVY_PCT,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_EFF_DT",$eff_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_STK_TYPE",$stk_type,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_MRKT_TYPE",$mrkt_type,PDO::PARAM_STR);
			$command->bindValue(":P_EFF_DT",$this->eff_dt,PDO::PARAM_STR);
			$command->bindValue(":P_STK_TYPE",$this->stk_type,PDO::PARAM_STR);
			$command->bindValue(":P_MRKT_TYPE",$this->mrkt_type,PDO::PARAM_STR);
			$command->bindValue(":P_VALUE_FROM",$this->value_from,PDO::PARAM_STR);
			$command->bindValue(":P_VALUE_TO",$this->value_to,PDO::PARAM_STR);
			$command->bindValue(":P_LEVY_PCT",$this->levy_pct,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);

			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
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

		if(!empty($this->eff_dt_date))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'DD') LIKE '%".$this->eff_dt_date."%'");
		if(!empty($this->eff_dt_month))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'MM') LIKE '%".$this->eff_dt_month."%'");
		if(!empty($this->eff_dt_year))
			$criteria->addCondition("TO_CHAR(t.eff_dt,'YYYY') LIKE '%".$this->eff_dt_year."%'");
		$criteria->compare('mrkt_type',$this->mrkt_type,true);
		$criteria->compare('value_from',$this->value_from,true);
		$criteria->compare('value_to',$this->value_to,true);
		$criteria->compare('levy_pct',$this->levy_pct,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".($this->cre_dt_date)."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".($this->cre_dt_month)."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".($this->cre_dt_year)."%'");
		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".($this->upd_dt_date)."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".($this->upd_dt_month)."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".($this->upd_dt_year)."%'");		$criteria->compare('user_id',$this->user_id,true);
		
		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".($this->approved_dt_date)."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".($this->approved_dt_month)."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".($this->approved_dt_year)."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		
		$criteria->compare('approved_stat',$this->approved_stat,true);

		$sort = new CSort;
		
		$sort->defaultOrder='eff_dt desc, stk_type, mrkt_type';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}