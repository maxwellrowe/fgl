<?php

/*
  Plugin Name: ProfProjects - URL 301 Redirections
  Plugin URI: http://profprojects.com/
  Description: Redirects Source CMS Articles to New Wordpress Posts
  Version: 2.8.4
  Author: profprojects.com
  Author URI: http://profprojects.com/
 */

function pp_redirection_raw() {
    global $wpdb;
    $value = false;
    $article = false;
    $tag = false;

    if (preg_match('|option\=com_glossary\&id\=([\d]+)|is', $_SERVER['REQUEST_URI'], $array)) {
        $value = ($array[1]) ? 'd' . trim($array[1]) : false;
        $article = true;
    } elseif (preg_match('|option\=com_k2\&view\=item\&id\=([\d]+)|is', $_SERVER['REQUEST_URI'], $array)) {
        $value = ($array[1]) ? 'k' . trim($array[1]) : false;
        $article = true;
    } elseif (preg_match('|option\=com_content\&view\=article\&id\=([\d]+)|is', $_SERVER['REQUEST_URI'], $array)) {
        $value = ($array[1]) ? 'j' . trim($array[1]) : false;
        $article = true;
    } elseif (preg_match('|option\=com_content\&amp\;view\=article\&amp\;id\=([\d]+)|is', $_SERVER['REQUEST_URI'], $array)) {
        $value = ($array[1]) ? 'j' . trim($array[1]) : false;
    } elseif (preg_match('|option\=com_content\&task\=view\&id\=([\d]+)|is', $_SERVER['REQUEST_URI'], $array)) {
        $value = ($array[1]) ? 'j' . trim($array[1]) : false;
        $article = true;
    } elseif (preg_match('|option\=com_k2\&view\=itemlist\&task\=tag\&tag\=([^\&]+)|is', $_SERVER['REQUEST_URI'], $array)) {
        $location = trim(get_bloginfo('url'), '/') . '/tag/' . str_replace('+', '-', $array[1]) . '/';
        $article = false;
        $tag = true;
    }

    if ($value && $article) {
        $post_id = $wpdb->get_var("SELECT `post_id` FROM `" . $wpdb->prefix . "postmeta` WHERE `meta_value` = '" . $value . "' AND `meta_key` = '_gcid'");
        if ($post_id == '') {
            $post_id = $wpdb->get_var("SELECT `post_id` FROM `" . $wpdb->prefix . "postmeta` WHERE `meta_value` = '" . str_replace(array('d', 'j', 'k'), '', $value) . "' AND `meta_key` = '_gcid'");
        }
        if ($post_id) {
            $location = get_permalink($post_id);
            if ($location) {
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: ' . $location);
                exit;
            }
        }
    } elseif ($tag) {
        if ($location) {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $location);
            exit;
        }
    }
}

function pp_redirection() {
    global $wpdb;
    $currrent = str_replace(array('http://', 'www.'), '', trim(get_bloginfo('url'), '/'));
    $host = trim($_SERVER["HTTP_HOST"], '/');
    $pathinfo = pathinfo(trim(get_bloginfo('url'), '/'));
    $path = trim($pathinfo['dirname'], '/');
    $domain_filter = array(0 => 'http://' . $host, 1 => 'http://www.' . $host, 2 => 'http://' . $host . '/' . $path, 3 => 'http://www.' . $host . '/' . $path, 4 => $currrent);
	$postname = '';

    if (preg_match('|\/([^\/]+)\.html$|is', trim($_SERVER['REQUEST_URI'], '/'), $gslug)) {
        $postname = $gslug[1]; 
    } elseif (preg_match('|\/([^\/]+)$|is', trim($_SERVER['REQUEST_URI'], '/'), $gslug)) {
        $postname = $gslug[1];
    } elseif (preg_match('|\/([^\/]+)\/$|is', trim($_SERVER['REQUEST_URI'], '/'), $gslug)) {
        $postname = $gslug[1];
    }

    if (strpos($_SERVER['REQUEST_URI'], 'page/') === FALSE) {
        if ($postname) {
            $postID = $wpdb->get_var("SELECT `ID` FROM `" . $wpdb->prefix . "posts` WHERE `post_name` = '" . $wpdb->escape($postname) . "'");
            if ($postID) {
                $location = get_permalink($postID);
                $FORCOMP = str_replace($domain_filter, '', $location);
                if (trim($FORCOMP, '/') == trim($_SERVER['REQUEST_URI'], '/')) {
                    //Wordpress URL
                } else {
                    //301 Redirection to Wordpress URL 
                    if (strpos($location, trim($_SERVER['REQUEST_URI'], '/')) === FALSE) {
                        header('HTTP/1.1 301 Moved Permanently');
                        header('Location: ' . $location);
                        exit;
                    } else {
					}
                }
            }
        }
    }
}

add_action('parse_request', 'pp_redirection_raw');
add_action('parse_request', 'pp_redirection'); 
?>
