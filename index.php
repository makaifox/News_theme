<?php get_header(); ?>

<div class="container mt-5" style="overflow-y: auto;">
  <div class="row">
    <div class="col-12">
      <!-- Loop para exibir os posts -->
      <?php
      $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
      $args = array(
        'post_type' => 'post',
        'posts_per_page' => 6,
        'paged' => $paged
      );
      $query = new WP_Query($args);
      ?>

      <?php if ($query->have_posts()) : ?>
        <div class="row">
          <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="col-md-4">
              <div class="card m-2"> <!-- Ajusta a altura do card -->
                <div class="card-body">
                  <h5 class="card-title text-center"><?php the_title(); ?></h5>
                  <ul class="card-categories text-center">
                    <?php
                    $categories = get_the_category();
                    foreach ($categories as $category) {
                      echo '<li>' . $category->name . '</li>';
                    }
                    ?>
                  </ul>
                  <p class="card-text" style="display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical; overflow: hidden;"><?php the_excerpt(); ?></p> <!-- Exibe apenas 4 linhas do texto -->
                </div>
                <div class="card-footer">
                  <button type="button" class="Main-button" data-toggle="modal" data-target="#postModal-<?php the_ID(); ?>">Leia mais</button> <!-- Botão "Leia mais" -->
                </div>
              </div>
            </div>

            <!-- Modal para exibir o conteúdo completo do post -->
            <div class="modal fade" id="postModal-<?php the_ID(); ?>" tabindex="-1" role="dialog" aria-labelledby="postModalLabel-<?php the_ID(); ?>" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="postModalLabel-<?php the_ID(); ?>"><?php the_title(); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <?php the_content(); ?> <!-- Exibe o conteúdo completo do post -->
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="Main-button" data-dismiss="modal">Fechar</button>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>

        <!-- Paginação -->
        <div class="pagination">
          <?php echo paginate_links(array(
            'base' => get_pagenum_link(1) . '%_%',
            'format' => '?paged=%#%',
            'current' => $paged,
            'total' => $query->max_num_pages
          )); ?>
        </div>

      <?php else : ?>
        <p>Nenhum post encontrado.</p>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>

    <div class="col-md-3 sidebar">
      <?php if (is_active_sidebar('sidebar')) {
        dynamic_sidebar('sidebar');
      } ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>