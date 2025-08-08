<?php

session_start();

class Task
{
    private $tasks; //tarefas
    private $users; //usuarios
    private $taskCounter; //contador de tarefas

    public function __construct()
    {
        //dados iniciais
        $this->tasks = [
            1 => [
                'id' => 1,
                'title' => 'Estudar PHP',
                'description' => 'Revisar conceitos básicos',
                'userId' => 1,
                'status' => 'pendente',
                'date' => '2024-01-15'
            ],
            2 => [
                'id' => 2,
                'title' => 'Fazer compras',
                'description' => "Ir ao supermercado",
                'usarId' => 1,
                'status' => 'concluida',
                'date' => '2024-01-14'
            ],
            3 => [
                'id' => 3,
                'title' => 'Exercitar-se',
                'description' => 'Academia às 18h',
                'userId' => 2,
                'status' => 'pendente',
                'date' => '2024-01-16'
            ]
        ];
        $this->users = [
            1 => ['id' => 1, 'name' => 'João Silva', 'email' => 'joao@email.com', 'password' => 'senha123'],
            2 => ['id' => 2, 'name' => 'Maria Santos', 'email' => 'maria@email.com', 'password' => 'abc456']
        ];

        $this->taskCounter = 4;
    }

    //metodos

    //criar tarefa
    public function addTask($data)
    {
        $title = isset($data['title']) ? trim($data['title']) : '';
        $description = isset($data['description']) ? trim($data['description']) : '';
        $userId = isset($data['userId']) ? $data['userId'] : null;
        $date = isset($data['date']) ? trim($data['date']) : '';

        //validações
        if (empty($title)) return "Título obrigatório";
        if (strlen($title) < 3) return "Título muito curto";
        if (strlen($title) > 100) return "Título muito longo";
        if (is_numeric($title)) return "Título inválido";

        if (empty($description)) return "Descrição obrigatória";
        if (strlen($description) < 5) return "Descrição muito curta";
        if (strlen($description) > 500) return "Descrição muito longa";

        if (!is_numeric($userId) || $userId <= 0 || !isset($this->users[$userId])) {
            return "Usuário inválido";
        }

        if (empty($date)) return "Data obrigatória";
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) return "Data inválida";
        if (strtotime($date) < strtotime(date('Y-m-d'))) return "Data não pode ser no passado";

        $this->tasks[$this->taskCounter] = [
            'id' => $this->taskCounter,
            'title' => $title,
            'description' => $description,
            'userId' => $userId,
            'status' => 'pendente',
            'date' => $date
        ];

