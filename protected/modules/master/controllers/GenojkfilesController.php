<?php

class GenojkfilesController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';
	
	public function actionIndex(){
		
		$model = new Tbondtrx;	
		$model->unsetAttributes();
		$filetypes = array(
		'BONDCOUNT'=> 'Jumlah Transaksi Obligasi',
		'TRANS' => 'Nilai Seluruh Transaksi Nasabah',
		'OCCUP' => 'Pekerjaan Nasabah',
		'IPO'	=> 'Nilai Transaksi IPO Nasabah',
		'HRISK' => 'Nasabah High Risk',
		'RDNBAL'=> 'Saldo RDN Nasabah',
		'GLBAL' => 'Saldo GL Nasabah',
		//'SP1'	=> 'Nasabah SPM Surabaya (SP1)',
		//'MU001I'=> 'Client Subrek MU001i'
		);
			
		if(isset($_POST['Tbondtrx']))
		{
			$model->attributes = $_POST['Tbondtrx'];
			$filetypeval = $model->bond_cd;
			
			$objPHPExcel = XPHPExcel::createPHPExcel();
			if (function_exists('mb_internal_encoding')) {
			    $oldEncoding = mb_internal_encoding();
			    mb_internal_encoding('latin1');
			}
			$objPHPExcel->setActiveSheetIndex(0);
			$rowCount = 2;
			$filename = '';
			
			switch($filetypeval){
				case 'TRANS':
					$model->validate(array('trx_date','value_dt'));
					
					$modelContent = DAO::queryAllSql("
					Select A.Client_Cd, A.Client_Name, Nvl(B.Transaction_Value,0) Transaction_Value, nvl(C.annual_income,C.profit) Income_Profit,
					decode(susp_stat,'N','ACTIVE','Y','SUSPENDED','CLOSED') client_stat From Mst_Client A, 
					(Select Client_Cd, Sum(Qty*Price) Transaction_Value From T_Contracts Where
					Contr_Stat <> 'C' And Contr_Dt Between to_date('$model->trx_date','YYYY-MM-DD') And to_date('$model->value_dt','YYYY-MM-DD')
					group by client_cd) B,
					mst_cif C
					Where A.Client_Cd = B.Client_Cd(+) And
					A.cifs = C.cifs AND
					a.client_type_1 <> 'B'
					order by 1
					");
					//var_dump($modelContent[0]);
					//die();
					
					$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CLIENT CODE');
				    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'CLIENT NAME');
					$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'TRANSACTION VALUE');
					$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'ANNUAL INCOME / PROFIT');
					$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'CLIENT STATUS');
					$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
		
					if($modelContent){
						foreach($modelContent as $row){
						    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['client_cd']);
						    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['client_name']);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['transaction_value']);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['income_profit']);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['client_stat']);
						    $rowCount++;
						}
					}else{
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '-');
					    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
					}
					$filename = 'client_trans_'.date('dMY');
					foreach(range('A','E') as $columnID) {
					    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
					}
					break;
					
				case 'OCCUP':
					$modelContent = DAO::queryAllSql("
					select a.client_cd, a.client_name, b.occupation, b.empr_biz_type from mst_client a, mst_client_indi b where
					a.cifs = b.cifs
					order by 1
					");
					//var_dump($modelContent[0]);
					//die();
					$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CLIENT CODE');
				    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'CLIENT NAME');
					$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'OCCUPATION');
					$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'FIELD OF WORK');
					$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
										
					if($modelContent){
						foreach($modelContent as $row){
						    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['client_cd']);
						    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['client_name']);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['occupation']);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['empr_biz_type']);
						    $rowCount++;
						}
					}else{
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '-');
					    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
					}
					$filename = 'client_occup_'.date('dMY');
					foreach(range('A','D') as $columnID) {
					    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
					}
					break;
					
				case 'SP1':
					$modelContent = DAO::queryAllSql("
					select a.client_cd, 
					a.client_name, 
					a.sid, 
					b.subrek001, 
					b.subrek004, 
					a.rem_cd sales,
					d.prm_desc id_type, 
					c.client_ic_num id_number,
					c.def_addr_1 alamat_domisili_1, 
					c.def_addr_2 alamat_domisili_2, 
					c.def_addr_3 alamat_domisili_3,
					e.id_addr alamat_ktp, 
					e.id_rtrw rt_rw_ktp, 
					e.id_klurahn kelurahan_ktp, 
					e.id_kcamatn kecamatan_ktp,
					e.id_kota kota_ktp,
					decode(a.susp_stat,'Y','Suspended','N','Active','Closed') client_status
					from mst_client a,
					v_client_subrek14 b,
					mst_cif c,
					(select * from mst_parameter where prm_cd_1 = 'IDTYPE') d,
					mst_client_indi e
					where
					a.client_cd = b.client_cd and
					a.cifs = c.cifs and
					c.ic_type = d.prm_cd_2 and
					a.cifs = e.cifs and
					a.client_type_1 <> 'B' and
					a.rem_cd = 'SP1'
					order by 1
					");
					//var_dump($modelContent[0]);
					//die();
					$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CLIENT CODE');
				    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'CLIENT NAME');
					$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'SID');
					$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'SUBREK001');
					$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'SUBREK004');
				    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'SALES');
					$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'ID TYPE');
					$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'ID NUMBER');
					$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'ALAMAT DOMISILI 1');
				    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'ALAMAT DOMISILI 2');
					$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'ALAMAT DOMISILI 3');
					$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'ALAMAT KTP');
					$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'RT RW KTP');
				    $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'KELURAHAN KTP');
					$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'KECAMATAN KTP');
					$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'KOTA KTP');
					$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'CLIENT STATUS');
					$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('P1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
										
					if($modelContent){
						foreach($modelContent as $row){
						    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['client_cd']);
						    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['client_name']);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['sid']);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['subrek001']);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['subrek004']);
						    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row['sales']);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row['id_type']);
							$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row['id_number']);
							$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row['alamat_domisili_1']);
						    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row['alamat_domisili_2']);
							$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row['alamat_domisili_3']);
							$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row['alamat_ktp']);
							$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row['rt_rw_ktp']);
						    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row['kelurahan_ktp']);
							$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row['kecamatan_ktp']);
							$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row['kota_ktp']);
							$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row['client_status']);
						    $rowCount++;
						}
					}else{
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '-');
					    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
					    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, '-');
					    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, '-');
					    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, '-');
					}
					$filename = 'client_sp1_'.date('dMY');
					foreach(range('A','Q') as $columnID) {
					    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
					}
					break;
					
				case 'HRISK':
					$modelContent = DAO::queryAllSql("
					Select name, kategori, descrip From T_Highrisk_Name Where Approved_Stat = 'A'
					order by kategori, nvl(descrip,'AA'), name
					");
					//var_dump($modelContent[0]);
					//die();
					$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CLIENT NAME');
				    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'KATEGORI');
					$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'DESCRIPTION');
					$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
															
					if($modelContent){
						foreach($modelContent as $row){
						    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['name']);
						    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['kategori']);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['descrip']);
						    $rowCount++;
						}
					}else{
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '-');
					    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, '-');
					}
					$filename = 'client_highrisk_'.date('dMY');
					foreach(range('A','C') as $columnID) {
					    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
					}
					break;
					
				case 'IPO':
					$model->validate(array('trx_date','value_dt'));
					
					$modelContent = DAO::queryAllSql("
					Select B.Client_Cd, To_Number(To_Char(a.doc_dt,'MM')) MONTH,
					To_Number(To_Char(A.Doc_Dt,'YYYY')) YEAR,
					sum(a.total_share_qty * nvl(a.price,0)) IPO_VALUE 
					from t_stk_movement a, mst_client b 
					Where
					a.client_cd = b.client_cd
					And A.S_D_Type = 'C' 
					and a.doc_dt between to_date('$model->trx_date','YYYY-MM-DD') And to_date('$model->value_dt','YYYY-MM-DD')
					And A.Doc_Num Like '%RSN%'
					And A.Seqno = 1
					And B.Client_Type_1 <> 'B'
					And Upper(A.Doc_Rem) Like '%IPO%'
					Group By B.Client_Cd, To_Number(To_Char(a.doc_dt,'MM')),
					To_Number(To_Char(a.doc_dt,'YYYY'))
					order by 3,2,1
					");
					//var_dump($modelContent[0]);
					//die();
					
					$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CLIENT CODE');
				    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'MONTH');
					$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'YEAR');
					$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'IPO VALUE');
					$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
		
					if($modelContent){
						foreach($modelContent as $row){
						    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['client_cd']);
						    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['month']);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['year']);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['ipo_value']);
						    $rowCount++;
						}
					}else{
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '-');
					    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
					}
					$filename = 'client_ipo_'.date('dMY');
					foreach(range('A','D') as $columnID) {
					    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
					}
					break;
					
				case 'RDNBAL':
					$model->validate(array('trx_date'));
					
					$modelContent = DAO::queryAllSql("
					Select Client_Cd, Client_Name, Decode(Susp_Stat,'N','ACTIVE','Y','SUSPENDED','CLOSED') Client_Stat,
					nvl(F_Fund_Bal(Client_Cd, To_Date('$model->trx_date','YYYY-MM-DD')),0) RDN_End_Bal From Mst_Client
					Where Client_Type_1 <> 'B'
					order by 1
					");
					//var_dump($modelContent[0]);
					//die();
					
					$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CLIENT CODE');
				    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'CLIENT NAME');
					$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'CLIENT STATUS');
					$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'RDN BALANCE');
					$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
		
					if($modelContent){
						foreach($modelContent as $row){
						    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['client_cd']);
						    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['client_name']);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['client_stat']);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['rdn_end_bal']);
						    $rowCount++;
						}
					}else{
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '-');
					    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
					}
					$filename = 'client_rdnbal_'.date('dMY');
					foreach(range('A','D') as $columnID) {
					    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
					}
					break;
				
				case 'MU001I':
					$model->validate(array('trx_date'));
					
					$modelContent = DAO::queryAllSql("
					SELECT a.client_cd, client_name,to_char(d.client_birth_dt,'DD MON YYYY') client_birth_dt, client_ic_num, d.npwp_no, subrek001,
					to_char(trunc(a.cre_dt),'DD MON YYYY') ACCOUNT_OPENING_DATE, nvl(e.bank_acct_num,'-') RDN_NO
					FROM MST_CLIENT a
					JOIN MST_CLIENT_INDI b ON a.cifs = b.cifs
					JOIN V_CLIENT_SUBREK14 c ON a.client_cd = c.client_cd
					JOIN MST_CIF d ON a.cifs = d.cifs
					LEFT JOIN MST_CLIENT_FLACCT e on a.client_cd = e.client_cd
					WHERE SUBSTR(subrek001,1,6) LIKE 'MU001I%'
					ORDER BY a.client_cd
					");
					//var_dump($modelContent[0]);
					//die();
					
					$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CLIENT CODE');
				    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'CLIENT NAME');
					$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'BIRTH DATE');
					$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'NO. KTP');
					$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'NO. NPWP');
					$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'SUBREK');
					$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'ACCOUNT OPENING DATE');
					$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'NO. RDN');
					$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
		
					if($modelContent){
						foreach($modelContent as $row){
						    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['client_cd']);
						    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['client_name']);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['client_birth_dt']);
							$objPHPExcel->getActiveSheet()->SetCellValueExplicit('D'.$rowCount, $row['client_ic_num'],PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->SetCellValueExplicit('E'.$rowCount, $row['npwp_no'],PHPExcel_Cell_DataType::TYPE_STRING);
						    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row['subrek001']);
							$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row['account_opening_date']);
							$objPHPExcel->getActiveSheet()->SetCellValueExplicit('H'.$rowCount, $row['rdn_no'],PHPExcel_Cell_DataType::TYPE_STRING);
						    $rowCount++;
						}
					}else{
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '-');
					    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
					    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, '-');
					}
					$filename = 'client_MU001i_'.date('dMY');
					foreach(range('A','H') as $columnID) {
					    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
					}
					break;

				case 'BONDCOUNT':
					$mon = $_POST['mon'];
					$year = $_POST['year'];
					$mon = sprintf("%02d", $mon);
					
					$modelContent = DAO::queryAllSql("
					select count(*) transaction_count, to_char(value_dt,'DD Mon YYYY') value_date, to_char(trx_date,'DD Mon YYYY') transaction_date, 
					$mon MONTH, $year YEAR from t_bond_trx
					where to_char(value_dt, 'MMYYYY') = '$mon$year' and
					lawan_type <> 'I' and
					approved_sts = 'A'
					group by trx_date, value_dt
					order by 2,3
					");
					//var_dump($modelContent[0]);
					//die();
					
					$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'TRANSACTION COUNT');
				    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'VALUE DATE');
					$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'TRANSACTION DATE');
					$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'MONTH');
					$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'YEAR');
					$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
		
					if($modelContent){
						foreach($modelContent as $row){
						    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['transaction_count']);
						    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['value_date']);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['transaction_date']);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['month']);
							$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['year']);
						    $rowCount++;
						}
					}else{
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '-');
					    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, '-');
					}
					$filename = 'bond_count_'.$mon.'_'.$year;
					foreach(range('A','E') as $columnID) {
					    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
					}
					break; 	
					
				default:
					$model->validate(array('trx_date'));
					
					$modelContent = DAO::queryAllSql("
					Select A.Client_Cd, a.client_name, nvl(B.Balance,0) balance, decode(a.susp_stat,'N','Active','C','Closed','Suspended') status
					From Mst_Client A, 
					(
					Select sl_acct_cd, sum(cre_obal - deb_obal) balance From T_Day_Trs Where Trs_Dt = to_date('$model->trx_date','YYYY-MM-DD')+1 And
					Gl_Acct_Cd In (1040, 3020, 1060, 1049)
					Group By Sl_Acct_Cd
					)B Where
					A.Client_Cd = B.Sl_Acct_Cd(+) And
					a.client_type_1 <> 'B'
					order by 1
					");
					//var_dump($modelContent[0]);
					//die();
					
					$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'CLIENT CODE');
				    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'CLIENT NAME');
					$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'GL BALANCE');
					$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'CLIENT STATUS');
					$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
		
					if($modelContent){
						foreach($modelContent as $row){
						    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['client_cd']);
						    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['client_name']);
							$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['balance']);
							$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['status']);
						    $rowCount++;
						}
					}else{
						$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '-');
					    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, '-');
						$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, '-');
					}
					$filename = 'client_glbal_'.date('dMY');
					foreach(range('A','D') as $columnID) {
					    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
					}
					
			}
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			ob_clean();
			$objWriter->save('php://output');
			exit;
		}else{
			$model->trx_date = date('01/m/Y');
			$model->value_dt = date('t/m/Y');
			$mon = date('m')-1;
			$year = date('Y');
		}
		
		$this->render('index',array(
		'filetypes'=>$filetypes,
		'model'=>$model,
		'mon'=>$mon,
		'year'=>$year
		));
	}
}
