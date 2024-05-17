<?php
class AdminSizeModel extends Database
{
  // lấy toàn bộ bản ghi thuộc bảng kích cỡ (có phân trang)
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
    $query = "SELECT * FROM size ORDER BY id LIMIT {$start_from}, {$limit}";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $sizes = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display = "
    <div class='table-responsive mb-3'>
    <table id='displayDataTable' class='table text-start align-middle table-bordered table-hover mb-0'>
      <thead>
        <tr class='text-dark'>
          <th scope='col'>ID</th>
          <th scope='col'>Tên Kích Cỡ</th>
          <th scope='col'>Thao Tác</th>
        </tr>
      </thead>
      <tbody>
    ";
    $count = $this->getSum();
    if ($count > 0) {
      foreach ($sizes as $size) {
        $display .=
          "<tr>
            <td>{$size->id}</td>
            <td>{$size->name}</td>
            <td>
              <button class='btn btn-sm btn-warning' onclick='get_detail({$size->id})'><i class='fa-solid fa-pen-to-square'></i></button>
              <button class='btn btn-sm btn-danger' onclick='delete_size({$size->id})'><i class='fa-solid fa-trash'></i></button>
            </td>
          </tr>";
      }
    } else {
      $display .= "
        <tr>
          <td> Không có dữ liệu </td>
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


  function getAllSize()
  {
    $display = "";
    $query = "SELECT * FROM size ORDER BY id";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $display .= "
    <option value='0'>Chọn kích cỡ</option>
    ";
    $sizes = $stmt->fetchAll(PDO::FETCH_OBJ);
    foreach ($sizes as $size) {
      $display .= "
      <option value='{$size->id}'>{$size->name}</option>
      ";
    }
    echo $display;
  }


  // lấy ra tổng số tất cả bản ghi
  function getSum()
  {
    $query = "SELECT COUNT(*) AS total FROM size";
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

    $query = "SELECT * FROM size WHERE name LIKE :keyword ORDER BY id LIMIT $start_from, $limit";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([
      ':keyword' => '%' . $keyword . '%',
    ]);
    $sizes = $stmt->fetchAll(PDO::FETCH_OBJ);


    $display = "
    <div class='table-responsive mb-3'>
    <table id='displayDataTable' class='table text-start align-middle table-bordered table-hover mb-0'>
      <thead>
        <tr class='text-dark'>
          <th scope='col'>ID</th>
          <th scope='col'>Tên Thương Hiệu</th>
          <th scope='col'>Thao Tác</th>
        </tr>
      </thead>
      <tbody>";

    $count = $this->getSumByKeyword($keyword);
    if ($count > 0) {
      foreach ($sizes as $size) {
        $display .=
          "<tr>
            <td>{$size->id}</td>
            <td>{$size->name}</td>
            <td>
              <button class='btn btn-sm btn-warning' onclick='get_detail({$size->id})'><i class='fa-solid fa-pen-to-square'></i></button>
              <button class='btn btn-sm btn-danger' onclick='delete_size({$size->id})'><i class='fa-solid fa-trash'></i></button>
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
    $query = "SELECT COUNT(*) AS total FROM size where name LIKE :keyword";
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
  function insert($POST)
  {
    if (isset($POST['size_name'])) {
      $size_name = $POST['size_name'];
      $query = 'INSERT INTO `size` (name, status) VALUES (?, ?)';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$size_name, 1]);
      $rowCount = $stmt->rowCount();
      if ($rowCount > 0) {
        echo "Insert successfully";
      } else {
        echo "Fail";
      }
    } else {
      echo "Fail";
    }
  }

  function checkDuplicate($POST)
  {
    if (isset($POST['size_name'])) {
      $size_name = $POST['size_name'];
      $query = 'SELECT * FROM size WHERE name = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$size_name]);
      $rowCount = $stmt->rowCount();
      if ($rowCount > 0) {
        echo "Đã tồn tại";
      } else {
        echo "Duy nhất";
      }
    } else {
      echo "Lỗi";
    }
  }

  function delete($id)
  {
    $query = 'DELETE FROM size WHERE id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Thành công";
    } else {
      echo "Thất bại";
    }
  }

  function getByID($id)
  {
    $query = 'SELECT * FROM size WHERE id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $response = array();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    $response['id'] = $result[0]->id;
    $response['name'] = $result[0]->name;
    echo json_encode($response);
  }

  function update($POST)
  {
    if (isset($POST['update_sizeName'])) {
      $size_id = $POST['hidden_data'];
      $size_name = $POST['update_sizeName'];
      $query = 'UPDATE size set name = ? WHERE id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$size_name, $size_id]);
      $rowCount = $stmt->rowCount();
      if ($rowCount > 0) {
        echo "Update successfully";
      } else {
        echo "Fail";
      }
    } else {
      echo "Fail";
    }
  }
}
?>