<?php 
class Kategori
{
    //DB Stuff
    private $conn,
        $table = "kategori";

    public
        $id_kategori,
        $nama_kategori;
    
        public function __construct($db)
        {
            $this->conn = $db;   
        }

        public function getKategori()
        {
            $query = "SELECT * FROM " . $this->table;
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
    
            // Execute query
            $stmt->execute();
    
            return $stmt;
        }
}

?>