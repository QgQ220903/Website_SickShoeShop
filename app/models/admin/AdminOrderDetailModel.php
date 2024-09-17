<?php
class AdminOrderDetailModel extends Database
{
  function insert($invoice_id, $productDetail_id, $quantity, $subtotal)
  {
    $query = 'INSERT INTO `order_detail` (order_id, product_detail_id, quantity, subtotal) VALUES (?, ?, ?, ?)';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$invoice_id, $productDetail_id, $quantity, $subtotal]);
    $rowCount = $stmt->rowCount();
  }
}