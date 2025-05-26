<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "scoreboardcom"; //The name of the database

    //The connection to the database
    function connectTodb() {
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->db);
        return $connection;
    }
    // Helps prevent SQL injection attacks
    function escapeString($value) {
        $conn = $this->connectTodb();
        return mysqli_real_escape_string($conn, $value);
    }

    // reads information from the databasa
    function readFromdb($query) {
        $conn = $this->connectTodb();
        $result = mysqli_query($conn, $query);
        // incase of an error it will be displayed
        if (!$result) {
            die("Query Error: " . mysqli_error($conn));
        }
        // displaying the read information on the mornitor
        $data = false;
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    // saves information to the database from the user
    function saveTodb($query) {
        $conn = $this->connectTodb();
        $result = mysqli_query($conn, $query);
        if (!$result) {
            echo "Error executing query: " . mysqli_error($conn);
            return false;
        }
        return true;
    }
}
?>
