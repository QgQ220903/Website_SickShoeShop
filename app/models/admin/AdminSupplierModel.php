<?php
class AdminSupplierModel extends Database
{
  // lấy toàn bộ bản ghi thuộc bảng nhà cung cấp (có phân trang)
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
    $query = "SELECT * FROM supplier ORDER BY id LIMIT {$start_from}, {$limit}";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $suppliers = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display = "
    <div class='table-responsive mb-3'>
    <table id='displayDataTable' class='table table-striped text-start align-middle table-bordered table-hover mb-0'>
      <thead>
        <tr class='text-dark'>
          <th scope='col'>Mã nhà cung cấp</th>
          <th scope='col'>Tên nhà cung cấp</th>
          <th scope='col'>Số điện thoại</th>
          <th scope='col'>Email</th>
          <th scope='col'>Thao Tác</th>
        </tr>
      </thead>
      <tbody>
    ";
    $count = $this->getSum();
    if ($count > 0) {
      foreach ($suppliers as $supplier) {
        $display .=
          "<tr class='form-switch'>
            <td>{$supplier->id}</td>
            <td>{$supplier->name}</td>
            <td>{$supplier->phone}</td>
            <td>{$supplier->email}</td>
            <td>
              <button class='btn btn-sm btn-warning' onclick='get_detail({$supplier->id})'><i class='fa-solid fa-pen-to-square'></i></button>
              <button class='btn btn-sm btn-danger' onclick='delete_supplier({$supplier->id})'><i class='fa-solid fa-trash'></i></button>
              <button class='btn btn-sm btn-primary' onclick='show_detail({$supplier->id})'><i class='fa-solid fa-eye'></i></button>
            </td>
          </tr>";
      }
    } else {
      $display .= "
        <tr>
          <td colspan='5' class='text-center'> Không có dữ liệu </td>
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


  // lấy ra tổng số tất cả bản ghi
  function getSum()
  {
    $query = "SELECT COUNT(*) AS total FROM supplier";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result->total;
    } else {
      return 0;
    }
  }


  // Tìm kiếm toàn bộ bản ghi thuộc bảng kích cỡ có từ khóa liên quan (có phân trang)
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

    $query = "SELECT * FROM supplier WHERE name LIKE :keyword ORDER BY id LIMIT $start_from, $limit";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([
      ':keyword' => '%' . $keyword . '%',
    ]);
    $suppliers = $stmt->fetchAll(PDO::FETCH_OBJ);


    $display = "
    <div class='table-responsive mb-3'>
    <table id='displayDataTable' class='table text-start align-middle table-bordered table-hover mb-0'>
      <thead>
        <tr class='text-dark'>
        <th scope='col'>ID</th>
        <th scope='col'>Tên nhà cung cấp</th>
        <th scope='col'>Số điện thoại</th>
        <th scope='col'>Email</th>
        <th scope='col'>Địa chỉ</th>
        <th scope='col'>Thao Tác</th>
        </tr>
      </thead>
      <tbody>";

    $count = $this->getSumByKeyword($keyword);
    if ($count > 0) {
      foreach ($suppliers as $supplier) {
        $display .=
          "<tr>
            <td>{$supplier->id}</td>
            <td>{$supplier->name}</td>
            <td>{$supplier->phone}</td>
            <td>{$supplier->email}</td>
            <td>{$supplier->address}</td>
            <td>
              <button class='btn btn-sm btn-warning' onclick='get_detail({$supplier->id})'><i class='fa-solid fa-pen-to-square'></i></button>
              <button class='btn btn-sm btn-danger' onclick='delete_supplier({$supplier->id})'><i class='fa-solid fa-trash'></i></button>
            </td>
          </tr>";
      }
    } else {
      $display .= "
        <tr>
          <td colspan = 6 class='text-center'>Không tìm thấy dữ liệu</td>
        </tr>
      ";
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
    $query = "SELECT COUNT(*) AS total FROM supplier where name LIKE :keyword";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([
      ':keyword' => '%' . $keyword . '%',
    ]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result->total;
    } else {
      return 0;
    }
  }

