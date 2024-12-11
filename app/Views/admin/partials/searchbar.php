<form class="searchbar">
    <div class="position-absolute top-50 translate-middle-y search-icon ms-3">
        <ion-icon name="search-sharp"></ion-icon>
    </div>
    <input id="global-search" class="form-control" type="text" placeholder="Buscar en <?= esc($moduleName ?? 'datos') ?>">
    <div class="position-absolute top-50 translate-middle-y search-close-icon">
        <ion-icon name="close-sharp"></ion-icon>
    </div>
</form>