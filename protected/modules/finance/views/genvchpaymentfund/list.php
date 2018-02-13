<style>
    #tableVoucher {
        background-color: #C3D9FF;
    }

    #tableVoucher thead, #tableVoucher tbody {
        display: block;
    }

    #tableVoucher tbody {
        max-height: 300px;
        overflow: auto;
        background-color: #FFFFFF;
    }

</style>


<table id="tableVoucher" class="table-bordered table-condensed" style="width:52%">
    <thead>
     <tr>
        <th width="90px">Client Code</th>
        <th width="300px">Client Name</th>
        <th width="130px" style="text-align: right">Payment</th>
        <th width="10px"><input type="checkbox" name="checkAll" id="checkAll" /></th>
    </tr>
    </thead>
    <tbody>

    <?php $x = 1;

    foreach ($modelDetail as $row) {   ?>

        <tr id="row<?php echo $x ?>">
            <td>
                <?php echo $form->textField($row, 'client_cd', array( 'name' => 'Genvchpaymentfund[' . $x . '][client_cd]', 'class' => 'span', 'readonly' => true)); ?>
                <?php echo $form->textField($row, 'branch_code', array('name' => 'Genvchpaymentfund[' . $x . '][branch_code]','style'=>'display:none')); ?>
            </td>
            <td>
                <?php echo $form->textField($row, 'client_name', array('name' => 'Genvchpaymentfund[' . $x . '][client_name]', 'class' => 'span', 'readonly' => true)); ?>
            </td>
            <td>
                <?php echo $form->textField($row, 't0', array('name' => 'Genvchpaymentfund[' . $x . '][t0]', 'class' => 'span tnumber','readonly' => true,'style'=>'text-align:right')); ?>
            </td>
            <td class="saveFlg">
                <?php echo $form->checkBox($row,'save_flg',array('class'=>'checkDetail','value' => 'Y','name'=>'Genvchpaymentfund['.$x.'][save_flg]','checked'=>true)); ?>
            </td>
        </tr>

        <?php $x++;

    } ?>
    </tbody>
</table>


<script>

    checkAll();
     $(window).resize(function () {
        alignColumn();
    })
    $(window).trigger('resize');

    function alignColumn()//align columns in thead and tbody
    {
        var header = $("#tableVoucher").find('thead tr');
        var firstRow = $("#tableVoucher").find('tbody tr:eq(0)');

        firstRow.find('td:eq(0)').css('width', header.find('th:eq(0)').width() + 'px');
        firstRow.find('td:eq(1)').css('width', header.find('th:eq(1)').width() + 'px');
        firstRow.find('td:eq(2)').css('width', header.find('th:eq(2)').width() + 'px');
        firstRow.find('td:eq(3)').css('width', (header.find('th:eq(3)').width()) - 17 + 'px');

    }
        $('#checkAll').change(function(){
        
        if($('#checkAll').is(':checked'))
        {
            $('.checkDetail').prop('checked',true)
        }
        else
        {
            $('.checkDetail').prop('checked',false)
        }
        
        
    })
    $('.checkDetail').change(function(){
       checkAll();
    })
    
    function checkAll()
    { 
         var sign='Y';
        $("#tableVoucher").children('tbody').children('tr').each(function()
        {
            var cek = $(this).children('td.saveFlg').children('[type=checkbox]').is(':checked');
            
            if(!cek){
                sign='N';
            }
        });
        if(sign=='N'){
            $('#checkAll').prop('checked',false)    
        }
        else{
            $('#checkAll').prop('checked',true)
        }
    }
</script>