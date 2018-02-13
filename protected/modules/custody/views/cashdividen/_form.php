<style>
    #Type > label {
        width: 100px;
        margin-left: -12px;
    }

    #Type > label > label {
        float: left;
        margin-top: 5px;
        margin-left: -10px;
    }

    #Type > label > input {
        float: left;
    }
</style>
<?php
$this->breadcrumbs = array(
    'Dividen Report'=> array('index'),
    'List',
);

$this->menu = array(
    array(
        'label'=>'Dividen Report',
        'itemOptions'=> array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
    ),
    //	array('label'=>'Approval','url'=>Yii::app()->request->baseUrl.'?r=inbox/tcorpact/index','icon'=>'list','itemOptions'=>array('style'=>'float:right')),
    array(
        'label'=>'List',
        'url'=> array('index'),
        'icon'=>'list',
        'itemOptions'=> array(
            'class'=>'active',
            'style'=>'float:right'
        )
    ),
);
?>
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'Tcorpact-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal'
    ));
 ?>
<br/>
<?php echo $form->errorSummary(array(
        $model,
        $modelreport
    ));
    
    
    $branch_cd = Branch::model()->findAll(array(
            'select' => "brch_cd, brch_cd ||' - '|| brch_name as brch_name",
            'condition' => "approved_stat='A' ",
            'order' => 'brch_cd'
        ));
 ?>
<div class="row-fluid">
	<div class="span1">
		<label>Stock</label>
	</div>
	<div class="span2">
    <?php echo $form->textField($model,'stk_cd',array('class'=>'span7','onkeyup'=>'getStock(this)','placeholder'=>'TLKM'));?>
	</div>
	<div class="span4">
		<?php	echo CHtml::button('View List', array(
            'submit'=> array('Cashdividen/index'),
            //'confirm' => 'Are you sure?'
            // or you can use 'params'=>array('id'=>$id)

            'class'=>'btn btn-small btn-primary'
        ));
		?>
	</div>

</div>

<div class="row-fluid">
	<div class="span6">
		<b>
		<legend>
			Dividen TUNAI
		</legend></b>
		<div class="row-fluid">
			<div class="span6">
				<label>Recording date</label>
			</div>
			<div class="span6">
				<label>Payment date</label>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6">
				<?php echo $form->datePickerRow($model, 'recording_dt', array(
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'placeholder'=>'dd/mm/yyyy',
                    'class'=>'tdate span8',
                    'options'=> array('format'=>'dd/mm/yyyy'),
                    'label'=>false
                ));
				?>
			</div>
			<div class="span6" style="margin-left: 0px">
				<?php echo $form->datePickerRow($model, 'distrib_dt', array(
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'placeholder'=>'dd/mm/yyyy',
                    'class'=>'tdate span8',
                    'options'=> array('format'=>'dd/mm/yyyy'),
                    'label'=>false
                ));
				?>
			</div>
		</div>
		<div class="row-fluid control-group">
			<div class="span1">
				<label>Rate</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'rate', array(
                    'class'=>'span',
                    'style'=>'margin-left:18px;text-align:right'
                ));
            ?>
				<?php echo $form->textField($model, 'cum_dt', array(
                        'class'=>'span',
                        'style'=>'display:none;'
                    ));
                ?>
			</div>
			<div class="span8">

			</div>
		</div>

		<b>
		<legend>
			Dividen Saham
		</legend></b>
		<div class="row-fluid control-group">
			<div class="span3">
				<label>Tiap</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'from_qty', array(
                    'class'=>'span',
                    'style'=>'text-align:right'
                ));
            ?>
			</div>
			<div class="span1">
				<label>Lembar</label>
			</div>
		</div>
		<div class="row-fluid control-group">
			<div class="span3">
				<label>Mendapat</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'to_qty', array(
                    'class'=>'span',
                    'style'=>'text-align:right'
                ));
            ?>
			</div>
			<div class="span1">
				<label>Lembar</label>
			</div>
		</div>
		<div class="row-fluid control-group">
			<div class="span3">
				<label>Price</label>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'price', array(
                    'class'=>'span',
                    'style'=>'text-align:right'
                ));
            ?>
			</div>
			<div class="span1">
				<label>Lembar</label>
			</div>
		</div>

	</div>
	<div class="span6">
	    
		<b><legend>Branch</legend></b>
        <div class="control-group">
            <div class="span2">
                <label>Branch</label>
            </div>
            <div class="span2">
                <?php echo $form->radioButton($model,'branch',array('value'=>'0','id'=>'Tcorpact_branch_0','class'=>'option_branch'))?>&nbsp;All
            </div>
            <div class="span2">
                <?php echo $form->radioButton($model,'branch',array('value'=>'1','id'=>'Tcorpact_branch_1','class'=>'option_branch'))?>&nbsp;Specified
            </div>
            <div class="span3">
                    <?php echo $form->dropDownList($model, 'dropdown_branch', CHtml::listData($branch_cd, 'brch_cd', 'brch_name'), array('class'=>'span10', 'prompt'=>'-Select-','style'=>'font-family:courier')); ?>
            </div>
        </div>
        
		<b><legend>Client</legend></b>
		<div class="control-group">
			<div class="span2">
				<label>Client</label>
			</div>
			<div class="span2">
				<?php echo $form->radioButton($model,'client_cd',array('value'=>'0','id'=>'Tcorpact_client_cd_0','class'=>'option_client'))?>&nbsp;All
			</div>
			<div class="span2">
				<?php echo $form->radioButton($model,'client_cd',array('value'=>'1','id'=>'Tcorpact_client_cd_1','class'=>'option_client'))?>&nbsp;Specified
			</div>
			<div class="span3">
                <?php echo $form->textField($model,'dropdown_client',array('class'=>'span10'))?>
            </div>
		</div>
		<input type="hidden" name="savePilih"/>

	</div>
