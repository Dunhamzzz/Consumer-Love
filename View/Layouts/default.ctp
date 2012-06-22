<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title_for_layout; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta property="og:title" content="Consumer Love" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="http://consumerlove.org" />
        <meta property="og:image" content="" />
        <meta property="og:site_name" content="Consumer Love" />
        <meta property="fb:admins" content="505549054" />

        <link rel="shortcut icon" href="/favicon.ico">
        <?php
        if (isset($canonical)) {
            echo '<link rel="canonical" href="http://consumerlove.org' . $canonical . '">';
        }

        echo $this->Html->script(array(
            'jquery-1.7.2.min',
            'jquery-ui-1.8.19.min',
            'jquery.tipsy',
            'global'
        ));
        echo $this->Html->css(array(
            'http://fonts.googleapis.com/css?family=Copse|Corben:700&v2',
            'tipsy',
            'style'
        ));

        echo $scripts_for_layout;
        echo $this->element('external/google_analytics');
        ?>
        <!--[if lt IE 9]>
        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=221050134590343";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <div id="user-bar">
            <div class="container">
                <a href="/" id="site-title" rel="home">Consumer Love <span class="heart"> &hearts;</span></a>
                <div id="search" class="<?php echo isset($class) ? $class : ''; ?>">
                    <div id="suggest-wrapper">
                        <input id="suggest"
                               type="text"
                               name="product_suggest"
                               class="idle"
                               value="Search for a product or brand"
                               autocomplete="off"/>
                        <div id="suggest-landing"></div>
                    </div>
                </div>
                <div id="user">
                    <?php if (isset($userData)): ?>
                        <div class="username">
                            <?php
                            echo $this->Link->user(
                                    $userData, $this->Gravatar->image($userData['email'], array('size' => 20, 'class' => 'gravatar')) . $userData['username'], array('escape' => false, 'class' => 'profile-link'));
                            ?>
                            <a class="nav-triangle">&#9662;</a>
                            <nav id="user-options" class="hide-on-body-click">
                                <ul>
                                    <li><?php echo $this->Link->user($userData, 'Your Profile'); ?></li>
                                    <li><?php echo $this->Link->inventory($userData, 'Your Inventory'); ?></li>
                                    <li><?php echo $this->Html->link('Settings', array('controller' => 'users', 'action' => 'settings', 'admin' => false)); ?> </li>
                                    <li class="divider"></li>
                                    <li><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout', 'admin' => false)); ?></li>
                                </ul>
                            </nav>
                        </div>
                    <?php else: ?>
                        <span class="guest">
                            <?php echo $this->Html->link('Register', array('plugin' => null, 'controller' => 'users', 'action' => 'signup')); ?> or
                            <?php echo $this->Html->link('Login', array('plugin' => null, 'controller' => 'users', 'action' => 'login')); ?> to participate!
                        </span>
                    <?php endif; ?>
                </div>
            </div></div>
        <nav id="nav">
            <div class="container">
                <ul id="menu"<?php echo isset($hideNav) ? ' style="display: none;' : ' class="show"'; ?>>
                    <li><?php echo $this->Html->link('Todays Activity', '/'); ?></li>
                    <li><a href="/forums">Forums</a></li>
                    <li><?php echo $this->Html->link('Browse Categories', array('controller' => 'categories', 'action' => 'index', 'admin' => false, 'plugin' => false, 'escape' => false)); ?></li>
                </ul>
            </div>
        </nav>
        <div id="main" role="main">
            <div class="container<?php echo isset($pageClass) ? ' ' . $pageClass : ''; ?>">
                <?php echo $this->Session->flash(); ?>
                <?php echo $this->Session->flash('auth'); ?>
                <div id="content" class="<?php echo isset($disableSidebar) ? 'no-sidebar' : ''; ?>">
                    <?php if (!empty($this->Html->_crumbs)): ?>
                        <div id="breadcrumbs">
                            <?php echo $this->Html->getCrumbs(' > ', 'Consumer Love'); ?>
                        </div>
                    <?php endif; ?>
                    <?php echo $content_for_layout; ?>
                </div>
                <?php if (!isset($disableSidebar)): ?>
                    <div id="side">
                        <?php
                        // Setup Widgets
                        if (isset($userData)) {
                            if ($userData['admin'] == true) {
                                $pageWidgets['admin'] = array();
                            }
                        } else {
                            // Put guest welcome on top
                            array_unshift($pageWidgets, 'guest_welcome');
                        }

                        // Put facebook on the end
                        $pageWidgets['facebook'] = array();

                        // Loop through widgets, put MPU as second widget.
                        $widgetIndex = 0;
                        foreach ($pageWidgets as $widget => $vars):
                            if (is_int($widget)) {
                                $widget = $vars;
                            }
                            $widgetIndex++;
                            ?>
                            <?php if ($widgetIndex == 2): ?>
                                <div class="sidebar-mpu">
                                    <?php echo $this->element('ads/mpu'); ?>
                                </div>
                            <?php endif; ?>
                            <div class = "widget <?php echo $widget; ?>">
                                <?php echo $this->element('widgets/' . $widget, (array) $vars);
                                ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div></div>
        <footer>

            <div id="footer-links-wrapper">
                <ul id="footer-links">
                    <li class="first">About
                        <ul class="sub">
                            <li><?php echo $this->Html->link('About Us', '/pages/about'); ?></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <p>Copyright &copy; 2011 consumerlove.org</p>
            <p>Consumer Love is still in epic alpha! Some functionality is incomplete or may not work at all.</p>
        </footer>
        <?php if (!isset($userData)): ?>
            <div id="register-login" title="You must Login or Register to participate">
                <div>
                    <h3>Create a new account</h3>
                    <p class="footnote">Sign up in 1 minute flat!</p>
                    <?php echo $this->element('forms/signup'); ?>
                </div>
                <div>
                    <h3>Login</h3>
                    <p class="footnote">Login to your existing account.</p>
                    <?php echo $this->element('forms/login'); ?>
                </div>
            </div>
        <?php endif; ?>
        <?php echo $this->Js->writeBuffer(); ?>
    </body>
</html>