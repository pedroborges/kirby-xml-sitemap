<?php

namespace Pedorborges;

class XMLSitemap {
    public static function sitemapPriority($page) {
        return $page->isHomePage() ? 1 : \number_format(1.6 / ($page->depth() + 1), 1);
    }

    public static function sitemapFrequency($page) {
        $priority = static::sitemapPriority($page);

        switch (true) {
            case $priority === 1  : $frequency = 'daily';  break;
            case $priority >= 0.5 : $frequency = 'weekly'; break;
            default : $frequency = 'monthly';
        }

        return $frequency;
    }

    public static function sitemapProcessAttributes($page) {
        $frequency = option('pedroborges.xml-sitemap.frequency');
        $priority  = option('pedroborges.xml-sitemap.priority');

        if ($frequency) {
            $frequency = is_bool($frequency) ? 'sitemapFrequency' : $frequency;
            if (! \is_callable($frequency)) throw new Exception($frequency . ' is not callable.');
            $page->frequency = $frequency($page);
        }

        if ($priority) {
            $priority = \is_bool($priority) ? 'sitemapPriority' : $priority;
            if (! is_callable($priority)) throw new Exception($priority . ' is not callable.');
            $page->priority = $priority($page);
        }

        return $page;
    }
}
