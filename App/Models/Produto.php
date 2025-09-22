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
        $this->imagem = $imagem; 
        $this->categoria = $categoria;
    }

    /**
     * Retorna a URL correta da imagem
     */
    public function getImagemUrl()
    {
        return "/projeto-teste/public/imagens/" . $this->imagem;
    }

    public static function getAll()
    {
        $salgadosGrandes = [
            [
                'nome' => 'Coxinha de Carne',
                'descricao' => 'Coxinha de massa de mandioca, com recheio de carne moída e tempero caseiro, com 190g',
                'preco' => 7.00,
                'imagem' => 'coxinha-carne.png',
            ],
            [
                'nome' => 'Coxinha de Frango',
                'descricao' => 'Coxinha de massa de mandioca, com recheio de frango com catupiry, com 190g',
                'preco' => 7.00,
                'imagem' => 'coxinha-de-frango.png',
            ],
            [
                'nome' => 'Kibi com queijo',
                'descricao' => 'Kibi feito com farinha de kibe e recheio de queijo, com 190g',
                'preco' => 7.00,
                'imagem' => 'kibi.png',
            ],
            [
                'nome' => 'Risoles de Carne',
                'descricao' => 'Risoles de massa caseira, com recheio de carne e tempero caseiro, com 190g',
                'preco' => 7.00,
                'imagem' => 'risoles-carne.png',
            ],
            [
                'nome' => 'Risoles de Frango',
                'descricao' => 'Risoles de massa caseira, com recheio de frango com catupiry, com 190g',
                'preco' => 7.00,
                'imagem' => 'risoles-frango.png',
            ],
            [
                'nome' => 'Risoles de Presunto',
                'descricao' => 'Risoles de massa caseira, com recheio de presunto e queijo, com 190g',
                'preco' => 7.00,
                'imagem' => 'risoles-de-presunto.png',
            ],
            [
                'nome' => 'Espetinho de Porco',
                'descricao' => 'Espetinho empanado com carne de porco, pimentão e cebola, com 190g',
                'preco' => 8.00,
                'imagem' => 'espetinho.png',
            ],
            [
                'nome' => 'Espetinho de Boi',
                'descricao' => 'Espetinho empanado com carne de boi, pimentão e cebola, com 190g',
                'preco' => 8.00,
                'imagem' => 'espetinho.png',
            ],
            [
                'nome' => 'Pastel de Presunto',
                'descricao' => 'Pastel de massa caseira, recheio de presunto e queijo, com 190g',
                'preco' => 8.00,
                'imagem' => 'pastel-presunto.png',
            ],
            [
                'nome' => 'Pastel de Carne',
                'descricao' => 'Pastel de massa caseira, recheio de carne moída e tempero caseiro, com 190g',
                'preco' => 8.00,
                'imagem' => 'pastel-carne.png',
            ],
        ];

        $salgadosPequenos = [
            [
                'nome' => 'Mini Bolinha de Queijo',
                'descricao' => 'Mini bolinha de massa comum recheada com queijo, 25g',
                'preco' => 0.90,
                'imagem' => 'mini-bolinha-queijo.png',
            ],
            [
                'nome' => 'Mini Coxinha de Carne',
                'descricao' => 'Mini coxinha de massa caseira recheada com carne moída, 25g',
                'preco' => 0.90,
                'imagem' => 'mini-coxinha-carne.png',
            ],
            [
                'nome' => 'Mini Coxinha de Frango',
                'descricao' => 'Mini coxinha de massa caseira recheada com frango e catupiry, 25g',
                'preco' => 0.90,
                'imagem' => 'mini-coxinha-frango.png',
            ],
            [
                'nome' => 'Mini Traveseirinho de Carne',
                'descricao' => 'Mini traveseirinho de massa caseira recheada com carne moída, 25g',
                'preco' => 0.90,
                'imagem' => 'mini-traveseirinho-carne.png',
            ],
            [
                'nome' => 'Mini Traveseirinho de Presunto',
                'descricao' => 'Mini traveseirinho de massa caseira recheada com presunto e queijo, 25g',
                'preco' => 0.90,
                'imagem' => 'mini-traveseirinho-presunto.png',
            ],
            [
                'nome' => 'Kibi com Queijo',
                'descricao' => 'Mini kibe feito com farinha de kibe, recheado com queijo, 25g',
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
        return array_filter(self::getAll(), function ($produto) use ($categoria) {
            return $produto->categoria === $categoria;
        });
    }
}
