<style>
	.filter-group *
	{
		float:left;
	}
	#tableGen
	{
		background-color:#C3D9FF;
	}
	#tableGen thead, #tableGen tbody
	{
		display:block;
	}
	#tableGen tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	.markCancel
	{
		background-color:#BB0000;
	}
</style>

<?php
$this->breadcrumbs=array(
	'List of Market Info Fee Journal'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'List of Market Info Fee Journal', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
		array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/gljournalledger/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
	
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'treksnab-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	foreach($model as $row)
		echo $form->errorSummary(array($row)); 
?>




<br/>




<table id='tableGen' class='table-bordered table-condensed' style="width: 994px" >
	<thead>
		<tr>
			<th width="80px">Date</th>
			<th width="100px">File No.</th>
			<th width="300px">Remarks</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($model as $row){
		
	?>
		<tr id="row<?php echo $x ?>">
			<td width="80px">
			
			<?php echo $row->jvch_date;?>
		
			</td>
			<td width="100px">
			<?php echo $row->folder_cd ;?>
			
			</td>
			<td width="300px">
				<?php echo $row->remarks ;?>
			</td>
			
		</tr>
	<?php $x++;
} ?>
	</tbody>
</table>


<?php $this->endWidget(); ?>

