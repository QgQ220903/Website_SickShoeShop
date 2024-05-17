<?php
class OrderDetailModel extends Database
{
  function insert($order_id, $product_detail_id, $quantity, $subtotal)
  {
    $query = "INSERT INTO `order_detail` (order_id ,`product_detail_id`, `quantity`, `subtotal`) VALUES (?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$order_id, $product_detail_id, $quantity, $subtotal]);
    $rowCount = $stmt->rowCount();
    return $rowCount;
  }
}