<?php

/**
 * This is the model class for table "MST_FUND_BANK".
 *
 * The followings are the available columns in table 'MST_FUND_BANK':
 * @property string $bank_cd
 * @property string $bank_name
 * @property string $swift_cd
 * @property string $default_flg
 * @property string $acct_mask
 * @property integer $acct_digit
 * @property string $cre_dt
 * @property string $user_id
 */
class Fundbank extends AActiveRecord
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
	
	public function primaryKey()
	{
		return 'bank_cd';
	}
    

	public function tableName()
	{
		return 'MST_FUND_BANK';
	}

	public function rules()
	{
		return array(
		
			array('acct_digit', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('bank_cd', 'required'),
			array('acct_digit', 'numerical', 'integerOnly'=>true),
			array('bank_cd', 'length', 'max'=>5),
			array('bank_name', 'length', 'max'=>50),
			array('swift_cd, user_id', 'length', 'max'=>10),
			array('default_flg', 'length', 'max'=>1),
			array('acct_mask', 'length', 'max'=>20),
			array('cre_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('bank_cd, bank_name, swift_cd, default_flg, acct_mask, acct_digit, cre_dt, user_id,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
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
			'bank_cd' => 'Bank Code',
			'bank_name' => 'Bank Name',
			'swift_cd' => 'Swift Code',
			'default_flg' => 'Default Flg',
			'acct_mask' => 'Acct Mask',
			'acct_digit' => 'Acct Digit',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
		);
	}
	
	public static function getBankName($bank_cd)
	{
		if($bank_cd !== NULL):	
			$bank_cd = trim($bank_cd);	
			$temp  = self::model()->find('bank_cd=:bank_cd',array(':bank_cd'=>$bank_cd));
			
			if($temp === null)
				return $bank_cd;
			return $temp->bank_name;
		endif;
		return $bank_cd;		
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('bank_cd',$this->bank_cd,true);
		$criteria->compare('bank_name',$this->bank_name,true);
		$criteria->compare('swift_cd',$this->swift_cd,true);
		$criteria->compare('default_flg',$this->default_flg,true);
		$criteria->compare('acct_mask',$this->acct_mask,true);
		$criteria->compare('acct_digit',$this->acct_digit);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".($this->cre_dt_date)."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".($this->cre_dt_month)."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".($this->cre_dt_year)."%'");		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}