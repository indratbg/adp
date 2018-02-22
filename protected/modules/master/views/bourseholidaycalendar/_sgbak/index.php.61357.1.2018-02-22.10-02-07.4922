<?php
$this->breadcrumbs=array(
	'IDX Holidays'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'IDX Holiday', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/bourseholidaycalendar/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('Bourseholidaycalendar-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of IDX Holidays</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'Bourseholidaycalendar-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'tgl_libur','type'=>'date'),
		array('name'=>'ket_libur','type'=>'raw','value'=>'nl2br($data->ket_libur)'),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("master/bourseholidaycalendar/update",array("id"=>$data->tgl_libur))',
			'viewButtonUrl'=>'Yii::app()->createUrl("master/bourseholidaycalendar/view",array("id"=>$data->tgl_libur))',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/master/bourseholidaycalendar/delete", array("id" => $data->tgl_libur))',			// AH : change
		        	'click'=>'js:function(e){
		            	e.preventDefault();
						showPopupModal("Cancel Reason",this.href);
		            }'
		         ),
        	 )
		),
	),
)); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>
