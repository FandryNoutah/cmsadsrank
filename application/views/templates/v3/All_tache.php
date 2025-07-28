<?php function compter_jours_ouvres($date_debut, $date_fin = null) {
    // Si aucune date de fin n'est fournie, on prend la date du jour
    if ($date_fin === null) {
        $date_fin = date('Y-m-d');
    }

    $debut = new DateTime($date_debut);
    $fin = new DateTime($date_fin);

    // S'assurer que la date de début est avant la fin
    if ($debut > $fin) {
        [$debut, $fin] = [$fin, $debut];
    }

    $jours_feries = jours_feries_france((int)$debut->format('Y'), (int)$fin->format('Y'));

    $nb_jours_ouvres = 0;

    while ($debut <= $fin) {
        $jour_semaine = $debut->format('N'); // 6 = samedi, 7 = dimanche
        $date_str = $debut->format('Y-m-d');

        if ($jour_semaine < 6 && !in_array($date_str, $jours_feries)) {
            $nb_jours_ouvres++;
        }

        $debut->modify('+1 day');
    }

    return $nb_jours_ouvres;
}

function jours_feries_france($annee_debut, $annee_fin) {
    $jours_feries = [];

    for ($annee = $annee_debut; $annee <= $annee_fin; $annee++) {
        // Jours fériés fixes
        $jours_feries[] = "$annee-01-01"; // Jour de l'an
        $jours_feries[] = "$annee-05-01"; // Fête du Travail
        $jours_feries[] = "$annee-05-08"; // Victoire 1945
        $jours_feries[] = "$annee-07-14"; // Fête nationale
        $jours_feries[] = "$annee-08-15"; // Assomption
        $jours_feries[] = "$annee-11-01"; // Toussaint
        $jours_feries[] = "$annee-11-11"; // Armistice
        $jours_feries[] = "$annee-12-25"; // Noël

        // Jours fériés mobiles (calculés à partir de Pâques)
        $paques = easter_date($annee);
        $jours_feries[] = date('Y-m-d', $paques + 1 * 24 * 3600);   // Lundi de Pâques
        $jours_feries[] = date('Y-m-d', $paques + 39 * 24 * 3600);  // Ascension
        $jours_feries[] = date('Y-m-d', $paques + 50 * 24 * 3600);  // Lundi de Pentecôte
    }

    return $jours_feries;
}

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css') ?>">

<style>
	#tableData td {
		text-align: center;
		/* Centre le texte horizontalement */
		vertical-align: middle;
		/* Centre le contenu verticalement */
	}

	/* Assurez-vous que Select2 prend toute la largeur du modal */
	#upsell_client {
		z-index: 9999;
	}

	.table-striped tbody tr:nth-of-type(2n+1) {
		background-color: white;
	}
    .board {
  display: flex;
  flex-wrap: nowrap;
  overflow-x: auto;
  padding: 20px;
  gap: 10px;
}
.column {
  background-color: #F3F3F3;
  padding: 10px;
  border-radius: 8px;
  width: 400px;
  min-height: 500px;
  flex-shrink: 0;
}
.column h2 {
  text-align: center;
  font-size: 16px;
}
.task {
  background-color: white;
  margin: 10px 0;
  padding: 10px;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.plus-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 50%;
  width: 25px;
  height: 25px;
  font-size: 18px;
  cursor: pointer;
}
.popup-overlay {
  display: none;
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.5);
  justify-content: center;
  align-items: center;
  z-index: 9999;
}
.popup {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 300px;
  max-width: 90%;
  box-shadow: 0 0 10px rgba(0,0,0,0.3);
}
.popup h3 {
  margin-top: 0;
}
.popup button {
  margin-top: 10px;
  background: #dc3545;
  color: white;
  border: none;
  padding: 5px 10px;
  border-radius: 4px;
  cursor: pointer;
}

</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> -->

<?php if ($this->session->flashdata('message-succes')): ?>
	<div class="alert alert-success alert-dismissible fade in mb-2" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>Succès!</strong> <?php echo $this->session->flashdata("message-succes"); ?>
	</div>
