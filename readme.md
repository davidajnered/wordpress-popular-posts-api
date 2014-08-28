# Wordpress Popular Posts API

This plugin extends Wordpress Popular Post with a API to use in functions.php or in your templates.

Example usage below.

```
function get_popular_posts_query($options = array())
{
    // Get post ids from WPP
    $wppapi = new WordpressPopularPostsApi();
    $postIds = $wppapi->getPopularPostIds($options);

    // Add post ids to query options
    $default = array('post__in' => $postIds, 'orderby' => 'post__in');
    $args = array_merge($default, $options);
    $query = new WP_Query($args);

    return $query;
}
```

*readme is not complete*