<?php

class PageLinksLib {

    public function __construct() {

    }

    public function getMainImage() {
        $html = '
        <link href="/wp-content/themes/twentyfourteen/css/vice-vice-davey.css" rel="stylesheet" type="text/css" />
        <div id="content" class="site-content" role="main">
            <div id="main-image">
                <img src="/images/vice.png" />
            </div>
        </div><!-- #content -->' ;
        return $html ;
    }

}