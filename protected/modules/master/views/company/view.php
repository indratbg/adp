<?php
$this->breadcrumbs=array(
	'Companies'=>array('index'),
	$model->kd_broker,
);

$this->menu=array(
	array('label'=>'Company', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->kd_broker)),
);
?>

<h1>View Company #<?php echo $model->kd_broker; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				'kd_broker',
				'nama_prsh',
				'other_1',
				'con_pers_title',
				'contact_pers',
				array('name'=>'round','type'=>'number'),
				'limit_mkbd',
				'kom_fee_pct',
				'vat_pct',
				'pph_pct',
				'levy_pct',
				'min_fee_flag',
				array('name'=>'min_value','type'=>'number'),
				array('name'=>'min_charge','type'=>'number'),
				'def_addr_1',
				'def_addr_2',
				'def_addr_3',
				'post_cd',
				'phone_num',
				'hp_num',
				'fax_num',
				'e_mail1',
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				'jenis_ijin1',
				'no_ijin1',
				array('name'=>'tgl_ijin1','type'=>'date'),
				'jenis_ijin2',
				'no_ijin2',
				array('name'=>'tgl_ijin2','type'=>'date'),
				'jenis_ijin3',
				'no_ijin3',
				array('name'=>'tgl_ijin3','type'=>'date'),
				'jenis_ijin4',
				'no_ijin4',
				array('name'=>'tgl_ijin4','type'=>'date'),
				'jenis_ijin5',
				'no_ijin5',
				array('name'=>'tgl_ijin5','type'=>'date'),
			),
		)); ?>
	</div>
</div>

<h3>Identity Attributes</h3>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'cre_dt','type'=>'datetime'),
		'user_id',
		array('name'=>'upd_dt','type'=>'datetime'),
		'upd_by',
		
	),
)); ?>