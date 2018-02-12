<?php

/**
 * This is the model class for table "MST_COUNTER".
 *
 * The followings are the available columns in table 'MST_COUNTER':
 * @property string $stk_cd
 * @property string $stk_desc
 * @property string $stk_desc_abbr
 * @property string $indry_type
 * @property string $ctr_type
 * @property string $exch_lisd
 * @property string $regr_cd
 * @property string $stk_lisd_dt
 * @property double $par_val
 * @property integer $lot_size
 * @property string $stk_stat
 * @property integer $trdg_lim
 * @property string $short_stk_cd
 * @property string $stk_basis
 * @property string $stk_scripless
 * @property double $sec_comp_perc
 * @property string $pp_from_dt
 * @property string $pp_to_dt
 * @property double $mrg_stk_cap
 * @property double $rem_stk_cap
 * @property string $contr_stamp
 * @property double $close_rate
 * @property string $pph_appl_flg
 * @property double $last_bid_rate
 * @property string $levy_appl_flg
 * @property double $mrg_stk_ceil
 * @property string $mrg_cap_type
 * @property string $affil_flg
 * @property string $sbi_flg
 * @property string $sbpu_flg
 * @property string $user_id
 * @property string $cre_dt
 * @property string $upd_dt
 * @property string $short_lisd_flg
 * @property string $short_dt_lisd
 * @property string $vat_appl_flg
 * @property string $stk_type
 * @property string $mrkt_type
 * @property string $layer
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 * @property string $isin_code
 */
