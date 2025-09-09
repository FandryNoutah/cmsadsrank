<?php start_section('stylesheet'); ?>
<link href="<?= base_url('assets/vendors/select2/css/select2.min.css'); ?>" rel="stylesheet" />
<style>
 * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    .sidebar2 {
      width: 220px;
      background: #fff;
      border-right: 1px solid #ddd;
      padding: 20px;
      float: left;
      min-height: 100%;
    }

    .sidebar2 h3 {
      margin-bottom: 15px;
      font-size: 14px;
      text-transform: uppercase;
      color: #555;
    }

    .sidebar2 ul {
      list-style: none;
      padding-left: 0;
    }

    .sidebar2 ul li {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
      font-size: 14px;
      color: #333;
      cursor: pointer;
      transition: background 0.2s;
    }

    .sidebar2 ul li:hover {
      background: #f0f0f5;
      border-radius: 6px;
      padding-left: 6px;
    }

    .label-section {
      margin-top: 30px;
    }

    /* Contenu principal */
    .main {
      margin-left: 240px; /* pour laisser la place au menu */
      padding: 20px;
    }

    .main-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .main-header h2 {
      font-size: 18px;
    }

    .message-list {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .message {
      background: #fff;
      padding: 15px;
      border: 1px solid #eee;
      border-radius: 10px;
      display: flex;
      flex-direction: column;
      transition: box-shadow 0.2s;
    }

    .message:hover {
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .message-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .sender {
      font-weight: bold;
      font-size: 14px;
    }

    .date {
      font-size: 12px;
      color: #777;
    }

    .subject {
      font-size: 15px;
      margin: 8px 0;
      font-weight: 600;
    }

    .preview {
      font-size: 13px;
      color: #555;
      margin-bottom: 10px;
    }

    /* Actions */
    .actions {
      display: flex;
      gap: 10px;
    }

    .action-btn {
      background: #f5f5f7;
      border: none;
      border-radius: 8px;
      padding: 5px 10px;
      font-size: 12px;
      cursor: pointer;
      transition: all 0.2s;
    }

    .action-btn:hover {
      background: #4f46e5;
      color: white;
    }
</style>
<?php end_section(); ?>


<?php start_section('page_title'); ?>
Dashboard
<?php end_section(); ?>

<?php start_section('page_heading'); ?>
<?php end_section(); ?>

<?php start_section('content'); ?>
<div class="sidebar2">
    <h3>Menu</h3>
    <ul>
      <li><a href="<?= base_url('mails'); ?>">📨 Tout les messages <span>12</span></a></li>
	  <li><a href="<?= base_url('favourites'); ?>">⭐ Team task <span>2</span></a></li>
      <li><a href="<?= base_url('sent'); ?>">📤 Brief <span>8</span></a></li>
      <li><a href="<?= base_url('archived'); ?>">📦 Temporaire <span>24</span></a></li>
      <li><a href="<?= base_url('spam'); ?>">⚠️ GTM <span>15</span></a></li>
      <li><a href="<?= base_url('trash'); ?>">🗑️ Trash <span>28</span></a></li>
    </ul>

    <div class="label-section">
      <h3>Label</h3>
      <ul>
        <li><a href="<?= base_url('projects'); ?>">📂 Projects</a></li>
        <li><a href="<?= base_url('customers'); ?>">👥 Customers</a></li>
        <li><a href="<?= base_url('companies'); ?>">🏢 Companies</a></li>
      </ul>
    </div>
</div>


<div class="main">
    <div class="main-header">
      <h2>📥 Message note <small>(12 messages)</small></h2>
    </div>

    <div class="message-list">
        <?php foreach($notes as $note): ?>			
          <div class="message">
            <div class="message-header">
              <span class="sender"><?= nl2br(htmlspecialchars($note->author)); ?></span>
              <span class="date"><?= nl2br(htmlspecialchars($note->date_due)); ?></span>
            </div>
            <div class="subject"><?= htmlspecialchars($note->title); ?></div>
            <div class="preview"><?= nl2br(htmlspecialchars($note->content)); ?></div>
            <div class="actions">
          <button class="action-btn">👍 4</button>
          <button class="action-btn" data-bs-toggle="modal" data-bs-target="#discussionModal">💬 2</button>
          </div>

          </div>
        <?php endforeach; ?>
        <?php foreach($tache as $taches): ?>			
          <div class="message">
            <div class="message-header">
              <span class="sender"><?= nl2br(htmlspecialchars($taches->AM_photo)); ?></span>
              <span class="date">Dec 4, 2019</span>
            </div>
            <div class="subject"><?= htmlspecialchars($taches->title); ?></div>
            <div class="preview"><?= nl2br(htmlspecialchars($taches->description)); ?></div>
            <div class="actions">
          <button class="action-btn">👍 4</button>
          <button class="action-btn" data-bs-toggle="modal" data-bs-target="#discussionModal">💬 2</button>
          </div>

          </div>
        <?php endforeach; ?>

    </div>
	<div class="modal fade" id="discussionModal" tabindex="-1" aria-labelledby="discussionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="discussionModalLabel">Discussion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" id="task_discussion">
        <!-- Ici tu ajoutes tes messages -->
      </div>

      <div class="modal-footer">
        <div class="input-group">
          <textarea name="message" id="message" class="form-control p-2" style="resize: none;" placeholder="Type a message ..."></textarea>
          <button class="btn btn-primary" type="button">Envoyer</button>
        </div>
      </div>
    </div>
  </div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php end_section(); ?>
