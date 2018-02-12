<?php
class ProcessavgprcController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
			
		$model= new Processavgprc ;
		$model->client_search_md="S";
		$model->stock_search_md="S";
		
		
		$model->from_dt = date('d/m/Y');
        $model->to_dt = date('d/m/Y');
		
		//utk test 
		//$model->from_dt = date('03/02/2014');
		//$model->to_dt = date('06/02/2014');
		
		
		$flag=(isset($_GET['flag']))?$_GET['flag']:'N';	
		
		if(isset($_POST['Processavgprc'])){
			
			$model->attributes=$_POST['Processavgprc'];
			
			$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			$model->ip_address = $ip;
			
			$valid=$model->validate();
			
			$model->client_beg=($model->client_search_md=='A')?"%":$model->client_cd;
			$model->client_end=($model->client_search_md=='A')?"_":$model->client_cd;
			
			$model->stock_beg=($model->stock_search_md=='A')?"%":$model->stock_cd;
			$model->stock_end=($model->stock_search_md=='A')?"_":$model->stock_cd;
			
			//utk test
			//$valid=false;
			
			if($valid){
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();		
				
				$res=$model->executeSp();
				
				if($res>0){
					 $transaction->commit();
					
					$clientMsg=($model->client_search_md=='A')?"ALL":$model->client_cd;
					$stockMsg=($model->stock_search_md=='A')?"ALL":$model->stock_cd;
			
					Yii::app()->user->setFlash('success', 'Process Average Price from : '.$model->from_dt.' to '.$model->to_dt.', Client: '.$clientMsg.' ,Stock: '.$stockMsg.'.');
					
					 $this->redirect(array('index','flag'=>'Y'));
				}else{
					 $transaction->rollback();
				}
			}
			
		}
		
		$this->render('index',array(
			'model'=>$model,
			'flag'=>$flag
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
	
	public function actionGetStock()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_POST['term']);
      $qSearch = DAO::queryAllSql("
				SELECT STK_CD FROM MST_COUNTER 
				WHERE STK_CD LIKE '".$term."%'
				AND ROWNUM <= 15
				AND APPROVED_STAT = 'A'
				ORDER BY STK_CD
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['stk_cd']
      			, 'labelhtml'=>$search['stk_cd'] //WT: Display di auto completenya
      			, 'value'=>$search['stk_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }
	/*
	public function actionAjxValidateSpv() //LO: The purpose of this 'empty' function is to check whether an user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}
	 * 
	 */
}
?>