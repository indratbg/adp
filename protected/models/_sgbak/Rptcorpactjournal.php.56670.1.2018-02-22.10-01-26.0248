<?php

class Rptcorpactjournal extends ARptForm
{

	public $stk_cd;
	public $ca_type;
	public $bgn_dt;
	public $cum_dt;
	public $remarks;
	public $x_dt;
	public $ip_address;
	public $at_journal;
	public $recording_dt;
	public $today_dt;
	public $distrib_dt;
	public $rate;
	public $stk_cd_merge;
	public function rules()
	{
		return array(
			array('stk_cd','cek_stk_cd','on'=>'jurnal'),
			array('stk_cd_merge,rate,distrib_dt,today_dt,at_journal,remarks,ca_type,stk_cd,bgn_dt,cum_dt,x_dt','safe')
		);
	}
	
	public function attributeLabels()
	{
		return array(
			
		);
	}
	
	public static function getData($distrib_dt,$ca_type, $stk_cd, $cek_date)
	{
		$sql = "SELECT a.STK_CD, a.stk_cd_merge, a.CA_TYPE, a.CUM_DT, 		
					   a.X_DT, a.RECORDING_DT, a.DISTRIB_DT, 	
					     a.FROM_QTY, a.TO_QTY, a.rate,	
						 case when a.DISTRIB_DT < to_date('$cek_date','dd/mm/yyyy') or b.jur_match_dt is not null then 'Y' else 'N' end jurnal_cumdt, 
        		    case when a.DISTRIB_DT < to_date('$cek_date','dd/mm/yyyy') or c.jur_distrib_dt is not null then 'Y' else 'N' end jurnal_distribdt,
        		    case when a.distrib_dt < to_date('$cek_date','dd/mm/yyyy') or d.distrib_dt_journal is not null then 'Y' else 'N' end distrib_dt_journal 
					FROM( SELECT 	
						STK_CD,stk_cd_merge, CA_TYPE, CUM_DT, 
						   X_DT, RECORDING_DT, DISTRIB_DT, 
						   FROM_QTY, TO_QTY,rate,
						decode(ca_type,'SPLIT',x_dt,'REVERSE',x_dt,cum_dt) as match_dt
						FROM T_CORP_ACT
						where ca_type like '%$ca_type'
						AND CA_TYPE <>'CASHDIV'
						AND distrib_dt >= to_date('$distrib_dt','dd/mm/yyyy')
						AND STK_CD LIKE '%$stk_cd'
						AND approved_stat = 'A' ) a,
					( SELECT DISTINCT stk_cd, doc_dt AS jur_match_dt	
					FROM T_STK_MOVEMENT	
					WHERE doc_dt >= to_date('$distrib_dt','dd/mm/yyyy') 	
					AND doc_stat = '2'	
					AND s_d_type IN ('S','R','H','B')
					and jur_type in ('SPLITX','REVERSEX','HMETDC','STKDIVC','BONUSC')
					AND seqno = 1) b,	
					( SELECT DISTINCT stk_Cd, doc_dt AS jur_distrib_dt
					FROM T_STK_MOVEMENT	
					WHERE doc_dt >= to_date('$distrib_dt','dd/mm/yyyy') 	
					AND doc_stat = '2'	
					AND s_d_type IN ('S','R','H','B','M')	
					and jur_type in ('SPLITD','REVERSED','HMETDD','STKDIVD','BONUSD')	
					AND seqno = 1) c,
					( SELECT DISTINCT stk_Cd, doc_dt AS distrib_dt_journal
					FROM T_STK_MOVEMENT	
					WHERE doc_dt >= to_date('$distrib_dt','dd/mm/yyyy')	
					AND doc_stat = '2'	
					AND s_d_type IN ('S','R','H','B','C')	
					and jur_type in ('SPLITN','REVERSEN','HMETDN','STKDIVN','BONUSN','WHDR')	
					AND seqno = 1) d		
					WHERE a.stk_cd = b.stk_cd(+)	
					AND a.match_dt = b.jur_match_dt(+)	
					AND a.stk_cd = c.stk_cd(+)	
					AND a.distrib_dt = c.jur_distrib_dt(+)
					 AND A.STK_CD = D.STK_CD(+)
					AND a.distrib_dt = d.distrib_dt_journal(+) 
					order by a.CUM_DT desc,a.DISTRIB_DT";
		
		return $sql;
	}
		
