<?php
/**
 * Created by PhpStorm.
 * User: williamchoy1
 * Date: 6/24/15
 * Time: 8:46 PM
 */
// src/AppBundle/Controller/BlogController.php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BlogController extends Controller
{
  /**
   * @Route("/blog/{page}", name="blog_index", defaults={"page": 1},
   *      requirements={"page": "\d+"}
   * )
   */
  public function indexAction($page)
  {
    return new Response('<html><body>Blog Page # '. $page .'!</body></html>');
  }

  /**
   * @Route(
   *    "/blog/{_locale}/{year}/{title}.{_format}",
   *    defaults={"_format": "html"},
   *    name="blog_show",
   *    requirements={
   *         "_locale": "en|fr",
   *         "_format": "html|rss",
   *        "year": "\d+"
   *    }
   * )
   */
  public function showAction($_locale, $year, $title)
  {
    $language = locale_get_display_language($_locale);
    return new Response('<html><body>Blog '. $language .' year='. $year .' for \''. $title .'\'slug!</body></html>');
  }

  /**
   * @Route("/{_locale}", defaults={"_locale": "en"},
   *     requirements={"_locale": "en|fr"}
   * )
   */
  public function homepageAction($_locale)
  {
    $language = locale_get_display_language($_locale);

    $url = $this->generateUrl('blog_show', array('_locale' => $_locale, 'year' => 2015, 'title' => 'foobar' ));
    return new Response('<html><body>Welcome '. $language .' home! <hr/>'. $url .'</body></html>');
  }

  /**
   * @Route("/contact")
   * @Method("GET")
   */
  public function contactAction()
  {
    $url = $this->get('router')->generate('blog_index', array(
      'page' => 2,
      'category' => 'Symfony'
    ));

    // ... display contact form
    return new Response('<html><body>GET contact '. $url .'</body></html>');
  }

  /**
   * @Route("/contact")
   * @Method("POST")
   *
   */
  public function processContactAction()
  {
    // ... process contact form
    return new JsonResponse(array('output' => 'POST contact'));
  }

  // see routing.yml
  public function firefoxContactAction(Request $request)
  {
    $method = $request->getMethod();
    $agent = $request->headers->get("User-Agent");
    // ... process contact form
    return new JsonResponse(array('method' => $method, 'agent' => $agent));
  }
}
// php app/console debug:router
// php app/console debug:router article_show
// php app/console router:match /blog/my-latest-post
// Incorrect... route "/api/lucky/number" matches