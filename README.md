## Dependências

- MySQL Server 5.7
- PHP 7.0

## Build

Primeiro, clone o repositório. Abra a pasta baixada e navegue até `docs/` e importe o arquivo `db.sql` para a o seu MySQL Server (nota: o projeto está configurado com as credenciais padrão(root/root) para fins de desenvolvimento). Após isso, navegue para `src/` e execute o servidor embutido do PHP:

```bash
php -S localhost:<port>
```

Após isso, abra `localhost:<port>` no seu navegador.

## Demo

Ao invés de seguir os passos acima, uma versão funcional do projeto pode ser facilmente acessada [aqui](https://kevinws.com.br/p3/iface).

## Funcionalidades
O sistema permite a um usuário:
- Criar conta
    - Editar todos os atributos do seu perfil
    - Remover sua conta
- Adicionar amigos
    - Gerenciar amizades (aceitar/recusar)
- Criar comunidades 
    - Gerenciar os membros das comunidades que administra
- Recuperar informações sobre os demais usuários e as comunidades cadastradas
- Enviar mensagens para outros usuários e comunidades    

## Classes
O sistema foi desenvolvido utilizando a seguinte estrutura de classes:

#### Autoload
Ao desenvolver, detectou-se que muitos trechos de códigos eram comuns a todas as páginas (como os _includes_ às classes desenvolvidas, por exemplo). Para contornar isso, foi criada a classe `Autoload` para efetuar o carregamento dos arquivos referentes aos métodos e classes que estão sendo invocados em cada uma das páginas:

```php
class Autoload {
    public function __construct() {
        spl_autoload_extensions('.php');
        spl_autoload_register(array($this, 'load'));
    }

    private function load($className) {
        $extension = spl_autoload_extensions();
        require_once (__DIR__ . '/' . $className . $extension);
    }
}
```
Além disso, a classe em questão inicializa os objetos responsáveis por prover métodos utilitários e efetuar a conexão com o banco de dados:

```php
$autoload = new Autoload();
$utils = new Utils();
$conn = new Database();

$db = $conn->getInstance();
```

#### Database
A classe `Database` foi implementada unicamente com a finalidade de efetuar a conexão com o banco de dados e disponibilizar uma instância dessa conexão para as classes que venham a solicitar.

#### Group
A classe `Group` tem por objetivo reunir os métodos responsáveis por controlar a interação com as comunidades da plataforma. Nela existem os atributos específicos de uma comunidade (como nome, descrição e ID do administrador) e métodos responsáveis por efetuar o gerenciamento da comunidade (como CRUD e afins). Um exemplo é o método de cadastro de grupos, que faz a inserção do grupo no banco de dados:

```php
public function register() {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            try {
                $sql='INSERT INTO `groups` (`name`,`description`,`idadmin`) VALUES (:name,:description,:idadmin);';

                $db=$this->db->prepare($sql);
                $db->bindValue(':name', $_POST['name'],PDO::PARAM_STR);
                $db->bindValue(':description', $_POST['description'],PDO::PARAM_STR);
                $db->bindValue(':idadmin', $_SESSION['user']['ID'],PDO::PARAM_STR);

                $db->execute();

                $lastID = $this->db->lastInsertId();
                $this->addMember($_SESSION['user']['ID'], $lastID);

                header('Location: groups.php?id=' . $lastID);
            } catch(PDOException $e) {
                echo 'Ops, aconteceu o seguinte erro: ' . $e->getMessage();
            }
        }
    }
```

E o método para adicionar um usuário a um grupo, que recebe o ID de um usuário e o ID de um grupo e concretiza a relação entre eles:

```php
public function addMember($memberID, $groupID) {
      try {
        $sql='INSERT INTO `groups_and_users` (`idgroup`,`iduser`) VALUES (:idgroup,:iduser);';

        $db=$this->db->prepare($sql);
        $db->bindValue(':idgroup', $groupID, PDO::PARAM_STR);
        $db->bindValue(':iduser', $memberID, PDO::PARAM_STR);

        $db->execute();
      }catch(PDOException $e) {
        echo 'Ops, aconteceu o seguinte erro: ' . $e->getMessage();
      }
    }
```

Um outro método implementado é o `checkMembership($username, $members)`, que recebe a lista de membros de um grupo e o ID de um usuário específico e retorna se ele pertence ou não aou grupo:

```php
public function checkMembership($username, $members) {
        foreach ($members as $member) {
            if($username === $member['username']) {
                return 1;
            }
        }
        return 0;
    }
```

#### Message, GroupMessage, UserMessage
Para gerenciar o envio das mensagens, optou-se por criar estas três classes. As classes `GroupMessage` e `UserMessage` herdam de `Message` e implementam a interface `iMessage`. Mais detalhes sobre estas classes podem ser vistos nas seções **Herança, Classe Abstrata** e **Interface**.

#### User
A classe `User` abrange todos os atributos de um usuário (nome, username, e-mail, etc), os métodos que gerenciam estas informações, o login/logout e as amizades dos usuários. A vantagem desta classe é que boa parte dos métodos implementados nela faz uso de atributos da própria classe.

Um exemolo de método implementado é o `updateData()`, que é invocado na página de alterar informações - onde o usuário pode modificar os atributos de seu perfil:

```php
public function updateData() {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            try {
                $sql='UPDATE `users` SET `name` = :name, `username` = :user, `email` = :email WHERE `users`.`username` = :user;';

                $db=$this->db->prepare($sql);

                $db->bindValue(':name', $_POST['name'],PDO::PARAM_STR);
                $db->bindValue(':username', $_POST['username'],PDO::PARAM_STR);
                $db->bindValue(':email', $_POST['email'],PDO::PARAM_STR);
                $db->bindValue(':user', $_POST['username'],PDO::PARAM_STR);

                $db->execute();
                header('Location: settings.php');
            } catch(PDOException $e) {
                echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
            }
        }
    }
```

Sua desvantagem reside justamente em seu tamanho: a classe possui dezessete métodos implementados (além dos `getters`), métodos estes que poderiam ser deslocados para outras novas classes: como a classe `Friendships` para os métodos relativos às amizades e a classe `System` que poderia concentrar os métodos de login/logout/checagem de sessão.

Um outro exemplo de método implementado é o de login, onde é feita a checagem dos dados passados e a criação de uma sessão que manterá o usuário conectado caso as suas credencias existam e estejam corretas:

```php
public function login() {
        session_start();

        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $user=$this->getUser($_POST['username']);

            if (crypt($_POST['password'], $user['password']) === $user['password']) {
                $_SESSION["user"] = $user;
            }

        } elseif ((!empty($_COOKIE['user'])) and (!empty($_COOKIE['password']))) {
            $cookie['user'] = base64_decode(substr($_COOKIE['if_usr'],22,strlen($_COOKIE['user'])));
            $cookie['password'] = base64_decode(substr($_COOKIE['if_pwd'],22,strlen($_COOKIE['password'])));

            $user=$this->getUser($cookie['user']);

            if ($cookie['password']==$user['password']) {
                $_SESSION["user"] = $user;
            }

        }

        if (!empty($_SESSION["user"])) {
            if (empty($_SESSION["url"])) {
                header('Location: index.php');
            } else {
                header('Location: '.$_SESSION["url"]);
            }
        }
    }
```

Outro exemplo é o método a seguir, que busca a lista de usuários que enviaram solicitações de amizade ao usuário que está logado:

```php
public function getRequestedFriends() {
        try {
            $sql='SELECT `ID`, `name`, `username` FROM `users` INNER JOIN `friendships` ON `friendships`.`idsender` = `users`.`ID` WHERE `friendships`.`idreceiver` = :user AND `friendships`.`status` = "REQUESTED";';

            $db=$this->db->prepare($sql);
            $db->bindValue(':user', $this->ID,PDO::PARAM_STR);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
        }
    }
```

#### Utils
A classe `Utils` dispõe de alguns métodos utilitários que são utilizados ao longo da plataforma. Três exemplos são dados abaixo: um método que verifica se um usuário está logado (caso contrário, o redireciona para a página de login); um método gerador de salt (utilizado para gerar o hash da senha) e um método responsável por gerar o hash das senhas:

```php
public function protectPage()
    {
        session_start();
        if (empty($_SESSION["user"])) {
            $_SESSION["url"]=$_SERVER['REQUEST_URI'];
            header('Location: login.php');
        }
    }

    public function salt()
    {
        $string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ0123456789';
        $salt = '';
        for ($i = 1; $i <= 22; $i++) {
            $rand = mt_rand(1, strlen($string));
            $salt .= $string[$rand-1];
        }
        return $salt;
    }

    public function hash($password)
    {
        return crypt($password, '$2a$10$' . $this->salt() . '$');
    }
``` 

## Distribuição dos Métodos
Buscou-se reunir os métodos relativos a um determinado objeto em suas respectivas classes. A maior motivação para isso se deve ao fato de que muitos métodos fazem uso de atributos que estão presentes dentro de suas respectivas classes - assim, não faria sentido manter esses métodos longe de tais atrivutos. 

À exceção dos métodos que gerenciam o login/logout e as amizades dos usuários - que estão localizados na classe `User` -, todos os demais estão implementados nas classes em que possuem relação com os atributos: métodos que gerenciam o usuário estão na `User`, métodos que gerenciam as comunidades estão em `Group`, e assim sucessivamente... 

## Herança
O conceito de herança foi implementado na classe `Message`. Nela, há apenas um atributo que tem o papel de fornecer a conexão com o banco de dados - para os métodos das classes que herdam de `Message` - e um construtor responsável por receber a instância da conexão do banco de dados. Dessa forma, evitou-se replicar este atributo nas subclasses.

As classes que herdam de `Message` são `UserMessage` e `GroupMessage`. Nelas, são implementados os métodos responsáveis pelo envio e pelo retorno das mensagens para usuários e para comunidades, respectivamente, utilizando a instância do banco que já existe em `Message`.

## Classe Abstrata
Existe uma classe abstrata no projeto denominada `Message`. Esta classe foi implementada como abstrata pois serve apenas como "esqueleto" para as demais classes de mensagens. Pois todos os objetos referentes às mensagens implementados devem ser de um tipo específico (neste projeto existem dois tipos, conforme explicitado na seção **Herança** logo acima).

Dessa forma, pode ser implementada uma nova categoria de mensagens - como uma mensagem de broadcast, por exemplo. Basta que essa nova classe herde de `Message` para que ela possa ter acesso a uma instância do banco já existente na superclasse.

## Interface

Foi implementada uma única interface no projeto em questão. Ela é denominada `iMessage` e possui os seguintes métodos: 
- `sendMessage($receiver)`
- `getMessages($id)`

A razão para esta interface se deve ao fato de existirem categorias distintas de mensagens (de usuário para usuário e de usuário para grupo) que possuem implementações específicas para estes métodos - porém requer-se que todas essas classes mantenham um padrão. Utilizando a interface em questão, tem-se a garantia de que estes métodos sempre estarão disponíveis para quaisquer novos tipos de mensagens que possam vir a ser implementados.

## Polimorfismo
Apesar de existirem métodos homônimos ao longo do projeto (como os métodos `register()` das classes `User` e `Group`; e `sendMessage()` presente nas classes `UserMessage` e `GroupMessage`) - não houve implementação concreta de polimorfismo no projeto.

Uma possibilidade poderia ser a implementação de uma classe `Interaction`, que abrangeria métodos que poderiam ser reescritos nas classes `Message` e em uma nova classe chamada `Friendships` - mas não foi o caso deste projeto.

## Tratamento de Exceções
Todas as interações relacionadas às operações de CRUD com o banco de dados e com as requisições HTTP tiveram suas exceções tratadas. A seguir, um exemplo de tratamento de erro para o método de registro para quando se tenta registrar um nome de usuário/e-mail já cadastrado na plataforma, localizado na classe `User`:

```php
public function register()
    {
        try {
            ...
        }catch(PDOException $e) {
            switch ($e->getCode()) {
                case "23000":
                    echo "<div class=\"alert alert-danger\" role=\"alert\">Ops! Já existe um usuário cadastrado com esse e-mail/nome de usuário. Tente novamente! </div>";
                    break;
                default:
                    echo "<div class=\"alert alert-danger\" role=\"alert\">Ops! Um erro aconteceu. </div>";
                    break;
            }
        }
    }
```

As validações referentes às entradas de dados (formulários e afins) foram tratadas no front, utilizando HTML e JS. Portanto não foram tratadas exceções referentes a estes casos.

A justificativa para essa implementação é evitar mensagens de erro complexas e informações sensíveis (como as credenciais do banco e as queries executadas) fossem exibidas ao usuário. Não foram detectadas desvantagens em tratar-se as exceções no projeto, porém podem existir exceções que não foram detectadas e que, obviamente, não foram tratadas.

## Extensibilidade
Apesar de ser extensível em determinadas partes (como nos objetos de mensagens), no projeto foi feito no máximo o uso de herança entre duas classes.

## Reuso

Além do reuso (como a classe `Autoload` que é carregada em todo o sistema) de classes, houve o reuso de métodos. Alguns exemplos são o método de `hash()` presente na classe `Utils` e é utilizado nos métodos `updatePassword()` e `register()` da classe `User` e o método `getInstance()` da classe `Database`, que é invocado em todas as páginas do sistema.

## Licença
Este projeto está licenciado sob a licença MIT.