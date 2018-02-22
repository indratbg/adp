<?php 

class Vinboxlaptrxharian extends Tmanyheader
{
	public $trx_date;
	
	public function attributeLabels()
	{
		return array_merge
				(
					parent::attributeLabels(),
					array(
						'trx_date' => 'Date',
						
					)
				);
	}
	
	public function search()
	{
		$criteria = new CDbCriteria;
		
	
			$criteria->select = "t.*, 
								(
									SELECT field_value FROM T_MANY_DETAIL 
									WHERE update_date = a.update_date 
									AND update_Seq = a.update_seq
									AND field_name = 'TRX_DT'
									AND RECORD_SEQ=1
								) TRX_DATE";
			
			$criteria->join = "JOIN T_MANY_DETAIL a ON t.update_date = a.update_date AND t.update_seq = a.update_seq";
			$criteria->condition = "a.TABLE_NAME = 'LAP_TRX_HARIAN' AND a.FIELD_NAME = 'TRX_DT' AND record_seq = 1";
		

		if(!empty($this->update_date_date))
			$criteria->addCondition("TO_CHAR(t.update_date,'DD') LIKE '%".$this->update_date_date."%'");
		if(!empty($this->update_date_month))
			$criteria->addCondition("TO_CHAR(t.update_date,'MM') LIKE '%".$this->update_date_month."%'");
		if(!empty($this->update_date_year))
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		//$criteria->compare('menu_name',$this->menu_name);
			
		//$criteria->addCondition("t.menu_name IN (".implode(',',$this->menu_name).")");
			
		$criteria->compare('t.update_seq',$this->update_seq);
		$criteria->compare('t.user_id',$this->user_id,true);
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
		$sort->defaultOrder ='trx_date desc';
		$page = new CPagination;
		$page->pageSize=20;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>$page,
		));
	}
}

	