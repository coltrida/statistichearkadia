<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <form wire:submit.prevent="addActivity">
        <div class="form-group">
            <label for="nomeattivita" class="text-white">Nome attività</label>
            <input type="text" id="nomeattivita" required class="form-control" wire:model.lazy="nomeattivita" aria-describedby="emailHelp">
        </div>

        <div class="row">
            <div class="col-md-4 form-group">
                <label for="costo" class="text-white">Costo</label>
                <input type="number" id="costo" step=0.5 required class="form-control" wire:model.lazy="costo">
            </div>
            <div class="col form-group">
                <label for="tipo" class="text-white">Tipo</label>
                <select id="tipo" class="custom-select" wire:model.lazy="tipo">
                    <option value="mensile">Mensile</option>
                    <option value="orario">Orario</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block">Inserisci</button>
    </form>
</div>
