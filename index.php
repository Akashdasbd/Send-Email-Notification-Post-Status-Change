function send_service_status_email($new_status, $old_status, $post) {
    if ($post->post_type != 'services') return;

    $author_email = get_the_author_meta('user_email', $post->post_author);
    $post_title = get_the_title($post->ID);
    $post_link = get_permalink($post->ID);

    $subject = "Service Status Changed: $post_title";
    $message = "Hello,\n\nYour service '$post_title' status has changed to $new_status.\n\n";
    $message .= "View it here: $post_link\n\nRegards,\nYour Website";

    wp_mail($author_email, $subject, $message);
}
add_action('transition_post_status', 'send_service_status_email', 10, 3);
