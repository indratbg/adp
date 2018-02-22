<?php

/**
 * This is the model class for table "MST_GROUP_ACCOUNT".
 *
 * The followings are the available columns in table 'MST_GROUP_ACCOUNT':
 * @property string $pl_bs_flg
 * @property integer $grp_1
 * @property integer $grp_2
 * @property integer $grp_3
 * @property integer $grp_4
 * @property integer $grp_5
 * @property string $gl_acct_cd
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $user_id
 * @property string $line_desc
 * @property string $formula
 */
class Groupaccount extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;
	//AH: #END search (datetime || date)  additional comparison
	
	public $filterCriteria;
	public $acct_name;
	public $save_flg = 'N';
	public $cancel_flg = 'N';
	
	public $old_pl_bs_flg;
	public $old_grp_1;
	public $old_grp_2;
	public $old_grp_3;
	public $old_grp_4;
	public $old_grp_5;
	
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
		return 'MST_GROUP_ACCOUNT';
	}

	public function executeSp($exec_status,$old_pl_bs_flg,$old_grp_1,$old_grp_2,$old_grp_3,$old_grp_4,$old_grp_5)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_MST_GROUP_ACCOUNT_UPD(
						:P_SEARCH_PL_BS_FLG,
						:P_SEARCH_GRP_1,
						:P_SEARCH_GRP_2,
						:P_SEARCH_GRP_3,
						:P_SEARCH_GRP_4,
						:P_SEARCH_GRP_5,
						:P_PL_BS_FLG,
						:P_GRP_1,
						:P_GRP_2,
						:P_GRP_3,
						:P_GRP_4,
						:P_GRP_5,
						:P_GL_ACCT_CD,
						:P_LINE_DESC,
						:P_FORMULA,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
						TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_USER_ID,
						:P_UPD_BY,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
			
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_PL_BS_FLG",$old_pl_bs_flg,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_GRP_1",$old_grp_1,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_GRP_2",$old_grp_2,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_GRP_3",$old_grp_3,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_GRP_4",$old_grp_4,PDO::PARAM_STR);
			$command->bindValue(":P_SEARCH_GRP_5",$old_grp_5,PDO::PARAM_STR);
			$command->bindValue(":P_PL_BS_FLG",$this->pl_bs_flg,PDO::PARAM_STR);
			$command->bindValue(":P_GRP_1",$this->grp_1,PDO::PARAM_STR);
			$command->bindValue(":P_GRP_2",$this->grp_2,PDO::PARAM_STR);
			$command->bindValue(":P_GRP_3",$this->grp_3,PDO::PARAM_STR);
			$command->bindValue(":P_GRP_4",$this->grp_4,PDO::PARAM_STR);
			$command->bindValue(":P_GRP_5",$this->grp_5,PDO::PARAM_STR);
			$command->bindValue(":P_GL_ACCT_CD",$this->gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_LINE_DESC",$this->line_desc,PDO::PARAM_STR);
			$command->bindValue(":P_FORMULA",$this->formula,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);

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
		
			array('grp_1, grp_2, grp_3, grp_4, grp_5', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('pl_bs_flg,grp_1,grp_2,grp_3,grp_4,grp_5,gl_acct_cd','required'),
			array('user_id', 'length', 'max'=>10),
			array('line_desc, formula', 'length', 'max'=>50),
			array('old_pl_bs_flg, old_grp_1, old_grp_2, old_grp_3, old_grp_4, old_grp_5, acct_name, save_flg, cancel_flg, cre_dt, upd_dt', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('pl_bs_flg, grp_1, grp_2, grp_3, grp_4, grp_5, gl_acct_cd, cre_dt, upd_dt, user_id, line_desc, formula,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year', 'safe', 'on'=>'search'),
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
			'pl_bs_flg' => 'Item Type',
			'grp_1' => 'Grp 1',
			'grp_2' => 'Grp 2',
			'grp_3' => 'Grp 3',
			'grp_4' => 'Grp 4',
			'grp_5' => 'Grp 5',
			'gl_acct_cd' => 'GL Account',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'user_id' => 'User',
			'line_desc' => 'Line Desc',
			'formula' => 'Formula',
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('pl_bs_flg',$this->pl_bs_flg,true);
		$criteria->compare('grp_1',$this->grp_1);
		$criteria->compare('grp_2',$this->grp_2);
		$criteria->compare('grp_3',$this->grp_3);
		$criteria->compare('grp_4',$this->grp_4);
		$criteria->compare('grp_5',$this->grp_5);
		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);

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
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".$this->upd_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('line_desc',$this->line_desc,true);
		$criteria->compare('formula',$this->formula,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}