</div>
<br/>
<div class="row-fluid control-group">
	<div class="span6">

	</div>

	<div class="span1">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'htmlOptions'=> array(
                'id'=>'btnOk',
                'class'=>'btn btn-primary',
                'style'=>'width:100px;'
            ),
            'label'=>'Ok',
            //'url'=>Yii::app()->request->baseUrl.'?r=custody/Cashdividen/report'
        ));
 ?>
	</div>

</div>

<?php $this->endWidget(); ?>

<script>
	init();
	function init()
	{
		
        getClient();
        option_client();
        option_branch();
	}


	$('#btnReset').click(function()
	{

		$('#Tcorpact_stk_cd').val("");
		$('#Tcorpact_recording_dt').val('');
		$('#Tcorpact_distrib_dt').val('');
		$('#Tcorpact_fee').val('');
		$('#Tcorpact_from_qty').val('');
		$('#Tcorpact_to_qty').val('');
		$('#Tcorpact_price').val('');
		$('#Tcorpact_rate').val('');
	})

	$('.option_client').change(function()
	{
		option_client();
	})
	$('.option_branch').change(function(){
	    option_branch();
	})
	
	function option_client()
	{
	    if ($('#Tcorpact_client_cd_0').is(':checked'))
        {
            $('#Tcorpact_dropdown_client').attr('disabled', true);
        }
        else
        {
            $('#Tcorpact_dropdown_client').attr('disabled', false);
        }
	}
	function option_branch()
	{
	    if ($('#Tcorpact_branch_0').is(':checked'))
        {
            $('#Tcorpact_dropdown_branch').attr('disabled', true);
        }
        else
        {
            $('#Tcorpact_dropdown_branch').attr('disabled', false);
        }
	}
	
	function getClient()
    {
        var result = [];
        $('#Tcorpact_dropdown_client').autocomplete(
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

function getStock(obj)
{ 
        var result = [];
        $(obj).autocomplete(
        {
            source: function (request, response) 
            {
                $.ajax({
                    'type'      : 'POST',
                    'url'       : '<?php echo Yii::app()->createUrl('share/sharesql/getstock'); ?>',
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
                     if(!match)
                    {
                        $(this).val('');
                    }
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
</script>