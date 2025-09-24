<h2>Créer une note</h2>
<form method="post" action="<?= site_url('notes/create'); ?>">
    <label>Titre</label>
    <input type="text" name="title" required>

    <label>Contenu</label>
    <textarea name="content" required></textarea>

    <label>Type</label>
    <select name="type" required>
        <option value="information">Information</option>
        <option value="tache">Tâche</option>
        <option value="rappel">Rappel</option>
    </select>

    <label>Statut</label>
    <select name="status" required>
        <option value="Normal">Normal</option>
        <option value="Priorité">Priorité</option>
        <option value="Urgent">Urgent</option>
    </select>

    <hr>

    <label>Attribuer la note :</label><br>
    <input type="radio" name="assign_mode" value="self" checked> Moi-même<br>
    <input type="radio" name="assign_mode" value="multiple"> Plusieurs personnes<br>

    <div id="multi-users" style="display:none; margin-top:10px;">
        <label>Choisir les destinataires :</label>
        <?php foreach ($users as $user): ?>
            <div>
                <input type="checkbox" name="assigned_to[]" value="<?= $user->id; ?>">
                <?= htmlspecialchars($user->username); ?>
            </div>
        <?php endforeach; ?>
    </div>

    <br>
    <button type="submit">Enregistrer</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modeSelf = document.querySelector('input[value="self"]');
    const modeMulti = document.querySelector('input[value="multiple"]');
    const multiUsersDiv = document.getElementById('multi-users');

    modeSelf.addEventListener('change', () => multiUsersDiv.style.display = 'none');
    modeMulti.addEventListener('change', () => multiUsersDiv.style.display = 'block');
});
</script>
