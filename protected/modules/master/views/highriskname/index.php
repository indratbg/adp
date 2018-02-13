<?php
$this->breadcrumbs=array(
	'Highrisknames'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Highriskname', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Upload','url'=>array('upload'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/highriskname/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('highriskname-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Highrisk Names</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'highriskname-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'name',
		'kategori',
		'descrip',
		array('name'=>'ref_date','type'=>'date'),
		//'cre_dt',
		/*
		'user_id',
		'upd_dt',
		'upd_by',
		'approved_dt',
		'approved_by',
		'approved_stat',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("master/highriskname/update",array("id" => $data->primaryKey))',
			'viewButtonUrl'=>'Yii::app()->createUrl("master/highriskname/view",array("id" => $data->primaryKey))',
			//'deleteButtonUrl'=>'Yii::app()->createUrl("master/highriskname/delete",$data->getPrimaryKey())',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/master/highriskname/AjxPopDelete", array("id" => $data->primaryKey))',			// AH : change
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


