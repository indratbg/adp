<?php 

class Vinboxtstkmovementall extends Tmanyheader
{
	public $doc_num;
	public $stk_cd;
	public $doc_dt;
	public $client_cd;
	// public $client_type;
	// public $curr_amt;
	// public $DOC_REM;
	
	public $processed_flg = false;
	
	public function attributeLabels()
	{
		return array_merge
				 (
					 parent::attributeLabels(),
					 array(
						 'doc_num' => 'Journal Number',
						 'stk_cd' => 'Stock',
						 'doc_dt' =>' Doc Date',
						 'client_cd' => 'Client Code',
						// 'client_type' => 'Type',
						// 'curr_amt' => 'Amount',
						// 'DOC_REM' => 'DOC_REM',
					)
				);
	}
	
	public function search()
	{
		$criteria = new CDbCriteria;
		
		if(!$this->processed_flg)
		{
			$criteria->select = "t.*, 
								(
									SELECT field_value FROM T_MANY_DETAIL 
									WHERE update_date = a.update_date 
									AND update_Seq = a.update_seq
									AND table_name = 'T_STK_MOVEMENT'
									AND field_name = 'DOC_NUM'
									AND record_seq = 1
								) doc_num,
								(
									SELECT field_value FROM T_MANY_DETAIL 
									WHERE update_date = a.update_date 
									AND update_Seq = a.update_seq
									AND table_name = 'T_STK_MOVEMENT'
									AND field_name = 'STK_CD'
									AND record_seq = 1
								) stk_cd,
								(
									SELECT field_value FROM T_MANY_DETAIL 
									WHERE update_date = a.update_date 
									AND update_Seq = a.update_seq
									AND table_name = 'T_STK_MOVEMENT'
									AND field_name = 'DOC_DT'
									AND record_seq = 1
								) DOC_DT,
								(
									SELECT field_value FROM T_MANY_DETAIL 
									WHERE update_date = a.update_date 
									AND update_Seq = a.update_seq
									AND table_name = 'T_STK_MOVEMENT'
									AND field_name = 'CLIENT_CD'
									AND record_seq = 1
								) client_cd,
								(
									SELECT field_value FROM T_MANY_DETAIL 
									WHERE update_date = a.update_date 
									AND update_Seq = a.update_seq
									AND table_name = 'T_STK_MOVEMENT'
									AND field_name = 'DOC_REM'
									AND record_seq = 1
								) DOC_REM";
			
			$criteria->join = "JOIN T_MANY_DETAIL a ON t.update_date = a.update_date AND t.update_seq = a.update_seq";
			$criteria->condition = "a.TABLE_NAME = 'T_STK_MOVEMENT' AND a.FIELD_NAME = 'STK_CD' AND (UPPER(a.FIELD_VALUE) LIKE UPPER('$this->stk_cd') OR '$this->stk_cd' IS NULL) AND record_seq = 1";
		}

		if(!empty($this->update_date_date))
			$criteria->addCondition("TO_CHAR(t.update_date,'DD') LIKE '%".$this->update_date_date."%'");
		if(!empty($this->update_date_month))
			$criteria->addCondition("TO_CHAR(t.update_date,'MM') LIKE '%".$this->update_date_month."%'");
		if(!empty($this->update_date_year))
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		
			//$criteria->compare('menu_name',$this->menu_name);			
		$criteria->addCondition("t.menu_name IN (".implode(',',$this->menu_name).")");
		$criteria->compare('t.update_seq',$this->update_seq);
		$criteria->compare('lower(t.user_id)',strtolower($this->user_id),true);
		$criteria->compare('t.ip_address',$this->ip_address,true);
		$criteria->compare('t.approved_status',$this->approved_status,true);
		$criteria->compare('t.approved_user_id',$this->approved_user_id,true);
		$criteria->compare('t.status',$this->status,true);

		if(!empty($this->approved_date_date))
			$criteria->addCondition("TO_CHAR(t.approved_date,'DD') LIKE '%".$this->approved_date_date."%'");
		if(!empty($this->approved_date_month))
			$criteria->addCondition("TO_CHAR(t.approved_date,'MM') LIKE '%".$this->approved_date_month."%'");
		if(!empty($this->approved_date_year))
			$criteria->addCondition("TO_CHAR(t.approved_date,'YYYY') LIKE '%".$this->approved_date_year."%'");		$criteria->compare('approved_ip_address',$this->approved_ip_address,true);
		$criteria->compare('reject_reason',$this->reject_reason,true);
		$criteria->compare('cancel_reason',$this->cancel_reason,true);

		$sort = new CSort;
		
		if(!$this->processed_flg)
			$sort->defaultOrder='t.update_date desc';
		else
			$sort->defaultOrder='approved_date desc, update_date desc';
		
		$page = new CPagination;
		$page->pageSize=100;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>$page,
		));
	}
}

	