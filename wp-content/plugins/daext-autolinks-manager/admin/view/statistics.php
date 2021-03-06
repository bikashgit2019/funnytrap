<?php

if ( ! current_user_can(get_option($this->shared->get('slug') . '_capabilities_statistics_menu'))) {
    wp_die(esc_attr__('You do not have sufficient permissions to access this page.', 'daam'));
}

?>

<!-- process data -->

<?php

//Get the value of the custom filter
if (isset($_GET['sb'])) {
    $sort_by = $_GET['sb'];
} else {
    $sort_by = false;
}

?>

<!-- output -->

<div class="wrap">

    <div id="daext-header-wrapper" class="daext-clearfix">

        <h2><?php esc_attr_e('Autolinks Manager - Statistics', 'daam'); ?></h2>

        <!-- Search Form -->

        <form action="admin.php" method="get" id="daext-search-form">

            <input type="hidden" name="page" value="daam-statistics">

            <p><?php esc_attr_e('Perform your Search', 'daam'); ?></p>

            <?php
            if (isset($_GET['s']) and mb_strlen(trim($_GET['s'])) > 0) {
                $search_string = $_GET['s'];
            } else {
                $search_string = '';
            }

            //Sort By
            if ($sort_by !== false) {
                echo '<input type="hidden" name="sb" value="' . $sort_by . '">';
            }

            ?>

            <input type="text" name="s" name="s"
                   value="<?php echo esc_attr(stripslashes($search_string)); ?>" autocomplete="off" maxlength="255">
            <input type="submit" value="">

        </form>

        <!-- Filter Form -->

        <form method="GET" action="admin.php" id="daext-sort-form">

            <input type="hidden" name="page" value="<?php echo $this->shared->get('slug'); ?>-statistics">

            <p><?php esc_attr_e('Sort By', 'daam'); ?></p>

            <select id="sb" name="sb" class="daext-display-none">

                <option value="pi" <?php if ($sort_by !== false) {
                    selected($sort_by, 'pi');
                } ?>><?php esc_attr_e('Post Id', 'daam'); ?></option>
                <option value="cl" <?php if ($sort_by !== false) {
                    selected($sort_by, 'cl');
                } ?>><?php esc_attr_e('Content Length', 'daam'); ?></option>
                <option value="al" <?php if ($sort_by !== false) {
                    selected($sort_by, 'al');
                } ?>><?php esc_attr_e('Autolinks', 'daam'); ?></option>
                <option value="alv" <?php if ($sort_by !== false) {
                    selected($sort_by, 'alv');
                } ?>><?php esc_attr_e('Clicks', 'daam'); ?></option>

            </select>

        </form>

    </div>

    <div id="daext-menu-wrapper" class="daext-clearfix">

        <div class="autolinks-container">

            <?php

            //search
            if (isset($_GET['s']) and mb_strlen(trim($_GET['s'])) > 0) {
                $search_string = $_GET['s'];
                global $wpdb;
                $filter = $wpdb->prepare('WHERE (post_id LIKE %s)', '%' . $search_string . '%');
            } else {
                $filter = '';
            }

            //order
            if ($sort_by !== false) {
                global $wpdb;
                switch ($sort_by) {
                    case 'pi':
                        $order = 'post_id DESC';
                        break;
                    case 'cl':
                        $order = 'content_length DESC';
                        break;
                    case 'al':
                        $order = 'auto_links DESC';
                        break;
                    case 'alv':
                        $order = 'auto_links_visits DESC';
                        break;
                }
            } else {
                $order = 'post_id DESC';
            }

            //sort -------------------------------------------------

            //retrieve the total number of events
            global $wpdb;
            $table_name  = $wpdb->prefix . $this->shared->get('slug') . "_statistic";
            $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name " . $filter);

            //Initialize the pagination class
            require_once($this->shared->get('dir') . '/admin/inc/class-daam-pagination.php');
            $pag = new daam_pagination();
            $pag->set_total_items($total_items);//Set the total number of items
            $pag->set_record_per_page(intval(get_option($this->shared->get('slug') . '_pagination_statistics_menu'),
                10)); //Set records per page
            $pag->set_target_page("admin.php?page=" . $this->shared->get('slug') . "-statistics");//Set target page
            $pag->set_current_page();//set the current page number from $_GET

            ?>

            <!-- Query the database -->
            <?php
            $query_limit = $pag->query_limit();
            $results     = $wpdb->get_results("SELECT * FROM $table_name " . $filter . " ORDER BY $order $query_limit ",
                ARRAY_A); ?>

            <?php if (count($results) > 0) : ?>

                <div class="daext-items-container">

                    <table class="daext-items">
                        <thead>
                        <tr>
                            <th>
                                <div><?php esc_attr_e('Post ID', 'daam'); ?></div>
                                <div class="help-icon" title="<?php esc_attr_e('The post, page or custom post type ID.',
                                    'daam'); ?>"></div>
                            </th>
                            <th>
                                <div><?php esc_attr_e('Post', 'daam'); ?></div>
                                <div class="help-icon"
                                     title="<?php esc_attr_e('The post, page or custom post type title.',
                                         'daam'); ?>"></div>
                            </th>
                            <th>
                                <div><?php esc_attr_e('Content Length', 'daam'); ?></div>
                                <div class="help-icon"
                                     title="<?php esc_attr_e('The length of the raw (with filters not applied) post content.',
                                         'daam'); ?>"></div>
                            </th>
                            <th>
                                <div><?php esc_attr_e('Autolinks', 'daam'); ?></div>
                                <div class="help-icon"
                                     title="<?php esc_attr_e('The number of autolinks applied on the post.', 'daam'); ?>"></div>
                            </th>
                            <th>
                                <div><?php esc_attr_e('Clicks', 'daam'); ?></div>
                                <div class="help-icon"
                                     title='<?php esc_attr_e('The number of clicks generated with the autolinks applied on the post.',
                                         'daam'); ?>'></div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($results as $result) : ?>

                            <tr>
                                <td><?php echo $result['post_id']; ?></td>
                                <?php
                                if (get_post_status($result['post_id']) !== false) {
                                    echo '<td><a href="' . get_the_permalink($result['post_id']) . '">' . get_the_title($result['post_id']) . '</a></td>';
                                } else {
                                    echo '<td>' . esc_attr__('Not Available', 'daam') . '</td>';
                                }
                                ?>
                                <td><?php echo $result['content_length']; ?></td>
                                <td><?php echo $result['auto_links']; ?></td>
                                <td><?php echo $result['auto_links_visits']; ?></td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                </div>

            <?php else : ?>

                <?php

                if (mb_strlen(trim($filter)) > 0) {
                    echo '<p>' . esc_attr__('There are no results that match your filter criteria.', 'daam') . '</p>';
                } else {
                    echo '<p>' . esc_attr__('There are no data at moment, click on the "Generate" button to generate statistics about the autolinks of your blog.',
                            'daam') . '</p>';
                }

                ?>

            <?php endif; ?>

            <!-- Display the pagination -->
            <?php if ($pag->total_items > 0) : ?>
                <div class="daext-tablenav daext-clearfix">
                    <div class="daext-tablenav-pages">
                        <span class="daext-displaying-num"><?php echo $pag->total_items; ?>&nbsp<?php esc_attr_e('items',
                                'daam'); ?></span>
                        <?php $pag->show(); ?>
                    </div>
                </div>
            <?php endif; ?>

        </div><!-- #subscribers-container -->

        <div class="sidebar-container">

            <div class="daext-widget">

                <h3 class="daext-widget-title"><?php esc_attr_e('Autolinks Data', 'daam'); ?></h3>

                <div class="daext-widget-content">

                    <p><?php esc_attr_e('This procedure allows you to generate statistics about the autolinks of your blog.',
                            'daam'); ?></p>

                </div><!-- .daext-widget-content -->

                <div class="daext-widget-submit">
                    <input id="ajax-request-status" type="hidden" value="inactive">
                    <input class="button" id="update-archive" type="button"
                           value="<?php esc_attr_e('Generate', 'daam'); ?>">
                    <img id="ajax-loader"
                         src="<?php echo $this->shared->get('url') . 'admin/assets/img/ajax-loader.gif'; ?>">
                </div>

            </div>

            <div class="daext-widget">

                <h3 class="daext-widget-title"><?php esc_attr_e('Export CSV', 'daam'); ?></h3>

                <div class="daext-widget-content">

                    <p><?php esc_attr_e('The downloaded CSV file can be imported in your favorite spreadsheet software.',
                            'daam'); ?></p>

                </div><!-- .daext-widget-content -->

                <!-- the data sent through this form are handled by the export_csv_controller() method called with the
                WordPress init action -->
                <form method="POST" action="admin.php?page=daam-statistics">

                    <div class="daext-widget-submit">
                        <input name="export_csv" class="button" type="submit" value="<?php esc_attr_e('Download',
                            'daam'); ?>" <?php if ($this->shared->number_of_records_in_statistic() == 0) {
                            echo 'disabled="disabled"';
                        } ?>>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>