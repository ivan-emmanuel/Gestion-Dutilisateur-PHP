<div class="row">
		<div class="col-lg-12">

		<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-lg-6">
							<h4>Gestion des utilisateurs</h4>
						</div>
						<div class="col-lg-6 text-right">
                            <?php if( UserIsIn(['admin']) ) : ?>
							<a data-animated-modal href="#creation_modal" class="btn btn-dark"> <i class="fa fa-plus"></i> Ajouter</a>
                            <?php endif; ?>
						</div>
					</div>
				</div>
				<div class="card-body">
					<table class="dataTable table table-striped table-bordered ">
						  <thead>
						    <tr>
						      <th>nom</th>
						      <th>login</th>
						      <th>email</th>
						      <th>creation</th>
						      <th>confirmation</th>
						      <th width="200">Action</th>
						    </tr>
						  </thead>
						  <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td>
                                        <?= $user->name ?>
                                        <span class="badge badge-warning"><?= soft_user_type($user->type) ?></span>
                                    </td>
                                    <td><?= $user->login ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= $user->created_at ?></td>
                                    <td><?= $user->confirmed_at ?></td>
                                    <td>
                                    <?php if ( $user->type !== 'admin' ) : ?>
                                        <?php if( UserIsIn(['admin'])) : ?>
                                            <div class="btn-group">
                                                <a data-animated-modal href="#edition_modal<?= $user->id ?>" class="btn btn-dark"><i class="fa fa-edit"></i>modifier</a>
                                                <a  data-toggle="modal" data-target="#delete_modal<?= $user->id ?>" href="#" class="btn btn-danger"><i class="fa fa-trash"></i>supprimer</a>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
						  </tbody>
						</table>
				</div>
			</div>

	</div>

	</div>


<?php if( in_array(\Application\Auth::getUser()->type,['admin']) ) : ?>
        <?php modal_tags("creation_modal","Ajouter un utilisateur"); ?>
            <form action="" method="post">
                <div class="row">
                    <div class="col-lg-6"><?php  email_field('email','Email de compte utilisateur')  ?></div>
                    <div class="col-lg-6"><?php  text_field('login','Login utilisateur')  ?></div>
                    <div class="col-lg-6"><?php  password_field('password','token de creation')  ?></div>
                    <div class="col-lg-6"><?php  password_field('password_confirmation','Confirmation du token de creation')  ?></div>
                    <div class="col-lg-6"><?php  text_field('name','Nom utilisateur')  ?></div>
                    <div class="col-lg-6">
                        <label for="type">type</label>
                        <select name="type" id="type" class="form-control custom-select">
                            <option value="admin">admin</option>
                            <option value="user">Utilisateur</option>
                        </select>
                    </div>
                </div>
                <div class="form-group"><button class="btn btn-dark" type="submit">Inscrire l'utilisateur</button></div>
            </form>
		<?php close_modal_tags(); ?>

        <?php foreach ($users as $user): ?>
            <?php if ( $user->type != "admin" ) : ?>

                <?php modal_tags("edition_modal{$user->id}","edition de l'utilisateur {$user->name}"); ?>
                <form action="<?= path_for("users.edit",['id'=>$user->id]) ?>" method="post" >
                    <div class="row">
                        <div class="col-lg-6"><?php  text_field('name','Nom utilisateur',$user->name)  ?></div>
                        <div class="col-lg-6">
                            <label for="type">type</label>
                            <select name="type" id="type" class="form-control custom-select">
                                <option value="<?= $user->type ?>"><?= soft_user_type($user->type) ?></option>
                                <option value="admin">admin</option>
                                <option value="user">Utilisateur</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-dark" type="submit">Modifier l'utilisateur <?= $user->name ?></button>
                    </div>
                </form>
                <?php close_modal_tags(); ?>

                <?php bs_modal_tags("delete_modal{$user->id}","Supprimer l'utilisateur {$user->name} "); ?>
                    <p>L'utilisateur <?= $user->name ?> vas etre supprimer </p>
                    <a href="<?= path_for("users.delete",['id'=>$user->id]) ?>" class="btn btn-dark"><i class="fa fa-check"></i>Supprimer</a>
                    <a data-dismiss="modal" href="#" class="btn btn-danger"><i class="fa fa-times"></i>Annuler</a>
                <?php bs_modal_tags_close(); ?>

            <?php endif ?>

        <?php endforeach ?>
<?php endif ?>






