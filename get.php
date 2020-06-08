<?php
define('DB_DSN',  'mysql:dbname=access;host=127.0.0.1');  // 接続先
define('DB_USER', 'senpai');    // MySQLのID
define('DB_PW',   'indocurry'); // MySQLのパスワード

$dbh  = connectDB(DB_DSN,DB_USER,DB_PW);

addCounter($dbh);

$count = getCounter($dbh);
header('Count-type: application/json');
echo json_encode([
    'status' => true
    ,'count' => $count
]);

function connectDB($dsn, $user, $pw){
    $dbh = new PDO($dsn, $user, $pw);  
    return($dbh);
}

function addCounter($dbh){
    // SQLを準備
    $sql = 'INSERT INTO access_log(accesstime) VALUES(now())';

    // 実行する
    $sth = $dbh->prepare($sql);   // SQLを解析
    $ret = $sth->execute();       // 実行

    return($ret);
}

function getCounter($dbh){
    $sql = 'SELECT count(*) as count FROM access_log';

    $sth = $dbh->prepare($sql);    
    $sth->execute();               
    
    $buff = $sth->fetch(PDO::FETCH_ASSOC);
    if( $buff === false){
        return(false);
    }
    else{
        return( $buff['count'] );
    }
}
