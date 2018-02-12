<style>
	.markCancel
	{
		background-color:#BB0000;
	}
</style>

<?php
$this->breadcrumbs=array(
	'Corporate Guarantee Entry'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Corporate Guarantee Entry', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tcorpguarantee/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tcorpguarantee-form',
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
<input type="hidden" id="oldPk1" name="oldPk1"/>
<table id='tableCorp' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="65px">Dari Tgl</th>
			<th width="65 px">Sampai Tgl</th>
			<th width="100px">Yang Dijamin</th>
			<th width="85px">Afiliasi/Tidak</th>
			<th width="80px">Rincian Jaminan</th>
			<th width="80px">Jangka Waktu</th>
			<th width="100px">Nilai</th>
			
			<th width="40px">
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
				<?php echo $form->textField($row,'contract_dt',array('class'=>'span tdate','name'=>'Tcorpguarantee['.$x.'][contract_dt]')); ?>
				<input type="hidden" id="oldContractDt<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $model[$x-1]->old_contract_dt ?>"/>
			</td>
			<td><?php echo $form->textField($row,'end_contract_dt',array('class'=>'span tdate','name'=>'Tcorpguarantee['.$x.'][end_contract_dt]')); ?></td>
			<td>
				<?php echo $form->textField($row,'guaranteed',array('class'=>'span tdate','name'=>'Tcorpguarantee['.$x.'][guaranteed]')); ?>
				<input type="hidden" id="oldGuaranteed<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $model[$x-1]->old_guaranteed ?>"/>
			</td>
			<td><?php echo $form->dropDownList($row,'afiliasi',array('Afiliasi'=>'Afiliasi','Tidak Terafiliasi'=>'Tidak Terafiliasi'),array('class'=>'span','name'=>'Tcorpguarantee['.$x.'][afiliasi]')); ?></td>
			<td><?php echo $form->textField($row,'rincian',array('class'=>'span','name'=>'Tcorpguarantee['.$x.'][rincian]')); ?></td>
			<td><?php echo $form->textField($row,'jangka',array('class'=>'span','name'=>'Tcorpguarantee['.$x.'][jangka]')); ?></td>
			<td><?php echo $form->textField($row,'nilai',array('class'=>'span','value'=>number_format((float) $row->nilai,'0','.',','),'name'=>'Tcorpguarantee['.$x.'][nilai]','style'=>'text-align:right')); ?></td>
			<td>
				<a href="#" title="<?php if(!$row->isNewRecord) echo 'save';else echo 'create'?>" onclick="<?php if(!$row->isNewRecord) echo 'update('.$x.')';else echo 'create()'?>"><i class="icon-ok"></i></a>
				<a 
					href="<?php if(!$row->isNewRecord)echo Yii::app()->createUrl("/glaccounting/tcorpguarantee/ajxpopdelete", 
								array('contract_dt'=>$model[$x-1]->old_contract_dt, 'guaranteed'=>$model[$x-1]->old_guaranteed ));else echo '#' ?>" 
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
			$("#tableCorp tbody tr:eq("+x+") td:eq(0) input").datepicker({format : "dd/mm/yyyy"});
			$("#tableCorp tbody tr:eq("+x+") td:eq(1) input").datepicker({format : "dd/mm/yyyy"});
		}
	}
	
	function addRow()
	{
		if(!insert)
		{
			$("#tableCorp").find('tbody')
    		.prepend($('<tr>')
    			.attr('id','row0')
    			.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tcorpguarantee[0][contract_dt]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tcorpguarantee[0][end_contract_dt]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tcorpguarantee[0][guaranteed]')
               		 	.attr('type','text')
               		 	
               		)
               	).append($('<td>')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Tcorpguarantee[0][afiliasi]')
               		 	.append($('<option>')
               		 	.attr('value','Afiliasi')
               		 

               		 	.html('Afiliasi'))
               		 		.append($('<option>')
               		 	.attr('value','Tidak Terafiliasi')
               		 

               		 	.html('Tidak Terafiliasi'))
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tcorpguarantee[0][rincian]')
               		 	.attr('type','text')
               		 	
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tcorpguarantee[0][jangka]')
               		 	.attr('type','text')
               		 	
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tcorpguarantee[0][nilai]')
               		 	.attr('type','text')
               		 	
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
	

	function create()
	{
		$('#scenario').val('create');
		$("#rowSeq").val(0);
		$("#Tcorpguarantee-form").submit();
	}
	
	function update(rowSeq)
	{
		$('#scenario').val('update');
		$("#rowSeq").val(rowSeq);
		$("#oldPk").val($("#oldContractDt"+rowSeq).val());
		$("#oldPk1").val($("#oldGuaranteed"+rowSeq).val());
		$("#Tcorpguarantee-form").submit();
	}
	
	function cancel(e,obj)
	{	$(obj).closest('tr').attr('class','markCancel'); 
		e.preventDefault();
		showPopupModal("Cancel Reason",obj.href);
	}
	$('#Tcorpguaratee-form').bind("keyup keypress", function(e) {
		
  	var code = e.keyCode || e.which; 
  	if (code  == 13) {               
    e.preventDefault();
    return false;
  	}
		});
</script>
