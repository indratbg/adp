<?php

class Rptmkbdvd55xe13Controller extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	public function actionIndex()
	{
		
		$model = new Rptmkbdvd55xe13('MKBD_VD55_XE13','R_MKBD_VD55_XE13','MKBD_vd55_xe13.rptdesign');
		$date = date('Y-m-d',strtotime(date('Y-m-d')." -1 month"));
		$model->doc_date = $this->getLastBourseDay($date);
		//$model->doc_date=date('29/04/Y');
		$url='';
		$url_xls='';
		if(isset($_POST['Rptmkbdvd55xe13']))
		{
			$model->attributes = $_POST['Rptmkbdvd55xe13'];
		
			if($model->validate() && $model->executeRpt()>0)
			{
				$rpt_link =$model->showReport();
				$url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				$url_xls = $rpt_link.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
			}
		}
		if(DateTime::createFromFormat('Y-m-d',$model->doc_date))$model->doc_date =DateTime::createFromFormat('Y-m-d',$model->doc_date)->format('d/m/Y'); 
		
		$this->render('index',array('model'=>$model,
									'url'=>$url,
									'url_xls'=>$url_xls,
									'rand_value'=>$model->vo_random_value,
									'user_id'=>$model->vp_userid));
	}
	
	
	public function actionGetTextFile($rand_value, $user_id)
	{
			
				$kode_ab = substr(Vbrokersubrek::model()->find()->broker_cd,0,2);
				
				$sql = "select to_char(to_date(txt0,'dd/mm/yy'),'yymm') txt_date from insistpro_rpt.R_MKBD_VD55_XE13 
						where rand_value='$rand_value' and user_id='$user_id' and mkbd_cd=3";
				$exec = DAO::queryRowSql($sql);
				$file_name = $kode_ab.$exec['txt_date'];
				$file_name	= $file_name.'.MKB';
				$file = "upload/mkbdxe13/$file_name";
				$handle = fopen($file,'wb');
				
			if($exec)
			{	
				
				$sql_txt ="select 1 mkbd_cd,'Kode AB|'||lower(substr(broker_cd,1,2))||'||' txt from v_broker_subrek
							union all
							select 2 mkbd_cd,'Tanggal|'||to_char(to_date(txt0,'dd/mm/yy'),'yyyymmdd')||'||' txt from insistpro_rpt.R_MKBD_VD55_XE13 
							where rand_value='$rand_value' and user_id='$user_id' and mkbd_cd=3
							union all
							select 4 mkbd_cd,'Direktur|'||contact_pers||'||' from mst_company
							union all
							select mkbd_cd,'XE13.'||mkbd_cd||'|'||TRIM(TO_CHAR(affil_f,'99999999999999999999999999990.99'))||'|'||
							trim(TO_CHAR(affil_l,'99999999999999999999999999990.99'))||'|'||trim(TO_CHAR(nonaffil_f,'99999999999999999999999999990.99'))||'|'||
							trim(TO_CHAR(nonaffil_l,'99999999999999999999999999990.99'))||'|'||trim(TO_CHAR(sum_amt,'99999999999999999999999999990.99')) txt from insistpro_rpt.R_MKBD_VD55_XE13
							where rand_value='$rand_value' and user_id='$user_id' and mkbd_cd between 7 and 24 and  mkbd_cd not in (10,13,20)
							union all
							select mkbd_cd,'XE13.'||mkbd_cd||'|||||'||trim(TO_CHAR(sum_amt,'99999999999999999999999999990.99')) txt from insistpro_rpt.R_MKBD_VD55_XE13
							where rand_value='$rand_value' and user_id='$user_id' and mkbd_cd in (10,13,20)
							union all
							select mkbd_cd,'XE13.'||mkbd_cd||'|||'||qty1||'|'||qty2||'|'||tot_qty txt from insistpro_rpt.R_MKBD_VD55_XE13
							where rand_value='$rand_value' and user_id='$user_id' and mkbd_cd between 26 and 37 and mkbd_cd <>36
							union all
							select mkbd_cd,'XE13.'||mkbd_cd||'|||||'||trim(to_char(tot_qty,'99999999999999999999999999990.99')) txt from insistpro_rpt.R_MKBD_VD55_XE13
							where rand_value='$rand_value' and user_id='$user_id' and mkbd_cd between 38 and 39
							union all
							select mkbd_cd,'XE13.'||mkbd_cd||'|'||to_char(tanggal,'yyyymmdd')||'||||' txt from insistpro_rpt.R_MKBD_VD55_XE13
							where rand_value='$rand_value' and user_id='$user_id' and mkbd_cd between 41 and 44
							union all
							select mkbd_cd,'XE13.'||mkbd_cd||'|||'||qty1||'|'||qty2||'|'||tot_qty txt from insistpro_rpt.R_MKBD_VD55_XE13
							where rand_value='$rand_value' and user_id='$user_id' and mkbd_cd =46
							order by mkbd_cd";
				$text_file = DAO::queryAllSql($sql_txt);
				
					foreach($text_file as $row)
					{
						fwrite($handle, ' '.$row['txt']."\r\n");	
					}
				}
				fclose($handle);
				
			
				//DOWNLOAD FILE LTH
				$filename = "upload/mkbdxe13/$file_name";
				header("Cache-Control: public");
				header("Content-Description: File Transfer");
				header("Content-Length: ". filesize("$file").";");
				header("Content-Disposition: attachment; filename=$file_name");
				header("Content-Type: application/octet-stream; "); 
				header("Content-Transfer-Encoding: binary");
				ob_clean();
		        flush();
				readfile($filename);
				unlink("upload/mkbdxe13/$file_name");
				exit;
	}
	
	public function getLastBourseDay($date)
	{
		$sql="select F_LAST_BOURSE_DAY(to_date('$date','yyyy-mm-dd')) as ls_date from dual";
		$exec =DAO::queryRowSql($sql);
		$date = $exec['ls_date'];
		if(DateTime::createFromFormat('Y-m-d H:i:s',$date))$date = DateTime::createFromFormat('Y-m-d H:i:s',$date)->format('d/m/Y'); 
		
		return $date;
	}
}