<style>
	.tableIpo
	{
		background-color:#C3D9FF;
	}
	.tableIpo thead, .tableIpo tbody
	{
		display:block;
	}
	.tableIpo tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	.radio.inline{
	width: 130px;
}
#tableIpo1 thead tr th{
	vertical-align: bottom;
}
#tableIpo2 thead tr th{
	vertical-align: bottom;
}
#tableIpo3 thead tr th{
	vertical-align: bottom;
}
.rdi_type .radio{
	margin-left:-30%;
}

</style>
<?php

$this->breadcrumbs=array(
	'IPO Fund Journal'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'IPO Fund Journal', 'itemOptions'=>array('style'=>'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tfundmovementall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	//array('label'=>'Approval Penerimaan Dana/Refund','url'=>Yii::app()->request->baseUrl.'?r=inbox/tfundmovementall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	//array('label'=>'Approval Penjatahan (Voucher)','url'=>Yii::app()->request->baseUrl.'?r=inbox/tpayrechall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>


<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tbankmutation-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	//'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); 
 ?>
 
 <?php echo $form->errorSummary(array($model,$modelPayrech,$modelPayrecd,$modelFolder,$modelgen,$modelFundTrf));?>
 <?php foreach($modelDetailDana as $row) echo $form->errorSummary(array($row))?>
 <?php foreach($modelDetailPenjatahan as $row) echo $form->errorSummary(array($row))?>
 <?php foreach($modelDetailRefund as $row) echo $form->errorSummary(array($row))?>
 <?php foreach($modelmovement as $row) echo $form->errorSummary(array($row))?>
 <?php foreach($modelIpofund2 as $row) echo $form->errorSummary(array($row))?>
 <?php foreach($modelaccountledger as $row) echo $form->errorSummary(array($row))?>
 <?php foreach($modelfundledger as $row) echo $form->errorSummary(array($row))?>

 <input type="hidden" name="rowCountDana" id="rowCountDana" />
 <input type="hidden" name="rowCountPenjatahan" id="rowCountPenjatahan" />
 <input type="hidden" name="rowCountRefund" id="rowCountRefund" />

<input type="hidden" name="scenario" id="scenario" />
 <br/>

 
 	<div class="row-fluid control-group">
 		<div class="span2">
 			<label>Kode Stock Sementara</label>
 		</div>
 		<div class="span2">
 		<?php //echo $form->dropdownList($model,'stk_cd',CHtml::listData(Tpee::model()->findAll(array('order'=>'stk_Cd')), 'stk_cd', 'stk_cd'),array('class'=>'span','prompt'=>'-Select-'));?>
 		<?php echo $form->dropdownList($model,'stk_cd',CHtml::listData(Tpee::model()->findAll(array('condition'=>'distrib_dt_fr>=trunc(sysdate)-40','order'=>'stk_Cd')), 'stk_cd', 'stk_cd'),array('class'=>'span','prompt'=>'-Select-', 'required'=>true));?>
 		<?php echo $form->textField($model,'ipo_bank_cd',array('style'=>'display:none'));?>
 		<?php echo $form->textField($model,'ipo_bank_acct',array('style'=>'display:none'));?>
 		<?php //echo $form->textField($model,'total_setor',array('style'=>'display:none'));?>
 		
 		</div>
 		<div class="span1">
 			<label>Tahap</label>
 		</div>
 		<div class="span2">
 				<?php echo $form->dropDownList($model,'tahap',array('0'=>'Penerimaan Dana Pemesanan Efek','1'=>'Penjatahan','2'=>'Refund'),array('class'=>'span','prompt'=>'-Select-','required'=>true));?>
 		</div>
 		<div class="span5">
 			<?php echo $form->radioButtonListInlineRow($model, 'option', array('0'=>'All','1'=>'Selected'),array('class'=>'option','label'=>false, 'labelOptions'=>array('style'=>'display:inline'))); ?>
 
 		</div>
 	</div>

<div class="row-fluid control-group">
	<div class="span2">
		<label>Offering date from</label>
	</div>
	<div class="span2">
		<?php echo $form->textField($model,'offer_dt_fr',array('readonly'=>true,'class'=>'span '));?>
	</div>
	<div class="span1">
		<label>To</label>
	</div>
	<div class="span2">
		<?php echo $form->textField($model,'offer_dt_to',array('readonly'=>true,'class'=>'span '));?>
	
	</div>
	<div class="span1">
		Penjatahan
	</div>
	<div class="span1">
		<?php echo $form->textField($model,'allocate_dt',array('class'=>'span12 ','readonly'=>true,'style'=>'width:90px;'));?>
	</div>
	<div class="span1">
		<label style="width: 100px;margin-left: 13px;">Distrib Date</label>
	</div>
	<div class="span1">
		<?php echo $form->textField($model,'distrib_dt_to',array('class'=>'span ','readonly'=>true,'style'=>'width:100px;'));?>
	</div>
	
</div>

<div class="row-fluid control-group">
	<div class="span2">
		<label>Tgl terima dana dr client</label>
	</div>
	<div class="span2">
		<?php echo $form->textField($model,'paym_dt',array('class'=>'span ','readonly'=>true));?>	
	</div>
	<div class="span1">
		<label>Price</label>
	</div>
	<div class="span2">
		<?php echo $form->textField($model,'price',array('class'=>'span tnumber','style'=>'text-align:right','readonly'=>true));?>
	</div>
	<div class="span1">
		<label>Client Cd</label>
	</div>
	<div class="span1">
		<?php echo $form->textField($model,'client_cd',array('class'=>'span6','style'=>'width:90px;'));?>
		
	</div>
	<div class="span1">
		<label style="width: 100px;margin-left: 13px;">Branch Cd</label>
	</div>
	<div class="span1" >
		<?php echo $form->dropDownList($model,'branch_cd',CHtml::listData(Branch::model()->findAll(), 'brch_cd', 'brch_cd'),array('class'=>'span','width:100px;','prompt'=>'-All-'));?>
	</div>
	
</div>

<div class="row-fluid">
	<div class="control-group">
		<div class="span2">
			<label>Journal date</label>
		</div>
		<div class="span2">
			<?php echo $form->textField($model,'journal_date',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','readonly'=>false));?>	
		</div>
		<div class="span1">
			<label>Total</label>
		</div>
		<div class="span2">
			<?php echo $form->textField($model,'total_setor',array('class'=>'span tnumber','readonly'=>true,'style'=>'text-align:right'));?>	
		</div>
		<div class="span1">
			<label>Batch</label>
		</div>
		<div class="span1" >
		<?php //echo $form->textField($model,'batch',array('class'=>'span','readonly'=>false,'style'=>'width:90px;'));?>	
		<?php echo $form->dropDownList($model,'batch',CHtml::listData(Tipoclient::model()->findAll(array('condition'=>'batch is not null','order'=>'batch')),'batch','batch'),array('class'=>'span','style'=>'width:90px;','prompt'=>'-All-'));?>
		</div>	
	</div>
</div>
<div class="row-fluid">
	<div class="control-group">
		<div class="span2">
			<label>Remarks</label>
		</div>
		<div class="span6">
			<?php echo $form->textField($model,'remarks',array('class'=>'span10'));?>	
		</div>
		
	</div>
</div>
<div class="row-fluid">
	<div class="control-group">
		<div class="span2">
			<label>RDI Type</label>
		</div>
		<div class="span3 rdi_type">
			<?php echo $form->radioButtonList($model,'rdi_type',array('CUKUP'=>'Punya RDI','NORDI'=>'Tidak punya RDI'));?>	
		</div>
		<div class="span2">
			<?php $this->widget('bootstrap.widgets.TbButton',
			    array('label' => 'Generate',
				        'size' => 'medium',
				        'id' => 'btnFilter',
				        'buttonType'=>'submit',
				        'htmlOptions'=>array('class'=>'btn-primary')
	    )
	); ?>
		</div>
	</div>
</div>



<br/>

<div id="dataDetail" style="overflow-x: auto;">
	<div style="width:1200px;"> 
	<table id='tableIpo1' class='table-bordered table-condensed tableIpo' >
		<thead>
			<tr>
			<th width="80px">Client Cd</th>
			<th width="160px">Name</th>
			<th width="110px">Fixed</th>
			<th width="110px">Pooling</th>
			<th width="110px">Allocated</th>
			<th width="110px">Amount</th>
			<th width="20px"><a title="Pindahkan Semua" onclick="moveAll()" style="cursor: pointer">All</a></th>
			<th width="110px">akan dipindahkan</th>
			<th width="20px"><input type="checkbox" name="checkAll" id="checkAll" /></th>
			<th width="100px">Dana pemesanan</th>
			<th width="120px">Saldo RDI</th>
		
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelDetailDana as $row){ 
		?>
			<tr id="row<?php echo $x ?>">
				<td>
				<?php echo $form->textField($row,'client_cd',array('name'=>'Tipoclient['.$x.'][client_cd]','class'=>'span','readonly'=>true)) ;?>
				</td>
				<td>
					<?php echo $form->textField($row,'client_name',array('class'=>'span','name'=>'Tipoclient['.$x.'][client_name]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'fixed_qty',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][fixed_qty]','readonly'=>true)); ?>
				</td>
				<td>
						<?php echo $form->textField($row,'pool_qty',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][pool_qty]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'alloc_qty',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][alloc_qty]','readonly'=>true)); ?>
				</td>
				<td class="amt">
					<?php echo $form->textField($row,'amount',array('id'=>"amount_$x",'style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][amount]','readonly'=>true)); ?>
					
				</td>
				<td  style="text-align: center">
					<a  onclick="move(<?php echo $x?>)" style="cursor:pointer;" title="move"> > </a>
				</td>
				<td class="setor">
					<?php echo $form->textField($row,'setor',array('id'=>"setor_$x",'style'=>'text-align:right','class'=>'span tnumber setor_amt','name'=>'Tipoclient['.$x.'][setor]','readonly'=>false)); ?>
				</td>
				<td class="saveFlg1">
					<?php echo $form->checkBox($row,'save_flg',array('id'=>"saveFlg_$x",'class'=>'checkDetail','value' => 'Y','name'=>'Tipoclient['.$x.'][save_flg]')); ?>
				</td>
				
				<td>
					<?php echo $form->textField($row,'fund_ipo',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][fund_ipo]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'bal_rdi',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][bal_rdi]','readonly'=>true)); ?>
				</td>
				
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>
	
	</div>
	</div>
	<table id='tableIpo2' class='table-bordered table-condensed tableIpo' >
		<thead>
			<tr>
			<th width="80px">Client Cd</th>
			<th width="170px">Name</th>
			<th width="110px">Fixed</th>
			<th width="110px">Pooling</th>
			<th width="110px">Allocated</th>
			<th width="140px">Amount</th>
			<th width="30px" style="text-align: center;"><input type="checkbox" name="checkAll2" id="checkAll2" /></th>
			<th width="140px">Dana Pemesanan</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelDetailPenjatahan as $row){ 
		?>
			<tr id="row<?php echo $x ?>">
				<td>
				<?php echo $form->textField($row,'client_cd',array('name'=>'Tipoclient['.$x.'][client_cd]','class'=>'span','readonly'=>true)) ;?>
				</td>
				<td>
					<?php echo $form->textField($row,'client_name',array('class'=>'span','name'=>'Tipoclient['.$x.'][client_name]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'fixed_qty',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][fixed_qty]','readonly'=>true)); ?>
				</td>
				<td>
						<?php echo $form->textField($row,'pool_qty',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][pool_qty]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'alloc_qty',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][alloc_qty]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'amount',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][amount]','readonly'=>true)); ?>
				</td>
				<td style="text-align: center" class="save_flg_jatah">
					<?php echo $form->checkBox($row,'save_flg',array('class'=>'checkDetail2','value' => 'Y','name'=>'Tipoclient['.$x.'][save_flg]')); ?>
	
				</td>
				<td class="fund_ipo">
					<?php echo $form->textField($row,'fund_ipo',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][fund_ipo]','readonly'=>true)); ?>
				</td>
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>
	<table id='tableIpo3' class='table-bordered table-condensed tableIpo' >
		<thead>
			<tr>
			<th width="8%">Client Cd</th>
			<th width="18%">Name</th>
			<th width="12%">Fixed</th>
			<th width="10%">Allocated</th>
			<th width="10%">Dana Pemesanan</th>
			<th width="10%">Paid to Emitent</th>
			<th width="12%">Refund</th>
			<th width="3%"><input type="checkbox" name="checkAll3" id="checkAll3" /></th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelDetailRefund as $row){ 
		?>
			<tr id="row<?php echo $x ?>">
				<td>
				<?php echo $form->textField($row,'client_cd',array('name'=>'Tipoclient['.$x.'][client_cd]','class'=>'span ','readonly'=>true)) ;?>
				</td>
				<td>
					<?php echo $form->textField($row,'client_name',array('class'=>'span','name'=>'Tipoclient['.$x.'][client_name]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'pool_qty',array('style'=>'display:none','name'=>'Tipoclient['.$x.'][pool_qty]')); ?>
					<?php echo $form->textField($row,'fixed_qty',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][fixed_qty]','readonly'=>true)); ?>
				</td>
				<td>
						<?php echo $form->textField($row,'alloc_qty',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][alloc_qty]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'fund_ipo',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][fund_ipo]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'paid_ipo',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][paid_ipo]','readonly'=>true)); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'refund',array('style'=>'text-align:right','class'=>'span tnumber','name'=>'Tipoclient['.$x.'][refund]','readonly'=>true)); ?>
					<?php //echo $form->textField($row,'amount',array('style'=>'display:none;','class'=>'span','name'=>'Tipoclient['.$x.'][amount]','readonly'=>true)); ?>
				</td>
				<td style="text-align: center" class="save_flg_refund">
					<?php echo $form->checkBox($row,'save_flg',array('class'=>'checkDetail3','value' => 'Y','name'=>'Tipoclient['.$x.'][save_flg]')); ?>
				</td>
				
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>
	
<div style="text-align: center">
	<?php $this->widget('bootstrap.widgets.TbButton',
			    array('label' => 'Save',
				        'size' => 'medium',
				        'id' => 'btnSave',
				        'buttonType'=>'submit',
				        'htmlOptions'=>array('class'=>'btn-primary')
	    )
	); ?>
</div>

<?php echo $form->datePickerRow($model,'cre_dt',array('style'=>'display:none','label'=>false));?>
<?php // echo $form->datePickerRow($model,'cre_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','style'=>'display:none','options'=>array('format' => 'dd/mm/yyyy'))); ?>

<?php $this->endWidget(); ?>

<script>

var rowCountDana = '<?php echo count($modelDetailDana)?>';
var rowCountPenjatahan = '<?php echo count($modelDetailPenjatahan)?>';
var rowCountRefund = '<?php echo count($modelDetailRefund)?>';
var trf_langsung_flg ='<?php echo $trf_langsung_flg;?>';
init();
function init(){

	$('.tdate').datepicker({format : "dd/mm/yyyy"});
	if(rowCountDana ==0){
		 $("#tableIpo1").hide();
	}
	else{
		 $("#tableIpo1").show();
	}
	
	if(rowCountPenjatahan ==0){
		 $("#tableIpo2").hide();
		
	}
	else{
		 $("#tableIpo2").show();
		 cekTotalAmt();
	}
	if(rowCountRefund ==0){
		 $("#tableIpo3").hide();
	}
	else{
		 $("#tableIpo3").show();
	}
	if(rowCountDana==0 && rowCountPenjatahan==0 && rowCountRefund==0 ){
		$('#btnSave').hide();
	}
	else{
		$('#btnSave').show();
	}
	
		cekGenerate();
		getClient();
		checkPenerimaan();
		checkPenjatahan();
		checkRefund();
		cek_all();
		cek_all2();
		cek_all3();
}

$(window).resize(function() {
		alignColumn();
		alignColumn2();
		alignColumn3();
	})
	$(window).trigger('resize');
	
	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableIpo1").find('thead');
		var firstRow = $("#tableIpo1").find('tbody tr:eq(0)');
		
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
		firstRow.find('td:eq(10)').css('width',header.find('th:eq(10)').width()-17 +'px');
		
	}
	
	function alignColumn2()//align columns in thead and tbody
	{
		var header = $("#tableIpo2").find('thead');
		var firstRow = $("#tableIpo2").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() +'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width()-17 +'px');
		
	}
	function alignColumn3()//align columns in thead and tbody
	{
		var header = $("#tableIpo3").find('thead');
		var firstRow = $("#tableIpo3").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() +'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width()-17 +'px');
		
	}
	
	
	$('#btnFilter').click(function(){
		$('#scenario').val('filter');
	})
	$('#btnSave').click(function(){
		$('#scenario').val('save');
		$('#rowCountDana').val(rowCountDana);
		$('#rowCountPenjatahan').val(rowCountPenjatahan);
		$('#rowCountRefund').val(rowCountRefund);
		cekTotalAmt();
	})
	
	function move(num){
		$('#setor_'+num).val($('#amount_'+num).val());
		$('#saveFlg_'+num).prop('checked',true);
	}
	function moveAll(){
		$("#tableIpo1").children('tbody').children('tr').each(function()
		{
			var amt = $(this).children('td.amt').children('[type=text]').val();

			$(this).children('td.setor').children('[type=text]').val(amt);
		});
		$('.checkDetail').prop('checked',true);
		$('#checkAll').prop('checked',true);
	}
	
	function cekGenerate()
	{
		if($('#Tpee_option_0').is(':checked'))
		{
			$('#btnFilter').html('Generate');
		}
		else
		{
			$('#btnFilter').html('Retrieve');
		}
	}
	
	$('#checkAll').change(function(){
		
		if($('#checkAll').is(':checked'))
		{
			$('.checkDetail').prop('checked',true)
		}
		else
		{
			$('.checkDetail').prop('checked',false)
		}
		
		
	})
	$('.checkDetail').change(function(){
		cek_all();
	})
	
	function cek_all()
	{
		var sign='Y';
		$("#tableIpo1").children('tbody').children('tr').each(function()
		{
			var cek = $(this).children('td.saveFlg1').children('[type=checkbox]').is(':checked');
			
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
	
	
	$('.save_flg_jatah').change(function(){
		cekTotalAmt();
	})
	
	function cekTotalAmt(){
		
		 var total=0;
		 var total_uncheck =0;
		$("#tableIpo2").children('tbody').children('tr').each(function()
		{
			 amt = parseInt(setting.func.number.removeCommas($(this).children('td.fund_ipo').children('[type=text]').val()));

			var saveFlg=$(this).children('td.save_flg_jatah').children('[type=checkbox]').is(':checked');
			
			//alert(saveFlg);
			if(saveFlg)
			{
			
			total+=amt;	
			}
			else{
				total_uncheck +=amt;
			}
		
		});
		
		$('#Tpee_total').val(setting.func.number.addCommas(total));
	}
	$('#Tpee_voucher_ref').change(function(){
		$('#Tpee_voucher_ref').val($('#Tpee_voucher_ref').val().toUpperCase());
	})
	$('.option').change(function(){
		cekGenerate();
	});
	
	$('#Tpee_remarks').change(function(){
		$('#Tpee_remarks').val($('#Tpee_remarks').val().toUpperCase());
	})
	$('#Tpee_branch_cd').change(function(){
	$('#Tpee_branch_cd').val($('#Tpee_branch_cd').val().toUpperCase());	
	})
	function getClient()
	{
		var result = [];
		$('#Tpee_client_cd').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getclient'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        						
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				 response(data);
				           				 result = data;
				    				}
				});
		    },
		    change: function(event,ui)
	        {
	        	$(this).val($(this).val().toUpperCase());
	        	if (ui.item==null)
	            {
	            	// Only accept value that matches the items in the autocomplete list
	            	
	            	var inputVal = $(this).val();
	            	var match = false;
	            	
	            	$.each(result,function()
	            	{
	            		if(this.value.toUpperCase() == inputVal)
	            		{
	            			match = true;
	            			return false;
	            		}
	            	});
	            	
	            }
	        },
		    minLength: 1
		});
	}
	
	$('#checkAll2').change(function(){
		if($('#checkAll2').is(':checked'))
		{
			$('.checkDetail2').prop('checked',true)
		}
		else
		{
			$('.checkDetail2').prop('checked',false)
		}
		
	})


	$('.checkDetail2').change(function(){
		cek_all2();
	})
	
	function cek_all2()
	{
		var sign='Y';
		$("#tableIpo2").children('tbody').children('tr').each(function()
		{
			var cek = $(this).children('td.save_flg_jatah').children('[type=checkbox]').is(':checked');
			
			if(!cek){
				sign='N';
			}
		});
		if(sign=='N'){
			$('#checkAll2').prop('checked',false)	
		}
		else{
			$('#checkAll2').prop('checked',true)
		}
	}
	
	function checkPenerimaan()
	{
		var rdi_type = $('#Tpee_rdi_type_1').is(':checked');
		if(rdi_type)
		{
			$('.checkDetail').prop('checked',true);
			$('.checkDetail').prop('disabled',true);
			$('#checkAll').prop('checked',true)
			$('#checkAll').prop('disabled',true)
		}
		
		
	}
	function checkPenjatahan()
	{
		var rdi_type = $('#Tpee_rdi_type_1').is(':checked');
		if(rdi_type)
		{
			$('.checkDetail2').prop('checked',true);
			$('.checkDetail2').prop('disabled',true);
			$('#checkAll2').prop('checked',true)
			$('#checkAll2').prop('disabled',true)
		}
		
	}
	function checkRefund()
	{
		var rdi_type = $('#Tpee_rdi_type_1').is(':checked');
		if(rdi_type)
		{
			$('.checkDetail3').prop('checked',true);
			$('.checkDetail3').prop('disabled',true);
			$('#checkAll3').prop('checked',true)
			$('#checkAll3').prop('disabled',true)
		}
		
	}
	$('#checkAll3').change(function(){
		if($('#checkAll3').is(':checked'))
		{
			$('.checkDetail3').prop('checked',true)
		}
		else
		{
			$('.checkDetail3').prop('checked',false)
		}
		
	})
	
	$('.checkDetail3').change(function(){
		cek_all3();
	})
	
	function cek_all3()
	{
		var sign='Y';
		$("#tableIpo3").children('tbody').children('tr').each(function()
		{
			var cek = $(this).children('td.save_flg_refund').children('[type=checkbox]').is(':checked');
			
			if(!cek){
				sign='N';
			}
		});
		if(sign=='N'){
			$('#checkAll3').prop('checked',false)	
		}
		else{
			$('#checkAll3').prop('checked',true)
		}
	}
	
	$('#Tpee_batch').change(function(){
			$('#Tpee_batch').val($('#Tpee_batch').val().toUpperCase());
	})
	
	$('.setor_amt').change(function(){
			cek_total();
	})
	
	function cek_total()
	{
		var setor=0;
		$("#tableIpo1").children('tbody').children('tr').each(function()
		{
			//var amt = $(this).children('td.setor').children('[type=text]').val(setting.func.number.removeCommas($(this).val()));
			var amt = parseInt(setting.func.number.removeCommas($(this).children('td.setor').children('[type=text]').val())) 
			//amt = parseInt(amt.replace(',',''));
			setor +=amt;
		});
		//alert(setor)
		$('#Tpee_total_setor').val(setting.func.number.addCommas(setor));
	}
	
	$('#Tpee_tahap').change(function(){
		var tahap = $('#Tpee_tahap').val();
		var stk_cd = $('#Tpee_stk_cd').val();
		if(tahap == '0')
		{
			$('#Tpee_remarks').val('Penerimaan '+stk_cd);
		}
		else if(tahap =='1')
		{
			$('#Tpee_remarks').val('Penjatahan '+stk_cd);
		}
		else if( tahap =='2')
		{
			$('#Tpee_remarks').val('Refund '+stk_cd);
		}
	});
		
	$('#Tpee_stk_cd').change(function(){
		getBatchList();
	})	
	function getBatchList()
	{
		var stk_cd = $('#Tpee_stk_cd').val();
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetBatchList'); ?>',
			'dataType' : 'json',
			'data'     : {
							'stk_cd' : stk_cd,
						}, 
			'success'  : function(data){
				var result = data.content.batch;
				
				$('#Tpee_batch').empty();
				$('#Tpee_batch').append($('<option>').val('').text('-Select-'));
				
				$.each(result, function(i, item) {
			    	$('#Tpee_batch').append($('<option>').val(result[i]).text(result[i]));
				});		
			}
		});
	}
	
</script>
