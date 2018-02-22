<?php

/**
 * This is the model class for table "MST_FUND_ACCT".
 *
 * The followings are the available columns in table 'MST_FUND_ACCT':
 * @property string $acct_cd
 * @property string $acct_name
 * @property integer $mkbd_cd
 * @property string $owner
 */
class Fundacct extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison	//AH: #END search (datetime || date)  additional comparison
	
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
		return 'MST_FUND_ACCT';
	}

	public function rules()
	{
		return array(
		
			array('mkbd_cd', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('acct_cd', 'required'),
			array('mkbd_cd', 'numerical', 'integerOnly'=>true),
			array('acct_cd', 'length', 'max'=>8),
			array('acct_name', 'length', 'max'=>30),
			array('owner', 'length', 'max'=>7),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('acct_cd, acct_name, mkbd_cd, owner', 'safe', 'on'=>'search'),
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
			'acct_cd' => 'Acct Code',
			'acct_name' => 'Acct Name',
			'mkbd_cd' => 'Mkbd Code',
			'owner' => 'Owner',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('acct_cd',$this->acct_cd,true);
		$criteria->compare('acct_name',$this->acct_name,true);
		$criteria->compare('mkbd_cd',$this->mkbd_cd);
		$criteria->compare('owner',$this->owner,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}