<?php
class RpttrialbalanceController extends AAdminController
{

	public $layout = '//layouts/admin_column3';
	
	public function actionIndex()
	{
		$model = new Rpttrialbalance('TRIAL_BALANCE','R_TRIAL_BALANCE','Trial_Balance.rptdesign');	
		$url='';
		$resp['status']='error';
		if(isset($_POST['Rpttrialbalance']) && isset($_POST['scenario']))
		{
			$resp['status']='success';
			$model->attributes = $_POST['Rpttrialbalance'];
			$scenario = $_POST['scenario'];
			if($scenario =='print')
			{
				if($model->validate())
				{
					
					if($model->from_gla=='')
					{
						$bgn_acct = '%';
						$end_acct='_';
					}
					else
					{
						$bgn_acct = $model->from_gla;
						$end_acct=$model->to_gla;
					}	
					if($model->from_sla=='')
					{
						$bgn_sub = '%';
						$end_sub = '_';	
					}
					else
					{
						$bgn_sub = $model->from_sla;
						$end_sub = $model->to_sla;
					}	
					
					$branch_cd = $model->branch_option=='0'?'%':$model->branch_cd;
					
					$rpt_mode =$model->report_mode==0?'DETAIL':'SUMMARY'; 
					
					if($model->executeRpt($bgn_acct, $end_acct, $bgn_sub, $end_sub, $branch_cd, $rpt_mode)>0)
					{
						$rpt_link =$model->showReport(); 
						$url = $rpt_link.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
					}
					else
	                {
	                    $resp['error_msg'] = $model->vo_errcd . ' ' . $model->vo_errmsg;
	                }
				}
				else
	            {
	                $err_msg = '';

	                foreach ($model->getErrors() as $row)
	                { 
	                    $x = 0;
	                    foreach ($row as $key=>$value)
	                    {
	                        if ($x > 0)
	                            $err_msg .= ', ';
	                        $err_msg .= $value;
	                        $x++;
	                    }
	                }
	                  $resp['error_msg'] = $err_msg;
				}//end validate

                $resp['url']=$url;
	            $resp['vo_random_value']=$model->vo_random_value;
	            $resp['vp_userid']=$model->vp_userid;
	            echo json_encode($resp);
            }//end scenario print
            else if($scenario=='export')//export to excel
            {
            	$condition = "where rand_value=$model->vo_random_value and user_id='$model->vp_userid' order by  gl_acct,sl_acct";
            	$this->ExportToExcel('INSISTPRO_RPT',$model,$condition,'Trial Balance');
            }
          
		}
		else
		{

			$gl_a = Glaccount::model()->findAll(array('select'=>"trim(gl_a) gl_a,gl_a||' - '||acct_name acct_name",'condition'=>"approved_stat='A' and sl_a='000000' AND acct_stat = 'A'",'order'=>'gl_a')); 		
			$model->year = date('Y');
			$model->bgn_date = date('01/m/Y');
			$model->end_date = date('t/m/Y');
			$model->report_mode=0;
			$model->cancel_flg='1';
			$model->branch_option=0;
			$model->month = date('m');
			$this->render('index',array('model'=>$model,
									'gl_a'=>$gl_a,
									'url'=>$url));
		}
	
	}
	
}
