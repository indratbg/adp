<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tcontracts-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row-fluid">
		<div class="span6">
			<label class="control-label required" for="bj">Beli / Jual</label>
			<?php echo $form->radioButtonListInLineRow($model, 'belijual', AConstant::$contract_belijual,array('id'=>'bj','label'=>false)); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'contr_num',array('readonly'=>'readonly','id'=>'contrnum','label'=>false))?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->datePickerRow($model,'contr_dt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?>
		</div>
		<div class="span6">
			<?php echo $form->datePickerRow($model,'due_dt_for_amt',array('prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy')));?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->dropDownListRow($model,'stk_cd',Chtml::listData(Counter::model()->findAll(array('condition'=>"approved_stat = 'A'",'order'=>'stk_cd')),'stk_cd', 'StockCdAndDesc'), array('prompt'=>'-Choose Stock Code-','id'=>'stk','class'=>'span8')); ?>		
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model,'stk_desc',array('class'=>'span8', 'readonly'=>'readonly','id'=>'stk_desc'))?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo $form->textFieldRow($model, 'qty',array('class'=>'span6 tnumber','maxlength'=>12,'style'=>'text-align: right;')); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model, 'price',array('class'=>'span6 tnumber','maxlength'=>14,'style'=>'text-align: right;')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<label class="control-label required" id="client_label" for="client_cd">Purchase Client <span class="required">*</span></label>
			<?php echo $form->dropDownListRow($model,'client_cd',Chtml::listData(Client::model()->findAll("approved_stat <> 'C' AND susp_stat = 'N' AND client_type_1 <> 'B' order by client_cd"),'client_cd', 'ConcatForSettlementClientCmb'), array('prompt'=>'-Choose Client-',
											'id'=>'client_txt','class'=>'span8','label'=>false)); ?>
		</div>
		<div class="span6">
			<?php echo $form->textFieldRow($model,'brok_perc',array('class'=>'span6 tnumber', 'id'=>'brok_perc', 'maxlength'=>7,'style'=>'text-align: right;'))?>
		</div>
	</div>
	
	<div class="row-fluid">
		<?php if(substr($model->contr_num,4,1) == 'B'){?>
		<div class="span6">
			<?php echo $form->label($model,'Sell Broker',array('class'=>'control-label','id'=>'broker_label'))?>
			<?php echo $form->dropDownListRow($model,'sell_broker_cd',Chtml::listData(Broker::model()->findAll(array('order'=>'broker_name')),'broker_cd', 'broker_name'), array('prompt'=>'-Choose Broker-',
											'id'=>'broker_txt','class'=>'span8','label'=>false)); ?>
		</div>
		<?php }else{?>
		<div class="span6">
			<?php echo $form->label($model,'Buy Broker',array('class'=>'control-label','id'=>'broker_label'))?>
			<?php echo $form->dropDownListRow($model,'buy_broker_cd',Chtml::listData(Broker::model()->findAll(array('order'=>'broker_name')),'broker_cd', 'broker_name'), array('prompt'=>'-Choose Broker-',
											'id'=>'broker_txt','class'=>'span8','label'=>false)); ?>
		</div>
		<?php }?>
		
		<div class="span6">
			<?php echo $form->textFieldRow($model,'broker_lawan_perc',array('class'=>'span6 tnumber', 'id'=>'broker_lawan_perc', 'maxlength'=>7,'style'=>'text-align: right;'))?>
		</div>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
<?php $this->endWidget(); ?>

<script>
	$("#contrnum").hide();
	
	$("#stk").ready(function(){
		
		var x = $("#stk").find(":selected").val();
		if(x){
			var stkval = $("#stk").find(":selected").text();
			var startval = stkval.indexOf(' - ')+3;
			var len = stkval.length;
			var stkdescval = stkval.substring(startval,len);
			$("#stk_desc").val(stkdescval);
		}
	});
	
	$("#stk").change(function(){
		var stkval = $(this.options[this.selectedIndex]).html();
		var stkv = $(this.options[this.selectedIndex]).val();
		if(stkv){
			var startval = stkval.indexOf(' - ')+3;
			var len = stkval.length;
			var stkdescval = stkval.substring(startval,len);
			$("#stk_desc").val(stkdescval);
		}else{
			$("#stk_desc").val('');
		}
	});
	
	$("#bj").ready(function(){
		<?php if (empty($model->belijual)){?>
			$('#Tcontracts_belijual_0').attr('checked','checked');
		<?php } if ($model->belijual == 'J'){?>
			$('#client_label').html('Sell Client <span class="required">*</span>');
		<?php }?>
	});
	
	$("#bj").change(function(){
		var bjval = $("#bj input[type='radio']:checked").val();
		if (bjval == 'B'){
			$('#client_label').html('Purchase Client <span class="required">*</span>');
			$('#broker_label').html('Sell Broker <span class="required">*</span>');
			$('#broker_txt').attr('name','Tcontracts[sell_broker_cd]');
		}else{
			
			$('#client_label').html('Sell Client <span class="required">*</span>');
			$('#broker_label').html('Buy Broker <span class="required">*</span>');
			$('#broker_txt').attr('name','Tcontracts[buy_broker_cd]');
		}
		
	});
	
	$("#client_txt").change(function(){
		var client_cd = $("#client_txt").val();
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetclientcommission'); ?>',
			'dataType' : 'json',
			'data'     : {'client_cd' : client_cd},
			'success'  : function(data){
				var dataCommission = data.content;
				$("#brok_perc").val(dataCommission);
			}
		});
	});
	
	$("#broker_txt").change(function(){
		var brok_cd = $("#broker_txt").val();
		var status = 'I';
		var contrnum = $("#contrnum").val();
		var transtype = $("#bj input[type='radio']:checked").val();
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxGetbrokercommission'); ?>',
			'dataType' : 'json',
			'data'     : {'brok_cd' : brok_cd, 'status' : status, 'contrnum' : contrnum, 'transtype' : transtype},
			'success'  : function(data){
				var dataCommission = data.content;
				$("#broker_lawan_perc").val(dataCommission);
			}
		});
	});
</script>