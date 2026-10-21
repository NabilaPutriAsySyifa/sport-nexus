-- Sport Nexus Database Schema
USE sport_nexus;

-- 1. Brands Table
CREATE TABLE IF NOT EXISTS brands (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    logo VARCHAR(255) NULL,
    sub_brands TEXT NULL,
    total_quota INT DEFAULT 0,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    show_in_marquee TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Products Table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(60) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    brand_id INT NOT NULL,
    brand_name VARCHAR(100) NOT NULL,
    gender ENUM('Men', 'Women', 'Unisex', 'Boys', 'Girls', 'Unisex Kids') DEFAULT 'Men',
    primary_sport VARCHAR(50) DEFAULT 'Lifestyle',
    footwear_type VARCHAR(50) DEFAULT 'Sneakers',
    color VARCHAR(50) DEFAULT 'Black',
    original_price DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    discount_percent INT NOT NULL DEFAULT 0,
    sale_price DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    thumbnail VARCHAR(255) NULL,
    images JSON NULL,
    description TEXT NULL,
    is_published TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_brand (brand_id),
    INDEX idx_gender (gender),
    INDEX idx_sport (primary_sport),
    INDEX idx_footwear_type (footwear_type),
    INDEX idx_color (color),
    INDEX idx_price (sale_price),
    INDEX idx_discount (discount_percent),
    INDEX idx_published (is_published)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Product SKUs Table (Sizing and physical stock matrix)
CREATE TABLE IF NOT EXISTS product_skus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    sku_code VARCHAR(100) NOT NULL,
    size_eu VARCHAR(20) NOT NULL,
    size_us VARCHAR(20) NULL,
    stock_qty INT NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_product_id (product_id),
    INDEX idx_size_eu (size_eu),
    INDEX idx_size_us (size_us),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Users Table (Customer)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    date_of_birth DATE NULL,
    gender ENUM('Male', 'Female') DEFAULT 'Male',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. User Addresses Table (Multi-address support)
CREATE TABLE IF NOT EXISTS user_addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    recipient_name VARCHAR(100) NOT NULL,
    phone_number VARCHAR(30) NOT NULL,
    full_address TEXT NOT NULL,
    province VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    district VARCHAR(100) NOT NULL,
    postal_code VARCHAR(10) NOT NULL,
    is_primary TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_id (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Admin Users Table (Isolated admin accounts with role and secret key validation)
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    work_email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    employee_id VARCHAR(50) NOT NULL UNIQUE,
    role ENUM('Super Admin', 'Stock & Catalog Manager', 'Order Operator', 'Finance Staff') DEFAULT 'Super Admin',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Orders Table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_number VARCHAR(50) NOT NULL UNIQUE,
    user_id INT NULL,
    recipient_name VARCHAR(100) NOT NULL,
    recipient_phone VARCHAR(30) NOT NULL,
    shipping_address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    district VARCHAR(100) NULL,
    postal_code VARCHAR(10) NOT NULL,
    shipping_courier VARCHAR(50) NOT NULL DEFAULT 'Regular Courier',
    payment_method VARCHAR(50) NOT NULL,
    billing_same_as_shipping TINYINT(1) DEFAULT 1,
    promo_code VARCHAR(50) NULL,
    discount_amount DECIMAL(12,2) DEFAULT 0.00,
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    shipping_fee DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    total_amount DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    order_status ENUM('Pending', 'Paid', 'Processing', 'Shipped', 'Completed', 'Cancelled') DEFAULT 'Paid',
    tracking_number VARCHAR(100) NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (order_status),
    INDEX idx_invoice (invoice_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Order Items Table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NULL,
    sku_code VARCHAR(100) NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    brand_name VARCHAR(100) NOT NULL,
    thumbnail VARCHAR(255) NULL,
    size_eu VARCHAR(20) NOT NULL,
    color VARCHAR(50) NULL,
    unit_price DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    quantity INT NOT NULL DEFAULT 1,
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    INDEX idx_order_id (order_id),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Promos Table (Voucher Manager)
CREATE TABLE IF NOT EXISTS promos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    promo_code VARCHAR(50) NOT NULL UNIQUE,
    discount_type ENUM('percentage', 'fixed') DEFAULT 'percentage',
    discount_value DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    min_purchase DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    quota_limit INT DEFAULT 100,
    used_count INT DEFAULT 0,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Hero Banners Table
CREATE TABLE IF NOT EXISTS hero_banners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    headline VARCHAR(255) NOT NULL,
    subheadline TEXT NULL,
    desktop_image VARCHAR(255) NOT NULL,
    mobile_image VARCHAR(255) NULL,
    cta_label VARCHAR(50) DEFAULT 'Beli Sekarang',
    cta_link VARCHAR(255) DEFAULT '/brands.html',
    target_brand VARCHAR(50) NULL,
    sort_order INT DEFAULT 1,
    is_published TINYINT(1) DEFAULT 1,
    start_date DATE NULL,
    end_date DATE NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Store Locations Table
CREATE TABLE IF NOT EXISTS store_locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    store_name VARCHAR(150) NOT NULL,
    city VARCHAR(50) NOT NULL,
    address TEXT NOT NULL,
    postal_code VARCHAR(10) NULL,
    latitude DECIMAL(10,8) NOT NULL,
    longitude DECIMAL(11,8) NOT NULL,
    maps_url TEXT NOT NULL,
    operating_hours VARCHAR(100) DEFAULT '10:00 - 22:00 WIB',
    phone VARCHAR(30) DEFAULT '+62 857-1737-2990',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Email OTPs Table
CREATE TABLE IF NOT EXISTS email_otps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) NOT NULL,
    otp_code VARCHAR(10) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email_otp (email, otp_code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
