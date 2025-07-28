<h1 class="text-center text-primary" style="font-family:prisdtina;margin-top:20px;margin-bottom:30px"><u>Insertion Concurrent</u></h1>
<?php foreach($visuels as $v){ ?>
<?php echo $v->id ?>
////
<br>
<?php echo $v->label ?>
//////
<br>
<?php echo $v->date_visuel ?>
<?php } ?>


<?php 
$hide = array("id", "status");
$count = count($visuels) > 1; 

$this->session->set_flashdata('result', $visuels);

?>
<?php // datadump($listeConcurrent); die();?>   


<div class="col-md-12 offset-md-4">
							<?php if(count($visuels)>0){ ?>
							<?php //datadump($visuels); die(); ?>
							<?php } ?>			
							
    <div class="card border-info" style="max-width: 20rem;">
      <div class="card-header text-center bg-primary text-uppercase" style="color:white">Concurrent</div>
      <div class="card-body">
        <form action="<?php echo site_url('Visuels/AjoutConcurrent/'.$this->session->userdata('idVisuels'));?>" method="post" enctype="multipart/form-data">
          <fieldset>
              
             <div class="form-group">
                <label for="exampleSelect1">Categorie</label>
                <select class="form-control" id="exampleSelect1" name="categorie">
            
			   <?php foreach($listeConcurrent as $C){ ?>
                        <option value="<?php echo $C['nomconcurrent'];?>"> <?php echo $C['nomconcurrent'];?>  </option>
                    <?php } ?>
                </select>
 
           <div class="form-group">
              <label for="exampleInputEmail1">Remarque</label>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="remarque">
            </div>
			<input type="hidden" value="<?php echo $visuels[0]->id ?>" name="idvisuels" >
            <br>
			<div class="col-md-3">
			</div>
			<div class="col-md-3">
			<div class="form-group">
				<input type="file" name="image1">
			</div>
			</div>
            <button type="submit" class="btn btn-primary col-md-12">Ajouter</button>
          </fieldset>
        </form>
      </div>
    </div>
</div>