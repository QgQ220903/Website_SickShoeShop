<?php

class AdminColorModel extends Database
{

  // lấy toàn bộ bản ghi thuộc bảng màu sắc (có phân trang)
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
    $query = "SELECT * FROM color ORDER BY id LIMIT {$start_from}, {$limit}";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $colors = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display = "
    <div class='table-responsive mb-3'>
    <table id='displayDataTable' class='table text-start align-middle table-bordered table-hover mb-0'>
      <thead>
        <tr class='text-dark'>
          <th scope='col'>ID</th>
          <th scope='col'>Tên màu sắc</th>
          <th scope='col'>Thao Tác</th>
        </tr>
      </thead>
      <tbody>
    ";
    $count = $this->getSum();
    if ($count > 0) {
      foreach ($colors as $color) {
        $display .=
          "<tr>
            <td>{$color->id}</td>
            <td>{$color->name}</td>
            <td>
              <button class='btn btn-sm btn-warning' onclick='get_detail({$color->id})'><i class='fa-solid fa-pen-to-square'></i></button>
              <button class='btn btn-sm btn-danger' onclick='delete_color({$color->id})'><i class='fa-solid fa-trash'></i></button>
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
  // lấy toàn bộ bản ghi thuộc bảng màu sắc (không phân trang)
  function getAllColor()
  {
    $display = "";
    $query = "SELECT * FROM color ORDER BY id";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $display .= "
    <option value='0'>Chọn màu sắc</option>
    ";
    $colors = $stmt->fetchAll(PDO::FETCH_OBJ);
    foreach ($colors as $color) {
      $display .= "
      <option value='{$color->id}'>{$color->name}</option>
      ";
    }
    echo $display;
  }


  // lấy ra tổng số tất cả bản ghi
  function getSum()
  {
    $query = "SELECT COUNT(*) AS total FROM color";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result->total;
    } else {
      return 0;
    }
  }


  // Tìm kiếm toàn bộ bản ghi thuộc bảng màu sắc có từ khóa liên quan (có phân trang)
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

    $query = "SELECT * FROM color WHERE name LIKE :keyword ORDER BY id LIMIT $start_from, $limit";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([
      ':keyword' => '%' . $keyword . '%',
    ]);
    $colors = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display = "
      <div class='table-responsive mb-3'>
      <table id='displayDataTable' class='table text-start align-middle table-bordered table-hover mb-0'>
        <thead>
          <tr class='text-dark'>
            <th scope='col'>ID</th>
            <th scope='col'>Tên màu sắc</th>
            <th scope='col'>Thao tác</th>
          </tr>
        </thead>
        <tbody>";
    $count = $this->getSumByKeyword($keyword);
    if ($count > 0) {
      foreach ($colors as $color) {
        $display .=
          "<tr>
              <td>{$color->id}</td>
              <td>{$color->name}</td>
              <td>
                <button class='btn btn-sm btn-warning' onclick='get_detail({$color->id})'><i class='fa-solid fa-pen-to-square'></i></button>
                <button class='btn btn-sm btn-danger' onclick='delete_color({$color->id})'><i class='fa-solid fa-trash'></i></button>
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
    $query = "SELECT COUNT(*) AS total FROM color where name LIKE :keyword";
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


  // kiểm tra trùng lặp
  function checkDuplicate($POST)
  {
    if (isset($POST['color_name'])) {
      $color_name = $POST['color_name'];
      $query = 'SELECT * FROM color WHERE name = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$color_name]);
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

  // thêm mới 1 bản ghi màu sắc
  function insert($POST)
  {
    if (isset($POST['color_name'])) {
      $color_name = $POST['color_name'];
      $query = 'INSERT INTO `color` (name, status) VALUES (?, ?)';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$color_name, 1]);
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

  // xóa 1 bản ghi màu sắc
  function delete($id)
  {
    $query = 'DELETE FROM color WHERE id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Thành công";
    } else {
      echo "Thất bại";
    }
  }

  // lấy ra bản ghi màu sắc thông qua id
  function getByID($id)
  {
    $query = 'SELECT * FROM color WHERE id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $response = array();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    $response['id'] = $result[0]->id;
    $response['name'] = $result[0]->name;
    echo json_encode($response);
  }

  // cập nhật 1 bản ghi màu sắc
  function update($POST)
  {
    if (isset($POST['update_colorName'])) {
      $color_id = $POST['hidden_data'];
      $color_name = $POST['update_colorName'];
      $query = 'UPDATE color set name = ? WHERE id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$color_name, $color_id]);
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