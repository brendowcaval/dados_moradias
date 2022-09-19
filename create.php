<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// chequa se o post nao esta vazio
if (!empty($_POST)) {
    
    
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
   
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $idade = isset($_POST['idade']) ? $_POST['idade'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $local = isset($_POST['local']) ? $_POST['local'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    
    $stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $name, $idade, $phone, $local, $created]);
    
    $msg = 'Criado com sucesso!';
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>Criar contato</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="name">Nome</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <input type="text" name="name" placeholder="John Doe" id="name">
        <label for="idade">Idade</label>
        <label for="phone">Telefone</label>
        <input type="text" name="idade" placeholder="20" id="idade">
        <input type="text" name="phone" placeholder="2025550143" id="phone">
        <label for="local">Local</label>
        <label for="created">Criado em</label>
        <input type="text" name="local" placeholder="Local" id="local">
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created">
        <input type="submit" value="Salvar">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>