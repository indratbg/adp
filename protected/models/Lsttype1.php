<?php

/**
 * This is the model class for table "LST_TYPE1".
 *
 * The followings are the available columns in table 'LST_TYPE1':
 * @property string $cl_type1
 * @property string $cl_desc
 */
class Lsttype1 extends AActiveRecord
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
		return 'LST_TYPE1';
	}

	public function rules()
	{
		return array(
			
			array('cl_desc', 'length', 'max'=>100),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('cl_type1, cl_desc', 'safe', 'on'=>'search'),
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
			'cl_type1' => 'Cl Type1',
			'cl_desc' => 'Cl Desc',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('cl_type1',$this->cl_type1,true);
		$criteria->compare('cl_desc',$this->cl_desc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}