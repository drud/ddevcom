<?php

defined('ABSPATH') OR die('This script cannot be accessed directly.');

/**
 * Description of Blog
 *
 * @author mark
 */
class HunchSchema_Blog extends HunchSchema_Thing
{
    public $schemaType = "Blog";

    public function getResource($pretty = false)
    {
        if ( is_front_page() && is_home() || is_front_page() )
        {
            $Headline = get_bloginfo( 'name' );
            $Permalink = get_site_url() . '/';
        }
        else
        {
            $Headline = get_the_title( get_option( 'page_for_posts' ) );
            $Permalink = get_permalink( get_option( 'page_for_posts' ) );
        }


        $blogPost = array();

        while (have_posts()) : the_post();

            $blogPost[] = array
                (
                '@type' => 'BlogPosting',
                'headline' => get_the_title(),
                'url' => get_the_permalink(),
                'datePublished' => get_the_date( 'Y-m-d' ),
                'dateModified' => get_the_modified_date( 'Y-m-d' ),
                'mainEntityOfPage' => get_the_permalink(),
                'author' => $this->getAuthor(),
                'publisher' => $this->getPublisher(),
                'image' => $this->getImage(),
                'wordCount' => str_word_count( get_the_content() ),
                'keywords' => $this->getTags(),
                'commentCount' => get_comments_number(),
                'comment' => $this->getComments(),
            );

        endwhile;

        $this->schema = array
            (
            '@context' => 'http://schema.org/',
            '@type' => $this->schemaType,
            'headline' => $Headline,
            'description' => get_bloginfo( 'description' ),
            'url' => $Permalink,
            'blogPost' => $blogPost,
        );

        return $this->toJson( $this->schema, $pretty );
    }
}