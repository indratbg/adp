<?php
$this->breadcrumbs=array(
	'Branches'=>array('index'),
	$model->brch_cd,
);

$this->menu=array(
	array('label'=>'Branch', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->brch_cd)),
);
?>

<h1>View Branch <?php echo $model->brch_cd; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'brch_cd',
		'brch_name',
		array('name'=>'Address','value'=>$model->def_addr_1.'<br/>'.$model->def_addr_2.'<br/>'.$model->def_addr_3,'type'=>'raw'),
		'post_cd',
		
		'phone_num',
		array('name'=>'','value'=>$model->phone2_1),
		'hand_phone1',
		'fax_num',
		'e_mail1',
		'contact_pers',
		
		'bankmaster.bank_name',
		'brch_acct_num',
		'acct_prefix',
		'branch_status'
	),
)); ?>


<?php /* $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'cre_dt','type'=>'datetime'),
		'user_id',
		array('name'=>'upd_dt','type'=>'datetime'),
		'upd_by',
		
	),
));*/ ?>
