<style>
	#formbalancesheetringkas-form input[type=radio]
	{
		margin-left: 15px;
		margin-right: 5px;
		margin-bottom: 7px;
	}
	#tableGrp
	{
		background-color:#C3D9FF;
	}
	#tableGrp thead, #tableGrp tbody
	{
		display:block;
	}
	#tableGrp tbody
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
	'Formbalancesheetringkass'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Format Neraca Ringkas', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/formbalancesheetringkas/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'formbalancesheetringkas-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php
	echo $form->errorSummary($modelRpt); 
	foreach($model as $row)
		echo $form->errorSummary(array($row)); 
?>

<br/>

<div class="filter-group span12" style="margin-left:-15px;">
	<?php //echo $form->radioButtonListInlineRow($model[],'filterCriteria',array('Neraca Ringkas Aktiva','Neraca Ringkas Pasiva','Profit and Loss')) ?>
	<input type="radio" id="filter1" name="filter" value="0" <?php if($selected == 0)echo 'checked' ?>/>Aktiva
	<input type="radio" id="filter2" name="filter" value="1" <?php if($selected == 1)echo 'checked' ?>/>Pasiva
	<input type="radio" id="filter3" name="filter" value="2" <?php if($selected == 2)echo 'checked' ?>/>Aktiva dan Pasiva
	&nbsp;&nbsp;&nbsp;&nbsp;Report Date
	<input type="text" id="rpt_date" name="report_date" class="tdate span2" value="<?php echo $report_date?$report_date:'';?>"/>
	<input type="hidden" id="scenario" name="scenario"/>
	
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id' => 'btnFilter',
		'buttonType' => 'submit',
		'type'=>'primary',
		'label'=>'Retrieve',
		'htmlOptions' => array('style'=>'margin-left:1em'),
	)); ?>
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id'=>'btnRpt',
		'buttonType' => 'submit',
		'type' => 'primary',
		'label' => 'Print'
	));
	?>
	<a href="<?php echo $url_xls ;?>" id="btn_xls" class="btn btn-primary">Save to Excel</a>
</div>

<input type="hidden" id="oldFilterCriteria" name="oldFilterCriteria" value="<?php echo $selected ?>"/>
<input type="hidden" id="rowCount" name="rowCount"/>

