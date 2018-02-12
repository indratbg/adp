<?php

/**
 * This is the model class for table "T_FASSET_MOVEMENT".
 *
 * The followings are the available columns in table 'T_FASSET_MOVEMENT':
 * @property string $doc_date
 * @property string $asset_cd
 * @property string $mvmt_type
 * @property integer $qty
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_by
 * @property string $upd_dt
 * @property string $approved_stat
 * @property string $approved_by
 * @property string $to_asset_cd
 */
class Fixedassetmovement extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $doc_date_date;
	public $doc_date_month;
	public $doc_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	public static $mvmt=array(''=>'-Select-','BUY'=>'BUY','SELL'=>'SELL','TRANSFER'=>'TRANSFER','WRITE OFF'=>'WRITE OFF');
	public $branch_cd='';
	public $to_branch='';
	public $asset_desc;
	public $asset_type;
	public $to_asset_cd;
	public $age;
	public $purch_dt;
	public $purch_price;
	public $accum_last_yr;
	public $asset_stat;
	public $qty_1;

	
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
		return 'T_FASSET_MOVEMENT';
	}

	public function getPrimaryKey()
	{
		return array('doc_date'=>$this->doc_date,'asset_cd'=>$this->asset_cd);
	}

	public function executeSpTFasset($exec_status,$doc_date,$asset_cd,$record_seq)
	{
		$connection  = Yii::app()->db;
		// $transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_T_FASSET_MOVEMENT_UPD(
						:P_SEARCH_DOC_DATE,
						:P_SEARCH_ASSET_CD,
						:P_DOC_DATE,
						:P_ASSET_CD,
						:P_MVMT_TYPE,
						:P_QTY,
						:P_TO_ASSET_CD,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,
						
						:P_UPD_STATUS,
						:p_ip_address,
						:p_cancel_reason,
						TO_DATE(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),
						:p_update_seq,
						:p_record_seq,
						:p_error_code,
						:p_error_msg)";
			
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_SEARCH_DOC_DATE",$doc_date,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_ASSET_CD",$asset_cd,PDO::PARAM_STR);
			$command->bindValue(":P_DOC_DATE",$this->doc_date,PDO::PARAM_STR);
			$command->bindValue(":P_ASSET_CD",$this->asset_cd,PDO::PARAM_STR);
			$command->bindValue(":P_MVMT_TYPE",$this->mvmt_type,PDO::PARAM_STR);
			$command->bindValue(":P_QTY",$this->qty,PDO::PARAM_STR);	
			$command->bindValue(":P_TO_ASSET_CD",$this->to_asset_cd,PDO::PARAM_STR);	
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
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);


			$command->execute();
			// $transaction->commit();
		}catch(Exception $ex){
			// $transaction->rollback();
			if($this->error_code == -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

public function executeSpMSTFasset($exec_status,$asset_cd,$record_seq)
	{
		$connection  = Yii::app()->db;
		// $transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_MST_FASSET_MOV_UPD(
						:P_SEARCH_ASSET_CD,
						:P_ASSET_CD,
						:P_ASSET_STAT,
						:P_ASSET_TYPE,
						:P_BRANCH_CD,
						:P_ASSET_DESC,
						:P_AGE,
						:P_PURCH_DT,
						:P_PURCH_PRICE,
						:P_TO_ASSET_CD,
						:P_TO_BRANCH_CD,
						:P_ACCUM_LAST_YR,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPD_BY,
						
						:P_UPD_STATUS,
						:p_ip_address,
						:p_cancel_reason,
						TO_DATE(:p_update_date,'YYYY-MM-DD HH24:MI:SS'),
						:p_update_seq,
						:p_record_seq,
						:p_error_code,
						:p_error_msg)";
			
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_SEARCH_ASSET_CD",$asset_cd,PDO::PARAM_STR);
			$command->bindValue(":P_ASSET_CD",$this->asset_cd,PDO::PARAM_STR);
			$command->bindValue(":P_ASSET_STAT",$this->asset_stat,PDO::PARAM_STR);
			$command->bindValue(":P_ASSET_TYPE",$this->asset_type,PDO::PARAM_STR);
			$command->bindValue(":P_BRANCH_CD",$this->branch_cd,PDO::PARAM_STR);
			$command->bindValue(":P_ASSET_DESC",$this->asset_desc,PDO::PARAM_STR);
			$command->bindValue(":P_AGE",$this->age,PDO::PARAM_STR);
			$command->bindValue(":P_PURCH_DT",$this->purch_dt,PDO::PARAM_STR);
			$command->bindValue(":P_PURCH_PRICE",$this->purch_price,PDO::PARAM_STR);
			$command->bindValue(":P_TO_ASSET_CD",$this->to_asset_cd,PDO::PARAM_STR);
			$command->bindValue(":P_TO_BRANCH_CD",$this->to_branch,PDO::PARAM_STR);
			$command->bindValue(":P_ACCUM_LAST_YR",$this->accum_last_yr,PDO::PARAM_STR);
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
			$command->bindParam(":P_ERROR_MSG",$this->error_msg,PDO::PARAM_STR,1000);


			$command->execute();
			// $transaction->commit();
		}catch(Exception $ex){
			// $transaction->rollback();
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
		
			array('doc_date,purch_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('qty,qty_1,purch_price', 'application.components.validator.ANumberSwitcherValidator'),
			array('asset_cd, doc_date,mvmt_type','required'),			
			array('qty,qty_1,purch_price', 'numerical', 'integerOnly'=>true),
			array('mvmt_type, user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_stat', 'length', 'max'=>1),
			array('to_asset_cd', 'length', 'max'=>7),
			array('cre_dt, upd_dt, age, branch_cd, to_branch, to_asset_cd, asset_type, asset_desc, purch_dt, purch_price, accum_last_yr, asset_stat', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('doc_date, asset_cd, mvmt_type, qty, user_id, cre_dt, upd_by, upd_dt, approved_stat, approved_by, to_asset_cd,doc_date_date,doc_date_month,doc_date_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'doc_date' => 'Date',
			'asset_cd' => 'Asset Code',
			'mvmt_type' => 'Movement',
			'qty' => 'Quantity yang di Input',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_by' => 'Upd By',
			'upd_dt' => 'Upd Date',
			'approved_stat' => 'Approved Stat',
			'approved_by' => 'Approved By',
			'to_asset_cd' => 'To Asset Code',
			'branch_cd' => 'Branch',
			'purch_dt'=>'Purchase Date',
			'purch_price'=>'Purchase Price',
			'to_asset_cd'=>'New Asset',
			'to_branch'=>'To Branch',
			'asset_desc'=>'Description',
			'qty_1'=>'Quantity di Sistem'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->select = "t.doc_date, b.branch_cd, t.asset_cd, b.asset_desc, t.mvmt_type, t.qty, 
							 decode(t.to_asset_cd,null,null,a.branch_cd) as TO_BRANCH";
		$criteria->join = "LEFT JOIN mst_fixed_asset a ON nvl(t.to_asset_cd,'X')=a.asset_cd
						   JOIN mst_fixed_asset b on t.asset_cd=b.asset_cd";
		
		
		if(!empty($this->doc_date))
			$criteria->addCondition("TO_CHAR(t.doc_date,'dd/mm/yyyy') LIKE '%".$this->doc_date."%'");
				
		$criteria->compare('asset_cd',$this->asset_cd,true);
		$criteria->compare('mvmt_type',$this->mvmt_type,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('b.branch_cd',$this->branch_cd,true);
		$criteria->compare('TO_BRANCH',$this->to_branch,true);
		$criteria->compare('a.asset_desc',$this->asset_desc,true);
		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		
		
		$criteria->compare('t.upd_by',$this->upd_by,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		
		
		$criteria->compare('approved_stat',$this->approved_stat,true);
		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('to_asset_cd',$this->to_asset_cd,true);
		$sort = new CSort;
		
		$sort->defaultOrder='doc_date,branch_cd,asset_cd';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}