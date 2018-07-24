<image:image>
    <image:loc><?= html($image->url()) ?></image:loc>

    <?php if ($image->caption()->isNotEmpty()) : ?>
    <image:caption><![CDATA[<?= $image->caption() ?>]]></image:caption>
    <?php elseif ($image->alt()->isNotEmpty()) : ?>
    <image:caption><![CDATA[<?= $image->alt() ?>]]></image:caption>
    <?php endif ?>

    <?php if ($license = option('pedroborges.xml-sitemap.images.license')) : ?>
    <image:license><?= html($license) ?></image:license>
    <?php endif ?>
</image:image>
