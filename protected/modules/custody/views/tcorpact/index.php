<style>
	.filter-group *
	{
		float:left;
	}
	#tableCorpact
	{
		background-color:#C3D9FF;
	}
	#tableCorpact thead, #tableCorpact tbody
	{
		display:block;
	}
	#tableCorpact tbody
	{
		max-height:300px;
		overflow:auto;
		background-color:#FFFFFF;
	}
	.markCancel
	{
		background-color:#BB0000;
	}
</style>


<?php
$this->breadcrumbs=array(
	'Corporate Action'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Corporate Action', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tcorpact/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
);
?>



<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tcorpact-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>


<?php 
	$ca_type_list = Parameter::model()->findAll($criteriaCorp);
?>
<pre>Jika Warrant yang didapat dari IPO, maka tanggal recording date dan distribution date harus sama</pre>
<div class="row-fluid">
    <div class="span1">
      <label>Stock Code</label>
    </div>
    <div class="span2">
     <?php echo $form->textField($modeldummy,'stk_cd',array('class'=>'span7','onkeypress'=>'getStock(this)','placeholder'=>'TLKM'));?>
    </div>
     <div class="span2">
      <label>Corporate Type</label>
    </div>
    <div class="span2">
     <?php echo $form->dropDownList($modeldummy,'ca_type',CHtml::listData($ca_type_list, 'prm_desc', 'prm_desc'),array('class'=>'span7','prompt'=>'-Select-','style'=>'font-family:courier'));?>
    </div>
    <div class="span2">
      <label>Distribution Sesudah</label>
    </div>
    <div class="span2">
     <?php echo $form->textField($modeldummy,'distrib_dt',array('class'=>'span7 tdate','placeholder'=>'dd/mm/yyyy'));?>   
    </div>
     <div class="span1">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
                            'id'=>'btnFilter',
                            'buttonType'=>'submit',
                            'type'=>'primary',
                            'label'=> 'Search',
                        )); ?>
    </div>
</div>
<br />
<input type="hidden" id="scenario" name="scenario"/>
<input type="hidden" id="rowCount" name="rowCount"/>

<?php 
	foreach($model as $row)
		echo $form->errorSummary(array($row)); 
