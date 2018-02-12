<?php

class GlaccountController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';

	public function actionView($gl_a,$sl_a)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($gl_a,$sl_a),
		));
	}
	
	public function actionGetgla()//RD: The purpose of this function is to check GL_A and SL_A to Auto choosing Branch Code
	{
		$resp['status']='error';
		if(isset($_POST['gl_a']) && isset($_POST['sl_a']) && isset($_POST['sl_acut'])){
			$gl_a=$_POST['gl_a'];
			$sl_a=$_POST['sl_a'];
			$sl_acut=$_POST['sl_acut'];
			$sql="
				select sl_a,A.gl_a, B.BRANCH_CD from mst_gl_account a, 
				(select param_cd2 BRANCH_CD,dstr1 GL_A from mst_sys_param where param_id='GL_ACCOUNT')b
				WHERE TRIM(A.GL_A)=B.GL_A
				AND B.GL_A = '$gl_a'
			";
			$sql1="
				SELECT BRANCH_CODE FROM MST_CLIENT A, MST_GL_ACCOUNT B WHERE A.CLIENT_CD=B.SL_A(+) AND B.GL_A(+)='$gl_a'
				AND A.CLIENT_CD='$sl_a'
			";
			$mGla=DAO::queryRowSql($sql);
			if($mGla){
				if($mGla['branch_cd']){
					$resp['branch_cd']=$mGla['branch_cd'];
				}else{
					$mGla1=DAO::queryRowSql($sql1);
					if($mGla1['branch_code']){
						$hasil=substr($mGla1['branch_code'],0,2);
						$resp['branch_cd']=$hasil;
					}
				}
			}else{
				if($sl_acut == 1){
					$resp['branch_cd']='JK';
				}else if($sl_acut == 2){
					$resp['branch_cd']='SL';
				}else{
					$resp['branch_cd']=null;
				}
			}
			$resp['status']='success';
		}
		
		echo json_encode($resp);
	}

	public function actionCreate()
	{
		$model=new Glaccount;

		if(isset($_POST['Glaccount']))
		{
			$model->attributes=$_POST['Glaccount'];
			$model->acct_stat = 'A';
			$model->sl_a = strtoupper($model->sl_a);
						
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->gl_a,$model->sl_a) > 0){
            	Yii::app()->user->setFlash('success', 'Successfully create GL Account');
				$this->redirect(array('index'));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($gl_a,$sl_a)
	{
		$model=$this->loadModel($gl_a,$sl_a);
		
		$gl_a = trim($gl_a);
		$model->gl_a = trim($model->gl_a);

		if(isset($_POST['Glaccount']))
		{
			$model->attributes=$_POST['Glaccount'];
			$model->sl_a = strtoupper($model->sl_a);
			
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$gl_a,$sl_a) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update GL Account');
				$this->redirect(array('index'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionAjxPopDelete($gl_a,$sl_a)
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
				
				$model1    				= $this->loadModel($gl_a,$sl_a);
				$model1->cancel_reason  = $model->cancel_reason;
				$model1->validate();
				
				if($model1->executeSp(AConstant::INBOX_STAT_CAN,$gl_a,$sl_a) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel GL Account');
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

	public function actionIndex()
	{
		$model=new Glaccount('search');
		$model->unsetAttributes();  // clear any default values
		
		$model->approved_stat = 'A';
		$model->acct_stat = 'A';

		if(isset($_GET['Glaccount']))
			$model->attributes=$_GET['Glaccount'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($gl_a,$sl_a)
	{
		$model=Glaccount::model()->findByPk(array('gl_a'=>$gl_a,'sl_a'=>$sl_a));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
