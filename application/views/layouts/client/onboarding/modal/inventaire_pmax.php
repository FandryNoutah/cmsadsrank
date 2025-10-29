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

						<?php foreach ($groupe_valider as $groupe): ?>
							<?php if ($groupe['type_campagne'] == 3): ?>

								<div class="row row-cols-5 mb-4 small">
									<!-- YouTube -->
									<div class="col-auto">
										<div class="phone-frame">
											<div class="screen">
												<div class="d-flex justify-content-between align-items-center">
													<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+PCFET0NUWVBFIHN2ZyAgUFVCTElDICctLy9XM0MvL0RURCBTVkcgMS4xLy9FTicgICdodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQnPjxzdmcgaGVpZ2h0PSIxMDAlIiBzdHlsZT0iZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7c3Ryb2tlLWxpbmVqb2luOnJvdW5kO3N0cm9rZS1taXRlcmxpbWl0OjI7IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiB3aWR0aD0iMTAwJSIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczpzZXJpZj0iaHR0cDovL3d3dy5zZXJpZi5jb20vIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PGc+PHBhdGggZD0iTTE1OS44NzQsMjE2LjY5OGMtMS44NzgsLTcuMDI2IC03LjQxLC0xMi41NTggLTE0LjQzNiwtMTQuNDM2Yy0xMi43MzUsLTMuNDEyIC02My43OTYsLTMuNDEyIC02My43OTYsLTMuNDEyYzAsMCAtNTEuMDYxLDAgLTYzLjc5NiwzLjQxMmMtNy4wMjUsMS44NzggLTEyLjU1OCw3LjQxIC0xNC40MzYsMTQuNDM2Yy0zLjQxMSwxMi43MzQgLTMuNDExLDM5LjMwMyAtMy40MTEsMzkuMzAzYzAsMCAwLDI2LjU2OCAzLjQxMSwzOS4zMDFjMS44NzgsNy4wMjYgNy40MTEsMTIuNTU5IDE0LjQzNiwxNC40MzdjMTIuNzM1LDMuNDExIDYzLjc5NiwzLjQxMSA2My43OTYsMy40MTFjMCwwIDUxLjA2MSwwIDYzLjc5NiwtMy40MTFjNy4wMjYsLTEuODc4IDEyLjU1OCwtNy40MTEgMTQuNDM2LC0xNC40MzdjMy40MTMsLTEyLjczMyAzLjQxMywtMzkuMzAxIDMuNDEzLC0zOS4zMDFjMCwwIDAsLTI2LjU2OSAtMy40MTMsLTM5LjMwM1oiIHN0eWxlPSJmaWxsOiNlZDFmMjQ7ZmlsbC1ydWxlOm5vbnplcm87Ii8+PHBhdGggZD0iTTY1LjMxMywyODAuNDk0bDQyLjQyMiwtMjQuNDkzbC00Mi40MjIsLTI0LjQ5NGwwLDQ4Ljk4N1oiIHN0eWxlPSJmaWxsOiNmZmY7ZmlsbC1ydWxlOm5vbnplcm87Ii8+PHBhdGggZD0iTTI1NS4xMSwyOTEuNjIzYzAuODk0LC0yLjMzMyAxLjM0MywtNi4xNDggMS4zNDMsLTExLjQ0MmwwLC0yMi4zMDRjMCwtNS4xMzcgLTAuNDQ5LC04Ljg5MyAtMS4zNDMsLTExLjI2OGMtMC44OTUsLTIuMzczIC0yLjQ3MiwtMy41NjEgLTQuNzI4LC0zLjU2MWMtMi4xOCwwIC0zLjcxOSwxLjE4OCAtNC42MTMsMy41NjFjLTAuODk1LDIuMzc1IC0xLjM0Myw2LjEzMSAtMS4zNDMsMTEuMjY4bDAsMjIuMzA0YzAsNS4yOTQgMC40MjcsOS4xMDkgMS4yODUsMTEuNDQyYzAuODU1LDIuMzM2IDIuNDExLDMuNTAzIDQuNjcxLDMuNTAzYzIuMjU2LDAgMy44MzMsLTEuMTY3IDQuNzI4LC0zLjUwM1ptLTE4LjA5OCwxMS4yMTFjLTMuMjMzLC0yLjE3NyAtNS41MywtNS41NjUgLTYuODksLTEwLjE2Yy0xLjM2MywtNC41OTEgLTIuMDQzLC0xMC43MDMgLTIuMDQzLC0xOC4zMzJsMCwtMTAuMzkyYzAsLTcuNzA3IDAuNzc3LC0xMy44OTcgMi4zMzUsLTE4LjU2NmMxLjU1NiwtNC42NzEgMy45ODgsLTguMDc3IDcuMjk4LC0xMC4yMThjMy4zMDgsLTIuMTQgNy42NDgsLTMuMjExIDEzLjAyLC0zLjIxMWM1LjI5NCwwIDkuNTM2LDEuMDkgMTIuNzI4LDMuMjdjMy4xOTEsMi4xNzkgNS41MjcsNS41ODYgNy4wMDcsMTAuMjE2YzEuNDc3LDQuNjM0IDIuMjE3LDEwLjgwMiAyLjIxNywxOC41MDlsMCwxMC4zOTJjMCw3LjYyOSAtMC43MiwxMy43NjEgLTIuMTYsMTguMzkyYy0xLjQ0MSw0LjYzMyAtMy43NzcsOC4wMTggLTcuMDA2LDEwLjE1OGMtMy4yMzIsMi4xNDEgLTcuNjA5LDMuMjExIC0xMy4xMzYsMy4yMTFjLTUuNjg1LDAgLTEwLjE0MiwtMS4wOSAtMTMuMzcsLTMuMjY5WiIgc3R5bGU9ImZpbGw6IzI3MjcyNztmaWxsLXJ1bGU6bm9uemVybzsiLz48cGF0aCBkPSJNNDg3LjA2OCwyNDQuMzg1Yy0wLjgxNiwxLjAxMyAtMS4zNjMsMi42NjcgLTEuNjM0LDQuOTYyYy0wLjI3NCwyLjI5NyAtMC40MDcsNS43ODEgLTAuNDA3LDEwLjQ1MmwwLDUuMTM5bDExLjc5MSwwbDAsLTUuMTM5YzAsLTQuNTkzIC0wLjE1NiwtOC4wNzcgLTAuNDY2LC0xMC40NTJjLTAuMzEyLC0yLjM3MyAtMC44NzUsLTQuMDQ1IC0xLjY5MiwtNS4wMmMtMC44MTksLTAuOTczIC0yLjA4NCwtMS40NiAtMy43OTYsLTEuNDZjLTEuNzE0LDAgLTIuOTc4LDAuNTA3IC0zLjc5NiwxLjUxOFptLTIuMDQxLDMwLjEyOGwwLDMuNjJjMCw0LjU5NCAwLjEzMyw4LjAzNyAwLjQwNywxMC4zMzNjMC4yNzEsMi4yOTcgMC44MzUsMy45NzIgMS42OTMsNS4wMjNjMC44NTcsMS4wNSAyLjE3OCwxLjU3NyAzLjk3MSwxLjU3N2MyLjQxMSwwIDQuMDY3LC0wLjkzNiA0Ljk2MiwtMi44MDRjMC44OTQsLTEuODY4IDEuMzgxLC00Ljk4MSAxLjQ1OSwtOS4zNDJsMTMuODk2LDAuODE4YzAuMDc4LDAuNjI1IDAuMTE3LDEuNDc5IDAuMTE3LDIuNTY4YzAsNi42MTggLTEuODA5LDExLjU2MiAtNS40MywxNC44MzFjLTMuNjE4LDMuMjY5IC04LjczOSw0LjkwNSAtMTUuMzU1LDQuOTA1Yy03Ljk0LDAgLTEzLjUwNywtMi40OTEgLTE2LjY5OCwtNy40NzVjLTMuMTkzLC00Ljk4IC00Ljc4OSwtMTIuNjg3IC00Ljc4OSwtMjMuMTJsMCwtMTIuNDk2YzAsLTEwLjc0MiAxLjY1NSwtMTguNTg0IDQuOTY0LC0yMy41MjhjMy4zMDgsLTQuOTQ0IDguOTcyLC03LjQxNiAxNi45OTEsLTcuNDE2YzUuNTI1LDAgOS43NjksMS4wMTIgMTIuNzI3LDMuMDM2YzIuOTU3LDIuMDI2IDUuMDQsNS4xNzggNi4yNDcsOS40NTljMS4yMDcsNC4yODIgMS44MTEsMTAuMTk5IDEuODExLDE3Ljc0OWwwLDEyLjI2MmwtMjYuOTczLDBaIiBzdHlsZT0iZmlsbDojMjcyNzI3O2ZpbGwtcnVsZTpub256ZXJvOyIvPjxwYXRoIGQ9Ik0xOTcuNzcyLDI3My4xNzJsLTE4LjMzMywtNjYuMjA5bDE1Ljk5NywwbDYuNDIyLDMwLjAwOWMxLjYzNiw3LjM5OCAyLjg0MiwxMy43MDMgMy42MiwxOC45MTdsMC40NjgsMGMwLjU0NCwtMy43MzYgMS43NTEsLTEwLjAwMSAzLjYxOSwtMTguOGw2LjY1NiwtMzAuMTI2bDE1Ljk5OCwwbC0xOC41NjYsNjYuMjA5bDAsMzEuNzYzbC0xNS44ODEsMGwwLC0zMS43NjNaIiBzdHlsZT0iZmlsbDojMjcyNzI3O2ZpbGwtcnVsZTpub256ZXJvOyIvPjxwYXRoIGQ9Ik0zMjQuNzE0LDIzMy4zNTVsMCw3MS41OGwtMTIuNjExLDBsLTEuNDAyLC04Ljc1NmwtMC4zNSwwYy0zLjQyNiw2LjYxNyAtOC41NjQsOS45MjQgLTE1LjQxNCw5LjkyNGMtNC43NDgsMCAtOC4yNTEsLTEuNTU2IC0xMC41MDksLTQuNjdjLTIuMjU4LC0zLjExMyAtMy4zODYsLTcuOTggLTMuMzg2LC0xNC41OTZsMCwtNTMuNDgybDE2LjExNCwwbDAsNTIuNTQ3YzAsMy4xOTMgMC4zNTEsNS40NyAxLjA1MSw2LjgzYzAuNzAxLDEuMzY0IDEuODY5LDIuMDQ1IDMuNTAzLDIuMDQ1YzEuNDAyLDAgMi43NDUsLTAuNDI4IDQuMDI4LC0xLjI4NWMxLjI4NSwtMC44NTcgMi4yMzgsLTEuOTQ1IDIuODYyLC0zLjI2OWwwLC01Ni44NjhsMTYuMTE0LDBaIiBzdHlsZT0iZmlsbDojMjcyNzI3O2ZpbGwtcnVsZTpub256ZXJvOyIvPjxwYXRoIGQ9Ik00MDcuMzcxLDIzMy4zNTVsMCw3MS41OGwtMTIuNjExLDBsLTEuNDAyLC04Ljc1NmwtMC4zNDgsMGMtMy40MjksNi42MTcgLTguNTY2LDkuOTI0IC0xNS40MTYsOS45MjRjLTQuNzQ5LDAgLTguMjUxLC0xLjU1NiAtMTAuNTA5LC00LjY3Yy0yLjI1OSwtMy4xMTMgLTMuMzg2LC03Ljk4IC0zLjM4NiwtMTQuNTk2bDAsLTUzLjQ4MmwxNi4xMTQsMGwwLDUyLjU0N2MwLDMuMTkzIDAuMzUsNS40NyAxLjA1LDYuODNjMC43MDIsMS4zNjQgMS44NywyLjA0NSAzLjUwNCwyLjA0NWMxLjQwMiwwIDIuNzQ1LC0wLjQyOCA0LjAyOCwtMS4yODVjMS4yODUsLTAuODU3IDIuMjM4LC0xLjk0NSAyLjg2MiwtMy4yNjlsMCwtNTYuODY4bDE2LjExNCwwWiIgc3R5bGU9ImZpbGw6IzI3MjcyNztmaWxsLXJ1bGU6bm9uemVybzsiLz48cGF0aCBkPSJNMzY4LjUwMywyMTkuOTI2bC0xNS45OTgsMGwwLDg1LjAwOWwtMTUuNzY0LDBsMCwtODUuMDA5bC0xNS45OTcsMGwwLC0xMi45NjJsNDcuNzU5LDBsMCwxMi45NjJaIiBzdHlsZT0iZmlsbDojMjcyNzI3O2ZpbGwtcnVsZTpub256ZXJvOyIvPjxwYXRoIGQ9Ik00NDUuOTMzLDI3My45OTVjMCw1LjIxNyAtMC4yMTYsOS4zMDQgLTAuNjQzLDEyLjI2MWMtMC40MjgsMi45NiAtMS4xNDgsNS4wNjIgLTIuMTYsNi4zMDZjLTEuMDEyLDEuMjQ2IC0yLjM3NywxLjg2OCAtNC4wODYsMS44NjhjLTEuMzI2LDAgLTIuNTUyLC0wLjMxMSAtMy42NzksLTAuOTM0Yy0xLjEzMSwtMC42MjMgLTIuMDQzLC0xLjU1NyAtMi43NDUsLTIuODAzbDAsLTQwLjYzNmMwLjU0NSwtMS45NDUgMS40NzksLTMuNTQyIDIuODAzLC00Ljc4OGMxLjMyNCwtMS4yNDMgMi43NjIsLTEuODY4IDQuMzIsLTEuODY4YzEuNjM1LDAgMi44OTksMC42NDMgMy43OTUsMS45MjZjMC44OTQsMS4yODUgMS41MTgsMy40NDUgMS44NjksNi40ODNjMC4zNSwzLjAzNSAwLjUyNiw3LjM1NSAwLjUyNiwxMi45NmwwLDkuMjI1Wm0xNC43NzEsLTI5LjE5N2MtMC45NzUsLTQuNTE0IC0yLjU1MSwtNy43ODQgLTQuNzMsLTkuODFjLTIuMTgsLTIuMDIzIC01LjE3OCwtMy4wMzUgLTguOTkxLC0zLjAzNWMtMi45NTgsMCAtNS43MjIsMC44MzggLTguMjksMi41MTFjLTIuNTY5LDEuNjc0IC00LjU1NSwzLjg3MyAtNS45NTYsNi41OTdsLTAuMTE4LDBsMC4wMDEsLTM3LjcxN2wtMTUuNTMsMGwwLDEwMS41OWwxMy4zMTEsMGwxLjYzNiwtNi43NzJsMC4zNDksMGMxLjI0NSwyLjQxMyAzLjExMyw0LjMyIDUuNjA1LDUuNzIyYzIuNDkxLDEuNDAxIDUuMjU2LDIuMTAyIDguMjkyLDIuMTAyYzUuNDQ4LDAgOS40NTcsLTIuNTEyIDEyLjAyNywtNy41MzJjMi41NjksLTUuMDIxIDMuODUzLC0xMi44NjMgMy44NTMsLTIzLjUzbDAsLTExLjMyNWMwLC04LjAxOCAtMC40ODcsLTE0LjI4NSAtMS40NTksLTE4LjgwMVoiIHN0eWxlPSJmaWxsOiMyNzI3Mjc7ZmlsbC1ydWxlOm5vbnplcm87Ii8+PC9nPjwvc3ZnPg==" alt="Youtube" width="58">
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
														<p class="small m-0">Résidence-Luxe</p>
														<p class="small m-0 text-muted">à Moi</p>
													</div>
												</div>
												<div class="thumb-box mb-3" style="height: 140px;">
													<img src=<?= $groupe['images'][1] ?? $groupe['images'][0] ?? "https://placehold.co/120x120?text=Gmail+Attachment" ?> alt="placeholder">
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
												<div class="d-flex align-items-center mb-1">
													<i class="fa fa-bars text-muted"></i>
													<img alt="google" height="24" class="mx-auto" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+PHN2ZyBoZWlnaHQ9IjkyIiB2aWV3Qm94PSIwIDAgMjcyIDkyIiB3aWR0aD0iMjcyIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciPjxwYXRoIGQ9Ik0xMTUuNzUgNDcuMThjMCAxMi43Ny05Ljk5IDIyLjE4LTIyLjI1IDIyLjE4cy0yMi4yNS05LjQxLTIyLjI1LTIyLjE4QzcxLjI1IDM0LjMyIDgxLjI0IDI1IDkzLjUgMjVzMjIuMjUgOS4zMiAyMi4yNSAyMi4xOHptLTkuNzQgMGMwLTcuOTgtNS43OS0xMy40NC0xMi41MS0xMy40NFM4MC45OSAzOS4yIDgwLjk5IDQ3LjE4YzAgNy45IDUuNzkgMTMuNDQgMTIuNTEgMTMuNDRzMTIuNTEtNS41NSAxMi41MS0xMy40NHoiIGZpbGw9IiNFQTQzMzUiLz48cGF0aCBkPSJNMTYzLjc1IDQ3LjE4YzAgMTIuNzctOS45OSAyMi4xOC0yMi4yNSAyMi4xOHMtMjIuMjUtOS40MS0yMi4yNS0yMi4xOGMwLTEyLjg1IDkuOTktMjIuMTggMjIuMjUtMjIuMThzMjIuMjUgOS4zMiAyMi4yNSAyMi4xOHptLTkuNzQgMGMwLTcuOTgtNS43OS0xMy40NC0xMi41MS0xMy40NHMtMTIuNTEgNS40Ni0xMi41MSAxMy40NGMwIDcuOSA1Ljc5IDEzLjQ0IDEyLjUxIDEzLjQ0czEyLjUxLTUuNTUgMTIuNTEtMTMuNDR6IiBmaWxsPSIjRkJCQzA1Ii8+PHBhdGggZD0iTTIwOS43NSAyNi4zNHYzOS44MmMwIDE2LjM4LTkuNjYgMjMuMDctMjEuMDggMjMuMDctMTAuNzUgMC0xNy4yMi03LjE5LTE5LjY2LTEzLjA3bDguNDgtMy41M2MxLjUxIDMuNjEgNS4yMSA3Ljg3IDExLjE3IDcuODcgNy4zMSAwIDExLjg0LTQuNTEgMTEuODQtMTN2LTMuMTloLS4zNGMtMi4xOCAyLjY5LTYuMzggNS4wNC0xMS42OCA1LjA0LTExLjA5IDAtMjEuMjUtOS42Ni0yMS4yNS0yMi4wOSAwLTEyLjUyIDEwLjE2LTIyLjI2IDIxLjI1LTIyLjI2IDUuMjkgMCA5LjQ5IDIuMzUgMTEuNjggNC45NmguMzR2LTMuNjFoOS4yNXptLTguNTYgMjAuOTJjMC03LjgxLTUuMjEtMTMuNTItMTEuODQtMTMuNTItNi43MiAwLTEyLjM1IDUuNzEtMTIuMzUgMTMuNTIgMCA3LjczIDUuNjMgMTMuMzYgMTIuMzUgMTMuMzYgNi42MyAwIDExLjg0LTUuNjMgMTEuODQtMTMuMzZ6IiBmaWxsPSIjNDI4NUY0Ii8+PHBhdGggZD0iTTIyNSAzdjY1aC05LjVWM2g5LjV6IiBmaWxsPSIjMzRBODUzIi8+PHBhdGggZD0iTTI2Mi4wMiA1NC40OGw3LjU2IDUuMDRjLTIuNDQgMy42MS04LjMyIDkuODMtMTguNDggOS44My0xMi42IDAtMjIuMDEtOS43NC0yMi4wMS0yMi4xOCAwLTEzLjE5IDkuNDktMjIuMTggMjAuOTItMjIuMTggMTEuNTEgMCAxNy4xNCA5LjE2IDE4Ljk4IDE0LjExbDEuMDEgMi41Mi0yOS42NSAxMi4yOGMyLjI3IDQuNDUgNS44IDYuNzIgMTAuNzUgNi43MiA0Ljk2IDAgOC40LTIuNDQgMTAuOTItNi4xNHptLTIzLjI3LTcuOThsMTkuODItOC4yM2MtMS4wOS0yLjc3LTQuMzctNC43LTguMjMtNC43LTQuOTUgMC0xMS44NCA0LjM3LTExLjU5IDEyLjkzeiIgZmlsbD0iI0VBNDMzNSIvPjxwYXRoIGQ9Ik0zNS4yOSA0MS40MVYzMkg2N2MuMzEgMS42NC40NyAzLjU4LjQ3IDUuNjggMCA3LjA2LTEuOTMgMTUuNzktOC4xNSAyMi4wMS02LjA1IDYuMy0xMy43OCA5LjY2LTI0LjAyIDkuNjZDMTYuMzIgNjkuMzUuMzYgNTMuODkuMzYgMzQuOTEuMzYgMTUuOTMgMTYuMzIuNDcgMzUuMy40N2MxMC41IDAgMTcuOTggNC4xMiAyMy42IDkuNDlsLTYuNjQgNi42NGMtNC4wMy0zLjc4LTkuNDktNi43Mi0xNi45Ny02LjcyLTEzLjg2IDAtMjQuNyAxMS4xNy0yNC43IDI1LjAzIDAgMTMuODYgMTAuODQgMjUuMDMgMjQuNyAyNS4wMyA4Ljk5IDAgMTQuMTEtMy42MSAxNy4zOS02Ljg5IDIuNjYtMi42NiA0LjQxLTYuNDYgNS4xLTExLjY1bC0yMi40OS4wMXoiIGZpbGw9IiM0Mjg1RjQiLz48L3N2Zz4=">
												</div>
												<div class="d-flex justify-content-between align-items-center border rounded-pill w-100 px-2 py-1">
													<i class="fa fa-search"></i>
													<img height="20" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+PHN2ZyBpZD0iQ2FwYV8xIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxNTAgMTUwOyIgdmVyc2lvbj0iMS4xIiB2aWV3Qm94PSIwIDAgMTUwIDE1MCIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+PHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbDojMUE3M0U4O30KCS5zdDF7ZmlsbDojRUE0MzM1O30KCS5zdDJ7ZmlsbDojNDI4NUY0O30KCS5zdDN7ZmlsbDojRkJCQzA0O30KCS5zdDR7ZmlsbDojMzRBODUzO30KCS5zdDV7ZmlsbDojNENBRjUwO30KCS5zdDZ7ZmlsbDojMUU4OEU1O30KCS5zdDd7ZmlsbDojRTUzOTM1O30KCS5zdDh7ZmlsbDojQzYyODI4O30KCS5zdDl7ZmlsbDojRkJDMDJEO30KCS5zdDEwe2ZpbGw6IzE1NjVDMDt9Cgkuc3QxMXtmaWxsOiMyRTdEMzI7fQoJLnN0MTJ7ZmlsbDojRjZCNzA0O30KCS5zdDEze2ZpbGw6I0U1NDMzNTt9Cgkuc3QxNHtmaWxsOiM0MjgwRUY7fQoJLnN0MTV7ZmlsbDojMzRBMzUzO30KCS5zdDE2e2NsaXAtcGF0aDp1cmwoI1NWR0lEXzJfKTt9Cgkuc3QxN3tmaWxsOiMxODgwMzg7fQoJLnN0MTh7b3BhY2l0eTowLjI7ZmlsbDojRkZGRkZGO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MTl7b3BhY2l0eTowLjM7ZmlsbDojMEQ2NTJEO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MjB7Y2xpcC1wYXRoOnVybCgjU1ZHSURfNF8pO30KCS5zdDIxe29wYWNpdHk6MC4zO2ZpbGw6dXJsKCNfNDVfc2hhZG93XzFfKTtlbmFibGUtYmFja2dyb3VuZDpuZXcgICAgO30KCS5zdDIye2NsaXAtcGF0aDp1cmwoI1NWR0lEXzZfKTt9Cgkuc3QyM3tmaWxsOiNGQTdCMTc7fQoJLnN0MjR7b3BhY2l0eTowLjM7ZmlsbDojMTc0RUE2O2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MjV7b3BhY2l0eTowLjM7ZmlsbDojQTUwRTBFO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0MjZ7b3BhY2l0eTowLjM7ZmlsbDojRTM3NDAwO2VuYWJsZS1iYWNrZ3JvdW5kOm5ldyAgICA7fQoJLnN0Mjd7ZmlsbDp1cmwoI0ZpbmlzaF9tYXNrXzFfKTt9Cgkuc3QyOHtmaWxsOiNGRkZGRkY7fQoJLnN0Mjl7ZmlsbDojMEM5RDU4O30KCS5zdDMwe29wYWNpdHk6MC4yO2ZpbGw6IzAwNEQ0MDtlbmFibGUtYmFja2dyb3VuZDpuZXcgICAgO30KCS5zdDMxe29wYWNpdHk6MC4yO2ZpbGw6IzNFMjcyMztlbmFibGUtYmFja2dyb3VuZDpuZXcgICAgO30KCS5zdDMye2ZpbGw6I0ZGQzEwNzt9Cgkuc3QzM3tvcGFjaXR5OjAuMjtmaWxsOiMxQTIzN0U7ZW5hYmxlLWJhY2tncm91bmQ6bmV3ICAgIDt9Cgkuc3QzNHtvcGFjaXR5OjAuMjt9Cgkuc3QzNXtmaWxsOiMxQTIzN0U7fQoJLnN0MzZ7ZmlsbDp1cmwoI1NWR0lEXzdfKTt9Cgkuc3QzN3tmaWxsOiNGQkJDMDU7fQoJLnN0Mzh7Y2xpcC1wYXRoOnVybCgjU1ZHSURfOV8pO2ZpbGw6I0U1MzkzNTt9Cgkuc3QzOXtjbGlwLXBhdGg6dXJsKCNTVkdJRF8xMV8pO2ZpbGw6I0ZCQzAyRDt9Cgkuc3Q0MHtjbGlwLXBhdGg6dXJsKCNTVkdJRF8xM18pO2ZpbGw6I0U1MzkzNTt9Cgkuc3Q0MXtjbGlwLXBhdGg6dXJsKCNTVkdJRF8xNV8pO2ZpbGw6I0ZCQzAyRDt9Cjwvc3R5bGU+PGc+PGcgaWQ9ImcxNzQ4MCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjQ2LjMwMzQsMjM2LjM3ODkpIj48cGF0aCBjbGFzcz0ic3Q2IiBkPSJNLTU3MS4zLTE0Ny4zYzcuOSwwLDE0LjItNi40LDE0LjItMTQuMmwwLTMzLjJjMC03LjktNi40LTE0LjItMTQuMi0xNC4yICAgIGMtNy45LDAtMTQuMiw2LjQtMTQuMiwxNC4ydjMzLjJDLTU4NS41LTE1My43LTU3OS4xLTE0Ny4zLTU3MS4zLTE0Ny4zIiBpZD0icGF0aDE3NDgyIi8+PC9nPjxnIGlkPSJnMTc0ODQiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDY0NS40ODAzLDIzMy4xNDkyKSI+PHBhdGggY2xhc3M9InN0NSIgZD0iTS01NzUuMi0xMjUuNUwtNTc1LjItMTI1LjV2MTQuOWg5LjV2LTE0LjhjLTEuNSwwLjItMy4xLDAuMi00LjcsMC4yICAgIEMtNTcyLjEtMTI1LjEtNTczLjYtMTI1LjItNTc1LjItMTI1LjUiIGlkPSJwYXRoMTc0ODYiLz48L2c+PGcgaWQ9ImcxNzQ4OCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoNjQzLjM4MDksMjM1LjkxMTUpIj48cGF0aCBjbGFzcz0ic3Q5IiBkPSJNLTU4NS4yLTE0NC4xYy00LjItNC4zLTYuOS05LjUtNi45LTE2LjZoLTkuNWMwLDkuNSwzLjcsMTcuMyw5LjcsMjMuM2wwLjEtMC4xICAgIGMwLDAsMCwwLTAuMS0wLjFMLTU4NS4yLTE0NC4xeiIgaWQ9InBhdGgxNzQ5MCIvPjwvZz48ZyBpZD0iZzE3NDkyIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSg2NTAuNDA4MSwyMzguNzkpIj48cGF0aCBjbGFzcz0ic3Q3IiBkPSJNLTU1MS43LTE2My42YzAsMTEuOS0xMC41LDIzLjYtMjMuNywyMy42Yy02LjYsMC0xMi41LTIuNy0xNi44LTdsLTAuMSwwLjFsLTYuNiw2LjYgICAgYzAsMCwwLDAsMC4xLDAuMWM0LjksNC45LDExLjQsOC4yLDE4LjcsOS4zYzEuNiwwLjIsMy4yLDAuNCw0LjgsMC40YzEuNiwwLDMuMiwwLDQuNy0wLjJjMTYuMS0yLjMsMjguNC0xNi4xLDI4LjQtMzIuN0gtNTUxLjd6IiBpZD0icGF0aDE3NDk0Ii8+PC9nPjwvZz48L3N2Zz4=" alt="google-microphone">
												</div>
												<hr class="mb-1 mt-2">
												<p class="small font-weight-bold mb-2">Sponsorisé</p>
												<div class="row no-gutters justify-content-start mb-2">
													<div class="col-auto">
														<img src="https://placehold.co/38x38?text=Favicon" alt="" class="rounded-circle" width="38">
													</div>
													<div class="pl-2 col">
														<p class="m-0">Résidence-Luxe</p>
														<p class="small m-0 text-muted"><?= $groupe['url_site'] ?></p>
													</div>
												</div>

												<p class="text-primary mb-2"><?= $groupe['nom_groupe'] ?></p>
												<p class="small text-muted mb-2"><?= $groupe['descriptions1'] ?></p>

												<span class="border rounded-pill text-primary py-1 px-2 small">Chalets de Luxe</span>
												<span class="border rounded-pill text-primary py-1 px-2 small">Promotions</span>
												<hr>
												<i class="fa fa-phone"></i>
												Appeler le <?= $groupe['téléphone'] ?>
											</div>
										</div>
									</div>

									<!-- Display -->
									<div class="col-auto">
										<div class="phone-frame">
											<div class="screen">
												<div class="thumb-box mb-3" style="height: 140px;">
													<img src=<?= $groupe['images'][2] ?? $groupe['images'][1] ?? $groupe['images'][0] ?? "https://placehold.co/120x120?text=Display" ?> alt="placeholder">
												</div>
												<div class="row no-gutters justify-content-start mb-2">
													<div class="col-auto">
														<img src="https://placehold.co/38x38?text=Favicon" alt="" class="rounded-circle" width="38">
													</div>
													<div class="pl-2 col">
														<p class="m-0">Résidence-Luxe</p>
													</div>
												</div>
												<div class="d-flex justify-content-between">
													<span class="small text-muted">Résidence-Luxe</span>
													<span class="small">
														En savoir plus
														<i class="fa fa-chevron-right"></i>
													</span>
												</div>
												<hr>
											</div>
										</div>
									</div>

									<!-- Discover -->
									<div class="col-auto">
										<div class="phone-frame">
											<div class="screen">
												<div class="row no-gutters justify-content-start mb-3">
													<div class="col-auto">
														<img src="https://placehold.co/38x38?text=Favicon" alt="" class="rounded-circle" width="38">
													</div>
													<div class="pl-2 col">
														<p class="m-0"><?= $groupe['nom_groupe'] ?></p>
														<p class="small m-0 text-muted">Sponsored</p>
													</div>
												</div>
												<div class="thumb-box mb-3" style="height: 220px;">
													<img src=<?= $groupe['images'][3] ?? $groupe['images'][2] ??$groupe['images'][1] ?? $groupe['images'][0] ?? "https://placehold.co/120x120?text=Discovery" ?> alt="placeholder">
													<span class="bg-white position-absolute text-primary" style="right: 2px; top: 2px; padding: 0px 2px;">
														<i class="fa fa-info-circle"></i>
													</span>
												</div>
												<p><?= $groupe['descriptions1'] ?></p>
												<div class="d-flex justify-content-end align-items-center text-muted">
													<i class="far fa-heart mr-4"></i>
													<i class="fa fa-share-square mr-4"></i>
													<i class="fa fa-ellipsis-h"></i>
												</div>
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
								<a class="nav-link py-0" type="button" id="pmax_tab" data-toggle="tab">
									<div class="mockup-icon">
										<img src="https://cdn1.iconfinder.com/data/icons/unicons-line-vol-3/24/graph-bar-256.png" alt="Tout">
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
										<img src="https://ailecs.org/wp-content/uploads/2024/07/web_100dp_33B54D_FILL0_wght400_GRAD0_opsz48.png" alt="Display">
									</div>
									<p class="mockup-label mt-0">Display</p>
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
</div>
