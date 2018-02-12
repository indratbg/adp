<?php
$this->breadcrumbs=array(
	'Tinterestrates'=>array('index'),
	$modelClient->client_cd,
);

/*
$this->menu=array(
	array('label'=>'Tinterestrate', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','icon'=>'list','url'=>array('index')),
	//array('label'=>'Create','icon'=>'plus','url'=>array('create')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','client_cd'=>$modelClient->client_cd)),
);

*/



$this->menu=array(
	array('label'=>'View Interest Rate '.$modelClient->client_cd, 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	//array('label'=>'Create', 'url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'View','url'=>array('view','client_cd'=>$modelClient->client_cd),'icon'=>'eye-open','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Update','icon'=>'pencil','url'=>array('update','client_cd'=>$modelClient->client_cd),'itemOptions'=>array('class'=>'active','style'=>'float:right')),
);


?>

<br/>

<?php AHelper::showFlash($this) ?> <!-- show flash -->

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'bankMaster',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<div class="row-fluid">
		
		<div class="span4">
<?php echo $form->label($modelClient,'client_cd',array('class'=>'control-label','style'=>'font-weight:bold')); ?>
<?php echo $form->textFieldRow($modelClient,'client_cd',array('class'=>'span5','readonly'=>'readonly','label'=>false)) ?>

	</div>
		<div class="span8">
			<div class="span2" style="margin-right:-3px">
				
<?php echo $form->label($modelClient,'client_name',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
</div>
<?php echo $form->textFieldRow($modelClient,'client_name',array('class'=>'span5','readonly'=>'readonly','label'=>false)) ?>
</div>


	</div>

<div class="row-fluid">
	<div class="span4">
		<?php echo $form->label($modelClient,'branch_code',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelClient,'branch_code',array('class'=>'span4','readonly'=>'readonly','label'=>false)) ?>
	</div>
	<div class="span8">
		<div class="span1">
			<?php echo $form->label($modelClient,'Client Type',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		</div>
		<div class="span2">
	<?php echo $form->textFieldRow($modelClient,'client_type',array('class'=>'span','readonly'=>'readonly','label'=>false,'value'=>$modelClient->client_type_1.$modelClient->client_type_2.$modelClient->client_type_3)) ?>
	</div>
	<?php echo $form->textFieldRow($modelClient,'Client Type',array('class'=>'span4','readonly'=>'readonly','label'=>false,'value'=>Lsttype3::model()->find("cl_type3 = '$modelClient->client_type_3'")->cl_desc)); ?>
</div>
</div>



<?php //echo $form->label($modelClient,'Client Type',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
<?php //echo $form->textFieldRow($modelClient,'Client Type',array('class'=>'span4','readonly'=>'readonly','label'=>false,'value'=>Lsttype3::model()->find("cl_type3 = '$modelClient->client_type_3'")->cl_desc)); ?>

<div class="row-fluid">
	<div class="span4">
		<?php echo $form->label($modelClient,'Calculation Mode',array('class'=>'control-label','style'=>'font-weight:bold')) ?>
		<?php echo $form->textFieldRow($modelClient,'amt_int_flg',array('class'=>'span4','readonly'=>'readonly','label'=>false,'value'=>$modelClient->amt_int_flg=='Y'?'System':'Manual')) ?>
	</div>
	<div class="span4">
		<div class="span4">
			<label class="control-label" style="font-weight:bold">PPH</label>
		</div>
		<?php echo $form->textFieldRow($modelClient,'tax_on_interest',array('class'=>'span4','readonly'=>'readonly','label'=>false,'value'=>$modelClient->tax_on_interest=='Y'?'Yes':'No')) ?>
		<?php //echo $form->textFieldRow($modelClient,'int_accumulated',array('class'=>'span4','readonly'=>'readonly','label'=>false,'value'=>$modelClient->int_accumulated=='Y'?'Majemuk':'Tunggal')) ?>
	</div>
</div>
	
<div class="row-fluid">
	<div class="span4">
		<label class="control-label" style="font-weight:bold">AR%</label>
		<?php echo $form->textFieldRow($modelClient,'int_rec_days',array('class'=>'span4','readonly'=>'readonly','label'=>false,'style'=>'text-align:right')); ?>
	</div>
	<div class="span4">
		<div class="span4">
			<label class="control-label" style="font-weight:bold">AP%</label>
		</div>
	<?php echo $form->textFieldRow($modelClient,'int_pay_days',array('class'=>'span4','readonly'=>'readonly','label'=>false,'style'=>'text-align:right')); ?>
	</div>
</div>
	

<?php $this->endWidget(); ?>

<br/>

<?php if($model){ ?>
<table id='tableInt' class='table table-bordered table-condensed' style="width:70%;">
	<thead>
		<tr>
			
			<th width="200px">Effective Date</th>
			<th width="100px">AR%</th>
			<th width="100px">AP%</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($model as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
		
			<td><?php echo Tmanydetail::reformatDate($row->eff_dt) ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::ReformatNumber($row->int_on_receivable) ?></td>
			<td style="text-align:right"><?php echo Tmanydetail::ReformatNumber($row->int_on_payable) ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>
<?php } ?>


<h3>Identity Attributes</h3>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$modelClient,
	'attributes'=>array(
		'cre_dt',
		'user_id',
		'upd_dt',
		'upd_by',
	),
)); ?>
