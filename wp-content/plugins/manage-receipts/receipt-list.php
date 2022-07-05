<?php 
$page = (isset($_GET['index'])) ? intval($_GET['index']) : 1; 
$number = (isset($_GET['number'])) ? intval($_GET['number']) : 50;
$date = (isset($_GET['date'])) ? $_GET['date'] : '';
$orders_count = wc_orders_count('completed'); 
?>
<div class="manage-receipts list" data-page="<?php echo $page; ?>" data-number="<?php echo $number; ?>" data-date="<?php echo $date; ?>" data-plugin-url="<?php echo plugin_dir_url(__FILE__); ?>">
    <h1>Tickets de caisse</h1>

    <div class="search">
        
        <div class="input clearfix">
            <input type="date" value="<?php echo $date; ?>" />
            <button type="button" class="search-btn btn"><i class="fas fa-search"></i></button>
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
                <th class="number-col">#</th>
                <th>Date</th>
                <th>Montant</th>
                <th>Client attribué</th>
            </thead>
            <tbody>

                <?php 

                    $tomorrow = new DateTime($date.' +1 day');
                    $offset = ($page - 1) * $number;

                    if ($date !== '') {
                        $orders = wc_get_orders(array(
                            'limit'  => -1,
                            'date_paid' => $date,
                            'status' => 'completed',
                            'orderby' => 'eta',
                            'orderby' => 'datepaid',
                            'order' => 'DESC'
                        ));
                    } else {
                        $orders = wc_get_orders(array(
                            'limit'  => $number,
                            'offset' => $offset,
                            'status' => 'completed',
                            'orderby' => 'datepaid',
                            'order' => 'DESC'
                        ));
                    }
                    

                    $nb_pages = ceil($orders_count/$number);
                
                    foreach ($orders as $order) {
                        $customer_id = $order->get_customer_id();
                        if ($customer_id) {
                            $user = get_userdata($customer_id);
                            $user_str = get_user_meta($user->ID, 'firstname', true).' '.get_user_meta($user->ID, 'lastname', true).'<br>('.$user->user_login.')';
                        } else {
                            $user_str = 'Non attribué';
                        }


                        $dt = new DateTime($order->get_date_paid());
                        echo '<tr data-order-id="'.$order->get_id().'" data-date="'.$dt->format('Y-m-d').'" data-time="'.$dt->format('H:i:s').'">
                            <td class="tac action-cell">
                                <div class="action-btn"><i class="fas fa-ellipsis-v"></i></div>
                                <div class="actions">
                                    <div class="action view"><i class="fas fa-eye"></i> Visualiser le ticket</div>
                                    ';
                                    if ($customer_id) {
                                        echo '<div class="action attribute" style="display: none;"><i class="fas fa-user-plus"></i> Affecter à un client</div>';
                                        echo '<div class="action disattribute" style="display: block;"><i class="fas fa-user-minus"></i> Désaffecter le client</div>';

                                    } else {
                                        echo '<div class="action attribute" style="display: block;"><i class="fas fa-user-plus"></i> Affecter à un client</div>';
                                        echo '<div class="action disattribute" style="display: none;"><i class="fas fa-user-minus"></i> Désaffecter le client</div>';

                                    }
                                    echo '<div class="action delivering"><i class="fas fa-truck"></i> Associer à un BL</div>
                                    <div class="action export-accounting"><i class="fas fa-calculator"></i> Export comptable</div>
                                    <div class="action export-pdf"><i class="fas fa-file-pdf"></i> Exporter en PDF</div>
                                    <div class="action export-excel"><i class="fas fa-file-excel"></i> Exporter en Excel</div>
                                </div>
                            </td>
                            <td class="tac"><a href="./admin.php?page=manage_receipts&feature=view_receipt&id='.$order->get_id().'">'.$order->get_meta('receipt_no').'</a></td>
                            <td class="tac">'.$dt->format('d/m/Y H:i:s').'</td>
                            <td class="tac '.(($order->get_total() < 0) ? 'red' : 'green').'">'.$order->get_total().'€</td>
                            <td class="tac user">'.$user_str.'</td>
                            
                        </tr>';
                    }

                ?>
            </tbody>
        </table>
    </div>
    <?php if ($date === ''): ?>
        <div class="pager">
            <?php if ($page > 1): ?>
                <a href="./admin.php?page=manage_receipts&index=<?php echo ($page-1); ?>&number=<?php echo ($number); ?>&date=<?php echo $date; ?>"><</a>
            <?php endif; ?>

            <?php
                if ($nb_pages > 1) {
                    for($i = 1; $i < $page; $i++) {
                        if ($page <= 5) { 
                            echo '<a href="./admin.php?page=manage_receipts&index='.$i.'&number='.$number.'&date='.$date.'" class="page">'.$i.'</a>';
                        } else{
                            if ($i == 1 || $i >= $page-3) {
                                echo '<a href="./admin.php?page=manage_receipts&index='.$i.'&number='.$number.'&date='.$date.'" class="page">'.$i.'</a>';
                                if ($i==1) echo '<span>...</span>';
                            }
                        }
                    }
                    echo '<a href="./admin.php?page=manage_receipts&index='.$page.'&number='.$number.'&date='.$date.'" class="page active">'.$page.'</a>';
                    for($i = $page+1; $i <= $nb_pages; $i++) {
                        if ($nb_pages - $page <= 5) { 
                            echo '<a href="./admin.php?page=manage_receipts&index='.$i.'&number='.$number.'&date='.$date.'" class="page">'.$i.'</a>';
                        } else {
                            if ($i == $nb_pages || $i <= $page+3) {
                                if ($i==$nb_pages) echo '<span>...</span>';
                                echo '<a href="./admin.php?page=manage_receipts&index='.$i.'&number='.$number.'&date='.$date.'" class="page">'.$i.'</a>';
                            }
                        }
                    }
                }
            ?>

            <?php if ($nb_pages > 1 && $page < $nb_pages): ?>
                <a href="./admin.php?page=manage_receipts&index=<?php echo ($page+1); ?>&number=<?php echo ($number); ?>&date=<?php echo $date; ?>">></a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
</div>

<?php get_template_part('template-parts/modals/client-selection'); ?>