document.addEventListener('DOMContentLoaded', function() {
    
    // Seleciona os elementos do formulário de upload
    const fileInput = document.getElementById('foto');
    const imagePreview = document.getElementById('image-preview');
    const previewPlaceholder = document.getElementById('preview-placeholder');

    // Esta verificação garante que o código só rode se os elementos existirem (só na página de cadastro)
    if (fileInput && imagePreview && previewPlaceholder) {
        
        fileInput.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                // Usa a API FileReader para ler o arquivo de imagem
                const reader = new FileReader();

                reader.addEventListener('load', function() {
                    // Mostra o elemento da imagem
                    imagePreview.style.display = 'block';
                    // Esconde o ícone de placeholder
                    previewPlaceholder.style.display = 'none';
                    // Define o 'src' da imagem para o resultado da leitura
                    imagePreview.setAttribute('src', this.result);
                });

                // Lê o arquivo como uma URL de dados, o que ativa o evento 'load' acima
                reader.readAsDataURL(file);
            }
        });
    }

});