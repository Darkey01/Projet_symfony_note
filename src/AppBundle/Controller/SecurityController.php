<?php
/**
 * Created by PhpStorm.
 * User: Reynald
 * Date: 15/12/2017
 * Time: 12:06
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Route("/")
     */
    public function loginAction(Request $request ,AuthenticationUtils $authUtils)
    {
        if($this->getUser() != null){
            $rolesTab = $this->getUser()->getRoles();

            if (in_array('ROLE_ADMIN', $rolesTab, true)){
                return $this->redirectToRoute('accueil_admin');
            }
            elseif (in_array('ROLE_PROPRIETAIRE', $rolesTab, true)){
                return $this->redirectToRoute('accueil_proprietaire');
            }
        };
        $error = $authUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();
        return $this->render(
            'AppBundle:Security:login.html.twig',
            [
                // last username entered by the user
                'last_username' => $lastUsername,
                'error' => $error,
            ]
        );
    }

/**
* @Route("/logout", name="logout")
*/
    public function logoutAction(Request $request)
    {
    }


    /**
     * @Route("/create/admin", name="ajoutUser")
     */
    public function createUserAction()
    {
        $user = new User();
        $encoder = $this->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, 'azerty');
        $user->setPassword($encoded);
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setUsername('Reynald');
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        $user = new User();
        $encoder = $this->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user, 'jojo');
        $user->setPassword($encoded);
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setUsername('Jordan');
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('login');
    }
}