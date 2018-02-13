<?php

/**
 * This is the model class for table "MST_CLIENT_INST".
 *
 * The followings are the available columns in table 'MST_CLIENT_INST':
 * @property string $cifs
 * @property integer $local_share_perc
 * @property integer $foreign_share_perc
 * @property string $premise_stat
 * @property string $premise_stat_text
 * @property string $premise_age
 * @property string $investment_type
 * @property string $investment_type_text
 * @property string $transaction_freq
 * @property string $trans_auth_name
 * @property string $trans_auth_phone_num
 * @property string $trans_auth_ic_num
 * @property string $trans_auth_relation
 * @property string $legal_domicile
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_by
 * @property string $upd_dt
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 * @property string $suppl_doc_type
 * @property string $suppl_exp_date
 */
class Clientinst extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	//RD: Edited add suppl_doc_type and suppl_exp_date 7 sept 2017
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
		return 'MST_CLIENT_INST';
	}
	
	public function executeSp($exec_status,$old_cif,$update_date,$update_seq,$record_seq)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_MST_CLIENT_INST_UPD(
						:P_SEARCH_CIFS,
						:P_CIFS,
						:P_LOCAL_SHARE_PERC,
						:P_FOREIGN_SHARE_PERC,
						:P_PREMISE_STAT,
						:P_PREMISE_STAT_TEXT,
						:P_PREMISE_AGE,
						:P_INVESTMENT_TYPE,
						:P_INVESTMENT_TYPE_TEXT,
						:P_TRANSACTION_FREQ,
						:P_TRANS_AUTH_NAME,
						:P_TRANS_AUTH_PHONE_NUM,
						:P_TRANS_AUTH_IC_NUM,
						:P_TRANS_AUTH_RELATION,
						:P_LEGAL_DOMICILE,
						:P_NET_PROFIT_CD,
						:P_NET_PROFIT_TEXT,
						:P_NON_OPR_INCM_CD,
						:P_NON_OPR_INCM_TEXT,
						:P_NET_ASSET_CD2,
						:P_NET_ASSET2,
						:P_NET_ASSET_YR2,
						:P_NET_ASSET_CD3,
						:P_NET_ASSET3,
						:P_NET_ASSET_YR3,
						:P_PROFIT_CD2,
						:P_PROFIT2,
						:P_PROFIT_CD3,
						:P_PROFIT3,
						:P_LIABILITY,
						:P_SUPPL_DOC_TYPE,
					  	TO_DATE(:P_SUPPL_EXP_DATE,'YYYY-MM-DD'),
						:P_CRE_DT,
						:P_USER_ID,
						:P_UPD_DT,
						:P_UPD_BY,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPDATE_SEQ,
						:P_RECORD_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_CIFS",$old_cif,PDO::PARAM_STR);
			$command->bindValue(":P_CIFS",$this->cifs,PDO::PARAM_STR);
			$command->bindValue(":P_LOCAL_SHARE_PERC",$this->local_share_perc,PDO::PARAM_STR);
			$command->bindValue(":P_FOREIGN_SHARE_PERC",$this->foreign_share_perc,PDO::PARAM_STR);
			$command->bindValue(":P_PREMISE_STAT",$this->premise_stat,PDO::PARAM_STR);
			$command->bindValue(":P_PREMISE_STAT_TEXT",$this->premise_stat_text,PDO::PARAM_STR);
			$command->bindValue(":P_PREMISE_AGE",$this->premise_age,PDO::PARAM_STR);
			$command->bindValue(":P_INVESTMENT_TYPE",$this->investment_type,PDO::PARAM_STR);
			$command->bindValue(":P_INVESTMENT_TYPE_TEXT",$this->investment_type_text,PDO::PARAM_STR);
			$command->bindValue(":P_TRANSACTION_FREQ",$this->transaction_freq,PDO::PARAM_STR);
			$command->bindValue(":P_TRANS_AUTH_NAME",$this->trans_auth_name,PDO::PARAM_STR);
			$command->bindValue(":P_TRANS_AUTH_PHONE_NUM",$this->trans_auth_phone_num,PDO::PARAM_STR);
			$command->bindValue(":P_TRANS_AUTH_IC_NUM",$this->trans_auth_ic_num,PDO::PARAM_STR);
			$command->bindValue(":P_TRANS_AUTH_RELATION",$this->trans_auth_relation,PDO::PARAM_STR);
			$command->bindValue(":P_LEGAL_DOMICILE",$this->legal_domicile,PDO::PARAM_STR);
			$command->bindValue(":P_NET_PROFIT_CD",$this->net_profit_cd,PDO::PARAM_STR);
			$command->bindValue(":P_NET_PROFIT_TEXT",$this->net_profit_text,PDO::PARAM_STR);
			$command->bindValue(":P_NON_OPR_INCM_CD",$this->non_opr_incm_cd,PDO::PARAM_STR);
			$command->bindValue(":P_NON_OPR_INCM_TEXT",$this->non_opr_incm_text,PDO::PARAM_STR);
			$command->bindValue(":P_NET_ASSET_CD2",$this->net_asset_cd2,PDO::PARAM_STR);
			$command->bindValue(":P_NET_ASSET2",$this->net_asset2,PDO::PARAM_STR);
			$command->bindValue(":P_NET_ASSET_YR2",$this->net_asset_yr2,PDO::PARAM_STR);
			$command->bindValue(":P_NET_ASSET_CD3",$this->net_asset_cd3,PDO::PARAM_STR);
			$command->bindValue(":P_NET_ASSET3",$this->net_asset3,PDO::PARAM_STR);
			$command->bindValue(":P_NET_ASSET_YR3",$this->net_asset_yr3,PDO::PARAM_STR);
			$command->bindValue(":P_PROFIT_CD2",$this->profit_cd2,PDO::PARAM_STR);
			$command->bindValue(":P_PROFIT2",$this->profit2,PDO::PARAM_STR);
			$command->bindValue(":P_PROFIT_CD3",$this->profit_cd3,PDO::PARAM_STR);
			$command->bindValue(":P_PROFIT3",$this->profit3,PDO::PARAM_STR);
			$command->bindValue(":P_LIABILITY",$this->liability,PDO::PARAM_STR);
			$command->bindValue(":P_SUPPL_DOC_TYPE",$this->suppl_doc_type,PDO::PARAM_STR);
			$command->bindValue(":P_SUPPL_EXP_DATE",$this->suppl_exp_date,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);			
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$update_seq,PDO::PARAM_STR);
			$command->bindValue(":P_RECORD_SEQ",$record_seq,PDO::PARAM_STR);	
					
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

	public function rules()
	{
		return array(
		
			array('approved_dt, suppl_exp_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('local_share_perc, foreign_share_perc', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('legal_domicile','required'),
			
			array('premise_stat_text','checkPremise'),
			array('investment_type_text','checkInvestment'),
			
			array('local_share_perc, foreign_share_perc', 'numerical', 'integerOnly'=>true),
			array('premise_stat, investment_type, transaction_freq, approved_stat', 'length', 'max'=>1),
			array('premise_stat_text', 'length', 'max'=>20),
			array('premise_age', 'length', 'max'=>25),
			array('investment_type_text, trans_auth_name, trans_auth_ic_num, trans_auth_relation', 'length', 'max'=>30),
			array('trans_auth_phone_num', 'length', 'max'=>15),
			array('legal_domicile', 'length', 'max'=>40),
			array('user_id', 'length', 'max'=>8),
			array('upd_by, approved_by', 'length', 'max'=>10),
			array('suppl_doc_type, net_asset_cd2, net_asset_cd3, net_asset2, net_asset3, net_asset_yr2, net_asset_yr3, profit_cd2, profit_cd3, profit2, profit3, liability, net_profit_cd, net_profit_text, non_opr_incm_cd, non_opr_incm_text, cre_dt, upd_dt, approved_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('cifs, local_share_perc, foreign_share_perc, premise_stat, premise_stat_text, premise_age, investment_type, investment_type_text, transaction_freq, trans_auth_name, trans_auth_phone_num, trans_auth_ic_num, trans_auth_relation, legal_domicile, cre_dt, user_id, upd_by, upd_dt, approved_dt, approved_by, approved_stat,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function checkPremise()
	{
		if($this->premise_stat == '9' && !$this->premise_stat_text)$this->addError('premise_stat_text','Office Domicile Status must be specified if \'LAINNYA\' is chosen');
	}
	
	public function checkInvestment()
	{
		if($this->investment_type == '9' && !$this->investment_type_text)$this->addError('investment_type_text','Instrument of Investment must be specified if \'LAINNYA\' is chosen');
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'cifs' => 'Cifs',
			'local_share_perc' => 'Local Share Perc',
			'foreign_share_perc' => 'Foreign Share Perc',
			'premise_stat' => 'Premises Status',
			'premise_stat_text' => 'Premise Stat Text',
			'premise_age' => 'Lama Menempati Kantor',
			'investment_type' => 'Instrument of Investment',
			'investment_type_text' => 'Investment Type Text',
			'transaction_freq' => 'Transaction Frequency',
			'trans_auth_name' => 'Trans Auth Name',
			'trans_auth_phone_num' => 'Trans Auth Phone Num',
			'trans_auth_ic_num' => 'Trans Auth Ic Num',
			'trans_auth_relation' => 'Trans Auth Relation',
			'legal_domicile' => 'Legal Domicile',
			'net_profit_cd' => 'Laba Bersih',
			'net_profit_text' => 'Laba Bersih',
			'non_opr_incm_cd' => 'Non Operational Profit',
			'non_opr_incm_text' => 'Non Operational Profit',
			'net_asset_cd2'	=> 'Kekayaan Bersih',
			'net_asset_cd3'	=> 'Kekayaan Bersih',
			'net_asset_yr'	=> 'Tahun',
			'net_asset_yr'	=> 'Tahun',
			'profit_cd2'	=> 'Operational Profit',
			'profit_cd3'	=> 'Operational Profit',
			'liability'		=>' Total Kewajiban',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_by' => 'Upd By',
			'upd_dt' => 'Upd Date',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Stat',
			'suppl_doc_type' => 'Supplementary Doc',
			'suppl_exp_date' => 'Tanggal Kadaluarsa',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('cifs',$this->cifs,true);
		$criteria->compare('local_share_perc',$this->local_share_perc);
		$criteria->compare('foreign_share_perc',$this->foreign_share_perc);
		$criteria->compare('premise_stat',$this->premise_stat,true);
		$criteria->compare('premise_stat_text',$this->premise_stat_text,true);
		$criteria->compare('premise_age',$this->premise_age,true);
		$criteria->compare('investment_type',$this->investment_type,true);
		$criteria->compare('investment_type_text',$this->investment_type_text,true);
		$criteria->compare('transaction_freq',$this->transaction_freq,true);
		$criteria->compare('trans_auth_name',$this->trans_auth_name,true);
		$criteria->compare('trans_auth_phone_num',$this->trans_auth_phone_num,true);
		$criteria->compare('trans_auth_ic_num',$this->trans_auth_ic_num,true);
		$criteria->compare('trans_auth_relation',$this->trans_auth_relation,true);
		$criteria->compare('legal_domicile',$this->legal_domicile,true);
		$criteria->compare('suppl_doc_type',$this->suppl_doc_type,true);
		$criteria->compare('suppl_exp_date',$this->suppl_exp_date,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('upd_by',$this->upd_by,true);

		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".$this->upd_dt_date."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".$this->upd_dt_month."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");
		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".$this->approved_dt_date."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".$this->approved_dt_month."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}