<?php
$this->breadcrumbs=array(
	'Contract Avg Price Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'Contract Avg Price Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>

<h1>View Contract Avg Price Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>From</h4> 

<table id='table-data' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th>Contract Date</th>
			<th>Beli / Jual</th>
			<th>Client Code</th>
			<th>Stock Code</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Commission %</th>
			<th>Due Date</th>
			<th>Sales</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelDetailCancel as $row){
			if(!empty($row->contr_dt)){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo DateTime::createFromFormat('Y-m-d',$row->contr_dt)->format('d M Y');?></td>
			<td><?php echo AConstant::$contract_belijual[substr($row->contr_num,4,1)]?></td>
			<td><?php echo $row->client_cd;?></td>
			<td><?php echo $row->stk_cd;?></td>
			<td style="text-align: right;"><?php echo number_format($row->qty,0);?></td>
			<td style="text-align: right;"><?php echo number_format($row->price,0);?></td>
			<td style="text-align: right;"><?php echo $row->brok_perc/100;?></td>
			<td><?php echo DateTime::createFromFormat('Y-m-d',$row->due_dt_for_amt)->format('d M Y');?></td>
			<td><?php echo $row->rem_cd;?></td>
		</tr>
	<?php $x++;}} ?>
	</tbody>
</table>

<h4>To</h4> 

<table id='table-data' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th>Contract Date</th>
			<th>Beli / Jual</th>
			<th>Client Code</th>
			<th>Stock Code</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Commission %</th>
			<th>Due Date</th>
			<th>Sales</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelDetail as $row){
			if(!empty($row->contr_dt)){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo DateTime::createFromFormat('Y/m/d H:i:s',$row->contr_dt)->format('d M Y');?></td>
			<td><?php echo AConstant::$contract_belijual[substr($modelDetailCancel[1]->contr_num,4,1)]?></td>
			<td><?php echo $row->client_cd;?></td>
			<td><?php echo $row->stk_cd;?></td>
			<td style="text-align: right;"><?php echo number_format($row->qty,0);?></td>
			<td style="text-align: right;"><?php echo number_format($row->price,0);?></td>
			<td style="text-align: right;"><?php echo $row->brok_perc/100;?></td>
			<td><?php echo DateTime::createFromFormat('Y/m/d H:i:s',$row->due_dt_for_amt)->format('d M Y');?></td>
			<td><?php echo $row->rem_cd;?></td>
		</tr>
	<?php $x++;}} ?>
	</tbody>
</table>

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

