<?php
// app/Controllers/ProdutoController.php

namespace App\Controllers;

use App\Models\Produto;

class ProdutoController {
    public function index() {
        // Pega todos os produtos do Model
        $produtos = Produto::getAll();
        
        // Inclui a View para exibir a página principal
        require_once __DIR__ . '/../Views/index.php';
    }
    
    // Métodos para as outras páginas
    public function grandes() {
        $produtos = Produto::getByCategoria('grande');
        require_once __DIR__ . '/../Views/index.php'; // Usa a mesma view, ou crie uma nova se preferir
    }
    
    public function pequenos() {
        $produtos = Produto::getByCategoria('pequeno');
        require_once __DIR__ . '/../Views/index.php'; // Usa a mesma view, ou crie uma nova se preferir
    }
}