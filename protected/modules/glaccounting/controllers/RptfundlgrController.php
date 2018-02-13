<?php
class RptfundlgrController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
		$model= new Rptfundlgr('LIST_OF_FUND_LGR','R_FUND_LEDGER_FL','Fund_ledger.rptdesign');
		
		//$model->trans_date =date('d/m/Y');
		$url 	= "";
		$option=array('NPR','PE','UMUM','ALL');
		
		$sqlFlacct = "SELECT ACCT_CD, ACCT_NAME, MKBD_CD FROM MST_FUND_ACCT order by mkbd_cd";
		$sqlSl_a = "SELECT trim(sl_a) AS bank_cd, acct_name FROM mst_gl_account g, ( select gl_a from mst_gla_trx where jur_type = 'BANKOP' or jur_type = 'KAS') b WHERE g.gl_a = b.gl_A and g.sl_a <> '000000' ORDER BY g.sl_a";
		$sqlGl_a = "select gl_a from mst_gla_trx where (jur_type = 'BANKOP' or jur_type = 'KAS') order by gl_a";
		
		$mFlacct = Fundacct::model()->findAllBySql($sqlFlacct);
		$mSl_a = Glaccount::model()->findAllBySql($sqlSl_a);
		$mGl_a = Glaccount::model()->findAllBySql($sqlGl_a);
		
		if(isset($_POST['Rptfundlgr'])){
			
			
			$model->attributes=$_POST['Rptfundlgr'];
			//$model->val_client_cd=($model->selected_opt!=4)?$option[$model->selected_opt]:$model->client_cd;
			
			if($model->opt==0){
				if($model->acct_cd==1){
					$p_acct_cd='%';
				}else{
					$p_acct_cd=$model->val_acct_cd;
				}
				
				if($model->client_cd==1){
					$p_client_cd='%';
				}else{
					$p_client_cd=$model->val_client_cd;
				}
				
				if($model->validate() && $model->executeReportNpr($p_acct_cd,$p_client_cd)>0  ){
					$url = $model->showReport().'&__showtitle=false&__format=pdf';	
				}
			}
	
		}else{
			$model->selected_opt=0;
			$model->month = date('n');
			$model->year = date('Y');
			$model->from_dt=date('01/m/Y');
			$model->to_dt=date('t/m/Y');
		}
		
		$this->render('index',array(
			'model'=>$model,
			'url'=>$url,
			'mFlacct'=>$mFlacct,
			'mSl_a'=>$mSl_a,
			'mGl_a'=>$mGl_a
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