<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>
    <?php echo $data['page_title']; ?>
  </title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- web logo -->
  <link rel="shortcut icon" href="<?php echo ASSETS ?>img/logo.jpg" type="image/x-icon">

  <!-- gg fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Customized Bootstrap Stylesheet -->
  <link href="<?php echo ASSETS ?>css/bootstrap.min.css" rel="stylesheet">
  <!-- Template Stylesheet -->
  <link href="<?php echo ASSETS ?>css/admin.css" rel="stylesheet">
  <!-- jquery -->
  <script src="<?php echo ASSETS ?>js/jquery.min.js"></script>
  <!-- sweet alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- TinyMCE cdn -->
  <script src="https://cdn.tiny.cloud/1/8vte9u8zlpomcyc2vvncwdv27uhgh5mim79wo4v1rxb8ayg1/tinymce/7/tinymce.min.js"
    referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });
  </script>
</head>

<body>