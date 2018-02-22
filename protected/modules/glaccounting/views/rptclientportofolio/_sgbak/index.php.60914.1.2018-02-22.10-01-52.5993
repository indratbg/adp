<style>
	input[type=radio] {
		margin-top: -3px;
	}
</style>
<?php
$this->breadcrumbs = array(
	'Client Portofolio' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'Client Portofolio',
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
			<div class="span12">
				<?php echo $form->datePickerRow($model, 'end_date', array(
					'prepend' => '<i class="icon-calendar"></i>',
					'placeholder' => 'dd/mm/yyyy',
					'class' => 'tdate span7',
					'options' => array('format' => 'dd/mm/yyyy')
				));
				?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->checkBoxRow($model, 'limit_flg', array('value' => 'Y','uncheckValue'=>'N')); ?>
		</div>

		<div class="control-group">

			<div class="control-group">
				<div class="span8">
					<?php echo $form->dropDownListRow($model, 'branch_cd', CHtml::listData(Branch::model()->findAll(array(
						'select' => "brch_cd, brch_cd||' - '||brch_name brch_name",
						'condition' => " approved_stat='A'",
						'order' => 'brch_cd'
					)), 'brch_cd', 'brch_name'), array(
						'class' => 'span6',
						'prompt' => '-ALL-',
						'style' => 'font-family:courier'
					));
					?>
				</div>
			</div>

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
			<div class="span8">
				<?php echo $form->textFieldRow($model, 'client_cd', array('class' => 'span5', )); ?>
			</div>
		</div>
		<div class="control-group">
				<div class="span8">
					<?php echo $form->dropDownListRow($model, 'rem_cd', CHtml::listData(Sales::model()->findAll(array(
						'select' => " rem_cd, rem_cd||' - '||rem_name rem_name ",
						'condition' => "approved_stat='A' ",
						'order' => 'rem_cd'
					)), 'rem_cd', 'rem_name'), array(
						'prompt' => '-ALL-',
						'class' => 'span5',
						'style' => 'font-family:courier'
					));
					?>
				</div>
			</div>
			<div class="control-group">
				<div class="span8">
					<?php echo $form->dropDownListRow($model, 'stk_cd', CHtml::listData(Counter::model()->findAll(array(
						'select' => "stk_cd,stk_cd||' - '||stk_desc as stk_desc",
						'condition' => "approved_stat='A'",
						'order' => 'stk_cd'
					)), 'stk_cd', 'stk_desc'), array(
						'class' => 'span5',
						'style' => 'font-family:courier;',
						'prompt' => '-ALL-'
					));
				?>
				</div>
			</div>

	</div>
</div>
<br />
<iframe src="<?php echo $url; ?>" class="span12" style="min-height:600px;max-width: 100%"></iframe>

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
        $('#Rptclientportofolio_client_cd').autocomplete(
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
        });;
    }

		$('#btnPrint').click(function(){
			$('#mywaitdialog').dialog('open');
		})
</script>
