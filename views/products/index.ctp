<?php
$pageWidgets = array('top5','facebook');
$this->set(compact('pageWidgets'));
?>
<div id="homepage">
	<h2>Product Reviews Without the Hassle at Consumer Love</h2>
	<p><strong>Consumer Love</strong> makes it easy to say how you really feel about the companies and brands we user everyday, and see what others recommend.</p>
	<?php echo $this->element('search.ctp')?>
	<div id="home">
		<ul>
			<li><a href="#latest">Latest</a></li>
			<li><a href="#trends">Trending</a></li>
			<li><a href="#inventory">Your Inventory</a></li>
		</ul>
		<div id="latest">
			<hgroup class="heading-wrapper">
				<h2>Latest Activity</h2>
				<h3>What's going on today at Consumer Love.</h3>
			</hgroup>
		</div>
		<div id="trends">
			<hgroup class="heading-wrapper">
				<h2>Trending Today</h2>
				<h3>Products with the most activity in the last 24 hours.</h3>
			</hgroup>
		</div>
		<div id="inventory">
			<hgroup class="heading-wrapper">
				<h2>Your Inventory</h2>
				<h3>Products and services you have added yo your inventory</h3>
			</hgroup>
			<?php if(isset($userData)): ?>
				<?php if(!empty($userInventory)) :?>
					<?php foreach($userInventory as $inventory): ?>
					<div class="">
						<?php echo $love->productLink($inventory['Product']);?>
					</div>
					<?php endforeach; ?>
				<?php else: ?>
				<p>You have nothing in your inventory! Check the star icon next to products see them in your favourites.</p>
				<?php endif; ?>
			<?php else: ?>
			<p>You need to <span class="guest">register or login</span> to see your favourites.</p>
			<?php endif; ?>
		</div>
	</div>
</div>