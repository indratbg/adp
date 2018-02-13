<?php
$this->breadcrumbs=array(
	'Close Price Entry'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Close Price Entry', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tcloseprice/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tclosepricegen-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Close Price</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tclosepricegen-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
	   array('name'=>'stk_date','type'=>'date'),
		'stk_cd',
		'stk_name',
		array('name'=>'stk_prev','type'=>'number','htmlOptions'=>array('style'=>'text-align:right;')),
		array('name'=>'stk_high','type'=>'number','htmlOptions'=>array('style'=>'text-align:right;')),
		array('name'=>'stk_low','type'=>'number','htmlOptions'=>array('style'=>'text-align:right;')),
		array('name'=>'stk_clos','type'=>'number','htmlOptions'=>array('style'=>'text-align:right;')),
		/*
		'stk_volm',
		'stk_amt',
		'stk_indx',
		'stk_pidx',
		'stk_askp',
		'stk_askv',
		'stk_askf',
		'stk_bidp',
		'stk_bidv',
		'stk_bidf',
		'stk_open',
		'cre_dt',
		'user_id',
		'upd_dt',
		'upd_by',
		'approved_dt',
		'approved_by',
		'approved_stat',
		'isin_code',
		*/
		  array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'updateButtonUrl'=>'Yii::app()->createUrl("contracting/tcloseprice/update",$data->getPrimaryKey())',
            'viewButtonUrl'=>'Yii::app()->createUrl("contracting/tcloseprice/view",$data->getPrimaryKey())',
            //'deleteButtonUrl'=>'Yii::app()->createUrl("master/levy/delete",$data->getPrimaryKey())',
            'buttons'=>array(
                'delete'=>array(
                    'url' => 'Yii::app()->createUrl("contracting/tcloseprice/AjxPopDelete", $data->getPrimaryKey())',
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