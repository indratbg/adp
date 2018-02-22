<?php

class MaplkController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';



public function actionGetLk_acct()
    {
      $i=0;
      $src=array();
      $term = strtoupper($_POST['term']);
      $qSearch = DAO::queryAllSql("
				SELECT DISTINCT lk_acct FROM MST_MAP_LK where lk_acct like '%".$term."%' 
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['lk_acct']
      			, 'labelhtml'=>$search['lk_acct'] //WT: Display di auto completenya
      			, 'value'=>$search['lk_acct']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
    }
	

	public function actionIndex()
	{
		$model= array();
		$valid = true;
		$success = false;
		$cancel_reason = '';
		$ver_from_dt ='';
		$ver_to_dt = '';
		$entity ='';
		$lk_acct='';
		$gl_a='';
		$sl_a='';
		$error='';
	if(isset($_POST['scenario'])){
		$scenario = $_POST['scenario'];
		if($scenario == 'filter')
				{
			$ver_from_dt = $_POST['from_dt'];
			$ver_to_dt = $_POST['to_dt'];
			$entity = $_POST['entity'];
			$lk_acct = $_POST['lk_acct'];
			$gl_a = $_POST['gl_a'];
			$sl_a = $_POST['sl_a'];
			
			
			
			if(strpos($sl_a,"%")!==FALSE){
				$sl_acct_cd = "%$sl_a";
			}
			else{
				$sl_acct_cd = "$sl_a%";
			}
			
			
			if(DateTime::createFromFormat('Y-m-d',$ver_from_dt))$ver_from_dt=DateTime::createFromFormat('Y-m-d',$ver_from_dt)->format('d/m/Y');
			if(DateTime::createFromFormat('Y-m-d',$ver_to_dt))$ver_to_dt=DateTime::createFromFormat('Y-m-d',$ver_to_dt)->format('d/m/Y');
			
			//SEARCH
			if($ver_from_dt == '' && $ver_to_dt == '' && $entity =='' && $lk_acct == '' && $gl_a =='' && $sl_a ==''){
				$error= Yii::app()->user->setFlash('error', '<strong>LK ACCT atau GL A harus diisi salah satu</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A' and lk_acct like '1%' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt != '' && $ver_to_dt != '' &&  $lk_acct != '' && $entity !=''){
			//	echo "<script>alert('1')</script>";
				$model = Maplk::model()->findAll(array('condition'=>"ver_bgn_dt between to_date('$ver_from_dt','DD/MM/YYYY') and TO_DATE('$ver_to_dt','DD/MM/YYYY')
												and lk_acct like '$lk_acct%' and entity_cd like '$entity' and  trim(gl_a) like '%$gl_a%' and sl_a like '$sl_acct_cd' and approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt != '' && $ver_to_dt != '' && $entity !='' && $gl_a != ''){
			//	echo "<script>alert('2')</script>";
				$model = Maplk::model()->findAll(array('condition'=>"ver_bgn_dt between to_date('$ver_from_dt','DD/MM/YYYY') and TO_DATE('$ver_to_dt','DD/MM/YYYY')
												 and entity_cd like '$entity' and  trim(gl_a) like '%$gl_a%' and sl_a like '$sl_acct_cd' and approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt != '' && $ver_to_dt != '' &&  $lk_acct != ''){
				$model = Maplk::model()->findAll(array('condition'=>"ver_bgn_dt between to_date('$ver_from_dt','DD/MM/YYYY') and TO_DATE('$ver_to_dt','DD/MM/YYYY')
												and lk_acct like '$lk_acct%' and  trim(gl_a) like '%$gl_a%' and sl_a like '$sl_acct_cd' and approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			
			else if($ver_from_dt != '' && $ver_to_dt != '' &&  $gl_a != ''){
				$model = Maplk::model()->findAll(array('condition'=>"ver_bgn_dt between to_date('$ver_from_dt','DD/MM/YYYY') and TO_DATE('$ver_to_dt','DD/MM/YYYY')
												 and  trim(gl_a) like '%$gl_a%' and sl_a like '$sl_acct_cd' and approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt != '' && $ver_to_dt != '' && $entity !='' && $lk_acct != ''){
				$model = Maplk::model()->findAll(array('condition'=>"ver_bgn_dt between to_date('$ver_from_dt','DD/MM/YYYY') and TO_DATE('$ver_to_dt','DD/MM/YYYY')
												and  entity_cd like '$entity' and lk_acct like '$lk_acct%' and  trim(gl_a) like '%$gl_a%' and sl_a like '$sl_acct_cd' and approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt !='' && $lk_acct !=''){
				//echo "<script>alert('1')</script>";
				$model = Maplk::model()->findAll(array('condition'=>"ver_bgn_dt like to_date('$ver_from_dt','DD/MM/YYYY') and lk_acct like '$lk_acct%' and approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt !='' && $gl_a !=''){
				
					$model = Maplk::model()->findAll(array('condition'=>"ver_bgn_dt like to_date('$ver_from_dt','DD/MM/YYYY') and trim(gl_a) like'%$gl_a%' and approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt =='' && $ver_to_dt !='' && $lk_acct!='' && $entity != ''){
					$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt !='' && $ver_to_dt =='' && $lk_acct!='' && $entity != ''){
				//echo "<script>alert('test')</script>";
					$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt !='' && $ver_to_dt =='' && $lk_acct!='' && $sl_a != ''){
				//echo "<script>alert('test')</script>";
					$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt =='' && $ver_to_dt !='' && $lk_acct!='' && $sl_a != ''){
				//echo "<script>alert('test')</script>";
					$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt =='' && $ver_to_dt !='' && $lk_acct!='' && $gl_a != ''){
				//echo "<script>alert('test')</script>";
					$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt !='' && $ver_to_dt =='' && $lk_acct!='' && $gl_a != ''){
				//echo "<script>alert('test')</script>";
					$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt !='' && $ver_to_dt =='' && $gl_a!='' && $entity != ''){
				//echo "<script>alert('test')</script>";
					$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt =='' && $ver_to_dt !='' && $gl_a!='' && $entity != ''){
				//echo "<script>alert('test')</script>";
					$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt =='' && $ver_to_dt !='' && $gl_a!='' && $sl_a != ''){
				//echo "<script>alert('test')</script>";
					$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt !='' && $ver_to_dt =='' && $gl_a!='' && $sl_a != ''){
				//echo "<script>alert('test')</script>";
					$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt !='' && $ver_to_dt =='' && $lk_acct!=''){
				//echo "<script>alert('test')</script>";
					$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt =='' && $ver_to_dt !='' && $lk_acct!=''){
				//echo "<script>alert('test')</script>";
					$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt != '' && $ver_to_dt != ''){
				$error= Yii::app()->user->setFlash('error', '<strong>LK ACCT atau GL A harus diisi salah satu</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			
			else if($ver_from_dt !=''){
				$model = Maplk::model()->findAll(array('condition'=>"ver_bgn_dt like to_date('$ver_from_dt','DD/MM/YYYY') and approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($lk_acct !='' && $entity !=''){
			
					$model = Maplk::model()->findAll(array('condition'=>"lk_acct like '$lk_acct%' and entity_cd like '$entity' 
													and trim(gl_a) like '%$gl_a%' and sl_a like '$sl_acct_cd' and approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($lk_acct !='' && $sl_a !=''){
				$model = Maplk::model()->findAll(array('condition'=>"lk_acct like '$lk_acct%' 
														and trim(gl_a) like '%$gl_a%' and sl_a like '$sl_acct_cd' and approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($entity != '' && $gl_a != ''){
				$model = Maplk::model()->findAll(array('condition'=>"entity_cd like '$entity' 
														and trim(gl_a) like '%$gl_a%' and sl_a like '$sl_acct_cd' and approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($gl_a !='' && $sl_a !=''){
			$model = Maplk::model()->findAll(array('condition'=>"trim(gl_a) like '%$gl_a%' and sl_a like '$sl_acct_cd' and approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
				}
			
			else if($entity !=''){
				$error= Yii::app()->user->setFlash('error', '<strong>LK ACCT atau GL A harus diisi salah satu</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($lk_acct !=''){
				//echo "<script>alert('test')</script>";
			$model = Maplk::model()->findAll(array('condition'=>"lk_acct like '$lk_acct%' 
														and trim(gl_a) like '%$gl_a%' and sl_a like '$sl_acct_cd' and approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			
			else if($ver_from_dt != '' && $ver_to_dt ==''){
				$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt == '' && $ver_to_dt !=''){
				$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($gl_a !=''){
				$model = Maplk::model()->findAll(array('condition'=>"trim(gl_a) like '%$gl_a%' and sl_a like '$sl_acct_cd' and approved_stat ='A' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($sl_a !=''){
				$error= Yii::app()->user->setFlash('error', '<strong>LK ACCT atau GL A harus diisi salah satu</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_from_dt =='' && $ver_to_dt !='' && $lk_acct !=''){
				$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			
			else if($ver_from_dt =='' && $gl_a !=''){
				$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			else if($ver_to_dt =='' && $gl_a !=''){
				$error= Yii::app()->user->setFlash('error', '<strong>Versi From Date dan To Date harus diisi</strong>');
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
			
			
			else{
				
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A'  ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
			}
				
				//END SEARCH
				foreach($model as $row)
				{
					if($row->ver_bgn_dt)$row->ver_bgn_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->ver_bgn_dt)->format('d/m/Y');
					if($row->ver_end_dt)$row->ver_end_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->ver_end_dt)->format('d/m/Y');
					$row->old_ver_bgn_dt = $row->ver_bgn_dt;
					$row->old_entity_cd = $row->entity_cd;
					$row->old_lk_acct = $row->lk_acct;					
					$row->old_gl_a = trim($row->gl_a);
					$row->old_sl_a = $row->sl_a;
					$row->old_col_num = $row->col_num;
					$row->gl_a = trim($row->gl_a);
		
				}
					if(count($model)==0){
					$model[0]=new Maplk;
					Yii::app()->user->setFlash('error', 'No Data Found');
					}
				}

		else{
		$rowCount = $_POST['rowCount'];
			
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A' and lk_acct like '1%' or lk_acct like '2%'", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
				foreach($model as $row)
				{
					if($row->ver_bgn_dt)$row->ver_bgn_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->ver_bgn_dt)->format('d/m/Y');
					if($row->ver_end_dt)$row->ver_end_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->ver_end_dt)->format('d/m/Y');
					$row->old_ver_bgn_dt = $row->ver_bgn_dt;
					$row->old_entity_cd = $row->entity_cd;
					$row->old_lk_acct = $row->lk_acct;					
					$row->old_gl_a = trim($row->gl_a);
					$row->old_sl_a = $row->sl_a;
					$row->old_col_num = $row->col_num;
		
				}
				$x;
				
				$save_flag = false; //False if no record is saved
				
				if(isset($_POST['cancel_reason']))
				{
					if(!$_POST['cancel_reason'])
					{
						$valid = false;
						Yii::app()->user->setFlash('error', 'Cancel Reason Must be Filled');
					}
					else
					{
						$cancel_reason = $_POST['cancel_reason'];
					}
				}
		
				for($x=0;$x<$rowCount;$x++)
				{
					$model[$x] = new Maplk;
					$model[$x]->attributes = $_POST['Maplk'][$x+1];
					if(isset($_POST['Maplk'][$x+1]['save_flg']) && $_POST['Maplk'][$x+1]['save_flg'] == 'Y')
					{
						$save_flag = true;
						if(isset($_POST['Maplk'][$x+1]['cancel_flg']))
						{
							if($_POST['Maplk'][$x+1]['cancel_flg'] == 'Y')
							{
								//CANCEL
								$model[$x]->scenario = 'cancel';
								$model[$x]->cancel_reason = $_POST['cancel_reason'];
							}
							else 
							{
								//UPDATE
								$model[$x]->scenario = 'update';
							}
						}
						else 
						{
							//INSERT
							$model[$x]->scenario = 'insert';
						}
						
						
						$valid = $model[$x]->validate() && $valid;
						
					}
				}
				
				$valid = $valid && $save_flag;
					
					
				if($valid)
				{ 
					$success = true;
					$connection  = Yii::app()->db;
					$transaction = $connection->beginTransaction();
					
					for($x=0;$success && $x<$rowCount;$x++)
					{
						
						if($model[$x]->save_flg == 'Y')
						{	
						
							if($model[$x]->cancel_flg == 'Y')
							{	
								//CANCEL
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_CAN,$model[$x]->old_ver_bgn_dt,$model[$x]->old_entity_cd,$model[$x]->old_lk_acct,$model[$x]->old_gl_a,$model[$x]->old_sl_a,$model[$x]->old_col_num) > 0)$success = true;
								else {
									$success = false;
								}
							}
							else if($model[$x]->old_ver_bgn_dt)
							{ 	
								//UPDATE
							
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_UPD,$model[$x]->old_ver_bgn_dt,$model[$x]->old_entity_cd,$model[$x]->old_lk_acct,$model[$x]->old_gl_a,$model[$x]->old_sl_a,$model[$x]->old_col_num) > 0)$success = true;
								else {
									$success = false;
								}
							}			
							else 
							{	
								//INSERT
								if($success && $model[$x]->executeSp(AConstant::INBOX_STAT_INS,$model[$x]->ver_bgn_dt,$model[$x]->entity_cd,$model[$x]->lk_acct,$model[$x]->gl_a,$model[$x]->sl_a,$model[$x]->col_num) > 0)$success = true;
								else {
									$success = false;
								}
							}
						}
					}

					if($success)
					{
						$transaction->commit();
							
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/glaccounting/Maplk/index'));
					}
					else {
						
						$transaction->rollback();
					}
				}
			
					foreach($model as $row)
					{
						if(DateTime::createFromFormat('Y-m-d',$row->ver_bgn_dt))$row->ver_bgn_dt=DateTime::createFromFormat('Y-m-d',$row->ver_bgn_dt)->format('d/m/Y');
						if(DateTime::createFromFormat('Y-m-d',$row->ver_end_dt))$row->ver_end_dt=DateTime::createFromFormat('Y-m-d',$row->ver_end_dt)->format('d/m/Y');
					}	
		
		}
		}
		else{
	
		
				$model = Maplk::model()->findAll(array('condition'=>"approved_stat ='A' and lk_acct like '1%' ", 'order'=>'lk_acct,gl_a,sl_a,ver_bgn_dt'));
				
				if(count($model)==0){
									$model[0]=new Maplk;
								
									}
							
								foreach($model as $row)
								{
									if($row->ver_bgn_dt)$row->ver_bgn_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->ver_bgn_dt)->format('d/m/Y');
									if($row->ver_end_dt)$row->ver_end_dt=DateTime::createFromFormat('Y-m-d G:i:s',$row->ver_end_dt)->format('d/m/Y');
									$row->old_ver_bgn_dt = $row->ver_bgn_dt;
									$row->old_entity_cd = $row->entity_cd;
									$row->old_lk_acct = $row->lk_acct;					
									$row->old_gl_a = trim($row->gl_a);
									$row->old_sl_a = $row->sl_a;
									$row->old_col_num = $row->col_num;
									$row->gl_a = trim($row->gl_a);
								}
				
	
}
		

		$this->render('index',array(
			'model'=>$model,
			'ver_from_dt'=>$ver_from_dt,
			'ver_to_dt'=>$ver_to_dt,
			'entity'=>$entity,
			'lk_acct'=>$lk_acct,
			'gl_a'=>$gl_a ,
			'sl_a'=>$sl_a,
			'pesan'=>$error,
			'cancel_reason'=>$cancel_reason,
		));
	}

	public function actionAjxValidateCancel() //LO: The purpose of this 'empty' function is to check whether an user is authorized to perform cancellation
	{
		$resp = '';
		echo json_encode($resp);
	}

/*
	public function actionAjxPopDelete($ver_bgn_dt,$entity_cd,$lk_acct,$gl_a,$sl_a,$col_num)
	{
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Ttempheader();
		$model->scenario = 'cancel';
		$model1 = NULL;
		
		if(isset($_POST['Ttempheader']))
		{
			$model->attributes = $_POST['Ttempheader'];	
					
			if($model->validate()){
				
				$model1    				= $this->loadModel($ver_bgn_dt,$entity_cd,$lk_acct,$gl_a,$sl_a,$col_num);
				$model1->cancel_reason  = $model->cancel_reason;
				
				if($model1->executeSp(AConstant::INBOX_STAT_CAN,$ver_bgn_dt,$entity_cd,$lk_acct,$gl_a,$sl_a,$col_num) > 0){
					Yii::app()->user->setFlash('success', 'Map GL Account Code to Consol Report Entry');
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
*/
	public function loadModel($ver_bgn_dt,$entity_cd,$lk_acct,$gl_a,$sl_a,$col_num)
	{
		$model=Maplk::model()->find("ver_bgn_dt = '$ver_bgn_dt' AND entity_cd = '$entity_cd' AND lk_acct = '$lk_acct' AND gl_a = '$gl_a' AND sl_a = '$sl_a' AND col_num = '$col_num'");
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
