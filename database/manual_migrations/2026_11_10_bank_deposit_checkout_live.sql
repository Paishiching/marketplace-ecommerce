-- Run this once against the live MySQL database after deploying the matching application code.
-- It creates the checkout bank-deposit detail table, stores the chosen payment-method code,
-- and records the Laravel migrations so `php artisan migrate` will not run them a second time.

ALTER TABLE `payments`
    ADD COLUMN `payment_method_code` VARCHAR(40) NULL AFTER `payment_method_id`;

CREATE TABLE `payment_deposit_details` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `payment_id` BIGINT UNSIGNED NOT NULL,
    `order_id` BIGINT UNSIGNED NOT NULL,
    `deposit_date` DATE NOT NULL,
    `depositor_bank` VARCHAR(150) NOT NULL,
    `depositor_branch` VARCHAR(150) NOT NULL,
    `deposit_type` VARCHAR(30) NOT NULL,
    `amount` DECIMAL(12,2) NOT NULL,
    `company_account` VARCHAR(190) NOT NULL,
    `bank_name` VARCHAR(150) NOT NULL,
    `company_name` VARCHAR(150) NOT NULL,
    `receipt_id` VARCHAR(190) NULL,
    `receipt_path` VARCHAR(255) NOT NULL,
    `remark` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `payment_deposit_details_payment_id_unique` (`payment_id`),
    KEY `payment_deposit_details_order_id_foreign` (`order_id`),
    CONSTRAINT `payment_deposit_details_payment_id_foreign`
        FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE,
    CONSTRAINT `payment_deposit_details_order_id_foreign`
        FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET @bank_deposit_batch = (SELECT COALESCE(MAX(`batch`), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
    ('2026_11_10_010000_create_payment_deposit_details_table', @bank_deposit_batch),
    ('2026_11_10_020000_add_payment_method_code_to_payments_table', @bank_deposit_batch);
