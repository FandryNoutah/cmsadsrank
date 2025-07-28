<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-colored-form-control">Historique client</h4>
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
				<form action="<?php echo site_url('Googleads/updateDonneeClient'); ?>" method="POST">
				<?php foreach($client as $C){ ?>
					<?php foreach($donnees as $D){ ?>
						<?php foreach($produitbyid as $P){ ?>
							<?php foreach($idinitiative as $I){ ?>
								<?php foreach($idam as $A){ ?>
						<input class="form-control" type="hidden" name="idclient" value="<?php echo $C['idclients']; ?>"/>
						<input class="form-control" type="hidden" name="idonnee" value="<?php echo $D['idonnee']; ?>"/>
						<label for="fname"><b>Client :</b> <?php echo $C['nom_client']; ?></label>
						<label for="fname"><b>Email client :</b> <?php echo $C['email_client']; ?></label>
						<label for="fname"><b>Numero Client :</b> <?php echo $C['numero_client']; ?></label>
						<label for="fname"><b>Site client :</b> <?php echo $C['site_client']; ?></label>
						<label for="fname"><b>Budget :</b> <?php echo $D['budget']; ?></label>
						<label for="fname"><b>Produit :</b> <?php echo $P['label_produit']; ?></label>
						<label for="fname"><b>Initiative :</b> <?php echo $I['nominitiative']; ?></label>
						<label for="fname"><b>Account account_manager :</b> <?php echo $A['nomam']; ?></label>
						<label for="fname"><b>Mise en place du payement :</b> <?php echo $D['mis_en_place_paiement']; ?></label>
						<label for="fname"><b>Brief :</b> <?php echo $D['Brief']; ?></label>
						<label for="fname"><b>Annonce :</b> <?php echo $D['annonce']; ?></label>
					
			<?php  }}}}}?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function() {
		$("#enableFileUpdate").click(function() {
			if($(this).is(":checked")) {
				$("input#logo").removeAttr("disabled");
				$("input#logo").show();
			} else {
				$("input#logo").attr("disabled", "disabled");
				$("input#logo").hide();
			}
		});
	});
</script>

    
