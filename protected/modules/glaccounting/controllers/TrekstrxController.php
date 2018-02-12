<?php

class TrekstrxController extends AAdminController
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
		$success = false;
		$model=new Trekstrx;
		if(isset($_POST['Trekstrx']))
		{
		$model->attributes=$_POST['Trekstrx'];
		
		if($model->validate()){
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
		$menuName = 'PENYERTAAN REKSA DANA ENTRY';
					
		if($model->executeSpHeader(AConstant::INBOX_STAT_INS,$menuName) > 0)$success = true;
		
			if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$model->doc_ref_num,1) > 0){
            	$success = true;
			}
			else{
				$success = false;
			}
					if($success)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/glaccounting/Trekstrx/index'));
					}
					else {
						$transaction->rollback();
					}
			}
		
			}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		
		$success = false;
		$model=$this->loadModel($id);
		$oldModel= $this->loadModel($id);
		if(isset($_POST['Trekstrx']))
		{
		$model->attributes=$_POST['Trekstrx'];
			
		if($model->validate()){
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
		$menuName = 'PENYERTAAN REKSA DANA ENTRY';
					
		if($model->executeSpHeader(AConstant::INBOX_STAT_UPD,$menuName) > 0)$success = true;
		if(DateTime::createFromFormat('Y-m-d H:i:s',$model->trx_date))$model->trx_date=DateTime::createFromFormat('Y-m-d H:i:s',$model->trx_date)->format('Y-m-d');
			
			$model->doc_ref_num='';
		
			if($success && $model->executeSp(AConstant::INBOX_STAT_INS,$model->doc_ref_num,1) > 0){
          	$success = true; 
					//echo "<script>alert('Test')</script>";
            }
			else{
			
				$success = false;
			}
			
			//echo "<script>alert('$model->update_date')</script>";
		
		
		
		$oldModel->update_date = $model->update_date;
		$oldModel->update_seq = $model->update_seq;
		if(DateTime::createFromFormat('Y-m-d H:i:s',$oldModel->trx_date))$oldModel->trx_date=DateTime::createFromFormat('Y-m-d H:i:s',$oldModel->trx_date)->format('Y-m-d');
		
		if($success && $oldModel->executeSp(AConstant::INBOX_STAT_UPD,$id,2) > 0){
          	$success = true;
			  
            }
			else{
				
				$success = false;
			}
		if($success)
					{
						$transaction->commit();
						Yii::app()->user->setFlash('success', 'Data Successfully Saved');
						$this->redirect(array('/glaccounting/Trekstrx/index'));
					}
					else {
						$transaction->rollback();
					}
					}
					}
		$this->render('update',array(
			'model'=>$model,
			'oldModel'=>$oldModel,
		));
	}

	public function actionAjxPopDelete($id)
	{	$success = false;
		$this->layout 	= '//layouts/main_popup';
		$is_successsave = false;
		
		$model  = new Tmanyheader();
		$model->scenario = 'cancel';
		$model1 = $this->loadModel($id);
		if(isset($_POST['Tmanyheader']))
		{
			$model->attributes = $_POST['Tmanyheader'];	
				
		if($model->validate()){
		
		$connection  = Yii::app()->db;
		$transaction = $connection->beginTransaction(); //Untuk memastikan bahwa transaksi di-commit jika dan hanya jika semua transaksi INSERT berhasil dijalankan, bila ada transaksi INSERT yang gagal, transaksi akan di rollback
		$menuName = 'PENYERTAAN REKSA DANA ENTRY';
				$model1->cancel_reason  = $model->cancel_reason;
				$model1->user_id = Yii::app()->user->id;
				$model1->ip_address = Yii::app()->request->userHostAddress;
				if($model1->ip_address=="::1")
					$model1->ip_address = '127.0.0.1';	
		if($model1->executeSpHeader(AConstant::INBOX_STAT_CAN,$menuName) > 0)$success = true;
				
				//if(DateTime::createFromFormat('Y-m-d H:i:s',$model1->trx_date))$model1->trx_date=DateTime::createFromFormat('Y-m-d H:i:s',$trx_date)->format('Y-m-d');
				if(DateTime::createFromFormat('Y-m-d H:i:s',$model1->trx_date))$model1->trx_date=DateTime::createFromFormat('Y-m-d H:i:s',$model1->trx_date)->format('Y-m-d');
				
			//	$oldModel = $this->loadModel($id);
				
				if($success && $model1->executeSp(AConstant::INBOX_STAT_UPD,$id,1) > 0){
					
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully cancel '.$model1->doc_ref_num);
					$is_successsave = true;
				}
					
					else {
						$transaction->rollback();
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
		$model=new Trekstrx('search');
		$model->unsetAttributes();  // clear any default values
		
		$model->approved_stat = 'A';
		

		if(isset($_GET['Trekstrx']))
			$model->attributes=$_GET['Trekstrx'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
	public function actionGetisin()
    {
		 
				 
      $i=0;
      $src=array();
      $term = strtoupper($_GET['term']);
	  
      $qSearch = DAO::queryAllSql("
				SELECT distinct REKS_CD FROM T_REKS_TRX
				WHERE REKS_CD LIKE '%$term%' order by reks_cd
      			");
      
      foreach($qSearch as $search)
      {
      	$src[$i++] = array('label'=>$search['reks_cd']
      			, 'labelhtml'=>$search['reks_cd'] //WT: Display di auto completenya
      			, 'value'=>$search['reks_cd']);
      }
      
      echo CJSON::encode($src);
      Yii::app()->end();
	   
    }

	public function actionReksname(){
	
		$resp['status']='error';
			if(isset($_POST['reks_cd'])){
			$reks_cd=$_POST['reks_cd'];
			$query="SELECT REKS_CD, REKS_NAME, REKS_TYPE,  AFILIASI, TRX_DATE, TRX_TYPE, subs, REDM , GL_A1,SL_A1,GL_A2,SL_A2
					FROM T_REKS_TRX where reks_cd = '$reks_cd'";	
			$reks_name = DAO::queryRowSql($query);
			
			$query1 = "SELECT T.REKS_TYPE,M.REKS_TYPE_TXT FROM MST_REKS_TYPE M, T_REKS_TRX T WHERE T.REKS_TYPE = M.REKS_TYPE";
			$reks_type = DAO::queryRowSql($query1);
				$resp['reks_type'] = $reks_type['reks_type'];
				$resp['afiliasi'] = $reks_name['afiliasi'];
				$resp['gl_a1'] = $reks_name['gl_a1'];
				$resp['sl_a1'] = $reks_name['sl_a1'];
				$resp['gl_a2'] = $reks_name['gl_a2'];
				$resp['sl_a2'] = $reks_name['sl_a2'];
				$resp['reks_name'] = $reks_name['reks_name'];
				$resp['status']='success';
			}
		echo json_encode($resp);
	}
	
	
	

	public function loadModel($id)
	{
		$model=Trekstrx::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	 
}
