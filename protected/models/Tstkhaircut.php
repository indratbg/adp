<?php

/**
 * This is the model class for table "T_STK_HAIRCUT".
 *
 * The followings are the available columns in table 'T_STK_HAIRCUT':
 * @property string $status_dt
 * @property string $stk_cd
 * @property double $haircut
 * @property string $create_dt
 * @property string $user_id
 */
class Tstkhaircut extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $status_dt_date;
	public $status_dt_month;
	public $status_dt_year;

	public $create_dt_date;
	public $create_dt_month;
	public $create_dt_year;
    public $file_upload;
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
    

	public function tableName()
	{
		return 'T_STK_HAIRCUT';
	}

	public function rules()
	{
		return array(
		
			array('status_dt, create_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		      array('file_upload','file','types'=>'txt','wrongType'=>'File type must be txt','on'=>'upload'),
			array('haircut', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('haircut', 'numerical'),
			array('user_id', 'length', 'max'=>10),
			array('create_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('status_dt, stk_cd, haircut, create_dt, user_id,status_dt_date,status_dt_month,status_dt_year,create_dt_date,create_dt_month,create_dt_year', 'safe', 'on'=>'search'),
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
			'status_dt' => 'Status Date',
			'stk_cd' => 'Stk Code',
			'haircut' => 'Haircut',
			'create_dt' => 'Create Date',
			'user_id' => 'User',
		);
	}


    public function executeSpUpdateCounter()
    {
        $connection  = Yii::app()->db;
        $transaction = $connection->beginTransaction();
        try{
            $query  = "CALL SP_UPD_STK_HAIRCUT(:p_user_id ,
                                            :P_ERROR_CD,
                                            :P_ERROR_MSG)";

            $command = $connection->createCommand($query);
            $command->bindValue(":p_user_id",$this->user_id,PDO::PARAM_STR);
            $command->bindParam(":P_ERROR_CD",$this->error_code,PDO::PARAM_INT,10);
            $command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,200);
            $command->execute();
            $transaction->commit();
        }catch(Exception $ex){
            $transaction->rollback();
            if($this->error_code == -999)
                $this->error_msg = $ex->getMessage();
        }
    
        if($this->error_code < 0)
            $this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
        
        return $this->error_code;
    }

	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->status_dt_date))
			$criteria->addCondition("TO_CHAR(t.status_dt,'DD') LIKE '%".$this->status_dt_date."%'");
		if(!empty($this->status_dt_month))
			$criteria->addCondition("TO_CHAR(t.status_dt,'MM') LIKE '%".$this->status_dt_month."%'");
		if(!empty($this->status_dt_year))
			$criteria->addCondition("TO_CHAR(t.status_dt,'YYYY') LIKE '%".$this->status_dt_year."%'");		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('haircut',$this->haircut);

		if(!empty($this->create_dt_date))
			$criteria->addCondition("TO_CHAR(t.create_dt,'DD') LIKE '%".$this->create_dt_date."%'");
		if(!empty($this->create_dt_month))
			$criteria->addCondition("TO_CHAR(t.create_dt,'MM') LIKE '%".$this->create_dt_month."%'");
		if(!empty($this->create_dt_year))
			$criteria->addCondition("TO_CHAR(t.create_dt,'YYYY') LIKE '%".$this->create_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}