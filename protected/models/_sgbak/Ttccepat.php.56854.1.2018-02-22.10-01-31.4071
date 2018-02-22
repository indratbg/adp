<?php

/**
 * This is the model class for table "T_TC_CEPAT".
 *
 * The followings are the available columns in table 'T_TC_CEPAT':
 * @property string $contr_dt
 * @property string $contr_num
 * @property string $contr_stat
 * @property string $tc_id
 * @property integer $tc_rev
 * @property string $client_cd
 * @property string $client_type
 * @property string $brch_cd
 * @property string $rem_cd
 * @property string $mrkt_type
 * @property string $trx_type
 * @property string $due_dt
 * @property integer $num_days
 * @property string $stk_cd
 * @property integer $lot_size
 * @property string $odd_lot_ind
 * @property integer $qty
 * @property double $price
 * @property string $price_type
 * @property string $curr_cd
 * @property double $val
 * @property double $val_avg
 * @property double $brok_perc
 * @property double $brok
 * @property double $commission
 * @property double $levy_perc
 * @property double $trans_levy
 * @property double $vat
 * @property double $pph_perc
 * @property double $pph
 * @property double $um_pph23
 * @property double $amt_for_curr
 * @property string $buy_broker_cd
 * @property string $sell_broker_cd
 * @property string $record_source
 * @property string $cre_dt
 * @property string $user_id
 * @property string $upd_dt
 * @property string $upd_by
 * @property string $approved_dt
 * @property string $approved_by
 * @property string $approved_stat
 * @property string $from_client_cd
 */
class Ttccepat extends AActiveRecordSP
{
	//AH: #BEGIN search (datetime || date) additional comparison
	public $contr_dt_date;
	public $contr_dt_month;
	public $contr_dt_year;

	public $due_dt_date;
	public $due_dt_month;
	public $due_dt_year;

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
	
	public $client_select;
	public $market_type;
	
	public $update_date;
	public $update_seq;
	
	public $doc_type;
	
	public function __construct($scenario = 'insert')
	{
		parent::__construct($scenario);
		$this->logRecord=true;
	}
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
	protected function afterFind()
	{
		$this->contr_dt = Yii::app()->format->cleanDate($this->contr_dt);
		$this->due_dt = Yii::app()->format->cleanDate($this->due_dt);
	}

	public function tableName()
	{
		return 'T_TC_CEPAT';
	}

