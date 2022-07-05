<h1>Gestion des looks</h1>
<nav class="table">
    <a href="./admin.php?page=manage_looks&category=home" class="td item <?php if (PAGE === 'home') echo 'active'; ?>">Actualités</a>
    <a href="./admin.php?page=manage_looks&category=draft" class="td item <?php if (PAGE === 'draft') echo 'active'; ?>">Mes brouillons</a>
    <a href="./admin.php?page=manage_looks&category=pending" class="td item <?php if (PAGE === 'pending') echo 'active'; ?>">Mes looks en attente</a>
    <a href="./admin.php?page=manage_looks&category=published" class="td item <?php if (PAGE === 'published') echo 'active'; ?>">Mes looks validés</a>
</nav>
<div class="search">
    <div class="fields">
        <input type="text" id="search" placeholder="Rechercher un look...">
    </div>
</div>

<div class="no-result">
    <p>Aucun look trouvé</p>
</div>