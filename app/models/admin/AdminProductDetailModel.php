<?php
class AdminProductDetailModel extends Database
{
  function getAllProductDetailByProductID($product_id)
  {
    // số bản ghi trong 1 trang
    $limit = 4;
    // số trang hiện tại
    $page = 0;
    // dữ liệu hiển thị lên view
    $display = "";
    if (isset($_POST['page'])) {
      $page = $_POST['page'];
    } else {
      $page = 1;
    }
    $start_from = ($page - 1) * $limit;
    // bắt đầu từ 
    $query = "SELECT 
    pd.id, 
    c.name as color_name, 
    s.name as size_name, 
    p.name as product_name, 
    quantity, 
    price, 
    image 
    FROM product_detail pd 
    INNER JOIN color c ON pd.color_id = c.id 
    INNER JOIN size s ON pd.size_id = s.id 
    INNER JOIN product p ON pd.product_id = p.id 
    WHERE p.id = ? ORDER BY pd.id LIMIT {$start_from}, {$limit};";

    $stmt = $this->conn->prepare($query);
    $stmt->execute([$product_id]);
    $display = "
    <div class='table-responsive mb-3'>
    <table id='displayDataTable' class='table text-start align-middle table-bordered table-hover mb-0'>
      <thead>
        <tr class='text-dark'>
          <th scope='col'>ID</th>
          <th scope='col'>Màu sắc</th>
          <th scope='col'>Kích cỡ</th>
          <th scope='col'>Sản phẩm</th>
          <th scope='col'>Số lượng</th>
          <th scope='col'>Giá</th>
          <th scope='col'>Hình ảnh</th>
          <th scope='col'>Thao tác</th>
        </tr>
      </thead>
      <tbody>
    ";

    $products = $stmt->fetchAll(PDO::FETCH_OBJ);
    foreach ($products as $product) {
      $display .=
        "<tr>
          <td>{$product->id}</td>
          <td>{$product->color_name}</td>
          <td>{$product->size_name}</td>
          <td>{$product->product_name}</td>
          <td>{$product->quantity}</td>
          <td>{$product->price}</td>
          <td><img class='previewImage_table' src='" . ASSETS . "img/{$product->image}'></td>
          <td>
            <button class='btn btn-sm btn-warning' onclick='get_detail({$product->id})'><i class='fa-solid fa-pen-to-square'></i></button>
            <button class='btn btn-sm btn-danger' onclick='delete_ProductDetail({$product->id})'><i class='fa-solid fa-trash'></i></button>
          </td>
        </tr>";
    }
    $display .= "
      </tbody>
    </table>
    </div>";
    // tổng số bản ghi 
    //  $total_rows = $this->getSum($product->id);
    //  echo $total_rows;
    // tổng số trang
    $total_pages = ceil($this->getSum($product_id)->total / $limit);
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

  function getAllProductDetailByProductIDImport($product_id)
  {
    $query = "SELECT 
    pd.id, 
    c.name as color_name, 
    s.name as size_name, 
    p.name as product_name, 
    quantity, 
    price, 
    image 
    FROM product_detail pd 
    INNER JOIN color c ON pd.color_id = c.id 
    INNER JOIN size s ON pd.size_id = s.id 
    INNER JOIN product p ON pd.product_id = p.id 
    WHERE p.id = ?  ORDER BY pd.id;";

    $stmt = $this->conn->prepare($query);
    $stmt->execute([$product_id]);
    $display = "";
    $display .= "<option id=''  value=''>Chọn sản phẩm</option>";

    $products = $stmt->fetchAll(PDO::FETCH_OBJ);
    foreach ($products as $product) {
      $display .= "<option id='{$product->id}'  value='{$product->id}'>{$product->product_name} - {$product->color_name} - {$product->size_name} </option>";

    }
    echo $display;
  }

  function getAllProductDetailByProductIDSale($product_id)
  {
    $query = "SELECT 
    pd.id, 
    c.name as color_name, 
    s.name as size_name, 
    p.name as product_name, 
    quantity, 
    price, 
    image 
    FROM product_detail pd 
    INNER JOIN color c ON pd.color_id = c.id 
    INNER JOIN size s ON pd.size_id = s.id 
    INNER JOIN product p ON pd.product_id = p.id 
    WHERE p.id = ? AND pd.quantity > 0 ORDER BY pd.id;";

    $stmt = $this->conn->prepare($query);
    $stmt->execute([$product_id]);
    $display = "";
    $display .= "<option id=''  value=''>Chọn sản phẩm</option>";

    $products = $stmt->fetchAll(PDO::FETCH_OBJ);
    foreach ($products as $product) {
      $display .= "<option id='{$product->id}'  value='{$product->id}'>{$product->product_name} - {$product->color_name} - {$product->size_name} </option>";

    }
    echo $display;
  }
  // function getAllProductDetailByProduct($productName)
  // {
  //   $query = "
  //       SELECT pd.id, c.name AS color_name, s.name AS size_name, p.name AS product_name, quantity, price, image
  //       FROM product_detail pd
  //       INNER JOIN color c ON pd.color_id = c.id
  //       INNER JOIN size s ON pd.size_id = s.id
  //       INNER JOIN product p ON pd.product_id = p.id
  //       WHERE p.name = ?
  //       ORDER BY pd.id;
  //   ";

  //   try {
  //     $stmt = $this->conn->prepare($query);
  //     $stmt->execute([$productName]);
  //     $productDetails = $stmt->fetchAll(PDO::FETCH_OBJ);
  //     echo $productDetails;

  //     $display = buildProductDetailTable($productDetails);

  //     echo $display;
  //   } catch (PDOException $e) {
  //     // Xử lý lỗi kết nối cơ sở dữ liệu (ví dụ: ghi nhật ký, thông báo lỗi cho người dùng)
  //     echo "Lỗi truy xuất chi tiết sản phẩm: " . $e->getMessage();
  //   }
  // }


  // function buildProductDetailTable($productDetails)
  // {
  //   $tableHtml = "
  //       <div class='table-responsive mb-3'>
  //       <table id='displayDataTable' class='table text-start align-middle table-bordered table-hover mb-0'>
  //           <thead>
  //               <tr class='text-dark'>
  //                   <th>ID</th>
  //                   <th>Màu sắc</th>
  //                   <th>Kích cỡ</th>
  //                   <th>Sản phẩm</th>
  //                   <th>Số lượng</th>
  //                   <th>Giá</th>
  //                   <th>Hình ảnh</th>
  //                   <th>Thao tác</th>
  //               </tr>
  //           </thead>
  //           <tbody>";

  //   foreach ($productDetails as $product) {
  //     $tableHtml .= "
  //           <tr>
  //               <td>{$product->id}</td>
  //               <td>{$product->color_name}</td>
  //               <td>{$product->size_name}</td>
  //               <td>{$product->product_name}</td>
  //               <td>{$product->quantity}</td>
  //               <td>{$product->price}</td>
  //               <td><img class='previewImage_table' src='{$product->image}'></td>
  //               <td class='text-center'>
  //                   <a href='' class='btn btn-sm btn-warning' onclick='get_detail({$product->id})'><i class='fa-solid fa-pen-to-square'></i></a>
  //                   <button class='btn btn-sm btn-danger' onclick='delete_ProductDetail({$product->id})'><i class='fa-solid fa-trash'></i></button>
  //                   <button class='btn btn-sm btn-primary' onclick='view_product({$product->id})'><i class='fa-solid fa-eye'></i></button>
  //               </td>
  //           </tr>";
  //   }

  //   $tableHtml .= "
  //           </tbody>
  //       </table>
  //       </div>";

  //   return $tableHtml;
  // }


  function checkDuplicate($POST)
  {
    $product_id = $POST['product_id'];
    $color_id = $POST['color_id'];
    $size_id = $POST['size_id'];
    $query = 'SELECT id FROM product_detail WHERE product_id = ? AND color_id = ? AND size_id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$product_id, $color_id, $size_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && isset($result['id'])) {
      $productDetailId = $result['id'];
    } else {
      $productDetailId = 0;
    }
    return $productDetailId;
  }

