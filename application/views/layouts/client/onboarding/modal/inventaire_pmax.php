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
						<a class="nav-link py-3" type="button" id="local_tab" data-toggle="tab" data-target="#local" role="tab" aria-controls="local" aria-selected="false">
							Local
						</a>
					</li>
				</ul>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="tab-content" id="clientTabContent">

					<!-- PMAX -->
					<div class="tab-pane fade show active" id="pmax" role="tabpanel" aria-labelledby="pmax_tab">

						<div class="row row-cols-5 text-center">
							<div class="col">
								<div class="mockup-icon">
									<img src="https://cdn3.iconfinder.com/data/icons/social-network-30/512/social-06-1024.png" alt="YouTube">
								</div>
								<p class="mockup-label">YouTube</p>
							</div>
							<div class="col">
								<div class="mockup-icon">
									<img src="https://cdn4.iconfinder.com/data/icons/logos-brands-in-colors/48/google-gmail-256.png" alt="Gmail">
								</div>
								<p class="mockup-label">Gmail</p>
							</div>
							<div class="col">
								<div class="mockup-icon">
									<img src="https://cdn2.iconfinder.com/data/icons/social-icons-33/128/Google-512.png" alt="Search">
								</div>
								<p class="mockup-label">Search</p>
							</div>
							<div class="col">
								<div class="mockup-icon">
									<img src="https://ailecs.org/wp-content/uploads/2024/07/web_100dp_33B54D_FILL0_wght400_GRAD0_opsz48.png" alt="Display">
								</div>
								<p class="mockup-label">Display</p>
							</div>
							<div class="col">
								<div class="mockup-icon">
									<img src="https://cdn1.iconfinder.com/data/icons/logos-brands-in-colors/150/Google_Discover-512.png" alt="Discover">
								</div>
								<p class="mockup-label">Discover</p>
							</div>
						</div>
					</div>

					<?php foreach ($groupe_valider as $groupe): ?>
						<?php if ($groupe['type_campagne'] == 3): ?>

							<div class="row row-cols-5 mb-4">
								<!-- YouTube -->
								<div class="col-auto">
									<div class="phone-frame">
										<div class="screen">
											<div class="d-flex justify-content-between align-items-center">
												<img src="https://cdn2.iconfinder.com/data/icons/social-media-2285/512/1_Youtube2_colored_svg-256.png" alt="Youtube" width="64">
												<i class="fa fa-search"></i>
											</div>
											<div class="thumb-box" style="height: 140px;">
												<img src=<?= $groupe['images'][0] ?? "https://placehold.co/120x120?text=Youtube+Ads" ?> alt="placeholder">
											</div>
											<div class="alert alert-primary border-0 py-0 px-2 d-flex justify-content-between align-items-center">
												<span class="small font-weight-bold">Book now</span>
												<i class="fa fa-external-link-alt"></i>
											</div>
											<div class="row no-gutters justify-content-between">
												<div class="col-auto">
													<img src="https://placehold.co/38x38?text=Favicon" alt="" class="rounded-circle" width="38">
												</div>
												<div class="col px-2">
													<p class="font-weight-bold m-0"><?= $groupe['nom_groupe'] ?></p>
													<p class="small text-muted m-0"><?= $groupe['descriptions1'] ?></p>
												</div>
												<div class="col-auto">
													<i class="fa fa-ellipsis-v"></i>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Gmail -->
								<div class="col-auto">
									<div class="phone-frame">
										<div class="screen">
											<div class="d-flex justify-content-between align-items-center mb-3">
												<i class="fa fa-chevron-left mr-auto"></i>
												<i class="mr-4 far fa-star"></i>
												<i class="mr-4 fa fa-trash"></i>
												<i class="fa fa-ellipsis-h"></i>
											</div>
											<div class="row no-gutters justify-content-start mb-3">
												<div class="col-auto">
													<img src="https://placehold.co/38x38?text=Favicon" alt="" class="rounded-circle" width="38">
												</div>
												<div class="pl-2 col">
													<p class="small m-0 font-weight-bold">Résidence-Luxe</p>
													<p class="small m-0 text-muted">à Moi</p>
												</div>
											</div>
											<div class="thumb-box mb-3" style="height: 140px;">
												<img src=<?= $groupe['images'][0] ?? "https://placehold.co/120x120?text=Youtube+Ads" ?> alt="placeholder">
											</div>

											<p class="font-weight-bold mb-2"><?= $groupe['nom_groupe'] ?></p>
											<p class="small text-muted"><?= $groupe['descriptions1'] ?></p>

											<span class="badge badge-primary py-2 w-100 rounded-pill">Book now</span>
										</div>
									</div>
								</div>

								<!-- Search -->
								<div class="col-auto">
									<div class="phone-frame">
										<div class="screen">
											<p class="small font-weight-bold mb-2">Sponsorisé</p>
											<div class="row no-gutters justify-content-start mb-3">
												<div class="col-auto">
													<img src="https://placehold.co/38x38?text=Favicon" alt="" class="rounded-circle" width="38">
												</div>
												<div class="pl-2 col">
													<p class="m-0">Résidence-Luxe</p>
													<p class="small m-0 text-muted"><?= $groupe['url_site'] ?></p>
												</div>
											</div>

											<p class="text-primary font-weight-bold mb-2"><?= $groupe['nom_groupe'] ?></p>
											<p class="small text-muted mb-2"><?= $groupe['descriptions1'] ?></p>

											<span class="border rounded-pill text-primary py-1 px-2 small">Chalets de Luxe</span>
											<span class="border rounded-pill text-primary py-1 px-2 small">Promotions</span>
											<hr>
											<i class="fa fa-phone"></i>
											Appeler le <?= $groupe['téléphone'] ?>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<!-- LOCAL -->
				<div class="tab-pane fade" id="local" role="tabpanel" aria-labelledby="local_tab">

					<ul class="nav nav-tabs mb-4 d-flex justify-content-center" role="tablist">
						<li class="nav-item">
							<a class="nav-link py-0 active" type="button" id="pmax_tab" data-toggle="tab">
								<div class="mockup-icon">
									<img src="https://cdn3.iconfinder.com/data/icons/social-network-30/512/social-06-1024.png" alt="YouTube">
								</div>
								<p class="mockup-label mt-0">Tout</p>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-0" type="button" id="local_tab" data-toggle="tab">
								<div class="mockup-icon">
									<img src="https://cdn4.iconfinder.com/data/icons/logos-brands-in-colors/150/google-maps-1024.png" alt="Maps">
								</div>
								<p class="mockup-label mt-0">Maps</p>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-0" type="button" id="local_tab" data-toggle="tab">
								<div class="mockup-icon">
									<img src="https://cdn2.iconfinder.com/data/icons/social-icons-33/128/Google-1024.png" alt="Search">
								</div>
								<p class="mockup-label mt-0">Search</p>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link py-0" type="button" id="local_tab" data-toggle="tab">
								<div class="mockup-icon">
									<img src="https://cdn4.iconfinder.com/data/icons/logos-brands-in-colors/48/google-gmail-1024.png" alt="Gmail">
								</div>
								<p class="mockup-label mt-0">Gmail</p>
							</a>
						</li>
					</ul>

					<div class="row text-center mockup justify-content-between">

						<!-- Gmail -->
						<div class="col-md-3 col-6 mb-4">
							<!-- foreach here -->
							<div class="mockup mb-3">
								<div class="phone-frame">
									<div class="screen">
										<div class="gmail-preview">
											<div class="mail-header">
												<div class="avatar"></div>
												<div class="mail-info">
													<div class="mail-title">Special Offer Just for You</div>
													<div class="mail-desc">Open to get your 25% discount now.</div>
												</div>
											</div>
											<div class="mail-image"></div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Maps -->
						<div class="col-md-3 col-6 mb-4">
							<div class="mockup mb-3">
								<div class="phone-frame">
									<div class="screen">
										<div class="maps-preview">
											<div class="map"></div>
											<div class="pin"></div>
											<div class="maps-desc">Visit our store at 123 Main St.</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- Google Search -->
						<div class="col-md-3 col-6 mb-4">
							<div class="mockup mb-3">
								<div class="phone-frame">
									<div class="screen">
										<div class="search-preview">
											<div class="search-bar"></div>
											<div class="search-result">
												<div class="result-link">https://example.com</div>
												<div class="result-title">Buy Sneakers Online - 50% Off</div>
												<div class="result-desc">Shop top brands. Free shipping and easy returns.</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>
</div>
