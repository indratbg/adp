<?php

class RptprofitlossbranchController extends AAdminController
{

    public $layout = '//layouts/admin_column3';

    public function actionIndex()
    {
        $model = new Rptprofitlossbranch('PROFIT_LOSS_BRANCH', 'R_PROFIT_LOSS_BRANCH', 'Profit_Loss_Branch.rptdesign');
        $sql = "SELECT * FROM 
				(
				SELECT brch_cd, brch_cd ||' - '|| brch_name as brch_name FROM MST_BRANCH WHERE approved_stat='A' 
				UNION ALL
				SELECT 'ZI', 'ZI' ||' - '|| 'FIXED INCOME' as brch_name FROM DUAL
				)
				ORDER BY brch_cd";
        $dropdown_branch = Branch::model()->findAllBySql($sql);
        $ui_flg = Sysparam::model()->find("PARAM_ID='PROFIT LOSS BRANCH' AND PARAM_CD1='REPORT' AND PARAM_CD2='UI'")->dstr1;

        $model->doc_date = date('t/m/Y');
        $model->branch_option = '1';
        $model->year = date('Y');
        $model->month = date('m');
        $model->rpt_pres = '0';
        //$model->branch_cd = 'JK';
        $model->half_year = '0';
        $model->quarter = '0';

        $url = '';
        $url_xls = '';

        if (isset($_POST['Rptprofitlossbranch']) && isset($_POST['scenario']))
        {
            $model->attributes = $_POST['Rptprofitlossbranch'];
            $scenario = $_POST['scenario'];

            if ($scenario == 'print')
            {

                if (DateTime::createFromFormat('d/m/Y', $model->doc_date))
                    $model->doc_date = DateTime::createFromFormat('d/m/Y', $model->doc_date)->format('Y-m-d');

                $bgn_date = '';
                $end_date = '';
                $criteria = '';
                $branch_flg = '';
                $bgn_mon = '';
                $fixed_income = 'TOTAL';
                if ($ui_flg == 'YJ')
                {
                    $model->rpt_pres = '3';
                }

                //REPORT PRESENTATION
                //QUARTER YEAR
                if ($model->rpt_pres == '0')
                {
                    if ($model->quarter == '0')
                    {
                        $bgn_mon = '1';
                        $bgn_date = date("$model->year-01-01");
                        $end_date = date('Y-m-t', strtotime("$model->year-03-01"));
                    }
                    else if ($model->quarter == '1')
                    {
                        $bgn_mon = '4';
                        $bgn_date = date("$model->year-01-01");
                        $end_date = date('Y-m-t', strtotime("$model->year-06-01"));
                    }
                    else if ($model->quarter == '2')
                    {
                        $bgn_mon = '7';
                        $bgn_date = date("$model->year-01-01");
                        $end_date = date('Y-m-t', strtotime("$model->year-09-01"));
                    }
                    else if ($model->quarter == '3')
                    {
                        $bgn_mon = '10';
                        $bgn_date = date("$model->year-01-01");
                        $end_date = date('Y-m-t', strtotime("$model->year-12-01"));
                    }
                    $criteria = 'QUARTER';
                }
                //HALF YEAR
                else if ($model->rpt_pres == '1')
                {
                    if ($model->half_year == '0')
                    {
                        $bgn_mon = '1';
                        $bgn_date = date("$model->year-01-01");
                        $end_date = date('Y-m-t', strtotime("$model->year-06-01"));
                    }
                    else
                    {
                        $bgn_mon = '7';
                        $bgn_date = date("$model->year-01-01");
                        $end_date = date('Y-m-t', strtotime("$model->year-12-01"));
                    }
                    $criteria = 'HALF';

                }
                //FULL YEAR
                else if ($model->rpt_pres == '2')
                {
                    $bgn_mon = '1';
                    $bgn_date = date("$model->year-01-01");
                    $end_date = date('Y-m-t', strtotime("$model->year-12-01"));
                    $criteria = 'YEAR';
                }
                //JANUARY UP TO
                else if ($model->rpt_pres == '3')
                {
                    $bgn_mon = '1';
                    $bgn_date = date("$model->year-01-01");
                    $end_date = $model->doc_date;
                    $criteria = 'UPTO';

                }

                //branch
                if ($model->branch_option == '0')
                {
                    $bgn_branch = $model->branch_cd;
                    $end_branch = $model->branch_cd;
                }
                else if ($model->branch_option == '1')
                {
                    $bgn_branch = '%';
                    $end_branch = '_';
                }
                else
                {
                    $bgn_branch = '%';
                    $end_branch = '_';
                }

                if (($model->branch_option == '0' || $model->branch_option == '1') && ($model->rpt_pres == '0' || $model->rpt_pres == '1' || $model->rpt_pres == '2'))
                {
                    $branch_flg = 'SPECIFIED';
                    $model->rptname = 'Profit_Loss_Branch.rptdesign';
                }
                else if (($model->branch_option == '2' || $model->branch_option == '3') && ($model->rpt_pres == '0' || $model->rpt_pres == '1' || $model->rpt_pres == '2' || $model->rpt_pres == '3'))
                {
                    $branch_flg = 'ALL BRANCHES';
                    $model->rptname = 'Profit_Loss_Total_Branch.rptdesign';
                }
                else if ($model->branch_option == '4' && $model->rpt_pres == '3')
                {
                    $branch_flg = 'EXPENSE';
                    if ($ui_flg == 'YJ')
                    {
                        $model->rptname = 'Profit_loss_detail_expense.rptdesign';
                        $model->tablename = 'R_PROFIT_LOSS_DETAIL_EXP';
                    }
                    else
                    {
                        $model->rptname = 'Profit_Loss_Branch_Expenses.rptdesign';
                        $model->tablename = 'R_PROFIT_LOSS_BRANCH_EXP';
                    }
                }
                
else if (($model->branch_option == '0' || $model->branch_option == '1') && $model->rpt_pres == '3')
                {

                    $branch_flg = 'SPECIFIED';
                    $model->rptname = 'Profit_Loss_Branch.rptdesign';
                    $model->tablename = 'R_PROFIT_LOSS_BRANCH';
                }
                else if ($model->branch_option == '2' && $model->rpt_pres == '3')
                {

                    $branch_flg = 'SPECIFIED';
                    $model->rptname = 'Profit_Loss_Total_Branch.rptdesign';
                    $model->tablename = 'R_PROFIT_LOSS_BRANCH';
                }

                if ($model->branch_option == '3')
                {
                    $fixed_income = 'WOFI';
                }

                //criteria
                $bgn_mon = $bgn_mon;
                //intval(DateTime::createFromFormat('Y-m-d',$bgn_date)->format('m'));
                $end_mon = intval(DateTime::createFromFormat('Y-m-d', $end_date)->format('m'));

                if (DateTime::createFromFormat('Y-m-d', $bgn_date))
                    $bgn_date = DateTime::createFromFormat('Y-m-d', $bgn_date)->format('Y-m-d');
                if (DateTime::createFromFormat('Y-m-d', $end_date))
                    $end_date = DateTime::createFromFormat('Y-m-d', $end_date)->format('Y-m-d');

                if ($ui_flg == 'YJ' && $model->rpt_pres == '3' && $model->branch_option == '4')
                {
                    if ($model->validate() && $model->executeRptDetailExpense($bgn_date, $end_date, $bgn_mon, $end_mon) > 0)
                    {
                        $rpt_link = $model->showReport($bgn_date, $end_date);
                        $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                        $url_xls = $rpt_link . '&&__dpi=96&__format=xlsx&__pageoverflow=0&__overwrite=false&#zoom=100';
                    }
                }
                else
                {
                    if ($model->validate() && $model->executeRpt($bgn_date, $end_date, $bgn_branch, $end_branch, $criteria, $bgn_mon, $end_mon, $branch_flg, $fixed_income) > 0)
                    {
                        $rpt_link = $model->showReport($bgn_date, $end_date);
                        $url = $rpt_link . '&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false&#zoom=100';
                        $url_xls = $rpt_link . '&&__dpi=96&__format=xlsx&__pageoverflow=0&__overwrite=false&#zoom=100';

                    }
                }
            }
            else
            {
                //export
                $user_id = Yii::app()->user->id;
                if ($model->branch_option == '4')
                {
                    $model->col_name = $model->col_name_exp;
                    $model->tablename = 'R_PROFIT_LOSS_DETAIL_EXP';
                    $condition = "where user_id= '$user_id' and rand_value=$model->vo_random_value order by sortk";
                    $this->ExportToExcel('INSISTPRO_RPT', $model, $condition, 'Profit Loss Detail Expense');
                }
                else
                {
                    $model->tablename = 'R_PROFIT_LOSS_BRANCH';
                    $condition = "where user_id= '$user_id' and rand_value=$model->vo_random_value ORDER BY gl_acct_group,gl_acct_cd,sl_acct_cd";
                    $this->ExportToExcel('INSISTPRO_RPT', $model, $condition, 'Profit Loss Branch');
                }
            }
        }

        if (DateTime::createFromFormat('Y-m-d', $model->doc_date))
            $model->doc_date = DateTime::createFromFormat('Y-m-d', $model->doc_date)->format('d/m/Y');
        $this->render('index', array(
            'model'=>$model,
            'url'=>$url,
            'url_xls'=>$url_xls,
            'branch_cd'=>$dropdown_branch,
            'ui_flg'=>$ui_flg
        ));
    }

}