        $this->taskCounter++;
        return "success";
    }

    //atualizar tarefa
    public function updateTask($id, $data)
    {
        if (!is_numeric($id) || $id <= 0 || !isset($this->tasks[$id])) {
            return "Tarefa nao encontrada";
        }

        $title = isset($data['title']) ? trim($data['title']) : '';
        $description = isset($data['description']) ? trim($data['description']) : '';
        $date = isset($data['date']) ? trim($data['date']) : '';

        //validações
        if (empty($title)) return "Title obrigatorio";
        if (strlen($title) < 3) return "Title muito curto";
        if (strlen($title) > 100) return "Title muito longo";
        if (is_numeric($title)) return "Title invalido";

        if (empty($description)) return "Description obrigatoria";
        if (strlen($description) < 5) return "Description muito curta";
        if (strlen($description) > 500) return "Description muito longa";

        if (empty($date)) return "Data obrigatoria";
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) return "Data invalida";
        if (strtotime($date) < strtotime(date('Y-m-d'))) return "Data nao pode ser no passado";

        $this->tasks[$id]['title'] = $title;
        $this->tasks[$id]['description'] = $description;
        $this->tasks[$id]['date'] = $date;

        return "success";
    }

    //concluir tarefa
    public function completeTask($id)
    {
        if (!is_numeric($id) || $id <= 0 || !isset($this->tasks[$id])) {
            return "Tarefa não encontrada";
        }

        if ($this->tasks[$id]['status'] === 'concluida') return "Tarefa já concluída";

        $this->tasks[$id]['status'] = 'concluida';
        return "success";
    }

    //excluir tarefa
    public function deleteTask($id)
    {
        if (!is_numeric($id) || $id <= 0 || !isset($this->tasks[$id])) {
            return "Tarefa não encontrada";
        }

        if ($this->tasks[$id]['status'] === 'concluida') return "Tarefa já concluída";

        unset($this->tasks[$id]);
        return "success";
    }

    //listar tarefas
    public function listTasks($userId = null, $status = null, $search = null)
    {
        $result = $this->tasks;

        if ($userId !== null) {
            if (!is_numeric($userId) || $userId <= 0 || !isset($this->users[$userId])) {
                return [];
            }
            $result = array_filter($result, fn($task) => $task['userId'] == $userId);
        }

        if ($status !== null) {
            if (!in_array($status, ['pendente', 'concluida'])) return [];
            $result = array_filter($result, fn($task) => $task['status'] === $status);
        }

        if ($search !== null) {
            $search = trim($search);
            if (strlen($search) < 2 || strlen($search) > 50) return [];
            $result = array_filter(
                $result,
                fn($task) =>
                stripos($task['title'], $search) !== false || stripos($task['description'], $search) !== false
            );
        }

        return array_values($result);
    }

    //criar usuario
    public function addUser($data)
    {
        $name = isset($data['name']) ? trim($data['name']) : '';
        $email = isset($data['email']) ? trim($data['email']) : '';
        $password = isset($data['password']) ? trim($data['password']) : '';

        if (empty($name)) return "Nome obrigatório";
        if (strlen($name) < 2) return "Nome muito curto";
        if (strlen($name) > 100) return "Nome muito longo";
        if (is_numeric($name)) return "Nome inválido";
        if (strpos($name, ' ') === false) return "Nome deve conter sobrenome";

        if (empty($email)) return "Email obrigatório";
        if (strlen($email) < 5 || strlen($email) > 200) return "Email inválido";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return "Email inválido";

        if (empty($password)) return "Senha obrigatória";
        if (strlen($password) < 6 || strlen($password) > 50) return "Senha inválida";
        if (!preg_match('/[0-9]/', $password)) return "Senha deve conter número";
        if (!preg_match('/[a-zA-Z]/', $password)) return "Senha deve conter letra";

        foreach ($this->users as $user) {
            if ($user['email'] === $email) return "Email já cadastrado";
        }

        $newId = (count($this->users) > 0) ? max(array_keys($this->users)) + 1 : 1;
        $this->users[$newId] = [
            'id' => $newId,
            'name' => $name,
            'email' => $email,
            'password' => $password
        ];

        return "success";
    }


    //login
    public function login($email, $password)
    {
        $email = trim($email);
        $password = trim($password);

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
        if (empty($password)) return false;
        if (strlen($password) < 6 || strlen($password) > 50) return false;
        if (!preg_match('/[0-9]/', $password) || !preg_match('/[a-zA-Z]/', $password)) return false;

        foreach ($this->users as $user) {
            if ($user['email'] === $email && $user['password'] === $password) {
                $_SESSION['uid'] = $user['id'];
                $_SESSION['un'] = $user['name'];
                return $user;
            }
        }

        return false;
    }

    //get tarefa

    public function getTask($id)
    {
        if (!is_numeric($id) || $id <= 0 || !isset($this->tasks[$id])) {
            return null;
        }

        return $this->tasks[$id];
    }

    //get usuario

    public function getUser($id)
    {
        if (!is_numeric($id) || $id <= 0 || !isset($this->users[$id])) {
            return null;
        }
    }

    //relatorio
    public function getReport()
    {
        $total = count($this->tasks);
        $pendentes = 0;
        $concluidas = 0;
        $usuarios = count($this->users);

        return [
            'total_tarefas' => $total,
            'pendentes' => $pendentes,
            'concluidas' => $concluidas,
            'usuarios' => $usuarios
        ];
    }
}


$system = new Task();

echo "<h1>Sistema Refatorado</h1>";

// Criar usuário de exemplo
$resultUser = $system->addUser([
    'name' => 'Pedro Oliveira',
    'email' => 'pedro@teste.com',
    'password' => 'senha789'
]);

if ($resultUser === 'success') {
    echo "<p>Usuário criado!</p>";
} else {
    echo "<p>Erro: $resultUser</p>";
}

// Login de exemplo
$user = $system->login('joao@email.com', 'senha123');
if ($user) {
    echo "<p>Login: " . htmlspecialchars($user['name']) . "</p>";
}

// Criar tarefa de exemplo
$resultTask = $system->addTask([
    'title' => 'Aprender programação',
    'description' => 'Estudar conceitos de POO e boas práticas',
    'userId' => 1,
    'date' => '2024-02-01'
]);

if ($resultTask === 'success') {
    echo "<p>Tarefa criada!</p>";
}

// Listar tarefas
$tarefas = $system->listTasks();

echo "<h2>Tarefas:</h2>";
foreach ($tarefas as $tarefa) {
    $status = $tarefa['status'] === 'pendente' ? 'aguardando' : 'concluída';
    echo "<p>" . htmlspecialchars($status) . " " . htmlspecialchars($tarefa['title']) . " - " . htmlspecialchars($tarefa['description']) . " (Data: " . htmlspecialchars($tarefa['date']) . ")</p>";
}

// Concluir tarefa 1
$system->completeTask(1);
echo "<p>Tarefa 1 concluída!</p>";

// Relatório
$rel = $system->getReport();
echo "<h2>Relatório:</h2>";
echo "<p>Total: " . $rel['total_tarefas'] . " | Pendentes: " . $rel['pendentes'] . " | Concluídas: " . $rel['concluidas'] . "</p>";
