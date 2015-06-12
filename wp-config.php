<?php
# Database Configuration
define( 'DB_NAME', 'wp_samplewp' );
define( 'DB_USER', 'samplewp' );
define( 'DB_PASSWORD', 'O3GOuXhz6HrhDLh4v9zH' );
define( 'DB_HOST', '127.0.0.1' );
define( 'DB_HOST_SLAVE', '127.0.0.1' );
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', 'utf8_unicode_ci');
$table_prefix = 'wp_';

# Security Salts, Keys, Etc
define('AUTH_KEY',         '8#&}[=|l6y3)*7> D=MkA4cQT`!>FYG5yZ?YWqLhRU8Q?^v6tvRDE4le.EBbojP$');
define('SECURE_AUTH_KEY',  '=Y*_zt_aj&N@Gy+jtCK[?P9~A;:Zb~qfb/.;5VMFcNTA)WQdHf|b-+d#H|@$$ht7');
define('LOGGED_IN_KEY',    '[|ZxkQa LN%p`ot8e!csg2V@-%qf<ctnYIz|pH7E*m6S`PeqXBK:?I-%0#iOFnO.');
define('NONCE_KEY',        'x0hFsVt|2<.+czAL;9z+9Z7l(|.DU]Bzab-GE*ij(?R>e_|$~9La~sV~8E,g-~u;');
define('AUTH_SALT',        '58.Fs,DySh,]$EKop^!BbZ/$ bS^3`;3#;vG3_Ua @y`B*7`c<RJe-V[Dk&FwXp?');
define('SECURE_AUTH_SALT', 'dFv0E|n;6[kFtF:#BEhRSjyJ-,,L-]w ?3NxihuO|_%},}~<c6@76>{~zUh6uejI');
define('LOGGED_IN_SALT',   'O~C<H0;.;MWExSzut<A *~+.g.1w{(eX0EicWJ3:8!x9obKNNV9(>!h+)-b|beNd');
define('NONCE_SALT',       '!U-HH,,[.9`-st:RS1d,?SO9?@{8Y<}]cu_iwy8 P&gDW46oni6rJ}_V7~%^=%Tl');


# Localized Language Stuff

define( 'WP_CACHE', TRUE );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'PWP_NAME', 'samplewp' );

define( 'FS_METHOD', 'direct' );

define( 'FS_CHMOD_DIR', 0775 );

define( 'FS_CHMOD_FILE', 0664 );

define( 'PWP_ROOT_DIR', '/nas/wp' );

define( 'WPE_APIKEY', '9328cf15f02a6f875cb0f5dcb698414f7ddd94ab' );

define( 'WPE_FOOTER_HTML', "" );

define( 'WPE_CLUSTER_ID', '2965' );

define( 'WPE_CLUSTER_TYPE', 'pod' );

define( 'WPE_ISP', true );

define( 'WPE_BPOD', false );

define( 'WPE_RO_FILESYSTEM', false );

define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );

define( 'WPE_SFTP_PORT', 22 );

define( 'WPE_LBMASTER_IP', '23.92.26.125' );

define( 'WPE_CDN_DISABLE_ALLOWED', true );

define( 'DISALLOW_FILE_EDIT', FALSE );

define( 'DISALLOW_FILE_MODS', FALSE );

define( 'DISABLE_WP_CRON', false );

define( 'WPE_FORCE_SSL_LOGIN', false );

define( 'FORCE_SSL_LOGIN', false );

/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/

define( 'WPE_EXTERNAL_URL', false );

define( 'WP_POST_REVISIONS', FALSE );

define( 'WPE_WHITELABEL', 'wpengine' );

define( 'WP_TURN_OFF_ADMIN_BAR', false );

define( 'WPE_BETA_TESTER', false );

umask(0002);

$wpe_cdn_uris=array ( );

$wpe_no_cdn_uris=array ( );

$wpe_content_regexs=array ( );

$wpe_all_domains=array ( 0 => 'samplewp.wpengine.com', );

$wpe_varnish_servers=array ( 0 => 'pod-2965', );

$wpe_special_ips=array ( 0 => '23.92.26.125', );

$wpe_ec_servers=array ( );

$wpe_largefs=array ( );

$wpe_netdna_domains=array ( );

$wpe_netdna_domains_secure=array ( );

$wpe_netdna_push_domains=array ( );

$wpe_domain_mappings=array ( );

$memcached_servers=array ( );
define('WPLANG','');

# WP Engine ID


# WP Engine Settings






# That's It. Pencils down
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');

$_wpe_preamble_path = null; if(false){}
