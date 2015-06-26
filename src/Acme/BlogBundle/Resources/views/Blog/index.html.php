<?php
/**
 * Created by PhpStorm.
 * User: williamchoy1
 * Date: 6/25/15
 * Time: 1:17 PM
 */
?>

<?php $view->extend('layout.html.php') ?>
<?php $view['slots']->set('title', 'List of Posts') ?>

<h1>List of Posts</h1>
<ul>
  <?php foreach ($posts as $post): ?>
    <li>
      <a href="<?php echo $view['router']->generate(
        'blog_show',
        array('id' => $post->getId())
      ) ?>">
        <?php echo $post->getTitle() ?>
      </a>
    </li>
  <?php endforeach ?>
</ul>