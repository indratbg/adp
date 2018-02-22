<?php
$this->breadcrumbs=array(
	'Deposito Entry'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Deposit Entry', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tdeposit/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 

<?php 
	$bankCdList = Ipbank::model()->findAll(array('condition'=>"approved_stat='A'",'order'=>'bank_cd'));
	$bankTypeList = Parameter::model()->findAll(array('select'=>'prm_cd_2, prm_desc','condition'=>"prm_cd_1 = 'BANKTY' AND approved_stat = 'A'",'order'=>'prm_cd_2'));
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tdeposit-form',
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

<table id='tableDeposit' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="80px">Ref No.</th>
			<th width="150px">Bank</th>
			<th width="90px">Branch</th>
			<th width="100px">Type</th>
			<th width="80px">From</th>
			<th width="80px">To</th>
			<th width="100px">Amount</th>
			
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
				<?php echo $form->textField($row,'ref_num',array('class'=>'span','name'=>'Tdeposit['.$x.'][ref_num]','onChange'=>"strToUpper(this)")); ?>
				<input type="hidden" id="oldSeqno<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $oldModel[$x-1]->seqno ?>"/>
			</td>
			<td><?php echo $form->dropDownList($row,'bank_cd',CHtml::listData($bankCdList, 'bank_cd', 'DropDownName'),array('class'=>'span','name'=>'Tdeposit['.$x.'][bank_cd]')); ?></td>
			<td><?php echo $form->textField($row,'bank_branch',array('class'=>'span','name'=>'Tdeposit['.$x.'][bank_branch]')); ?></td>
			<td><?php echo $form->dropDownList($row,'bank_type',CHtml::listData($bankTypeList, 'prm_cd_2', 'prm_desc'),array('class'=>'span','name'=>'Tdeposit['.$x.'][bank_type]')); ?></td>
			<td><?php echo $form->textField($row,'from_dt',array('class'=>'span tdate','name'=>'Tdeposit['.$x.'][from_dt]')); ?></td>
			<td><?php echo $form->textField($row,'to_dt',array('class'=>'span tdate','name'=>'Tdeposit['.$x.'][to_dt]')); ?></td>
			<td><?php echo $form->textField($row,'amount',array('class'=>'span tnumber','maxlength'=>21,'name'=>'Tdeposit['.$x.'][amount]','style'=>'text-align:right')); ?></td>
			
			<td>
				<a href="#" title="<?php if(!$row->isNewRecord) echo 'save';else echo 'create'?>" onclick="<?php if(!$row->isNewRecord) echo 'update('.$x.')';else echo 'create()'?>"><i class="icon-ok"></i></a>
				<a 
					href="<?php if(!$row->isNewRecord)echo Yii::app()->createUrl("/glaccounting/Tdeposit/AjxPopDelete", 
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
			$("#tableDeposit tbody tr:eq("+x+") td:eq(4) input").datepicker({format : "dd/mm/yyyy"});
			$("#tableDeposit tbody tr:eq("+x+") td:eq(5) input").datepicker({format : "dd/mm/yyyy"});
		}
	}
	
	function addRow()
	{
		if(!insert)
		{
			$("#tableDeposit").find('tbody')
    		.prepend($('<tr>')
    			.attr('id','row0')
    			.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tdeposit[0][ref_num]')
               		 	.attr('type','text')
               		 	.attr('onChange','strToUpper(this)')
               		)
               	).append($('<td>')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Tdeposit[0][bank_cd]')
               		 	<?php
               		 		foreach($bankCdList as $row){
               		 	?>
           		 		.append($('<option>')
           		 			.attr('value','<?php echo $row->bank_cd ?>')
           		 			.html('<?php echo $row->DropDownName ?>')
           		 		)
               		 	<?php } ?>
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tdeposit[0][bank_branch]')
               		 	.attr('type','text')
               		)
               	).append($('<td>')
               		 .append($('<select>')
               		 	.attr('class','span')
               		 	.attr('name','Tdeposit[0][bank_type]')
               		 	<?php
               		 		foreach($bankTypeList as $row){
               		 	?>
           		 		.append($('<option>')
           		 			.attr('value','<?php echo $row->prm_cd_2 ?>')
           		 			.html('<?php echo $row->prm_desc ?>')
           		 		)
               		 	<?php } ?>
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tdeposit[0][from_dt]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
				).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tdeposit[0][to_dt]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span tnumber')
               		 	.attr('name','Tdeposit[0][amount]')
               		 	.attr('type','text')
               		 	.attr('onChange','addCommas(this)')
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
		$("#Tdeposit-form").submit();
	}
	
	function update(rowSeq)
	{
		$('#scenario').val('update');
		$("#rowSeq").val(rowSeq);
		$("#oldPk").val($("#oldSeqno"+rowSeq).val());
		$("#Tdeposit-form").submit();
	}
	
	function cancel(e,obj)
	{
		e.preventDefault();
		showPopupModal("Cancel Reason",obj.href);
	}
		$('#Tdeposit-form').bind("keyup keypress", function(e) {
		
  	var code = e.keyCode || e.which; 
  	if (code  == 13) {               
    e.preventDefault();
    return false;
  	}
		});
</script>
