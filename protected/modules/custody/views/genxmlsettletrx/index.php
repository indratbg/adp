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
		max-height:300px;
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
	'CBEST Interface for Transaction Settlement'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'CBEST Interface for Transaction Settlement', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'genxmlsettletrx-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<?php 
		echo $form->errorSummary($model); 
	?>
	
	<div id="showloading" style="display:none;margin: auto; width: auto; text-align: center;">
		Please wait...<br />
		<img src="<?php echo Yii::app()->request->baseUrl ?>/images/loading2.gif" width="25px">	
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->datePickerRow($model,'trx_date',array('id'=>'trxDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			<?php echo $form->datePickerRow($model,'due_date',array('id'=>'dueDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			<?php echo $form->radioButtonListInlineRow($model,'trx_type',array('A'=>'All', 'B'=>'Net Buy', 'S'=>'Net Sell'),array('class'=>'trxType')); ?>
			<?php echo $form->radioButtonListInlineRow($model,'output',array('XML'=>'XML', 'XLS'=>'Excel'),array('class'=>'output')); ?>
		</div>
		<div class="span6">
			<div class="control-group">
				<div class="span3">
					<?php echo $form->label($model,'transfer_type',array('class'=>'control-label')) ?>
				</div>
				<div class="controls">
					<input id="GenXmlSettleTrx_transfer_type_0" class="type" type="radio" name="GenXmlSettleTrx[transfer_type]" value='N' style="float:left" <?php if($model->transfer_type == 'N')echo 'checked' ?>>
					<label for="GenXmlSettleTrx_transfer_type_0" style="float:left">&emsp;Share - Trx T3</label>
				</div>
			</div>
			
			<div class="control-group" style="display:none">
				<div class="span3">
					&nbsp;
				</div>
				<input id="GenXmlSettleTrx_transfer_type_1" class="type" type="radio" name="GenXmlSettleTrx[transfer_type]" value='004' style="float:left" <?php if($model->transfer_type == '004')echo 'checked' ?>>
				<label for="GenXmlSettleTrx_transfer_type_1" style="float:left">&emsp;Share - Trx T3 + Net Sell T1, T2</label>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="GenXmlSettleTrx_transfer_type_2" class="type" type="radio" name="GenXmlSettleTrx[transfer_type]" value='C' style="float:left" <?php if($model->transfer_type == 'C')echo 'checked' ?>>
				<label for="GenXmlSettleTrx_transfer_type_2" style="float:left">&emsp;Cash (Dana)</label>
			</div>
			
			<div class="control-group">
				<div class="span3">
					&nbsp;
				</div>
				<input id="GenXmlSettleTrx_transfer_type_3" class="type" type="radio" name="GenXmlSettleTrx[transfer_type]" value='TN' style="float:left" <?php if($model->transfer_type == 'TN')echo 'checked' ?>>
				<label for="GenXmlSettleTrx_transfer_type_3" style="float:left">&emsp;Tunai Before Market Closed</label>
			</div>
		</div>
	</div>
	
	<input type="hidden" id="scenario" name="scenario" value="<?php echo $scenario ?>"/>
	
	<div class="row-fluid form-actions">
		<div class="span2">
			<div id="showAll" style="float:left;display:<?php if($retrieved)echo 'inline';else echo 'none' ?>">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnShowAll',
					'label'=>'Show All Data',
				)); ?>
			</div>
		</div>
		<div class="span4" style="text-align:right">
			<div id="retrieve" style="float:left">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'id'=>'btnProcess',
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>'Process',
					'htmlOptions'=>array('name'=>'submit','value'=>'process')
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
		<?php
			$tabs = array();
			$x = $labelCounter = 1;
			foreach($resultContent as $key => $data)
			{
				/*if($x > 1 && $resultContent[$key]['type'] != $resultContent[$key - 1]['type'])
				{
					$labelCounter = 1;
				}*/
				
				$tabs[] = array(
	                'label'   => $data['type'],
	                'content' => $this->renderPartial('_result',array('step'=>$x,'columnName'=>$data['columnName'],'content'=>$data['raw']),true,false),
	                'active'  => $x++ == 1 ? true : false 
				);
			}
	
			$this->widget(
			   'bootstrap.widgets.TbTabs',
			    array(
			        'type' => 'pills', // 'tabs' or 'pills'
			        'tabs' => $tabs,
			        'htmlOptions' => array('id'=>'resultTab', 'class'=>'tabMenu'),
			    )
			);	
		?>	
	</div>
	
	<div id="xml_dialog" style="display:none">
		<?php
			$tabs = array();
			$x = $labelCounter = 1;
			foreach($resultContent as $key => $data)
			{
				/*if($x > 1 && $resultContent[$key]['type'] != $resultContent[$key - 1]['type'])
				{
					$labelCounter = 1;
				}*/
				
				$tabs[] = array(
	                'label'   => $data['type'],
	                'content' => $this->renderPartial('xml',array('step'=>$x,'xml'=>$data['xml'],'fileName'=>$data['fileName']),true,false),
	                'active'  => $x++ == 1 ? true : false 
				);
			}
	
			$this->widget(
			   'bootstrap.widgets.TbTabs',
			    array(
			        'type' => 'pills', // 'tabs' or 'pills'
			        'tabs' => $tabs,
			        'htmlOptions' => array('id'=>'xmlTab', 'class'=>'tabMenu'),
			    )
			);	
		?>	
	</div>

	<div id="downloadFrame">
		<textarea id="xmlSubmit" name="xmlSubmit" style="display:none"></textarea>
		<input type="hidden" id="fileName" name="fileName" />
	</div>

