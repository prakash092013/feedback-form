<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Feedback_Form
 * @subpackage Feedback_Form/public/partials
 */

// $page = sanitize_text_field($_POST['page']);
// echo '<pre>';
// print_r($data);
// echo '</pre>';

?>

<div id="CodeableFeedbackForm-list" class="CodeableFeedbackForm-list">
    <div class="pagination-loading">
        <span class="spinner"></span>
    </div>
    <?php //  if there are feedbacks
        if( isset($data->feedbacks) && count($data->feedbacks) > 0 ):
            $counter = 0;

            $cur_page = $data->page;
            $page = $data->page-1;
            // Set the number of results to display
            $per_page = $data->posts_per_page;
            $previous_btn = true;
            $next_btn = true;
            $first_btn = true;
            $last_btn = true;
            // $start = $page * $per_page;
            ?>

            <table cellspacing="0" cellpadding="10" border="1" width="100%" style="border-collapse: collapse;">
                <tbody>
                    <tr>
                        <th>#</th>
                        <th><?php esc_html_e('First name', 'feedback-form'); ?></th>
                        <th><?php esc_html_e('Last name', 'feedback-form'); ?></th>
                        <th><?php esc_html_e('Email', 'feedback-form'); ?></th>
                        <th><?php esc_html_e('Subject', 'feedback-form'); ?></th>
                        <th><?php esc_html_e('Submitted on', 'feedback-form'); ?></th>
                        <th><?php esc_html_e('Action', 'feedback-form'); ?></th>
                    </tr>
                    <?php 
                    foreach ($data->feedbacks as $feedback_id => $feedback) :
                    $counter++;?>
                            
                        <tr class="row-<?php echo esc_attr($feedback_id); ?>">
                            <td><?php echo esc_html($feedback_id); ?></td>
                            <td><?php echo esc_html($feedback['first_name']); ?></td>
                            <td><?php echo esc_html($feedback['last_name']); ?></td>
                            <td><?php echo esc_html($feedback['email']); ?></td>
                            <td><?php echo esc_html($feedback['subject']); ?></td>
                            <td><?php 
                            $df = get_option( 'date_format' );
                            $tf = get_option( 'time_format' );
                            $format = $df.' '.$tf;
                            echo get_the_date($format, $feedback_id); ?></td>
                            <td><button class="view-details" data-id="<?php echo esc_attr($feedback_id); ?>"><?php esc_html_e('Open', 'feedback-form'); ?></button></td>
                        </tr>

                    <?php endforeach;?>
                    
                </tbody>
            </table>
            <?php 

            // This is where the magic happens
            $no_of_paginations = $data->max_num_pages;

            if ($cur_page >= 7) {
                $start_loop = $cur_page - 3;
                if ($no_of_paginations > $cur_page + 3)
                    $end_loop = $cur_page + 3;
                else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
                    $start_loop = $no_of_paginations - 6;
                    $end_loop = $no_of_paginations;
                } else {
                    $end_loop = $no_of_paginations;
                }
            } else {
                $start_loop = 1;
                if ($no_of_paginations > 7)
                    $end_loop = 7;
                else
                    $end_loop = $no_of_paginations;
            }

            // Pagination Buttons logic 
            $pag_container = '';    
            $pag_container .= "<div class='cvf-universal-pagination'>
                <ul>";

            if ($first_btn && $cur_page > 1) {
                $pag_container .= "<li data-p='1' class='active'>".esc_html('First', 'feedback-form')."</li>";
            } else if ($first_btn) {
                $pag_container .= "<li data-p='1' class='inactive'>".esc_html('First', 'feedback-form')."</li>";
            }

            if ($previous_btn && $cur_page > 1) {
                $pre = $cur_page - 1;
                $pag_container .= "<li data-p='$pre' class='active'>".esc_html('Previous', 'feedback-form')."</li>";
            } else if ($previous_btn) {
                $pag_container .= "<li class='inactive'>".esc_html('Previous', 'feedback-form')."</li>";
            }

            // echo "start_loop:".$start_loop;
            // echo "end_loop:".$end_loop;

            for ($i = $start_loop; $i <= $end_loop; $i++) {

                if ($cur_page == $i)
                    $pag_container .= "<li data-p='$i' class = 'selected' >{$i}</li>";
                else
                    $pag_container .= "<li data-p='$i' class='active'>{$i}</li>";
            }

            if ($next_btn && $cur_page < $no_of_paginations) {
                $nex = $cur_page + 1;
                $pag_container .= "<li data-p='$nex' class='active'>".esc_html('Next', 'feedback-form')."</li>";
            } else if ($next_btn) {
                $pag_container .= "<li class='inactive'>".esc_html('Next', 'feedback-form')."</li>";
            }

            if ($last_btn && $cur_page < $no_of_paginations) {
                $pag_container .= "<li data-p='$no_of_paginations' class='active'>".esc_html('Last', 'feedback-form')."</li>";
            } else if ($last_btn) {
                $pag_container .= "<li data-p='$no_of_paginations' class='inactive'>".esc_html('Last', 'feedback-form')."</li>";
            }

            $pag_container = $pag_container . "
                </ul>
            </div>";
            echo $pag_container;
        endif; // $data->feedbacks ?>
</div>
