<?php
class ImptransfromfoController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model= new Imptransfromfo;
			
		$model->curr_date =date('d/m/Y');
		
		//$flag="N";
		$flag=(isset($_GET['flag']))?$_GET['flag']:'N';
		// if(DateTime::createFromFormat('Y-m-d',$model->curr_date)){
			// $model->curr_date=DateTime::createFromFormat('Y-m-d',$model->curr_date)->format('d/m/Y');
		// }
		if(isset($_POST['Imptransfromfo'])){
			$success=false;
			$date=$_POST['Imptransfromfo']['curr_date'];
			$connection  = Yii::app()->db;
			$transaction = $connection->beginTransaction();		
			
			$res=$model->executeSp($date);
			if($res>0){
				$transaction->commit();
				if($model->total_trx>0){
					Yii::app()->user->setFlash('success', 'Data at '.$date.' with total : '.$model->total_trx.' transactions are  successfully imported');
				}else{
					Yii::app()->user->setFlash('warning', 'Warning : data at '.$date.' has total : '.$model->total_trx.' transactions ');
				}
			    //$this->redirect(array('/contracting/Imptransfromfo/index'));
				 $this->redirect(array('index','flag'=>'Y'));
			}else{
				$transaction->rollback();
			}
			//$flag="Y";
		}
			$this->render('index',array(
			'model'=>$model,
			'flag'=>$flag
		));
	}
}
?>