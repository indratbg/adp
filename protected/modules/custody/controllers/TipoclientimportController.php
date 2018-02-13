<?php

class TipoclientimportController extends AAdminController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin_column2';
	
	public function actionIndex()
	{
		$model=new Tipoclientimport;
		
		if(isset($_POST['Tipoclientimport']))
		{
			$model->attributes=$_POST['Tipoclientimport'];
			
			if($model->validate())
			{
				$model->source_file = CUploadedFile::getInstance($model,'source_file');
				$filepath = FileUpload::getFilePath(FileUpload::T_IPO_CLIENT,'UPLOAD.txt');		
				$model->source_file->saveAs($filepath);
				
				$file = fopen($filepath, "r");
				
				$x = 0;
				$success = TRUE;
				
				$connection  = Yii::app()->db;
				$transaction = $connection->beginTransaction();	
				
				while(!feof($file))
				{
					$buffer = fgetcsv($file,0,"\t");
					
					if(count($buffer) < 2)
					{
						if($buffer[0])Yii::app()->user->setFlash('error', 'Delimiter not supported');
						break;
					}
					
					if(strtoupper($buffer[0]) != 'CLIENT_CD' && strtoupper($buffer[0] != 'CLIENT CD'))
					{
						if($success && $model->executeSp($buffer[0],str_replace('.','',$buffer[1])) > 0)$x = 1;
						else {
							$temp = $buffer[0];
							if($model->error_code == -3)echo "<script>alert('$temp doesn\'t exist in MST_CLIENT')</script>";
							$success = false;
							break;
						}
					}
				}
				if($success && $x == 1)
				{
					$transaction->commit();
					Yii::app()->user->setFlash('success', 'Successfully saved');
				}
				else {
					$transaction->rollback();
				}
				
			}
		}
		else
		{
			$model->ipo_perc = 1;
		}
		
		$criteria_stk = new CDbCriteria;
		$criteria_stk->select = 'stk_cd';
		$criteria_stk->condition = "distrib_dt_to > TRUNC(SYSDATE)-30 AND approved_stat = 'A' ";
		$criteria_stk->order = 'stk_cd';
		
		$this->render('index',array('model'=>$model,'criteria_stk'=>$criteria_stk));
	}
}
	
?>