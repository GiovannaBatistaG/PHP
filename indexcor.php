<?php


class t //classe de tarefas
{
    private $ts; //tarefas
    private $us; //usuario
    private $c;  //controle tarefa

    public function __construct() //inicia a função, estrutura basica de cada uma
    {

        //reformular estrutura do codigo, orimeiro ts -> tarefas
        $this->ts = [
            1 => [

                'id' => 1,
                't' => 'Estudar PHP',
                'd' => 'Revisar conceitos básicos',
                'u' => 1,
                's' => 'pendente',
                'dt' => '2024-01-15'
            ],

            2 => [

                'id' => 2,
                't' => 'Fazer compras',
                'd' => 'Ir ao supermercado',
                'u' => 1,
                's' => 'concluida',
                'dt' => '2024-01-14'
            ],

            3 => [
                'id' => 3,
                't' => 'Exercitar-se',
                'd' => 'Academia às 18h',
                'u' => 2,
                's' => 'pendente',
                'dt' => '2024-01-16'
            ]

        ];

        //reformular estrutura do codigo, us -> usuarios
        $this->us = [
            1 => ['id' => 1, 'n' => 'João Silva', 'e' => 'joao@email.com', 'p' => 'senha123'],
            2 => ['id' => 2, 'n' => 'Maria Santos', 'e' => 'maria@email.com', 'p' => 'abc456']
        ];

        $this->c = 4;
    }

