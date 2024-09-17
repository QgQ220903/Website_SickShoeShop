<?php
class AdminInvoiceDetailModel extends Database
{
  function insert($invoice_id, $productDetail_id, $quantity, $subtotal)
  {
    $query = 'INSERT INTO `invoice_detail` (invoice_id, productDetail_id, quantity, subtotal) VALUES (?, ?, ?, ?)';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$invoice_id, $productDetail_id, $quantity, $subtotal]);
    $rowCount = $stmt->rowCount();
  }
}