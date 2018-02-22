<style>
	#groupneraca-form input[type=radio]
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
	'Groupneracas'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Map GL Account to Neraca Ringkas', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/groupneraca/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
);

?>

<!-- <h1>Map GL Account to Neraca Ringkas</h1> -->

<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'groupneraca-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal'
)); ?>

<?php
	echo $form->errorSummary($modelRpt); 
	foreach($model as $row)
		echo $form->errorSummary(array($row)); 
?>

<br/>

<div class="filter-group span8" style="margin-left:-15px;width:560px">
	<?php //echo $form->radioButtonListInlineRow($model[],'filterCriteria',array('Neraca Ringkas Aktiva','Neraca Ringkas Pasiva','Profit and Loss')) ?>
	<input type="radio" id="filter1" name="filter" value="0" <?php if($selected == 0)echo 'checked' ?>/>Neraca Ringkas Aktiva
	<input type="radio" id="filter2" name="filter" value="1" <?php if($selected == 1)echo 'checked' ?>/>Neraca Ringkas Pasiva
	<input type="radio" id="filter3" name="filter" value="2" <?php if($selected == 2)echo 'checked' ?>/>Aktiva dan Pasiva
	<input type="hidden" id="scenario" name="scenario"/>
	
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'id' => 'btnFilter',
		'buttonType' => 'submit',
		'type'=>'primary',
		'label'=>'Retrieve',
		'htmlOptions' => array('style'=>'margin-left:1em'),
	)); ?>
</div>

<div>
	<label id="label_id_gl" class="control-label">Gl Account</label>
	<div class="controls">
		<input type="text" id="glAcctCd" class="span" style="margin-left:-60px;width:50px" maxlength="4">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id' => 'btnSearch',
			'buttonType' => 'button',
			'label'=>'Find',
			'htmlOptions' => array('style'=>'margin-left:1em'),
		)); ?>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'id'=>'btnRpt',
			'buttonType' => 'submit',
			'type' => 'primary',
			'label' => 'Print',
			'htmlOptions' => array('style'=>'margin-left:1em')
		));
		?>
		<a href="<?php echo $url_xls ;?>" id="btn_xls" class="btn btn-primary">Save to Excel</a>
	</div>
</div>

<input type="hidden" id="oldFilterCriteria" name="oldFilterCriteria" value="<?php echo $selected ?>"/>
<input type="hidden" id="rowCount" name="rowCount"/>

