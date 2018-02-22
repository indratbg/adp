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
		height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	
	
	
	#jur_status > label
	{
		width:120px;
		margin-left:-5px;
		
	}
	
	#jur_status > label > label
	{
		float:left;
		margin-top:5px;
		margin-left:-30px;
		
	}
	
	#jur_status > label > input
	{
		float:left;
		margin-left:-50px;
	}
	
	
	#client > label
	{
		min-width:102px;
		margin-left:-5px;
	}
	
	#client > label > label
	{
		float:left;
		margin-top:5px;
		margin-left:-30px;
	}
	
	#client > label > input
	{
		float:left;
		margin-left:-50px;
	}
</style>
<?php
$this->breadcrumbs=array(
	'Print Journal'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Print Journal', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
		//array('label'=>'Create','url'=>array('create'),'icon'=>'plus','itemOptions'=>array('style'=>'float:right')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/gljournalledger/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
	
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'treksnab-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
<?php echo $form->errorSummary($model); ?>
<?php  foreach($modeldetail as $row)$form->errorSummary(array($row)); ?>



<br/>
<input type="hidden" name="scenario" id="scenario"/>
<input type="hidden" name="rowCount" id="rowCount"/>


<div class="row-fluid">
	<div class="control-group">
		<div class="span1">
			<label>Date From</label>
		</div>
		<div class="span2">
			<?php echo $form->textField($model,'bgn_dt',array('placeholder'=>'dd/mm/yyyy','class'=>'span10 tdate'));?>
			
		</div>
		<div class="span2">
			To &nbsp;
			<?php echo $form->textField($model,'end_dt',array('placeholder'=>'dd/mm/yyyy','class'=>'span10 tdate'));?>
		</div>
		<div class="span5">
			<?php echo $form->radioButtonListInlineRow($model,'jur_status',array('A'=>'Approved','E'=>'Belum Diapprove','C'=>'Cancel'),array('onchange'=>'filter()','id'=>'jur_status'));?>
		</div>
	</div>
	<div class="control-group">
		<div class="span1">
			<label>Jur Type</label>
		</div>
		<div class="span10">
			<?php echo $form->checkBox($model,'jur_type_vch',array('onchange'=>'init()','class'=>'span1','value'=>'VCH*','label'=>false))."Voucher";?>
			<?php echo $form->checkBox($model,'jur_type_gl',array('onchange'=>'init()','class'=>'span1','value'=>'GL*','label'=>false))."General Ledger";?>
			<?php echo $form->checkBox($model,'jur_type_int',array('onchange'=>'init()','class'=>'span1','value'=>'INT*','label'=>false))."Interest";?>
			<?php echo $form->checkBox($model,'jur_type_trx',array('onchange'=>'init()','class'=>'span1','value'=>'TRX*','label'=>false))."Transaction";?>
			<?php echo $form->checkBox($model,'jur_type_bond',array('onchange'=>'init()','class'=>'span1','value'=>'BOND*','label'=>false))."Bond";?>	
		</div>
	</div>
	<div class="control-group">
		<div class="span1">
			<label>File No.</label>
		</div>
		<div class="span2">
				<?php echo $form->textField($model,'file_no_from',array('class'=>'span10'));?>
		</div>
		<div class="span2">
			To &nbsp;
				<?php echo $form->textField($model,'file_no_to',array('class'=>'span10'));?>
		</div>
		
		<div class="span6">
			<?php echo $form->radioButtonListInlineRow($model,'client',array('0'=>'All','1'=>'Non Client','2'=>'Specified'),array('id'=>'client','onchange'=>'client()'));?>
		</div>
	</div>
	<div class="control-group">
		<div class="span1">
			<label>Jurnal No.</label>
		</div>
		<div class="span2">
				<?php echo $form->textField($model,'jur_num_from',array('class'=>'span10'));?>
		</div>
		<div class="span2">
			To &nbsp;
				<?php echo $form->textField($model,'jur_num_to',array('class'=>'span10'));?>
		</div>
		<div class="span1"></div>
		<div class="span2">
				<?php echo $form->textField($model,'client_spec_from',array('class'=>'span10'));?>
		</div>
		<div class="span2">
			To &nbsp;
				<?php echo $form->textField($model,'client_spec_to',array('class'=>'span10'));?>
		</div>
	</div>
	<div class="control-group">
		<div class="span1">
			<label>Bond ID</label>
		</div>
		<div class="span2">
				<?php echo $form->textField($model,'bond_trx_from',array('class'=>'span10'));?>
		</div>
		<div class="span2">
			To &nbsp;
				<?php echo $form->textField($model,'bond_trx_to',array('class'=>'span10'));?>
		</div>
		<div class="span6">
					
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'htmlOptions'=>array('id'=>'btnFilter','style'=>'margin-left:0px;','class'=>'btn btn-small btn-primary'),
					'label'=>'Retrieve',
				)); ?>
			&emsp;
		<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'htmlOptions'=>array('id'=>'btnPrint','style'=>'margin-left:0px;','class'=>'btn btn-small btn-primary'),
					'label'=>'Print Journal',
				)); ?>
			<a href="<?php echo $url_xls ;?>" id="btn_xls" class="btn btn-small btn-primary">Save to Excel</a>
		</div>
	</div>
