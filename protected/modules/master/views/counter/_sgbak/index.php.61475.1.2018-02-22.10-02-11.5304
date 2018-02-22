<?php
$this->breadcrumbs=array(
	'Counter'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Counter', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/counter/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('counter-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Shares</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'counter-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
    'enablePagination'=>true,
	'columns'=>array(
		
		'stk_cd',
		array('name'=>'ctr_type','value'=>'Parameter::getParamDesc("CTRTYP",$data->ctr_type)'),
		'stk_desc',
		
		/*
		'stk_lisd_dt',
		'par_val',
		'lot_size',
		'stk_stat',
		'trdg_lim',
		'short_stk_cd',
		'stk_basis',
		'stk_scripless',
		'sec_comp_perc',
		'pp_from_dt',
		'pp_to_dt',
		'mrg_stk_cap',
		'rem_stk_cap',
		'contr_stamp',
		'close_rate',
		'pph_appl_flg',
		'last_bid_rate',
		'levy_appl_flg',
		'mrg_stk_ceil',
		'mrg_cap_type',
		'affil_flg',
		'sbi_flg',
		'sbpu_flg',
		'user_id',
		'cre_dt',
		'upd_dt',
		'short_lisd_flg',
		'short_dt_lisd',
		'vat_appl_flg',
		'stk_type',
		'mrkt_type',
		'layer',
		'upd_by',
		'approved_dt',
		'approved_by',
		'approved_stat',
		*/
		
		//'upd_by',
		//array('name'=>'upd_dt','type'=>'datetime'),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/master/counter/AjxPopDelete", array("id" => $data->primaryKey))',			// AH : change
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
