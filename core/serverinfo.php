<?php
### Function: Format Bytes Into TiB/GiB/MiB/KiB/Bytes
if(!function_exists('format_filesize')) {
    function format_filesize($rawSize) {
        if($rawSize / 1099511627776 > 1) {
            return number_format_i18n($rawSize/1099511627776, 1).' '.__('TiB', 'wp-serverinfo');
        } elseif($rawSize / 1073741824 > 1) {
            return number_format_i18n($rawSize/1073741824, 1).' '.__('GiB', 'wp-serverinfo');
        } elseif($rawSize / 1048576 > 1) {
            return number_format_i18n($rawSize/1048576, 1).' '.__('MiB', 'wp-serverinfo');
        } elseif($rawSize / 1024 > 1) {
            return number_format_i18n($rawSize/1024, 1).' '.__('KiB', 'wp-serverinfo');
        } elseif($rawSize > 1) {
            return number_format_i18n($rawSize, 0).' '.__('bytes', 'wp-serverinfo');
        } else {
            return __('unknown', 'wp-serverinfo');
        }
    }
}

### Function: Convert PHP Size Format to Localized
function format_php_size($size) {
    if (!is_numeric($size)) {
        if (strpos($size, 'M') !== false) {
            $size = intval($size)*1024*1024;
        } elseif (strpos($size, 'K') !== false) {
            $size = intval($size)*1024;
        } elseif (strpos($size, 'G') !== false) {
            $size = intval($size)*1024*1024*1024;
        }
    }
    return is_numeric($size) ? format_filesize($size) : $size;
}

### Function: Get PHP Short Tag
if(!function_exists('get_php_short_tag')) {
    function get_php_short_tag() {
        if(ini_get('short_open_tag')) {
            $short_tag = __('On', 'wp-serverinfo');
        } else {
            $short_tag = __('Off', 'wp-serverinfo');
        }
        return $short_tag;
    }
}


### Function: Get PHP Magic Quotes GPC
if(!function_exists('get_php_magic_quotes_gpc')) {
    function get_php_magic_quotes_gpc() {
        if(get_magic_quotes_gpc()) {
            $magic_quotes_gpc = __('On', 'wp-serverinfo');
        } else {
            $magic_quotes_gpc = __('Off', 'wp-serverinfo');
        }
        return $magic_quotes_gpc;
    }
}


### Function: Get PHP Max Upload Size
if(!function_exists('get_php_upload_max')) {
    function get_php_upload_max() {
        if(ini_get('upload_max_filesize')) {
            $upload_max = ini_get('upload_max_filesize');
        } else {
            $upload_max = __('N/A', 'wp-serverinfo');
        }
        return $upload_max;
    }
}





### Function: PHP Memory Limit
if(!function_exists('get_php_memory_limit')) {
    function get_php_memory_limit() {
        if(ini_get('memory_limit')) {
            $memory_limit = ini_get('memory_limit');
        } else {
            $memory_limit = __('N/A', 'wp-serverinfo');
        }
        return $memory_limit;
    }
}


### Function: Get MYSQL Version
if(!function_exists('get_mysql_version')) {
    function get_mysql_version() {
        global $wpdb;
        return $wpdb->get_var("SELECT VERSION() AS version");
    }
}


### Function: Get MYSQL Data Usage
if(!function_exists('get_mysql_data_usage')) {
    function get_mysql_data_usage() {
        global $wpdb;
        $data_usage = 0;
        $tablesstatus = $wpdb->get_results("SHOW TABLE STATUS");
        foreach($tablesstatus as  $tablestatus) {
            $data_usage += $tablestatus->Data_length;
        }

        return $data_usage;
    }
}


### Function: Get MYSQL Index Usage
if(!function_exists('get_mysql_index_usage')) {
    function get_mysql_index_usage() {
        global $wpdb;
        $index_usage = 0;
        $tablesstatus = $wpdb->get_results("SHOW TABLE STATUS");
        foreach($tablesstatus as  $tablestatus) {
            $index_usage +=  $tablestatus->Index_length;
        }

        return $index_usage;
    }
}


### Function: Get MYSQL Max Allowed Packet
if(!function_exists('get_mysql_max_allowed_packet')) {
    function get_mysql_max_allowed_packet() {
        global $wpdb;
        $packet_max_query = $wpdb->get_row("SHOW VARIABLES LIKE 'max_allowed_packet'");

        return $packet_max_query->Value;
    }
}