  function checkDuplicateUpdate($POST)
  {
    $product_id = $POST['product_id'];
    $color_id = $POST['color_id'];
    $size_id = $POST['size_id'];
    $product_detail_id = $POST['product_detail_id'];

    $query = 'SELECT id FROM product_detail WHERE product_id = ? AND color_id = ? AND size_id = ? AND id <> ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$product_id, $color_id, $size_id, $product_detail_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && isset($result['id'])) {
      $productDetailId = $result['id'];
    } else {
      $productDetailId = 0;
    }

    return $productDetailId;
  }

  function insert($POST)
  {
    if ($this->checkDuplicate($POST) == 0) {
      $product_id = $POST['product_id'];
      $color_id = $POST['color_id'];
      $size_id = $POST['size_id'];
      $productDetail_price = $POST['productDetail_price'];
      $productDetail_img = $POST['productDetail_img'];
      $query = 'INSERT INTO `product_detail`
      (`product_id`, `size_id`, `color_id`, `quantity`, `price`, `image`) 
      VALUES 
      (?,?,?,?,?,?)';
      $stmt = $this->conn->prepare($query);
      $result = $stmt->execute([$product_id, $size_id, $color_id, 0, $productDetail_price, $productDetail_img]);
      if (!$result) {
        echo "Thành công";
      }
    }

  }



  function update($POST)
  {
    $id = $POST['productDetail_id'];
    $product_id = $POST['product_id'];
    $color_id = $POST['color_id'];
    $size_id = $POST['size_id'];
    $productDetail_price = $POST['productDetail_price'];
    $productDetail_img = $POST['productDetail_img'];
    // Check if the combination of product, color, and size already exists
    $query = 'SELECT id FROM product_detail WHERE product_id = ? AND color_id = ? AND size_id = ? AND image = ? AND id <> ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$product_id, $color_id, $size_id, $productDetail_img, $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && isset($result['id'])) {
      return;
    }
    // Update the product detail
    $query = 'UPDATE product_detail SET color_id = ?, size_id = ?, price = ?, image = ? WHERE id = ?';
    $stmt = $this->conn->prepare($query);
    $result = $stmt->execute([$color_id, $size_id, $productDetail_price, $productDetail_img, $id]);
    if ($result) {
      echo "Thành công";
    } else {
      echo "Thất bại";
    }
  }


  // xóa 1 bản ghi chi tiết sản phẩm
  function delete($id)
  {
    $query = 'DELETE FROM product_detail WHERE id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Thành công";
    } else {
      echo "Thất bại";
    }
  }

  function getSum($id)
  {
    // SQL query to count records with the given product_id
    $query = "SELECT COUNT(*) AS total FROM `product_detail` WHERE `product_id`= ?";

    // Prepare the SQL query
    $stmt = $this->conn->prepare($query);

    // Execute the query with the given product_id
    $stmt->execute([$id]);

    // Fetch the result as an object
    $result = $stmt->fetch(PDO::FETCH_OBJ);

    // Return the total count
    return $result;
  }

  // lấy  1 bản ghi chi tiết sản phẩm thông qua id
  function getProductDetailByID($id)
  {
    $query = 'SELECT pd.id, 
    c.name as color_name, 
    s.name as size_name, 
    p.name as product_name, 
    quantity, 
    price, 
    image 
    FROM product_detail pd 
    INNER JOIN color c ON pd.color_id = c.id 
    INNER JOIN size s ON pd.size_id = s.id 
    INNER JOIN product p ON pd.product_id = p.id WHERE pd.id = ? ORDER BY pd.id ';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $response = array();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    $response['id'] = $result[0]->id;
    $response['color_name'] = $result[0]->color_name;
    $response['size_name'] = $result[0]->size_name;
    $response['product_name'] = $result[0]->product_name;
    $response['quantity'] = $result[0]->quantity;
    $response['price'] = $result[0]->price;
    $response['image'] = $result[0]->image;
    echo json_encode($response);
  }

  function updateQuantity($id, $quantity)
  {
    $query = "UPDATE product_detail SET quantity = quantity + ? WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$quantity, $id]);
    $rowCount = $stmt->rowCount();
  }


  function decreaseQuantity($id, $quantity)
  {
    $query = "UPDATE product_detail SET quantity = quantity - ? WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$quantity, $id]);
    $rowCount = $stmt->rowCount();
  }

}