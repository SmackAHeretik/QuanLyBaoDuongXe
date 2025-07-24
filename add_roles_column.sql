-- Migration script to add Roles column to nhanvien table if it doesn't exist
-- This should be run if the Roles column doesn't exist in the database

ALTER TABLE `nhanvien` ADD COLUMN `Roles` VARCHAR(50) DEFAULT NULL AFTER `SDT`;

-- Update existing records to have a default role if needed
-- UPDATE `nhanvien` SET `Roles` = 'Thợ sửa xe' WHERE `Roles` IS NULL;