	public function cek_stk_cd(){
			if($this->ca_type == 'RIGHT' || $this->ca_type == 'WARRANT'){
			if(strlen($this->stk_cd) == 4){
					$this->addError('stk_cd','Tidak boleh sama dengan Stock Code pokok');
				}
			}
			$cek = Counter::model()->find("stk_cd = '$this->stk_cd' ");
			if(!$cek){
				$this->addError('stk_cd','Stock code tidak ditemukan');
			}
			$this->cek_stk_bal();
		}
	
	public function cek_stk_bal(){
		if($this->at_journal =='C')
		{
			$tgl = DateTime::createFromFormat('Y-m-d',$this->cum_dt)->format('Y-m-01');
			$cek = Tstkbal::model()->find("bal_dt = to_date('$tgl','yyyy-mm-dd') ");
			if(!$cek){
				$this->addError('stk_cd', 'Month end harus dilakukan dahulu');
			}	
		}
		else if($this->at_journal =='D')
		{
			$tgl = DateTime::createFromFormat('Y-m-d',$this->distrib_dt)->format('Y-m-01');
			$cek = Tstkbal::model()->find("bal_dt = to_date('$tgl','yyyy-mm-dd') ");
			if(!$cek){
				$this->addError('stk_cd', 'Month end harus dilakukan dahulu');
			}	
			/*
			if($this->today_dt == $this->recording_dt)
			{
			$cek2 = Tcontracts::model()->find(" contr_dt between to_date('$this->recording_dt','yyyy-mm-dd') - 20 
												and to_date('$this->recording_dt','yyyy-mm-dd')  and 
												due_dt_for_amt <= to_date('$this->recording_dt','yyyy-mm-dd') 
												and nvl(sett_qty,0) < qty");	
			
			if($cek2){
				$this->addError('stk_cd', 'Tidak dapat jurnal pada distribution date');
			}
			}
			*/
			
			
			
		}
	}
	
