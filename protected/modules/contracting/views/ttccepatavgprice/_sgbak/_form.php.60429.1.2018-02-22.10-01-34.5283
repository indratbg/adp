<style>
	.help-inline.error{display:none;}
</style>
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'ttccepatavgprice-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<h4>From</h4>	
 <table id='table-source' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th style="width:10%">Trx Date</th>
			<th style="width:10%">Beli / Jual</th>
			<th>Client</th>
			<th>Stock</th>
			<th style="width:15%">Quantity</th>
		</tr>
	</thead>
	<tbody>
		<?php if($formstat == 'insert'){?>
		<tr>
			<td><?php echo $form->textField($modelfotd,'trade_date',array('class'=>'span tdate','placeholder'=>'dd/mm/yyyy','id'=>'trade_date','name'=>'trade_date','readonly'=>'readonly')); ?></td>
			<td><?php echo $form->dropDownList($modelfotd,'belijual',array('B'=>'Beli','J'=>'Jual'), array('class'=>'span','id'=>'belijual','name'=>'belijual')); ?></td>
       		<td><?php echo $form->dropDownList($modelfotd,'client_cd',CHtml::listData(Client::model()->findAll(array('select'=>'client_cd, client_name','condition'=>"approved_stat <> 'C' AND client_cd IN (SELECT DISTINCT client_cd FROM V_FOTD_TRADE_TC) ",'order'=>'client_cd')), 'client_cd', 'CodeAndName'),
       			array('class'=>'span','id'=>'client_cd','name'=>'client_cd')); ?></td>
       		<td><?php echo $form->dropDownList($modelfotd,'stk_cd',CHtml::listData(Counter::model()->findAll(array('select'=>'stk_cd, stk_desc','condition'=>"approved_stat <> 'C' AND stk_cd IN (SELECT DISTINCT stk_cd FROM V_FOTD_TRADE_TC)",'order'=>'stk_cd')), 'stk_cd', 'StockCdAndDesc'),
       			array('class'=>'span','id'=>'stk_cd','name'=>'stk_cd')); ?></td>
			<td><?php echo $form->textField($modelfotd,'qty',array('style'=>'text-align: right;','class'=>'span tnumber','id'=>'qty','name'=>'qty','readonly'=>'readonly')); ?></td>
       </tr>
       <?php }else{?>
       <tr>
       		<td><?php echo DateTime::createFromFormat('Y-m-d',$modelfotd->trade_date)->format('d/m/Y');;?></td>
       		<td><?php echo AConstant::$contract_belijual[$modelfotd->belijual];?></td>
       		<td><?php echo $modelfotd->client_cd;?></td>
       		<td><?php echo $modelfotd->stk_cd;?></td>
       		<td style="text-align: right;"><?php echo number_format($modelfotd->qty,0);?></td>
       </tr>
       <?php }?>
	</tbody>
</table>
<?php if($formstat == 'insert'){?>
<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Retrieve',
			'id'=>'retbtn'
		)); ?>
	</div>
<?php }?>

