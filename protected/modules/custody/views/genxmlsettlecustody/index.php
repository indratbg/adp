<style>
	.radio.inline{margin-top:5px}
	
	.radio.inline label{margin-left: 15px;}
	
	.tnumber, .tnumberdec
	{
		text-align:right
	}

	#showloading
	{
		display:none;
		position:absolute;
		left:45%;
		top:20%;
	}
	
	.tableDetailList
	{
		background-color:#C3D9FF;
	}
	.tableDetailList thead, .tableDetailList tbody, .tableDetailList tfoot
	{
		display:block;
	}
	.tableDetailList tbody
	{
		max-height:360px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	.tableDetailList tfoot
	{
		background-color:#FFFFFF;
		font-style:normal;
	}
	
	.resultColumn
	{
		width:auto
	}
	
	.ui-dialog-titlebar
	{
		height:35px;
	}
	
	.tabMenu ul
	{
		border-top:2px solid #ddd;
		border-bottom:2px solid #ddd;
		border-left:2px solid #ddd;
		border-radius:5px;
	}	
	.tabMenu li
	{
		border-right:1px solid #ddd;
		border-radius:5px;
	}
	.tabMenu li:not(:first-child)
	{
		border-left:1px solid #ddd;
		border-radius:5px;
	}
</style>

<?php
$this->breadcrumbs=array(
	'CBEST Interface for Transaction on Custodian / Nego Settlement'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'CBEST Interface for Transaction on Custodian / Nego Settlement', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>
<br />
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'GenXmlSettleCustody-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<?php 
		echo $form->errorSummary($model); 
		
		foreach($modelResult as $row)echo $form->errorSummary($row);
	?>
	
	<div id="showloading" style="display:none;margin: auto; width: auto; text-align: center;">
		Please wait...<br />
		<img src="<?php echo Yii::app()->request->baseUrl ?>/images/loading2.gif" width="25px">	
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->datePickerRow($model,'trx_date',array('id'=>'trxDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			<?php echo $form->datePickerRow($model,'due_date',array('id'=>'dueDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'),'readonly'=>$model->cekInsert=='Y'?'readonly':'')); ?>
			<br/>
			<label class="control-label">Nego Tunai<br/> Before Market Closed</label> <?php echo $form->checkbox($model,'cekInsert',array('id'=>'cekIns','class'=>'','value'=>'Y'))?>
		</div>
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'transfer_type',array('class'=>'control-label')) ?>
				</div>
				<div class="controls">
					<input id="GenXmlSettleCustody_transfer_type_0" class="type" type="radio" name="GenXmlSettleCustody[transfer_type]" value='VP' style="float:left" <?php if($model->transfer_type == 'VP')echo 'checked' ?>>
					<label for="GenXmlSettleCustody_transfer_type_0" style="float:left">&emsp;DVP/RVP</label>
				</div>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="GenXmlSettleCustody_transfer_type_1" class="type" type="radio" name="GenXmlSettleCustody[transfer_type]" value='FOP' style="float:left" <?php if($model->transfer_type == 'FOP')echo 'checked' ?>>
				<label for="GenXmlSettleCustody_transfer_type_1" style="float:left">&emsp;DFOP/RFOP</label>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="GenXmlSettleCustody_transfer_type_2" class="type" type="radio" name="GenXmlSettleCustody[transfer_type]" value='%' style="float:left" <?php if($model->transfer_type == '%')echo 'checked' ?>>
				<label for="GenXmlSettleCustody_transfer_type_2" style="float:left">&emsp;All Deliver/Receive </label>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="GenXmlSettleCustody_transfer_type_3" class="type" type="radio" name="GenXmlSettleCustody[transfer_type]" value='WT' style="float:left" <?php if($model->transfer_type == 'WT')echo 'checked' ?>>
				<label for="GenXmlSettleCustody_transfer_type_3" style="float:left">&emsp;WT from Main1 to Bank</label>
			</div>
		</div>
	</div>
	
	<input type="hidden" id="scenario" name="scenario" value="<?php echo $scenario ?>"/>
	
	<div class="row-fluid form-actions">
		<div class="span2">

		</div>
		<div class="span4" style="text-align:right">
			<div id="retrieve" style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnRetrieve',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Retrieve',
					'htmlOptions'=>array('name'=>'submit','value'=>'retrieve','disabled'=>$model->transfer_type == 'WT')
				)); ?>
			</div>
			
			<div class="span1" style="float:left">
				
			</div>
			
			<div id="retrieve" style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnProcess',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Process',
					'htmlOptions'=>array('name'=>'submit','value'=>'process','disabled'=>!$retrieved && $model->transfer_type != 'WT')
				)); ?>
			</div>
			
			<div class="span1" style="float:left">
				
			</div>
			
			<div style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnDownload',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Download',
					'htmlOptions'=>array('name'=>'submit','value'=>'download','style'=>'display:none')
				)); ?>
			</div>
		</div>
	</div>
	
	<div id="resultContainer" style="overflow:auto;display:<?php if($retrieved)echo 'inline';else echo 'none' ?>">
		<?php echo $this->renderPartial('_result',array('modelResult'=>$modelResult,'form'=>$form),true,false) ?>
	</div>
	
	<div id="xml_dialog" style="display:none">
		<div class="span3">
			<select id="resultType">
				<?php
					foreach($resultContent as $data)
					{
						echo "<option value='{$data['type']}'>{$data['type']}</option>";
					}
				?>
			</select>
		</div>
		<div class="span2">
			<?php 
				$this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnNext',
					'label'=>'Next',
				)); 
			?>
		</div>
		<?php 
			foreach($resultContent as $data)
				echo $this->renderPartial('xml',array('data'=>$data));
		?>
	</div>

	<div id="downloadFrame">
		<textarea id="xmlSubmit" name="xmlSubmit" style="display:none"></textarea>
		<input type="hidden" id="fileName" name="fileName" />
	</div>

