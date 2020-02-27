<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<?php if(!isset($home_page)): ?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $title; ?></title>
        <link rel="shortcut icon" href="<?php echo Uri::create(Asset::find_file('favicon.ico', 'img')); ?>" />
        <meta name="description" content="Whereweallmeet.com a social dating platform that allows members to view local activities such as events, dating ideas and vacation packages and enjoy live dating agents to assist them in finding the perfect match.">
        <meta name="viewport" content="width=device-width">
        <meta name="keywords" content="DATING SITE, SOCIAL PLATFORM, DATING VIP VACATIONS, EVENTS, WOMEN, MEN, INTERNET DATING, SEARCH ENGINE, DATING CONCIERGE AGENT">

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <?php echo Asset::css('normalize.css'); ?>
        <?php echo Asset::css('font-awesome.min.css'); ?>
        <?php echo Asset::css('flowplayer/minimalist.css'); ?>
        <?php echo Asset::css('style.css'); ?>
        <?php echo Asset::css('chat.css'); ?>
        <?php echo Asset::css('slimbox2.css'); ?>
        <?php echo Asset::css('jquery-ui.css'); ?>
        <?php echo Asset::css('jquery.Jcrop.min.css'); ?>
        <?php echo isset($page_css) ? Asset::css($page_css) : ""; ?>

        <?php echo Asset::js('modernizr-2.6.2.min.js'); ?>
        <?php echo Asset::js('jquery-1.10.2.min.js'); ?>
        <?php echo Asset::js('jquery.min.js'); ?>
        <?php echo Asset::js('jquery-ui.min.js'); ?>
        <?php echo Asset::js('jquery.resizecrop-1.0.3.js'); ?>
        <?php echo Asset::js('jquery.Jcrop.min.js'); ?>
        
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Oswald">
        <script src="/ckeditor/ckeditor.js" type="text/javascript"></script>
        <script src="/chat_server/node_modules/socket.io/node_modules/socket.io-client/dist/socket.io.js" type="text/javascript"></script>
        <script src="/chat_server/node_modules/node-uuid/uuid.js" type="text/javascript"></script>
        <?php echo Asset::js('facescroll.js'); ?>

        <?php echo Asset::js('jtmyw.js'); ?>
        <?php echo Asset::js('flowplayer/flowplayer.js'); ?>
        <?php echo Asset::js('slimbox2.js'); ?>
        <?php echo Asset::js('cookie.js'); ?>
        <?php echo Asset::js('chat.js'); ?>
        <?php echo Asset::js('member_interaction.js'); ?>
        <?php echo isset($page_js) ? Asset::js($page_js) : ""; ?>
    </head>
    <!-- Google Analytics Code-->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-66788912-1', 'auto');
        ga('send', 'pageview');
    </script>

    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <div id="wrapper">
            <?php echo isset($home_page) ? "" : View::forge("layout/partials/header"); ?>
            <?php echo isset($home_page) ? "" : View::forge("layout/partials/navigation"); ?>
            <?php echo View::forge("layout/partials/flash"); ?>
            <?php echo $content; ?>
            <?php echo View::forge("layout/partials/footer"); ?>
        </div>       

    </body>
<?php else: ?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $title; ?></title>
        <link rel="shortcut icon" href="<?php echo Uri::create(Asset::find_file('favicon.ico', 'img')); ?>" />
        <meta name="description" content="Whereweallmeet.com a social dating platform that allows members to view local activities such as events, dating ideas and vacation packages and enjoy live dating agents to assist them in finding the perfect match.">
        <meta name="viewport" content="width=device-width">
        <meta name="keywords" content="DATING SITE, SOCIAL PLATFORM, DATING VIP VACATIONS, EVENTS, WOMEN, MEN, INTERNET DATING, SEARCH ENGINE, DATING CONCIERGE AGENT">

        <?php echo Asset::css('pages/bootstrap.min.css'); ?>

        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Oswald">
            <?php echo Asset::css('style.css'); ?>
            <?php echo Asset::css('font-awesome.min.css'); ?>
        <?php echo isset($page_css) ? Asset::css($page_css) : ""; ?>

        <?php echo Asset::js('jquery-1.10.2.min.js'); ?>
        <?php echo Asset::js('jtmyw.js'); ?>
        <?php echo Asset::js('jquery.cycle.all.js'); ?>
        <?php echo Asset::js('cookie.js'); ?>

        <?php echo Asset::js('pages/bootstrap.min.js'); ?>
        <?php echo Asset::js('pages/home.js'); ?>
        <?php echo isset($page_js) ? Asset::js($page_js) : ""; ?>

    </head>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-66788912-1', 'auto');
        ga('send', 'pageview');
    </script>

    <body>
                <?php if(isset($facebook)):?>
            <script type="text/javascript">
                var profile_uploaded = false;
                window.fbAsyncInit = function() {
                    FB.init({
                      appId      : '443368829181690',
                      xfbml      : true,
                      version    : 'v2.4'
                    });
                  };

                  (function(d, s, id){
                     var js, fjs = d.getElementsByTagName(s)[0];
                     if (d.getElementById(id)) {return;}
                     js = d.createElement(s); js.id = id;
                     js.src = "//connect.facebook.net/en_US/sdk.js";
                     fjs.parentNode.insertBefore(js, fjs);
                   }(document, 'script', 'facebook-jssdk'));

                  function myFacebookLogin() {
                    FB.getLoginStatus(function(response) {
                      if (response.status === 'connected') {
                        FB.api(
                            "/me/picture?type=large",
                            function (response) {
                              if (response && !response.error) {
                                    profile_uploaded = true;
                                    console.log(response.data);
                                $("#facebook_profile").attr("src", response.data.url);
                                document.getElementById("info49").value = response.data.url;
                              }
                            }
                        );
                      }
                      else {
                        FB.login(function(){
                            FB.api(
                                "/me/picture?type=large",
                                function (response) {
                                  if (response && !response.error) {
                                    console.log(response.data);
                                    profile_uploaded = true;
                                    $("#facebook_profile").attr("src", response.data.url);
                                    document.getElementById("info49").value = response.data.url;
                                  }
                                }
                            );
                    }, {scope: 'publish_actions'});
                      }
                    });
                }
            </script>
        <?php endif;?>
        <?php //echo $content; ?>

            <?php echo $content; ?>
            <?php echo View::forge("layout/partials/flash"); ?>


    </body>
<?php endif; ?>
</html>