	public function rules()
	{
		return array(
		
			array('contr_dt, due_dt, approved_dt', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
		
			array('tc_rev, num_days, lot_size, qty, price, val, val_avg, brok_perc, brok, commission, levy_perc, trans_levy, vat, pph_perc, pph, um_pph23, amt_for_curr', 'application.components.validator.ANumberSwitcherValidator'),
			array('contr_dt','required','on'=>'fixed'),
			array('tc_rev, num_days, lot_size, qty', 'numerical', 'integerOnly'=>true),
			array('price, val, val_avg, brok_perc, brok, commission, levy_perc, trans_levy, vat, pph_perc, pph, um_pph23, amt_for_curr', 'numerical'),
			array('contr_num', 'length', 'max'=>13),
			array('contr_stat, trx_type, odd_lot_ind, price_type, approved_stat', 'length', 'max'=>1),
			array('client_cd, from_client_cd', 'length', 'max'=>12),
			array('tc_id', 'length', 'max'=>20),
			array('client_type, rem_cd, curr_cd', 'length', 'max'=>3),
			array('brch_cd, mrkt_type, buy_broker_cd, sell_broker_cd, record_source', 'length', 'max'=>2),
			array('stk_cd', 'length', 'max'=>50),
			array('user_id, upd_by, approved_by', 'length', 'max'=>10),
			array('contr_dt, due_dt, cre_dt, upd_dt, approved_dt', 'safe'),
			array('stk_cd, client_cd, brok_perc, trx_type, due_dt','required','on'=>'create,update'),
			

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
	
			array('contr_dt, contr_num, contr_stat, tc_id, tc_rev, client_cd, client_type, brch_cd, rem_cd, mrkt_type, trx_type, due_dt, num_days, stk_cd, lot_size, odd_lot_ind, qty, price, price_type, curr_cd, val, val_avg, brok_perc, brok, commission, levy_perc, trans_levy, vat, pph_perc, pph, um_pph23, amt_for_curr, buy_broker_cd, sell_broker_cd, record_source, cre_dt, user_id, upd_dt, upd_by, approved_dt, approved_by, approved_stat,contr_dt_date,contr_dt_month,contr_dt_year,due_dt_date,due_dt_month,due_dt_year,cre_dt_date,cre_dt_month,cre_dt_year,upd_dt_date,upd_dt_month,upd_dt_year,approved_dt_date,approved_dt_month,approved_dt_year, from_client_cd', 'safe', 'on'=>'search'),
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
			'contr_dt' => 'Contr Date',
			'contr_num' => 'Contr Num',
			'contr_stat' => 'Contr Stat',
			'tc_id' => 'Tc',
			'tc_rev' => 'Tc Rev',
			'client_cd' => 'Client',
			'client_type' => 'Client Type',
			'brch_cd' => 'Branch',
			'rem_cd' => 'Sales',
			'mrkt_type' => 'Market',
			'trx_type' => 'Beli / Jual',
			'due_dt' => 'Due Date',
			'num_days' => 'Num Days',
			'stk_cd' => 'Stock',
			'lot_size' => 'Lot Size',
			'odd_lot_ind' => 'Odd Lot Ind',
			'qty' => 'Qty',
			'price' => 'Price',
			'price_type' => 'Price Type',
			'curr_cd' => 'Curr Code',
			'val' => 'Val',
			'val_avg' => 'Val Avg',
			'brok_perc' => 'Brok Perc',
			'brok' => 'Brok',
			'commission' => 'Commission',
			'levy_perc' => 'Levy Perc',
			'trans_levy' => 'Trans Levy',
			'vat' => 'Vat',
			'pph_perc' => 'Pph Perc',
			'pph' => 'Pph',
			'um_pph23' => 'Um Pph23',
			'amt_for_curr' => 'Amt For Curr',
			'buy_broker_cd' => 'Buy Broker Code',
			'sell_broker_cd' => 'Sell Broker Code',
			'record_source' => 'Record Source',
			'cre_dt' => 'Cre Date',
			'user_id' => 'User',
			'upd_dt' => 'Upd Date',
			'upd_by' => 'Upd By',
			'approved_dt' => 'Approved Date',
			'approved_by' => 'Approved By',
			'approved_stat' => 'Approved Sts',
			'from_client_cd' => 'From Client'
		);
	}
	
	public function executeSp()
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_TC_CEPAT_SAVE(
						TO_DATE(:P_TRX_DATE,'YYYY-MM-DD'),
						:P_CLIENT_CD,
						:P_STK_CD,
						:P_TRX_TYPE,
						:P_QTY,
						:P_PRICE,
						:P_MRKT_TYPE,
						TO_DATE(:P_DUE_DT,'YYYY-MM-DD'),
						:P_USER_ID,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_TRX_DATE",$this->contr_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_TRX_TYPE",$this->trx_type,PDO::PARAM_STR);
			$command->bindValue(":P_QTY",$this->qty,PDO::PARAM_STR);
			$command->bindValue(":P_PRICE",$this->price,PDO::PARAM_STR);
			$command->bindValue(":P_MRKT_TYPE",$this->mrkt_type,PDO::PARAM_STR);
			$command->bindValue(":P_DUE_DT",$this->due_dt,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",Yii::app()->user->id,PDO::PARAM_STR);

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

	public function executeSpHeader($exec_status,$menuName,&$transaction)
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
			
			//Commit baru akan dijalankan saat semua transaksi INSERT sukses
			
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->error_code = -999)
				$this->error_msg = $ex->getMessage();
		}
		
		if($this->error_code < 0)
			$this->addError('error_msg', 'Error '.$this->error_code.' '.$this->error_msg);
		
