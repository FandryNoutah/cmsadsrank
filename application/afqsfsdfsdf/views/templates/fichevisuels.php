<h1>Fiche Visuels</h1>
<h4>Visuels :</H4>	
<h4>Date : </h4>
<?php if(count($visuels)>0){ ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">label</th>
               
            </tr>
        </thead>
        <tbody>
            <?php foreach($visuels as $v) : ?>
				
				<?php echo $v->label . "<br/>"; ?>
			<?php endforeach ?>
        </tbody>
    </table>
<?php } ?>


DANGER
          
                    
