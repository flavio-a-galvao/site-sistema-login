<?php
// app/Models/Produto.php

namespace App\Models;

class Produto
{
    public $nome;
    public $descricao;
    public $preco;
    public $imagem;
    public $categoria;

    public function __construct($nome, $descricao, $preco, $imagem, $categoria)
    {
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->imagem = $imagem; // agora só guarda o nome do arquivo
        $this->categoria = $categoria;
    }

    /**
     * Retorna a URL da imagem automaticamente
     */
    public function getImagemUrl()
    {
        // Detecta o diretório base automaticamente
        $basePath = dirname($_SERVER['SCRIPT_NAME']); 
        return $basePath . "/public/imagens/" . $this->imagem;
    }

    public static function getAll()
    {
        $salgadosGrandes = [
            [
                'nome' => 'Coxinha de Carne',
                'descricao' => 'Coxinha de massa de mandioca, com recheio de carne moida e tempero caseiro, com o peso de 190g',
                'preco' => 7.00,
                'imagem' => 'coxinha-carne.png',
            ],
            [
                'nome' => 'Coxinha de Frango',
                'descricao' => 'Coxinha de massa de mandioca, com recheio de frango com catupiry, com o peso de 190g',
                'preco' => 7.00,
                'imagem' => 'coxinha-de-frango.png',
            ],
            [
                'nome' => 'Kibi com queijo',
                'descricao' => 'Kibi feito com farinha de kibi, com recheio de queijo, com o peso de 190g',
                'preco' => 7.00,
                'imagem' => 'kibi.png',
            ],
            [
                'nome' => 'Risoles de Carne',
                'descricao' => 'Risoles de massa caseira, com recheio de carne e tempero caseiro, com o peso de 190g',
                'preco' => 7.00,
                'imagem' => 'risoles-carne.png',
            ],
            [
                'nome' => 'Risoles de Frango',
                'descricao' => 'Risoles de massa caseira, com recheio de frango com catupiry, com o peso de 190g',
                'preco' => 7.00,
                'imagem' => 'risoles-frango.png',
            ],
            [
                'nome' => 'Risoles de Presunto',
                'descricao' => 'Risoles de massa caseira, com recheio de presunto e queijo, com o peso de 190g',
                'preco' => 7.00,
                'imagem' => 'risoles-de-presunto.png',
            ],
            [
                'nome' => 'Espetinho de Porco',
                'descricao' => 'Espetinho de massa empanada, com recheio de carne de porco, pimentão e cebola,com o peso de 190g',
                'preco' => 8.00,
                'imagem' => 'espetinho.png',
            ],
            [
                'nome' => 'Espetinho de Boi',
                'descricao' => 'Espetinho de massa empanada, com recheio de carne de boi, pimentão e cebola,com o peso de 190g',
                'preco' => 8.00,
                'imagem' => 'espetinho.png',
            ],
            [
                'nome' => 'Pastel de Presunto',
                'descricao' => 'Pastel de massa caseira, com recheio de presunto, queijo e qualquer adicional que pedir, com o peso de 190g',
                'preco' => 8.00,
                'imagem' => 'pastel-presunto.png',
            ],
            [
                'nome' => 'Pastel de Carne',
                'descricao' => 'Pastel de massa caseira, com recheio de carne moida, tempero caseiro e qualquer adicional que pedir, com o peso de 190g',
                'preco' => 8.00,
                'imagem' => 'pastel-carne.png',
            ],
        ];

        $salgadosPequenos = [
            [
                'nome' => 'Mini Bolinha de Queijo',
                'descricao' => 'Mini bolinha de queijo com massa comum, recheio de queijo, com o peso de 25g',
                'preco' => 0.90,
                'imagem' => 'mini-bolinha-queijo.png',
            ],
            [
                'nome' => 'Mini Coxinha de Carne',
                'descricao' => 'Mini coxinha de massa caseira, com recheio de carne moida, tempero caseiro, com o peso de 25g',
                'preco' => 0.90,
                'imagem' => 'mini-coxinha-carne.png',
            ],
            [
                'nome' => 'Mini Coxinha de Frango',
                'descricao' => 'Mini coxinha de massa caseira, com recheio de frango e catupiry, com o peso de 25g',
                'preco' => 0.90,
                'imagem' => 'mini-coxinha-frango.png',
            ],
            [
                'nome' => 'Mini Traveseirinho de Carne',
                'descricao' => 'Mini traveseirinho de massa caseira, com recheio de carne moida, tempero caseiro, com o peso de 25g',
                'preco' => 0.90,
                'imagem' => 'mini-traveseirinho-carne.png',
            ],
            [
                'nome' => 'Mini Traveseirinho de Presunto',
                'descricao' => 'Mini traveseirinho de massa caseira, com recheio de presunto e queijo, com o peso de 25g',
                'preco' => 0.90,
                'imagem' => 'mini-traveseirinho-presunto.png',
            ],
            [
                'nome' => 'Kibi com Queijo',
                'descricao' => 'Mini kibi feito com farinha de kibi, com recheio de queijo, com o peso de 25g',
                'preco' => 0.90,
                'imagem' => 'kibi.png',
            ],
        ];

        $produtos = [];
        foreach ($salgadosGrandes as $item) {
            $produtos[] = new self(
                $item['nome'],
                $item['descricao'],
                $item['preco'],
                $item['imagem'],
                'grande'
            );
        }
        foreach ($salgadosPequenos as $item) {
            $produtos[] = new self(
                $item['nome'],
                $item['descricao'],
                $item['preco'],
                $item['imagem'],
                'pequeno'
            );
        }
        return $produtos;
    }

    public static function getByCategoria($categoria)
    {
        $todosOsProdutos = self::getAll();
        $produtosFiltrados = [];
        foreach ($todosOsProdutos as $produto) {
            if ($produto->categoria === $categoria) {
                $produtosFiltrados[] = $produto;
            }
        }
        return $produtosFiltrados;
    }
}
