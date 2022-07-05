<?php 
$today = new DateTime();
$six_month_ago = new DateTime();
$six_month_ago->modify('-6 month');
?>
<div class="dashboard-page" data-plugin-url="<?php echo plugin_dir_url(__FILE__); ?>">
    <h1>Tableau de bord</h1>
    <div class="dashboard">

        <div class="board-list">
            <div class="board-btn" data-board="seller">Vendeur</div>
            <div class="board-btn active" data-board="sales">Chiffre d'affaire</div>
            <div class="board-btn" data-board="products">Produits</div>
            <div class="board-btn" data-board="clients">Clients</div>
            <div class="board-btn" data-board="human">Ressources humaines</div>
        </div>

        <div class="board" data-board="seller">
            
            <div class="widget">

            </div>
        </div>

        <div class="board active" data-board="sales">


            <div class="widget wide in-progress" id="sales">
                <div class="head">Évolution du chiffre d'affaire / objectif</div>
                <div class="graph-controls">
                    <input type="date" class="start-date" value="<?php echo $six_month_ago->format('Y-m-d'); ?>"> ~ <input type="date" class="end-date" value="<?php echo $today->format('Y-m-d'); ?>"> <button type="button" class="dash-btn search-btn"><i class="fa fa-search"></i></button>
                </div>
                <div class="chart"></div>
            </div>

            <div class="widget wide in-progress" id="sales-category">
                <div class="head">Évolution des ventes par catégorie</div>
                <div class="graph-controls">
                    <input type="date" class="start-date" value="<?php echo $six_month_ago->format('Y-m-d'); ?>"> ~ <input type="date" class="end-date" value="<?php echo $today->format('Y-m-d'); ?>"> <button type="button" class="dash-btn search-btn"><i class="fa fa-search"></i></button>
                </div>
                <div id="sales-category" class="chart"></div>
            </div>

            <div class="widget in-progress" id="sales-category-pie">
                <div class="head">Répartition des ventes par catégorie</div>
                <div class="graph-controls">
                    <input type="date" class="start-date" value="<?php echo $six_month_ago->format('Y-m-d'); ?>"> ~ <input type="date" class="end-date" value="<?php echo $today->format('Y-m-d'); ?>"> <button type="button" class="dash-btn search-btn"><i class="fa fa-search"></i></button>
                </div>
                <div id="sales-category-pie" class="chart"></div>
            </div>

            <div class="widget wide in-progress" id="sales-table">
                <div class="head">Analyse chiffre d'affaire</div>
                <table>
                    <thead></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <div class="board" data-board="products">
            <div class="widget">
                <div class="head">Produits vendus par catégorie</div>
                <div id="pie_chart" style="width: 100%; height: 100%"></div>
            </div>
            <div class="widget">

            </div>
        </div>

        <div class="board" data-board="clients">
            <div class="widget full">
                <div class="head">Analyse clients</div>
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Semaine 1</th>
                            <th>Semaine 2</th>
                            <th>Semaine 3</th>
                            <th>Semaine 4</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Nombre de visiteurs ou nombre de visites total du client</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Nombre de vente (nbr de ticket)</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Nombre de produit vendus</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <th>CA réalisé</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <th>Prix moyen d'un produit vendu</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <th>Nombre de nouveaux clients</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <th>Nombre de clients enregistrés</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <th>Nombre de clients parainnés par ce client</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <th>Nombre de clients contactés</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <th>Nombre de looks proposés</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <th>Nombre de looks acceptés</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <th>Nombre total de réservation</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <th>Nombre de rdv réalisé</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <th>Chiffre d'affaires correspondant au rdv réalisé</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <th>Nombre de réservations annulés</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <th>CA correspondant à l'annulation (perte)</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        
                        <tr>
                            <th>Litiges clients</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="board" data-board="human">
            <div class="widget">

            </div>
            <div class="widget">

            </div>
        </div>

    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>