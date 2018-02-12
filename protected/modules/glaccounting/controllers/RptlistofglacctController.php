<?php

class RptlistofglacctController extends AAdminController
{

	public $layout = '//layouts/admin_column3';
	
	public function actionGetsla()
	{
		$i=0;
      	$src=array();
      	$term = strtoupper($_REQUEST['term']);
      	$glAcctCd = $_REQUEST['gl_acct_cd'];
      	
      	$qSearch = DAO::queryAllSql("
					SELECT sl_a, acct_name FROM MST_GL_ACCOUNT 
					WHERE TRIM(gl_a) = '$glAcctCd' 
					AND sl_a LIKE '".$term."%'
					AND prt_type <> 'S'
					AND acct_stat = 'A'
					AND approved_stat = 'A'
	      			AND rownum <= 200
	      			ORDER BY sl_a
      			");
      
	    foreach($qSearch as $search)
	    {
	      	$src[$i++] = array('label'=>$search['sl_a'].' - '.$search['acct_name']
	      			, 'labelhtml'=>$search['sl_a'].' - '.$search['acct_name'] //WT: Display di auto completenya
	      			, 'value'=>$search['sl_a']);
	    }
      
      	echo CJSON::encode($src);
      	Yii::app()->end();
	}
	
	public function actionIndex()
	{
		$model = new Rptlistofglacct('LIST_OF_GL_ACCOUNT', 'R_LIST_OF_GL_ACCOUNT', 'List_Of_GL_Account.rptdesign');
		$gl_a = Glaccount::model()->findAll(array('select'=>"trim(gl_a) gl_a,gl_a||' - '||acct_name acct_name",'condition'=>"approved_stat='A' 
				 and sl_a='000000' AND acct_stat = 'A'",'order'=>'gl_a'));
		$url='';
		if(isset($_POST['Rptlistofglacct']))
		{
			$model->attributes = $_POST['Rptlistofglacct'];
			
			if($model->rpt_bgn_acct=='')
			{
				$model->bgn_acct = '%';
				$model->end_acct='_';
			}
			else
			{
				$model->bgn_acct=$model->rpt_bgn_acct;
				$model->end_acct=$model->rpt_end_acct;
			}	
			if($model->rpt_bgn_sub=='')
			{
				$model->bgn_sub='%';
				$model->end_sub='_';	
			}
			else
			{
				$model->bgn_sub = $model->rpt_bgn_acct;
				$model->end_sub = $model->rpt_end_acct;
			}	
			
			if($model->validate() && $model->executeRpt() > 0)
			{
				$rpt_link =$model->showReport();
				$url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
			}
			
			
		}else{
			$model->acct_stat = 'ALL';
			$model->arap = 'A';
		}
		
		$this->render('index',array('model'=>$model,
									'gl_a'=>$gl_a,
									'url'=>$url));
	}

}
