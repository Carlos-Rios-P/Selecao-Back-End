# Desenvolvimento do projeto

Primeiramente, foi criado as tabelas do banco de dados com as seguintes relações:

- N - 1 Users/Roles
- 1 - N Users/Comments
- 1 - N Comments/Revisions

Também foi criado um seeder para um usuário admin inicial e um outro seeder para 2 funções: admin e customer.
Após, foi feita a instação do JWT e é necessário o seguinte comando para o funcionamento da aplicação:

- php artisan jwt:secret

## Explicação dos endpoints

- POST api/auth -> utilizado para autenticar um usuário com login e senha. É retornado um token jwt.
- DELETE api/logout -> utilizado para deslogar um usuário.

- POST api/user/register -> utilizado para criação de novos usuários. Só é permitido criar um usuário admin quando na requisição possuir um usuário ADMIN logado.
Quando não possuir um usuário admin logado apenas é possível criar usuário CUSTOMER.
Essa rota não precisa de auntenticação para criação de usuário CUSTOMER.

- GET api/user/me -> retorna o usuário logado
- PUT api/user/update/me -> atualiza dados do usuário logado
- PUT api/user/update/:id -> atualiza dados do usuário passado na requisição. Apenas usuários ADMIN tem acesso à essa rota.

- GET api/comments -> retorna todos comentários de forma paginada
- POST api/comments -> utilizado para criação de um novo comentário. Necessário um usuário logado
- PUT api/comments/:id -> atualiza um comentário. Necessário que o comentário tenha sido criado pelo usuário que está logado
- DELETE api/comments/:id -> deleta o comentário passado na requisição. O ADMIN consegue excluir qualquer comentário. O CUSTOMER apenas consegue excluir comentários criados por ele.
- DELETE /api/comments/delete/all -> apaga todos comentários. Apenas o ADMIN possui permissão.

## Explicação dos requisitos

- O sistema deverá gerenciar os usuários, permitindo-os se cadastrar e editar seu cadastro:
foi criado em endpoint POST api/user/register.

- O sistema poderá autenticar o usuário através do e-mail e senha do usuário e, nas outras requisições, utilizar apenas um token de identificação:
Foi utilizado autenticação JWT para utilização de token.

- O sistema deverá retornar comentários a todos que o acessarem, porém deverá permitir inserir comentários apenas a usuários autenticados:
Foi criado o middleware JwtMiddleware para gerenciar permissões.

- O sistema deverá retornar qual é o autor do comentário e dia e horário da postagem:
Foi criado relacionamentos para que seja capaz buscar o autor do comentário
1 - N Users/Comments

- O sistema deverá permitir o usuário editar os próprios comentários (exibindo a data de criação do comentário e data da última edição):
Foi criado o endpoint PUT api/comments/:id 

- O sistema deverá possuir histórico de edições do comentário:
Foi criado uma tabela de revisions e um observer para Comments. Assim, sempre que um comentário for atualizado gerará um novo registro em revisions.

- O sistema deverá permitir o usuário excluir os próprios comentários;
Foi criado o endpoint DELETE api/comments/:id

- O sistema deverá possuir um usuário administrador que pode excluir todos os comentários:
Foi criado uma tabela de roles onde possui o registro de ADMIN. Dessa maneira, qualquer usuário que possui role_id referente à ADMIN conseguirá excluir comentários.
Para exclusão de todos comentários foi criado o endpoint DELETE /api/comments/delete/all

- O sistema deverá criptografar a senha do usuário:
Foi usada a facade do laravel use Illuminate\Support\Facades\Hash; para criptografia de senha.

- Implementação de testes automatizados utilizando phpunit:
Foram implementados testes para todos endpoints, estão localizados em: api/app/tests/Feature
Também foi criado o arquivo .env.testing para configuração do banco de dados em memórios para realização dos testes.

