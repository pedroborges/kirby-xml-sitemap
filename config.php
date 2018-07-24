<?php
    Kirby::plugin('pedroborges/xml-sitemap', [
        'options' => [
            'frequency' => false,
            'priority' => false,
            'include.images' => true,
            'images.license' => null,
            'include.invisible' => false,
            'ignored.pages' => [],
            'ignored.templates' => [],
            'process' => null,
            'cache' => true,
            'cache.expires' => (60 * 24 * 7), // minutes
        ],
        'snippets' => [ 
            'xml-sitemap/image' => __DIR__ . '/snippets/xml-sitemap/image.php',
            'xml-sitemap/page' => __DIR__ . '/snippets/xml-sitemap/page.php',
        ],
        'hooks' => [
            'page.*' => function() {
                kirby()->cache('pedroborges.xml-sitemap')->flush();
            }
        ],
        'routes' => [
            [
                'pattern' => 'sitemap.xsl',
                'method'  => 'GET',
                'action'  => function() {
                    $stylesheet = \F::read(__DIR__ . DIRECTORY_SEPARATOR . 'xml-sitemap.xsl');
            
                    return new \Kirby\Http\Response($stylesheet, 'xsl');
                }
            ],
            [
                'pattern' => 'sitemap.xml',
                'method'  => 'GET',
                'action'  => function() {
                    $cache = kirby()->cache('pedroborges.xml-sitemap');
                    if ($c = $cache->get('xml-sitemap')) {
                        return new \Kirby\Http\Response($c, 'xml');
                    }
            
                    $includeInvisibles = option('pedroborges.xml-sitemap.include.invisible');
                    $ignoredPages      = option('pedroborges.xml-sitemap.ignored.pages');
                    $ignoredTemplates  = option('pedroborges.xml-sitemap.ignored.templates');
            
                    if (! is_array($ignoredPages)) {
                        throw new \Kirby\Exception('The option "pedroborges.xml-sitemap.ignored.pages" must be an array.');
                    }
            
                    if (! is_array($ignoredTemplates)) {
                        throw new \Kirby\Exception('The option "pedroborges.xml-sitemap.ignored.templates" must be an array.');
                    }
            
                    $languages = kirby()->site()->languages();
                    $pages     = kirby()->site()->index();
            
                    if (! $includeInvisibles) {
                        $pages = $pages->visible();
                    }
            
                    // TODO: something is broken here
                    $pages = $pages
                                ->not($ignoredPages)
                                ->filterBy('intendedTemplate', 'not in', $ignoredTemplates)
                                ->map('sitemapProcessAttributes');
            
                    $process = option('pedroborges.xml-sitemap.process');
            
                    if ($process instanceof Closure) {
                        $pages = $process($pages);
            
                        // TODO: this migh also not work in k3
                        if (! $pages instanceof Collection) {
                            throw new \Kirby\Exception('The option "pedroborges.xml-sitemap.process" must return a Collection.');
                        }
                    } elseif (! is_null($process)) {
                        throw new \Kirby\Exception($process . ' is not callable.');
                    }
            
                    $template = __DIR__ . DIRECTORY_SEPARATOR . 'xml-sitemap.html.php';
                    $sitemap  = \Pedroborges\Tpl::load($template, compact('languages', 'pages'));
            
                    $cache->set('xml-sitemap', $sitemap, option('pedroborges.xml-sitemap.cache.expires'));
            
                    return new \Kirby\Http\Response($sitemap, 'xml');
                }
            ]
        ]
    ]);