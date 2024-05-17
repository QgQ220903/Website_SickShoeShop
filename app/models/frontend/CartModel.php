<?php
class CartModel extends Database
{
  // thực hiện thêm mới cart 
  function insert($POST)
  {
    if (isset($POST['user_id'])) {
      $user_id = $POST['user_id'];
      $query = "INSERT INTO `cart` (user_id) VALUES (?)";
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$user_id]);
    }
  }

  function getCurrentCartID()
  {
    $query = "SELECT id AS cart_id FROM cart";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result->cart_id;
    } else {
      return 0;
    }
  }

  function getCartIDByUserID($POST)
  {
    $user_id = $POST['user_id'];

    $query = "SELECT id AS cart_id FROM cart where user_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$user_id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result->cart_id;
    } else {
      return 0;
    }
  }
  function delete($id)
  {
    $query = 'DELETE FROM cart WHERE id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Thành công";
    } else {
      echo "Thất bại";
    }
  }
  function getCartByUserID($POST)
  {
    $display = "<table class='table table-bordered table-striped text-center mb-0'>";

    $user_id = $POST['user_id'];
    $query = '
    SELECT cart.id AS cart_id, cart_detail.id, product.name AS product_name, color.name AS color_name, size.name AS size_name, cart_detail.quantity, product_detail.price, product_detail.image
    FROM cart
    JOIN cart_detail ON cart.id = cart_detail.cart_id
    JOIN product_detail ON cart_detail.product_detail_id = product_detail.id
    JOIN product ON product_detail.product_id = product.id
    JOIN color ON product_detail.color_id = color.id
    JOIN size ON product_detail.size_id = size.id
    WHERE cart.user_id = :user_id
    ';

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {
      $display .= "
        <thead class='bg-secondary text-dark'>
          <tr>
            <th class='fw-bold'>Sản Phẩm</th>
            <th class='fw-bold'>Màu sắc</th>
            <th class='fw-bold'>Kích cỡ</th>
            <th class='fw-bold'>Số lượng</th>
            <th class='fw-bold'>Giá tiền</th>
            <th class='fw-bold'>Hình ảnh</th>
            <th class='fw-bold'>Thao tác</th>
          </tr>
        </thead>
        <tbody class='align-middle'>
      ";
      $total = 0;
      foreach ($result as $row) {
        $price = $row['price'] + (($row['price'] * 10 / 100));
        $price = $price * $row['quantity'];
        $total += $price;
        $price = currency_format($price);
        // $price = currency_format($price);
        $display .= "
        <tr>
          <td class='align-middle'>{$row['product_name']} </td>
          <td class='align-middle'>{$row['color_name']} </td>
          <td class='align-middle'>{$row['size_name']} </td>
          <td class='align-middle'>
            {$row['quantity']}
          </td>
          <td class='align-middle'>$price</td>
          <td class='align-middle'><img src='" . ASSETS . "img/{$row['image']}' alt='' style='width: 120px; height: 80px; object-fit: cover;'></td>
          <td class='align-middle'><button onclick='deleteCartDetail({$row['id']})' class='btn btn-sm btn-danger'><i class='fa fa-trash'></i></button></td>
        </tr>";

      }
      $total = currency_format($total);
      $display .= "
      <tr>
        <td class='align-middle' colspan=6>TỔNG TIỀN</td>
        <td class='align-middle text-danger fw-bold fs-5' colspan=1>{$total}</td>
      </tr>
      </tbody>
      ";
      $display .= "</table>";
      $display .= "
      <div class = 'd-flex align-item-center justify-content-end'>
        <a href='" . ROOT . "checkout/{$_SESSION['user_id']}' id='place_order_btn'
        class='btn btn-block btn-primary mt-2 me-2 text-end'>Đặt Hàng</a>
        <a href='" . ROOT . "shop' id='' class='btn btn-block btn-success mt-2'>Tiếp tục mua
        sắm</a>
      </div>
      
      ";
      echo $display;
    } else {
      echo "
      <div class = 'd-flex align-item-center'>
        <a href='" . ROOT . "shop' id='' class='btn btn-block btn-success mt-2'>Tiếp tục mua
        sắm</a>
      </div>
      ";
    }
  }

  public function getCartDataToCheckout($user_id)
  {
    $query = "
    SELECT p.name, pd.id AS product_detail_id, pd.size_id, pd.color_id, pd.price, pd.image, cd.quantity,
    s.name AS size_name, c.name AS color_name
    FROM cart ct
    INNER JOIN cart_detail cd ON ct.id = cd.cart_id
    INNER JOIN product_detail pd ON cd.product_detail_id = pd.id
    INNER JOIN product p ON pd.product_id = p.id
    INNER JOIN size s ON pd.size_id = s.id  -- Join with size table
    INNER JOIN color c ON pd.color_id = c.id  -- Join with color table
    WHERE ct.user_id = ?
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$user_id]);
    $cart_data = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $cart_data;
  }
}