<?php

/**
 * The template for displaying manufacturer single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Reel
 */

get_header();
$manufacturer_name = get_the_title();
$country_of_manufacturer = get_field('country_of_manufacture');

$years_in_business_from = get_field('years_in_business_from');
$years_in_business_to = get_field('years_in_business_to');

$years_making_recorders_from = get_field('years_making_recorders_from');
$years_making_recorders_to = get_field('years_making_recorders_to');

$technical_innovations = get_field('technical_innovations');
$general_information = get_field('general_information');
$company_description = get_field('company_description');
?>
<div class="row">
    <div class="medium-12 columns">
        <div id="primary" class="content-area single-tape-recorder-mfg">
            <main id="main" class="site-main" role="main">
                <?php if (get_field('manufacturer_logo')) : ?>
                    <div class="row">
                        <div class="medium-12 columns logo">
                            <div class="center-logo">
                                <img id="manufacturer-logo" src="<?php the_field('manufacturer_logo'); ?>" />
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <h4>
                    <?php echo $manufacturer_name . ' - ' . $country_of_manufacturer; ?>
                    <?php if (isUserEligibleFor()) : ?>
                        <a class="button" href="<?php echo home_url() . '/update-brand/?post_id=' . get_the_ID(); ?>">Submit New Info</a>
                    <?php endif; ?>
                </h4>

                <div class="row">
                    <div class="medium-12 columns">
                        <table class="table table-dark">
                            <tbody>
                                <?php if (($years_in_business_from) || ($years_in_business_to)) : ?>
                                    <tr>
                                        <td> <strong>Years in Business:</strong></td>
                                        <td>
                                            <?php echo $years_in_business_from ? $years_in_business_from : '_ _ _ _'; ?>
                                            To
                                            <?php echo $years_in_business_to ? $years_in_business_to : '_ _ _ _'; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if (($years_making_recorders_from) || ($years_making_recorders_to)) : ?>
                                    <tr>
                                        <td><strong> Years making R-R Tape Recorders:</strong></td>
                                        <td>
                                            <?php echo $years_making_recorders_from ? $years_making_recorders_from : '_ _ _ _'; ?>
                                            To
                                            <?php echo $years_making_recorders_to ? $years_making_recorders_to : ' _ _ _ _'; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if ($technical_innovations) : ?>
                        <div class="medium-12 columns manufacturer_widget">
                            <div>
                                <div class="manufacturer_widget_title">
                                    <strong>Technical Innovations</strong>
                                </div>
                                <div class="manufacturer_widget_content">
                                    <?php echo $technical_innovations ? $technical_innovations : $empty_content_html; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($general_information) : ?>
                        <div class="medium-12 columns manufacturer_widget">
                            <div>
                                <div class="manufacturer_widget_title">
                                    <strong>General Information</strong>
                                </div>
                                <div class="manufacturer_widget_content">
                                    <?php echo $general_information ? $general_information : $empty_content_html; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if ($company_description) : ?>
                        <div class="medium-12 columns manufacturer_widget">
                            <div>
                                <div class="manufacturer_widget_title">
                                    <strong>Company description</strong>
                                </div>
                                <div class="manufacturer_widget_content">
                                    <?php echo $company_description ? $company_description : $empty_content_html; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <h4>
                    <?php echo $post->post_title; ?> R-R Tape Recorder Models<a class="button" href="<?php echo get_home_url() . '/reel/submit-tape-recorder/?brand=' . urlencode(get_the_ID()); ?>">Submit New Model</a>
                </h4>

                <?php
                $args_posts = array(
                    'post_type' => 'tape_recorder',
                    'posts_per_page' => -1,
                    'meta_key' => 'recorder_manufacturer_id',
                    'meta_query' => array(
                        array(
                            'key' => 'recorder_manufacturer_id',
                            'value' => $post->ID,
                            'compare' => '='
                        )
                    )
                );
                $query = new WP_Query($args_posts);



                echo '<ul class="recorder-holder">';
                if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                        $main_selected = get_field('select_main_image');
                        empty($main_selected) ? $main_selected = 'main' : '';

                        echo '<li class="recorders">';
                        echo '<a href="' . get_permalink() . '">';
                        echo wp_get_attachment_image(get_field('recorder_' . $main_selected), 'thumbnail');
                        // echo the_title('<span>', '</span>');
                        $field = get_field('recorder_model');
                        echo '<span>' . $field . '</span>';
                        echo '</a>';
                        echo '</li>';
                        wp_reset_postdata();

                    endwhile;
                else :
                // No posts found
                endif;
                echo '</ul>';

                ?>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div>
</div>

<?php
get_footer();
