<?php
$pageWidgets = array();

if (isset($latestInventory)) {
    $pageWidgets['inventory'] = array('inventory' => $latestInventory);
} else {
    $pageWidgets['inventory_empty'] = array();
}

$pageWidgets['top5'] = array();

$this->set(compact('pageWidgets'));
?>
<h2>Your Activity Feed</h2>
<p>What's going on with the products and services you own.</p>
<?php if (!empty($news)): ?>
    <div class="timeline">
        <?php foreach ($news as $newsItem): ?>
            <article class="news-article">
                <h2>
                    <?php echo $this->Link->product($newsItem['Product'], $this->Love->productImage($newsItem['Product']), array('escape' => false, 'class' => 'news-logo')); ?>
                    <?php echo $this->Link->news($newsItem); ?>
                </h2>
                <?php echo $newsItem['News']['content']; ?>

                <?php //debug($newsItem); ?>
            </article>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Here be a message encouraging you to fill ya inventory!</p>
<?php endif; ?>