		return $this->error_code;
	}

	public function executeSpUpdAvgPrice($exec_status,$record_seq,&$transaction,$total_qty)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_T_TC_CEPAT_UPD(
						:P_SEARCH_CONTR_NUM,
						TO_DATE(:P_CONTR_DT,'YYYY-MM-DD'),
						:P_TRX_TYPE,
						:P_STK_CD,
						:P_CLIENT_CD,
						:P_QTY,
						:P_TOTAL_QTY,
						:P_BROK_PERC,
						TO_DATE(:P_DUE_DT,'YYYY-MM-DD'),
						:P_PRICE,
						:P_FROM_CLIENT_CD,
						:P_USER_ID,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPDATE_SEQ,
						:P_RECORD_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_CONTR_NUM",NULL,PDO::PARAM_STR);
			$command->bindValue(":P_CONTR_DT",$this->contr_dt,PDO::PARAM_STR);
			$command->bindValue(":P_TRX_TYPE",$this->trx_type,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_QTY",$this->qty,PDO::PARAM_STR);
			$command->bindValue(":P_TOTAL_QTY",$total_qty,PDO::PARAM_STR);
			$command->bindValue(":P_BROK_PERC",$this->brok_perc*100,PDO::PARAM_STR);
			$command->bindValue(":P_DUE_DT",$this->due_dt,PDO::PARAM_STR);
			$command->bindValue(":P_PRICE",$this->price,PDO::PARAM_STR);
			$command->bindValue(":P_FROM_CLIENT_CD",$this->from_client_cd,PDO::PARAM_STR);
			
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
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
	
	public function executeSpCancelAvgPrice($exec_status,$record_seq,&$transaction,$contr_num)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_T_TC_CEPAT_CANCEL(
						:P_SEARCH_CONTR_NUM,
						:P_USER_ID,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPDATE_SEQ,
						:P_RECORD_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_SEARCH_CONTR_NUM",$contr_num,PDO::PARAM_STR);
			
			$command->bindValue(":P_USER_ID",$this->user_id,PDO::PARAM_STR);
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
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
	
	/*
	public function executeSpSourceAvgPrice($exec_status,$record_seq,&$transaction)
	{
		$connection  = Yii::app()->db;
		
		try{
			$query  = "CALL SP_T_TC_CEPAT_SOURCE(
						:P_CLIENT_CD,
						:P_STK_CD,
						:P_QTY,
						:P_BELIJUAL,
						:P_UPD_STATUS,
						:P_IP_ADDRESS,
						:P_CANCEL_REASON,
						TO_DATE(:P_UPDATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
						:P_UPDATE_SEQ,
						:P_RECORD_SEQ,
						:P_ERROR_CODE,
						:P_ERROR_MSG)";
						
			$command = $connection->createCommand($query);
			$command->bindValue(":P_CLIENT_CD",$this->client_cd,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_QTY",$this->qty,PDO::PARAM_STR);
			$command->bindValue(":P_BELIJUAL",$this->trx_type,PDO::PARAM_STR);
						
			$command->bindValue(":P_UPD_STATUS",$exec_status,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_CANCEL_REASON",$this->cancel_reason,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_DATE",$this->update_date,PDO::PARAM_STR);
			$command->bindValue(":P_UPDATE_SEQ",$this->update_seq,PDO::PARAM_STR);
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
	*/
	public function search()
	{
		$criteria = new CDbCriteria;

		if(!empty($this->contr_dt_date))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'DD') LIKE '%".$this->contr_dt_date."%'");
		if(!empty($this->contr_dt_month))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'MM') LIKE '%".$this->contr_dt_month."%'");
		if(!empty($this->contr_dt_year))
			$criteria->addCondition("TO_CHAR(t.contr_dt,'YYYY') LIKE '%".$this->contr_dt_year."%'");		$criteria->compare('contr_num',$this->contr_num,true);
		$criteria->compare('contr_stat',$this->contr_stat,true);
		$criteria->compare('tc_id',$this->tc_id,true);
		$criteria->compare('tc_rev',$this->tc_rev);
		$criteria->compare('client_cd',$this->client_cd,true);
		$criteria->compare('client_type',$this->client_type,true);
		$criteria->compare('brch_cd',$this->brch_cd,true);
		$criteria->compare('rem_cd',$this->rem_cd,true);
		$criteria->compare('mrkt_type',$this->mrkt_type,true);
		$criteria->compare('trx_type',$this->trx_type,true);

		if(!empty($this->due_dt_date))
			$criteria->addCondition("TO_CHAR(t.due_dt,'DD') LIKE '%".$this->due_dt_date."%'");
		if(!empty($this->due_dt_month))
			$criteria->addCondition("TO_CHAR(t.due_dt,'MM') LIKE '%".$this->due_dt_month."%'");
		if(!empty($this->due_dt_year))
			$criteria->addCondition("TO_CHAR(t.due_dt,'YYYY') LIKE '%".$this->due_dt_year."%'");		$criteria->compare('num_days',$this->num_days);
		$criteria->compare('stk_cd',$this->stk_cd,true);
		$criteria->compare('lot_size',$this->lot_size);
		$criteria->compare('odd_lot_ind',$this->odd_lot_ind,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('price',$this->price);
		$criteria->compare('price_type',$this->price_type,true);
		$criteria->compare('curr_cd',$this->curr_cd,true);
		$criteria->compare('val',$this->val);
		$criteria->compare('val_avg',$this->val_avg);
		$criteria->compare('brok_perc',$this->brok_perc);
		$criteria->compare('brok',$this->brok);
		$criteria->compare('commission',$this->commission);
		$criteria->compare('levy_perc',$this->levy_perc);
		$criteria->compare('trans_levy',$this->trans_levy);
		$criteria->compare('vat',$this->vat);
		$criteria->compare('pph_perc',$this->pph_perc);
		$criteria->compare('pph',$this->pph);
		$criteria->compare('um_pph23',$this->um_pph23);
		$criteria->compare('amt_for_curr',$this->amt_for_curr);
		$criteria->compare('buy_broker_cd',$this->buy_broker_cd,true);
		$criteria->compare('sell_broker_cd',$this->sell_broker_cd,true);
		$criteria->compare('record_source',$this->record_source,true);

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
			$criteria->addCondition("TO_CHAR(t.approved_dt,'YYYY') LIKE '%".$this->approved_dt_year."%'");		$criteria->compare('approved_by',$this->approved_by,true);
		$criteria->compare('approved_stat',$this->approved_stat,true);
		$criteria->addCondition("approved_stat <> 'C'");

		$sort = new CSort;
		
		$sort->defaultOrder='client_cd, stk_cd';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
		));
	}
}