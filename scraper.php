<?php

require_once 'simple_html_dom.php';

function get_links($url, $max_depth, $user_agent = null, $proxy = null, $depth = 0, &$all_links = [])
{
    if ($depth > $max_depth) {
        return $all_links;
    }

    $html = file_get_html_with_proxy($url, $user_agent, $proxy);
    if (! $html) {
        return $all_links;
    }

    foreach ($html->find('a') as $element) {
        $link = $element->href;
        if (! in_array($link, $all_links)) {
            $all_links[] = $link;
            get_links($link, $max_depth, $user_agent, $proxy, $depth + 1, $all_links);
        }
    }

    return $all_links;
}

function save_assets($url, $save_dir, $user_agent = null, $proxy = null)
{
    $html = file_get_html_with_proxy($url, $user_agent, $proxy);
    if (! $html) {
        return;
    }

    // Сохранение изображений
    foreach ($html->find('img') as $element) {
        $src = $element->src;
        download_file($src, $save_dir, $user_agent, $proxy);
    }

    // Сохранение CSS
    foreach ($html->find('link[rel=stylesheet]') as $element) {
        $href = $element->href;
        download_file($href, $save_dir, $user_agent, $proxy);
    }

    // Сохранение JS
    foreach ($html->find('script') as $element) {
        $src = $element->src;
        download_file($src, $save_dir, $user_agent, $proxy);
    }
}

function save_page($url, $save_dir, $user_agent = null, $proxy = null)
{
    $html = file_get_html_with_proxy($url, $user_agent, $proxy);
    if (! $html) {
        return;
    }

    $filename = $save_dir . '/' . basename($url) . '.html';
    file_put_contents($filename, $html);
}

function file_get_html_with_proxy($url, $user_agent = null, $proxy = null)
{
    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => 'Accept-language: en\r\n',
        ]
    ];

    if ($user_agent) {
        $opts['http']['header'] .= 'User-Agent: ' . $user_agent . '\r\n';
    }

    if ($proxy) {
        $opts['http']['proxy'] = 'tcp://' . $proxy;
        $opts['http']['request_fulluri'] = true;
    }

    $context = stream_context_create($opts);
    $html = file_get_contents($url, false, $context);
    return str_get_html($html);
}

function download_file($url, $save_dir, $user_agent = null, $proxy = null)
{
    $path = $save_dir . '/' . basename($url);
    if (file_exists($path)) {
        return;
    }

    $file_contents = file_get_contents_with_proxy($url, $user_agent, $proxy);
    if ($file_contents !== false) {
        file_put_contents($path, $file_contents);
    }
}

function file_get_contents_with_proxy($url, $user_agent = null, $proxy = null)
{
    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => 'Accept-language: en\r\n',
        ]
    ];

    if ($user_agent) {
        $opts['http']['header'] .= 'User-Agent: ' . $user_agent . '\r\n';
    }

    else $user_agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X x.y; rv:42.0) Gecko/20100101 Firefox/42.0';

    if ($proxy) {
        $opts['http']['proxy'] = 'tcp://' . $proxy;
        $opts['http']['request_fulluri'] = true;
    }
    // else $proxy = null;

    $context = stream_context_create($opts);
    return file_get_contents($url, false, $context);
}

// Пример использования:

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $url = $_POST['url'];
    $save_dir = $_POST['save_dir'];
    $max_depth = $_POST['max_depth'];
    $user_agent = empty($_POST['user_agent']) ? null : $_POST['user_agent'];
    $proxy = empty($_POST['proxy']) ? null : $_POST['proxy'];

    $links = get_links($url, $max_depth, $user_agent, $proxy);

    foreach ($links as $link) {
        save_page($link, $save_dir, $user_agent, $proxy);
        save_assets($link, $save_dir, $user_agent, $proxy);
    }

    header('Location: preview.php');
}