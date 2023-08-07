<?php

namespace Api\Controller;

use Api\Database\Queries;
use PDO;
use PDOException;


class ProductController extends Queries
{
    private $table = "products";

    private function discount($price)
    {
        $discount = 10 / 100 * $price;
        $harga = $price - $discount;
        return $harga;
    }

    private function calculateStatus($expirationDate)
    {
        $today = date('Y-m-d');
        $daysRemaining = (strtotime($expirationDate) - strtotime($today)) / (60 * 60 * 24);

        if ($daysRemaining <= 0) {
            return 'expired';
        } elseif ($daysRemaining <= 10) {
            return 'bahaya';
        } else {
            return 'active';
        }
    }

    public function store($code, $name, $expiration_date, $stringprice)
    {
        $sql = "INSERT INTO {$this->table} (code,name,expiration_date,price,status,is_deleted) VALUES (?,?,?,?,?,?)";
        $expired = date('Y-m-d', strtotime($expiration_date));
        $status = $this->calculateStatus($expired);
        if ($status != 'active') {
            $price = $this->discount(floatval($stringprice));
        } else {
            $price = floatval($stringprice);
        }
        $params = [$code, $name, $expired, $price, $status, 0];
        try {
            $stmt = $this->perform($sql, $params);
            header('Content-Type: application/json');
            if ($stmt) {
                if ($status == 'expired') {
                    echo json_encode(['message' => 'Product expired']);
                }
                echo json_encode(['message' => 'Data inserted successfully']);
            } else {
                echo json_encode(['error' => 'Failed to insert data']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function edit($stringid, $code, $name, $expiration_date, $stringprice)
    {
        $id = (int)$stringid;
        $sql = "UPDATE {$this->table} SET code = ?, name = ?, expiration_date = ?, price = ?, status = ? WHERE id = ?";
        $expired = date('Y-m-d', strtotime($expiration_date));
        $status = $this->calculateStatus($expired);
        if ($status != 'active') {
            $price = $this->discount(floatval($stringprice));
        } else {
            $price = floatval($stringprice);
        }
        $params = [$code, $name, $expired, $price, $status, $id];
        try {
            $stmt = $this->perform($sql, $params);
            header('Content-Type: application/json');
            if ($stmt) {
                if ($status == 'expired') {
                    echo json_encode(['message' => 'Product expired']);
                }
                echo json_encode(['message' => 'Data updated successfully']);
            } else {
                echo json_encode(['error' => 'Failed to update data']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function search($code)
    {
        $sql = "SELECT * FROM {$this->table} WHERE code = ?";
        try {
            $stmt = $this->perform($sql, [$code]);
            header('Content-Type: application/json');
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($data as $row) {
                    if ($row['is_deleted'] == 1) {
                        echo json_encode(['message' => "produk sudah dihapus"]);
                        return;
                    }
                }
                echo json_encode(['message' => $data]);
            } else {
                echo json_encode(['error' => 'Produk tidak ditemukan']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function productWithPaging($stringPageNumber, $stringPageSize)
    {
        $pageNumber = (int)$stringPageNumber;
        $pageSize = (int)$stringPageSize;
        $offset = ($pageNumber - 1) * $pageSize;
        $sql = "SELECT * FROM {$this->table} LIMIT ? OFFSET ?";
        try {
            $params = [$pageSize, $offset];
            $stmt = $this->perform($sql, $params);

            header('Content-Type: application/json');
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($data)) {
                echo json_encode(['data' => $data]);
            } else {
                echo json_encode(['message' => 'Tidak ada data']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }



    public function deleteProduct($productId)
    {
        $sql = "UPDATE {$this->table} SET is_deleted = 1 WHERE id = ?";
        try {
            $stmt = $this->perform($sql, [$productId]);
            header('Content-Type: application/json');
            if ($stmt->rowCount() > 0) {
                echo json_encode(['message' => 'Produk berhasil dihapus']);
            } else {
                echo json_encode(['error' => 'Produk tidak ditemukan']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function restoreProduct($productId)
    {
        $sql = "UPDATE {$this->table} SET is_deleted = 0 WHERE id = ?";
        try {
            $stmt = $this->perform($sql, [$productId]);
            header('Content-Type: application/json');

            if ($stmt->rowCount() > 0) {
                echo json_encode(['message' => 'Produk berhasil direstore']);
            } else {
                echo json_encode(['error' => 'Produk tidak ditemukan']);
            }
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
