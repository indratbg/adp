<?php

/**
 * This is the model class for table "T_LK_REP".
 *
 * The followings are the available columns in table 'T_LK_REP':
 * @property string $report_date
 * @property integer $line_num
 * @property string $col1
 * @property string $col2
 * @property integer $col3
 * @property string $col4
 * @property integer $col5
 * @property integer $col6
 * @property integer $col7
 * @property integer $col8
 * @property integer $col9
 * @property integer $colx
 * @property string $cre_dt
 * @property string $user_id
 */
class Tlkrep extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $report_date_date;
	public $report_date_month;
	public $report_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;
	public $save_flg='N';
	public $acct_desc;
	public $old_line_num;
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
		return 'T_LK_REP';
	}

		public function getDbConnection()
	{
				return Yii::app()->dbrpt;
	}

	public function rules()
	{
		return array(
		
			array('report_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('line_num, col3, col5, col6, col7, col8, col9, colx', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('line_num, col3, col5, col6, col7, col8, col9, colx', 'numerical', 'integerOnly'=>true),
			array('col1', 'length', 'max'=>5),
			array('col2', 'length', 'max'=>80),
			array('col4', 'length', 'max'=>30),
			array('user_id', 'length', 'max'=>10),
			array('old_line_num,acct_desc,save_flg,report_date, cre_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('report_date, line_num, col1, col2, col3, col4, col5, col6, col7, col8, col9, colx, cre_dt, user_id,report_date_date,report_date_month,report_date_year,cre_dt_date,cre_dt_month,cre_dt_year', 'safe', 'on'=>'search'),
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
			'report_date' => 'Report Date',
			'line_num' => 'Line Num',
			'col1' => 'Col1',
			'col2' => 'Col2',
			'col3' => 'Col3',
			'col4' => 'Col4',
			'col5' => 'Col5',
			'col6' => 'Col6',
			'col7' => 'Col7',
			'col8' => 'Col8',
			'col9' => 'Col9',
			'colx' => 'Colx',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
		);
	}
public function executeSp($exec_status)
	{
		$connection  = Yii::app()->dbrpt;		
		try{
			$query  = "CALL Sp_T_LK_REP_UPD( to_date(:P_end_DATE,'yyyy-mm-dd'),
											   :P_LINE_NUM,
											   :P_COL2,
											   :P_COL4,
											   :P_COL5,
											   :P_COL6,
											   :P_COL7,
											   :P_UPD_STATUS,
											   :P_USER_ID,
											   :P_ERROR_CODE,
											   :P_ERROR_MSG)";	
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_end_DATE",$this->report_date,PDO::PARAM_STR);
			$command->bindValue(":P_LINE_NUM",$this->line_num,PDO::PARAM_STR);
			$command->bindValue(":P_COL2",$this->col2,PDO::PARAM_STR);
			$command->bindValue(":P_COL4",$this->col4,PDO::PARAM_STR);
			$command->bindValue(":P_COL5",$this->col5,PDO::PARAM_STR);
			$command->bindValue(":P_COL6",$this->col6,PDO::PARAM_STR);
			$command->bindValue(":P_COL7",$this->col7,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

			$command->execute();
		
		}catch(Exception $ex){
			
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->report_date_date))
			$criteria->addCondition("TO_CHAR(t.report_date,'DD') LIKE '%".$this->report_date_date."%'");
		if(!empty($this->report_date_month))
			$criteria->addCondition("TO_CHAR(t.report_date,'MM') LIKE '%".$this->report_date_month."%'");
		if(!empty($this->report_date_year))
			$criteria->addCondition("TO_CHAR(t.report_date,'YYYY') LIKE '%".$this->report_date_year."%'");		$criteria->compare('line_num',$this->line_num);
		$criteria->compare('col1',$this->col1,true);
		$criteria->compare('col2',$this->col2,true);
		$criteria->compare('col3',$this->col3);
		$criteria->compare('col4',$this->col4,true);
		$criteria->compare('col5',$this->col5);
		$criteria->compare('col6',$this->col6);
		$criteria->compare('col7',$this->col7);
		$criteria->compare('col8',$this->col8);
		$criteria->compare('col9',$this->col9);
		$criteria->compare('colx',$this->colx);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}