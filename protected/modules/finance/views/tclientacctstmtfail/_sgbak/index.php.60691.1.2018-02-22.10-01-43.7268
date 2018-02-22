<style>
	#tableTclientacctstmtfail
	{
		background-color:#C3D9FF;
		width:100%;
	}
	
    #tableTclientacctstmtfail thead, #tableTclientacctstmtfail tbody {

	width: 1200px !important;
	}
	#tableTclientacctstmtfail thead, #tableTclientacctstmtfail tbody
	{
		display:block;
	}
	
	#tableTclientacctstmtfail tbody
	{
		
		max-height:280px;
		overflow:auto;
		background-color:#FFFFFF;
	}	
</style>
<?php
$this->breadcrumbs=array(
	'Auto RDI Mutation (Fail)'=>array('index'),
	'List',
);

$this->menu=array(
	array('label'=>'Auto RDI Mutation (Fail)', 'itemOptions'=>array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')),
	array('label'=>'List','url'=>array('index'),'icon'=>'list','itemOptions'=>array('class'=>'active','style'=>'float:right')),
	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tfundmovementall/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
	
);

?>


<?php AHelper::showFlash($this) ?> <!-- show flash -->
<?php AHelper::applyFormatting() ?> 


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'Tclientacctstmtfail-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); 
 ?>
 
 
 <?php foreach($model as $row)echo $form->errorSummary($row);?>
 <?php echo $form->errorSummary($model_dummy);?>
 
 <input type="hidden" name="rowCount" id="rowCount" />
 <input type="hidden" name="scenario" id="scenario" />
 <br />
 <div class="row-fluid">
 	<div class="span8">
 		<div class="control-group">
 		<div class="span1">
 			<label>From </label>
 		</div>
 		<div class="span3">
 			<?php echo $form->textField($model_dummy,'from_dt',array('label'=>false,'class'=>'span7 tdate','placeholder'=>'dd/mm/yyyy',));?>
 		</div>
 		<div class="span1">
 			<label>To </label>
 		</div>
 		<div class="span3">
 			<?php echo $form->textField($model_dummy,'to_dt',array('label'=>false,'class'=>'span7 tdate','placeholder'=>'dd/mm/yyyy'));?>
 		</div>
 		<div class="span1">
 			<label>Branch</label>
 		</div>
 		<div class="span3">
 				<?php echo $form->dropDownList($model_dummy, 'branch_code', CHtml::listData(Branch::model()->findAll(array(
					'select' => "brch_cd, brch_cd||' - '||brch_name brch_name",
					'condition' => " approved_stat='A'",
					'order' => 'brch_cd'
				)), 'brch_cd', 'brch_name'), array(
					'class' => 'span10',
					'prompt' => '-Select-',
					'style' => 'font-family:courier'
				));
				?>
 		</div>

 	</div>
 	</div>
 	<div class="span4">
 		<div class="control-group">
 			<div class="span6">
 				<?php $this->widget('bootstrap.widgets.TbButton', array(
						'id' => 'btnFilter',
						'buttonType' => 'submit',
						'type'=>'default',
						'label'=>'Retrieve',
						'htmlOptions' => array('class'=>'btn btn-primary')
					)); ?>
 		</div>
 		<div class="span6">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
				'id' => 'btnSubmit',
				'buttonType' => 'submit',
				'type'=>'default',
				'label'=>'Journal',
				'htmlOptions' => array('class'=>'btn btn-primary')
			)); ?>
 		</div>
 		</div>
 		
 	</div>
 	
 </div>
 
 <div style="background-color: #white; border: 0px solid 00000; overflow: auto; height: 410px;padding-bottom: -20px; width: 100%;margin-top: -20px;">
 <br />

