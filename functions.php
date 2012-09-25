<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/TwigProxy.php';

function twig_template($filename)
{
    $wp = new TwigProxy();

    $loader = new Twig_Loader_Filesystem(dirname(__FILE__));
    $twig = new Twig_Environment($loader, array(
                'cache' => false
            ));
    $template = $twig->loadTemplate($filename);

    $data = get_template_data($filename);

    $template->display(
        array_merge(array('wp' => $wp), get_template_data($filename))
    );
}

function get_template_data($filename)
{
    $data = array();
    switch ($filename) {
        case 'index.twig':
            $data['posts'] = get_posts();
            break;
        case 'single.twig':
            global $post;
            $data['post'] = $post;
            break;
    }

    return $data;
}

// Sidebar register
if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'Sidebar Widgets',
        'id'   => 'sidebar-widgets',
        'description'   => 'These are widgets for the sidebar.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>'
    ));
}