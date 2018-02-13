<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs=array(
	'Companies'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Company', 'url'=>array('index')),
	array('label'=>'Create Company', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#company-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Companies</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'company-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'kd_broker',
		'nama_prsh',
		'round',
		'limit_mkbd',
		'jsx_listed',
		'ssx_listed',
		/*
		'kom_fee_pct',
		'vat_pct',
		'pph_pct',
		'levy_pct',
		'min_fee_flag',
		'min_value',
		'min_charge',
		'brok_nom_asing',
		'brok_nom_lokal',
		'jenis_ijin1',
		'no_ijin1',
		'tgl_ijin1',
		'jenis_ijin2',
		'no_ijin2',
		'tgl_ijin2',
		'jenis_ijin3',
		'no_ijin3',
		'tgl_ijin3',
		'jenis_ijin4',
		'no_ijin4',
		'tgl_ijin4',
		'jenis_ijin5',
		'no_ijin5',
		'tgl_ijin5',
		'user_id',
		'cre_dt',
		'upd_dt',
		'other_1',
		'other_2',
		'def_addr_1',
		'def_addr_2',
		'def_addr_3',
		'post_cd',
		'contact_pers',
		'phone_num',
		'hp_num',
		'fax_num',
		'e_mail1',
		'con_pers_title',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
