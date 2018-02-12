<?php
class MonthendprsController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
			
		$model= new Monthendprs;
			
		//$model->curr_date =date('t/m/Y');
		$model->month = date('n');
		$model->year = date('Y');
		
		$flag=(isset($_GET['flag']))?$_GET['flag']:'N';	
		
		// if(DateTime::createFromFormat('Y-m-d',$model->curr_date)){
			// $model->curr_date=DateTime::createFromFormat('Y-m-d',$model->curr_date)->format('d/m/Y');
		// }
		if(isset($_POST['Monthendprs'])){
			
			$model->attributes=$_POST['Monthendprs'];
			
			$ip = Yii::app()->request->userHostAddress;
			if($ip=="::1")
			$ip = '127.0.0.1';
			$model->ip_address = $ip;
			
			$valid=$model->validate();
			//$model->mmyy=DateTime::createFromFormat('d/m/Y',$model->curr_date)->format('my');
			
			
			if($valid){
				$model->curr_date=date("01/$model->month/$model->year");
				
				$newMonth;
				$newYear;
				if($model->month+1>12){
					$newMonth=1;
					$newYear=$model->year+1;
				}else{
					$newMonth=$model->month+1;
					$newYear=$model->year;
				}
				
				$model->new_date=date("01/$newMonth/$newYear");
				
			
				
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();		
				
				$res=$model->executeSp();
				if($res>0){
					
					$success_dt=DateTime::createFromFormat('d/m/Y',$model->curr_date)->format('My');
					$transaction->commit();
				
					//Yii::app()->user->setFlash('success', 'Month End Closing date: '.$model->curr_date.'  successfully processed');
					Yii::app()->user->setFlash('success', 'Month End Closing : '.$success_dt.'  successfully processed');
					
					 $this->redirect(array('index','flag'=>'Y'));
				}else{
					$transaction->rollback();
				}
				//$flag="Y";
				
			}
			
			
		}
		
			$this->render('index',array(
			'model'=>$model,
			'flag'=>$flag
		));
	}
}
?>