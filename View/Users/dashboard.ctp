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
<h2 class="dashboard-header">Your Activity Feed</h2>
<?php if (!empty($news)): ?>
    <div class="timeline">
        <?php foreach ($news as $newsItem): ?>
            <article class="news-article">
                <?php echo $this->Link->product($newsItem['Product'], $this->Love->productImage($newsItem['Product']), array('escape' => false, 'class' => 'news-logo')); ?>
                <h2>
                    <?php echo $this->Link->news($newsItem); ?>
                </h2>
                <p><?php echo $newsItem['News']['content']; ?></p>

                <?php //debug($newsItem); ?>
            </article>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Here be a message encouraging you to fill ya inventory!</p>
<?php endif; ?>