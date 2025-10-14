<div class="text-right mb-3">
	
    <a href="<?= site_url('client/export_pdf/' . $id) ?>" target="_blank">
        <img class="mr-2" src="<?= base_url('assets/images/icons/figma/ArrowLineDown.png') ?>" />
    </a>
</div>

<h1 class="display-1 text-center mt-4" style="font-size: 42px;">
					Campagne
				</h1>
				<div class="table-responsive">
					<table class="table table-hover table-wrapper">
						<thead class="thead-light">
							<tr>
								<th class="text-muted">TYPE</th>
								<th class="text-muted">CAMPAGNES</th>
								<th class="text-muted">BUDGET</th>
								<th class="text-muted">DEMANDE</th>
								<th class="text-muted">STATUT</th>
								<th class="text-muted">ACTION</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($campagnes)): ?>
								<?php foreach ($campagnes as $campagne): ?>
									<tr>
										<td><?= $campagne['type_campagne']; ?></td>
										<td><?= $campagne['nom_campagne']; ?></td>
										<td><?= $campagne['repartition_budget'] ?: 0; ?> Euro</td>
										<td>
											<span class="badge alert-primary">GTM</span>
										</td>
										<td>
											<?php if ($campagne['actif'] == 1): ?>
												<span class="badge alert-primary">
													<i class="fa fa-circle"></i>
													En cours
												</span>
											<?php else: ?>
												<span class="badge alert-success">
													<i class="fa fa-circle"></i>
													Terminée
												</span>
											<?php endif; ?>
										</td>
										<td>
											<a href="javascript:void(0);" class="text-decoration-none">
												<i class="fa fa-ellipsis-v"></i>
											</a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr>
									<td colspan="14" class="text-center text-muted">
										Aucune campagne trouvée.
									</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>

				</div>