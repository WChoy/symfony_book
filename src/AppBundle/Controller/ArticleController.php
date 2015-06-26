<?php
/**
 * Created by PhpStorm.
 * User: williamchoy1
 * Date: 6/25/15
 * Time: 2:38 PM
 */
// src/AppBundle/Controller/ArticleController.php
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller {
  public function recentArticlesAction($max = 3, Request $request)
  {
    // make a database call or other logic
    // to get the "$max" most recent articles
    $articles = $this->getMostRecentArticles($max);
    dump($articles);

    $format = $request->getRequestFormat();
    return $this->render(
      'article/recent_list.'.$format.'.twig',
      array('articles' => $articles)
    );
  }

  public function getMostRecentArticles($max) {
    return array(
      array('slug' => 'hello1', 'title' => 'hello 1 World'),
      array('slug' => 'hello2', 'title' => 'hello 2 World'),
      array('slug' => 'hello3', 'title' => 'hello 3 World'),
    );

  }
} 