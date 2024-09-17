<?php
class AdminStatisticModel extends Database
{

  function getTopSaleProduct($limit)
  {

    try {
      // Kết nối đến cơ sở dữ liệu
      // Chuẩn bị câu truy vấn với tham số giới hạn
      $sql = "SELECT
                  pd.product_id,
                  pd.color_id,
                  pd.size_id,
                  pd.image,
                  p.name,
                  pd.price,
                  SUM(odt.quantity) AS total_sales
              FROM product_detail AS pd
              INNER JOIN order_detail AS odt ON pd.id = odt.product_detail_id
              INNER JOIN product AS p ON pd.product_id = p.id
              GROUP BY pd.product_id, p.name
              ORDER BY total_sales DESC
              LIMIT :limit";
      // Chuẩn bị statement và truyền tham số
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

      // Thực thi truy vấn
      $stmt->execute();

      // Lấy kết quả và chuyển thành JSON
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $jsonData = json_encode($results);

      // Trả về kết quả JSON
      return $jsonData;

    } catch (PDOException $e) {
      // Xử lý lỗi
      echo "Error: " . $e->getMessage();
      return null;
    }


  }

  function dailyRevenue()
  {
    $stmt = $this->conn->prepare("
        SELECT SUM(order_total) as total_revenue
        FROM `order`
        WHERE DATE(date) = CURDATE();
    ");

    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total_revenue'] ?? 0;
  }

  function monthlyRevenue($year, $month)
  {

    $stmt = $this->conn->prepare("
        SELECT SUM(order_total) AS total_revenue
        FROM `order`
        WHERE YEAR(date) = :year AND MONTH(date) = :month
    ");
    $stmt->bindParam(':year', $year);
    $stmt->bindParam(':month', $month);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total_revenue'] ?? 0;
  }

  function yearlyRevenue($year)
  {

    $stmt = $this->conn->prepare("
        SELECT SUM(order_total) AS total_revenue
        FROM `order`
        WHERE YEAR(date) = :year
    ");
    $stmt->bindParam(':year', $year);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['total_revenue'] ?? 0;
  }

  public function getProfitByDate($startDate, $endDate)
  {
    $sql = "
        
    SELECT
      DATE(t.ngay) AS ngay,  -- Group by date only
      SUM(t.doanh_thu) AS tong_doanh_thu,
      SUM(t.chi_phi) AS tong_chi_phi,
      SUM(t.doanh_thu - t.chi_phi) AS loi_nhuan
    FROM (
      SELECT
        order.date AS ngay,
        order.order_total AS doanh_thu,
        0 AS chi_phi
      FROM
        `order`
      WHERE
        `date` BETWEEN :startDate AND :endDate
      UNION ALL
      SELECT
        invoice.create_date AS ngay,
        0 AS doanh_thu,
        invoice.total AS chi_phi
      FROM
        invoice
      WHERE
        create_date BETWEEN :startDate AND :endDate
    ) AS t
    GROUP BY DATE(t.ngay);  -- Group by date only
    ";

    // Sử dụng prepared statement để tránh SQL injection
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':startDate', $startDate);
    $stmt->bindParam(':endDate', $endDate);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
  }
}