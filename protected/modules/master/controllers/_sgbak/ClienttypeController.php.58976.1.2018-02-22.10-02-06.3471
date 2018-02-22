<?php

class ClienttypeController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionView($cl_type1,$cl_type2,$cl_type3)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($cl_type1,$cl_type2,$cl_type3),
		));
	}

	public function actionCreate()
	{
		$model=new Clienttype;

		if(isset($_POST['Clienttype']))
		{	$valid = true ;
			$model->attributes=$_POST['Clienttype'];
			$query="select distinct gl_a from MST_GL_ACCOUNT where GL_A = '$model->os_p_acct_cd'";
			$query1="select distinct gl_a from MST_GL_ACCOUNT where GL_A = '$model->os_s_acct_cd'";
			$query2="select distinct gl_a from MST_GL_ACCOUNT where GL_A = '$model->os_contra_g_acct_cd'";
			$query3="select distinct gl_a from MST_GL_ACCOUNT where GL_A = '$model->os_contra_l_acct_cd'";
			$stat = DAO::queryRowSql($query);
			$stat1 = DAO::queryRowSql($query1);
			$stat2 = DAO::queryRowSql($query2);
			$stat3 = DAO::queryRowSql($query3);
			if(!$model->validate())$valid=false;
			
			if(!$stat && $model->os_p_acct_cd){
				$valid=false;
				$model->addError('os_p_acct_cd','Not found in chart of Account');
			}
			if(!$stat1 && $model->os_s_acct_cd){
				$valid=false;
				$model->addError('os_s_acct_cd','Not found in chart of Account');
			}
			if(!$stat2 && $model->os_contra_g_acct_cd){
				$valid=false;
				$model->addError('os_contra_g_acct_cd','Not found in chart of Account');
			}
			if(!$stat3 && $model->os_contra_l_acct_cd){
				$valid=false;
				$model->addError('os_contra_l_acct_cd','Not found in chart of Account');
			}
			
			
			
			if($valid == true && $model->executeSp(AConstant::INBOX_STAT_INS,$model->cl_type1,$model->cl_type2,$model->cl_type3) > 0)
			{
			   	Yii::app()->user->setFlash('success', 'Successfully create Client type ');
				$this->redirect(array('/master/clienttype/index'));
				//$this->redirect(array('index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($cl_type1,$cl_type2,$cl_type3)
	{
		$model=$this->loadModel($cl_type1,$cl_type2,$cl_type3);
		$model->cl_type3 =trim($model->cl_type3);
		if(isset($_POST['Clienttype']))
		{
		
		$valid = true ;
			$model->attributes=$_POST['Clienttype'];
			$query="select distinct gl_a from MST_GL_ACCOUNT where GL_A = '$model->os_p_acct_cd'";
			$query1="select distinct gl_a from MST_GL_ACCOUNT where GL_A = '$model->os_s_acct_cd'";
			$query2="select distinct gl_a from MST_GL_ACCOUNT where GL_A = '$model->os_contra_g_acct_cd'";
			$query3="select distinct gl_a from MST_GL_ACCOUNT where GL_A = '$model->os_contra_l_acct_cd'";
			$stat = DAO::queryRowSql($query);
			$stat1 = DAO::queryRowSql($query1);
			$stat2 = DAO::queryRowSql($query2);
			$stat3 = DAO::queryRowSql($query3);
			if(!$model->validate())$valid=false;
			
			if(!$stat && $model->os_p_acct_cd){
				$valid=false;
				$model->addError('os_p_acct_cd','Not found in chart of Account');
			}
			if(!$stat1 && $model->os_s_acct_cd){
				$valid=false;
				$model->addError('os_s_acct_cd','Not found in chart of Account');
			}
			if(!$stat2 && $model->os_contra_g_acct_cd){
				$valid=false;
				$model->addError('os_contra_g_acct_cd','Not found in chart of Account');
			}
			if(!$stat3 && $model->os_contra_l_acct_cd){
				$valid=false;
				$model->addError('os_contra_l_acct_cd','Not found in chart of Account');
			}
			
		
			$model->attributes=$_POST['Clienttype'];
			if($valid == true && $model->executeSp(AConstant::INBOX_STAT_UPD,$cl_type1,$cl_type2,$cl_type3) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update Client Type');
				$this->redirect(array('index','cl_type1'=>$model->cl_type1,'cl_type2'=>$model->cl_type2,'cl_type3'=>$model->cl_type3));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionAjxPopDelete($cl_type1,$cl_type2,$cl_type3)
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
				
				$model1    				= $this->loadModel($cl_type1,$cl_type2,$cl_type3);
				$model1->cancel_reason  = $model->cancel_reason;
				
				if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$cl_type1,$cl_type2,$cl_type3) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel Client Type');
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
	/*
	public function actionCekGL(){
	
		$resp['status']='error';
		if(isset($_POST['acct_buy']) || isset($_POST['acct_sell']) ||  isset($_POST['acct_kredit']) || isset($_POST['acct_debit'])){

			$a = $_POST['acct_buy'];
			$b = $_POST['acct_sell'];
			$c = $_POST['acct_kredit'];
			$d = $_POST['acct_debit'];

			$query="select distinct gl_a from MST_GL_ACCOUNT where GL_A = '$a'";
			$query1="select distinct gl_a from MST_GL_ACCOUNT where GL_A = '$a'";
			
			$stat = DAO::queryRowSql($query);
			
			if($stat){
				$resp['cek'] = 'success';
			}
			else{
				$resp['acct']=$stat['gl_a'];
				
				$resp['cek']='fail';
			}
			$resp['status']='success';
	
		}
		
		
		echo json_encode($resp);
	}
	
	*/


	public function actionIndex()
	{
		$model=new Clienttype('search');
		$model->unsetAttributes();  // clear any default values
		$model->approved_stat = 'A';
		if(isset($_GET['Clienttype']))
			$model->attributes=$_GET['Clienttype'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($cl_type1,$cl_type2,$cl_type3)
	{
		$model=Clienttype::model()->findByPk(array('cl_type1'=>$cl_type1,'cl_type2'=>$cl_type2,'cl_type3'=>$cl_type3));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
