<?php
$this->breadcrumbs=array(
	'Clienttypes'=>array('index'),
	$model->cl_type1,
);

$this->menu=array(
	array('label'=>'Client Type', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','cl_type1'=>$model->cl_type1,'cl_type2'=>$model->cl_type2,'cl_type3'=>$model->cl_type3)),
);
?>

<h1>View Client Type <?php echo $model->cl_type1."".$model->cl_type2."".$model->cl_type3; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
				array('name'=>'cl_type1','value'=>Constanta::$client_type1[$model->cl_type1]),
				array('name'=>'cl_type2','value'=>Constanta::$client_type2[$model->cl_type2]),
				array('name'=>'cl_type3','value'=>Constanta::$client_type3[trim($model->cl_type3)]),
		'type_desc',
		//'dup_contract',
		//'avg_contract',
		//'nett_allow',
		//'rebate_pct',
		//'comm_pct',
		//'user_id',
		//array('name'=>'cre_dt','type'=>'date'),
	//	array('name'=>'upd_dt','type'=>'date'),
		'os_p_acct_cd',
		'os_s_acct_cd',
		'os_contra_g_acct_cd',
		'os_contra_l_acct_cd',
	//	'os_setoff_g_acct_cd',
		//'os_setoff_l_acct_cd',
		//'int_on_payable',
		//'int_on_receivable',
		//'int_on_pay_chrg_cd',
		//'int_on_rec_chrg_cd',
	),
)); ?>



<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
	),
)); ?>