### Function:Get MYSQL Max Allowed Connections
if(!function_exists('get_mysql_max_allowed_connections')) {
    function get_mysql_max_allowed_connections() {
        global $wpdb;
        $connection_max_query = $wpdb->get_row("SHOW VARIABLES LIKE 'max_connections'");

        return $connection_max_query->Value;
    }
}



### Function: Get GD Version
if(!function_exists('get_gd_version')) {
    function get_gd_version() {
        if (function_exists('gd_info')) {
            $gd = gd_info();
            $gd = $gd["GD Version"];
        } else {
            ob_start();
            phpinfo(8);
            $phpinfo = ob_get_contents();
            ob_end_clean();
            $phpinfo = strip_tags($phpinfo);
            $phpinfo = stristr($phpinfo,"gd version");
            $phpinfo = stristr($phpinfo,"version");
            $gd = substr($phpinfo,0,strpos($phpinfo,"\n"));
        }
        if(empty($gd)) {
            $gd = __('N/A', 'wp-serverinfo');
        }
        return $gd;
    }
}





### Function: Register ServerInfo Dashboard Widget
add_action('wp_dashboard_setup', 'serverinfo_register_dashboard_widget');
function serverinfo_register_dashboard_widget() {
    if(current_user_can('manage_options')) {
        wp_add_dashboard_widget('dashboard_serverinfo', __('Server Information', 'wp-serverinfo'), 'wp_dashboard_serverinfo');
    }
}


### Function: Print ServerInfo Dashboard Widget
function wp_dashboard_serverinfo() {
    if( is_rtl() ) {
        echo '<style type="text/css"> #wp-serverinfo ul { padding-left: 15px !important; } </style>';
        echo '<div id="wp-serverinfo" style="direction: ltr; text-align: left;">';
    } else {
        echo '<div id="wp-serverinfo">';
    }
    echo '<p><strong>'.__('General', 'wp-serverinfo').'</strong></p>';
    echo '<ul>';
    echo '<li>'. __('OS', 'wp-serverinfo').': <strong>'.PHP_OS.'</strong></li>';
    echo '<li>'. __('Server', 'wp-serverinfo').': <strong>'.$_SERVER["SERVER_SOFTWARE"].'</strong></li>';
    echo '<li>'. __('Hostname', 'wp-serverinfo').': <strong>'.$_SERVER['SERVER_NAME'].'</strong></li>';
    echo '<li>'. __('IP:Port', 'wp-serverinfo').': <strong>'.$_SERVER['SERVER_ADDR'].':'.$_SERVER['SERVER_PORT'].'</strong></li>';
    echo '<li>'. __('Document Root', 'wp-serverinfo').': <strong>'.$_SERVER['DOCUMENT_ROOT'].'</strong></li>';
    echo '</ul>';
    echo '<p><strong>PHP</strong></p>';
    echo '<ul>';
    echo '<li>v<strong>'.PHP_VERSION.'</strong></li>';
    echo '<li>GD: <strong>'.get_gd_version().'</strong></li>';
    echo '<li>'. __('Magic Quotes GPC', 'wp-serverinfo').': <strong>'.get_php_magic_quotes_gpc().'</strong></li>';
    echo '<li>'. __('Memory Limit', 'wp-serverinfo').': <strong>'.format_php_size(get_php_memory_limit()).'</strong></li>';
    echo '<li>'. __('Max Upload Size', 'wp-serverinfo').': <strong>'.format_php_size(get_php_upload_max()).'</strong></li>';
    echo '</ul>';
    echo '<p><strong>MYSQL</strong></p>';
    echo '<ul>';
    echo '<li>v<strong>'.get_mysql_version().'</strong></li>';
    echo '<li>'. __('Maximum No. Connections', 'wp-serverinfo').': <strong>'.number_format_i18n(get_mysql_max_allowed_connections(), 0).'</strong></li>';
    echo '<li>'. __('Maximum Packet Size', 'wp-serverinfo').': <strong>'.format_filesize(get_mysql_max_allowed_packet()).'</strong></li>';
    echo '<li>'. __('Data Disk Usage', 'wp-serverinfo').': <strong>'.format_filesize(get_mysql_data_usage()).'</strong></li>';
    echo '<li>'. __('Index Disk Usage', 'wp-serverinfo').': <strong>'.format_filesize(get_mysql_index_usage()).'</strong></li>';
    echo '</ul>';
    echo '</div>';
}?>