<?php

class LawanbondtrxController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new LawanBondTrx;
		$model->is_active = 'Y';

		if(isset($_POST['LawanBondTrx']))
		{
				$model->attributes=$_POST['LawanBondTrx'];
				if(!$model->participant){
					$model->participant = 'N';
				}
				if(!$model->is_active){
					$model->is_active = 'N';
				}
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS, $model->lawan) > 0){
				
            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->lawan);
				$this->redirect(array('index','id'=>$model->lawan));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['LawanBondTrx']))
		{
			$model->attributes=$_POST['LawanBondTrx'];
			if(!$model->participant){
				$model->participant = 'N';
			}
			if(!$model->is_active){
				$model->is_active = 'N';
			}
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$id) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update '.$model->lawan);
				$this->redirect(array('index','id'=>$model->lawan));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
		$model=new LawanBondTrx('search');
		$model->unsetAttributes();  // clear any default values
		$model->approved_sts = 'A';

		if(isset($_GET['LawanBondTrx']))
			$model->attributes=$_GET['LawanBondTrx'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
		public function actionGetSub()
    {
		    	/*
				 
				 $request=$_GET['term'];
				
			    if($request!=''){
			        $model= DAO::queryAllSql("SELECT client_cd, client_name
											FROM MST_CLIENT
											WHERE client_type_1 <> 'B'
											AND CLIENT_CD like '%$request%'
											ORDER BY 2
							      			");
			        $data=array();
			        foreach($model as $search)
     								 {
      				$data[$i++] = array('label'=>$search['client_cd']
				      					, 'labelhtml'=>$search['client_cd'] //WT: Display di auto completenya
				      					, 'value'=>$search['client_cd']);
      			}
		        //$this->layout='empty';
		       // echo json_encode($data);
				}				
		
				echo CJSON::encode($data);
    			  Yii::app()->end();
				 *
				 * 
				 */ 
				 
      $i=0;
      $src=array();
      $term = strtoupper($_POST['term']);
	  
      $qSearch = DAO::queryAllSql("
				SELECT client_cd, client_name
				FROM MST_CLIENT
				WHERE client_type_1 <> 'B'
				AND CLIENT_CD like '".$term."%'
				AND susp_stat <> 'C'
				ORDER BY 1
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['client_cd']
      			, 'labelhtml'=>$search['client_cd'] //WT: Display di auto completenya
      			, 'value'=>$search['client_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
	   
    }
	public function actionAjxPopDelete($id)
	{
	$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model1 = NULL;
		$model  = new Ttempheader();
		$model->scenario = 'cancel';
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate()){
				
				$model1    				= $this->loadModel($id);
				$model1->cancel_reason  = $model->cancel_reason;
				
				$cek=Tbondtrx::model()->find("lawan='$id'");
				if(!$cek){
					if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$id) > 0){
					Yii::app()->user->setFlash('success', 'Successfully Cancel Counter Party');
					$is_successsave = true;	
				}
				}
				else{
					Yii::app()->user->setFlash('error', 'Kode ini pernah dipakai, Tidak dapat dicancel');
					$is_successsave = true;	
				}
					
			
	}
		}
		$this->render('_popcancel',array(
			'model'=>$model,
			'model1'=>$model1,
			'is_successsave'=>$is_successsave		
		));
	}
	
	public function actionGlaccount(){
	
		$resp['status']='error';
			if(isset($_POST['type'])){
			$type=$_POST['type'];
			$query="SELECT DISTINCT lawan_type, p.descrip,  capital_tax_pcn, deb_gl_acct, cre_gl_acct
					FROM MST_LAWAN_BOND_TRX m ,
					( SELECT prm_cd_2, prm_desc AS descrip
					FROM MST_PARAMETER
					WHERE prm_cd_1 = 'LAWAN') p
					WHERE m.lawan_type = p.prm_cd_2 and lawan_type='$type'";
					
			$gl = DAO::queryRowSql($query);
				$resp['pcn'] = $gl['capital_tax_pcn'];
				$resp['gl'] = $gl['deb_gl_acct'];
				$resp['cre'] = $gl['cre_gl_acct'];
				$resp['status']='success';
		
		
		
			}
		echo json_encode($resp);
	}


	public function loadModel($id)
	{
		$model=LawanBondTrx::model()->find("lawan='$id'");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
