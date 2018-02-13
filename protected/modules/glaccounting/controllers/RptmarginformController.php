<?php
class RptmarginformController extends AAdminController
{

	public $layout = '//layouts/admin_column3';
	public function actionCheckTextFile()
	{
		$resp['status'] = 'error';
		if (isset($_POST['tanggal']))
		{
			$tanggal = $_POST['tanggal'];
			$user_id = Yii::app()->user->id;
			$sql = "select * from LAP_MARGIN_FORM_III_I_1 where report_date=to_date('$tanggal','dd/mm/yyyy') and user_id='$user_id' and approved_stat='A'";
			$cek = DAO::queryRowSql($sql);

			if ($cek)
				$resp['status'] = 'success';
		}
		echo json_encode($resp);
	}

	public function actionIndex()
	{
		$model = new Rptmarginform('MARGIN_FORM', 'LAP_MARGIN_FORM_III_I_1', 'Margin_form.rptdesign');
		$model->rpt_date = date('d/m/Y');
		$urlAll = '';
		$urlForm1 = '';
		$urlForm2 = '';
		$urlForm3 = '';

		if (isset($_POST['Rptmarginform']))
		{
			$model->attributes = $_POST['Rptmarginform'];
			$scenario = $_POST['scenario'];
			if ($scenario == 'print')
			{
				if ($model->validate() && $model->executeReportGenSp() > 0)
				{
					$model->tablename = 'LAP_MARGIN_FORM_III_I_1';
					$model->rptname = 'Formulir_III_I_1.rptdesign';
					$urlForm1 = $model->showReportStat($model->update_date, $model->update_seq) . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$model->tablename = 'LAP_MARGIN_FORM_III_I_2';
					$model->rptname = 'Formulir_III_I_2.rptdesign';
					$urlForm2 = $model->showReportStat($model->update_date, $model->update_seq) . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$model->tablename = 'LAP_MARGIN_FORM_III_I_3';
					$model->rptname = 'Formulir_III_I_3.rptdesign';
					$urlForm3 = $model->showReportStat($model->update_date, $model->update_seq) . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					$model->rptname = 'All_margin_form.rptdesign';
					$urlAll = $model->showReportStat($model->update_date, $model->update_seq) . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
			}
			else if ($scenario == 'saveText')
			{
				if ($model->validate())
					$this->GetTextFile($model->rpt_date);
			}

		}

		$this->render('index', array('model' => $model, 'urlAll' => $urlAll, 'urlForm1' => $urlForm1, 'urlForm2' => $urlForm2, 'urlForm3' => $urlForm3));

	}

	public function GetTextFile($rpt_date)
	{

		//FIND HEADER TEXT FILE
		$sql = "SELECT kode_ab,nama_prsh,to_char(report_date,'DD-MON-YY') report_date,TO_CHAR(REPORT_DATE,'YYYYMMDD') DATE_FILE FROM 
				LAP_MARGIN_FORM_III_I_1	WHERE REPORT_DATE='$rpt_date' AND APPROVED_STAT='A' and rownum<=1";
		$exec = DAO::queryRowSql($sql);
		//KODE AB
		$kode_ab = $exec['kode_ab'];
		//NAMA PERUSAHAAN
		$nama_prsh = $exec['nama_prsh'];
		//REPORT DATE
		$report_date = $exec['report_date'];
		//DATE FILENAME
		$date_file = $exec['date_file'];
		//DATA FORM 1
		$sql = "SELECT 'KODE EFEK'||'|'||STK_CD||'|'||SUM_AMT||'|'||CNT_MARGIN AS FORM_1 FROM LAP_MARGIN_FORM_III_I_1 
				where  REPORT_DATE='$rpt_date' AND APPROVED_STAT='A' AND STK_CD<>'HEADER' ORDER BY STK_CD";
		$form1 = DAO::queryAllSql($sql);
		//$form1 = $exec['form_1'];
		//SUM FORM 1
		$sql = "SELECT '|'||'TOTAL'||'|'||SUM(SUM_AMT)||'|'||SUM(CNT_MARGIN) AS TOTAL_form1 FROM LAP_MARGIN_FORM_III_I_1
				where  REPORT_DATE='$rpt_date' AND APPROVED_STAT='A' AND STK_CD<>'HEADER' ";
		$exec = DAO::queryRowSql($sql);
		$ttl_form_1 = $exec['total_form1'];
		//DATA FORM 2
		$sql = "SELECT 'JENIS KOLATERAL'||'|'||'SAHAM'||'|'||STK_CD||'|'||STK_VALUE||'|'||
				TRIM(TO_CHAR(STK_PERC,'99999990.99'))||'|'||CNT_MARGIN AS FORM_2 
				FROM LAP_MARGIN_FORM_III_I_2 where  REPORT_DATE='$rpt_date' AND APPROVED_STAT='A' AND STK_CD<>'HEADER' ORDER BY STK_CD";
		$form2 = DAO::queryAllSql($sql);
		//$form2 = $exec['form2'];
		$sql = "SELECT '|'||'TOTAL'||'|'||SUM(STK_VALUE)||'||'||TRIM(TO_CHAR(SUM(STK_PERC),'99999990.99'))||'|'||SUM(CNT_MARGIN)
				AS total_form2 FROM LAP_MARGIN_FORM_III_I_2 where  REPORT_DATE='$rpt_date' AND APPROVED_STAT='A' AND STK_CD<>'HEADER' ";
		$exec = DAO::queryRowSql($sql);
		$ttl_form_2 = $exec['total_form2'];
		//DATA FORM 3
		$sql = "SELECT 'ID-NASABAH'||'|'||CLIENT_CD||'|'||CL_TYPE||'|'||END_BAL||'|'||
			    TRIM(TO_CHAR(PERC_BAL,'99999990.99'))||'|'||AVG_STK||'|'||TRIM(TO_CHAR(M_RATIO,'99999990.99'))||'|'||
			    AVG1||'|'||AVG3||'|'||AVG6||'|'||TRIM(TO_CHAR(AVG_RATIO1,'99999990.99'))||'|'||TRIM(TO_CHAR(AVG_RATIO3,'99999990.99'))||'|'||
			    TRIM(TO_CHAR(AVG_RATIO6,'99999990.99'))  AS FORM_3
			    FROM LAP_MARGIN_FORM_III_I_3 where  REPORT_DATE='$rpt_date' AND APPROVED_STAT='A' AND CLIENT_CD<>'HEADER' order by client_Cd";
		$form3 = DAO::queryAllSql($sql);
		//$form3 = $exec['form_3'];
		$sql = "SELECT '|JUMLAH||'||SUM(END_BAL)||'|'||TRIM(TO_CHAR(SUM(PERC_BAL),'99999990.99'))||'|'||SUM(AVG_STK)||'|'||
			      TRIM(TO_CHAR(SUM(M_RATIO),'99999990.99'))||'|'||SUM(AVG1)||'|'||SUM(AVG3)||'|'||SUM(AVG6)||'|'||
			      TRIM(TO_CHAR(SUM(AVG_RATIO1),'99999990.99'))||'|'||TRIM(TO_CHAR(SUM(AVG_RATIO3),'99999990.99'))||'|'||
			      TRIM(TO_CHAR(SUM(AVG_RATIO6),'99999990.99'))
			    AS TTL_FORM3
			    FROM LAP_MARGIN_FORM_III_I_3 where  REPORT_DATE='$rpt_date' AND APPROVED_STAT='A' AND CLIENT_CD<>'HEADER' ";
		$exec = DAO::queryRowSql($sql);
		$ttl_form_3 = $exec['ttl_form3'];
		//EXPOSURE
		$sql = "SELECT 'TOTAL EXPOSURE|'||SUM(EXP50)||'|'||SUM(EXP65)||'|'||SUM(EXP80)||'|'||SUM(EXP_GREATER_80) AS TTL_EXP
				FROM (
				SELECT NVL(SUM(END_BAL),0) EXP50, 0 EXP65, 0 EXP80, 0 EXP_GREATER_80
				FROM LAP_MARGIN_FORM_III_I_3
				WHERE M_RATIO<50 and REPORT_DATE='$rpt_date' AND APPROVED_STAT='A' AND CLIENT_CD<>'HEADER'
				UNION ALL
				SELECT 0 EXP50, NVL(SUM(END_BAL),0) EXP65, 0 EXP80, 0 EXP_GREATER_80
				FROM LAP_MARGIN_FORM_III_I_3
				WHERE M_RATIO >50 AND M_RATIO<65 and REPORT_DATE='$rpt_date' AND APPROVED_STAT='A' AND CLIENT_CD<>'HEADER'
				UNION ALL
				SELECT 0 EXP50, 0 EXP65,NVL(SUM(END_BAL),0) EXP80, 0 EXP_GREATER_80
				FROM LAP_MARGIN_FORM_III_I_3
				WHERE M_RATIO >65 AND M_RATIO<80 and REPORT_DATE='$rpt_date' AND APPROVED_STAT='A' AND CLIENT_CD<>'HEADER'
				UNION ALL
				SELECT 0 EXP50, 0 EXP65, 0 EXP80, NVL(SUM(END_BAL),0) EXP_GREATER_80
				FROM LAP_MARGIN_FORM_III_I_3
				WHERE M_RATIO>80 and REPORT_DATE='$rpt_date' AND APPROVED_STAT='A' AND CLIENT_CD<>'HEADER'
				)";
		$exec = DAO::queryRowSql($sql);
		$ttl_exposure = $exec['ttl_exp'];

		$file_name = $kode_ab . '-MARJIN' . $date_file . '.MJN';
		$file = fopen("upload/form_margin/$file_name", "w");
		fwrite($file, "LAPORAN MARJIN\r\n");
		fwrite($file, "NAMA AB|$nama_prsh|\r\n");
		fwrite($file, "KODE AB|$kode_ab|\r\n");
		fwrite($file, "TANGGAL|$report_date|\r\n");
		fwrite($file, "FORMULIR III-I.1\r\n");
		fwrite($file, "RINGKASAN DATA EXPOSURE\r\n");
		foreach ($form1 as $row)
		{
			$text = $row['form_1'];
			fwrite($file, "$text\r\n");
		}
		fwrite($file, "$ttl_form_1\r\n");
		fwrite($file, "FORMULIR III-I.2\r\n");
		foreach ($form2 as $row)
		{
			$text = $row['form_2'];
			fwrite($file, "$text\r\n");
		}

		if (count($form2) == 0)
		{
			fwrite($file, "|JUMLAH|0||0.00|0\r\n");
		}
		else
		{
			fwrite($file, "$ttl_form_2\r\n");
		}
		fwrite($file, "FORMULIR III-I.3\r\n");
		foreach ($form3 as $row)
		{
			$text = $row['form_3'];
			fwrite($file, "$text\r\n");
		}
		fwrite($file, "$ttl_form_3\r\n");
		fwrite($file, "MARJIN RASIO|MR < 50%|50 % < MR < 65 %|65 % < MR < 80 %|MR > 80 %\r\n");
		fwrite($file, "$ttl_exposure\r\n");
		fwrite($file, "FORMULIR III-I.4\r\n");
		fwrite($file, "KODE EFEK|||||||\r\n");

		fclose($file);

		//DOWNLOAD FILE REP
		$filename = "upload/form_margin/$file_name";
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Length: " . filesize("$filename") . ";");
		header("Content-Disposition: attachment; filename=$file_name");
		header("Content-Type: application/octet-stream; ");
		header("Content-Transfer-Encoding: binary");
		ob_clean();
		flush();
		readfile($filename);
		unlink("upload/form_margin/$file_name");
		exit ;

	}

}