<?php if($modelfotd->client_cd){?>

 <h4>To</h4>
 
	<?php echo $form->errorSummary($model);?>
	<?php 
		foreach($model1 as $row)
			echo $form->errorSummary(array($row)); 
	?>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group ">
				<label class="control-label">Average Price</label>
				<div class="controls">
					<input style="text-align: right" class="span6 tnumber" type="text" name="avg_price" maxlength="12" value="<?php echo $avgprice;?>" />
				</div>
			</div>
		</div>
	</div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="table-data" class="items table table-striped table-bordered table-condensed">
        <thead>
            <th style="width: 45%;">Client</th>
            <th style="width: 15%;">Quantity</th>
            <th style="width: 10%;">Commission %</th>
            <th>Due Date</th>
            <th><?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/add.png', 'Add'), 'javascript://', array('id'=>'addrowbtn')); ?></th>
        </thead>
       	<tbody>
   		<?php if($rowCount > 0){
			for ($j=2;$j<=$rowCount;$j++){
				if(isset($model1[$j])){?>
			<tr id="row_<?php echo $j;?>">
	       		<td><?php echo $form->dropDownList($model1[$j],'client_cd',CHtml::listData($modelClient, 'client_cd', 'CodeAndName'),
	       			array('class'=>'span','id'=>'Ttccepat_client_cd['.$j.']','name'=>'Ttccepat['.$j.'][client_cd]')); ?></td>
				<td><?php echo $form->textField($model1[$j],'qty',array('style'=>'text-align: right;','onchange'=>'updqty()','class'=>'span tnumber','maxlength'=>12,'id'=>'Ttccepat_qty['.$j.']','name'=>'Ttccepat['.$j.'][qty]')); ?></td>
				<td><?php echo $form->textField($model1[$j],'brok_perc',array('style'=>'text-align: right;','class'=>'span','id'=>'Ttccepat_brok_perc['.$j.']','name'=>'Ttccepat['.$j.'][brok_perc]')); ?></td>	
				<td><?php echo $form->datePickerRow($model1[$j],'due_dt',array('label'=>false, 'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span',
					'id'=>'Ttccepat_due_dt'.$j,'name'=>'Ttccepat['.$j.'][due_dt]','options'=>array('format' => 'dd/mm/yyyy'))); ?></td>
	       		<td style="text-align: center"><?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png', 'Delete'), 'javascript://', array('class'=>'delete-detail','onclick'=>'deleteRow(this);')); ?></td>
	       </tr>
	    <?php }}}?>
        </tbody>    	
    </table>
    <table border="0" cellspacing="0" cellpadding="0" id="table-total" class="table-condensed">
    	<tr>
	    	<td style="width: 45%; text-align: right">Total Quantity</td>
	    	<td style="width: 15%"; ><input id="txt_totqty" readonly="readonly" class="span tnumber" type="text" name="txt_totqty" maxlength="12" style="text-align: right;" value="<?php echo $totalqty;?>"></td>
	    	<td style="width: 10%"></td>
	    	<td></td>
	    	<td></td>
    	</tr>
    	<tr>
	    	<td style="width: 45%; text-align: right">Remaining Quantity</td>
	    	<td style="width: 15%"; ><input id="txt_remqty" readonly="readonly" class="span tnumber" type="text" name="txt_remqty" maxlength="12" style="text-align: right;" value="<?php echo ($modelfotd->qty-$totalqty);?>"></td>
	    	<td style="width: 10%"></td>
	    	<td></td>
	    	<td></td>
    	</tr>
    </table>
    <hr />
    <?php echo $form->textAreaRow($model,'cancel_reason',array('row'=>2,'class'=>'span6')); ?>
    <input type="hidden" id="rowcount" name="rowcount" <?php if($rowCount > 0){?>value="<?php echo $rowCount;?>"<?php }?> />
	<input type="hidden" name="from_client_cd" id="from_client_cd" value="<?php echo $modelfotd->client_cd;?>" />
    <input type="hidden" name="from_stk_cd" id="from_stk_cd" value="<?php echo $modelfotd->stk_cd;?>" />
    <input type="hidden" name="from_belijual" id="from_belijual" value="<?php echo $modelfotd->belijual;?>" />
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Save',
		)); ?>
	</div>
<?php }?>
	
