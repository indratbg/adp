<?php

/**
 * This is the model class for table "LST_TYPE2".
 *
 * The followings are the available columns in table 'LST_TYPE2':
 * @property string $cl_type2
 * @property string $cl_desc
 */
class Lsttype2 extends AActiveRecord
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
		return 'LST_TYPE2';
	}

	public function rules()
	{
		return array(
			
			array('cl_desc', 'length', 'max'=>100),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('cl_type2, cl_desc', 'safe', 'on'=>'search'),
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
			'cl_type2' => 'Cl Type2',
			'cl_desc' => 'Cl Desc',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('cl_type2',$this->cl_type2,true);
		$criteria->compare('cl_desc',$this->cl_desc,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}