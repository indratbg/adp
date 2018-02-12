<style>
/*
	.checkBoxInline
	{
		width:1050px;
	}

	.checkBoxInline input[type=checkbox]#Ttccepat_market_type_0 
	{
	    float: left;
	    padding-left: 130px;
	}
	
	.checkBoxInline input[type=checkbox]#Ttccepat_market_type_1
	{
	    float: left;
	   padding-left: -170px;
	}
	
	.checkBoxInline label[for=Ttccepat_market_type_0]  
	{
	    float: left;
	    padding-left: -100px;
	}
	
	.checkBoxInline label[for=Ttccepat_market_type_1]  
	{
	    float: left;
	    padding-left: -140px;
	}
*/
	#loading
	{
		display:none;
		width:150px;
		height:150px;
		position:absolute;
		left:45%;
		top:20%;
	}
</style>

<?php
$this->breadcrumbs=array(
	'Trade Confirmation Cepat Nego/Tunai'=>array('index'),
	'Index',
);

$this->menu=array(
	array('label'=>'Trade Confirmation Cepat Fixed Price', 'itemOptions'=>array('class'=>'nav-header')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active')),
);

?>

<h1>Generate Trade Confirmation Cepat Nego/Tunai</h1>

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
<?php 
	foreach($modelTcDoc as $row)
		echo $form->errorSummary($row); 
?>

<div id="loading">
	<img src="<?php echo Yii::app()->request->baseUrl ?>/images/loading.gif">
</div>

<div class="row-fluid">
	<div class="span2">
		<?php echo $form->label($model,'Date',array('for'=>'contrDt','class'=>'control-label')) ?>
	</div>
	<?php echo $form->datePickerRow($model,'contr_dt',array('id'=>'contrDt','prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span10','label'=>false,'options'=>array('format' => 'dd/mm/yyyy'))); ?>
</div>

<div class="row-fluid">
	<div class="span2">
		<?php echo $form->label($model,'Market Type',array('class'=>'control-label')) ?>
	</div>

	<?php //echo $form->checkBoxListInlineRow($model,'market_type',array('TN'=>'Tunai','NG'=>'Nego'),array('class'=>'marketType','label'=>false)) ?>

	<input type="checkbox" class="marketType" value="TN" id="Ttccepat_market_type_0" name="Ttccepat[market_type][0]" <?php if(strpos($market_type,'TN') !== false)echo 'checked' ?>/>&emsp;Tunai&emsp;&emsp;
	<input type="checkbox" class="marketType" value="NG" id="Ttccepat_market_type_1" name="Ttccepat[market_type][1]" <?php if(strpos($market_type,'NG') !== false)echo 'checked' ?>/>&emsp;Nego 
</div>

<table id='tableTcCepat' class='table-bordered table-condensed' style='display:<?php if($modelFotd)echo 'table';else echo 'none'?>'>
	<thead>
		<tr>
			<th width="5px"><input type="checkbox" id="checkBoxAll" value="1" onClick= "changeAll()"/></th>
			<th width="100px">Client Code</th>
			<th width="100px">Stock Code</th>
			<th width="100px">Market Type</th>
			<th width="150px">Due Date</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelFotd as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><input type="checkbox" class="<?php if(($row->mrkt_type != 'TS' && $row->mrkt_type != 'NG') || $row->due_date == $model->contr_dt)echo 'checkBoxDetail' ?>" id="checkBox<?php echo $x ?>" name="checkBox<?php echo $x ?>" <?php if($row->check_flag)echo 'checked' ?> <?php if(($row->mrkt_type == 'TS' || $row->mrkt_type == 'NG') && $row->due_date != $model->contr_dt)echo 'disabled' ?> value="1"/></td>
			<td><?php echo $form->textField($row,'client_cd',array('class'=>'span detail'.$x,'name'=>'Fotdtrade['.$x.'][client_cd]','disabled'=>'disabled')); ?></td>
			<td><?php echo $form->textField($row,'stk_cd',array('class'=>'span detail'.$x,'name'=>'Fotdtrade['.$x.'][stk_cd]','disabled'=>'disabled')); ?></td>
			<td><?php echo $form->textField($row,'mrkt_type',array('class'=>'span detail'.$x,'name'=>'Fotdtrade['.$x.'][mrkt_type]','disabled'=>'disabled')); ?></td>
			<td><?php echo $form->textField($row,'due_date',array('class'=>$row->mrkt_type=='TN'?'span tdate detail'.$x:'span tdate','name'=>'Fotdtrade['.$x.'][due_date]','disabled'=>$row->mrkt_type=='TN'?'disabled':'','onChange'=>'checkDate(this,'.$x.')')); ?></td>
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
				'htmlOptions'=>array('style'=>!$model->market_type?'display:none':'display:inline'),
	)); ?>
