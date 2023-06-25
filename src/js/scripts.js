jQuery(document).ready(function($) {
  // Inicializar o componente de busca dinâmica
  $('#searchInput').keyup(function() {
    var searchValue = $(this).val();
    // Implemente a lógica de busca dinâmica aqui, por exemplo, fazendo uma requisição AJAX para recuperar os posts correspondentes e atualizar a exibição
  });
});
document.addEventListener('DOMContentLoaded', function() {
  var categoriaSelect = document.getElementById('categoria');
  var novaCategoriaContainer = document.getElementById('novaCategoriaContainer');

  categoriaSelect.addEventListener('change', function() {
    if (categoriaSelect.value === 'nova_categoria') {
      novaCategoriaContainer.style.display = 'block';
    } else {
      novaCategoriaContainer.style.display = 'none';
    }
  });
});

jQuery(function($) {
  // Mostrar/ocultar campo de nova categoria ao selecionar "Criar Nova Categoria"
  $('#cadastroNoticiaModal select[name="categoria"]').on('change', function() {
    var selectedOption = $(this).val();
    if (selectedOption === 'nova_categoria') {
      $('#cadastroNoticiaModal #novaCategoriaContainer').show();
    } else {
      $('#cadastroNoticiaModal #novaCategoriaContainer').hide();
    }
  });

  // Mostrar/ocultar campo de nova categoria ao selecionar "Criar Nova Categoria" no modal de edição de notícia
  $('.edit-post-button').on('click', function() {
    var postId = $(this).data('target').replace('#editPostModal-', '');
    $('#editPostModal-' + postId + ' select[name="editCategoria"]').on('change', function() {
      var selectedOption = $(this).val();
      if (selectedOption === 'nova_categoria') {
        $('#editPostModal-' + postId + ' #novaCategoriaContainer').show();
      } else {
        $('#editPostModal-' + postId + ' #novaCategoriaContainer').hide();
      }
    });
  });

  // Confirmar exclusão de notícia
  $('.delete-post-button').on('click', function() {
    var postId = $(this).data('target').replace('#deletePostModal-', '');
    $('#deletePostModal-' + postId + ' form').on('submit', function(e) {
      e.preventDefault();
      if (confirm('Você tem certeza de que deseja excluir esta notícia?')) {
        $(this).off('submit').submit();
      }
    });
  });
});