<br/>
<table id='tableGrp' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th rowspan="2" width="4%"></th>
			<th rowspan="2" width="5%">Nomor Urut</th>
			<th colspan="2" width="18%">Version Date</th>
			<th rowspan="2" width="4%">Grp 1</th>
			<th rowspan="2" width="8%">Gl Account</th>
			<th rowspan="2" width="25%">Description</th>
			<th rowspan="2" width="5%">Neraca Ringkas</th>
			<th rowspan="2" width="25%">Neraca Description</th>
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
	?>
		<tr id="row<?php echo $x ?>" class="<?php if($row->cancel_flg == 'Y')echo 'markCancel' ?>">
			<td width="4%">
				<?php echo $form->checkBox($row,'save_flg',array('id'=>"checkbox_$x",'class'=>'cekbox','value' => 'Y','name'=>'Groupneraca['.$x.'][save_flg]','onChange'=>$row->acct_name?'rowControl(this,true)':'rowControl(this,false)')); ?>
				<?php if($row->old_norut): ?>
					<input type="hidden" name="Groupneraca[<?php echo $x ?>][cancel_flg]" value="<?php echo $row->cancel_flg ?>"/>	
				<?php endif; ?>
			</td>
			<td width="5%">
				<?php echo $form->textField($row,'norut',array('class'=>'span','name'=>'Groupneraca['.$x.'][norut]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Groupneraca[<?php echo $x ?>][old_norut]" value="<?php echo $row->old_norut ?>" />
			</td>
			<td width="9%">
				<?php echo $form->textField($row,'ver_bgn_dt',array('class'=>$row->save_flg!='Y'?'span':'span tdate','name'=>'Groupneraca['.$x.'][ver_bgn_dt]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Groupneraca[<?php echo $x ?>][old_ver_bgn_dt]" value="<?php echo $row->old_ver_bgn_dt ?>" />
			</td>
			<td width="9%">
				<?php echo $form->textField($row,'ver_end_dt',array('class'=>$row->save_flg!='Y'?'span':'span tdate','name'=>'Groupneraca['.$x.'][ver_end_dt]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Groupneraca[<?php echo $x ?>][old_ver_end_dt]" value="<?php echo $row->old_ver_end_dt ?>" />
			</td>
			<td width="4%">
				<?php echo $form->textField($row,'grp_1',array('class'=>'span','name'=>'Groupneraca['.$x.'][grp_1]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Groupneraca[<?php echo $x ?>][old_grp_1]" value="<?php echo $row->old_grp_1 ?>" />
			</td>
			<td width="8%">
				<?php echo $form->dropdownList($row,'gl_acct_cd',CHtml::listData($mGla, 'gl_a', 'acct_name'),array('class'=>'span','name'=>'Groupneraca['.$x.'][gl_acct_cd]','empty'=>'--Select GL Account--','readonly'=>$row->save_flg!='Y'?'readonly':''))?>
				<?php // echo $form->textField($row,'gl_acct_cd',array('class'=>'span','name'=>'Groupneraca['.$x.'][gl_acct_cd]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Groupneraca[<?php echo $x ?>][old_gl_acct_cd]" value="<?php echo $row->old_gl_acct_cd ?>" />
			</td>
			<td width="25%">
				<?php echo $form->textField($row,'acct_name',array('class'=>'span','name'=>'Groupneraca['.$x.'][acct_name]','readonly'=>true)); ?>
			</td>
			<td width="5%">
				<?php echo $form->dropdownList($row,'ringkasan_cd',CHtml::listData($mRingkasan_cd, 'ringkasan_cd', 'line_desc'),array('class'=>'span','name'=>'Groupneraca['.$x.'][ringkasan_cd]','empty'=>'--Select Ringkasan Code--','readonly'=>$row->save_flg!='Y'?'readonly':''))?>
				<?php // echo $form->textField($row,'ringkasan_cd',array('class'=>'span','name'=>'Groupneraca['.$x.'][ringkasan_cd]','readonly'=>$row->save_flg!='Y'?'readonly':'')); ?>
				<input type="hidden" name="Groupneraca[<?php echo $x ?>][old_ringkasan_cd]" value="<?php echo $row->old_ringkasan_cd ?>" />
			</td>
			<td width="25%">
				<?php echo $form->textField($row,'line_desc',array('class'=>'span','name'=>'Groupneraca['.$x.'][line_desc]','readonly'=>true)); ?>
			</td>
			<td width="6%">
				<a title="add" onclick="addRow(this)"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
				<a 	
					title="<?php if($row->old_norut) echo 'cancel';else echo 'delete'?>" 
					onclick="<?php if($row->old_norut) echo 'cancel(this,\''.$row->cancel_flg.'\','.$x.')';else echo 'deleteRow(this)'?>">
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
	<textarea id="cancel_reason" class="span5 cancel_reason" name="cancel_reason" maxlength="200" rows="4" disabled><?php echo $cancel_reason ?></textarea>
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

	<iframe src="<?php echo $url; ?>" id="iframe" style="min-height:600px;max-width: 100%;"></iframe>



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
		$('#label_id_gl').hide();
		$('#glAcctCd').hide();
		$('#btnSearch').hide();
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
		$("#tableGrp tbody tr:eq("+x+") td:eq(4) [type=text]").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(5) select").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(6) [type=text]").attr("readonly",!$(obj).is(':checked')||readonly?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(7) select").attr("readonly",!$(obj).is(':checked')?true:false);
		$("#tableGrp tbody tr:eq("+x+") td:eq(8) [type=text]").attr("readonly",!$(obj).is(':checked')||readonly?true:false);
		
		if(!$(obj).is(':checked') && $(obj).closest('tr').hasClass('markCancel'))$(obj).closest('tr').find('td:eq(9) a:eq(1)').trigger('click'); //unmark the row for cancellation if the checkbox is unchecked
		
		// $(".tdate").datepicker(!$(obj).is(':checked')?"destroy":{'format':'dd/mm/yyyy'});
	}
	
	// function cekbox(obj)
	// {
		// var test = obj;
		// alert(test);
		// // $(".tdate").datepicker(!$(obj).is(':checked')?"destroy":{'format':'dd/mm/yyyy'});
	// }
	
	function addTopRow()
	{
		$("#tableGrp").find('tbody')
    		.prepend($('<tr>')
			.attr('id','row1')
			.append($('<td>')
				.append($('<input>')
					.attr('name','Groupneraca[1][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.attr('class','cekbox')
					.prop('checked',true)
					.val('Y')
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupneraca[1][norut]')
					.attr('type','text')
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','tdate span')
           		 	.attr('name','Groupneraca[1][ver_bgn_dt]')
					.attr('type','text')
				)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','tdate span')
           		 	.attr('name','Groupneraca[1][ver_end_dt]')
					.attr('type','text')
					.val(tanggal)
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupneraca[1][grp_1]')
					.attr('type','text')
				<?php
					if($selected == 0 || $selected == 2)
					{
				?>
					.val('1')
				<?php
					}
					else
					{
				?>
					.val('2')
				<?php		
					}
				?>
           		)
           	).append($('<td>')
           		.append($('<select>')
			    	.attr('class','span')
			        .attr('name','Groupneraca[1][gl_acct_cd]')
			        .append($('<option>')
			        	.val(' ')
			            .html('-- Select GL_A --')
			        )
			        <?php
			        foreach ($mGla as $gla) {	
					echo"
			        .append($('<option>')
			        	.val('".$gla->gl_a."')
			            .html('".$gla->acct_name."')
			        )
			        ";
			        }
			        ?>
			    )
           	// ).append($('<td>')
           		// .append($('<input>')
           		 	// .attr('class','span')
           		 	// .attr('name','Groupneraca[1][gl_acct_cd]')
					// .attr('type','text')
           		// )
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupneraca[1][acct_name]')
					.attr('type','text')
					.attr("readonly",true)
           		)
           	).append($('<td>')
           		.append($('<select>')
			    	.attr('class','span')
			        .attr('name','Groupneraca[1][ringkasan_cd]')
			        .append($('<option>')
			        	.val(' ')
			            .html('-- Select Ringkasan cd --')
			        )
			        <?php
			        foreach ($mRingkasan_cd as $Rcd) {	
					echo"
			        .append($('<option>')
			        	.val('".$Rcd->ringkasan_cd."')
			            .html('".$Rcd->line_desc."')
			        )
			        ";
			        }
			        ?>
			    )
           	// ).append($('<td>')
           		// .append($('<input>')
           		 	// .attr('class','span')
           		 	// .attr('name','Groupneraca[1][ringkasan_cd]')
					// .attr('type','text')
           		// )
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupneraca[1][line_desc]')
					.attr('type','text')
					.attr("readonly",true)
           		)
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
					.attr('name','Groupneraca[0][save_flg]')
					.attr('type','checkbox')
					.attr('onChange','rowControl(this,false)')
					.attr('class','cekbox')
					.prop('checked',true)
					.val('Y')
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupneraca[0][norut]')
					.attr('type','text')
				)
			).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span tdate tdate')
           		 	.attr('name','Groupneraca[0][ver_bgn_dt]')
					.attr('type','text')
				)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span tdate tdate')
           		 	.attr('name','Groupneraca[0][ver_end_dt]')
					.attr('type','text')
					.val(tanggal)
           		)
           	).append($('<td>')
           		 .append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupneraca[0][grp_1]')
					.attr('type','text')
           		<?php
					if($selected == 0 || $selected == 2)
					{
				?>
					.val('1')
				<?php
					}
					else
					{
				?>
					.val('2')
				<?php		
					}
				?>
           		)
           	).append($('<td>')
           		.append($('<select>')
			    	.attr('class','span')
			        .attr('name','Groupneraca[0][gl_acct_cd]')
			        .append($('<option>')
			        	.val(' ')
			            .html('-- Select GL_A --')
			        )
			        <?php
			        foreach ($mGla as $gla) {	
					echo"
			        .append($('<option>')
			        	.val('".$gla->gl_a."')
			            .html('".$gla->acct_name."')
			        )
			        ";
			        }
			        ?>
			    )
           	// ).append($('<td>')
           		// .append($('<input>')
           		 	// .attr('class','span')
           		 	// .attr('name','Groupneraca[0][gl_acct_cd]')
					// .attr('type','text')
           		// )
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupneraca[0][acct_name]')
					.attr('type','text')
					.attr("readonly",true)
           		)
           	).append($('<td>')
           		.append($('<select>')
			    	.attr('class','span')
			        .attr('name','Groupneraca[0][ringkasan_cd]')
			        .append($('<option>')
			        	.val(' ')
			            .html('-- Select Ringkasan cd --')
			        )
			        <?php
			        foreach ($mRingkasan_cd as $Rcd) {	
					echo"
			        .append($('<option>')
			        	.val('".$Rcd->ringkasan_cd."')
			            .html('".$Rcd->line_desc."')
			        )
			        ";
			        }
			        ?>
			    )
           	// ).append($('<td>')
           		// .append($('<input>')
           		 	// .attr('class','span')
           		 	// .attr('name','Groupneraca[0][ringkasan_cd]')
					// .attr('type','text')
           		// )
           	).append($('<td>')
           		.append($('<input>')
           		 	.attr('class','span')
           		 	.attr('name','Groupneraca[0][line_desc]')
					.attr('type','text')
					.attr("readonly",true)
           		)
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
			obj.find("tr:eq("+x+") td:eq(0) [type=checkbox]").attr("name","Groupneraca["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(0)").attr("name","Groupneraca["+(x+1)+"][save_flg]");
			obj.find("tr:eq("+x+") td:eq(0) [type=hidden]:eq(1)").attr("name","Groupneraca["+(x+1)+"][cancel_flg]");
			obj.find("tr:eq("+x+") td:eq(1) [type=text]").attr("name","Groupneraca["+(x+1)+"][norut]");
			obj.find("tr:eq("+x+") td:eq(1) [type=hidden]").attr("name","Groupneraca["+(x+1)+"][old_norut]");
			obj.find("tr:eq("+x+") td:eq(2) [type=text]").attr("name","Groupneraca["+(x+1)+"][ver_bgn_dt]");
			obj.find("tr:eq("+x+") td:eq(2) [type=hidden]").attr("name","Groupneraca["+(x+1)+"][old_ver_bgn_dt]");
			obj.find("tr:eq("+x+") td:eq(3) [type=text]").attr("name","Groupneraca["+(x+1)+"][ver_end_dt]");
			obj.find("tr:eq("+x+") td:eq(3) [type=hidden]").attr("name","Groupneraca["+(x+1)+"][old_ver_end_dt]");
			obj.find("tr:eq("+x+") td:eq(4) [type=text]").attr("name","Groupneraca["+(x+1)+"][grp_1]");
			obj.find("tr:eq("+x+") td:eq(4) [type=hidden]").attr("name","Groupneraca["+(x+1)+"][old_grp_1]");
			obj.find("tr:eq("+x+") td:eq(5) select").attr("name","Groupneraca["+(x+1)+"][gl_acct_cd]");
			obj.find("tr:eq("+x+") td:eq(5) [type=hidden]").attr("name","Groupneraca["+(x+1)+"][old_gl_acct_cd]");
			obj.find("tr:eq("+x+") td:eq(6) [type=text]").attr("name","Groupneraca["+(x+1)+"][acct_name]");
			obj.find("tr:eq("+x+") td:eq(7) select").attr("name","Groupneraca["+(x+1)+"][ringkasan_cd]");
			obj.find("tr:eq("+x+") td:eq(7) [type=hidden]").attr("name","Groupneraca["+(x+1)+"][old_ringkasan_cd]");
			obj.find("tr:eq("+x+") td:eq(8) [type=text]").attr("name","Groupneraca["+(x+1)+"][line_desc]");
		}
		
		//Looping kedua untuk menentukan mana record yang dapat di-cancel dan mana row yang dapat di-delete
		for(x=0;x<rowCount;x++)
   		{
   			if($("[name='Groupneraca["+(x+1)+"][cancel_flg]']").val())
				obj.find("tr:eq("+x+") td:eq(9) a:eq(1)").attr('onClick',"cancel(this,'"+$("[name='Groupneraca["+(x+1)+"][cancel_flg]']").val()+"',"+(x+1)+")")		
   			else
   			{
   				obj.find("tr:eq("+x+") td:eq(9) a:eq(1)").attr('onClick',"deleteRow(this)");
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
			$('[name="Groupneraca['+seq+'][cancel_flg]"]').val(cancel_flg=='N'?'Y':'N'); 
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
		  // $("#iframe").offset({left:35});
		  // $("#iframe").offset({right:55});
		  $("#iframe").css('width',($(window).width()+35));
	 }
	 
	 // $('.cekbox').click(function(){
// 		
		// var coba = $(this).closest("tr").find("td:eq(0)").find(".cekbox").is(":checked");
// 		
		// alert(coba);
// 		
		// if(coba){
			// $(this).closest("tr").find(".tdate").datepicker({'format':'dd/mm/yyyy'});
		// }
// 		
	// })
</script>

