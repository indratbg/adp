<?php

class CounterController extends AAdminController
{
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model=new Counter;

		if(isset($_POST['Counter'])){
			$model->attributes=$_POST['Counter'];
			$ctrtypeval = $_POST['Counter']['ctr_type'];
			//var_dump($ctrtypeval);
			//die();
			if($ctrtypeval == 'OB' || $ctrtypeval == 'RT' || $ctrtypeval == 'WR'){
				$model->scenario = 'special';	
			}
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_INS,$model->stk_cd) > 0 ){
            	Yii::app()->user->setFlash('success', 'Successfully create '.$model->stk_cd);
				$this->redirect(array('/master/counter/index'));
            }
		}else{
			// AH: setting default value
			$model->pph_appl_flg = 'Y'; 
			$model->levy_appl_flg = 'Y';  
			$model->stk_scripless = 'Y';
		
			$model->mrg_stk_cap	= 0;	
			$model->layer	 = 5;
			$model->lot_size = 100;
			$model->exch_lisd = 'JSX';
			$model->ctr_type  = 'RG';
			
			$model->par_val	= 1;
			$model->stk_stat = 'A';
			$model->trdg_lim = 0;
			$model->stk_basis = 'R';
			$model->mrkt_type = 'RG';
			$model->contr_stamp	= 'N';
			$model->vat_appl_flg = 'Y';
			$model->affil_flg = 'N';
			$model->sbi_flg = 'N';
			$model->sbpu_flg = 'N';
			$model->rem_stk_cap	= 100;
			$model->close_rate = 0;
			$model->last_bid_rate =	0;
			$model->mrg_stk_ceil = 0;
			$model->sec_comp_perc =	0;
			$model->short_lisd_flg = 'N';
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		if(isset($_POST['Counter']))
		{
			$model->attributes=$_POST['Counter'];
			$ctrtypeval = $_POST['Counter']['ctr_type'];
			if($ctrtypeval == 'OB' || $ctrtypeval == 'RT' || $ctrtypeval == 'WR'){
				$model->scenario = 'special';	
			}
			if($model->validate() && $model->executeSp(AConstant::INBOX_STAT_UPD,$id) > 0){
                Yii::app()->user->setFlash('success', 'Successfully update '.$model->stk_cd);
				$this->redirect(array('/master/counter/index'));
            }
		}
		else 
		{
			$sql = "SELECT eff_dt
					FROM
					(  
						SELECT stk_cd, Get_Doc_Date(1,pp_from_dt) AS distrib_dt
						FROM mst_counter m
					   	WHERE ctr_type = 'RT'
					   	AND pp_from_dt IS NOT NULL
					   	AND approved_stat = 'A'
					)  m,
					t_corp_act t
					WHERE m.stk_cd = t.stk_Cd
					AND m.distrib_dt = t.distrib_dt
					AND m.stk_cd = '$model->stk_cd'
					AND t.approved_stat = 'A'";
					
			$result = DAO::queryRowSql($sql);
			
			if($result)
			{
				$model->eff_dt = $result['eff_dt'];
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	
	public function actionAjxPopDelete($id)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model 			 = new Ttempheader();
		$model->scenario = 'cancel';
		$model1 = null;
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate())
			{
				$model1    				= $this->loadModel($id);
				$model1->cancel_reason  = $model->cancel_reason;
				if($model1->validate() && $model1->executeSp(AConstant::INBOX_STAT_CAN,$id) > 0){
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->stk_cd);
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
		$model=new Counter('search');
		$model->unsetAttributes();  // clear any default values

		if(isset($_GET['Counter']))
			$model->attributes=$_GET['Counter'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Counter::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