<?php $this->endWidget(); ?>

<script>
	var result = <?php echo json_encode($resultArr) ?>;
	
	var changeXMLVisibility = function()
	{
		$(".xmlContainer").each(function()
		{
			if($(this).hasClass($("#resultType").val()))
			{
				$(this).show();
			}
			else
			{
				$(this).hide();
			}
		});
		
		triggerDownloadXML();
	}

	$(document).ready(function()
	{
		alignColumn();
		<?php if($resultContent) echo 'showXML();' ?>
	});
	
	$('#cekIns').change(function(){
		var cek;
		if(this.checked){
			cek = 'Y';
		}else{
			cek = 'N'; 
		}
		if(cek == 'Y'){
			$('#dueDate').val($('#trxDate').val());
			$('#dueDate').prop('readonly',true);	
		}else{
			$('#dueDate').prop('readonly',false);
		}
	});
	
	$(window).resize(function()
	{		
		alignColumn();
	});
	
	$("#trxDate").change(function()
	{
		$("#btnProcess").prop('disabled',true);
		 $.ajax({
        	'type'		: 'POST',
        	'url'		: '<?php echo $this->createUrl('ajxGetDueDate'); ?>',
        	'dataType' 	: 'json',
        	'data'		:	{
        						'trx_date' : $(this).val(),
        					},
        	'success'	: 	function (data) 
        					{
		           				$("#dueDate").val(data)
		    				}
		});
	});
	
	$("#dueDate").change(function(){
		$("#btnProcess").prop('disabled',true);
	});
	
	$(".type").click(function()
	{
		if($(this).val() == 'WT')
		{
			$("#btnRetrieve").prop('disabled',true);
			$("#btnProcess").prop('disabled',false);
		}
		else
		{
			$("#btnRetrieve").prop('disabled',false);
			$("#btnProcess").prop('disabled',<?php if($retrieved)echo 'false';else echo 'true' ?>);
		}
	});
	
	$("#resultType").change(changeXMLVisibility);
	
	$("#btnNext").click(function()
	{
		$("#resultType").children("option:selected").next().prop('selected',true).change();
	});
	
	$(".btnDownload_dialog").click(function()
	{
		$("#fileName").val($(this).siblings(".fileName").val());
		$("#xmlSubmit").html($("#textArea"+$(this).val()).text());
		$("#btnDownload").click();
	});
	
	function showXML()
	{
		changeXMLVisibility();
		$("#xml_dialog").dialog({title:'XML',width:'auto',position: { my: "bottom", at: "bottom", of: window }});		
	}
	
	function triggerDownloadXML()
	{
		var type = $("#resultType").val();
		
		if($("#xmlContent" + type).hasClass("first"))
		{
			$("#xmlContent" + type).removeClass("first");
			if($("#textArea" + type).text())$("#btnDownload"+type).click();
		}	
	}
	
	function alignColumn()
	{
		var table = $("#tableDetail");
		var head = table.children("thead");
		var body = table.children("tbody");
		var firstRow = table.children("tbody").children("tr:first");
		var totalWidth = 0;

		if(firstRow.length)
		{
			if(body.get(0).scrollHeight > body.height()) //check whether  tbody has a scrollbar
			{
				head.css('width', '100%').css('width', '-=17px');	
			}
			else
			{
				head.css('width', '100%');	
			}
			
			firstRow.children("td").each(function()
			{
				var headerColumnWidth = head.children("tr").children("th:eq(" + $(this).index() + ")").width();
				
				$(this).css('width', headerColumnWidth);
			});
		}
	}
	
	function sum(obj)
	{
		var classArr = $(obj).closest('tr').attr('class').split(' ');
		var clientName = classArr[0];
		var stockName = classArr[1];
		var net = $(obj).parent('td').siblings('.net').children('input');
		
		net.prop('checked',false);
		calculate(clientName, stockName);
	}
	
	function net(obj)
	{
		var classArr = $(obj).closest('tr').attr('class').split(' ');
		var clientName = classArr[0];
		var stockName = classArr[1];
		var sum = $(obj).parent('td').siblings('.sum').children('input');
		
		sum.prop('checked',false);	
		calculate(clientName, stockName);
	}
	
	function calculate(clientName, stockName)
	{
		var calc = {};
		calc['firstSumB'] = false;
		calc['firstSumJ'] = false;
		calc['firstNetB'] = false;
		calc['firstNetJ'] = false;
		
		calc['sumB'] = {};
		calc['sumJ'] = {};
		calc['net'] = {};
		
		calc['sumB']['qty'] = 0;
		calc['sumB']['amount'] = 0;
		calc['sumJ']['qty'] = 0;
		calc['sumJ']['amount'] = 0;
		calc['net']['qty'] = 0;
		calc['net']['amount'] = 0;
			
		$("#tableDetail").children("tbody").children("tr."+clientName+"."+stockName).each(function()
		{
			var belijual = $(this).children("td.belijual").children("input").val();
			var qty = parseInt(setting.func.number.removeCommas($(this).children("td.qty").children("input").val()));
			var amount = parseInt($(this).children("td.amount").children("input").val().replace(/[,.]/g, ''));
			
			if($(this).children("td.sum").children("[type=checkbox]").is(":checked"))
			{
				if(!calc['firstSum'+belijual])
				{
					$(this).addClass("firstSum"+belijual).removeClass("firstNet"+belijual);
					calc['firstSum'+belijual] = true;
				}
				else
				{
					$(this).removeClass("firstSum"+belijual+" firstNet"+belijual);
					$(this).children("td.trfQty").children("input").val(0);
					$(this).children("td.trfAmount").children("input").val(0).blur();
				}
				
				calc['sum'+belijual]['qty'] += qty;
				calc['sum'+belijual]['amount'] += amount; 
			}
			else if($(this).children("td.net").children("[type=checkbox]").is(":checked"))
			{
				if(!calc['firstNet'+belijual])
				{
					$(this).addClass("firstNet"+belijual).removeClass("firstSum"+belijual);
					calc['firstNet'+belijual] = true;
				}
				else
				{
					$(this).removeClass("firstSum"+belijual+" firstNet"+belijual);
				}
				
				calc['net']['qty'] += qty;
				calc['net']['amount'] += amount;
			}
			else
			{
				$(this).removeClass("firstSum"+belijual+" firstNet"+belijual);
			}
		});
		
		if(calc['firstSumB'])
		{
			var trfAmount = String(calc['sumB']['amount']);
			var length = trfAmount.length;
			trfAmount = trfAmount.substr(0, length - 2) + '.' +trfAmount.substr(-2);
			
			$("#tableDetail").children("tbody").children("tr."+clientName+"."+stockName+".firstSumB").children("td.trfQty").children("input").val(calc['sumB']['qty']).blur();
			$("#tableDetail").children("tbody").children("tr."+clientName+"."+stockName+".firstSumB").children("td.trfAmount").children("input").val(trfAmount).blur();
		}
		
		if(calc['firstSumJ'])
		{
			var trfAmount = String(calc['sumJ']['amount']);
			var length = trfAmount.length;		
			trfAmount = trfAmount.substr(0, length - 2) + '.' +trfAmount.substr(-2);
			
			$("#tableDetail").children("tbody").children("tr."+clientName+"."+stockName+".firstSumJ").children("td.trfQty").children("input").val(calc['sumJ']['qty']).blur();
			$("#tableDetail").children("tbody").children("tr."+clientName+"."+stockName+".firstSumJ").children("td.trfAmount").children("input").val(trfAmount).blur();
		}
		
		if(calc['firstNetB'] || calc['firstNetJ'])
		{
			var trfAmount = String(calc['net']['amount']);
			var length = trfAmount.length;
			trfAmount = trfAmount.substr(0, length - 2) + '.' +trfAmount.substr(-2);
			
			var notSelector;
			
			if(calc['net']['qty'] > 0)
			{
				$("#tableDetail").children("tbody").children("tr."+clientName+"."+stockName+".firstNetB").children("td.trfQty").children("input").val(calc['net']['qty']).blur();
				$("#tableDetail").children("tbody").children("tr."+clientName+"."+stockName+".firstNetB").children("td.trfAmount").children("input").val(trfAmount).blur();
				
				notSelector = '.firstNetB';
			}
			else if(calc['net']['qty'] < 0)
			{
				$("#tableDetail").children("tbody").children("tr."+clientName+"."+stockName+".firstNetJ").children("td.trfQty").children("input").val(calc['net']['qty']).blur();
				$("#tableDetail").children("tbody").children("tr."+clientName+"."+stockName+".firstNetJ").children("td.trfAmount").children("input").val(trfAmount).blur();
				
				notSelector = '.firstNetJ';
			}
			else
			{
				notSelector = '';
			}
			
			$("#tableDetail").children("tbody").children("tr."+clientName+"."+stockName).not(notSelector).each(function()
			{
				if($(this).children("td.net").children("[type=checkbox]").is(":checked"))
				{
					$(this).children("td.trfQty").children("input").val(0);
					$(this).children("td.trfAmount").children("input").val(0).blur();
				}
			});
		}
		
		$("#tableDetail").children("tbody").children("tr."+clientName+"."+stockName).each(function()
		{
			if(!$(this).children("td.sum").children("[type=checkbox]").is(":checked") && !$(this).children("td.net").children("[type=checkbox]").is(":checked"))
			{
				$(this).children("td.trfQty").children("input").val($(this).children("td.qty").children("input").val());
				$(this).children("td.trfAmount").children("input").val($(this).children("td.amount").children("input").val());
			}
		});
	}
</script>