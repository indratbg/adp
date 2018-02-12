<style>
	.markCancel
	{
		background-color:#BB0000;
	}
</style>


<?php
$this->breadcrumbs=array(
	'Komitmen Belanja Modal Entry'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Komitmen Belanja Modal Entry', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tbelanjamodal/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tbelanjamodal-form',
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

<table id='tableBelanja' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="18%">Tanggal Komitmen</th>
			<th width="21%">Rincian</th>
			<th width="19%">Nilai Komitmen</th>
			<th width="18%">Tanggal Realisasi</th>
			<th width="19%">Sudah Realisasi</th>
			
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
				<?php echo $form->textField($row,'tgl_komitmen',array('class'=>'span tdate','name'=>'Tbelanjamodal['.$x.'][tgl_komitmen]')); ?>
				<input type="hidden" id="oldSeqno<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $oldModel[$x-1]->seqno ?>"/>
			</td>
			<td><?php echo $form->textField($row,'rincian',array('class'=>'span','name'=>'Tbelanjamodal['.$x.'][rincian]')); ?></td>
			<td><?php echo $form->textField($row,'nilai',array('class'=>'span','name'=>'Tbelanjamodal['.$x.'][nilai]','value'=>number_format((float) $row->nilai,0,'.',','),'style'=>'text-align:right;')); ?></td>
			<td><?php echo $form->textField($row,'tgl_realisasi',array('class'=>'span tdate','name'=>'Tbelanjamodal['.$x.'][tgl_realisasi]')); ?></td>
			
			
			<td><?php echo $form->textField($row,'sudah_real',array('class'=>'span','name'=>'Tbelanjamodal['.$x.'][sudah_real]','value'=>number_format((float) $row->sudah_real,0,'.',','),'style'=>'text-align:right;')); ?></td>

			<td>
				<a href="#" title="<?php if(!$row->isNewRecord) echo 'save';else echo 'create'?>" onclick="<?php if(!$row->isNewRecord) echo 'update('.$x.')';else echo 'create()'?>"><i class="icon-ok"></i></a>
				<a 
					href="<?php if(!$row->isNewRecord)echo Yii::app()->createUrl("/glaccounting/Tbelanjamodal/AjxPopDelete", 
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
			$("#tableBelanja tbody tr:eq("+x+") td:eq(0) input").datepicker({format : "dd/mm/yyyy"});
			$("#tableBelanja tbody tr:eq("+x+") td:eq(3) input").datepicker({format : "dd/mm/yyyy"});
		}
	}
	
	function addRow()
	{
		if(!insert)
		{
			$("#tableBelanja").find('tbody')
    		.prepend($('<tr>')
    			.attr('id','row0')
    			.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tbelanjamodal[0][tgl_komitmen]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tbelanjamodal[0][rincian]')
               		 	.attr('type','text')
               		 	
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span tnumber')
               		 	.attr('name','Tbelanjamodal[0][nilai]')
               		 	.attr('type','text')
               		 	.css('text-align','right')
               		 	
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tbelanjamodal[0][tgl_realisasi]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tbelanjamodal[0][sudah_real]')
               		 	.attr('type','text')
               		 	.attr('value',0)
               		 	.css('text-align','right')
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
		$("#Tbelanjamodal-form").submit();
	}
	
	function update(rowSeq)
	{
		$('#scenario').val('update');
		$("#rowSeq").val(rowSeq);
		$("#oldPk").val($("#oldSeqno"+rowSeq).val());
		$("#Tbelanjamodal-form").submit();
	}
	
	function cancel(e,obj)
	{ 
		$(obj).closest('tr').attr('class','markCancel'); 
		e.preventDefault();
		showPopupModal("Cancel Reason",obj.href);
	}
	/*
	$('#Tbelanjamodal-form').bind("keyup keypress", function(e) {
		
	  	var code = e.keyCode || e.which; 
	  	if (code  == 13) {               
	    e.preventDefault();
	    return false;
	  	}
	});
	*/
</script>
