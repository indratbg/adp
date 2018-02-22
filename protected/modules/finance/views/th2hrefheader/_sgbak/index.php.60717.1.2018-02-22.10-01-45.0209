<?php
$this->breadcrumbs=array(
	'Th2hrefheaders'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Host to Host Transfer Status', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('th2hrefheader-grid', {
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
	'id'=>'th2hrefheader-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'file_name',
		'trf_id',
		'kbb_type1',
		'branch_group',
		'trf_date',
		array('name'=>'total_trf_amt','value'=>'$data->total_trf_amt','type'=>'number','htmlOptions'=>array('style'=>'text-align:right')),
		'save_date',
		'trf_status',
		'total_record',
		'fail_cnt',
		
		/*
		'save_date',
		'upload_date',
		'response_date',
		'total_record',
		'success_cnt',
		'fail_cnt',
		'description',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{view}',
			/*'buttons' => array(
				'view' => array(
					'visible' => '$data->response_date?true:false'
				)
			),*/
		),
	),
)); ?>
