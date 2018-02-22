<?php
$this->breadcrumbs=array(
	'Tportojaminans'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Tportojaminan', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tportojaminan/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tportojaminan-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Daftar Portofolio yang Dijaminkan</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tportojaminan-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'from_dt','type'=>'date'),
		'client_cd',
		'stk_cd',
		array('name'=>'qty','type'=>'number','htmlOptions'=>array('style'=>'text-align:right','width')),
		/*
		'upd_by',
		'approved_dt',
		'approved_by',
		'approved_stat',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("custody/tportojaminan/update",$data->getPrimaryKey())',
			'viewButtonUrl'=>'Yii::app()->createUrl("custody/tportojaminan/view",$data->getPrimaryKey())',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/custody/tportojaminan/AjxPopDelete", $data->getPrimaryKey())',			// AH : change
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
