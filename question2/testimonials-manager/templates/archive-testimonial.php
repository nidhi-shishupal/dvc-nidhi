<?php
if (!defined('ABSPATH')) exit;

get_header();

echo '<main style="max-width:1000px;margin:80px auto;padding:20px">';
echo '<h1 style="text-align:center;margin-bottom:40px">Client Testimonials</h1>';

echo do_shortcode('[testimonials count="-1"]');

echo '</main>';

get_footer();