<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'Report Interest Reconcile' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Report Interest Reconcile',
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

<?php
	//$zx=$mPeriodeDate[0]->trs_dt; 
	// $newDate = DateTime::createFromFormat("Y-m-d", $zx);
	// $cobadate = $newDate->format('d/m/Y');
	//echo $zx;
	//echo $mPeriodeDate[0]->trs_dt;
	//echo date_format($mPeriodeDate[0], 'Y/m/d'); 
?>
<br />
<div class="row-fluid">
	<div class="span12"></div>
	<div class="span6">
		<div class="control-group">
			<div class="span2">
				Period from 
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'bgn_period',array('id'=>'fromDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span12','required'=>true)); ?>
			</div>			
			<div class="span1">
				to 
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'end_period',array('id'=>'toDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span12','required'=>true)); ?>
			</div>			
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<div class="span2">
				Posting Date 
			</div>
			<div class="span3">
				<?php echo $form->textField($model,'post_dt',array('id'=>'postDt','placeholder'=>'dd/mm/yyyy','class'=>'tdate span12','required'=>true)); ?>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
			<div class="span2">
				<label><?php echo $form->label($model,'Show',array('class'=>'control-label')) ?></label>
			</div>
			<div class="span2">
				<input type="radio" id="opt" name="Rptinterestrecon[opt]" value="ALL" <?php echo $model->opt=='ALL'?'checked':'' ?>/> &nbsp; All
			</div>
			<div class="span2">
				<input type="radio" id="opt_mt3" name="Rptinterestrecon[opt]" value="DIFF" <?php echo $model->opt=='DIFF'?'checked':'' ?>/> &nbsp; Difference
			</div>
		</div>
	</div>
	<div class="span6">
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
		updateDate();
		getPostdate();
		//getClient();
	}
	
	$('#fromDt').change(function(){
		updateDate();
		getPostdate();
	    //alert('dd');
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
	
	function getPostdate(){
		var fromDt = $('#fromDt').val();
		$.ajax({
		    		'type'     :'POST',
		    		'url'      : '<?php echo $this->createUrl('getpostdate'); ?>',
					'dataType' : 'json',
					'data'		:{	
									fromdt : fromDt,
								},
					'success': function(result)
								{
									$("#postDt").val(result.post_dt);
								}
					,
					'async':false
				});
	}
	
	// $('.opt').click(function(){
		// optDefault();
	// })
// 	
	// function optDefault()
	// {	
		// if($('#default,#notDefault').is(':checked')){
			// $('#toDt').attr('disabled',true);
			// $('#opt_mt1').attr('disabled',true);
			// $('#opt_mt2').attr('disabled',true);
			// $('#opt_mt3').attr('disabled',true);
			// $('#opt_mt4').attr('disabled',true);
			// $('#opt_sts1').attr('disabled',true);
			// $('#opt_sts2').attr('disabled',true);
			// $('#clt1').attr('disabled',true);
			// $('#clt2').attr('disabled',true);
			// $('#brch1').attr('disabled',true);
			// $('#brch2').attr('disabled',true);
		// }else{
			// $('#toDt').attr('disabled',false);
			// $('#opt_mt1').attr('disabled',false);
			// $('#opt_mt2').attr('disabled',false);
			// $('#opt_mt3').attr('disabled',false);
			// $('#opt_mt4').attr('disabled',false);
			// $('#opt_sts1').attr('disabled',false);
			// $('#opt_sts2').attr('disabled',false);
			// $('#clt1').attr('disabled',false);
			// $('#clt2').attr('disabled',false);
			// $('#brch1').attr('disabled',false);
			// $('#brch2').attr('disabled',false);
		// }		
	// }
// 	
	// $('#clt1').click(function(){
		// optionclient_CD();
	// })
// 	
	// function optionclient_CD()
	// {	
// 		
		// var client_CD=$('input:checkbox[name="Rptlistofinterestrates[opt_clt]"]:checked').val();
		// var isclient_CD=(client_CD==='1');
		// $('#clt2').attr('disabled',isclient_CD);
// 			
	// }
// 	
	// $('#brch1').click(function(){
		// optionbranch_CD();
	// })
// 	
	// function optionbranch_CD()
	// {	
// 		
		// var branch_CD=$('input:checkbox[name="Rptlistofinterestrates[opt_branch]"]:checked').val();
		// var isbranch_CD=(branch_CD==='1');
		// $('#brch2').attr('disabled',isbranch_CD);
// 			
	// }

	// function getClient()
	// {
		// var result = [];
		// $('#clt2').autocomplete(
		// {
			// source: function (request, response) 
			// {
		        // $.ajax({
		        	// 'type'		: 'POST',
		        	// 'url'		: '<?php //echo $this->createUrl('getclient'); ?>',
		        	// 'dataType' 	: 'json',
		        	// 'data'		:	{
		        						// 'term': request.term,
// 		        						
		        					// },
		        	// 'success'	: 	function (data) 
		        					// {
				           				 // response(data);
				           				 // result = data;
				    				// }
				// });
		    // },
		    // change: function(event,ui)
	        // {
	        	// $(this).val($(this).val().toUpperCase());
	        	// if (ui.item==null)
	            // {
	            	// // Only accept value that matches the items in the autocomplete list
// 	            	
	            	// var inputVal = $(this).val();
	            	// var match = false;
// 	            	
	            	// $.each(result,function()
	            	// {
	            		// if(this.value.toUpperCase() == inputVal)
	            		// {
	            			// match = true;
	            			// return false;
	            		// }
	            	// });
// 	            	
	            // }
	        // },
		    // minLength: 1,
		     // open: function() { 
			        // $(this).autocomplete("widget").width(400);
			    // } 
		// });
	// }
</script>
