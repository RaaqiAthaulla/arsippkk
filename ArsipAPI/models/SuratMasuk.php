<?php
class SuratMasuk
{
    //DB Stuff
    private $conn,
        $table = "surat_masuk";

    public
        $id,
        $tgl_terima,
        $nomer,
        $pengirim,
        $nomer_tertulis,
        $tgl_tertulis,
        $keperluan,
        $keterangan,
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
            $this->tgl_terima = $row['tgl_terima'];
            $this->nomer = $row['nomer'];
            $this->pengirim = $row['pengirim'];
            $this->nomer_tertulis = $row['nomer_tertulis'];
            $this->tgl_tertulis = $row['tgl_tertulis'];
            $this->keperluan = $row['keperluan'];
            $this->keterangan = $row['keterangan'];
            $this->kategori = $row['kategori'];
            $this->status = $row['status'];
            return true;
        }
    }

    public function getByStatus()
    {
        $query = "SELECT * FROM " . $this->table . "WHERE status = ?";

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
            tgl_terima = :tgl_terima,
            nomer = :nomer,
            pengirim = :pengirim,
            nomer_tertulis = :nomer_tertulis,
            tgl_tertulis = :tgl_tertulis,
            keperluan = :keperluan,
            keterangan = :keterangan,
            kategori = :kategori,
            status = :status";

        //Perpare statement
        $stmt = $this->conn->prepare($query);

        //Bind data
        $stmt->bindParam(":tgl_terima", $this->tgl_terima);
        $stmt->bindParam(":nomer", $this->nomer);
        $stmt->bindParam(":pengirim", $this->pengirim);
        $stmt->bindParam(":nomer_tertulis", $this->nomer_tertulis);
        $stmt->bindParam(":tgl_tertulis", $this->tgl_tertulis);
        $stmt->bindParam(":keperluan", $this->keperluan);
        $stmt->bindParam(":keterangan", $this->keterangan);
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
        $query = "UPDATE " . $this->table . " SET nomer = :nomer, tgl_terima = :tgl_terima, pengirim = :pengirim, nomer_tertulis = :nomer_tertulis, tgl_tertulis = :tgl_tertulis, keperluan = :keperluan, keterangan = :keterangan, kategori = :kategori, status = :status WHERE " . $this->table . ".id = :id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clear data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->tgl_terima = htmlspecialchars(strip_tags($this->tgl_terima));
        $this->nomer = htmlspecialchars(strip_tags($this->nomer));
        $this->pengirim = htmlspecialchars(strip_tags($this->pengirim));
        $this->nomer_tertulis = htmlspecialchars(strip_tags($this->nomer_tertulis));
        $this->tgl_tertulis = htmlspecialchars(strip_tags($this->tgl_tertulis));
        $this->keperluan = htmlspecialchars(strip_tags($this->keperluan));
        $this->keterangan = htmlspecialchars(strip_tags($this->keterangan));
        $this->kategori = htmlspecialchars(strip_tags($this->kategori));
        $this->status = htmlspecialchars(strip_tags($this->status));

        //Bind data
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":tgl_terima", $this->tgl_terima);
        $stmt->bindParam(":nomer", $this->nomer);
        $stmt->bindParam(":pengirim", $this->pengirim);
        $stmt->bindParam(":nomer_tertulis", $this->nomer_tertulis);
        $stmt->bindParam(":tgl_tertulis", $this->tgl_tertulis);
        $stmt->bindParam(":keperluan", $this->keperluan);
        $stmt->bindParam(":keterangan", $this->keterangan);
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

    public function Nonaktif()
    {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";

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
