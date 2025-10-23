<div class="modal fade" id="inventaireModal" tabindex="-1" role="dialog" aria-labelledby="inventaireModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
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

						<div class="row text-center mockup">
							<!-- YouTube -->
							<div class="col-md-3 col-6">
								<div class="mockup-icon">
									<img src="https://cdn3.iconfinder.com/data/icons/social-network-30/512/social-06-1024.png" alt="YouTube">
								</div>
								<p class="mockup-label">YouTube</p>
								<!-- foreach here -->
								<div class="mockup mb-3">
									<div class="phone-frame">
										<div class="screen">
											<div class="youtube-preview">
												<div class="thumbnail"></div>
												<div class="video-info">
													<div class="video-title">Amazing Product Demo</div>
													<div class="video-desc">Watch how this product changes your life.</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="mockup mb-3">
									<div class="phone-frame">
										<div class="screen">
											<div class="youtube-preview">
												<div class="thumbnail"></div>
												<div class="video-info">
													<div class="video-title">Amazing Product Demo</div>
													<div class="video-desc">Watch how this product changes your life.</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- Gmail -->
							<div class="col-md-3 col-6 mb-4">
								<div class="mockup mb-3">
									<div class="mockup-icon">
										<img src="https://cdn4.iconfinder.com/data/icons/logos-brands-in-colors/48/google-gmail-1024.png" alt="Gmail">
									</div>
									<p class="mockup-label">Gmail</p>
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
									<div class="mockup-icon">
										<img src="https://cdn4.iconfinder.com/data/icons/logos-brands-in-colors/150/google-maps-1024.png" alt="Maps">
									</div>
									<p class="mockup-label">Maps</p>
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
									<div class="mockup-icon">
										<img src="https://cdn2.iconfinder.com/data/icons/social-icons-33/128/Google-1024.png" alt="Search">
									</div>
									<p class="mockup-label">Search</p>
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
