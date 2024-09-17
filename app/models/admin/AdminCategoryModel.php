<?php
class AdminCategoryModel extends Database
{

  // lấy toàn bộ bản ghi hiển thị lên view, có phân trang
  function getAll()
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
    $query = "SELECT * FROM category ORDER BY id LIMIT {$start_from}, {$limit}";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display = "
    <div class='table-responsive mb-3'>
    <table id='displayDataTable' class='table text-start align-middle table-bordered table-hover mb-0'>
      <thead>
        <tr class='text-dark'>
          <th scope='col'>ID</th>
          <th scope='col'>Tên Thể Loại</th>
          <th scope='col'>Thao Tác</th>
        </tr>
      </thead>
      <tbody>";

    $count = $this->getSum();
    if ($count > 0) {
      foreach ($categories as $category) {
        $display .=
          "<tr>
            <td>{$category->id}</td>
            <td>{$category->name}</td>
            <td>
              <button class='btn btn-sm btn-warning' onclick='get_detail({$category->id})'><i class='fa-solid fa-pen-to-square'></i></button>
              <button class='btn btn-sm btn-danger' onclick='delete_category({$category->id})'><i class='fa-solid fa-trash'></i></button>
            </td>
          </tr>";
      }
    } else {
      $display .= "
        <tr>
          <td colspan= '3' class='text-center'>Không có dữ liệu</td>
        </tr>
      ";
    }

    $display .= '
        </tbody>
      </table>
    </div>';


    $total_rows = $this->getSum();
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

  // lấy toàn bộ bản ghi, không phân trang
  function getAllCategories($id)
  {
    $display = "";
    $display .= "<option value='0'>Chọn thể loại</option>";
    $query = "SELECT * FROM category ORDER BY id ";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
    if ($id == 0) {
      foreach ($categories as $category) {
        $display .= "<option value='{$category->id}'>{$category->name}</option>";
      }
    } else {
      foreach ($categories as $category) {
        if ($category->id == $id) {
          $display .= "<option selected value='{$category->id}'>{$category->name}</option>";
        } else {
          $display .= "<option value='{$category->id}'>{$category->name}</option>";
        }
      }
    }
    echo $display;
  }

  // tìm kiếm các bản ghi có chứa từ khóa liên quan, có phân trang
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
    // query lấy ra các bản ghi có phân trang, và theo keyword 
    $query = "SELECT * FROM category WHERE name LIKE :keyword ORDER BY id LIMIT $start_from, $limit";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([
      ':keyword' => '%' . $keyword . '%',
    ]);
    $categories = $stmt->fetchAll(PDO::FETCH_OBJ);


    $display = "
    <div class='table-responsive mb-3'>
    <table id='displayDataTable' class='table text-start align-middle table-bordered table-hover mb-0'>
      <thead>
        <tr class='text-dark'>
          <th scope='col'>ID</th>
          <th scope='col'>Tên Thể Loại</th>
          <th scope='col'>Thao Tác</th>
        </tr>
      </thead>
      <tbody>";

    $count = $this->getSumByKeyword($keyword);
    if ($count > 0) {
      foreach ($categories as $category) {
        $display .=
          "<tr>
            <td>{$category->id}</td>
            <td>{$category->name}</td>
            <td>
              <button class='btn btn-sm btn-warning' onclick='get_detail({$category->id})'><i class='fa-solid fa-pen-to-square'></i></button>
              <button class='btn btn-sm btn-danger' onclick='delete_category({$category->id})'><i class='fa-solid fa-trash'></i></button>
            </td>
          </tr>";
      }
    } else {
      $display .= "
        <tr>
          <td colspan= '3' class='text-center'>Không có dữ liệu</td>
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

  // tổng số bản ghi trong bảng
  function getSum()
  {
    $query = "SELECT COUNT(*) AS total FROM category";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
      return $result['total'];
    } else {
      return 0;
    }
  }

  // tổng số các bản ghi có từ khóa liên quan
  function getSumByKeyword($keyword)
  {
    $query = "SELECT COUNT(*) AS total FROM category WHERE name LIKE :keyword";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([
      ':keyword' => '%' . $keyword . '%',
    ]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
      return $result['total'];
    } else {
      return 0;
    }
  }

  function checkDuplicate($POST)
  {
    if (isset($POST['category_name'])) {
      $category_name = $POST['category_name'];
      $query = 'SELECT * FROM category WHERE name = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$category_name]);
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
  // hàm thêm mới 1 thể loại
  function insert($POST)
  {
    if (isset($POST['category_name'])) {
      $category_name = $POST['category_name'];
      $query = 'INSERT INTO `category` (name, status) VALUES (?, ?)';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$category_name, 1]);
      $rowCount = $stmt->rowCount();
      if ($rowCount > 0) {
        // trả ra thông báo thành  công
        echo "Insert successfully";
      } else {
        echo "Fail";
      }
    } else {
      echo "Fail";
    }
  }

  // xóa 1 bản ghi
  function delete($id)
  {
    // Giả sử bạn đã có một kết nối PDO đến cơ sở dữ liệu và lưu trữ trong biến $pdo
    try {
      // Chuẩn bị câu lệnh SQL để xóa category
      $stmt = $this->conn->prepare("DELETE FROM category WHERE id = :id");

      // Gán giá trị cho tham số
      $stmt->bindParam(':id', $id);

      // Thực thi câu lệnh
      $stmt->execute();

      // Kiểm tra số lượng hàng bị ảnh hưởng
      if ($stmt->rowCount() > 0) {
        echo "Đã xóa thành công.";
      } else {
        echo "Không thể xóa.";
      }
    } catch (PDOException $e) {
      echo "Lỗi khi xóa";
    }
  }


  function getByID($id)
  {
    $query = 'SELECT * FROM category WHERE id = ?';
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
    if (isset($POST['update_categoryName'])) {
      $category_id = $POST['hidden_data'];
      $category_name = $POST['update_categoryName'];
      $query = 'UPDATE category set name = ? WHERE id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$category_name, $category_id]);
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