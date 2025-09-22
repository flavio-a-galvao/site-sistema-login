<?php
namespace App\Controllers;

use App\Models\Produto;

class ProdutoController
{
    public function index()
    {
        $produtos = Produto::getAll();
        require __DIR__ . '/../Views/index.php';
    }
}
