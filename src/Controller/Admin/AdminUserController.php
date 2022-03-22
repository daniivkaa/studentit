<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="app_admin_user")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $users = $em->getRepository(User::class)->findAll();

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/user/mute/{user}", name="app_admin_user_ban")
     */
    public function muteUser(User $user, EntityManagerInterface $em): Response
    {
        $user->setIsMuted(true);

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('app_admin_user');
    }
}
