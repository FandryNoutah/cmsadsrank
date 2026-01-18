
<div class="modal fade" id="inventaireModal" tabindex="-1" role="dialog" aria-labelledby="inventaireModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 1400px;">
		<div class="modal-content">
			<div class="modal-header pb-0">
				<h5 class="modal-title align-self-center" id="inventaireModalLabel">Inventaire</h5>
				<ul class="nav nav-tabs mr-auto ml-5" role="tablist">
					<li class="nav-item">
						<a class="nav-link py-3 active" type="button" id="pmax_tab" data-toggle="tab" data-target="#pmax" role="tab" aria-controls="pmax" aria-selected="true">
							Performance max
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link py-3" type="button" id="search_tab" data-toggle="tab" data-target="#search" role="tab" aria-controls="pmax" aria-selected="true">
							Search
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link py-3" type="button" id="local_tab" data-toggle="tab" data-target="#local" role="tab" aria-controls="local" aria-selected="false">
							Local
						</a>
					</li>
				</ul>
				<button id="exportPdfBtn" class="btn btn-primary no-export">Lien datastudio</button>
				<button id="exportPdfBtn" class="btn btn-primary no-export">Exporter en PDF</button>
				<!-- <button class="btn btn-secondary no-export" data-dismiss="modal">Fermer</button> -->


			</div>
			<div class="modal-body">

				<div class="tab-content" id="clientTabContent">

					<!-- PMAX -->
					<div class="tab-pane fade show active" id="pmax" role="tabpanel" aria-labelledby="pmax_tab">
						<?php foreach ($groupe_valider as $groupe): ?>
							<?php if ($groupe['type_campagne'] == 3): ?>

								
							<?php endif; ?>
						<?php endforeach; ?>
					</div>

					<!-- SEARCH -->
					<div class="tab-pane fade" id="search" role="tabpanel" aria-labelledby="search_tab">

						<?php foreach ($groupe_valider as $groupe): ?>
							<?php if ($groupe['type_campagne'] == 1): ?>


							<?php endif; ?>
						<?php endforeach; ?>
					</div>

					<!-- LOCAL -->
					<div class="tab-pane fade" id="local" role="tabpanel" aria-labelledby="local_tab">
						<?php foreach ($groupe_valider as $groupe): ?>
							<?php if ($groupe['type_campagne'] == 2): ?>
								
							<?php endif; ?>
						<?php endforeach; ?>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
