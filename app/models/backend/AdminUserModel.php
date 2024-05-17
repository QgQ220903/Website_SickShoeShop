<?php
class AdminUserModel extends Database
{
  private $error = "";
  function check_login()
  {
    if (isset($_SESSION['user_id'])) {
      $query = "SELECT u.*, r.name AS role_name
      FROM user u
      INNER JOIN role r ON u.role_id = r.id
      WHERE u.id = ? AND r.name <> 'Khách Hàng'";
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$_SESSION['user_id']]);
      $result = $stmt->fetchAll(PDO::FETCH_OBJ);
      if (is_array($result) && count($result) > 0) {
        return $result[0];
      }
    }
    return null;
  }

  function check_role($role_id)
  {
    $query = "SELECT DISTINCT m.id AS module_id, m.name AS module_name
      FROM module m
      JOIN role_detail rd ON rd.module_id = m.id
      JOIN role r ON r.id = rd.role_id
      WHERE r.id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$role_id]);
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    if (!empty($result) && is_array($result)) {
      return $result;
    }
  }

  function register($POST)
  {

    $username = $POST['username'];
    $email = $POST['email'];
    $phone = $POST['phone'];
    $password = $POST['password'];
    // kiểm tra username rỗng
    if (empty($username)) {
      $this->error .= "Please enter username <br>";
    }
    // kiểm tra username đúng định dạng
    if (!preg_match('/^[A-Za-z]{1}[A-Za-z0-9]{5,31}$/', $username)) {
      $this->error .= "Username must start with letter <br>";
      $this->error .= "6-32 characters <br>";
      $this->error .= "Letters and numbers only <br>";
    }
    //kiểm tra email rỗng
    if (empty($email)) {
      $this->error .= "Please enter email <br>";
    }
    // kiểm tra email đúng định dạng
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $this->error .= "Invalid email <br>";
    }
    // Kiểm tra email duy nhất
    $query = "SELECT COUNT(*) FROM `user` WHERE `email` = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$email]);
    $count = $stmt->fetchColumn();
    if ($count > 0) {
      $this->error .= "Email already exists <br>";
    }
    // kiểm tra số điện thoại rỗng
    if (empty($phone)) {
      $this->error .= "Please enter phone numbers <br>";
    }
    // kiểm tra password rỗng
    if (empty($password)) {
      $this->error .= "Please enter password <br>";
    }
    // kiểm tra password đúng định dạng
    if (strlen($password) < 6) {
      $this->error .= "Password must be atleast 6 characters long <br>";
    }

    // nếu không bị lỗi nào thực hiện thêm vào cơ sở dữ liệu
    if ($this->error == "") {
      $date = date("Y-m-d H:i:s");
      $password = hash('sha1', $password);
      $query = "INSERT INTO `user` (`id`, `role_id`, `email`, `username`, `password`, `phone`, `date`) 
      VALUES (NULL, 1, ?, ?, ?, ?, ?);";
      $stmt = $this->conn->prepare($query);
      $result = $stmt->execute([$email, $username, $password, $phone, $date]);
      if ($result) {
        header("Location: " . ROOT . "adminhome");
        die;
      }
    }
    $_SESSION['error'] = $this->error;

  }
  function login($POST)
  {
    if (isset($POST['email'])) {
      $email = $POST['email'];
    }
    $password = $POST['password'];

    $password = hash('sha1', $password);
    $query = "select * from user where email = ? AND password = ? AND role_id <> 5";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$email, $password]);
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    if (is_array($result) && count($result) > 0) {
      $_SESSION['user_id'] = $result[0]->id;
      echo "Đăng nhập thành công";
    } else {
      echo "Tài khoản không tồn tại";
    }
  }


  function logout()
  {
    if (isset($_SESSION['user_id'])) {
      unset($_SESSION['user_id']);
    }
    header("Location: " . ROOT . "adminlogin");
    die;
  }


  // lấy toàn bộ danh sách người dùng có phân trang
  function getAll()
  {
    $limit = 4;
    $page = 0;
    $keyword = "";
    if (isset($_POST['page'])) {
      $page = $_POST['page'];
    } else {
      $page = 1;
    }

    $col = "";
    if (isset($_POST['column'])) {
      $col = trim($_POST['column']);
    }

    $keyword = "";
    if (isset($_POST['keyword'])) {
      $keyword = trim($_POST['keyword']);
    }
    $start_from = ($page - 1) * $limit;
    if ($keyword != "") {
      if ($col != "") {
        $sort = trim($_POST['typeSort']);
        $query = "SELECT u.id, u.email, u.username, u.phone, u.img, u.status, u.date, r.name AS role_name
        FROM user u
        INNER JOIN role r ON u.role_id = r.id
        WHERE (u.username LIKE :keyword OR u.email LIKE :keyword OR u.phone LIKE :keyword)
        ORDER BY u.{$col} {$sort}
        LIMIT {$start_from}, {$limit}";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
          ':keyword' => '%' . $keyword . '%', // Add wildcards for partial matches
        ]);
      } else {
        $query = "SELECT u.id, u.email, u.username, u.phone, u.img, u.status, u.date, r.name AS role_name
        FROM user u
        INNER JOIN role r ON u.role_id = r.id
        WHERE (u.username LIKE :keyword OR u.email LIKE :keyword OR u.phone LIKE :keyword)
        ORDER BY u.id LIMIT {$start_from}, {$limit}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
          ':keyword' => '%' . $keyword . '%', // Add wildcards for partial matches
        ]);
      }

    } else {
      if ($col != "") {
        $sort = trim($_POST['typeSort']);
        $query = "SELECT u.id, u.email, u.username, u.phone, u.img, u.status, u.date, r.name AS role_name
        FROM user u
        INNER JOIN role r ON u.role_id = r.id
        ORDER BY u.{$col} {$sort}
        LIMIT {$start_from}, {$limit}";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
      } else {
        $query = "SELECT u.id, u.email, u.username, u.phone, u.img, u.status, u.date, r.name AS role_name
        FROM user u
        INNER JOIN role r ON u.role_id = r.id
        ORDER BY u.id LIMIT {$start_from}, {$limit}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
      }
    }

    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
    $display = "
    <div class='table-responsive mb-4'>
          <table class='table table-striped text-start align-middle table-bordered table-hover mb-0'>
            <thead>
              <tr>
                <th scope='col' onclick='ColSort(\"id\")'>ID</th>
                <th scope='col' onclick='ColSort(\"email\")'>Email</th>
                <th scope='col' onclick='ColSort(\"username\")'>Tên Đăng Nhập</th>
                <th scope='col' onclick='ColSort(\"role_id\")'>Nhóm Quyền</th>
                <th scope='col' onclick='ColSort(\"date\")'>Ngày lập</th>
                <th scope='col' onclick=''>Khóa</th>
                <th scope='col'>Thao Tác</th>
              </tr>
            </thead>
            <tbody>
    ";
    $count = $this->getSum($keyword);
    if ($count > 0) {
      foreach ($users as $user) {
        if ($user->status == 1) {
          $display .= "
          <tr>
            <td>{$user->id}</td>
            <td>{$user->email}</td>
            <td>{$user->username}</td>
            <td>{$user->role_name}</td>
            <td>{$user->date}</td>
            <td>
              <div class='form-check form-switch'>
                <input  class='form-check-input' type='checkbox' role='switch' value='{$user->id}'>
              </div>
            </td>
            <td>
            <a href='" . ROOT . "AdminAddUser/update/$user->id' class='btn btn-sm btn-warning'><i class='fa-solid fa-pen-to-square'></i></a>
            <button class='btn btn-sm btn-danger' onclick='delete_user({$user->id})'><i class='fa-solid fa-trash'></i></button>
            <a href='" . ROOT . "AdminAddUser/detail/$user->id' class='btn btn-sm btn-primary'><i class='fa-solid fa-eye'></i></a>
            </td>
          </tr>
          ";
        } else {
          $display .= "
          <tr>
            <td>{$user->id}</td>
            <td>{$user->email}</td>
            <td>{$user->username}</td>
            <td>{$user->role_name}</td>
            <td>{$user->date}</td>
            <td>
              <div class='form-check form-switch'>
                <input checked class='form-check-input' type='checkbox' role='switch' value='{$user->id}'>
              </div>
            </td>
            <td>
            <a href='" . ROOT . "AdminAddUser/update/$user->id' class='btn btn-sm btn-warning'><i class='fa-solid fa-pen-to-square'></i></a>
            <button class='btn btn-sm btn-danger' onclick='delete_user({$user->id})'><i class='fa-solid fa-trash'></i></button>
            <a href='" . ROOT . "AdminAddUser/update/$user->id' class='btn btn-sm btn-primary'><i class='fa-solid fa-eye'></i></a>
            </td>
          </tr>
        ";
        }

      }
    } else {
      $display .= "
        <tr>
          <td>Không có dữ liệu</td>
        </tr>
      ";
    }
    $display .= "
        </tbody>
      </table>
    </div>
    ";

    $total_pages = ceil($count / $limit);

    $display .= "<div class='col-12 pb-1'>
    <nav aria-label='Page navigation'>
    <ul class='pagination justify-content-center mb-3'>";
    if ($page > 1) {
      $prev_active = "";
      $prev = $page - 1;
      $display .= "
      <li class='page-item {$prev_active}'>
        <a onclick='changePageFetch($prev, $keyword)' id = '{$prev}' class='page-link' href='#' aria-label='Previous'>
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
      $display .= "<li class='page-item {$active_class} '><a onclick='changePageFetch($i, $keyword)' id = '$i' class='page-link' href='#'>$i</a></li>";
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
          <a onclick='changePageFetch($next, $keyword)' id='{$next}' class='page-link {$next_active}' href='#' aria-label='Next'>
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

  // lấy tổng số lượng người dùng ()
  function getSum($keyword)
  {
    if (empty($keyword)) {
      $query = "SELECT COUNT(*) AS total FROM user";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
    } else {
      $query = "SELECT COUNT(*) AS total 
      FROM user 
      WHERE username LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword";
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


  // thêm mới người dùng
  function insert($POST)
  {
    $fullname = $POST['fullName'];
    $username = $POST['username'];
    $phone = $POST['phone'];
    $email = $POST['email'];
    $password = $POST['password'];
    $role_id = $POST['role_id'];
    $user_image = $POST['fileName'];

    $date = date("Y-m-d H:i:s");
    $password = hash('sha1', $password);

    $query = "SELECT COUNT(*) FROM `user` WHERE `email` = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$email]);
    $count = $stmt->fetchColumn();
    if ($count > 0) {
      echo "Email đã có tài khoản khác sử dụng";
    } else {
      $query = 'INSERT INTO `user`
      (`username`, `phone`, `email`, `password`, `role_id`, `img`, `date`, `fullname`, status) 
      VALUES 
      (?,?,?,?,?,?,?,?, 1)';
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$username, $phone, $email, $password, $role_id, $user_image, $date, $fullname]);
      $user_id = $this->getLatestUser();
      if ($user_id == -1) {
        echo "Thêm thất bại";
      } else {
        echo $user_id;
      }
    }
  }

  function getLatestUser()
  {
    $query = "SELECT * FROM `user` ORDER BY id DESC LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_OBJ);
    if ($user) {
      return $user->id;
    } else {
      return -1; // Return null if no user is found
    }

  }


  function getRows($start = 0, $limit = 4)
  {
    $query = "SELECT * FROM user ORDER BY id DESC LIMIT {$start}, {$limit}";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
      $results = $stmt->fetchAll(PDO::FETCH_OBJ);
    } else {
      $results = [];
    }
    return $results;
  }

  function getByID($id)
  {
    $query = '
    SELECT u.*,
    a.street_name,
    p.id AS province_id,
    p.name AS province_name,
    d.id AS district_id,
    d.name AS district_name,
    w.id AS ward_id,
    w.name AS ward_name
    FROM user u
    LEFT JOIN user_address ua ON u.id = ua.user_id
    LEFT JOIN address a ON ua.address_id = a.id
    LEFT JOIN province p ON a.province_id = p.id  -- Join province table
    LEFT JOIN district d ON a.district_id = d.id  -- Join district table
    LEFT JOIN ward w ON a.ward_id = w.id            -- Join ward table
    WHERE u.id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $result = $stmt->fetch(PDO::FETCH_OBJ);

    // Trả về giá trị thuộc tính cần lấy
    if ($result) {
      return $result;
    } else {
      return null;
    }
  }

  function checkDuplicate($POST)
  {
    if (isset($POST['username'])) {
      $str = "";
      $userName = $POST['username'];
      $phone = $POST['phone'];
      $email = $POST['email'];
      $id = $POST['hidden_data'];

      $queries = [
        'username' => 'SELECT COUNT(*) FROM user WHERE username = ? AND id != ?',
        'phone' => 'SELECT COUNT(*) FROM user WHERE phone = ? AND id != ?',
        'email' => 'SELECT COUNT(*) FROM user WHERE email = ? AND id != ?'
      ];

      foreach ($queries as $field => $query) {
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$POST[$field], $id]);
        $rowCount = $stmt->fetchColumn();
        if ($rowCount > 0) {
          $str .= $field . ",";
        }
      }

      echo rtrim($str, ",");
    } else {
      echo "Lỗi";
    }
  }


  function update($POST)
  {
    $id = $POST['id'];
    $username = $POST['username'];
    $phone = $POST['phone'];
    $email = $POST['email'];
    $fullname = $POST['fullName'];
    $role_id = $POST['role_id'];
    $img = $POST['fileName'];
    $query = 'UPDATE user set username = ?, phone = ?, email = ?, role_id = ?, img = ?, fullname = ?  WHERE id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$username, $phone, $email, $role_id, $img, $fullname, $id]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Sửa thành công";
    } else {
      echo "Sửa thất bại";
    }
  }

  function changeStatus($POST)
  {
    $id = $POST['id'];
    $status = $POST['status'];
    $query = 'UPDATE user set status = ? WHERE id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$status, $id]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Sửa thành công";
    } else {
      echo "Sửa thất bại";
    }
  }

  function delete($id)
  {
    $query = 'DELETE FROM user WHERE id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$id]);
    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
      echo "Xóa thành công";
    } else {
      echo "Xóa thất bại";
    }
  }

  function getAllUserForOption($id)
  {
    $display = "";
    $display .= "<option value=''>Chọn nhân viên</option>";
    $query = "SELECT * FROM user where role_id <> 5 ORDER BY id ";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_OBJ);
    if ($id == 0) {
      foreach ($users as $user) {
        $display .= "
        <option value='{$user->id}'>{$user->email}</option>
      ";
      }
    } else {
      foreach ($users as $user) {
        if ($user->id == $id) {
          $display .= "
          <option selected value='{$user->id}'>{$user->email}</option>
        ";
        } else {
          $display .= "
          <option value='{$user->id}'>{$user->email}</option>
        ";
        }
      }
    }
    echo $display;
  }
}
?>