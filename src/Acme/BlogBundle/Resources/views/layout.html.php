<!-- app/Resources/views/layout.html.php -->
<!DOCTYPE html>
<html>

  <head>
    <title><?php echo $view['slots']->output(
        'title',
        'Default title'
      ) ?></title>
  </head>

  <body>

  <!-- generate an absolute URL, with a 3rd argument to generate -->
  <a href="<?php echo $view['router']->generate('_welcome', array(), true) ?>">Home</a>

    <?php echo $view['slots']->output('_content') ?>
  </body>

</html>