	public function executeRpt()
	{
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL  SPR_CORP_ACT_JOURNAL( TO_DATE(:P_RECORDING_DT,'YYYY-MM-DD'),
													 TO_DATE(:P_TODAY_DT,'YYYY-MM-DD'),
													TO_DATE(:P_BGN_DT,'YYYY-MM-DD'),
													TO_DATE(:P_CUM_DT,'YYYY-MM-DD'),
													 :P_CA_TYPE,
													 :P_STK_CD,
													 :P_STK_CD_MERGE,
													 :P_USER_ID,
													 :P_GENERATE_DATE,
													 :P_RANDOM_VALUE,
													 :P_ERRCD,
													 :P_ERRMSG) ";
					
			$command = $connection->createCommand($query);
			$command->bindValue(":P_RECORDING_DT",$this->recording_dt,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_DT",$this->bgn_dt,PDO::PARAM_STR);
			$command->bindValue(":P_TODAY_DT",$this->today_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CUM_DT",$this->cum_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CA_TYPE",$this->ca_type,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD_MERGE",$this->stk_cd_merge,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":P_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,100);

			$command->execute();
			$transaction->commit();
			
			
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->vo_errcd == -999){
				$this->vo_errmsg = $ex->getMessage();
		    }
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}


public function executeSp($menuName='CORPORATE ACTION JOURNAL')
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		try{
			$query  = "CALL SP_CA_JUR_UPD(TO_DATE(:P_RECORDING_DT,'YYYY-MM-DD'),
										TO_DATE(:P_BGN_DT,'YYYY-MM-DD'),
										TO_DATE(:P_TODAY_DT,'YYYY-MM-DD'),
										TO_DATE(:P_CUM_DT,'YYYY-MM-DD'),
										TO_DATE(:P_X_DT,'YYYY-MM-DD'),
										:P_CA_TYPE,
										:P_STK_CD,
										:P_USER_ID,
										:p_ip_address,
										:P_REMARKS,
										:P_JOURNAL, 
										:P_MENU_NAME,
										:P_MANUAL,
										
										:P_ERRCD,
										:P_ERRMSG) ";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_RECORDING_DT",$this->recording_dt,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_DT",$this->bgn_dt,PDO::PARAM_STR);
			$command->bindValue(":P_TODAY_DT",$this->today_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CUM_DT",$this->cum_dt,PDO::PARAM_STR);
			$command->bindValue(":P_X_DT",$this->x_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CA_TYPE",$this->ca_type,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindValue(":P_REMARKS",$this->remarks,PDO::PARAM_STR);
			$command->bindValue(":P_JOURNAL",$this->at_journal,PDO::PARAM_STR);
			$command->bindValue(":P_MENU_NAME",$menuName,PDO::PARAM_STR);
			$command->bindValue(":P_MANUAL",'Y',PDO::PARAM_STR);
			//$command->bindValue(":P_PRICE",$this->rate,PDO::PARAM_STR);
			$command->bindParam(":P_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,100);
			$command->execute();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->vo_errcd == -999)
				$this->vo_errmsg = $ex->getMessage();
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}

	public function executeSp2($menuName='CORPORATE ACTION JOURNAL')
	{
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction();	
		try{
			$query  = "CALL SP_CA_DISTRIB_JUR_UPD(  TO_DATE(:P_TODAY_DT,'YYYY-MM-DD'),
							                        TO_DATE(:P_CUM_DT,'YYYY-MM-DD'),
							                        TO_DATE(:P_X_DT,'YYYY-MM-DD'),
							                        TO_DATE(:P_RECORDING_DT,'YYYY-MM-DD'),
							                        TO_DATE(:P_DISTRIB_DT,'YYYY-MM-DD'),
							                        :P_CA_TYPE,
							                        :P_STK_CD,
							                        :P_STK_CD_MERGE,
							                      	:P_JUR_TYPE,	
							                        :P_REMARKS,
							                        :P_MANUAL,
							                        :P_USER_ID,
							                        :P_MENU_NAME,
							                        :P_IP_ADDRESS,
							                        :P_ERRCD,
							                        :P_ERRMSG) ";
			
			$command = $connection->createCommand($query);
			$command->bindValue(":P_TODAY_DT",$this->today_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CUM_DT",$this->cum_dt,PDO::PARAM_STR);
			$command->bindValue(":P_X_DT",$this->x_dt,PDO::PARAM_STR);
			$command->bindValue(":P_RECORDING_DT",$this->recording_dt,PDO::PARAM_STR);
			$command->bindValue(":P_DISTRIB_DT",$this->distrib_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CA_TYPE",$this->ca_type,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD",$this->stk_cd,PDO::PARAM_STR);
			$command->bindValue(":P_STK_CD_MERGE",$this->stk_cd_merge,PDO::PARAM_STR);
			$command->bindValue(":P_JUR_TYPE",$this->at_journal,PDO::PARAM_STR);
			$command->bindValue(":P_REMARKS",$this->remarks,PDO::PARAM_STR);
			$command->bindValue(":P_MANUAL",'Y',PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_MENU_NAME",$menuName,PDO::PARAM_STR);
			$command->bindValue(":P_IP_ADDRESS",$this->ip_address,PDO::PARAM_STR);
			$command->bindParam(":P_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":P_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,100);
			$command->execute();
			$transaction->commit();
		}catch(Exception $ex){
			$transaction->rollback();
			if($this->vo_errcd == -999)
				$this->vo_errmsg = $ex->getMessage();
		}
		
		if($this->vo_errcd < 0)
			$this->addError('vo_errmsg', 'Error '.$this->vo_errcd.' '.$this->vo_errmsg);
		
		return $this->vo_errcd;
	}

}
