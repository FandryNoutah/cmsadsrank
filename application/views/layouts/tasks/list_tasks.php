<!DOCTYPE html>
<html>
<head>
    <title>Liste des tâches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <h4 class="mb-4">📋 Liste des tâches</h4>

    <table class="table table-bordered table-hover bg-white">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Titre</th>
                <th>Statut</th>
                <th>Date demande</th>
                <th>Discussion</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= htmlspecialchars($task->reference) ?></td>
                <td><?= htmlspecialchars($task->title) ?></td>
                <td><?= htmlspecialchars($task->status) ?></td>
                <td><?= htmlspecialchars($task->date_demande) ?></td>
                <td>
                    <a href="<?= site_url('tasks/view/' . $task->idtask) ?>" class="btn btn-sm btn-primary">
                        Ouvrir le chat
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
