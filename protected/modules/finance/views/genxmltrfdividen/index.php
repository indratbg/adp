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
	array('label'=>'CBEST Interface to Transfer Dividen', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
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
			<?php echo $form->datePickerRow($model,'payment_date',array('id'=>'paymentDate','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
			<?php echo $form->radioButtonListInlineRow($model,'output',array('XML'=>'XML', 'XLS'=>'Excel'),array('class'=>'output')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'brch_cd',array('id'=>'brchCd','class'=>'span2')) ?>
			<?php echo $form->textFieldRow($model,'stk_cd',array('id'=>'stkCd','class'=>'span2')) ?>
		</div>
	</div>
	
	<div class="row-fluid form-actions">
		<div class="span2">
			<div id="showAll" style="float:left;display:<?php if($retrieved && $resultContent['raw'])echo 'inline';else echo 'none' ?>">
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
	
	<?php if($retrieved){ ?>
	<div id="resultContainer" style="overflow:auto">
		<?php
			echo $this->renderPartial('_result',array('columnName'=>$resultContent['columnName'],'content'=>$resultContent['raw']));
		?>	
	</div>
	
	<div id="xml_dialog" style="display:none">
		<?php
			echo $this->renderPartial('xml',array('xml'=>$resultContent['xml'],'fileName'=>$resultContent['fileName']));
		?>	
	</div>
	<?php } ?>
	
	<div id="downloadFrame">
		<textarea id="xmlSubmit" name="xmlSubmit" style="display:none"></textarea>
		<input type="hidden" id="fileName" name="fileName" />
	</div>

<?php $this->endWidget(); ?>

<script>
	var result = <?php echo json_encode($retrieved?$resultContent['raw']:'') ?>;

	$(document).ready(function()
	{
		if(<?php if($retrieved && $resultContent['raw'])echo 1; else echo 0; ?>)
		{
			showXML();
			populateTable(false);
			alignColumn();
		}
	});
	
	$("#btnShowAll").click(function()
	{
		$(this).hide();
		populateTable(true);
		alert("All data have been displayed");
	});
	
	$("#btnDownload_dialog").click(function()
	{
		$("#fileName").val($(this).siblings(".fileName").val());
		$("#xmlSubmit").html($("#textArea").text());
		$("#btnDownload").click();
	});
	
	$("#brchCd").autocomplete(
	{
		source: function (request, response) 
		{
	        $.ajax({
	        	'type'		: 'POST',
	        	'url'		: '<?php echo $this->createUrl('getBranch'); ?>',
	        	'dataType' 	: 'json',
	        	'data'		:	{
	        						'term': request.term,
	        					},
	        	'success'	: 	function (data) 
	        					{
			           				 response(data);
			    				}
			});
	   },
	   minLength: 0
	}).focus(function(){     
        $(this).data("autocomplete").search($(this).val());
	});
	
	$("#stkCd").autocomplete(
	{
		source: function (request, response) 
		{
	        $.ajax({
	        	'type'		: 'POST',
	        	'url'		: '<?php echo $this->createUrl('getStock'); ?>',
	        	'dataType' 	: 'json',
	        	'data'		:	{
	        						'term': request.term,
	        					},
	        	'success'	: 	function (data) 
	        					{
			           				 response(data);
			    				}
			});
	   },
	   minLength: 1
	})
	
	function showXML()
	{
		$("#xml_dialog").dialog({title:'XML',width:'auto',position: { my: "bottom", at: "bottom", of: window }});		
		$("#btnDownload_dialog").click();
	}
	
	function populateTable(populateAllflg)
	{		
		var threshold = Math.min(result.length, 10);
		var start = populateAllflg ? threshold : 0;
		var end = populateAllflg ? result.length : threshold;
		var table = $("#tableDetail");
		var body = table.children("tbody");
		
		for(x = start; x < end; x++)
		{
			body.append($("<tr>"));

			var tr = body.children("tr:last");
			
			$.each(result[x], function(i, value)
			{
				tr.append($("<td>").addClass("resultColumn").html(value));
			});
		}
	}
	
	function alignColumn()
	{
		var firstRow = $("#tableDetail").children("tbody").children("tr:first");
		var totalWidth = 0;

		$("#tableDetail").children("thead").children("tr").children("td").each(function()
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

		$("#tableDetail").parent("div.tableContainer").css('width', totalWidth + 100);
	}
</script>