    public function a($d) //primeiro metodo criado, tem validações para poder adicionar uma nova tarefa ao um usuario
    {
        $t = trim($d['t']); //trim remove espaços, cria uma variavel para t -> titulo
        $desc = trim($d['d']); //cria uma variavel para desc -> descricao
        $u = $d['u']; //cria uma variavel para u -> usuario
        $dt = trim($d['dt']); //cria uma variavel para dt -> data

        //validações

        if (strlen($t) < 3) return "Título muito curto"; //strlen, conta a quantidade de caracters, se menor que 3 muito curto
        if (strlen($t) > 100) return "Título muito longo"; //se maior que 100 muito longo
        if (empty($t)) return "Título obrigatório"; //empty, caso esteja vazio
        if (is_numeric($t)) return "Título inválido"; //is_numeric, caso seja numero


        if (strlen($desc) < 5) return "Descrição muito curta"; //strlen, conta a quantidade de caracters, se menor que 5 muito curto
        if (strlen($desc) > 500) return "Descrição muito longa"; //se maior que 500 muito longo
        if (empty($desc)) return "Descrição obrigatória"; //empty, caso esteja vazio


        if (!is_numeric($u)) return "Usuário inválido"; //is_numeric, caso seja numero
        if ($u <= 0) return "ID usuário inválido"; // <= 0, usuario menor ou igual a 0
        if (!isset($this->us[$u])) return "Usuário não existe"; //!isset, valida se o usuario ja existe dentro de "u"(usuario)

        if (empty($dt)) return "Data obrigatória"; // validações pra data, caso esteja em branco
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dt)) return "Data inválida"; //esse nao sei mas deve ser estrutra da data
        if (strtotime($dt) < strtotime(date('Y-m-d'))) return "Data não pode ser no passado"; //strtotime, valida se a data é menor que a do dia?

        //para acidionar a tarefa nova
        $this->ts[$this->c] = [
            'id' => $this->c,
            't' => $t,
            'd' => $desc,
            'u' => $u,
            's' => 'pendente',
            'dt' => $dt
        ];

        $this->c++;
        return "success";
    }

    public function u($id, $d) //metodo para atualizar e validar uma tarefa com titulo descricao e data

    //validadao de ID, por verificao no $id, menor ou igual a 0 e tarefa nao localixada em ids
    {
        if (!is_numeric($id)) return "ID inválido";
        if ($id <= 0) return "ID deve ser positivo";
        if (!isset($this->ts[$id])) return "Tarefa não encontrada";
        //simplificar em uma vlidação so

        $t = trim($d['t']); //receber tarefa
        $desc = trim($d['d']); //receber descricao
        $dt = trim($d['dt']); //receber data

        //validações

        if (strlen($t) < 3) return "Título muito curto";
        if (strlen($t) > 100) return "Título muito longo";
        if (empty($t)) return "Título obrigatório";
        if (is_numeric($t)) return "Título inválido";

        if (strlen($desc) < 5) return "Descrição muito curta";
        if (strlen($desc) > 500) return "Descrição muito longa";
        if (empty($desc)) return "Descrição obrigatória";

        if (empty($dt)) return "Data obrigatória";
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dt)) return "Data inválida";
        if (strtotime($dt) < strtotime(date('Y-m-d'))) return "Data não pode ser no passado";

        //atuação da tarefa
        $this->ts[$id]['t'] = $t;
        $this->ts[$id]['d'] = $desc;
        $this->ts[$id]['dt'] = $dt;

        return "success";
    }

    public function cs($id) //concluir tareda
    {
        if (!is_numeric($id)) return "ID inválido";
        if ($id <= 0) return "ID deve ser positivo";
        if (!isset($this->ts[$id])) return "Tarefa não encontrada";
        if ($this->ts[$id]['s'] === 'concluida') return "Tarefa já concluída";
        //validação

        $this->ts[$id]['s'] = 'concluida';
        return "success";
    }

    public function d($id) //exclui uma tarefa
    {
        if (!is_numeric($id)) return "ID inválido";
        if ($id <= 0) return "ID deve ser positivo";
        if (!isset($this->ts[$id])) return "Tarefa não encontrada";
        //validação

        //unset vai remover pelo numero do id passado
        unset($this->ts[$id]);
        return "success";
    }

    public function l($uid = null, $s = null, $search = null) //possivilidade de filtros atraves do uid, d search, utilizando array
    {
        $result = $this->ts;

        //validacao de uid, s e search, da pra deixar menor
        if ($uid !== null) {
            if (!is_numeric($uid)) return [];
            if ($uid <= 0) return [];
            if (!isset($this->us[$uid])) return [];

            $result = array_filter($result, function ($task) use ($uid) {
                return $task['u'] == $uid;
            }); //filtro, nao entedi como funciona
        }

        if ($s !== null) {
            if (!in_array($s, ['pendente', 'concluida'])) return [];

            $result = array_filter($result, function ($task) use ($s) {
                return $task['s'] === $s;
            });
        }

        if ($search !== null) {
            $search = trim($search);
            if (strlen($search) < 2) return [];
            if (strlen($search) > 50) return [];

            $result = array_filter($result, function ($task) use ($search) {
                return stripos($task['t'], $search) !== false ||
                    stripos($task['d'], $search) !== false;
            });
        }

        return array_values($result);
    }

    public function au($d) //metodo cadastro do usuario
    {

        $n = trim($d['n']); // n -> nome
        $e = trim($d['e']); // e -> email
        $p = trim($d['p']); // p -> senha


        //validações, n -> onome, e -> email, p -> senha
        if (strlen($n) < 2) return "Nome muito curto";
        if (strlen($n) > 100) return "Nome muito longo";
        if (empty($n)) return "Nome obrigatório";
        if (is_numeric($n)) return "Nome inválido";
        if (strpos($n, ' ') === false) return "Nome deve ter sobrenome";

        if (strlen($e) < 5) return "Email muito curto";
        if (strlen($e) > 200) return "Email muito longo";
        if (empty($e)) return "Email obrigatório";
        if (!filter_var($e, FILTER_VALIDATE_EMAIL)) return "Email inválido";
        if (strpos($e, '@') === false) return "Email deve conter @";

        if (strlen($p) < 6) return "Senha muito curta";
        if (strlen($p) > 50) return "Senha muito longa";
        if (empty($p)) return "Senha obrigatória";
        if (!preg_match('/[0-9]/', $p)) return "Senha deve ter número";
        if (!preg_match('/[a-zA-Z]/', $p)) return "Senha deve ter letra";

        foreach ($this->us as $user) {
            if ($user['e'] === $e) return "Email já existe";
        }

        $newId = max(array_keys($this->us)) + 1; //para adicionar o novo usuario em us(usuarios)
        $this->us[$newId] = [
            'id' => $newId, // id -> id do usuario
            'n' => $n, // n -> nome
            'e' => $e, // e -> email
            'p' => $p  // p -> senha
        ];

        return "success";
    }

    public function lg($e, $p) //metodo login com validações, e -> email, p -> senha

    {
        $e = trim($e); // e -> email
        $p = trim($p); // p -> senha

        //validações, do email e senha

        if (strlen($e) < 5) return false;
        if (strlen($e) > 200) return false;
        if (empty($e)) return false;
        if (!filter_var($e, FILTER_VALIDATE_EMAIL)) return false;
        if (strpos($e, '@') === false) return false;

        if (strlen($p) < 6) return false;
        if (strlen($p) > 50) return false;
        if (empty($p)) return false;
        if (!preg_match('/[0-9]/', $p)) return false;
        if (!preg_match('/[a-zA-Z]/', $p)) return false;

        foreach ($this->us as $user) {
            if ($user['e'] === $e && $user['p'] === $p) {
                $_SESSION['uid'] = $user['id'];
                $_SESSION['un'] = $user['n'];
                return $user;
            }
        }

        return false;
    }

    public function gt($id) //metodoo gt e gu, gt -> get tarefa, gu -> get usuario

    //validações, da para simplicar
    {
        if (!is_numeric($id)) return null;
        if ($id <= 0) return null;
        if (!isset($this->ts[$id])) return null;

        return $this->ts[$id]; // retorna a tarefa pelo id, buscando no array ts(tarefas)
    }

    public function gu($id)
    {
        if (!is_numeric($id)) return null;
        if ($id <= 0) return null;
        if (!isset($this->us[$id])) return null;

        return $this->us[$id]; // retorna o usuario pelo id, buscando no array us(usuarios)
    }

    public function r() // metodo relatorio

    {
        $total = count($this->ts); //total de tarefas, o count conta a quantidade de tarefas no array ts
        $pendentes = 0; // declarado como 0 para poder somar as tarefas pendentes
        $concluidas = 0; // declarado como 0 para poder somar as tarefas concluidas
        $usuarios = count($this->us); //total de usuarios, o count conta a quantidade de usuarios no array us


        foreach ($this->ts as $task) {
            if ($task['s'] === 'pendente') $pendentes++;
            if ($task['s'] === 'concluida') $concluidas++;
        }

        return [
            'total_tarefas' => $total,
            'pendentes' => $pendentes,
            'concluidas' => $concluidas,
            'usuarios' => $usuarios
        ];
    }
}

