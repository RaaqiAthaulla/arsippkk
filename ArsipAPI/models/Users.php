<?php 
class Users
{
    //DB Stuff
    private $conn,
        $table = "user";

    public
        $id,
        $kode_guru,
        $nama,
        $email,
        $status_asn,
        $username,
        $password,
        $status_aktif,
        $role,
        $created_date,
        $last_login;
    
        public function __construct($db)
        {
            $this->conn = $db;   
        }

        public function getAll()
        {
            $query = "SELECT * FROM " . $this->table;
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
    
            // Execute query
            $stmt->execute();
    
            return $stmt;
        }

        public function get()
        {
            $query = "SELECT * FROM " . $this->table . " WHERE id = ?";

            // Prepare statement
            $stmt = $this->conn->prepare($query);
    
            // Bind user id
            $stmt->bindParam(1, $this->id);
    
            // Execute query
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $num = $stmt->rowCount();
    
            if ($num > 0) {
                // Set properties
                $this->id = $row['id'];
                $this->kode_guru = $row['kode_guru'];
                $this->nama = $row['nama'];
                $this->email = $row['email'];
                $this->status_asn = $row['status_asn'];
                $this->username = $row['username'];
                $this->password = $row['password'];
                $this->status_aktif = $row['status_aktif'];
                $this->role = $row['role'];
                $this->last_login = $row['last_login'];
                $this->created_date = $row['created_date'];
                return true;
            } else {
                return false;
            }
        }

        public function login()
        {
            $query = "SELECT id, username, nama, email, status_aktif, role FROM " . $this->table . " WHERE username = ? && password = ?";
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
    
            // Bind username & password
            $stmt->bindParam(1, $this->username);
            $stmt->bindParam(2, $this->password);
    
            // Execute query
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($row == null) {
                return false;
            } else {
                // Set properties
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->nama = $row['nama'];
                $this->email = $row['email'];
                $this->status_aktif = $row['status_aktif'];
                $this->role = $row['role'];
                return true;
            }
        }

        public function validasi()
    {
        $query = "SELECT username FROM " . $this->table . " WHERE username = '" . $this->username . "'";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            return false;
        } else {
            return true;
        }
    }

        public function post()
    {
        // Create query
        $query = "INSERT INTO " . $this->table . " 
       SET 
            kode_guru = :kode_guru,
            nama = :nama, 
            email = :email,
            status_asn = :status_asn,
            username = :username, 
            password = :password,
            status_aktif = :status_aktif, 
            role = :role,
            created_date = :created_date";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind data
        $stmt->bindParam(":kode_guru", $this->kode_guru);
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":status_asn", $this->status_asn);
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":status_aktif", $this->status_aktif);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":created_date", $this->created_date);
        // $stmt->bindParam(":last_login", $this->last_login);
        
        // Execute query
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function put()
        {
            // Create query
            $query = "UPDATE " . $this->table . " SET kode_guru = :kode_guru, email = :email, status_asn = :status_asn, password = :password, status_aktif = :status_aktif WHERE id = :id";
    
            // Prepare statement
            $stmt = $this->conn->prepare($query);
    
            // Clear data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->kode_guru = htmlspecialchars(strip_tags($this->kode_guru));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->status_aktif = htmlspecialchars(strip_tags($this->status_aktif));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->status_asn = htmlspecialchars(strip_tags($this->status_asn));
            
            // Bind data
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":kode_guru", $this->kode_guru);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":status_aktif", $this->status_aktif);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":status_asn", $this->status_asn);
            
            // Execute query
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $num = $stmt->rowCount();
    
            if ($num > 0) {
                // Set properties
                return true;
            } else {
                return false;
            }
        }

    public function logout()
    {
       // Create query
       $query = "UPDATE " . $this->table . " SET last_login = :last_login WHERE id = :id";

       // Prepare statement
       $stmt = $this->conn->prepare($query);

       // Clear data
       $this->id = htmlspecialchars(strip_tags($this->id));
       $this->last_login = htmlspecialchars(strip_tags($this->last_login));

       // Bind data
       $stmt->bindParam(":id", $this->id);
       $stmt->bindParam(":last_login", $this->last_login);

       // Execute query
       $stmt->execute();

       $row = $stmt->fetch(PDO::FETCH_ASSOC);

       $num = $stmt->rowCount();

       if ($num > 0) {
           // Set properties
           return true;
       } else {
           return false;
       }
    }
}
?>