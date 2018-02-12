<?php


class Rptlistofclient extends ARptForm
{
	public $p_margin_cd;
	public $p_client_type3;
	public $p_client_type1;
	public $p_stat;
	public $p_bgn_open_dt;
	public $p_end_open_dt;
	public $p_client_type2;
	public $p_sid;
	public $p_afil;
	public $p_open;
	public $client_cd;
	public $branch_cd;
	public $rem_cd;
	public $p_bgn_subrek;
	public $p_end_subrek;
	public $p_bgn_branch;
	public $p_end_branch;
	public $p_bgn_rem;
	public $p_end_rem;
	public $p_afil_opt;
	public $ab;
	public $opt_rem;
	public $opt_branch;
	public $opt_acc;
	public $opt_marg;
	public $dummy_dt;
	//checkbox
	public $sid;
	public $id;
	public $subre;
	public $dtb;
	public $ktp;
	public $email;
	public $telp;
	public $hp;
	public $fax;
	public $clt;
	public $oltrad;
	public $opac;
	public $ocac;
	public $sls;
	public $norek;
	public $checkbox;
	public $sortby;
	public $cnt_disp=3;
	public $ktp_1;
	public $ktp_2;
	public $totalck;
	
	public static $sortlist = array('1'=>'Client CD','2'=>'Branch','3'=>'Sales','4'=>'Sub Rekening');
	/*
	
		public static $list = array('SID'=>'SID','ID'=>'Id Card No.','SUBRE'=>'Sub Rekening','DTB'=>'Date of Birth','KTP'=>'Alamat KTP','EMAIL'=>'email','TELP'=>'Nomor Telepon','HP'=>'Nomor HP',
		'FAX'=>'Nomor FAX','CLT'=>'Client Type','OLTRAD'=>'Online Trading','OPAC'=>'Opening Account Type','SLS'=>'Sales','NOREK'=>'No. Rekening Dana');
		 const LIST_SID = 'SID'*/
	

