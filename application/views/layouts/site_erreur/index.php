<?php start_section('stylesheet'); ?>
<style>
	.table-wrapper {
		border-spacing: 0 15px !important;
		border-collapse: separate !important;
	}

	.table-wrapper td,
	.table-wrapper th {
		vertical-align: middle;
		border-bottom: 1px solid #dee2e6 !important;
	}

	.table-wrapper tbody tr td:first-child,
	.table-wrapper thead tr th:first-child {
		border-left: 1px solid #dee2e6;
		border-top-left-radius: 4px;
		border-bottom-left-radius: 4px;
	}

	.table-wrapper tbody tr td:last-child,
	.table-wrapper thead tr th:last-child {
		border-right: 1px solid #dee2e6;
		border-top-right-radius: 4px;
		border-bottom-right-radius: 4px;
	}

	.table-wrapper th:nth-child(2),
	.table-wrapper td:nth-child(2) {
		width: 15%;
	}

	.table-wrapper th:nth-child(3),
	.table-wrapper td:nth-child(3) {
		width: 10%;
	}

	.table-wrapper th:nth-child(4),
	.table-wrapper td:nth-child(4) {
		width: 15%;
	}

	.table-wrapper th:nth-child(5),
	.table-wrapper td:nth-child(5) {
		width: 10%;
	}

	.table-wrapper th:nth-child(6),
	.table-wrapper td:nth-child(6) {
		width: 15%;
	}

	.budget {
		font-weight: 500;
	}
</style>
<?php end_section(); ?>

<?php start_section('page_title'); ?>
<h1 class="h4">Liste des sites avec erreur</h1>
<?php end_section(); ?>

<?php start_section('page_heading'); ?>

<ul class="nav nav-tabs mr-auto ml-5" role="tablist">
	<div class="col-auto px-1">
    <button id="exportExcelBtn" class="btn btn-dark" type="button">
    <img src="<?= base_url('assets/images/icons/figma/icon-plus.svg') ?>" alt="">
    Mettre à jour
</button>
</div>

</div>

<?php end_section(); ?>

<?php start_section('content'); ?>

<div class="container-fluid">


	<div class="tab-content" id="clientTabContent">

		<div class="tab-pane fade show active mb-5" id="list" role="tabpanel" aria-labelledby="list_tab">
			<div class="table-responsive">
				<table class="table table-wrapper">
					<thead class="bg-light text-muted">
						<tr>
							<th>Client</th>
							<th>site</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($donnee as $d): ?>
							<?php //if ($d->budget != 0): ?>
								<tr class="client-filter">
									<td>
											<?= htmlspecialchars($d->nom_client) ?>
										</a>
									</td>

									<td class="text-muted"><?= $d->site_client ?></td>
									<td class="text-muted"></td>
									
								</tr>
							<?php //endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>

		
														

	</div>
</div>

<?php end_section(); ?>

<?php start_section('script'); ?>
<script>
document.getElementById('exportExcelBtn').addEventListener('click', function () {
    var btn = this;
    btn.disabled = true;
    var original = btn.innerHTML;
    btn.innerHTML = 'Scanning...';

    // Préparer body (CSRF si activé)
    var body = '';
    <?php if ($this->config->item('csrf_protection')): ?>
        body = encodeURIComponent('<?= $this->security->get_csrf_token_name() ?>') + '=' + encodeURIComponent('<?= $this->security->get_csrf_hash() ?>');
    <?php endif; ?>

    fetch('<?= site_url("Site_erreur/update_sites_error") ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        body: body
    }).then(function (resp) {
        // Si status non 200 -> afficher info
        if (!resp.ok) {
            return resp.text().then(function (text) {
                throw { httpStatus: resp.status, bodyText: text };
            });
        }
        // Essayer de parser JSON
        return resp.text().then(function (txt) {
            try {
                return JSON.parse(txt);
            } catch (e) {
                throw { httpStatus: 200, bodyText: txt, parseError: true };
            }
        });
    }).then(function (json) {
        btn.disabled = false;
        btn.innerHTML = original;

        if (!json.success) {
            // Afficher message serveur si fourni
            var msg = json.msg || 'Erreur lors du scan (serveur)';
            alert(msg);
            return;
        }

        // Rafraîchir le tableau pour n'afficher que les sites en erreur
        var erreurs = json.liste_erreurs || [];
        var tbody = document.querySelector('table.table-wrapper tbody');
        tbody.innerHTML = '';

        if (erreurs.length === 0) {
            tbody.innerHTML = '<tr><td colspan="3">Aucun site en erreur.</td></tr>';
            return;
        }

        erreurs.forEach(function (e) {
            var nom = e.nom_client || '';
            var site = e.site_client || '';
            var href = site.match(/^https?:\/\//i) ? site : ('http://' + site);
            var status = e.error_type ? (e.error_type + (e.message ? ' - ' + e.message : '')) : ('HTTP ' + e.http_code);

            var tr = document.createElement('tr');
            tr.className = 'client-filter';
            tr.setAttribute('data-status', '0');

            tr.innerHTML =
                '<td>' + escapeHtml(nom) + '</td>' +
                '<td class="text-muted"><a href="' + escapeAttribute(href) + '" target="_blank" rel="noopener noreferrer">' + escapeHtml(site) + '</a></td>' +
                '<td class="text-danger">' + escapeHtml(status) + '</td>';

            tbody.appendChild(tr);
        });
    }).catch(function (err) {
        btn.disabled = false;
        btn.innerHTML = original;

        // Cas : réponse non-OK (err.httpStatus) ou parse error (err.parseError)
        if (err && err.httpStatus) {
            var info = 'Requête échouée (HTTP ' + err.httpStatus + ').\n';
            if (err.bodyText) info += 'Réponse serveur:\n' + err.bodyText;
            alert(info);
            console.error('Scan error:', err);
            return;
        }

        alert('Erreur réseau: ' + (err.message || err));
        console.error(err);
    });

    function escapeHtml(s) {
        if (!s) return '';
        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }
    function escapeAttribute(s) {
        return escapeHtml(s).replace(/'/g,'&#39;');
    }
});

fetch('<?= site_url("Site_erreur/update_sites_error") ?>', { method: 'POST', headers: {'X-Requested-With':'XMLHttpRequest'} })
  .then(resp => resp.text())
  .then(txt => {
      console.log('RAW RESPONSE:\n', txt);
      try {
          const json = JSON.parse(txt);
          console.log('JSON:', json);
      } catch (e) {
          console.error('JSON parse failed', e);
      }
  }).catch(err => console.error(err));

</script>

<?php end_section(); ?>

