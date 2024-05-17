<?php
class AdminRoleModel extends Database
{
  function insert($POST)
  {
    $role_name = $POST['role_name'];
    $query = "INSERT INTO role(name, status) VALUES (?, ?)";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$role_name, 1]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Thêm thành công";
    } else {
      echo "Thất bại";

    }
  }

  function checkDuplicate($POST)
  {
    $role_name = $POST['role_name'];
    $query = "SELECT * FROM role WHERE name = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$role_name]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Đã tồn tại";
    } else {
      echo "Duy nhất";

    }
  }

  // lấy các nhóm quyền bỏ vào select để lựa chọn
  function getAllRoleToSelect($POST)
  {
    if (isset($POST['role_id'])) {
      $role_id = $POST['role_id'];
    }
    $display = "
    <option id='' value='0'>Chọn nhóm quyền</option>
    ";
    $query = "SELECT * FROM role ORDER BY id";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $roles = $stmt->fetchAll(PDO::FETCH_OBJ);
    foreach ($roles as $role) {
      if ($role_id == $role->id) {
        $display .= "
          <option selected id='' value='{$role->id}'>{$role->name}</option>
      ";
      } else {
        $display .= "
          <option id='' value='{$role->id}'>{$role->name}</option>
        ";
      }
    }
    echo $display;
  }


  // lấy toàn bộ bản ghi thuộc bảng nhóm quyền (có phân trang)
  function getAllRole()
  {
    // số bản ghi trong 1 trang
    $limit = 4;
    // số trang hiện tại
    $page = 0;
    // dữ liệu hiển thị lên view
    $display = "";

    // kiểm tra có tồn tại biến page không nếu có thì gán vào trang hiện tại
    // không thì cho biến page bằng 1
    if (isset($_POST['page'])) {
      $page = $_POST['page'];
    } else {
      $page = 1;
    }

    // bắt đầu từ 
    $start_from = ($page - 1) * $limit;

    $keyword = "";
    if (isset($_POST['keyword'])) {
      $keyword = $_POST['keyword'];
      $query = "SELECT * FROM role WHERE name LIKE :keyword ORDER BY id LIMIT $start_from, $limit";
      $stmt = $this->conn->prepare($query);
      $stmt->execute([
        ':keyword' => '%' . $keyword . '%',
      ]);
    } else {
      $query = "SELECT * FROM role ORDER BY id LIMIT {$start_from}, {$limit}";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
    }
    $roles = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display = "
      <div class='table-responsive mb-3'>
      <table id='displayDataTable' class='table text-start align-middle table-bordered table-hover mb-0'>
        <thead>
          <tr class='text-dark'>
            <th scope='col'>ID</th>
            <th scope='col'>Tên Nhóm Quyền</th>
            <th scope='col'>Trạng Thái</th>
            <th scope='col'>Thao Tác</th>
          </tr>
        </thead>
        <tbody>
      ";
    $count = $this->getSum($keyword);
    if ($count > 0) {
      foreach ($roles as $role) {
        if ($role->status == 1) {
          $display .=
            "<tr>
              <td>{$role->id}</td>
              <td>{$role->name}</td>
              <td>
                <div class='form-check form-switch'>
                  <input  class='form-check-input' type='checkbox' role='switch' value='{$role->id}'>
                </div>
              </td>
              <td>
                <button class='btn btn-sm btn-warning' onclick='get_detail({$role->id})'><i class='fa-solid fa-pen-to-square'></i></button>
                <button class='btn btn-sm btn-danger' onclick='deleteRole({$role->id})'><i class='fa-solid fa-trash'></i></button>
                <button class='btn btn-sm btn-primary' onclick='get_detail({$role->id})'><i class='fa-solid fa-eye'></i></button>
              </td>
            </tr>";
        } else if ($role->status == 0) {
          $display .=
            "<tr>
              <td>{$role->id}</td>
              <td>{$role->name}</td>
              <td>
                <div class='form-check form-switch'>
                  <input checked class='form-check-input' type='checkbox' role='switch' value='{$role->id}'>
                </div>
              </td>              <td>
                <button class='btn btn-sm btn-warning' onclick='get_detail({$role->id})'><i class='fa-solid fa-pen-to-square'></i></button>
                <button class='btn btn-sm btn-danger' onclick='deleteRole({$role->id})'><i class='fa-solid fa-trash'></i></button>
                <button class='btn btn-sm btn-primary' onclick='check_role({$role->id})'><i class='fa-solid fa-eye'></i></button>
              </td>
            </tr>";
        }

      }
    } else {
      $display .= "
          <tr>
            <td colspan = '3' class ='text-center'> Không có dữ liệu </td>
          </tr>
        ";
    }

    $display .= "
          </tbody>
        </table>
      </div>
      ";


    // tổng số bản ghi 
    $total_rows = $this->getSum($keyword);
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

  // lấy ra tổng số tất cả bản ghi của bảng nhóm quyền
  function getSum($keyword)
  {
    if (empty($keyword)) {
      $query = "SELECT COUNT(*) AS total FROM role";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
    } else {
      $query = "SELECT COUNT(*) AS total FROM role where name LIKE :keyword";
      $stmt = $this->conn->prepare($query);
      $stmt->execute([
        ':keyword' => '%' . $keyword . '%',
      ]);
    }
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      return $result->total;
    } else {
      return 0;
    }
  }


  function deleteRole($POST)
  {
    $id = $POST['id'];

    $query = "SELECT * FROM role_detail WHERE role_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      $detailQuery = "DELETE FROM role_detail where role_id = ?";
      $stmt = $this->conn->prepare($detailQuery);
      $stmt->execute([$id]);
      $rowCount = $stmt->rowCount();
      if ($rowCount > 0) {
        try {
          $query = 'DELETE FROM role WHERE id = ?';
          $stmt = $this->conn->prepare($query);
          $stmt->execute([$id]);
          $rowCount = $stmt->rowCount();
          if ($rowCount > 0) {
            echo "Xóa thành công";
          } else {
            echo "Xóa thất bại";
          }
        } catch (PDOException $e) {
          echo "Không thể xóa nhóm quyền";
        }
      }
    } else {
      $query = 'DELETE FROM role WHERE id = ?';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$id]);
      $rowCount = $stmt->rowCount();
      if ($rowCount > 0) {
        echo "Xóa thành công";
      } else {
        echo "Xóa thất bại";
      }
    }



  }

  function deleteRoleDetail($POST)
  {
    $id = $POST['id'];
    $detailQuery = "DELETE FROM role_detail where role_id = ?";
    $stmt = $this->conn->prepare($detailQuery);
    $stmt->execute([$id]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      return "Xóa thành công";
    } else {
      return "Xóa thất bại";
    }
  }

  function getLatestRole()
  {
    $query = 'SELECT * FROM role ORDER BY id DESC LIMIT 1'; // Get the role with the highest ID (assuming ID is auto-incrementing)
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $role = $stmt->fetch(PDO::FETCH_OBJ); // Fetch the result as an associative array
    if ($role) {
      return $role; // Return the associative array containing the latest role data
    } else {
      return null; // No roles found
    }
  }


  function get_detail($roleID)
  {
    // 1. Prepare SQL query (improved):
    $query = "SELECT r.id, r.name, rd.module_id, rd.action
              FROM role r
              INNER JOIN role_detail rd ON r.id = rd.role_id
              WHERE r.id = ?";

    $stmt = $this->conn->prepare($query);

    $stmt->execute([$roleID]);

    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

    // 5. Check for results and build response:
    if (!empty($results)) {
      $response = [];
      foreach ($results as $result) {
        $response[] = [
          'id' => $result->id,
          'name' => $result->name,
          'module_id' => $result->module_id,
          'action' => $result->action,
        ];
      }
      echo json_encode($response);
    } else {
      echo "Không tìm thấy dữ liệu";
    }
  }


}