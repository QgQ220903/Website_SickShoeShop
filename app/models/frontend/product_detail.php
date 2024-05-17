<?php
class product_detail extends Database
{

  function getData($offset, $limit, $searchText, $minPrice, $maxPrice, $category, $brand, $color, $size)
  {
    $query = "";
    $error = "";

    //Lấy toàn bộ dữ liệu 
    $query .= "SELECT p.*, pd.color_id, MIN(pd.id) AS product_detail_id, MIN(pd.price) AS min_price, MIN(pd.image) AS min_image,
    c.name AS category_name, b.name AS brand_name
    FROM product p
    INNER JOIN product_detail pd ON p.id = pd.product_id
    INNER JOIN category c ON p.category_id = c.id
    INNER JOIN brand b ON p.brand_id = b.id";

    //Xử lý truy vấn where: từ khóa tìm kiếm, giá
    $where = "";
    //xử lý từ khóa tìm kiếm.
    if ($searchText != "") {
      $where .= " p.name LIKE '%$searchText%' ";
    }
    //xử lý giá.
    if ($minPrice != "" || $maxPrice != "") {
      if ($where != "") {
        $where .= " AND ";
      }
      if ($minPrice != "" && $maxPrice != "") {
        $where .= " pd.price >= $minPrice AND pd.price <= $maxPrice ";
      } else {
        if ($minPrice != "") {
          $where .= " pd.price >= $minPrice";
        } else {
          $where .= " pd.price <= $maxPrice";
        }
      }
    }

    //xử lý thể loại
    if ($category != "") {
      if ($where != "") {
        $where .= " AND ";
      }
      $parts = explode(",", $category);
      $conditions = []; // Mảng để chứa các điều kiện

      foreach ($parts as $part) {
        $conditions[] = "c.name = '$part'";
      }

      if (!empty($conditions)) {

        // Xây dựng chuỗi điều kiện WHERE từ mảng $conditions
        $where .= "(" . implode(" OR ", $conditions) . ")";
      }
    }

    //xử lý thương hiệu
    if ($brand != "") {
      if ($where != "") {
        $where .= " AND ";
      }
      $parts = explode(",", $brand);
      $conditions = []; // Mảng để chứa các điều kiện

      foreach ($parts as $part) {
        $conditions[] = "b.name = '$part'";
      }

      if (!empty($conditions)) {

        // Xây dựng chuỗi điều kiện WHERE từ mảng $conditions
        $where .= "(" . implode(" OR ", $conditions) . ")";
      }
    }

    //xử lý màu
    if ($color != "") {
      if ($where != "") {
        $where .= " AND ";
      }
      $parts = explode(",", $color);
      $conditions = []; // Mảng để chứa các điều kiện

      foreach ($parts as $part) {
        $conditions[] = " pd.color_id = (SELECT id FROM color WHERE name = '$part') ";
      }

      if (!empty($conditions)) {

        // Xây dựng chuỗi điều kiện WHERE từ mảng $conditions
        $where .= "(" . implode(" OR ", $conditions) . ")";
      }
    }

    //xử lý size
    if ($size != "") {
      if ($where != "") {
        $where .= " AND ";
      }
      $parts = explode(",", $size);
      $conditions = []; // Mảng để chứa các điều kiện

      foreach ($parts as $part) {
        $conditions[] = " pd.size_id = (SELECT id FROM size WHERE name = '$part') ";
      }

      if (!empty($conditions)) {

        // Xây dựng chuỗi điều kiện WHERE từ mảng $conditions
        $where .= "(" . implode(" OR ", $conditions) . ")";
      }
    }

    //kết hợp where và query
    if ($where != "") {
      $query .= " WHERE " . $where;
    }

    $query .= " GROUP BY p.id, pd.color_id ";//

    // lấy tổng số lượng
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $rowCount = $stmt->rowCount();

    //giới hạn số lượng sản phẩm lấy
    $query .= " LIMIT $limit OFFSET $offset ";

    $this->conn->exec("SET CHARACTER SET utf8mb4");
    $stmt = $this->conn->prepare($query);
    try {
      $stmt->execute();
    } catch (PDOException $e) {
      echo 'Error: ' . $e->getMessage(); // In thông tin lỗi chi tiết
      // Ghi log lỗi vào file
      error_log('PDOException: ' . $e->getMessage(), 0);
    }
    $products = $stmt->fetchAll(PDO::FETCH_OBJ);

    // $error .= $query;

    return [
      'products' => $products,
      'count' => $rowCount,
      'error' => $error
    ];
  }

