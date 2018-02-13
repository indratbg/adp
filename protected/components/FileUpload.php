<?php
class FileUpload 
{
	const IMPORT_REK_DANA = 1;
	const SDI_FILE_XML = 2;
	const UPLOAD_STK_CLOSE_PRICE = 3;
	const BEJ_TRS_HEADER = 4;
	const T_IPO_CLIENT = 5;
	const T_BANK_MUTATION = 6;
	const T_JVCH=7;
	const T_PAYRECH=8;
	const T_DHK=9;
	const T_BANK_STMT=10;
	const UPLOAD_T_HIGHRISK_NAME=11;
	const UPLOAD_STOCK_BALANCE=12;
	const RECONCILE_PORTO = 13;
	const IMPORT_BANK_BALANCE = 14;
	const UPLOAD_SUBREK = 15;
	const UPLOAD_HAIRCUT_MKBD =16;
	/***
	 * Untuk dapatin file path untuk upload file. "C:\xampp\htdocs\del\upload\foto\file.ext"
	 * @param String $fileName filename dan extention dari file yang mau di upload
	 * @param String $constPath variable constant yang ada diatas
	 * @return String a Complete upload path for file upload.
	 */
	public static function getFilePath($constPath,$fileName) 
	{
		$pathFile = '';
		$pathFile = Yii::app()->basePath.''.$fileName;
		switch($constPath) {
			case FileUpload::IMPORT_REK_DANA:
				$pathFile = Yii::app()->basePath.'/../upload/rek_dana/'.$fileName;
				break;
			case FileUpload::SDI_FILE_XML:
				$pathFile = Yii::app()->basePath.'/../upload/sdi_xml/'.$fileName;
				break;
			case FileUpload::UPLOAD_STK_CLOSE_PRICE:
				$pathFile = Yii::app()->basePath.'/../upload/upload_stk_close_price/'.$fileName;
				break;
			case FileUpload::BEJ_TRS_HEADER:
				$pathFile = Yii::app()->basePath.'/../upload/bej_trs_header/'.$fileName;
				break;
			case FileUpload::T_IPO_CLIENT:
				$pathFile = Yii::app()->basePath.'/../upload/stock_ipo_client/'.$fileName;
				break;
			case FileUpload::T_BANK_MUTATION:
				$pathFile = Yii::app()->basePath.'/../upload/mutasi_rdi/'.$fileName;
				break;
			case FileUpload::T_JVCH:
				$pathFile = Yii::app()->basePath.'/../upload/gl_jurnal/'.$fileName;
				break;
			case FileUpload::T_PAYRECH:
				$pathFile = Yii::app()->basePath.'/../upload/upload_voucher/'.$fileName;
				break;
			case FileUpload::T_DHK:
				$pathFile = Yii::app()->basePath.'/../upload/reconcile/'.$fileName;
				break;
			case FileUpload::T_BANK_STMT:
				$pathFile = Yii::app()->basePath.'/../upload/reconcile/'.$fileName;
				break;
			case FileUpload::UPLOAD_T_HIGHRISK_NAME:
				$pathFile = Yii::app()->basePath.'/../upload/highrisk/'.$fileName;
				break;
			case FileUpload::UPLOAD_STOCK_BALANCE:
				$pathFile = Yii::app()->basePath.'/../upload/upload_stk_balance/'.$fileName;
				break;
			case FileUpload::RECONCILE_PORTO:
				$pathFile = Yii::app()->basePath.'/../upload/reconcile_porto/'.$fileName;
				break;
			case FileUpload::IMPORT_BANK_BALANCE:
				$pathFile = Yii::app()->basePath.'/../upload/bank_balance/'.$fileName;
				break;	
			case FileUpload::UPLOAD_SUBREK:
				$pathFile = Yii::app()->basePath.'/../upload/subrek/'.$fileName;
				break;	
			case FileUpload::UPLOAD_HAIRCUT_MKBD:
				$pathFile = Yii::app()->basePath.'/../upload/haircut_mkbd/'.$fileName;
				break;	
		}
		return $pathFile;
	}
	
	
	/**
	 * 
	 * Digunakan untuk mencari path file yang sudah di upload.
	 * @param String $const 
	 * @param String $file_name nama file yang akan di download
	 * NOTE : Return String berisi path file
	 */	
	public static function getHttpPath($const,$file_name)
	{
		$path = '';
		switch ($const) {
			case FileUpload::SDI_FILE_XML:
				$path = Yii::app()->request->hostInfo . Yii::app()->request->baseURL .'/upload/sdi_xml/'. $file_name;
				break;
		}
		return $path;
	}
}