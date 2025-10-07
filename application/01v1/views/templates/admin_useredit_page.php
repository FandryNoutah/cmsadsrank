<div id="infoMessage"><?php echo $message;?></div>

<div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-colored-form-control">User Profile</h4>
        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
        <div class="heading-elements">
          <ul class="list-inline mb-0">
            <li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
            <li><a data-action="reload"><i class="icon-reload"></i></a></li>
            <li><a data-action="expand"><i class="icon-expand2"></i></a></li>
            <li><a data-action="close"><i class="icon-cross2"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="card-body collapse in">
        <div class="card-block">

          <div class="card-text"></div>
          <!--
          <div id="infoMessage"><?php //echo $message;?></div>
          -->
          <?php echo form_open(uri_string());?>
            <div class="form-body">
              <h4 class="form-section"><i class="icon-eye6"></i> About User</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="first_name">Prénom <?php echo form_error('first_name', '<span class="error">', '</span>'); ?></label>
                    <?php echo form_input($first_name, '', 'required'); ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="last_name">Nom <?php echo form_error('last_name', '<span class="error">', '</span>'); ?></label>
                    <?php echo form_input($last_name, '', 'required'); ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="username">Login (Nom d'utilisateur) <?php echo form_error('identity', '<span class="error">', '</span>'); ?></label>
                    <?php echo form_input($identity, '', 'required'); ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="company">Société <?php echo form_error('company', '<span class="error">', '</span>'); ?></label>
                    <?php echo form_input($company, '', 'required'); ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password">Mot de passe <?php echo form_error('password', '<span class="error">', '</span>'); ?></label>
                    <?php echo form_input($password, '', 'required'); ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password_confirm">Confirmation mot de passe <?php echo form_error('password_confirm', '<span class="error">', '</span>'); ?></label>
                    <?php echo form_input($password_confirm, '', 'required'); ?>
                  </div>
                </div>
              </div>

              <h4 class="form-section"><i class="icon-mail6"></i> Contact Info</h4>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Adresse E-mail <?php echo form_error('email', '<span class="error">', '</span>'); ?></label>
                    <?php echo form_input($email, '', 'required'); ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="phone">Téléphone <?php echo form_error('phone', '<span class="error">', '</span>'); ?></label>
                    <?php echo form_input($phone, '', 'required'); ?>
                  </div>
                </div>
              </div>

              <h4 class="form-section"><i class="icon-mail6"></i> Groupes</h4>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    
                    <?php if ($this->ion_auth->is_admin()): ?>
                      <h3><?php echo lang('edit_user_groups_heading');?></h3>
                      <?php foreach ($groups as $group):?>
                          <label class="checkbox">
                          <?php
                              $gID=$group['id'];
                              $checked = null;
                              $item = null;
                              foreach($currentGroups as $grp) {
                                  if ($gID == $grp->id) {
                                      $checked= ' checked="checked"';
                                  break;
                                  }
                              }
                          ?>
                          <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                          <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                          </label>
                      <?php endforeach?>
                    <?php endif ?>

                  </div>
                </div>


            </div>

            <?php echo form_hidden('id', $user->id);?>
            <?php echo form_hidden($csrf); ?>

            <div class="form-actions right">
              <button type="reset" class="btn btn-warning mr-1">
                <i class="icon-cross2"></i> Cancel
              </button>
              <button type="submit" class="btn btn-primary">
                <i class="icon-check2"></i> Save
              </button>
            </div>
          <?php echo form_close();?>

        </div>
      </div>
    </div>
  </div>
</div>