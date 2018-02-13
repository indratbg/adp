<?php
$this->breadcrumbs=array(
	'IP Bank'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'IP Bank', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/ipbank/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ipbank-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of IP Bank</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'ipbank-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
        'bank_cd',
		'bi_code',
		'bank_short_name',
		'bank_name',
		'bank_stat',
	   array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'buttons'=>array(
                'delete'=>array(
                    'url' => 'Yii::app()->createUrl("/master/ipbank/AjxPopDelete", array("id" => $data->primaryKey))',         // AH : change
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