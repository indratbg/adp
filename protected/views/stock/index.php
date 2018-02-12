<?php
$this->breadcrumbs=array(
	'Stocks'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Stock', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('stock-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List Stocks</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'stock-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'stockname',
		'status',
		'previousprice',
		'openprice',
		'highestprice',
		'lowestprice',
		/*
		'lastprice',
		'lastvolume',
		'change',
		'changepercentage',
		'bid',
		'bidvolume',
		'offer',
		'offervolume',
		'totalfrequency',
		'totalvolume',
		'totalvalue',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
