<?php
// Kết nối đến CSDL sử dụng PDO
function pdo_connect(){
    GLOBAL $servername;
    GLOBAL $database;
    GLOBAL $username;
    GLOBAL $password;
    try{
        $conn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    catch(PDOException $e) {
        echo "Kết nối CSDL thất bại: " . $e->getMessage();
    }
}
/**
 * Chạy câu lệnh sql để (INSERT, UPDATE, DELETE)
 * @param array $args mảng giá trị cung cấp cho các tham số của $sql
 */
function pdo_execute($sql){
    $sql_args = array_slice(func_get_args(), 1);
    try{
        $conn = pdo_connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute($sql_args);
    }
    catch(PDOException $e){
        throw $e;
    }
    finally{
        unset($conn);
    }
}
/**
 * Chạy câu lệnh sql SELECT
 * @param array $args mảng giá trị cung cấp cho các tham số của $sql
 * @return array mảng các bản ghi
 * @throws PDOException lỗi thực thi câu lệnh
 */
function pdo_getAll($sql){
    $sql_args = array_slice(func_get_args(), 1);
    try{
        $conn = pdo_connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        $rows = $stmt->fetchAll();
        return $rows;
    }
    catch(PDOException $e){
        throw $e;
    }
    finally{
        unset($conn);
    }
}
/**
 * Chạy lệnh sql để lấy 1 record
 * @param array $args mảng giá trị cung cấp cho các tham số của $sql
 * @return array mảng chứa bản ghi
 */
function pdo_getOne($sql){
    $sql_args = array_slice(func_get_args(), 1);
    try{
        $conn = pdo_connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    catch(PDOException $e){
        throw $e;
    }
    finally{
        unset($conn);
    }
}
/**
 * Chạy câu lệnh sql truy vấn 1 giá trị
 * @param array $args mảng giá trị cung cấp cho các tham số của $sql
 * @return giá trị
 */
function pdo_getValue($sql){
    $sql_args = array_slice(func_get_args(), 1);
    try{
        $conn = pdo_connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute($sql_args);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return array_values($row)[0];
    }
    catch(PDOException $e){
        throw $e;
    }
    finally{
        unset($conn);
    }
}