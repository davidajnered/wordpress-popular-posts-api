<?php
/*
*/
namespace WordpressPopularPostsApi;

class Core extends \WordpressPopularPosts
{
    /**
     * Get array with popular post ids.
     *
     * @param array $options
     * @return array $postIds
     */
    public function getPopularPostIds(array $options = array())
    {
        $options = array_merge($this->defaults, $options);
        $results = $this->_query_posts($options);

        $postIds = array();
        foreach ($results as $result) {
            $postIds[] = (int) $result->id;
        }

        // Return the same number of posts as option['limit']
        if (count($postIds) < $options['limit']) {
            $postIds = $this->addExtraPostIds($postIds, $options);
        }

        return $postIds;
    }

    /**
     * Fill postIds array with the remaining number of ids
     *
     * @param array $postIds
     * @param array $options
     * @return array $postIds
     */
    private function addExtraPostIds(array $postIds, array $options)
    {
        // Set WP options
        $options['post__not_in'] = $postIds;
        $options['posts_per_page'] = (int) $options['limit'] - count($postIds);

        $posts = get_posts($options);
        foreach ($posts as $post) {
            $postIds[] = $post->ID;
        }

        return $postIds;
    }
}
