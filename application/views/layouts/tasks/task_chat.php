<!DOCTYPE html>
<html>
<head>
    <title>Discussion - <?= htmlspecialchars($task->title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .chat-card { border: 1px solid #e5e7eb; border-radius: 10px; padding: 15px; margin-bottom: 10px; background: white; }
        .chat-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
        .chat-header { font-weight: bold; font-size: 0.95rem; }
        .chat-date { font-size: 0.8rem; color: #9ca3af; }
        .chat-message { font-size: 0.9rem; color: #374151; margin-top: 4px; }
    </style>
</head>
<body class="bg-light">

<div class="container py-4">
    <h4 class="mb-4">💬 Discussion pour la tâche : <?= htmlspecialchars($task->title) ?></h4>

    <?php foreach ($messages as $msg): ?>
        <div class="chat-card d-flex">
            <img src="<?= base_url('assets/images/' . $msg->photo_users) ?>" class="chat-avatar me-3">
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="chat-header"><?= htmlspecialchars($msg->username) ?></span>
                    <span class="chat-date"><?= date('M d, Y', strtotime($msg->created_at)) ?></span>
                </div>
                <div class="chat-message"><?= nl2br(htmlspecialchars($msg->message)) ?></div>
            </div>
        </div>
    <?php endforeach; ?>

    <form method="post" action="<?= site_url('tasks/send_message/' . $task->idtask) ?>" class="mt-4 d-flex">
        <input type="text" name="message" class="form-control me-2" placeholder="Écrivez un message..." required>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>

</body>
</html>
