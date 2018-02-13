<style>
	#tableRate {
		background-color: #C3D9FF;
	}
	#tableRate thead, #tableRate tbody {
		display: block;
	}
	#tableRate tbody {
		max-height: 300px;
		overflow: auto;
		background-color: #FFFFFF;
	}
</style>
<?php
$this->breadcrumbs=array(
	'Foreign Currency- Exchange Rate Entry'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Foreign Currency - Exchange Rate', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/texchrate/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Texchrate-form',
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
<table id='tableRate' class='table-bordered table-condensed' style="width: 60%">
	<thead>
		<tr>
			<th width="10%">Date</th>
			<th width="10%">Currency</th>
			<th width="15%">Rate</th>
			<th width="5%">
				<a style="cursor: pointer;" title="add" onclick="addRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
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
				<?php echo $form->textField($row,'exch_dt',array('class'=>'span tdate','name'=>'Texchrate['.$x.'][exch_dt]')); ?>
				<input type="hidden" id="old_exch_dt<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $model[$x-1]->old_exch_dt ?>"/>
			</td>
			<td><?php echo $form->textField($row,'curr_cd',array('class'=>'span','onchange'=>'currency('.$x.')','id'=>'Curr_cd_'.$x.'','name'=>'Texchrate['.$x.'][curr_cd]')); ?>
				<input type="hidden" id="old_curr_cd<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $model[$x-1]->old_curr_cd ?>"/>
			</td>
			
			<td>
				<?php echo $form->textField($row,'rate',array('class'=>'span','value'=>number_format((float) $row->rate,0,'.',','),'style'=>'text-align:right;','name'=>'Texchrate['.$x.'][rate]')); ?>
				
			</td>
			<td>
				<a title="<?php if(!$row->isNewRecord) echo 'save';else echo 'create'?>" onclick="<?php if(!$row->isNewRecord) echo 'update('.$x.')';else echo 'create()'?>"><i class="icon-ok"></i></a>
				<a href="<?php if(!$row->isNewRecord)echo Yii::app()->createUrl("/glaccounting/Texchrate/ajxpopdelete", 
								array('exch_dt'=>$model[$x-1]->old_exch_dt,'curr_cd'=>$model[$x-1]->old_curr_cd));else echo '#' ?>" 
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

	$('.tdate').datepicker({'format':'dd/mm/yyyy'});
	init();
	
	function init()
	{
		var x;
		
		for(x=0;x<rowCount;x++)
		{
			$("#tableRate tbody tr:eq("+x+") td:eq(0) input").datepicker({format : "dd/mm/yyyy"});
			
		}
	}
	
	function addRow()
	{
		if(!insert)
		{
			$("#tableRate").find('tbody')
    		.prepend($('<tr>')
    			.attr('id','row0')
    			.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span tdate')
               		 	.attr('name','Texchrate[0][exch_dt]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Texchrate[0][curr_cd]')
               		 	.attr('type','text')
               		 	.attr('id','Curr_cd_0')
               		 	.attr('onchange','currency(0)')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Texchrate[0][rate]')
               		 	.attr('type','text')
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
	

	function create()
	{
		$('#scenario').val('create');
		$("#rowSeq").val(0);
		$("#Texchrate-form").submit();
	}
	
	function update(rowSeq)
	{
		$('#scenario').val('update');
		$("#rowSeq").val(rowSeq);
		$("#oldPk").val($("#oldExchDate"+rowSeq).val());
		$("#oldPk1").val($("#oldCurrCd"+rowSeq).val());
		$("#Texchrate-form").submit();
	}
	
	function cancel(e,obj)
	{
		e.preventDefault();
		showPopupModal("Cancel Reason",obj.href);
	}
	
	function currency(x){
		
			var curr = $('#Curr_cd_'+(x)).val();
			var y= curr.toUpperCase(); 
		
			$('#Curr_cd_'+x).val(y);
		}
		$('#Texchrate-form').bind("keyup keypress", function(e) {
		
  	var code = e.keyCode || e.which; 
  	if (code  == 13) {               
    e.preventDefault();
    return false;
  	}
		});
	
	$(window).resize(function()
	{
		alignColumn();
	})
	$(window).trigger('resize');

	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableRate").find('thead');
		var firstRow = $("#tableRate").find('tbody tr:eq(0)');

		firstRow.find('td:eq(0)').css('width', header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width', header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width', header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width', (header.find('th:eq(3)').width()) - 17 + 'px');

	}
</script>
