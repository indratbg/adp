<?php
$this->breadcrumbs=array(
	'Trepos'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'List of Repo / Reverse Repo', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/trepo/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	
	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('trepo-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'trepo-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'repo_type',
		'client_cd',
		array('name'=>'repo_date','type'=>'date'),
		array('name'=>'extent_dt','type'=>'date'),
		array('name'=>'due_date','type'=>'date'),
		'repo_ref',
		array('name'=>'repo_val','type'=>'number','htmlOptions'=>array('style'=>'text-align:right')),
		array('name'=>'return_val','type'=>'number','htmlOptions'=>array('style'=>'text-align:right')),
		/*
		'repo_val',
		'return_val',
		'fee',
		'fee_per',
		'client_cd',
		'client_type',
		'sett_val',
		'cre_dt',
		'upd_dt',
		'user_id',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view} {update}',
		),
	),
)); ?>
