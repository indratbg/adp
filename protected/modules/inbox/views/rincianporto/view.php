<style>
	.right{
		text-align:center;
	}
</style>
<?php
$this->breadcrumbs=array(
	'Laporan Rincian Portofolio Inbox'=>array('index'),
	//$model->update_seq,
);

$this->menu=array(
	array('label'=>'View Laporan Rincian Portofolio Inbox ', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'Unprocessed','icon'=>'list','url'=>array('index'),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Processed','icon'=>'list','url'=>array('indexProcessed'),'itemOptions'=>array('style'=>'float:right')),
);
?>
<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h4>Laporan Rincian Portofolio</h4> 

<div class="row-fluid control-group" >
	<div class="span3" >
		<label>Nama Anggota Bursa Effek</label>
		<label>Kode Anggota Bursa Efek </label>
		<label>Tanggal Pelaporan </label>
		<label>Jumlah on Account di KSEI </label>
	</div>
	<div class="span7">
		<label>:&emsp;<?php echo $nama_ab ;?></label>
		<label>:&emsp;<?php echo $kode_ab ;?></label>
		<label>:&emsp;<?php echo $tanggal ;?></label>
		<label>:&emsp;<?php echo $jumlah_acct ;?></label>
	</div>
</div>


<table id='tableAcct' class='table table-bordered table-condensed' style="width: 100%">
	<thead>		
		<tr>
		<tr>
			<th colspan="3"></th>
			<th colspan="3" style="text-align: center">Portofolio (Unit)</th>
			<th colspan="3"  style="text-align: center">Nasabah (Unit)</th>
			<th colspan="1"></th>
		</tr>
			<th width="3%">No.</th>
			<th width="7%">Stk Cd</th>
			<th width="10%">Price</th>
			<th width="10%">Rek 001</th>
			<th width="10%">Rek 002</th>
			<th width="10%">Rek 004</th>
			<th width="10%">Rek 001</th>
			<th width="10%">Rek 002</th>
			<th width="10%">Rek 004</th>
			<th width="10%">Sub account Nasabah</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;

	foreach($modeldetail as $row){
	?>
		<tr>
			<td>
				<?php echo $x;?>
			</td>
			<td>
				<?php echo $row->stk_cd;?>
			</td>
			<td style="text-align:right">
				<?php echo $row->price;?>
			</td>
			<td style="text-align:right">
				<?php echo  number_format($row->port001,0,',','.');?>
			</td>
			<td style="text-align:right">
				<?php echo  number_format($row->port002,0,',','.');?>
			</td>
			<td style="text-align:right">
				<?php echo number_format($row->port004,0,',','.');?>
			</td>
			<td style="text-align:right">
				<?php echo  number_format($row->client001,0,',','.');?>
			</td>
			<td style="text-align:right">
				<?php echo number_format($row->client002,0,',','.');?>
			</td>
			<td style="text-align:right">
				<?php echo number_format($row->client004,0,',','.');?>
			</td>
			<td style="text-align:right">
				<?php echo number_format($row->subrek_qty,0,',','.');?>
				</td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>


<table id='tableAcct' class='table table-bordered table-condensed' style="width: 60%">
	<thead>
		
		
		<tr>
		<tr>
			<th colspan="3"></th>
			<th colspan="2" style="text-align: center">Warkat </th>
			<th colspan="2"  style="text-align: center">Kustodian lain</th>
			
		</tr>
			<th width="3%">No.</th>
			<th width="7%">Stk Cd</th>
			<th width="10%">Price</th>
			<th width="10%">Portofolio</th>
			<th width="10%">Nasabah</th>
			<th width="10%">Portofolio</th>
			<th width="10%">Nasabah</th>
			
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;

	foreach($modeldetail2 as $row){
	?>
		<tr>
			<td>
				<?php echo $x;?>
			</td>
			<td>
				<?php echo $row->stk_cd;?>
			</td>
			<td style="text-align:right">
				<?php echo $row->price;?>
			</td>
			<td style="text-align:right">
				<?php echo  number_format($row->port001,0,',','.');?>
			</td>
			<td style="text-align:right">
				<?php echo  number_format($row->port002,0,',','.');?>
			</td>
			<td style="text-align:right">
				<?php //echo number_format($row->port004,0,',','.');?>
			</td>
			<td style="text-align:right">
				<?php echo number_format($row->port004,0,',','.');?>
			</td>
			
		</tr>
	<?php $x++;} ?>
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
			//'id'=>'btnApprove',
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
