<?php
class InterestprsController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
			
		$model= new Interestprs ;
		$model->search_md=1;
		
		$model->month = date('n');
		$model->year = date('Y');
		$model->from_due_dt = date('01/m/Y');
		$model->to_due_dt = date('t/m/Y');
		$model->closing_dt = date('t/m/Y');
		
		$flag=(isset($_GET['flag']))?$_GET['flag']:'N';	
		$model->take_from_soa='N';
		
		if(isset($_POST['Interestprs'])){
			
			$model->attributes=$_POST['Interestprs'];
			
			$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
				$ip = '127.0.0.1';
			$model->ip_address = $ip;
			
			$valid=$model->validate();
		//	$valid=false;
			if($valid){
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();		
				
				$res=$model->executeSp();
				
				if($res>0){
					 $transaction->commit();
				
					Yii::app()->user->setFlash('success', 'Interest Process the month of : '.$model->month.' / '.$model->year.'  successfully process: '.$model->client_cnt.' client(s).');
					
					 $this->redirect(array('index','flag'=>'Y'));
				}else{
					 $transaction->rollback();
				}
			}
			
		}
		else 
		{
			$model->branch_all_flg = 'Y';
			$model->client_search_susp = 'Active';
		}
		
		$this->render('index',array(
			'model'=>$model,
			'flag'=>$flag
		));
	}
	public function actionGetClient()
	{
		$i = 0;
	    $src=array();
	    $term = strtoupper($_POST['term']);
		$searchOpt = $_POST['searchOpt'];
		$searchField = $searchOpt=='Code'?'client_cd':'client_name';
		$suspFlg = $_POST['suspFlg'];
		
	    $qSearch = DAO::queryAllSql("
					SELECT client_cd, branch_code, client_name,client_type_3, DECODE(susp_stat,'C','C','') susp_stat, DECODE(susp_stat,'C',' - Closed','') susp_text
					FROM MST_CLIENT
					WHERE ($searchField like '".$term."%')
					AND ('$suspFlg' = 'All' OR susp_stat = 'N')
					AND client_type_1 <> 'B'
	      			AND rownum <= 15
	      			ORDER BY client_cd
	      			");
	      
	    foreach($qSearch as $search)
	    {
	    	$cl_type=$search['client_type_3'];
			
	    	$src[$i++] = array('label'=>$search['client_cd'].$search['susp_text'].' - '.$search['branch_code']. ' - '.$search['client_name']
	      			, 'labelhtml'=>$search['client_cd'].$search['susp_text'].' - '.$search['branch_code']. ' - '.$search['client_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['client_cd']
					, 'branch'=>$search['branch_code']
					, 'name'=>$search['client_name']
					, 'susp_stat'=>$search['susp_stat']
					, 'client_type'=>$cl_type
					, 'client_type_desc'=>Lsttype3::model()->find("cl_type3 = '$cl_type'")->cl_desc);
	    }
	      
	    echo CJSON::encode($src);
	    Yii::app()->end();
	}
	
	public function actionAjxValidateSpv() //LO: The purpose of this 'empty' function is to check whether an user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}
}
?>