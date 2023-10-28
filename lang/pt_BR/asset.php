<?php

return [
    'not_found' => 'Ativo não encontrado. Entre em contato pelo e-mail <b>' . config('mail.from.address') . '</b> e peça a inclusão dele no sistema.',
    'max_quantity' => 'O limite máximo de ativos é ' . config('asset.max_quantity') . '. Assine o plano Pro para ter ativos ilimitados.',
    'deleted' => 'Ativo deletado com sucesso!',
    'created' => 'Ativo adicionado com sucesso!',
    'updated' => 'Ativo alterado com sucesso!',
    'insufficient_quantity_to_sell' => 'Quantidade insuficiente para vender.',
    'asset_class_not_found' => 'Cadastre a classe de ativos antes de adicionar o ativo.'
];
