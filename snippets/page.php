<url>
    <loc><?= html($page->url()) ?></loc>
    <lastmod><?= $page->modified('c') ?></lastmod>

    <?php if ($languages && $languages->count() > 1) : ?>
    <?php foreach ($languages as $lang) : ?>
    <xhtml:link hreflang="<?= $lang->code() ?>" href="<?= html($page->url($lang->code())) ?>" rel="alternate" />
    <?php endforeach ?>
    <?php endif ?>

    <?php if (c::get('sitemap.attributes.priority', false)) : ?>
    <priority><?= $page->priority() ?></priority>
    <?php endif ?>

    <?php if (c::get('sitemap.attributes.frequency', false)) : ?>
    <changefreq><?= $page->frequency() ?></changefreq>
    <?php endif ?>

    <?php if (c::get('sitemap.attributes.images', true) && $page->hasImages()) : ?>
    <?php foreach ($page->images() as $image) : ?>
    <?php snippet('sitemap.image', compact('image')) ?>
    <?php endforeach ?>
    <?php endif ?>
</url>
