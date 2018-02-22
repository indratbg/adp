<?php
class GeniposecujournalController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';

public function actionIndex(){
	
	$modelfilter = new Tpee;
	$cek_date = Sysparam::model()->find("param_id='IPO' and param_cd1='START'")->ddate1;
	$sql="SELECT a.STK_CD, a.DISTRIB_DT_FR, A.DISTRIB_DT_TO,STK_NAME,a.price,
						 CASE WHEN a.DISTRIB_DT_FR  < '$cek_date' or   B.jurnal_distribdt is not null THEN 'Y'  
            ELSE  'N' END jurnal_distribdt
					FROM( SELECT STK_CD, DISTRIB_DT_FR, DISTRIB_DT_TO, 
						   STK_NAME,	DISTRIB_DT_FR as jur_distrib_dt,price,stk_cd_ksei
						FROM T_PEE
						WHERE DISTRIB_DT_FR >= (TRUNC(SYSDATE) - 40)
          AND       approved_stat = 'A' ) a,
					( SELECT DISTINCT stk_Cd, doc_dt AS jurnal_distribdt	
					FROM T_STK_MOVEMENT	
					WHERE doc_dt >= (TRUNC(SYSDATE) - 40) 	
           AND    doc_stat = '2'	
					and jur_type ='IPO'
					AND seqno = 1) b
					WHERE a.stk_cd_ksei = b.stk_cd(+)		
					AND a.jur_distrib_dt = b.jurnal_distribdt(+) 
				order by  a.distrib_dt_fr desc ";
	$model = Tpee::model()->findAllBySql($sql);
	if(isset($_POST['Tpee']))
	{	$modelfilter->attributes = $_POST['Tpee'];
		if(DateTime::createFromFormat('d/m/Y',$modelfilter->distrib_dt_fr))$modelfilter->distrib_dt_fr = DateTime::createFromFormat('d/m/Y',$modelfilter->distrib_dt_fr)->format('Y-m-d');
		if($modelfilter->stk_cd_temp != "" || $modelfilter->stk_cd_ksei != ""){
		
		$sql="SELECT * FROM (SELECT a.STK_CD, a.DISTRIB_DT_FR, A.DISTRIB_DT_TO,STK_NAME,a.price,	
					 CASE WHEN a.DISTRIB_DT_FR  < '$cek_date' or   B.jurnal_distribdt is not null THEN 'Y'  
            ELSE  'N' END jurnal_distribdt
					FROM(
						 SELECT STK_CD, DISTRIB_DT_FR, DISTRIB_DT_TO, 
						 STK_NAME,	DISTRIB_DT_FR as jur_distrib_dt, price, stk_cd_ksei
						FROM T_PEE
						WHERE
	          			
	          			 approved_stat = 'A' ) a,
					( SELECT DISTINCT stk_Cd, doc_dt AS jurnal_distribdt	
					FROM T_STK_MOVEMENT	
					WHERE 
		          	 
		          	 doc_stat = '2'	
					and jur_type ='IPO'
					AND seqno = 1) b
						WHERE a.stk_cd_ksei = b.stk_cd(+)		
						AND a.jur_distrib_dt = b.jurnal_distribdt(+) 
						order by a.distrib_dt_fr desc)
					WHERE STK_CD = '$modelfilter->stk_cd_temp' or stk_cd = '$modelfilter->stk_cd_ksei' 
					order by distrib_dt_fr desc";
		}
		else if($modelfilter->distrib_dt_fr !='')
		{
			//echo "<script>alert('test')</script>";		
			$sql="SELECT * FROM (SELECT a.STK_CD, a.DISTRIB_DT_FR, A.DISTRIB_DT_TO,STK_NAME,a.price,	
						 CASE WHEN a.DISTRIB_DT_FR  < '$cek_date' or   B.jurnal_distribdt is not null THEN 'Y'  
            ELSE  'N' END jurnal_distribdt
					FROM(
						 SELECT STK_CD, DISTRIB_DT_FR, DISTRIB_DT_TO, price,
						 STK_NAME,	DISTRIB_DT_FR as jur_distrib_dt, stk_cd_ksei
						FROM T_PEE
						WHERE DISTRIB_DT_FR >= to_date('$modelfilter->distrib_dt_fr','yyyy-mm-dd')
	          			AND approved_stat = 'A' ) a,
					( SELECT DISTINCT stk_Cd, doc_dt AS jurnal_distribdt	
					FROM T_STK_MOVEMENT	
					WHERE doc_dt >= to_date('$modelfilter->distrib_dt_fr','yyyy-mm-dd')
		          	AND  doc_stat = '2'	
					and jur_type ='IPO'
					AND seqno = 1) b
						WHERE a.stk_cd_ksei = b.stk_cd(+)		
						AND a.jur_distrib_dt = b.jurnal_distribdt(+) 
						order by distrib_dt_fr desc) ";
		}
			$model = Tpee::model()->findAllBySql($sql);
	}
	else
	{
	$modelfilter->distrib_dt_fr = date('d/m/Y',strtotime('-40 days'));
	
	}
	if(DateTime::createFromFormat('Y-m-d',$modelfilter->distrib_dt_fr))$modelfilter->distrib_dt_fr=DateTime::createFromFormat('Y-m-d',$modelfilter->distrib_dt_fr)->format('d/m/Y');
	foreach($model as $row)
	{
	if(DateTime::createFromFormat('Y-m-d H:i:s',$row->distrib_dt_fr))$row->distrib_dt_fr=DateTime::createFromFormat('Y-m-d H:i:s',$row->distrib_dt_fr)->format('d/m/Y');
	}
	$this->render('index',array('model'=>$model,'modelfilter'=>$modelfilter));
}


public function actionPilih($stk_cd, $stk_cd_ksei,$distrib_dt_fr, $jurnal_distribdt)
{					
		$model = new Rptgeniposecujournal('GENERATE_IPO_SECURITIES_JOURNAL','R_GEN_IPO_SECU_JUR','Gen_ipo_secu_jur.rptdesign');			
		$url='';
		//$model->stk_cd = $stk_cd;
		$model->stk_cd_ksei =$stk_cd_ksei;
		$model->stk_cd_temp = $stk_cd;
		$success= false;	
		if($model->validate() && $model->executeSpRpt()>0){
			$url = $model->showReport().'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
		}
		
		if(isset($_POST['Rptgeniposecujournal'])){
			$model->attributes = $_POST['Rptgeniposecujournal'];
			$model->scenario='generate';

			$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			$model->ip_address = $ip;
			if($model->validate() && $model->executeSp()>0){
				$success =true;
			}
			
			if($success){
				Yii::app()->user->setFlash('success', 'Successfully Generate IPO Securities Journal');	
				$this->redirect(array('index'));
			}
		
		}
		
		
	$this->render('_report',array('model'=>$model,'url'=>$url,'jurnal_distribdt'=>$jurnal_distribdt));
}
	
}
	?>