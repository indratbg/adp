<?php

/**
 * This is the model class for table "MST_BOND".
 *
 * The followings are the available columns in table 'MST_BOND':
 * @property string $bond_cd
 * @property string $bond_desc
 * @property string $int_type
 * @property double $interest
 * @property double $fee_ijarah
 * @property double $nisbah
 * @property string $issue_date
 * @property string $listing_date
 * @property string $maturity_date
 * @property string $isin_code
 * @property string $issuer
 * @property string $sec_sector
 * @property string $bond_group_cd
 * @property string $product_type
 * @property string $short_desc
 * @property string $int_freq
 * @property string $day_count_basis
 * @property string $gl_acct_cd
 * @property string $sl_acct_cd
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_sts
 * @property string $first_coupon_date
 */
class Bond extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $issue_date_date;
	public $issue_date_month;
	public $issue_date_year;

	public $listing_date_date;
	public $listing_date_month;
	public $listing_date_year;

	public $maturity_date_date;
	public $maturity_date_month;
	public $maturity_date_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	
	public $first_coupon_date_date;
	public $first_coupon_date_month;
	public $first_coupon_date_year;
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
		return 'MST_BOND';
	}
	
	public function getBondDesc()
	{
		return $this->bond_cd.' - '.$this->short_desc;
	}

	public function rules()
	{
		return array(
		
			array('first_coupon_date, issue_date, listing_date, maturity_date, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('interest, fee_ijarah, nisbah', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('first_coupon_date, bond_cd,bond_group_cd,product_type,bond_desc,short_desc,maturity_date,interest,int_type,int_freq,day_count_basis', 'required'),
			array('interest, fee_ijarah, nisbah', 'numerical'),
			array('bond_cd, isin_code, product_type', 'length', 'max'=>20),
			array('bond_desc, issuer', 'length', 'max'=>100),
			array('int_type, int_freq, day_count_basis', 'length', 'max'=>25),
			array('sec_sector, gl_acct_cd', 'length', 'max'=>4),
			array('bond_group_cd', 'length', 'max'=>2),
			array('short_desc', 'length', 'max'=>50),
			array('sl_acct_cd', 'length', 'max'=>12),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('approved_sts', 'length', 'max'=>1),
			array('issue_date, listing_date, maturity_date, cre_dt, upd_dt, isin_code,approved_dt,listing_date', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('bond_cd, bond_desc, int_type, interest, fee_ijarah, nisbah, issue_date, listing_date, maturity_date, isin_code, 
			issuer, sec_sector, bond_group_cd, product_type, short_desc, int_freq, day_count_basis, gl_acct_cd, sl_acct_cd, cre_dt, 
			user_id, upd_dt, upd_by, approved_dt, approved_by, approved_sts,issue_date_date,issue_date_month,issue_date_year,
			listing_date_date,listing_date_month,listing_date_year,maturity_date_date,maturity_date_month,maturity_date_year,cre_dt_date,
			cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year,
			first_coupon_date_date, first_coupon_date_month, first_coupon_date_year', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'tbondcoupon' => array(self::BELONGS_TO, 'TBondCoupon', array('bond_cd'=>'bond_cd')),
		);
	}

	public function attributeLabels()
	{
		return array(
			'bond_cd' => 'Bond Code',
			'bond_desc' => 'Bond Description',
			'int_type' => 'Rate Type',
			'interest' => 'Coupon Rate',
			'fee_ijarah' => 'Fee Ijarah',
			'nisbah' => 'Nisbah',
			'issue_date' => 'Issue Date',
			'listing_date' => 'Listing Date',
			'maturity_date' => 'Maturity Date',
			'isin_code' => 'ISIN',
			'issuer' => 'Issuer',
			'sec_sector' => 'Industry',
			'bond_group_cd' => 'Issuer Type',
			'product_type' => 'Product Type',
			'short_desc' => 'Short Name',
			'int_freq' => 'Frequency',
			'day_count_basis' => 'Day Count Basis',
			'gl_acct_cd' => 'Gl Acct Code',
			'sl_acct_cd' => 'Sl Acct Code',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_sts' => 'Approved stat',
			'first_coupon_date' => 'First Coupon Date'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('lower(bond_cd)',strtolower($this->bond_cd),true);
		$criteria->compare('lower(bond_desc)',strtolower($this->bond_desc),true);
		$criteria->compare('int_type',$this->int_type,true);
		$criteria->compare('interest',$this->interest);
		$criteria->compare('fee_ijarah',$this->fee_ijarah);
		$criteria->compare('nisbah',$this->nisbah);

		if(!empty($this->issue_date_date))
			$criteria->addCondition("TO_CHAR(t.issue_date,'DD') LIKE '%".$this->issue_date_date."%'");
		if(!empty($this->issue_date_month))
			$criteria->addCondition("TO_CHAR(t.issue_date,'MM') LIKE '%".$this->issue_date_month."%'");
		if(!empty($this->issue_date_year))
			$criteria->addCondition("TO_CHAR(t.issue_date,'YYYY') LIKE '%".$this->issue_date_year."%'");
		if(!empty($this->listing_date_date))
			$criteria->addCondition("TO_CHAR(t.listing_date,'DD') LIKE '%".$this->listing_date_date."%'");
		if(!empty($this->listing_date_month))
			$criteria->addCondition("TO_CHAR(t.listing_date,'MM') LIKE '%".$this->listing_date_month."%'");
		if(!empty($this->listing_date_year))
			$criteria->addCondition("TO_CHAR(t.listing_date,'YYYY') LIKE '%".$this->listing_date_year."%'");
		if(!empty($this->maturity_date_date))
			$criteria->addCondition("TO_CHAR(t.maturity_date,'DD') LIKE '%".$this->maturity_date_date."%'");
		if(!empty($this->maturity_date_month))
			$criteria->addCondition("TO_CHAR(t.maturity_date,'MM') LIKE '%".$this->maturity_date_month."%'");
		if(!empty($this->maturity_date_year))
			$criteria->addCondition("TO_CHAR(t.maturity_date,'YYYY') LIKE '%".$this->maturity_date_year."%'");		$criteria->compare('isin_code',$this->isin_code,true);
		$criteria->compare('lower(issuer)',strtolower($this->issuer),true);
		$criteria->compare('sec_sector',$this->sec_sector,true);
		$criteria->compare('lower(bond_group_cd)',strtolower($this->bond_group_cd),true);
		$criteria->compare('product_type',$this->product_type,true);
		$criteria->compare('lower(short_desc)',strtolower($this->short_desc),true);
		$criteria->compare('int_freq',$this->int_freq,true);
		$criteria->compare('day_count_basis',$this->day_count_basis,true);
		$criteria->compare('gl_acct_cd',$this->gl_acct_cd,true);
		$criteria->compare('sl_acct_cd',$this->sl_acct_cd,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".$this->cre_dt_date."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".$this->cre_dt_month."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".$this->cre_dt_year."%'");		$criteria->compare('user_id',$this->user_id,true);

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
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		
			$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_sts',$this->approved_sts,true);
		
		if(!empty($this->first_coupon_date_date))
			$criteria->addCondition("TO_CHAR(t.first_coupon_date,'DD') LIKE '%".$this->first_coupon_date_date."%'");
		if(!empty($this->first_coupon_date_month))
			$criteria->addCondition("TO_CHAR(t.first_coupon_date,'MM') LIKE '%".$this->first_coupon_date_month."%'");
		if(!empty($this->first_coupon_date_year))
			$criteria->addCondition("TO_CHAR(t.first_coupon_date,'YYYY') LIKE '%".$this->first_coupon_date_year."%'");

		$sort = new CSort();
		$sort->defaultOrder = 'bond_cd';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
		
	}

public function executeSp($exec_status,$old_bond_cd)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_MST_BOND_UPD(
			:P_SEARCH_BOND_CD,
			:P_BOND_CD,
			:P_BOND_DESC,
			:P_INT_TYPE,
			:P_INTEREST,
			:P_FEE_IJARAH,
			:P_NISBAH,
			TO_DATE(:P_ISSUE_DATE,'YYYY-MM-DD'),
			TO_DATE(:P_LISTING_DATE,'YYYY-MM-DD'),
			TO_DATE(:P_MATURITY_DATE,'YYYY-MM-DD'),
			:P_ISIN_CODE,
			:P_ISSUER,
			:P_SEC_SECTOR,
			:P_BOND_GROUP_CD,
			:P_PRODUCT_TYPE,
			:P_SHORT_DESC,
			:P_INT_FREQ,
			:P_DAY_COUNT_BASIS,
			:P_GL_ACCT_CD,
			:P_SL_ACCT_CD,
			TO_DATE(:P_FIRST_COUPON_DATE,'YYYY-MM-DD'),
			TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),
			:P_USER_ID,
			TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
			:P_UPD_BY,
			:P_UPD_STATUS,
			:P_IP_ADDRESS,
			:P_CANCEL_REASON,
			:P_ERROR_CODE,
			:P_ERROR_MSG


						)";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_BOND_CD",$old_bond_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BOND_CD",$this->bond_cd,PDO::PARAM_STR);
			$command->bindValue(":P_BOND_DESC",$this->bond_desc,PDO::PARAM_STR);
			$command->bindValue(":P_INT_TYPE",$this->int_type,PDO::PARAM_STR);
			$command->bindValue(":P_INTEREST",$this->interest,PDO::PARAM_STR);
			$command->bindValue(":P_FEE_IJARAH",$this->fee_ijarah,PDO::PARAM_STR);
			$command->bindValue(":P_NISBAH",$this->nisbah,PDO::PARAM_STR);
			$command->bindValue(":P_ISSUE_DATE",$this->issue_date,PDO::PARAM_STR);
			$command->bindValue(":P_LISTING_DATE",$this->listing_date,PDO::PARAM_STR);
			$command->bindValue(":P_MATURITY_DATE",$this->maturity_date,PDO::PARAM_STR);
			$command->bindValue(":P_ISIN_CODE",$this->isin_code,PDO::PARAM_STR);
			$command->bindValue(":P_ISSUER",$this->issuer,PDO::PARAM_STR);
			$command->bindValue(":P_SEC_SECTOR",$this->sec_sector,PDO::PARAM_STR);
			$command->bindValue(":P_BOND_GROUP_CD",$this->bond_group_cd,PDO::PARAM_STR);
			$command->bindValue(":P_PRODUCT_TYPE",$this->product_type,PDO::PARAM_STR);
			$command->bindValue(":P_SHORT_DESC",$this->short_desc,PDO::PARAM_STR);
			$command->bindValue(":P_INT_FREQ",$this->int_freq,PDO::PARAM_STR);
			$command->bindValue(":P_DAY_COUNT_BASIS",$this->day_count_basis,PDO::PARAM_STR);
			$command->bindValue(":P_GL_ACCT_CD",$this->gl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_SL_ACCT_CD",$this->sl_acct_cd,PDO::PARAM_STR);
			$command->bindValue(":P_FIRST_COUPON_DATE",$this->first_coupon_date,PDO::PARAM_STR);
			$command->bindValue(":P_CRE_DT",$this->cre_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_DT",$this->upd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_BY",$this->upd_by,PDO::PARAM_STR);
			
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
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


}