<?php
$this->breadcrumbs=array(
	'Glaccounts'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Glaccount', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/glaccount/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('glaccount-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Chart of Accounts</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'glaccount-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'gl_a',
		'sl_a',
		'acct_name',
		'prt_type',
		'brch_cd',
		/*
		'db_cr_flg',
		'prt_type',
		'anal_flg',
		'acct_stat',
		'user_id',
		'cre_dt',
		'upd_dt',
		'excess_pay_flg',
		'match_flg',
		'trust_flg',
		'refund_flg',
		'bah_acct_name',
		'bah_acct_short',
		'def_cpc_cd',
		'mkbd_cd',
		'mkbd_group',
		'gl_a',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("glaccounting/glaccount/update",$data->getPrimaryKey())',
			'viewButtonUrl'=>'Yii::app()->createUrl("glaccounting/glaccount/view",$data->getPrimaryKey())',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/glaccounting/glaccount/AjxPopDelete", $data->getPrimaryKey())',			// AH : change
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
