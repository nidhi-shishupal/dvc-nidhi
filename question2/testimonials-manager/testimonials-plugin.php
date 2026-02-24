<?php

/**
 * Plugin Name: Testimonials Manager
 * Description: Custom testimonials system
 * Version: 1.0
 * Author: Nidhi Shishupal
 */

if (!defined('ABSPATH')) exit;


/* REGISTER TESTIMONIAL POST TYPE */
function tm_register_testimonials_cpt()
{

    $labels = array(
        'name'               => 'Testimonials',
        'singular_name'      => 'Testimonial',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Testimonial',
        'edit_item'          => 'Edit Testimonial',
        'new_item'           => 'New Testimonial',
        'view_item'          => 'View Testimonial',
        'search_items'       => 'Search Testimonials',
        'not_found'          => 'No Testimonials found',
        'menu_name'          => 'Testimonials'
    );

    $args = array(
        'labels'        => $labels,
        'public'        => true,
        'menu_icon'     => 'dashicons-format-quote',
        'supports'      => array('title', 'editor', 'thumbnail'),
        'show_in_rest'  => true,
        'has_archive'   => true,
        'rewrite'       => array('slug' => 'testimonials'),
        'capability_type' => 'post',
        'map_meta_cap'    => true,
    );

    register_post_type('testimonial', $args);
}

