<style>
	#Mapmkbd-form input[type=radio]
	{
		margin-left: 15px;
		margin-right: 5px;
		margin-bottom: 7px;
	}
	#tableMap
	{
		background-color:#C3D9FF;
	}
	#tableMap thead, #tableMap tbody
	{
		display:block;
	}
	#tableMap tbody
	{
		height:300px;
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
	'Map GL Account Code to MKBD'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Map GL Account Code to MKBD', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/mapmkbd/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>



<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Mapmkbd-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	foreach($model as $row)
		echo $form->errorSummary(array($row)); 
	echo $form->errorSummary($modelReport);
?>
<input type="hidden" name="scenario" id="scenario"/>
<br/>
<div class="row-fluid">
	<div class="span1">
		<label><strong>VD</strong></label>
	</div>
	<div class="span2">
		<select id="source" name="source" class="span">
				<?php for($i=51;$i<=59;$i++){?>
				
				<option value="<?php echo "VD$i";?>" <?php if( "VD$i" == $source ) echo 'selected' ?>  > <?php echo "VD$i";?></option>
				
				<?php }?>
				
			</select>	
	</div>
	<div class="span2">
		<?php echo $form->textField($modelDummy,'ver_bgn_dt',array('class'=>'span8 tdate'));?>
	</div>
	<div class="span1">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
								'id'=>'btnFilter',
								'buttonType'=>'submit',
								'type'=>'primary',
								'htmlOptions'=>array('style'=>'margin-left:0px;'),
								'label'=> 'Retrieve',
							)); ?>
	</div>
	<div class="span1">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
								'id'=>'btnPrint',
								'buttonType'=>'submit',
								'type'=>'primary',
								'htmlOptions'=>array('style'=>'margin-left:0px;'),
								'label'=> 'Print',
							)); ?>
	</div>
	<div class="span3">
		<a href="<?php echo $url.'&&__dpi=96&__format=xls&__pageoverflow=0&__overwrite=false';?>" id="btnExport"  class="btn btn-primary">Export to Excel</a>
	</div>
</div>

<br/>
<?php for($i=51; $i<= 59; $i++){
		
	$source_list["VD$i"] ="VD$i";
	
}
?>

<iframe id="reporMapMKBD" src="<?php echo $url.'&&__dpi=96&__format=pdf&__pageoverflow=0&__overwrite=false';?>" width="100%" height="500px"></iframe>
<input type="hidden" id="rowCount" name="rowCount"/>

