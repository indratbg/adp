<?php
class RptrepoharianController extends AAdminController
{

	public $layout = '//layouts/admin_column3';

	public function actionIndex()
	{
		$model = new Rptrepoharian('REPO_HARIAN', 'R_REPO_HARIAN', 'Repo_harian.rptdesign');
		$model->rpt_date = date('d/m/Y');
		$url = '';
		$save_flg='Y';
		if (isset($_POST['Rptrepoharian']))
		{
			$model->attributes = $_POST['Rptrepoharian'];

			if ($model->validate() && $model->executeReportGenSp() > 0)
			{
				$url = $model->showReport() . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
			}
		}
		$cek = Vrepoharian::model()->findAll("rand_value= '$model->vo_random_value' ");
		if(!$cek)$save_flg='N';
		$this->render('index', array(
			'model' => $model,
			'url' => $url,
			'save_flg'=>$save_flg
		));

	}

	public function actionGetTextFile($rand_value)
	{
		$cek = Vrepoharian::model()->findAll("rand_value= '$rand_value' ");
		
		if (!$cek)
		{
			Yii::app()->user->setFlash('danger', 'No data found to save text file');
			$this->redirect(array('index'));
		}
		else
		{

			//$date = date('Ymd');
			//nama perusahaan
			$nama_prsh = Company::model()->find()->nama_prsh;
			//KODE AB
			$kode_ab = Vrepoharian::model()->find("rand_value= '$rand_value' ")->kode_ab;
			//Tanggal
			$tanggal = Vrepoharian::model()->find("rand_value= '$rand_value'")->report_date;
			$tanggal = strtoupper(DateTime::createFromFormat('Y-m-d H:i:s', $tanggal)->format('d-M-y'));
			$date = Vrepoharian::model()->find("rand_value= '$rand_value'")->report_date;
			$date = DateTime::createFromFormat('Y-m-d H:i:s', $date)->format('Ymd');
			//DIREKTUR
			$direktur = Company::model()->find()->contact_pers;
			//REPO
			$data1 = Vrepoharian::model()->findAll("rand_value= '$rand_value' and repo_type='1' ");
			$data2 = Vrepoharian::model()->findAll("rand_value= '$rand_value' and repo_type='2' ");

			$file_name = $kode_ab . '-REPO' . $date . '.REP';
			$file = fopen("upload/repo_harian/$file_name", "w");
			fwrite($file, "LAPORAN REPO\r\n");
			fwrite($file, "NAMA AB|$nama_prsh||\r\n");
			fwrite($file, "KODE AB|$kode_ab||\r\n");
			fwrite($file, "TANGGAL|$tanggal||\r\n");
			fwrite($file, "DIREKTUR|$direktur||\r\n");
			fwrite($file, "EFEK BELI\r\n");
			$repo_num =array();
			$x=0;
			foreach ($data1 as $row)
			{
				$repo_date = strtoupper(DateTime::createFromFormat('Y-m-d H:i:s', $row->extent_dt)->format('d-M-y'));
				$due_date = strtoupper(DateTime::createFromFormat('Y-m-d H:i:s', $row->due_date)->format('d-M-y'));
				$agunan = $row->agunan_prc;
				$amt = $row->sum_amt;
				$repo_num[$x]= $row->repo_num;
		
				if(count($data1)>1 && $x>0)
				{
					if($repo_num[$x-1] == $row->repo_num)
					{
						$agunan = '';
						$amt = '';
					}
				
				}
				
				fwrite($file, "KODE EFEK|$row->stk_cd|$row->sum_qty|$row->stk_price|||$agunan|$amt|$row->days|$repo_date|$due_date|$row->lawan\r\n");
				$x++;
			}
			fwrite($file, "EFEK JUAL\r\n");
			$repo_num =array();
			$x=0;
			foreach ($data2 as $row)
			{
				$repo_date = strtoupper(DateTime::createFromFormat('Y-m-d H:i:s', $row->repo_date)->format('d-M-y'));
				$due_date = strtoupper(DateTime::createFromFormat('Y-m-d H:i:s', $row->due_date)->format('d-M-y'));
				$agunan = $row->agunan_prc;
				$repo_num[$x]= $row->repo_num;
		
				if(count($data2)>1 && $x>0)
				{
					if($repo_num[$x-1] == $row->repo_num)
					{
						$agunan = '';
						$amt = '';
					}
				
				}
				fwrite($file, "KODE EFEK|$row->stk_cd|$row->sum_qty|$row->stk_price|||$agunan|$amt|$row->days|$repo_date|$due_date|$row->lawan\r\n");
			}
			fclose($file);

			//DOWNLOAD FILE REP
			$filename = "upload/repo_harian/$file_name";
			header("Cache-Control: public");
			header("Content-Description: File Transfer");
			header("Content-Length: " . filesize("$filename") . ";");
			header("Content-Disposition: attachment; filename=$file_name");
			header("Content-Type: application/octet-stream; ");
			header("Content-Transfer-Encoding: binary");
			ob_clean();
			flush();
			readfile($filename);
			unlink("upload/repo_harian/$file_name");
			exit ;
		}//end save text file if existing
	}

}
