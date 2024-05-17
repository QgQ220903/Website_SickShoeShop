<?php

function show($data)
{
  echo "<pre>";
  print_r($data);
  echo "</pre>";
}
function currency_format($number, $suffix = 'đ')
{
  if (!empty($number)) {
    return number_format($number, 0, ',', '.') . "{$suffix}";
  }
}
function currency_format1($number, $suffix = 'đ')
{
  if (!empty($number)) {
    return number_format($number, 0, ',', '.') . "{$suffix}";
  }else {
    return"0đ";
  }
}

function check_error()
{
  if (isset($_SESSION['error']) && $_SESSION['error'] != "") {
    echo "<div class='alert alert-danger' role='alert'>";
    echo $_SESSION['error'];
    echo "</div>";
    unset($_SESSION['error']);
  } else if (isset($_SESSION['error']) && $_SESSION['error'] == "") {
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
    echo "<strong>Đăng Ký Thành Công";
    echo "  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>";
    echo "<span aria-hidden='true'>&times;</span>";
    echo "</button>";
    echo "</div>";
    unset($_SESSION['error']);
  }


}