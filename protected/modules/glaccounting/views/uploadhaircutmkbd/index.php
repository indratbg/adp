<style>
	#tableHaircut {
		background-color: #C3D9FF;
	}
	#tableHaircut thead, #tableHaircut tbody {
		display: block;
	}
	#tableHaircut tbody {
		max-height: 300px;
		overflow: auto;
		background-color: #FFFFFF;
	}
</style>
<?php
$this->breadcrumbs=array(
	'Upload Haircut MKBD'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Upload Haircut MKBD', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	//array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/texchrate/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
);
?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Texchrate-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));

echo $form->errorSummary(array($model));
 ?>

<input type="hidden" name="scenario" id="scenario">

<br/>

<div class="row-fluid">
	<div class="control-group">
		<div class="span5">
		<?php echo $form->datePickerRow($model, 'eff_dt', array(
				'prepend' => '<i class="icon-calendar"></i>',
				'placeholder' => 'dd/mm/yyyy',
				'class' => 'tdate span8',
				'options' => array('format' => 'dd/mm/yyyy')
			));
			?>
		</div>
		<div class="span4">
				<?php  echo CHTML::activeFileField($model,'file_upload');?>
		</div>
		<div class="span3">
			<?php 
				$this->widget('bootstrap.widgets.TbButton',
			    array(
			        'label' => 'UPLOAD',
			        'size' => 'medium',
			        'id' => 'btnImport',
			        'buttonType'=>'submit',
			        'htmlOptions'=>array('class'=>'btn-small btn-primary')
			    )
			); ?>
			&nbsp;
			
			<select id="eff_dt" class="span7">
				
			</select>
				<?php 
				/*
				$this->widget('bootstrap.widgets.TbButton',
								array(
									'label' => 'View Imported Date',
									'size' => 'medium',
									'id' => 'btnView',
									//'buttonType'=>'submit',
									'htmlOptions'=>array('class'=>'btn-small btn-primary','onclick'=>'getImportDate()')
								)
							); */
				?>
		</div>
		
	</div>
</div>

<br/>

<table id="tableHaircut" class="table-bordered table-condensed" style="width: 80%">
	<thead>
		<tr>
			<th width= "10%">Status Date</th>
			<th width= "10%">Stk Code</th>
			<th width= "10%">Haircut</th>
			<th width= "10%">Create Date</th>
			<th width="10%"> Effective Date</th>
		</tr>
	</thead>
	<tbody>
		<?php $x = 0;
		foreach($modelDetail as $row){
		?>
		<tr id="row<?php echo $x ?>">
			<td> <?php echo $row->status_dt; ?></td>
			<td> <?php echo $row->stk_cd; ?></td>
			<td> <?php echo $row->haircut; ?></td>
			<td> <?php echo $row->create_dt; ?></td>
			<td> <?php echo $row->eff_dt; ?></td>
		</tr>
		<?php  $x++; }?>
	</tbody>
</table>

<?php $this->endWidget();?>



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
	
if(rowCount==0)
{
	$('#tableHaircut').hide();
}
else
{
	$('#tableHaircut').show();
}
	getImportDate();
}



	$('#btnImport').click(function(event){
		$('#scenario').val('import');
		$('#mywaitdialog').dialog("open"); 
	})
	$('#btnView').click(function(event){
		$('#scenario').val('view');
	})
	
	function getImportDate()
	{
			
		$.ajax({
	    url: '<?php echo Yii::app()->request->baseUrl.'?r=glaccounting/uploadhaircutmkbd/GetListImportDate' ?>',
		    type: 'GET',
		    data: {},
		    dataType:'json',
		
		    success: function(data) {
		   
		    	var result = data.list_eff_dt;
					$('#eff_dt').append($('<option>').val('').text('-Imported Date-'));
					
					$.each(result, function(i, item) {
						console.log(result[i].eff_dt);
								$('#eff_dt').append($('<option>').val(result[i].eff_dt2).text(result[i].eff_dt2));
					});	
		    }
	    
	    });
 
	}
	
	$(window).resize(function()
	{
		alignColumn();
	})
	$(window).trigger('resize');

	function alignColumn()//align columns in thead and tbody
	{
		var header = $("#tableHaircut").find('thead');
		var firstRow = $("#tableHaircut").find('tbody tr:eq(0)');

		firstRow.find('td:eq(0)').css('width', header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width', header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width', header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width', header.find('th:eq(3)').width() + 'px');
		firstRow.find('td:eq(4)').css('width', header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width', (header.find('th:eq(5)').width()) - 17 + 'px');

	}
</script>
