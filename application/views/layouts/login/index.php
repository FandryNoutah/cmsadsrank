<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/figma/login_page/globals.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/figma/login_page/styleguide.css"); ?>" />
    <link rel="stylesheet" href="<?php echo base_url("assets/css/figma/login_page/style.css"); ?>" />
   <style>
      html body.fixed-navbar {
        padding-top: 0rem;
    }
    html body .content .content-wrapper {
    padding: 0rem;
    }
    .input-field {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    background-color: white;
}

.input-field::placeholder {
    color: #aaa;
}
.input-base-3 {
    position: relative;
    display: flex;
    align-items: center;
}

.input-base-3 .input-field {
    width: 100%;
    padding-right: 40px;
    box-sizing: border-box;
}

.input-base-3 .icon-eye {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    cursor: pointer;
}
.button-signin {
    background: transparent;  /* Pas de background */
    color: white;             /* Texte blanc */
    border: none;             /* Pas de bordure */
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    padding: 6px 0;
    /* Si tu veux, ajoute un effet au survol */
    transition: color 0.3s ease;
}

.button-signin:hover {
    color: #ddd; /* Texte un peu plus clair au survol */
}
.sign-in-page .input-base-3 {
      padding: 0px;
          border: 0px solid;
}
.input-field {
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.input-field:hover {
  border-color: #888; /* bordure plus foncée au hover */
  box-shadow: 0 0 5px rgba(136, 136, 136, 0.3); /* légère ombre */
}

.input-field:focus {
  border-color: border-color 0.3s ease, box-shadow 0.3s ease; /* bleu clair bordure */
  box-shadow: 0 0 8px rgba(51, 153, 255, 0.6); /* ombre bleutée */
  outline: none; /* supprimer outline par défaut */
}

  </style>

  </head>
  <body>
    <div class="sign-in-page" data-model-id="844:78426">
      <div class="illustrational-image">
        <div class="overlap" style="">
          <div class="pattern">
          
          </div>
          <p class="text-wrapper">Pilotage Clients – </br>La performance de votre portefeuille</p>
          <div class="companies">
            <div class="company-logo"><img class="vector" src="<?php echo base_url("assets/css/figma/login_page/img/image.svg"); ?>" /></div>
            <div class="div">
              <img class="vector-2" src="<?php echo base_url("assets/css/figma/login_page/img/vector-1.svg"); ?>" /> <img class="vector-3" src="<?php echo base_url("assets/css/figma/login_page/img/vector-2.svg"); ?>" />
            </div>
            <div class="company-logo-2">
              <img class="vector-4" src="<?php echo base_url("assets/css/figma/login_page/img/vector-3-2.svg"); ?>" />
              <img class="vector-5" src="<?php echo base_url("assets/css/figma/login_page/img/vector-4.svg"); ?>" />
              <img class="vector-6" src="<?php echo base_url("assets/css/figma/login_page/img/vector-5.svg"); ?>" />
              <img class="vector-7" src="<?php echo base_url("assets/css/figma/login_page/img/vector-6.svg"); ?>" />
              <img class="vector-8" src="<?php echo base_url("assets/css/figma/login_page/img/vector-7.svg"); ?>" />
              <img class="vector-9" src="<?php echo base_url("assets/css/figma/login_page/img/vector-8.svg"); ?>" />
            </div>
            <div class="company-logo-3">
              <img class="vector-10" src="<?php echo base_url("assets/css/figma/login_page/img/vector-9.svg"); ?>" />
              <img class="vector-11" src="<?php echo base_url("assets/css/figma/login_page/img/vector-10.svg"); ?>" />
              <img class="vector-12" src="<?php echo base_url("assets/css/figma/login_page/img/vector-11.svg"); ?>" />
              <img class="vector-13" src="<?php echo base_url("assets/css/figma/login_page/img/vector-12.svg"); ?>" />
              <img class="vector-14" src="<?php echo base_url("assets/css/figma/login_page/img/vector-13.svg"); ?>" />
            </div>
            <div class="vector-wrapper"><img class="vector-15" src="<?php echo base_url("assets/css/figma/login_page/img/img/vector.svg"); ?>" /></div>
            <div class="img-wrapper"><img class="vector-16" src="<?php echo base_url("assets/css/figma/login_page/img/img/vector-3.svg"); ?>" /></div>
            <div class="rectangle"></div>
            <div class="rectangle-2"></div>
          </div>
          
          <div class="illustration">
            <img src="<?php echo base_url("assets/css/figma/login_page/img/capture.jpg"); ?>" style="width: 450px; border-radius: 10px;" />
            <div class="task-modal">
              <div class="div-7">
                <div class="text-wrapper-13">Enter Task Name</div>
                <img class="icon-x" src="img/icon-x.svg" />
              </div>
              <img class="separator-2" src="img/separator-2.svg" />
              <div class="content-12">
                <div class="content-13">
                  <div class="members">
                    <div class="text-wrapper-14">Add Members</div>
                    <div class="buttons-5"><img class="icon-userplus" src="img/icon-userplus.svg" /></div>
                  </div>
                  <div class="labels">
                    <div class="text-wrapper-14">Add Labels</div>
                    <div class="buttons-5"><img class="img-4" src="img/icon-tag.svg" /></div>
                  </div>
                  <div class="date-picker">
                    <div class="label"><div class="input-label">Due Date</div></div>
                    <div class="input-base">
                      <img class="icon-calendar" src="img/icon-calendar-1.svg" />
                      <div class="select-date-range">Select Date</div>
                      <img class="icon-arrow-down" src="img/icon-arrow-down.svg" />
                    </div>
                  </div>
                </div>
                <div class="div-10">
                  <div class="label"><div class="input-label-2">Description</div></div>
                  <div class="input-base-2">
                    <div class="enter-your-title">Enter your description here</div>
                    <div class="text-wrapper-15">0/50</div>
                  </div>
                </div>
                <div class="checklist-5">
                  <div class="text-field">
                    <div class="label"><div class="input-label-3">Task Checklist</div></div>
                  </div>
                  <div class="buttons-5"><img class="img-4" src="img/icon-listcheck.svg" /></div>
                </div>
                <div class="div-10">
                  <div class="text-wrapper-16">Attachment</div>
                  <div class="upload-files-modal">
                    <img class="icon-image" src="img/icon-image.svg" />
                    <p class="text-wrapper-17">Drag files here or Browse</p>
                  </div>
                </div>
              </div>
              <div class="buttons-6"><div class="placeholder-3">Create Task</div></div>
            </div>
          </div>
       </div>
      </div>
      <div class="content-14">
        <div class="content-15">
          <div class="frame-5">
            <div class="text-wrapper-18"></div>
          </div>
          <div class="headline">
            <img src="<?= base_url('assets/images/figma/logo_adsrank.png') ?>" style="width: 42%;"/>
            <div class="text-wrapper-19">Welcome!</div>
            <div class="text-wrapper-20">Connectez-vous pour continuer.</div>
          </div>
          <div class="right-panel">
          <?php echo $this->session->flashdata('message'); ?>
          
          <?php echo form_open('', array('class' => 'form')); ?>
          
          <div class="textfield">
              <!-- Username / Email -->
              <div class="text-field-2">
                  <div class="label">
                      <div class="input-label-4">User name</div>
                  </div>
                  <div class="input-base-3">
                      <?php echo form_error('identity'); ?>
                      <input 
                          type="text" 
                          name="identity"
                          value="<?php echo set_value('identity'); ?>"
                          class="input-field" 
                          placeholder="Votre nom d'utilisateur" 
                          required 
                      />
                  </div>
              </div>

              <!-- Password -->
              <div class="text-field-2">
                  <div class="label">
                      <div class="input-label-4">Password</div>
                  </div>
                <div class="input-base-3" style="position: relative; display: flex; align-items: center;">
          <?php echo form_error('password'); ?>
          
          <input 
              type="password" 
              name="password"
              id="password-field"
              class="input-field"
              placeholder="Votre mot de passe ici"
              required
              style="
                  width: 100%;
                  padding-right: 40px; /* Espace pour l'œil */
                  box-sizing: border-box;
              "
          />

    <img 
        class="icon-eye" 
        src="<?php echo base_url("assets/css/figma/login_page/img/icon-eye.svg"); ?>" 
        alt="Toggle visibility" 
        onclick="togglePasswordVisibility()" 
        style="
            position: absolute;
            right: 12px;
            top: 50%;
              transform: translateY(-50%);
            width: 20px;
            height: 20px;
            cursor: pointer; margin-right: 5px;
        "
    />
</div>



</div>

        <!-- Remember Me & Forgot Password -->
        <div class="div-6">
            <div class="frame-6">
                <div class="checkbox">
                    <input type="checkbox" id="remember" name="remember" />
                    <label for="remember" class="rounded-rectangle"></label>
                </div>
                <div class="text-wrapper-21">Remember Me</div>
            </div>
            <div class="text-wrapper-22">Forgot Password?</div>
        </div>
    </div>

    <!-- Buttons -->
    <div class="button-2">
        <div class="buttons-7" onclick="this.querySelector('button').click()" style="cursor: pointer;">
    <button type="submit" class="button-signin">Se connecter</button>
</div>

        <div class="buttons-8">
            <img class="brand-logos" src="<?php echo base_url("img/brand-logos.svg"); ?>" />
            <div class="placeholder-5">Sign In with Google</div>
        </div>
        <div class="frame-7">
            <p class="text-wrapper-23">Vous n'avez pas de compte?</p>
            <div class="text-wrapper-22">Contact Admin</div>
        </div>
    </div>

    <?php echo form_close(); ?>
</div>


        </div>
        <p class="text-wrapper-24">©2025 Adsrank. CRM</p>
      </div>
    </div>
  </body>
</html>
<script>
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password-field');
    const eyeIcon = document.querySelector('.icon-eye');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.src = '<?php echo base_url("assets/css/figma/login_page/img/icon-eye.svg"); ?>';
    } else {
        passwordInput.type = 'password';
        eyeIcon.src = '<?php echo base_url("assets/css/figma/login_page/img/icon-eye.svg"); ?>';
    }
}
</script>
