<style>
		#option > label
	{
		width:165px;
		margin-left:-19px;
	}
	
	#option > label > label
	{
		float:left;
		margin-top:5px;
		margin-left:-20px;
	}
		#option > label > input
	{
		float:left;
	}
	
	
	.tableContr
	{
		background-color:#C3D9FF;
	}
	.tableContr thead, .tableContr tbody
	{
		display:block;
	}
	.tableContr tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	/*
	.radio.inline{
		width: 130px;
	}*/
	
#tableContr thead tr th{
	vertical-align: bottom;
}




	
</style>
<?php
$this->breadcrumbs=array(
	'Update Stock On-hand'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Update Stock On-hand', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//	array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/gljournalledger/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
	
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'transferarap-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<br/>
<?php echo $form->errorSummary($model); ?>
<?php foreach($modelDetail as $row)echo $form->errorSummary(array($row));?>

<input type="hidden" name="scenario" id="scenario"/>
<input type="hidden" name="rowCount" id="rowCount"/>

<div class="row-fluid control-group">
	<div class="span1">
		<label>Due Date</label>
	</div>	
	<div class="span3">
		
<?php echo $form->datePickerRow($model,'trx_dt',array('label'=>false,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>		
	
	</div>
<div class="span6" style="margin-left: -50px">
	<?php echo $form->radioButtonListInlineRow($model,'grp',array('0'=>'All Transaction','1'=>'Selected Transaction'),array('id'=>'option','class'=>'span5 option','label'=>false)); ?>
</div>
</div>

<div class="row-fluid control-group">
	<div class="span2">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Retrieve',
			'id'=>'btnFilter',
			'htmlOptions'=>array('class'=>' btn-small')
		)); ?>
	</div>
	<div class="span2">
			
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Process',
			'id'=>'btnProses',
			'htmlOptions'=>array('class'=>'btn-small')
		)); ?>
	</div>
</div>

	
	
	<br/>
	<table id='tableContr' class='table-bordered table-condensed tableContr'>
			<thead>
				<tr>
				<th width="160px">Contr Num</th>
				<th width="120px">Trx Date</th>
				<th width="120px">Due Date</th>
				<th width="110px">Client</th>
				<th width="30px">B/S</th>
				<th width="60px">Stock</th>
				<th width="40px">L F</th>
				<th width="90px">Price</th>
				<th width="100px">Qty</th>
				<th width="120px">Settle Qty</th>
				<th width="120px">Entry Qty</th>
				<th width="30px"><input type="checkbox" name="checkAll" id="checkAll" /></th>
				
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelDetail as $row){ 
		?>
			<tr id="row<?php echo $x ?>">
				<td>
				<?php echo $form->textField($row,'contr_num',array('name'=>'Updstkhand['.$x.'][contr_num]','class'=>'span','readonly'=>true)) ;?>
				</td>
				<td>
				<?php echo $form->textField($row,'contr_dt',array('name'=>'Updstkhand['.$x.'][contr_dt]','class'=>'span','readonly'=>true)) ;?>
				</td>
				<td>
					<?php echo $form->textField($row,'due_dt_for_amt',array('class'=>'span','name'=>'Updstkhand['.$x.'][due_dt_for_amt]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'Updstkhand['.$x.'][client_cd]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'bs',array('style'=>'font-weight:bold','class'=>'span','name'=>'Updstkhand['.$x.'][bs]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'stk_cd',array('class'=>'span','name'=>'Updstkhand['.$x.'][stk_cd]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'status',array('style'=>'font-weight:bold','class'=>'span','name'=>'Updstkhand['.$x.'][status]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'price',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Updstkhand['.$x.'][price]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'qty',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Updstkhand['.$x.'][qty]','readonly'=>true)); ?>
					
				</td>
				<td>
					<?php echo $form->textField($row,'sett_qty',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Updstkhand['.$x.'][sett_qty]','readonly'=>true)); ?>
				</td>
				<td >
					<?php echo $form->textField($row,'entry_qty',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Updstkhand['.$x.'][entry_qty]','readonly'=>false)); ?>
				</td>
				<td class="save_flg">
					<?php echo $form->checkBox($row,'save_flg',array('class'=>'checkDetail','value' => 'Y','name'=>'Updstkhand['.$x.'][save_flg]')); ?>
				</td>
				
			
			</tr>
		<?php $x++;} ?>
	
		</tbody>
	</table>
	
	
	
<?php $this->endWidget()?>

<script>
var rowCount = '<?php echo count($modelDetail);?>';

	init();
	function init()
	{
		option();
		if(rowCount>0)
		{
			$('#tableContr').show();
		}
		else
		{
			$('#tableContr').hide();
		}	
	}
	
	$('.option').change(function(){
		option();
		
	});
	
	$('#btnFilter').click(function(){
		$('#scenario').val('filter');
	})
	$('#btnProses').click(function(){
		$('#scenario').val('proses');
	})
	
	$(window).resize(function() {
		alignColumn();
		
	})
	$(window).trigger('resize');
	
	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableContr").find('thead');
		var firstRow = $("#tableContr").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() +'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() +'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() +'px');
		firstRow.find('td:eq(9)').css('width',header.find('th:eq(9)').width() +'px');
		firstRow.find('td:eq(10)').css('width',header.find('th:eq(10)').width() +'px');
		firstRow.find('td:eq(11)').css('width',header.find('th:eq(11)').width()-17 +'px');
		
	}
	
	
	
	function option(){
		
		if($('#Updstkhand_grp_0').is(':checked'))
		{
		$('#btnProses').prop('disabled',false);
		$('#btnFilter').prop('disabled',true);	
		}
		else
		{
		$('#btnProses').prop('disabled',false);
		$('#btnFilter').prop('disabled',false);	
		}
	}
	$('#btnProses').click(function(){
		$('#scenario').val('proses');
		$('#rowCount').val(rowCount);
	})
	
	$('#checkAll').change(function(){
		if($('#checkAll').is(':checked'))
		{
			$('.checkDetail').prop('checked',true);
		}
		else
		{
			$('.checkDetail').prop('checked',false);
		}
	})
	$('.checkDetail').change(function(){
		
		checkAll();
	})
	function checkAll()
	{
		var safe=1;
		$("#tableContr").children('tbody').children('tr').each(function()
		{
			if($(this).children('td.save_flg').children('[type=checkbox]').length)
			{
			var save_flg = $(this).children('td.save_flg').children('[type=checkbox]').is(':checked');	
			
			//console.log(save_flg);
			if(!save_flg)
			{	
				safe=0;
				
				return false;
			}
			}
			
			
		});
		if (safe==0)
		{
		$('#checkAll').prop('checked',false);	
		}
		else
		{
		$('#checkAll').prop('checked',true);	
		}
	}
</script>
