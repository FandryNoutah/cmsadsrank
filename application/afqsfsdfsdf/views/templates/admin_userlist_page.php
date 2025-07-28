<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Utilisateurs</h4>
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
                <div class="card-block card-dashboard"></div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Société</th>
                                <th>Téléphone</th>
                                <th>Groupes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user):?>
                            <tr>
                                <th scope="row"><?php echo htmlspecialchars($user->id,ENT_QUOTES,'UTF-8');?></th>
                                <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($user->username,ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($user->company,ENT_QUOTES,'UTF-8');?></td>
                                <td><?php echo htmlspecialchars($user->phone,ENT_QUOTES,'UTF-8');?></td>
                                <td>
                                	<?php foreach ($user->groups as $group):?>
										<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
					                <?php endforeach?>
									
                                </td>
                                <td>
                                	<?php if ($user->id != 1): ?>
                                	<?php echo anchor("admin/user/edit/".$user->id, '<i class="icon-edit" title="Editer"></i>','data-edit="'.$user->id.'"') ;?>&nbsp;
                                	<?php echo anchor("auth/delete_user/".$user->id, '<i class="icon-android-delete" title="Supprimer"></i>','data-toggle="modal" data-target="#default-'.$user->id.'" onclick="return false;"') ;?>

                                	<div class="modal fade text-xs-left" id="default-<?php echo $user->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
									  <div class="modal-dialog" role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
											<h4 class="modal-title" id="myModalLabel1">Confirmation</h4>
										  </div>
										  <div class="modal-body">
											<p>Voulez-vous vraiment supprimer l'utilisateur <b><?php echo $user->first_name . " " . $user->last_name ?></b> ?</p>
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Fermer</button>
											<a href="<?php echo base_url("admin/user/delete/".$user->id) ?>" target="_self" class="btn btn-outline-primary">Supprimer</a>
										  </div>
										</div>
									  </div>
									</div>

                                	<?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                        <tfoot>
                        	<tr>
                        		
                        	</tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <a href="<?php echo base_url("admin/user/create") ?>" target="_self" class="btn btn-success upgrade-to-pro">Ajouter nouvel utilisateur</a>
    </div>
</div>