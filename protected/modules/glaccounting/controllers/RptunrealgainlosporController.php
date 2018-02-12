<?php
class RptunrealgainlosporController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
		$model= new Rptunrealgainlospor('LIST_OF_UNREAL_GAIN_LOSS_PORTO','R_UNREAL_GAIN_LOSS_PORTO','Unreal_Gain_Loss_Porto.rptdesign');
		
		//$model->trans_date =date('d/m/Y');
		$url 	= "";
		// $sql1="SELECT ACCT_CD, ACCT_NAME, MKBD_CD FROM MST_FUND_ACCT order by mkbd_cd";
		// $macct_cd= Fundacct::model()->findAllBySql($sql1);
		
		if(isset($_POST['Rptunrealgainlospor'])){
			
			
			$model->attributes=$_POST['Rptunrealgainlospor'];
			
			if($model->client_opt=='0')
			{
				$client_cd = '%';
				$client_cd1 = '_';
			}
			else 
			{
				$client_cd = $model->client_cd;
				$client_cd1 = $model->client_cd;
			}
			
			if($model->validate() && $model->executeRpt($client_cd, $client_cd1)>0  ){
				$url = $model->showReport().'&__showtitle=false&__format=pdf';
			}
	
		}else{
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