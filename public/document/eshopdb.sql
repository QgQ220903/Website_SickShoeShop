-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 07, 2024 lúc 07:52 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `eshopdb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `address`
--

CREATE TABLE `address` (
  `id` varchar(11) NOT NULL,
  `street_name` varchar(255) NOT NULL,
  `ward` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `brand`
--

INSERT INTO `brand` (`id`, `name`, `status`) VALUES
(29, 'NIKE', 1),
(30, 'ADIDAS', 1),
(31, 'PUMA', 1),
(34, 'JORDAN', 1),
(35, 'YEEZY', 1),
(41, 'Converse', 1),
(42, 'Vans', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `user_id`) VALUES
(8, 1),
(16, 3),
(13, 12),
(12, 16),
(6, 31),
(10, 32),
(7, 33),
(11, 34),
(14, 35),
(15, 36),
(17, 37),
(18, 38),
(19, 44);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_detail`
--

CREATE TABLE `cart_detail` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_detail_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_detail`
--

INSERT INTO `cart_detail` (`id`, `cart_id`, `product_detail_id`, `quantity`) VALUES
(19, 6, 71, 3),
(20, 6, 50, 1),
(21, 6, 69, 8),
(22, 7, 63, 9),
(23, 7, 60, 3),
(24, 7, 46, 3),
(25, 7, 65, 3),
(29, 11, 57, 6),
(30, 11, 53, 2),
(32, 11, 62, 1),
(34, 15, 73, 2),
(35, 13, 52, 2),
(36, 13, 60, 1),
(37, 13, 69, 1),
(38, 13, 57, 1),
(40, 13, 64, 1),
(42, 17, 73, 1),
(43, 17, 52, 1),
(44, 17, 69, 1),
(45, 18, 76, 1),
(46, 18, 52, 1),
(62, 19, 72, 1),
(63, 19, 76, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`, `status`) VALUES
(5, 'Giày nam', 1),
(8, 'Giày thể thao nữ', 1),
(37, 'Giày nữ', 1),
(38, 'Giày thể thao nam', 1),
(39, 'Giày golf', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `color`
--

CREATE TABLE `color` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `color`
--

INSERT INTO `color` (`id`, `name`, `status`) VALUES
(1, 'Đỏ ', 1),
(3, 'Vàng ', 1),
(5, 'Đen', 1),
(8, 'Xám', 1),
(12, 'Trắng', 1),
(17, 'Tím `', 1),
(19, 'Cam', 1),
(20, 'Xanh lá', 1),
(21, 'Xanh dương', 1),
(22, 'Kem', 1),
(23, 'Hồng', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `invoice`
--

INSERT INTO `invoice` (`id`, `create_date`, `user_id`, `supplier_id`, `total`) VALUES
(8, '2024-05-06 15:24:21', 44, 102, 64580000),
(9, '2024-05-07 01:37:07', 44, 1, 143600000),
(10, '2024-05-07 06:02:24', 44, 1, 21540000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoice_detail`
--

CREATE TABLE `invoice_detail` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `productDetail_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `invoice_detail`
--

INSERT INTO `invoice_detail` (`id`, `invoice_id`, `productDetail_id`, `quantity`, `subtotal`) VALUES
(5, 8, 46, 10, 6000000),
(6, 8, 71, 10, 29290000),
(7, 8, 72, 10, 29290000),
(8, 9, 89, 10, 35900000),
(9, 9, 90, 10, 35900000),
(10, 9, 91, 10, 35900000),
(11, 9, 92, 10, 35900000),
(12, 10, 81, 6, 21540000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `module`
--

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `module`
--

INSERT INTO `module` (`id`, `name`) VALUES
(1, 'Đơn Hàng'),
(2, '<i class=\"fa fa-file-invoice-dollar\"></i>Sản Phẩm'),
(3, 'Nhà Cung Cấp'),
(4, 'Nhập Hàng'),
(5, 'Người Dùng'),
(6, 'Phân Quyền');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `address` varchar(11) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `order_total` int(11) NOT NULL,
  `order_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`id`, `user_id`, `customer_name`, `date`, `address`, `payment_method`, `order_total`, `order_status`) VALUES
(14, '37', 'Nguyễn Phương Thùy', '2024-04-25', '273 An Dươn', 'Thanh toán khi nhận hàng', 10963700, 0),
(15, '1', 'Quách Gia Quy', '2024-04-25', '375 Vĩnh Kh', 'Thanh toán khi nhận hàng', 96737300, 0),
(16, '3', 'Quách Gia Quy', '2024-04-29', '375 Vĩnh Kh', 'Thanh toán khi nhận hàng', 3949000, 0),
(17, '44', 'Mai Văn Tài', '2024-05-05', '273 An Dươn', 'Thanh toán khi nhận hàng', 3870900, 0),
(18, '44', '', '2024-05-07', 'tỳdjuyhfh', 'Thanh toán khi nhận hàng', 3881900, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_detail_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_detail_id`, `quantity`, `subtotal`) VALUES
(1, 14, 73, 1, 2929000),
(2, 14, 52, 1, 3519000),
(3, 14, 69, 1, 3519000),
(4, 15, 72, 10, 29290000),
(5, 15, 52, 13, 45747000),
(6, 15, 64, 1, 3519000),
(7, 15, 73, 3, 8787000),
(8, 15, 76, 1, 600000),
(9, 16, 91, 1, 3590000),
(10, 17, 51, 1, 3519000),
(11, 17, 72, 1, 2929000),
(12, 17, 76, 1, 600000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `category_id`, `brand_id`, `supplier_id`, `name`, `description`) VALUES
(14, 5, 29, 102, 'Nike Air Force 1 Shadow', 'Nike Air Force 1 Shadow là một phiên bản đặc biệt của dòng giày thể thao Air Force 1 của Nike. Với thiết kế độc đáo, giày mang đến sự kết hợp giữa cái cổ điển và phong cách hiện đại.\nĐặc trưng chính của Air Force 1 Shadow là việc sử dụng lớp đệm mềm mại và đế giày bền bỉ, tạo cảm giác thoải mái và ổn định trong suốt quá trình sử dụng. Với sự phóng đại và \"đèn bụi\" của thiết kế, giày tạo nên một vẻ ngoài độc đáo và cá tính.\nMặt trên của Nike Air Force 1 Shadow được làm từ chất liệu da hoặc da nhân tạo chất lượng cao, mang lại sự bền bỉ và độ bóng sang trọng. Các chi tiết thêu và logo Nike cũng được thêm vào để tăng tính thẩm mỹ và độc đáo của giày.\nAir Force 1 Shadow có nhiều tùy chọn màu sắc và họa tiết, cho phép người dùng lựa chọn theo phong cách và cá nhân hóa riêng của họ. Một số phiên bản có sự kết hợp của các màu sắc tương phản giữa các lớp và chi tiết, tạo nên một cái nhìn độc đáo và nổi bật.\nGiày Nike Air Force 1 Shadow không chỉ là một sản phẩm thể thao, mà còn trở thành một biểu tượng thời trang và phong cách đường phố. Với sự phối hợp linh hoạt giữa phong cách cổ điển và hiện đại, nó phù hợp cho nhiều hoạt động và dịp khác nhau, từ các buổi dạo phố hàng ngày cho đến các sự kiện thể thao và giải trí.\nVới Nike Air Force 1 Shadow, bạn có thể tự tin thể hiện phong cách riêng của mình và tận hưởng sự thoải mái và cá nhân hóa mà giày mang lại.                                          '),
(19, 5, 29, 102, 'Air Jordan 1 Low SE', 'Air Jordan 1 Low SE là một phiên bản đặc biệt của dòng sản phẩm Air Jordan 1, một trong những mẫu giày bóng rổ biểu tượng của hãng Nike. Được ra mắt với sự kết hợp giữa thiết kế hiện đại và phong cách retro, Air Jordan 1 Low SE mang đến một diện mạo độc đáo và cá nhân.\n\nGiày Air Jordan 1 Low SE có đặc điểm chính là bề mặt trên được làm từ chất liệu da hoặc da lộn cao cấp, tạo nên sự sang trọng và bền bỉ. Mẫu giày này thường có các màu sắc tươi sáng và đa dạng, cho phép người sử dụng lựa chọn phong cách phù hợp với cá nhân.\nThiết kế của Air Jordan 1 Low SE mang một phần nổi bật từ phiên bản gốc Air Jordan 1 High, với đường chỉ may tỉ mỉ và họa tiết cánh cổng mảnh ghép trên thân giày. Đồng thời, nó cũng có một phần độc đáo riêng, bao gồm hệ thống dây buộc và đế giữa đúc cao su, mang lại sự thoải mái và độ bền cho người sử dụng.\n\nAir Jordan 1 Low SE không chỉ là một đôi giày thể thao, mà còn là một biểu tượng thời trang được ưa chuộng bởi cả cộng đồng yêu giày sneaker và những người ham mê thời trang. Với sự kết hợp giữa phong cách và tính năng vượt trội, nó trở thành một lựa chọn tuyệt vời cho những người yêu thích sự cá nhân hóa và tự tin trong phong cách của riêng mình.'),
(20, 5, 29, 102, 'Air Jordan 1 Low G', '                                Air Jordan 1 Low G là một phiên bản của giày Air Jordan 1 dành riêng cho golf. Được thiết kế từ phiên bản gốc Air Jordan 1 Low, phiên bản này kết hợp giữa phong cách thể thao và chức năng chơi golf.\n\nAir Jordan 1 Low G có các đặc điểm chính giống như Air Jordan 1 Low thông thường, bao gồm đế giữa phẳng và phần trên thường được làm từ chất liệu da hoặc da lộn cao cấp. Tuy nhiên, phiên bản này có một số cải tiến và điều chỉnh để phù hợp với hoạt động golf.\n\nMột trong những điểm đáng chú ý của Air Jordan 1 Low G là đế ngoài được thiết kế đặc biệt để cung cấp độ bám tốt trên sân golf. Đế cao su có gai và rãnh chống trượt, giúp người chơi ổn định hơn khi di chuyển trên các bề mặt sân cỏ.\n\nNgoài ra, Air Jordan 1 Low G cũng có các tính năng khác như hệ thống dây buộc thích ứng và đệm êm ái, mang lại sự thoải mái và hỗ trợ cho người chơi trong suốt quá trình chơi golf.\n\nVề mặt thiết kế, Air Jordan 1 Low G thường có nhiều biến thể màu sắc và họa tiết đa dạng, cho phép người dùng lựa chọn phong cách cá nhân. Nó mang đến sự kết hợp giữa vẻ ngoài thể thao và phong cách thời trang, làm nổi bật phong cách cá nhân của người chơi golf.\n\nAir Jordan 1 Low G là một sự lựa chọn tuyệt vời cho những người yêu thích golf và đồng thời muốn tỏa sáng với phong cách thời trang của Air Jordan 1. Với sự kết hợp của tính năng chơi golf và thiết kế đẹp mắt, nó mang lại sự tự tin và thoải mái trong mỗi vụ đánh.                            '),
(21, 37, 29, 102, 'Air Jordan 1 Mid', 'Air Jordan 1 Mid là một đôi giày thể thao nổi tiếng và phổ biến từ thương hiệu Nike. Được ra mắt lần đầu vào năm 1985, Air Jordan 1 Mid mang đậm phong cách thiết kế của người chơi bóng rổ huyền thoại Michael Jordan.\n\nSản phẩm Air Jordan 1 Mid có thiết kế cổ điển và đặc trưng với một phần trên bằng da hoặc da tổng hợp, tạo nên sự bền bỉ và độ bền cao. Đôi giày này có một mũi giày và phần gót giày vuông vức, tạo cảm giác ổn định và thoải mái cho người mang. Ngoài ra, Air Jordan 1 Mid cũng có hệ thống dây buộc và lưỡi gà linh hoạt giúp điều chỉnh sự vừa vặn và thoải mái cho người dùng.\n\nVề màu sắc, Air Jordan 1 Mid có sự đa dạng với nhiều tùy chọn màu khác nhau, từ các màu sắc cổ điển như đen, trắng, đỏ, xanh, đến các biến thể phối màu sáng tạo và độc đáo. Điều này cho phép người dùng tùy chọn theo phong cách riêng của mình.\n\nAir Jordan 1 Mid không chỉ được ưa chuộng trong làng bóng rổ, mà còn trở thành một biểu tượng thời trang đường phố với sự kết hợp linh hoạt với nhiều trang phục khác nhau. Đôi giày này thường được sử dụng trong các hoạt động thể thao, đi dạo hàng ngày hoặc thậm chí trong các sự kiện đặc biệt.\n\nVới sự kết hợp giữa phong cách, sự thoải mái và sự đa dạng về màu sắc, Air Jordan 1 Mid đã trở thành một lựa chọn phổ biến cho những người yêu thích giày thể thao và thời trang.'),
(22, 5, 29, 102, 'Nike Air Force 1 \'07 LV8', 'Nike Air Force 1 \'07 LV8 là một đôi giày thể thao đẹp và mang tính biểu tượng trong bộ sưu tập Air Force 1 của Nike. Đôi giày này kết hợp giữa các yếu tố thiết kế cổ điển và các cập nhật hiện đại, là sự lựa chọn phổ biến của những người yêu giày sneaker.\n\nPhần trên của Nike Air Force 1 \'07 LV8 được làm từ các vật liệu cao cấp, mang lại độ bền và vẻ ngoại hình sang trọng. Đôi giày có kiểu dáng mảnh mai và thanh lịch với các đường nét sạch sẽ, tạo nên một sự hấp dẫn vượt thời gian và linh hoạt. Đôi giày này có sẵn trong nhiều màu sắc khác nhau, cho phép người dùng lựa chọn phong cách ưa thích của mình.\n\nMột trong những tính năng đáng chú ý của đôi giày này là công nghệ Air của Nike được tích hợp trong đế giày. Hệ thống đệm này mang lại sự thoải mái tuyệt vời và khả năng hấp thụ va đập, phù hợp cho việc mang suốt cả ngày. Ngoài ra, đế cao su cung cấp độ bám và ổn định trên các bề mặt khác nhau.'),
(23, 37, 29, 1, 'Nike Air Force 1 Low By You', 'Nike Air Force 1 Low By You là một phiên bản cá nhân hóa của đôi giày Nike Air Force 1 Low. Đây là một dòng giày cho phép bạn tạo ra một đôi giày độc đáo và phù hợp với phong cách riêng của mình.\n\nVới Nike Air Force 1 Low By You, bạn có thể tùy chỉnh các thành phần của giày, bao gồm màu sắc, chất liệu và các chi tiết như dây giày, logo và đế giày. Bạn có thể lựa chọn từ một loạt các tùy chọn có sẵn để tạo ra một đôi giày hoàn toàn riêng biệt và phản ánh cá nhân của mình.\n\nĐôi giày Nike Air Force 1 Low By You vẫn giữ nguyên vẻ ngoài cổ điển và thiết kế đặc trưng của dòng Air Force 1. Chúng có phần trên bằng chất liệu cao cấp và đế ngoài bằng cao su, mang lại độ bền và độ bám tốt. Điểm nhấn chính là công nghệ đệm Nike Air trong đế giày, giúp cung cấp sự thoải mái và hấp thụ lực va đập.\n\nNike Air Force 1 Low By You là sự kết hợp giữa sự cá nhân hóa và phong cách cổ điển, cho phép bạn thể hiện cá nhân hóa riêng của mình thông qua đôi giày này. Đây là một lựa chọn tuyệt vời cho những người yêu thích thể thao và muốn sở hữu một đôi giày độc đáo và mang phong cách riêng.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_detail`
--

CREATE TABLE `product_detail` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `product_detail`
--

INSERT INTO `product_detail` (`id`, `product_id`, `size_id`, `color_id`, `quantity`, `price`, `image`) VALUES
(46, 14, 22, 12, 10, 600000, 'http://localhost/EShop_MVC/public/assets//img/air-force-1-07-shoes-WrLlWX.png'),
(50, 19, 19, 21, 0, 3519000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-low-se-shoes-hgcLbC.jpeg'),
(51, 19, 20, 21, 0, 3519000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-low-se-shoes-hgcLbC.jpeg'),
(52, 19, 21, 21, 0, 3519000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-low-se-shoes-hgcLbC.jpeg'),
(53, 19, 22, 21, 0, 3519000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-low-se-shoes-hgcLbC.jpeg'),
(55, 20, 20, 12, 0, 4109000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-low-g-golf-shoes-8bKbqs (1).png'),
(57, 20, 22, 12, 0, 4109000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-low-g-golf-shoes-8bKbqs (1).png'),
(58, 20, 19, 5, 0, 4109000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-low-g-golf-shoes-8bKbqs.jpeg'),
(59, 20, 20, 5, 0, 4109000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-low-g-golf-shoes-8bKbqs.jpeg'),
(60, 20, 21, 5, 0, 4109000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-low-g-golf-shoes-8bKbqs.jpeg'),
(62, 21, 20, 5, 0, 3519000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-mid-shoes-7cdjgS.jpeg'),
(63, 21, 21, 5, 0, 3519000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-mid-shoes-7cdjgS.jpeg'),
(64, 21, 22, 5, 0, 3519000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-mid-shoes-7cdjgS.jpeg'),
(65, 21, 23, 5, 0, 3519000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-mid-shoes-7cdjgS.jpeg'),
(66, 21, 19, 12, 0, 3519000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-mid-shoes-7cdjgS.png'),
(69, 21, 20, 12, 0, 3519000, 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-mid-shoes-7cdjgS.png'),
(71, 14, 20, 5, 10, 2929000, 'http://localhost/EShop_MVC/public/assets//img/air-force-1-07-shoes-WrLlWX (1).png'),
(72, 14, 21, 5, 10, 2929000, 'http://localhost/EShop_MVC/public/assets//img/air-force-1-07-shoes-WrLlWX (1).png'),
(73, 14, 22, 5, 0, 2929000, 'http://localhost/EShop_MVC/public/assets//img/air-force-1-07-shoes-WrLlWX (1).png'),
(76, 14, 24, 12, 0, 600000, 'http://localhost/EShop_MVC/public/assets//img/air-force-1-07-shoes-WrLlWX.png'),
(77, 22, 19, 12, 0, 3519000, 'http://localhost/EShop_MVC/public/assets//img/air-force-1-07-lv8-shoes-2gP9Bc.png'),
(78, 22, 20, 12, 0, 3519000, 'http://localhost/EShop_MVC/public/assets//img/air-force-1-07-lv8-shoes-2gP9Bc.png'),
(79, 22, 21, 12, 0, 3519000, 'http://localhost/EShop_MVC/public/assets//img/air-force-1-07-lv8-shoes-2gP9Bc.png'),
(80, 22, 22, 12, 0, 3519000, 'http://localhost/EShop_MVC/public/assets//img/air-force-1-07-lv8-shoes-2gP9Bc.png'),
(81, 23, 19, 5, 6, 3590000, 'http://localhost/EShop_MVC/public/assets//img/custom-nike-air-force-1-low-by-you.png'),
(82, 23, 20, 5, 0, 3590000, 'http://localhost/EShop_MVC/public/assets//img/custom-nike-air-force-1-low-by-you.png'),
(83, 23, 21, 5, 0, 3590000, 'http://localhost/EShop_MVC/public/assets//img/custom-nike-air-force-1-low-by-you.png'),
(84, 23, 22, 5, 0, 3590000, 'http://localhost/EShop_MVC/public/assets//img/custom-nike-air-force-1-low-by-you.png'),
(85, 23, 19, 19, 0, 3590000, 'http://localhost/EShop_MVC/public/assets//img/custom-nike-air-force-1-low-by-you (1).jpeg'),
(86, 23, 20, 19, 0, 3590000, 'http://localhost/EShop_MVC/public/assets//img/custom-nike-air-force-1-low-by-you (1).jpeg'),
(87, 23, 21, 19, 0, 3590000, 'http://localhost/EShop_MVC/public/assets//img/custom-nike-air-force-1-low-by-you (1).jpeg'),
(88, 23, 22, 19, 0, 3590000, 'http://localhost/EShop_MVC/public/assets//img/custom-nike-air-force-1-low-by-you (1).jpeg'),
(89, 23, 19, 23, 10, 3590000, 'http://localhost/EShop_MVC/public/assets//img/custom-nike-air-force-1-low-by-you.jpeg'),
(90, 23, 20, 23, 10, 3590000, 'http://localhost/EShop_MVC/public/assets//img/custom-nike-air-force-1-low-by-you.jpeg'),
(91, 23, 21, 23, 10, 3590000, 'http://localhost/EShop_MVC/public/assets//img/custom-nike-air-force-1-low-by-you.jpeg'),
(92, 23, 22, 23, 10, 3590000, 'http://localhost/EShop_MVC/public/assets//img/custom-nike-air-force-1-low-by-you.jpeg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_detail_image`
--

CREATE TABLE `product_detail_image` (
  `id` varchar(11) NOT NULL,
  `product_detail_id` varchar(11) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `role`
--

INSERT INTO `role` (`id`, `name`, `status`) VALUES
(1, 'Admin', 1),
(3, 'Quản Lý', 1),
(5, 'Khách Hàng', 1),
(16, 'Thủ Kho', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_detail`
--

CREATE TABLE `role_detail` (
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `role_detail`
--

INSERT INTO `role_detail` (`role_id`, `module_id`, `action`) VALUES
(16, 2, ' Thêm'),
(16, 2, ' Sửa'),
(16, 2, ' Xóa'),
(16, 2, ' Xem'),
(16, 3, ' Thêm'),
(16, 3, ' Sửa'),
(16, 3, ' Xóa'),
(16, 3, ' Xem'),
(16, 4, ' Thêm'),
(16, 4, ' Sửa'),
(16, 4, ' Xóa'),
(16, 4, ' Xem');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `size`
--

CREATE TABLE `size` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `size`
--

INSERT INTO `size` (`id`, `name`, `status`) VALUES
(19, '38', 1),
(20, '39', 1),
(21, '40', 1),
(22, '41', 1),
(23, '42', 1),
(24, '43', 1),
(25, '44', 1),
(26, '45', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `phone`, `email`, `address`, `status`) VALUES
(1, 'PUMA Việt Nam ', '0909111222', 'puma@gmail.com', '65 Lê Lợi, phường Bến Nghé, quận 1,', 1),
(2, 'ADIDAS Việt Nam', '0909551122', 'adidasVietNam@gmail.com', 'Số 2 Hải Triều Bến Nghé Q1', 1),
(102, 'NIKE Việt Nam', '0909552727', 'nike@gmail.com', '93-95 NguyễnTrãi, P. Bến Thành, Quận 1.', 1),
(106, 'Vans Việt Nam', '0987654321', 'vans@gmail.com', '123 Đường abc xyz', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `status` tinyint(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `role_id`, `email`, `username`, `password`, `phone`, `img`, `status`, `date`) VALUES
(1, 5, 'quyquach@gmail.com', 'QuachQuy', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '0907146115', 'http://localhost/EShop_MVC/public/assets/img/air-jordan-1-low-se-shoes-hgcLbC.jpeg', 0, '2024-03-19 07:07:33'),
(12, 5, 'thienPhuc@gmail.com', 'ThienPhuc', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', '0987654321', 'http://localhost/EShop_MVC/public/assets/img/air-jordan-1-high-method-of-make-shoes-wvNP62.png', 0, '2024-03-24 19:37:05'),
(14, 5, 'qgq@gmail.com', 'QGQ', '', '0909556677', 'http://localhost/EShop_MVC/public/assets/img/7.jpg', 0, '2024-03-24 19:48:36'),
(20, 5, 'quyquach@gmaii.com', 'abcxyz1234', '', '0909552311', 'http://localhost/EShop_MVC/public/assets/img/8.jpg', 0, '2024-03-25 05:58:48'),
(27, 3, 'quy123@gmail.com', 'QuachQuy1222', '7c4a8d09ca3762af61e59520943dc26494f8941b', '0907146115', 'http://localhost/EShop_MVC/public/assets//img/6.jpg', 0, '2024-04-08 08:58:34'),
(41, 3, 'nguyetminh@gmail.com', 'NguyetMinh', '7c4a8d09ca3762af61e59520943dc26494f8941b', '0909888777', 'http://localhost/EShop_MVC/public/assets//img/3.jpg', 0, '2024-04-30 16:59:17'),
(43, 1, 'thanhThuy@gmail.com', 'ThanhThuy', '7c4a8d09ca3762af61e59520943dc26494f8941b', '0909552345', 'http://localhost/EShop_MVC/public/assets//img/air-jordan-1-mid-shoes-7cdjgS.jpeg', 0, '2024-04-30 17:02:04'),
(44, 16, 'vantai@gmail.com', 'VanTai', '7c4a8d09ca3762af61e59520943dc26494f8941b', '0909778844', 'http://localhost/EShop_MVC/public/assets//img/custom-nike-air-force-1-low-by-you (1).jpeg', 0, '2024-05-01 08:08:56'),
(45, 1, 'phuongthuy@gmail.com', 'PhuongThuy', '7c4a8d09ca3762af61e59520943dc26494f8941b', '0987654321', 'http://localhost/EShop_MVC/public/assets/img/custom-nike-air-force-1-low-by-you.jpeg', 0, '2024-05-01 08:25:31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_address`
--

CREATE TABLE `user_address` (
  `user_id` varchar(11) NOT NULL,
  `address_id` varchar(11) NOT NULL,
  `is_default` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cart_detail`
--
ALTER TABLE `cart_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `FK_product_detailID` (`product_detail_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_invoiceID` (`invoice_id`),
  ADD KEY `FK_productDetailID` (`productDetail_id`);

--
-- Chỉ mục cho bảng `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shipping_address` (`address`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_detail_id` (`order_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_detail_id_2` (`product_detail_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `FK_supplierID` (`supplier_id`);

--
-- Chỉ mục cho bảng `product_detail`
--
ALTER TABLE `product_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`,`size_id`,`color_id`),
  ADD KEY `size_id` (`size_id`),
  ADD KEY `colour_id` (`color_id`);

--
-- Chỉ mục cho bảng `product_detail_image`
--
ALTER TABLE `product_detail_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_detail_id`);

--
-- Chỉ mục cho bảng `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `role_detail`
--
ALTER TABLE `role_detail`
  ADD KEY `FK_roleID` (`role_id`),
  ADD KEY `FK_moduleID` (`module_id`);

--
-- Chỉ mục cho bảng `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Chỉ mục cho bảng `user_address`
--
ALTER TABLE `user_address`
  ADD KEY `address_id` (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `cart_detail`
--
ALTER TABLE `cart_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `color`
--
ALTER TABLE `color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `module`
--
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `product_detail`
--
ALTER TABLE `product_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT cho bảng `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `size`
--
ALTER TABLE `size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart_detail`
--
ALTER TABLE `cart_detail`
  ADD CONSTRAINT `FK_cartID` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `FK_product_detailID` FOREIGN KEY (`product_detail_id`) REFERENCES `product_detail` (`id`);

--
-- Các ràng buộc cho bảng `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD CONSTRAINT `FK_invoiceID` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`id`),
  ADD CONSTRAINT `FK_productDetailID` FOREIGN KEY (`productDetail_id`) REFERENCES `product_detail` (`id`);

--
-- Các ràng buộc cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`product_detail_id`) REFERENCES `product_detail` (`id`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_brandID` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  ADD CONSTRAINT `FK_categoryID` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_supplierID` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);

--
-- Các ràng buộc cho bảng `product_detail`
--
ALTER TABLE `product_detail`
  ADD CONSTRAINT `FK_colorID` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`),
  ADD CONSTRAINT `FK_productID` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `FK_sizeID` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`);

--
-- Các ràng buộc cho bảng `role_detail`
--
ALTER TABLE `role_detail`
  ADD CONSTRAINT `FK_moduleID` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`),
  ADD CONSTRAINT `FK_roleID` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Các ràng buộc cho bảng `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