<?php $this->endWidget(); ?>

<script>
	var result = <?php echo json_encode($resultArr) ?>;

	$(document).ready(function()
	{
		if(<?php if($retrieved)echo 1; else echo 0; ?>)
		{
			showXML();
			
			$.each(result, function(i)
			{
				populateTable(i, false);
			});
			
			alignColumn($("#tableDetail1"));
		}
	});
	
	$("#dueDate").change(function()
	{
		 $.ajax({
        	'type'		: 'POST',
        	'url'		: '<?php echo $this->createUrl('ajxGetTrxDate'); ?>',
        	'dataType' 	: 'json',
        	'data'		:	{
        						'due_date' : $(this).val(),
        					},
        	'success'	: 	function (data) 
        					{
		           				$("#trxDate").val(data)
		    				}
		});
	});
	
	$("#btnShowAll").click(function()
	{
		$(this).hide();
		
		$.each(result, function(i)
		{
			populateTable(i, true);
		});
		
		alert("All data have been displayed");
	});
	
	$(".btnDownload_dialog").click(function()
	{
		$("#fileName").val($(this).siblings(".fileName").val());
		$("#xmlSubmit").html($("#textArea"+$(this).val()).text());
		$("#btnDownload").click();
	});
	
	$("#xmlTab").children("ul").children("li").children("a").click(function()
	{
		var step = $(this).parent("li").index() + 1;
		triggerDownloadXML(step);
	});
	
	$("#resultTab").children("ul").children("li").children("a").click(function()
	{
		var activeTabIndex = $(this).parent("li").index();
		var activeTable = $("#tableDetail" + (activeTabIndex + 1));
		
		$("#resultTab").on("shown",function()
		{
			$("#resultTab").off('shown');
			alignColumn(activeTable);
		});
	});
	
	function showXML()
	{
		$("#xml_dialog").dialog({title:'XML',width:'auto',position: { my: "bottom", at: "bottom", of: window }});		
		triggerDownloadXML(1);
	}
	
	function triggerDownloadXML(step)
	{		
		if($("#xmlContent" + step).hasClass("first"))
		{
			$("#xmlContent" + step).removeClass("first");
			if($("#textArea" + step).text())$("#btnDownload"+step).click();
		}	
	}
	
	function populateTable(tableIndex, populateAllflg)
	{		
		var threshold = Math.min(result[tableIndex].length, 10);
		var start = populateAllflg ? threshold : 0;
		var end = populateAllflg ? result[tableIndex].length : threshold;
		var table = $("#tableDetail" + (tableIndex + 1));
		var body = table.children("tbody");
		
		for(x = start; x < end; x++)
		{
			body.append($("<tr>"));

			var tr = body.children("tr:last");
			
			$.each(result[tableIndex][x], function(i, value)
			{
				tr.append($("<td>").addClass("resultColumn").html(value));
			});
		}
	}
	
	function alignColumn(table)
	{
		var firstRow = table.children("tbody").children("tr:first");
		var totalWidth = 0;

		table.children("thead").children("tr").children("td").each(function()
		{
			var rowColumn = firstRow.children("td:eq(" + $(this).index() + ")");

			if($(this).width() > rowColumn.width())
			{
				rowColumn.css('width', $(this).width());
				totalWidth += $(this).outerWidth();
			}
			else
			{
				$(this).css('width', rowColumn.width());
				totalWidth += rowColumn.outerWidth();
			}
		});

		table.parent("div.tableContainer").css('width', totalWidth + 100);
	}
</script>