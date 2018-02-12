<?php

/**
 * This is the model class for table "MST_FIXED_ASSET".
 *
 * The followings are the available columns in table 'MST_FIXED_ASSET':
 * @property string $branch_cd
 * @property string $asset_cd
 * @property string $asset_type
 * @property string $asset_desc
 * @property string $purch_dt
 * @property double $purch_price
 * @property integer $age
 * @property double $accum_last_yr
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $user_id
 * @property string $asset_stat
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Fixedasset extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $purch_dt_date;
	public $purch_dt_month;
	public $purch_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
	public $purch_dt_from;
	public $purch_dt_to;
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
		return 'MST_FIXED_ASSET';
	}
	
	public function executeSp($exec_status,$old_id)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_MST_FIXED_ASSET_UPD(
						:P_SEARCH_ASSET_CD,
						:P_BRANCH_CD,
						:P_ASSET_CD,
						:P_ASSET_TYPE,
						:P_ASSET_DESC,
						TO_DATE(:P_PURCH_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_PURCH_PRICE,
						:P_AGE,
						:P_ACCUM_LAST_YR,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						:P_ASSET_STAT,
						:P_UPD_BY,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_ASSET_CD",$old_id,PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH_CD",$this->branch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_ASSET_CD",$this->asset_cd,PDO::PARAM_STR);
			$command->bindValue(":P_ASSET_TYPE",$this->asset_type,PDO::PARAM_STR);
			$command->bindValue(":P_ASSET_DESC",$this->asset_desc,PDO::PARAM_STR);
			$command->bindValue(":P_PURCH_DT",$this->purch_dt,PDO::PARAM_STR);
			$command->bindValue(":P_PURCH_PRICE",$this->purch_price,PDO::PARAM_STR);
			$command->bindValue(":P_AGE",$this->age,PDO::PARAM_STR);
			$command->bindValue(":P_ACCUM_LAST_YR",$this->accum_last_yr,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_ASSET_STAT",$this->asset_stat,PDO::PARAM_STR);
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
		
			array('purch_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('purch_price, age, accum_last_yr', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('age', 'numerical', 'integerOnly'=>true),
			array('purch_price, accum_last_yr', 'numerical'),
			array('branch_cd', 'length', 'max'=>3),
			array('asset_type', 'length', 'max'=>20),
			array('asset_desc', 'length', 'max'=>60),
			array('user_id, asset_stat', 'length', 'max'=>10),
			array('purch_dt, cre_dt, upd_dt', 'safe'),
			
			array('asset_cd,branch_cd,asset_type,asset_desc,purch_dt,purch_price,age,asset_stat','required'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('approved_stat,branch_cd, asset_cd, asset_type, asset_desc, purch_dt, purch_price, age, accum_last_yr, cre_dt, upd_dt, user_id, asset_stat,purch_dt_date,purch_dt_month,purch_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,purch_dt_from,purch_dt_to', 'safe', 'on'=>'search'),
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
			'branch_cd' => 'Branch',
			'asset_cd' => 'Asset No',
			'asset_type' => 'Asset Type',
			'asset_desc' => 'Description',
			'purch_dt' => 'Purchase Date',
			'purch_price' => 'Value',
			'age' => 'Age',
			'accum_last_yr' => 'Accum Last Yr',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'user_id' => 'User',
			'asset_stat' => 'Asset Stat',
			'purch_dt_from'=>'Purchase Date From',
			'purch_dt_to'=>'Purchase Date To',
			
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('lower(branch_cd)',strtolower($this->branch_cd),true);
		$criteria->compare('lower(asset_cd)',strtolower($this->asset_cd),true);
		$criteria->compare('lower(asset_type)',strtolower($this->asset_type),true);
		$criteria->compare('lower(asset_desc)',strtolower($this->asset_desc),true);

		if(!empty($this->purch_dt_from) and !empty($this->purch_dt_to)){
			$criteria->addCondition("purch_dt between TO_DATE('".$this->purch_dt_from."','DD-MM-YYYY') and to_date('".$this->purch_dt_to."','DD-MM-YYYY')");
			
		}
			
		
		
		$criteria->compare('purch_price',$this->purch_price);
		$criteria->compare('age',$this->age);
		$criteria->compare('accum_last_yr',$this->accum_last_yr);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");
		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		
			$criteria->compare('lower(user_id)',strtolower($this->user_id),true);
		$criteria->compare('lower(asset_stat)',strtolower($this->asset_stat),true);
		$criteria->compare('approved_stat',$this->approved_stat);

		$sort = new CSort;
		$sort->defaultOrder = 'branch_cd,asset_type,asset_cd';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}