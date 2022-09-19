<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// verifica se o contato id existe
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $idade = isset($_POST['idade']) ? $_POST['idade'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $local = isset($_POST['local']) ? $_POST['local'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        // atualiza
        $stmt = $pdo->prepare('UPDATE contacts SET id = ?, name = ?, idade = ?, phone = ?, local = ?, created = ? WHERE id = ?');
        $stmt->execute([$id, $name, $idade, $phone, $local, $created, $_GET['id']]);
        $msg = 'Atualizado com sucesso!';
    }
    // pepa o contato da tabela contacts
    $stmt = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('contato nao existe com este id!');
    }
} else {
    exit('sem id especificado');

}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Atualizar contato #<?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <label for="name">Nome</label>
        <input type="text" name="id" placeholder="1" value="<?=$contact['id']?>" id="id">
        <input type="text" name="name" placeholder="John Doe" value="<?=$contact['name']?>" id="name">
        <label for="idade">Idade</label>
        <label for="phone">Telefone</label>
        <input type="text" name="idade" placeholder="20" value="<?=$contact['idade']?>" id="idade">
        <input type="text" name="phone" placeholder="2025550143" value="<?=$contact['phone']?>" id="phone">
        <label for="local">Local</label>
        <label for="created">Criado em</label>
        <input type="text" name="local" placeholder="Local" value="<?=$contact['local']?>" id="local">
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($contact['created']))?>" id="created">
        <input type="submit" value="Atualizar">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>