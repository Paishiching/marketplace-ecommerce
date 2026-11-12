-- Run once against the live MySQL database after deploying the matching application code.
ALTER TABLE `payments`
    ADD COLUMN `payer_account` VARCHAR(30) NULL AFTER `payment_method_code`;

SET @mobile_banking_batch = (SELECT COALESCE(MAX(`batch`), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`migration`, `batch`)
VALUES ('2026_11_12_060000_add_payer_account_to_payments_table', @mobile_banking_batch);
