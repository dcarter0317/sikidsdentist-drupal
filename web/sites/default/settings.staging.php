<?php

/**
 * @file
 * Staging environment settings for Hostinger.
 * 
 * INSTRUCTIONS:
 * 1. Upload this file to the Hostinger server inside:
 *    public_html/sikidsdentist/web/sites/default/
 * 2. Rename this file to: settings.local.php
 * 3. Update the database credentials below with the ones you create in hPanel.
 */

// 1. Hostinger Staging Database Configuration
// This file becomes settings.local.php on the server and is gitignored,
// so it's safe to put the real password directly below.
$databases['default']['default'] = [
  'database' => 'u123456789_staging',   // Replace with your Hostinger DB name (e.g. u123456789_db)
  'username' => 'u123456789_dbuser',    // Replace with your Hostinger DB username
  'password' => 'REPLACE_WITH_REAL_DB_PASSWORD', // Replace with your Hostinger DB user password
  'host' => '127.0.0.1',                // Hostinger databases use 127.0.0.1 or localhost
  'port' => '3306',
  'driver' => 'mysql',
  'prefix' => '',
  'collation' => 'utf8mb4_general_ci',
];

// 2. Security Settings
// Pre-generated secure hash salt for your staging site
$settings['hash_salt'] = '8d92f7c6e7a5b3d29c41f9e8a7b6c5d4e3f2a1b0c9d8e7f6a5b4c3d2e1f0a9b8';

// Prevent host spoofing by limiting access to your custom subdomain
$settings['trusted_host_patterns'] = [
  '^sikidsdentist\.dcartdevelopment\.com$',
  '^www\.sikidsdentist\.dcartdevelopment\.com$',
];

// 3. File System Paths
$settings['file_public_path'] = 'sites/default/files';
$settings['config_sync_directory'] = 'sites/default/files/sync';

// Disable skip permissions hardening for security on production/staging
$settings['skip_permissions_hardening'] = FALSE;

// 4. Performance & Logging
// Set error logging to show errors on staging for debugging (change to 'none' for production)
$config['system.logging']['error_level'] = 'verbose';

// Disable CSS/JS aggregation if you need to debug custom theme styles, or keep enabled for speed
$config['system.performance']['css']['preprocess'] = TRUE;
$config['system.performance']['js']['preprocess'] = TRUE;
