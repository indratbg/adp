<?php
class RptnilaibandingController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
		$model= new Rptnilaibanding('LIST_OF_NILAI_BANDING','R_NILAI_BANDING_ALL','Nilai_Banding_All.rptdesign');
		
		//$model->trans_date =date('d/m/Y');
		$url 	= "";
		$model->opt_clt = 0;
		$model->rpt_type = 0;
		
		if(isset($_POST['Rptnilaibanding'])){
			
			
			$model->attributes=$_POST['Rptnilaibanding'];
			if($model->opt_clt == 0)
			{
				$bgn_clt = '%';
				$end_clt = '_';
			}
			else {
				$bgn_clt = $model->clt_cd;
				$end_clt = $model->clt_cd;
			}
			
	
			// Nilai Banding List All Client
				if ($model->rpt_type == '0')
				{
					$model->tablename = 'R_NILAI_BANDING_ALL';
					$model->rptname = 'Nilai_Banding_All.rptdesign';
					if ($model->validate() && $model->executeRptAllClt($bgn_clt,$end_clt) > 0)
					{
						$rpt_link = $model->showReport();
						$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
						// $url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
					}
				}
	
				// Nilai Banding Detail By Client
				else 
				{
					$model->tablename = 'R_NILAI_BANDING_CLIENT';
					$model->rptname = 'Nilai_Banding_Client.rptdesign';
					if ($model->validate() && $model->executeRptSpecClt($bgn_clt,$end_clt) > 0)
					{
						$rpt_link = $model->showReport();
						$url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
						// $url_xls = $rpt_link . '&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false&#zoom=100';
					}
				}
	
			 /*

		 // Untuk Testing
		 $locale = '&__locale=in_ID';
		 $param 		  = '&ACC_TOKEN='.'XX'.'&ACC_USER_ID='.'IN'.'&RP_RANDOM_VALUE='.'1451153890';
		 $url   = Constanta::URL.$model->rptname.$locale.$param.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';

		 */
	
			
	
		}else{
			$model->month = date('n');
			$model->year = date('Y');
			$model->from_dt=date('01/m/Y');
			$model->to_dt=date('t/m/Y');
		}
		
		$this->render('index',array(
			'model'=>$model,
			'url'=>$url
		));
	}
	
	public function actionGetClient()
	{
		 $i=0;
	      $src=array();
	      $term = strtoupper($_REQUEST['term']);
	      $qSearch = DAO::queryAllSql("
					Select client_cd, client_name FROM MST_CLIENT 
					Where (client_cd like '".$term."%')
	      			AND susp_stat = 'N' AND client_type_1 <> 'B' AND custodian_cd IS NULL
	      			and client_type_3 in ('M','T')
	      			AND rownum <= 11
	      			ORDER BY client_cd
	      			");
	      
	      foreach($qSearch as $search)
	      {
	      	$src[$i++] = array('label'=>$search['client_cd'].' - '.$search['client_name']
	      			, 'labelhtml'=>$search['client_cd'].' - '.$search['client_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['client_cd']);
	      }
	      
	      echo CJSON::encode($src);
	      Yii::app()->end();
	}
	
}
?>