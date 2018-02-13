<?php
$this->breadcrumbs=array(
	'Deposit Client Entry'=>array('index'),
	$model[0]->folder_cd,
);

$this->menu=array(
	array('label'=>'View Deposit Client Entry '.$model[0]->folder_cd, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model[0]->doc_num),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'View','url'=>array('view','id'=>$model[0]->doc_num),'icon'=>'eye-open','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);


?>



<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>

<table id='tableAcct' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="30px">Trx Date</th>
			<th width="80px">Client Cd</th>
			<th width="100px">Debit</th>
			<th width="50px">Credit</th>
			<th width="300px">No. Perjanjian</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($model as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo $row->trx_date ?></td>
			<td><?php echo $row->client_cd ?></td>
			<td style="text-align: right;"><?php echo number_format((float)$row->credit,2,',','.') ?></td>
			<td style="text-align: right;"><?php echo number_format((float)$row->debit,2,',','.') ?></td>
			<td><?php echo $row->no_perjanjian ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>

<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'cre_dt','type'=>'date'),
		'user_id',
		array('name'=>'upd_dt','type'=>'datetime'),
		'upd_by',
	),
)); ?>
