<h1 class="text-center text-primary" style="font-family:pristina;margin-top:20px;margin-bottom:30px"><u>Connecter-vous</u></h1>

<div class="col-md-12 offset-md-4">
    <div class="card border-info" style="max-width: 20rem;">
      <div class="card-header text-center bg-primary text-uppercase" style="color:white">Utilisateur</div>
      <div class="card-body">
        <form action="<?php echo site_url('BaseController/connectionUser');?>" method="post">
          <fieldset>
            <div class="form-group">
              <label for="exampleInputEmail1">Login</label>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="login">
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Mot de passe</label>
              <input type="password" class="form-control" id="exampleInputPassword1" name="password">
            </div>
            <button type="submit" class="btn btn-primary col-md-12">Se connecter</button>
          </fieldset>
        </form>
        <?php if($message!=""){ ?>
          <hr>
          <div class="alert-danger">
           <p class="text-center" style="color:white"> <strong><?php echo $message;?></strong> </p>
          </div>
          <?php } ?>
      </div>
    </div>
</div>