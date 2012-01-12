<?php
// Register Widgets
$pageWidgets = array(
    'product_meta' => array($product['Product']),
    'product_submit' => array($product['Product'])
);

if (!empty($product['Tweet'])) {
    $pageWidgets['twitter'] = array('tweets' => $product['Tweet']);
}
$this->set(compact('pageWidgets'));
$this->Html->addCrumb($product['Product']['name']);
?>
<div id="product" class="product-section">
    <?php echo $this->Love->productImage($product, 128); ?>
    <?php if (isset($userData)): ?>
        <?php echo $this->Love->inventoryButton($product['Product']['id'], $inInventory); ?>
    <?php endif; ?>
    <h1><?php echo $product['Product']['name']; ?></h1>
    <div id="product-description">
        <p><?php echo nl2br($product['Product']['description_formatted'] ? $product['Product']['description_formatted'] : $product['Product']['description']); ?></p>
    </div>
</div>
<div id="product-tabs" class="tabs-wrapper">
    <div class="tab-list-wrapper">
        <ul class="tabs">
            <li><a href="#latest">Latest</a></li>
            <li><a href="#threads">Forum</a></li>
            <li><a href="#reviews">Reviews</a></li>
            <li><a href="#gallery">Gallery</a></li>
        </ul>
    </div>
    <div id="latest">
        <h2>
            Latest <?php echo $product['Product']['name']; ?> News
            <?php
            echo $this->Html->link('Submit News', array(
                'controller' => 'news',
                'action' => 'submit',
                $product['Product']['slug'],
                    ), array('class' => 'cta')
            );
            ?>
        </h2>
        <?php if (!empty($news)): ?>
            <ul>
                <?php foreach ($news as $newsItem): ?>
                    <li>
                        <h3><?php echo $this->Link->news($newsItem); ?></h3>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No latest news for <?php echo $product['Product']['name']; ?>.</p>
        <?php endif; ?>
    </div>
    <div id="reviews" class="product-section">
        <h2><?php echo $product['Product']['name']; ?> Reviews</h2>
        <p>You can write what you think of <?php echo $product['Product']['name']; ?> here, it can be long, short or just a rant!</p>
        <?php if (isset($userData)): ?>
        <?php else: ?>
            <a class="guest">You must be logged in to add a review.</a>
        <?php endif; ?>
    </div>
    <div id="threads" class="product-section">
        <h2><?php echo $this->Link->forum($product['Product']['slug'], $product['Product']['name'] . ' Forum'); ?><?php echo $this->Link->newThread($product['Product']['id']); ?></h2>
        <p>Here are the lastest discussions in our <?php echo $this->Link->forum($product['Product']['slug'], $product['Product']['name'] . ' forum'); ?>.</p>
        <?php echo $this->element('forms/thread'); ?>
        <?php echo $this->element('forums/threads'); ?>
        <p><?php echo $this->Link->forum($product['Product']['slug'], 'View All Threads'); ?></p>
    </div>
    <div id="gallery">
        <h2><?php echo $product['Product']['name']; ?> Gallery</h2>
        <p>Gallery goes here</p>
    </div>
    <?php debug($related); ?>
</div>