<br/>
<br/>
<br/>
<table id='tableGrp' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th rowspan="2" width="4%"></th>
			<th rowspan="2" width="5%">Nomor Urut</th>
			<th colspan="2" width="18%">Version Date</th>
			<th rowspan="2" width="6%">Grp 1</th>
			<th rowspan="2" width="4%">Grp 2</th>
			<th rowspan="2" width="4%">Grp 3</th>
			<th rowspan="2" width="10%">Kode</th>
			<th rowspan="2" width="30%">Neraca Description</th>
			<th rowspan="2" width="6%">Catatan</th>
			<th rowspan="2" width="7%">Indent</th>
			<th rowspan="2" width="6%">
				<a title="add" onclick="addTopRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th>
		</tr>
		<tr>
			<th width="9%">From</th>
			<th width="9%">To</th>
		</tr>
	</thead>	
	<tbody>
	<?php $x = 1;
		foreach($model as $row){
			if ($row->ringkasan_cd == 'LRLASTYR' || $row->ringkasan_cd == 'LRTHISYR' || $row->ringkasan_cd == 'SUM3' || $row->ringkasan_cd == 'SUM2'){
				$cekRcd = true;
			}else{
				$cekRcd = false;
			}
	?>
		<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
			<td width="4%">
				<?php echo $form->checkBox($row,'save_flg',array('value' => 'Y','name'=>'Formbalancesheetringkas['.$x.'][save_flg]','onChange'=>$row->norut?'rowControl(this,true)':'rowControl(this,false)','disabled'=>$cekRcd?'disabled':'')); ?>
				<?php if($row->old_norut): ?>
					<input type="hidden" name="Formbalancesheetringkas[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php endif; ?>
			</td>
			<td width="5%">
				<?php echo $form->textField($row,'norut',array('class'=>'span','name'=>'Formbalancesheetringkas['.$x.'][norut]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Formbalancesheetringkas[<?php echo $x ?>][old_norut]" value="<?php echo $row->old_norut ?>" />
			</td>
			<td width="9%">
				<?php echo $form->textField($row,'ver_bgn_dt',array('class'=>$row->save_flg!='Y'?'span':'span tdate','name'=>'Formbalancesheetringkas['.$x.'][ver_bgn_dt]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Formbalancesheetringkas[<?php echo $x ?>][old_ver_bgn_dt]" value="<?php echo $row->old_ver_bgn_dt ?>" />
			</td>
			<td width="9%">
				<?php echo $form->textField($row,'ver_end_dt',array('class'=>$row->save_flg!='Y'?'span':'span tdate','name'=>'Formbalancesheetringkas['.$x.'][ver_end_dt]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Formbalancesheetringkas[<?php echo $x ?>][old_ver_end_dt]" value="<?php echo $row->old_ver_end_dt ?>" />
			</td>
			<td width="6%">
				<?php echo $form->dropdownList($row,'grp_1',array('1'=>'Aktiva','2'=>'Pasiva'),array('class'=>'span','name'=>'Formbalancesheetringkas['.$x.'][grp_1]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<?php // echo $form->textField($row,'grp_1',array('class'=>'span','name'=>'Formbalancesheetringkas['.$x.'][grp_1]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Formbalancesheetringkas[<?php echo $x ?>][old_grp_1]" value="<?php echo $row->old_grp_1 ?>" />
			</td>
			<td width="4%">
				<?php echo $form->textField($row,'grp_2',array('class'=>'span','name'=>'Formbalancesheetringkas['.$x.'][grp_2]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Formbalancesheetringkas[<?php echo $x ?>][old_grp_2]" value="<?php echo $row->old_grp_2 ?>" />
			</td>
			<td width="4%">
				<?php echo $form->textField($row,'grp_3',array('class'=>'span','name'=>'Formbalancesheetringkas['.$x.'][grp_3]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Formbalancesheetringkas[<?php echo $x ?>][old_grp_3]" value="<?php echo $row->old_grp_3 ?>" />
			</td>
			<td width="10%">
				<?php echo $form->textField($row,'ringkasan_cd',array('class'=>'span','name'=>'Formbalancesheetringkas['.$x.'][ringkasan_cd]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Formbalancesheetringkas[<?php echo $x ?>][old_ringkasan_cd]" value="<?php echo $row->old_ringkasan_cd ?>" />
			</td>
			<td width="30%">
				<?php echo $form->textField($row,'line_desc',array('class'=>'span','name'=>'Formbalancesheetringkas['.$x.'][line_desc]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Formbalancesheetringkas[<?php echo $x ?>][old_line_desc]" value="<?php echo $row->old_line_desc ?>" />
				<input type="hidden" name="Formbalancesheetringkas[<?php echo $x ?>][old_line_type]" value="<?php echo $row->old_line_type ?>" />
			</td>
			<td width="6%">
				<?php echo $form->textField($row,'catatan',array('class'=>'span','name'=>'Formbalancesheetringkas['.$x.'][catatan]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Formbalancesheetringkas[<?php echo $x ?>][old_catatan]" value="<?php echo $row->old_catatan ?>" />
			</td>
			<td width="7%">
				<?php echo $form->dropdownList($row,'spasi',array(''=>'-- Select Indent --','1'=>'Header','2'=>'Sub Header','3'=>'Detail','4'=>'Sub Total','5'=>'Total'),array('class'=>'span','name'=>'Formbalancesheetringkas['.$x.'][spasi]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<?php // echo $form->textField($row,'spasi',array('class'=>'span','name'=>'Formbalancesheetringkas['.$x.'][spasi]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Formbalancesheetringkas[<?php echo $x ?>][old_spasi]" value="<?php echo $row->old_spasi ?>" />
			</td>
			<td width="6%">
				<a title="add" onclick="addRow(this)"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
				<a 	
					title="<?php if($row->old_norut) echo 'cancel';else echo 'delete'?>" 
					onclick="<?php if($row->old_norut) echo 'cancel(this,\''.$row->cancel_flg.'\','.$x.')';else echo 'deleteRow(this)'?>"
					<?php if($cekRcd){echo "hidden";}?>>
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
	<textarea id="cancel_reason" class="span5 cancel_reason" name="cancel_reason" maxlength="200" rows="4" readonly><?php echo $cancel_reason ?></textarea>
<?php endif; ?>

<br id="temp"/><br id="temp"/>

<div class="text-center style="margin-left:-100px"">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'htmlOptions'=>array('id'=>'btnSubmit'),
		'label'=> 'Save',
	)); ?>
</div>

<br/>

	<iframe src="<?php echo $url; ?>" class="span12" id="iframe" style="min-height:600px;max-width: 100%;"></iframe>



<?php // echo $form->datePickerRow($model[0],'dummy_dt',array('label'=>false,'style'=>'display:none'));?>
<?php echo $form->datePickerRow($modelRpt,'dummy_date',array('label'=>false,'style'=>'display:none'));?>
<?php $this->endWidget(); ?>

<?php
  	AHelper::popupwindow($this, 600, 500);
?>

<script>
	var rowCount = <?php echo count($model) ?>;
	var authorizedCancel = true;
	var url_xls = '<?php echo $url_xls ?>';
	var tanggal = '<?php echo $mDate->tanggal;?>';
	
	$('#iframe').hide();
	$('#btn_xls').hide();
	if(url_xls !=''){
		$('#btn_xls').show();
		$('#iframe').show();
		$('#tableGrp').hide();
		$('#btnSubmit').hide();
	}
	
	$(document).ready(function()
	{
		$(".tdate").datepicker({'format':'dd/mm/yyyy'});
	});

	$('#btnFilter').click(function()
	{
		$('#scenario').val('filter');
	})
	
	$('#btnSubmit').click(function()
	{
		$('#scenario').val('save');
		$('#rowCount').val(rowCount);
	})
	
	$('#btnRpt').click(function()
	{
		$('#scenario').val('report');
	})
	
	$('#btn_xls').click(function()
	{
		
	})
	
	$('#btnSearch').click(function()
	{
		var gl_acct_cd = $('#glAcctCd').val();
		
		for(x=0;x<rowCount;x++)
		{
			var obj = $("#tableGrp tbody tr:eq("+x+") td:eq(5) [type=text]")
			if(obj.val().trim().substr(0,4).toUpperCase() == gl_acct_cd.trim().toUpperCase())
			{
				obj.focus();
				break;
			}
			if(x == rowCount-1)alert('Gl Account Not Found')
		}
	})
	
	$(window).resize(function() {
		$('thead').css('width', '100%').css('width', '-=17px');
	})
	$(window).trigger('resize');
	
	init();
	
	function init()
	{
		$.ajax({
    		'type'     :'POST',
    		'url'      : '<?php echo $this->createUrl('ajxValidateCancel'); ?>',
			'dataType' : 'json',
			'statusCode':
			{
				403		: function(data){
					authorizedCancel = false;
				}
			}
		});
		
		cancel_reason();
		
		adjustIframeSize();
		
		if(url_xls=='')
		{
			$('#btn_xls').attr('disabled',true);
		}
	}
	
		
	function rowControl(obj, readonly)
	{
		var x = $(obj).closest('tr').prevAll().length;
		
		$("#tableGrp tbody tr:eq("+x+")").attr("id","row"+(x+1));	
		$("#tableGrp tbody tr:eq("+x+") td:eq(1) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(2) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false).attr("class",!$(obj).is(':checked')?"span":"span tdate").datepicker({'format':'dd/mm/yyyy'},readonly?"disable":"enable");
		$("#tableGrp tbody tr:eq("+x+") td:eq(3) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false).attr("class",!$(obj).is(':checked')?"span":"span tdate").datepicker({'format':'dd/mm/yyyy'},readonly?"disable":"enable");
		$("#tableGrp tbody tr:eq("+x+") td:eq(4) select").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(5) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(6) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(7) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(8) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(9) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(10) select").attr("readonly",!$(obj).is(':checked')?true:false);
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(11) a:eq(1)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
	}
	
	function addTopRow()
	{
		$("#tableGrp").find('tbody')
    		.prepend($('<tr>')
			.attr('id','row1')
			.append($('<td>')
				.append($('<input>')
					.attr('name','Formbalancesheetringkas[1][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Formbalancesheetringkas[1][norut]')
					.attr('type','text')
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','tdate span')
           		 	.attr('name','Formbalancesheetringkas[1][ver_bgn_dt]')
					.attr('type','text')
				)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','tdate span')
           		 	.attr('name','Formbalancesheetringkas[1][ver_end_dt]')
					.attr('type','text')
					.val(tanggal)
           		)
           	).append($('<td>')
           		.append($('<select>')
			    	.attr('class','span')
			        .attr('name','Groupneraca[1][gl_acct_cd]')
			        .append($('<option>')
			        	.val(' ')
			            .html('-- Select Group --')
			        )
			        <?php
			        	if($selected == 0){
			        	echo"
			        		.append($('<option>')
					        	.val('1')
					            .html('Aktiva')
					            .prop('selected', true)
					        )
					        .append($('<option>')
					        	.val('2')
					            .html('Pasiva')
					        )
					    ";
			        	}else if($selected == 1){
			        	echo"
			        		.append($('<option>')
					        	.val('1')
					            .html('Aktiva')
					        )
					        .append($('<option>')
					        	.val('2')
					            .html('Pasiva')
					            .prop('selected', true)
					        )
					    ";
			        	}else{
			        	echo"
			        		.append($('<option>')
					        	.val('1')
					            .html('Aktiva')
					        )
					        .append($('<option>')
					        	.val('2')
					            .html('Pasiva')
					        )
					    ";	
			        	}
			        ?>
			    )
           	// ).append($('<td>')
           		 // .append($('<input>')
           		 	// .attr('class','span')
           		 	// .attr('name','Formbalancesheetringkas[1][grp_1]')
					// .attr('type','text')
				// <?php
					// if($selected == 0 || $selected == 2)
					// {
				// ?>
					// .val('1')
				// <?php
					// }
					// else
					// {
				// ?>
					// .val('2')
				// <?php		
					// }
				// ?>
           		// )
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Formbalancesheetringkas[1][grp_2]')
					.attr('type','text')
				)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Formbalancesheetringkas[1][grp_3]')
					.attr('type','text')
				)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Formbalancesheetringkas[1][ringkasan_cd]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Formbalancesheetringkas[1][line_desc]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Formbalancesheetringkas[1][catatan]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<select>')
           		 	.attr('class','span')
           		 	.attr('name','Formbalancesheetringkas[1][spasi]')
					.append($('<option>')
			        	.val(' ')
			            .html('-- Select Indent --')
			        )
			        .append($('<option>')
			        	.val('1')
			            .html('Header')
			        )
			        .append($('<option>')
			        	.val('2')
			            .html('Sub Header')
			        )
			        .append($('<option>')
			        	.val('3')
			            .html('Detail')
			            .attr("selected","selected")
			        )
			        .append($('<option>')
			        	.val('4')
			            .html('Sub Total')
			        )
			        .append($('<option>')
			        	.val('5')
			            .html('Total')
			        )
           		)
           	// ).append($('<td>')
           		// .append($('<input>')
           		 	// .attr('class','span')
           		 	// .attr('name','Formbalancesheetringkas[1][spasi]')
					// .attr('type','text')
					// .val('3')
           		// )
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
           	)  	
		);
		rowCount++;
		reassignId();
		
		$(".tdate").datepicker({'format':'dd/mm/yyyy'});
	}

	function addRow(obj)
	{
		($('<tr>').insertAfter($(obj).closest('tr'))
			.attr('id','row0')
			.append($('<td>')
				.append($('<input>')
					.attr('name','Formbalancesheetringkas[0][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.prop('checked',true)
					.val('Y')
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Formbalancesheetringkas[0][norut]')
					.attr('type','text')
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span tdate tdate')
           		 	.attr('name','Formbalancesheetringkas[0][ver_bgn_dt]')
					.attr('type','text')
				)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span tdate tdate')
           		 	.attr('name','Formbalancesheetringkas[0][ver_end_dt]')
					.attr('type','text')
					.val(tanggal)
           		)
           	).append($('<td>')
           		.append($('<select>')
			    	.attr('class','span')
			        .attr('name','Groupneraca[0][gl_acct_cd]')
			        .append($('<option>')
			        	.val(' ')
			            .html('-- Select Group --')
			        )
			        <?php
			        	if($selected == 0){
			        	echo"
			        		.append($('<option>')
					        	.val('1')
					            .html('Aktiva')
					            .prop('selected', true)
					        )
					        .append($('<option>')
					        	.val('2')
					            .html('Pasiva')
					        )
					    ";
			        	}else if($selected == 1){
			        	echo"
			        		.append($('<option>')
					        	.val('1')
					            .html('Aktiva')
					        )
					        .append($('<option>')
					        	.val('2')
					            .html('Pasiva')
					            .prop('selected', true)
					        )
					    ";
			        	}else{
			        	echo"
			        		.append($('<option>')
					        	.val('1')
					            .html('Aktiva')
					        )
					        .append($('<option>')
					        	.val('2')
					            .html('Pasiva')
					        )
					    ";	
			        	}
			        ?>
			    )
           	// ).append($('<td>')
           		 // .append($('<input>')
           		 	// .attr('class','span')
           		 	// .attr('name','Formbalancesheetringkas[0][grp_1]')
					// .attr('type','text')
           		// <?php
					// if($selected == 0 || $selected == 2)
					// {
				// ?>
					// .val('1')
				// <?php
					// }
					// else
					// {
				// ?>
					// .val('2')
				// <?php		
					// }
				// ?>
           		// )
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Formbalancesheetringkas[0][grp_2]')
					.attr('type','text')
				)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Formbalancesheetringkas[0][grp_3]')
					.attr('type','text')
				)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Formbalancesheetringkas[0][ringkasan_cd]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Formbalancesheetringkas[0][line_desc]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Formbalancesheetringkas[0][catatan]')
					.attr('type','text')
           		)
           	).append($('<td>')
           		.append($('<select>')
           		 	.attr('class','span')
           		 	.attr('name','Formbalancesheetringkas[0][spasi]')
					.append($('<option>')
			        	.val(' ')
			            .html('-- Select Indent --')
			        )
			        .append($('<option>')
			        	.val('1')
			            .html('Header')
			        )
			        .append($('<option>')
			        	.val('2')
			            .html('Sub Header')
			        )
			        .append($('<option>')
			        	.val('3')
			            .html('Detail')
			            .attr("selected","selected")
			        )
			        .append($('<option>')
			        	.val('4')
			            .html('Sub Total')
			        )
			        .append($('<option>')
			        	.val('5')
			            .html('Total')
			        )
           		)
           	// ).append($('<td>')
           		// .append($('<input>')
           		 	// .attr('class','span')
           		 	// .attr('name','Formbalancesheetringkas[0][spasi]')
					// .attr('type','text')
					// .val('3')
				// )
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
           	)  	
		);
		rowCount++;
		reassignId();
		
		$(".tdate").datepicker({'format':'dd/mm/yyyy'});
   	}
   	
   	function reassignId()
   	{
   		//var index = $(obj).closest('tr').prevAll().length + 1;
   		var obj = $("#tableGrp tbody");
   		
   		for(x=0;x<rowCount;x++)
   		{
			obj.find("tr:eq("+x+")").attr("id","row"+(x+1));	
			obj.find("tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Formbalancesheetringkas["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Formbalancesheetringkas["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(1)").attr("name","Formbalancesheetringkas["+(x+1)+"][cancel_flg]");
			
			obj.find("tr:eq("+x+") td:eq(1) [type=text]").attr("name","Formbalancesheetringkas["+(x+1)+"][norut]");
			obj.find("tr:eq("+x+") td:eq(1) [type=hidden]").attr("name","Formbalancesheetringkas["+(x+1)+"][old_norut]");
			
			obj.find("tr:eq("+x+") td:eq(2) [type=text]").attr("name","Formbalancesheetringkas["+(x+1)+"][ver_bgn_dt]");
			obj.find("tr:eq("+x+") td:eq(2) [type=hidden]").attr("name","Formbalancesheetringkas["+(x+1)+"][old_ver_bgn_dt]");
			
			obj.find("tr:eq("+x+") td:eq(3) [type=text]").attr("name","Formbalancesheetringkas["+(x+1)+"][ver_end_dt]");
			obj.find("tr:eq("+x+") td:eq(3) [type=hidden]").attr("name","Formbalancesheetringkas["+(x+1)+"][old_ver_end_dt]");
			
			obj.find("tr:eq("+x+") td:eq(4) select").attr("name","Formbalancesheetringkas["+(x+1)+"][grp_1]");
			obj.find("tr:eq("+x+") td:eq(4) [type=hidden]").attr("name","Formbalancesheetringkas["+(x+1)+"][old_grp_1]");
			
			obj.find("tr:eq("+x+") td:eq(5) [type=text]").attr("name","Formbalancesheetringkas["+(x+1)+"][grp_2]");
			obj.find("tr:eq("+x+") td:eq(5) [type=hidden]").attr("name","Formbalancesheetringkas["+(x+1)+"][old_grp_2]");
			
			obj.find("tr:eq("+x+") td:eq(6) [type=text]").attr("name","Formbalancesheetringkas["+(x+1)+"][grp_3]");
			obj.find("tr:eq("+x+") td:eq(6) [type=hidden]").attr("name","Formbalancesheetringkas["+(x+1)+"][old_grp_3]");
			
			obj.find("tr:eq("+x+") td:eq(7) [type=text]").attr("name","Formbalancesheetringkas["+(x+1)+"][ringkasan_cd]");
			obj.find("tr:eq("+x+") td:eq(7) [type=hidden]").attr("name","Formbalancesheetringkas["+(x+1)+"][old_ringkasan_cd]");
			
			obj.find("tr:eq("+x+") td:eq(8) [type=text]").attr("name","Formbalancesheetringkas["+(x+1)+"][line_desc]");
			obj.find("tr:eq("+x+") td:eq(8) [type=hidden]").attr("name","Formbalancesheetringkas["+(x+1)+"][old_line_desc]");
			obj.find("tr:eq("+x+") td:eq(8) [type=hidden]").attr("name","Formbalancesheetringkas["+(x+1)+"][line_type]");
			
			obj.find("tr:eq("+x+") td:eq(9) [type=text]").attr("name","Formbalancesheetringkas["+(x+1)+"][catatan]");
			obj.find("tr:eq("+x+") td:eq(9) [type=hidden]").attr("name","Formbalancesheetringkas["+(x+1)+"][old_catatan]");
			
			obj.find("tr:eq("+x+") td:eq(10) select").attr("name","Formbalancesheetringkas["+(x+1)+"][spasi]");
			obj.find("tr:eq("+x+") td:eq(10) [type=hidden]").attr("name","Formbalancesheetringkas["+(x+1)+"][old_spasi]");
		}
		
		//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0;x<rowCount;x++)
   		{
   			if($("[name='Formbalancesheetringkas["+(x+1)+"][cancel_flg]']").val())
				obj.find("tr:eq("+x+") td:eq(11) a:eq(1)").attr('onClick',"cancel(this,'"+$("[name='Formbalancesheetringkas["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
   			else
   			{
   				obj.find("tr:eq("+x+") td:eq(11) a:eq(1)").attr('onClick',"deleteRow(this)");
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
		if(authorizedCancel)
		{
			$(obj).closest('tr').attr('class',cancel_flg=='N'?'markCancel':''); 
			$('[name="Formbalancesheetringkas['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
			$(obj).attr('onClick',cancel_flg=='N'?"cancel(this,'Y',"+seq+")":"cancel(this,'N',"+seq+")");
			
			$("#tableGrp tbody tr:eq("+(seq-1)+") td:eq(0) [type=checkbox]").prop('checked',cancel_flg=='N'?true:false).trigger('change'); //check or uncheck the checkbox
			
			cancel_reason();
		}
		else
			alert('You are not authorized to perform this action');	
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
	  adjustIframeSize();
	 });
	 
	 function adjustIframeSize()
	 {
		  // $("#iframe").offset({left:335});
		  $("#iframe").css('width',($(window).width()+35));
	 }
</script>

