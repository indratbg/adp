<?php
$this->breadcrumbs=array(
	'Tpees'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Tpee', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tpee/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tpee-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of IPO Stock</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tpee-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'stk_cd',
		array('name'=>'name','value'=> '$data->stk_name'),
		//'stk_name',
		array('name'=>'distrib_dt_to' , 'type' => 'date'),
		/*
		'qty',
		'price',
		'unsubscribe_qty',
		'cre_dt',
		'upd_dt',
		'user_id',
		'stk_name',
		'paym_dt',
		'tgl_kontrak',
		'jenis_penjaminan',
		'nilai_komitment',
		'allocate_dt',
		'order_price',
		'bank_garansi',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/custody/tpee/AjxPopDelete", array("id" => $data->primaryKey))',			// AH : change
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