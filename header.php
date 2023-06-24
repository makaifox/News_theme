<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <title><?php bloginfo('name'); ?> &raquo; <?php is_front_page() ? bloginfo('description') : wp_title(''); ?></title>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
  <?php wp_head(); ?>
</head>

<body>
  <header class="site-header">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light d-flex justify-content-between">
        <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
          <img src="<?php echo get_stylesheet_directory_uri(); ?>/src/assets/logo.png" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="nav-link Main-button d-lg-none d-block" href="#" data-toggle="modal" data-target="#cadastroNoticiaModal">Cadastrar Notícia</a>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item d-lg-block d-none">
              <a class="nav-link Main-button" href="#" data-toggle="modal" data-target="#cadastroNoticiaModal">Cadastrar Notícia</a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search" id="searchInput">
          </form>
        </div>
      </nav>
    </div>
  </header>

  <!-- Modal para cadastrar notícia -->
  <div class="modal fade" id="cadastroNoticiaModal" tabindex="-1" role="dialog" aria-labelledby="cadastroNoticiaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form id="cadastroNoticiaForm" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
          <input type="hidden" name="action" value="cadastro_noticia">
          <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="categoria">Categoria</label>
            <select name="categoria" id="categoria" class="form-control" required>
              <?php
              $categories = get_categories();
              foreach ($categories as $category) {
                echo '<option value="' . $category->term_id . '">' . $category->name . '</option>';
              }
              ?>
              <option value="nova_categoria">Criar Nova Categoria</option> <!-- Nova opção para criar nova categoria -->
            </select>
          </div>
          <div id="novaCategoriaContainer" style="display: none;"> <!-- Campo para criar nova categoria, inicialmente oculto -->
            <div class="form-group">
              <label for="novaCategoria">Nova Categoria</label>
              <input type="text" name="novaCategoria" id="novaCategoria" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label for="conteudo">Conteúdo</label>
            <textarea name="conteudo" id="conteudo" class="form-control" required></textarea>
          </div>
          <button type="submit" class="Main-button">Cadastrar</button>
        </form>
      </div>
    </div>
  </div>

  <?php wp_footer(); ?> <!-- Adicione esta linha para carregar os scripts e estilos do WordPress -->
</body>

</html>
