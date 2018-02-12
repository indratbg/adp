<?php
$this->breadcrumbs=array(
	'Levies'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Levy', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/levy/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('levy-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Levies</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'levy-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'eff_dt','type'=>'date'),
		'stk_type',
		'mrkt_type',
		'value_from',
		'value_to',
		'levy_pct',
		/*
		'cre_dt',
		'upd_dt',
		'user_id',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("master/levy/update",$data->getPrimaryKey())',
			'viewButtonUrl'=>'Yii::app()->createUrl("master/levy/view",$data->getPrimaryKey())',
			//'deleteButtonUrl'=>'Yii::app()->createUrl("master/levy/delete",$data->getPrimaryKey())',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/master/levy/AjxPopDelete", $data->getPrimaryKey())',
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