  function getAllSuppliers($id)
  {
    $display = "";
    $display .= "<option value='0'>Chọn nhà cung cấp</option>";
    $query = "SELECT * FROM supplier ORDER BY id";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $suppliers = $stmt->fetchAll(PDO::FETCH_OBJ);
    if ($id == 0) {
      foreach ($suppliers as $supplier) {
        $display .= "
        <option value='{$supplier->id}'>{$supplier->name}</option>
      ";
      }
    } else {
      foreach ($suppliers as $supplier) {
        if ($supplier->id == $id) {
          $display .= "
          <option selected value='{$supplier->id}'>{$supplier->name}</option>
        ";
        } else {
          $display .= "
          <option value='{$supplier->id}'>{$supplier->name}</option>
        ";
        }
      }
    }
    echo $display;
  }
  function insert($POST)
  {
    $supplier_name = $POST['supplier_name'];
    $supplier_phone = $POST['supplier_phone'];
    $supplier_email = $POST['supplier_email'];
    $supplier_address = $POST['supplier_address'];
    $ward = $POST['ward']; // Thay $supplier_address thành $ward
    $province = $POST['province']; // Thay $supplier_address thành $province
    $district = $POST['district']; // Thay $supplier_address thành $district
    // Truy vấn để lấy address_id từ ward, district, province
    $addressQuery = 'SELECT id FROM `address` WHERE province_id = ? AND district_id = ? AND ward_id = ? AND street_name = ?';
    $addressStmt = $this->conn->prepare($addressQuery);
    $addressStmt->execute([$province, $district, $ward, $supplier_address]);
    $addressRow = $addressStmt->fetch(PDO::FETCH_ASSOC);
    $address_id = $addressRow['id'];

    // Thực hiện truy vấn thêm dữ liệu nhà cung cấp vào cơ sở dữ liệu
    $query = 'INSERT INTO `supplier` (name, phone, email, address, status) VALUES (?, ?, ?, ?, ?)';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$supplier_name, $supplier_phone, $supplier_email, $address_id, 1]);
    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
      echo "Thêm thành công";
    } else {
      echo "Thêm thất bại";
    }
  }

  // kiểm tra trùng lặp dữ liệu nhà cung cấp
  function checkDuplicate($POST)
  {
    $phone = $POST['phone'];
    $email = $POST['email'];
    $address = $POST['address'];
    $query = 'SELECT * FROM supplier WHERE (phone = ? OR email = ? OR address = ?) AND status = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$phone, $email, $address, 1]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      $duplicateFields = array();
      while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        if ($row->phone == $phone) {
          $duplicateFields[] = 'Số điện thoại';
        }
        if ($row->email == $email) {
          $duplicateFields[] = 'Email';
        }
        if ($row->address == $address) {
          $duplicateFields[] = 'Địa chỉ';
        }
      }
      $duplicateFieldsStr = implode(', ', $duplicateFields);
      echo "Dữ liệu trùng lặp: $duplicateFieldsStr";
    } else {
      echo "Không có dữ liệu trùng lặp";
    }
  }

  // kiểm tra trùng lặp dữ liệu nhà cung cấp
  function checkDuplicateUpdate($POST)
  {
    $id = $POST['supplier_id'];
    $phone = $POST['phone'];
    $email = $POST['email'];
    $address = $POST['address'];
    $query = 'SELECT * FROM supplier WHERE (phone = ? OR email = ? OR address = ?) AND status = ? AND id <> ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$phone, $email, $address, 1, $id]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      $duplicateFields = array();
      while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        if ($row->phone == $phone) {
          $duplicateFields[] = 'Số điện thoại';
        }
        if ($row->email == $email) {
          $duplicateFields[] = 'Email';
        }
        if ($row->address == $address) {
          $duplicateFields[] = 'Địa chỉ';
        }
      }
      $duplicateFieldsStr = implode(', ', $duplicateFields);
      echo "Dữ liệu trùng lặp: $duplicateFieldsStr";
    } else {
      echo "Không có dữ liệu trùng lặp";
    }
  }

  function delete($POST)
  {
    $id = $POST['id'];
    try {
      $query = 'DELETE FROM supplier WHERE id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$id]);
      $rowCount = $stmt->rowCount();

      if ($rowCount > 0) {
        echo "Xóa thành công";
      } else {
        echo "Xóa thất bại";
      }
    } catch (PDOException $e) {
      echo "Không thể xóa nhà cung cấp";
    }

  }

  function getByID($id)
  {
    $query = 'SELECT s.*, a.province_id, a.district_id, a.ward_id, a.street_name
    FROM supplier s
    INNER JOIN address a ON s.address = a.id
    WHERE s.id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (!empty($result)) {
      $response['id'] = $result[0]->id;
      $response['name'] = $result[0]->name;
      $response['phone'] = $result[0]->phone;
      $response['email'] = $result[0]->email;
      $response['address'] = $result[0]->address;
      $response['status'] = $result[0]->status;
      $response['province_id'] = $result[0]->province_id;
      $response['district_id'] = $result[0]->district_id;
      $response['ward_id'] = $result[0]->ward_id;
      $response['street_name'] = $result[0]->street_name;
      echo json_encode($response);
    } else {
      echo "Không tìm thấy dữ liệu.";
    }
  }

  function update($POST)
  {
    if (isset($POST['supplier_name'])) {
      $supplier_id = $POST['supplier_id'];
      $supplier_name = $POST['supplier_name'];
      $supplier_phone = $POST['supplier_phone'];
      $supplier_email = $POST['supplier_email'];
      $supplier_address = $POST['supplier_address'];
      $ward = $POST['ward']; // Thay $supplier_address thành $ward
      $province = $POST['province']; // Thay $supplier_address thành $province
      $district = $POST['district']; // Thay $supplier_address thành $district
      // Truy vấn để lấy address_id từ ward, district, province
      $addressQuery = 'SELECT id FROM `address` WHERE province_id = ? AND district_id = ? AND ward_id = ? AND street_name = ?';
      $addressStmt = $this->conn->prepare($addressQuery);
      $addressStmt->execute([$province, $district, $ward, $supplier_address]);
      $addressRow = $addressStmt->fetch(PDO::FETCH_ASSOC);
      $address_id = $addressRow['id'];

      $query = 'UPDATE supplier set name = ?, phone = ?, email = ?, address = ? WHERE id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$supplier_name, $supplier_phone, $supplier_email, $address_id, $supplier_id]);
      $rowCount = $stmt->rowCount();
      if ($rowCount > 0) {
        echo "Sửa thành công";
      } else {
        echo "Sửa thất bại";
      }
    } else {
      echo "Thất bại";
    }
  }



}
?>