<?php
/**
 * Created by PhpStorm.
 * User: williamchoy1
 * Date: 6/24/15
 * Time: 2:36 PM
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

// use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;

class HelloController extends Controller {
  /**
   * @Route("/index/{firstName}/{lastName}/{middleName}", name="index")
   */
  // public function indexAction($lastName, $firstName) // order does not matter
  public function indexAction($firstName, $lastName)
  {
    $this->addFlash(
      'noticeLast',
      'Just seen '.$firstName
    );
    // return new Response('<html><body>Hello '.$firstName. ' '. $lastName .'!</body></html>');
    return $this->render('hello/greetings/index.html.twig', array('name' => $firstName. ' '. $lastName ));
  }

  /**
   * @Route("/hello/{firstName}/{lastName}/{middleName}", name="hello")
   */
  // public function indexAction($lastName, $firstName) // order does not matter
  public function helloAction($firstName, $lastName)
  {
    if ($lastName == 'Doe') {
      // HTTP 404: NotFoundHttpException
      throw $this->createNotFoundException('The '. $firstName. ' '. $lastName .' does not really exist');
    }
    else if(strlen($lastName) < 3) {
      throw new \Exception('Something went wrong!');
    }
    return $this->render('AppBundle:Hello:index.html.twig', array('name' => $firstName. ' '. $lastName ));
  }
  /**
   * @Route("/list")
   * -- Symfony stores the attributes in a cookie by using the native PHP sessions.
   */
  public function pagerAction(Request $request)
  {
    // read query parameters, grab a request header or get access to an uploaded file
    $page = $request->query->get('page',1);


    $session = $request->getSession();
    // get the attribute set by another controller in another request
    $prev = $session->get('prev', 0);

    // store an attribute for reuse during a later user
    $session->set('prev', $page);

    // create a simple Response with a 200 status code (the default)
    // return new Response('<html><body>Page '. $page .',  Prev page was '. $prev .'! </body></html>', Response::HTTP_OK);

    // create a JSON-response with a 200 status code
//    $response = new Response(json_encode(array('page' => $page, 'prev' => $prev)));
//    $response->headers->set('Content-Type', 'application/json');
//    return $response;

    return new JsonResponse(array('page' => $page, 'prev' => $prev), Response::HTTP_OK);
  }

  /**
   * @Route("/home")
   */
  public function homeAction()
  {
    return $this->redirectToRoute('homepage'); // v2.6 .. default HTTP:302 (temporary) redirect
    // return $this->redirect($this->generateUrl('homepage'), 301); // (permanent) redirect,
    return new RedirectResponse($this->generateUrl('homepage'));
  }

  /**
   * @Route("/map")
   */
  public function mapAction(Request $request)
  {
    $request->isXmlHttpRequest(); // is it an Ajax request?
    $request->getPreferredLanguage(array('en', 'fr'));
    $request->query->get('page'); // get a $_GET parameter
    $request->request->get('page'); // get a $_POST parameter

    return $this->redirect('http://maps.google.com');
  }
  /**
   * @Route("/forward/{name}")
   */
  public function forwardAction($name)
  {
    $response = $this->forward('AppBundle:Lucky:number', array(
      'name'  => $name,
      'count' => 6,
    ));
      // ... further modify the response or return it directly
    return $response;
  }
}
// php app/console debug:container