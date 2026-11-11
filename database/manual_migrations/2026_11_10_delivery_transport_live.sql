-- Run once against the live MySQL database after deploying the matching application code.
-- Adds the self-transport fields to shipments and marks the Laravel migration as applied.

ALTER TABLE `shipments`
    ADD COLUMN `transport_type` VARCHAR(30) NOT NULL DEFAULT 'self' AFTER `courier_id`,
    ADD COLUMN `driver_name` VARCHAR(150) NULL AFTER `transport_type`,
    ADD COLUMN `driver_phone` VARCHAR(30) NULL AFTER `driver_name`,
    ADD COLUMN `vehicle_number` VARCHAR(50) NULL AFTER `driver_phone`,
    ADD COLUMN `vehicle_owner` VARCHAR(150) NULL AFTER `vehicle_number`,
    ADD COLUMN `expected_arrival_at` DATE NULL AFTER `shipped_at`;

SET @delivery_transport_batch = (SELECT COALESCE(MAX(`batch`), 0) + 1 FROM `migrations`);

INSERT INTO `migrations` (`migration`, `batch`)
VALUES ('2026_11_10_030000_add_self_transport_details_to_shipments_table', @delivery_transport_batch);
