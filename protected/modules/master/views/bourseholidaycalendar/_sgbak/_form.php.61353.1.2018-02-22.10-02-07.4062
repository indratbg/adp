
<div class="row-fluid">
	<div class="span5">
		<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'bourseholidaycalendar-form',
			'enableAjaxValidation'=>false,
			'type'=>'horizontal'
		)); ?>
		
			<p class="help-block">Fields with <span class="required">*</span> are required.</p>
			
			<?php echo $form->errorSummary($model); ?>
		
			<?php echo $form->textFieldRow($model,'tgl_libur',array('class'=>'span6 tdate','maxlength'=>40,'readonly'=>'readonly','id'=>'txttgllibur')); ?>
			
			<?php echo $form->textAreaRow($model,'ket_libur',array('class'=>'span6','maxlength'=>40)); ?>
		
			<div class="form-actions">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>$model->isNewRecord ? 'Create' : 'Save',
				)); ?>
			</div>
		
		<?php $this->endWidget(); ?>
	</div>
	<div class="span7">
		<div id="datepicker"></div>
	</div>
</div>
<script>
  $(document).ready(function() {

	var highlightedDays = <?php echo $listLiburJson; ?>;
	
	
	function highlightDays(date) 
	{
		var m = ((date.getMonth()+1) < 10)?'0'+(date.getMonth()+1):(date.getMonth()+1), 
			d = (date.getDate() < 10)?'0'+date.getDate():date.getDate(), 
			y = date.getFullYear();
	
		//console.log('Checking (raw): ' + m + '-' + d + '-' + y);
		for (i = 0; i < highlightDays.length; i++) {		
			if($.inArray(d + '-' + m + '-' + y,highlightedDays) != -1) 
				return [true, 'highlight'];
			
		}
		//console.log('good:  ' + (m+1) + '-' + d + '-' + y);
		
		<?php if($model->isNewRecord):?>
				return [true];
		<?php else:?>
				return [false];
		<?php endif;?>
	}
	
	
	
	function noWeekendsOrHolidays(date) 
	{
		var noWeekend = jQuery.datepicker.noWeekends(date);
		var temp 	  =  noWeekend[0] ?  highlightDays(date) : noWeekend;
		return temp; 
	}

  	
    $( "#datepicker" ).datepicker({
  	 	changeMonth: true,
      	changeYear: true,
      	dateFormat: 'dd/mm/yy',
      	beforeShowDay: noWeekendsOrHolidays,
      	onSelect: function(dateText,inst) {
      		
      		var isupd       =  false;
      		var dateTextArr = dateText.split("/"); 
      		var tglupd      = null;
      		
      		for (i = 0; i < highlightDays.length; i++) {
      			tglupd = dateTextArr[0] + '-' + dateTextArr[1] + '-' + dateTextArr[2];
				if($.inArray(tglupd,highlightedDays) != -1){ 
					isupd  = true;
					tglupd = dateTextArr[2] + '-' + dateTextArr[1] + '-' + dateTextArr[0]; 
				}
			}
			
			if(!isupd)
				$('#txttgllibur').val(dateText);
			else
				location.href = '<?php echo $this->createUrl('update')?>/id/'+tglupd;
  		}
    });
    
    <?php 
    	if(!empty($model->tgl_libur)):
			$tempArr  = explode('-', $model->tgl_libur); 
    		$year     = $tempArr[0]; 
    		$month    = intval($tempArr[1]);
			$month    = $month - 1;
			$month	  = ($month < 10)?'0'.$month:$month;
    		$days     = $tempArr[2];
    ?>
    	$('#datepicker').datepicker("setDate", new Date(<?php echo $year ?>,<?php echo $month; ?>,<?php echo $days; ?>) );
    <?php endif; ?>
  });
</script>