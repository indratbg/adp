<?php
$this->breadcrumbs=array(
	'Sales'=>array('index'),
	$model->rem_cd,
);

$this->menu=array(
	array('label'=>'Sales', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->rem_cd)),
);
?>

<h1>View Sales Person #<?php echo $model->rem_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'rem_cd',
		array('name'=>'rem_type','value'=>Sales::$rem_type[$model->rem_type]),
		array('name'=>'rem_susp_stat','value'=>AConstant::$is_flag_status[$model->rem_susp_stat]),
		'rem_name',
		array('name'=>'ic_type','value'=>Parameter::getParamDesc('IDTYPE', $model->ic_type)),
		'rem_ic_num',
		'npwp_number',
		'ptkp_type',
		array('name'=>'branch_cd','value'=>Branch::getBranchName($model->branch_cd)),
		array('name'=>'join_dt','type'=>'date'),
		array('name'=>'lic_num','value'=>Sales::$lic_num[$model->lic_num]),
		array('name'=>'lic_expry_dt','type'=>'date'),
		
		'def_addr_1',
		'def_addr_2',
		'def_addr_3',
		'post_cd',
		
		'contact_pers',
		'phone_num',
		'handphone_num',
		'fax_num',
		
		/*
		    array('name'=>'regr_cd','value'=>Parameter::getParamDesc('REGNCD',$model->regn_cd)),
			'bank_cd',
			'bank_brch_cd',
			'rem_acct_num',
			'dep_val',
			'exp_lim',	
			'race',
			'old_ic_num',
			'rem_main_sub',
			'sub_rem_cd',
			'commission_val',
			'basic_salary',
			'email',
			'incentive_flg',
			'incentive_basis',
			'incentive_per',
			'upd_by',
			array('name'=>'approved_dt','type'=>'date'),
			'approved_by',
			'approved_stat',
			'def_addr',
		*/
	),
)); ?>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'Create','value'=>$model->user_id.' / '.Yii::app()->format->formatDate($model->cre_dt)),
		array('name'=>'Update','value'=>$model->upd_by.' / '.Yii::app()->format->formatDate($model->upd_dt)),
		array('name'=>'Approve','value'=>$model->approved_by.' / '.Yii::app()->format->formatDate($model->approved_dt)),
	),
)); ?>
