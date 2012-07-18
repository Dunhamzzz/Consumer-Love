<?php
$this->Html->script('quicksand.jquery', array('inline' => false));
$this->Html->addCrumb('Categories', '/categories');
foreach ($path as $breadcrumb) {
    $this->Html->addCrumb($breadcrumb['Category']['name'], '/categories/' . $breadcrumb['Category']['slug']);
}
?>
<h1><?php echo $category['Category']['name']; ?></h1>
<?php if (!empty($category['ChildCategory'])): ?>
    <h2>Sub-Categories</h2>
    <ul>
        <?php foreach ($category['ChildCategory'] as $subCat): ?>
            <li><?php echo $love->categoryLink($subCat); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php if (!empty($products)) : ?>
    <h2>Products and Services in <?php echo $category['Category']['name']; ?></h2>
    <form id="product-paginate" method="post">
        <img class="loader" src="/img/icons/ajax-loader.gif" alt="Loading" style="vertical-align: top; height: 22px; display: none;"/>
        <input type="hidden" name="category_id" value="<?php echo $category['Category']['id']; ?>" />
        Sort By:
        <select name="sort" class="filter-select">
            <option value="Product.name">Name</option>
            <option value="Product.inventory_count">Users</option>
        </select>
        <select name="order" class="filter-select">
            <option value="asc">Asc.</option>
            <option value="desc">Desc.</option>
        </select>
    </form>
    <?php echo $this->element('products/list'); ?>
<?php else: ?>
    <p>There are currently no products listed in <?php echo $category['Category']['name']; ?>!</p>
<?php endif; ?>