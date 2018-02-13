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

<?php
$this->breadcrumbs = array(
	'Generate  Journal Selisih Kurs' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Generate  Journal Selisih Kurs',
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
		'id' => 'genrepojournal-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));

	echo $form->errorSummary($model);
	foreach($modelDetail as $row)echo $form->errorSummary(array($row));
?>
<br />
<br />
<input type="hidden" name="scenario" id="scenario" />
<input type="hidden" name="rowCount" id="rowCount" />
<div class="row-fluid">
	<div class="control-group">
		<div class="span5">
			<?php echo $form->datePickerRow($model, 'bal_dt', array(
				'prepend' => '<i class="icon-calendar"></i>',
				'placeholder' => 'dd/mm/yyyy',
				'class' => 'tdate span8',
				'options' => array('format' => 'dd/mm/yyyy')
			));
			?>
		</div>
		<div class="span5">

			<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType' => 'submit',
		'type' => 'primary',
		'label' => 'Retrieve',
		'id'=>'btnFilter'
	));
			?>
			&emsp;
			<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'submit',
					'type' => 'primary',
					'label' => 'Journal',
					'id'=>'btnJournal'
				));
			?>
		</div>

	</div>
</div>

<br />

<table id="tableKurs" class="table-bordered table-condensed" style="width: 80%">
	<thead>
		<tr>
			<th width= "10%">Tgl Saldo</th>
			<th width= "10%">Gl Account</th>
			<th width= "10%">Sl Account</th>
			<th width="10%"> Balance</th>
			<th width="10%"> File No</th>
		</tr>
	</thead>
	<tbody>
		<?php $x = 0;
		foreach($modelDetail as $row){
		?>
		<tr id="row<?php echo $x ?>">
			<td> <?php echo $form->textField($row, 'bal_dt', array(
				'name' => 'Tbalforeigncurrency[' . $x . '][bal_dt]',
				'class' => 'span',
				'readonly' => true
			));
		?>
			</td>
			<td> <?php echo $form->textField($row, 'gl_acct_cd', array(
					'name' => 'Tbalforeigncurrency[' . $x . '][gl_acct_cd]',
					'class' => 'span',
					'readonly' => true
				));
			?> </td>
			<td> <?php echo $form->textField($row, 'sl_acct_cd', array(
					'name' => 'Tbalforeigncurrency[' . $x . '][sl_acct_cd]',
					'class' => 'span',
					'readonly' => true
				));
			?> </td>
			<td> <?php echo $form->textField($row, 'bal_amount', array(
					'name' => 'Tbalforeigncurrency[' . $x . '][bal_amount]',
					'class' => 'span',
					'readonly' => true,
					'style'=>'text-align:right'
				));
			?> </td>
			<td> <?php echo $form->textField($row, 'folder_cd', array(
					'name' => 'Tbalforeigncurrency[' . $x . '][folder_cd]',
					'class' => 'span',
					'readonly' => $folder_cd_flg=='Y'?false:true
				));
			?> </td>
		</tr>

		<?php  $x++;

	}
		?>
	</tbody>
</table>

<?php $this->endWidget(); ?>


<?php  $this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id'=>'mywaitdialog',
        'options'=>array(
            'title'=>'In Progress',
            'modal'=>true,
            'autoOpen'=>false,// default is true
            'closeOnEscape'=>false,
            'resizable'=>false,
            'draggable'=>false,
            'height'=>120,
            'open'=>// supply a callback function to handle the open event
                    'js:function(){ // in this function hide the close button
                         $(".ui-dialog-titlebar-close").hide();
						 //$(".ui-dialog-content").hide();
						
                    }'
         ))
);

	$this->widget('bootstrap.widgets.TbProgress',
    array('percent' => 100, // the progress
        	'striped' => true,
        	'animated' => true,
    )
);
?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
	var rowCount = '<?php echo count($modelDetail);?>';
	
	
	
	init();
	function init()
	{
		if(rowCount>0)
		{
			$('#tableKurs').show();
		}
		else
		{
			$('#tableKurs').hide();
		}
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
	$('#btnFilter').click(function(){
		$('#mywaitdialog').dialog('open');
		$('#scenario').val('filter');
	})
	$('#btnJournal').click(function(){
		$('#mywaitdialog').dialog('open');
		$('#scenario').val('journal');
		$('#rowCount').val(rowCount);
	})
	
</script>
