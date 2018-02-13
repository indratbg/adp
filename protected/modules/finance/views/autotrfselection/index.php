
<style>
	#tableTrf
	{
		background-color:#C3D9FF;
	}
	#tableTrf thead, #tableTrf tbody
	{
		display:block;
	}
	#tableTrf tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	#tableTrf thead tr th{
	vertical-align: bottom;
}
	#tablePrint
	{
		background-color:#C3D9FF;
	}
	#tablePrint thead, #tablePrint tbody
	{
		display:block;
	}
	#tablePrint tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	#tablePrint thead tr th{
	vertical-align: bottom;
}
	#tablePE
	{
		background-color:#C3D9FF;
	}
	#tablePE thead, #tablePE tbody
	{
		display:block;
	}
	#tablePE tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	#tablePE thead tr th{
	vertical-align: bottom;
}
</style><?php
$this->breadcrumbs=array(
	'Select Payment for Auto Transfer BCA'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Select Payment for Auto Transfer BCA', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	//array('label'=>'Approval Penerimaan Dana/Refund','url'=>Yii::app()->request->baseUrl.'?r=inbox/tfundmovementall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	//array('label'=>'Approval Penjatahan (Voucher)','url'=>Yii::app()->request->baseUrl.'?r=inbox/tpayrechall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>


<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Payment-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); 
 ?>
 <?php
$branch=Branch::model()->findAllBySql("select PRM_DESC as brch_cd from mst_parameter where prm_cd_1='KBBGRP' AND APPROVED_STAT='A' ORDER BY PRM_CD_2");


echo $form->errorSummary(array($model,$modelReport));
foreach($modelDetail as $row)echo $form->errorSummary(array($row));
foreach($modelPenarikan as $row)echo $form->errorSummary(array($row));
?>

