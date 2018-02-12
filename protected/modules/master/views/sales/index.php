<?php
$this->breadcrumbs=array(
	'Sales'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Sales', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus'),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/sales/index','icon'=>'list'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sales-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>List of Sales Person</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'sales-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		'rem_cd',
		'rem_name',
		array('name'=>'rem_type','value'=>'Sales::$rem_type[$data->rem_type]'),
		array('name'=>'rem_susp_stat','value'=>'AConstant::$is_flag_status[$data->rem_susp_stat]'),
		'lic_num',
		'brch_name',
		array('name'=>'join_dt','type'=>'date'),
		/*'rem_name',
		'rem_name_abbr',
		'rem_birth_dt',
		'join_dt',
		'rem_ic_num',
		
		'def_addr_1',
		'def_addr_2',
		'def_addr_3',
		'post_cd',
		
		'phone_num',
		'handphone_num',
		'fax_num',
		'regn_cd',
		'lic_num',
		'lic_expry_dt',
		'bank_cd',
		'bank_brch_cd',
		'rem_acct_num',
		'dep_val',
		'exp_lim',
		'rem_susp_stat',
		'cre_dt',
		'upd_dt',
		'user_id',
		'ic_type',
		'race',
		'old_ic_num',
		'rem_main_sub',
		'sub_rem_cd',
		'commission_val',
		'basic_salary',
		'email',
		'branch_cd',
		'incentive_flg',
		'incentive_basis',
		'incentive_per',
		'upd_by',
		'approved_dt',
		'approved_by',
		'approved_stat',
		'def_addr',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'viewButtonUrl'=>'Yii::app()->createUrl("master/sales/view", array("id" => $data->rem_cd))',
			'updateButtonUrl'=>'Yii::app()->createUrl("master/sales/update", array("id" => $data->rem_cd))',
			'buttons'=>array(
		        'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/master/sales/AjxPopDelete", array("id" => $data->rem_cd))',			// AH : change
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
