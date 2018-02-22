<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'Profit Loss Recapitulation' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Profit Loss Recapitulation',
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
		'id' => 'profitlossrecap-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));
?>
<br />
<?php AHelper::AjaxFlash();?>
<?php echo $form->errorSummary(array($model)); ?>
<input type="hidden" name="scenario" id="scenario" />
<?php echo $form->textField($model,'vo_random_value',array('style'=>'display:none'));?>
<?php echo $form->textField($model,'vp_userid',array('style'=>'display:none'));?>
<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<div class="span3">
				<label>For the month of</label>
			</div>
			<div class="span3">
				<?php echo $form->dropDownList($model, 'month', AConstant::getArrayMonth(), array(
					'class' => 'span9',
					'prompt' => '-Select-'
				));
				?>
			</div>
			<div class="span1">
				<label>Year</label>
			</div>
			<div class="spa2">
				<?php echo $form->textField($model, 'year', array('class' => 'span2')); ?>
			</div>

		</div>

	</div>
	<div class="span6">
		<div class="control-group">
			<div class="span5">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'submit',
					'type' => 'primary',
					'label' => 'Show',
					'id' => 'btnPrint'
				));
 				?>
 				&emsp;
 					<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'submit',
					'type' => 'primary',
					'label' => 'Save to Excel',
					'id' => 'btn_xls'
				));
 				?>
				
			</div>
		</div>
	</div>
</div>
<br />
<iframe id="iframe" src="<?php echo $url; ?>" class="span12" style="min-height:600px"></iframe>

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
		$('#btn_xls').attr('disabled',true);
		$("#iframe").offset({left:2});
        $("#iframe").css('width',($(window).width()));
	}
	$(window).resize(function()
    {
        $("#iframe").offset({left:2});
        $("#iframe").css('width',($(window).width()));
    });
	$('#btnPrint').click(function(e){
		e.preventDefault();
		$('.error_msg').empty();
		$('#mywaitdialog').dialog('open');
		$('#scenario').val('print');
		submitData();
	});
	$('#btn_xls').click(function(){
		
		$('#scenario').val('export');
		
	});

	function submitData()
	{

		$.ajax({
			'type'      : 'POST',
			'url'       : '<?php echo $this->createUrl('index'); ?>',
			'dataType'  : 'json',
			'data'      : $('#profitlossrecap-form').serialize(),
			'success'   :   function (data) 
			{
				
				if(data.status='success')
				{
					if(!data.error_msg)
					{
						$('#Rptprofitlossrecap_vo_random_value').val(data.vo_random_value);
						$('#Rptprofitlossrecap_vp_userid').val(data.vp_userid);
						$('#iframe').show();
						$("#iframe").attr("src", data.url);
						
						$("#iframe").load(function(){
						$('#mywaitdialog').dialog('close');	
						});
						
						$('#btn_xls').attr('disabled',false);
					}
					else
					{
						$('#mywaitdialog').dialog('close');
						AjaxFlash('danger', data.error_msg)
					}
				}

			}
		});
	}
</script>
