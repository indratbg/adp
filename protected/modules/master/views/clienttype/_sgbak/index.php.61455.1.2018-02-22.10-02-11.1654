<?php
$this->breadcrumbs=array(
	'Clienttypes'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Clienttype', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/clienttype/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('clienttype-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List Of Client Types</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'clienttype-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'cl_type1','value'=>'Constanta::$client_type1[$data->cl_type1]'),
		array('name'=>'cl_type2','value'=>'Constanta::$client_type2[$data->cl_type2]'),
		array('name'=>'cl_type3','value'=>'Constanta::$client_type3[trim($data->cl_type3)]'),
		'type_desc',
		'os_p_acct_cd',
		'os_s_acct_cd',
		
		/*
		'nett_allow',
		'rebate_pct',
		'comm_pct',
		'user_id',
		'cre_dt',
		'upd_dt',
		'dup_contract',
		'avg_contract',
		'os_contra_g_acct_cd',
		'os_contra_l_acct_cd',
		'os_setoff_g_acct_cd',
		'os_setoff_l_acct_cd',
		'int_on_payable',
		'int_on_receivable',
		'int_on_pay_chrg_cd',
		'int_on_rec_chrg_cd',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'updateButtonUrl'=>'Yii::app()->createUrl("master/clienttype/update",$data->getPrimaryKey())',
			'viewButtonUrl'=>'Yii::app()->createUrl("master/clienttype/view",$data->getPrimaryKey())',
			//'deleteButtonUrl'=>'Yii::app()->createUrl("master/clienttype/delete",$data->getPrimaryKey())',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("master/clienttype/AjxPopDelete", $data->getPrimaryKey())',
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