	public function rules()
	{
		return array(
			array('p_margin,opt_marg,checkbox,branch_cd,client_cd,rem_cd,p_open,
			p_afil,p_margin_cd,p_client_type3,opt_rem,p_client_type1,p_stat,opt_branch,p_afil_opt,
			p_bgn_open_dt,p_end_open_dt,p_client_type2,p_sid,p_bgn_subrek,p_end_subrek,sid,id,subre,dtb,
			ktp,email,telp,hp,fax,clt,oltrad,opac,ocac,sls,norek,dummy_dt,cnt_disp,sortby,ktp_1,ktp_2,totalck','safe')
		);
	}

	public function attributeLabels()
	{
		return array('sid'=>'SID',
					 'id'=>'ID card',
					 'subre'=>'Sub Rekening',
					 'dtb'=>'Date of Birth',
					 'ktp'=>'Alamat KTP',
					 'ktp_1'=>'Kelurahan',
					 'ktp_2'=>'Kota',
					 'email'=>'Alamat E-mail',
					 'telp'=>'Nomor Telepon',
					 'hp'=>'Nomor HP',
					 'fax'=>'Nomor FAX',
					 'clt'=>'Client Type',
					 'oltrad'=>'Online Trading',
					 'opac'=>'Opening Account Date',
					 'ocac'=>'Closed Account Date',
					 'sls'=>'Sales',
					 'norek'=>'No. Rekening Dana'
		);
	}
		
	public function executeReport($bgn_sub,$end_sub,$sortby)
	{	
		$connection  = Yii::app()->dbrpt;
		$transaction = $connection->beginTransaction();
		
		try{
			$query  = "CALL SPR_LIST_OF_CLIENT(
			:P_MARGIN_CD,    
			:P_CLIENT_TYPE3,
			:P_BGN_REM,     
			:P_END_REM,      
			:P_CLIENT_TYPE1,   
			:P_STAT,
			:P_AFIL,     
			:P_BGN_BRANCH,    
			:P_END_BRANCH,
			to_date(:P_BGN_OPEN_DT,'dd/mm/yyyy'),
			to_date(:P_END_OPEN_DT,'dd/mm/yyyy'),     
			:P_CLIENT_TYPE2,  
			:P_SID,           
			:P_BGN_SUBREK,   
			:P_END_SUBREK,
			:SID_FLAG,
			:ID_FLAG,
			:SUBRE_FLAG,
			:DTB_FLAG,
			:KTP_FLAG,
			:EMAIL_FLAG,
			:TELP_FLAG,
			:HP_FLAG,
			:FAX_FLAG,
			:CLT_FLAG,
			:OLTRAD_FLAG,
			:OPAC_FLAG,
			:OCAC_FLAG,
			:SLS_FLAG,
			:NOREK_FLAG,
			:SORTBY,
			:P_CNT_DISP,
			:KTP_1_FLAG,
			:KTP_2_FLAG,
			:P_USER_ID,
			TO_DATE(:P_GENERATE_DATE,'YYYY-MM-DD HH24:MI:SS'),
			:VO_RANDOM_VALUE,
			:VO_ERRCD,
			:VO_ERRMSG)";
					
			$command = $connection->createCommand($query);		
			$command->bindValue(":P_MARGIN_CD",$this->p_margin_cd,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE3",$this->p_client_type3,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_REM",$this->p_bgn_rem,PDO::PARAM_STR); 
			$command->bindValue(":P_END_REM",$this->p_end_rem,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE1",$this->p_client_type1,PDO::PARAM_STR);
			$command->bindValue(":P_STAT",$this->p_stat,PDO::PARAM_STR);
			$command->bindValue(":P_AFIL",$this->p_afil,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_BRANCH",$this->p_bgn_branch,PDO::PARAM_STR);
			$command->bindValue(":P_END_BRANCH",$this->p_end_branch,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_OPEN_DT",$this->p_bgn_open_dt,PDO::PARAM_STR);
			$command->bindValue(":P_END_OPEN_DT",$this->p_end_open_dt,PDO::PARAM_STR);
			$command->bindValue(":P_CLIENT_TYPE2",$this->p_client_type2,PDO::PARAM_STR);
			$command->bindValue(":P_SID",$this->p_sid,PDO::PARAM_STR);
			$command->bindValue(":P_BGN_SUBREK",$bgn_sub,PDO::PARAM_STR);
			$command->bindValue(":P_END_SUBREK",$end_sub,PDO::PARAM_STR);
			$command->bindValue(":SID_FLAG",$this->sid,PDO::PARAM_STR);
			$command->bindValue(":ID_FLAG",$this->id,PDO::PARAM_STR);
			$command->bindValue(":SUBRE_FLAG",$this->subre,PDO::PARAM_STR);
			$command->bindValue(":DTB_FLAG",$this->dtb,PDO::PARAM_STR);
			$command->bindValue(":KTP_FLAG",$this->ktp,PDO::PARAM_STR);
			$command->bindValue(":EMAIL_FLAG",$this->email,PDO::PARAM_STR);
			$command->bindValue(":TELP_FLAG",$this->telp,PDO::PARAM_STR);
			$command->bindValue(":HP_FLAG",$this->hp,PDO::PARAM_STR);
			$command->bindValue(":FAX_FLAG",$this->fax,PDO::PARAM_STR);
			$command->bindValue(":CLT_FLAG",$this->clt,PDO::PARAM_STR);
			$command->bindValue(":OLTRAD_FLAG",$this->oltrad,PDO::PARAM_STR);
			$command->bindValue(":OPAC_FLAG",$this->opac,PDO::PARAM_STR);
			$command->bindValue(":OCAC_FLAG",$this->ocac,PDO::PARAM_STR);
			$command->bindValue(":SLS_FLAG",$this->sls,PDO::PARAM_STR);
			$command->bindValue(":NOREK_FLAG",$this->norek,PDO::PARAM_STR);
			$command->bindValue(":SORTBY",$sortby,PDO::PARAM_STR);
			$command->bindValue(":P_CNT_DISP",$this->cnt_disp,PDO::PARAM_STR);
			$command->bindValue(":KTP_1_FLAG",$this->ktp_1,PDO::PARAM_STR);
			$command->bindValue(":KTP_2_FLAG",$this->ktp_2,PDO::PARAM_STR);
			$command->bindValue(":P_USER_ID",$this->vp_userid,PDO::PARAM_STR);
			$command->bindValue(":P_GENERATE_DATE",$this->vp_generate_date,PDO::PARAM_STR);
			$command->bindParam(":VO_RANDOM_VALUE",$this->vo_random_value,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRCD",$this->vo_errcd,PDO::PARAM_INT,10);
			$command->bindParam(":VO_ERRMSG",$this->vo_errmsg,PDO::PARAM_STR,100);

			
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
}
