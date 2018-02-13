<?php

Class Genrepojournal extends CFormModel
{
	public $repo_date;
	public $repo_num;
	public $repo_val;
	public $return_val;
	public $repo_type;
	public $repo_stage;
	public $bank_gla;
	public $bank_sla;
	public $porto_gla;
	public $porto_sla;
	public $lr_porto_gla;
	public $lr_porto_sla;
	public $remarks;
	public $folder_cd;
	
	public $tempDateCol   = array();  
	
	public function getPortoSql($repo_num, $repo_date)
	{
		/*$sql = "SELECT SUM(stk_val)	stk_val			
				FROM
				(				
					SELECT b.client_cd, b.stk_cd, b.qty, a.avg_price, b.qty * a.avg_price AS stk_Val				
					FROM				
					(
						SELECT a1.client_Cd, a1.stk_cd, a1.avg_dt, a1.avg_buy_price avg_price				
						FROM T_AVG_PRICE a1,				
						(				
							SELECT client_cd, stk_Cd, MAX(avg_dt) max_Dt				
							FROM T_AVG_PRICE 				
							WHERE avg_dt <= TO_DATE('$repo_date','YYYY-MM-DD')		
							GROUP BY client_cd, stk_Cd				
						) a2				
						WHERE a1.avg_dt = a2.max_dt				
						AND a1.client_Cd = a2.client_Cd				
						AND a1.stk_cd = a2.stk_cd				
					) a,				
					(
						SELECT h.client_Cd, t.stk_Cd, t.total_Share_qty qty				
						FROM T_REPO h, T_REPO_STK s, T_STK_MOVEMENT t				
						WHERE h.repo_num = '$repo_num'				
						AND h.repo_num = s.repo_num 				
						AND s.doc_num = t.doc_num				
						AND t.seqno = 1
					) b				
					WHERE a.client_cd = b.client_Cd				
					AND a.stk_Cd = b.stk_Cd				
				)";*/
		
		$sql = "SELECT SUM(stk_val)	stk_val			
				FROM
				(				
					SELECT b.client_cd, b.stk_cd, b.qty, a.close_price, b.qty * a.close_price AS stk_Val				
					FROM				
					(
						SELECT a1.stk_cd, a1.stk_date, a1.stk_clos close_price			
						FROM T_CLOSE_PRICE a1,				
						(				
							SELECT stk_Cd, MAX(stk_date) max_Dt				
							FROM T_CLOSE_PRICE				
							WHERE stk_date <= TO_DATE('$repo_date','YYYY-MM-DD')		
							GROUP BY stk_Cd				
						) a2				
						WHERE a1.stk_date = a2.max_dt						
						AND a1.stk_cd = a2.stk_cd				
					) a,				
					(
						SELECT h.client_Cd, t.stk_Cd, t.total_Share_qty qty				
						FROM T_REPO h, T_REPO_STK s, T_STK_MOVEMENT t				
						WHERE h.repo_num = '$repo_num'				
						AND h.repo_num = s.repo_num 				
						AND s.doc_num = t.doc_num				
						AND t.seqno = 1
					) b				
					WHERE a.stk_Cd = b.stk_Cd				
				)";
		
		return $sql;
	}
	
	public function rules()
	{
		return array(
			array('repo_date', 'application.components.validator.ADatePickerSwitcherValidatorSP'),
			array('repo_val, return_val', 'application.components.validator.ANumberSwitcherValidator'),
			
			array('bank_sla','checkExist'),
			
			array('repo_date, repo_num, repo_val, repo_stage, remarks, bank_gla, bank_sla, porto_gla, porto_sla, lr_porto_gla, lr_porto_sla','required'),
			array('repo_type, folder_cd','safe'),
		);
	}
	
	public function checkExist()
	{
		if($this->bank_sla)
		{
			$checkBank = DAO::queryRowSql
						("
							SELECT COUNT(*) cnt
							FROM MST_GL_ACCOUNT
							WHERE TRIM(gl_a) = TRIM('$this->bank_gla') 
							AND sl_a LIKE '$this->bank_sla'
							AND prt_type <> 'S'
							AND acct_stat = 'A'
							AND approved_stat = 'A'
						");
			
			if($checkBank['cnt'] == 0)$this->addError('bank_sla', "$this->bank_gla $this->bank_sla not found in chart of accounts");
		}
		
		if($this->porto_sla)
		{
			$checkPorto = DAO::queryRowSql
						("
							SELECT COUNT(*) cnt
							FROM MST_GL_ACCOUNT
							WHERE TRIM(gl_a) = TRIM('$this->porto_gla') 
							AND sl_a LIKE '$this->porto_sla'
							AND prt_type <> 'S'
							AND acct_stat = 'A'
							AND approved_stat = 'A'
						");
			
			if($checkPorto['cnt'] == 0)$this->addError('porto_sla', "$this->porto_gla $this->porto_sla not found in chart of accounts");
		}
		
		if($this->lr_porto_sla)
		{
			$checkLrPorto = DAO::queryRowSql
							("
								SELECT COUNT(*) cnt
								FROM MST_GL_ACCOUNT
								WHERE TRIM(gl_a) = TRIM('$this->lr_porto_gla') 
								AND sl_a LIKE '$this->lr_porto_sla'
								AND prt_type <> 'S'
								AND acct_stat = 'A'
								AND approved_stat = 'A'
							");
			
			if($checkLrPorto['cnt'] == 0)$this->addError('lr_porto_sla', "$this->lr_porto_gla $this->lr_porto_sla not found in chart of accounts");
		}
	}
	
	public function attributeLabels()
	{
		return array(
			'repo_date' => 'Date',
			'repo_num' => 'Repo',
			'repo_val' => 'Amount',
			'repo_stage' => 'Tahap',
			'folder_cd' => 'File No',
			'bank_gla' => 'GL Bank',
			'bank_sla' => 'SL Bank',
			'porto_gla' => 'GL Portofolio',
			'porto_sla' => 'SL Portofolio',
			'lr_porto_gla' => 'GL Laba/Rugi Portofolio',
			'lr_porto_sla' => 'SL Laba/Rugi Portofolio',
		);
	}
}
