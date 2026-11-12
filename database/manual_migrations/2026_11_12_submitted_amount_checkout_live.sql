-- Run once against the live MySQL database after deploying the matching application code.
ALTER TABLE `payments`
    ADD COLUMN `submitted_amount` DECIMAL(12,2) NULL AFTER `amount`;

SET @submitted_amount_batch = (SELECT COALESCE(MAX(`batch`), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`migration`, `batch`)
VALUES ('2026_11_12_070000_add_submitted_amount_to_payments_table', @submitted_amount_batch);
