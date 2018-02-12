<style>
	
	#tableReport
	{
		background-color:#C3D9FF;
	}
	#tableReport thead, #tableReport tbody
	{
		display:block;
	}
	#tableReport tbody
	{
		height:250px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	
	
	
</style>
<?php
$this->breadcrumbs=array(
	'Bond Trade Confirmation'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Bond Trade Confirmation', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),

	
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Rptbondtradeconf-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<?php echo $form->errorSummary($model); ?>
<input type="hidden" name="scenario" id="scenario"/>
<input type="hidden" name="rowCount" id="rowCount"/>
<br/>
<div class="row-fluid">
	<div class="control-group">
	
		<div class="span1">
			<label>Transaction Date From</label>
		</div>
		<div class="span2">
			<?php echo $form->textField($model,'bgn_dt',array('placeholder'=>'dd/mm/yyyy','class'=>'span10 tdate'));?>
			
		</div>
		<div class="span2">
			To &nbsp;
			<?php echo $form->textField($model,'end_dt',array('placeholder'=>'dd/mm/yyyy','class'=>'span10 tdate'));?>
		</div>
		<div class="span2">
			<?php echo $form->checkBox($model,'bond_option',array('value'=>'ALL'));?>
			&nbsp; All ID
			&emsp;
			ID
			<?php echo $form->textField($model,'bond_id',array('class'=>'span4'));?>
		</div>
		<div class="span1">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'htmlOptions'=>array('id'=>'btnFilter','style'=>'margin-left:0px;','class'=>'btn btn-small btn-primary'),
					'label'=>'Retrieve',
				)); ?>
		</div>
	</div>
</div>



<br/>

<table id='tableReport' class='table-bordered table-condensed'  >
	<thead>
		<tr>
			<th width="100px">Trx Date</th>
			<th width="100px">Value Date</th>
			<th width="50px">Trx ID</th>
			<th width="260px">Trx Ref</th>
			<th width="120px">Seller</th>
			<th width="120px">Buyer</th>
			<th width="150px">Bond Cd</th>
			<th width="150px">Nominal</th>
			<th width="150px">Price (%)</th>
			<th width="100px"><input type="checkbox" id="checkAll" value="1" style="margin-left: 10px;" onclick= "changeAll()"/></th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modeldetail as $row){
			
	?>
		<tr id="row<?php echo $x ?>">
			<td>
			<?php echo $row->trx_date ;?>
			<?php echo $form->textfield($row,'trx_date',array('name'=>'Tbondtrx['.$x.'][trx_date]','style'=>'display:none;'));?>
			<?php echo $form->textfield($row,'trx_seq_no',array('name'=>'Tbondtrx['.$x.'][trx_seq_no]','style'=>'display:none;'));?>
			<?php echo $form->textfield($row,'doc_num',array('name'=>'Tbondtrx['.$x.'][doc_num]','style'=>'display:none;'));?>
			</td>
			<td>
			<?php echo $row->value_dt ;?>
			<?php echo $form->textfield($row,'value_dt',array('name'=>'Tbondtrx['.$x.'][value_dt]','style'=>'display:none;'));?>
			</td>
			<td >
				<?php echo $row->trx_id ;?>
				<?php echo $form->textfield($row,'trx_id',array('name'=>'Tbondtrx['.$x.'][trx_id]','style'=>'display:none;'));?>
			</td>
			<td >
			<?php echo $row->trx_ref ;?>
			<?php echo $form->textfield($row,'trx_ref',array('name'=>'Tbondtrx['.$x.'][trx_ref]','style'=>'display:none;'));?>
			</td>
			<td >
			<?php echo $row->seller;?>
			<?php echo $form->textfield($row,'seller',array('name'=>'Tbondtrx['.$x.'][seller]','style'=>'display:none;'));?>
			</td>
			<td>
				<?php echo $row->buyer ;?>
				<?php echo $form->textfield($row,'buyer',array('name'=>'Tbondtrx['.$x.'][buyer]','style'=>'display:none;'));?>
			</td>
			<td>
				<?php echo $row->bond_cd ;?>
				<?php echo $form->textfield($row,'bond_cd',array('name'=>'Tbondtrx['.$x.'][bond_cd]','style'=>'display:none;'));?>
			</td>
			<td style="text-align: right">
				<?php echo number_format($row->nominal,0,',','.') ;?>
				<?php echo $form->textfield($row,'nominal',array('name'=>'Tbondtrx['.$x.'][nominal]','style'=>'display:none;'));?>
			</td>
			<td style="text-align: right">
				<?php echo number_format((float)$row->price,6,',','.') ;?>
				<?php echo $form->textfield($row,'price',array('name'=>'Tbondtrx['.$x.'][price]','style'=>'display:none;'));?>
			</td>
			<td class="saveFlg">
				<?php echo $form->checkBox($row,'save_flg',array('class'=>'checkBoxDetail','id'=>'save_flg_'.$x.'','value' => 'Y','name'=>'Tbondtrx['.$x.'][save_flg]','style'=>'margin-left:10px;')); ?>
				
			</td>
		</tr>
		
	<?php 
	$x++;
} ?>
	</tbody>
