<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\Form\FormTypeInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\User\UserInterface;

class MarsupilamiController extends Controller {

    public function registerAction() {
        $discriminator->setClass('AppBundle\Entity\Marsupilami');
        $userManager = $this->container->get('pugx_user_manager');
        $userOne = $userManager->createUser();
        $userOne->setUsername('marsupilami');
        $userOne->setEmail('marsupilami@mail.com');
        $userOne->setPlainPassword('marsupilami');
        $userOne->setEnabled(true);
        $userManager->updateUser($userOne, true);
        return $this->container->get('pugx_multi_user.registration_manager')
                        ->register('AppBundle\Entity\Marsupilami');
    }

    public function listAction() {
        $id = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:Marsupilami')->friends($id);
        }
        $users = $em->getRepository('AppBundle:Marsupilami')->users($id);
        return new JsonResponse(array(
            'user' => $user,
            'users' => $users,
                ), Response::HTTP_OK
        );
    }

    public function addAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $body = $request->getContent();
        $data = json_decode($body, true);
        $amis = $request->query->get('id'); //$data['id'];
        $ami = $em->getRepository('AppBundle:Marsupilami')->find($amis);
        $currentUserId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $currentUser = $em->getRepository('AppBundle:Marsupilami')->find($currentUserId);
        $currentUser->addFriend($ami);
        $em->persist($currentUser);
        $em->flush();
        return new JsonResponse(Response::HTTP_OK);
    }

    public function removeAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $body = $request->getContent();
        $data = json_decode($body, true);
        $amis = $request->query->get('id');
        $ami = $em->getRepository('AppBundle:Marsupilami')->find($amis);
        $currentUserId = $this->get('security.token_storage')->getToken()->getUser()->getId();
        $currentUser = $em->getRepository('AppBundle:Marsupilami')->find($currentUserId);
        $currentUser->removeFriend($ami);
        $em->persist($currentUser);
        $em->flush();
        return new JsonResponse(Response::HTTP_OK);
    }

    public function searchAction(Request $request) {
        $id = $this->container->get('security.token_storage')->getToken()->getUser()->getId();
        if ($id) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:Marsupilami')->friends($id);
        }
        $content = json_decode($request->getContent(), true);
        $keyword = $content['keyword'];
        $keyword = $request->query->get('keyword');

        $users = $em->getRepository('AppBundle:Marsupilami')->search($keyword);
        return new JsonResponse(array(
            'users' => $users,
                ), Response::HTTP_OK
        );
    }

    public function invitAction(Request $request) {
        $content = json_decode($request->getContent(), true);
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $email = $request->query->get('email'); 
        $text = "<html><body>Bonjour,Je suis " . $user->getUsername() . " et je vous invite à me joindre sur mon.Veillez cliquer sur le "
                . '<a href=localhost/appartoo-app/appartoo-app/web/app_dev.php/register>lien</a>. </body></html>';
        $message = \Swift_Message::newInstance()
                ->setSubject('Invitation')
                ->setFrom('demo.appartoo@gmail.com')
                ->addTo($email)
                ->setContentType("text/html")
                ->setBody($text, 'text/html');
        $this->get('mailer')->send($message);
        return new JsonResponse(array('data' => 'Invitation envoyé'), Response::HTTP_OK);
    }

}
