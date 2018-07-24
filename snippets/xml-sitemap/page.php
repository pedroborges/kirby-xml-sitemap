<url>
    <loc><?= html($page->url()) ?></loc>
    <lastmod><?= date('c', $page->modified()) ?></lastmod>

    <?php if ($languages && $languages->count() > 1) : ?>
    <?php foreach ($languages as $lang) : ?>
    <xhtml:link hreflang="<?= $lang->code() ?>" href="<?= html($page->url($lang->code())) ?>" rel="alternate" />
    <?php endforeach ?>
    <?php endif ?>

    <?php if (option('pedroborges.xml-sitemap.priority')) : ?>
    <priority><?= $page->priority() ?></priority>
    <?php endif ?>

    <?php if (option('pedroborges.xml-sitemap.frequency')) : ?>
    <changefreq><?= $page->frequency() ?></changefreq>
    <?php endif ?>

    <?php if (option('pedroborges.xml-sitemap.include.images') && $page->hasImages()) : ?>
    <?php foreach ($page->images() as $image) : ?>
    <?php snippet('xml-sitemap/image', compact('image')) ?>
    <?php endforeach ?>
    <?php endif ?>
</url>