  // lấy ra đại diện các sản phẩm theo màu sắc cho khách hàng lựa chọn
  function getProductForShop()
  {
    // số bản ghi trong 1 trang
    $limit = 9;
    // số trang hiện tại
    $page = 0;
    // dữ liệu hiển thị lên view
    $display = "";
    if (isset($_POST['page'])) {
      $page = $_POST['page'];
    } else {
      $page = 1;
    }

    $keyword = "";
    $minPrice = "";
    $maxPrice = "";
    $category = "";
    $brand = "";
    $color = "";
    $size = "";

    if (isset($_POST['minPrice']) && isset($_POST['maxPrice']) && isset($_POST['category']) && isset($_POST['brand']) && isset($_POST['color']) && isset($_POST['size'])) {
      // Gán giá trị cho các biến nếu có
      $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
      $minPrice = $_POST['minPrice'];
      $maxPrice = $_POST['maxPrice'];
      $category = urldecode($_POST['category']);
      $brand = urldecode($_POST['brand']);
      $color = urldecode($_POST['color']);
      $size = $_POST['size'];
    }

    // bắt đầu từ 
    $start_from = ($page - 1) * $limit;
    $limit = 12;
    $offset = ($page - 1) * $limit; // Calculate offset based on current page
    $data = $this->getData($offset, $limit, $keyword, $minPrice, $maxPrice, $category, $brand, $color, $size);
    $display = "<div class='row pb-3'>";
    $display .= $data['error'];

    $products = $data['products'];

    foreach ($products as $product) {
      $price = $product->min_price + (($product->min_price * 10) / 100);
      $price = currency_format($price);
      $image = $product->min_image; // Assuming image path is stored in min_image
      $display .= "
        <div class='col-lg-4 col-md-6 col-sm-12 pb-1 mb-2'>
          <div class='single-product border'>
            <div class='product-img w-100'>
              <img class='w-100 h-100 object-fit-cover' src='" . ASSETS . "img/{$image}'
                alt=''>
            </div>
            <div class='product-details p-2 w-100'>
              <p class='text-primary m-0 p-0'>{$product->brand_name}</p>
              <a href='" . ROOT . "shop/showProductDetail/{$product->product_detail_id}' class='fw-bold link-offset-2 link-underline link-underline-opacity-0'>{$product->name}</a>
              <p class='text-seccondary m-0 p-0'>{$product->category_name}</p>
              <div class='price'>
                <h6 class='text-danger fw-bold'>$price</h6>
              </div>
            </div>
          </div>
        </div>";
    }
    $display .= "</div>";

    // tổng số bản ghi 
    $total_rows = $data['count'];
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


  // lấy ra tổng số tất cả bản ghi
  function getSum()
  {
    $query = "SELECT p.*, pd.color_id, MIN(pd.id) AS product_detail_id, MIN(pd.price) AS min_price, MIN(pd.image) AS min_image,
              c.name AS category_name, b.name AS brand_name
              FROM product p
              INNER JOIN product_detail pd ON p.id = pd.product_id
              INNER JOIN category c ON p.category_id = c.id
              INNER JOIN brand b ON p.brand_id = b.id
              GROUP BY p.id, pd.color_id";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->rowCount(); // sử dụng rowCount() để đếm số hàng trả về từ câu truy vấn
    return $result;
  }

  function showProductDetail($productDetailID)
  {
    $query = "SELECT pd.*, p.name AS product_name, p.description AS product_description, c.name AS category_name, b.name AS brand_name, s.name AS size_name
    FROM product_detail pd
    INNER JOIN product p ON pd.product_id = p.id
    INNER JOIN category c ON p.category_id = c.id
    INNER JOIN brand b ON p.brand_id = b.id
    LEFT JOIN size s ON pd.size_id = s.id
    WHERE pd.id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$productDetailID]);
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $result;
  }

  // lấy ra chi tiết sản phẩm sử dụng màu sắc và mã sản phẩm 
  function getProductDetailByColor($productID, $colorID)
  {
    $query = "SELECT pd.*, p.name AS product_name, p.description AS product_description, c.name AS category_name, b.name AS brand_name, s.name AS size_name
             FROM product_detail pd
             INNER JOIN product p ON pd.product_id = p.id
             INNER JOIN category c ON p.category_id = c.id
             INNER JOIN brand b ON p.brand_id = b.id
             LEFT JOIN size s ON pd.size_id = s.id
             WHERE pd.product_id = ? and pd.color_id = ? LIMIT 1";

    $stmt = $this->conn->prepare($query);
    $stmt->execute([$productID, $colorID]);

    $response = array();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    $response['id'] = $result[0]->id;
    $response['product_id'] = $result[0]->product_id;
    $response['size_id'] = $result[0]->size_id;
    $response['color_id'] = $result[0]->color_id;
    $response['quantity'] = $result[0]->quantity;
    $response['price'] = $result[0]->price;
    $response['image'] = $result[0]->image;
    echo json_encode($response); // Fetch single associative array
  }

  // lấy ra các biến thể kích cỡ của 1 sản phẩm dựa trên màu sắc
  function getAllSizeByColor($productID, $colorID)
  {
    $display = "";
    $display .= "
      <p class='text-dark font-weight-medium mb-0 mr-3'>Kích cỡ:</p>
      
    ";
    $query = "SELECT s.id AS size_id, s.name AS size_name, pd.quantity
    FROM product_detail pd
    INNER JOIN size s ON pd.size_id = s.id
    WHERE pd.product_id = ? AND pd.color_id = ?";

    $stmt = $this->conn->prepare($query);
    $stmt->execute([$productID, $colorID]);
    $sizes = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($sizes as $size) {
      if ($size->quantity > 0) {
        $display .= "
        <div class='custom-control custom-radio custom-control-inline'>
          <input type='radio' class='btn-check ' name='sizes' id='{$size->size_id} - {$size->size_name}' autocomplete='off'>
          <label class='btn btn-outline-primary ' for='{$size->size_id} - {$size->size_name}'>{$size->size_name}</label>
        </div>
        ";
      } else if ($size->quantity == 0) {
        $display .= "
        <div class='custom-control custom-radio custom-control-inline'>
          <input disabled type='radio' class='btn-check ' name='sizes' id='{$size->size_id} - {$size->size_name}' autocomplete='off'>
          <label class='btn btn-outline-primary ' for='{$size->size_id} - {$size->size_name}'>{$size->size_name}</label>
        </div>
        ";
      }

    }
    echo $display;
  }


  function getAllProductDetailByProductID($id)
  {
    $query = "SELECT pd.id, p.id AS product_id, p.name, p.description, pd.price, c.name AS color_name, s.name AS size_name, pd.image
    FROM product_detail pd
    INNER JOIN product p ON pd.product_id = p.id
    INNER JOIN color c ON pd.color_id = c.id
    INNER JOIN size s ON pd.size_id = s.id
    WHERE p.id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $result;
  }

  function getProductDetail($product_id, $color_name, $size_name)
  {
    $query = "SELECT pd.id, p.id AS product_id, p.name, p.description, pd.price, c.name AS color_name, s.name AS size_name, pd.image
    FROM product_detail pd
    INNER JOIN product p ON pd.product_id = p.id
    INNER JOIN color c ON pd.color_id = c.id
    INNER JOIN size s ON pd.size_id = s.id
    WHERE p.id = 20 and c.name = ? and s.name= ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$product_id, $color_name, $size_name]);
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $result;
  }

  // hàm lấy ra chi tiết sản phẩm sử dụng mã sản phẩm, mã màu, mã kích cỡ
  function getProductDetailByProductIDColorIDSizeID($product_id, $color_id, $size_id)
  {
    $query = "SELECT * from product_detail where product_id = ? and color_id = ? and size_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$product_id, $color_id, $size_id]);
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $result;
  }

  function getAllColorByProductID($productID, $colorID)
  {
    $display = "";
    $query = "SELECT DISTINCT pd.color_id, c.name FROM product_detail pd
              JOIN color c ON pd.color_id = c.id
              WHERE pd.product_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$productID]);
    $colors = $stmt->fetchAll(PDO::FETCH_OBJ);
    foreach ($colors as $color) {
      if ($color->name == $colorID) {
        $display .= "
        <div class='custom-control custom-radio custom-control-inline'>
          <input checked type='radio' class='custom-control-input' id='' name='color' value='{$color->name}'>
          <label class='custom-control-label' for='color'>{$color->name}</label>
        </div>      
        ";
      } else {
        $display .= "
        <div class='custom-control custom-radio custom-control-inline'>
          <input type='radio' class='custom-control-input' id='' name='color' value='{$color->name}'>
          <label class='custom-control-label' for='color'>{$color->name}</label>
        </div>      
        ";
      }

    }
    echo $display;
  }

  function getProductDetailByID($id)
  {
    $query = "SELECT pd.id, p.name, p.description, pd.price, c.name AS color_name, s.name AS size_name, pd.image
    FROM product_detail pd
    INNER JOIN product p ON pd.product_id = p.id
    INNER JOIN color c ON pd.color_id = c.id
    INNER JOIN size s ON pd.size_id = s.id
    WHERE pd.id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $result;
  }
  function updateQuantity($id)
  {
    // Prepare and execute the update query with parameter binding
    $query = "UPDATE product_detail SET quantity = quantity - 1 WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
  }
}