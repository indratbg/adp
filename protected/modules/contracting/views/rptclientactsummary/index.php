<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'Client Activity (Summary)' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Client Activity (Summary)',
		'itemOptions' => array('style' => 'font-size:28px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
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

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'importTransaction-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));
?>


<?php AHelper::showFlash($this)
?>
<?php echo $form->errorSummary(array($model)); ?>
<br />
<div class="row-fluid">
	<div class="span5">
		<div class="control-group">
			<div class="span2">Date</div>
			<div class="span1">From</div>
			<div class="span3"><?php echo $form->textField($model,'bgn_date',array('id'=>'fromDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span12','required'=>true)); ?></div>
			<div class="span1">To</div>
			<div class="span4"><?php echo $form->textField($model,'end_date',array('id'=>'toDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span12','required'=>true)); ?></div>
		</div>
		
		<div class="control-group">
			<div class="span2">Client Code</div>
			<div class="span5">
				<div class="span6"><input type="radio" id="clt1" class="opt_clt" name="Rptclientactsummary[opt_clt]" value="1" <?php echo $model->opt_clt=='1'?'checked':'' ?>/> &nbsp; All</div>
				<div class="span6"><input type="radio" id="clt2" class="opt_clt" name="Rptclientactsummary[opt_clt]" value="2" <?php echo $model->opt_clt=='2'?'checked':'' ?>/> &nbsp; Specified</div>
			</div>
			<div class="span4">
				<?php echo $form->textField($model,'clt',array('id'=>'clt3','class'=>'span12'))?>
			</div>
		</div>
		
		<div class="control-group">
			<div class="span2">Report Type</div>
			<div class="span5">
				<div class="span6"><input type="radio" name="Rptclientactsummary[rpt_type]" class="rpt" value="0" <?php echo $model->rpt_type=='0'?'checked':'' ?>/> &nbsp; Summary</div>
				<div class="span6"><input id="ringkas" type="radio" name="Rptclientactsummary[rpt_type]" class="rpt" value="1" <?php echo $model->rpt_type=='1'?'checked':'' ?>/> &nbsp; Ringkas</div>
			</div>
		</div>
	</div>
	
	<div class="span6">
		<div class="control-group">
			<div class="span1">
				Branch
			</div>
			<div class="span1">
				<?php echo $form->checkBox($model,'opt_branch',array('id'=>'brch1','value'=>'1')) ?> All
			</div>
			<div class="span8">
				Specified&nbsp;
				<?php echo $form->dropdownList($model, 'branch',CHtml::listData($mbranch, 'brch_cd', 'brch_name'),array('id'=>'brch2','class'=>'span6','prompt'=>'-- Select Branch --','style'=>'font-family:courier'))?>
			</div>
		</div>
		
		<div class="control-group">
			<div class="span1">
				Sales
			</div>
			<div class="span1">
				<?php echo $form->checkBox($model,'opt_rem',array('id'=>'rem1','value'=>'1')) ?> All
			</div>
			<div class="span8">
				Specified&nbsp;
				<?php echo $form->dropdownList($model, 'rem',CHtml::listData($msales, 'rem_cd', 'rem_name'),array('id'=>'rem2','class'=>'span6','prompt'=>'-- Select Sales --','style'=>'font-family:courier'))?>
			</div>
		</div>
		
		<div class="control-group">
			<div class="span2">
				Client Status
			</div>
			<div class="span2">
				<input type="radio" id="opt_sts1" name="Rptclientactsummary[opt_sts]" value="%" <?php echo $model->opt_sts=='%'?'checked':'' ?>/> &nbsp; All
			</div>
			<div class="span2">
				<input type="radio" id="opt_sts2" name="Rptclientactsummary[opt_sts]" value="R" <?php echo $model->opt_sts=='R'?'checked':'' ?>/> &nbsp; Regular
			</div>
			<div class="span2">
				<input type="radio" id="opt_sts3" name="Rptclientactsummary[opt_sts]" value="I" <?php echo $model->opt_sts=='I'?'checked':'' ?>/> &nbsp; Titip
			</div>
		</div>
		
	</div>
	
	<div class="control-group">
		<div class="span3">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType'=>'submit',
				'type'=>'primary',
				'label'=>'Show Report',
				'id'=>'btnProcess'
			)); ?>
		</div>
	</div>
</div>

