<style>
      #tableCash {
        background-color: #C3D9FF;
    }
    #tableCash thead, #tableCash tbody {
        display: block;
    }
    #tableCash tbody {
        max-height: 300px;
        overflow: auto;
        background-color: #FFFFFF;
    }
</style>
<?php
$this->breadcrumbs = array(
    'CBEST Interface to Transfer Cash Dividen'=> array('index'),
    'List',
);

$this->menu = array(
    array(
        'label'=>'CBEST Interface to Transfer Cash Dividen',
        'itemOptions'=> array('style'=>'font-size:30px;font-weight:bold;color:black;margin-left:-17px;margin-top:8px;')
    ),
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

<?php AHelper::showFlash($this) ?>
<!-- show flash -->
<?php AHelper::applyFormatting() ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'Generateexcelforctp-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal'
    ));
 ?>

<?php echo $form->errorSummary(array($model));
    foreach ($modelDetail as $row)
        echo $form->errorSummary(array($row));
?>
<br/>

<input type="hidden" name="scenario" id="scenario" />
<input type="hidden" name="rowCount" id="rowCount" />

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<div class="span8">
				<?php echo $form->datePickerRow($model, 'distrib_dt', array(
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'placeholder'=>'dd/mm/yyyy',
                    'class'=>'tdate span7',
                    'options'=> array('format'=>'dd/mm/yyyy')
                ));
				?>
			</div>
			<div class="span4">
			     <?php $this->widget('bootstrap.widgets.TbButton', array(
                            'id'=>'btnFilter',
                            'buttonType'=>'submit',
                            'type'=>'primary',
                            'label'=>'Retrieve'
                        )); ?>
         &emsp;
        <?php $this->widget('bootstrap.widgets.TbButton', array(
                'id'=>'btnProcess',
                'buttonType'=>'submit',
                'type'=>'primary',
                'label'=>'Process'
            )); ?>
			</div>
       
		</div>
	</div>
	
</div>

<br />

<table id="tableCash" class="table-bordered table-condensed" style="width: 25%">
    <thead>
            <th width="100px"> Stock</th>
            <th width="200px" style="text-align: right"> Amount</th>
    </thead>
    <tbody>
        <?php $x = 1;
        foreach($modelDetail as $row){
        ?>
        <tr id="row<?php echo $x ?>" >
            <td > <?php echo $form->textField($row, 'stk_cd',array('class'=>'span12')) ?> 
                </td>
            <td>
            <?php echo $form->textField($row,'div_amt',array('class'=>'span12 tnumberdec','style'=>'text-align:right')) ?>
            </td>
            
        </tr>
        <?php $x++;
    }
        ?>
    </tbody>
</table>

<?php $this->endWidget();?>
<script>

    var rowCount =  '<?php echo count($modelDetail); ?>';
	
	
	if(rowCount==0)
	{
	    $('#tableCash').hide();
	}
	
	$(window).resize(function() {
	  adjustWidth();
	})
	$(window).trigger('resize');

	function adjustWidth()
	{
    	var header = $("#tableCash").find('thead');
    	var firstRow = $("#tableCash").find('tbody tr:eq(0)');
    
    	firstRow.find('td:eq(0)').css('width',header.find('th:eq(0)').width() + 'px');
    	firstRow.find('td:eq(1)').css('width',(header.find('th:eq(1)').width())-17 + 'px');
	}

	$('#btnFilter').click(function(){
	   $('#scenario').val('retrieve');
	})
	$('#btnProcess').click(function(){
	   $('#scenario').val('process');
	   $('#rowCount').val(rowCount);
	})
	
</script>
