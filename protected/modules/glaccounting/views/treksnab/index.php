<style>
	.filter-group *
	{
		float:left;
	}
	#tableNab
	{
		background-color:#C3D9FF;
	}
	#tableNab thead, #tableNab tbody
	{
		display:block;
	}
	#tableNab tbody
	{
		max-height:300px;
		overflow-y:scroll;
		background-color:#FFFFFF;
	}
	.markCancel
	{
		background-color:#BB0000;
	}
</style>

<?php
$this->breadcrumbs=array(
	'NAB Harian Entry'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Nab Harian', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/treksnab/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php 
		$query="SELECT DISTINCT reks_cd,reks_cd ||' - ' ||reks_name as reks_name, t.reks_type, m.reks_type_txt, afiliasi,
				GL_A1, GL_A2,SL_A1,SL_a2
				FROM T_REKS_TRX t, MST_REKS_TYPE m
				WHERE t.reks_type = m.reks_type
				ORDER BY reks_cd";
		$rek_Cdlist=DAO::queryAllSql($query);
		
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'treksnab-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	foreach($model as $row)
		echo $form->errorSummary(array($row)); 
?>

<br/>

<div class="filter-group">
	<label for="dateRange">NAB Date Since&emsp;</label>
	<input type="text" id="dateRange" name="dateRange" class="span1" value="<?php echo $dateRange ?>" style="float:left;text-align:right"/>
	<label>&emsp;Day(s) Ago</label>

	<input type="hidden" id="scenario" name="scenario"/>
	
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id' => 'btnFilter',
		'buttonType' => 'submit',
		'type'=>'primary',
		'label'=>'Filter',
		'htmlOptions' => array('style'=>'margin-left:3em'),
	)); ?>
</div>

<input type="hidden" id="oldDateRange" name="oldDateRange" value="<?php echo $dateRange ?>"/>

<input type="hidden" id="rowCount" name="rowCount"/>
<br/><br/><br/>

