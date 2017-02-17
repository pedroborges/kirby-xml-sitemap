<?php

kirby()->set('snippet', 'sitemap.page', __DIR__ . '/snippets/page.php');
kirby()->set('snippet', 'sitemap.image', __DIR__ . '/snippets/image.php');

kirby()->set('route', [
    'pattern' => 'sitemap.xsl',
    'method'  => 'GET',
    'action'  => function() {
        $stylesheet = f::read(__DIR__ . DS . 'sitemap.xsl');

        return new response($stylesheet, 'xsl');
    }
]);

kirby()->set('route', [
    'pattern' => 'sitemap.xml',
    'method'  => 'GET',
    'action'  => function() {
        if (cache::exists('sitemap')) {
            return new response(cache::get('sitemap'), 'xml');
        }

        $includeInvisibles = c::get('sitemap.include.invisible', false);
        $ignoredPages      = c::get('sitemap.ignored.pages', []);
        $ignoredTemplates  = c::get('sitemap.ignored.templates', []);

        $languages = site()->languages();
        $pages     = site()->index();

        if (! $includeInvisibles) {
            $pages = $pages->visible();
        }

        $pages = $pages
                    ->not($ignoredPages)
                    ->filterBy('intendedTemplate', 'not in', $ignoredTemplates)
                    ->map(function($page) {
                        $priority = $page->isHomePage() ? 1 : number_format(1.6 / ($page->depth() + 1), 1);

                        if (c::get('sitemap.attributes.priority', false)) {
                            $page->priority = $priority;
                        }

                        if (c::get('sitemap.attributes.frequency', false)) {
                            switch (true) {
                                case $priority === 1  : $frequency = 'daily';  break;
                                case $priority >= 0.5 : $frequency = 'weekly'; break;
                                default : $frequency = 'monthly';
                            }

                            $page->frequency = $frequency;
                        }

                        return $page;
                    });

        $sitemap = tpl::load(__DIR__ . DS . 'sitemap.html.php', compact('languages', 'pages'));

        cache::set('sitemap', $sitemap);

        return new response($sitemap, 'xml');
    }
]);
