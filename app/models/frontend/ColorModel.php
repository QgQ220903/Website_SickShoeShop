<?php
class ColorModel extends Database
{
  // lấy toàn bộ lựa chọn màu sắc của 1 sản phẩm 
  function colors_chooser($productID, $colorID)
  {
    $display = "";
    $display .= "
    <p class='text-dark font-weight-medium mb-0 mr-3'>Màu sắc:</p>
    ";
    $query = "SELECT c.id, c.name AS color_name
    FROM product_detail pd
    INNER JOIN product p ON pd.product_id = p.id
    INNER JOIN color c ON pd.color_id = c.id
    WHERE p.id = ?
    GROUP BY c.id;
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$productID]);
    $colors = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($colors as $color) {

      if ($color->id == $colorID) {
        $display .= "
        <div class='custom-control custom-radio custom-control-inline'>
          <input checked type='radio' class='btn-check ' name='colors' id='{$color->id} - {$color->color_name}' autocomplete='off'>
          <label class='btn btn-outline-primary' for='{$color->id} - {$color->color_name}'>{$color->color_name}</label>
        </div>        
      ";
      } else {
        $display .= "
        <div class='custom-control custom-radio custom-control-inline'>
          <input type='radio' class='btn-check ' name='colors' id='{$color->id} - {$color->color_name}' autocomplete='off'>
          <label class='btn btn-outline-primary' for='{$color->id} - {$color->color_name}'>{$color->color_name}</label>
        </div>        
      ";
      }
    }
    echo $display;
  }
}