<?php
class AdminProductModel extends Database
{

  function getStats(){
    $display = "";


 $tongtien = currency_format1($this->getDailyRevenue());
    $display ="<div class='row g-4'>
    <div class='col-sm-6 col-xl-3'>
      <div class='bg-light rounded d-flex align-items-center justify-content-between p-4'>
        <i class='fa fa-chart-line fa-3x text-primary'></i>
        <div class='ms-3'>
          <p class='mb-2'>Doanh thu ngày</p>
          <div class='mb-0' id='showDay' >". $tongtien . "</div>
        </div>
      </div>
</div>";
    $display .="<div class='col-sm-6 col-xl-3'>
    <div class='bg-light rounded d-flex align-items-center justify-content-between p-4'>
      <i class='fa fa-chart-bar fa-3x text-primary'></i>
      <div class='ms-3'>
        <p class='mb-2'>Tổng doanh thu</p>
        <h6 class='mb-0'>".currency_format1($this->getYearRenvenue()) ."</h6>
      </div>
    </div>
  </div>";
  $display .= "<div class='col-sm-6 col-xl-3'>
  <div class='bg-light rounded d-flex align-items-center justify-content-between p-4'>
    <i class='fa fa-chart-area fa-3x text-primary'></i>
    <div class='ms-3'>
      <p class='mb-2'>Lợi nhuận tháng</p>
      <h6 class='mb-0'>". currency_format1($this->getMonthlyProfit())."</h6>
    </div>
  </div>
  </div>";
  $display .=  "<div class='col-sm-6 col-xl-3'>
  <div class='bg-light rounded d-flex align-items-center justify-content-between p-4'>
    <i class='fa fa-chart-pie fa-3x text-primary'></i>
    <div class='ms-3'>
      <p class='mb-2'>Tổng lợi nhuận</p>
      <h6 class='mb-0'>". currency_format1($this->getTotalProfit()) ."</h6>
    </div>
  </div>
</div>
</div>";

$display .= "

";
  

    // // Lấy lợi nhuận tháng hiện tại
  

    // $stmt = $this->conn->prepare($query);
    // $stmt->execute();
    // $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // $NhapMonth = $result['total'];

    // $query = "
    // SELECT SUM(order_total) AS total
    // FROM `order`
    // WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())";

    // $stmt = $this->conn->prepare($query);
    // $stmt->execute();
    // $result = $stmt->fetch(PDO::FETCH_ASSOC);
    // $DTMonth = $result['total'];

    // $LNMonth = $DTMonth - $NhapMonth;
    // $LNMonth = currency_format($LNMonth);

    // // Lấy tổng lợi nhuận
    // $query = "
    // SELECT SUM(total) AS total
    // FROM `invoice`";

    // $stmt = $this->conn->prepare($query);
    // $stmt->execute();
    // $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // $totalNhap = $result['total'];
    // $totalLN = $totalDT - $totalNhap;
    // $totalLN = currency_format($totalLN);

    // // Lấy doanh thu từng tháng
    // $DTMonthArr = array();

    // $month = 1;
    // for($month = 1; $month <=12;$month++){
    //   $query = "
    //   SELECT SUM(order_total) AS total
    //   FROM `order`
    //   WHERE MONTH(date) = {$month} AND YEAR(date) = YEAR(CURDATE())";
  
    //   $stmt = $this->conn->prepare($query);
    //   $stmt->execute();
    //   $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
    //   $tempMonth = $result['total'];
    //   $tempMonth = currency_format($tempMonth);

    //   $DTMonthArr[$month] = $tempMonth;
    // }
    
    // // Lấy lợi nhuận từng tháng
    // $LNMonthArr = array();

    // $month = 1;
    // for($month = 1; $month <=12;$month++){
    //   $query = "
    //   SELECT SUM(total) AS total
    //   FROM `invoice`
    //   WHERE MONTH(create_date) = {$month} AND YEAR(create_date) = YEAR(CURDATE())";
  
    //   $stmt = $this->conn->prepare($query);
    //   $stmt->execute();
    //   $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
    //   $tempMonth = $result['total'];
    //   $tempMonth = $DTMonthArr[$month] - $tempMonth;
    //   $tempMonth = currency_format($tempMonth);

    //   $LNMonthArr[$month] = $tempMonth;
    // }

    // $NewResult['TongDT'] = $totalDT;
    // $NewResult['LoiNhuanThang'] =  $LNMonth;
    // $NewResult['TongLoiNhuan'] = $totalLN;
    // $NewResult['DTThang'] = $DTMonthArr;
    // $NewResult['LNThang'] = $LNMonthArr;

 echo $display;
  }
    function chart ()
    {
      
    }

function getDailyRevenue(){
  $query = "";
    // Lấy doanh thu ngày
    $query = "
    SELECT SUM(order_total) AS total
    FROM `order`
    WHERE DATE(date) = CURDATE()
    GROUP BY date";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if($result)
    {
      $tongtien=$result->total;
    }else{
      $tongtien = 0;
  }

 return $tongtien;
}
function getYearRenvenue(){
    //Lấy tổng doanh thu
    $query = "
    SELECT SUM(order_total) AS total
    FROM `order`
    WHERE YEAR(date) = YEAR(CURDATE())
  ";
  $stmt = $this->conn->prepare($query);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_OBJ);
  if($result)
  {
    $tongtien=$result->total;
  }else{
    $tongtien = 0;
}

return $tongtien;
}
function getMonthlyProfit(){
  $query = "
  SELECT 
  COALESCE((SELECT SUM(order_total) FROM `order` WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())), 0) 
  - 
  COALESCE((SELECT SUM(total) FROM `invoice` WHERE MONTH(create_date) = MONTH(CURDATE()) AND YEAR(create_date) = YEAR(CURDATE())), 0) 
  AS profit";
  $stmt = $this->conn->prepare($query);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_OBJ);
  if($result)
  {
    $tongtien=$result->profit;
  }else{
    $tongtien = 0;
}
 return $tongtien;
}

