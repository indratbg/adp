<?php 

class Vinboxinterestrate extends Tmanyheader
{

	public $client_cd;
	
	public $processed_flg = false;
	
	public function attributeLabels()
	{
		return array_merge
				(
					parent::attributeLabels(),
					array(
						'client_cd' => 'Client',
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
									AND table_name = 'MST_CLIENT'
									AND field_name = 'CLIENT_CD'
									AND record_seq = 1
								) client_cd
								";
			
			$criteria->join = "JOIN T_MANY_DETAIL a ON t.update_date = a.update_date AND t.update_seq = a.update_seq";
			$criteria->condition = "a.TABLE_NAME = 'MST_CLIENT' AND a.FIELD_NAME = 'CLIENT_CD' AND record_seq = 1";
		}

		if(!empty($this->update_date_date))
			$criteria->addCondition("TO_CHAR(t.update_date,'DD') LIKE '%".$this->update_date_date."%'");
		if(!empty($this->update_date_month))
			$criteria->addCondition("TO_CHAR(t.update_date,'MM') LIKE '%".$this->update_date_month."%'");
		if(!empty($this->update_date_year))
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		//$criteria->compare('menu_name',$this->menu_name);
			
		$this->menu_name?$criteria->addCondition("t.menu_name = '$this->menu_name'"):'';

		$this->update_seq?$criteria->addCondition("t.update_seq = $this->update_seq"):'';
		$this->user_id?$criteria->addCondition("t.user_id = '$this->user_id'"):'';
		$this->ip_address?$criteria->addCondition("t.ip_address = '$this->ip_address'"):'';
		$this->approved_status?$criteria->addCondition("t.approved_status = '$this->approved_status'"):'';
		$this->approved_user_id?$criteria->addCondition("t.approved_user_id = '$this->approved_user_id'"):'';
		$this->status?$criteria->addCondition("t.status = '$this->status'"):'';
		
		if(!empty($this->approved_date_date))
			$criteria->addCondition("TO_CHAR(t.approved_date,'DD') LIKE '%".$this->approved_date_date."%'");
		if(!empty($this->approved_date_month))
			$criteria->addCondition("TO_CHAR(t.approved_date,'MM') LIKE '%".$this->approved_date_month."%'");
		if(!empty($this->approved_date_year))
			$criteria->addCondition("TO_CHAR(t.approved_date,'YYYY') LIKE '%".$this->approved_date_year."%'");		//$criteria->compare('approved_ip_address',$this->approved_ip_address,true);
		//$criteria->compare('reject_reason',$this->reject_reason,true);
		//$criteria->compare('cancel_reason',$this->cancel_reason,true);

		$sort = new CSort;
		
		if(!$this->processed_flg)
			$sort->defaultOrder='t.update_date desc, client_cd';
		else
			$sort->defaultOrder='approved_date desc, update_date desc';
		
		$page = new CPagination;
		$page->pageSize=500;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>$sort,
			'pagination'=>$page,
		));
	}
}

	