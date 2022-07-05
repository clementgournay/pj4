<div class="my-account-subnav page-<?php echo PAGE; ?>">
    <ul>
        <?php 
            foreach(PAGES as $page=>$item) {
                $active = (PAGE === $page) ? 'class="active"' : '';
                $icon = ($item[1]!=='') ? '<i class="fa fa-'.$item[1].'"></i>' : '';
                echo '<li '.$active.'><a class="no-underline" href="'.get_site_url().'/mon-compte/'.CATEGORY.'/'.$page.'">'.$icon.'<span>'.$item[0].'</span></a></li>';
            }
        ?>
    </ul>
</div>