<br/>
<input type="hidden" name="scenario" id="scenario"/>
<input type="hidden" name="rowCount" id="rowCount"/>
<input type="hidden" name="rowCountPenarikan" id="rowCountPenarikan"/>
<input type="hidden" name="rowCountPrint" id="rowCountPrint"/>
<input type="hidden" name="reSelect" id="reSelect"/>
<div class="row-fluid control-group">
	<div class="span6">
		
			<div class="span2">
				<label style="width:100px;">Transfer Date</label>
			</div>
			<div class="span4">
				<?php echo $form->datePickerRow($model,'doc_date',array('label'=>false,'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			</div>
	
			<div class="span1">
				<label>Type</label>
			</div>
			<div class="span4">
			<?php echo $form->dropDownList($model,'trx_type',array('0'=>'RDI to Client','1'=>'PE to RDI Penarikan',
																	'2'=>'PE to RDI saldo Kredit',
																	'3'=>'RDI to PE saldo Debit'),array('class'=>'span','prompt'=>'-Select-'));?>
			</div>
	</div>
	<div class="span6">
		<div class="span2">
			<label>Branch</label>
		</div>
		<div class="span3">
			<?php echo $form->dropDownList($model,'brch_cd',CHtml::listData($branch,'brch_cd','brch_cd'),array('class'=>'span','prompt'=>'-Select-'));?>
		</div>
		<div class="span2">
			<label>Bank</label>
		</div>
		<div class="span3">
		<?php echo $form->dropDownList($model,'from_bank',CHtml::listData(Fundbank::model()->findAll(), 'bank_cd', 'bank_name'),array('class'=>'span10','prompt'=>'-Select-','style'=>'margin-left:30px;'));?>
		</div>
	</div>
</div>


<div class="row-fluid control-group">
	<div class="span1">
			<?php $this->widget('bootstrap.widgets.TbButton',
			    array('label' => 'Retrieve',
				        'size' => 'medium',
				        'id' => 'btnFilter',
				        'buttonType'=>'submit',
				        'htmlOptions'=>array('class'=>'btn btn-small btn-primary','style'=>'width:70px;')
	    )
	); ?>
	</div>
	<div class="span1">
			<?php $this->widget('bootstrap.widgets.TbButton',
			    array('label' => 'Re-select',
				        'size' => 'medium',
				        'id' => 'btnReselect',
				        'buttonType'=>'submit',
				        'htmlOptions'=>array('class'=>'btn btn-small btn-primary','style'=>'width:70px;')
	    )
	); ?>
	</div>
	<div class="span1">
			<?php $this->widget('bootstrap.widgets.TbButton',
			    array('label' => 'Update',
				        'size' => 'medium',
				        'id' => 'btnUpdate',
				        'buttonType'=>'submit',
				        'htmlOptions'=>array('class'=>'btn btn-small btn-primary','style'=>'width:70px;')
	    )
	); ?>
	</div>
	<div class="span3">
			<?php $this->widget('bootstrap.widgets.TbButton',
			    array('label' => 'Print Selected Payment',
				        'size' => 'medium',
				        'id' => 'btnPrintSelect',
				        'buttonType'=>'submit',
				        'htmlOptions'=>array('class'=>'btn btn-small btn-primary')
	    )
	); ?>
	</div>
	<div class="span4"></div>
	<div class="span2">
		<?php /*$this->widget('bootstrap.widgets.TbButton',
			    array('label' => 'Print Payment',
				        'size' => 'medium',
				        'id' => 'btnPrint',
				        'buttonType'=>'submit',
				        'htmlOptions'=>array('class'=>'btn btn-small btn-primary')
	    )
	); */?>
	</div>
</div>

<br/>

<table id='tableTrf' class='table-bordered table-condensed' >
		<thead>
			<tr>
			<th width="10px" style="text-align: center;"><input type="checkbox" name="checkAll" id="checkAll" /></th>
			<th width="80px">Date</th>
			<th width="80px">Client Cd</th>
			<th width="300px">Client Name</th>
			<th width="110px">Amount</th>
			<th width="110px">Fee</th>
			<th width="140px">Acct No.</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelDetail as $row){ 
		?>
			<tr id="row<?php echo $x ?>">
				<td class="save_flg" style="text-align: center" >
					<?php echo $form->checkBox($row,'save_flg',array('class'=>'checkDetail','value' => 'Y','name'=>'Autotrfselection['.$x.'][save_flg]')); ?>
					<?php echo $form->textField($row,'doc_num',array('name'=>'Autotrfselection['.$x.'][doc_num]','style'=>'display:none'));?>
					<?php echo $form->textField($row,'trf_flg_ori',array('name'=>'Autotrfselection['.$x.'][trf_flg_ori]','style'=>'display:none'));?>
					<?php echo $form->textField($row,'auto_trf',array('name'=>'Autotrfselection['.$x.'][auto_trf]','style'=>'display:none'));?>
				</td>
				<td>
				<?php echo $form->textField($row,'doc_date',array('name'=>'Autotrfselection['.$x.'][doc_date]','class'=>'span tdate','readonly'=>true)) ;?>
				</td>
				<td>
					<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'Autotrfselection['.$x.'][client_cd]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'client_name',array('class'=>'span','name'=>'Autotrfselection['.$x.'][client_name]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'trx_amt',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Autotrfselection['.$x.'][trx_amt]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'fee',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Autotrfselection['.$x.'][fee]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'to_acct',array('class'=>'span','name'=>'Autotrfselection['.$x.'][to_acct]','readonly'=>true)); ?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<?php echo $form->textField($row,'branch_code',array('name'=>'Autotrfselection['.$x.'][branch_code]','class'=>'span','readonly'=>true)) ;?>
				</td>
				<td>
					<label>Acct Name</label>
				</td>
				<td>
					<?php echo $form->textField($row,'acct_name',array('name'=>'Autotrfselection['.$x.'][acct_name]','class'=>'span','readonly'=>true)) ;?>
				</td>
				<td></td>
				<td></td>
				<td>
					<?php echo $form->textField($row,'to_bank',array('name'=>'Autotrfselection['.$x.'][to_bank]','class'=>'span','readonly'=>true)) ;?>
				</td>
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>


<!----------PE TO RDI PENARIKAN-->
	<table id='tablePE' class='table-bordered table-condensed' >
		<thead>
			<tr>
			<th width="10px" style="text-align: center;"><input type="checkbox" name="checkAll3" id="checkAll3" /></th>
			<th width="250px">Nama</th>
			<th width="80px">Trans Date</th>
			<th width="110px">Trans Amount</th>
			<th width="90px">Acc No.</th>
			<th width="145px">Remark 1</th>
			<th width="145px">Remark 2</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelPenarikan as $row){ 
		?>
			<tr id="row<?php echo $x ?>">
				<td class="save_flg3" style="text-align: center" >
					<?php echo $form->checkBox($row,'save_flg',array('class'=>'checkDetail3','value' => 'Y','name'=>'Autotrfselection['.$x.'][save_flg]')); ?>
					<?php echo $form->textField($row,'doc_num',array('name'=>'Autotrfselection['.$x.'][doc_num]','style'=>'display:none'));?>
				</td>
				<td>
					<?php echo $form->textField($row,'nama',array('name'=>'Autotrfselection['.$x.'][nama]','class'=>'span tdate','readonly'=>true)) ;?>
				</td>
				<td>
					<?php echo $form->textField($row,'trans_date',array('class'=>'span','name'=>'Autotrfselection['.$x.'][trans_date]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'trans_amount',array('style'=>'text-align:right','class'=>'span tnumberdec','name'=>'Autotrfselection['.$x.'][trans_amount]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'acc_no',array('class'=>'span','name'=>'Autotrfselection['.$x.'][acc_no]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'remark_1',array('class'=>'span','name'=>'Autotrfselection['.$x.'][remark_1]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'remark_2',array('class'=>'span','name'=>'Autotrfselection['.$x.'][remark_2]','readonly'=>true)); ?>
				</td>
			</tr>
			
		<?php $x++;} ?>
		</tbody>
	</table>

<!--<iframe src="<?php echo $url; ?>" class="span12" id="report" style="min-height:600px;max-width: 100%;"></iframe>-->	


<table id='tablePrint' class='table-bordered table-condensed' >
		<thead>
			<tr>
			<th width="10px">No.</th>
			<th width="65px">Client Cd</th>
			<th width="200px">Client Name</th>
			<th width="50px">Fee</th>
			<th width="100px">Amount</th>
			<th width="200px">Payee Acct No.</th>
			<th width="170px"></th>
			<th width="10px" >
				<?php $this->widget('bootstrap.widgets.TbButton',
			    array('label' => 'Print',
				        'size' => 'medium',
				        'id' => 'btnPrint',
				        'buttonType'=>'submit',
				        'htmlOptions'=>array('class'=>'btn btn-small btn-primary')
	    )
	); ?>
				<input type="checkbox" name="checkAll2" id="checkAll2" style="margin-left: 17px;" /></th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelPrint as $row){ 
		?>
			<tr id="row<?php echo $x ?>">
				<td>
					<label><?php echo $x;?></label>
				</td>
				<td>
					<?php echo $row->client_cd ;?>
					<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'Autotrfselection['.$x.'][client_cd]','style'=>'display:none'));?>
					<?php echo $form->textField($row,'doc_num',array('class'=>'span','name'=>'Autotrfselection['.$x.'][doc_num]','style'=>'display:none'));?>
				</td>
				<td>
					<?php echo $row->rdi_acct_name ;?>
					<?php echo $form->textField($row,'rdi_acct_name',array('class'=>'span','name'=>'Autotrfselection['.$x.'][client_name]','style'=>'display:none'));?>
				</td>
				<td>
					
				</td>
				<td style="text-align: right">
					<?php echo number_format($row->curr_amt,0,',','.') ;?>
					<?php echo $form->textField($row,'curr_amt',array('class'=>'span','name'=>'Autotrfselection['.$x.'][curr_amt]','style'=>'display:none'));?>
				</td>
				<td>
					<?php echo $row->payee_acct_num ;?>
					<?php echo $form->textField($row,'payee_acct_num',array('class'=>'span','name'=>'Autotrfselection['.$x.'][payee_acct_num]','style'=>'display:none'));?>
				</td>
				<td>
					<?php echo $row->bank_name ;?>
					<?php echo $form->textField($row,'bank_name',array('class'=>'span','name'=>'Autotrfselection['.$x.'][bank_name]','style'=>'display:none'));?>
				</td>
				<td class="save_flg2"  >
					<?php echo $form->checkBox($row,'save_flg',array('class'=>'span checkDetail2','value' => 'Y','name'=>'Autotrfselection['.$x.'][save_flg]','style'=>'margin-left:10px;')); ?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>
					<?php echo "Vch : ".$row->folder_cd." RDI : ".$row->bank_acct_fmt;?>
					<?php echo $form->textField($row,'folder_cd',array('class'=>'span', 'name'=>'Autotrfselection['.$x.'][folder_cd]','style'=>'display:none'));?>
					<?php echo $form->textField($row,'bank_acct_fmt',array('class'=>'span','name'=>'Autotrfselection['.$x.'][bank_acct_fmt]','style'=>'display:none'));?>
				</td>
				<td style="text-align: right">
					<?php echo number_format($row->trf_fee,0,',','.');?>
					<?php echo $form->textField($row,'trf_fee',array('class'=>'span','name'=>'Autotrfselection['.$x.'][fee]','style'=>'display:none'));?>
				</td>
				<td></td>
				<td>
					<?php echo $row->payee_name;?>
					<?php echo $form->textField($row,'payee_name',array('class'=>'span','name'=>'Autotrfselection['.$x.'][payee_name]','style'=>'display:none'));?>
				</td>
				<td>
					<?php echo $row->bank_branch;?>
					<?php echo $form->textField($row,'bank_branch',array('class'=>'span','name'=>'Autotrfselection['.$x.'][bank_branch]','style'=>'display:none'));?>
				</td>
				<td></td>
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>

