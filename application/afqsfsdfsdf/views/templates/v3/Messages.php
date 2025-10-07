<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Instantanée</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    #chat-box {
        width: 100%;
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
        background-color: white;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        height: 400px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }

    .message {
        margin-bottom: 15px;
        display: flex;
        flex-direction: column;
        max-width: 75%;
        position: relative;
    }

    .message p {
        margin: 0;
        padding: 10px;
        background-color: #f1f1f1;
        border-radius: 5px;
    }

    .message-time {
        font-size: 0.85em;
        color: #777;
        margin-top: 5px;
        text-align: right;
    }

    .sent {
        align-self: flex-start; /* Aligner à gauche */
        text-align: left;
    }

    .sent p {
        background-color: #4CAF50;
        color: white;
    }

    .received {
        align-self: flex-end; /* Aligner à droite */
        text-align: right;
    }

    .received p {
        background-color: #e0e0e0;
    }

    textarea {
        width: 100%;
        height: 60px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        margin-top: 10px;
    }

    button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        margin-top: 10px;
    }

    button:hover {
        background-color: #45a049;
    }

    .delete-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        cursor: pointer;
        color: red;
    }

    .delete-btn:hover {
        color: darkred;
    }
</style>
</head>
<body>

<div id="chat-box">
    <!-- Messages seront affichés ici -->
    <?php foreach ($messages as $message): ?>
        <div class="message <?= $message->sender_id == $current_user->id ? 'sent' : 'received' ?>" id="message-<?= $message->id ?>">
            <strong><?= $message->sender_id == $current_user->id ? $current_user->first_name : "Utilisateur {$message->sender_id}" ?>:</strong>
            <p><?= htmlspecialchars($message->message) ?></p>
            <div class="message-time"><?= date('H:i', strtotime($message->timestamp)) ?></div>
            <span class="delete-btn" onclick="deleteMessage(<?= $message->id ?>)">🗑️</span>
        </div>
    <?php endforeach; ?>
</div>

<!-- Liste déroulante pour sélectionner un destinataire -->
<div class="user-list">
    <label for="recipient">Envoyer à :</label>
    <select id="recipient">
        <?php foreach ($users as $user): ?>
            <?php if ($user->id != $current_user->id): ?>
                <option value="<?= $user->id ?>"><?= htmlspecialchars($user->first_name) ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
</div>

<textarea id="message-text" placeholder="Écrire un message..."></textarea>
<button id="send-message" onclick="sendMessage()">Envoyer</button>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Fonction pour envoyer le message
function sendMessage() {
    var message = document.getElementById("message-text").value;
    var sender_id = <?= $current_user->id ?>;  // Utilisateur courant
    var receiver_id = document.getElementById("recipient").value; // ID du destinataire sélectionné

    // Vérification qu'un message a été écrit
    if (message.trim() === "") {
        alert("Veuillez écrire un message avant d'envoyer.");
        return;
    }

    // Envoi du message via AJAX
    $.post("<?= base_url('Googleads/send_message') ?>", {
        sender_id: sender_id,
        receiver_id: receiver_id,
        message: message
    }, function(response) {
        // Assurer que la réponse est bien au format JSON
        var responseData = JSON.parse(response);

        // Déterminer si le message est envoyé ou reçu
        var messageClass = responseData.sender_id == <?= $current_user->id ?> ? 'sent' : 'received';
        var senderName = responseData.sender_id == <?= $current_user->id ?> ? 'Moi' : 'Utilisateur ' + responseData.sender_id;

        // Ajouter le message dans le chat sans recharger la page
        var newMessage = `
            <div class="message ${messageClass}" id="message-${responseData.id}">
                <strong>${senderName}:</strong>
                <p>${message}</p>
                <div class="message-time">${responseData.timestamp}</div>
                <span class="delete-btn" onclick="deleteMessage(${responseData.id})">🗑️</span>
            </div>
        `;
        
        // Ajouter le message au chat
        $('#chat-box').append(newMessage);  
        
        // Réinitialiser le champ texte
        $('#message-text').val('');  
        
        // Forcer un recalcul de la disposition après l'ajout du message
        setTimeout(function() {
            scrollToBottom();  // Faire défiler jusqu'au dernier message après un petit délai
        }, 50);  // Petit délai pour s'assurer que la mise en page est appliquée avant de défiler
    }).fail(function() {
        alert("Erreur lors de l'envoi du message");
    });
}

// Fonction pour supprimer le message via AJAX
function deleteMessage(messageId) {
    // Confirmation avant suppression
    if (!confirm("Êtes-vous sûr de vouloir supprimer ce message ?")) {
        return;
    }

    // Envoi de la requête AJAX pour supprimer le message
    $.post("<?= base_url('Googleads/delete_message') ?>", { message_id: messageId }, function(response) {
        var responseData = JSON.parse(response);

        // Vérifie si la suppression a réussi
        if (responseData.status == 'success') {
            // Supprimer le message du DOM
            $('#message-' + messageId).remove();
        } else {
            alert("Erreur lors de la suppression du message");
        }
    }).fail(function() {
        alert("Erreur lors de la suppression du message");
    });
}

// Fonction pour faire défiler jusqu'au bas du chat
function scrollToBottom() {
    var chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
}
</script>

</body>
</html>
