<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <title>查询数据结果</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="plugin/jquery-1.12.1.min.js"></script>
        <script src="plugin/jquery.dataTables.js"></script>
        <script src="plugin/DataTables/Buttons-1.1.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
        <script src="plugin/DataTables/Buttons-1.1.2/js/buttons.flash.min.js" type="text/javascript"></script> 
        <script src="plugin/DataTables/Buttons-1.1.2/js/buttons.html5.min.js" type="text/javascript"></script>
        <!--<script src="plugin/DataTables/Buttons-1.1.2/js/buttons.print.min.js" type="text/javascript"></script>-->
        <script src="plugin/DataTables/JSZip-2.5.0/jszip.min.js" type="text/javascript"></script>
<!--        <script src="plugin/DataTables/pdfmake-0.1.18/build/pdfmake.min.js" type="text/javascript"></script>
        <script src="plugin/DataTables/pdfmake-0.1.18/build/vfs_fonts.js" type="text/javascript"></script>
-->        
        <link rel="stylesheet" href="plugin/bootstrap.css">
        <link rel="stylesheet" href="plugin/bootstrap-theme.css">
        <link rel="stylesheet" href="plugin/jquery.dataTables.css">
        <link href="plugin/DataTables/Buttons-1.1.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="col-sm-2"></div>
        <div class="col-sm-8 ">
            <h2 style="text-align: center">查询结果表</h2>
            <hr/>
        <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>电话号码</th>
                <th>状态</th>
                <th>拨号时间</th>
                <th>通话时长</th>
                <th>按键</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>电话号码</th>
                <th>状态</th>
                <th>拨号时间</th>
                <th>通话时长</th>
                <th>按键</th>
            </tr>
        </tfoot>
    </table>
            </div>
        <div class="col-sm-2"></div>
        <script>
            var $aa='#example';
    $(document).ready(function() {
    $($aa).DataTable( {
        "autoWidth":false,
        "lengthMenu": [[10, 30, 50, 1000], [10, 30, 50, 1000]],
        "processing": true,
        "serverSide": <?php if ($searchid==2){echo 'true';}else if ($searchid==3){echo 'false';} ?>,
        "ajax": "<?php if ($searchid==2){echo 'server_processing2.php';}else if ($searchid==3){echo 'server_processing3.php';} ?>",
         "columns": [
            { "data": 0 },
            { "data": 1 },
            { "data": 2 },
            { "data": 3 },
            { "data": 4 }
        ],
        "deferRender": true,
        "dom": 'B<"clear">lfrtip',
        "buttons": [
            'copy', 'excel'
        ],
         language: {
        "sProcessing": "处理中...",
        "sLengthMenu": "显示 _MENU_ 项结果",
        "sZeroRecords": "没有匹配结果",
        "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
        "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
        "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
        "sInfoPostFix": "",
        "sSearch": "搜索:",
        "sUrl": "",
        "sEmptyTable": "表中数据为空",
        "sLoadingRecords": "载入中...",
        "sInfoThousands": ",",
        "oPaginate": {
            "sFirst": "首页",
            "sPrevious": "上页",
            "sNext": "下页",
            "sLast": "末页"
        },
        "oAria": {
            "sSortAscending": ": 以升序排列此列",
            "sSortDescending": ": 以降序排列此列"
        }
    }
    } );
    
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input style="width: 100%;padding: 3px;box-sizing: border-box;" type="text" placeholder="查询 '+title+'" />' );
    } );
    // DataTable
    var table = $('#example').DataTable();
    
    table.columns([2]).order('desc').draw();
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
        } );
} );
</script>
    </body>
</html>
