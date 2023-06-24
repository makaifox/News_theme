<?php
// Admin Bar
add_theme_support('admin-bar', array('callback' => '__return_false'));

// Adiciona o normalize.css para padronizar o layout da página.
function add_normalize_CSS()
{
  wp_enqueue_style('normalize-styles', "https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css");
}
add_action('wp_enqueue_scripts', 'add_normalize_CSS');

// Adiciona o jQuery
function add_jquery()
{
  wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'add_jquery');

// Função para carregar scripts e estilos
function theme_enqueue_scripts()
{
  // Carregar o arquivo scripts.js
  wp_enqueue_script('custom-scripts', get_stylesheet_directory_uri() . '/src/js/scripts.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');

// Adiciona o Bootstrap
require_once('src/bs4navwalker.php');

function enqueue_styles()
{
  wp_enqueue_style('bootstrap', get_template_directory_uri() . '/src/css/bootstrap.min.css');
  wp_enqueue_style('core', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_styles');

function enqueue_scripts()
{
  wp_enqueue_script('bootstrap', get_template_directory_uri() . '/src/js/bootstrap.bundle.min.js', array('jquery'));
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');

// Função para lidar com a submissão do formulário de cadastro de notícia
function handle_cadastro_noticia()
{
  // Verifica se o formulário foi submetido
  if (isset($_POST['action']) && $_POST['action'] === 'cadastro_noticia') {
    // Processa os dados do formulário
    $titulo = sanitize_text_field($_POST['titulo']);
    $conteudo = sanitize_textarea_field($_POST['conteudo']);
    $categoria = $_POST['categoria'];

    // Verifica se é uma nova categoria
    if ($categoria === 'nova_categoria') {
      $novaCategoria = sanitize_text_field($_POST['novaCategoria']);
      $categoria_id = criar_nova_categoria($novaCategoria);
    } else {
      $categoria_id = intval($categoria);
    }

    // Cria um novo post no WordPress
    $post_args = array(
      'post_title' => $titulo,
      'post_content' => $conteudo,
      'post_status' => 'publish',
      'post_type' => 'post',
      'post_category' => array($categoria_id)
    );

    $post_id = wp_insert_post($post_args);

    // Redireciona para a página inicial após a submissão do formulário
    wp_redirect(home_url());
    exit;
  }
}
add_action('admin_post_nopriv_cadastro_noticia', 'handle_cadastro_noticia');
add_action('admin_post_cadastro_noticia', 'handle_cadastro_noticia');

// Função para lidar com a submissão do formulário de cadastro de categoria
function handle_cadastro_categoria()
{
  // Verifica se o formulário foi submetido
  if (isset($_POST['action']) && $_POST['action'] === 'cadastro_categoria') {
    // Processa os dados do formulário
    $nome_categoria = sanitize_text_field($_POST['nomeCategoria']);

    // Cria uma nova categoria no WordPress
    $categoria_args = array(
      'cat_name' => $nome_categoria,
      'category_description' => '',
      'category_nicename' => '',
      'category_parent' => ''
    );

    $categoria_id = wp_insert_category($categoria_args);

    // Redireciona para a página inicial após a submissão do formulário
    wp_redirect(home_url());
    exit;
  }
}
add_action('admin_post_nopriv_cadastro_categoria', 'handle_cadastro_categoria');
add_action('admin_post_cadastro_categoria', 'handle_cadastro_categoria');

// Função para criar uma nova categoria
function criar_nova_categoria($nome_categoria)
{
  $categoria_args = array(
    'cat_name' => $nome_categoria,
    'category_description' => '',
    'category_nicename' => '',
    'category_parent' => ''
  );
  $categoria_id = wp_insert_category($categoria_args);

  return $categoria_id;
}

// Função para processar a edição da notícia
function edit_noticia()
{
  // Verifique o nonce de segurança
  if (!isset($_POST['cadastro_noticia_nonce']) || !wp_verify_nonce($_POST['cadastro_noticia_nonce'], 'cadastro_noticia')) {
    wp_die('Ação não autorizada.');
  }

  // Recupere os dados do formulário
  $post_id = $_POST['post_id'];
  $post_title = $_POST['editTitulo'];
  $post_content = $_POST['editConteudo'];
  $post_category = $_POST['editCategoria'];

  // Atualize os dados da notícia
  $updated_post = array(
    'ID' => $post_id,
    'post_title' => $post_title,
    'post_content' => $post_content,
    'post_category' => array($post_category)
  );
  wp_update_post($updated_post);

  // Redirecione para a página de notícias após a edição
  wp_redirect(get_permalink($post_id));
  exit();
}
add_action('admin_post_edit_noticia', 'edit_noticia');
add_action('admin_post_nopriv_edit_noticia', 'edit_noticia'); // Permita que usuários não logados editem a notícia

// Função para processar a exclusão da notícia
function delete_noticia()
{
  wp_die('Ação não autorizada.');
}
add_action('admin_post_delete_noticia', 'delete_noticia');
add_action('admin_post_nopriv_delete_noticia', 'delete_noticia'); // Permita que usuários não logados excluam a notícia
