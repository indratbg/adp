<?php
$this->breadcrumbs=array(
	'Trade Confirmation Cepat Fixed Price'=>array('index'),
	'Index',
);

$this->menu=array(
	array('label'=>'Trade Confirmation Cepat Fixed Price', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
);

?>

<h1>Generate Trade Confirmation Cepat Fixed Price</h1>

<br/><br/>

<?php AHelper::showFlash($this) ?>
<?php AHelper::applyFormatting() ?> <!-- apply formatting to date and number -->

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tcontracts-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<?php echo $form->errorSummary($model); ?>
<?php 
	foreach($model1 as $row)
		echo $form->errorSummary($row); 
?>

<div class="row-fluid">
	<div class="span2" >
		<?php echo $form->label($model,'Date',array('for'=>'contrDt','class'=>'control-label')) ?>
	</div>
	<?php echo $form->datePickerRow($model,'contr_dt',array('id'=>'contrDt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span10','label'=>false,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
</div>

<div class="row-fluid">
	<?php echo $form->dropDownListRow($model,'client_cd',CHtml::listData(Client::model()->findAll(array('select'=>'DISTINCT client_cd,client_name','join'=>'JOIN FOTD_TRADE a ON a.clearingAccount = t.client_cd','condition'=>"a.symbolsfx = '0RG'",'order'=>'client_cd')), 'client_cd', 'CodeAndName'),array('id'=>'clientCd','class'=>'span4','prompt'=>'-Choose Client-','onChange'=>'getTradeList()')) ?>
</div>

<div class="row-fluid">
	<?php echo $form->radioButtonListInlineRow($model,'doc_type',array('New','Revise'),array('id'=>'docType')) ?>
</div>

<table id='tableTcCepat' class='table-bordered table-condensed' style='display:<?php if($modelFotd)echo 'table';else echo 'none'?>'>
	<thead>
		<tr>
			<th width="5px"><input type="checkbox" id="checkBoxAll" value="1" onClick= "changeAll()"/></th>
			<th width="120px">Client Code</th>
			<th width="100px">Stock Code</th>
			<th width="100px">Trx Type</th>
			<th width="150px">Qty</th>
			<th width="100px">Market Type</th>
			<th width="150px">Due Date</th>
			<th width="150px">Price</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelFotd as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><input type="checkbox" class="checkBoxDetail" id="checkBox<?php echo $x ?>" name="checkBox<?php echo $x ?>" <?php if($row->check_flag)echo 'checked' ?> value="1"/></td>
			<td><?php echo $form->textField($row,'client_cd',array('class'=>'span detail'.$x,'name'=>'Fotdtrade['.$x.'][client_cd]','disabled'=>'disabled')); ?></td>
			<td><?php echo $form->textField($row,'stk_cd',array('class'=>'span detail'.$x,'name'=>'Fotdtrade['.$x.'][stk_cd]','disabled'=>'disabled')); ?></td>
			<td><?php echo $form->textField($row,'trx_type',array('class'=>'span detail'.$x,'name'=>'Fotdtrade['.$x.'][trx_type]','disabled'=>'disabled')); ?></td>
			<td><?php echo $form->textField($row,'qty',array('class'=>'span tnumber detail'.$x,'name'=>'Fotdtrade['.$x.'][qty]','disabled'=>'disabled','style'=>'text-align:right')); ?></td>
			<td><?php echo $form->textField($row,'mrkt_type',array('class'=>'span detail'.$x,'name'=>'Fotdtrade['.$x.'][mrkt_type]','disabled'=>'disabled')); ?></td>
			<td><?php echo $form->textField($row,'due_date',array('class'=>'span tdate','name'=>'Fotdtrade['.$x.'][due_date]')); ?></td>
			<td><?php echo $form->textField($row,'price',array('class'=>'span tnumber detail'.$x,'name'=>'Fotdtrade['.$x.'][price]','disabled'=>'disabled','style'=>'text-align:right')); ?></td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>

<input type="hidden" id="rowCount" name="rowCount"/>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id'=>'btnSubmit',
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Save',
	)); ?>
</div>

<br/><br/>

<?php $this->endWidget(); ?>

<script>
	var rowCount = <?php echo count($modelFotd) ?>;
	var x;

	init();
	
	$("#btnSubmit").click(function(){
		for(x=0;x<rowCount;x++)
		{
			if($("#checkBox"+(x+1)).is(':checked'))
			{
				$(".detail"+(x+1)).prop('disabled',false);
				$(".detail"+(x+1)).prop('readonly',true);
			}
		}
		$("#rowCount").val(rowCount);
	})
	
	function init()
	{
		for(x=0;x<rowCount;x++)
		{
			$("#tableTcCepat tbody tr:eq("+x+") td:eq(6) input").datepicker({format : "dd/mm/yyyy"});
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
	
	function getTradeList() // SPECIFIED
	{
		
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetTradeListFixed'); ?>',
			'dataType' : 'json',
			'data'     : {
							'client_cd' : $("#clientCd").val(),
						}, 
			'success'  : function(data){
				var client_cd = data.content.client_cd;
				var stk_cd = data.content.stk_cd;
				var trx_type = data.content.trx_type;
				var qty = data.content.qty;
				var mrkt_type = data.content.mrkt_type;
				var due_date = data.content.due_date;
				var price = data.content.price;
				
				rowCount = client_cd.length;
				
				$('#tableTcCepat tbody').empty();
				
				if(client_cd.length > 0)
				{
					$.each(client_cd, function(i, item){
				    	$('#tableTcCepat').find('tbody')
					    	.append($('<tr>')
				    			.attr('id','row'+(i+1))
				        		.append($('<td>')
				               		 .append($('<input>')
				               		 	.attr('type','checkbox')
				               		 	.attr('id','checkBox'+(i+1))
				               		 	.attr('name','checkBox'+(i+1))
				               		 	.attr('class','checkBoxDetail')
				               		 	.val('1')
				               		)
								).append($('<td>')
				               		 .append($('<input>')
				               		 	.attr('class','span detail'+(i+1))
				               		 	.attr('name','Fotdtrade['+(i+1)+'][client_cd]')
				               		 	.attr('type','text')
				               		 	.attr('disabled','')
				               		 	.val(client_cd[i])
				               		)
				               	).append($('<td>')
				               		 .append($('<input>')
				               		 	.attr('class','span detail'+(i+1))
				               		 	.attr('name','Fotdtrade['+(i+1)+'][stk_cd]')
				               		 	.attr('type','text')
				               		 	.attr('disabled','')
				               		 	.val(stk_cd[i])
				               		)
				               	).append($('<td>')
				               		 .append($('<input>')
				               		 	.attr('class','span detail'+(i+1))
				               		 	.attr('name','Fotdtrade['+(i+1)+'][trx_type]')
				               		 	.attr('type','text')
				               		 	.attr('disabled','')
				               		 	.val(trx_type[i])
				               		)
				               	).append($('<td>')
				               		 .append($('<input>')
				               		 	.attr('class','span tnumber detail'+(i+1))
				               		 	.attr('name','Fotdtrade['+(i+1)+'][qty]')
				               		 	.attr('type','text')
				               		 	.attr('disabled','')
				               		 	.val(setting.func.number.addCommas(qty[i]))
				               		 	.css('text-align','right')
				               		)
				               	).append($('<td>')
				               		 .append($('<input>')
				               		 	.attr('class','span detail'+(i+1))
				               		 	.attr('name','Fotdtrade['+(i+1)+'][mrkt_type]')
				               		 	.attr('type','text')
				               		 	.attr('disabled','')
				               		 	.val(mrkt_type[i])
				               		)
				               	).append($('<td>')
				               		 .append($('<input>')
				               		 	.attr('class','span')
				               		 	.attr('name','Fotdtrade['+(i+1)+'][due_date]')
				               		 	.attr('type','text')
				               		 	.val(due_date[i])
				               		 	.datepicker({format : "dd/mm/yyyy"})
				               		 )
				               	).append($('<td>')
				               		 .append($('<input>')
				               		 	.attr('class','span tnumber detail'+(i+1))
				               		 	.attr('name','Fotdtrade['+(i+1)+'][price]')
				               		 	.attr('type','text')
				               		 	.attr('disabled','')
				               		 	.val(setting.func.number.addCommas(price[i]))
				               		 	.css('text-align','right')
				               		)
				               	)
				            )  	
						});
					$('#tableTcCepat').show();
				}
				else
					$('#tableTcCepat').hide();		
			}
		});
	}
</script>