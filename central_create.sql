
Table	Create Table
payment_methods	CREATE TABLE `payment_methods` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `global_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `processing_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_provider_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `has_send_verification_email` tinyint(1) NOT NULL DEFAULT '0',
  `is_void` tinyint(1) NOT NULL DEFAULT '0',
  `has_refund` tinyint(1) NOT NULL DEFAULT '0',
  `payment_method_type_global_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_methods_global_id_unique` (`global_id`),
  KEY `payment_methods_payment_provider_id_foreign` (`payment_provider_id`),
  KEY `payment_methods_payment_method_type_global_id_foreign` (`payment_method_type_global_id`),
  CONSTRAINT `payment_methods_payment_method_type_global_id_foreign` FOREIGN KEY (`payment_method_type_global_id`) REFERENCES `payment_method_types` (`global_id`) ON DELETE SET NULL,
  CONSTRAINT `payment_methods_payment_provider_id_foreign` FOREIGN KEY (`payment_provider_id`) REFERENCES `payment_providers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