<?php endif; ?>
<div id="messageBox" style="display: none; padding: 10px; margin-top: 20px; border-radius: 5px;  background-color: #6CF5C2! important;"></div>

<div class="row">
	<div class="col-lg-12">
		<div class="card">

			<div class="card-header">
				<h4 class="card-title">Gestion des tâches<span id="countItem"><?php  ?></span></h4>
			</div>
            
            <br>

            <div class="card-body">
    <div class="row">
        
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            <form method="get" action="" style="margin-right: 20px;" class="form-inline d-flex justify-content-end">
                <div style="margin-right: 10px;">
                    <label for="am_filter"><b>Filtrer par AM :</b></label>
                    <select name="am_filter" id="am_filter" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Tous les AM --</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= htmlspecialchars($user['first_name']) ?>"
                                <?= (isset($_GET['am_filter']) && $_GET['am_filter'] === $user['first_name']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($user['first_name']) ?> <?= htmlspecialchars($user['last_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="margin-left: 10px;">
                    <label for="date_start"><b>Du :</b></label>
                    <input type="date" name="date_start" id="date_start" class="form-control"
                        value="<?= isset($_GET['date_start']) ? htmlspecialchars($_GET['date_start']) : '' ?>"
                        onchange="this.form.submit()">
                </div>
                <div style="margin-left: 10px;">
                    <label for="date_end"><b>Au :</b></label>
                    <input type="date" name="date_end" id="date_end" class="form-control"
                        value="<?= isset($_GET['date_end']) ? htmlspecialchars($_GET['date_end']) : '' ?>"
                        onchange="this.form.submit()">
                </div>
            </form>
        </div>
    </div>

    <?php
    $am_filter   = $_GET['am_filter']   ?? '';
    $date_start  = $_GET['date_start']  ?? '';
    $date_end    = $_GET['date_end']    ?? '';

    // Liste des champs de date à vérifier
    $date_fields = ['Brief', 'validation_technique', 'date_validation_structure'];

    function passes_filters($cna, $am_filter, $date_start, $date_end, $date_fields) {
        $am_ok = empty($am_filter) || $cna->am_first_name === $am_filter;

        // Si les deux dates sont vides, on ne filtre pas par date
        if (empty($date_start) && empty($date_end)) {
            return $am_ok;
        }

        foreach ($date_fields as $field) {
            if (empty($cna->$field) || $cna->$field === '0000-00-00') {
                continue;
            }

            $date = substr($cna->$field, 0, 10);

            if (
                (empty($date_start) || $date >= $date_start) &&
                (empty($date_end)   || $date <= $date_end)
            ) {
                return $am_ok; // date OK et AM OK
            }
        }

        return false; // aucune date ne tombe dans l'intervalle
    }
    ?>

    <div class="board">
        <!-- Colonne BRIEF -->
          <?php if( $current_user->tech == 3): ?>
        <div class="column">
            <h2>Brief en cours</h2><br>
            <?php foreach ($Campgagne_non_actif as $cna): ?>
                <?php if (!passes_filters($cna, $am_filter, $date_start, $date_end, ['Brief'])) continue; ?>
                <a href="<?= base_url('Googleads/Admin_brief/' . $cna->idclients); ?>">
                    <div class="task">
                        <b><?= $cna->nom_client; ?></b><br>
                        <p style="font-size: 12px;">
                            En attente de brief
                            <img width="10%" style="margin-top: -2px; margin-left: 55px;"
                                src="<?= base_url("assets/images/ico/danger.jpg"); ?>" alt="Danger">
                            <br>Date brief : <?= substr($cna->Brief, 0, 10); ?>
                        </p>
                        <p><b>AM :</b> <img src="<?= base_url(IMAGES_PATH . htmlspecialchars($cna->am_photo_user)); ?>"
                            style="width: 20px;" class="avatar-image"></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
  <?php endif; ?>
        <!-- Colonne CRÉATION ANNONCE -->
         <?php if( $current_user->tech  == 1): ?>
        <div class="column">
            <h2>Création annonce</h2><br>
            <?php foreach ($Campgagne_en_attente_envoye as $cna): ?>
                

                <?php if (!passes_filters($cna, $am_filter, $date_start, $date_end, ['validation_technique', 'date_validation_structure'])) continue; ?>
                <?php if ($cna->validation_technique === '0000-00-00' || $cna->date_validation_structure === '0000-00-00'): ?>
                    <div class="task">
                        <b><?= $cna->nom_client; ?></b><br>
                        <?php
$date_validation = substr($cna->date_validation_structure, 0, 10); // ex. "2025-07-24"
$aujourdhui = date('Y-m-d');

if ($date_validation < $aujourdhui) {
    echo "La date est passée";
} else {
    $jours_ouvres = compter_jours_ouvres($aujourdhui, $date_validation);
    echo "J-" . $jours_ouvres;
}
?>

                        <p style="font-size: 12px;">
                            

                            <?php if ($cna->date_validation_structure === '0000-00-00'): ?>
                                <img width="10%" src="<?= base_url("assets/images/ico/danger.jpg"); ?>" alt="Danger"> Validation : Non défini<br>
                            <?php else: ?>
                                <img width="4%" src="<?= base_url("assets/images/ico/check.jpg"); ?>" alt="Check"> Validation :
                                <?= substr($cna->date_validation_structure, 0, 10); ?><br>
                            <?php endif; ?>
                        </p>
                        <p><b>AM :</b> <img src="<?= base_url(IMAGES_PATH . htmlspecialchars($cna->am_photo_user)); ?>"
                            style="width: 20px;" class="avatar-image"></p>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>  
        <?php if( $current_user->tech  == 3): ?>                      
        <!-- Colonne VALIDATION CLIENT -->
        <div class="column">
            <h2>Validation Client</h2><br>
            <?php foreach ($Campgagne_en_attente_envoye as $cna): ?>
                <?php if (!passes_filters($cna, $am_filter, $date_start, $date_end, ['validation_technique', 'date_validation_structure'])) continue; ?>
                <?php if ($cna->validation_technique !== '0000-00-00' && $cna->date_validation_structure !== '0000-00-00'): ?>
                    <div class="task">
                        <b><?= $cna->nom_client; ?></b><br>
                        <p style="font-size: 12px;">
                            <img width="8%" src="<?= base_url("assets/images/ico/check.jpg"); ?>" alt="Check"> Tech :
                            <?= substr($cna->validation_technique, 0, 10); ?><br>
                            <img width="8%" src="<?= base_url("assets/images/ico/check.jpg"); ?>" alt="Check"> Validation :
                            <?= substr($cna->date_validation_structure, 0, 10); ?><br>
                        </p>
                        <p><b>AM :</b> <img src="<?= base_url(IMAGES_PATH . htmlspecialchars($cna->am_photo_user)); ?>"
                            style="width: 20px;" class="avatar-image"></p>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <!-- Autres colonnes -->
        <div class="column"><h2>Mise en ligne</h2></div>

        
    </div>
</div>



        </div>
    </div>
</div>












<div class="modal fade text-xs-left" id="inlineNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="padding: 20px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title text-text-bold-300" id="myModalLabel33">Créer Upsell - Baisse</h2>
            </div>
            <div id="modal-form-new">
                <form action="<?php echo base_url("Upsell/creer_upsell") ?>" enctype="multipart/form-data" method="post" id="majCampagne">
                    <fieldset>
                        <input type="hidden" class="form-control" name="demmande_upsell" value="<?php echo $current_user->id; ?>">

                        
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade text-xs-left" id="inlineNew1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="padding: 20px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h2 class="modal-title text-text-bold-300" id="myModalLabel33">Tâche GTM</h2>
            </div>
            <div id="modal-form-new">
                <form action="<?php echo base_url("Upsell/creer_upsell") ?>" enctype="multipart/form-data" method="post" id="majCampagne">
                    <fieldset>
                        <input type="hidden" class="form-control" name="demmande_upsell" value="<?php echo $current_user->id; ?>">

                        
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>