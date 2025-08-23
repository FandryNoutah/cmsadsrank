<h2>Mes notes</h2>
<ul>
<?php foreach ($notes as $note): ?>
    <li>
        <strong><?= htmlspecialchars($note->title); ?></strong>
        <br>Type : <?= htmlspecialchars($note->type); ?>
        <br>Statut : <?= htmlspecialchars($note->status); ?>
        <br>De : <?= htmlspecialchars($note->author); ?>
        <br>Pour :
        <?php 
            $recipients = $this->Note_model->get_note_recipients($note->id);
            echo implode(', ', array_map(function($r) {
                return htmlspecialchars($r->username);
            }, $recipients));
        ?>
        <p><?= nl2br(htmlspecialchars($note->content)); ?></p>
    </li>
<?php endforeach; ?>
</ul>

<a href="<?php echo base_url('Notes/create'); ?>">Create</a>