<?php $this->endWidget(); ?>

<script>

var rowCount = '<?php echo count($modelDetail);?>';
var rowCountPrint = '<?php echo count($modelPrint);?>';
var rowCountPenarikan ='<?php echo count($modelPenarikan);?>';
var url = '<?php echo $url;?>';
//alert(url)
if(url !=''){
		 var myWindow = window.open('<?php echo $url;?>&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false','_blank');
		 myWindow.document.title = 'Transfer BCA';
	}

init();
function init()
{
	checkAll();
	checkAll2();
	checkAll3();
	
	
	if(rowCountPrint==0)
	{
		$('#tablePrint').hide();
		
	}
	else
	{
		$('#tablePrint').show();
		
	}
	
	//RDI to client
	if ($('#Autotrfselection_trx_type').val()=='0')
	{
		if(rowCount==0)
		{
			$('#tableTrf').hide();
			$('#tablePE').hide();
			$('#btnUpdate').prop('disabled',true);
		}
		else
		{
			$('#tableTrf').show();
			$('#tablePE').hide();
			$('#btnUpdate').prop('disabled',false);
		}
	}
	//PE to RDI penarikan
	else if($('#Autotrfselection_trx_type').val()=='1')
	{
		if(rowCountPenarikan==0)
		{
			$('#tablePE').hide();
			$('#tableTrf').hide();
			$('#btnUpdate').prop('disabled',true);
			$('#btnFilter').prop('disabled',true);
		}
		else
		{
			$('#tablePE').show();
			$('#tableTrf').hide();
			$('#btnUpdate').prop('disabled',false);
			$('#btnFilter').prop('disabled',true);
		}
	}
	
}

	$('#btnFilter').click(function(){
		$('#scenario').val('filter');
		$('#reSelect').val('N');
	})
	$('#btnPrintSelect').click(function(){
		$('#scenario').val('print_x');
	})
	
	$('#btnReselect').click(function(){
		$('#scenario').val('filter');
		$('#reSelect').val('Y');
		
	})
	$('#btnUpdate').click(function(){
		$('#scenario').val('update');
		$('#rowCount').val(rowCount);
		$('#rowCountPenarikan').val(rowCountPenarikan);
	})
	$('#btnPrint').click(function(){
		$('#scenario').val('print');
		$('#rowCountPrint').val(rowCountPrint);
	})
	
	
	
	
	$(window).resize(function() {
		alignColumn();
		alignColumnPrint();
		alignColumnPenarikan();
	})
	$(window).trigger('resize');
	
		function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableTrf").find('thead');
		var firstRow = $("#tableTrf").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() +'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width()-17 + 'px');
	}
	
	function alignColumnPrint()//align columns in thead and tbody
	{
		var header = $("#tablePrint").find('thead');
		var firstRow = $("#tablePrint").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() +'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width()-17 + 'px');
	}
	function alignColumnPenarikan()//align columns in thead and tbody
	{
		var header = $("#tablePE").find('thead');
		var firstRow = $("#tablePE").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() +'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width()-17 + 'px');
		
	}
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
	$('#checkAll2').change(function(){
		if($('#checkAll2').is(':checked'))
		{
			$('.checkDetail2').prop('checked',true);
		}
		else
		{
			$('.checkDetail2').prop('checked',false);
		}
	})
	$('#checkAll3').change(function(){
		if($('#checkAll3').is(':checked'))
		{
			$('.checkDetail3').prop('checked',true);
		}
		else
		{
			$('.checkDetail3').prop('checked',false);
		}
	})
	$('.checkDetail').change(function(){
		
		checkAll();
	})
	$('.checkDetail2').change(function(){
		
		checkAll2();
	})
	$('.checkDetail3').change(function(){
		
		checkAll3();
	})
	
	function checkAll()
	{
		var safe=1;
		$("#tableTrf").children('tbody').children('tr').each(function()
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
	function checkAll2()
	{
		var safe=1;
		$("#tablePrint").children('tbody').children('tr').each(function()
		{
			if($(this).children('td.save_flg2').children('[type=checkbox]').length)
			{
			var save_flg = $(this).children('td.save_flg2').children('[type=checkbox]').is(':checked');	
			
			if(!save_flg)
			{	
				safe=0;
				
				return false;
			}
			}
			
			
		});
		if (safe==0)
		{
		$('#checkAll2').prop('checked',false);	
		}
		else
		{
		$('#checkAll2').prop('checked',true);	
		}
	}
	function checkAll3()
	{
		var safe=1;
		$("#tablePE").children('tbody').children('tr').each(function()
		{
			if($(this).children('td.save_flg3').children('[type=checkbox]').length)
			{
			var save_flg = $(this).children('td.save_flg3').children('[type=checkbox]').is(':checked');	
			
			if(!save_flg)
			{	
				safe=0;
				
				return false;
			}
			}
			
			
		});
		if (safe==0)
		{
		$('#checkAll3').prop('checked',false);	
		}
		else
		{
		$('#checkAll3').prop('checked',true);	
		}
	}
	$('#Autotrfselection_trx_type').change(function(){
		var type = $('#Autotrfselection_trx_type').val();
		if(type=='0')
		{
			$('#btnFilter').prop('disabled',false);
			$('#btnReselect').prop('disabled',false);
			$('#btnUpdate').prop('disabled',false);
			
		}
		else if(type=='1')
		{
			$('#btnFilter').prop('disabled',true);
			$('#btnReselect').prop('disabled',false);
			$('#btnUpdate').prop('disabled',true);
		}
	})
</script>