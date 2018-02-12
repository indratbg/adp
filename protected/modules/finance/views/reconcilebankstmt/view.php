<?php
$this->breadcrumbs=array(
	'Reconcile Bank Account Statement'=>array('index'),
	//$model[0]->period_from,
);

$this->menu=array(
	array('label'=>'View Reconcile Bank Account Statement '.$model[0]->period_from, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	//array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	//array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model[0]->period_from),'itemOptions'=>array('style'=>'float:right')),
	//array('label'=>'View','url'=>array('view','id'=>$model[0]->period_from),'icon'=>'eye-open','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);

?>
<br /><br/>

<table id='tableLedger' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="30px">Period Date</th>
			<th width="80px">Trx Date</th>
			<th width="100px">Gl Acct Cd</th>
			<th width="100px">Sl Acct Cd</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($model as $row){
			
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo $row->period_from ?></td>
			<td><?php echo $row->trx_date ?></td>
			<td><?php echo $row->gl_acct_cd ?></td>
			<td><?php echo $row->sl_acct_cd ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>
