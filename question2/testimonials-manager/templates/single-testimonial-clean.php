<?php
if (!defined('ABSPATH')) exit;

get_header();

if (have_posts()) : while (have_posts()) : the_post();

        $name     = esc_html(get_post_meta(get_the_ID(), '_tm_client_name', true));
        $position = esc_html(get_post_meta(get_the_ID(), '_tm_position', true));
        $company  = esc_html(get_post_meta(get_the_ID(), '_tm_company', true));
        $rating   = (int) get_post_meta(get_the_ID(), '_tm_rating', true);
?>

        <main style="max-width:700px;margin:80px auto;padding:20px">

            <h1><?php the_title(); ?></h1>

            <div style="font-size:24px;color:#f5b301;margin:10px 0">
                <?php for ($i = 1; $i <= 5; $i++) echo $i <= $rating ? '★' : '☆'; ?>
            </div>

            <p style="font-size:18px;color:#444">
                <strong><?php echo $name; ?></strong>
                <?php if ($position || $company): ?>
                    — <?php echo $position; ?><?php if ($company) echo ', ' . $company; ?>
                <?php endif; ?>
            </p>

            <div style="font-size:17px;line-height:1.6">
                <?php echo wp_kses_post(get_the_content()); ?>
            </div>

        </main>

<?php endwhile;
endif;

get_footer();
