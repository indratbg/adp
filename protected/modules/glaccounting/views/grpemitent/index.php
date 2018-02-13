<?php
$this->breadcrumbs=array(
	'Group Emitent Entry'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Group Emitent', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/grpemitent/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Grpemitent-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php 
	foreach($model as $row)
		echo $form->errorSummary(array($row)); 
?>

<br/>

<input type="hidden" id="scenario" name="scenario"/>
<input type="hidden" id="rowSeq" name="rowSeq"/>
<input type="hidden" id="oldPk" name="oldPk"/>

<table id='tableEmi' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="21%">Effective Date</th>
			<th width="21%">Stock Code</th>
			<th width="21%">Group Emitent</th>
			<th width="32%">Group Type</th>
			
			
			<th>
				<a href="#" title="add" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($model as $row){
			if($row->isNewRecord)$x = 0; 
	?>
		<tr id="row<?php echo $x ?>">
			<td>
				<?php echo $form->textField($row,'eff_dt',array('class'=>'span','name'=>'Grpemitent['.$x.'][eff_dt]','onChange'=>"strToUpper(this)")); ?>
				<input type="hidden" id="oldSeqno<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $oldModel[$x-1]->seqno ?>"/>
			</td>
			<td><?php echo $form->textField($row,'stk_cd',array('class'=>'span','name'=>'Grpemitent['.$x.'][stk_cd]')); ?></td>
			<td><?php echo $form->textField($row,'grp_emi',array('class'=>'span','name'=>'Grpemitent['.$x.'][grp_emi]')); ?></td>
			<td><?php echo $form->dropDownList($row,'grp_type',array('B'=>'1 Emitent bbrp jenis efek','C'=>'1 Grup bbrp emitent'),array('class'=>'span','name'=>'Grpemitent['.$x.'][grp_type]')); ?></td>
			
			
			<td>
				<a href="#" title="<?php if(!$row->isNewRecord) echo 'save';else echo 'create'?>" onclick="<?php if(!$row->isNewRecord) echo 'update('.$x.')';else echo 'create()'?>"><i class="icon-ok"></i></a>
				<a 
					href="<?php if(!$row->isNewRecord)echo Yii::app()->createUrl("/glaccounting/Grpemitent/AjxPopDelete", 
								array('seqno'=>$oldModel[$x-1]->seqno));else echo '#' ?>" 
					title="<?php if(!$row->isNewRecord) echo 'cancel';else echo 'delete'?>" 
					onclick="<?php if(!$row->isNewRecord) echo 'cancel(event,this)';else echo 'deleteRow()'?>">
					<i class="icon-remove"></i>
				</a>
			</td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>

<?php 
	if($model)
	{
?>

<?php echo $form->datePickerRow($model[0],'cre_dt',array('label'=>false,'disabled'=>'disabled','style'=>'display:none','options'=>array('format' => 'dd/mm/yyyy'))); ?>

<?php
	} 
?>

<?php $this->endWidget(); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>

<script>
	var rowCount = <?php echo count($model) ?>;
	
	var insert = false;
	<?php if($insert){ ?>
		insert = true;
	<?php } ?>

	init();
	
	function init()
	{
		var x;
		
		for(x=0;x<rowCount;x++)
		{
			$("#tableEmi tbody tr:eq("+x+") td:eq(0) input").datepicker({format : "dd/mm/yyyy"});
			
		}
	}
	
	function addRow()
	{
		if(!insert)
		{
			$("#tableEmi").find('tbody')
    		.prepend($('<tr>')
    			.attr('id','row0')
    			.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Grpemitent[0][eff_dt]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Grpemitent[0][stk_cd]')
               		 	.attr('type','text')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Grpemitent[0][grp_emi]')
               		 	.attr('type','text')
               		 	
               		)
				).append($('<td>')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Grpemitent[0][grp_type]')
               		 	.append($('<option>')
               		 	.attr('value','B')
               		 	.html('1 Emitent bbrp jenis efek')
               			 )
               		 	
               		 	.append($('<option>')
               		 	.attr('value','C')
               		 	.html('1 Grup bbrp emitent')
               		 	
               		 	)
               		 	
               		)
               	).append($('<td>')
               		 .append($('<a>')
               		 	.attr('href','#')
               		 	.attr('onClick','create()')
               		 	.attr('title','create')
               		 	.append($('<i>')
               		 		.attr('class','icon-ok')
               		 	)
               		).append('&nbsp;')
               		 .append($('<a>')
           		 		.attr('href','#')
           		 		.attr('onClick','deleteRow()')
           		 		.attr('title','delete')
           		 		.append($('<i>')
           		 			.attr('class','icon-remove')
           		 		)
               		)
               	)  	
    		);
    		
			insert = true;
		}
	}
	
	function deleteRow()
	{
		$("#row0").remove();
		insert = false;
	}
	
	function addCommas(obj)
	{
		$(obj).val(setting.func.number.addCommas(setting.func.number.removeCommas($(obj).val())));
	}
	
	function strToUpper(obj)
	{
		$(obj).val($(obj).val().toUpperCase());
	}
	
	function create()
	{
		$('#scenario').val('create');
		$("#rowSeq").val(0);
		$("#Grpemitent-form").submit();
	}
	
	function update(rowSeq)
	{
		$('#scenario').val('update');
		$("#rowSeq").val(rowSeq);
		$("#oldPk").val($("#oldSeqno"+rowSeq).val());
		$("#Grpemitent-form").submit();
	}
	
	function cancel(e,obj)
	{
		e.preventDefault();
		showPopupModal("Cancel Reason",obj.href);
	}
	
	/*
	$('#Grpemitent-form').bind("keyup keypress", function(e) {
	  	var code = e.keyCode || e.which; 
	  	if (code  == 13) {
	    e.preventDefault();
	    return false;
	  	}
	});
	*/
</script>
