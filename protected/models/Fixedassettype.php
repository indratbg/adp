<?php

/**
 * This is the model class for table "MST_PARAMETER".
 *
 * The followings are the available columns in table 'MST_PARAMETER':
 * @property string $prm_cd_1
 * @property string $prm_cd_2
 * @property string $prm_desc
 * @property string $prm_desc2
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 */
class Fixedassettype extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $gl_acct_db;
	public $gl_acct_cr;
	public $sl_acct_db;
	public $sl_acct_cr;
	
	public $update_date;
	public $update_seq;
	
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
		return 'MST_PARAMETER';
	}
	
	public function getPrimaryKey()
	{
		return array('prm_cd_1'=>$this->prm_cd_1,'prm_cd_2'=>$this->prm_cd_2);
	}
	
	public function executeSpManyHeader($exec_status,$menuName,&$transaction)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_T_MANY_HEADER_INSERT(
						:P_MENU_NAME,
						:P_STATUS,
						:P_USER_ID,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_UPDATE_DATE,
						:P_UPDATE_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_MENU_NAME",$menuName,PDO::PARAM_STR);
			$command->bindValue(":P_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);			
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			
			$command->bindParam(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR,30);
			$command->bindParam(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR,10);
			$command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);

			$command->execute();
			
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}
	
	public function executeSp($exec_status,$old_prm_cd_2,$record_seq,&$transaction)
	{
		$connection  = Yii::app()->db;
		
		$this->prm_cd_1 = 'FASSET';
		
		$this->prm_desc2 = $this->gl_acct_db.$this->sl_acct_db.$this->gl_acct_cr.$this->sl_acct_cr;
		
		try{
			$query  = "CALL SP_FIXED_ASSET_TYPE_UPD(
						:P_SEARCH_PRM_CD_1,
						:P_SEARCH_PRM_CD_2,		
						:P_PRM_CD_1,
						:P_PRM_CD_2,
						:P_PRM_DESC,
						:P_PRM_DESC2,	
						:P_USER_ID,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),		
						:P_UPD_BY,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_UPDATE_DATE,
						:P_UPDATE_SEQ,
						:P_RECORD_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_SEARCH_PRM_CD_1",$this->prm_cd_1,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_PRM_CD_2",$old_prm_cd_2,PDO::PARAM_STR);
			$command->bindValue(":P_PRM_CD_1",$this->prm_cd_1,PDO::PARAM_STR);
            $command->bindValue(":P_PRM_CD_2",$this->prm_cd_2,PDO::PARAM_STR);
            $command->bindValue(":P_PRM_DESC",$this->prm_desc,PDO::PARAM_STR);
            $command->bindValue(":P_PRM_DESC2",$this->prm_desc2,PDO::PARAM_STR);
			
            $command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR); 
            $command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR); 
            $command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR); 
            $command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR); 
            $command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR); 
            $command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR); 
            $command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR); 
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR); 
			$command->bindValue(":P_RECORD_SEQ",$record_seq,PDO::PARAM_STR);  
             
             
            $command->bindParam(":P_ERROR_CODE",$this->error_code,PDO::PARAM_INT,10); 
            $command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,100); 
			
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

	public function rules()
	{
		return array(
		
			array('approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			
			array('prm_desc,prm_cd_2,gl_acct_db,gl_acct_cr,sl_acct_db,sl_acct_cr', 'required'),
			array('prm_desc', 'length', 'max'=>255),
			array('prm_desc2', 'length', 'max'=>1000),
			array('user_id', 'length', 'max'=>8),
			array('upd_by, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('cre_dt, upd_dt, approved_dt', 'safe'),
			array('gl_acct_db,gl_acct_cr','length','is'=>4),
			array('sl_acct_db,sl_acct_cr','length','is'=>6),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('prm_cd_1, prm_cd_2, prm_desc, prm_desc2, user_id, cre_dt, upd_dt, upd_by, approved_dt, approved_by, approved_stat,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
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
			'prm_cd_1' => 'Prm Code 1',
			'prm_cd_2' => 'Asset Type Code',
			'prm_desc' => 'Description',
			'prm_desc2' => 'Prm Desc2',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
			
			'gl_acct_db' => 'GL Account Debit',
			'gl_acct_cr' => 'GL Account Credit',
			'sl_acct_db' => 'SL Account Debit',
			'sl_acct_cr' => 'SL Account Credit',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'PRM_CD_1,PRM_CD_2,PRM_DESC,PRM_DESC2,USER_ID,CRE_DT,UPD_DT,
							 substr(prm_desc2,1,4) gl_acct_db,substr(prm_desc2,5,6) sl_acct_db,
							 substr(prm_desc2,11,4) gl_acct_cr,substr(prm_desc2,15,6) sl_acct_cr';
							 
		$criteria->compare('prm_cd_1',$this->prm_cd_1,true);
		$criteria->compare('prm_cd_2',$this->prm_cd_2,true);
		$criteria->compare('prm_desc',$this->prm_desc,true);
		$criteria->compare('prm_desc2',$this->prm_desc2,true);
		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");
		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('upd_by',$this->upd_by,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);
		
		$sort = new CSort;
		$sort->defaultOrder = 'prm_cd_2';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}