<?php $this->endWidget(); 
	  $model->client_cd = '';?>
	<table class="hidden">
    	<tr id="clone_row" class="hidden">
       		<td><?php echo $form->dropDownList($model,'client_cd',CHtml::listData($modelClient, 'client_cd', 'CodeAndName')
       				,array('class'=>'span','prompt'=>'--Select Client--')); ?></td>
			<td><?php echo $form->textField($model,'qty',array('style'=>'text-align: right;','onchange'=>'updqty()','class'=>'span tnumber','maxlength'=>12,'value'=>0)); ?></td>
			<td><?php echo $form->textField($model,'brok_perc',array('style'=>'text-align: right;','class'=>'span','value'=>0)); ?></td>	
			<td><?php echo $form->datePickerRow($model,'due_dt',array('value'=>'','label'=>false, 'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span','options'=>array('format' => 'dd/mm/yyyy'))); ?></td>
       		<td style="text-align: center"><?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png', 'Delete'), 'javascript://', array('class'=>'delete-detail','onclick'=>'deleteRow(this);')); ?></td>
       </tr>
   </table>

<script>
	$("#retbtn").click(function(){
		$("#rowcount").val("");
		return true;
	});
	<?php if($rowCount == 0){?>
		var a = 2;
		cloneRow(a);
		a++;
	<?php }else{?>
		var a = <?php echo $rowCount+1;?>
	<?php }?>
	
	$("#addrowbtn").click(function(){	
		cloneRow(a);
		a++;
	});
	
	function updqty(){
		var sumqty = 0;
		for(var n=2;n<=a;n++){
			if($("#Ttccepat_qty"+n).val()){
				var rowqtyval = $("#Ttccepat_qty"+n).val();
				rowqtyval = parseInt(rowqtyval.replace(/,/g, ''), 10);
				sumqty += rowqtyval; 
			}
		}
		$("#txt_totqty").val(setting.func.number.addCommas(sumqty));
		var reqty = <?php echo !empty($modelfotd->qty)?$modelfotd->qty: 0;?>;
		reqty -= sumqty;
		$("#txt_remqty").val(setting.func.number.addCommas(reqty));
	}
	
	function deleteRow(obj){
		var rowdata = $("#table-data tr").length;
		//alert(rowdata);
		if(rowdata > 2){
			$jTr = $(obj).parents('tr:first');
			$jTr.remove();
		}
	}
	
	function cloneRow(i)
	{
		var row = $('#clone_row').clone();
		var table = $('#table-data tbody');
		var newid = '';
		var nm = '';
		
    	//kalo mau replace id,name semua element yang ada di dalam row
    	//kalo mau replace input doank, pake row.find("input")
    	   row.find("*").each(function() {
    	   	var nama = new String(this.name);
    	   	var tipe = typeof this.name;
    	   	
    	   	if(this.id!='')
            this.id = this.id+i;
           	if(nama == 'Ttccepat[due_dt]'){
           		newid = this.id;
           		nm = nama;
           	}
            if(nama!='' && tipe!='undefined')
            {
            	var pos_first = nama.indexOf('[');
            	var pos_last = nama.indexOf(']');
				
            	var model_name  = nama.substring(0,pos_first);
            	var attr_name = nama.substring(pos_first,pos_last+1);
            	
            	this.name = model_name +'['+i+']'+attr_name;
            	
            }//end if nama !='' && tipe!='undefined'
    	});
    	
    	row.removeAttr('class');
		row.attr('id','row_'+i);
		//tambahkan row ke table
		row.appendTo(table);
		if(nm == 'Ttccepat[due_dt]'){
			jQuery(function($) {
				jQuery('[data-toggle=popover]').popover();
				jQuery('body').tooltip({"selector":"[data-toggle=tooltip]"});
				registerFormatField('.tdate','.tnumber')
				registerFormatField('.tdetaildate','.tdetailnumber')
				$(".alert").animate({opacity: 1.0}, 3000).fadeOut("slow");
				jQuery('#yw0_0 .alert').alert();
				jQuery('#yw1_1 .alert').alert();
				jQuery('#'+newid).datepicker({'format':'dd/mm/yyyy','language':'en'});
				jQuery('#yii_bootstrap_collapse_0').collapse({'parent':false,'toggle':false});
			}); 
		}
		$("#rowcount").val(i);
	}
	/*--------------------------------Cloning Row With Javascript--------------------------------*/
</script>
