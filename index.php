function send_service_status_email_on_admin_change($new_status, $old_status, $post) {
    if ($post->post_type != 'services' || $new_status == $old_status) return;

    
    if (!current_user_can('manage_options')) return; 

   
    $author_email = get_the_author_meta('user_email', $post->post_author);
    if (!$author_email) {
        error_log("No email found for post author.");
        return; 
    }

    $post_title = get_the_title($post->ID);
    $post_link = get_permalink($post->ID);

    
    $subject = "Service Status Changed: $post_title";

    
    $message = "Hello,\n\n";
    $message .= "Your service '$post_title' status has been changed by an administrator.\n\n";
    $message .= "New status: $new_status\n\n";
    $message .= "You can view your service here: $post_link\n\n";
    $message .= "Regards,\nMobadarat.org";

    
    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'From: Akash <akash248486@gmail.com>',
        'Reply-To: akash248486@gmail.com'
    ];

    
    $sent = wp_mail($author_email, $subject, $message, $headers);
    if (!$sent) {
        error_log("Email failed to send to $author_email");
    } else {
        error_log("Email successfully sent to $author_email");
    }
}
add_action('transition_post_status', 'send_service_status_email_on_admin_change', 10, 3);
