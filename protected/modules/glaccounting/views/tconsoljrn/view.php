<?php
$this->breadcrumbs=array(
	'Consolidation Journal Entry'=>array('index'),
	$model[0]->xn_doc_num,
);
/*
$this->menu=array(
	array('label'=>'GL Journal Entry', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','id'=>$model->jvch_num)),
);
*/



$this->menu=array(
	array('label'=>'View Consolidation Journal '.$model[0]->xn_doc_num, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','xn_doc_num'=>$model[0]->xn_doc_num,'doc_date'=>$model[0]->doc_date),'itemOptions'=>array('style'=>'float:right')),
	array('label'=>'View','url'=>array('view','xn_doc_num'=>$model[0]->xn_doc_num,'doc_date'=>$model[0]->doc_date),'icon'=>'eye-open','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);


?>



<?php AHelper::showFlash($this) ?> <!-- show flash -->

<h3>Primary Attributes</h3>





<br/>
<table id='tableAcct' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="30px">Journal Code</th>
			<th width="80px">Date</th>
			<th width="30px">No. Urut</th>
			<th width="30px">Entity</th>
			<th width="40px">Gl Main Acct Cd</th>
			<th width="40px">Sl Acct Cd</th>
			<th width="30px">Debit/Credit</th>
			<th width="100px">Amount</th>
			<th width="210px">Description</th>
			
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($model as $row){
			if(DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_date))$row->doc_date=DateTime::createFromFormat('Y-m-d H:i:s',$row->doc_date)->format('d M Y'); 
	?>
		
			<tr id="row<?php echo $x ?>">
			<td>
				<?php echo $row->xn_doc_num ?>
			</td>
			<td>
				<?php  echo $row->doc_date ?>
			</td>
			<td><?php echo $row->tal_id ?></td>
			<td><?php echo $row->entity?></td>
			<td><?php echo $row->gl_acct_cd ?></td>
			<td><?php echo $row->sl_acct_cd?></td>
			<td><?php echo Constanta::$gljournal[$row->db_cr_flg] ?></td>
			<td style="text-align: right">
				<?php echo number_format((float)$row->curr_val,2,'.',',') ?>
			</td>
			<td>
				<?php echo $row->ledger_nar ?>
			</td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model[0],
	'attributes'=>array(
		array('name'=>'cre_dt','type'=>'date'),
		'user_id',
		array('name'=>'upd_dt','type'=>'datetime'),
		'upd_by',
	),
)); ?>