class Counter extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $stk_lisd_dt_date;
	public $stk_lisd_dt_month;
	public $stk_lisd_dt_year;

	public $pp_from_dt_date;
	public $pp_from_dt_month;
	public $pp_from_dt_year;

	public $pp_to_dt_date;
	public $pp_to_dt_month;
	public $pp_to_dt_year;

	public $cre_dt_date;
	public $cre_dt_month;
	public $cre_dt_year;

	public $upd_dt_date;
	public $upd_dt_month;
	public $upd_dt_year;

	public $short_dt_lisd_date;
	public $short_dt_lisd_month;
	public $short_dt_lisd_year;

	public $approved_dt_date;
	public $approved_dt_month;
	public $approved_dt_year;
	public $stk_desc;
	//AH: #END search (datetime || date)  additional comparison
	
	public $eff_dt;
	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
	public function getStockCdAndDesc(){
		return $this->stk_cd.' - '.$this->stk_desc;
	}
	public function getDropDownList(){
		return $this->stk_cd." - ".$this->stk_desc;
	}

	public function tableName()
	{
		return 'MST_COUNTER';
	}
	
	/*
	 * AH: provide char data to trim value according
	 *     especially those which shape combo box
	 * 	   and also those who type date and shows in user input
	 */
	protected function afterFind()
	{
		$this->ctr_type    = trim($this->ctr_type);
		$this->indry_type  = trim($this->indry_type);
		$this->regr_cd 	   = trim($this->regr_cd);
		$this->pp_from_dt  = Yii::app()->format->cleanDate($this->pp_from_dt);
		$this->pp_to_dt    = Yii::app()->format->cleanDate($this->pp_to_dt);
		$this->stk_lisd_dt = Yii::app()->format->cleanDate($this->stk_lisd_dt);
	}
	
	/*
	 *  AH: this function is for executing procedure
	 *  exec_status  : I/U/C
	 */
	public function executeSp($exec_status,$stk_cd)
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		
		try{
			$query  = "CALL SP_MST_COUNTER_UPD(
						:P_SEARCH_STK_CD,:P_STK_CD,:P_STK_DESC,:P_STK_DESC_ABBR,:P_INDRY_TYPE,
						:P_CTR_TYPE,:P_EXCH_LISD,:P_REGR_CD,TO_DATE(:P_STK_LISD_DT,'YYYY-MM-DD'),
						:P_PAR_VAL,:P_LOT_SIZE,:P_STK_STAT,:P_TRDG_LIM,:P_SHORT_STK_CD,:P_STK_BASIS,
						:P_STK_SCRIPLESS,:P_SEC_COMP_PERC,
						TO_DATE(:P_PP_FROM_DT,'YYYY-MM-DD'),TO_DATE(:P_PP_TO_DT,'YYYY-MM-DD'),
						:P_MRG_STK_CAP,:P_REM_STK_CAP,
						:P_CONTR_STAMP,:P_CLOSE_RATE,:P_PPH_APPL_FLG,:P_LAST_BID_RATE,
						:P_LEVY_APPL_FLG,:P_MRG_STK_CEIL,:P_MRG_CAP_TYPE,:P_AFFIL_FLG,
						:P_SBI_FLG,:P_SBPU_FLG,
						:P_USER_ID,
						TO_DATE(:P_CRE_DT,'YYYY-MM-DD HH24:MI:SS'),TO_DATE(:P_UPD_DT,'YYYY-MM-DD HH24:MI:SS'),
						:P_SHORT_LISD_FLG,TO_DATE(:P_SHORT_DT_LISD,'YYYY-MM-DD'),
						:P_VAT_APPL_FLG,:P_STK_TYPE,:P_MRKT_TYPE,:P_LAYER,:P_ISIN_CODE, :P_EFF_DT,
						:P_UPD_BY,:P_UPD_STATUS,:P_IP_ADDRESS,:P_CANCEL_REASON,
						:P_ERROR_CODE,:P_ERROR_MSG)";
						
			$command = $connection->createCommand($query);
			
			$command->bindValue(":P_SEARCH_STK_CD",$stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_STK_DESC",$this->stk_desc,PDO::PARAM_STR);
			$command->bindValue(":P_STK_DESC_ABBR",$this->stk_desc_abbr,PDO::PARAM_STR);
			$command->bindValue(":P_INDRY_TYPE",$this->indry_type,PDO::PARAM_STR);
			$command->bindValue(":P_CTR_TYPE",$this->ctr_type,PDO::PARAM_STR);
			$command->bindValue(":P_EXCH_LISD",$this->exch_lisd,PDO::PARAM_STR);
			$command->bindValue(":P_REGR_CD",$this->regr_cd,PDO::PARAM_STR);
			$command->bindValue(":P_STK_LISD_DT",$this->stk_lisd_dt,PDO::PARAM_STR);
			$command->bindValue(":P_PAR_VAL",$this->par_val,PDO::PARAM_STR);
			$command->bindValue(":P_LOT_SIZE",$this->lot_size,PDO::PARAM_STR);
			$command->bindValue(":P_STK_STAT",$this->stk_stat,PDO::PARAM_STR);
			$command->bindValue(":P_TRDG_LIM",$this->trdg_lim,PDO::PARAM_STR);
			$command->bindValue(":P_SHORT_STK_CD",$this->short_stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_STK_BASIS",$this->stk_basis,PDO::PARAM_STR);
			$command->bindValue(":P_STK_SCRIPLESS",$this->stk_scripless,PDO::PARAM_STR);
			$command->bindValue(":P_SEC_COMP_PERC",$this->sec_comp_perc,PDO::PARAM_STR);
			$command->bindValue(":P_PP_FROM_DT",$this->pp_from_dt,PDO::PARAM_STR);
			$command->bindValue(":P_PP_TO_DT",$this->pp_to_dt,PDO::PARAM_STR);
			$command->bindValue(":P_MRG_STK_CAP",$this->mrg_stk_cap,PDO::PARAM_STR);
			$command->bindValue(":P_REM_STK_CAP",$this->rem_stk_cap,PDO::PARAM_STR);
			$command->bindValue(":P_CONTR_STAMP",$this->contr_stamp,PDO::PARAM_STR);
			$command->bindValue(":P_CLOSE_RATE",$this->close_rate,PDO::PARAM_STR);
			$command->bindValue(":P_PPH_APPL_FLG",$this->pph_appl_flg,PDO::PARAM_STR);
			$command->bindValue(":P_LAST_BID_RATE",$this->last_bid_rate,PDO::PARAM_STR);
			$command->bindValue(":P_LEVY_APPL_FLG",$this->levy_appl_flg,PDO::PARAM_STR);
			$command->bindValue(":P_MRG_STK_CEIL",$this->mrg_stk_ceil,PDO::PARAM_STR);
			$command->bindValue(":P_MRG_CAP_TYPE",$this->mrg_cap_type,PDO::PARAM_STR);
			$command->bindValue(":P_AFFIL_FLG",$this->affil_flg,PDO::PARAM_STR);
			$command->bindValue(":P_SBI_FLG",$this->sbi_flg,PDO::PARAM_STR);
			$command->bindValue(":P_SBPU_FLG",$this->sbpu_flg,PDO::PARAM_STR);
			$command->bindValue(":P_SHORT_LISD_FLG",$this->short_lisd_flg,PDO::PARAM_STR);
			$command->bindValue(":P_SHORT_DT_LISD",$this->short_dt_lisd,PDO::PARAM_STR);
			$command->bindValue(":P_VAT_APPL_FLG",$this->vat_appl_flg,PDO::PARAM_STR);
			$command->bindValue(":P_STK_TYPE",$this->stk_type,PDO::PARAM_STR);
			$command->bindValue(":P_MRKT_TYPE",$this->mrkt_type,PDO::PARAM_STR);
			$command->bindValue(":P_LAYER",$this->layer,PDO::PARAM_STR);
			$command->bindValue(":P_ISIN_CODE",$this->isin_code,PDO::PARAM_STR);
			$command->bindValue(":P_EFF_DT",$this->eff_dt,PDO::PARAM_STR);
			
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

	public function rules()
	{
		return array(
			array('stk_cd,ctr_type,indry_type,stk_desc,exch_lisd,stk_lisd_dt,lot_size,pph_appl_flg,levy_appl_flg,stk_scripless,pp_from_dt','required'),
			
			array('eff_dt, stk_lisd_dt, pp_from_dt, pp_to_dt, short_dt_lisd, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('par_val, lot_size, trdg_lim, sec_comp_perc, mrg_stk_cap, rem_stk_cap, close_rate, last_bid_rate, mrg_stk_ceil', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('lot_size, trdg_lim', 'numerical', 'integerOnly'=>true),
			array('par_val, sec_comp_perc, mrg_stk_cap, rem_stk_cap, close_rate, last_bid_rate, mrg_stk_ceil', 'numerical'),
			array('stk_desc', 'length', 'max'=>50),
			array('stk_desc_abbr, upd_by, approved_by', 'length', 'max'=>10),
			array('indry_type, short_stk_cd, layer', 'length', 'max'=>3),
			array('ctr_type, mrkt_type', 'length', 'max'=>2),
			array('exch_lisd, regr_cd', 'length', 'max'=>4),
			array('stk_stat, stk_basis, stk_scripless, contr_stamp, pph_appl_flg, levy_appl_flg, mrg_cap_type, affil_flg, sbi_flg, sbpu_flg, short_lisd_flg, vat_appl_flg, approved_stat', 'length', 'max'=>1),
			array('user_id', 'length', 'max'=>8),
			array('stk_type, isin_code', 'length', 'max'=>20),
			array('stk_desc,stk_lisd_dt, cre_dt, upd_dt, short_dt_lisd, approved_dt', 'safe'),
			array('pph_appl_flg, levy_appl_flg, stk_scripless','default','value'=>'Y'),
			array('pp_to_dt','required','on'=>'special'),
			array('eff_dt','checkCorpAct'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('stk_cd, stk_desc, stk_desc_abbr, indry_type, ctr_type, exch_lisd, regr_cd, stk_lisd_dt, par_val, lot_size, stk_stat, trdg_lim, short_stk_cd, stk_basis, stk_scripless, sec_comp_perc, pp_from_dt, pp_to_dt, mrg_stk_cap, rem_stk_cap, contr_stamp, close_rate, pph_appl_flg, last_bid_rate, levy_appl_flg, mrg_stk_ceil, mrg_cap_type, affil_flg, sbi_flg, sbpu_flg, user_id, cre_dt, upd_dt, short_lisd_flg, short_dt_lisd, vat_appl_flg, stk_type, mrkt_type, layer, upd_by, approved_dt, approved_by, approved_stat,stk_lisd_dt_date,stk_lisd_dt_month,stk_lisd_dt_year,pp_from_dt_date,pp_from_dt_month,pp_from_dt_year,pp_to_dt_date,pp_to_dt_month,pp_to_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,short_dt_lisd_date,short_dt_lisd_month,short_dt_lisd_year,approved_dt_date,approved_dt_month,approved_dt_year', 'safe', 'on'=>'search'),
		);
	}

	public function checkCorpAct()
	{
		if(!$this->isNewRecord && $this->eff_dt)
		{
			$sql = "SELECT COUNT(*) cnt
					FROM
					(  
						SELECT stk_cd, Get_Doc_Date(1,TO_DATE('$this->pp_from_dt','YYYY-MM-DD')) AS distrib_dt
						FROM mst_counter m
					   	WHERE ctr_type in ('RT','WR')
					   	AND pp_from_dt IS NOT NULL
					   	AND stk_cd = '$this->stk_cd'
					   	AND approved_stat = 'A'
					)  m,
					t_corp_act t
					WHERE m.stk_cd = t.stk_Cd
					AND m.distrib_dt = t.distrib_dt
					AND t.approved_stat = 'A'";
					
			$result = DAO::queryRowSql($sql);
			
			if($result['cnt'] == 0)
			{
				$this->addError('eff_dt', "Corporate Action for $this->stk_cd with correct distribution date is not found");
			}
		}
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'stk_cd' => 'Stock Code',
			'ctr_type' => 'Stock Type',
			'indry_type' => 'Industry',
			'stk_desc' => 'Stock Name',
			
			'exch_lisd' => 'Exchange Listed',
			'regr_cd' => 'BAE Code',
			'stk_lisd_dt' => 'Stock Listed Date',
			
			'pp_from_dt' => 'Period From',
			'pp_to_dt' => 'Period To / Maturity Date',
			'pph_appl_flg' => 'Pph',
			'levy_appl_flg' => 'Levy',
			
			'stk_scripless' => 'Scripless',
			'stk_desc_abbr' => 'Stock Desc Abbr',
			
			'mrg_stk_cap' => 'Capping %',
			
			'par_val' => 'Par Val',
			'lot_size' => 'Lot Size',
			'stk_stat' => 'Stock Stat',
			'trdg_lim' => 'Trdg Lim',
			'short_stk_cd' => 'Short Stock Code',
			'stk_basis' => 'Stock Basis',
			'sec_comp_perc' => 'Sec Comp Perc',
			
			'rem_stk_cap' => 'Rem Stock Cap',
			'contr_stamp' => 'Contr Stamp',
			'close_rate' => 'Close Rate',
			
			'last_bid_rate' => 'Last Bid Rate',
			
			'mrg_stk_ceil' => 'Mrg Stock Ceil',
			'mrg_cap_type' => 'Mrg Cap Type',
			'affil_flg' => 'Affil Flg',
			'sbi_flg' => 'Bond Type',
			'sbpu_flg' => 'Sbpu Flg',
			'user_id' => 'User',
			'cre_dt' => 'Cre Date',
			'upd_dt' => 'Upd Date',
			'short_lisd_flg' => 'Short Lisd Flg',
			'short_dt_lisd' => 'Short Date Lisd',
			'vat_appl_flg' => 'Vat Appl Flg',
			'stk_type' => 'Stock Type',
			'mrkt_type' => 'Mrkt Type',
			'layer' => 'Layer',
			'isin_code' => 'ISIN',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
			
			'eff_dt' => 'Effective Date'
		);
	}


	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition("UPPER(stk_cd) LIKE UPPER('".$this->stk_cd."%')");
		if(!empty($this->stk_desc))
			$criteria->addCondition("UPPER(stk_desc) LIKE UPPER('%".$this->stk_desc."%')");
		
		$criteria->compare('stk_desc_abbr',$this->stk_desc_abbr,true);
		$criteria->compare('indry_type',$this->indry_type,true);
		$criteria->compare('ctr_type',$this->ctr_type,true);
		$criteria->compare('exch_lisd',$this->exch_lisd,true);
		$criteria->compare('regr_cd',$this->regr_cd,true);

		if(!empty($this->stk_lisd_dt_date))
			$criteria->addCondition("TO_CHAR(t.stk_lisd_dt,'DD') LIKE '%".($this->stk_lisd_dt_date)."%'");
		if(!empty($this->stk_lisd_dt_month))
			$criteria->addCondition("TO_CHAR(t.stk_lisd_dt,'MM') LIKE '%".($this->stk_lisd_dt_month)."%'");
		if(!empty($this->stk_lisd_dt_year))
			$criteria->addCondition("TO_CHAR(t.stk_lisd_dt,'YYYY') LIKE '%".($this->stk_lisd_dt_year)."%'");		$criteria->compare('par_val',$this->par_val);
		$criteria->compare('lot_size',$this->lot_size);
		$criteria->compare('stk_stat',$this->stk_stat,true);
		$criteria->compare('trdg_lim',$this->trdg_lim);
		$criteria->compare('short_stk_cd',$this->short_stk_cd,true);
		$criteria->compare('stk_basis',$this->stk_basis,true);
		$criteria->compare('stk_scripless',$this->stk_scripless,true);
		$criteria->compare('sec_comp_perc',$this->sec_comp_perc);

		if(!empty($this->pp_from_dt_date))
			$criteria->addCondition("TO_CHAR(t.pp_from_dt,'DD') LIKE '%".($this->pp_from_dt_date)."%'");
		if(!empty($this->pp_from_dt_month))
			$criteria->addCondition("TO_CHAR(t.pp_from_dt,'MM') LIKE '%".($this->pp_from_dt_month)."%'");
		if(!empty($this->pp_from_dt_year))
			$criteria->addCondition("TO_CHAR(t.pp_from_dt,'YYYY') LIKE '%".($this->pp_from_dt_year)."%'");
		if(!empty($this->pp_to_dt_date))
			$criteria->addCondition("TO_CHAR(t.pp_to_dt,'DD') LIKE '%".($this->pp_to_dt_date)."%'");
		if(!empty($this->pp_to_dt_month))
			$criteria->addCondition("TO_CHAR(t.pp_to_dt,'MM') LIKE '%".($this->pp_to_dt_month)."%'");
		if(!empty($this->pp_to_dt_year))
			$criteria->addCondition("TO_CHAR(t.pp_to_dt,'YYYY') LIKE '%".($this->pp_to_dt_year)."%'");		$criteria->compare('mrg_stk_cap',$this->mrg_stk_cap);
		$criteria->compare('rem_stk_cap',$this->rem_stk_cap);
		$criteria->compare('contr_stamp',$this->contr_stamp,true);
		$criteria->compare('close_rate',$this->close_rate);
		$criteria->compare('pph_appl_flg',$this->pph_appl_flg,true);
		$criteria->compare('last_bid_rate',$this->last_bid_rate);
		$criteria->compare('levy_appl_flg',$this->levy_appl_flg,true);
		$criteria->compare('mrg_stk_ceil',$this->mrg_stk_ceil);
		$criteria->compare('mrg_cap_type',$this->mrg_cap_type,true);
		$criteria->compare('affil_flg',$this->affil_flg,true);
		$criteria->compare('sbi_flg',$this->sbi_flg,true);
		$criteria->compare('sbpu_flg',$this->sbpu_flg,true);
		$criteria->compare('user_id',$this->user_id,true);

		if(!empty($this->cre_dt_date))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'DD') LIKE '%".($this->cre_dt_date)."%'");
		if(!empty($this->cre_dt_month))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'MM') LIKE '%".($this->cre_dt_month)."%'");
		if(!empty($this->cre_dt_year))
			$criteria->addCondition("TO_CHAR(t.cre_dt,'YYYY') LIKE '%".($this->cre_dt_year)."%'");
		if(!empty($this->upd_dt_date))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'DD') LIKE '%".($this->upd_dt_date)."%'");
		if(!empty($this->upd_dt_month))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'MM') LIKE '%".($this->upd_dt_month)."%'");
		if(!empty($this->upd_dt_year))
			$criteria->addCondition("TO_CHAR(t.upd_dt,'YYYY') LIKE '%".($this->upd_dt_year)."%'");		$criteria->compare('short_lisd_flg',$this->short_lisd_flg,true);

		if(!empty($this->short_dt_lisd_date))
			$criteria->addCondition("TO_CHAR(t.short_dt_lisd,'DD') LIKE '%".($this->short_dt_lisd_date)."%'");
		if(!empty($this->short_dt_lisd_month))
			$criteria->addCondition("TO_CHAR(t.short_dt_lisd,'MM') LIKE '%".($this->short_dt_lisd_month)."%'");
		if(!empty($this->short_dt_lisd_year))
			$criteria->addCondition("TO_CHAR(t.short_dt_lisd,'YYYY') LIKE '%".($this->short_dt_lisd_year)."%'");		$criteria->compare('vat_appl_flg',$this->vat_appl_flg,true);
		$criteria->compare('stk_type',$this->stk_type,true);
		$criteria->compare('mrkt_type',$this->mrkt_type,true);
		$criteria->compare('layer',$this->layer,true);
		$criteria->compare('upd_by',$this->upd_by,true);
		
		$criteria->compare('isin_code',$this->isin_code,true);

		if(!empty($this->approved_dt_date))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'DD') LIKE '%".($this->approved_dt_date)."%'");
		if(!empty($this->approved_dt_month))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'MM') LIKE '%".($this->approved_dt_month)."%'");
		if(!empty($this->approved_dt_year))
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".($this->approved_dt_year)."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat','A',true);
		$sort = new CSort();
		$sort->defaultOrder = 'stk_cd';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort
		));
	}
}