<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>
<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>false,'style'=>'display:none'));?>
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

	init();
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		getClient();
		optionclient_CD();
		rptRingkas();
		optionclient_CD();
		optionrem_CD();
		optionbranch_CD();
	}
	
	$('.rpt').click(function(){
		rptRingkas();
	})
	
	$("#btnProcess").click(function(event)
	{	
		if(!$('#ringkas').is(':checked')){
			//console.log("klik");
			var specClient=$('input:radio[name="Rptclientactsummary[opt_clt]"]:checked').val();
			console.log("specClient: "+specClient)
			var isSpecClient=(specClient==='1');
			
			var clientPass = (!isSpecClient&&$("#clt2").val() || isSpecClient)?true:false;
			
			if(!clientPass){
				alert("Client harus diisi jika Specified Client")
				return false;
			}
			
			var specBranch=$('input:checkbox[name="Rptclientactsummary[opt_branch]"]:checked').val();
			console.log("specBranch: "+specBranch)
			var isSpecBranch=(specBranch==='1');
			
			var branchPass = (!isSpecBranch&&$("#brch2").val() || isSpecBranch)?true:false;
			
			if(!branchPass){
				alert("Branch harus diisi jika Specified Client")
				return false;
			}
			
			var specRem=$('input:checkbox[name="Rptclientactsummary[opt_rem]"]:checked').val();
			console.log("specRem: "+specRem)
			var isSpecRem=(specRem==='1');
			
			var remPass = (!isSpecRem&&$("#rem2").val() || isSpecRem)?true:false;
			
			if(!remPass){
				alert("Sales harus diisi jika Specified Client")
				return false;
			}
		}
	
	})
	
	function rptRingkas()
	{	
		if($('#ringkas').is(':checked')){
			$('#clt1').attr('disabled',true);
			$('#clt2').attr('disabled',true);
			$('#clt3').attr('disabled',true);
			$('#brch1').attr('disabled',true);
			$('#brch2').attr('disabled',true);
			$('#rem1').attr('disabled',true);
			$('#rem2').attr('disabled',true);
			$('#opt_sts1').attr('disabled',true);
			$('#opt_sts2').attr('disabled',true);
			$('#opt_sts3').attr('disabled',true);
		}else{
			$('#clt1').attr('disabled',false);
			$('#clt2').attr('disabled',false);
			$('#brch1').attr('disabled',false);
			$('#brch2').attr('disabled',false);
			$('#rem1').attr('disabled',false);
			$('#rem2').attr('disabled',false);
			$('#opt_sts1').attr('disabled',false);
			$('#opt_sts2').attr('disabled',false);
			$('#opt_sts3').attr('disabled',false);
		}		
	}
	
	$('.opt_clt').click(function(){
		// $('#brch1').prop('checked',true);
		// $('#rem1').prop('checked',true);
		optionclient_CD();
		optionbranch_CD();
		optionrem_CD();
	})
	
	function optionclient_CD()
	{	
		
		var client_CD=$('input:radio[name="Rptclientactsummary[opt_clt]"]:checked').val();
		var isclient_CD=(client_CD==='1');
		$('#clt3').attr('disabled',isclient_CD);
			
	}
	
	$('#rem1').click(function(){
		optionrem_CD();
	})
	
	function optionrem_CD()
	{	
		
		var rem_CD=$('input:checkbox[name="Rptclientactsummary[opt_rem]"]:checked').val();
		var isrem_CD=(rem_CD==='1');
		$('#rem2').attr('disabled',isrem_CD);
			
	}
	
	$('#brch1').click(function(){
		optionbranch_CD();
	})
	
	function optionbranch_CD()
	{	
		
		var branch_CD=$('input:checkbox[name="Rptclientactsummary[opt_branch]"]:checked').val();
		var isbranch_CD=(branch_CD==='1');
		$('#brch2').attr('disabled',isbranch_CD);
			
	}

	$('#fromDt').change(function(){
		updateDate();
	})
	
	function updateDate(){
		var tgl = $('#fromDt').val(); 
	    var dd = tgl.slice(0, 2);
	    var mm = tgl.slice(3, 5);
	    var yyyy = tgl.slice(6, 10);
	 	var lastDate  = new Date(yyyy, mm, 0);
		$("#toDt").val(lastDate.getDate() + '/' + ('0'+(lastDate.getMonth()+1)).slice(-2) + '/' + lastDate.getFullYear());
		$("#toDt").datepicker("update");
	}
	
	function getClient()
	{
		var result = [];
		$('#clt3').autocomplete(
		{
			source: function (request, response) 
			{
		        $.ajax({
		        	'type'		: 'POST',
		        	'url'		: '<?php echo $this->createUrl('getclient'); ?>',
		        	'dataType' 	: 'json',
		        	'data'		:	{
		        						'term': request.term,
		        						
		        					},
		        	'success'	: 	function (data) 
		        					{
				           				 response(data);
				           				 result = data;
				    				}
				});
		    },
		    change: function(event,ui)
	        {
	        	$(this).val($(this).val().toUpperCase());
	        	if (ui.item==null)
	            {
	            	// Only accept value that matches the items in the autocomplete list
	            	
	            	var inputVal = $(this).val();
	            	var match = false;
	            	
	            	$.each(result,function()
	            	{
	            		if(this.value.toUpperCase() == inputVal)
	            		{
	            			match = true;
	            			return false;
	            		}
	            	});
	            	
	            }
	        },
		    minLength: 1,
		     open: function() { 
			        $(this).autocomplete("widget").width(400);
			    } 
		});
	}
</script>
