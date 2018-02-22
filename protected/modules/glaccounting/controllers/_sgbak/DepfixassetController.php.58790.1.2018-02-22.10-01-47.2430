<?php
class DepfixassetController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		
			
		$model= new Depfixasset;
			
		$model->curr_date =date('t/m/Y');
		
		$flag=(isset($_GET['flag']))?$_GET['flag']:'N';	
		
		// if(DateTime::createFromFormat('Y-m-d',$model->curr_date)){
			// $model->curr_date=DateTime::createFromFormat('Y-m-d',$model->curr_date)->format('d/m/Y');
		// }
		if(isset($_POST['Depfixasset'])){
			
			$model->attributes=$_POST['Depfixasset'];
			
			$valid=$model->validate();
			$model->mmyy=DateTime::createFromFormat('d/m/Y',$model->curr_date)->format('my');

			if($valid){
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();		
				
				$res=$model->executeSp();
				if($res>0){
					$transaction->commit();
				
					Yii::app()->user->setFlash('success', 'Data date: '.$model->curr_date.'  successfully processed');
					
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