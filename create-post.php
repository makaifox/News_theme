<?php
// Carregue o arquivo wp-load.php para ter acesso às funções do WordPress
require_once('wp-load.php');

// Verifique se o formulário foi enviado
if (isset($_POST['submit'])) {
  // Recupere os dados do formulário
  $post_title = $_POST['post_title'];
  $post_content = $_POST['post_content'];
  $post_category = $_POST['post_category']; // Adicione esta linha para obter a categoria selecionada

  if ($post_category === 'nova_categoria' && isset($_POST['novaCategoria'])) {
    // Crie uma nova categoria
    $nova_categoria = sanitize_text_field($_POST['novaCategoria']);
    $categoria_args = array(
      'cat_name' => $nova_categoria,
      'category_description' => '',
      'category_nicename' => '',
      'category_parent' => ''
    );
    $categoria_id = wp_insert_category($categoria_args);

    // Defina a nova categoria como a categoria selecionada
    $post_category = $categoria_id;
  }

  // Crie um novo post
  $new_post = array(
    'post_title' => $post_title,
    'post_content' => $post_content,
    'post_status' => 'publish',
    'post_author' => 1, // ID do autor do post (1 é o ID do usuário admin por padrão)
    'post_type' => 'post',
    'post_category' => array($post_category) // Adicione esta linha para inserir a categoria no novo post
  );

  // Insira o novo post
  $post_id = wp_insert_post($new_post);

  if ($post_id) {
    echo 'Post criado com sucesso!';
  } else {
    echo 'Ocorreu um erro ao criar o post.';
  }
}
?>

<!-- Formulário HTML para criar o post -->
<form method="post" action="">
  <input type="text" name="post_title" placeholder="Título do post"><br>
  <textarea name="post_content" placeholder="Conteúdo do post"></textarea><br>
  <select name="post_category">
    <?php
    $categories = get_categories();
    foreach ($categories as $category) {
      echo '<option value="' . $category->term_id . '">' . $category->name . '</option>';
    }
    ?>
    <option value="nova_categoria">Criar Nova Categoria</option> <!-- Nova opção para criar nova categoria -->
  </select><br>
  <div id="novaCategoriaContainer" style="display: none;"> <!-- Campo para criar nova categoria, inicialmente oculto -->
    <input type="text" name="novaCategoria" placeholder="Nome da Nova Categoria">
  </div>
  <input type="submit" name="submit" value="Criar Post">
  <?php wp_nonce_field('cadastro_noticia', 'cadastro_noticia_nonce'); ?>
</form>