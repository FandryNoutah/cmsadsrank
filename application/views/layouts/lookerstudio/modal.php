<div class="modal fade" id="rapportmodal" tabindex="-1">
    <div class="modal-dialog" style="max-width: 600px;">
        <div class="modal-content p-3">

            <div class="modal-header">
                <h5 class="modal-title">Modifier les rapports</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form action="<?= base_url("Lookerstudio/update_rapports") ?>" method="post" id="rapportForm">

                <input type="hidden" name="idonnee" id="modal_idonnee">

                <div class="modal-body">

                    <div class="form-group">
                        <label>Rapport</label>
                        <input type="text" class="form-control" name="rapport" id="modal_rapport">
                    </div>

                    <div class="form-group">
                        <label>Rapport Conversions</label>
                        <input type="text" class="form-control" name="rapport_conversions" id="modal_conv">
                    </div>

                    <div class="form-group">
                        <label>Rapport Conv + CA</label>
                        <input type="text" class="form-control" name="rapport_conv_ca" id="modal_convca">
                    </div>

                    <div class="form-group">
                        <label>Bilan</label>
                        <input type="text" class="form-control" name="bilan" id="modal_bilan">
                    </div>

                    <div class="text-right">
                        <button class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button class="btn btn-dark" id="submitBtn">
                            Sauvegarder
                            <span id="btnLoader" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // Remplir le modal au clic
    document.querySelectorAll(".open-rapport-modal").forEach(btn => {
        btn.addEventListener("click", function () {
            document.getElementById("modal_idonnee").value = this.dataset.id;
            document.getElementById("modal_rapport").value = this.dataset.rapport;
            document.getElementById("modal_conv").value = this.dataset.conv;
            document.getElementById("modal_convca").value = this.dataset.convca;
            document.getElementById("modal_bilan").value = this.dataset.bilan;
        });
    });

    // Loader bouton + validation http si champ rempli
    const form = document.getElementById("rapportForm");
    const btn = document.getElementById("submitBtn");
    const loader = document.getElementById("btnLoader");

    form.addEventListener("submit", function (e) {
        const inputs = [ "modal_rapport", "modal_conv", "modal_convca", "modal_bilan" ];
        for (let id of inputs) {
            const value = document.getElementById(id).value.trim();
            if (value !== "" && !value.startsWith("http")) {
                alert("Les champs remplis doivent commencer par 'http'.");
                e.preventDefault();
                return;
            }
        }

        // Désactiver bouton et afficher loader
        btn.disabled = true;
        loader.classList.remove("d-none");
    });

});
</script>
