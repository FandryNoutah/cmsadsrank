<h1 class="display-1 text-center mt-4" style="font-size: 42px;">
						Campagne
					</h1>
					<div class="table-responsive">
						<table class="table table-hover table-wrapper">
							<thead class="bg-light text-muted">
								<tr>
									<th class="text-muted">TYPE</th>
									<th class="text-muted">CAMPAGNE</th>
									<th class="text-muted">BUDGET</th>
									<th class="text-muted">GROUPES D'ANNONCES</th>
									<th class="text-muted">MOT CLE</th>
									
								</tr>
							</thead>
							<tbody>
								<?php if (!empty($donne_valider)): ?>
									<?php foreach ($donne_valider as $campagne): ?>
										<tr>
											<td>
												<?php 
													switch ($campagne['type_campagne']) {
														case 1: echo "Search"; break;
														case 2: echo "Local"; break;
														case 3: echo "PMax"; break;
														default: echo "Inconnu"; break;
													}
												?>
											</td>
											<td><?= htmlspecialchars($campagne['nom_campagne']) ?></td>
											<td><?= isset($campagne['repartition_budget']) ? (float)$campagne['repartition_budget'] : 0 ?> €</td>
											<td>
												<?php if (!empty($campagne['groupes_annonces'])): ?>
													<?php foreach ($campagne['groupes_annonces'] as $groupe): ?>
														<div style="margin-bottom: 10px;">
															<a href="<?= base_url('Client/insertgroupeannonce/' . $groupe['idgroupe_annonce']) ?>"><strong><?= htmlspecialchars($groupe['nom_groupe']) ?></strong></a>
															<?php if($groupe['statut'] == 1): ?>
															<img class="mr-2" src="<?= base_url('assets/images/icons/figma/CheckCircle.png') ?>" />
															<?php endif; ?>	
															<br>
														</div>
														
														<hr>
													<?php endforeach; ?>
												<?php else: ?>
													<em>Aucun groupe</em>
												<?php endif; ?>
											</td>
											<td>
												<?php if (!empty($campagne['groupes_annonces'])): ?>
													<?php foreach ($campagne['groupes_annonces'] as $groupe): ?>
														<div style="margin-bottom: 10px;">
															<?php 
																$mots = explode("\n", $groupe['mot_cle']);
																foreach ($mots as $mot) {
																	if (trim($mot) !== '') {
																		echo '<span class="badge badge-secondary">"' . htmlspecialchars(trim($mot)) . '"</span> ';
																	}
																}
															?>
														</div>
														<hr>
													<?php endforeach; ?>
												<?php else: ?>
													<em>Aucun groupe</em>
												<?php endif; ?>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else: ?>
									<tr>
										<td colspan="9" class="text-center text-muted">Aucune campagne trouvée.</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>