<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title_for_layout; ?></title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <?php
        if (isset($canonical)) {
            echo '<link rel="canonical" href="http://consumerlove.org' . $canonical . '">';
        }

        echo $this->Html->script(array(
            'https://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js',
            'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js',
            'global'
        ));
        echo $this->Html->css(array(
            'http://fonts.googleapis.com/css?family=Copse|Corben:700&v2',
            'http://twitter.github.com/bootstrap/1.4.0/bootstrap.min.css',
            'cl'
        ));

        echo $scripts_for_layout;
        echo $this->element('external/google_analytics');
        ?>

        <!-- Le fav and touch icons -->
        <link rel="shortcut icon" href="images/favicon.ico">
    </head>

    <body>
        <div class="topbar">
            <div class="fill">
                <div class="container">
                    <a class="brand" href="#">Consumer Love <span class="heart"> &hearts;</span></a>
                    <ul class="nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                    <form action="" class="pull-right">
                        <input class="input-small" type="text" placeholder="Username">
                        <input class="input-small" type="password" placeholder="Password">
                        <button class="btn" type="submit">Sign in</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="container">

            <div class="content">
                <div class="page-header">
                    <h1>Page name <small>Supporting text or tagline</small></h1>
                </div>
                <div class="row">
                    <div class="span10">
                        <?php echo $content_for_layout; ?>
                    </div>
                    <div class="span4">
                        <h3>Secondary content</h3>
                    </div>
                </div>
            </div>

            <footer>
                <p>&copy; Company 2012</p>
            </footer>

        </div> <!-- /container -->

    </body>
</html>
