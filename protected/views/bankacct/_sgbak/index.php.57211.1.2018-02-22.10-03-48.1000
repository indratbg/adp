<?php
$this->breadcrumbs=array(
	'Bankaccts'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Bankacct', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('bankacct-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List Bankaccts</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'bankacct-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'bank_cd',
		'sl_acct_cd',
		'bank_acct_cd',
		'chq_num_mask',
		'bank_acct_type',
		'brch_cd',
		/*
		'folder_prefix',
		'gl_acct_cd',
		'curr_cd',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
