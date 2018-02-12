<?php

/**
 * This is the model class for table "MST_CITY".
 *
 * The followings are the available columns in table 'MST_CITY':
 * @property string $city_cd
 * @property string $city
 * @property string $province_cd
 * @property string $province
 */
class City extends AActiveRecordSP
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
		return 'MST_CITY';
	}

	public function rules()
	{
		return array(
			
			array('city_cd', 'length', 'max'=>3),
			array('city, province', 'length', 'max'=>35),
			array('province_cd', 'length', 'max'=>2),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('city_cd, city, province_cd, province', 'safe', 'on'=>'search'),
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
			'city_cd' => 'City Code',
			'city' => 'City',
			'province_cd' => 'Province Code',
			'province' => 'Province',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('city_cd',$this->city_cd,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('province_cd',$this->province_cd,true);
		$criteria->compare('province',$this->province,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}