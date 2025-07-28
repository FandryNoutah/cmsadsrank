<div class="col-md-12">
	<div class="card">
		<div class="card-header">
			<h4 class="card-title" id="basic-layout-colored-form-control">Commentaire client</h4>
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
				<?php foreach($client as $C){ ?>
					<?php foreach($donnees as $D){ ?>
						<p>Commentaire:  <?php echo $D['commentaire_client']; ?></p>	
			<?php  }}?>
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

    