?>
<table id='tableCorpact' class="table-bordered table-condensed">
	<thead>
		<tr>
		<th width="3%"></th>
		<th width="6%"> Stock</th>
		<th width="8%"> Corporate Action Type</th>
		<th width="6%">To Stock</th>
		<th width="8%"> Cum Date</th>
		<th width="8%"> X Date</th>
		<th width="8%"> Recording Date</th>
		<th width="8%"> Distribution/ Payment Date</th>
		<th width="8%"> Setiap</th>
		<th width="8%"> Menjadi/ Mendapat</th>
		<th width="8%"> Rate</th>
		<th width="9%"> Rounding</th>
		<th width="4%">Round Point</th>
		<th width="4%"> 
				<a style="cursor:pointer;" title="add" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
		</tr>
	</thead>
	<tbody>
		
	<?php $x = 1;
		foreach($model as $row){?>
			<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
			<td class="save_flg">
				<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Tcorpact['.$x.'][save_flg]','onChange'=>'rowControl(this)')) ?>
				<input type="hidden" name="Tcorpact[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
			</td>
			<td >
			    <?php echo $form->textField($row,'stk_cd',array('class'=>'span','name'=>'Tcorpact['.$x.'][stk_cd]','onfocus'=>'getStock(this)','readonly'=>$row->save_flg!='Y'?'readonly':''));?>
				
			<input type="hidden" name="Tcorpact[<?php echo $x ?>][old_stk_cd]" value="<?php echo $row->old_stk_cd ?>" />
			</td>
			<td class="ca_type">
				<?php echo $form->dropDownList($row,'ca_type',CHtml::listData($ca_type_list,'prm_desc','prm_desc2'),array('class'=>'span','name'=>'Tcorpact['.$x.'][ca_type]','id'=>'Tcorpact_'.$x.'_ca_type','onChange'=>$row->save_flg != 'Y' ? 'check_catype('.$x.',true)':'check_catype('.$x.',false)' ,'readonly'=>$row->save_flg!='Y'?'readonly':'','prompt'=>'-Choose-')); ?>
				<input type="hidden" name="Tcorpact[<?php echo $x ?>][old_ca_type]"  value="<?php echo $row->old_ca_type ?>" />
			</td>
			<td class="stk_cd_merge">
			   <?php echo $form->textField($row,'stk_cd_merge',array('class'=>'span','name'=>'Tcorpact['.$x.'][stk_cd_merge]','onfocus'=>'getStock(this)','readonly'=>$row->save_flg!='Y'?'readonly':''));?> 
			</td>
			<td>
				<?php echo $form->textField($row,'cum_dt',array('class'=>'span tdate','onchange'=>'cum_dt('.$x.')','id'=>'Tcorpact_'.$x.'_cum_dt','name'=>'Tcorpact['.$x.'][cum_dt]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
			</td>
			<td>
				<?php echo $form->textField($row,'x_dt',array('class'=>'span tdate','id'=>'Tcorpact_'.$x.'_x_dt','name'=>'Tcorpact['.$x.'][x_dt]','readonly'=>$row->save_flg!='Y'?'readonly':''))	?>			
				<input type="hidden" name="Tcorpact[<?php echo $x ?>][old_x_dt]" value="<?php echo $row->old_x_dt ?>" />
			</td>
			<td>
				<?php echo $form->textField($row,'recording_dt',array('class'=>'span tdate','id'=>'Tcorpact_'.$x.'_recording_dt','name'=>'Tcorpact['.$x.'][recording_dt]','readonly'=>$row->save_flg!='Y'?'readonly':''))?>		
			</td>
			<td>
				<?php echo $form->textField($row,'distrib_dt',array('class'=>'span tdate','id'=>'Tcorpact_'.$x.'_distrib_dt','name'=>'Tcorpact['.$x.'][distrib_dt]','readonly'=>$row->save_flg!='Y'?'readonly':''))?>		
			</td>
			<td>
				<?php echo $form->textField($row,'from_qty',array('class'=>'span','style'=>'text-align:right','id'=>'Tcorpact_'.$x.'_from_qty','name'=>'Tcorpact['.$x.'][from_qty]','readonly'=>$row->save_flg!='Y'?'readonly':''))?>		
			</td>
			<td>
				<?php echo $form->textField($row,'to_qty',array('class'=>'span','style'=>'text-align:right','id'=>'Tcorpact_'.$x.'_to_qty','name'=>'Tcorpact['.$x.'][to_qty]','readonly'=>$row->save_flg!='Y'?'readonly':''))?>	
			</td>
			<td>
				<?php echo $form->textField($row,'rate',array('class'=>'span','style'=>'text-align:right','name'=>'Tcorpact['.$x.'][rate]','readonly'=>$row->save_flg!='Y'?'readonly':''))?>	
			</td>
			<td>
                <?php echo $form->dropDownList($row,'rounding',AConstant::$rounding,array('onchange'=>'changeRounding('.$x.')','class'=>'span','name'=>'Tcorpact['.$x.'][rounding]','id'=>'Tcorpact_'.$x.'_rounding','readonly'=>$row->save_flg!='Y'?'readonly':'','prompt'=>'-Choose-')); ?>
            </td>
            <td>
                <?php echo $form->textField($row,'round_point',array('class'=>'span','style'=>'text-align:right','name'=>'Tcorpact['.$x.'][round_point]','readonly'=>$row->save_flg!='Y'?'readonly':''))?>    
            </td>
			<td>
				<a style="cursor: pointer"
				title="<?php if($row->old_stk_cd) echo 'cancel';else echo 'delete'?>" 
				onclick="<?php if($row->old_stk_cd) echo 'cancel(this,\''.$row->cancel_flg.'\','.$x.')';else echo 'deleteRow(this)'?>">
				<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
				</a>
			</td>
		</tr>
	<?php $x++;
} ?>
	</tbody>
</table>

<?php 
	if($model)
	{
?>
<?php if($model): ?>
	<?php echo $form->label($model[0], 'Cancel Reason', array('class'=>'control-label cancel_reason'))?>
	<textarea id="cancel_reason" class="span5 cancel_reason" name="cancel_reason" maxlength="200" rows="4" disabled><?php echo $cancel_reason ?></textarea>
<?php endif; ?>
<?php echo $form->datePickerRow($model[0],'cre_dt',array('label'=>false,'disabled'=>'disabled','style'=>'display:none','options'=>array('format' => 'dd/mm/yyyy'))); ?>

<?php
	} 
?>
<div class="text-center" style="margin-left:-100px">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'htmlOptions'=>array('id'=>'btnSubmit'),
		'label'=> 'Save',
	)); ?>
