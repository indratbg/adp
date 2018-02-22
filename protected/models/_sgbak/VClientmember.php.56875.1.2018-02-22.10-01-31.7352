<?php

/**
 * This is the model class for table "V_CLIENT_MEMBER".
 *
 * The followings are the available columns in table 'V_CLIENT_MEMBER':
 * @property string $client_cd
 * @property string $subrek14
 */
class VClientmember extends AActiveRecord
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
    
	public function primaryKey()
	{
		return 'client_cd';	
	}

	public function tableName()
	{
		return 'V_CLIENT_MEMBER';
	}

	public function rules()
	{
		return array(
			
			array('client_cd', 'required'),
			array('client_cd', 'length', 'max'=>12),
			array('subrek14', 'length', 'max'=>31),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('client_cd, subrek14', 'safe', 'on'=>'search'),
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
			'client_cd' => 'Client Code',
			'subrek14' => 'Subrek14',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('subrek14',$this->subrek14,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}