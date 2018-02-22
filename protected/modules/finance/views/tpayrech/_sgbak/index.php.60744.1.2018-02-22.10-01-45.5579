<?php
$this->breadcrumbs=array(
	'Receipt/Payment'=>array('index'),
	'List',
);

$controllerId = $this->getId();

$this->menu=array(
	array('label'=>'List of Vouchers', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tpayrechall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tpayrech-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php if($controllerId == 'tpayrechalt'): ?>
<pre><strong>Note : Cancel / Update voucher menghasilkan tanggal reversal sama dengan tanggal voucher yang dicancel/update</strong></pre>
<?php else: ?>
<pre><strong>Note : Cancel / Update voucher menghasilkan tanggal reversal sama dengan tanggal hari ini (Untuk voucher non AR/AP)</strong></pre>
<?php endif; ?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('/tpayrech/_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tpayrech-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'filterPosition'=>'',
	'columns'=>array(
		array('name'=>'payrec_date','type'=>'date'),
		'payrec_num',
		'client_cd',
		array('name'=>'curr_amt','type'=>'number','htmlOptions'=>array('style'=>'text-align:right')),
		'remarks',
		'folder_cd',		
		/*
		'payrec_frto',
		'remarks',
		'user_id',
		'cre_dt',
		'upd_dt',
		'approved_sts',
		'approved_by',
		'approved_dt',
		'gl_acct_cd',
		'client_cd',
		'check_num',
		'folder_cd',
		'num_cheq',
		'client_bank_acct',
		'client_bank_name',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view}{update}{updateRemark}{delete}',
			'buttons'=>array(
				'updateRemark'=>array(
		        	'url' => 'Yii::app()->createUrl("/finance/'.$controllerId.'/updateRemark",array("id"=>$data->PrimaryKey))',			// AH : change      	
		            'icon'=> 'wrench',
		            'label'=> 'Update Remark'
		         ),
				 'delete'=>array(
		        	'url' => 'Yii::app()->createUrl("/finance/'.$controllerId.'/AjxPopDelete", array("id"=>$data->primaryKey))',			// AH : change
		        	'click'=>'js:function(e){
		            	e.preventDefault();
						showPopupModal("Cancel Reason",this.href);
		            }',
		        ),
			),
			'htmlOptions'=>array('style'=>'width:60px')
		),
	),
)); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>
