<?php

/**
 * This is the model class for table "V_BROKER_SUBREK".
 *
 * The followings are the available columns in table 'V_BROKER_SUBREK':
 * @property string $broker_cd
 * @property string $broker_001
 * @property string $broker_002
 * @property string $broker_003
 * @property string $broker_004
 * @property string $broker_client_cd
 * @property string $broker_sid
 */
class Vbrokersubrek extends AActiveRecordSP
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
		return 'V_BROKER_SUBREK';
	}

	public function rules()
	{
		return array(
			
			array('broker_cd', 'length', 'max'=>255),
			array('broker_001, broker_002, broker_003, broker_004', 'length', 'max'=>517),
			array('broker_client_cd', 'length', 'max'=>10),
			array('broker_sid', 'length', 'max'=>15),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('broker_cd, broker_001, broker_002, broker_003, broker_004, broker_client_cd, broker_sid', 'safe', 'on'=>'search'),
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
			'broker_cd' => 'Broker Code',
			'broker_001' => 'Broker 001',
			'broker_002' => 'Broker 002',
			'broker_003' => 'Broker 003',
			'broker_004' => 'Broker 004',
			'broker_client_cd' => 'Broker Client Code',
			'broker_sid' => 'Broker Sid',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('broker_cd',$this->broker_cd,true);
		$criteria->compare('broker_001',$this->broker_001,true);
		$criteria->compare('broker_002',$this->broker_002,true);
		$criteria->compare('broker_003',$this->broker_003,true);
		$criteria->compare('broker_004',$this->broker_004,true);
		$criteria->compare('broker_client_cd',$this->broker_client_cd,true);
		$criteria->compare('broker_sid',$this->broker_sid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}