</div>
<?php $this->endWidget(); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>


<script>

	var rowCount = <?php echo count($model) ?>;
	var authorizedCancel = true;
	init();
	
	$('#btnFilter').click(function()
	{
		$('#scenario').val('filter');
	});
	
	$('#btnSubmit').click(function()
	{
		$('#scenario').val('save');
		$('#rowCount').val(rowCount);
	});
	
	
	function init()
	{
		
		$('.tdate').datepicker({format:'dd/mm/yyyy'});
		
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxValidateCancel'); ?>',
			'dataType' : 'json',
			'statusCode':
			{
				403		: function(data){
					authorizedCancel = false;
				}
			}
		});
		
		
		
		var x;
		cancel_reason();
		
		//$("#tableSearch tr:eq(0) td:eq(5) input").datepicker({format : "dd/mm/yyyy"});
		for(x=0;x<rowCount;x++)
		{
			$("#Tcorpact_"+x+"_cum_dt").datepicker({format : "dd/mm/yyyy"});
			$("#Tcorpact_"+x+"_x_dt").datepicker({format : "dd/mm/yyyy"});
			$("#Tcorpact_"+x+"_recording_dt").datepicker({format : "dd/mm/yyyy"});
			$("#Tcorpact_"+x+"_distrib_dt").datepicker({format : "dd/mm/yyyy"});
		}
		$('.tdate').datepicker({format : "dd/mm/yyyy"});
	}
	
	function rowControl(obj)
	{
		var x = $(obj).closest('tr').prevAll().length;
		var table = $("#tableCorpact tbody");
		
		table.find("tr:eq("+x+")").attr("id","row"+(x+1));	
		
		table.find("tr:eq("+x+") td:eq(1) input").attr("readonly",!$(obj).is(':checked')?true:false);
    	table.find("tr:eq("+x+") td:eq(2) select").attr("readonly",!$(obj).is(':checked')?true:false);
        table.find("tr:eq("+x+") td:eq(3) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
        table.find("tr:eq("+x+") td:eq(4) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
        table.find("tr:eq("+x+") td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
        table.find("tr:eq("+x+") td:eq(6) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
        table.find("tr:eq("+x+") td:eq(7) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
        table.find("tr:eq("+x+") td:eq(8) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
        table.find("tr:eq("+x+") td:eq(9) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
        table.find("tr:eq("+x+") td:eq(10) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
        table.find("tr:eq("+x+") td:eq(11) select").attr("readonly",!$(obj).is(':checked')?true:false);
        table.find("tr:eq("+x+") td:eq(12) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
        table.find("tr:eq("+x+") td:eq(2) select").attr("onchange",$(obj).is(':checked')?'check_catype('+(x+1)+',false)':'check_catype('+(x+1)+',true)');
       //table.find("tr:eq("+x+") td:eq(11) select").attr("onchange",$(obj).is(':checked')?'changeRounding('+(x+1)+',false)':'changeRounding('+(x+1)+',true)');
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(10) a:eq(0)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked

	}
	
	function addRow()
	{
			$("#tableCorpact").find('tbody')
    		.prepend($('<tr>')
    			.attr('id','row1')
    			.append($('<td>')
				.append($('<input>')
					.attr('name','Tcorpact[1][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.attr('id','Tcorpact_1_save_flg')
					.val('Y')
				)
			).append($('<td>')
         		.append($('<input>')
         			.attr('class','span')
         			.attr('name','Tcorpact[1][stk_cd]')
         			.attr('id','Tcorpact_1_stk_cd')
         			.attr('type','text')
         			.attr('onfocus','getStock(this)')
				)
			).append($('<td>')
           		 .append($('<select>')
           		 	.attr('class','span')
           		 	.attr('name','Tcorpact[1][ca_type]')
           		 	.attr('id','Tcorpact_1_ca_type]')
           		 	.attr('onChange','check_catype(1,false)')
           		 	.append($('<option>')
                        .attr('value','')
                        .html('-Choose-')
                    )
       		 		<?php foreach($ca_type_list as $row){ ?>
           		 	.append($('<option>')
       		 			.attr('value','<?php echo $row['prm_desc'] ?>')
       		 			.html('<?php echo $row['prm_desc2'] ?>')
       		 		)
           		 	<?php } ?>
       		 	)
           	).append($('<td>')
         		.append($('<input>')
         			.attr('class','span')
         			.attr('name','Tcorpact[1][stk_cd_merge]')
         			.attr('id','Tcorpact_1_stk_cd_merge')
         			.attr('type','text')
         			.prop('readonly',true)
         			.attr('onfocus','getStock(this)')
         			
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tcorpact[1][cum_dt]')
           		 	.attr('id','Tcorpact_1_cum_dt')
           		 	.attr('onchange','cum_dt(1)')
           		 	.attr('type','text')
           		 	.datepicker({format : "dd/mm/yyyy"})
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tcorpact[1][x_dt]')
           		 	.attr('id','Tcorpact_1_x_dt')
           		 	.attr('type','text')
           		 	.datepicker({format : "dd/mm/yyyy"})
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tcorpact[1][recording_dt]')
           		 	.attr('id','Tcorpact_1_recording_dt')
           		 	.attr('type','text')
           		 	.datepicker({format : "dd/mm/yyyy"})
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tcorpact[1][distrib_dt]')
           		 	.attr('id','Tcorpact_1_distrib_dt')
           		 	.attr('type','text')
           		 	.datepicker({format : "dd/mm/yyyy"})
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tcorpact[1][from_qty]')
           		 	.attr('type','text')
           		 	.attr('id','Tcorpact[1][from_qty]')
           		 	.attr('value',0)
           		 	.css('text-align','right')
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tcorpact[1][to_qty]')
           		 	.attr('type','text')
           		 	.attr('id','Tcorpact[1][to_qty]')
           		 	.attr('value',0)
           		 	.css('text-align','right')
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Tcorpact[1][rate]')
           		 	.attr('type','text')
           		 	.attr('id','Tcorpact_1_rate')
           		 	.attr('value',0)
           		 	.css('text-align','right')
           		)
           	).append($('<td>')
                 .append($('<select>')
                    .attr('class','span')
                    .attr('name','Tcorpact[1][rounding]')
                    .attr('id','Tcorpact_1_rounding]')
                    .attr('onchange','changeRounding(1)')
                    .append($('<option>')
                        .attr('value','')
                        .html('-Choose-')
                    )
                    <?php foreach(AConstant::$rounding as $key=>$value){ ?>
                    .append($('<option>')
                        .attr('value','<?php echo $key ?>')
                        .html('<?php echo $value ?>')
                    )
                    <?php } ?>
                )
            ).append($('<td>')
                 .append($('<input>')
                    .attr('class','span')
                    .attr('name','Tcorpact[1][round_point]')
                    .attr('type','text')
                    .attr('id','Tcorpact_1_round_point')
                    .attr('value',0)
                    .css('text-align','right')
                )
            ).append($('<td>')
           		.append('&nbsp;')
           		 .append($('<a>')
       		 		.attr('onClick','deleteRow(this)')
       		 		.css('cursor','pointer')
       		 		.attr('title','delete')
       		 		.append($('<img>')
       		 			.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
       		 		)
           		)
           	)  	
		);
    		
		rowCount++;
		reassignId();
			$(window).trigger('resize');
		$('#Tcorpact_0_stk_cd').focus();	
	}
		
	function reassignId()
   	{
   		//var index = $(obj).closest('tr').prevAll().length + 1;
   		var obj = $("#tableCorpact tbody");
   		
   		for(x=0;x<rowCount;x++)
   		{
			obj.find("tr:eq("+x+")").attr("id","row"+(x+1));	
			obj.find("tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Tcorpact["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Tcorpact["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(1)").attr("name","Tcorpact["+(x+1)+"][cancel_flg]");
			obj.find("tr:eq("+x+") td:eq(1) input").attr("name","Tcorpact["+(x+1)+"][stk_cd]");
			obj.find("tr:eq("+x+") td:eq(1) [type=hidden]").attr("name","Tcorpact["+(x+1)+"][old_stk_cd]");
			obj.find("tr:eq("+x+") td:eq(2) select").attr("name","Tcorpact["+(x+1)+"][ca_type]");
			obj.find("tr:eq("+x+") td:eq(2) [type=hidden]").attr("name","Tcorpact["+(x+1)+"][old_ca_type]");
			obj.find("tr:eq("+x+") td:eq(3) [type=text]").attr("name","Tcorpact["+(x+1)+"][stk_cd_merge]");
			obj.find("tr:eq("+x+") td:eq(4) [type=text]").attr("name","Tcorpact["+(x+1)+"][cum_dt]");
			obj.find("tr:eq("+x+") td:eq(5) [type=text]").attr("name","Tcorpact["+(x+1)+"][x_dt]");
			obj.find("tr:eq("+x+") td:eq(5) [type=hidden]").attr("name","Tcorpact["+(x+1)+"][old_x_dt]");
			obj.find("tr:eq("+x+") td:eq(6) [type=text]").attr("name","Tcorpact["+(x+1)+"][recording_dt]");
			obj.find("tr:eq("+x+") td:eq(7) [type=text]").attr("name","Tcorpact["+(x+1)+"][distrib_dt]");
			obj.find("tr:eq("+x+") td:eq(8) [type=text]").attr("name","Tcorpact["+(x+1)+"][from_qty]");
			obj.find("tr:eq("+x+") td:eq(9) [type=text]").attr("name","Tcorpact["+(x+1)+"][to_qty]");
			obj.find("tr:eq("+x+") td:eq(10) [type=text]").attr("name","Tcorpact["+(x+1)+"][rate]");
			obj.find("tr:eq("+x+") td:eq(11) select").attr("name","Tcorpact["+(x+1)+"][rounding]");
			obj.find("tr:eq("+x+") td:eq(12) [type=text]").attr("name","Tcorpact["+(x+1)+"][round_point]");
			
			obj.find("tr:eq("+x+") td:eq(0) [type=checkbox]").attr("id","Tcorpact_"+(x+1)+"_save_flg");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("id","Tcorpact_"+(x+1)+"_save_flg");
			obj.find("tr:eq("+x+") td:eq(2) select").attr("onChange","check_catype("+(x+1)+",false)");
			obj.find("tr:eq("+x+") td:eq(2) select").attr("id","Tcorpact_"+(x+1)+"_ca_type");
			obj.find("tr:eq("+x+") td:eq(3) [type=text]").attr("id","Tcorpact_"+(x+1)+"_stk_cd_merge");
			obj.find("tr:eq("+x+") td:eq(4) [type=text]").attr("onChange","cum_dt("+(x+1)+")");
			obj.find("tr:eq("+x+") td:eq(5) [type=text]").attr("id","Tcorpact_"+(x+1)+"_x_dt");
			obj.find("tr:eq("+x+") td:eq(6) [type=text]").attr("id","Tcorpact_"+(x+1)+"_recording_dt");
            obj.find("tr:eq("+x+") td:eq(7) [type=text]").attr("id","Tcorpact_"+(x+1)+"_distrib_dt");
			obj.find("tr:eq("+x+") td:eq(8) [type=text]").attr("id","Tcorpact_"+(x+1)+"_from_qty");
			obj.find("tr:eq("+x+") td:eq(9) [type=text]").attr("id","Tcorpact_"+(x+1)+"_to_qty");
			obj.find("tr:eq("+x+") td:eq(11) select").attr("id","Tcorpact_"+(x+1)+"_rounding");
			obj.find("tr:eq("+x+") td:eq(12) [type=text]").attr("id","Tcorpact_"+(x+1)+"_round_point");
		
		}
		
		//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0;x<rowCount;x++)
   		{
   		    
   			if($("[name='Tcorpact["+(x+1)+"][cancel_flg]']").val())
   			{
				obj.find("tr:eq("+x+") td:eq(13) a:eq(0)").attr('onClick',"cancel(this,'"+$("[name='Tcorpact["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")
			}		
   			else
   			{
   				obj.find("tr:eq("+x+") td:eq(13) a:eq(0)").attr('onClick',"deleteRow(this)");
   			}
   		}
   	}

	
	function addCommas(obj)
	{
		$(obj).val(setting.func.number.addCommas(setting.func.number.removeCommas($(obj).val())));
	}
	function deleteRow(obj)
	{
		$(obj).closest('tr').remove();
		rowCount--;
		reassignId();
			$(window).trigger('resize');
	}
	
	function cancel(obj, cancel_flg, seq)
	{ 
		if(authorizedCancel)
		{
		$(obj).closest('tr').attr('class',cancel_flg=='N'?'markCancel':''); 
		$('[name="Tcorpact['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
		$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
		
		$("#tableCorpact tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
		
		cancel_reason();
			}
		else
			alert('You are not authorized to perform this action');
		
	}
	
	
	function cancel_reason()
	{
		var cancel_reason = false;
		
		for(x=0;x<rowCount;x++)
		{
			if($("#row"+(x+1)).hasClass('markCancel'))
			{
				cancel_reason = true;
				break;
			}
		}
		
		if(cancel_reason)$(".cancel_reason, #temp").show().attr('disabled',false)
		else
			$(".cancel_reason, #temp").hide().attr('disabled',true);
	}
	function check_catype(rnum,x)
	{	var x;
		if(x == false){
	
		if($("#Tcorpact_"+rnum+"_ca_type").val() == "CASHDIV")
		{
			
			$("#Tcorpact_"+rnum+"_from_qty").val(0);
			$("#Tcorpact_"+rnum+"_to_qty").val(0);
			
			$("#Tcorpact_"+rnum+"_from_qty").prop('readonly',true);
			$("#Tcorpact_"+rnum+"_to_qty").prop('readonly',true);
			$("#Tcorpact_"+rnum+"_stk_cd_merge").prop('readonly',true);
			//21MAR2017
			$("#Tcorpact_"+rnum+"_rounding").val('ROUND');
			$("#Tcorpact_"+rnum+"_round_point").val(2);
		}
		else if($("#Tcorpact_"+rnum+"_ca_type").val() == "MERGE")
		{
			$("#Tcorpact_"+rnum+"_stk_cd_merge").prop('readonly',false);
			//21MAR2017
            $("#Tcorpact_"+rnum+"_rounding").val('CEIL');
            $("#Tcorpact_"+rnum+"_round_point").val('');
		}
		else
		{
			$("#Tcorpact_"+rnum+"_from_qty").prop('readonly',false);
			$("#Tcorpact_"+rnum+"_to_qty").prop('readonly',false);
			$("#Tcorpact_"+rnum+"_stk_cd_merge").prop('readonly',true);
			//21MAR2017
            $("#Tcorpact_"+rnum+"_rounding").val('FLOOR');
            $("#Tcorpact_"+rnum+"_round_point").val('');
		}
	}
	}
	function cum_dt(rnum)
	{
		var cum_dt=$("#Tcorpact_"+rnum+"_cum_dt").val();
		$.ajax({
        	'type'		: 'POST',
        	'url'		: '<?php echo $this->createUrl('getDueDate'); ?>',
        	'dataType' 	: 'json',
        	'data'		:	{'cum_dt': cum_dt},
        	'success'	: 	function (data) 
        					{
						         var x_dt = data.content.x_dt;
						         var recording_dt = data.content.recording_dt;
						         var distrib_dt = data.content.distrib_dt;
						         
						         $("#Tcorpact_"+rnum+"_x_dt").val(x_dt);
						         $("#Tcorpact_"+rnum+"_recording_dt").val(recording_dt);
						         if( $("#Tcorpact_"+rnum+"_ca_type").val()=='SPLIT' || $("#Tcorpact_"+rnum+"_ca_type").val()=='REVERSE')
						         {
						         	$("#Tcorpact_"+rnum+"_distrib_dt").val(distrib_dt);
						         }
		    				}
		});
	}

	$(window).resize(function() {
		var body = $("#tableCorpact").find('tbody');
		if(body.get(0).scrollHeight > body.height()) //check whether  tbody has a scrollbar
		{
			$('thead').css('width', '100%').css('width', '-=17px');	
		}
		else
		{
			$('thead').css('width', '100%');	
		}
		
		alignColumn();
	})
	$(window).trigger('resize');
	
	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableCorpact").find('thead');
		var firstRow = $("#tableCorpact").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() + 'px');
		firstRow.find('td:eq(9)').css('width',header.find('th:eq(9)').width() + 'px');
		firstRow.find('td:eq(10)').css('width',header.find('th:eq(10)').width() + 'px');
		firstRow.find('td:eq(11)').css('width',header.find('th:eq(11)').width() + 'px');
        firstRow.find('td:eq(12)').css('width',header.find('th:eq(12)').width() + 'px');
	}
	
function changeRounding(num)
{
    if($('#Tcorpact_'+num+'_rounding').val() =='ROUND')
    {
        $('#Tcorpact_'+num+'_round_point').prop('readonly',false);
    }
    else
    {
        $('#Tcorpact_'+num+'_round_point').prop('readonly',true);
        $('#Tcorpact_'+num+'_round_point').val('');
    }
}	


function getStock(obj)
{ 
        var result = [];
        $(obj).autocomplete(
        {
            source: function (request, response) 
            {
                $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo Yii::app()->createUrl('share/sharesql/getstock'); ?>',
                    'dataType'  : 'json',
                    'data'      :   {
                                        'term': request.term,
                                        
                                    },
                    'success'   :   function (data) 
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
                     if(!match)
                    {
                        $(this).val('');
                    }
                }
            },
            minLength: 0,
           open: function() { 
                    $(this).autocomplete("widget").width(500);
                     $(this).autocomplete("widget").css('overflow-y','scroll');
                     $(this).autocomplete("widget").css('max-height','250px');
                     $(this).autocomplete("widget").css('font-family','courier');
                } 
        });
    }
</script>
