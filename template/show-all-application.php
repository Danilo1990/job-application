<?php
$args = array(
    'post_type' => JobCandidatePostType::CUSTOM_TYPE,
    'posts_per_page' => -1,
);

$allRequest = new WP_Query($args);

if ($allRequest->have_posts()): ?>

    <table>
        <tr>
            <th><?= __( 'Name', JobCandidatePostType::TEXT_DOMAIN ) ?></th>
            <th><?= __( 'Surname', JobCandidatePostType::TEXT_DOMAIN ) ?></th>
            <th><?= __( 'Phone', JobCandidatePostType::TEXT_DOMAIN ) ?></th>
            <th><?= __( 'Email', JobCandidatePostType::TEXT_DOMAIN ) ?></th>
            <th><?= __( 'Social link', JobCandidatePostType::TEXT_DOMAIN ) ?></th>
            <th><?= __( 'Candidate for', JobCandidatePostType::TEXT_DOMAIN ) ?></th>
            <th><?= __( 'Cv', JobCandidatePostType::TEXT_DOMAIN ) ?></th>
            <th><?= __( 'Response', JobCandidatePostType::TEXT_DOMAIN ) ?></th>
        </tr>
        <?php  while ($allRequest->have_posts()) : $allRequest->the_post(); ?>
            <tr>
                <td><strong><?=  get_field(acforJobs::ACF_NAME) ?></strong></<td>
                <td><strong><?=  get_field(acforJobs::ACF_SURNAME) ?></strong></<td>
                <td><strong><?=  get_field(acforJobs::ACF_PHONE) ?></strong></<td>
                <td><strong><?=  get_field(acforJobs::ACF_EMAIL) ?></strong></<td>
                <?php if($social = get_field(acforJobs::ACF_SOCIAL)) {
                    echo '<td><strong><a href="'.$social.'" download>'. __('Link social' , JobCandidatePostType::TEXT_DOMAIN).'</a></strong></<td>';
                } else {
                    echo '<td></td>';
                } ?>
                <td><strong><?=  get_term(  get_field(acforJobs::ACF_TYPE) )->name; ?></strong></<td>
                <?php if($cv = get_field(acforJobs::ACF_CV)) {
                    echo '<td><strong><a href="'.$cv.'" download>'. __('Download' , JobCandidatePostType::TEXT_DOMAIN).'</a></strong></<td>';
                } else {
                        echo '<td></td>';
                } ?>
                <td><strong><?=  get_field(acforJobs::ACF_TICKET) ?></strong></<td>
            </tr>
        <?php endwhile; ?>
    </table>

<?php else: ?>

    <h1><?= __('No request found', JobCandidatePostType::TEXT_DOMAIN) ?></h1>

<?php endif; wp_reset_postdata(); wp_reset_query();
