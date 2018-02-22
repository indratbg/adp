<style>
	#tableConsol
	{
		background-color:#C3D9FF;
	}
	#tableConsol thead, #tableConsol tbody
	{
		display:block;
	}
	#tableConsol tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
</style>
<?php
$this->breadcrumbs=array(
	'Laporan Keuangan Konsolidasi Entry',
);
?>
<?php
$this->menu=array(
	
	array('label'=>'Laporan Keuangan Konsolidasi Entry', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
//	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/Lapkeuanganconsol/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
);

?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Laptrxharian-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br />
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting()?>
<?php echo $form->errorSummary(array($model));?>
<?php foreach($modeldetail as $row)echo $form->errorSummary(array($row));?>
<div class="row-fluid">
	<div class="span5">
<?php echo $form->datePickerRow($model,'report_date',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>		
	</div>
	<div class="span6">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Retrieve',
				'htmlOptions'=>array('id'=>'filter','class'=>'btn btn-small','style'=>'margin-left:-20%;')
			)); ?>
				<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=> 'Save',
				'htmlOptions'=>array('id'=>'save','class'=>'btn btn-small','style'=>'margin-left:2%;')
			)); ?>
	</div>
</div>
<input type="hidden" name="rowCount" id="rowCount" />
	<input type="hidden" name="scenario" id="scenario" />
	<table id="tableConsol"  class="table-bordered table-condensed">
		<thead>
		<tr>
			<th width="2%">Line</th>
			<th width="2%">Col1</th>
			<th width="25%">Col2</th>
			<th width="3%">Update</th>
			<th width="22%">Col4</th>
			<th width="9%">Col5</th>
			<th width="9%">Col6</th>
			<th width="9%">Col7</th>
			<th width="9%">Col8</th>
			<th width="10%">Col9</th>
		</tr>
	<thead>
		<tbody>
	<?php $x=1; 
	foreach($modeldetail as $row){?>
		<tr>
			<td style="text-align: right">
				<?php echo $row->line_num ?>
				<?php echo $form->textField($row,'line_num',array('name'=>'Tlkrep['.$x.'][line_num]','class'=>'span','style'=>'display:none'));?>
				<?php //echo $form->textField($row,'old_line_num',array('name'=>'Tlkrep['.$x.'][old_line_num]','class'=>'span','style'=>'display:none'));?>
			</td>
			<td>
				<?php echo $row->col1 ?>
				<?php echo $form->textField($row,'col1',array('name'=>'Tlkrep['.$x.'][col1]','class'=>'span','style'=>'display:none'));?>
			</td>
			<td>
				<?php echo $form->textField($row,'col2',array('name'=>'Tlkrep['.$x.'][col2]','class'=>'span'));?>
			</td>
			<td style="text-align: center" class="saveFlg">
				<?php echo $form->checkBox($row,'save_flg',array('class'=>'saveCheck','name'=>'Tlkrep['.$x.'][save_flg]','value'=>'Y')); ?>
			</td>
			<td>
				<?php echo $form->textField($row,'col4',array('name'=>'Tlkrep['.$x.'][col4]','class'=>'span'));?>
			</td>
			<td>
				<?php echo $form->textField($row,'col5',array('name'=>'Tlkrep['.$x.'][col5]','class'=>'span tnumber','style'=>'text-align:right;'));?>
			</td>
			<td>
				<?php echo $form->textField($row,'col6',array('name'=>'Tlkrep['.$x.'][col6]','class'=>'span tnumber','style'=>'text-align:right;'));?>
			</td>
			<td>
				<?php echo $form->textField($row,'col7',array('name'=>'Tlkrep['.$x.'][col7]','class'=>'span tnumber','style'=>'text-align:right;'));?>
			</td>
			<td>
				<?php echo $form->textField($row,'col8',array('name'=>'Tlkrep['.$x.'][col8]','class'=>'span tnumber','style'=>'text-align:right;'));?>
			</td>
			<td>
				<?php echo $form->textField($row,'col9',array('name'=>'Tlkrep['.$x.'][col9]','class'=>'span tnumber','style'=>'text-align:right;'));?>
			</td>
		</tr>
		
	<?php $x++; }?>
		</tbody>
</table>



<?php $this->endWidget()?>

<script>

var rowCount = '<?php echo count($modeldetail)?>'
	
	init();
	function init(){
		if(rowCount==0)
		{
		$('#tableConsol').hide();	
		
		}
		else
		{
		$('#tableConsol').show();
		
		}
	}
	$(window).resize(function() {
		alignColumn();
	})
	$(window).trigger('resize');
	
	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableConsol").find('thead');
		var firstRow = $("#tableConsol").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() + 'px');
		firstRow.find('td:eq(9)').css('width',(header.find('th:eq(9)').width())-17 + 'px');
		
	}
	$('#filter').click(function(){
		$('#scenario').val('filter');
	})
	$('#save').click(function(){
		$('#rowCount').val(rowCount);
		$('#scenario').val('save');
	})
	
	
	$('.saveCheck').change(function(){
		checkUpd();
	})
	
	
	
	
	checkUpd();
	
	function checkUpd()
	{
		
		var x=0;
	$("#tableConsol").children('tbody').children('tr').each(function()
	{
			var saveFlg=$(this).children('td.saveFlg').children('[type=checkbox]').is(':checked');
			
			if(saveFlg)
			{
			x = 1;
			return false;
			}	
	});
	
	if(x==1)
	{
	$('#save').prop('disabled',false);	
	}
	else
	{
	$('#save').prop('disabled',true);
	}
	
	}
		
	
</script>