<br/>
<table id='tableMap' class='table-bordered table-condensed' style="margin-top:-30px;width:75%;">
	<thead>
		<tr>
			<th width="30px"></th>
			<th width="150px">Version Date From</th>
			<th width="155px">To</th>
			<th width="155px">GL A</th>
			<th width="160px">MKBD Code</th>
			<th width="70px">VD</th>
			
			<th width="70px">
				<a title="add" style="cursor: pointer;" onclick="addTopRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
		</tr>
	</thead>	
	<tbody>
	<?php $x = 1;
		foreach($model as $row){
	?>
		<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
			<td style="text-align: center">
				<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Mapmkbd['.$x.'][save_flg]','onChange'=>'rowControl(this,true)')); ?>
				<?php if($row->old_ver_bgn_dt): ?>
					<input type="hidden" name="Mapmkbd[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php endif; ?>
			</td>
			<td>
				<?php echo $form->textField($row,'ver_bgn_dt',array('class'=>'span tdate','name'=>'Mapmkbd['.$x.'][ver_bgn_dt]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Mapmkbd[<?php echo $x ?>][old_ver_bgn_dt]" value="<?php echo $row->old_ver_bgn_dt ?>" />
			</td>
			<td>
				<?php echo $form->textField($row,'ver_end_dt',array('class'=>'span tdate','name'=>'Mapmkbd['.$x.'][ver_end_dt]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				
			</td>
			<td>
				<?php echo $form->textField($row,'gl_a',array('class'=>'span','name'=>'Mapmkbd['.$x.'][gl_a]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Mapmkbd[<?php echo $x ?>][old_gl_a]" value="<?php echo $row->old_gl_a ?>" />
			</td>
			<td>
				<?php echo $form->textField($row,'mkbd_cd',array('class'=>'span','name'=>'Mapmkbd['.$x.'][mkbd_cd]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Mapmkbd[<?php echo $x ?>][old_mkbd_cd]" value="<?php echo $row->old_mkbd_cd ?>" />
			</td>
			<td>
				<?php echo $form->dropDownList($row,'source',$source_list,array('class'=>'span','name'=>'Mapmkbd['.$x.'][source]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Mapmkbd[<?php echo $x ?>][old_source]" value="<?php echo $row->old_source ?>" />
			</td>
			
			<td>
				<a title="add" style="cursor: pointer;" onclick="addRow(this)"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
				<a style="cursor : pointer;"
					title="<?php if($row->old_ver_bgn_dt) echo 'cancel';else echo 'delete'?>" 
					onclick="<?php if($row->old_ver_bgn_dt) echo 'cancel(this,\''.$row->cancel_flg.'\','.$x.')';else echo 'deleteRow(this)'?>">
					<img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png">
				</a>
			</td>
		</tr>
	<?php $x++;} ?>
	</tbody>	
</table>
<br id="temp"/>

<?php if($model): ?>
	<?php echo $form->label($model[0], 'Cancel Reason', array('class'=>'control-label cancel_reason'))?>
	<textarea id="cancel_reason" class="span5 cancel_reason" name="cancel_reason" maxlength="200" rows="4" disabled><?php echo $cancel_reason ?></textarea>
<?php endif; ?>

<?php echo $form->datePickerRow($modelDummy,'cre_dt',array('label'=>false,'disabled'=>'disabled','style'=>'display:none','options'=>array('format' => 'dd/mm/yyyy'))); ?>

<br id="temp"/><br id="temp"/>

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
	var url = '<?php echo $url;?>';
	$('#reporMapMKBD').hide();
	$('#btnExport').hide();
	if(url !=''){
		$('#btnExport').show();
		$('#reporMapMKBD').show();
		$('#tableMap').hide();
		$('#btnSubmit').hide();
	}

	$('#btnFilter').click(function()
	{
		$('#scenario').val('source');
	});
	$('#btnPrint').click(function()
	{
		$('#scenario').val('print');
	})
	
	$('#btnSubmit').click(function()
	{
		$('#scenario').val('save');
		$('#rowCount').val(rowCount);
	})
	
	$('.tdate').datepicker({format : "dd/mm/yyyy"});
	
	// $(window).resize(function() {
		// $('thead').css('width', '100%').css('width', '-=17px');
	// })
	// $(window).trigger('resize');
	
	
	for(x=0;x<rowCount;x++)
		{
			$("#tableMap tbody tr:eq("+x+") td:eq(1) input").datepicker({format : "dd/mm/yyyy"});
			$("#tableMap tbody tr:eq("+x+") td:eq(2) input").datepicker({format : "dd/mm/yyyy"});
		}
		
	cancel_reason();
	
		
	function rowControl(obj, readonly)
	{
		var x = $(obj).closest('tr').prevAll().length;
		
		$("#tableMap tbody tr:eq("+x+")").attr("id","row"+(x+1));	
		$("#tableMap tbody tr:eq("+x+") td:eq(1) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableMap tbody tr:eq("+x+") td:eq(2) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableMap tbody tr:eq("+x+") td:eq(3) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableMap tbody tr:eq("+x+") td:eq(4) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableMap tbody tr:eq("+x+") td:eq(5) select").attr("readonly",!$(obj).is(':checked')?true:false);
		
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(6) a:eq(1)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}
	
	function addTopRow()
	{
		$("#tableMap").find('tbody')
    		.prepend($('<tr>')
			.attr('id','row1')
			.append($('<td>')
				.append($('<input>')
					.attr('name','Mapmkbd[1][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
				)
				.css('text-align','center')
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Mapmkbd[1][ver_bgn_dt]')
					.attr('type','text')
					.datepicker({format : "dd/mm/yyyy"})
					//.css('width','150px')
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Mapmkbd[1][ver_end_dt]')
					.attr('type','text')
					.datepicker({format : "dd/mm/yyyy"})
					//.css('width','155px')
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Mapmkbd[1][gl_a]')
					.attr('type','text')
				//	.css('width','155px')
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Mapmkbd[1][mkbd_cd]')
					.attr('type','text')
					//.css('width','160px')
           		)
           	).append($('<td>')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Mapmkbd[1][source]')
               		 	<?php $x=51; foreach($source_list as $row=>$value){?>
               			.append($('<option>')
               			.attr('value','<?php echo $row ?>')
               			.html('<?php echo $value ?>')
               			)
               			<?php $x++;} ?>
               			.val($('#source').val())
               		)
				).append($('<td>')
           		 .append($('<a>')
           		 	.attr('onClick','addRow(this)')
           		 	.attr('title','add')
           		 	.append($('<img>')
           		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/add.png')
           		 	)
           		).append('&nbsp;')
           		 .append($('<a>')
       		 		.attr('onClick','deleteRow(this)')
       		 		.attr('title','delete')
       		 		.append($('<img>')
       		 			.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
       		 			
       		 		)
           		)
           		.css('cursor','pointer')
           	)  	
		);
		rowCount++;
		reassignId();
	}

	function addRow(obj)
	{
		($('<tr>').insertAfter($(obj).closest('tr'))
			.attr('id','row0')
			.append($('<td>')
				.append($('<input>')
					.attr('name','Mapmkbd[0][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
				)
				.css('text-align','center')
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Mapmkbd[1][ver_bgn_dt]')
					.attr('type','text')
					.datepicker({format : "dd/mm/yyyy"})
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Mapmkbd[1][ver_end_dt]')
					.attr('type','text')
					.datepicker({format : "dd/mm/yyyy"})
           		)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Mapmkbd[1][gl_a]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Mapmkbd[1][mkbd_cd]')
					.attr('type','text')
           		)
           	).append($('<td>')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Mapmkbd[1][source]')
               		 	<?php $x=51; foreach($source_list as $row=>$value){?>
               			.append($('<option>')
               			.attr('value','<?php echo $row ?>')
               			.html('<?php echo $value ?>')
               			)
               			<?php $x++;} ?>
               			.val($('#source').val())
               		)
				).append($('<td>')
           		 .append($('<a>')
           		 	.attr('onClick','addRow(this)')
           		 	.attr('title','add')
           		 	.append($('<img>')
           		 		.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/add.png')
           		 	)
           		).append('&nbsp;')
           		 .append($('<a>')
       		 		.attr('onClick','deleteRow(this)')
       		 		.attr('title','delete')
       		 		.append($('<img>')
       		 			.attr('src','<?php echo Yii::app()->request->baseUrl ?>/images/delete.png')
       		 			
       		 		)
           		)
           		.css('cursor','pointer')
           	)  	
		);
		rowCount++;
		reassignId();
   	}
   	
   	function reassignId()
   	{
   		//var index = $(obj).closest('tr').prevAll().length + 1;
   		var obj = $("#tableMap tbody");
   		
   		for(x=0;x<rowCount;x++)
   		{
			obj.find("tr:eq("+x+")").attr("id","row"+(x+1));	
			obj.find("tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Mapmkbd["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Mapmkbd["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(1)").attr("name","Mapmkbd["+(x+1)+"][cancel_flg]");
			obj.find("tr:eq("+x+") td:eq(1) [type=text]").attr("name","Mapmkbd["+(x+1)+"][ver_bgn_dt]");
			obj.find("tr:eq("+x+") td:eq(1) [type=hidden]").attr("name","Mapmkbd["+(x+1)+"][old_ver_bgn_dt]");
			obj.find("tr:eq("+x+") td:eq(2) [type=text]").attr("name","Mapmkbd["+(x+1)+"][ver_end_dt]");
			obj.find("tr:eq("+x+") td:eq(3) [type=text]").attr("name","Mapmkbd["+(x+1)+"][gl_a]");
			obj.find("tr:eq("+x+") td:eq(3) [type=hidden]").attr("name","Mapmkbd["+(x+1)+"][old_gl_a]");
			obj.find("tr:eq("+x+") td:eq(4) [type=text]").attr("name","Mapmkbd["+(x+1)+"][mkbd_cd]");
			obj.find("tr:eq("+x+") td:eq(4) [type=hidden]").attr("name","Mapmkbd["+(x+1)+"][old_mkbd_cd]");
			obj.find("tr:eq("+x+") td:eq(5) select").attr("name","Mapmkbd["+(x+1)+"][source]");
			obj.find("tr:eq("+x+") td:eq(5) [type=hidden]").attr("name","Mapmkbd["+(x+1)+"][old_source]");
		}
		
		//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0;x<rowCount;x++)
   		{
   			if($("[name='Mapmkbd["+(x+1)+"][cancel_flg]']").val())
				obj.find("tr:eq("+x+") td:eq(6) a:eq(1)").attr('onClick',"cancel(this,'"+$("[name='Mapmkbd["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
   			else
   			{
   				obj.find("tr:eq("+x+") td:eq(6) a:eq(1)").attr('onClick',"deleteRow(this)");
   			}
   		}
   	}
	
	function deleteRow(obj)
	{
		$(obj).closest('tr').remove();
		rowCount--;
		reassignId();
	}
	
	function cancel(obj, cancel_flg, seq)
	{
		
			$(obj).closest('tr').attr('class',cancel_flg=='N'?'markCancel':''); 
			$('[name="Mapmkbd['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
			$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
			
			$("#tableMap tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
			
			cancel_reason();
		
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
	
	$(window).resize(function()
    {
        alignColumn();
    })
    $(window).trigger('resize');

    function alignColumn()//align columns in thead and tbody
    {
        var header = $("#tableMap").find('tbody tr:eq(0)');
        var firstRow = $("#tableMap").find('thead tr');
        header.find('td:eq(0)').css('width', firstRow.find('th:eq(0)').width() + 'px');
        header.find('td:eq(1)').css('width', firstRow.find('th:eq(1)').width() + 'px');
        header.find('td:eq(2)').css('width', firstRow.find('th:eq(2)').width() + 'px');
        header.find('td:eq(3)').css('width', firstRow.find('th:eq(3)').width() + 'px');
        header.find('td:eq(4)').css('width', firstRow.find('th:eq(4)').width() + 'px');
        header.find('td:eq(5)').css('width', firstRow.find('th:eq(5)').width() + 'px');
        //header.find('td:eq(6)').css('width', firstRow.find('th:eq(6)').width() + 'px');
    }
    
    
</script>

