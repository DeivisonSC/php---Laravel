## README: PHP + Laravel + Eloquent

# API de Usuários - Laravel & Eloquent (DB Transactions)

Desenvolvimento de API robusta utilizando o framework **Laravel**, demonstrando o uso de **Migrations** e o gerenciador de transações do **Eloquent ORM**.

## Tecnologias
* PHP 8.x
* Laravel (Framework)
* Eloquent (ORM)
* MySQL (via Laragon)

## Integridade de Dados
A API utiliza o método `DB::transaction` para envolver a criação múltipla de registros. Caso a criação do usuário falhe, o perfil também não é salvo, evitando dados órfãos no banco de dados:

```php
$novoUsuario = DB::transaction(function () use ($request) {
    $perfil = Perfil::create(['perfil_nome' => $request->perfil['perfil_nome']]);
    
    return Usuario::create([
        ...,
        'id_perfil' => $perfil->id
    ]);
});
