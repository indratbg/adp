<style>
	#tableKurs {
		background-color: #C3D9FF;
	}
	#tableKurs thead, #tableKurs tbody {
		display: block;
	}
	#tableKurs tbody {
		max-height: 300px;
		overflow: auto;
		background-color: #FFFFFF;
	}
</style>
</style>

<?php
$this->breadcrumbs = array(
	'Foreign Currency Balance' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Foreign Currency Balance',
		'itemOptions' => array('style' => 'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
	),
	array(
		'label' => 'List',
		'url' => array('index'),
		'icon' => 'list',
		'itemOptions' => array(
			'class' => 'active',
			'style' => 'float:right'
		)
	),
);
?>

<?php AHelper::showFlash($this) ?>
<!-- show flash -->
<?php AHelper::applyFormatting()
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'Tbalforeigncurrency-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));

	foreach($model as $row)echo $form->errorSummary(array($row));
?>
<div class="msg"></div>
<br />

<input type="hidden" id="scenario" name="scenario"/>
<input type="hidden" id="rowSeq" name="rowSeq"/>


<table id="tableKurs" class="table-bordered table-condensed" style="width: 80%">
	<thead>
		<tr>
			<th width= "10%">Date</th>
			<th width= "10%">GL Account</th>
			<th width= "10%">SL Account</th>
			<th width="5%">Currency</th>
			<th width="10%"> Balance</th>
			<th width="10%">
				<a href="#" onclick="addRow()" title="Add Row" > 
				<span class="icon-plus"></span>
				</a>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php $x = 1;
		foreach($model as $row){
			if($row->isNewRecord)$x = 0;
		?>
		<tr id="row<?php echo $x ?>">
			<td> <?php echo $form->textField($row, 'bal_dt', array(
				'name' => 'Tbalforeigncurrency[' . $x . '][bal_dt]',
				'class' => 'span tdate',
				'placeholder' => 'dd/mm/yyyy'
			));
		?>
		 <?php echo $form->textField($row, 'rowid', array(
				'name' => 'Tbalforeigncurrency[' . $x . '][rowid]',
				'class' => 'span',
				'style'=>'display:none'
			));
		?>
			</td>
			<td> <?php echo $form->textField($row, 'gl_acct_cd', array(
					'name' => 'Tbalforeigncurrency[' . $x . '][gl_acct_cd]',
					'class' => 'span',
				));
			?>
			</td>
			<td>
			<?php echo $form->textField($row, 'sl_acct_cd', array(
					'name' => 'Tbalforeigncurrency[' . $x . '][sl_acct_cd]',
					'class' => 'span',

				));
			?> </td>
			<td>
				<?php echo $form->textField($row, 'curr_cd', array(
					'name' => 'Tbalforeigncurrency[' . $x . '][curr_cd]',
					'class' => 'span',
					'id'=>'curr_cd_'.$x,
					'onchange'=>'upper_curr_cd('.$x.')'
				));
			?> 
			</td>
			<td> <?php echo $form->textField($row, 'bal_amount', array(
					'name' => 'Tbalforeigncurrency[' . $x . '][bal_amount]',
					'class' => 'span tnumberdec',
					'style'=>'text-align:right'
				));
			?> </td>
			<td style="cursor:pointer;">
				<a onclick="<?php if(!$row->isNewRecord) echo 'update('.$x.')';else echo 'create()'?>" title="Save" > 
				<span class="icon-ok"></span>
				</a>
				<a  onclick="cancel('<?php echo $row->rowid ;?>')" title="Delete" > 
				<span class="icon-trash"></span>
				</a>
			</td>
		</tr>

		<?php  $x++;

	}
		?>
	</tbody>
</table>
<?php echo $form->datePickerRow($model[0],'cre_dt',array('label'=>false,'style'=>'display:none'));?>

<?php $this->endWidget(); ?>


<script>
	var rowCount = '<?php echo count($model);?>';
	var today = '<?php echo date('d/m/Y');?>';
	var insert = false;
	<?php if($insert){ ?>
		insert = true;
	<?php } ?>

	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
	
	}
	
	
	$(window).resize(function()
	{
		alignColumn();
	})
	$(window).trigger('resize');

	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableKurs").find('thead');
		var firstRow = $("#tableKurs").find('tbody tr:eq(0)');

		firstRow.find('td:eq(0)').css('width', header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width', header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width', header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width', header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width', header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width', (header.find('th:eq(5)').width()) - 17 + 'px');

	}
	
	function addRow()
	{
		if(!insert)
		{		
			$("#tableKurs").find('tbody')
    		.prepend($('<tr>')
    			.attr('id','row0')
    			.append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tbalforeigncurrency[0][bal_dt]')
               		 	.attr('type','text')
               		 	.datepicker({format : "dd/mm/yyyy"})
               		 	.val(today)
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tbalforeigncurrency[0][gl_acct_cd]')
               		 	.attr('type','text')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tbalforeigncurrency[0][sl_acct_cd]')
               		 	.attr('type','text')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tbalforeigncurrency[0][curr_cd]')
               		 	.attr('type','text')
               		 	.attr('id','curr_cd_0')
               		 	.attr('onchange','upper_curr_cd(0)')
               		 	.val('USD')
               		)
               	).append($('<td>')
               		 .append($('<input>')
               		 	.attr('class','span')
               		 	.attr('name','Tbalforeigncurrency[0][bal_amount]')
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
		$("#Tbalforeigncurrency-form").submit();
	}
	function update(rowSeq)
	{
		$('#scenario').val('update');
		$("#rowSeq").val(rowSeq);
		$("#Tbalforeigncurrency-form").submit();
	}
	
	function cancel(rowId)
	{
		if(confirm('Are you sure want to delete ?'))
		{
			$.get('<?php echo Yii::app()->createUrl("/glaccounting/Tbalforeigncurrency/ajxdelete&rowid=") ?>'+rowId,function(data){
				var msg = "<div class='alert in alert-block fade alert-success' role='alert'>";
				msg +="Data has been deleted";
				msg +="</div>";
				
				$('.msg').html(msg);
				location.reload();
				
			})
		}
	}
	function upper_curr_cd(num)
	{
		$('#curr_cd_'+num).val($('#curr_cd_'+num).val().toUpperCase());
	}		
	
	setTimeout(function(){
		$('.tdate').datepicker('update');
	},
	100
	)
</script>
