<?php
$this->breadcrumbs = array(
	'CBEST Interface for Fund Transfer to KSEI (BTS)' => array('index'),
	'List',
);

$this->menu = array(
	array(
		'label' => 'CBEST Interface for Fund Transfer to KSEI (BTS)',
		'itemOptions' => array('style' => 'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
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

<?php AHelper::showFlash($this)
?>
<!-- show flash -->
<?php AHelper::applyFormatting()
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id' => 'geninstructionforotcsectrvca-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal'
	));
?>
<?php echo $form->errorSummary($model); ?>
<?php
foreach ($modelDetail as $row)
	echo $form->errorSummary(array($row));
?>

<br/>
<input type="hidden" name="scenario" id="scenario"/>
<input type="hidden" name="rowCount" id="rowCount"/>
<?php echo $form->textField($model, 'reselect', array('style'=>'display:none')); ?>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
        	<div class="span2">
        		<label>Date</label>
        	</div>
            <div class="span4">
                  <?php echo $form->textField($model, 'doc_date', array('class' => 'span8 tdate')); ?>
            </div>
           
        </div>
         <div class="control-group">
            <div class="span2">
                <label>Client From</label>
            </div>
            <div class="span4">
                <?php echo $form->textField($model, 'bgn_client', array('class' => 'span8')); ?>
            </div>
            <div class="span1">
                <label>To</label>
            </div>
            <div class="span4">
                <?php echo $form->textField($model, 'end_client', array('class' => 'span8')); ?>
            </div>
        </div>
    </div>
    <div class="span6">
		<div class="control-group">
			
				 <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type' => 'primary',
			'label' => 'Retrieve',
			'id' => 'btnRetrieve',
			'htmlOptions' => array('class' => 'btn btn-small')
		));
        ?>
        &nbsp;
        <?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType' => 'submit',
				'type' => 'primary',
				'label' => 'Generate Xml',
				'id' => 'btnGenerate',
				'htmlOptions' => array('class' => 'btn btn-small')
			));
        ?>
        &nbsp;
        <?php $this->widget('bootstrap.widgets.TbButton', array(
				'buttonType' => 'submit',
				'type' => 'primary',
				'label' => 'Reselect',
				'id' => 'btnReselect',
				'htmlOptions' => array('class' => 'btn btn-small')
			));
        ?>
			
		</div>
    </div>

</div>

<br/>

<?php
if (count($modelDetail) > 0)
	echo $this->renderPartial('_list', array(
		'modelDetail' => $modelDetail,
		'cnt_detail'=>$cnt_detail,
		'form' => $form
	));
?>

<?php echo $form->datePickerRow($model,'dummy_date',array('label'=>false,'class'=>'span','style'=>'display:none'));?>
<?php $this->endWidget(); ?>

<script>
	
	var rowCount = 0;
	init();
	
	function init()
	{
		$('.tdate').datepicker({'format':'dd/mm/yyyy'});
		getClient();

	}
	
	$('#btnRetrieve').click(function(){
	$('#scenario').val('retrieve');
	$('#Genxmlfundtransfertoksei_reselect').val('N');
	});
	
	$('#btnGenerate').click(function(){
	$('#scenario').val('generate');
	$('#rowCount').val(rowCount);
	});
	
	$('#btnReselect').click(function(){
	$('#scenario').val('retrieve');
	$('#Genxmlfundtransfertoksei_reselect').val('Y');

	});

	
function getClient()
	{
		var result = [];
		$('#Genxmlfundtransfertoksei_bgn_client, #Genxmlfundtransfertoksei_end_client').autocomplete(
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
			        $(this).autocomplete("widget").width(500);
			    } 
		});
	}
	
	$('#Genxmlfundtransfertoksei_bgn_client').change(function(){
	
	$('#Genxmlfundtransfertoksei_end_client').val($('#Genxmlfundtransfertoksei_bgn_client').val());
	})	
</script>