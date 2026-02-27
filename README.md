## README: PHP + Laravel + Eloquent

# API de Usuários - Laravel & Eloquent (DB Transactions)

Desenvolvimento de API robusta utilizando o framework **Laravel**, demonstrando o uso de **Migrations** e o gerenciador de transações do **Eloquent ORM**.

## Tecnologias
* PHP  8.3.30
* Laravel  12v(Framework)
* Eloquent  12v(ORM)
* MySQL  (via Laragon)

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
```
Como Executar:

1. Instale as dependências: `composer install`

2. Depois configure o `.env` com os dados do MySQL (Lembre-se de ajustar o link do banco de dados de acordo com o banco de dados que utilizar.)

3. Gere a chave da aplicação: `php artisan key:generate`

4. Rode as migrações: `php artisan migrate`

5. Inicie o servidor: `php artisan serve`
   
Obs: Para o código em questão foi utilizado o Postman para testar as funcionalidades (GET, PUT, POST E DELETE).


