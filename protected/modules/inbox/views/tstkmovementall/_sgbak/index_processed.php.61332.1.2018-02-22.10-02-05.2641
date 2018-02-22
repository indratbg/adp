<?php
$this->breadcrumbs=array(
	'Stock Movement Inbox'=>array('index'),
	'Processed Stock Movement',
);

$this->menu=array(
	array('label'=>'Processed Stock Movement Inbox', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Unprocessed','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Processed','url'=>array('indexProcessed'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'List','url'=>Yii::app()->request->baseUrl.'?r=custody/tstkmovement/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});

$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ttempheader-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php AHelper::applyScrollableGridView(); ?> <!-- add vertical scrollbar to grid view -->
<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('/template/_search_processed',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'ttempheader-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'user_id',
		array('name'=>'update_date','type'=>'datetime'),
		array('name'=>'status','value'=>'AConstant::$inbox_stat[$data->status]'),
		array('name'=>'approved_status','value'=>'AConstant::$inbox_app_stat[$data->approved_status]'),
		'approved_user_id',
		array('name'=>'approved_date','type'=>'datetime'),
		array('name'=>'reject_reason','type'=>'raw','value'=>'nl2br($data->reject_reason)'),
		array(
			'class'	  =>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}',
		),
	),
)); ?>


<?php
  	AHelper::popupwindow($this, 600, 500);
?>
