<?php
$this->breadcrumbs=array(
	'Tipoclients'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Tipoclient', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tipoclient/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tipoclient-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<h1>List of Client IPO Stock</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tipoclient-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'stk_cd',
		'client.client_name',
		'brch_cd',
		'client_cd',
		array('name'=>'fixed_qty','value'=>'AFormatter::formatNumberNonDec($data->fixed_qty)','htmlOptions'=>array('style'=>'text-align:right')),
		array('name'=>'pool_qty','value'=>'AFormatter::formatNumberNonDec($data->pool_qty)','htmlOptions'=>array('style'=>'text-align:right')),
		array('name'=>'alloc_qty','value'=>'AFormatter::formatNumberNonDec($data->alloc_qty)','htmlOptions'=>array('style'=>'text-align:right')),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("custody/tipoclient/update",$data->getPrimaryKey())',
			'viewButtonUrl'=>'Yii::app()->createUrl("custody/tipoclient/view",$data->getPrimaryKey())',
			//'deleteButtonUrl'=>'Yii::app()->createUrl("master/levy/delete",$data->getPrimaryKey())',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/custody/tipoclient/AjxPopDelete", $data->getPrimaryKey())',
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