<style>
    #tableInterest
    {
        background-color:#C3D9FF;
    }
    #tableInterest thead, #tableInterest tbody
    {
        display:block;
    }
    #tableInterest tbody
    {
        max-height:300px;
        overflow:auto;
        background-color:#FFFFFF;
    }
</style>

<table id='tableInterest' class="table-bordered table-condensed" style="width: 75%">
    <thead>
        <tr>
            <th colspan="3"></th>
            <th colspan="2" style="text-align: center">Interest Rate</th>
        </tr>
        <tr>
        <th width="100px"> </th>
        <th width="100px"> </th>
        <th width="250px"> Client</th>
        <th width="50px"> AR</th>
        <th width="50px"> AP</th>
        <th width="150px"> Amount</th>
        <th width="100px"> Status</th>
        </tr>
    </thead>
    <tbody>
        
    <?php $x = 1;
        foreach($modelDetail as $row){?>
            <tr id="row<?php echo $x ?>">
            <td>
                <?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'Postingintselected['.$x.'][client_cd]','readonly'=>'readonly'));?>
            </td>
            <td >
                <?php echo $form->textField($row,'old_ic_num',array('class'=>'span','name'=>'Postingintselected['.$x.'][old_ic_num]','readonly'=>'readonly'));?>
            </td>
            <td >
                <?php echo $form->textField($row,'client_name',array('class'=>'span','name'=>'Postingintselected['.$x.'][client_name]','readonly'=>'readonly'));?>
            </td>
            <td>
               <?php echo $form->textField($row,'int_on_receivable',array('class'=>'span','name'=>'Postingintselected['.$x.'][int_on_receivable]','readonly'=>'readonly','style'=>'text-align:right'));?> 
            </td>
            <td>
                <?php echo $form->textField($row,'int_on_payable',array('class'=>'span','name'=>'Postingintselected['.$x.'][int_on_payable]','readonly'=>'readonly','style'=>'text-align:right')); ?>
            </td>
             <td>
                <?php echo $form->textField($row,'amt',array('class'=>'span tnumber','name'=>'Postingintselected['.$x.'][receive_on_payable]','readonly'=>'readonly','style'=>'text-align:right')); ?>
            </td>
            <td>
                <?php echo $form->dropDownList($row,'jurnal_sts',array('Y'=>'Sudah dijurnal','A'=>'Akan dijurnal','N'=>'N'),array('name'=>'Postingintselected['.$x.'][jurnal_sts]','onchange'=>'updateJurnalSts('.$x.')','class'=>'span','disabled'=>$row->jurnal_sts=='Y'?'disabled':'','prompt'=>'-Choose-','required'=>'required'));?>
            </td>
        </tr>
    <?php $x++;
} ?>
    </tbody>
</table>

<div class="row-fluid">
    <div class="span3">
        <pre>Total : <?php echo count($modelDetail).' client(s)';?></pre>
    </div>    
</div>

<script>

    $(window).resize(function () {
        alignColumn();
    });
    $(window).trigger('resize');

    function alignColumn()//align columns in thead and tbody
    {
        var header = $("#tableInterest").find('thead tr:eq(1)');
        var firstRow = $("#tableInterest").find('tbody tr:eq(0)');

        firstRow.find('td:eq(0)').css('width', header.find('th:eq(0)').width() + 'px');
        firstRow.find('td:eq(1)').css('width', header.find('th:eq(1)').width() + 'px');
        firstRow.find('td:eq(2)').css('width', header.find('th:eq(2)').width() + 'px');
        firstRow.find('td:eq(3)').css('width', header.find('th:eq(3)').width() + 'px');
        firstRow.find('td:eq(4)').css('width', header.find('th:eq(4)').width() + 'px');
        firstRow.find('td:eq(5)').css('width', header.find('th:eq(5)').width() + 'px');
        firstRow.find('td:eq(6)').css('width', (header.find('th:eq(6)').width()) - 17 + 'px');

    }
     function updateJurnalSts(num)
    {
        var jurnal_sts= $('#Postingintselected_'+num+'_jurnal_sts').val();
        $('#successMessage').hide();
        if(jurnal_sts)
        {
        $.ajax({
                        'type'     :'POST',
                        'url'      : '<?php echo $this->createUrl('updateJurnalSts'); ?>',
                        'dataType' : 'json',
                        'data'      :{   int_dt_from :$('#Postingintselected_int_dt_from').val(),
                                         int_dt_to : $('#Postingintselected_int_dt_to').val(),
                                         jurnal_sts : $('#Postingintselected_'+num+'_jurnal_sts').val(),
                                         client_cd : $('#Postingintselected_'+num+'_client_cd').val(),
                                        },
                        'success': function(result)
                                    {
                                        if(result.status=='success')
                                        {
                                            $('#successMessage').show();
                                        }
                                  
                                    },
                        'async':false
                    });
         }
         else
         {
             alert('Status harus dipilih');
         }           
    }
       
</script>