function getTotalProfit()
{
  $query = "SELECT 
  COALESCE((SELECT SUM(order_total) FROM `order` ), 0) 
  - 
  COALESCE((SELECT SUM(total) FROM `invoice`), 0) 
  AS profit";

 $stmt = $this->conn->prepare($query);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_OBJ);
  if($result)
  {
    $tongtien=$result->profit;
  }else{
    $tongtien = 0;
}
 return $tongtien;

}
  // lấy toàn bộ bản ghi thuộc bảng sản phẩm (có phân trang)
  function getAll()
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
    // bắt đầu từ 
    $start_from = ($page - 1) * $limit;
    $query = "SELECT p.id, c.name as category_name, b.name as brand_name, s.name as supplier_name, p.name
    FROM product p
    INNER JOIN category c ON p.category_id = c.id
    INNER JOIN brand b ON p.brand_id = b.id
    INNER JOIN supplier s ON p.supplier_id = s.id
    ORDER BY p.id LIMIT {$start_from}, {$limit}";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display = "
    <div class='table-responsive mb-3'>
    <table id='displayDataTable' class='table table-striped text-start align-middle table-bordered table-hover mb-0'>
      <thead>
        <tr class='text-dark'>
          <th scope='col'>ID</th>
          <th scope='col'>Thể loại</th>
          <th scope='col'>Thương hiệu</th>
          <th scope='col'>Nhà cung cấp</th>
          <th scope='col'>Sản phẩm</th>
          <th scope='col'>Thao Tác</th>
        </tr>
      </thead>
      <tbody>
    ";
    $count = $this->getSum();
    if ($count > 0) {
      foreach ($products as $product) {
        $display .=
          "<tr>
            <td>{$product->id}</td>
            <td>{$product->category_name}</td>
            <td>{$product->brand_name}</td>
            <td>{$product->supplier_name}</td>
            <td>{$product->name}</td>
            <td>
              <a href='" . ROOT . "AdminProduct/getDetail/{$product->id}' class='btn btn-sm btn-warning'><i class='fa-solid fa-pen-to-square'></i></a>
              <button class='btn btn-sm btn-danger' onclick='delete_product({$product->id})'><i class='fa-solid fa-trash'></i></button>
              <a href='" . ROOT . "AdminProduct/ProductDetail/{$product->id}' class='btn btn-sm btn-primary' onclick=''><i class='fa-solid fa-eye'></i></a>
            </td>
          </tr>";
      }
    } else {
      $display .= "
        <tr>
          <td colspan='6' class='text-center'> Không có dữ liệu </td>
        </tr>
      ";
    }

    $display .= "
        </tbody>
      </table>
    </div>
    ";
    // tổng số bản ghi 
    $total_rows = $this->getSum();
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

  function getAllProduct()
  {
    $display = "";
    $query = "SELECT p.id, c.name as category_name, b.name as brand_name, s.name as supplier_name, p.name
    FROM product p
    INNER JOIN category c ON p.category_id = c.id
    INNER JOIN brand b ON p.brand_id = b.id
    INNER JOIN supplier s ON p.supplier_id = s.id
    ORDER BY p.id";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display .= "<option selected value='All'>All</option>";
    foreach ($products as $product) {
      $display = "<option value='{$product->id}'>{$product->name}</option>";
    }
    echo $display;
  }


  // lấy ra tổng số tất cả bản ghi
  function getSum()
  {
    $query = "SELECT COUNT(*) AS total FROM product";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result->total;
    } else {
      return 0;
    }
  }


  // Tìm kiếm toàn bộ bản ghi thuộc bảng sản phẩm có từ khóa liên quan (có phân trang)
  function search($keyword)
  {

    // số bản ghi trong 1 trang
    $limit = 4;
    // số trang hiện tại
    $page = 0;
    // dữ liệu hiển thị sang view
    $display = "";
    if (isset($_POST['page'])) {
      $page = $_POST['page'];
    } else {
      $page = 1;
    }
    // bắt đầu
    $start_from = ($page - 1) * $limit;

    $query = "SELECT p.id, c.name as category_name, b.name as brand_name, s.name as supplier_name, p.name
    FROM product p
    INNER JOIN category c ON p.category_id = c.id
    INNER JOIN brand b ON p.brand_id = b.id
    INNER JOIN supplier s ON p.supplier_id = s.id
    WHERE c.name LIKE :keyword OR b.name LIKE :keyword OR s.name OR p.name LIKE :keyword
    ORDER BY p.id
    LIMIT {$start_from}, {$limit}";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([
      'keyword' => '%' . $keyword . '%',
    ]);
    $products = $stmt->fetchAll(PDO::FETCH_OBJ);


    $display = "
    <div class='table-responsive mb-3'>
    <table id='displayDataTable' class='table text-start align-middle table-bordered table-hover mb-0'>
      <thead>
        <tr class='text-dark'>
          <th scope='col'>ID</th>
          <th scope='col'>Thể loại</th>
          <th scope='col'>Thương hiệu</th>
          <th scope='col'>Nhà cung cấp</th>
          <th scope='col'>Sản phẩm</th>
          <th scope='col'>Thao Tác</th>
        </tr>
      </thead>
      <tbody>";

    $count = $this->getSumByKeyword($keyword);
    if ($count > 0) {
      foreach ($products as $product) {
        $display .=
          "<tr>
          <td>{$product->id}</td>
          <td>{$product->category_name}</td>
          <td>{$product->brand_name}</td>
          <td>{$product->supplier_name}</td>
          <td>{$product->name}</td>
              <td>
              <a href='" . ROOT . "AdminProduct/getDetail/{$product->id}' class='btn btn-sm btn-warning'><i class='fa-solid fa-pen-to-square'></i></a>
                <button class='btn btn-sm btn-danger' onclick='delete_size({$product->id})'><i class='fa-solid fa-trash'></i></button>
              </td>
            </tr>";
      }
    } else {
      $display .= '
          <tr>
            <td>There is no data found</td>
          </tr>
        ';
    }

    $display .= '
          </tbody>
        </table>
      </div>';


    $total_rows = $this->getSumByKeyword($keyword);
    $total_pages = ceil($total_rows / $limit);

    $display .= "
      <div class='col-12 pb-1'>
        <nav aria-label='Page navigation'>
        <ul class='pagination justify-content-center mb-3'>";
    if ($page > 1) {
      $prev_active = "";
      $prev = $page - 1;
      $display .= "
        <li class='page-item {$prev_active}'>
          <a onclick='changePageSearch(\"$keyword\", $prev)' id = '{$prev}' class='page-link' href='#' aria-label='Previous'>
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
      $display .= "<li class='page-item {$active_class} '><a onclick='changePageSearch(\"$keyword\", $i)' id = '$i' class='page-link' href='#'>$i</a></li>";
    }

    $next_active = "";
    if ($page == $total_pages) {
      $next_active = "disabled";
      $display .= "
            <li class='page-item'>
            <a id='' class='page-link {$next_active}' href='#' aria-label='Next'>
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
            <a onclick='changePageSearch(\"$keyword\", $next)' id='{$next}' class='page-link {$next_active}' href='#' aria-label='Next'>
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


  // lấy ra tổng số tất cả bản ghi có từ khóa liên quan
  function getSumByKeyWord($keyword)
  {
    $query = "SELECT COUNT(*) AS total
              FROM product p
              INNER JOIN category c ON p.category_id = c.id
              INNER JOIN brand b ON p.brand_id = b.id
              INNER JOIN supplier s ON p.supplier_id = s.id
              WHERE p.name LIKE :keyword
              OR c.name LIKE :keyword
              OR b.name LIKE :keyword
              OR s.name LIKE :keyword";
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(':keyword', '%' . $keyword . '%');
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
      return $result['total'];
    } else {
      return 0;
    }
  }

  function insert($POST)
  {
    $product_category = $POST['product_category'];
    $product_brand = $POST['product_brand'];
    $product_supplier = $POST['product_supplier'];
    $product_name = $POST['product_name'];
    $product_description = $POST['product_description'];
    $query = "INSERT INTO `product`(`category_id`, `brand_id`, `supplier_id`, `name`, `description`) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$product_category, $product_brand, $product_supplier, $product_name, $product_description]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Thêm thành công";
    } else {
      echo "Thêm thất bại";
    }
  }

  function getByID($id)
  {
    $query = "SELECT * FROM product WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $result[0];
  }

  function getAllProductBySupplierName($supplier_name)
  {
    $display = "";
    $display .= "<option id=''  value=''>Chọn sản phẩm</option>";
    $query = "SELECT p.id, c.name as category_name, b.name as brand_name, s.name as supplier_name, p.name
    FROM product p
    INNER JOIN category c ON p.category_id = c.id
    INNER JOIN brand b ON p.brand_id = b.id
    INNER JOIN supplier s ON p.supplier_id = s.id
    WHERE s.name = ?
    ORDER BY p.id";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$supplier_name]);
    $products = $stmt->fetchAll(PDO::FETCH_OBJ);
    foreach ($products as $product) {
      $display .= "<option id='{$product->name}'  value='{$product->id}'>{$product->name}</option>";
    }
    echo $display;
  }

  function update($POST)
  {
    $product_category = $POST['product_category'];
    $product_brand = $POST['product_brand'];
    $product_supplier = $POST['product_supplier'];
    $product_name = $POST['product_name'];
    $product_description = $POST['product_description'];
    $product_id = $POST['product_id'];
    $query = "UPDATE `product` SET `category_id`=?,`brand_id`=?,`supplier_id`=?,`name`=?,`description`=? WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$product_category, $product_brand, $product_supplier, $product_name, $product_description, $product_id]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Sửa thành công";
    } else {
      echo "Sửa thất bại";
    }
  }

  // xóa 1 bản ghi màu sắc
  function delete($id)
  {
    $query = 'DELETE FROM product WHERE id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Thành công";
    } else {
      echo "Thất bại";
    }
  }


}