</div>

<br/><br/>

<?php $this->endWidget(); ?>

<script>
	var rowCount = <?php echo count($modelFotd) ?>;
	var x;

	init();
	
	$(".marketType").change(function(){
		getClientList();
	})
	
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
	
	$("#contrDt").datepicker( "widget" ).on('changeDate',function()
	{
		getClientList();
	});
	
	$(document).ajaxStart(function() {
  		 $('#loading').show();
	});
	
	$(document).ajaxStop(function() {
   		$('#loading').hide();
	});
	
	function init()
	{
		$("#contrDt").datepicker({format : "dd/mm/yyyy"});
		for(x=0;x<rowCount;x++)
		{
			$("#tableTcCepat tbody tr:eq("+x+") td:eq(4) input").datepicker({format : "dd/mm/yyyy"});
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
	
	function checkDate(obj,seq)
	{
		if($('[name = "Fotdtrade['+seq+'][mrkt_type]"]').val() == 'TS' || $('[name = "Fotdtrade['+seq+'][mrkt_type]"]').val() == 'NG')
		{
			if($(obj).val() == $("#contrDt").val())
			{
				$('#checkBox'+seq).attr('class','checkBoxDetail').prop('disabled',false);
			}
			else
			{
				$('#checkBox'+seq).attr('class','').prop('disabled',true).prop('checked',false);
			}
		}
	}

	function getClientList() // ALL
	{
		var type1,type2;
		
		if($("#Ttccepat_market_type_0").is(":checked"))type1=1;
		else
			type1=0;
			
		if($("#Ttccepat_market_type_1").is(":checked"))type2=1;
		else
			type2=0;
		
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetClientListFixed'); ?>',
			'dataType' : 'json',
			'data'     : {
							'tc_date' : $("#contrDt").val(),
							'type1'	: type1,
							'type2' : type2,
						}, 
			'success'  : function(data){
				var client_cd = data.content.client_cd;
				var stk_cd = data.content.stk_cd;
				var mrkt_type = data.content.mrkt_type;
				var due_date = data.content.due_date;
				
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
				               		 	.attr('class',(mrkt_type[i]=="TS"||mrkt_type[i]=="NG") && due_date[i] != $("#contrDt").val()?"":"checkBoxDetail")
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
				               		 	.attr('name','Fotdtrade['+(i+1)+'][mrkt_type]')
				               		 	.attr('type','text')
				               		 	.attr('disabled','')
				               		 	.val(mrkt_type[i])
				               		)
				               	).append($('<td>')
				               		 .append($('<input>')
				               		 	.attr('class',mrkt_type[i]=='TN'?'span detail'+(i+1):'span')
				               		 	.attr('name','Fotdtrade['+(i+1)+'][due_date]')
				               		 	.attr('type','text')
				               		 	.attr('disabled',mrkt_type[i]=='TN'?true:false)
				               		 	.attr('onChange','checkDate(this,'+(i+1)+')')
				               		 	.val(due_date[i])
				               		 	.datepicker({format : "dd/mm/yyyy"})
				               		 )
				               	)
				            )
				            if((mrkt_type[i] == 'TS' || mrkt_type[i] == 'NG')&& due_date[i] != $("#contrDt").val())$("#checkBox"+(i+1)).prop('disabled',true);  	
						});
					$('#tableTcCepat').show();
					$("#btnSubmit").show();
				}
				else
				{
					$('#tableTcCepat').hide();
					$("#btnSubmit").hide();		
				}
			/*		
			if($("#Ttccepat_market_type_0").is(':checked') || $("#Ttccepat_market_type_1").is(':checked'))$("#btnSubmit").show()
			else
				$("#btnSubmit").hide();	
			*/
			}
		});
	}
</script>