<?php
class CartDetailModel extends Database
{
  function insert($cart_id, $product_detail_id)
  {
    // Kiểm tra xem product_detail_id đã tồn tại trong bảng cart_detail hay chưa
    $checkQuery = 'SELECT COUNT(*) FROM cart_detail WHERE product_detail_id = ? AND cart_id = ?';
    $checkStmt = $this->conn->prepare($checkQuery);
    $checkStmt->execute([$product_detail_id, $cart_id]);
    $rowCount = $checkStmt->fetchColumn();

    if ($rowCount > 0) {
      // Nếu product_detail_id đã tồn tại, tăng quantity lên 1
      $updateQuery = 'UPDATE cart_detail SET quantity = quantity + 1 WHERE product_detail_id = ? AND cart_id = ?';
      $updateStmt = $this->conn->prepare($updateQuery);
      $updateStmt->execute([$product_detail_id, $cart_id]);
      echo "Thêm thành công";
    } else {
      // Nếu product_detail_id chưa tồn tại, thực hiện thêm mới
      $insertQuery = 'INSERT INTO cart_detail (cart_id, product_detail_id, quantity) VALUES (?, ?, ?)';
      $insertStmt = $this->conn->prepare($insertQuery);
      $insertStmt->execute([$cart_id, $product_detail_id, 1]);
      echo "Thêm thành công";
    }
  }

  function delete($POST)
  {
    $id = $_POST['id'];
    $query = 'DELETE FROM cart_detail WHERE id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Thành công";
    } else {
      echo "Thất bại";
    }
  }
  function deleteByCartId($cart_id)
  {
    $query = 'DELETE FROM cart_detail WHERE cart_id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$cart_id]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Thành công";
    } else {
      echo "Thất bại";
    }
  }
}
