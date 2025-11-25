<style>
/* Style des labels */
.nav-label {
    color: #282a2c !important;
}

/* Décalage des liens */
.nav-link {
    margin-left: 20px;
}

/* Fond blanc pour l'élément actif */
.nav-item.active {
    background-color: #ffffff;
}

/* Texte actif */
.nav-item.active .nav-link {
    color: #282a2c !important;
}

/* Ajout d'un léger arrondi */
.nav-item.rounded {
    border-radius: 6px;
    margin-bottom: 5px;
}

/* Image dans les liens */
.nav-link img {
    vertical-align: middle;
}
</style>

<nav id="sidebarMenu" class="col-auto p-0 d-md-block bg-light sidebar collapse border-right h-100" style="width: 250px;">
    <a class="navbar-brand d-flex align-items-center justify-content-center p-0 m-0 border-bottom" href="#" style="height: 72px;">
        <img class="logo-full" src="<?= base_url('assets/images/figma/logo_adsrank.png') ?>" alt="" height="30">
        <img class="logo-split d-none" src="<?= base_url('assets/images/figma/logo_split.png') ?>" alt="" style="width: 30px;">
    </a>
    <div class="sidebar-sticky">
        <ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">  
            <li class="nav-item rounded <?= ($this->uri->segment(1) == "Dashboard") ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('Dashboard'); ?>">
                    <span class="nav-label" style="margin-left: 0px;">Tableau de bord</span>
                </a>
            </li>
        </ul>

        <ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
            <h6 class="sidebar-heading nav-label text-muted font-weight-light ml-3"><b>Client</b></h6>
            
            <li class="nav-item rounded <?= ($this->uri->segment(1) == "Onboarding") ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('Onboarding') ?>">
                    <img class="mr-2" src="<?= base_url('assets/images/ico/icone/Stack.png') ?>" />
                    <span class="nav-label">Onboarding</span>
                </a>
            </li>

            <li class="nav-item rounded <?= ($this->uri->segment(1) == "Client") ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('Client') ?>">
                    <img class="mr-2" src="<?= base_url('assets/images/ico/icone/Users.png') ?>" />
                    <span class="nav-label">Vue Clients</span>
                </a>
            </li>

            <li class="nav-item rounded <?= ($this->uri->segment(1) == "Task") ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('Task') ?>">
                    <img class="mr-2" src="<?= base_url('assets/images/ico/icone/CalendarPlus.png') ?>" />
                    <span class="nav-label">Tâches</span>
                </a>
            </li>

            <li class="nav-item rounded <?= ($this->uri->segment(1) == "Notes") ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('Notes') ?>">
                    <img class="mr-2" src="<?= base_url('assets/images/ico/icone/PencilLine.png') ?>" />
                    <span class="nav-label">Notes</span>
                </a>
            </li>

            <li class="nav-item rounded <?= ($this->uri->segment(1) == "Discussion") ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('Discussion'); ?>">
                    <img class="mr-2" src="<?= base_url('assets/images/ico/icone/Stack.png') ?>" />
                    <span class="nav-label">Discussions</span>
                </a>
            </li>

            <li class="nav-item rounded <?= ($this->uri->segment(1) == "Gtm") ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('Gtm') ?>">
                    <img class="mr-2" src="<?= base_url('assets/images/ico/icone/ChatCircleText.png') ?>" />
                    <span class="nav-label">Suivi GTM</span>
                </a>
            </li>

            <li class="nav-item rounded <?= ($this->uri->segment(1) == "Upsell") ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('Upsell') ?>">
                    <img class="mr-2" src="<?= base_url('assets/images/ico/icone/CurrencyEur.png') ?>" />
                    <span class="nav-label">Suivi Budget</span>
                </a>
            </li>
            <li class="nav-item rounded <?= ($this->uri->segment(1) == "Lookerstudio") ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('Lookerstudio') ?>">
                    <img class="mr-2" src="<?= base_url('assets/images/ico/icone/ChartLineUp.png') ?>" />
                    <span class="nav-label">Looker Studio</span>
                </a>
            </li>
        </ul>

        <ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
            <h6 class="sidebar-heading nav-label text-muted font-weight-light ml-3">Planification</h6>
            <li class="nav-item rounded <?= ($this->uri->segment(1) == "Calendar") ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('Calendar'); ?>">
                    <img class="mr-2" src="<?= base_url('assets/images/ico/icone/CalendarPlus.png') ?>" />
                    <span class="nav-label">Calendrier</span>
                </a>
            </li>
        </ul>

        <ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
            <h6 class="sidebar-heading nav-label text-muted font-weight-light ml-3">Ressources humaines</h6>
            <li class="nav-item rounded <?= ($this->uri->segment(1) == "Conges") ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('Conges') ?>">
                    <img class="mr-2" src="<?= base_url('assets/images/ico/icone/SuitcaseSimple.png') ?>" />
                    <span class="nav-label">Congés <?php if($nbr_conge_en_cours != 0 && $current_user->tech == 3): ?> (<?php echo $nbr_conge_en_cours; ?>) <?php endif; ?></span>
                </a>
            </li>
        </ul>

        <ul class="nav flex-column pt-4 pb-3 px-2 border-bottom">
            <h6 class="sidebar-heading nav-label text-muted font-weight-light ml-3">Paramètres</h6>
            <li class="nav-item rounded <?= ($this->uri->segment(1) == "Utilisateur") ? 'active' : ''; ?>">
                <a class="nav-link" href="<?= base_url('Utilisateur'); ?>">
                    <img class="mr-2" src="<?= base_url('assets/images/ico/icone/Gear.png') ?>" />
                    <span class="nav-label">Mon profil</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
