<?php

/**
 * This is the model class for table "T_BOND_PRICE".
 *
 * The followings are the available columns in table 'T_BOND_PRICE':
 * @property string $price_dt
 * @property string $bond_cd
 * @property string $bond_rate
 * @property double $price
 * @property string $user_id
 * @property string $cre_dt
 * @property double $yield
 */
class Tbondprice extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $price_dt_date;
	public $price_dt_month;
	public $price_dt_year;
	
	public $save_flg = 'N';
	public $cancel_flg = 'N';

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $old_price_dt;
	public $old_bond_cd;
	
	public $new_price_dt;
	
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
		$this->price_dt = Yii::app()->format->cleanDate($this->price_dt);
	}
	
	public function getPrimaryKey()
	{
		return array('price_dt'=>$this->price_dt,'bond_cd'=>$this->bond_cd);	
	}

	public function tableName()
	{
		return 'T_BOND_PRICE';
	}

	public function rules()
	{
		return array(
		
			array('price_dt, old_price_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('price, yield', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('price_dt, bond_cd, bond_rate, price', 'required'),
			array('price', 'numerical'),
			array('bond_rate', 'length', 'max'=>7),
			array('user_id', 'length', 'max'=>50),
			array('cre_dt, save_flg, cancel_flg, old_bond_cd', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('price_dt, bond_cd, bond_rate, price, user_id, cre_dt,price_dt_date,price_dt_month,price_dt_year,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'bond' => array(self::BELONGS_TO, 'Bond', array('bond_cd'=>'bond_cd')),
		);
	}

	public function attributeLabels()
	{
		return array(
			'price_dt' => 'Date',
			'bond_cd' => 'Bond Code',
			'bond_rate' => 'Rating',
			'price' => 'Price',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'yield' => 'Yield',
			'new_price_dt' => 'New Date'
		);
	}
	
	public function executeSp($exec_status, $old_price_dt, $old_bond_cd)
	{
		$connection  = Yii::app()->db;		
		try{
			$query  = "CALL SP_T_BOND_PRICE_UPD(
						TO_DATE(:P_SEARCH_PRICE_DT,'YYYY-MM-DD'),:P_SEARCH_BOND_CD,
						TO_DATE(:P_PRICE_DT,'YYYY-MM-DD'),:P_BOND_CD,:P_BOND_RATE,:P_PRICE,
						:P_USER_ID,:P_YIELD,
						:P_UPD_STATUS,:P_IP_ADDRESS,
						:P_CANCEL_REASON,:P_ERROR_CODE,:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_PRICE_DT",$old_price_dt,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_BOND_CD",$old_bond_cd,PDO::PARAM_STR);
			
			$command->bindValue(":P_PRICE_DT",$this->price_dt,PDO::PARAM_STR);
			$command->bindValue(":P_BOND_CD",$this->bond_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BOND_RATE",$this->bond_rate,PDO::PARAM_STR);
			$command->bindValue(":P_PRICE",$this->price,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_YIELD",$this->yield,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);

			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

			$command->execute();
		}catch(Exception $ex){
			if($this->error_code < 1)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->price_dt_date))
			$criteria->addCondition("TO_CHAR(t.price_dt,'DD') LIKE '%".$this->price_dt_date."%'");
		if(!empty($this->price_dt_month))
			$criteria->addCondition("TO_CHAR(t.price_dt,'MM') LIKE '%".$this->price_dt_month."%'");
		if(!empty($this->price_dt_year))
			$criteria->addCondition("TO_CHAR(t.price_dt,'YYYY') LIKE '%".$this->price_dt_year."%'");		$criteria->compare('bond_cd',$this->bond_cd,true);
		$criteria->compare('bond_rate',$this->bond_rate,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");
		$sort = new CSort;
		
		$sort->defaultOrder='bond_cd';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}