<table id='tableNab' class='table-bordered table-condensed' style="width: 994px" >
	<thead>
		<tr>
			<th width="15px">&nbsp;</th>
			<th width="379px">Kode Reksa Dana</th>
			<th width="141">NAB Date</th>
			<th width="140">NAB Unit</th>
			<th width="140">NAB</th>
			<th width="140">Mkbd Date</th>
			<th width="37px">
				<a title="add" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png" /></a>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($model as $row){
		
	?>
		<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
			<td width="15px">
				<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Treksnab['.$x.'][save_flg]','onChange'=>'rowControl(this)')) ?>
				<?php if($row->old_reks_cd): ?>
					<input type="hidden" name="Treksnab[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php endif; ?>
			</td>
			<td width="379px">
				<?php echo $form->dropDownList($row,'reks_cd',CHtml::listData($rek_Cdlist, 'reks_cd', 'reks_name'),array('class'=>'span','name'=>'Treksnab['.$x.'][reks_cd]','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?>
				<input type="hidden" name="Treksnab[<?php echo $x ?>][old_reks_cd]" value="<?php echo $row->old_reks_cd ?>"/>
			</td>
			<td width="141px"><?php echo $form->textField($row,'nab_date',array('class'=>'span tdate','name'=>'Treksnab['.$x.'][nab_date]','readonly'=>$row->save_flg !='Y'?'readonly':'')); ?></td>
			<td width="140px"><?php echo $form->textField($row,'nab_unit',array('class'=>'span','autocomplete'=>'off','onload'=>'formatNumber('.$x.')','value'=>number_format((float) $row->nab_unit,6,'.',','),'maxlength'=>19,'name'=>'Treksnab['.$x.'][nab_unit]','readonly'=>$row->save_flg !='Y'?'readonly':'','style'=>'text-align:right')); ?></td>
			<td width="140px"><?php echo $form->textField($row,'nab',array('class'=>'span','autocomplete'=>'off','onchange'=>'formatNumber('.$x.')','value'=>number_format((float) $row->nab,2,'.',','),'maxlength'=>21,'name'=>'Treksnab['.$x.'][nab]','readonly'=>$row->save_flg !='Y'?'readonly':'','style'=>'text-align:right')); ?></td>
			<td width="140px">
				<?php echo $form->textField($row,'mkbd_dt',array('class'=>'span tdate','name'=>'Treksnab['.$x.'][mkbd_dt]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Treksnab[<?php echo $x ?>][old_mkbd_dt]" value="<?php echo $row->old_mkbd_dt ?>"/>
			</td>
			<td width="30px">
				<a
				title="<?php if($row->old_reks_cd) echo 'cancel';else echo 'delete'?>" 
					onclick="<?php if($row->old_reks_cd) echo 'cancel(this,\''.$row->cancel_flg.'\','.$x.')';else echo 'deleteRow(this)'?>">
					<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
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
	})
	$('#btnSubmit').click(function()
	{
		$('#scenario').val('save');
		$('#rowCount').val(rowCount);
	})
	/*
	$('#treksnab-form').bind("keyup keypress", function(e) {
		
	  	var code = e.keyCode || e.which; 
	  	if (code  == 13) {               
	    e.preventDefault();
	    return false;
	  	}
	});
	*/
	function init()
	{
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
		
		for(x=0;x<rowCount;x++)
		{
			$("#tableNab tbody tr:eq("+x+") td:eq(2) input").datepicker({format : "dd/mm/yyyy"});
			$("#tableNab tbody tr:eq("+x+") td:eq(5) input").datepicker({format : "dd/mm/yyyy"});
		}
		
		cancel_reason();
	}
	
	function rowControl(obj)
	{
		var x = $(obj).closest('tr').prevAll().length;
		
		$("#tableNab tbody tr:eq("+x+")").attr("id","row"+(x+1));	
		
		$("#tableNab tbody tr:eq("+x+") td:eq(1) select").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableNab tbody tr:eq("+x+") td:eq(2) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableNab tbody tr:eq("+x+") td:eq(3) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableNab tbody tr:eq("+x+") td:eq(4) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableNab tbody tr:eq("+x+") td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(6) a:eq(0)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}
	
	function addRow()
	{
		
	
			
			$("#tableNab").find('tbody')
    		.prepend($('<tr>')
    			.attr('id','row1')
    			.append($('<td>')
				.append($('<input>')
					.attr('name','Treksnab[1][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
				)
			)
        		.append($('<td>')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Treksnab[1][reks_cd]')
               		 	<?php
               		 		foreach($rek_Cdlist as $row){
               		 	?>
           		 		.append($('<option>')
           		 			.attr('value','<?php echo $row['reks_cd'] ?>')
           		 			.html('<?php echo $row['reks_name'] ?>')
           		 		)
               		 	<?php } ?>
               		)
				).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Treksnab[1][nab_date]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Treksnab[1][nab_unit]')
               		 	.attr('type','text')
               		 	.attr('maxlength',19)
               		 	.attr('id','Treksnab_1_nab_unit')
               		 	.attr('onload','formatNumber(1)')
               		 	.css('text-align','right')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Treksnab[1][nab]')
               		 	.attr('type','text')
               		 	.attr('maxlength',21)
               		 	.attr('id','Treksnab_1_nab')
               		 	.attr('onChange','formatNumber(1)')
               		 	.css('text-align','right')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Treksnab[1][mkbd_dt]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		 .append($('<a>')
           		 		.attr('onClick','deleteRow()')
           		 		.attr('title','delete')
       		 		 	.append($('<img>')
           		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
               		 	//.css('width','13px')
               		 	//.css('height','13px')
               		 	)
               		)
               	)  	
    		);
    		
		rowCount++;
		reassignId();
	
		$('#Treksnab_1_nab_unit').focus();
	}
	function reassignId()
   	{
   		//var index = $(obj).closest('tr').prevAll().length + 1;
   		for(x=0;x<rowCount;x++)
   		{
			$("#tableNab tbody tr:eq("+x+")").attr("id","row"+(x+1));	
			$("#tableNab tbody tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Treksnab["+(x+1)+"][save_flg]");
			$("#tableNab tbody tr:eq("+x+") td:eq(0) [type=hidden]:eq(1)").attr("name","Treksnab["+(x+1)+"][cancel_flg]");
			$("#tableNab tbody tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Treksnab["+(x+1)+"][save_flg]");
			$("#tableNab tbody tr:eq("+x+") td:eq(1) select").attr("name","Treksnab["+(x+1)+"][reks_cd]");
			$("#tableNab tbody tr:eq("+x+") td:eq(1) [type=hidden]").attr("name","Treksnab["+(x+1)+"][old_reks_cd]");
			$("#tableNab tbody tr:eq("+x+") td:eq(2) [type=text]").attr("name","Treksnab["+(x+1)+"][nab_date]");
			$("#tableNab tbody tr:eq("+x+") td:eq(3) [type=text]").attr("name","Treksnab["+(x+1)+"][nab_unit]");
			$("#tableNab tbody tr:eq("+x+") td:eq(4) [type=text]").attr("name","Treksnab["+(x+1)+"][nab]");
			$("#tableNab tbody tr:eq("+x+") td:eq(5) [type=text]").attr("name","Treksnab["+(x+1)+"][mkbd_dt]");
			$("#tableNab tbody tr:eq("+x+") td:eq(5) [type=hidden]").attr("name","Treksnab["+(x+1)+"][old_mkbd_dt]");
			$("#tableNab tbody tr:eq("+x+") td:eq(3) [type=text]").attr("id","Treksnab_"+(x+1)+"_nab_unit");
			$("#tableNab tbody tr:eq("+x+") td:eq(4) [type=text]").attr("id","Treksnab_"+(x+1)+"_nab");
			$("#tableNab tbody tr:eq("+x+") td:eq(3) [type=text]").attr("onLoad","formatNumber("+ (x+1)+ ")");
			$("#tableNab tbody tr:eq("+x+") td:eq(4) [type=text]").attr("onChange","formatNumber("+ (x+1)+ ")");
		
		}
		
		//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0;x<rowCount;x++)
   		{
   			if($("[name='Treksnab["+(x+1)+"][cancel_flg]']").val())
				$("#tableNab tbody tr:eq("+x+") td:eq(6) a:eq(0)").attr('onClick',"cancel(this,'"+$("[name='Treksnab["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
   			else
   			{
   				$("#tableNab tbody tr:eq("+x+") td:eq(6) a:eq(0)").attr('onClick',"deleteRow(this)");
   			}
   		}
   	}

	
	function addCommas(obj)
	{
		$(obj).val(setting.func.number.addCommas(setting.func.number.removeCommas($(obj).val())));
	}
	
	$(window).resize(function() {
		var body = $("#tableNab").find('tbody');
		/*
		if(body.get(0).scrollHeight > body.height()) //check whether  tbody has a scrollbar
		{
			$('thead').css('width', '100%').css('width', '-=17px');	
		}
		else
		{
			$('thead').css('width', '100%');	
		}
		*/
		alignColumn();
	})
	$(window).trigger('resize');
	
	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableNab").find('thead');
		var firstRow = $("#tableNab").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',(header.find('th:eq(6)').width())-17 + 'px');
		
	}
	function deleteRow(obj)
	{
		$(obj).closest('tr').remove();
		rowCount--;
		reassignId();
	}
	
	function cancel(obj, cancel_flg, seq)
	{
		if(authorizedCancel)
		{
			$(obj).closest('tr').attr('class',cancel_flg=='N'?'markCancel':''); 
			$('[name="Treksnab['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
			$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
			
			$("#tableNab tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
			
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
	function formatNumber(rnum){
		
				$('#Treksnab_'+rnum+'_nab_unit').number( true, 6 );
				$('#Treksnab_'+rnum+'_nab').number( true, 2 );
				
	}	
	

</script>
