<image:image>
    <image:loc><?= $image->url() ?></image:loc>
    <?php if ($image->caption()->isNotEmpty()) : ?>
    <image:caption><![CDATA[<?= $image->caption() ?>]]></image:caption>
    <?php elseif ($image->alt()->isNotEmpty()) : ?>
    <image:caption><![CDATA[<?= $image->alt() ?>]]></image:caption>
    <?php endif ?>
</image:image>
