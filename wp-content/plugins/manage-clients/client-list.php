<?php 
$page = (isset($_GET['index'])) ? intval($_GET['index']) : 1; 
$number = (isset($_GET['number'])) ? intval($_GET['number']) : 10;
$search = (isset($_GET['search'])) ? $_GET['search'] : '';
?>


<div class="manage-clients list" data-page="<?php echo $page; ?>" data-number="<?php echo $number; ?>" data-search="<?php echo $search; ?>">
    <h1>Clients</h1>

    <div class="search">
        <div class="input clearfix">
            <input type="text" placeholder="Rechercher un client..."> <button type="button" class="search-btn btn"><i class="fas fa-search"></i></button>
        </div>

        <select name="number" class="number">
            <option value="5" <?php echo ($number == 5) ? 'selected' : ''; ?>>5</option>
            <option value="10" <?php echo ($number == 10) ? 'selected' : ''; ?>>10</option>
            <option value="20" <?php echo ($number == 20) ? 'selected' : ''; ?>>20</option>
            <option value="50" <?php echo ($number == 50) ? 'selected' : ''; ?>>50</option>
            <option value="100" <?php echo ($number == 100) ? 'selected' : ''; ?>>100</option>
        </select>
    </div>


    <div class="outer">
        <table>
            <thead>
                <th class="action-col">Actions</th>
                <th class="id-col">ID</th>
                <th>Nom Prénom</th>
                <th>Email</th>
            </thead>
            <tbody>
                <?php 

                    $offset = ($page - 1) * $number;

                    if ($search !== '') {
                        $user_query = new WP_User_Query(array(
                            'orderby' => 'display_name',
                            'number'  => $number,
                            'offset' => $offset,
                            'role' => 'customer',
                            'search'         => '*'.esc_attr($search).'*',
                            'search_columns' => array(
                                'user_login',
                                'user_display_name',
                                'user_email',
                                'user_url',
                            ),
                        )); 
                    } else {
                        $user_query = new WP_User_Query(array(
                            'orderby' => 'display_name',
                            'number'  => $number,
                            'offset' => $offset,
                            'role' => 'customer'
                        ));
                    }
  

                    $total_users = $user_query->total_users;  
                    $nb_pages = ceil($total_users/$number);

                    foreach ($user_query->get_results() as $user) {
                        echo '<tr data-user-id="'.$user->ID.'">
                            <td class="tac action-cell">
                                <div class="action-btn"><i class="fas fa-ellipsis-v"></i></div>
                                <div class="actions">
                                    <div class="action dashboard" data-feature="dashboard"><i class="fas fa-columns"></i> Voir tableau de bord</div>
                                    <div class="action dressing" data-feature="dressing"><i class="fas fa-eye"></i> Voir dressing</div>
                                    <div class="action services" data-feature="services"><i class="fas fa-hand-holding"></i> Voir les services</div>
                                    <div class="action looks" data-feature="looks"><i class="fas fa-tshirt"></i> Proposer un look</div>
                                    <div class="action measurement" data-feature="measurement"><i class="fas fa-ruler"></i> Voir les mensurations</div>
                                    <div class="action informations" data-feature="informations"><i class="fas fa-heart"></i> Voir les préférences</div>
                                    <div class="action notes" data-feature="notes"><i class="fas fa-sticky-note"></i> Voir les notes</div>
                                </div>
                            </td>
                            <td class="tac">'.$user->user_login.'</td>
                            <td class="tac"><a href="./admin.php?page=manage_clients&feature=dashboard&user_id='.$user->ID.'">'.get_user_meta($user->ID, 'lastname', true).' '.get_user_meta($user->ID, 'firstname', true).'</a></td>
                            <td class="tac">'.$user->user_email.'</td>
                        </tr>';
                    }

                ?>
            </tbody>
        </table>
    </div>
    <?php if ($search === ''): ?>
        <div class="pager">
            <?php if ($page > 1): ?>
                <a href="./admin.php?page=manage_clients&index=<?php echo ($page-1); ?>&number=<?php echo $number; ?>&search=<?php echo $search; ?>"><</a>
            <?php endif; ?>
            <?php
                if ($nb_pages > 1) {
                    for($i = 1; $i < $page; $i++) {
                        if ($page <= 5) { 
                            echo '<a href="./admin.php?page=manage_clients&index='.$i.'&number='.$number.'&search='.$search.'" class="page">'.$i.'</a>';
                        } else{
                            if ($i == 1 || $i >= $page-3) {
                                echo '<a href="./admin.php?page=manage_clients&index='.$i.'&number='.$number.'&search='.$search.'" class="page">'.$i.'</a>';
                                if ($i==1) echo '<span>...</span>';
                            }
                        }
                    }
                    echo '<a href="./admin.php?page=manage_clients&index='.$page.'&number='.$number.'&search='.$search.'" class="page active">'.$page.'</a>';
                    for($i = $page+1; $i <= $nb_pages; $i++) {
                        if ($nb_pages - $page <= 5) { 
                            echo '<a href="./admin.php?page=manage_clients&index='.$i.'&number='.$number.'&search='.$search.'" class="page">'.$i.'</a>';
                        } else {
                            if ($i == $nb_pages || $i <= $page+3) {
                                if ($i==$nb_pages) echo '<span>...</span>';
                                echo '<a href="./admin.php?page=manage_clients&index='.$i.'&number='.$number.'&search='.$search.'" class="page">'.$i.'</a>';
                            }
                        }
                    }
                }
            ?>
            <?php if ($nb_pages > 1 && $page < $nb_pages): ?>
                <a href="./admin.php?page=manage_clients&index=<?php echo ($page+1); ?>&number=<?php echo $number; ?>&search=<?php echo $search; ?>">></a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>