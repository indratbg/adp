<?php
$this->breadcrumbs=array(
	'Transaksi Dalam Mata Uang Asing Entry'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Transaksi Dalam Mata Uang Asing', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/ttrxforeign/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 



<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Ttrxforeign-form',
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
<table id='tableTtrx' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="13%">Tanggal Transaksi</th>
			<th width="9%">No Urut</th>
			<th width="12%">Jenis Transaksi</th>
			<th width="10%">Mata Uang</th>
			<th width="17%">Nilai (Rph)</th>
			<th width="17%">Untung Belum Terealisasi</th>
			<th width="17%">Rugi Belum Terealisasi</th>
			
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
				<?php echo $form->textField($row,'tgl_trx',array('class'=>'span','name'=>'Ttrxforeign['.$x.'][tgl_trx]')); ?>
				<input type="hidden" id="oldTglTrx<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $model[$x-1]->old_tgl_trx ?>"/>
			</td>
			<td><?php echo $form->textField($row,'norut',array('class'=>'span','name'=>'Ttrxforeign['.$x.'][norut]','style'=>'text-align:right;')); ?>
				<input type="hidden" id="oldNorut<?php echo $x ?>" value="<?php if(!$row->isNewRecord)echo $model[$x-1]->old_norut ?>"/>
			</td>
			
			<td><?php echo $form->textField($row,'jenis_trx',array('class'=>'span','name'=>'Ttrxforeign['.$x.'][jenis_trx]')); ?></td>
			<td><?php echo $form->textField($row,'currency_type',array('class'=>'span tdate','onchange'=>'currency('.$x.')','id'=>'Currency_type_'.$x.'','name'=>'Ttrxforeign['.$x.'][currency_type]')); ?></td>
			<td><?php echo $form->textField($row,'nilai_rph',array('class'=>'span tdate','name'=>'Ttrxforeign['.$x.'][nilai_rph]','value'=>number_format((float) $row->nilai_rph,0,'.',','),'style'=>'text-align:right;')); ?></td>
			<td><?php echo $form->textField($row,'untung_unreal',array('class'=>'span tdate','name'=>'Ttrxforeign['.$x.'][untung_unreal]','value'=>number_format((float) $row->untung_unreal,0,'.',','),'style'=>'text-align:right;')); ?></td>
			<td><?php echo $form->textField($row,'rugi_unreal',array('class'=>'span tdate','name'=>'Ttrxforeign['.$x.'][rugi_unreal]','value'=>number_format((float) $row->rugi_unreal,0,'.',','),'style'=>'text-align:right;')); ?></td>
			<td>
				<a href="#" title="<?php if(!$row->isNewRecord) echo 'save';else echo 'create'?>" onclick="<?php if(!$row->isNewRecord) echo 'update('.$x.')';else echo 'create()'?>"><i class="icon-ok"></i></a>
				<a 
					href="<?php if(!$row->isNewRecord)echo Yii::app()->createUrl("/glaccounting/Ttrxforeign/AjxPopDelete", 
								array('tgl_trx'=>$model[$x-1]->old_tgl_trx, 'norut'=>$model[$x-1]->old_norut));else echo '#' ?>" 
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
			$("#tableTtrx tbody tr:eq("+x+") td:eq(0) input").datepicker({format : "dd/mm/yyyy"});
			
		}
	}
	
	function addRow()
	{
		if(!insert)
		{
			$("#tableTtrx").find('tbody')
    		.prepend($('<tr>')
    			.attr('id','row0')
    			.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Ttrxforeign[0][tgl_trx]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Ttrxforeign[0][norut]')
               		 	.attr('type','text')
               		 	
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Ttrxforeign[0][jenis_trx]')
               		 	.attr('type','text')
               		 	
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Ttrxforeign[0][currency_type]')
               		 	.attr('type','text')
               		 	.attr('id','Currency_type_0')
               		 	.attr('onchange','currency(0)')
               		 	
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Ttrxforeign[0][nilai_rph]')
               		 	.attr('type','text')
               		 	.css('text-align','right')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Ttrxforeign[0][untung_unreal]')
               		 	.attr('type','text')
               		 	.css('text-align','right')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Ttrxforeign[0][rugi_unreal]')
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
	
	function strToUpper(obj)
	{
		$(obj).val($(obj).val().toUpperCase());
	}
	
	function create()
	{
		$('#scenario').val('create');
		$("#rowSeq").val(0);
		$("#Ttrxforeign-form").submit();
	}
	
	function update(rowSeq)
	{
		$('#scenario').val('update');
		$("#rowSeq").val(rowSeq);
		$("#oldPk").val($("#oldTglTrx"+rowSeq).val());
		$("#oldPk1").val($("#oldNorut"+rowSeq).val());
		$("#Ttrxforeign-form").submit();
	}
	
	function cancel(e,obj)
	{
		e.preventDefault();
		showPopupModal("Cancel Reason",obj.href);
	}
	function currency(x){
		
			var curr = $('#Currency_type_'+(x)).val();
			var y= curr.toUpperCase(); 
		
			$('#Currency_type_'+x).val(y);
		}
		$('#Ttrxforeign-form').bind("keyup keypress", function(e) {
		
  	var code = e.keyCode || e.which; 
  	if (code  == 13) {               
    e.preventDefault();
    return false;
  	}
		});
</script>
