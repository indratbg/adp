<?php

class GenbondfilesController extends AAdminController
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
		);
			
		if(isset($_POST['Tbondtrx']))
		{
			$model->attributes = $_POST['Tbondtrx'];
			$filetypeval = $model->bond_cd;
			
			$objPHPExcel = XPHPExcel::createPHPExcel();
			$objPHPExcel->setActiveSheetIndex(0);
			$rowCount = 2;
			$filename = '';
			
			switch($filetypeval){
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
