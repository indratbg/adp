<?php
class UpdsubrekandsidController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model= new Updsubrekandsid;
			
		$model->curr_date =date('d/m/Y');
		
		$flag=(isset($_GET['flag']))?$_GET['flag']:'N';
		
		if(isset($_POST['Updsubrekandsid'])){
			
			//$success=false;
			//$date=$_POST['Updsubrekandsid']['curr_date'];
			$model->attributes=$_POST['Updsubrekandsid'];
			
			$valid=$model->validate();
			
			if($valid){
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();		
				
				$res=$model->executeSp();
				
				if($res>0){
					$transaction->commit();
					
					if($model->total_upd>0){
						Yii::app()->user->setFlash('success', 'Data at '.$model->curr_date.' with suffix : '.$model->selected_mode. ' and total : '.$model->total_upd.' data are  successfully processed');
					}else{
						Yii::app()->user->setFlash('warning', 'Warning : data at '.$model->curr_date.' with suffix :' .$model->selected_mode. ' has total : '.$model->total_upd.' update ');
					}
					 
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