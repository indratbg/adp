<?php

class RptcashdividenhistoryController extends AAdminController
{
	
	public $layout='//layouts/admin_column3';
	
public function actionGetclient()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_REQUEST['term']);
      $qSearch = DAO::queryAllSql("
				select a.cifs, a.cif_name from mst_cif a, mst_client b where 
				a.cifs=b.client_cd 
				and b.susp_stat='N'
				and a.cif_name like '".$term."%'
				and rownum<31
				and a.approved_stat='A'
				order by a.cifs

      			"); 
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['cifs']. ' - '.$search['cif_name']
      			, 'labelhtml'=>$search['cif_name']
      			, 'value'=>$search['cifs']. ' - '.$search['cif_name']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }
	
	
	public function actionIndex()
    {
    	$model = new Rptcashdividenhistory('CASH_DIVIDEN_HISTORY','R_CASH_DIVIDEN_HIST','Cash_dividen_history.rptdesign');
		$sql = "select  stk_cd, stk_cd||'-'||stk_desc stk_desc from mst_counter where approved_stat='A' order by stk_cd";
		$list_stk_cd = Counter::model()->findAllBySql($sql); 
		$url = '';
		$date = date('Y-m-d');
		$model->bgn_date = date('01/01/Y', strtotime("$date - 1 year"));
		$model->end_date = date('31/12/Y',strtotime("$date - 1 year"));
		$model->stk_option = 0;
		$model->client_option=0;
		if(isset($_POST['Rptcashdividenhistory']))
		{
			$model->attributes = $_POST['Rptcashdividenhistory'];
			if($model->validate())
			{
				
				if($model->stk_option =='0')
				{
					$stk_cd ='A';
				}
				else {
					$stk_cd =$model->stk_cd;
				}
				if($model->client_option =='0')
				{
					$client_cd = 'A';	
				}
				else
				{
					$client_cd =substr($model->client_cd,0,8);
				}	
				//branch
				$branch_cd= $model->branch_cd?$model->branch_cd:'%';
				
				if($model->executeRpt($stk_cd, $client_cd, $branch_cd)>0)
				{
					$url = $model->showReport().'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
				}
				
			}
		}
		
		if(DateTime::createFromFormat('Y-m-d',$model->bgn_date)) $model->bgn_date = DateTime::createFromFormat('Y-m-d',$model->bgn_date)->format('d/m/Y');
		if(DateTime::createFromFormat('Y-m-d',$model->end_date)) $model->end_date = DateTime::createFromFormat('Y-m-d',$model->end_date)->format('d/m/Y');
	
		
		$this->render('index',array('model'=>$model,
									'url'=>$url,
									'stk_cd'=>$list_stk_cd));
	}
}
?>