/* ADD META BOX */
function tm_add_testimonial_meta_box()
{
    add_meta_box(
        'tm_testimonial_details',
        'Client Details',
        'tm_testimonial_meta_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'tm_add_testimonial_meta_box');


function tm_testimonial_meta_callback($post)
{

    wp_nonce_field('tm_save_testimonial_data', 'tm_testimonial_nonce');

    $client_name = get_post_meta($post->ID, '_tm_client_name', true);
    $position    = get_post_meta($post->ID, '_tm_position', true);
    $company     = get_post_meta($post->ID, '_tm_company', true);
    $rating = (int) get_post_meta(get_the_ID(), '_tm_rating', true);
?>

    <p>
        <label><strong>Client Name *</strong></label><br>
        <input type="text" name="tm_client_name" value="<?php echo esc_attr($client_name); ?>" style="width:100%;" required>
    </p>

    <p>
        <label>Position / Title</label><br>
        <input type="text" name="tm_position" value="<?php echo esc_attr($position); ?>" style="width:100%;">
    </p>

    <p>
        <label>Company</label><br>
        <input type="text" name="tm_company" value="<?php echo esc_attr($company); ?>" style="width:100%;">
    </p>

    <p>
        <label>Rating</label><br>
        <select name="tm_rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?php echo $i; ?>" <?php selected($rating, $i); ?>>
                    <?php echo $i; ?> Star<?php if ($i > 1) echo 's'; ?>
                </option>
            <?php endfor; ?>
        </select>
    </p>

    <?php
}

function tm_activate()
{
    tm_register_testimonials_cpt();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'tm_activate');

function tm_deactivate()
{
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'tm_deactivate');

/* SAVE META BOX DATA SECURELY */
function tm_save_testimonial_meta($post_id)
{
    // Only run for testimonial post type
    if (get_post_type($post_id) !== 'testimonial') return;

    // 1. Verify nonce
    if (
        !isset($_POST['tm_testimonial_nonce']) ||
        !wp_verify_nonce($_POST['tm_testimonial_nonce'], 'tm_save_testimonial_data')
    ) {
        return;
    }

    // 2. Prevent autosave overwrite
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // 3. Check permissions
    if (!current_user_can('edit_post', $post_id)) return;

    // 4. Save fields
    if (isset($_POST['tm_client_name']))
        update_post_meta($post_id, '_tm_client_name', sanitize_text_field($_POST['tm_client_name']));

    if (isset($_POST['tm_position']))
        update_post_meta($post_id, '_tm_position', sanitize_text_field($_POST['tm_position']));

    if (isset($_POST['tm_company']))
        update_post_meta($post_id, '_tm_company', sanitize_text_field($_POST['tm_company']));

    if (isset($_POST['tm_rating']))
        update_post_meta($post_id, '_tm_rating', intval($_POST['tm_rating']));
}
add_action('save_post', 'tm_save_testimonial_meta');

function tm_remove_author_blocks($block_content, $block)
{
    if (!is_singular('testimonial')) return $block_content;

    $blocked_blocks = [
        'core/post-author',
        'core/post-date',
        'core/post-terms',
        'core/post-author-name',
        'core/post-author-biography',
        'core/post-meta'
    ];

    if (isset($block['blockName']) && in_array($block['blockName'], $blocked_blocks)) {
        return '';
    }

    return $block_content;
}
add_filter('render_block', 'tm_remove_author_blocks', 10, 2);

function tm_force_blank_template($template)
{
    if (is_singular('testimonial')) {
        return plugin_dir_path(__FILE__) . 'templates/single-testimonial-clean.php';
    }
    return $template;
}
add_filter('template_include', 'tm_force_blank_template', 1000);

function tm_styles()
{
    echo '<style>
    .tm-single-testimonial { max-width:700px;margin:auto;padding:20px }
    .tm-rating { font-size:24px;color:#f5b301;margin:10px 0 }
    .tm-client { font-size:18px;margin-bottom:15px;color:#444 }
    .tm-content { font-size:17px;line-height:1.6 }
    .tm-slider{position:relative;overflow:hidden;max-width:900px;margin:40px auto}
    .tm-track{display:flex;transition:transform .4s ease}
    .tm-slide{min-width:100%;box-sizing:border-box;padding:20px;text-align:center}
    .tm-photo img{width:80px;height:80px;border-radius:50%;object-fit:cover;margin-bottom:10px}
    .tm-prev,.tm-next{
        position:absolute;top:50%;transform:translateY(-50%);
        background:#000;color:#fff;border:none;padding:8px 12px;cursor:pointer
    }
    .tm-prev{left:0}
    .tm-next{right:0}

    /* Center page title for testimonials page */
    .page-template-default .entry-title,
    .wp-block-post-title{
    text-align:center;
    width:100%;
    margin-bottom:30px;
}

    @media(max-width:768px){
    .tm-slide{padding:15px}
    .tm-prev,.tm-next{padding:6px 8px;font-size:14px}
    .tm-photo img{width:60px;height:60px}
}
    </style>';

    echo '<script>
    document.addEventListener("DOMContentLoaded",()=>{
    const track=document.querySelector(".tm-track");
    if(!track)return;
    let index=0;
    const slides=document.querySelectorAll(".tm-slide");

    document.querySelector(".tm-next").onclick=()=>{
    index=(index+1)%slides.length;
    track.style.transform=`translateX(-${index*100}%)`;
    };

    document.querySelector(".tm-prev").onclick=()=>{
    index=(index-1+slides.length)%slides.length;
    track.style.transform=`translateX(-${index*100}%)`;
    };
  });
   </script>';
}
add_action('wp_head', 'tm_styles');

function tm_testimonials_shortcode($atts)
{
    $atts = shortcode_atts([
        'count'   => -1,
        'orderby' => 'date',
        'order'   => 'DESC'
    ], $atts, 'testimonials');

    /* whitelist allowed values */
    $allowed_orderby = ['date', 'title', 'menu_order', 'rand'];
    $allowed_order   = ['ASC', 'DESC'];

    $orderby = in_array($atts['orderby'], $allowed_orderby) ? $atts['orderby'] : 'date';
    $order   = in_array(strtoupper($atts['order']), $allowed_order) ? strtoupper($atts['order']) : 'DESC';
    $count   = intval($atts['count']);

    $query = new WP_Query([
        'post_type'      => 'testimonial',
        'posts_per_page' => $count,
        'orderby'        => $orderby,
        'order'          => $order
    ]);

    ob_start();

    if ($query->have_posts()) :
    ?>
        <div class="tm-slider">
            <button class="tm-prev" aria-label="Previous testimonial">❮</button>

            <div class="tm-track">
                <?php while ($query->have_posts()) : $query->the_post();

                    $name     = esc_html(get_post_meta(get_the_ID(), '_tm_client_name', true));
                    $position = esc_html(get_post_meta(get_the_ID(), '_tm_position', true));
                    $company  = esc_html(get_post_meta(get_the_ID(), '_tm_company', true));
                    $rating   = (int) get_post_meta(get_the_ID(), '_tm_rating', true);
                ?>
                    <div class="tm-slide">

                        <div class="tm-photo">
                            <?php
                            if (has_post_thumbnail()) {
                                echo wp_kses_post(get_the_post_thumbnail(get_the_ID(), 'thumbnail'));
                            } else {
                                echo '<img src="https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=0D8ABC&color=fff" alt="Client photo">';
                            }
                            ?>
                        </div>

                        <div class="tm-rating">
                            <?php for ($i = 1; $i <= 5; $i++) echo esc_html($i <= $rating ? '★' : '☆'); ?>
                        </div>

                        <div class="tm-text"><?php echo wp_kses_post(get_the_content()); ?></div>

                        <p class="tm-client">
                            <strong><?php echo $name; ?></strong>
                            <br><?php echo esc_html(trim("$position, $company", ', ')); ?>
                        </p>

                    </div>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </div>

            <button class="tm-next" aria-label="Next testimonial">❯</button>
        </div>
<?php
    else :
        echo "<p>No testimonials found.</p>";
    endif;

    return ob_get_clean();
}
add_shortcode('testimonials', 'tm_testimonials_shortcode');

function tm_archive_template($template)
{
    if (is_post_type_archive('testimonial')) {
        return plugin_dir_path(__FILE__) . 'templates/archive-testimonial.php';
    }
    return $template;
}
add_filter('archive_template', 'tm_archive_template');

add_action('init', 'tm_register_testimonials_cpt');
