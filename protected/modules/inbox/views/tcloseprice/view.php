<?php
$this->breadcrumbs=array(
	'Close Price Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'Close Price Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>

<h1>View Close Price Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Data Close Price</h4> 

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$modelDetail,
	'attributes'=>array(
		          array('name'=>'stk_date','type'=>'date'),
                   'stk_cd',
                    'stk_name',
                    array('name'=>'stk_prev','type'=>'number'),
                    array('name'=>'stk_high','type'=>'number'),
                    array('name'=>'stk_low','type'=>'number'),
                    array('name'=>'stk_clos','type'=>'number'),
                    array('name'=>'stk_volm','type'=>'number'),
                    array('name'=>'stk_amt','type'=>'number'),
                    array('name'=>'stk_indx','type'=>'number'),
                    array('name'=>'stk_pidx','type'=>'number'),
                    array('name'=>'stk_askp','type'=>'number'),
                    array('name'=>'stk_askv','type'=>'number'),
                    array('name'=>'stk_askf','type'=>'number'),
                    array('name'=>'stk_bidp','type'=>'number'),
                    array('name'=>'stk_bidv','type'=>'number'),
                    array('name'=>'stk_bidf','type'=>'number'),
                    array('name'=>'stk_open','type'=>'number'),
                    'isin_code'
	),
)); ?>

<h4>Approval Attributes</h4>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array('name'=>'status','value'=>AConstant::$inbox_stat[$model->status]),
				array('name'=>'update_date','type'=>'datetime'),
				'user_id',
				'ip_address',
				array('name'=>'cancel_reason','type'=>'raw','value'=>nl2br($model->cancel_reason)),
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$model,
			'attributes'=>array(
				array('name'=>'approved_status','value'=>AConstant::$inbox_app_stat[$model->approved_status]),
				array('name'=>'approved_date','type'=>'datetime'),
				'approved_user_id',
				array('name'=>'reject_reason','type'=>'raw','value'=>nl2br($model->reject_reason)),
			),
		)); ?>
	</div>
</div>

<?php if($model->approved_status == AConstant::INBOX_APP_STAT_ENTRY): ?>	
	<br/>
	<div style="text-align:right;">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'secondary',
			'icon'=>'ok',
			'url'=>$this->createUrl('approve',array('id'=>$model->primaryKey)),
			'label'=>'Approve',
		)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'secondary',
			'icon'=>'remove',
			'url'=>$this->createUrl('reject',array('id'=>$model->primaryKey)),
			'htmlOptions'=>array('class'=>'reject-inbox'),
			'label'=>'Reject',
		)); ?>
	</div>
	<?php 
		$param  = array(array('class'=>'reject-inbox','title'=>'Reject Reason','url'=>'AjxPopReject','urlparam'=>array('id'=>$model->primaryKey,'label'=>false)));
	  	AHelper::popupwindow($this, 600, 500, $param);
	?>
<?php endif; ?>
