<style>
	.help-inline.error{display:none;}
</style>
<?php AHelper::showFlash($this) ?> <!-- show flash -->
<h4>From</h4>	
 <table id='table-source' class='table table-bordered table-condensed'>
	<thead>
		<tr>
			<th>Transaction Date</th>
			<th>Client</th>
			<th>Beli / Jual</th>
			<th>Stock</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Due Date</th>
			<th>Commission %</th>
			<th>Sales</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?php echo DateTime::createFromFormat('Y-m-d',$model->contr_dt)->format('d M Y');?></td>
			<td><?php echo $model->client_cd;?></td>
			<td><?php echo AConstant::$contract_belijual[substr($model->contr_num,4,1)]?></td>
			<td><?php echo $model->stk_cd;?></td>
			<td style="text-align: right"><?php echo number_format($model->qty,0);?></td>
			<td style="text-align: right"><?php echo number_format($model->price,0);?></td>
			<td><?php echo DateTime::createFromFormat('Y-m-d',$model->due_dt_for_amt)->format('d M Y');?></td>
			<td style="text-align: right"><?php echo $model->brok_perc;?></td>
			<td><?php echo $model->rem_cd;?></td>
		</tr>
	</tbody>
</table>
 <h4>To</h4>
 <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tcontracts-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>
	<?php echo $form->errorSummary($model); ?>
	<?php 
		foreach($model1 as $row)
			echo $form->errorSummary(array($row)); 
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="table-data" class="items table table-striped table-bordered table-condensed">
        <thead>
            <th style="width: 45%;">Client Code</th>
            <th style="width: 20%;">Quantity</th>
            <!--<th style="width: 10%;">Commission %</th>-->
            <th>Due Date</th>
            <th>&emsp;</th>
        </thead>
       	<tbody>
   		<?php if($rowCount > 0){
			for ($j=2;$j<=$rowCount;$j++){
				if(isset($model1[$j])){?>
			<tr id="row_<?php echo $j;?>">
	       		<td><?php echo $form->dropDownList($model1[$j],'client_cd',CHtml::listData($dropdownclient, 'client_cd', 'CodeAndName'),
	       			array('class'=>'span','id'=>'Tcontracts_client_cd'.$j,'name'=>'Tcontracts['.$j.'][client_cd]')); ?></td>
				<td><?php echo $form->textField($model1[$j],'qty',array('style'=>'text-align: right;','onchange'=>'updqty()','class'=>'span tnumber','maxlength'=>12,'id'=>'Tcontracts_qty'.$j,'name'=>'Tcontracts['.$j.'][qty]')); ?></td>
				<!--<td><?php //echo $form->textField($model1[$j],'brok_perc',array('style'=>'text-align: right;','class'=>'span','id'=>'Tcontracts_brok_perc['.$j.']','name'=>'Tcontracts['.$j.'][brok_perc]')); ?></td>-->	
				<td><?php echo $form->datePickerRow($model1[$j],'due_dt_for_amt',array('label'=>false, 'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','class'=>'tdate span8',
					'id'=>'Tcontracts_due_dt_for_amt'.$j,'name'=>'Tcontracts['.$j.'][due_dt_for_amt]','options'=>array('format' => 'dd/mm/yyyy'))); ?></td>
	       		<td style="text-align: center"><?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png', 'Delete'), 'javascript://', array('class'=>'delete-detail','onclick'=>'deleteRow(this);')); ?>
	       			&nbsp;
	       			<?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/add.png', 'Add'), 'javascript://', array('onclick'=>'addrow();')); ?>
	       		</td>
	       </tr>
	    <?php }}}?>
        </tbody>    	
    </table>
    <table border="0" cellspacing="0" cellpadding="0" id="table-total" class="table-condensed">
    	<tr>
	    	<td style="width: 45%; text-align: right">Total Quantity</td>
	    	<td style="width: 20%"; ><input id="txt_totqty" readonly="readonly" class="span tnumber" type="text" name="txt_totqty" maxlength="12" style="text-align: right;" value="<?php echo $totalqty;?>"></td>
	    	<!--<td style="width: 10%"></td>-->
	    	<td></td>
	    	<td></td>
    	</tr>
    	<tr>
	    	<td style="width: 45%; text-align: right">Remaining Quantity</td>
	    	<td style="width: 20%"; ><input id="txt_remqty" readonly="readonly" class="span tnumber" type="text" name="txt_remqty" maxlength="12" style="text-align: right;" value="<?php echo ($model->qty-$totalqty);?>"></td>
	    	<!--<td style="width: 10%"></td>-->
	    	<td></td>
	    	<td></td>
    	</tr>
    </table>
    <hr />
    <?php echo $form->textAreaRow($model,'correction_reason',array('row'=>2,'class'=>'span6')); ?>
    <input type="hidden" id="rowcount" name="rowcount" <?php if($rowCount > 0){?>value="<?php echo $rowCount;?>"<?php }?> />
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Save',
		)); ?>
	</div>
	
<?php $this->endWidget(); 
	  $model->client_cd = '';?>
	<table class="hidden">
    	<tr id="clone_row" class="hidden">
       		<td><?php echo $form->dropDownList($model,'client_cd',CHtml::listData($dropdownclient, 'client_cd', 'CodeAndName')
       				,array('class'=>'span','prompt'=>'--Select Client--')); ?></td>
			<td><?php echo $form->textField($model,'qty',array('style'=>'text-align: right;','onchange'=>'updqty()','class'=>'span tnumber','maxlength'=>12,'value'=>0)); ?></td>
			<!--<td><?php //echo $form->textField($model,'brok_perc',array('style'=>'text-align: right;','class'=>'span','value'=>0)); ?></td>-->	
			<td><?php echo $form->datePickerRow($model,'due_dt_for_amt',array('value'=>'','label'=>false, 'prepend'=>'<i class="icon-calendar"></i>','placeholder'=>'dd/mm/yyyy','value'=>DateTime::createFromFormat('Y-m-d',$model->due_dt_for_amt)->format('d/m/Y'),'class'=>'tdate span8','options'=>array('format' => 'dd/mm/yyyy'))); ?></td>
       		<td style="text-align: center"><?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png', 'Delete'), 'javascript://', array('class'=>'delete-detail','onclick'=>'deleteRow(this);')); ?>
       		&nbsp;
	       	<?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/add.png', 'Add'), 'javascript://', array('onclick'=>'addrow();')); ?>
	       	</td>
       </tr>
   </table>

<script>

	<?php if($rowCount == 0){?>
		var a = 2;
		cloneRow(a);
		a++;
	<?php }else{?>
		var a = <?php echo $rowCount+1;?>
	<?php }?>
	
	function addrow(){
		
		$('html, body').animate({
	        scrollTop: $("#txt_totqty").offset().top - 350
	    }, 100);	
		cloneRow(a);
		a++;
	}
	
	function updqty(){
		var sumqty = 0;
		for(var n=2;n<=a;n++){
			if($("#Tcontracts_qty"+n).val()){
				var rowqtyval = $("#Tcontracts_qty"+n).val();
				rowqtyval = parseInt(rowqtyval.replace(/,/g, ''), 10);
				sumqty += rowqtyval; 
			}
		}
		$("#txt_totqty").val(setting.func.number.addCommas(sumqty));
		var reqty = <?php echo $model->qty;?>;
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
           	if(nama == 'Tcontracts[due_dt_for_amt]'){
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
		if(nm == 'Tcontracts[due_dt_for_amt]'){
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
