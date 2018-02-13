<?php 

class VinboxpayrecAll extends Tmanyheader
{
	public $payrec_num;
	public $folder_cd;
	public $payrec_date;
	public $client_cd;
	public $client_type;
	public $curr_amt;
	public $remarks;
	
	public $processed_flg = false;
	
	public function attributeLabels()
	{
		return array_merge
				(
					parent::attributeLabels(),
					array(
						'payrec_num' => 'Doc Number',
						'folder_cd' => 'File No',
						'payrec_date' =>' Voucher Date',
						'client_cd' => 'Client',
						'client_type' => 'Type',
						'curr_amt' => 'Amount',
						'remarks' => 'Remarks',
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
									AND table_name = 'T_PAYRECH'
									AND field_name = 'PAYREC_NUM'
									AND record_seq = 1
								) payrec_num,
								(
									SELECT field_value FROM T_MANY_DETAIL 
									WHERE update_date = a.update_date 
									AND update_Seq = a.update_seq
									AND table_name = 'T_PAYRECH'
									AND field_name = 'FOLDER_CD'
									AND record_seq = 1
								) folder_cd,
								(
									SELECT field_value FROM T_MANY_DETAIL 
									WHERE update_date = a.update_date 
									AND update_Seq = a.update_seq
									AND table_name = 'T_PAYRECH'
									AND field_name = 'PAYREC_DATE'
									AND record_seq = 1
								) payrec_date,
								(
									SELECT field_value FROM T_MANY_DETAIL 
									WHERE update_date = a.update_date 
									AND update_Seq = a.update_seq
									AND table_name = 'T_PAYRECH'
									AND field_name = 'CLIENT_CD'
									AND record_seq = 1
								) client_cd,
								(
									SELECT nvl(client_type_3,'')||decode(nvl(recov_charge_flg,'N'),'N','','2490') as client_type 
									FROM MST_CLIENT WHERE client_cd =
										(
											SELECT field_value FROM T_MANY_DETAIL 
											WHERE update_date = a.update_date 
											AND update_Seq = a.update_seq
											AND table_name = 'T_PAYRECH'
											AND field_name = 'CLIENT_CD'
											AND record_seq = 1
										)
								) client_type,
								(
									SELECT field_value FROM T_MANY_DETAIL 
									WHERE update_date = a.update_date 
									AND update_Seq = a.update_seq
									AND table_name = 'T_PAYRECH'
									AND field_name = 'CURR_AMT'
									AND record_seq = 1
								) curr_amt,
								(
									SELECT field_value FROM T_MANY_DETAIL 
									WHERE update_date = a.update_date 
									AND update_Seq = a.update_seq
									AND table_name = 'T_PAYRECH'
									AND field_name = 'REMARKS'
									AND record_seq = 1
								) remarks";
			
			$criteria->join = "JOIN T_MANY_DETAIL a ON t.update_date = a.update_date AND t.update_seq = a.update_seq";
			$criteria->condition = "a.TABLE_NAME = 'T_PAYRECH' AND a.FIELD_NAME = 'PAYREC_NUM' AND record_seq = 1";
		}

		if(!empty($this->update_date_date))
			$criteria->addCondition("TO_CHAR(t.update_date,'DD') LIKE '%".$this->update_date_date."%'");
		if(!empty($this->update_date_month))
			$criteria->addCondition("TO_CHAR(t.update_date,'MM') LIKE '%".$this->update_date_month."%'");
		if(!empty($this->update_date_year))
			$criteria->addCondition("TO_CHAR(t.update_date,'YYYY') LIKE '%".$this->update_date_year."%'");		//$criteria->compare('menu_name',$this->menu_name);
			
		$criteria->addCondition("t.menu_name IN (".implode(',',$this->menu_name).")");

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
			$sort->defaultOrder='payrec_date desc, t.update_date desc';
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

	