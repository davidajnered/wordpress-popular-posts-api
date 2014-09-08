<?php
/**
 * Wordpress Popular Posts API
 *
 * Written by David Ajnered
 * http://davidajnered.com
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
    public function getPopularPosts(array $options = array())
    {
        $status = '';
        $options = array_merge($this->defaults, $options);

        // Save requested limit for later
        // If limits not set (WPP value) but posts_per_page (WP value) is, then use posts_per_page as limit.
        $limit = isset($options['limit']) && !isset($options['posts_per_page']) ? $options['limit'] : $options['posts_per_page'];
        $offset = isset($options['offset']) ? $options['offset'] : 0;

        // Update limit passed to query with the offset.
        $options['limit'] = $this->getLimit($limit, $offset);

        // Query Wordpress Popular Posts
        $results = $this->_query_posts($options);

        $postIds = array();
        foreach ($results as $result) {
            $postIds[] = (int) $result->id;
        }

        // Return the same number of posts as option['limit']
        if (count($postIds) < $limit && (isset($options['fill_results']) && $options['fill_results'])) {
            $postIds = $this->addExtraPostIds($postIds, $options);
        }

        return $postIds;
    }

    /**
     * Get query limit based on limit and offset.
     *
     * @param array $options
     * @return string $limit
     */
    private function getLimit($limit, $offset)
    {
        if ($offset != '0' && is_numeric($offset)) {
            $limit = $offset . ',' . $limit;
        }

        return $limit;
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
        $options['posts_per_page'] = (int) $options['posts_per_page'] - count($postIds);

        $posts = get_posts($options);
        foreach ($posts as $post) {
            $postIds[] = $post->ID;
        }

        return $postIds;
    }
}
