<?php
class SuratKeluar
{
    //DB Stuff
    private $conn,
        $table = "surat_keluar";

    public
        $id,
        $nomer,
        $tanggal,
        $ditujukan,
        $keperluan,
        $keterangan,
        $penerima,
        $kategori,
        $status;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table;

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    public function getById()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //bind user id
        $stmt->bindParam(1, $this->id);

        //Execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row == null) {
            return false;
        } else {
            //Set Properties
            $this->id = $row['id'];
            $this->nomer = $row['nomer'];
            $this->ditujukan = $row['ditujukan'];
            $this->keperluan = $row['keperluan'];
            $this->keterangan = $row['keterangan'];
            $this->penerima = $row['penerima'];
            $this->tanggal = $row['tanggal'];
            $this->kategori = $row['kategori'];
            $this->status = $row['status'];
            return true;
        }
    }

    public function getByStatus()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE status = ?";

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind status
        $stmt->bindParam(1, $this->status);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    public function getLimit()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC LIMIT 3";

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }

    public function post()
    {
        $query = "INSERT INTO " . $this->table . "
        SET
            nomer = :nomer,
            ditujukan = :ditujukan,
            keperluan = :keperluan,
            keterangan = :keterangan,
            penerima = :penerima,
            tanggal = :tanggal,
            kategori = :kategori,
            status = :status";

        //Perpare statement
        $stmt = $this->conn->prepare($query);

        //Bind data
        $stmt->bindParam(":nomer", $this->nomer);
        $stmt->bindParam(":ditujukan", $this->ditujukan);
        $stmt->bindParam(":keperluan", $this->keperluan);
        $stmt->bindParam(":keterangan", $this->keterangan);
        $stmt->bindParam(":penerima", $this->penerima);
        $stmt->bindParam(":tanggal", $this->tanggal);
        $stmt->bindParam(":kategori", $this->kategori);
        $stmt->bindParam(":status", $this->status);

        //Execute query
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function put()
    {
        $query = "UPDATE " . $this->table . " SET nomer = :nomer, ditujukan = :ditujukan, keperluan = :keperluan, keterangan = :keterangan, penerima = :penerima, tanggal = :tanggal, kategori = :kategori, status = :status WHERE id = :id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clear data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->nomer = htmlspecialchars(strip_tags($this->nomer));
        $this->ditujukan = htmlspecialchars(strip_tags($this->ditujukan));
        $this->keperluan = htmlspecialchars(strip_tags($this->keperluan));
        $this->keterangan = htmlspecialchars(strip_tags($this->keterangan));
        $this->penerima = htmlspecialchars(strip_tags($this->penerima));
        $this->tanggal = htmlspecialchars(strip_tags($this->tanggal));
        $this->kategori = htmlspecialchars(strip_tags($this->kategori));
        $this->status = htmlspecialchars(strip_tags($this->status));

        //Bind data
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nomer", $this->nomer);
        $stmt->bindParam(":ditujukan", $this->ditujukan);
        $stmt->bindParam(":keperluan", $this->keperluan);
        $stmt->bindParam(":keterangan", $this->keterangan);
        $stmt->bindParam(":penerima", $this->penerima);
        $stmt->bindParam(":tanggal", $this->tanggal);
        $stmt->bindParam(":kategori", $this->kategori);
        $stmt->bindParam(":status", $this->status);

        //execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $num = $stmt->rowCount();

        if ($num > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function nonaktif()
    {
        $query = "UPDATE " . $this->table . "
        SET
            status = :status
        WHERE
            id = :id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clear data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->status = htmlspecialchars(strip_tags($this->status));

        //Bind data
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":status", $this->status);

        //execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $num = $stmt->rowCount();

        if ($num > 0) {
            return true;
        } else {
            return false;
        }
    }
}
