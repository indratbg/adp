<?php
    class AConstant
    {
        // AH: for user interface
        public static $is_flag          = array(''=>'All',0=>'No',1=>'Yes');
		public static $is_flag_ch       = array(''=>'All','N'=>'No','Y'=>'Yes');
		public static $is_flag_status   = array(''=>'All','N'=>'Active','Y'=>'Suspended');
		
		public static $susp_status 		= array('Y'=>'Suspended','N'=>'Active','C'=>'Closed');
		
        public static $status           = array('1'=>'New','2'=>'Approved','8'=>'Finished','9'=>'Void');
        public static $depedency_status = array('1'=>'Not Yet','2'=>'Half','8'=>'Complete');
        public static $menuactiongroup  = array('1'=>'No Access','2'=>'Read Only','3'=>'Create','4'=>'Modify','5'=>'Remove');
       
	   	public static $inbox_stat 	 	= array('I'=>'Insert','U'=>'Update','C'=>'Cancel','R'=>'Update');
		public static $inbox_app_stat   = array('E'=>'Entry','A'=>'Approve','R'=>'Reject');
		
		public static $user_level 		= array(''=>'-','1  '=>'Branch Manager','2  '=>'Salesman');
		
		public static $acct_stat		= array('A'=>'Active','I'=>'Inactive','C'=>'Closed','B'=>'Blocked');
		public static $acct_stat2 		= array('A'=>'Active','C'=>'Cancel');
		
		public static $client_code_opt  = array('A'=>'Automatic', 'M'=>'Manual'); 
		public static $client_print_flg = array('N'=>'none', 'E'=>'email' , 'F' => 'fax', 'B' => 'email & fax');
		public static $client_rebate_basis = array('DM'=>'alamat surat = alamat domisili', 'ID'=>'alamat surat = alamat id card' , 
												   'KT' => 'alamat surat = alamat office', 'SU' => 'alamat surat beda dr lainnya');
		
		public static $settle_client_sale_sts = array('P'=>'Buy','S'=>'Sell');
		public static $rp_list_stock_group = array('1'=>'Ctr Type','2'=>'No Grouping');
		public static $import_type = array('1'=>'Upload Pertama','2'=>'Upload Berikutnya');
		public static $sdi_type = array('1'=>'Pembukaan Sub Rekening','2'=>'Pengkinian Data','3'=>'Block','4'=>'UnBlock');
		
		public static $highrisk_kategori = array('CUSTOMER'=>'Customer','ENTITY'=>'Entity','JOB'=>'Job Position','OCCUPATION'=>'Occupation','BUSINESS'=>'Business','COUNTRY'=>'Country');
		
		public static $client_type = array('I'=>'INDIVIDUAL','C'=>'INSTITUTIONAL','H'=>'HOUSE','B'=>'BROKER');
		
		public static $contract_belijual = array('B'=>'Beli', 'J'=>'Jual');
		
		public static $is_popup = array('0'=>'No', '1'=>'Yes');
		
		public static $spouse_relation = array('1'=>'Suami','2'=>'Istri','3'=>'Ayah','4'=>'Ibu','5'=>'Lainnya');
		
		public static $grp_type_emitent =array('B'=>'1 Emitent bbrp jenis efek','C'=>'1 Grup bbrp emitent');
		
		public static $client_type_stkmov = array('%'=>'ALL','M'=>'MARGIN','R'=>'REGULAR','H'=>'OWN PORTO','L'=>'SHORTSELL');
		public static $reconcile_dhk = array('DIFF'=>'Show Difference','ALL'=>'Show All');
		public static $reconcile_bank_acct = array('DIFF'=>'Difference','ALL'=>'All');
		public static $doc_type_client_deposit = array('A'=>'ADDENDUM','D'=>'DEPOSIT');
		public static $upd_subrek_sid = array('XX'=>'Suffix XX','00'=>'Suffix 00');
		public static $rpt_fund_lgr_jur=array('PE'=>'PE','CLIENT'=>'All Client','UMUM'=>'Nasabah Umum','ALL'=>'All','CLIENT_CD'=>'Specified Client');
		public static $approve_stat = array('A'=>'Sudah Diapprove','C'=>'Sudah Reject','E'=>'Belum Diappove');
		public static $client_status = array('ALL'=>'ALL','N'=>'Active','C'=>'Closed','Y'=>'Suspend');
		public static $receiver_cust_type = array('1'=>'Perorangan','2'=>'Perusahaan','3'=>'Pemerintah');
		public static $receiver_cust_residence = array('R'=>'Penduduk','N'=>'Bukan Penduduk');
		public static $rounding =array('CEIL'=>'ROUND UP','ROUND'=>'ROUND','FLOOR'=>'ROUND DOWN');
		public static $bank_stat=array('A'=>'Active','C'=>'Closed');
		public static $movement_type = array('R'=>'Setoran','W'=>'Tarik','B'=>'Bunga','T'=>'Pajak','P'=>'Pindah','I'=>'Recv IPO','O'=>'Withdraw IPO');//'M'=>'Masuk ke Nsb umum','K'=>'Keluar dr Nsb umum','I'=>'Adjustment IN','O'=>'Adjustment OUT');
		const SUPERADMIN_GROUP = '4'; // Change to '1' in production
		
		const CLIENT_TYPE_INDIVIDUAL	= 'I';
		const CLIENT_TYPE_INSTITUTIONAL	= 'C';
		const CLIENT_TYPE_HOUSE			= 'H';
		const CLIENT_TYPE_BROKER		= 'B';
		
		const KBB_TYPE_AP = 1;
		const KBB_TYPE_AR = 2;
		const KBB_TYPE_TO_RDI = 3;
		const KBB_TYPE_TO_CLIENT = 4;
		const KBB_TYPE_TO_CLIENT_IPO = 5;
        const KBB_TYPE_TO_RDI_FUND = 6;
        const KBB_TYPE_TO_CLIENT_FUND = 7;
		
		const HMETD_TYPE_DISTRIBUTION = 1;
		const HMETD_TYPE_TEBUS = 2;
		const HMETD_TYPE_EXPIRED = 3;
		
		const VOUCHER_TENDER_TYPE_PENJUALAN = 1;
		const VOUCHER_TENDER_TYPE_DISTRIBUTION = 2;
		
		const INIT_DEPOSIT_CD_DANA = 'D';
		const INIT_DEPOSIT_CD_EFEK = 'E';
		
		const HIGHRISK_KATEGORI_CUSTOMER = 'CUSTOMER';
		const HIGHRISK_KATEGORI_JOB = 'JOB';
		const HIGHRISK_KATEGORI_OCCUPATION = 'OCCUPATION';
		const HIGHRISK_KATEGORI_BUSINESS = 'BUSINESS';
		
		const SDI_TYPE_SUBREK = '1';
		const SDI_TYPE_PENGKINIANDATA = '2';
		const SDI_TYPE_BLOCK = '3';
		const SDI_TYPE_UNBLOCK = '4';
		
		const IMPORT_TYPE_PERTAMA = '1';
		const IMPORT_TYPE_BERIKUTNYA = '2';
		
		const RP_LIST_STOCK_CTRTYPE 	= '1';
		const RP_LIST_STOCK_NOGROUPING 	= '2';
		
		const ACCT_STAT_ACTIVE 		= 'A';
		const ACCT_STAT_INACTIVE	= 'I';
		
		const INBOX_STAT_INS = 'I';
		const INBOX_STAT_UPD = 'U';
		const INBOX_STAT_CAN = 'C';
		
		const INBOX_APP_STAT_ENTRY   = 'E';
		const INBOX_APP_STAT_APPROVE = 'A';
		const INBOX_APP_STAT_REJECT  = 'R';
		
		const INBOX_CONTR_UPD = 'R';
                
        const IS_FLAG_NO   = 0;
        const IS_FLAG_YES  = 1;
		
		const IS_FLAG_N   = 'N';
        const IS_FLAG_Y   = 'Y';
        
        const STATUS_NEW      = 1;
        const STATUS_APPROVED = 2;
        const STATUS_FINISHED = 8;
        const STATUS_VOID     = 9;
        
        const DEPEDENCY_STATUS_NOT_YET  = 1;
        const DEPEDENCY_STATUS_HALF     = 2;
        const DEPEDENCY_STATUS_COMPLETE = 8;
		
		
		const MENUACTIONGROUP_READONLY = 2;
		const MENUACTIONGROUP_CREATE = 3;
		const MENUACTIONGROUP_MODIFY = 4;
		const MENUACTIONGROUP_REMOVE = 5;
    
        // AH: getting image path to display image 
        public static function getImagePath($folder_name = '')
        {
        	$images_path =  Yii::app()->request->hostInfo.'/templatephp/images/';
        	if($folder_name != '')
        		$images_path .= $folder_name.'/';
        	
           return $images_path;   
        }      
        
        // AH: getting real path on computer [use this to delete file] 
        // Example  D:\onwork\web\php\paramamu\protected\..\images\{folder_name}
        public static function getImageBasePath($folder_name = '')
        {
        	$images_basepath =  Yii::app()->basePath.'/../templatephp/images/';
        	if($folder_name != '')
        		$images_basepath .= $folder_name.'/';
        	 
        	return $images_basepath;	
        }
		
		public static function getFileBasePath($folder_name = '')
        {
        	$images_basepath =  Yii::app()->basePath.'/../upload/';
        	if($folder_name != '')
        		$images_basepath .= $folder_name.'/';
        	 
        	return $images_basepath;	
        }
        
        public static function getArraySearch($field_name)
        {
            $temp    = AConstant::${$field_name};
            $temp[''] = 'All';
            
            return $temp;   
        }
		
		
		public static function getArrayYear()
		{
			$yearStart = date('Y')-5;
			$yearEnd   = date('Y')+2;
			$yearArr   = array();
			
			for($i=$yearStart;$i<$yearEnd;$i++)
				$yearArr[$i] = $i;
			
			return $yearArr;
		}
		
		public static function getArrayMonth()
		{
			return array('01'=>'January','02'=>'February','03'=>'March','04'=> 'April', '05'=>'May', '06'=>'June', 
						 '07'=>'July','08'=>'August','09'=>'September','10'=>'October', '11'=>'November','12'=>'December');	                    	
		}
		
		public static function getEndDateBourse($date)//date format d/m/Y
		{
			if(DateTime::createFromFormat('d/m/Y',$date))$date =DateTime::createFromFormat('d/m/Y',$date)->format('Y-m-d'); 
			
			$date = date('Y-m-t',strtotime($date));
			$cek_date = DateTime::createFromFormat('Y-m-d',$date)->format('d/m/Y');
			
			$sql="select F_IS_HOLIDAY('$cek_date') holiday from dual";
			$exec = DAO::queryRowSql($sql);
			
			while($exec['holiday']==1){
				$date = date('Y-m-d',strtotime("$date -1 day"));
				$cek_date =DateTime::createFromFormat('Y-m-d',$date)->format('d/m/Y');
				$sql="select F_IS_HOLIDAY('$cek_date') holiday from dual";
				$exec = DAO::queryRowSql($sql);
			}
			
			if(DateTime::createFromFormat('Y-m-d',$date))$date =DateTime::createFromFormat('Y-m-d',$date)->format('d/m/Y'); 
			
			return $date;                    	
		}
        public static function getDueDate($days,$date)
        {
            $date_format_flg='';
            if(DateTime::createFromFormat('d/m/Y',$date))
            {
                $date_format_flg='Y';
                $date =DateTime::createFromFormat('d/m/Y',$date)->format('Y-m-d');
            }
            $sql = DAO::queryRowSql("select get_due_date('$days','$date')due_date from dual");
            $due_date = DateTime::createFromFormat('Y-m-d H:i:s',$sql['due_date'])->format('Y-m-d');
            if($date_format_flg)
            {
                $due_date = DateTime::createFromFormat('Y-m-d',$due_date)->format('d/m/Y');
            }
            return $due_date;
        }
        public static function getDocDate($days,$date)
        {
            $date_format_flg='';
            if(DateTime::createFromFormat('d/m/Y',$date))
            {
                $date_format_flg='Y';
                $date =DateTime::createFromFormat('d/m/Y',$date)->format('Y-m-d');
            }
            $sql = DAO::queryRowSql("select get_doc_date('$days','$date')doc_date from dual");
            $doc_date = DateTime::createFromFormat('Y-m-d H:i:s',$sql['doc_date'])->format('Y-m-d');
            if($date_format_flg)
            {
                $doc_date = DateTime::createFromFormat('Y-m-d',$doc_date)->format('d/m/Y');
            }
            return $doc_date;
        }
        
    }

?>