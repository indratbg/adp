<?php
$this->breadcrumbs=array(
	'Haircut MKBD'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Haircut MKBD', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/thaircutkomite/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('Thaircutkomite-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Haircut MKBD</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'Thaircutkomite-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
			array('name'=>'status_dt','type'=>'date'),
			'stk_cd',
			'haircut',
			array('name'=>'eff_dt','type'=>'date'),
		
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("glaccounting/Thaircutkomite/update",$data->getPrimaryKey())',
			'viewButtonUrl'=>'Yii::app()->createUrl("glaccounting/Thaircutkomite/view",$data->getPrimaryKey())',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/glaccounting/Thaircutkomite/AjxPopDelete", $data->getPrimaryKey())',			// AH : change
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