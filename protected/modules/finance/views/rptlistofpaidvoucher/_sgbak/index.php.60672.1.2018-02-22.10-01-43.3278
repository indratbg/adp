<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'List of Paid Voucher' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'List of Paid Voucher',
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
	<div class="span6">
		
		<div class="control-group">
			<div class="span3">
				<label>Date From</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'bgn_date', array(
					'class' => 'span10 tdate',
					'placeholder' => 'dd/mm/yyyy'
				));
				?>
			</div>
			<div class="span1">
				<label>To</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'end_date', array(
					'class' => 'span10 tdate',
					'placeholder' => 'dd/mm/yyyy'
				));
				?>
			</div>
		</div>
		<div class="control-group">
			
			<div class="offset3 span3">
				<?php //echo $form->radioButton($model, 'vch_type', array('value' => '0')) . "&nbsp All"; ?>
				<input type="radio" name="Rptlistofpaidvoucher[type]" value="0" <?php echo $model->type=='0'?'checked':'' ?>/> &nbsp; Invoice
			</div>
			<div class="span3">
				 <?php //echo $form->radioButton($model, 'vch_type', array('value' => '1')) . "&nbsp Payment Vch"; ?>
				<input type="radio" name="Rptlistofpaidvoucher[type]" value="1" <?php echo $model->type=='1'?'checked':'' ?>/> &nbsp; Voucher
			</div>
			
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Voucher Type</label>
			</div>
			<div class="span3">
				<?php //echo $form->radioButton($model, 'vch_type', array('value' => '0')) . "&nbsp All"; ?>
				<input type="radio" name="Rptlistofpaidvoucher[vch_type]" value="0" <?php echo $model->vch_type=='0'?'checked':'' ?>/> &nbsp; All
			</div>
			<div class="span3">
				 <?php //echo $form->radioButton($model, 'vch_type', array('value' => '1')) . "&nbsp Payment Vch"; ?>
				<input type="radio" name="Rptlistofpaidvoucher[vch_type]" value="1" <?php echo $model->vch_type=='1'?'checked':'' ?>/> &nbsp; Payment Vch
			</div>
			<div class="span3">
				<?php //echo $form->radioButton($model, 'vch_type', array('value' => '2')) . "&nbsp Receipt Vch"; ?>
				<input type="radio" name="Rptlistofpaidvoucher[vch_type]" value="2" <?php echo $model->vch_type=='2'?'checked':'' ?>/> &nbsp; Receipt Vch
			</div>
		</div>
	<div class="control-group">
			<div class="span5">

				<?php $this->widget('bootstrap.widgets.TbButton', array(
						'label' => 'OK',
						'type' => 'primary',
						'id' => 'btnPrint',
						'buttonType' => 'submit',
					));
				 ?>
			</div>
		</div>
	</div>
	<div class="span6">
			<div class="control-group">
			<div class="span3">
				<label>Voucher Ref</label>
			</div>
			<div class="span5">
				<?php echo $form->textField($model, 'vch_ref', array(
					'class' => 'span7',
				));
				?>
			</div>
		</div>
		<div class="control-group">
			<div class="span3">
				<label>Client Code</label>
			</div>
			<div class="span5">
				<?php echo $form->textField($model, 'client_cd', array(
					'class' => 'span7',
				));
				?>
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
		getClient();
	}

    function getClient()
    {
        var result = [];
        $('#Rptlistofpaidvoucher_client_cd').autocomplete(
        {
            source: function (request, response) 
            {
                $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo Yii::app()->createUrl('share/sharesql/getclient'); ?>',
                    'dataType'  : 'json',
                    'data'      :   {
                                        'term': request.term,
                                        
                                    },
                    'success'   :   function (data) 
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
            minLength: 0,
             open: function() { 
                    $(this).autocomplete("widget").width(400);
                     $(this).autocomplete("widget").css('overflow-y','scroll');
                     $(this).autocomplete("widget").css('max-height','250px');
                     $(this).autocomplete("widget").css('font-family','courier');
                } 
        }).focus(function(){     
            $(this).data("autocomplete").search($(this).val());
        });
    }
	$('#Rptlistofpaidvoucher_bgn_date').change(function(){
		$('#Rptlistofpaidvoucher_end_date').val($('#Rptlistofpaidvoucher_bgn_date').val());
		$('.tdate').datepicker('update');
	})
</script>
