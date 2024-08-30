<?php
class SQLiteDB {
    private $db;

    public function __construct($db_file) {
        try {
            $this->db = new SQLite3($db_file);
        } catch (Exception $e) {
            die('Veritabanına bağlanırken hata oluştu: ' . $e->getMessage());
        }
    }

    public function query($sql) {
        $result = $this->db->query($sql);
        if (!$result) {
            die('Sorgu hatası: ' . $this->db->lastErrorMsg());
        }
        return $result;
    }

    public function exec($sql) {
        $result = $this->db->exec($sql);
        if (!$result) {
            die('Sorgu hatası: ' . $this->db->lastErrorMsg());
        }
        return $result;
    }

    public function close() {
        $this->db->close();
    }
}
class db extends SQLite3
{
    function __construct($path)
    {
        $this->open($path);
    }
}
function sqlsingle($db, $sql)
{
    $results = $db->prepare($sql);
    $res = $results->execute();
    $row = $res->fetchArray(SQLITE3_NUM);
    return $row;
}
function sqlssingle($db, $sql)
{
    $results = $db->prepare($sql);
    $res = $results->execute();
    $row = $res->fetchArray(SQLITE3_ASSOC);
    return $row;
}
function sqlmulti($db, $sql)
{
    $result = $db->query($sql);
    $results = $db->prepare($sql);
    $prepare = $results->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    //Create array to keep all results
    $data = array();

    // Fetch Associated Array (1 for SQLITE3_ASSOC)
    while ($res = $prepare->fetchArray(SQLITE3_ASSOC)) {
        //insert row into array
        array_push($data, $res);
    }
    return $data;
}
function sqlinsert($db, $sql)
{
    $db->exec($sql);
}
function sqldelete($db, $sql)
{
    $db->exec($sql);
}
function sqlupdate($db,$sql){
    $result = $db->prepare($sql);
    $result->execute();
   
}
$db = new db('mydatabase.db');
if (!empty($_POST['type'])) {
    if ($_POST['type'] == 'letter') {
        $w = (!(empty($_POST['w'])))?$_POST['w']: "p";
        
        if ($w != "p") {
            # code...
            $p = ($_POST['p'] == 'true')? 'sesli = "'.$w.'"':"sesli LIKE '{$w}%'";
            //echo $p . ' '. $_POST['p'] ;
            $sql = "SELECT * FROM kelime WHERE {$p} ORDER BY hece";
            $result = sqlmulti($db,$sql);
            
            if (is_array($result)) {
                $ex = "<div class='sticky-top bg-primary rounded text-lihgt p-2 m-2'>".strval(count($result))."kelime bulundu</div>";
                $ex .= '<ol class="list-group m-2 list-group-numbered" id="popo">';
                foreach ($result as $key => $value) {
                    //$ex .="<li>{$value['kelime']}</li>";
                    $ex .="<li class='list-group-item d-flex justify-content-between align-items-start'>
    <div class='ms-2 me-auto'>
      <div class='fw-bold'>{$value['kelime']}</div>
      {$value['anlam']}
    </div>
    <span class='badge bg-primary rounded-pill'>{$value['sesli']}</span>&nbsp;
    <span class='badge bg-primary rounded-pill'>{$value['hece']}</span>
  </li>";
                }
                $ex .="</ol>";
                echo $ex;
            } else {
                var_dump($result);
            }
            
        }
    }
}
?>