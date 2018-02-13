<?php

/**
 * This is the model class for table "BEJ_TRS_HEADER".
 *
 * The followings are the available columns in table 'BEJ_TRS_HEADER':
 * @property double $trx_code
 * @property double $trx_post
 * @property string $trx_note
 * @property double $trx_sess
 * @property string $trx_type
 * @property string $brk_cod2
 * @property string $inv_typ2
 * @property string $brk_cod1
 * @property string $inv_typ1
 * @property string $stk_code
 * @property double $stk_volm
 * @property double $stk_pric
 * @property string $trx_date
 * @property double $trx_ord2
 * @property double $trx_ord1
 * @property string $trx_ref2
 * @property string $trx_ref1
 * @property double $trx_kopur
 * @property string $trx_time
 * @property string $trx_user
 */
class Bejtrsheader extends AActiveRecord
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $trx_date_date;
	public $trx_date_month;
	public $trx_date_year;
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
    
	public function getDbConnection()
	{
		return Yii::app()->dbfo;
	}

	public function tableName()
	{
		return 'BEJ_TRS_HEADER';
	}
	
	public function executeSpBejTransUpload()
	{
		$connection  = Yii::app()->dbfo;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_BEJ_TRANS_UPLOAD(:VI_USER_ID,:VO_ERR_CODE,:VO_ERR_MSG)";
			$command = $connection->createCommand($query);
			
			$command->bindValue(":VI_USER_ID",Yii::app()->user->id,PDO::PARAM_STR);
			$command->bindParam(":VO_ERR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERR_MSG",$this->error_msg,PDO::PARAM_STR,100);
						
			$command->execute();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->error_code < 0)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

	public function rules()
	{
		return array(
		
			array('trx_date', 'application.components.validator.ADatePickerSwitcherValidator'),
			
			array('trx_code, trx_post, trx_sess, stk_volm, stk_pric, trx_ord2, trx_ord1, trx_kopur', 'numerical'),
			array('trx_type', 'length', 'max'=>2),
			array('brk_cod2, brk_cod1', 'length', 'max'=>5),
			array('inv_typ2, inv_typ1', 'length', 'max'=>1),
			array('stk_code', 'length', 'max'=>8),
			array('trx_ref2, trx_ref1', 'length', 'max'=>20),
			array('trx_time', 'length', 'max'=>6),
			array('trx_user', 'length', 'max'=>10),
			array('trx_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('trx_code, trx_post, trx_note, trx_sess, trx_type, brk_cod2, inv_typ2, brk_cod1, inv_typ1, stk_code, stk_volm, stk_pric, trx_date, trx_ord2, trx_ord1, trx_ref2, trx_ref1, trx_kopur, trx_time, trx_user,trx_date_date,trx_date_month,trx_date_year', 'safe', 'on'=>'search'),
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
			'trx_code' => 'Trx Code',
			'trx_post' => 'Trx Post',
			'trx_note' => 'Trx Note',
			'trx_sess' => 'Trx Sess',
			'trx_type' => 'Trx Type',
			'brk_cod2' => 'Brk Cod2',
			'inv_typ2' => 'Inv Typ2',
			'brk_cod1' => 'Brk Cod1',
			'inv_typ1' => 'Inv Typ1',
			'stk_code' => 'Stk Code',
			'stk_volm' => 'Stk Volm',
			'stk_pric' => 'Stk Pric',
			'trx_date' => 'Trx Date',
			'trx_ord2' => 'Trx Ord2',
			'trx_ord1' => 'Trx Ord1',
			'trx_ref2' => 'Trx Ref2',
			'trx_ref1' => 'Trx Ref1',
			'trx_kopur' => 'Trx Kopur',
			'trx_time' => 'Trx Time',
			'trx_user' => 'Trx User',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('trx_code',$this->trx_code);
		$criteria->compare('trx_post',$this->trx_post);
		$criteria->compare('trx_note',$this->trx_note,true);
		$criteria->compare('trx_sess',$this->trx_sess);
		$criteria->compare('trx_type',$this->trx_type,true);
		$criteria->compare('brk_cod2',$this->brk_cod2,true);
		$criteria->compare('inv_typ2',$this->inv_typ2,true);
		$criteria->compare('brk_cod1',$this->brk_cod1,true);
		$criteria->compare('inv_typ1',$this->inv_typ1,true);
		$criteria->compare('stk_code',$this->stk_code,true);
		$criteria->compare('stk_volm',$this->stk_volm);
		$criteria->compare('stk_pric',$this->stk_pric);

		if(!empty($this->trx_date_date))
			$criteria->addCondition("TO_CHAR(t.trx_date,'DD') LIKE '%".($this->trx_date_date)."%'");
		if(!empty($this->trx_date_month))
			$criteria->addCondition("TO_CHAR(t.trx_date,'MM') LIKE '%".($this->trx_date_month)."%'");
		if(!empty($this->trx_date_year))
			$criteria->addCondition("TO_CHAR(t.trx_date,'YYYY') LIKE '%".($this->trx_date_year)."%'");		$criteria->compare('trx_ord2',$this->trx_ord2);
		$criteria->compare('trx_ord1',$this->trx_ord1);
		$criteria->compare('trx_ref2',$this->trx_ref2,true);
		$criteria->compare('trx_ref1',$this->trx_ref1,true);
		$criteria->compare('trx_kopur',$this->trx_kopur);
		$criteria->compare('trx_time',$this->trx_time,true);
		$criteria->compare('trx_user',$this->trx_user,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}