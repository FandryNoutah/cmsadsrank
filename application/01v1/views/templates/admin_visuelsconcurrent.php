<h1 class="text-center text-primary" style="font-family:pristicsna;margin-top:20px;margin-bottom:40px"><u>Liste Concurrent par visuel:</u></h1>
<div class="form-group">		
										<label for="exampleSelect1"></label>
										<select class="form-control" id="exampleSelect1" name="visuels"<?php echo form_error('visuels', '<span class="error">', '</span>'); ?>>
										<?php foreach($visuels as $v){ ?>

												<option value="<?php echo $v->id;?>"> <?php echo $v->label;?> </option>
											<?php } ?>
										
										
										</select>
									</div>

  

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Nom concurrent</th>
                <th scope="col">remarque</th>
                <th scope="col">image 1</th>
                <th scope="col">image 2</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listeConcurrent as $c){ ?>
            <form>
                

                <tr class="table">
                    <td><?php echo $c['nomconcurrent'] ;?></td>
                    <td><?php echo $c['remarque'] ;?></td>
                    <td><button type="submit"  class="btn btn-primary col-md-12"><?php echo $c['image1'] ;?></button></td>
					<td><button type="submit" class="btn btn-primary col-md-12" style="color:white" ><?php echo $c['image2'] ;?></button></td>
                    <td>
                        
                    </td>
                   
                </tr>
            </form>
        <?php  } ?>
        </tbody>
		
    </table>

