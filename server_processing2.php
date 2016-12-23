<?php

// DB table to use
$table = 'proc_num';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'telnum', 'dt' => 0 ),
    array( 'db' => 'call_status',  'dt' => 1 ),
    array( 'db' => 'call_time',   'dt' => 2 ),
    array(
        'db'        => 'call_duration', 'dt'        => 3),
    array(
        'db'        => 'click',
        'dt'        => 4));
 
// SQL server connection information
$sql_details = array(
    'user' => 'tel',
    'pass' => 'cj2894',
    'db'   => 'Tel',
    'host' => 'localhost'
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );



echo json_encode(
    // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
      
        SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, '', $whereAll)
);
