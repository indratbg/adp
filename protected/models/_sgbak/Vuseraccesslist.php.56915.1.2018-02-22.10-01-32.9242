<?php

/**
 * This is the model class for table "V_USER_ACCESS_LIST".
 *
 * The followings are the available columns in table 'V_USER_ACCESS_LIST':
 * @property string $user_id
 * @property string $menu_name
 * @property string $access_level
 */
class Vuseraccesslist extends AActiveRecordSP
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
		return 'V_USER_ACCESS_LIST';
	}

	public function rules()
	{
		return array(
			
			array('user_id', 'length', 'max'=>8),
			array('menu_name', 'length', 'max'=>100),
			array('access_level', 'length', 'max'=>7),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('user_id, menu_name, access_level', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'menu_name' => 'Menu Name',
			'access_level' => 'Access Level',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition("UPPER(user_id) LIKE UPPER('%".$this->user_id."%')");
		$criteria->addCondition("UPPER(menu_name) LIKE UPPER('%".$this->menu_name."%')");
		$criteria->compare('access_level',$this->access_level,true);
		
		$page = new CPagination;
		$page->pageSize = 40;
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>$page
		));
	}
}