</table>
<!--
<iframe src="<?php echo $url; ?>" id="report" class="span12" style="min-height:600px;"></iframe>
-->


<div class="text-center">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'htmlOptions'=>array('id'=>'btnReport','style'=>'margin-left:0px;','class'=>'btn btn-primary'),
					'label'=>'Retrieve Trade Confirmation',
				)); ?>
</div>
<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>FALSE,'placeholder'=>'dd/mm/yyyy','style'=>'display:none','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
<?php $this->endWidget();?>

<script>
	
	var url = '<?php echo $url;?>';
	var rowCount = '<?php echo count($modeldetail);?>';
	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});
		cek_all();
		checkOption();
		//hide table if rowcount = 0
		
		if(rowCount =='0')
		{
			$('#tableReport').hide();
			$('#btnReport').hide();
		}
		
		
		
		if(url =='')
		{
			$('#report').hide();
		}
		else
		{
			$('#report').show();
			 var myWindow = window.open(url,'_blank');
			 myWindow.document.title = 'Bond Trade Confirmation';
		}
	}
	
	$(window).resize(function() {
		alignColumn();
	})
	$(window).trigger('resize');

	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableReport").find('thead');
		var firstRow = $("#tableReport").find('tbody tr:eq(0)');
		
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
	
	$('#checkAll').change(function(){
	
	if($('#checkAll').is(':checked'))
	{
		$('.checkBoxDetail').prop('checked',true)
	}
	else
	{
		$('.checkBoxDetail').prop('checked',false)
	}
	})

	$('.checkBoxDetail').change(function(){
		cek_all();
	})
	
	function cek_all()
	{
		var sign='Y';
		$("#tableReport").children('tbody').children('tr').each(function()
		{
			var cek = $(this).children('td.saveFlg').children('[type=checkbox]').is(':checked');
			
			if(!cek){
				sign='N';
			}
		});
		if(sign=='N'){
			$('#checkAll').prop('checked',false)	
		}
		else{
			$('#checkAll').prop('checked',true)
		}
	}
		
	
	
	//alert('test')
	$('#btnFilter').click(function(){
		$('#scenario').val('filter');
	});
	$('#btnReport').click(function(){
		$('#scenario').val('print');
		$('#rowCount').val(rowCount);
	});

	$('#Rptbondtradeconf_bond_option').change(function(){
		checkOption()
	})
	function checkOption()
	{
		if($('#Rptbondtradeconf_bond_option').is(':checked'))
		{
			$('#Rptbondtradeconf_bond_id').prop('readonly',true);
		}
		else
		{
			$('#Rptbondtradeconf_bond_id').prop('readonly',false);
		}
	}
	$('#Rptbondtradeconf_bgn_dt').change(function(){
		$('#Rptbondtradeconf_end_dt').val($('#Rptbondtradeconf_bgn_dt').val());
	})
</script>