session_start();

$sistema = new t();

echo "<h1>Sistema</h1>";

$resultUser = $sistema->au([
    'n' => 'Pedro Oliveira',
    'e' => 'pedro@teste.com',
    'p' => 'senha789'
]);

if ($resultUser === 'success') {
    echo "<p>Usuário criado!</p>";
} else {
    echo "<p>Erro: $resultUser</p>";
}

$user = $sistema->lg('joao@email.com', 'senha123');
if ($user) {
    echo "<p>Login: " . $user['n'] . "</p>";
}

$resultTask = $sistema->a([
    't' => 'Aprender programação',
    'd' => 'Estudar conceitos de POO e boas práticas',
    'u' => 1,
    'dt' => '2024-02-01'
]);

if ($resultTask === 'success') {
    echo "<p>Tarefa criada!</p>";
}

$tarefas = $sistema->l();
echo "<h2>Tarefas:</h2>";
foreach ($tarefas as $tarefa) {
    $status = $tarefa['s'] === 'pendente' ? 'aguardando' : 'concluída';
    echo "<p>$status {$tarefa['t']} - {$tarefa['d']} (Data: {$tarefa['dt']})</p>";
}

$sistema->cs(1);
echo "<p>Tarefa 1 concluída!</p>";

$rel = $sistema->r();
echo "<h2>Relatório:</h2>";
echo "<p>Total: {$rel['total_tarefas']} | Pendentes: {$rel['pendentes']} | Concluídas: {$rel['concluidas']}</p>";
