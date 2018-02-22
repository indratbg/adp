<?php
$this->breadcrumbs=array(
	'Bond Transactions Inbox'=>array('index'),
	$model->update_seq,
);

$this->menu=array(
	array('label'=>'Bond Transactions Inbox', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed')),
);
?>

<h1>View Bond Transaction Inbox #<?php echo $model->update_seq; ?></h1>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php if ($modelDetailSell){?>
<h4>Data Sold Outstanding Buy</h4>
<table id='table-data' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th>Trx Date</th>
			<th>Trx ID</th>
			<th>Bond</th>
			<th>Counterpart</th>
			<th>Sisa Nominal Before Sell</th>
			<th>Sold Nominal</th>
			<th>Sisa Nominal After Sell</th>
			<th>Price</th>
			<th>Trx Ref</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		$totalnominal = 0;
		$totalnominalxprice = 0;
		$averageprice = 0;
		foreach($modelDetailSell as $row){
			if(!empty($row->trx_date)){
			$totalnominal = $totalnominal + $row->sisa_temp; 
			$totalnominalxprice = $totalnominalxprice + ($row->sisa_temp * $row->price);
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo DateTime::createFromFormat('Y/m/d H:i:s',$row->trx_date)->format('d M Y');?></td>
			<td><?php echo $row->trx_id?></td>
			<td><?php echo $row->bond_cd;?></td>
			<td>BUY from <?php echo $row->lawan;?></td>
			<td style="text-align: right;"><?php echo number_format($row->sisa_nominal,0);?></td>
			<td style="text-align: right;"><?php echo number_format($row->sisa_temp,0);?></td>
			<td style="text-align: right;"><?php echo number_format($row->sisa_nominal - $row->sisa_temp,0);?></td>
			<td style="text-align: right;"><?php echo $row->price;?></td>
			<td><?php echo $row->trx_ref;?></td>
		</tr>
	<?php $x++;}
		$averageprice = $totalnominalxprice / $totalnominal;
		} ?>
		<tr id="rowtotal">
			<td colspan="4">&nbsp;</td>
			<td><strong>Total Nominal</strong></td>
			<td style="text-align: right;"><?php echo number_format($totalnominal,0);?></td>
			<td><strong>Average Price</strong></td>
			<td style="text-align: right;"><?php echo number_format($averageprice,2);?></td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>
	
<?php }?>

<h4>Data Bond Transactions</h4>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetailNew,
			'attributes'=>array(
				'trx_type',
				'trx_id',
				'trx_ref',
				'trx_id_yymm',
				'ctp_num',
				array('name'=>'trx_date','type'=>'date'),
				array('name'=>'value_dt','type'=>'date'),
				'custodian_cd',
				'settlement_instr',
				'lawan_type',
				'lawan',
									
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetailNew,
			'attributes'=>array(
				array('name'=>'int_rate','value'=>$modelDetailNew->int_rate*100),
				array('name'=>'nominal','value'=>number_format($modelDetailNew->nominal,0)),
				array('name'=>'Price','value'=>$modelDetailNew->price.' %'),
				array('name'=>'cost','value'=>number_format($modelDetailNew->cost,0)),
				'bond_cd',
				array('name'=>'last_coupon','type'=>'date'),
				array('name'=>'next_coupon','type'=>'date'),
			),
		)); ?>
	</div>
</div>
<h4>Accrued Interest</h4>
<div class="row-fluid">
	<div class="span6">
		
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetailNew,
			'attributes'=>array(
				'accrued_days',
				'accrued_int_round',
				array('name'=>'accrued_int','value'=>number_format($modelDetailNew->accrued_int,0)),
			),
		)); ?>
	</div>
</div>

<h4>Accrued Interest Tax</h4>
<div class="row-fluid">
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetailNew,
			'attributes'=>array(
				'accrued_tax_days',
				'accrued_tax_round',
				array('name'=>'accrued_tax_pcn','value'=>($modelDetailNew->accrued_tax_pcn*100).' %'),
				array('name'=>'accrued_int_tax','value'=>number_format($modelDetailNew->accrued_int_tax,0)),
				array('name'=>'capital_gain','value'=>number_format($modelDetailNew->capital_gain,0)),
				array('name'=>'capital_tax_pcn','value'=>($modelDetailNew->capital_tax_pcn*100).' %'),
				array('name'=>'capital_tax','value'=>number_format($modelDetailNew->capital_tax,0)),
				array('name'=>'multi_buy_price','value'=>$modelDetailNew->multi_buy_price == 'Y'?'Yes' : 'No'),
				array('name'=>'Purchase Price','value'=>$modelDetailNew->multi_buy_price == 'Y'?'-' : ($modelDetailNew->buy_price.' %')),
			),
		)); ?>
	</div>
	<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbDetailView',array(
			'data'=>$modelDetailNew,
			'attributes'=>array(
				array('name'=>'buy_dt','type'=>'date'),
				'buy_trx_seq',
				array('name'=>'buy_value_dt','type'=>'date'),
				array('name'=>'seller_buy_dt','type'=>'date'),
				array('name'=>'net_capital_gain','value'=>number_format($modelDetailNew->net_capital_gain,0)),
				array('name'=>'net_amount','value'=>number_format($modelDetailNew->net_amount,0)),
				'sign_by'
			),
		)); ?>
	</div>
</div>
<?php if ($modelDetailMultiprice){?>
<h4>Data Multiple Purchase Price</h4>
<table id='table-data' class='table table-bordered table-condensed' style="width: 60%">
	<thead>
		<tr>
			<th>Nominal</th>
			<th>Purchase Price</th>
			<th>Purchase Date</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelDetailMultiprice as $row){
	?>
		<tr id="row<?php echo $x ?>">
			<td style="text-align: right;"><?php echo number_format($row->nominal,0);?></td>
			<td style="text-align: right;"><?php echo $row->buy_price;?></td>
			<td><?php echo DateTime::createFromFormat('Y/m/d H:i:s',$row->buy_dt)->format('d M Y');?></td>
		</tr>
	<?php $x++;}
		?>
	</tbody>
</table>
	
<?php }?>

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
