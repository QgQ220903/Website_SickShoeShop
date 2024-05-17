<?php
class OrderModel extends Database
{
  function GetAll($POST)
  {
    $user_id = $POST['user_id'];
    $limit = 4;
    $page = 0;
    $display = "";
    if (isset($POST['page'])) {
      $page = $POST['page'];
    } else {
      $page = 1;
    }
    //bat dau tu
    $startfrom = ($page - 1) * $limit;
    $query = "
    SELECT o.*,
    CONCAT(p.name, ', ', d.name, ', ', w.name, ', ', a.street_name) AS full_address
    FROM `order` o
    JOIN address a ON o.address = a.id
    JOIN province p ON a.province_id = p.id
    JOIN district d ON a.district_id = d.id
    JOIN ward w ON a.ward_id = w.id
    WHERE o.user_id =  ?
    ORDER BY o.id
    LIMIT {$startfrom}, {$limit}
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$user_id]);
    $orders = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display = "
    <div class='col-12 table-responsive mb-3' id='table'>
      <table class='table table-striped text-start align-middle table-bordered table-hover mb-0'>
        <thead>
          <tr class='text-dark'>
            <th scope='col'>Mã đơn hàng</th>
            <th scope='col'>Ngày đặt hàng</th>
            <th scope='col'>Trạng thái</th>
            <th scope='col'>Thao tác</th>
          </tr>
        </thead>
        <tbody>";
    $count = $this->getSum($user_id);
    if ($count > 0) {
      foreach ($orders as $order) {
        $display .= "
          <tr>
            <td>{$order->id}</td>
            <td>{$order->date}</td>
        ";
        if ($order->order_status == 0) {
          $display .= "<td>Chờ xử lý</td>";
        } else {
          $display .= "<td>Đã xử lý</td>";
        }

        $display .= "<td><button onclick='getDetail({$order->id})' class='btn btn-sm btn-primary'><i class='fa-solid fa-eye'></i></button></td></tr>";
      }
    } else {
      $display .= "
        <tr>
          <td colspan='7' class='text-center'> không có dữ liệu </td>
        </tr>";
    }
    $display .= " 
          </tbody>
        </table>
      </div>";

    //tổng số bản ghi
    $total_rows = $this->getSum($user_id);
    // tổng số trang
    $total_pages = ceil($total_rows / $limit);

    // hiển thị số trang 
    $display .= "
      <div class='col-12 pb-1'>
        <nav aria-label='Page navigation'>
        <ul class='pagination justify-content-center mb-3'>";
    if ($page > 1) {
      $prev_active = "";
      $prev = $page - 1;
      $display .= "
        <li class='page-item {$prev_active}'>
          <a onclick='changePageFetch($prev)' id = '{$prev}' class='page-link' href='#' aria-label='Previous'>
            <span aria-hidden='true'>&laquo;</span>
            <span class='sr-only'>Previous</span>
          </a>
        </li>";
    } else {
      $prev_active = "disabled";
      $display .= "
        <li class='page-item {$prev_active}'>
          <a id = '0' class='page-link' href='#' aria-label='Previous'>
            <span aria-hidden='true'>&laquo;</span>
            <span class='sr-only'>Previous</span>
          </a>
        </li>";
    }

    for ($i = 1; $i <= $total_pages; $i++) {
      $active_class = "";
      if ($i == $page) {
        $active_class = "active";

      }
      $display .= "<li class='page-item {$active_class} '><a onclick='changePageFetch($i)' id = '$i' class='page-link' href='#'>$i</a></li>";
    }

    $next_active = "";
    if ($page == $total_pages) {
      $next_active = "disabled";
      $display .= "
            <li class='page-item'>
            <a ' id='' class='page-link {$next_active}' href='#' aria-label='Next'>
              <span aria-hidden='true'>&raquo;</span>
              <span class='sr-only'>Next</span>
            </a>
          </li>
        </ul>
        </nav>
        </div>
          ";
    } else {
      $next = $page + 1;
      $display .= "
            <li class='page-item'>
            <a onclick='changePageFetch($next)' id='{$next}' class='page-link {$next_active}' href='#' aria-label='Next'>
              <span aria-hidden='true'>&raquo;</span>
              <span class='sr-only'>Next</span>
            </a>
          </li>
        </ul>
        </nav>
        </div>
          ";
    }
    echo $display;
  }
  function insert($POST)
  {
    $user_id = $POST['user_id'];
    $customer_name = $POST['customer_name'];
    $date = date("Y-m-d H:i:s");
    $address = $POST['address'];
    $payment_method = $POST['payment_method'];
    $order_total = $POST['order_total'];
    $query = 'INSERT INTO `order` (user_id, customer_name, date, address, payment_method, order_total, order_status) VALUES (?, ?, ?, ?, ?, ?, ?)';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$user_id, $customer_name, $date, $address, $payment_method, $order_total, 0]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Thêm thành công";
    } else {
      echo "Thất bại";
    }
  }
  

  function getOrderByUserId($POST)
  {
    $query = "SELECT * FROM `order` WHERE `user_id` = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$POST['user_id']]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result;
    } else {
      return 0;
    }
  }

  function getLastestOrder($POST)
  {
    $query = "SELECT * FROM `order` WHERE `user_id` = ? order by date DESC LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$POST['user_id']]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result;
    } else {
      return 0;
    }
  }
  function getSum($id)
  {
    $query = "SELECT COUNT(*) AS total FROM `order` where `user_id`= ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result->total;
    } else {
      return 0;
    }
  }

  function getDetail($POST)
  {
    $display = "
    <div class='modal-dialog modal-dialog-centered modal-xl'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h1 class='modal-title fs-5' id='exampleModalLabel'>Thông tin đơn hàng</h1>
          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
        </div>
    ";
    $order_id = $POST['order_id'];
    $query = "
    SELECT o.*,
    CONCAT(a.street_name, ', ', p.name, ', ', w.name, ', ', d.name) AS full_address
    FROM `order` o
    JOIN address a ON o.address = a.id
    JOIN province p ON a.province_id = p.id
    JOIN district d ON a.district_id = d.id
    JOIN ward w ON a.ward_id = w.id
    WHERE o.id =  ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$order_id]);
    $order = $stmt->fetch(PDO::FETCH_OBJ);
    $display .= "
    <div class='modal-body'>
      <p class='mb-1'>Mã đơn hàng: {$order_id}</p>
      <p class='mb-1'>Tên khách hàng: {$order->customer_name}</p>
      <p class='mb-1'>Ngày đặt hàng: {$order->date}</p>
      <p class='mb-1'>Địa chỉ giao hàng: {$order->full_address}</p>
    ";
    if ($order->order_status == 0) {
      $display .= "
      <p class='mb-1'>Trạng thái: Chờ xác nhận</p>
      ";
    } else if ($order->order_status == 1) {
      $display .= "
      <p class='mb-1'>Trạng thái: Đã xác nhận</p>
      ";
    }
    $detailQuery = "
    SELECT  p.name AS product_name, c.name AS color_name, s.name AS size_name,
       od.quantity, od.subtotal, od.product_detail_id, pd.price, pd.image
    FROM order_detail od
    INNER JOIN product_detail pd ON od.product_detail_id = pd.id
    INNER JOIN product p ON pd.product_id = p.id
    INNER JOIN color c ON pd.color_id = c.id  -- Join with color table
    INNER JOIN size s ON pd.size_id = s.id  -- Join with size table
    WHERE od.order_id = ?;
    ";
    $stmt = $this->conn->prepare($detailQuery);
    $stmt->execute([$order_id]);
    $order_detail = $stmt->fetchAll(PDO::FETCH_OBJ);

    $display .= "
    <table class='table table-striped'>
      <thead>
        <tr>
          <th scope='col'>Ảnh</th>
          <th scope='col'>Sản Phẩm</th>
          <th scope='col'>Màu Sắc</th>
          <th scope='col'>Kích Cỡ</th>
          <th scope='col'>Số Lượng</th>
          <th scope='col'>Thành Tiền</th>
        </tr>
      </thead>
      <tbody>";
    foreach ($order_detail as $row) {
      $display .= "
        <tr>
          <td scope='col'><img src ='". ASSETS ."img/{$row->image}' style='width:60px; height:60px; object-fit: cover;'></td>
          <td scope='col'>{$row->product_name}</td>
          <td scope='col'>{$row->color_name}</td>
          <td scope='col'>{$row->size_name}</td>
          <td scope='col'>{$row->quantity}</td>
          <td scope='col'>" . currency_format($row->subtotal) . "</td>   
        </tr>";
    }
    $display .= "
        </tbody>
      </table>
      <div class='d-flex justify-content-end'>
        Tổng tiền: 
        <p class='text-danger fw-bold'>" . currency_format($order->order_total) . "</p>
      </div>
    </div>
  <div class='modal-footer'>
    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Đóng</button>
  </div>";
    echo $display;
  }
}

