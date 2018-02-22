<?php
class RptfundlgrtbController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
		$model= new Rptfundlgrtb('LIST_OF_FUND_LGR_JUR','R_TRIAL_BALANCE_FUND_LEDGER','Trial_Balance_Fund_ledger.rptdesign');
		
		//$model->trans_date =date('d/m/Y');
		$url 	= "";
		$sql1="SELECT ACCT_CD, ACCT_NAME, MKBD_CD FROM MST_FUND_ACCT order by mkbd_cd";
		$macct_cd= Fundacct::model()->findAllBySql($sql1);
		
		if(isset($_POST['Rptfundlgrtb'])){
			
			
			$model->attributes=$_POST['Rptfundlgrtb'];
			
			if($model->validate() && $model->executeReportGenSp()>0  ){
				$url = $model->showReport().'&__showtitle=false&__format=pdf';
			}
	
		}else{
			$model->month = date('n');
			$model->year = date('Y');
			$model->from_dt=date('01/m/Y');
			$model->to_dt=date('t/m/Y');
		}
		
		$this->render('index',array(
			'model'=>$model,
			'macct_cd'=>$macct_cd,
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