</div>


<br/>

<table id='tableReport' class='table-bordered table-condensed'  >
	<thead>
		<tr>
			<th width="100px">Date</th>
			<th width="100px">Client code</th>
			<th width="350px">Description</th>
			<th width="100px">File No.</th>
			<th width="150px">Journal Number</th>
			<th width="100px"><input type="checkbox" id="checkBoxAll" value="1" style="margin-left: 10px;" onclick= "changeAll()"/>&emsp;Print</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modeldetail as $row){
			
			if(DateTime::createFromFormat('Y/m/d H:i:s',$row->jur_date)){
				$row->jur_date=DateTime::createFromFormat('Y/m/d H:i:s',$row->jur_date)->format('d M Y');
			}
			else if(DateTime::createFromFormat('Y-m-d H:i:s',$row->jur_date)){
				$row->jur_date= DateTime::createFromFormat('Y-m-d H:i:s',$row->jur_date)->format('d M Y');				
			}
	?>
		<tr id="row<?php echo $x ?>">
			<td>
			<?php echo $row->jur_date ;?>
			<?php echo $form->textfield($row,'jur_date',array('name'=>'Tjvchh['.$x.'][jur_date]','style'=>'display:none;'));?>
			</td>
			<td >
			<?php echo $row->client_cd ;?>
			<?php echo $form->textfield($row,'client_cd',array('name'=>'Tjvchh['.$x.'][client_cd]','style'=>'display:none;'));?>
			</td>
			<td >
				<?php echo $row->remarks ;?>
				<?php echo $form->textfield($row,'remarks',array('name'=>'Tjvchh['.$x.'][remarks]','style'=>'display:none;'));?>
			</td>
			<td >
			<?php echo $row->folder_cd;?>
			<?php echo $form->textfield($row,'folder_cd',array('name'=>'Tjvchh['.$x.'][folder_cd]','style'=>'display:none;'));?>
			</td>
			<td>
				<?php echo $row->doc_num ;?>
				<?php echo $form->textfield($row,'doc_num',array('name'=>'Tjvchh['.$x.'][doc_num]','style'=>'display:none;'));?>
			</td>
			<td class="save_flg">
				<?php echo $form->checkBox($row,'save_flg',array('class'=>'checkBoxDetail','id'=>'save_flg_'.$x.'','value' => 'Y','name'=>'Tjvchh['.$x.'][save_flg]','style'=>'margin-left:10px;')); ?>
				
			</td>
		</tr>
		
	<?php 
	$x++;
} ?>
	</tbody>
</table>

<!-- 29jul2016 -->
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px;"></iframe>


<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>false,'disabled'=>true,'style'=>'display:none'));?>
<?php $this->endWidget();?>
<script>

var rowCount = '<?php echo count($modeldetail);?>';
var url_xls = '<?php echo $url_xls ?>';
$('#Rptlistofjournal_jur_status_2').css('margin-top','-11px');
$('#Rptlistofjournal_jur_status_2').css('margin-left','150px');
$("label:contains('Cancel')").css('margin-top','-15px');
$("label:contains('Cancel')").css('margin-left','170px');

$('.tdate').datepicker({'format':'dd/mm/yyyy','language':'en'});

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
		//firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',(header.find('th:eq(5)').width())-17 + 'px');
		
	}
