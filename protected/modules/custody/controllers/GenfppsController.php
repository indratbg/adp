<?php

Class GenfppsController extends AAdminController
{
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model = new GenFPPS;
		$modelRetrieve = array();
		
		$success = false;
		
		if(isset($_POST['GenFPPS']))
		{
			$model->attributes = $_POST['GenFPPS'];
			
			if($model->format == 1)$model->type = '%';
			
			if($_POST['submit'] == 'retrieve')
			{
				if($model->begin_subrek == '')$model->begin_subrek = '%';
				if($model->end_subrek == '')$model->end_subrek = '_';
				
				$modelRetrieve = Tipoclient::model()->findAllBySql($model->getFppsSql());
				
				if($model->begin_subrek == '%')$model->begin_subrek = '';
				if($model->end_subrek == '_')$model->end_subrek = '';
			}
			else 
			{
				$excelFileName = Yii::app()->basePath.'/../upload/gen_fpps/fpps_'.date('YmdHis').substr((string)microtime(), 2, 6).'.xls';
							 
				$objPHPExcel= XPHPExcel::createPHPExcel();	
				
				$objPHPExcel->setActiveSheetIndex(0);
				
				$fileRow = 2;
				
				if($model->format == 1)
				{
					$objPHPExcel->getActiveSheet()
								->setCellValue('A1', 'NO')
								->setCellValue('B1', 'NAMA PEAP')
								->setCellValue('C1', 'JENIS ID')
								->setCellValue('D1', 'NO ID')
								->setCellValue('E1', 'NAMA-1')
								->setCellValue('F1', 'NAMA-2')
								->setCellValue('G1', 'ALAMAT')
								->setCellValue('H1', 'KECAMATAN')
								->setCellValue('I1', 'KOTA')
								->setCellValue('J1', 'TANGGAL ID EXPIRED')
								->setCellValue('K1', 'WARGA NEGARA')
								->setCellValue('L1', 'STATUS')
								->setCellValue('M1', 'PARTISIPAN')
								->setCellValue('N1', 'REKENING EFEK')
								->setCellValue('O1', 'JUMLAH PESAN')
								->setCellValue('P1', 'STATUS PESANAN');
								
					foreach($_POST['FppsList'] as $row)
					{
						$objPHPExcel->getActiveSheet()
									->setCellValue('A'.$fileRow,$row['no'])
									->setCellValue('B'.$fileRow,$row['nama_peap'])
									->setCellValue('C'.$fileRow,$row['jenis_id'])
									->setCellValue('D'.$fileRow,$row['no_id'].' ') // Force parse to string
									->setCellValue('E'.$fileRow,$row['nama_1'])
									->setCellValue('F'.$fileRow,$row['nama_2'])
									->setCellValue('G'.$fileRow,$row['alamat'])
									->setCellValue('H'.$fileRow,$row['kecamatan'])
									->setCellValue('I'.$fileRow,$row['kota'])
									->setCellValue('J'.$fileRow,$row['tanggal_id_expired']=='Seumur hidup'?'01/01/9999':$row['tanggal_id_expired'])
									->setCellValue('K'.$fileRow,$row['warganegara'])
									->setCellValue('L'.$fileRow,$row['status'])
									->setCellValue('M'.$fileRow,$row['partisipan'])
									->setCellValue('N'.$fileRow,$row['rekening_efek'])
									->setCellValue('O'.$fileRow,str_replace(',','',$row['jum_pesan']))
									->setCellValue('P'.$fileRow,$row['status_pesan']);
									
						//$objPHPExcel->getActiveSheet()->getStyle('D'.$fileRow)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
						
						$fileRow++;
					}
				}
				else 
				{
					$objPHPExcel->getActiveSheet()
								->setCellValue('A1', 'NO')
								->setCellValue('B1', 'NAMA PEAP')
								->setCellValue('C1', 'JENIS ID')
								->setCellValue('D1', 'NO ID')
								->setCellValue('E1', 'NAMA-1')
								->setCellValue('F1', 'NAMA-2')
								->setCellValue('G1', 'ALAMAT-1')
								->setCellValue('H1', 'ALAMAT-2')
								->setCellValue('I1', 'KOTA')
								->setCellValue('J1', 'TANGGAL LAHIR')
								->setCellValue('K1', 'WARGA NEGARA')
								->setCellValue('L1', 'PARTISIPAN')
								->setCellValue('M1', 'REKENING EFEK')
								->setCellValue('N1', 'JUMLAH PESAN')
								->setCellValue('O1', 'STATUS PESANAN');
								
					foreach($_POST['FppsList'] as $row)
					{
						$objPHPExcel->getActiveSheet()
									->setCellValue('A'.$fileRow,$row['no'])
									->setCellValue('B'.$fileRow,$row['nama_peap'])
									->setCellValue('C'.$fileRow,$row['jenis_id'])
									->setCellValue('D'.$fileRow,$row['no_id'].' ') // Force parse to string
									->setCellValue('E'.$fileRow,$row['nama_1'])
									->setCellValue('F'.$fileRow,$row['nama_2'])
									->setCellValue('G'.$fileRow,$row['alamat'])
									->setCellValue('H'.$fileRow,$row['kecamatan'])
									->setCellValue('I'.$fileRow,$row['kota'])
									->setCellValue('J'.$fileRow,$row['tanggal_lahir'])
									->setCellValue('K'.$fileRow,$row['warganegara'])
									->setCellValue('L'.$fileRow,$row['partisipan'])
									->setCellValue('M'.$fileRow,$row['rekening_efek'])
									->setCellValue('N'.$fileRow,str_replace(',','',$row['jum_pesan']))
									->setCellValue('O'.$fileRow,$row['status_pesan']);
						
						$fileRow++;
					}
				}
				
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save($excelFileName);
				
				if($model->format == 1)
				{
					$fileDownloadName = 'FPPS '.$model->stk_cd;
				}
				else 
				{
					$result = DAO::queryRowSql("SELECT SUBSTR(broker_cd,1,2) broker_cd FROM V_BROKER_SUBREK");
					$broker_cd = $result['broker_cd'];
					
					$fileDownloadName = $broker_cd.date('dm').$model->type.'00';
				}
					
				if(file_exists($excelFileName))
				{
					header('Content-Description: File Transfer');
				    header('Content-Type: application/vnd.ms-excel');
				    header('Content-Disposition: attachment; filename="'.$fileDownloadName.'.xls"');
				    header('Expires: 0');
				    header('Cache-Control: must-revalidate');
				    header('Pragma: public');
				    header('Content-Length: ' . filesize($excelFileName));
					ob_clean();
					flush();
				    readfile($excelFileName);
					unlink($excelFileName);
				} 
			}
		}
		else
		{
			$model->batch_opt = 1;
			$model->format = 1;
		}
		
		$this->render('index',array(
			'model' => $model,
			'modelRetrieve' => $modelRetrieve,
		));
	}
}