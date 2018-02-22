<?php
$this->breadcrumbs=array(
	'Lawan Bond Trxes'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'LawanBondTrx', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/lawanbondtrx/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('lawan-bond-trx-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List Of Counter Parties</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'lawan-bond-trx-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'lawan',
		'lawan_name',
		'lawan_type',
		array('name'=>'typedesc','value'=>'Parameter::getTypeDesc($data->lawan_type)'),
		/*
		'phone',
		'fax',
		'contact_person',
		'capital_tax_pcn',
		
		'deb_gl_acct',
		'cre_gl_acct',
		'sl_acct_cd',
		'cre_dt',
		'user_id',
		'upd_dt',
		'upd_by',
		'approved_dt',
		'approved_by',
		'approved_stat',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("fixedincome/lawanbondtrx/update",array("id"=>"$data->lawan"))',
			'viewButtonUrl'=>'Yii::app()->createUrl("fixedincome/lawanbondtrx/view",array("id"=>"$data->lawan"))',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("fixedincome/lawanbondtrx/AjxPopDelete", array("id" =>"$data->lawan" ))',			// AH : change
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