$('#btnFilter').click(function(){
	
	$('#scenario').val('filter');
	
});
$('#btnPrint').click(function(){
	
	$('#scenario').val('print');
	$('#rowCount').val(rowCount);
	
});
	init();
	bond();
	client();
	
	function init()
	{
		
		if($('#Rptlistofjournal_jur_type_vch').is(':checked') || $('#Rptlistofjournal_jur_type_int').is(':checked') ||	$('#Rptlistofjournal_jur_type_trx').is(':checked')){
		client();
		}
		else{
			
			
		$('#Rptlistofjournal_client_spec_from').attr('disabled',true);
		$('#Rptlistofjournal_client_spec_to').attr('disabled',true);
		}
		
		bond();
		cek_all();
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
		if(rowCount==0)
		{
			$('#btnPrint').prop('disabled',true);
		}
		
	}
	function client(){
	
	if($('#Rptlistofjournal_client_0').is(':checked')){
		$('#Rptlistofjournal_client_spec_from').attr('disabled',true)
			$('#Rptlistofjournal_client_spec_to').attr('disabled',true)
	}
	
	
		if($('#Rptlistofjournal_client_2').is(':checked')){
			if($('#Rptlistofjournal_jur_type_vch').is(':checked') || $('#Rptlistofjournal_jur_type_int').is(':checked') ||	$('#Rptlistofjournal_jur_type_trx').is(':checked')){
			$('#Rptlistofjournal_client_spec_from').attr('disabled',false)
			$('#Rptlistofjournal_client_spec_to').attr('disabled',false)
			}
		}
		else{
			
			$('#Rptlistofjournal_client_spec_from').attr('disabled',true)
			$('#Rptlistofjournal_client_spec_to').attr('disabled',true)
		}
		
	}

	function bond(){
	
		if($('#Rptlistofjournal_jur_type_bond').is(':checked')){
			
		
		$('#Rptlistofjournal_bond_trx_from').attr('disabled',false);
		$('#Rptlistofjournal_bond_trx_to').attr('disabled',false);
		}
		else{
			$('#Rptlistofjournal_bond_trx_from').attr('disabled',true);
		$('#Rptlistofjournal_bond_trx_to').attr('disabled',true);
		}
		
	}
	filter();
	function filter(){
		
	if($('#Rptlistofjournal_jur_status_1').is(':checked')){
	//$('#Rptlistofjournal_bgn_dt').attr('disabled',true);
	//$('#Rptlistofjournal_end_dt').attr('disabled',true);
	//$('#Rptlistofjournal_file_no_from').attr('disabled',true);
	//$('#Rptlistofjournal_file_no_to').attr('disabled',true);
	//$('#Rptlistofjournal_jur_num_from').attr('disabled',true);
	//$('#Rptlistofjournal_jur_num_to').attr('disabled',true);
	$('#Rptlistofjournal_client_spec_from').attr('disabled',true);
	$('#Rptlistofjournal_client_spec_to').attr('disabled',true);
	}	
		else{
	$('#Rptlistofjournal_bgn_dt').attr('disabled',false);
	$('#Rptlistofjournal_end_dt').attr('disabled',false);
	$('#Rptlistofjournal_file_no_from').attr('disabled',false);
	$('#Rptlistofjournal_file_no_to').attr('disabled',false);
	$('#Rptlistofjournal_jur_num_from').attr('disabled',false);
	$('#Rptlistofjournal_jur_num_to').attr('disabled',false);
	//$('#Rptlistofjournal_client_spec_from').attr('disabled',false);
	//$('#Rptlistofjournal_client_spec_to').attr('disabled',false);
		}
	
	}	
	function changeAll()
	{
		
		
		if($("#checkBoxAll").is(':checked'))
		{
			$(".checkBoxDetail").prop('checked',true);
		}
		else
		{
			$(".checkBoxDetail").prop('checked',false);
		}
	}
	
$('#Rptlistofjournal_bgn_dt').change(function(){
	$('#Rptlistofjournal_end_dt').val($('#Rptlistofjournal_bgn_dt').val());
	$('#Rptlistofjournal_end_dt').datepicker('update');
})
$('#Rptlistofjournal_file_no_from').change(function(){
	$('#Rptlistofjournal_file_no_from').val($('#Rptlistofjournal_file_no_from').val().toUpperCase());
	$('#Rptlistofjournal_file_no_to').val($('#Rptlistofjournal_file_no_from').val());
})
$('#Rptlistofjournal_jur_num_from').change(function(){
	$('#Rptlistofjournal_jur_num_to').val($('#Rptlistofjournal_jur_num_from').val());
})
$('#Rptlistofjournal_file_no_to').change(function(){
	$('#Rptlistofjournal_file_no_to').val($('#Rptlistofjournal_file_no_to').val().toUpperCase());
})

$('#Rptlistofjournal_client_spec_from').change(function(){
	$('#Rptlistofjournal_client_spec_from').val($('#Rptlistofjournal_client_spec_from').val().toUpperCase());	
	$('#Rptlistofjournal_client_spec_to').val($('#Rptlistofjournal_client_spec_from').val().toUpperCase());
})

$('#Rptlistofjournal_bond_trx_from').change(function(){
	$('#Rptlistofjournal_bond_trx_from').val($('#Rptlistofjournal_bond_trx_from').val().toUpperCase());
	$('#Rptlistofjournal_bond_trx_to').val($('#Rptlistofjournal_bond_trx_from').val().toUpperCase());
});


$('.checkBoxDetail').change(function(){
	cek_all();
})

function cek_all()
	{
		var sign='Y';
		$("#tableReport").children('tbody').children('tr').each(function()
		{
			var cek = $(this).children('td.save_flg').children('[type=checkbox]').is(':checked');
			
			if(!cek){
				sign='N';
			}
		});
		if(sign=='N'){
			$('#checkBoxAll').prop('checked',false)	
		}
		else{
			$('#checkBoxAll').prop('checked',true)
		}
	}
	
</script>