<table id='tableTclientacctstmtfail'  class='table-bordered table-condensed' >
	<thead>
		<tr>
			<th width="90px">Tanggal Efektif</th>
			<th width="120px">Tanggal Timestamp</th>
			<th width="100px">RDN</th>
			<th width="30px">Branch</th>
			<th width="90px">Client Code</th>
			<th width="230px">Client Name</th>
			<th width="120px">Transaction Value</th>
			<th width="10px" style="text-align: center"> <input type="checkbox" id="checkAll" value="1" /></th>
			<th width="160px">Remark</th>
			<th width="120px">External Ref.</th>
		</tr>
	</thead>	
	<tbody>
 	<?php $x = 1;
		foreach($model as $row)
		{
	?>
		<tr id="row<?php echo $x ?>">
			<td>
				
				<?php  echo $form->textField($row,'tanggalefektif',array('class'=>'span tdate','name'=>'Tclientacctstmtfail['.$x.'][tanggalefektif]','readonly'=>false));?>
				<?php  echo $form->textField($row,'trx_type',array('class'=>'span tdate','name'=>'Tclientacctstmtfail['.$x.'][trx_type]','style'=>'display:none'));?>
				<?php  echo $form->textField($row,'trx_cd',array('class'=>'span','name'=>'Tclientacctstmtfail['.$x.'][trx_cd]','style'=>'display:none'));?>
				<?php  echo $form->textField($row,'cifs',array('class'=>'span','name'=>'Tclientacctstmtfail['.$x.'][cifs]','style'=>'display:none'));?>
			</td>
			<td>
				<?php  echo $form->textField($row,'tanggaltimestamp',array('placeholder'=>'dd/mm/yyyy h:m:s','class'=>'span','name'=>'Tclientacctstmtfail['.$x.'][tanggaltimestamp]','readonly'=>true));?>
			</td>
			<td>
				<?php  echo $form->textField($row,'acct_num',array('class'=>'span','name'=>'Tclientacctstmtfail['.$x.'][acct_num]','readonly'=>true));?>
			</td>
			<td>
				<?php  echo $form->textField($row,'branch_code',array('class'=>'span','name'=>'Tclientacctstmtfail['.$x.'][branch_code]','readonly'=>true));?>
			</td>
			<td>
				<?php  echo $form->textField($row,'client_cd',array('onchange'=>'client_upper('.$x.')','class'=>'span','name'=>'Tclientacctstmtfail['.$x.'][client_cd]','readonly'=>false));?>
			</td>
			<td>
				<?php  echo $form->textField($row,'client_name',array('class'=>'span','name'=>'Tclientacctstmtfail['.$x.'][client_name]','readonly'=>true));?>
			</td>
			<td>
				<?php  echo $form->textField($row,'trx_amt',array('class'=>'span tnumberdec','name'=>'Tclientacctstmtfail['.$x.'][trx_amt]','style'=>'text-align:right','readonly'=>true));?>
			</td>
			<td style="text-align: center" class="save_flg">
				<?php  echo $form->checkBox($row,'save_flg',array('class'=>'checkDetail','value'=>'Y','name'=>'Tclientacctstmtfail['.$x.'][save_flg]'));?>
			</td>
			<td>
				<?php  echo $form->textField($row,'remarks',array('class'=>'span','name'=>'Tclientacctstmtfail['.$x.'][remarks]','readonly'=>false));?>
			</td>
			<td>
				<?php  echo $form->textField($row,'external_ref',array('class'=>'span','name'=>'Tclientacctstmtfail['.$x.'][external_ref]','readonly'=>true));?>
			</td>
			
		</tr>
	<?php $x++;} ?>
	</tbody>	
</table>
</div>
<?php echo $form->datePickerRow($model_dummy,'trx_date',array('label'=>false,'style'=>'display:none'));?>
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
	var rowCount = '<?php echo count($model);?>';
	init();
	function init()
	{
		$('.tdate').datepicker({format:'dd/mm/yyyy'});
		if(rowCount==0)
		{
			$('#tableTclientacctstmtfail').hide();
		}
		 cek_all();
	}
	
	
	$('#btnFilter').click(function(){
		$('#mywaitdialog').dialog('open');
		$('#scenario').val('filter');
	});
	
	$('#btnSubmit').click(function(){
		$('#mywaitdialog').dialog('open');
		$('#scenario').val('journal');
		$('#rowCount').val(rowCount);
	});
	
	
	$(window).resize(function() {
		adjustWidth();
	})
	$(window).trigger('resize');
	
	function adjustWidth()
	{
		
	var header = $("#tableTclientacctstmtfail").find('thead');
		var firstRow = $("#tableTclientacctstmtfail").find('tbody tr:eq(0)');
		
		firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
		firstRow.find('td:eq(1)').css('width',header.find('th:eq(1)').width() + 'px');
		firstRow.find('td:eq(2)').css('width',header.find('th:eq(2)').width() + 'px');
		firstRow.find('td:eq(3)').css('width',header.find('th:eq(3)').width() +'px');
		firstRow.find('td:eq(4)').css('width',header.find('th:eq(4)').width() + 'px');
		firstRow.find('td:eq(5)').css('width',header.find('th:eq(5)').width() + 'px');
		firstRow.find('td:eq(6)').css('width',header.find('th:eq(6)').width() + 'px');
		firstRow.find('td:eq(7)').css('width',header.find('th:eq(7)').width() + 'px');
		firstRow.find('td:eq(8)').css('width',header.find('th:eq(8)').width() + 'px');
		firstRow.find('td:eq(9)').css('width',header.find('th:eq(9)').width()-17 +'px');
	};
	
	
	$('#checkAll').change(function(){
		if($('#checkAll').is(':checked'))
		{
			$('.checkDetail').prop('checked',true);
		}
		else
		{
			$('.checkDetail').prop('checked',false);
		}
		
	});
	
	$('.checkDetail').change(function(){
		cek_all();
	})
	
	function cek_all()
	{
		var sign='Y';
		$("#tableTclientacctstmtfail").children('tbody').children('tr').each(function()
		{
			var cek = $(this).children('td.save_flg').children('[type=checkbox]').is(':checked');
			
			if(!cek){
				sign='N';
			}
		});
		if(sign=='N'){
			$('#checkAll').prop('checked',false)	
		}
		else{
			$('#checkAll').prop('checked',true)
		}
	}
	
	function client_upper(num)
	{
		$('#Tclientacctstmtfail_'+num+'_client_cd').val($('#Tclientacctstmtfail_'+num+'_client_cd').val().toUpperCase());
	}
	$('#Tclientacctstmtfail_from_dt').change(function(){
		$('#Tclientacctstmtfail_to_dt').val($('#Tclientacctstmtfail_from_dt').val());
		$('.tdate').datepicker('update');
	});
</script>
